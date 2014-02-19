<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/*hardcoding baby...*/

class R_garantia
{
	var $version_actual = FALSE;
	var $tsi_actual = FALSE;
	var $fix_bateria = FALSE;
	var $media_bateria = FALSE;
	var $frts_procesados = array();
	var $materiales_procesados = array();
	var $kilometros_maximos = 100000; //kilometros a partir de los cuales el auto esta fuera de garantia
	
	//todo esto para campañas
	var $campania = FALSE;
	var $materiales_requeridos = array();
	var $materiales_opcionales = array();
	var $frts_requeridos = array();
	var $frts_opcionales = array();

	//todo esto para campañas 
	
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
	
	public function R_garantia()
    {
		$this->CI =& get_instance();
	}
	
	public function get_fix_bateria()
	{
		RETURN $this->fix_bateria;
	}
	
	public function get_kilometros_maximos()
	{
		RETURN $this->kilometros_maximos;
	}
	
	
	public function set_version($version)
	{
		
		switch ($version)
		{
			case 'CONCESIONARIO':
				$this->version_actual = $version;
				RETURN TRUE;
				break;
			case 'HONDA':
				if(!$this->CI->backend->_permiso('admin'))
				{
					RETURN FALSE;
				}
				$this->version_actual = $version;
				RETURN TRUE;
				break;
			case 'JAPON':
				if(!$this->CI->backend->_permiso('admin'))
				{
					RETURN FALSE;
				}
				$this->version_actual = $version;
				RETURN TRUE;
				break;
		}
		
		RETURN FALSE;
		
	}
	
	public function get_version()
	{
		RETURN $this->version_actual;
	}
	
	public function set_campania($campania_id)
	{
		if($this->es_campania($campania_id))
		{
			
			
			//tomo repuestos
			$q = Doctrine_Query::create()
			->from('Reclamo_Garantia_Campania_Material')
			->where('reclamo_garantia_campania_id = ?',$campania_id);
			$materiales=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			foreach($materiales as $material)
			{
				if($material['material_requerido'] == 1)
				{
					
					
					$this->materiales_requeridos[$material['material_id']] = array(
											'cantidad'=>explode(";",$material['material_cantidad']),
											'principal'=>$material['material_principal']
					
					);
				}
				else
				{
					$this->materiales_opcionales[$material['material_id']] = array(
											'cantidad'=>explode(";",$material['material_cantidad']),
											'principal'=>$material['material_principal']
					
					);
				}
			}
			//tomo frts
			$q = Doctrine_Query::create()
			->from('Reclamo_Garantia_Campania_Frt')
			->where('reclamo_garantia_campania_id = ?',$campania_id);
			$frts=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			foreach($frts as $frt)
			{
				if($frt['frt_requerido'] == 1)
				{
					$this->frts_requeridos[$frt['frt_id']] = array(
															'horas'=>explode(';',$frt['frt_hora'])
															);
				}
				else
				{
					$this->frts_opcionales[$frt['frt_id']] = array(
															'horas'=>explode(';',$frt['frt_hora'])
															);
				}
			}
			
			$this->campania = $campania_id;
		
		}
		
	}
	
	public function get_campania()
	{
		RETURN $this->campania;
	}
	
	
	public function normalizar_documento_sap($documento_sap)
	{
		return str_pad($documento_sap,10,"0",STR_PAD_LEFT);
	
	}
	
