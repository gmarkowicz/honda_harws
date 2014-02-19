<?php

class Cambio_Codigo_Llave_Crv extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
			exit;
			
    }  
	
	
	
	
    public function index()
    {   
		$this->load->helper('file');
		
		$statement = Doctrine_Manager::getInstance()->connection();
		
	
		
		
		$path = dirname(__FILE__) . "/cambio_codigo_llave_crv.csv";
		$file = read_file($path);
		
		$data = explode("\n",$file);
		
		$i = 0;
		foreach($data as $line)
		{
		
			
			
			
			$array = explode(';',$line);
			$vin = trim($array[1]);
			$unidad = trim($array[2]);
			$codigo_llave = trim($array[3]);
			
			$sql = "SELECT id from unidad WHERE unidad_field_unidad ='".$unidad."' AND unidad_field_vin = '".$vin."'";
			$r = $statement->execute($sql);
			$result = $r->fetchAll();
			if(count($result) == 1)
			{
				if(strlen($codigo_llave)>1)
				{
					$updateSql  ="UPDATE unidad SET unidad_field_codigo_de_llave ='".$codigo_llave."' WHERE unidad_field_unidad ='".$unidad."' AND unidad_field_vin = '".$vin."'";
					$statement->execute($updateSql);
					
				}
				else
				{
					echo 'no se encontro codigo de llave' . "<br />";
				}
			}
			else
			{
				echo "no encuentro ". $vin;
			}
			
			
			
			/*
			//unidad_field_codigo_de_llave
			$sql ="UPDATE unidad set unidad_field_codigo_de_llave='' WHERE unidad_field_vin='".trim($line)."'";
			
			$statement->execute($sql);
			
			++$i;
			*/
			
			
		}
		
		
	}
	
	
}
?>    