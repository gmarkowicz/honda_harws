<?php
define('ID_SECCION',1081);

class Cliente_Sucursal_Main extends Backend_Controller {

	//filtra por sucursal?
	var $sucursal = TRUE;
	var $dias_default = 250;

	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(

		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(

										'MATCH(
												cliente_sucursal_field_nombre, cliente_sucursal_field_apellido, cliente_sucursal_field_email,cliente_field_numero_documento
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

		//solo para reporte
		'id'=>
			array(
				 'sql_filter'	=>false,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>true

			),
		'cliente_id'=>
			array(
				 'sql_filter'	=>false,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>true

			),
		'fecha_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(cliente_sucursal_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE

			),


		//solo para reporte
		'fecha_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(cliente_sucursal_field_fechahora_alta) <= ?'),
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
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),

		'cliente_sucursal_field_apellido'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),

		'cliente_sucursal_field_razon_social'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),

		'documento_tipo_id'=>
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
		'documento_tipo_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),


		'cliente_field_numero_documento'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>120,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),


		'cliente_sucursal_field_email'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),
		'cliente_sucursal_field_fecha_nacimiento'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),

		'cliente_conformidad_id'=>
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
		'cliente_conformidad_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'sexo_id'=>
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
		'sexo_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'tratamiento_id'=>
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
		'tratamiento_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_codigo_interno_id'=>
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
		/*'cliente_codigo_interno_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		*/
		//solo para busqueda
		'cliente_sucursal_field_direccion'=>
			array(
				 'sql_filter'	=>array('MATCH( cliente_sucursal_field_direccion_calle,cliente_sucursal_field_direccion_piso, cliente_sucursal_field_direccion_depto ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),

		'cliente_sucursal_field_direccion_calle'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_direccion_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_direccion_piso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_direccion_depto'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),

		'cliente_sucursal_field_direccion_codigo_postal'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',

			),
		'provincia_id'=>
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
		'provincia_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'ciudad_id'=>
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
		'ciudad_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_localidad_aux'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),




		//solo para busqueda
		'cliente_sucursal_field_telefono_particular'=>
			array(
				 'sql_filter'	=>array('MATCH( cliente_sucursal_field_telefono_particular_codigo,cliente_sucursal_field_telefono_particular_numero) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_telefono_particular_codigo'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_telefono_particular_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		//solo para busqueda
		'cliente_sucursal_field_telefono_laboral'=>
			array(
				 'sql_filter'	=>array('MATCH( cliente_sucursal_field_telefono_laboral_codigo,cliente_sucursal_field_telefono_laboral_numero) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_telefono_laboral_codigo'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_telefono_laboral_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		//solo para busqueda
		'cliente_sucursal_field_telefono_movil'=>
			array(
				 'sql_filter'	=>array('MATCH( cliente_sucursal_field_telefono_movil_codigo,cliente_sucursal_field_telefono_movil_numero) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_telefono_movil_codigo'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
			),
		'cliente_sucursal_field_telefono_movil_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
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
				 'width'		=>200,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',

			),

		'cliente_id'=>
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


/*
		//para descargar
		'cliente_sucursal_adjunto'=>
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


	function Cliente_Sucursal_Main()
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
		//-------[PARCHE]
		//si no envio data desde el reporte mostramos los primeros x registros
		if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
		{
			$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
			$desde_fecha = date('Y-m-d', $dia); //Formatea dia
			/*
			 * No se para que se aplica este filtro.
			 */
			//$this->query->AddWhere("CS.cliente_sucursal_field_fechahora_alta>=?",$desde_fecha);
		}
		//------[PARCHE]

		//$this->query->addWhere('id = ?',222222222222222222222222);
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

		$cantidad_querys = ceil($total/$registros_por_query);



		//$cantidad_querys=1;
		for($pagina=0;$pagina<$cantidad_querys;$pagina++)
		{
			//el hydrate, tuve que separar las querys parece que no queda otra amigo
			$this->_create_query();
			//-------[PARCHE]
			//si no envio data desde el reporte mostramos los primeros x registros
			if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
			{
				$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
				$desde_fecha = date('Y-m-d', $dia); //Formatea dia
				$this->query->AddWhere("CS.cliente_sucursal_field_fechahora_alta>=?",$desde_fecha);
			}
			//------[PARCHE]
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
		$this->form_validation->set_rules('fecha_alta_inicial',$this->marvin->mysql_field_to_human('fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_alta_final',$this->marvin->mysql_field_to_human('fechahora_alta_final'),
			'trim|my_form_date_reverse'
		);

		$this->form_validation->set_rules('cliente_sucursal_field_nombre',$this->marvin->mysql_field_to_human('cliente_sucursal_field_nombre'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_sucursal_field_apellido',$this->marvin->mysql_field_to_human('cliente_sucursal_field_apellido'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_sucursal_field_razon_social',$this->marvin->mysql_field_to_human('cliente_sucursal_field_razon_social'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_sucursal_field_email',$this->marvin->mysql_field_to_human('cliente_sucursal_field_email'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_field_numero_documento',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_sucursal_field_direccion',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_sucursal_field_direccion_codigo_postal',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_codigo_postal'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_sucursal_field_telefono_particular',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_particular'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_sucursal_field_telefono_laboral',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_laboral'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_sucursal_field_telefono_movil',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_movil'),
			'trim'
		);
		$this->form_validation->set_rules('sexo_id[]',$this->marvin->mysql_field_to_human('sexo_id'),
			'trim'
		);
		$this->form_validation->set_rules('tratamiento_id[]',$this->marvin->mysql_field_to_human('tratamiento_id'),
			'trim'
		);
		$this->form_validation->set_rules('documento_tipo_id[]',$this->marvin->mysql_field_to_human('documento_tipo_id'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_conformidad_id[]',$this->marvin->mysql_field_to_human('cliente_conformidad_id'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_codigo_interno_id[]',$this->marvin->mysql_field_to_human('cliente_codigo_interno_id'),
			'trim'
		);

		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		$this->form_validation->set_rules('provincia_id[]',$this->marvin->mysql_field_to_human('provincia_id'),
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
		$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]

		//------------ [select / checkbox / radio sexo_id] :(
		$sexo=new Sexo();
		$q = $sexo->get_all();
		$config=array();
		$config['fields'] = array('sexo_field_desc');
		$config['select'] = FALSE;
		$this->template['sexo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sexo_id]

		//------------ [select / checkbox / radio tratamiento_id] :(
		$obj=new Tratamiento();
		$q = $obj->get_all();
		$config=array();
		$config['fields'] = array('tratamiento_field_desc');
		$config['select'] = FALSE;
		$this->template['tratamiento_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tratamiento_id]

		//------------ [select / checkbox / radio provincia_id] :(
		$obj=new Provincia();
		$q = $obj->get_all();
		$config=array();
		$config['fields'] = array('provincia_field_desc');
		$config['select'] = FALSE;
		$this->template['provincia_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio provincia_id]

		//------------ [select / checkbox / radio documento_tipo_id] :(
		$obj=new Documento_Tipo();
		$q = $obj->get_all();
		$config=array();
		$config['fields'] = array('documento_tipo_field_desc');
		$config['select'] = FALSE;
		$this->template['documento_tipo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio documento_tipo_id]

		//------------ [select / checkbox / radio cliente_conformidad_id] :(
		$obj=new Cliente_Conformidad();
		$q = $obj->get_all();
		$config=array();
		$config['fields'] = array('cliente_conformidad_field_desc');
		$config['select'] = FALSE;
		$this->template['cliente_conformidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_conformidad_id]

		//------------ [select / checkbox / radio cliente_codigo_interno_id] :(
		$obj=new Cliente_Codigo_Interno();
		$q = $obj->get_all();
		$config=array();
		$config['fields'] = array('cliente_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['cliente_codigo_interno_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_codigo_interno_id]

		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