	/**
	 * return array si encuentra hora/vin, sino false, param horas solo para campañas
	 */
	public function get_frt_data($frt_id = FALSE, $vin = FALSE, $horas = FALSE, $unique = TRUE)
	{
		
		//si ya lo proceso antes?
		if($unique)
		{
			if(isset($this->frts_procesados[$frt_id]))
			{
				RETURN FALSE;
			}
		}
		
		$this->frts_procesados[$frt_id] = TRUE;
		
		
		if(!$vin && $this->tsi_actual)
		{
			$vin = $this->tsi_actual->Unidad->unidad_field_vin;
		}
		
		
		if(strlen($frt_id)>7)
		{
			RETURN FALSE;
		}
		
		if($this->campania)
		{
			if(!isset($this->frts_requeridos[$frt_id]) AND !isset($this->frts_opcionales[$frt_id]))
			{
				RETURN FALSE;
			}
			else if(isset($this->frts_requeridos[$frt_id]))
			{
				if(!in_array($horas,$this->frts_requeridos[$frt_id]['horas']))
				{
					RETURN FALSE;
				}
			}
			else if(isset($this->frts_opcionales[$frt_id]))
			{
				if(!in_array($horas,$this->frts_opcionales[$frt_id]['horas']))
				{
					RETURN FALSE;
				}
			}
		}
		
		
		
		//si termina en 99 es frt personalizado!
		if(substr($frt_id, -2)==99)
		{
			
			//que exista la seccion....
			$s = Doctrine::getTable('Frt_Seccion')->findOneByid(substr($frt_id, 0, 4));
			if(!$s)
			{
				RETURN FALSE;
			}
			
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
	
	/*
		se fija si se ingresaron todos los frts requeridos en el caso de una campaña
	*/
	public function campania_frt_ingresados()
	{
		if(!$this->campania)
		{
			RETURN TRUE;
		}
		reset($this->frts_requeridos);
		while(list($frt_id,)=each($this->frts_requeridos))
		{
			if(!isset($this->frts_procesados[$frt_id]))
			{
				RETURN FALSE;
			}
		}
		
		RETURN TRUE;
	}
	
	/*
		se fija si se ingresaron todos los materiales requeridos en el caso de una campaña
	*/
	public function campania_materiales_ingresados()
	{
		if(!$this->campania)
		{
			RETURN TRUE;
		}
		reset($this->materiales_requeridos);
		while(list($material_id,)=each($this->materiales_requeridos))
		{
			if(!isset($this->materiales_procesados[$material_id]))
			{
				RETURN FALSE;
			}
		}
		
		RETURN TRUE;
	}
	
	/*
		return false si estamos en una campaña y no es el repuesto principal
	*/
	
	public function campania_material_principal($material_id)
	{
		if(!$this->campania)
		{
			RETURN TRUE;
		}
		
		if(isset($this->materiales_requeridos[$material_id]['principal']) AND $this->materiales_requeridos[$material_id]['principal'] == 1)
		{
			RETURN TRUE;
		}
		else
		{
			RETURN FALSE;
		}
		
	}
	
	
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
			
			if($this->es_bateria($material_id) && $this->media_bateria)
			{
				$resultado[0]['precio'] = $resultado[0]['precio'] *0.5;
				$this->fix_bateria = TRUE;
			}
			
			
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
	 * PARCHE pongo aca materiales procesados para la campaña :$
	 */
	public function validar_material_cantidad($material_id = FALSE,$cantidad = FALSE, $unique = TRUE)
	{
		//si ya lo proceso antes?
		if($unique)
		{
			if(isset($this->materiales_procesados[$material_id]))
			{
				RETURN FALSE;
			}
		}
		
		$this->materiales_procesados[$material_id] = TRUE;
		
		if($this->campania)
		{
			if(!isset($this->materiales_requeridos[$material_id]) AND !isset($this->materiales_requeridos[$material_id]))
			{
				RETURN FALSE;
			}
			else if(isset($this->materiales_requeridos[$material_id]))
			{
				if(!in_array($cantidad,$this->materiales_requeridos[$material_id]['cantidad']))
				{
					RETURN FALSE;
				}
			}
			else if(isset($this->materiales_opcionales[$material_id]))
			{
				if(!in_array($cantidad,$this->materiales_opcionales[$material_id]['cantidad']))
				{
					RETURN FALSE;
				}
			}
			
		}
		
		
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
		$return = array(
			'valor_ingresos_brutos' => 0,
			'valor_frt_hora'=> 0,
			'valor_hora_japon'=>0,
			'valor_alca'=>0,
			'valor_dolar'=>0
		);
		
		$tsi = new Tsi();
		$q = $tsi->get_all();
		$q->WhereIn('sucursal_id ', $this->CI->session->userdata('sucursales'));
		$q->addWhere('id = ?',$tsi_id);
		$q->limit(1);
		$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		if(is_array($resultado) && isset($resultado[0]['Sucursal']['sucursal_field_ingresos_brutos']))
		{
			$return['valor_ingresos_brutos'] 	= $resultado[0]['Sucursal']['sucursal_field_ingresos_brutos'];
			
			//valor frt hora
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
				$return['valor_frt_hora'] = $valor[0]['sucursal_valor_frt_field_valor_frt_hora'];
			}
			//valor frt dolar
			
			//todo ultimo reclamo que tenga dolares
			$q = Doctrine_Query::create()
			->from('Reclamo_Garantia Reclamo_Garantia')
			->where('reclamo_garantia_field_valor_dolar > ?',0)
			->orderBy('id DESC')
			->limit(1);
			$valor=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			if(is_array($valor) && isset($valor[0]))	
			{	
				$return['valor_dolar'] = $valor[0]['reclamo_garantia_field_valor_dolar'];
			}
			//tomo valor alca
			$a = new Reclamo_Garantia_Valor_Alca();
			$q = $a->get_all();
			$q->addWhere('reclamo_garantia_valor_alca_field_fecha_inicio <= ?',$resultado[0]['tsi_field_fecha_de_egreso']);
			$q->addWhere('reclamo_garantia_valor_alca_field_fecha_inicio <= ?',date("Y-m-d"));
			$q->orderBy('reclamo_garantia_valor_alca_field_fecha_inicio DESC');
			$q->limit(1);
			$valor=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			if(is_array($valor) && isset($valor[0]))	
			{	
				$return['valor_alca'] = $valor[0]['reclamo_garantia_valor_alca_field_valor_alca'];
			}
			//tomo valor hora japon
			$a = new Reclamo_Garantia_Valor_Hora_Japon();
			$q = $a->get_all();
			$q->addWhere('reclamo_garantia_valor_hora_japon_field_fecha_inicio <= ?',$resultado[0]['tsi_field_fecha_de_egreso']);
			$q->addWhere('reclamo_garantia_valor_hora_japon_field_fecha_inicio <= ?',date("Y-m-d"));
			$q->orderBy('reclamo_garantia_valor_hora_japon_field_fecha_inicio DESC');
			$q->limit(1);
			$valor=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			if(is_array($valor) && isset($valor[0]))	
			{	
				$return['valor_hora_japon'] = $valor[0]['reclamo_garantia_valor_hora_japon_field_valor_hora_japon'];
			}

			
			/*
			$sql="SELECT valor_dolar FROM ".$this-> prefix ."reclamo_garantia
			WHERE valor_dolar>0 ORDER BY id_reclamo DESC LIMIT 1
		";
			*/
			
		}
		RETURN $return;
	
	}
	
	
	public function es_campania_duplicada($campania_id = FALSE, $id_reclamo = FALSE)
	{
		if(!$this->tsi_actual)
		{
			show_error('no existe TSI seteado');
		}
		$q = Doctrine_Query::create()
		->from('Reclamo_Garantia Reclamo_Garantia')
		->leftJoin('Reclamo_Garantia.Tsi Tsi')
		->where('Reclamo_Garantia.reclamo_garantia_estado_id != ?',9) //rechazado
		->addWhere('Tsi.unidad_id = ?', $this->tsi_actual->unidad_id)
		->addWhere('Reclamo_Garantia.reclamo_garantia_campania_id LIKE ?',substr($campania_id, 0, 3).'%')
		->addWhere('Reclamo_Garantia.id != ?',$id_reclamo);
		if($q->count()!=0)
		{
			RETURN TRUE;
		}
		RETURN FALSE;
		
	}
	
	
	
	
	public function es_campania($campania_id = FALSE, $vin = FALSE)
	{
	
		
		if(!$vin && $this->tsi_actual)
		{
			$vin = $this->tsi_actual->Unidad->unidad_field_vin;
		}
		$c = new Reclamo_Garantia_Campania_Unidad();
		$q = $c->get_all();
		$q->addWhere('Reclamo_Garantia_Campania_Unidad.reclamo_garantia_campania_id = ?',$campania_id);
		$q->addWhere('Reclamo_Garantia_Campania_Unidad.unidad_field_vin = ?',$vin);
		if($q->count()==1)
		{
			RETURN TRUE;
		}
		RETURN FALSE;
		
	}
	
	
	
	public function get_campania_default($campania_id = FALSE, $vin = FALSE)
	{
		
		
		if($this->es_campania($campania_id, $vin))
		{
			
			$return_repuestos = array();
			$return_frts = array();
			//-------------- materiales 
			$r = new Reclamo_Garantia_Campania_Material();
			$q = $r->get_all();
			$q->addWhere('Reclamo_Garantia_Campania_Material.reclamo_garantia_campania_id = ?',$campania_id);
			$q->addWhere('Reclamo_Garantia_Campania_Material.material_requerido = ?',1);
			$q->orderBy('Reclamo_Garantia_Campania_Material.material_principal DESC');
			if($q->count()>0)
			{	
				$r=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
				foreach($r as $repuesto)
				{
					
					$material = $this->get_material_descripcion($repuesto['material_id']);
					if(!$material)
					{
						$desc = NULL;
					}else{
						$desc = $material['descripcion'];
					}
					//
					$repuesto_cantidad = "";
					$cantidades = explode(";",$repuesto['material_cantidad']);
					if(count($cantidades) == 1)
					{
						$repuesto_cantidad = $repuesto['material_cantidad'];
					}
					$return_repuestos[] = array('material'=>$repuesto['material_id'],
												'cantidad'=>$repuesto_cantidad,
												'material_desc'=>$desc
					);
					
				}
			}
			//-------------- materiales 
			
			//-------------- frts
			$r = new Reclamo_Garantia_Campania_Frt();
			$q = $r->get_all();
			$q->addWhere('Reclamo_Garantia_Campania_Frt.reclamo_garantia_campania_id = ?',$campania_id);
			$q->addWhere('Reclamo_Garantia_Campania_Frt.frt_requerido = ?',1);
			if($q->count()>0)
			{
				$r=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
				foreach($r as $frt)
				{
					$frt_data = $this->get_frt_data($frt['frt_id'], $vin);
					if($frt_data)
					{
						$horas = "";
						$cantidades = explode(";",$frt['frt_hora']);
						if(count($cantidades) == 1)
						{
							$horas = $frt['frt_hora'];
						}
						
						$return_frts[] = array('horas'=>$horas,
												'frt'=>$frt['frt_id'],
												'frt_descripcion'=>$frt_data['descripcion']
										);
					}
				}
			}
			
			//-------------- frts			
			
			return array(
				'repuestos'=>$return_repuestos,
				'frts'=>$return_frts
			);
		}
		
		RETURN FALSE;
	}
	
	
	/*
		setea el tsi del reclamo de garantia en cuestion
	*/
	public function set_tsi( $tsi_id, $fecha = FALSE )
	{
		$q = Doctrine_Query::create();
        $q->from('Tsi Tsi');
		$q->leftJoin('Tsi.Many_Tsi_Tipo_Servicio Many_Tsi_Tipo_Servicio ');
		$q->Where('id = ?',$tsi_id);
		
		if($fecha)
		{
			$q->addWhere(' ( TO_DAYS(NOW()) - TO_DAYS(Tsi.tsi_field_fecha_de_egreso) ) <= ?  ',30); //30 dias desde que salio
		}
		$tih = "";
		if($this->CI->session->userdata('show_tsi_tih'))
		{
			$tih = "Many_Tsi_Tipo_Servicio.id = 9 OR ";
		}
		$q->addWhere('( '.$tih.' Many_Tsi_Tipo_Servicio.id = 7 OR Many_Tsi_Tipo_Servicio.id = 8 OR (Many_Tsi_Tipo_Servicio.id= 4 AND Tsi.tsi_field_kilometros_rotura<201))');
		$q->WhereIn('sucursal_id ', $this->CI->session->userdata('sucursales'));
		
		if($q->count()!=1)
		{
			RETURN FALSE;
		}
		else
		{
			
			
			$this->tsi_actual = $q->fetchOne();
			$entregada = new DateTime($this->tsi_actual->Unidad->unidad_field_fecha_entrega);
			$rota = new DateTime($this->tsi_actual->tsi_field_fecha_rotura);
			$intervalo = date_diff($entregada, $rota);
			if((int)$intervalo->format('%Y')>=2) //mas de 2 años, fix bateria....
			{
				$this->media_bateria = TRUE;
			}
			
			RETURN TRUE;
		}
		
	}
	
	
	/*
		la fecha de rotura no deberia ser mayor a la fecha de tsi
		deberia estar seteado el tsi;
		//TODO no deberia ser la fecha de ingreso?
	*/
	public function is_valid_fecha_rotura($fecha_rotura)
	{
		show_error('deprecated');
		if(!$this->tsi_actual)
		{
			show_error('no existe tsi seteado');
		}
		
		if ( !preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})#", $fecha_rotura) )
		{
			RETURN FALSE;
		}
		
		
		$tsi_fecha = new DateTime($this->tsi_actual->tsi_field_fecha_de_egreso);
		$garantia_rotura = new DateTime($fecha_rotura);
		RETURN ($tsi_fecha >= $garantia_rotura);
		
	}
	
