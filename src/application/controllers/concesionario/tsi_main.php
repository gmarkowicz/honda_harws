<?php
define('ID_SECCION',3021);

class Tsi_Main extends Backend_Controller {
	
	//solo para aca, cantidad de dias de los ultimos registros
	var $dias_default = 30;
	
	//filtra por sucursal?
	var $sucursal = TRUE;
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
		
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array('MATCH( 
												unidad_field_unidad,
												unidad_field_vin,
												unidad_field_descripcion_sap,
												cliente_field_numero_documento,
												cliente_sucursal_field_nombre,
												cliente_sucursal_field_nombre,
												cliente_sucursal_field_razon_social,
												cliente_sucursal_field_email
										) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para filtrar
		
		//---------------[solo para reporte]
		'fecha_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fechahora_alta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_de_ingreso_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_de_ingreso) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_de_ingreso_final'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_de_ingreso) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_de_egreso_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_de_egreso) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_de_egreso_final'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_de_egreso) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_entrega_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(unidad_field_fecha_entrega) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_entrega_final'=>
			array(
				 'sql_filter'	=>array('DATE(unidad_field_fecha_entrega) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'fecha_rotura_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_rotura) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_rotura_final'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_rotura) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'cliente'=>
			array(
				 'sql_filter'	=>array('MATCH( cliente_sucursal_field_nombre,cliente_sucursal_field_nombre,cliente_sucursal_field_razon_social ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//---------------[solo para reporte]
		
		'sucursal_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'sucursal_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'tsi_field_fecha_de_egreso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'tsi_field_fecha_de_ingreso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'tsi_field_fecha_rotura'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'unidad_field_unidad'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		'unidad_field_vin'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		'unidad_field_motor'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_patente'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_codigo_de_llave'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_codigo_de_radio'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_material_sap'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_descripcion_sap'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_codigo_interno_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_codigo_interno_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_oblea'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_certificado'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_formulario_12'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_formulario_01'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'tsi_tipo_servicio_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'tsi_tipo_mantenimiento_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'tsi_motivo_reparacion_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'tsi_motivo_reparacion_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_promocion_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'tsi_promocion_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'tsi_estado_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'tsi_estado_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'tsi_field_kilometros'=>
			array(
				 'sql_filter'	=>array('%THIS% >= ?'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'tsi_tipo_servicio_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		'tsi_tipo_mantenimiento_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		
		'cliente_codigo_interno_id'=>
			array(
				'sql_filter'	=>array(),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_codigo_interno_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		
		'cliente_sucursal_field_nombre'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_apellido'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_razon_social'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'cliente_field_numero_documento'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_conformidad_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
			
		'cliente_conformidad_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		
		'tsi_field_fechahora_alta'=>
			array(
				 'sql_filter'	=>array('DATE(%THIS%) >= ?'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'auto_modelo_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		
		'auto_version_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		
		'auto_transmision_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		
		'auto_anio_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		
		
		);
			
			
	function Tsi_Main()
	{
		parent::Backend_Controller();
		if($this->session->userdata('show_unidad_codigo_interno') != TRUE)
		{
			unset($this->default_valid_fields['unidad_codigo_interno_id']);
			unset($this->default_valid_fields['unidad_codigo_interno_field_desc']);
		}
		if($this->session->userdata('show_cliente_codigo_interno') != TRUE)
		{
			unset($this->default_valid_fields['cliente_codigo_interno_id']);
			unset($this->default_valid_fields['cliente_codigo_interno_field_desc']);
		}
	}


	function index()
	{	
		//-------------------------[buscador ]
		
		$config['campos'] = $this->default_valid_fields;
		
		//borramos en caso de que haya algun filtro previo
		$this->session->unset_userdata('filtro_'.$this->router->class);
		$this->session->unset_userdata('excluir_codigo_interno'.$this->router->class);
				
		//->filtros del buscador por post
			if($this->input->post('_filtro'))
			{
				if($this->input->post('cliente_codigo_interno_id'))
				{
					$this->session->set_userdata('excluir_codigo_interno'.$this->router->class,$this->input->post('cliente_codigo_interno_id'));
				}
				
				if($this->_validar_filtros())
				{ //validamos los datos que envia...
					$filtro=$this->_create_filters($config['campos']);
					
					#--------------------------
					if(count($filtro)>0)
					{
						//ya no se si me gusta el ajax
						$this->session->set_userdata('filtro_'.$this->router->class,$filtro);
					}
					#--------------------------
				}
			}
			//->filtros del buscador por post
				
			//->selecciones del buscador
			
			//-------------------------[/buscador ]
			
			
			//-------------------------[configuracion de grilla ]
			//->grilla
			/*
			 * 0 - display name
			 * 1 - width
			 * 2 - sortable
			 * 3 - align
			 * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.) // no se usa
			 */
			 
			$esqueleto_grid=$this->_create_grid_template($config['campos']);
			$buttons=false;
		
			//Build js
			//View helpers/flexigrid_helper.php for more information about the params on this function
			$this->template['js_grid'] = build_grid_js
			(
					'flex1', //html name
					$this->get_grid_url(), //url a la que apunta
					$esqueleto_grid,
					$this->default_sortname, //default order
					$this->default_sortorder, //default order 
					$this->config->item('gridParams'),
					$buttons
			);
		//-------------------------[/configuracion de grilla ]
		
		$this->_view();
		
	}

	function grid()
	{
		
		$config['campos'] = $this->default_valid_fields;
		//agrego para que pueda filtrar por id
		$this->default_valid_fields['id']['sorteable'] = TRUE;
		
		$this->_create_query();
		
		
		
		//-------[PARCHE]
		//si no envio data desde el reporte mostramos los primeros x registros
		if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
		{
			
			
			
			
			
			/*
			$dia = time()-($this->dias_default*24*60*60); //restamos dias default
			$desde_fecha = date('Y-m-d', $dia); //Formatea dia
			$this->query->AddWhere("TSI.tsi_field_fechahora_alta>=?",$desde_fecha);
			*/
			
			$rg = new Tsi();
			$this->query = $rg->get_grid();
			$this->query->whereIn('TSI.sucursal_id',$this->session->userdata('sucursales'));
			
			$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
			$desde_fecha = date('Y-m-d', $dia); //Formatea dia
			$this->query->AddWhere("TSI.tsi_field_fechahora_alta>=?",$desde_fecha);
			
			
			$this->flexigrid->validate_post();
			$this->flexigrid->build_query();
			
			
			
			
		}
		//------[PARCHE]
		
		if($this->session->userdata('excluir_codigo_interno'.$this->router->class))
		{
			$this->query->addWhere('(MANY_CLIENTE_CODIGO_INTERNO.id IS NULL OR MANY_CLIENTE_CODIGO_INTERNO.id NOT IN ?)  ',$this->session->userdata('excluir_codigo_interno'.$this->router->class) );
		}
		
		//$this->query->whereIn('SUCURSAL.id',$this->session->userdata('sucursales'));
		
		//-------[PARCHE]
		if($this->session->userdata('show_tsi_tih')!=TRUE)
		{
			//ocultamos servicios tih
			$this->query->AddWhere("TSI_TIPO_SERVICIO.id != ?",9);
		}
		//-------[PARCHE]
		
		//-------------------------[escribe la grilla]
		$pager = new Doctrine_Pager(
				$this->query,
				$this->post_info['page'], //flexigrid genera este dato
				$this->post_info['rp']	//flexigrid genera este dato
		 );
			
		
			
		/*
		 * Json build WITH json_encode. If you do not have this function please read
		 * http://flexigrid.eyeviewdesign.com/index.php/flexigrid/example#s3 to know how to use the alternative
		 */
		$record_items=array();
		try {
			$resultado=$pager->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			//$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}
		foreach ($resultado as $row)
		{
			unset($row['Unidad']['Sucursal']);
			$record_items[] = $this->_create_grid_data($row,$config['campos']);
		}
		
		//Print please
		
		
		$this->output->set_header($this->config->item('json_header'));
		$this->output->set_output($this->flexigrid->json_build($pager->getNumResults(),$record_items));
		//-------------------------[/escribe la grilla]
	}
		
	
	//exporta registros a xls
	function export()
	{
		
		ini_set('memory_limit', '3000M');
		
		//pdf xls
		$this->load->library('ofimatica');
		
		//nombre de las fields que exporta
		$config['campos']	=	$this->default_valid_fields;
		$config['registros_por_query'] = $this->ofimatica->get_records_per_query();
		
		
		$export_fields = array();
		$export_fields[]='id'; //agrego id
		reset($config['campos']);
		while (list($field_name,$val) = each ($config['campos']))
		{
			if(isset($val['export']) && $val['export'] === TRUE)
			{
				$export_fields[] = $field_name;
			}		
		}
		
		
		//creo archivo base
		$this->ofimatica->make_file();
		
		//agrego fila
		$this->ofimatica->add_row();
		/*
		reset($export_fields);
		while(list(,$field_name)=each($export_fields))
		{
			$this->ofimatica->add_header( $this->marvin->mysql_field_to_human($field_name),$val['width'] );
		}
		*/
		// a mano
		
		$this->ofimatica->add_header( lang('id') ,100 );
		$this->ofimatica->add_header( lang('unidad') ,100 );
		$this->ofimatica->add_header( lang('vin') ,100 );
		$this->ofimatica->add_header( lang('motor') ,100 );
		$this->ofimatica->add_header( lang('auto_modelo_id') ,100 );
		$this->ofimatica->add_header( lang('auto_version_id') ,100 );
		$this->ofimatica->add_header( lang('auto_transmision_id') ,100 );
		$this->ofimatica->add_header( lang('auto_anio_id') ,100 );
		$this->ofimatica->add_header( lang('patente') ,100 );
		$this->ofimatica->add_header( lang('codigo_de_llave') ,100 );
		$this->ofimatica->add_header( lang('codigo_de_radio') ,100 );
		$this->ofimatica->add_header( lang('sucursal_id') ,100 );
		//$this->ofimatica->add_header( lang('sucursal_vende_id') ,100 );
		$this->ofimatica->add_header( lang('fecha_de_egreso') ,100 );
		$this->ofimatica->add_header( lang('fechahora_alta') ,100 );
		$this->ofimatica->add_header( lang('fecha_entrega') ,100 );
		$this->ofimatica->add_header( lang('orden_de_reparacion') ,100 );
		$this->ofimatica->add_header( lang('kilometros') ,100 );
		$this->ofimatica->add_header( lang('tsi_tipo_servicio_id') ,100 );
		$this->ofimatica->add_header( lang('tsi_tipo_mantenimiento_id') ,100 );
		$this->ofimatica->add_header( lang('tsi_motivo_reparacion_id') ,100 );
		$this->ofimatica->add_header( lang('tsi_promocion_id') ,100 );
		$this->ofimatica->add_header( lang('admin_recepcionista_id') ,100 );
		$this->ofimatica->add_header( lang('admin_tecnico_id') ,100 );
		//--- cliente
		$this->ofimatica->add_header( lang('tratamiento_id') ,100 );
		$this->ofimatica->add_header( lang('razon_social') ,100 );
		$this->ofimatica->add_header( lang('nombre') ,100 );
		$this->ofimatica->add_header( lang('apellido') ,100 );
		$this->ofimatica->add_header( lang('cliente_conformidad_id') ,100 );
		$this->ofimatica->add_header( lang('documento_tipo_id') ,100 );
		$this->ofimatica->add_header( lang('numero_documento') ,100 );
		$this->ofimatica->add_header( lang('direccion_calle') ,100 );
		$this->ofimatica->add_header( lang('direccion_numero') ,100 );
		$this->ofimatica->add_header( lang('direccion_piso') ,100 );
		$this->ofimatica->add_header( lang('direccion_depto') ,100 );
		$this->ofimatica->add_header( lang('provincia_id') ,100 );
		$this->ofimatica->add_header( lang('ciudad_id') ,100 );
		$this->ofimatica->add_header( lang('direccion_codigo_postal') ,100 );
		$this->ofimatica->add_header( lang('telefono_particular') . ' ' . lang('telefono_particular_codigo')  ,100 );
		$this->ofimatica->add_header( lang('telefono_particular') . ' ' . lang('telefono_particular_numero'),100 );
		$this->ofimatica->add_header( lang('telefono_laboral') . ' ' . lang('telefono_laboral_codigo') ,100 );
		$this->ofimatica->add_header( lang('telefono_laboral') . ' ' . lang('telefono_laboral_numero'),100 );
		$this->ofimatica->add_header( lang('telefono_movil') . ' ' . lang('telefono_movil_codigo'),100 );
		$this->ofimatica->add_header( lang('telefono_movil') . ' ' . lang('telefono_movil_codigo') ,100 );
		$this->ofimatica->add_header( lang('fax') . ' ' . lang('fax_codigo') ,100 );
		$this->ofimatica->add_header( lang('fax') . ' ' . lang('fax_numero'),100 );
		$this->ofimatica->add_header( lang('email') ,100 );
		$this->ofimatica->add_header( lang('sexo_id') ,100 );
		$this->ofimatica->add_header( lang('fecha_nacimiento') ,100 );
		//--- cliente
		$this->ofimatica->add_header( lang('usuario') ,100 );
		if($this->session->userdata('show_unidad_codigo_interno') === TRUE)
		{
			$this->ofimatica->add_header( lang('unidad_codigo_interno_id') ,100 );
		}
		if($this->session->userdata('show_cliente_codigo_interno') === TRUE)
		{
			$this->ofimatica->add_header( lang('cliente_codigo_interno_id') ,100 );
		}
		
		
		
		
		
		$this->_create_query();
		//-------[PARCHE]
		if($this->session->userdata('show_tsi_tih')!=TRUE)
		{
			//ocultamos servicios tih
			$this->query->AddWhere("TSI_TIPO_SERVICIO.id != ?",9);
		}
		//-------[PARCHE]
		
		
		
		//-------[PARCHE]
		//si no envio data desde el reporte mostramos los primeros x registros
		if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
		{
			$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
			$desde_fecha = date('Y-m-d', $dia); //Formatea dia
			$this->query->AddWhere("TSI.tsi_field_fechahora_alta>=?",$desde_fecha);
		}
		//------[PARCHE]
		
		if($this->session->userdata('excluir_codigo_interno'.$this->router->class))
		{
			$this->query->addWhere('(MANY_CLIENTE_CODIGO_INTERNO.id IS NULL OR MANY_CLIENTE_CODIGO_INTERNO.id NOT IN ?)  ',$this->session->userdata('excluir_codigo_interno'.$this->router->class) );
		}
		
		
		$total = $this->query->count();
		$max = $this->ofimatica->get_export_max_rows();
		#vamos a aprobechar la limitacion del xls para ahorrrar memoria
		if($max>0 && $total>$max)	$total=$max;	
		
		$cantidad_querys=ceil($total/$config['registros_por_query']);
		//$cantidad_querys=1;
		for($pagina=0;$pagina<$cantidad_querys;$pagina++){
			//el hydrate, tuve que separar las querys parece que no queda otra amigo
			//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT\n"); //le voy tirando headers para q no salga por time out
			$this->_create_query();
			//-------[PARCHE]
			//si no envio data desde el reporte mostramos los primeros x registros
			if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
			{
				$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
				$desde_fecha = date('Y-m-d', $dia); //Formatea dia
				$this->query->AddWhere("TSI.tsi_field_fechahora_alta>=?",$desde_fecha);
			}
			//------[PARCHE]
			$this->query->limit($config['registros_por_query']);
			$this->query->offset($pagina*$config['registros_por_query']);
			$this->query->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
			
			$result=$this->query->execute(array());
			$this->query->free();
			
			foreach($result as $row)
			{
				
				$this->ofimatica->add_row();
				
			
				
				
				$this->ofimatica->add_data( $row['id']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_unidad'] );
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_vin'] );				
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_motor'] );
				$this->ofimatica->add_data( $row['Unidad']['Auto_Version']['Auto_Modelo']['auto_modelo_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Auto_Version']['auto_version_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Auto_Transmision']['auto_transmision_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Auto_Anio']['auto_anio_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_patente'] );	
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_codigo_de_llave']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_codigo_de_radio']);
				$this->ofimatica->add_data( $row['Sucursal']['sucursal_field_desc'] );	
				//$this->ofimatica->add_data( $row['Unidad']['Sucursal']['sucursal_field_desc'] );	
				$this->ofimatica->add_data( $row['tsi_field_fecha_de_egreso']);	
				$this->ofimatica->add_data( $row['tsi_field_fechahora_alta']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_fecha_entrega'] );						
				$this->ofimatica->add_data( $row['tsi_field_orden_de_reparacion']);	
				$this->ofimatica->add_data( $row['tsi_field_kilometros']);	
				$this->ofimatica->add_data( element('tsi_tipo_servicio_field_desc', $row['Many_Tsi_Tipo_Servicio']) );
				$this->ofimatica->add_data( $row['Tsi_Tipo_Mantenimiento']['tsi_tipo_mantenimiento_field_desc']);	
				$this->ofimatica->add_data( $row['Tsi_Motivo_Reparacion']['tsi_motivo_reparacion_field_desc']);	
				$this->ofimatica->add_data( @$row['Tsi_Promocion']['tsi_promocion_field_desc']);	
				$this->ofimatica->add_data( @$row['Recepcionista']['admin_field_nombre'] . ' ' . @$row['Recepcionista']['admin_field_apellido'] );
				$this->ofimatica->add_data( @$row['Tecnico']['admin_field_nombre'] . ' ' . @$row['Tecnico']['admin_field_apellido'] );
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['Tratamiento']['tratamiento_field_desc']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_razon_social']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_nombre']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_apellido']);
				$this->ofimatica->add_data( @$row['Cliente']['Cliente_Conformidad']['cliente_conformidad_field_desc']);
				$this->ofimatica->add_data( @$row['Cliente']['Documento_Tipo']['documento_tipo_field_desc']);
				$this->ofimatica->add_data( @$row['Cliente']['cliente_field_numero_documento']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_calle']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_numero']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_piso']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_depto']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['Provincia']['provincia_field_desc']);
				$this->ofimatica->add_data( @$row['Cliente']['Cliente_Sucursal'][0]['Ciudad']['ciudad_field_desc']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_codigo_postal']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_particular_codigo']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_particular_numero']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_laboral_codigo']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_laboral_numero']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_movil_codigo']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_movil_numero']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_fax_codigo']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_fax_numero']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_email']);
				$this->ofimatica->add_data( @$row['Cliente']['Cliente_Sucursal'][0]['Sexo']['sexo_field_desc']);
				$this->ofimatica->add_data( $row['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_fecha_nacimiento']);
				$this->ofimatica->add_data( $row['Admin_Alta']['admin_field_usuario']);
				if($this->session->userdata('show_unidad_codigo_interno') === TRUE)
				{
					$this->ofimatica->add_data( element('unidad_codigo_interno_field_desc', $row['Unidad']['Many_Unidad_Codigo_Interno']) );
				}
				if($this->session->userdata('show_cliente_codigo_interno') === TRUE)
				{
					$this->ofimatica->add_data( element('cliente_codigo_interno_field_desc', $row['Cliente']) );
				}
				
				/*
				reset($export_fields);
				
				while(list(,$field_name)=each($export_fields))
				{
					
					$this->ofimatica->add_data( element($field_name, $row) );
					//$this->ofimatica->add_data('holas');
					
				}
				*/
				
			}
		}
	
		$this->ofimatica->send_file('xls');
		//-------------------------[exporta la mostrada en la grilla a xls]
			
	}


	// validation fields
	private function _validar_filtros() {		
		//-------------------------[valida datos del buscador]
		/*
		// validation rules
		$this->form_validation->set_rules('tsi_field_fecha_servicio',$this->marvin->mysql_field_to_human('tsi_field_fecha_servicio'),
			'trim|my_form_date_reverse'
		);
		*/
		
		$this->form_validation->set_rules('fecha_alta_inicial',$this->marvin->mysql_field_to_human('fecha_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_alta_final',$this->marvin->mysql_field_to_human('fecha_alta_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_de_ingreso_inicial',$this->marvin->mysql_field_to_human('fecha_de_ingreso_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_de_ingreso_final',$this->marvin->mysql_field_to_human('fecha_de_ingreso_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_de_egreso_inicial',$this->marvin->mysql_field_to_human('fecha_de_egreso_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_de_egreso_final',$this->marvin->mysql_field_to_human('fecha_de_egreso_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_entrega_inicial',$this->marvin->mysql_field_to_human('fecha_entrega_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_entrega_final',$this->marvin->mysql_field_to_human('fecha_entrega_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_rotura_inicial',$this->marvin->mysql_field_to_human('fecha_rotura_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_rotura_final',$this->marvin->mysql_field_to_human('fecha_rotura_final'),
			'trim|my_form_date_reverse'
		);
		
		
		//---['unidad']
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_motor',$this->marvin->mysql_field_to_human('unidad_field_motor'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_codigo_de_radio',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_radio'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_patente',$this->marvin->mysql_field_to_human('unidad_field_patente'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_oblea',$this->marvin->mysql_field_to_human('unidad_field_oblea'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_material_sap',$this->marvin->mysql_field_to_human('unidad_field_material_sap'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_descripcion_sap',$this->marvin->mysql_field_to_human('unidad_field_descripcion_sap'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_certificado',$this->marvin->mysql_field_to_human('unidad_field_certificado'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_formulario_12',$this->marvin->mysql_field_to_human('unidad_field_formulario_12'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_formulario_01',$this->marvin->mysql_field_to_human('unidad_field_formulario_01'),
			'trim'
		);
		
		//---['unidad']
		
		$this->form_validation->set_rules('cliente',$this->marvin->mysql_field_to_human('cliente'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_field_numero_documento',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_codigo_interno_id[]',$this->marvin->mysql_field_to_human('unidad_codigo_interno_id'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_codigo_interno_id[]',$this->marvin->mysql_field_to_human('unidad_codigo_interno_id'),
			'trim'
		);
		$this->form_validation->set_rules('tsi_motivo_reparacion_id[]',$this->marvin->mysql_field_to_human('tsi_motivo_reparacion_id'),
			'trim'
		);
		$this->form_validation->set_rules('tsi_estado_id[]',$this->marvin->mysql_field_to_human('tsi_estado_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_modelo_id[]',$this->marvin->mysql_field_to_human('auto_modelo_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_version_id[]',$this->marvin->mysql_field_to_human('auto_version_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_transmision_id[]',$this->marvin->mysql_field_to_human('auto_transmision_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_anio_id[]',$this->marvin->mysql_field_to_human('auto_anio_id'),
			'trim'
		);
		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_conformidad_id[]',$this->marvin->mysql_field_to_human('cliente_conformidad_id'),
			'trim'
		);
		$this->form_validation->set_rules('tsi_tipo_servicio_id[]',$this->marvin->mysql_field_to_human('tsi_tipo_servicio_id'),
			'trim'
		);
		$this->form_validation->set_rules('tsi_tipo_mantenimiento_id[]',$this->marvin->mysql_field_to_human('tsi_tipo_mantenimiento_id'),
			'trim'
		);
		$this->form_validation->set_rules('tsi_promocion_id[]',$this->marvin->mysql_field_to_human('tsi_promocion_id'),
			'trim'
		);
		
		
		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{
		//-------------------------[vista generica]

		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]
		
		//------------ [select / checkbox / radio unidad_codigo_interno_id] :(
		$unidad_codigo_interno=new Unidad_Codigo_Interno();
		$q = $unidad_codigo_interno->get_all();
		$config=array();
		$config['fields'] = array('unidad_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['unidad_codigo_interno_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_codigo_interno_id]
		
		//------------ [select / checkbox / radio unidad_codigo_interno_id] :(
		$tsi_estado=new Tsi_Estado();
		$q = $tsi_estado->get_all();
		$config=array();
		$config['fields'] = array('tsi_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['tsi_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_codigo_interno_id]
		
		//------------ [select / checkbox / radio cliente_conformidad_id] :(
		$cliente_conformidad=new Cliente_Conformidad();
		$q = $cliente_conformidad->get_all();
		$config=array();
		$config['fields'] = array('cliente_conformidad_field_desc');
		$config['select'] = FALSE;
		$this->template['cliente_conformidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_conformidad_id]
		
		//------------ [select / checkbox / radio cliente_codigo_interno_id] :(
		$cliente_codigo_interno=new Cliente_Codigo_Interno();
		$q = $cliente_codigo_interno->get_all();
		$config=array();
		$config['fields'] = array('cliente_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['cliente_codigo_interno_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_codigo_interno_id]
		
		
		//------------ [select / checkbox / radio tsi_tipo_servicio_id] :(
		$tsi_tipo_servicio=new Tsi_Tipo_Servicio();
		$q = $tsi_tipo_servicio->get_all();
		//-------[PARCHE]
		if($this->session->userdata('show_tsi_tih')!=TRUE)
		{
			//ocultamos servicios tih
			$q->AddWhere("id != ?",9);
		}
		//-------[PARCHE]
		$config=array();
		$config['fields'] = array('tsi_tipo_servicio_field_desc');
		$config['select'] = FALSE;
		$this->template['tsi_tipo_servicio_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tsi_tipo_servicio_id]
		
		//------------ [select / checkbox / radio tsi_tipo_servicio_id] :(
		$tsi_tipo_mantenimiento=new Tsi_Tipo_Mantenimiento();
		$q = $tsi_tipo_mantenimiento->get_all();
		
		$config=array();
		$config['fields'] = array('tsi_tipo_mantenimiento_field_desc');
		$config['select'] = FALSE;
		$this->template['tsi_tipo_mantenimiento_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tsi_tipo_servicio_id]
		
		//------------ [select / checkbox / radio tsi_motivo_principal_de_reparacion_id] :(
		$tsi_motivo_reparacion=new Tsi_Motivo_Reparacion();
		$q = $tsi_motivo_reparacion->get_all();
		$config=array();
		$config['fields'] = array('tsi_motivo_reparacion_field_desc');
		$config['select'] = FALSE;
		$this->template['tsi_motivo_reparacion_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tsi_motivo_principal_de_reparacion_id]
		
		
		
		
		
		//------------ [select / checkbox / radio auto_modelo_id] :(
		$auto_modelo=new Auto_Modelo();
		$q = $auto_modelo->get_all();
		$q->addWhere(' auto_marca_id = ? ', 100); //honda
		$q->orderBy('auto_modelo_field_desc');
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_modelo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_modelo_id]
		
		//------------ [select / checkbox / radio auto_version_id] :(
		$auto_version=new Auto_Version();
		$q = $auto_version->get_all();
		$q->addWhere('auto_marca_id = ?',100);
		$q->orderBy('auto_modelo_field_desc');
		$q->addOrderBy('auto_version_field_desc');
		$q->whereIn('auto_modelo_id',$this->input->post('auto_modelo_id'));
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc','auto_version_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_version_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_version_id]
		
		//------------ [select / checkbox / radio auto_transmision_id] :(
		$auto_transmision=new Auto_Transmision();
		$q = $auto_transmision->get_all();
		$config=array();
		$config['fields'] = array('auto_transmision_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_transmision_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_transmision_id]
		
		//------------ [select / checkbox / radio auto_anio_id] :(
		$auto_anio=new Auto_Anio();
		$q = $auto_anio->get_all();
		$q->leftJoin('Auto_Anio.Unidad');
		$q->addWhere('auto_anio_id !=' , FALSE);
		$q->groupBy('id');
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_anio_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_anio_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_anio_id]
		
		//------------ [select / checkbox / radio auto_transmision_id] :(
		$obj=new Tsi_Promocion();
		$q = $obj->get_all();
		$q->orderBy('tsi_promocion_fiel_desc ASC');
		$config=array();
		$config['fields'] = array('tsi_promocion_field_desc');
		$config['select'] = FALSE;
		$this->template['tsi_promocion_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_transmision_id]
		
		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}
	
	//la llaman los _main
	public function _create_query()
	{
		
		parent::_create_query();
		return;
		
		
		if($this->router->method != 'export')
		{
			parent::_create_query();
		}	
		else
		{
			//deja la query lista para usar en $this->query
			$objeto = new $this->model();
			$this->query = $objeto->get_export();
			$this->query->expireQueryCache(TRUE);
			$this->query->expireResultCache(TRUE); //borra la cache
			if($this->sucursal){
				$this->query->whereIn('sucursal_id',$this->session->userdata('sucursales'));
			}
			$this->flexigrid->validate_post();
			$this->flexigrid->build_query();
		}
		
	}

}
