<?php
define('ID_SECCION',3052);
/*
esto esta bastante cabeza
*/
class Encuesta_Nos_Cumplimiento_Main extends Backend_Controller {
		
	//solo para aca
	var $tarjetas_garantia	= array();
	var $encuestas_nos		= array();
	
	//filtra por sucursal?
	var $sucursal = FALSE;
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
	
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array('MATCH( 
												sucursal_field_desc
										) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para filtrar
		
	
		'unidad_field_fecha_entrega_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(unidad_field_fecha_entrega) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'unidad_field_fecha_entrega_final'=>
			array(
				 'sql_filter'	=>array('DATE(unidad_field_fecha_entrega) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
			'sucursal_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>250,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
			'tarjeta_garantia_id'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>150,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
			'encuesta_nos_id'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>150,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
			'porcentaje'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>150,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
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



		);
			
			
	function Encuesta_Nos_Cumplimiento_Main()
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
		
			
			$config = $this->config->item('gridParams');
			$config['rp'] = 500;
			$config['rpOptions'] = 500;
			//Build js
			//View helpers/flexigrid_helper.php for more information about the params on this function
			$this->template['js_grid'] = build_grid_js
			(
					'flex1', //html name
					$this->get_grid_url(), //url a la que apunta
					$esqueleto_grid,
					$this->default_sortname, //default order
					$this->default_sortorder, //default order 
					$config,
					$buttons
			);
		//-------------------------[/configuracion de grilla ]
		
		$this->_view();
		
	}

	function grid()
	{
		
		$config['campos'] = $this->default_valid_fields;
		$this->flexigrid->validate_post();
		
		$q = $this->_q_sucursal();
		
		$total = $q->count();
		
		$sucursales=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		if($total>0)
		{
			
			$this->_create_q( );
			
		}
		
		foreach($sucursales as $row) {
			
			$record_items[] = array(
				'',
				'',
				'',
				$row['sucursal_field_desc'],
				$this->_buscar_tarjetas_de_garantia($row['id']),
				$this->_buscar_encuestas_nos($row['id']),
				$this->_crear_porcentaje($row['id']) . '%' );
		}
		
		
		
		//Print please
		$this->output->set_header($this->config->item('json_header'));
		$this->output->set_output($this->flexigrid->json_build($total,$record_items));
		//-------------------------[/escribe la grilla]
	}
		
		
	///exporta registros a xls
	function export()
	{
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
		
		
		$q = $this->_q_sucursal();
		
		$total = $q->count();
		
		$sucursales=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		if($total>0)
		{
			
			$this->_create_q( );
			
		}
		
		foreach($sucursales as $row) 
		{
			$this->ofimatica->add_row();
			$this->ofimatica->add_data( $row['sucursal_field_desc'] );
			$this->ofimatica->add_data( $this->_buscar_tarjetas_de_garantia($row['id']) );
			$this->ofimatica->add_data( $this->_buscar_encuestas_nos($row['id']) );
			$this->ofimatica->add_data( $this->_crear_porcentaje($row['id']) . '%' );
				
		}
		
		$this->ofimatica->send_file( );
	}
		
		
	
	//exporta registros a xls
	function exportOld()
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
		//filtro sucursal
		$this->query->WhereIn(' TARJETA_GARANTIA.sucursal_id ', $this->session->userdata('sucursales')); //solo las sucursales del admin
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
			//filtro sucursal
			$this->query->WhereIn(' TARJETA_GARANTIA.sucursal_id ', $this->session->userdata('sucursales')); //solo las sucursales del admin
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
		
		$this->form_validation->set_rules('_buscador_general','buscador_general',
			'trim'
		);
		
		$this->form_validation->set_rules('unidad_field_fecha_entrega_inicial',$this->marvin->mysql_field_to_human('unidad_field_fecha_entrega_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_fecha_entrega_final',$this->marvin->mysql_field_to_human('unidad_field_fecha_entrega_final'),
			'trim|my_form_date_reverse'
		);
		
		
		
		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		
	
		
		//---['unidad']
		
		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}

