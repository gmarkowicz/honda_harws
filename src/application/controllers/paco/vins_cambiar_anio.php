<?php

class Vins_Cambiar_Anio extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
    }  
	
	
	function index()
	{
	
		$this->load->helper('file');
		$this->load->library('ofimatica');
		
		$this->ofimatica->make_file();
		
		$this->ofimatica->add_row();
		
		$this->ofimatica->add_header( 'VIN',50 );
		$this->ofimatica->add_header( 'Unidad',50 );
		$this->ofimatica->add_header( 'Anio Modelo VIN',50 );
		$this->ofimatica->add_header( 'Anio Modelo HARWS',50 );
		$this->ofimatica->add_header( 'Accion',50 );
		$this->ofimatica->add_header( 'Cambiar Modelo ID HARWS',50 );
		
		$statement = Doctrine_Manager::getInstance()->connection();
			
		$path = dirname(__FILE__) . "/vins_cambiar_anio.txt";
		$file = read_file($path);
		
		
		$data = explode("\n",$file);
		$i = 0;
		foreach($data as $vin)
		{
			++$i;
			$vin = trim($vin);
			$this->ofimatica->add_row();
			$this->ofimatica->add_data($vin);
			
			//existe en la db?
			$sql="SELECT unidad_field_unidad, auto_anio_id from unidad where unidad_field_vin='".$vin."'" ;
			$unidad = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
			$cantidad = count($unidad);
			
			if($cantidad == 1)
			{
				$this->ofimatica->add_data($unidad[0]['unidad_field_unidad']);
			}
			else if($cantidad == 0)
			{
				$this->ofimatica->add_data('NO ENCONTRADO');
			}
			else
			{
				$this->ofimatica->add_data('se encontraron ' . $cantidad . ' de registros');
			}
			
			//auto anio en base al vin
			$sql="SELECT AN.auto_anio_field_desc FROM vin_anio VA
				INNER JOIN auto_anio AN ON AN.id = VA.auto_anio_id
				where VA.id='".substr($vin, 9,1)."'" ;
			
			$vin_anio = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
			$cantidad = count($vin_anio);
			
			$anio_vin = '';
			
			if($cantidad == 1)
			{
				$anio_vin =$vin_anio[0]['auto_anio_field_desc'];
				$this->ofimatica->add_data($vin_anio[0]['auto_anio_field_desc']);
			}
			else if($cantidad == 0)
			{
				$this->ofimatica->add_data('NO ENCONTRADO');
			}
			else
			{
				$this->ofimatica->add_data('');
			}
			
			//auto anio harws
			
			$anio_harws  = '';
			
			if(isset($unidad[0]['auto_anio_id']))
			{
				
				$sql="SELECT AN.auto_anio_field_desc FROM auto_anio AN
				where AN.id='".$unidad[0]['auto_anio_id']."'" ;
				$auto_anio = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
				if(count($auto_anio) == 1)
				{
					$anio_harws = $auto_anio[0]['auto_anio_field_desc'];
					$this->ofimatica->add_data($auto_anio[0]['auto_anio_field_desc']);
					
				}
				else
				{
					$this->ofimatica->add_data('');
				}
			}
			else
			{
				$this->ofimatica->add_data('');
			}
			
			if(!isset($unidad[0]['auto_anio_id']))
			{
				$this->ofimatica->add_data('');
			}
			else if($anio_harws!=$anio_vin)
			{
				$this->ofimatica->add_data('cambiar:' .$anio_vin .'!=' . $anio_harws );
			}
			else
			{
				$this->ofimatica->add_data('no cambiar');
			}
			
			if(!isset($unidad[0]['auto_anio_id']))
			{
				$this->ofimatica->add_data('');
				
			}
			else
			{
				$sql="SELECT id FROM auto_anio 
				where auto_anio_field_desc='".$anio_vin."'" ;
				$cambiar_anio = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
				if(count($cambiar_anio) == 1)
				{
					$this->ofimatica->add_data($cambiar_anio[0]['id']);
				}
				else
				{
					$this->ofimatica->add_data('');
				}
			}
			
			
		}
		
		
		$this->ofimatica->send_file('xls');
		
	}
	
	
}
?>    