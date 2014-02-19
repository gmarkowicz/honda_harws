<?php
define('ID_SECCION',3028);

class Tsi_Reporte_Totales_Main extends Backend_Controller {
		
	//filtra por sucursal?
	var $sucursal = FALSE;
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
		
		//---------------[solo para reporte]
		'fecha_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(Tsi.tsi_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(Tsi.tsi_field_fechahora_alta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_de_ingreso_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(Tsi.tsi_field_fecha_de_ingreso) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_de_ingreso_final'=>
			array(
				 'sql_filter'	=>array('DATE(Tsi.tsi_field_fecha_de_ingreso) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_de_egreso_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(Tsi.tsi_field_fecha_de_egreso) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_de_egreso_final'=>
			array(
				 'sql_filter'	=>array('DATE(Tsi.tsi_field_fecha_de_egreso) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_rotura_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(Tsi.tsi_field_fecha_rotura) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_rotura_final'=>
			array(
				 'sql_filter'	=>array('DATE(Tsi.tsi_field_fecha_rotura) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_entrega_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(Unidad.unidad_field_fecha_entrega) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'fecha_entrega_final'=>
			array(
				 'sql_filter'	=>array('DATE(Unidad.unidad_field_fecha_entrega) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		//---------------[solo para reporte]
		
		
		'sucursal_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>200,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		
	);
	
			
	function Tsi_Reporte_Totales_Main()
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
			/*
			[Accesorios] => Array
			(
				[0] => ??Accesorios
				[1] => 200
				[2] => 
				[3] => left
				[4] => 0
			)
			*/
			$buttons=false;
			
			$q = $this->_get_tipos_servicio();
			
		
			$r=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			
			foreach($r as $row)
			{
				
				$esqueleto_grid[$row['tsi_tipo_servicio_field_desc']] = array(
				0 => $row['tsi_tipo_servicio_field_desc'],
				1 => 100,
				2 => '',
				3 => 'left',
				4 => 0
				);
				
			}
			
			
			$esqueleto_grid['total'] = array(
				0 => 'Total',
				1 => 100,
				2 => '',
				3 => 'left',
				4 => 0
				);
			
		
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
		
		$f = $this->session->userdata('filtro_'.$this->router->class);
		$_POST['rp'] = 99999;
		if(!$f)
		{
			$this->flexigrid->validate_post();
		}
		$record_items=array();
		
		$config['campos'] = $this->default_valid_fields;
		//agrego para que pueda filtrar por id
		$this->default_valid_fields['id']['sorteable'] = FALSE;
		
		$total = 0;
		
		if($f)
		{
			$this->_create_query();
			
			
			$r=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$record_items = array();
			
			
			
			
			
			$q = $this->_get_tipos_servicio();
			$tipos_servicio = $q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			
			$los_servicios = array();
			foreach($tipos_servicio as $t)
			{
				$los_servicios[$t['id']] = 0;
			}
			$los_servicios['total'] = 0;
			
			$total = count($r);
			
			foreach($r as $row)
			{	
				
				$servicios = $los_servicios;
				
				foreach($row['Tsi'] as $tsi)
				{
					foreach($tsi['Many_Tsi_Tipo_Servicio'] as $ts)
					{
						
						$servicios[$ts['id']] = $ts['cantidad'];
						$servicios['total']+=$ts['cantidad'];
					}
				}
				$servicios[] = $servicios['total'];
				unset($servicios['total']);
				
				
				
				$fila = array($row['id'],
					$row['id'],
					'',
					$row['sucursal_field_desc'],
					//$servicios
				);
				
				
				
				$record_items[] = array_merge($fila, $servicios);
				
							
			}
			
			
		}
		
		

		
		//Print please
		$this->output->set_header($this->config->item('json_header'));
		$this->output->set_output($this->flexigrid->json_build($total,$record_items));
		//-------------------------[/escribe la grilla]
	}
		
	
	//exporta registros a xls
	function export()
	{
	
		//$this->output->enable_profiler();
		$config['campos'] = $this->default_valid_fields;
		$this->load->library('ofimatica');
		
		$this->ofimatica->make_file();
		
		//----seteo campos a exportar para aliviar el while
		$export_fields = array();
		$export_fields[] = 'id';
		reset($config['campos']);
		while (list($field_name,$val) = each ($config['campos']))
		{
			if(isset($val['export']) && $val['export'] === TRUE)
			{
				$export_fields[] = $this->marvin->mysql_field_to_human($field_name);
			}		
		}
		//----seteo campos a exportar para aliviar el while
		
		
		$q = $this->_get_tipos_servicio();
		$r=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);	
		foreach($r as $row)
		{
			$export_fields[] = $row['tsi_tipo_servicio_field_desc'];
		}
		$export_fields[] = 'total';
		
		
		
		
		//creo el header
		reset($export_fields);
		$this->ofimatica->add_row();
		while(list(,$field_name)=each($export_fields))
		{
			$this->ofimatica->add_header( $field_name,100 );
		}
		//creo el header
		
		$f = $this->session->userdata('filtro_'.$this->router->class);
		if($f)
		{
			$this->_create_query();
			
			
			$r=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$record_items = array();
			
			$q = $this->_get_tipos_servicio();
			$tipos_servicio = $q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			
			$los_servicios = array();
			foreach($tipos_servicio as $t)
			{
				$los_servicios[$t['id']] = 0;
			}
			$los_servicios['total'] = 0;
			
			$total = count($r);
			
			foreach($r as $row)
			{	
				
				$servicios = $los_servicios;
				
				foreach($row['Tsi'] as $tsi)
				{
					foreach($tsi['Many_Tsi_Tipo_Servicio'] as $ts)
					{
						
						$servicios[$ts['id']] = $ts['cantidad'];
						$servicios['total']+=$ts['cantidad'];
					}
				}
				$servicios[] = $servicios['total'];
				unset($servicios['total']);
				
				
				
				$fila = array($row['id'],
					$row['sucursal_field_desc'],
					//$servicios
				);
				
				
				
				$record_items[] = array_merge($fila, $servicios);
				
							
			}
			
			
			foreach($record_items as $row)
			{
				
				$this->ofimatica->add_row();
				while(list(,$v)=each($row))
				{
					$this->ofimatica->add_data( $v );
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
		
		$this->form_validation->set_rules('fecha_alta_inicial',$this->marvin->mysql_field_to_human('fecha_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_alta_final',$this->marvin->mysql_field_to_human('fecha_alta_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_de_egreso_inicial',$this->marvin->mysql_field_to_human('fecha_de_egreso_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_de_egreso_final',$this->marvin->mysql_field_to_human('fecha_de_egreso_final'),
			'trim|my_form_date_reverse'
		);
		
		$this->form_validation->set_rules('fecha_de_ingreso_inicial',$this->marvin->mysql_field_to_human('fecha_de_ingreso_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_de_ingreso_final',$this->marvin->mysql_field_to_human('fecha_de_ingreso_final'),
			'trim|my_form_date_reverse'
		);
		
		
		
		$this->form_validation->set_rules('fecha_entrega_inicial',$this->marvin->mysql_field_to_human('fecha_entrega_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_entrega_final',$this->marvin->mysql_field_to_human('fecha_entrega_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_rotura_inicial',$this->marvin->mysql_field_to_human('fecha_rotura_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_rotura_final',$this->marvin->mysql_field_to_human('fecha_rotura_final'),
			'trim|my_form_date_reverse'
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
	
	
	function _create_query()
	{
		
		/*
		$sql = "SELECT
						CO.id_concesionario,
						CO.concesionario_nombre,
						CO.concesionario_inicio_actividad,
						CO.concesionario_fin_actividad,
						count(T.id_mantenimiento) as cantidad,
						T.id_mantenimiento,
						M.mantenimiento_nombre
						FROM ".$_config['db']['prefix']."concesionario CO
						LEFT JOIN ".$_config['db']['prefix']."tsi T ON T.id_concesionario=CO.id_concesionario
						LEFT JOIN ".$_config['db']['prefix']."tsi_mantenimiento M ON T.id_mantenimiento=M.id_mantenimiento
						LEFT JOIN ".$_config['db']['prefix']."tarjeta_garantia TG ON TG.vin=T.vin AND TG.fecha_entrega is null
						WHERE T.id_concesionario IN (".implode(",", $_SESSION['admin']['concesionario']).") ".$aux_where."
						GROUP BY T.id_concesionario, T.id_mantenimiento";
						
		*/
		
		
		
		$this->query = Doctrine_Query::create();
        $this->query->select('Sucursal.id');
		$this->query->addSelect('Tsi.id');
		$this->query->addSelect('Sucursal.sucursal_field_desc');
		$this->query->addSelect('Sucursal.sucursal_field_fecha_inicio_actividad');
		$this->query->addSelect('Sucursal.sucursal_field_fecha_fin_actividad');
		$this->query->addSelect('Many_Tsi_Tipo_Servicio.*');
		$this->query->addSelect('COUNT(Many_Tsi_Tipo_Servicio.id) AS cantidad');
		
		$this->query->from('Sucursal Sucursal');
		$this->query->leftJoin('Sucursal.Tsi Tsi');
		$this->query->leftJoin('Tsi.Unidad Unidad');
		$this->query->leftJoin('Tsi.Many_Tsi_Tipo_Servicio Many_Tsi_Tipo_Servicio');
	
		
		
		
		
		$this->query->where("1 = 1");
		$this->query->addWhere('Tsi.tsi_estado_id = ?',2);
		$this->query->WhereIn('Tsi.sucursal_id ', $this->session->userdata('sucursales'));
		
		$this->query->orderBy('Sucursal.sucursal_field_desc');
		
		
		$this->query->groupBy('Sucursal.id');
		//$this->query->addGroupBy('Tsi.id');
		$this->query->addGroupBy('Many_Tsi_Tipo_Servicio.id');
		
		
		$this->flexigrid->validate_post();
		$this->flexigrid->build_query();
	}
	
	
	
	
	private function _get_tipos_servicio()
	{
		//tomo los tipos de servicio
			$obj = new Tsi_Tipo_Servicio();
			$q = $obj->get_all();
			if(!$this->session->userdata('show_tsi_tih'))
			{
				$q->addWhere("TSI_TIPO_SERVICIO.id != ?",9);
			}
			$q->orderBy('tsi_tipo_servicio_field_desc');
			
			
			RETURN $q;
			
	}
	
	
}
