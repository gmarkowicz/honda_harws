<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/*hardcoding baby...*/

class MY_Reclamo_garantia
{
	/**
	* Constructor
	* 
	* @access	public
	*/	
	
	//estos repuestos (fluidos) pueden tener como cantidad un numero float, los demas NO
	var $repuestos_float = array(
			'OL999-9001',
			'OL999-9002',
			'OL999-9003',
			'08200-9001',
			'08200-9005',
			'08798-9016',
			'08200-9002',
			'08200-9003',
			'08200-9007',
			'08798-9008',
			'08206-9002',
			'08717-0004',
			'08718-0001'
	);
	
	#repuestos
	var $repuestos_validos = array(
		'5WS' => array(
						'35750-SAD-M01ZA' =>array(0,1), //repuesto eregi y cantidades
						'35751-SAA-305' =>array(1),
						'32751-SAA-M' =>array(1)
					),
		'5WS1' => array(
						'35752-SAA-306ZA' =>array(0), //repuesto eregi y cantidades
						'35752-SAA-405ZA' =>array(1),
						'32751-SAA-M' =>array(1)
					),
		'5LR' => array(
						'06535-SJA-A01' =>array(1), //repuesto eregi y cantidades
						'08206-9002' =>array(3),
					),
		'5SZ' => array(
						'06770-S84-A11ZA' =>array(0), //repuesto eregi y cantidades
						'04770-S5A-308' =>array(1),
					),
		'5SD' => array(
						'06780-S5A-G80ZA' =>array(0), //repuesto eregi y cantidades
						'04780-S5A-308' =>array(1),
					),
		'5SE' => array(
						'70450-SZAA01' =>array(0), //repuesto eregi y cantidades
						'70450-SZA-A11' =>array(1),
					),
		'5LB' => array(
						'46101-SHJ-A03' =>array(0), //repuesto eregi y cantidades
						'06462-SJA-305' =>array(1),
						'08798-9008' 	=>array(1.5),
						'01469-SJA-G00' =>array(0,1)
					),
		'5GC' => array(
						'35100-SDA-A31' =>array(0), //repuesto eregi y cantidades
						'06351-SDA-000' =>array(1)
					),
	);
	
	var $repuestos_auto = array(
		'5WS' => array(
						'35750-SAD-M01ZA',
						'35751-SAA-305',
					),
		'5WS1' => array(
						'35752-SAA-306ZA',
						'35752-SAA-405ZA',
					),
		'5LR' => array(
						'06535-SJA-A01',
						'08206-9002',
					),
		'5SZ' => array(
						'06770-S84-A11ZA',
						'04770-S5A-308',
					),
		'5SD' => array(
						'06780-S5A-G80ZA',
						'04780-S5A-308',
					),
		'5SE' => array(
						'70450-SZAA01',
						'70450-SZA-A11',
					),
		'5LB' => array(
						'46101-SHJ-A03',
						'06462-SJA-305',
						'08798-9008',
						'01469-SJA-G00'
					),
		'5GC' => array(
						'35100-SDA-A31',
						'06351-SDA-000'
					),
	);
	
	var $frts_validos = array(
		'5WS' => array(
			'744799'=>array(0.8),
			'744299'=>array(0.7, 1.2)
		),
		'5WS1' => array(
			'744299'=>array(0.7, 1.2),
		),
		'5LR' => array(
			'5121D3'=>array(1.3),
		),
		'5SZ' => array(
			'7521F4'=>array(0.5),
		),
		'5SD' => array(
			'7521F7'=>array(0.7),
		),
		'5SE' => array(
			'729143'=>array(0.3),
		),
		'5LB' => array(
			'4131Q8'=>array(1.3),
			'4131Q8A'=>array(0.6),
		),
		'5GC' => array(
			'7255A1'=>array(0.2),
			'7255A1A'=>array(0.1),
		),
		
	);
	
	var $frts_auto = array(
		'5WS' => array(
		),
		'5LR' => array(
			'5121D3',
		),
		'5SZ' => array(
			'7521F4',
		),
		'5SD' => array(
			'7521F7',
		),
		'5SE' => array(
			'729143',
		),
		'5LB' => array(
			'4131Q8',
		),
		'5GC' => array(
			'7255A1',
		),
	);
	
	
	public function MY_Reclamo_garantia()
    {
		$this->CI =& get_instance();
	}
	
	public function validar_version($version)
	{
		
		switch ($version)
		{
			case 'CONCESIONARIO':
				RETURN TRUE;
				break;
			case 'HONDA':
				if(!$this->CI->backend->_permiso('admin'))
				{
					RETURN FALSE;
				}
				RETURN TRUE;
				break;
			case 'JAPON':
				if(!$this->CI->backend->_permiso('admin'))
				{
					RETURN FALSE;
				}
				RETURN TRUE;
				break;
		}
		
		RETURN FALSE;
		
	}
	
	
	public function normalizar_documento_sap($documento_sap)
	{
		return str_pad($documento_sap,10,"0",STR_PAD_LEFT);
	
	}
	
