<?php

define('ID_SECCION',3014);

class Tarjeta_garantia_archivo_japon_main extends Backend_Controller {		
	
			
	function Tarjeta_garantia_archivo_japon_main()
	{
		parent::Backend_Controller();
	}


	function index()
	{	
		
		
		if($this->_validar_filtros())
		{
			$this->_exportar();
		}
		else
		{
			$this->_view();
		}
	}



	// validation fields
	private function _validar_filtros() {		
		//-------------------------[valida datos del buscador]
		
		$filtro = FALSE;
		
		if(!$this->input->post('_filtro'))
		{
			RETURN FALSE;
		}
		
		
		$this->form_validation->set_rules('fecha_alta_inicial',$this->marvin->mysql_field_to_human('fecha_alta_inicial'),
				'trim|my_form_date_reverse|my_valid_date[y-m-d,-]' );
		$this->form_validation->set_rules('fecha_alta_final',$this->marvin->mysql_field_to_human('fecha_alta_inicial'),
				'trim|my_form_date_reverse|my_valid_date[y-m-d,-]' );
		$this->form_validation->set_rules('fecha_entrega_inicial',$this->marvin->mysql_field_to_human('fecha_alta_inicial'),
				'trim|my_form_date_reverse|my_valid_date[y-m-d,-]' );
		$this->form_validation->set_rules('fecha_entrega_final',$this->marvin->mysql_field_to_human('fecha_alta_inicial'),
				'trim|my_form_date_reverse|my_valid_date[y-m-d,-]' );
		
		$this->form_validation->run();
		
		if(
			$this->form_validation->my_valid_date( $this->input->post('fecha_alta_inicial'),	'y-m-d,-'  ) ||
			$this->form_validation->my_valid_date( $this->input->post('fecha_alta_final'),		'y-m-d,-'  ) ||
			$this->form_validation->my_valid_date( $this->input->post('fecha_entrega_inicial'),	'y-m-d,-'  ) ||
			$this->form_validation->my_valid_date( $this->input->post('fecha_entrega_final'),	'y-m-d,-'  )	)
		{
			RETURN TRUE;
		}
		
		
		
		RETURN FALSE;
		//-------------------------[/valida datos del buscador]
	}
	
	private function _exportar()
	{
		$o = new Unidad();
		$q = $o->get_archivo_japon();
		
		
		if($this->form_validation->my_valid_date( $this->input->post('fecha_alta_inicial'),	'y-m-d,-'  ))
		{
			$q->addWhere('DATE(TARJETA_GARANTIA.tarjeta_garantia_field_fechahora_alta) >= ?',$this->input->post('fecha_alta_inicial'));
		}
		if($this->form_validation->my_valid_date( $this->input->post('fecha_alta_final'),	'y-m-d,-'  ))
		{
			$q->addWhere('DATE(TARJETA_GARANTIA.tarjeta_garantia_field_fechahora_alta) <= ?',$this->input->post('fecha_alta_final'));
		}
		
		if($this->form_validation->my_valid_date( $this->input->post('fecha_entrega_inicial'),	'y-m-d,-'  ))
		{
			$q->addWhere('DATE(UNIDAD.unidad_field_fecha_entrega) >= ?',$this->input->post('fecha_entrega_inicial'));
		}
		
		if($this->form_validation->my_valid_date( $this->input->post('fecha_entrega_final'),	'y-m-d,-'  ))
		{
			$q->addWhere('DATE(UNIDAD.unidad_field_fecha_entrega) <= ?',$this->input->post('fecha_entrega_final'));
		}
		
		
		
		
		
		
		$total_registros = $q->count();
		$result=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		
		$fname=APPPATH.'tmp/' . 'TG-JPN'.date("Y-m-d").'_'.md5(microtime() * mktime()) . '.txt';
		$fp = fopen($fname ,"w+");
			
		$head =
				'S1' 					. "\t" .//format type (fixed)
				date("YmdHis")					//fecha YYYYMMDDHHMMSS //the date on which the file is modefied
				;
			
		fwrite($fp, $head."\r\n");
		
		foreach($result as $row)
		{
			
			$registration_date = str_replace('-','',$row['unidad_field_fecha_entrega']);
			$vin = $row['unidad_field_vin'];
			$modelo = substr($row['unidad_field_vin'], 3, 3);
			$frame = substr($row['unidad_field_vin'], 11, 6);
			$sales_dealer = $row['Sucursal']['Empresa']['empresa_field_id_sap'];
			$sales_state = $row['Sucursal']['Provincia']['provincia_field_iso_code'];
			$delivery_date = str_replace('-','',$row['unidad_field_fecha_facturacion']);
			$anio = $row['Auto_Anio']['auto_anio_field_desc'];
		
			
			$data = 
						'S2'					. "\t" . //1 format type (fixed)
						'00'					. "\t" . //2 data type (fixed)
						'2'						. "\t" . //3 product division code (fixed)
						$registration_date		. "\t" . //4 warranty registration date 
						'404'					. "\t" . //5 sales distributir code (fixed)
						'ARG'					. "\t" . //6 sales country code (fixed)
						$vin					. "\t" . //7 vin 
						''						. "\t" . //8 HIN (unused)
						$modelo					. "\t" . //9 model key type
						'0'.$frame				. "\t" . //10 frame serial (0 + ultimos 6 vin)
						$sales_dealer			. "\t" . //11 sales dealer ( id concesionario SAP)
						$sales_state			. "\t" . //12 sales state (codigo iso de provincia del concesionario)
						'0'						. "\t" . //13 acura code (fixed)
						$delivery_date			. "\t" . //14 delivery date (fecha informada por SAP)
						$anio					. "\t" . //15 model year
						''						. "\t" . //16 number of transmission (no se informa)
						''						. "\t" . //17 transmission class (no se informa)
						''							 //18 shop series (unused)
					;
				
				fwrite($fp, $data."\r\n");
		}
		
		$footer =
					'S3' 					. "\t" .//format type (fixed)
					$total_registros		//numer of existing data exluding header and footer
					;
			
		fwrite($fp, $footer);
		
		fclose($fp);
			
		
		header("Content-disposition: attachment; filename=".'TG-JPN'.date("Y-m-d").'_'.md5(microtime() * mktime()) . '.txt');
		header("Content-type: application/octet-stream");
		readfile($fname);
			
		exit;
		
	}
	
