<?php
define('ID_SECCION',6012);

class Boutique_Pedido_Main extends Backend_Controller {

	//filtra por sucursal?
	var $sucursal = FALSE;

	//modelo doctrine con el cual laburamos
	var $model = 'Boutique_Pedido';

	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(

		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(

										'MATCH(
												boutique_pedido_observacion, admin_field_usuario
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



			//Columnas a mostrar en el grid


			'boutique_pedido_observacion'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>320,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[200]|print|',

			),

			'boutique_pedido_total'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'		=>70,
					'sorteable'	=>TRUE,
					'align'		=>'left',
					'export'		=>TRUE,
					'download'  	=>FALSE,
					'print'  		=>TRUE,
					'rules'		=>'grid|sorteable|export|print|align[left]|width[200]|print|',

			),

			'sucursal_field_desc'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'			=>130,
					'sorteable'		=>TRUE,
					'align'			=>'left',
					'export'		=>TRUE,
					'download'  	=>FALSE,
					'print'  		=>TRUE,
					'rules'			=>'grid|sorteable|export|print|align[left]|width[200]|print|',

			),

			'admin_field_usuario'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'			=>130,
					'sorteable'		=>TRUE,
					'align'			=>'left',
					'export'		=>TRUE,
					'download'  	=>FALSE,
					'print'  		=>TRUE,
					'rules'			=>'grid|sorteable|export|print|align[left]|width[200]|print|',

			),

			'boutique_pedido_estado_field_desc'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'			=>80,
					'sorteable'		=>TRUE,
					'align'			=>'left',
					'export'		=>TRUE,
					'download'  	=>FALSE,
					'print'  		=>TRUE,
					'rules'			=>'grid|sorteable|export|print|align[left]|width[200]|print|',

			),

			'created_at'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'		=>200,
					'sorteable'	=>TRUE,
					'align'		=>'left',
					'export'		=>TRUE,
					'download'  	=>FALSE,
					'print'  		=>TRUE,
					'rules'		=>'grid|sorteable|export|print|align[left]|width[200]|print|',

			),


		);


	function Boutique_Pedido_Main()
	{
		parent::Backend_Controller();
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
		//$this->ofimatica->add_row();
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
			$buttons=true;

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
		/**
                *  $type_user es para distinguie si el usuario es super_administrador, usuario del pedido o proovedor
                *
                *  $type_user => N  : Inicialmente es N (Ningun tipo de usuario)
                *  $type_user => A  : es (Super) Administrador (puede ver todos los listados)
                *  $type_user => U  : es el Usuario que realizo el pedido (puede ver todos sus pedidos)
                *  $type_user => P  : es proovedor de unos de sus producto (puede ver solo sus productos)
                *
                */
                $type_user = 'N';
                $total_proovedor = 0;

		$config['campos'] = $this->default_valid_fields;
		//agrego para que pueda filtrar por id
		$this->default_valid_fields['id']['sorteable'] = TRUE;

		$this->_create_query();

		if($this->session->userdata('admin_field_super_admin') === true)
		{
                    //filtros para super usuario
		}
		else
		{
			//filtros para los NO super usauario
			$this->query->addWhere('admin_id = ?', $this->session->userdata('admin_id'));
                        $this->query->orWhere('proovedor_id= ? ', $this->session->userdata('admin_id'));
			//$this->query->addWhere('sucursal_id = ' . $this->session->userdata('sucursal_id'));
		}



		$this->query->WhereIn(' admin_id = ' . $this->session->userdata('admin_id'));

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
                    $resultado=$pager->execute()->toArray();
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
                    $type_user = 'N';
                    if($this->session->userdata('admin_field_super_admin') === true)
                    {
                        $type_user = 'A'; //Es Super Administrador
                    }
                    elseif($row)
                    {
                        if($row['Admin']['id'] == $this->session->userdata('admin_id'))
                        {
                            $type_user = 'U'; //Es el usuario que realizo el pedido
                        }
                        else
                        {
                            foreach($row['Boutique_Pedido_Detalle'] as $pedido_proovedor)
                            {
                                if ($pedido_proovedor['proovedor_id'] == $this->session->userdata('admin_id'))
                                {
                                    $type_user = 'P'; //Es el proovedor de uno de los productos
                                    $total_proovedor += $pedido_proovedor['boutique_pedido_subtotal'];
                                }
                            }

                        }
                    }

                    if($type_user == 'A' || $type_user == 'U')
                    {
                        $row['boutique_pedido_total'] = $row['boutique_pedido_total'] . ' (' .$type_user . ')' ;
                        $record_items[] = $this->_create_grid_data($row,$config['campos']);
                    }
                    elseif($type_user == 'P')
                    {
                        $row['boutique_pedido_total'] = $total_proovedor . ' (' .$type_user . ')' ;
                        $record_items[] = $this->_create_grid_data($row,$config['campos']);
                    }
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

		$this->form_validation->set_rules('boutique_pedido_observacion',$this->marvin->mysql_field_to_human('boutique_pedido_observacion'),
			'trim'
		);

		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{

		//$this->output->enable_profiler();


		//------------ [select / checkbox / radio categoria_id] :(
		$estado_producto = new Boutique_Producto_Estado();
		$q = $estado_producto->get_all();
		$config=array();
		$config['fields'] = array('boutique_producto_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['boutique_producto_estado_id']=$this->_create_html_options($q, $config);


		//------------ [select / checkbox / radio categoria_id] :(
		$categoria_producto = new Boutique_Categoria();
		$q = $categoria_producto->get_all();
		$config=array();
		$config['fields'] = array('boutique_categoria_field_desc');
		$config['select'] = FALSE;
		$this->template['boutique_categoria_id']=$this->_create_html_options($q, $config);


		$url_abm = $this->config->item('base_url'). $this->config->item('backend_root') . str_replace('_main','_detalle_abm',strtolower($this->router->class));

		//------------ [fin select / checkbox / radio sucursal_id]
		$this->template['abm_url'] = $url_abm;
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//print_r ($this->template);

		//-------------------------[/vista generica]
	}

}
