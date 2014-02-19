<?php

class Ajax_Json extends Backend_Controller {
	
	var $json_data=Array(
		'error' => 1,
		'response'  => 'Datos Incorrectos'
	);	
	
	function Ajax_Json()
	{
		
		parent::Backend_Controller();
		$this->load->library('form_validation');
		
		
	}
	
	public function get_tsi_encuesta_satisfaccion()
	{
		
		$tsi = new Tsi();
		$q = $tsi->get_all();
		$q->leftJoin('TSI.Tsi_Encuesta_Satisfaccion ENCUESTA');
		$q->addWhere('unidad_field_unidad = ?', $this->input->post('unidad'));
		$q->addWhere('unidad_field_vin = ?', $this->input->post('vin'));
		$q->addWhere('ENCUESTA.tsi_id is NULL');
		$q->WhereIn('TSI.sucursal_id ', $this->session->userdata('sucursales'));
		$q->orderBy('tsi_field_fecha_de_egreso DESC');
		
		try {
			$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['message']	= $e->getPortableMessage();
			$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			echo "error";
		}
		if($resultado)
		{
			
			$data = array();
			foreach($resultado as $row) {
				$data[] = array('id'=> 		$row['id'],
								'desc' =>	'#'. $row['id'] . ' ' .
											$this->marvin->mysql_date_to_form($row['tsi_field_fecha_de_egreso']) . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_nombre'] . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_apellido'] . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_razon_social'] . ' ' .
											element('tsi_tipo_servicio_field_desc',$row['Many_Tsi_Tipo_Servicio'])
				);
			}
			$this->json_data['error'] = 0;
			$this->json_data['response'] = $data;
		}
			
	}
	
	public function get_tsi_encuesta_seguimiento()
	{
		
		$tsi = new Tsi();
		$q = $tsi->get_all();
		$q->leftJoin('TSI.Tsi_Encuesta_Seguimiento ENCUESTA');
		$q->addWhere('unidad_field_unidad = ?', $this->input->post('unidad'));
		$q->addWhere('unidad_field_vin = ?', $this->input->post('vin'));
		$q->addWhere('ENCUESTA.tsi_id is NULL');
		$q->WhereIn('TSI.sucursal_id ', $this->session->userdata('sucursales'));
		$q->orderBy('tsi_field_fecha_de_egreso DESC');
		
		try {
			$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['message']	= $e->getPortableMessage();
			$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			echo "error";
		}
		if($resultado)
		{
			
			$data = array();
			$data[] = array('id'=>'','desc'=>'');
			foreach($resultado as $row) {
				$data[] = array('id'=> 		$row['id'],
								'desc' =>	'#'. $row['id'] . ' ' .
											$this->marvin->mysql_date_to_form($row['tsi_field_fecha_de_egreso']) . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_nombre'] . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_apellido'] . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_razon_social'] . ' ' .
											element('tsi_tipo_servicio_field_desc',$row['Many_Tsi_Tipo_Servicio'])
				);
			}
			$this->json_data['error'] = 0;
			$this->json_data['response'] = $data;
		}
			
	}
	
	public function get_modelos()
	{
		
		$auto_modelo = new Auto_Modelo();
		$q = $auto_modelo->get_all();
		$q->addWhere('auto_marca_id = ?',$this->input->post('auto_marca_id'));
		$q->orderBy('auto_modelo_field_desc');
		try {
			$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['message']	= $e->getPortableMessage();
			$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			echo "error";
		}
		if($resultado)
		{
			
			$data = array();
			foreach($resultado as $row) {
				$data[] = array('id'=> 		$row['id'],
								'desc' =>	$row['auto_modelo_field_desc']
				);
			}
			$this->json_data['error'] = 0;
			$this->json_data['response'] = $data;
		}
			
	}
	
	public function get_versiones()
	{
		
		$auto_version = new Auto_Version();
		$q = $auto_version->get_all();
		$q->addWhere('auto_modelo_id = ?',$this->input->post('auto_modelo_id'));
		$q->orderBy('auto_version_field_desc');
		try {
			$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['message']	= $e->getPortableMessage();
			$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			echo "error";
		}
		if($resultado)
		{
			
			$data = array();
			foreach($resultado as $row) {
				$data[] = array('id'=> 		$row['id'],
								'desc' =>	$row['auto_version_field_desc']
				);
			}
			$this->json_data['error'] = 0;
			$this->json_data['response'] = $data;
		}
			
	}
	
	
	public function get_frt_hora()
	{

		$this->load->library('r_garantia');
		$resultado = $this->r_garantia->get_frt_data($this->input->post('frt_id'), $this->input->post('unidad_field_vin'));
		if($resultado != FALSE)
		{
			$this->json_data['error'] = 0;
			$this->json_data['response'] = $resultado;
		}
	}
	
	public function get_material_descripcion()
	{
		
		$this->load->library('r_garantia');
		$resultado = $this->r_garantia->get_material_descripcion($this->input->post('material_id'));
		if($resultado)
		{
			$this->json_data['error'] = 0;
			$this->json_data['response'] = array(
					'descripcion'=> $resultado['descripcion']	
			);
		}			
	}
	
	public function get_material_precio()
	{
		
		$error = FALSE;
		$resultado = FALSE;
		
		$this->load->library('r_garantia');
		if(is_numeric($this->input->post('tsi_id')) )
		{
			if(!$this->r_garantia->set_tsi($this->input->post('tsi_id')))
			{
				$error = TRUE;
			}
		}
		
		if(!$error)
		{
			$resultado =  $this->r_garantia->get_material_precio(
					$this->input->post('factura'),
					$this->input->post('material'),
					$this->input->post('sucursal')
					);
		}
		if($resultado)
		{
			$this->json_data['error'] = 0;
			$this->json_data['response'] = array(
				'valor'=>$resultado['precio']
			);
		}
	}
	
	public function get_material_precio_fob()
	{
		
		$error = FALSE;
		$resultado = FALSE;
		
		$this->load->library('r_garantia');
		if(is_numeric($this->input->post('tsi_id')) )
		{
			if(!$this->r_garantia->set_tsi($this->input->post('tsi_id')))
			{
				$error = TRUE;
			}
		}
		if(!$error)
			$resultado =  $this->r_garantia->get_precio_fob($this->input->post('material'));
		if($resultado)
		{
			$this->json_data['error'] = 0;
			$this->json_data['response'] = array(
				'valor'=>$resultado
			);
		}
	}
	
	
	public function get_codigo_sintoma()
	{
		$codigo_sintoma = new Reclamo_Garantia_Codigo_Sintoma();
		$resultado = $codigo_sintoma->get_desc($this->input->post('codigo_sintoma_id'));
		if($resultado)
		{
			$this->json_data['error'] = 0;
			$this->json_data['response'] = array('descripcion'=> $resultado);
		}			
	}
	
	public function get_codigo_defecto()
	{
		
		$codigo_defecto = new Reclamo_Garantia_Codigo_Defecto();
		$resultado = $codigo_defecto->get_desc($this->input->post('codigo_defecto_id'));
		if($resultado)
		{
			$this->json_data['error'] = 0;
			$this->json_data['response'] = array('descripcion'=> $resultado);
		}			
	}
	
	public function get_garantia_tsi()
	{
		
		$tsi= new Tsi();
		$q= $tsi->get_all();
		$q->addWhere('unidad_id = ?',$this->input->post('unidad_id'));
		$q->addWhere('TO_DAYS(now())-TO_DAYS(tsi_field_fecha_de_egreso)<= ? ',30);
		$tih = "";
		if($this->session->userdata('show_tsi_tih'))
		{
			$tih = "TSI_TIPO_SERVICIO.id = 9 OR ";
		}
		$q->addWhere('( '.$tih.' TSI_TIPO_SERVICIO.id = 7 OR TSI_TIPO_SERVICIO.id = 8 OR (TSI_TIPO_SERVICIO.id = 4 AND TSI.tsi_field_kilometros_rotura<201))');
		$q->WhereIn('TSI.sucursal_id ', $this->session->userdata('sucursales'));
		/*
		" AND
					( 
						T.id_mantenimiento = '7'
						OR T.id_mantenimiento = '8' 
						OR ( T.id_mantenimiento = '4' AND  T.kilometros<201)
					)"	
			// . " AND  ( (TG.id_tarjeta IS null AND T.kilometros<201) OR TG.id_tarjeta IS NOT NULL ) "
			 . " AND  (TO_DAYS(now())-TO_DAYS(T.tsi_fecha)<=40 )"				 
		*/
		
		
		
		
		$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		if($resultado)
		{
			$data = array();
			foreach($resultado as $row) {
				$data[] = array('id'=> 		$row['id'],
								'desc' =>	'#'. $row['id'] . ' ' .
											$this->marvin->mysql_date_to_form($row['tsi_field_fecha_de_egreso']) . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_nombre'] . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_apellido'] . ' ' .
											$row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_razon_social'] . ' ' .
											element('tsi_tipo_servicio_field_desc',$row['Many_Tsi_Tipo_Servicio'])
				);
			}
			$this->json_data['error'] = 0;
			$this->json_data['response'] = $data;
		}
		
	}
	
	public function get_tsi_sucursal_garantia()
	{
		
		
		$this->load->library('r_garantia');
		
		
		$resultado = $this->r_garantia->get_tsi_valores_garantia($this->input->post('tsi_id'));
		if($resultado)
		{
			$this->json_data['error'] = 0;
			$this->json_data['response'] = array(
				'ingresos_brutos'=> $resultado['valor_ingresos_brutos'],
				'valor_frt_hora'=> $resultado['valor_frt_hora'],
			);
		}
				
	}
	
	
	public function get_reclamo_garantia_campania()
	{
		
		
		$this->load->library('r_garantia');
		$resultado = $this->r_garantia->get_campania_default($this->input->post('campania_id'),$this->input->post('vin'));
		
		if($resultado)
		{
			
			$this->json_data['error'] = 0;
				$this->json_data['response'] = array(
					'repuestos'=> $resultado['repuestos'],
					'frts'=>$resultado['frts']
				);
		}
	}
	
	
	
	function _output($output)
	{
		//header('Cache-Control: no-cache, must-revalidate');
		//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		//header('Content-type: application/json');
		echo json_encode($this->json_data);
	}
	
	

}
