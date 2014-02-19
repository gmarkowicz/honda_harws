<?php
define('ID_SECCION',5031);

class Trafico_Pilot_Legend_Main extends Backend_Controller {
		
	//filtra por sucursal?
	var $sucursal = TRUE;
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
	
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(
										
										'MATCH( 
												trafico_pilot_legend_field_vendedor_nombre,
												trafico_pilot_legend_field_nombre,
												trafico_pilot_legend_field_apellido,
												trafico_pilot_legend_field_razon_social
										) against (? IN BOOLEAN MODE)'
										
										), //definir campos a buscar
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>FALSE,
				 
			),
		//solo para filtrar
	
	

		'trafico_pilot_legend_field_fecha'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		'trafico_pilot_legend_field_fecha_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(trafico_pilot_legend_field_fecha) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'trafico_pilot_legend_field_fecha_final'=>
			array(
				 'sql_filter'	=>array('DATE(trafico_pilot_legend_field_fecha) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		

		'trafico_pilot_legend_field_vendedor_nombre'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'trafico_pilot_legend_field_nombre'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'trafico_pilot_legend_field_apellido'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'trafico_pilot_legend_field_razon_social'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'trafico_pilot_legend_field_telefono_contacto_codigo'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'trafico_pilot_legend_field_telefono_contacto_numero'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'trafico_pilot_legend_field_email'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'auto_modelo_interes_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'auto_modelo_interes_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),

		'auto_modelo_actual_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'auto_modelo_actual_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),

		'sucursal_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'sucursal_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),

		'backend_estado_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'backend_estado_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),

		'trafico_pilot_legend_field_fechahora_alta'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		'trafico_pilot_legend_field_fechahora_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(trafico_pilot_legend_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'trafico_pilot_legend_field_fechahora_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(trafico_pilot_legend_field_fechahora_alta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		

/*		
		//para descargar
		'trafico_pilot_legend_adjunto'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'		=>TRUE,
				 'rules'		=>FALSE,
				 
			),
		
*/

		);
			
			
	function Trafico_Pilot_Legend_Main()
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
			if(isset($row['Auto_Modelo_Actual']))
			{
				$row['auto_modelo_actual_field_desc'] =  $row['Auto_Modelo_Actual']['Auto_Marca']['auto_marca_field_desc'] . ' ' . $row['Auto_Modelo_Actual']['auto_modelo_field_desc'];
			}
			if(isset($row['Auto_Modelo_Interes']))
			{
				$row['auto_modelo_interes_field_desc'] =   $row['Auto_Modelo_Interes']['auto_modelo_field_desc'];
			}
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
	
		//$this->output->enable_profiler();
		
		$this->load->library('ofimatica');
		$config['campos']	=	$this->default_valid_fields;
		
		
		
		$this->ofimatica->make_file();
		
		//----seteo campos a exportar para aliviar el while
		$export_fields = array();
		reset($config['campos']);
		while (list($field_name,$val) = each ($config['campos']))
		{
			if(isset($val['export']) && $val['export'] === TRUE)
			{
				$export_fields[] = $field_name;
			}		
		}
		//----seteo campos a exportar para aliviar el while
		
		
	
		
		
		//creo el header
		reset($export_fields);
		$this->ofimatica->add_row();
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
				reset($export_fields);
				while(list(,$field_name)=each($export_fields))
				{
					if(isset($row['Auto_Modelo_Interes']))
					{
						$row['auto_modelo_interes_field_desc'] =   $row['Auto_Modelo_Interes']['auto_modelo_field_desc'];
					}
					if(isset($row['Auto_Modelo_Actual']))
					{
						$row['auto_modelo_actual_field_desc'] =  $row['Auto_Modelo_Actual']['Auto_Marca']['auto_marca_field_desc'] . ' ' . $row['Auto_Modelo_Actual']['auto_modelo_field_desc'];
					}
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
		
		$this->form_validation->set_rules('_buscador_general',$this->marvin->mysql_field_to_human('_buscador_general'),
			'trim'
		);
		
		$this->form_validation->set_rules('trafico_pilot_legend_field_fecha_inicial',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_fecha_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_fecha_final',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_fecha_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_fecha',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_fecha'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_vendedor_nombre',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_vendedor_nombre'),
			'trim'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_nombre',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_nombre'),
			'trim'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_apellido',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_apellido'),
			'trim'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_razon_social',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_razon_social'),
			'trim'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_telefono_contacto_codigo',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_telefono_contacto_codigo'),
			'trim'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_telefono_contacto_numero',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_telefono_contacto_numero'),
			'trim'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_email',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_email'),
			'trim'
		);
		$this->form_validation->set_rules('auto_modelo_interes_id[]',$this->marvin->mysql_field_to_human('auto_modelo_interes_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_modelo_actual_id[]',$this->marvin->mysql_field_to_human('auto_modelo_actual_id'),
			'trim'
		);
		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		$this->form_validation->set_rules('backend_estado_id[]',$this->marvin->mysql_field_to_human('backend_estado_id'),
			'trim'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_fechahora_alta_inicial',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_fechahora_alta_final',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_fechahora_alta_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('trafico_pilot_legend_field_fechahora_alta',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_fechahora_alta'),
			'trim|my_form_date_reverse'
		);
		
		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{
		//-------------------------[vista generica]
		//$this->output->enable_profiler();

		//------------ [select / checkbox / radio auto_modelo_interes_id] :(
		$auto_modelo_interes=new Auto_Modelo();
		
		$q = $auto_modelo_interes->get_all();
		$q->whereIn('id',array(520,525));
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_modelo_interes_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_modelo_interes_id]

		//------------ [select / checkbox / radio auto_modelo_actual_id] :(
		$auto_modelo_actual=new Auto_Modelo();
		$q = $auto_modelo_actual->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_marca_field_desc','auto_modelo_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_modelo_actual_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_modelo_actual_id]

		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]

		//------------ [select / checkbox / radio backend_estado_id] :(
		$backend_estado=new Backend_Estado();
		$q = $backend_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('backend_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['backend_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio backend_estado_id]

		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
