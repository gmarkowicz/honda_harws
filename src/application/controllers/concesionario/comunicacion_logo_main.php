<?php
define('ID_SECCION',4041);

class Comunicacion_Logo_Main extends Backend_Controller {

	//filtra por sucursal?
	var $sucursal = FALSE;

	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(
										'MATCH(
												comunicacion_logo_field_desc
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

			'comunicacion_logo_field_desc'=>
			array(
					'sql_filter'	=>array(
										'MATCH(
												comunicacion_logo_field_desc
										) against (? IN BOOLEAN MODE)'
										), //definir campos a buscar
					'grid'			=>TRUE,
					'width'		=> 800,
					'sorteable'	=> TRUE,
					'align'		=>'left',
					'export'		=>TRUE,
					'download'		=>FALSE,
					'print'		=>TRUE,
					'rules'		=>'align[left]|width[100]|print|grid',

			),

		);


	function __construct()
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
		$this->query->WhereIn(' 1 = 1 ');

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
			//$error['sql'] 		= $e->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}


		foreach ($resultado as $row)
		{
			$record_items[] = $this->_create_grid_data_zip($row,$config['campos']);
		}

		//Print please
		$this->output->set_header($this->config->item('json_header'));
		$this->output->set_output($this->flexigrid->json_build($pager->getNumResults(),$record_items));
		//-------------------------[/escribe la grilla]
	}




	// validation fields
	private function _validar_filtros() {
		//-------------------------[valida datos del buscador]
		// validation rules

		$this->form_validation->set_rules('_buscador_general',$this->marvin->mysql_field_to_human('_buscador_general'),
			'trim'
		);

		$this->form_validation->set_rules('comunicacion_logo_field_desc',$this->marvin->mysql_field_to_human('comunicacion_logo_field_desc'),
			'trim'
		);

		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//print_r ($this->template);

		//-------------------------[/vista generica]
	}

}
