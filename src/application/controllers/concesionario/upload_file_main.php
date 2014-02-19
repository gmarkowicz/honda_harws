<?php
define('ID_SECCION',7011);

class Upload_File_Main extends Backend_Controller {

	//filtra por sucursal?
	var $sucursal = FALSE;

	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(

		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(

										'MATCH(
												upload_file_field_desc
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



		'upload_file_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>700,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),

			//para descargar
			'upload_file_adjunto'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'			=>100,
					'sorteable'		=>FALSE,
					'align'			=>'left',
					'export'		=>FALSE,
					'download'		=>TRUE,
					'rules'			=>FALSE,

			),


		);


	function Upload_File_Main()
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

		$this->form_validation->set_rules('upload_file_field_desc',$this->marvin->mysql_field_to_human('upload_file_field_desc'),
			'trim'
		);
		/*$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim|my_valid_sucursal'
		);*/

		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{

		//-------------------------[vista generica]
		//$this->output->enable_profiler();

		//------------ [select / checkbox / radio sucursal_id] :(
		/*$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);*/
		//------------ [fin select / checkbox / radio sucursal_id]


		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//print_r ($this->template);

		//-------------------------[/vista generica]
	}

        public function zip()
		{

            $this->load->library('zip');

            if($this->backend->_permiso('view',ID_SECCION))
            {

                $archivo_adjunto = new Upload_File_Adjunto();
				$q = $archivo_adjunto->get_all();
				$q->WhereIn(' upload_file_id ', (int) $this->input->get('files'));

                $result = $q->execute()->toArray();

                if (count($result)<1)
                {
                	die('No se encontr� el archivo especificado');
                }

                $folder = FCPATH.'public/uploads/upload_file/adjunto/';

                foreach ($result as $row)
                {
                    $this->zip->read_file($folder . $row['upload_file_adjunto_field_archivo'] . '.' . $row['upload_file_adjunto_field_extension']);
                }

                $this->zip->download('Archivo_'. (int)$this->input->get('files') . '.zip');

            }
            else
            {
                die('No tiene permiso para descargar este archivo');
            }

		}

}
