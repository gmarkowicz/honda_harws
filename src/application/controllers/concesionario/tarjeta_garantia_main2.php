<?php
define('ID_SECCION',3012);

class Tarjeta_Garantia_main extends Backend_Controller {
	//variables que se le pasan al template
	var $template = array();
		
	//filtra por sucursal?
	var $sucursal = TRUE;
		
	//modelo doctrine con el cual laburamos
	var $model = 'Tarjeta_Garantia';
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
		
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array('MATCH( 
												unidad_field_unidad,
												unidad_field_vin,
												cliente_field_numero_documento,
												cliente_sucursal_field_nombre,
												cliente_sucursal_field_nombre,
												cliente_sucursal_field_razon_social,
												cliente_sucursal_field_email,
												cliente_sucursal_field_direccion_calle,
												ciudad_field_desc,
												provincia_field_desc,
												cliente_sucursal_field_localidad_aux
										) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		//solo para reporte
		'fecha_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tarjeta_garantia_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		//solo para reporte
		'fecha_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(tarjeta_garantia_field_fechahora_alta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para reporte
		'fecha_venta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(unidad_field_fecha_venta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		//solo para reporte
		'fecha_venta_final'=>
			array(
				 'sql_filter'	=>array('DATE(unidad_field_fecha_venta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		//solo para reporte
		'auto_anio_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
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
		
		'tarjeta_garantia_field_fechahora_alta'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
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
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'documento_tipo_field_desc'=>
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
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_email'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'tarjeta_garantia_field_vendedor_nombre_aux'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		
		'tarjeta_garantia_field_fecha'=>
			array(
				 'sql_filter'	=>array('%THIS% >= ?'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'unidad_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'unidad_field_unidad'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_vin'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'unidad_field_motor'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
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

		'sucursal_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
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


		'tarjeta_garantia_estado_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'tarjeta_garantia_estado_field_desc'=>
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
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'auto_version_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		);

	//default order 
	var $default_sortname = 'id';
	//default order 
	var $default_sortorder = 'DESC';
	//query lista para execute(); 
	var $query = FALSE;
			
			
	function Tarjeta_Garantia_main()
	{
		parent::Backend_Controller();
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
		//-------------------------[escribe la grilla]
		$pager = new Doctrine_Pager(
				$this->query,
				$this->post_info['page'], //flexigrid genera este dato
				$this->post_info['rp']	//flexigrid genera este dato
		 );
			
		$this->output->set_header($this->config->item('json_header'));
			
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
			$record_items[] = $this->_create_grid_data($row,$config['campos']);
			unset($row);
		}
		
		//Print please
		//$this->output->enable_profiler();
		$this->output->set_output($this->flexigrid->json_build($pager->getNumResults(),$record_items));
		//-------------------------[/escribe la grilla]
	}
		
	
	//exporta registros a xls
	function export()
	{
		
		//nombre de las fields que exporta
		$config['campos']	=	$this->default_valid_fields;
		$config['registros_por_query'] = 10000;
		
		//pdf xls
		$this->load->library('ofimatica');
		
		//creo archivo base
		$this->ofimatica->make_file();
		
		//agrego fila
		$this->ofimatica->add_row();
		reset($config['campos']);
		while(list($field_name,$val)=each($config['campos'])){
			//nombre de los campos
			if(isset($val['export']) && $val['export'] === TRUE)
			{
				$this->ofimatica->add_header( $this->marvin->mysql_field_to_human($field_name),$val['width'] );
			}
		}
		
		
		$this->_create_query();
		$total = $this->query->count();
		#vamos a aprobechar la limitacion del xls para ahorrrar memoria
		if($total>65536)	$total=65536;
		$cantidad_querys=ceil($total/$config['registros_por_query']);
		//$cantidad_querys=1;
		for($pagina=0;$pagina<$cantidad_querys;$pagina++){
			//el hydrate, tuve que separar las querys
			
			$this->_create_query();
			$this->query->limit($config['registros_por_query']);
			$this->query->offset($pagina*$config['registros_por_query']);
			$result=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			foreach($result as $row)
			{
				$this->ofimatica->add_row();
				reset($config['campos']);
				while (list($field_name,$val) = each ($config['campos']))
				{
					if(isset($val['export']) && $val['export'] === TRUE)
					{
						$this->ofimatica->add_data( element($field_name, $row) );
					}
				}
				unset($row);
			}
			$this->query->free(true);
		}
		$this->ofimatica->send_file('xls');
		
		//-------------------------[exporta la mostrada en la grilla a xls]
			
	}


	// validation fields
	private function _validar_filtros() {		
		//-------------------------[valida datos del buscador]
		// validation rules
		$this->form_validation->set_rules('_buscador_general',$this->marvin->mysql_field_to_human('_buscador_general'),
			'trim'
		);
		
		$this->form_validation->set_rules('tarjeta_garantia_field_vendedor_nombre_aux',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_vendedor_nombre_aux'),
			'trim'
		);
		$this->form_validation->set_rules('fechahora_alta_inicial',$this->marvin->mysql_field_to_human('fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fechahora_alta_final',$this->marvin->mysql_field_to_human('fechahora_alta_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_venta_inicial',$this->marvin->mysql_field_to_human('fecha_venta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_venta_final',$this->marvin->mysql_field_to_human('fecha_venta_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_desde',$this->marvin->mysql_field_to_human('unidad_desde'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_hasta',$this->marvin->mysql_field_to_human('unidad_hasta'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_motor',$this->marvin->mysql_field_to_human('unidad_field_motor'),
			'trim'
		);
		$this->form_validation->set_rules('cliente',$this->marvin->mysql_field_to_human('cliente'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_field_numero_documento',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_conformidad_id[]',$this->marvin->mysql_field_to_human('cliente_conformidad_id'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_codigo_interno_id[]',$this->marvin->mysql_field_to_human('unidad_codigo_interno_id'),
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
		$this->form_validation->set_rules('tarjeta_garantia_field_fecha',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_fecha'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_id[]',$this->marvin->mysql_field_to_human('unidad_id'),
			'trim'
		);
		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		$this->form_validation->set_rules('tarjeta_garantia_field_admin_alta_id[]',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_admin_alta_id'),
			'trim'
		);
		$this->form_validation->set_rules('tarjeta_garantia_field_admin_modifica_id[]',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_admin_modifica_id'),
			'trim'
		);
		$this->form_validation->set_rules('tarjeta_garantia_estado_id[]',$this->marvin->mysql_field_to_human('tarjeta_garantia_estado_id'),
			'trim'
		);
		
		
		
		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{
		//-------------------------[vista generica]
		//$this->output->enable_profiler();
		
		
		
		
		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]
		
		
		//------------ [select / checkbox / radio tarjeta_garantia_field_admin_alta_id] :(
		$tarjeta_garantia_field_admin_alta=new Admin();
		$q = $tarjeta_garantia_field_admin_alta->get_all();
		$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tarjeta_garantia_field_admin_alta_field_desc');
		$config['select'] = FALSE;
		$this->template['tarjeta_garantia_field_admin_alta_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tarjeta_garantia_field_admin_alta_id]

		//------------ [select / checkbox / radio tarjeta_garantia_field_admin_modifica_id] :(
		$tarjeta_garantia_field_admin_modifica=new Admin();
		$q = $tarjeta_garantia_field_admin_modifica->get_all();
		$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tarjeta_garantia_field_admin_modifica_field_desc');
		$config['select'] = FALSE;
		$this->template['tarjeta_garantia_field_admin_modifica_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tarjeta_garantia_field_admin_modifica_id]

		//------------ [select / checkbox / radio tarjeta_garantia_estado_id] :(
		$tarjeta_garantia_estado=new Tarjeta_Garantia_Estado();
		$q = $tarjeta_garantia_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tarjeta_garantia_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['tarjeta_garantia_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tarjeta_garantia_estado_id]
		
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
		
		//------------ [select / checkbox / radio unidad_codigo_interno_id] :(
		$unidad_codigo_interno=new Unidad_Codigo_Interno();
		$q = $unidad_codigo_interno->get_all();
		$config=array();
		$config['fields'] = array('unidad_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['unidad_codigo_interno_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_codigo_interno_id]
		
		//------------ [select / checkbox / radio cliente_conformidad_id] :(
		$cliente_conformidad=new Cliente_Conformidad();
		$q = $cliente_conformidad->get_all();
		$config=array();
		$config['fields'] = array('cliente_conformidad_field_desc');
		$config['select'] = FALSE;
		$this->template['cliente_conformidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_conformidad_id]
		
		if($this->input->post('_buscador_general'))
		{
			$this->template['_buscador_general']=$this->input->post('_buscador_general');
		}
		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