	private function _view()
	{
		//-------------------------[vista generica]
		//$this->output->enable_profiler();
		//------------ [select / checkbox / radio sucursal] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales')); //solo las sucursales del admin
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / sucursal]
		
		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}
	
	
	private function _create_q( )
	{
		$this->_tarjetas_garantia();
		$this->_encuestas_nos();
	}
	
	private function _tarjetas_garantia( )
	{
		$this->query = Doctrine_Query::create();
        $this->query->select('count(*) as cantidad, Tarjeta_Garantia.sucursal_id');
		$this->query->from('Tarjeta_Garantia');
		$this->query->leftJoin('Tarjeta_Garantia.Unidad Unidad ON Unidad.id = Tarjeta_Garantia.unidad_id ');
		$this->query->leftJoin('Tarjeta_Garantia.Sucursal Sucursal ON Tarjeta_Garantia.sucursal_id = Sucursal.id ');
		
        $this->query->WhereIn('Tarjeta_Garantia.sucursal_id ', $this->session->userdata('sucursales')); //solo las sucursales del admin
		$this->query->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id != ?',	9); //no esta rechazada
        $this->query->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id != ?',	3); //no esta esperando aprobacion
		$this->query->addWhere('Unidad.unidad_field_fecha_entrega = Tarjeta_Garantia.tarjeta_garantia_field_fecha_entrega');
		$this->query->groupBy('Tarjeta_Garantia.sucursal_id');
		if(is_array($this->session->userdata('filtro_'.$this->router->class))){
			$filtro=$this->session->userdata('filtro_'.$this->router->class);
			while(list(,$where) =each($filtro)){
				if(is_array($where[1]))
				{
					//$this->CI->query->addWhere($where[0],$where[1]);
					$this->query->whereIn('Tarjeta_Garantia.sucursal_id',$where[1]);
				}else{
					$this->query->addWhere($where[0],$where[1]);	
				}
				
			}
		}
		else
		{
			//$this->query->addWhere('DATE(unidad_field_fecha_entrega) >= ?',date('Y-m-1'));
			
		}
		
		
		
		$r = $this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		$this->tarjetas_garantia = array();
		foreach($r as $row)
		{
			$this->tarjetas_garantia[$row['sucursal_id']] = $row['cantidad'];
		}
	}
	
	private function _encuestas_nos( )
	{
		$this->query = Doctrine_Query::create();
        $this->query->select('count(*) as cantidad, Tarjeta_Garantia.sucursal_id, Encuesta_Nos.id');
		$this->query->from('Encuesta_Nos');
		$this->query->leftJoin('Encuesta_Nos.Tarjeta_Garantia Tarjeta_Garantia ON Tarjeta_Garantia.id = Encuesta_Nos.tarjeta_garantia_id ');
		$this->query->leftJoin('Tarjeta_Garantia.Unidad Unidad ON Unidad.id = Tarjeta_Garantia.unidad_id ');
		$this->query->leftJoin('Tarjeta_Garantia.Sucursal Sucursal ON Tarjeta_Garantia.sucursal_id = Sucursal.id ');
		$this->query->WhereIn('Tarjeta_Garantia.sucursal_id ', $this->session->userdata('sucursales')); //solo las sucursales del admin
		$this->query->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id != ?',	9); //no esta rechazada
        $this->query->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id != ?',	3); //no esta esperando aprobacion
		$this->query->groupBy('Tarjeta_Garantia.sucursal_id');
		if(is_array($this->session->userdata('filtro_'.$this->router->class))){
			$filtro=$this->session->userdata('filtro_'.$this->router->class);
			while(list(,$where) =each($filtro)){
				if(is_array($where[1]))
				{
					//$this->CI->query->addWhere($where[0],$where[1]);
					$this->query->whereIn('Tarjeta_Garantia.sucursal_id',$where[1]);
				}else {
					$this->query->addWhere($where[0],$where[1]);	
				}
				
			}
		}
		else
		{
			//$this->query->addWhere('DATE(unidad_field_fecha_entrega) >= ?',date('Y-m-1'));
			
		}
		
		$r = $this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		$this->encuestas_nos = array();
		foreach($r as $row)
		{
			$this->encuestas_nos[$row['Tarjeta_Garantia']['sucursal_id']] = $row['cantidad'];
		}
		
	}
	
	
	private function _buscar_tarjetas_de_garantia( $sucursal_id )
	{
		
		if(isset($this->tarjetas_garantia[$sucursal_id]))
		{
			RETURN $this->tarjetas_garantia[$sucursal_id];
			
		}
		
		RETURN 0;
		
	}
	
	private function _buscar_encuestas_nos( $sucursal_id )
	{
		if(isset($this->encuestas_nos[$sucursal_id]))
		{
			RETURN $this->encuestas_nos[$sucursal_id];
			
		}
		
		RETURN 0;
		
	}
	
	private function _crear_porcentaje( $sucursal_id)
	{
		
		$tg = $this->_buscar_tarjetas_de_garantia($sucursal_id);
		$nos = $this->_buscar_encuestas_nos( $sucursal_id );
		if($tg == 0 || $nos == 0)
		{
			RETURN 0;
		}
		
		RETURN number_format($nos * 100 / $tg, 2, '.', '');
		
	}
	
	private function _q_sucursal()
	{
		$filtro = $this->session->userdata('filtro_'.$this->router->class);
		//tomo sucursales
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales')); //solo las sucursales del admin
		$q->orderBy('sucursal_field_desc','ASC');
		/*
		$q->leftJoin('SUCURSAL.Tarjeta_Garantia TARJETA_GARANTIA ');
		$q->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id != ?',	9); //no esta rechazada
        $q->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id != ?',	3); //no esta esperando aprobacion
		*/
		$q->groupBy('SUCURSAL.id');
		$sucursales_elejidas = array();
		if($filtro)
		{
			
			reset($filtro);
			
			while(list(,$where) =each($filtro))
			{
				if($where[0] == 'sucursal_id')
				{
					$q->WhereIn(' id ', $where[1]); //solo las sucursales del admin
				}
				else if(stristr($where[0], 'MATCH') != FALSE)
				{
					$q->addWhere($where[0],	$where[1]);
				}
			}
		}
		else
		{
			
		}
		
		RETURN $q;
	}
	
}