	public function get_precio_fob($material){
		
		$fob = new Material_Precio_Fob();
		$q = $fob->get_all();
		$q->addWhere('Material_Precio_Fob.material_id = ?',$material);
		$q->addWhere('Material_Precio_Fob.moneda_id = ?',2); //dolar
		$q->limit(1);
		if($q->count()!=1)
		{
			RETURN 0;
		}
		$r = $q->fetchArray();
		$precio_fob = $r[0]['material_precio_fob_field_precio_fob'];
		
		if($this->es_bateria($material) && $this->media_bateria)
		{
			$precio_fob = $precio_fob * 0.5;
			$this->fix_bateria = TRUE;
		}

		RETURN (float)$precio_fob;

		
	}
	
	
	public function get_info($id_tsi = FALSE)
	{
		if(!$id_tsi && $this->tsi_actual)
		{
			$id_tsi = $this->tsi_actual->id;
		}
		
		
		
		//tomo el vin
		$q = Doctrine_Query::create();
        $q->from('Tsi Tsi');
		$q->leftJoin('Tsi.Unidad Unidad');
        $q->where("Tsi.id = ?",$id_tsi);
		$q->addWhere('Tsi.tsi_estado_id != ?',9);
		$q->addWhere('Unidad.id IS NOT NULL');
		if($q->count()!=1)
		{
			show_error(__LINE__ . __FILE__ . ' no encuentro tsi:' . $id_tsi);
		}
		$row = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
		$vin = $row['Unidad']['unidad_field_vin'];
		
		
		$unidad_estado_garantia_id = 4;
		if($row['tsi_field_kilometros_rotura']>$this->kilometros_maximos)
		{
			$unidad_estado_garantia_id =2; //vencida por 100k kilometros
		}
		else if($row['Unidad']['unidad_estado_garantia_id'] ==2)
		{
			//si esta vencida, me fijo que hayan pasado 3 años
			$entregada = new DateTime($row['Unidad']['unidad_field_fecha_entrega']);
			$rota = new DateTime($row['tsi_field_fecha_rotura']);
			$intervalo = date_diff($entregada, $rota);
			if((int)$intervalo->format('%Y')<3)
			{
				$unidad_estado_garantia_id = 1; //se la paso a activa...
			}
			else
			{
				$unidad_estado_garantia_id = 2; //sigue inactiva
			}
			
		}
		else
		{
			$unidad_estado_garantia_id = $row['Unidad']['unidad_estado_garantia_id'];
		}
		
		
		$garantia_problemas = 0;
		$mantenimientos_esperados = floor($row['tsi_field_kilometros']/10000)+1;
		
		if($row['tsi_field_kilometros']<10000){
			$mantenimientos_esperados=1;
		}
		if($row['tsi_field_kilometros']<1000){
			$mantenimientos_esperados=0;
		}				
		
		//tomo los mantenimientos que se le hicieron al auto hasta ese tsi
		$q = Doctrine_Query::create();
        $q->from('Tsi Tsi');
		$q->leftJoin('Tsi.Unidad Unidad');
		$q->leftJoin('Tsi.Many_Tsi_Tipo_Servicio Many_Tsi_Tipo_Servicio');
        $q->where("Unidad.id = ?",$row['Unidad']['id']);
		$q->whereIn("Many_Tsi_Tipo_Servicio.id",array(1));
		$q->addWhere('Tsi.tsi_estado_id != ?',9);
		$q->addWhere("Tsi.tsi_field_fecha_de_egreso <= ? ",$row['tsi_field_fecha_de_egreso']);
		
		$mantenimientos_realizados = $q->count();
		
		if($mantenimientos_esperados<$mantenimientos_esperados OR $row['tsi_field_kilometros_rotura']>$this->kilometros_maximos OR $unidad_estado_garantia_id!=1 )
		{
			$garantia_problemas = 1;
	    }
		
		
		return array(
			'mantenimientos_esperados'=>$mantenimientos_esperados,
			'mantenimientos_realizados'=>$mantenimientos_realizados,
			'garantia_problemas'=>$garantia_problemas,
			'unidad_estado_garantia_id'=> $unidad_estado_garantia_id
		);
		
	}
	
	
	
	
}
?>