	/*
	if($filtro)
		{
			$sql = "SELECT 
					DATE_FORMAT(T.fecha_venta, '%Y%m%d') as fecha,
					T.vin,
					SUBSTRING(T.vin,4,3) as modelo,
					SUBSTRING(T.vin,12,6) as frame,
					VA.anio,
					DATE_FORMAT(U.fecha_facturacion, '%Y%m%d') as delivery_date,
					P.provincia_iso as sales_state,	
					C.id_concesionario_sap as sales_dealer
					
			
					FROM  ".$_config['db']['prefix']."tarjeta_garantia T
					LEFT JOIN ".$_config['db']['prefix']."vin_anio VA ON SUBSTRING(T.vin,10,1)=VA.id_anio
					LEFT JOIN ".$_config['db']['prefix']."unidad U ON U.vin = T.vin
					LEFT JOIN ".$_config['db']['prefix']."concesionario C ON T.id_concesionario = C.id_concesionario
					LEFT JOIN ".$_config['db']['prefix']."provincia P ON P.id_provincia = C.concesionario_id_provincia
					
					
					WHERE
					T.fecha_entrega IS NULL
					".$aux_where."
					
					GROUP BY T.vin
					
					ORDER BY T.fecha_venta
			
			";
			if(!($result = $db->sql_query($sql)))sql_error(__LINE__, __FILE__, $db->sql_error(), $sql);	
			$total_registros = $db->sql_numrows($result);
			
			$fname=$_config['directorio']['xls'].'/'. 'TG-JPN'.date("Y-m-d").'_'.md5(microtime() * mktime()) . '.txt';
			$fp = fopen($fname ,"w+");
			
			$head =
					'S1' 					. "\t" .//format type (fixed)
					date("YmdHis")					//fecha YYYYMMDDHHMMSS //the date on which the file is modefied
					;
			
			fwrite($fp, $head."\r\n");
			
			
			while($row=$db->sql_fetchrow($result))
			{
				$data = 
						'S2'					. "\t" . //1 format type (fixed)
						'00'					. "\t" . //2 data type (fixed)
						'2'						. "\t" . //3 product division code (fixed)
						$row['fecha']			. "\t" . //4 warranty registration date 
						'404'					. "\t" . //5 sales distributir code (fixed)
						'ARG'					. "\t" . //6 sales country code (fixed)
						$row['vin']				. "\t" . //7 vin 
						''						. "\t" . //8 HIN (unused)
						$row['modelo']			. "\t" . //9 model key type
						'0'.$row['frame']		. "\t" . //10 frame serial (0 + ultimos 6 vin)
						$row['sales_dealer']	. "\t" . //11 sales dealer ( id concesionario SAP)
						$row['sales_state']		. "\t" . //12 sales state (codigo iso de provincia del concesionario)
						'0'						. "\t" . //13 acura code (fixed)
						$row['delivery_date']	. "\t" . //14 delivery date (fecha informada por SAP)
						$row['anio']			. "\t" . //15 model year
						''						. "\t" . //16 number of transmission (no se informa)
						''						. "\t" . //17 transmission class (no se informa)
						''							 //18 shop series (unused)
					;
				
				fwrite($fp, $data."\r\n");
				
			}
			
			$footer =
					'S3' 					. "\t" .//format type (fixed)
					$total_registros		//numer of existing data exluding header and footer
					;
			
			fwrite($fp, $footer);
		
			fclose($fp);
			
			
			header("Content-disposition: attachment; filename=".'TG-JPN'.date("Y-m-d").'_'.md5(microtime() * mktime()) . '.txt');
			header("Content-type: application/octet-stream");
			readfile($fname);
			
			exit;
		
		
		}
	*/
	
	
	

	private function _view()
	{
		//-------------------------[vista generica]
		//$this->output->enable_profiler();
		
		$this->template['tpl_include'] = 'backend/tarjeta_garantia_archivo_japon_main_view';
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}
	
	
}
