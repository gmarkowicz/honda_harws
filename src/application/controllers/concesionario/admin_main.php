<?php
define('ID_SECCION',1011);

class Admin_main extends Backend_Controller {
	//filtra por sucursal?
	var $sucursal = FALSE;
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(

		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array('MATCH( 
												admin_field_usuario,
												admin_field_nombre,
												admin_field_apellido,
												admin_field_email
										) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para filtrar
		
		'admin_field_usuario'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'admin_field_nombre'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'admin_field_apellido'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'admin_field_email'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'admin_field_telefono_celular'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'admin_field_dni'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'admin_field_direccion'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'admin_field_idioma'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'admin_field_estudios'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'provincia_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'ciudad_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		
		'fecha_ingreso_inicial'=>
			array(
				 'sql_filter'	=>array('admin_field_fecha_ingreso >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_ingreso_final'=>
			array(
				 'sql_filter'	=>array('admin_field_fecha_ingreso <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'admin_field_fecha_ingreso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		'fecha_egreso_inicial'=>
			array(
				 'sql_filter'	=>array('admin_field_fecha_egreso >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_ingreso_egreso'=>
			array(
				 'sql_filter'	=>array('admin_field_fecha_egreso <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'admin_field_fecha_egreso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		//
		'fecha_nacimiento_inicial'=>
			array(
				 'sql_filter'	=>array('admin_field_fecha_nacimiento >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_nacimiento_final'=>
			array(
				 'sql_filter'	=>array('admin_field_fecha_nacimiento <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'admin_field_fecha_nacimiento'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'grupo_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'grupo_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'admin_departamento_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'admin_departamento_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'admin_puesto_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'admin_puesto_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
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

		'admin_estado_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'admin_estado_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		);
			
			
	function Admin_main()
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
		
		}
		
		//Print please
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
		$this->ofimatica->add_header( $this->marvin->mysql_field_to_human('id'),50 );
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
				$this->ofimatica->add_data( $row['id'] );
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
		
		$this->form_validation->set_rules('fecha_ingreso_inicial',$this->marvin->mysql_field_to_human('fecha_ingreso_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_ingreso_final',$this->marvin->mysql_field_to_human('fecha_ingreso_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_egreso_inicial',$this->marvin->mysql_field_to_human('fecha_egreso_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_egreso_final',$this->marvin->mysql_field_to_human('fecha_ingreso_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_nacimiento_inicial',$this->marvin->mysql_field_to_human('fecha_nacimiento_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_nacimiento_final',$this->marvin->mysql_field_to_human('fecha_nacimiento_final'),
			'trim|my_form_date_reverse'
		);
		
		$this->form_validation->set_rules('admin_field_usuario',$this->marvin->mysql_field_to_human('admin_field_usuario'),
			'trim'
		);
		$this->form_validation->set_rules('admin_field_password',$this->marvin->mysql_field_to_human('admin_field_password'),
			'trim'
		);
		$this->form_validation->set_rules('admin_field_nombre',$this->marvin->mysql_field_to_human('admin_field_nombre'),
			'trim'
		);
		$this->form_validation->set_rules('admin_field_apellido',$this->marvin->mysql_field_to_human('admin_field_apellido'),
			'trim'
		);
		$this->form_validation->set_rules('admin_field_email',$this->marvin->mysql_field_to_human('admin_field_email'),
			'trim'
		);
		$this->form_validation->set_rules('admin_field_telefono_celular',$this->marvin->mysql_field_to_human('admin_field_telefono_celular'),
			'trim'
		);
		$this->form_validation->set_rules('admin_field_dni',$this->marvin->mysql_field_to_human('admin_field_dni'),
			'trim'
		);
		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		$this->form_validation->set_rules('admin_puesto_id[]',$this->marvin->mysql_field_to_human('admin_puesto_id'),
			'trim'
		);
		$this->form_validation->set_rules('admin_departamento_id[]',$this->marvin->mysql_field_to_human('admin_departamento_id'),
			'trim'
		);
		$this->form_validation->set_rules('grupo_id[]',$this->marvin->mysql_field_to_human('grupo_id'),
			'trim'
		);
		$this->form_validation->set_rules('admin_estado_id[]',$this->marvin->mysql_field_to_human('admin_estado_id'),
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
		$sucursal=new sucursal();
		$q = $sucursal->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]
		
		//------------ [select / checkbox / radio admin_departamento_id] :(
		$departamento=new Admin_Departamento();
		$q = $departamento->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('admin_departamento_field_desc');
		$config['select'] = FALSE;
		$this->template['admin_departamento_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio admin_departamento_id]
		
		//------------ [select / checkbox / radio admin_puesto_id] :(
		$puesto=new Admin_Puesto();
		$q = $puesto->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('admin_puesto_field_desc');
		$config['select'] = FALSE;
		$this->template['admin_puesto_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio admin_departamento_id]
		
		//------------ [select / checkbox / radio grupo_id] :(
		$grupo=new Grupo();
		$q = $grupo->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('grupo_field_desc');
		$config['select'] = FALSE;
		$this->template['grupo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio grupo_id]

		//------------ [select / checkbox / radio admin_estado_id] :(
		$admin_estado=new Admin_Estado();
		$q = $admin_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('admin_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['admin_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio admin_estado_id]

		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
