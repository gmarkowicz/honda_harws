<?php
define('ID_SECCION',7021);

class Hma_Main extends Backend_Controller {

    //filtra por sucursal?
    var $sucursal = FALSE;

    //columnas por las que se puede ordenar la data //List of all fields that can be sortable
    var $default_valid_fields = array(

    //solo para filtrar
    '_buscador_general'=>
        array(
            'sql_filter'    => array('MATCH(hma_field_desc) AGAINST (? IN BOOLEAN MODE)'), //definir campos a buscar
            'grid'          => FALSE,
            'width'         => FALSE,
            'sorteable'     => FALSE,
            'align'         => FALSE,
            'export'        => FALSE,
            'download'      => FALSE,
            'print'         => FALSE,
            'rules'         => FALSE
        ),
    //solo para filtrar

    'hma_field_desc'=>
        array(
            'sql_filter'    => array('MATCH( %THIS% ) AGAINST (? IN BOOLEAN MODE)'),
            'grid'          => TRUE,
            'width'         => 700,
            'sorteable'     => TRUE,
            'align'         => 'left',
            'export'        => TRUE,
            'download'      => FALSE,
            'print'         => TRUE,
            'rules'         => 'grid|sorteable|export|print|align[left]|width[100]|print|'
        ),

            //para descargar
    'hma_adjunto'=>
        array(
            'sql_filter'    => FALSE,
            'grid'          => TRUE,
            'width'         => 100,
            'sorteable'     => FALSE,
            'align'         => 'left',
            'export'        => FALSE,
            'download'      => TRUE,
            'rules'         => FALSE
        ),
    );


    public function _create_grid_data_hma_zip($row,$campos,$params = array())
	{

		$this->load->helper('url');


		$config_archivos = $this->config->item('backend_files_config');


		$return = array($row['id'],
				$row['id'],
				$this->backend->_grid_links($row['id'],$params),
		);

		if(is_array($campos))
		{

			reset($campos);
			$data=array();
			while(list($field_name,$val) = each($campos))
			{
				if(isset($val['grid']) && $val['grid'] === TRUE )
				{

					//todo este lio para bajar
					if(isset($val['download']) && $val['download']===TRUE) //solo para descargar archivos
					{

						$folder = explode('_adjunto',$field_name);

						$link = $this->config->item('backend_uploads_root');
						$link.= $folder[0] . '/';
						$link.= 'adjunto' . $folder[1] . '/'; //ojo, el nombre de la tabla tiene que empezar con adjunto
						$link = urlencode($link);

						$archivos = explode('|',element($field_name . $config_archivos['archivo'], $row));
						$extensiones = explode('|',element($field_name . $config_archivos['extension'], $row));
						$return_link = '';


						$return_link.= anchor($this->config->item('base_url').$this->config->item('backend_root').'hma_main/zip?files=' . $row['id'] . '&amp;filename=' . $row['id'] . '.zip',
										lang('descargar_archivo'),
										array('title' => lang('descargar_archivo'),
											  'target' => '_blank')
							);

						$return[]= $return_link;

					}
					//todo este lio para bajar
					else
					{

						//$string = $this->marvin->string_to_utf(element($field_name, $row));
						$string = element($field_name, $row);
						if(stristr($field_name, '_fechahora') != FALSE)
						{
							$return[]= $this->marvin->mysql_datetime_to_form($string);
							//$return[]= $string;
						}
						else if(stristr($field_name, '_fecha') != FALSE)
						{
							$return[]= $this->marvin->mysql_date_to_form($string);
						}
						else
						{
							$return[]= $string;
						}

					}
				}

			}
		}

		RETURN $return;
	}


    function Hma_Main()
    {
        parent::Backend_Controller();
    }


    function index()
    {
        //-------------------------[buscador ]

        $config['campos'] = $this->default_valid_fields;

        //borramos en caso de que haya algun filtro previo
        $this->session->unset_userdata('filtro_'.$this->router->class);

        if($this->input->post('_filtro'))
        {
            if($this->_validar_filtros())
            {
                ////validamos los datos que envia...
                $filtro=$this->_create_filters($config['campos']);
                if(count($filtro)>0)
                {
                        //ya no se si me gusta el ajax
                        $this->session->set_userdata('filtro_'.$this->router->class,$filtro);
                }
            }
        }


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

        /**
        * Json build WITH json_encode. If you do not have this function please read
        * http://flexigrid.eyeviewdesign.com/index.php/flexigrid/example#s3 to know how to use the alternative
        */
        $record_items=array();

        //try {
            $resultado=$pager->execute()->toArray();
//        } catch (Doctrine_Connection_Exception $e) {
//            $error=array();
//            $error['line'] 		= __LINE__;
//            $error['file'] 		= __FILE__;
//            $error['error']		= $e->errorMessage();
//            $this->backend->_log_error($error);
//            show_error( $e->errorMessage());
//        }


        foreach ($resultado as $row)
        {
            $record_items[] = $this->_create_grid_data_hma_zip($row,$config['campos']);
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

        $this->form_validation->set_rules('_buscador_general',$this->marvin->mysql_field_to_human('_buscador_general'), 'trim');
        $this->form_validation->set_rules('hma_field_desc',$this->marvin->mysql_field_to_human('hma_field_desc'), 'trim');
        return $this->form_validation->run();
        //-------------------------[/valida datos del buscador]
    }

    private function _view()
    {
        $this->template['abm_url'] = $this->get_abm_url();
        $this->template['tpl_include'] = $this->get_template_view();
        $this->load->view('backend/esqueleto_view',$this->template);
    }

    public function zip()
    {

        $this->load->library('zip');

        if($this->backend->_permiso('view',ID_SECCION))
        {

            $archivo_adjunto = new Hma_Adjunto();
            $q = $archivo_adjunto->get_all();
            $q->WhereIn(' hma_id ', (int)$this->input->get('files'));

            $result = $q->execute()->toArray();

        	if (count($result)<1)
                {
                	die('No se encontr� el archivo especificado');
                }

            $folder = FCPATH.'public/uploads/hma/adjunto/';

            foreach ($result as $row)
            {
                $this->zip->read_file($folder . $row['hma_adjunto_field_archivo'] . '.' . $row['hma_adjunto_field_extension']);
            }

            //header( "Content-type: application/octet-stream; charset=iso-8859-1");
            $this->zip->download('Archivo_'. (int)$this->input->get('files') . '.zip');

        }
        else
        {
            die('No tiene permiso para descargar este archivo de HMA');
        }

    }
}
