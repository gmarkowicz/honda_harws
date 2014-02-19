<?php
define('ID_SECCION',3053);
/*
esto esta bastante cabeza
TODO borrar graficos viejos
*/
class Encuesta_Nos_Graficos_Main extends Backend_Controller {
		
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
	
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array('MATCH( 
												unidad_field_unidad
										) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para filtrar
		
		'encuesta_nos_field_fechahora_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(encuesta_nos_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'encuesta_nos_field_fechahora_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(encuesta_nos_field_fechahora_alta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
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
		
		
		
		'sucursal_id'=>
			array(
				 'sql_filter'	=>array('Tarjeta_Garantia.sucursal_id'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'auto_modelo_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		
		'auto_version_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
			
		'auto_transmision_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		
		
		//solo para reporte
		'auto_anio_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		
	
	


		);
			
			
	function __construct()
	{
		parent::Backend_Controller();
		
		//------------------[jpgraph package_pack]
		$this->load->add_package_path(APPPATH.'third_party/jpgraph/');
		$this->load->library('jpgraph');
		$this->load->library('jpgraph_bar');
		$this->load->library('jpgraph_pie');
		$this->load->library('jpgraph_pie3d');
		$this->load->config('jpgraph');
		//------------------[/jpgraph package_pack]	
		
	}


	function index()
	{	
		
		if(isset($_SESSION['nos_listado']))
		{
			unset($_SESSION['nos_listado']);
		}
		
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
					$this->_encuestas_nos();
					$this->_iniciar_session();
					$_SESSION['nos_listado']['registros_encontrados'] = $this->query->count();
					if($_SESSION['nos_listado']['registros_encontrados']>0)
					{
					
						$r = $this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
						
						foreach($r as $row)
						{
							
							//sexo
							if(isset($_SESSION['nos_listado']['sexo'][$row['sexo_id']]))
							{
								$_SESSION['nos_listado']['sexo'][$row['sexo_id']]++;
							}
							else
							{
								$_SESSION['nos_listado']['sexo'][0]++;
							}
							
							//edad
							if(isset($_SESSION['nos_listado']['edad'][$row['encuesta_nos_edad_id']]))
							{
								$_SESSION['nos_listado']['edad'][$row['encuesta_nos_edad_id']]++;
							}
							else
							{
								$_SESSION['nos_listado']['edad'][0]++;
							}
							
							//grupo familiar
							if(isset($_SESSION['nos_listado']['grupo'][$row['encuesta_nos_grupo_familiar_id']]))
							{
								$_SESSION['nos_listado']['grupo'][$row['encuesta_nos_grupo_familiar_id']]++;
							}
							else
							{
								$_SESSION['nos_listado']['grupo'][0];
							}
							
							//ocupacion
							if(isset($_SESSION['nos_listado']['ocupacion'][$row['encuesta_nos_ocupacion_id']]))
							{
								$_SESSION['nos_listado']['ocupacion'][$row['encuesta_nos_ocupacion_id']]++;
							}
							else
							{
								$_SESSION['nos_listado']['ocupacion'][0]++;
							}
							
							//financiacion
							if(isset($_SESSION['nos_listado']['financiacion'][$row['encuesta_nos_financiacion_id']]))
							{
								$_SESSION['nos_listado']['financiacion'][$row['encuesta_nos_financiacion_id']]++;
							}
							else
							{
								$_SESSION['nos_listado']['financiacion'][0]++;
							}
							
							//tipó de automovil
							if(isset($_SESSION['nos_listado']['tipo'][$row['encuesta_nos_tipo_automovil_id']]))
							{
								$_SESSION['nos_listado']['tipo'][$row['encuesta_nos_tipo_automovil_id']]++;
							}
							else
							{
								$_SESSION['nos_listado']['tipo'][0]++;
							}
							
							//conducido por 
							if(isset($_SESSION['nos_listado']['conducido'][$row['encuesta_nos_conductor_id']]))
							{
								$_SESSION['nos_listado']['conducido'][$row['encuesta_nos_conductor_id']]++;
							}
							else
							{
								$_SESSION['nos_listado']['conducido'][0]++;
							}
							//usos
							$_SESSION['nos_listado']['uso_negocios_total']++;
							if(isset($_SESSION['nos_listado']['uso_negocios'][$row['encuesta_nos_field_uso_negocios']]))
							{
								$_SESSION['nos_listado']['uso_negocios'][$row['encuesta_nos_field_uso_negocios']]++;
							}
							if(isset($_SESSION['nos_listado']['uso_trabajo'][$row['encuesta_nos_field_uso_transporte_trabajo']]))
							{
								$_SESSION['nos_listado']['uso_trabajo'][$row['encuesta_nos_field_uso_transporte_trabajo']]++;
							}
							if(isset($_SESSION['nos_listado']['uso_escuela'][$row['encuesta_nos_field_uso_transporte_escuela']]))
							{
								$_SESSION['nos_listado']['uso_escuela'][$row['encuesta_nos_field_uso_transporte_escuela']]++;
							}
							if(isset($_SESSION['nos_listado']['uso_general'][$row['encuesta_nos_field_uso_general']]))
							{
								$_SESSION['nos_listado']['uso_general'][$row['encuesta_nos_field_uso_general']]++;
							}
							if(isset($_SESSION['nos_listado']['uso_placer'][$row['encuesta_nos_field_uso_placer']]))
							{
								$_SESSION['nos_listado']['uso_placer'][$row['encuesta_nos_field_uso_placer']]++;
							}
							
							//opiniones..
							if(isset($_SESSION['nos_listado']['opinion_investigacion'][$row['encuesta_nos_field_opinion_investigacion']]))
							{
								$_SESSION['nos_listado']['opinion_investigacion'][$row['encuesta_nos_field_opinion_investigacion']]++;
							}
							if(isset($_SESSION['nos_listado']['opinion_originalidad'][$row['encuesta_nos_field_opinion_originalidad']]))
							{
								$_SESSION['nos_listado']['opinion_originalidad'][$row['encuesta_nos_field_opinion_originalidad']]++;
							}
							if(isset($_SESSION['nos_listado']['opinion_carreras'][$row['encuesta_nos_field_opinion_carreras']]))
							{
								$_SESSION['nos_listado']['opinion_carreras'][$row['encuesta_nos_field_opinion_carreras']]++;
							}
							if(isset($_SESSION['nos_listado']['opinion_seguridad'][$row['encuesta_nos_field_opinion_seguridad']]))
							{
								$_SESSION['nos_listado']['opinion_seguridad'][$row['encuesta_nos_field_opinion_seguridad']]++;
							}
							if(isset($_SESSION['nos_listado']['opinion_medio_ambiente'][$row['encuesta_nos_field_opinion_medio_ambiente']]))
							{
								$_SESSION['nos_listado']['opinion_medio_ambiente'][$row['encuesta_nos_field_opinion_medio_ambiente']]++;
							}
							if(isset($_SESSION['nos_listado']['opinion_eficiencia'][$row['encuesta_nos_field_opinion_eficiencia']]))
							{
								$_SESSION['nos_listado']['opinion_eficiencia'][$row['encuesta_nos_field_opinion_eficiencia']]++;
							}
							
							//interes
							if(count($row['Many_Encuesta_Nos_Opinion_Interes'])>0)
							{
								foreach($row['Many_Encuesta_Nos_Opinion_Interes'] as $interes)
								{
									if(isset($_SESSION['nos_listado']['interes'][$interes['id']]))
									{
										$_SESSION['nos_listado']['interes'][$interes['id']]++;
										$_SESSION['nos_listado']['interes_total']++;
									}
								}
							}
							
							//influencia
							
							if(isset($_SESSION['nos_listado']['influencia_estilo'][$row['encuesta_nos_field_influencia_estilo']]))
							{
								$_SESSION['nos_listado']['influencia_estilo'][$row['encuesta_nos_field_influencia_estilo']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_tamanio'][$row['encuesta_nos_field_influencia_tamanio']]))
							{
								$_SESSION['nos_listado']['influencia_tamanio'][$row['encuesta_nos_field_influencia_tamanio']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_potencia'][$row['encuesta_nos_field_influencia_potencia']]))
							{
								$_SESSION['nos_listado']['influencia_potencia'][$row['encuesta_nos_field_influencia_potencia']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_respuesta'][$row['encuesta_nos_field_influencia_respuesta']]))
							{
								$_SESSION['nos_listado']['influencia_respuesta'][$row['encuesta_nos_field_influencia_respuesta']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_maniobrabilidad'][$row['encuesta_nos_field_influencia_maniobrabilidad']]))
							{
								$_SESSION['nos_listado']['influencia_maniobrabilidad'][$row['encuesta_nos_field_influencia_maniobrabilidad']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_economia'][$row['encuesta_nos_field_influencia_economia']]))
							{
								$_SESSION['nos_listado']['influencia_economia'][$row['encuesta_nos_field_influencia_economia']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_precio'][$row['encuesta_nos_field_influencia_precio']]))
							{
								$_SESSION['nos_listado']['influencia_precio'][$row['encuesta_nos_field_influencia_precio']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_financiacion'][$row['encuesta_nos_field_influencia_financiacion']]))
							{
								$_SESSION['nos_listado']['influencia_financiacion'][$row['encuesta_nos_field_influencia_financiacion']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_garantia'][$row['encuesta_nos_field_influencia_garantia']]))
							{
								$_SESSION['nos_listado']['influencia_garantia'][$row['encuesta_nos_field_influencia_garantia']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_modelo'][$row['encuesta_nos_field_influencia_modelo']]))
							{
								$_SESSION['nos_listado']['influencia_modelo'][$row['encuesta_nos_field_influencia_modelo']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_empresa'][$row['encuesta_nos_field_influencia_empresa']]))
							{
								$_SESSION['nos_listado']['influencia_empresa'][$row['encuesta_nos_field_influencia_empresa']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_disenio'][$row['encuesta_nos_field_influencia_disenio']]))
							{
								$_SESSION['nos_listado']['influencia_disenio'][$row['encuesta_nos_field_influencia_disenio']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_comodidad'][$row['encuesta_nos_field_influencia_comodidad']]))
							{
								$_SESSION['nos_listado']['influencia_comodidad'][$row['encuesta_nos_field_influencia_comodidad']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_practicidad'][$row['encuesta_nos_field_influencia_practicidad']]))
							{
								$_SESSION['nos_listado']['influencia_practicidad'][$row['encuesta_nos_field_influencia_practicidad']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_seguridad'][$row['encuesta_nos_field_influencia_seguridad']]))
							{
								$_SESSION['nos_listado']['influencia_seguridad'][$row['encuesta_nos_field_influencia_seguridad']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_confiabilidad'][$row['encuesta_nos_field_influencia_confiabilidad']]))
							{
								$_SESSION['nos_listado']['influencia_confiabilidad'][$row['encuesta_nos_field_influencia_confiabilidad']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_longevidad'][$row['encuesta_nos_field_influencia_longevidad']]))
							{
								$_SESSION['nos_listado']['influencia_longevidad'][$row['encuesta_nos_field_influencia_longevidad']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_prestigio'][$row['encuesta_nos_field_influencia_prestigio']]))
							{
								$_SESSION['nos_listado']['influencia_prestigio'][$row['encuesta_nos_field_influencia_prestigio']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_calidad'][$row['encuesta_nos_field_influencia_calidad']]))
							{
								$_SESSION['nos_listado']['influencia_calidad'][$row['encuesta_nos_field_influencia_calidad']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_disponibilidad'][$row['encuesta_nos_field_influencia_disponibilidad']]))
							{
								$_SESSION['nos_listado']['influencia_disponibilidad'][$row['encuesta_nos_field_influencia_disponibilidad']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_accesorios'][$row['encuesta_nos_field_influencia_accesorios']]))
							{
								$_SESSION['nos_listado']['influencia_accesorios'][$row['encuesta_nos_field_influencia_accesorios']]++;
							}
							if(isset($_SESSION['nos_listado']['influencia_servicio'][$row['encuesta_nos_field_influencia_servicio']]))
							{
								$_SESSION['nos_listado']['influencia_servicio'][$row['encuesta_nos_field_influencia_servicio']]++;
							}
							//comparo
							if(isset($_SESSION['nos_listado']['comparo'][$row['encuesta_nos_field_comparo_otra_marca']]))
							{
								$_SESSION['nos_listado']['comparo'][$row['encuesta_nos_field_comparo_otra_marca']]++;
							}
							//primer auto
							if(isset($_SESSION['nos_listado']['primer_automovil'][$row['encuesta_nos_field_primer_automovil']]))
							{
								$_SESSION['nos_listado']['primer_automovil'][$row['encuesta_nos_field_primer_automovil']]++;
							}
							
										
						}
						
						
						
					}
					
					$this->session->set_userdata('reporte_nos_data',$_SESSION['nos_listado']);
					$this->_graficar();
					
					
					
					
				}
				else
				{
					$this->session->unset_userdata('reporte_nos_data');
				}
				#--------------------------
			}
		}
		//->filtros del buscador por post
			
		//->selecciones del buscador
			
		//-------------------------[/buscador ]
			
			
			
			
			
			
			
			
		
		$this->_view();
		
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
		
		$this->form_validation->set_rules('encuesta_nos_field_fechahora_alta_inicial',$this->marvin->mysql_field_to_human('encuesta_nos_field_fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('encuesta_nos_field_fechahora_alta_final',$this->marvin->mysql_field_to_human('encuesta_nos_field_fechahora_alta_final'),
			'trim|my_form_date_reverse'
		);
		
		$this->form_validation->set_rules('auto_version_id[]',$this->marvin->mysql_field_to_human('auto_version_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_modelo_id[]',$this->marvin->mysql_field_to_human('auto_modelo_id'),
			'trim'
		);
		
		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		
		$this->form_validation->set_rules('auto_transmision_id[]',$this->marvin->mysql_field_to_human('auto_transmision_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_anio_id[]',$this->marvin->mysql_field_to_human('auto_anio_id'),
			'trim'
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
		
		//------------ [select / checkbox / radio auto_modelo_id] :(
		$auto_modelo=new Auto_Modelo();
		$q = $auto_modelo->get_all();
		$q->addWhere(' auto_marca_id = ? ', 100); //honda
		$q->orderBy('auto_modelo_field_desc');
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_modelo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_modelo_id]
		
		//------------ [select / checkbox / radio auto_version_id] :(
		$auto_version=new Auto_Version();
		$q = $auto_version->get_all();
		$q->addWhere('auto_marca_id = ?',100);
		$q->orderBy('auto_modelo_field_desc');
		$q->addOrderBy('auto_version_field_desc');
		$q->whereIn('auto_modelo_id',$this->input->post('auto_modelo_id'));
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc','auto_version_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_version_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_version_id]
		
		//------------ [select / checkbox / radio auto_transmision_id] :(
		$auto_transmision=new Auto_Transmision();
		$q = $auto_transmision->get_all();
		$config=array();
		$config['fields'] = array('auto_transmision_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_transmision_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_transmision_id]
		
		//------------ [select / checkbox / radio auto_anio_id] :(
		$auto_anio=new Auto_Anio();
		$q = $auto_anio->get_all();
		$q->leftJoin('Auto_Anio.Unidad');
		$q->addWhere('auto_anio_id !=' , FALSE);
		$q->groupBy('id');
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_anio_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_anio_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_anio_id]
		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}
	
	function vprint()
	{
		
		$this->_graficar();
		$this->template['tpl_include'] = 'backend/encuesta_nos_graficos_print_view';
		$this->load->view('backend/esqueleto_print_view',$this->template);
	}
	
	
	
	private function _encuestas_nos( )
	{
		$this->query = Doctrine_Query::create();
		$this->query->from('Encuesta_Nos');
		$this->query->leftJoin('Encuesta_Nos.Many_Encuesta_Nos_Opinion_Interes Many_Encuesta_Nos_Opinion_Interes  ');
		$this->query->leftJoin('Encuesta_Nos.Tarjeta_Garantia Tarjeta_Garantia ON Tarjeta_Garantia.id = Encuesta_Nos.tarjeta_garantia_id ');
		$this->query->leftJoin('Tarjeta_Garantia.Unidad Unidad ON Unidad.id = Tarjeta_Garantia.unidad_id ');
		$this->query->leftJoin('Unidad.Auto_Version Auto_Version ');
		$this->query->leftJoin('Tarjeta_Garantia.Sucursal Sucursal ON Tarjeta_Garantia.sucursal_id = Sucursal.id ');
		$this->query->WhereIn('Tarjeta_Garantia.sucursal_id ', $this->session->userdata('sucursales')); //solo las sucursales del admin
		$this->query->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id != ?',	9); //no esta rechazada
        $this->query->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id != ?',	3); //no esta esperando aprobacion
		$this->query->groupBy('Encuesta_Nos.id');
		
		//$this->query->whereIn('Tarjeta_Garantia.sucursal_id',$where[1]);
		$this->flexigrid->validate_post();
		$this->flexigrid->build_query();
		
		
	}
	
	
	private function _iniciar_session()
	{
		
		

		
		if(isset($_SESSION['nos_listado']))
		{
			unset($_SESSION['nos_listado']);
		}


			$_SESSION['nos_listado']['tmp_images']=date("Y-m-d").'_'.md5(microtime() * mktime());
				
				$_SESSION['nos_listado']['sexo'][0]=0; //ns/nc
				$_SESSION['nos_listado']['sexo'][1]=0; //masculino
				$_SESSION['nos_listado']['sexo'][2]=0; //femenino

				$_SESSION['nos_listado']['edad'][0]=0; 
				$_SESSION['nos_listado']['edad'][1]=0;
				$_SESSION['nos_listado']['edad'][2]=0;
				$_SESSION['nos_listado']['edad'][3]=0; 
				$_SESSION['nos_listado']['edad'][4]=0;
				$_SESSION['nos_listado']['edad'][5]=0; 
				$_SESSION['nos_listado']['edad'][6]=0; 
				$_SESSION['nos_listado']['edad'][7]=0; 

				$_SESSION['nos_listado']['grupo'][0]=0;
				$_SESSION['nos_listado']['grupo'][1]=0;
				$_SESSION['nos_listado']['grupo'][2]=0;
				$_SESSION['nos_listado']['grupo'][3]=0;
				$_SESSION['nos_listado']['grupo'][4]=0;
				$_SESSION['nos_listado']['grupo'][5]=0;
				$_SESSION['nos_listado']['grupo'][6]=0;

				for($n=0;$n<14;$n++){
					$_SESSION['nos_listado']['ocupacion'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['financiacion'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['tipo'][$n]=0;
				}
				for($n=0;$n<7;$n++){
					$_SESSION['nos_listado']['conducido'][$n]=0;
				}
				for($n=1;$n<7;$n++){
					$_SESSION['nos_listado']['interes'][$n]=0;
				}
				$_SESSION['nos_listado']['interes_total']=0;
				
				for($n=0;$n<3;$n++){
					$_SESSION['nos_listado']['uso_negocios'][$n]=0;
				}
				$_SESSION['nos_listado']['uso_negocios_total']=0;
				for($n=0;$n<3;$n++){
					$_SESSION['nos_listado']['uso_trabajo'][$n]=0;
				}
				for($n=0;$n<3;$n++){
					$_SESSION['nos_listado']['uso_escuela'][$n]=0;
				}
				for($n=0;$n<3;$n++){
					$_SESSION['nos_listado']['uso_general'][$n]=0;
				}
				for($n=0;$n<3;$n++){
					$_SESSION['nos_listado']['uso_placer'][$n]=0;
				}
				for($n=0;$n<5;$n++){
					$_SESSION['nos_listado']['opinion_investigacion'][$n]=0;
				}
				for($n=0;$n<5;$n++){
					$_SESSION['nos_listado']['opinion_originalidad'][$n]=0;
				}
				for($n=0;$n<5;$n++){
					$_SESSION['nos_listado']['opinion_carreras'][$n]=0;
				}
				for($n=0;$n<5;$n++){
					$_SESSION['nos_listado']['opinion_seguridad'][$n]=0;
				}
				for($n=0;$n<5;$n++){
					$_SESSION['nos_listado']['opinion_medio_ambiente'][$n]=0;
				}
				for($n=0;$n<5;$n++){
					$_SESSION['nos_listado']['opinion_eficiencia'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_estilo'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_tamanio'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_potencia'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_respuesta'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_maniobrabilidad'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_economia'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_precio'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_financiacion'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_garantia'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_modelo'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_empresa'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_disenio'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_comodidad'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_practicidad'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_seguridad'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_confiabilidad'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_longevidad'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_prestigio'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_calidad'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_disponibilidad'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_accesorios'][$n]=0;
				}
				for($n=0;$n<4;$n++){
					$_SESSION['nos_listado']['influencia_servicio'][$n]=0;
				}
				for($n=0;$n<3;$n++){
					$_SESSION['nos_listado']['comparo'][$n]=0;
				}
				for($n=0;$n<3;$n++){
					$_SESSION['nos_listado']['primer_automovil'][$n]=0;
				}
				for($n=0;$n<3;$n++){
					$_SESSION['nos_listado']['automovil_otro'][$n]=0;
				}
	}
	
	
	private function _nf($numero)
	{
		RETURN number_format($numero, 2, '.', '');
	}
	
	private function _graficar()
	{
		$_SESSION['nos_listado'] = $this->session->userdata('reporte_nos_data');
		if(!isset($_SESSION['nos_listado']['registros_encontrados']) OR $_SESSION['nos_listado']['registros_encontrados']<1)
			show_404();
		
		
		$colores = $this->config->item('jpgraph_2colores');
						
						
						
						
						//---------------[sexo]
						
						for($i = 0;$i<=2;$i++)
						{
							$_SESSION['nos_listado']['sexo'][$i] = $this->_nf(($_SESSION['nos_listado']['sexo'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						
						$graph = new Graph(300,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,35,105,30); //margenes
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
						//$graph->xaxis->SetLabelAngle(45); //angulo de la data
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Género (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);	
						$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->SetTickLabels(array('Género ('. $_SESSION['nos_listado']['registros_encontrados'] .')')); //asigna data a los labels
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_1') ,BGIMG_COPY);
						
						
						
						$b1plot = new BarPlot(array($_SESSION['nos_listado']['sexo'][1]));
						$b1plot->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
						$b1plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b1plot->value->Show();
						$b1plot->SetValuePos('center'); //posicion del valor
						$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b1plot->SetLegend('Masculino');
						
						$b2plot = new BarPlot(array($_SESSION['nos_listado']['sexo'][2]));
						$b2plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$b2plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b2plot->value->Show();
						$b2plot->SetValuePos('center'); //posicion del valor
						$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b2plot->SetLegend('Femenino');

						$b0plot = new BarPlot(array($_SESSION['nos_listado']['sexo'][0]));
						$b0plot->SetFillColor($colores[0] . $this->config->item('jpgraph_2transparencia')); //
						$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b0plot->value->Show();
						$b0plot->SetValuePos('center'); //posicion del valor
						$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b0plot->SetLegend('Ns/Nc');
						
						$gbplot = new AccBarPlot(array($b0plot,$b2plot,$b1plot));
						$graph->Add($gbplot);
						$graph->Stroke($this->config->item('jpgraph_write') ."sexo_".$_SESSION['nos_listado']['tmp_images'].".png");
						unset($graph);
						//---------------[sexo]
						
						//---------------[edad]
						for($i = 0;$i<=7;$i++)
						{
							$_SESSION['nos_listado']['edad'][$i] = $this->_nf(($_SESSION['nos_listado']['edad'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						
						$graph = new Graph(300,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,35,105,30); //margenes
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
						//$graph->xaxis->SetLabelAngle(45); //angulo de la data
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Edad (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);	
						$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->SetTickLabels(array('Edad ('.$_SESSION['nos_listado']['registros_encontrados'].')')); //asigna data a los labels
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_1') ,BGIMG_COPY);
						
						$b0plot = new BarPlot(array($_SESSION['nos_listado']['edad'][0]));
						$b2plot->SetFillColor($colores[0] . $this->config->item('jpgraph_2transparencia')); //
						$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b0plot->value->Show();
						$b0plot->SetValuePos('center'); //posicion del valor
						$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b0plot->SetLegend('Ns/Nc');
						
						$b1plot = new BarPlot(array($_SESSION['nos_listado']['edad'][1]));
						$b1plot->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
						$b1plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b1plot->value->Show();
						$b1plot->SetValuePos('center'); //posicion del valor
						$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b1plot->SetLegend('Menos de 20');

						$b2plot = new BarPlot(array($_SESSION['nos_listado']['edad'][2]));
						$b2plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$b2plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b2plot->value->Show();
						$b2plot->SetValuePos('center'); //posicion del valor
						$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b2plot->SetLegend('20-29');

						$b3plot = new BarPlot(array($_SESSION['nos_listado']['edad'][3]));
						$b3plot->SetFillColor($colores[3] . $this->config->item('jpgraph_2transparencia')); //
						$b3plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b3plot->value->Show();
						$b3plot->SetValuePos('center'); //posicion del valor
						$b3plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b3plot->SetLegend('30-39');

						$b4plot = new BarPlot(array($_SESSION['nos_listado']['edad'][4]));
						$b4plot->SetFillColor($colores[4] . $this->config->item('jpgraph_2transparencia')); //
						$b4plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b4plot->value->Show();
						$b4plot->SetValuePos('center'); //posicion del valor
						$b4plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b4plot->SetLegend('40-49');

						$b5plot = new BarPlot(array($_SESSION['nos_listado']['edad'][5]));
						$b5plot->SetFillColor($colores[5] . $this->config->item('jpgraph_2transparencia')); //
						$b5plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b5plot->value->Show();
						$b5plot->SetValuePos('center'); //posicion del valor
						$b5plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b5plot->SetLegend('50-59');

						$b6plot = new BarPlot(array($_SESSION['nos_listado']['edad'][6]));
						$b6plot->SetFillColor($colores[6] . $this->config->item('jpgraph_2transparencia')); //
						$b6plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b6plot->value->Show();
						$b6plot->SetValuePos('center'); //posicion del valor
						$b6plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b6plot->SetLegend('60-69');

						$b7plot = new BarPlot(array($_SESSION['nos_listado']['edad'][7]));
						$b7plot->SetFillColor($colores[7] . $this->config->item('jpgraph_2transparencia')); //
						$b7plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b7plot->value->Show();
						$b7plot->SetValuePos('center'); //posicion del valor
						$b7plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b7plot->SetLegend('70 o más');
						
						$gbplot = new AccBarPlot(array($b0plot,$b7plot,$b6plot,$b5plot,$b4plot,$b3plot,$b2plot,$b1plot));
						$graph->Add($gbplot);
						$graph->Stroke($this->config->item('jpgraph_write') ."edad_".$_SESSION['nos_listado']['tmp_images'].".png");
						unset($graph);
						
						//---------------[edad]
						
						//---------------[grupo familiar]
						
						for($i = 0;$i<=6;$i++)
						{
							$_SESSION['nos_listado']['grupo'][$i] = $this->_nf(($_SESSION['nos_listado']['grupo'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						
						$graph = new Graph(300,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,35,105,30); //margenes
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
						//$graph->xaxis->SetLabelAngle(45); //angulo de la data
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Número de personas (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);	
						$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->SetTickLabels(array('Número de personas ('.$_SESSION['nos_listado']['registros_encontrados'].')')); //asigna data a los labels
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_1') ,BGIMG_COPY);
						
						
						$b0plot = new BarPlot(array($_SESSION['nos_listado']['grupo'][0]));
						$b0plot->SetFillColor($colores[0] . $this->config->item('jpgraph_2transparencia')); //
						$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b0plot->value->Show();
						$b0plot->SetValuePos('center'); //posicion del valor
						$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b0plot->SetLegend('Ns/Nc');
						
						$b1plot = new BarPlot(array($_SESSION['nos_listado']['grupo'][1]));
						$b1plot->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
						$b1plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b1plot->value->Show();
						$b1plot->SetValuePos('center'); //posicion del valor
						$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b1plot->SetLegend('Uno');
						
						$b2plot = new BarPlot(array($_SESSION['nos_listado']['grupo'][2]));
						$b2plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$b2plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b2plot->value->Show();
						$b2plot->SetValuePos('center'); //posicion del valor
						$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b2plot->SetLegend('Dos');
						
						$b3plot = new BarPlot(array($_SESSION['nos_listado']['grupo'][3]));
						$b3plot->SetFillColor($colores[3] . $this->config->item('jpgraph_2transparencia')); //
						$b3plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b3plot->value->Show();
						$b3plot->SetValuePos('center'); //posicion del valor
						$b3plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b3plot->SetLegend('Tres');
						
						$b4plot = new BarPlot(array($_SESSION['nos_listado']['grupo'][4]));
						$b4plot->SetFillColor($colores[4] . $this->config->item('jpgraph_2transparencia')); //
						$b4plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b4plot->value->Show();
						$b4plot->SetValuePos('center'); //posicion del valor
						$b4plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b4plot->SetLegend('Cuatro');
						
						$b5plot = new BarPlot(array($_SESSION['nos_listado']['grupo'][5]));
						$b5plot->SetFillColor($colores[5] . $this->config->item('jpgraph_2transparencia')); //
						$b5plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b5plot->value->Show();
						$b5plot->SetValuePos('center'); //posicion del valor
						$b5plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b5plot->SetLegend('Cinco');
						
						$b6plot = new BarPlot(array($_SESSION['nos_listado']['grupo'][6]));
						$b6plot->SetFillColor($colores[6] . $this->config->item('jpgraph_2transparencia')); //
						$b6plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b6plot->value->Show();
						$b6plot->SetValuePos('center'); //posicion del valor
						$b6plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b6plot->SetLegend('Seis o Más');
						
						$gbplot = new AccBarPlot(array($b0plot,$b6plot,$b5plot,$b4plot,$b3plot,$b2plot,$b1plot));
						$graph->Add($gbplot);
						$graph->Stroke($this->config->item('jpgraph_write') ."grupo_".$_SESSION['nos_listado']['tmp_images'].".png");
						unset($graph);
						
					
						//---------------[grupo familiar]
						
						//---------------[ocupacion]
						for($i = 0;$i<=13;$i++)
						{
							$_SESSION['nos_listado']['ocupacion'][$i] = $this->_nf(($_SESSION['nos_listado']['ocupacion'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						
						$graph = new Graph(600,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(35,20,35,100); //margenes
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
						$graph->xaxis->SetLabelAngle(55); //angulo de la data
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Ocupación (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);	
						$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->SetTickLabels(array(
															'Dueño / Director',
															'Gerencia',
															'Empleado',
															'Profesional',
															'Educador',
															'Independiente',
															'Estudiante',
															'Funcionario de gob.',
															'Empleado del gob.',
															'Oficial militar',
															'Soldado',
															'Ama de casa',
															'Otros',
															'Ns/Nc'
															)); //asigna data a los labels
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_2') ,BGIMG_COPY);
						

						$b0plot = new BarPlot(array(
							$_SESSION['nos_listado']['ocupacion'][1],
							$_SESSION['nos_listado']['ocupacion'][2],
							$_SESSION['nos_listado']['ocupacion'][3],
							$_SESSION['nos_listado']['ocupacion'][4],
							$_SESSION['nos_listado']['ocupacion'][5],
							$_SESSION['nos_listado']['ocupacion'][6],
							$_SESSION['nos_listado']['ocupacion'][7],
							$_SESSION['nos_listado']['ocupacion'][8],
							$_SESSION['nos_listado']['ocupacion'][9],
							$_SESSION['nos_listado']['ocupacion'][10],
							$_SESSION['nos_listado']['ocupacion'][11],
							$_SESSION['nos_listado']['ocupacion'][12],
							$_SESSION['nos_listado']['ocupacion'][13],
							$_SESSION['nos_listado']['ocupacion'][0]));
						$b0plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b0plot->value->Show();
						$b0plot->SetValuePos('top'); //posicion del valor
						$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);

						
						$graph->Add($b0plot);
						$graph->Stroke($this->config->item('jpgraph_write') ."ocupacion_".$_SESSION['nos_listado']['tmp_images'].".png");
						unset($graph);
						
						//---------------[ocupacion]
						
						
						//---------------[financiacion]
						for($i = 0;$i<=3;$i++)
						{
							$_SESSION['nos_listado']['financiacion'][$i] = $this->_nf(($_SESSION['nos_listado']['financiacion'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						
						$graph = new Graph(300,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,35,105,30); //margenes
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
						//$graph->xaxis->SetLabelAngle(45); //angulo de la data
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Como compró su automóvil (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);	
						$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->SetTickLabels(array('Como compró su automóvil ('.$_SESSION['nos_listado']['registros_encontrados'].')')); //asigna data a los labels
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_1') ,BGIMG_COPY);
						
						$b0plot = new BarPlot(array($_SESSION['nos_listado']['financiacion'][0]));
						$b0plot->SetFillColor($colores[0] . $this->config->item('jpgraph_2transparencia')); //
						$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b0plot->value->Show();
						$b0plot->SetValuePos('center'); //posicion del valor
						$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b0plot->SetLegend('Ns/Nc');
						
						$b1plot = new BarPlot(array($_SESSION['nos_listado']['financiacion'][1]));
						$b1plot->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
						$b1plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b1plot->value->Show();
						$b1plot->SetValuePos('center'); //posicion del valor
						$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b1plot->SetLegend('Al Contado');
						
						$b2plot = new BarPlot(array($_SESSION['nos_listado']['financiacion'][2]));
						$b2plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$b2plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b2plot->value->Show();
						$b2plot->SetValuePos('center'); //posicion del valor
						$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b2plot->SetLegend('Préstamo');
						
						$b3plot = new BarPlot(array($_SESSION['nos_listado']['financiacion'][3]));
						$b3plot->SetFillColor($colores[3] . $this->config->item('jpgraph_2transparencia')); //
						$b3plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b3plot->value->Show();
						$b3plot->SetValuePos('center'); //posicion del valor
						$b3plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b3plot->SetLegend('Otros');
						
						
						$gbplot = new AccBarPlot(array($b0plot,$b3plot,$b2plot,$b1plot));
						$graph->Add($gbplot);
						$graph->Stroke($this->config->item('jpgraph_write') ."financiacion_".$_SESSION['nos_listado']['tmp_images'].".png");
						unset($graph);
						//---------------[financiacion]
						
						
						//---------------[tipo de automovil]
						for($i = 0;$i<=3;$i++)
						{
							$_SESSION['nos_listado']['tipo'][$i] = $this->_nf(($_SESSION['nos_listado']['tipo'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						$graph = new Graph(300,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,35,105,30); //margenes
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
						//$graph->xaxis->SetLabelAngle(45); //angulo de la data
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Es este automovil (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);	
						$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->SetTickLabels(array('Es este automovil ('.$_SESSION['nos_listado']['registros_encontrados'].')')); //asigna data a los labels
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_1') ,BGIMG_COPY);
						
						
						
						$b0plot = new BarPlot(array($_SESSION['nos_listado']['tipo'][0]));
						$b0plot->SetFillColor($colores[0] . $this->config->item('jpgraph_2transparencia')); //
						$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b0plot->value->Show();
						$b0plot->SetValuePos('center'); //posicion del valor
						$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b0plot->SetLegend('Ns/Nc');
						
						$b1plot = new BarPlot(array($_SESSION['nos_listado']['tipo'][1]));
						$b1plot->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
						$b1plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b1plot->value->Show();
						$b1plot->SetValuePos('center'); //posicion del valor
						$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b1plot->SetLegend('Principal');
						
						$b2plot = new BarPlot(array($_SESSION['nos_listado']['tipo'][2]));
						$b2plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$b2plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b2plot->value->Show();
						$b2plot->SetValuePos('center'); //posicion del valor
						$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b2plot->SetLegend('Secundario');
						
						$b3plot = new BarPlot(array($_SESSION['nos_listado']['tipo'][3]));
						$b3plot->SetFillColor($colores[3] . $this->config->item('jpgraph_2transparencia')); //
						$b3plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b3plot->value->Show();
						$b3plot->SetValuePos('center'); //posicion del valor
						$b3plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b3plot->SetLegend('Auto de la compañia');
						
						$gbplot = new AccBarPlot(array($b0plot,$b3plot,$b2plot,$b1plot));
						$graph->Add($gbplot);
						$graph->Stroke($this->config->item('jpgraph_write') ."tipo_".$_SESSION['nos_listado']['tmp_images'].".png");
						unset($graph);

						//---------------[tipo de automovil]
						
						//---------------[conducido por]
						for($i = 0;$i<=6;$i++)
						{
							$_SESSION['nos_listado']['conducido'][$i] = $this->_nf(($_SESSION['nos_listado']['conducido'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						$graph = new Graph(300,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,35,105,30); //margenes
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
						//$graph->xaxis->SetLabelAngle(45); //angulo de la data
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Este automovil es conducido por (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);	
						$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->SetTickLabels(array('Es este automovil ('.$_SESSION['nos_listado']['registros_encontrados'].')')); //asigna data a los labels
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_1') ,BGIMG_COPY);
						
						$b0plot = new BarPlot(array($_SESSION['nos_listado']['conducido'][0]));
						$b0plot->SetFillColor($colores[0] . $this->config->item('jpgraph_2transparencia')); //
						$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b0plot->value->Show();
						$b0plot->SetValuePos('center'); //posicion del valor
						$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b0plot->SetLegend('Ns/Nc');
						
						
						$b1plot = new BarPlot(array($_SESSION['nos_listado']['conducido'][1]));
						$b1plot->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
						$b1plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b1plot->value->Show();
						$b1plot->SetValuePos('center'); //posicion del valor
						$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b1plot->SetLegend('Propietario');
						
						$b2plot = new BarPlot(array($_SESSION['nos_listado']['conducido'][2]));
						$b2plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$b2plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b2plot->value->Show();
						$b2plot->SetValuePos('center'); //posicion del valor
						$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b2plot->SetLegend('Esposo/a o Hijo/a');
						
						$b3plot = new BarPlot(array($_SESSION['nos_listado']['conducido'][3]));
						$b3plot->SetFillColor($colores[3] . $this->config->item('jpgraph_2transparencia')); //
						$b3plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b3plot->value->Show();
						$b3plot->SetValuePos('center'); //posicion del valor
						$b3plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b3plot->SetLegend('Chofer');
						
						$b4plot = new BarPlot(array($_SESSION['nos_listado']['conducido'][4]));
						$b4plot->SetFillColor($colores[4] . $this->config->item('jpgraph_2transparencia')); //
						$b4plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b4plot->value->Show();
						$b4plot->SetValuePos('center'); //posicion del valor
						$b4plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b4plot->SetLegend('Ejecutivo');
						
						$b5plot = new BarPlot(array($_SESSION['nos_listado']['conducido'][5]));
						$b5plot->SetFillColor($colores[5] . $this->config->item('jpgraph_2transparencia')); //
						$b5plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b5plot->value->Show();
						$b5plot->SetValuePos('center'); //posicion del valor
						$b5plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b5plot->SetLegend('Empleado');
						
						$b6plot = new BarPlot(array($_SESSION['nos_listado']['conducido'][6]));
						$b6plot->SetFillColor($colores[6] . $this->config->item('jpgraph_2transparencia')); //
						$b6plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b6plot->value->Show();
						$b6plot->SetValuePos('center'); //posicion del valor
						$b6plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b6plot->SetLegend('Otros');
						
						$gbplot = new AccBarPlot(array($b0plot,$b6plot,$b5plot,$b4plot,$b3plot,$b2plot,$b1plot));
						$graph->Add($gbplot);
						$graph->Stroke($this->config->item('jpgraph_write') ."conducido_".$_SESSION['nos_listado']['tmp_images'].".png");
						unset($graph);
						
						
						//---------------[conducido por]
						
						//---------------[usos]
						for($i = 0;$i<=2;$i++)
						{
							$_SESSION['nos_listado']['uso_negocios'][$i] = $this->_nf(($_SESSION['nos_listado']['uso_negocios'][$i]*100)/$_SESSION['nos_listado']['uso_negocios_total']);
							
							$_SESSION['nos_listado']['uso_trabajo'][$i] = $this->_nf(($_SESSION['nos_listado']['uso_trabajo'][$i]*100)/$_SESSION['nos_listado']['uso_negocios_total']);
							
							$_SESSION['nos_listado']['uso_escuela'][$i] = $this->_nf(($_SESSION['nos_listado']['uso_escuela'][$i]*100)/$_SESSION['nos_listado']['uso_negocios_total']);
							
							$_SESSION['nos_listado']['uso_general'][$i] = $this->_nf(($_SESSION['nos_listado']['uso_general'][$i]*100)/$_SESSION['nos_listado']['uso_negocios_total']);
							
							$_SESSION['nos_listado']['uso_placer'][$i] = $this->_nf(($_SESSION['nos_listado']['uso_placer'][$i]*100)/$_SESSION['nos_listado']['uso_negocios_total']);
						}
						
						
						$graph = new Graph(600,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,100,40,30); //margenes
						
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Como usa el automóvil (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->xaxis->SetTickLabels(array('Importante','Secundario','Ns/Nc'));
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);				
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_2') ,BGIMG_COPY);
						
						$bplot1 = new BarPlot(array(
							$_SESSION['nos_listado']['uso_negocios'][1],
							$_SESSION['nos_listado']['uso_negocios'][2],
							$_SESSION['nos_listado']['uso_negocios'][0]));
						$bplot1->value->Show();
						$bplot1->SetValuePos('center'); //posicion del valor
						$bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$bplot1->SetLegend('Negocios / Trabajo');
						$bplot1->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
						$bplot1->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						
						$bplot2 = new BarPlot(array(
							$_SESSION['nos_listado']['uso_trabajo'][1],
							$_SESSION['nos_listado']['uso_trabajo'][2],
							$_SESSION['nos_listado']['uso_trabajo'][0]));
						$bplot2->value->Show();
						$bplot2->SetValuePos('center'); //posicion del valor
						$bplot2->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$bplot2->SetLegend('Transporte al trabajo');
						$bplot2->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$bplot2->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						
						$bplot3 = new BarPlot(array(
							$_SESSION['nos_listado']['uso_escuela'][1],
							$_SESSION['nos_listado']['uso_escuela'][2],
							$_SESSION['nos_listado']['uso_escuela'][0]));
						$bplot3->value->Show();
						$bplot3->SetValuePos('center'); //posicion del valor
						$bplot3->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$bplot3->SetLegend('Transporte a la escuela');
						$bplot3->SetFillColor($colores[3] . $this->config->item('jpgraph_2transparencia')); //
						$bplot3->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						
						$bplot4 = new BarPlot(array(
							$_SESSION['nos_listado']['uso_general'][1],
							$_SESSION['nos_listado']['uso_general'][2],
							$_SESSION['nos_listado']['uso_general'][0]));
						$bplot4->value->Show();
						$bplot4->SetValuePos('center'); //posicion del valor
						$bplot4->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$bplot4->SetLegend('General');
						$bplot4->SetFillColor($colores[4] . $this->config->item('jpgraph_2transparencia')); //
						$bplot4->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						
						$bplot5 = new BarPlot(array(
							$_SESSION['nos_listado']['uso_placer'][1],
							$_SESSION['nos_listado']['uso_placer'][2],
							$_SESSION['nos_listado']['uso_placer'][0]));
						$bplot5->value->Show();
						$bplot5->SetValuePos('center'); //posicion del valor
						$bplot5->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$bplot5->SetLegend('Placer');
						$bplot5->SetFillColor($colores[5] . $this->config->item('jpgraph_2transparencia')); //
						$bplot5->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						
						$gbarplot = new GroupBarPlot(array($bplot1,$bplot2,$bplot3,$bplot4,$bplot5));
						$graph->Add($gbarplot);
						$graph->Stroke($this->config->item('jpgraph_write') ."usos_".$_SESSION['nos_listado']['tmp_images'].".png");
						
						//---------------[usos]
						
						//---------------[opinion]
						//seleccione va como ns/nc
						$_SESSION['nos_listado']['opinion_investigacion'][4]+=$_SESSION['nos_listado']['opinion_investigacion'][0];
						$_SESSION['nos_listado']['opinion_investigacion_total']=0;
						
						$_SESSION['nos_listado']['opinion_originalidad'][4]+=$_SESSION['nos_listado']['opinion_originalidad'][0];
						$_SESSION['nos_listado']['opinion_originalidad_total']=0;
						
						$_SESSION['nos_listado']['opinion_carreras'][4]+=$_SESSION['nos_listado']['opinion_carreras'][0];
						$_SESSION['nos_listado']['opinion_carreras_total']=0;
						
						$_SESSION['nos_listado']['opinion_seguridad'][4]+=$_SESSION['nos_listado']['opinion_seguridad'][0];
						$_SESSION['nos_listado']['opinion_seguridad_total']=0;
						
						$_SESSION['nos_listado']['opinion_medio_ambiente'][4]+=$_SESSION['nos_listado']['opinion_medio_ambiente'][0];
						$_SESSION['nos_listado']['opinion_medio_ambiente_total']=0;
						
						$_SESSION['nos_listado']['opinion_eficiencia'][4]+=$_SESSION['nos_listado']['opinion_eficiencia'][0];
						$_SESSION['nos_listado']['opinion_eficiencia_total']=0;
						for($n=1;$n<=4;$n++)
						{
							$_SESSION['nos_listado']['opinion_investigacion_total']+=$_SESSION['nos_listado']['opinion_investigacion'][$n];
							$_SESSION['nos_listado']['opinion_originalidad_total']+=$_SESSION['nos_listado']['opinion_originalidad'][$n];
							$_SESSION['nos_listado']['opinion_carreras_total']+=$_SESSION['nos_listado']['opinion_carreras'][$n];
							$_SESSION['nos_listado']['opinion_seguridad_total']+=$_SESSION['nos_listado']['opinion_seguridad'][$n];
							$_SESSION['nos_listado']['opinion_medio_ambiente_total']+=$_SESSION['nos_listado']['opinion_medio_ambiente'][$n];
							$_SESSION['nos_listado']['opinion_eficiencia_total']+=$_SESSION['nos_listado']['opinion_eficiencia'][$n];
						}
						
						for($i=1;$i<=4;$i++)
						{
							$_SESSION['nos_listado']['opinion_investigacion'][$i] = $this->_nf(($_SESSION['nos_listado']['opinion_investigacion'][$i]*100)/$_SESSION['nos_listado']['opinion_investigacion_total']);
							
							$_SESSION['nos_listado']['opinion_originalidad'][$i] = $this->_nf(($_SESSION['nos_listado']['opinion_originalidad'][$i]*100)/$_SESSION['nos_listado']['opinion_originalidad_total']);
							
							$_SESSION['nos_listado']['opinion_carreras'][$i] = $this->_nf(($_SESSION['nos_listado']['opinion_carreras'][$i]*100)/$_SESSION['nos_listado']['opinion_carreras_total']);
							
							$_SESSION['nos_listado']['opinion_seguridad'][$i] = $this->_nf(($_SESSION['nos_listado']['opinion_seguridad'][$i]*100)/$_SESSION['nos_listado']['opinion_seguridad_total']);
							
							$_SESSION['nos_listado']['opinion_medio_ambiente'][$i] = $this->_nf(($_SESSION['nos_listado']['opinion_medio_ambiente'][$i]*100)/$_SESSION['nos_listado']['opinion_medio_ambiente_total']);
							
							$_SESSION['nos_listado']['opinion_eficiencia'][$i] = $this->_nf(($_SESSION['nos_listado']['opinion_eficiencia'][$i]*100)/$_SESSION['nos_listado']['opinion_eficiencia_total']);
						}
						
						
						
						$graph = new Graph(600,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,150,35,50); //margenes
						$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
					   //	$graph->xaxis->SetLabelAngle(45); //angulo de la data
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Impresiones de Honda (%)');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
						$graph->xaxis->SetTickLabels(array("Investigación","Innovacion","Competición","Seguridad","Medio\nAmbiente","Eficiencia")); //asigna data a los labels
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_2') ,BGIMG_COPY);
						
						//ns/nc
						$b0plot = new BarPlot(array(
							$_SESSION['nos_listado']['opinion_investigacion'][4],
							$_SESSION['nos_listado']['opinion_originalidad'][4],
							$_SESSION['nos_listado']['opinion_carreras'][4],
							$_SESSION['nos_listado']['opinion_seguridad'][4],
							$_SESSION['nos_listado']['opinion_medio_ambiente'][4],
							$_SESSION['nos_listado']['opinion_eficiencia'][4]));
						
						$b0plot->SetFillColor($colores[0] . $this->config->item('jpgraph_2transparencia')); //
						$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b0plot->value->Show();
						$b0plot->SetValuePos('center'); //posicion del valor
						$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b0plot->SetLegend('Ns/Nc');
						
						$b3plot = new BarPlot(array(
							$_SESSION['nos_listado']['opinion_investigacion'][3],
							$_SESSION['nos_listado']['opinion_originalidad'][3],
							$_SESSION['nos_listado']['opinion_carreras'][3],
							$_SESSION['nos_listado']['opinion_seguridad'][3],
							$_SESSION['nos_listado']['opinion_medio_ambiente'][3],
							$_SESSION['nos_listado']['opinion_eficiencia'][3]));
						
						$b3plot->SetFillColor($colores[3] . $this->config->item('jpgraph_2transparencia')); //
						$b3plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b3plot->value->Show();
						$b3plot->SetValuePos('center'); //posicion del valor
						$b3plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b3plot->SetLegend('Debajo de lo normal');
						
						$b2plot = new BarPlot(array(
							$_SESSION['nos_listado']['opinion_investigacion'][2],
							$_SESSION['nos_listado']['opinion_originalidad'][2],
							$_SESSION['nos_listado']['opinion_carreras'][2],
							$_SESSION['nos_listado']['opinion_seguridad'][2],
							$_SESSION['nos_listado']['opinion_medio_ambiente'][2],
							$_SESSION['nos_listado']['opinion_eficiencia'][2]));
						
						$b2plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
						$b2plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b2plot->value->Show();
						$b2plot->SetValuePos('center'); //posicion del valor
						$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b2plot->SetLegend('Normal');
						
						$b1plot = new BarPlot(array(
							$_SESSION['nos_listado']['opinion_investigacion'][1],
							$_SESSION['nos_listado']['opinion_originalidad'][1],
							$_SESSION['nos_listado']['opinion_carreras'][1],
							$_SESSION['nos_listado']['opinion_seguridad'][1],
							$_SESSION['nos_listado']['opinion_medio_ambiente'][1],
							$_SESSION['nos_listado']['opinion_eficiencia'][1]));
						
						$b1plot->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
						$b1plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
						$b1plot->value->Show();
						$b1plot->SetValuePos('center'); //posicion del valor
						$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
						$b1plot->SetLegend('Más de lo normal');
						
						$gbplot = new AccBarPlot(array($b0plot,$b3plot,$b2plot,$b1plot));
						$graph->Add($gbplot);
						$graph->Stroke($this->config->item('jpgraph_write') ."opinion_".$_SESSION['nos_listado']['tmp_images'].".png");
						unset($graph);
						
						//---------------[opinion]
						
						//---------------[interes]
						for($i = 1;$i<=6;$i++)
						{
							$_SESSION['nos_listado']['interes'][$i] = $this->_nf(($_SESSION['nos_listado']['interes'][$i]*100)/$_SESSION['nos_listado']['interes_total']);
						}
						
						$graph = new PieGraph(600,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,150,35,50); //margenes
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Como se interesó en su Honda');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_2') ,BGIMG_COPY);
						// Create 3D pie plot
						$p1 = new PiePlot3d(array(
												$_SESSION['nos_listado']['interes'][1],
												$_SESSION['nos_listado']['interes'][2],
												$_SESSION['nos_listado']['interes'][3],
												$_SESSION['nos_listado']['interes'][4],
												$_SESSION['nos_listado']['interes'][5],
												$_SESSION['nos_listado']['interes'][6],
												
												));
						$p1->SetEdge("#000000");
						$p1->SetTheme("sand");
						$p1->SetCenter(0.4);
						$p1->SetSize(0.4);
						$p1->SetHeight(15);
						$p1->SetAngle(45);
						$p1->Explode(array(15,15,15,15,15,15));
						$p1->value->SetFont(FF_ARIAL,FS_NORMAL,10);
						$p1->SetLegends(array('Reputación','Anuncio comercial','Recomendación','Conduciendo','Anuncio','Exposición'));

						$graph->Add($p1);
						$graph->Stroke($this->config->item('jpgraph_write') ."interes_".$_SESSION['nos_listado']['tmp_images'].".png");
						#interes
						//---------------[interes]
						
						//---------------[influencia]
						$_SESSION['nos_listado']['influencia_estilo'][3]+=$_SESSION['nos_listado']['influencia_estilo'][0];
						$_SESSION['nos_listado']['influencia_estilo_total']=0;
						
						$_SESSION['nos_listado']['influencia_tamanio'][3]+=$_SESSION['nos_listado']['influencia_tamanio'][0];
						$_SESSION['nos_listado']['influencia_tamanio_total']=0;
						
						$_SESSION['nos_listado']['influencia_potencia'][3]+=$_SESSION['nos_listado']['influencia_potencia'][0];
						$_SESSION['nos_listado']['influencia_potencia_total']=0;
						
						$_SESSION['nos_listado']['influencia_respuesta'][3]+=$_SESSION['nos_listado']['influencia_respuesta'][0];
						$_SESSION['nos_listado']['influencia_respuesta_total']=0;
						
						$_SESSION['nos_listado']['influencia_maniobrabilidad'][3]+=$_SESSION['nos_listado']['influencia_maniobrabilidad'][0];
						$_SESSION['nos_listado']['influencia_maniobrabilidad_total']=0;
						
						$_SESSION['nos_listado']['influencia_economia'][3]+=$_SESSION['nos_listado']['influencia_economia'][0];
						$_SESSION['nos_listado']['influencia_economia_total']=0;
						
						$_SESSION['nos_listado']['influencia_precio'][3]+=$_SESSION['nos_listado']['influencia_precio'][0];
						$_SESSION['nos_listado']['influencia_precio_total']=0;
						
						$_SESSION['nos_listado']['influencia_financiacion'][3]+=$_SESSION['nos_listado']['influencia_financiacion'][0];
						$_SESSION['nos_listado']['influencia_financiacion_total']=0;
						
						$_SESSION['nos_listado']['influencia_garantia'][3]+=$_SESSION['nos_listado']['influencia_garantia'][0];
						$_SESSION['nos_listado']['influencia_garantia_total']=0;
						
						$_SESSION['nos_listado']['influencia_modelo'][3]+=$_SESSION['nos_listado']['influencia_modelo'][0];
						$_SESSION['nos_listado']['influencia_modelo_total']=0;
						
						$_SESSION['nos_listado']['influencia_empresa'][3]+=$_SESSION['nos_listado']['influencia_empresa'][0];
						$_SESSION['nos_listado']['influencia_empresa_total']=0;
						
						$_SESSION['nos_listado']['influencia_disenio'][3]+=$_SESSION['nos_listado']['influencia_disenio'][0];
						$_SESSION['nos_listado']['influencia_disenio_total']=0;
						
						$_SESSION['nos_listado']['influencia_comodidad'][3]+=$_SESSION['nos_listado']['influencia_comodidad'][0];
						$_SESSION['nos_listado']['influencia_comodidad_total']=0;
						
						$_SESSION['nos_listado']['influencia_practicidad'][3]+=$_SESSION['nos_listado']['influencia_practicidad'][0];
						$_SESSION['nos_listado']['influencia_practicidad_total']=0;
						
						$_SESSION['nos_listado']['influencia_seguridad'][3]+=$_SESSION['nos_listado']['influencia_seguridad'][0];
						$_SESSION['nos_listado']['influencia_seguridad_total']=0;
						
						$_SESSION['nos_listado']['influencia_confiabilidad'][3]+=$_SESSION['nos_listado']['influencia_confiabilidad'][0];
						$_SESSION['nos_listado']['influencia_confiabilidad_total']=0;
						
						$_SESSION['nos_listado']['influencia_longevidad'][3]+=$_SESSION['nos_listado']['influencia_longevidad'][0];
						$_SESSION['nos_listado']['influencia_longevidad_total']=0;
						
						$_SESSION['nos_listado']['influencia_prestigio'][3]+=$_SESSION['nos_listado']['influencia_prestigio'][0];
						$_SESSION['nos_listado']['influencia_prestigio_total']=0;
						
						$_SESSION['nos_listado']['influencia_calidad'][3]+=$_SESSION['nos_listado']['influencia_calidad'][0];
						$_SESSION['nos_listado']['influencia_calidad_total']=0;
						
						$_SESSION['nos_listado']['influencia_disponibilidad'][3]+=$_SESSION['nos_listado']['influencia_disponibilidad'][0];
						$_SESSION['nos_listado']['influencia_disponibilidad_total']=0;
						
						$_SESSION['nos_listado']['influencia_accesorios'][3]+=$_SESSION['nos_listado']['influencia_accesorios'][0];
						$_SESSION['nos_listado']['influencia_accesorios_total']=0;
						
						$_SESSION['nos_listado']['influencia_servicio'][3]+=$_SESSION['nos_listado']['influencia_servicio'][0];
						$_SESSION['nos_listado']['influencia_servicio_total']=0;
				
						for($n=1;$n<=3;$n++)
						{
							$_SESSION['nos_listado']['influencia_estilo_total']+=
												$_SESSION['nos_listado']['influencia_estilo'][$n];
							$_SESSION['nos_listado']['influencia_tamanio_total']+=
												$_SESSION['nos_listado']['influencia_tamanio'][$n];
							$_SESSION['nos_listado']['influencia_potencia_total']+=
												$_SESSION['nos_listado']['influencia_potencia'][$n];
							$_SESSION['nos_listado']['influencia_respuesta_total']+=
												$_SESSION['nos_listado']['influencia_respuesta'][$n];
							$_SESSION['nos_listado']['influencia_maniobrabilidad_total']+=
												$_SESSION['nos_listado']['influencia_maniobrabilidad'][$n];
							$_SESSION['nos_listado']['influencia_economia_total']+=
												$_SESSION['nos_listado']['influencia_economia'][$n];
							$_SESSION['nos_listado']['influencia_precio_total']+=
												$_SESSION['nos_listado']['influencia_precio'][$n];
							$_SESSION['nos_listado']['influencia_financiacion_total']+=
												$_SESSION['nos_listado']['influencia_financiacion'][$n];
							$_SESSION['nos_listado']['influencia_garantia_total']+=
												$_SESSION['nos_listado']['influencia_garantia'][$n];
							$_SESSION['nos_listado']['influencia_modelo_total']+=
												$_SESSION['nos_listado']['influencia_modelo'][$n];
							$_SESSION['nos_listado']['influencia_empresa_total']+=
												$_SESSION['nos_listado']['influencia_empresa'][$n];
							$_SESSION['nos_listado']['influencia_disenio_total']+=
												$_SESSION['nos_listado']['influencia_disenio'][$n];
							$_SESSION['nos_listado']['influencia_comodidad_total']+=
												$_SESSION['nos_listado']['influencia_comodidad'][$n];
							$_SESSION['nos_listado']['influencia_practicidad_total']+=
												$_SESSION['nos_listado']['influencia_practicidad'][$n];
							$_SESSION['nos_listado']['influencia_seguridad_total']+=
												$_SESSION['nos_listado']['influencia_seguridad'][$n];
							$_SESSION['nos_listado']['influencia_confiabilidad_total']+=
												$_SESSION['nos_listado']['influencia_confiabilidad'][$n];
							$_SESSION['nos_listado']['influencia_longevidad_total']+=
												$_SESSION['nos_listado']['influencia_longevidad'][$n];
							$_SESSION['nos_listado']['influencia_prestigio_total']+=
												$_SESSION['nos_listado']['influencia_prestigio'][$n];
							$_SESSION['nos_listado']['influencia_calidad_total']+=
												$_SESSION['nos_listado']['influencia_calidad'][$n];
							$_SESSION['nos_listado']['influencia_disponibilidad_total']+=
												$_SESSION['nos_listado']['influencia_disponibilidad'][$n];
							$_SESSION['nos_listado']['influencia_accesorios_total']+=
												$_SESSION['nos_listado']['influencia_accesorios'][$n];
							$_SESSION['nos_listado']['influencia_servicio_total']+=
												$_SESSION['nos_listado']['influencia_servicio'][$n];
						}
						for($n=1;$n<=3;$n++)
						{
							$_SESSION['nos_listado']['influencia_estilo'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_estilo'][$n]*100)/$_SESSION['nos_listado']['influencia_estilo_total']);
							
							$_SESSION['nos_listado']['influencia_tamanio'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_tamanio'][$n]*100)/$_SESSION['nos_listado']['influencia_tamanio_total']);
							
							$_SESSION['nos_listado']['influencia_potencia'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_potencia'][$n]*100)/$_SESSION['nos_listado']['influencia_potencia_total']);
							
							$_SESSION['nos_listado']['influencia_respuesta'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_respuesta'][$n]*100)/$_SESSION['nos_listado']['influencia_respuesta_total']);
							
							$_SESSION['nos_listado']['influencia_maniobrabilidad'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_maniobrabilidad'][$n]*100)/$_SESSION['nos_listado']['influencia_maniobrabilidad_total']);
							
							$_SESSION['nos_listado']['influencia_economia'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_economia'][$n]*100)/$_SESSION['nos_listado']['influencia_economia_total']);
							
							$_SESSION['nos_listado']['influencia_precio'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_precio'][$n]*100)/$_SESSION['nos_listado']['influencia_precio_total']);
							
							$_SESSION['nos_listado']['influencia_financiacion'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_financiacion'][$n]*100)/$_SESSION['nos_listado']['influencia_financiacion_total']);
							
							$_SESSION['nos_listado']['influencia_garantia'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_garantia'][$n]*100)/$_SESSION['nos_listado']['influencia_garantia_total']);
							
							$_SESSION['nos_listado']['influencia_modelo'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_modelo'][$n]*100)/$_SESSION['nos_listado']['influencia_modelo_total']);
							
							$_SESSION['nos_listado']['influencia_empresa'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_empresa'][$n]*100)/$_SESSION['nos_listado']['influencia_empresa_total']);
							
							$_SESSION['nos_listado']['influencia_disenio'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_disenio'][$n]*100)/$_SESSION['nos_listado']['influencia_disenio_total']);
							
							$_SESSION['nos_listado']['influencia_comodidad'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_comodidad'][$n]*100)/$_SESSION['nos_listado']['influencia_comodidad_total']);
							
							$_SESSION['nos_listado']['influencia_practicidad'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_practicidad'][$n]*100)/$_SESSION['nos_listado']['influencia_practicidad_total']);
							
							$_SESSION['nos_listado']['influencia_seguridad'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_seguridad'][$n]*100)/$_SESSION['nos_listado']['influencia_seguridad_total']);
							
							$_SESSION['nos_listado']['influencia_confiabilidad'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_confiabilidad'][$n]*100)/$_SESSION['nos_listado']['influencia_confiabilidad_total']);
							
							$_SESSION['nos_listado']['influencia_longevidad'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_longevidad'][$n]*100)/$_SESSION['nos_listado']['influencia_longevidad_total']);
							
							$_SESSION['nos_listado']['influencia_prestigio'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_prestigio'][$n]*100)/$_SESSION['nos_listado']['influencia_prestigio_total']);
							
							$_SESSION['nos_listado']['influencia_calidad'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_calidad'][$n]*100)/$_SESSION['nos_listado']['influencia_calidad_total']);
							
							$_SESSION['nos_listado']['influencia_disponibilidad'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_disponibilidad'][$n]*100)/$_SESSION['nos_listado']['influencia_disponibilidad_total']);
							
							$_SESSION['nos_listado']['influencia_accesorios'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_accesorios'][$n]*100)/$_SESSION['nos_listado']['influencia_accesorios_total']);
							
							$_SESSION['nos_listado']['influencia_servicio'][$n] =  $this->_nf(($_SESSION['nos_listado']['influencia_servicio'][$n]*100)/$_SESSION['nos_listado']['influencia_servicio_total']);
							
							
						}
						$graph = new Graph(600,350,"auto");
							$graph->SetScale('textlin',0,100);
							$graph->img->SetMargin(55,110,35,150); //margenes
							$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); //fuente eje x
							$graph->xaxis->SetLabelAngle(60); //angulo de la data
							$graph->SetMarginColor("#ffffff"); //color del margen
							$graph->legend->Pos(0.02,0.15); //posicion de la legenda
							$graph->title->Set('Influencia (%)');
							$graph->title->SetMargin(3);
							$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
							$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
							$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
							$graph->xaxis->SetTickLabels(array(
								"Diseño / estilo exterior",
								"Tamaño",
								"Potencia",
								"Respuesta",
								"Maniobrabilidad",
								"Economía del combustible",
								"Precio",
								"Términos del prestamo",
								"Período / Términos de Garantía",
								"Reputación del modelo",
								"Reputación de la compañia",
								"Diseño / estilo interior",
								"Comodidad",
								"Caracter Práctico",
								"Características de seguridad",
								"Confiabilidad",
								"Longevidad",
								"Prestigio",
								"Calidad de los repuestos",
								"Disponibilidad de los respuestos",
								"Opciónes / accesorios",
								"Servicio del Concesionario")); //asigna data a los labels
							$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_2') ,BGIMG_COPY);
							
							//ns/nc
							$b0plot = new BarPlot(array(
								$_SESSION['nos_listado']['influencia_estilo'][3],
								$_SESSION['nos_listado']['influencia_tamanio'][3],
								$_SESSION['nos_listado']['influencia_potencia'][3],
								$_SESSION['nos_listado']['influencia_respuesta'][3],
								$_SESSION['nos_listado']['influencia_maniobrabilidad'][3],
								$_SESSION['nos_listado']['influencia_economia'][3],
								$_SESSION['nos_listado']['influencia_precio'][3],
								$_SESSION['nos_listado']['influencia_financiacion'][3],
								$_SESSION['nos_listado']['influencia_garantia'][3],
								$_SESSION['nos_listado']['influencia_modelo'][3],
								$_SESSION['nos_listado']['influencia_empresa'][3],
								$_SESSION['nos_listado']['influencia_disenio'][3],
								$_SESSION['nos_listado']['influencia_comodidad'][3],
								$_SESSION['nos_listado']['influencia_practicidad'][3],
								$_SESSION['nos_listado']['influencia_seguridad'][3],
								$_SESSION['nos_listado']['influencia_confiabilidad'][3],
								$_SESSION['nos_listado']['influencia_longevidad'][3],
								$_SESSION['nos_listado']['influencia_prestigio'][3],
								$_SESSION['nos_listado']['influencia_calidad'][3],
								$_SESSION['nos_listado']['influencia_disponibilidad'][3],
								$_SESSION['nos_listado']['influencia_accesorios'][3],
								$_SESSION['nos_listado']['influencia_servicio'][3]));
							$b0plot->SetFillColor($colores[0] . $this->config->item('jpgraph_2transparencia')); //
							$b0plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
								//$b0plot->value->Show();
								$b0plot->SetValuePos('center'); //posicion del valor
								$b0plot->value->SetFont(FF_ARIAL,FS_NORMAL,7);
								$b0plot->SetLegend('Ns/Nc');
							
							$b2plot = new BarPlot(array(
								$_SESSION['nos_listado']['influencia_estilo'][2],
								$_SESSION['nos_listado']['influencia_tamanio'][2],
								$_SESSION['nos_listado']['influencia_potencia'][2],
								$_SESSION['nos_listado']['influencia_respuesta'][2],
								$_SESSION['nos_listado']['influencia_maniobrabilidad'][2],
								$_SESSION['nos_listado']['influencia_economia'][2],
								$_SESSION['nos_listado']['influencia_precio'][2],
								$_SESSION['nos_listado']['influencia_financiacion'][2],
								$_SESSION['nos_listado']['influencia_garantia'][2],
								$_SESSION['nos_listado']['influencia_modelo'][2],
								$_SESSION['nos_listado']['influencia_empresa'][2],
								$_SESSION['nos_listado']['influencia_disenio'][2],
								$_SESSION['nos_listado']['influencia_comodidad'][2],
								$_SESSION['nos_listado']['influencia_practicidad'][2],
								$_SESSION['nos_listado']['influencia_seguridad'][2],
								$_SESSION['nos_listado']['influencia_confiabilidad'][2],
								$_SESSION['nos_listado']['influencia_longevidad'][2],
								$_SESSION['nos_listado']['influencia_prestigio'][2],
								$_SESSION['nos_listado']['influencia_calidad'][2],
								$_SESSION['nos_listado']['influencia_disponibilidad'][2],
								$_SESSION['nos_listado']['influencia_accesorios'][2],
								$_SESSION['nos_listado']['influencia_servicio'][2]));
							$b2plot->SetFillColor($colores[2] . $this->config->item('jpgraph_2transparencia')); //
							$b2plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
								//$b0plot->value->Show();
								$b2plot->SetValuePos('center'); //posicion del valor
								$b2plot->value->SetFont(FF_ARIAL,FS_NORMAL,7);
								$b2plot->SetLegend('Secundario');
								
								
							$b1plot = new BarPlot(array(
								$_SESSION['nos_listado']['influencia_estilo'][1],
								$_SESSION['nos_listado']['influencia_tamanio'][1],
								$_SESSION['nos_listado']['influencia_potencia'][1],
								$_SESSION['nos_listado']['influencia_respuesta'][1],
								$_SESSION['nos_listado']['influencia_maniobrabilidad'][1],
								$_SESSION['nos_listado']['influencia_economia'][1],
								$_SESSION['nos_listado']['influencia_precio'][1],
								$_SESSION['nos_listado']['influencia_financiacion'][1],
								$_SESSION['nos_listado']['influencia_garantia'][1],
								$_SESSION['nos_listado']['influencia_modelo'][1],
								$_SESSION['nos_listado']['influencia_empresa'][1],
								$_SESSION['nos_listado']['influencia_disenio'][1],
								$_SESSION['nos_listado']['influencia_comodidad'][1],
								$_SESSION['nos_listado']['influencia_practicidad'][1],
								$_SESSION['nos_listado']['influencia_seguridad'][1],
								$_SESSION['nos_listado']['influencia_confiabilidad'][1],
								$_SESSION['nos_listado']['influencia_longevidad'][1],
								$_SESSION['nos_listado']['influencia_prestigio'][1],
								$_SESSION['nos_listado']['influencia_calidad'][1],
								$_SESSION['nos_listado']['influencia_disponibilidad'][1],
								$_SESSION['nos_listado']['influencia_accesorios'][1],
								$_SESSION['nos_listado']['influencia_servicio'][1]));
							$b1plot->SetFillColor($colores[1] . $this->config->item('jpgraph_2transparencia')); //
							$b1plot->SetShadow($this->config->item('jpgraph_2sombra') . $this->config->item('jpgraph_2transparencia'));
								//$b0plot->value->Show();
								$b1plot->SetValuePos('center'); //posicion del valor
								$b1plot->value->SetFont(FF_ARIAL,FS_NORMAL,7);
								$b1plot->SetLegend('Importante');

							$gbplot = new AccBarPlot(array($b1plot,$b2plot,$b0plot));
							$graph->Add($gbplot);
							$graph->Stroke($this->config->item('jpgraph_write') ."influencia_".$_SESSION['nos_listado']['tmp_images'].".png");
							unset($graph);
						//---------------[influencia]
						
						//---------------[comparo]
						for($i = 0;$i<=2;$i++)
						{
							$_SESSION['nos_listado']['comparo'][$i] = $this->_nf(($_SESSION['nos_listado']['comparo'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						
						$graph = new PieGraph(300,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,30,35,50); //margenes
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Comparó con otros modelos');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_1') ,BGIMG_COPY);
						// Create 3D pie plot
						$p1 = new PiePlot3d(array(
									$_SESSION['nos_listado']['comparo'][2],
									$_SESSION['nos_listado']['comparo'][1]));
						$p1->SetEdge("#000000");
						$p1->SetTheme("pastel");
						//$p1->SetCenter(0.4);
						$p1->SetSize(0.3);
						$p1->SetHeight(15);
						$p1->SetAngle(45);
						$p1->Explode(array(15,15));
						$p1->value->SetFont(FF_ARIAL,FS_NORMAL,10);
						$p1->SetLegends(array('Sí','No'));

						$graph->Add($p1);
						$graph->Stroke($this->config->item('jpgraph_write') ."comparo_".$_SESSION['nos_listado']['tmp_images'].".png");
						//---------------[comparo]
						
						//---------------[primer auto]
						for($i = 0;$i<=2;$i++)
						{
							$_SESSION['nos_listado']['primer_automovil'][$i] = $this->_nf(($_SESSION['nos_listado']['primer_automovil'][$i]*100)/$_SESSION['nos_listado']['registros_encontrados']);
						}
						$graph = new PieGraph(300,300,"auto");
						$graph->SetScale('textlin',0,100);
						$graph->img->SetMargin(30,30,35,50); //margenes
						$graph->SetMarginColor("#ffffff"); //color del margen
						$graph->legend->Pos(0.02,0.15); //posicion de la legenda
						$graph->title->Set('Es este su primer automóvil');
						$graph->title->SetMargin(3);
						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);
						$graph->SetBackgroundImage( $this->config->item('jpgraph_2back_1') ,BGIMG_COPY);
						// Create 3D pie plot
						$p1 = new PiePlot3d(array(
												$_SESSION['nos_listado']['primer_automovil'][2],
												$_SESSION['nos_listado']['primer_automovil'][1]
											));
						$p1->SetEdge("#000000");
						$p1->SetTheme("pastel");
						//$p1->SetCenter(0.4);
						$p1->SetSize(0.3);
						$p1->SetHeight(15);
						$p1->SetAngle(45);
						$p1->Explode(array(15,15));
						$p1->value->SetFont(FF_ARIAL,FS_NORMAL,10);
						$p1->SetLegends(array('Sí','No'));

						$graph->Add($p1);
						$graph->Stroke($this->config->item('jpgraph_write') ."primer_automovil_".$_SESSION['nos_listado']['tmp_images'].".png");
	}
}
