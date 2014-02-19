<?php
define('ID_SECCION',4015);

class Publicidad_Main extends Backend_Controller {

	//filtra por sucursal?
	var $sucursal = FALSE;

	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(

		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(

										'MATCH(
												publicidad_field_desc,
												publicidad_medida_field_desc,
												publicidad_ubicacion_field_desc,
												publicidad_medio_field_desc,
												publicidad_producto_field_desc
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
		'publicidad_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>240,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),

		'publicidad_field_fecha_publicacion'=>
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
		'publicidad_field_fecha_publicacion_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(publicidad_field_fecha_publicacion) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',

			),

		'publicidad_field_fecha_publicacion_final'=>
			array(
				 'sql_filter'	=>array('DATE(publicidad_field_fecha_publicacion) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',

			),


		'publicidad_medida_id'=>
			array(
				 'sql_filter'	=>false,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',

			),

		'publicidad_medida_field_desc'=>
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

		'publicidad_ubicacion_id'=>
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

		'publicidad_ubicacion_field_desc'=>
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

		'publicidad_medio_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',

			),

		'publicidad_medio_field_desc'=>
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

		'publicidad_producto_id'=>
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

		'publicidad_producto_field_desc'=>
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

/*
		//para descargar
		'publicidad_adjunto'=>
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


	function Publicidad_Main()
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

		$this->form_validation->set_rules('publicidad_field_desc',$this->marvin->mysql_field_to_human('publicidad_field_desc'),
			'trim'
		);
		$this->form_validation->set_rules('publicidad_field_fecha_publicacion_inicial',$this->marvin->mysql_field_to_human('publicidad_field_fecha_publicacion_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('publicidad_field_fecha_publicacion_final',$this->marvin->mysql_field_to_human('publicidad_field_fecha_publicacion_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('publicidad_field_fecha_publicacion',$this->marvin->mysql_field_to_human('publicidad_field_fecha_publicacion'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('publicidad_medida_id[]',$this->marvin->mysql_field_to_human('publicidad_medida_id'),
			'trim'
		);
		$this->form_validation->set_rules('publicidad_ubicacion_id[]',$this->marvin->mysql_field_to_human('publicidad_ubicacion_id'),
			'trim'
		);
		$this->form_validation->set_rules('publicidad_medio_id[]',$this->marvin->mysql_field_to_human('publicidad_medio_id'),
			'trim'
		);
		$this->form_validation->set_rules('publicidad_producto_id[]',$this->marvin->mysql_field_to_human('publicidad_producto_id'),
			'trim'
		);

		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{
		//-------------------------[vista generica]
		//$this->output->enable_profiler();

		//------------ [select / checkbox / radio publicidad_medida_id] :(
		$publicidad_medida=new Publicidad_Medida();
		$q = $publicidad_medida->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('publicidad_medida_field_desc');
		$config['select'] = FALSE;
		$this->template['publicidad_medida_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio publicidad_medida_id]

		//------------ [select / checkbox / radio publicidad_ubicacion_id] :(
		$publicidad_ubicacion=new Publicidad_Ubicacion();
		$q = $publicidad_ubicacion->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('publicidad_ubicacion_field_desc');
		$config['select'] = FALSE;
		$this->template['publicidad_ubicacion_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio publicidad_ubicacion_id]

		//------------ [select / checkbox / radio publicidad_medio_id] :(
		$publicidad_medio=new Publicidad_Medio();
		$q = $publicidad_medio->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('publicidad_medio_field_desc');
		$config['select'] = FALSE;
		$this->template['publicidad_medio_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio publicidad_medio_id]

		//------------ [select / checkbox / radio publicidad_producto_id] :(
		$publicidad_producto=new Publicidad_Producto();
		$q = $publicidad_producto->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('publicidad_producto_field_desc');
		$config['select'] = FALSE;
		$this->template['publicidad_producto_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio publicidad_producto_id]


		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
