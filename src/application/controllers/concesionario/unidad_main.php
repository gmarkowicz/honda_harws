<?php
define('ID_SECCION',1021);

class Unidad_Main extends Backend_Controller {
		
	//filtra por sucursal?
	var $sucursal = FALSE;
	
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(

		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array('MATCH( 
												unidad_field_unidad,
												unidad_field_vin,
												unidad_field_descripcion_sap
										) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para filtrar
		
		//---------------[solo para reporte]
		'unidad_field_fecha_facturacion_inicial'=>
			array(
				 'sql_filter'	=>array('unidad_field_fecha_facturacion >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_field_fecha_facturacion_final'=>
			array(
				 'sql_filter'	=>array('unidad_field_fecha_facturacion <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'unidad_field_fecha_venta_inicial'=>
			array(
				 'sql_filter'	=>array('unidad_field_fecha_venta >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_field_fecha_venta_final'=>
			array(
				 'sql_filter'	=>array('unidad_field_fecha_venta <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_field_fecha_entrega_inicial'=>
			array(
				 'sql_filter'	=>array('unidad_field_fecha_entrega >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_field_fecha_entrega_final'=>
			array(
				 'sql_filter'	=>array('unidad_field_fecha_entrega <= ?'),
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
		
		
		
		'unidad_field_unidad'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'unidad_field_vin'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>110,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'unidad_field_motor'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>80,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_field_patente'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_codigo_interno_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		
		
		'unidad_codigo_interno_field_desc'=>
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
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'unidad_field_codigo_de_radio'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		
		'unidad_field_oblea'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_field_fecha_entrega'=>
			array(
				 'sql_filter'	=>array('%THIS% = ? '),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_descripcion_sap'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_field_material_sap'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_field_certificado'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_field_formulario_12'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_field_formulario_01'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_color_exterior_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'unidad_color_exterior_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),

		'unidad_color_interior_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'unidad_color_interior_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		

		'vin_procedencia_ktype_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'vin_procedencia_ktype_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),

		'auto_fabrica_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'auto_fabrica_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),

		'auto_modelo_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		
		'auto_version_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'auto_modelo_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'auto_version_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'auto_puerta_cantidad_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'auto_puerta_cantidad_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),

		'auto_transmision_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'auto_transmision_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),

		'auto_anio_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'auto_anio_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_estado_garantia_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_estado_garantia_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_estado_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_estado_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		);		
			
	function Unidad_main()
	{
		parent::Backend_Controller();
		if($this->session->userdata('show_unidad_codigo_interno') != TRUE)
		{
			unset($this->default_valid_fields['unidad_codigo_interno_id']);
			unset($this->default_valid_fields['unidad_codigo_interno_field_desc']);
		}
	}


	function index()
	{	
		//-------------------------[buscador ]
		
		$config['campos'] = $this->default_valid_fields;
		
		//borramos en caso de que haya algun filtro previo
		$this->session->unset_userdata('filtro_'.$this->router->class);
				
		//->filtros del buscador por post
			if($this->input->post('_filtro'))
			{
				
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
		$total = $this->query->count();
		
		$this->query->limit($this->post_info['rp']);
		$this->query->offset(($this->post_info['page'] - 1)*$this->post_info['rp']);
		$this->query->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

		try {
			$resultado=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			//$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}
		$record_items = array();
		foreach ($resultado as $row)
		{
			$record_items[] = $this->_create_grid_data($row,$config['campos']);
		}
		
		//Print please
		//$this->output->enable_profiler();
		$this->output->set_header($this->config->item('json_header'));
		$this->output->set_output($this->flexigrid->json_build($total,$record_items));
		//-------------------------[/escribe la grilla]
	}
		
	
	//exporta registros a xls
	function export()
	{
		
		//pdf xls
	
		//$this->output->enable_profiler();
		$this->load->library('ofimatica');
		$config['campos']	=	$this->default_valid_fields;
		
		
		
		$this->ofimatica->make_file();
		
		//seteo campos a exportar
		$export_fields = array();
		reset($config['campos']);
		while (list($field_name,$val) = each ($config['campos']))
		{
			if(isset($val['export']) && $val['export'] === TRUE)
			{
				$export_fields[] = $field_name;
			}		
		}
		//seteo campos a exportar para aliviar el while
		
		
	
		
		
		//creo el header
		reset($export_fields);
		$this->ofimatica->add_row();
		$this->ofimatica->add_header( $this->marvin->mysql_field_to_human('id'), 50 );
		while(list(,$field_name)=each($export_fields))
		{
			$this->ofimatica->add_header( $this->marvin->mysql_field_to_human($field_name),$config['campos'][$field_name]['width'] );
		}
		//creo el header
		
		
		$this->_create_query(); //creo query
		$total = $this->query->count(); //cuento total
		
		$maximos_registos = $this->ofimatica->get_export_max_rows();
		
		$registros_por_query = $this->ofimatica->get_records_per_query();
		#vamos a aprobechar la limitacion del xls para ahorrrar memoria
		if($maximos_registos>0 && $total>$maximos_registos)	$total=$maximos_registos;	
		
		$cantidad_querys=ceil($total/$registros_por_query);
		
		
		
		//$cantidad_querys=1;
		for($pagina=0;$pagina<$cantidad_querys;$pagina++)
		{
			//el hydrate, tuve que separar las querys parece que no queda otra amigo
			$this->_create_query();
			$this->query->limit($registros_por_query);
			$this->query->offset($pagina*$registros_por_query);
			$this->query->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
			
			$result=$this->query->execute(array());
			$this->query->free();
			
			foreach($result as $row)
			{
				
				$this->ofimatica->add_row();
				$this->ofimatica->add_data( $row['id'] );
				reset($export_fields);
				while(list(,$field_name)=each($export_fields))
				{
					$this->ofimatica->add_data( element($field_name, $row) );
					//$this->ofimatica->add_data( 'asd' );
				}
				
			}
		}
		
		
		$this->ofimatica->send_file( );
		
		
		//-------------------------[exporta la mostrada en la grilla a xls]
			
	}


	// validation fields
	private function _validar_filtros() {		
		//-------------------------[valida datos del buscador]
		// validation rules
		
		$this->form_validation->set_rules('unidad_field_fecha_facturacion_inicial',$this->marvin->mysql_field_to_human('unidad_field_fecha_facturacion_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_fecha_facturacion_final',$this->marvin->mysql_field_to_human('unidad_field_fecha_facturacion_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_fecha_venta_inicial',$this->marvin->mysql_field_to_human('unidad_field_fecha_venta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_fecha_venta_final',$this->marvin->mysql_field_to_human('unidad_field_fecha_venta_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_fecha_entrega_inicial',$this->marvin->mysql_field_to_human('unidad_field_fecha_entrega_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_fecha_entrega_final',$this->marvin->mysql_field_to_human('unidad_field_fecha_entrega_final'),
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
		$this->form_validation->set_rules('unidad_color_exterior_id[]',$this->marvin->mysql_field_to_human('unidad_color_exterior_id'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_color_interior_id[]',$this->marvin->mysql_field_to_human('unidad_color_interior_id'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_estado_garantia_id[]',$this->marvin->mysql_field_to_human('unidad_estado_garantia_id'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_estado_id[]',$this->marvin->mysql_field_to_human('unidad_estado_id'),
			'trim'
		);
		$this->form_validation->set_rules('vin_procedencia_ktype_id[]',$this->marvin->mysql_field_to_human('vin_procedencia_ktype_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_fabrica_id[]',$this->marvin->mysql_field_to_human('auto_fabrica_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_version_id[]',$this->marvin->mysql_field_to_human('auto_version_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_modelo_id[]',$this->marvin->mysql_field_to_human('auto_modelo_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_puerta_cantidad_id[]',$this->marvin->mysql_field_to_human('auto_puerta_cantidad_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_transmision_id[]',$this->marvin->mysql_field_to_human('auto_transmision_id'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_codigo_interno_id[]',$this->marvin->mysql_field_to_human('unidad_codigo_interno_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_anio_id[]',$this->marvin->mysql_field_to_human('auto_anio_id'),
			'trim'
		);
		
		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{
		//-------------------------[vista generica]
		//$this->output->enable_profiler();

		//------------ [select / checkbox / radio sucursal] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales')); //solo las sucursales del admin
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / sucursal]
		
		//------------ [select / checkbox / radio unidad_estado] :(
		$unidad_estado=new Unidad_Estado();
		$q = $unidad_estado->get_all();
		$config=array();
		$config['fields'] = array('unidad_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['unidad_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / unidad_estado]
		
		//------------ [select / checkbox / radio unidad_estado] :(
		$unidad_estado_garantia=new Unidad_Estado_Garantia();
		$q = $unidad_estado_garantia->get_all();
		$config=array();
		$config['fields'] = array('unidad_estado_garantia_field_desc');
		$config['select'] = FALSE;
		$this->template['unidad_estado_garantia_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / unidad_estado]
		
		//------------ [select / checkbox / radio unidad_color_exterior_id] :(
		$unidad_color_exterior=new Unidad_Color_Exterior();
		$q = $unidad_color_exterior->get_all( TRUE );
		$q->groupBy('id');
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('unidad_color_exterior_field_desc');
		$config['select'] = FALSE;
		$this->template['unidad_color_exterior_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_color_exterior_id]

		//------------ [select / checkbox / radio unidad_color_interior_id] :(
		$unidad_color_interior=new Unidad_Color_Interior();
		$q = $unidad_color_interior->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('unidad_color_interior_field_desc');
		$config['select'] = FALSE;
		$this->template['unidad_color_interior_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_color_interior_id]

		//------------ [select / checkbox / radio vin_procedencia_id] :(
		$vin_procedencia_ktype=new Vin_Procedencia_Ktype();
		$q = $vin_procedencia_ktype->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('vin_procedencia_ktype_field_desc');
		$config['select'] = FALSE;
		$this->template['vin_procedencia_ktype_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio vin_procedencia_id]

		//------------ [select / checkbox / radio auto_fabrica_id] :(
		$auto_fabrica=new Auto_Fabrica();
		$q = $auto_fabrica->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_fabrica_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_fabrica_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_fabrica_id]
		
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
		
		//------------ [select / checkbox / radio auto_fabrica_id] :(
		$unidad_codigo_interno=new Unidad_Codigo_Interno();
		$q = $unidad_codigo_interno->get_all();
		$config=array();
		$config['fields'] = array('unidad_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['unidad_codigo_interno_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_fabrica_id]

		//------------ [select / checkbox / radio auto_puerta_cantidad_id] :(
		$auto_puerta_cantidad=new Auto_Puerta_Cantidad();
		$q = $auto_puerta_cantidad->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_puerta_cantidad_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_puerta_cantidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_puerta_cantidad_id]

		//------------ [select / checkbox / radio auto_transmision_id] :(
		$auto_transmision=new Auto_Transmision();
		$q = $auto_transmision->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
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

		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