	/**
	 * return array si encuentra hora/vin, sino false
	 */
	public function get_frt_data($frt_id = FALSE, $vin = FALSE)
	{
		//si termina en 99 es frt personalizado!
		if(substr($frt_id, -2)==99)
		{
			RETURN  array(
			'frt_id'		=> $frt_id,
			'horas' 		=> null,
			'descripcion' 	=> lang('personalizado'),
			'custom' 		=> 1
			); 
		}
		else
		{
			//primero tomo datos de la unidad
			$unidad = Doctrine::getTable('Unidad')->findOneByunidad_field_vin($vin);
			if($unidad)
			{				
				$frt_hora = new Frt_Hora();
				$q	=	$frt_hora->get_all();
				$q->addWhere('frt_id = ?',			$frt_id);
				$q->addWhere('auto_modelo_id = ?',	$unidad->Auto_Version->Auto_Modelo->id);
				$q->addWhere('auto_anio_id = ?',	$unidad->auto_anio_id);
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
					
				}
				if($resultado)
				{
					RETURN  array(
					'frt_id'		=> $frt_id,
					'horas' 		=> $resultado[0]['frt_hora_field_horas'],
					'descripcion' 	=> $resultado[0]['Frt']['frt_field_desc'],
					'custom' 		=> 0
					);
				}
				
				
			}
			
			RETURN FALSE;
		
		
		}
		
		
	}
	// --------------------------------------------------------------------
	
	/**
	 * return array  /  false
	 * TODO validar sucursal contra permisos, (empresa sap id)
	 */
	public function get_material_precio($documento_sap = FALSE, $material_id = FALSE, $sucursal_id = FALSE)
	{
		/*
		SELECT (importe_neto/cantidad_facturada) AS importe_neto
						FROM ".$this-> prefix ."fcsp_facturacion
						WHERE material='".$this->sqlIn ( $repuestoNumero )."'
						AND documento_sap='".$this->sqlIn ( $facturaSAP )."'
						AND importe_neto>0
						AND cantidad_facturada>0
						ORDER BY posicion DESC LIMIT 1
		*/
		
		/*aca hay un parche, puede ser que venga sin documento sap, en tal caso mandamos todo como vacio*/
		if(!$documento_sap || strlen($documento_sap)==0)
		{
			RETURN array(
				'documento_sap'	=>NULL,
				'material'		=>$material_id,
				'precio'		=>0
			);
		}
		
		
		$documento_sap = $this->normalizar_documento_sap($documento_sap);
		
		
		$material_facturacion = new Material_Facturacion();
		$q = $material_facturacion->get_all();
		$q->select('(material_facturacion_field_importe_neto / material_facturacion_field_cantidad_facturada ) AS precio');
		$q->addWhere('material_facturacion_field_importe_neto > ?',	0);
		$q->addWhere('material_facturacion_field_cantidad_facturada > ?',	0);
		$q->addWhere('material_facturacion_field_documento_sap_id = ?',	$documento_sap);
		$q->addWhere('material_id = ?',									$material_id);
		//$q->addWhere('material_facturacion_field_solicitante = ?',	$sucursal_id);
		$q->orderBy('material_facturacion_field_posicion DESC');
		$q->limit(1);
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
					
		}
		if($resultado)
		{
			RETURN array(
				'documento_sap'	=>$documento_sap,
				'material'		=>$material_id,
				'precio'		=>round($resultado[0]['precio'],2)
			);
		}
		RETURN FALSE;
		
	}
	// --------------------------------------------------------------------
	
	/**
	 * return array  /  false
	 * devuelve el nombre de un material
	 */
	public function get_material_descripcion($material_id = FALSE)
	{
		$material = Doctrine::getTable('Material')->findOneByid($material_id);
		if($material)
		{
			RETURN  array(
					'material'	=>$material_id,
					'descripcion'=> $material->material_field_desc	
			);
		}		
		RETURN FALSE;
		
	}
	// --------------------------------------------------------------------
	
	/**
	 * return true /  false
	 * el material es una bateria?
	 */
	public function es_bateria($material_id = FALSE)
	{
		if ( preg_match("#^31500#", $material_id) )
		{
			return TRUE;
		}
		RETURN FALSE;
		
	}
	// --------------------------------------------------------------------
	
	
	/**
	 * return true /  false
	 * el material es un fluido
	 */
	public function es_fluido($material_id = FALSE)
	{
		if(in_array($material_id, $this->repuestos_float))
		{
			 RETURN TRUE;
		}
		RETURN FALSE;
	}
	// --------------------------------------------------------------------
	
	/**
	 * return true /  false
	 * valida la cantidad para un material, si es un fluido puede ser un float
	 */
	public function validar_material_cantidad($material_id = FALSE,$cantidad = FALSE)
	{
		
		if(!is_numeric($cantidad) || $cantidad<0)
		{
			RETURN FALSE;
		}
		if(!$this->es_fluido($material_id))
		{	
			 RETURN (is_numeric($cantidad) ? intval($cantidad) == $cantidad : FALSE);
		}
		else
		{
			RETURN TRUE;
		}
		
	}
	// --------------------------------------------------------------------
	
	/*return false, array*/
	public function get_tsi_valores_garantia($tsi_id = FALSE)
	{
		$tsi = new Tsi();
		$q = $tsi->get_all();
		$q->WhereIn('sucursal_id ', $this->CI->session->userdata('sucursales'));
		$q->addWhere('id = ?',$tsi_id);
		$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		if(is_array($resultado) && isset($resultado[0]['Sucursal']['sucursal_field_ingresos_brutos']))
		{
			//tomo ingresos burtos de la sucursal
			$valor_frt = new Sucursal_Valor_Frt();
			$q = $valor_frt->get_all();
			$q->WhereIn('sucursal_id ', $this->CI->session->userdata('sucursales'));
			$q->addWhere('sucursal_id = ?',$resultado[0]['sucursal_id']);
			$q->addWhere('sucursal_valor_frt_field_fecha_inicio <= ?',$resultado[0]['tsi_field_fecha_de_egreso']);
			$q->addWhere('sucursal_valor_frt_field_fecha_inicio <= ?',date("Y-m-d"));
			$q->limit(1);
			$q->orderBy('sucursal_valor_frt_field_fecha_inicio DESC');
			$valor=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			if(is_array($valor) && isset($valor[0]))	
			{
				RETURN 	array(
						'valor_ingresos_brutos'=> $resultado[0]['Sucursal']['sucursal_field_ingresos_brutos'],
						'valor_frt_hora'=> $valor[0]['sucursal_valor_frt_field_valor_frt_hora'],
						);
			}
		}
		RETURN FALSE;
	
	}
	
	
	public function get_campania_default($campania_id = FALSE,$vin = FALSE)
	{
		
		$campania_id = trim(strtoupper($campania_id));
		
		$campania = new Reclamo_Garantia_Campania();
		$q = $campania->get_all();
		$q->addWhere('id = ?',$campania_id);
		$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		if($resultado && count($resultado)==1)
		{
			
			$campania = strtoupper($resultado[0]['reclamo_garantia_campania_field_desc']);
			$return_repuestos = array();
			$return_frts = array();
			$return_custom_field = array();
			if(isset($this->repuestos_validos[$campania]) && isset($this->repuestos_auto[$campania]))
			{

				reset($this->repuestos_auto[$campania]);
				while(list(,$repuesto)=each($this->repuestos_auto[$campania]))
				{
					if(isset($this->repuestos_validos[$campania]))
					{
						$material = $this->get_material_descripcion($repuesto);
						if(!$material)
						{
							$desc = NULL;
						}else{
							$desc = $material['descripcion'];
						}
						if(count($this->repuestos_validos[$campania][$repuesto])>1)
						{
							//tiene mas de 1 repuesto, no le envio nada por default
							$repuesto_cantidad = "";
						}else{
							$repuesto_cantidad = $this->repuestos_validos[$campania][$repuesto][0];
						}
						$return_repuestos[] = array('material'=>$repuesto,
													'cantidad'=>$repuesto_cantidad,
													'material_desc'=>$desc
													);
					}
				}
				
			}
			//------
			
			if(isset($this->frts_validos[$campania]) && isset($this->frts_auto[$campania]))
			{

				reset($this->frts_auto[$campania]);
				while(list(,$frt)=each($this->frts_auto[$campania]))
				{
					
				
					if(isset($this->frts_validos[$campania]))
					{
						/*
						$material = $this->get_material_descripcion($repuesto);
						if(!$material)
						{
							$desc = NULL;
						}else{
							$desc = $material['descripcion'];
						}
						*/
						
						$frt_data = $this->get_frt_data($frt, $vin);
						if($frt_data)
						{
							if(count($this->frts_validos[$campania][$frt])>1)
							{
								//tiene mas de 1 repuesto, no le envio nada por default
								$horas = "";
							}else{
								$horas =$this->frts_validos[$campania][$frt][0];
							}
							
							$return_frts[] = array('horas'=>$horas,
													'frt'=>$frt,
													'frt_descripcion'=>$frt_data['descripcion']
											);
						}
					}
				}
				
			}
			
			if($campania_id =='5SD')
			{
			
				$return_custom_field[] = array(
					'reclamo_garantia_version_field_serie_inflador_original'=>array('req'=>FALSE),
					'reclamo_garantia_version_field_serie_inflador_colocado'=>array('req'=>FALSE)
				);
			}
				
			
			return array(
				'repuestos'=>$return_repuestos,
				'frts'=>$return_frts,
				'custom_field'=>$return_custom_field
			);
			
		}
		
		RETURN FALSE;
	}
	
	
	
	
}
?>