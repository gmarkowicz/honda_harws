<?php
define('ID_SECCION',1024);

class Unidad_Color_Interior_main extends Backend_Controller {
		
	//filtra por sucursal?
	var $sucursal = FALSE;
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(

		'_buscador_general'=>
			array(
				'sql_filter'	=>array(
										
										'MATCH( 
												unidad_color_interior_field_desc
												
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
		
		
		'unidad_color_interior_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		);
			
			
	function Unidad_Color_Interior_main()
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
		$this->form_validation->set_rules('unidad_color_interior_field_desc',$this->marvin->mysql_field_to_human('unidad_color_interior_field_desc'),
			'trim'
		);
		
		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{
		//-------------------------[vista generica]
		//$this->output->enable_profiler();

		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
