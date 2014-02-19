<?php
define('ID_SECCION',3012);

class Tarjeta_Garantia_main extends Backend_Controller {
	
	//solo para aca, cantidad de dias de los ultimos registros
	var $dias_default = 180;
	
	//filtra por sucursal?
	var $sucursal = TRUE;

	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
		
		
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array('MATCH( 
												unidad_field_unidad,
												unidad_field_vin,
												unidad_field_descripcion_sap,
												cliente_field_numero_documento,
												cliente_sucursal_field_nombre,
												cliente_sucursal_field_nombre,
												cliente_sucursal_field_razon_social,
												cliente_sucursal_field_email,
												cliente_sucursal_field_direccion_calle,
												ciudad_field_desc,
												provincia_field_desc,
												cliente_sucursal_field_localidad_aux
										) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para filtrar
		
		
		//solo para reporte
		'excluir_cambio_propietario'=>
			array(
				 'sql_filter'	=>array('tarjeta_garantia_field_fecha_entrega = unidad_field_fecha_entrega AND "fruta" != ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		
		//solo para reporte
		'fecha_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tarjeta_garantia_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		
		//solo para reporte
		'fecha_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(tarjeta_garantia_field_fechahora_alta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para reporte
		'fecha_entrega_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tarjeta_garantia_field_fecha_entrega) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		//solo para reporte
		'fecha_entrega_final'=>
			array(
				 'sql_filter'	=>array('DATE(tarjeta_garantia_field_fecha_entrega) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//solo para reporte
		'cliente'=>
			array(
				 'sql_filter'	=>array('MATCH( cliente_sucursal_field_nombre,cliente_sucursal_field_apellido,cliente_sucursal_field_razon_social ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		
		
		'unidad_field_unidad'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_vin'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>110,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_motor'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>90,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'tarjeta_garantia_field_fecha_entrega'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'sucursal_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
		'unidad_field_patente'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>70,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
		'unidad_estado_garantia_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_motivo_garantia_anulada'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),

		'unidad_codigo_interno_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_codigo_interno_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'cliente_codigo_interno_id'=>
			array(
				'sql_filter'	=>array(),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'cliente_codigo_interno_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
		'tarjeta_garantia_estado_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'auto_modelo_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE,		
			),
		
		
		
		
			
			
		'auto_modelo_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'auto_version_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		
		'auto_version_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		//solo reporte
		'auto_transmision_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'auto_transmision_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
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
		
		'auto_anio_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_material_sap'=>
			array(
				  'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
		'unidad_field_descripcion_sap'=>
			array(
				  'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_oblea'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_certificado'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_formulario_12'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_formulario_01'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
		'unidad_field_codigo_de_llave'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
		'unidad_field_codigo_de_radio'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
			
		'cliente_sucursal_field_razon_social'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_nombre'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		'cliente_sucursal_field_apellido'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'cliente_conformidad_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
			
		'cliente_conformidad_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'documento_tipo_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		
		'cliente_field_numero_documento'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_direccion_calle'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_direccion_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_direccion_piso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_direccion_depto'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_direccion_codigo_postal'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_telefono_particular_codigo'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_telefono_particular_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_telefono_laboral_codigo'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_telefono_laboral_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_telefono_movil_codigo'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_telefono_movil_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_fax_codigo'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		'cliente_sucursal_field_fax_numero'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_email'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		

		'sexo_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'sexo_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		
		'cliente_sucursal_field_fecha_nacimiento'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		
		//por aca
		
		
		
		'tarjeta_garantia_field_vendedor_nombre_aux'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
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
			
		'tarjeta_garantia_estado_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE,		
			),
		
		'tarjeta_garantia_field_fechahora_alta'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		);			
			
	function Tarjeta_Garantia_main()
	{
		parent::Backend_Controller();
		if($this->session->userdata('show_unidad_codigo_interno') != TRUE)
		{
			unset($this->default_valid_fields['unidad_codigo_interno_id']);
			unset($this->default_valid_fields['unidad_codigo_interno_field_desc']);
		}
		if($this->session->userdata('show_cliente_codigo_interno') != TRUE)
		{
			unset($this->default_valid_fields['cliente_codigo_interno_id']);
			unset($this->default_valid_fields['cliente_codigo_interno_field_desc']);
		}
	}


	function index()
	{	
		//-------------------------[buscador ]
		
		$config['campos'] = $this->default_valid_fields;
		
		//borramos en caso de que haya algun filtro previo
		$this->session->unset_userdata('filtro_'.$this->router->class);
		$this->session->unset_userdata('excluir_codigo_interno'.$this->router->class);
				
		//->filtros del buscador por post
			if($this->input->post('_filtro'))
			{
				if($this->input->post('cliente_codigo_interno_id'))
				{
					$this->session->set_userdata('excluir_codigo_interno'.$this->router->class,$this->input->post('cliente_codigo_interno_id'));
				}
				
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
			/*
			$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
			$desde_fecha = date('Y-m-d', $dia); //Formatea dia
			$this->query->AddWhere("TARJETA_GARANTIA.tarjeta_garantia_field_fechahora_alta>=?",$desde_fecha);
			*/
			
			$rg = new Tarjeta_Garantia();
			$this->query = $rg->get_grid();
			$this->query->whereIn('TARJETA_GARANTIA.sucursal_id',$this->session->userdata('sucursales'));
			$this->flexigrid->validate_post();
			$this->flexigrid->build_query();
			
			
		}
		//------[PARCHE]
		//$this->query->whereIn('SUCURSAL.id',$this->session->userdata('sucursales'));
		
		if($this->session->userdata('excluir_codigo_interno'.$this->router->class))
		{
			$this->query->addWhere('(MANY_CLIENTE_CODIGO_INTERNO.id IS NULL OR MANY_CLIENTE_CODIGO_INTERNO.id NOT IN ?)  ',$this->session->userdata('excluir_codigo_interno'.$this->router->class) );
		}
		
		//echo $this->query->getSqlQuery();
		//print_r( $this->query->getParams());
		
		$total = $this->query->count();
		
		$this->query->limit($this->post_info['rp']);
		$this->query->offset(($this->post_info['page'] - 1)*$this->post_info['rp']);
		$this->query->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
		
		try {
			$resultado=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			//$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}
		$record_items = array();
		foreach ($resultado as $row)
		{
			$record_items[] = $this->_create_grid_data($row,$config['campos']);
		}
		
		//Print please
		//$this->output->enable_profiler();
		$this->output->set_header($this->config->item('json_header'));
		$this->output->set_output($this->flexigrid->json_build($total,$record_items));
		//-------------------------[/escribe la grilla]
	}
		
	
	//exporta registros a xls
	function export()
	{
		
		//pdf xls
		$this->load->library('ofimatica');
		
		//nombre de las fields que exporta
		$config['campos']	=	$this->default_valid_fields;
		$config['registros_por_query'] = $this->ofimatica->get_records_per_query();
		
		
		$export_fields = array();
		reset($config['campos']);
		while (list($field_name,$val) = each ($config['campos']))
		{
			if(isset($val['export']) && $val['export'] === TRUE)
			{
				$export_fields[] = $field_name;
			}		
		}
		
		
		//creo archivo base
		$this->ofimatica->make_file();
		
		//agrego fila
		$this->ofimatica->add_row();
		/*
		reset($export_fields);
		while(list(,$field_name)=each($export_fields))
		{
			$this->ofimatica->add_header( $this->marvin->mysql_field_to_human($field_name),$val['width'] );
		}
		*/
		// a mano
		
		$this->ofimatica->add_header( lang('unidad') ,100 );
		$this->ofimatica->add_header( lang('vin') ,100 );
		$this->ofimatica->add_header( lang('motor') ,100 );
		$this->ofimatica->add_header( lang('fecha_entrega') ,100 );
		$this->ofimatica->add_header( lang('sucursal_id') ,100 );
		$this->ofimatica->add_header( lang('patente') ,100 );
		$this->ofimatica->add_header( lang('unidad_estado_garantia_id') ,100 );
		$this->ofimatica->add_header( lang('motivo_garantia_anulada') ,100 );
		if($this->session->userdata('show_unidad_codigo_interno') === TRUE)
		{
			$this->ofimatica->add_header( lang('unidad_codigo_interno_id') ,100 );
		}
		if($this->session->userdata('show_cliente_codigo_interno') === TRUE)
		{
			$this->ofimatica->add_header( lang('cliente_codigo_interno_id') ,100 );
		}
		$this->ofimatica->add_header( lang('tarjeta_garantia_estado_id') ,100 );
		$this->ofimatica->add_header( lang('auto_modelo_id') ,100 );
		$this->ofimatica->add_header( lang('auto_version_id') ,100 );
		$this->ofimatica->add_header( lang('auto_transmision_id') ,100 );
		$this->ofimatica->add_header( lang('auto_anio_id') ,100 );
		$this->ofimatica->add_header( lang('unidad_color_exterior_id') ,100 );
		$this->ofimatica->add_header( lang('auto_puerta_cantidad_id') ,100 );
		$this->ofimatica->add_header( lang('ktype') ,100 );
		$this->ofimatica->add_header( lang('material_sap') ,100 );
		$this->ofimatica->add_header( lang('descripcion_sap') ,100 );
		$this->ofimatica->add_header( lang('oblea') ,100 );
		$this->ofimatica->add_header( lang('certificado') ,100 );
		$this->ofimatica->add_header( lang('formulario_01') ,100 );
		$this->ofimatica->add_header( lang('formulario_12') ,100 );
		$this->ofimatica->add_header( lang('codigo_de_llave') ,100 );
		$this->ofimatica->add_header( lang('codigo_de_radio') ,100 );
		$this->ofimatica->add_header( lang('tratamiento_id') ,100 );
		$this->ofimatica->add_header( lang('razon_social') ,100 );
		$this->ofimatica->add_header( lang('nombre') ,100 );
		$this->ofimatica->add_header( lang('apellido') ,100 );
		$this->ofimatica->add_header( lang('cliente_conformidad_id') ,100 );
		$this->ofimatica->add_header( lang('documento_tipo_id') ,100 );
		$this->ofimatica->add_header( lang('numero_documento') ,100 );
		$this->ofimatica->add_header( lang('direccion_calle') ,100 );
		$this->ofimatica->add_header( lang('direccion_numero') ,100 );
		$this->ofimatica->add_header( lang('direccion_piso') ,100 );
		$this->ofimatica->add_header( lang('direccion_depto') ,100 );
		$this->ofimatica->add_header( lang('provincia_id') ,100 );
		$this->ofimatica->add_header( lang('ciudad_id') ,100 );
		$this->ofimatica->add_header( lang('ciudad_id') ,100 );
		$this->ofimatica->add_header( lang('direccion_codigo_postal') ,100 );
		$this->ofimatica->add_header( lang('telefono_particular') . ' ' . lang('telefono_particular_codigo')  ,100 );
		$this->ofimatica->add_header( lang('telefono_particular') . ' ' . lang('telefono_particular_numero'),100 );
		$this->ofimatica->add_header( lang('telefono_laboral') . ' ' . lang('telefono_laboral_codigo') ,100 );
		$this->ofimatica->add_header( lang('telefono_laboral') . ' ' . lang('telefono_laboral_numero'),100 );
		$this->ofimatica->add_header( lang('telefono_movil') . ' ' . lang('telefono_movil_codigo'),100 );
		$this->ofimatica->add_header( lang('telefono_movil') . ' ' . lang('telefono_movil_codigo') ,100 );
		$this->ofimatica->add_header( lang('fax') . ' ' . lang('fax_codigo') ,100 );
		$this->ofimatica->add_header( lang('fax') . ' ' . lang('fax_numero'),100 );
		$this->ofimatica->add_header( lang('email') ,100 );
		$this->ofimatica->add_header( lang('sexo_id') ,100 );
		$this->ofimatica->add_header( lang('fecha_nacimiento') ,100 );
		$this->ofimatica->add_header( lang('vendedor_nombre_aux') ,100 );
		$this->ofimatica->add_header( lang('admin_vende_id') . ' ' . lang('nombre') ,100 );
		$this->ofimatica->add_header( lang('admin_vende_id') . ' ' . lang('apellido') ,100 );
		$this->ofimatica->add_header( lang('fechahora_alta') ,100 );
		$this->ofimatica->add_header( lang('usuario') ,100 );
		
		$this->_create_query();
		
		//-------[PARCHE]
		//si no envio data desde el reporte mostramos los primeros x registros
		if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
		{
			$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
			$desde_fecha = date('Y-m-d', $dia); //Formatea dia
			$this->query->AddWhere("TARJETA_GARANTIA.tarjeta_garantia_field_fechahora_alta>=?",$desde_fecha);
		}
		//------[PARCHE]
		
		if($this->session->userdata('excluir_codigo_interno'.$this->router->class))
		{
			$this->query->addWhere('(MANY_CLIENTE_CODIGO_INTERNO.id IS NULL OR MANY_CLIENTE_CODIGO_INTERNO.id NOT IN ?)  ',$this->session->userdata('excluir_codigo_interno'.$this->router->class) );
		}
		
		$total = $this->query->count();
		$max = $this->ofimatica->get_export_max_rows();
		#vamos a aprobechar la limitacion del xls para ahorrrar memoria
		if($max>0 && $total>$max)	$total=$max;	
		
		$cantidad_querys=ceil($total/$config['registros_por_query']);
		//$cantidad_querys=1;
		for($pagina=0;$pagina<$cantidad_querys;$pagina++){
			//el hydrate, tuve que separar las querys parece que no queda otra amigo
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT\n"); //le voy tirando headers para q no salga por time out
			$this->_create_query();
			//-------[PARCHE]
			//si no envio data desde el reporte mostramos los primeros x registros
			if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
			{
				$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
				$desde_fecha = date('Y-m-d', $dia); //Formatea dia
				$this->query->AddWhere("TARJETA_GARANTIA.tarjeta_garantia_field_fechahora_alta>=?",$desde_fecha);
			}
			//------[PARCHE]
			$this->query->limit($config['registros_por_query']);
			$this->query->offset($pagina*$config['registros_por_query']);
			$this->query->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
			
			$result=$this->query->execute(array());
			$this->query->free();
			
			foreach($result as $row)
			{
				
				
				$this->ofimatica->add_row();
				/*
			
				
				
				
				
				
				
				
			
				
				
				
				$this->ofimatica->add_header( lang('fechahora_alta') ,100 );
				$this->ofimatica->add_header( lang('usuario') ,100 );
				*/
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_unidad'] );
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_vin'] );				
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_motor'] );
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_fecha_entrega'] );					
				$this->ofimatica->add_data( $row['Sucursal']['sucursal_field_desc'] );					
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_patente'] );	
				$this->ofimatica->add_data( $row['Unidad']['Unidad_Estado_Garantia']['unidad_estado_garantia_field_desc'] );					
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_motivo_garantia_anulada']);
				if($this->session->userdata('show_unidad_codigo_interno') === TRUE)
				{
					$this->ofimatica->add_data( element('unidad_codigo_interno_field_desc', $row['Unidad']['Many_Unidad_Codigo_Interno']) );
				}
				if($this->session->userdata('show_cliente_codigo_interno') === TRUE)
				{
					$this->ofimatica->add_data( element('cliente_codigo_interno_field_desc', $row['Many_Cliente']) );
				}
				$this->ofimatica->add_data( $row['Tarjeta_Garantia_Estado']['tarjeta_garantia_estado_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Auto_Version']['Auto_Modelo']['auto_modelo_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Auto_Version']['auto_version_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Auto_Transmision']['auto_transmision_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Auto_Anio']['auto_anio_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Unidad_Color_Exterior']['unidad_color_exterior_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Auto_Puerta_Cantidad']['auto_puerta_cantidad_field_desc']);
				$this->ofimatica->add_data( $row['Unidad']['Vin_Procedencia_Ktype']['vin_procedencia_ktype_field_ktype']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_material_sap']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_descripcion_sap']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_oblea']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_certificado']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_formulario_12']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_formulario_01']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_codigo_de_llave']);
				$this->ofimatica->add_data( $row['Unidad']['unidad_field_codigo_de_radio']);
				$this->ofimatica->add_data( element('tratamiento_field_desc', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_razon_social', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_nombre', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_apellido', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_conformidad_field_desc', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('documento_tipo_field_desc', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_field_numero_documento', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_direccion_calle', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_direccion_numero', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_direccion_piso', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_direccion_depto', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('provincia_field_desc', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('ciudad_field_desc', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_localidad_aux', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_direccion_codigo_postal', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_telefono_particular_codigo', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_telefono_particular_numero', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_telefono_laboral_codigo', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_telefono_laboral_numero', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_telefono_movil_codigo', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_telefono_movil_numero', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_fax_codigo', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_fax_numero', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_email', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('sexo_field_desc', $row['Many_Cliente']) );
				$this->ofimatica->add_data( element('cliente_sucursal_field_fecha_nacimiento', $row['Many_Cliente']) );
				$this->ofimatica->add_data( $row['tarjeta_garantia_field_vendedor_nombre_aux']);
				$this->ofimatica->add_data( $row['Admin_Vende']['admin_field_nombre']);
				$this->ofimatica->add_data( $row['Admin_Vende']['admin_field_apellido']);
				$this->ofimatica->add_data( $row['tarjeta_garantia_field_fechahora_alta']);
				$this->ofimatica->add_data( $row['Admin_Alta']['admin_field_usuario']);
				
			}
		}
		
		$this->ofimatica->send_file('xls');
		//-------------------------[exporta la mostrada en la grilla a xls]
			
	}


	// validation fields
	private function _validar_filtros() {		
		//-------------------------[valida datos del buscador]
		// validation rules
		$this->form_validation->set_rules('_buscador_general',$this->marvin->mysql_field_to_human('_buscador_general'),
			'trim'
		);
		
		$this->form_validation->set_rules('tarjeta_garantia_field_vendedor_nombre_aux',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_vendedor_nombre_aux'),
			'trim'
		);
		$this->form_validation->set_rules('fecha_alta_inicial',$this->marvin->mysql_field_to_human('fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_alta_final',$this->marvin->mysql_field_to_human('fechahora_alta_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_entrega_inicial',$this->marvin->mysql_field_to_human('fecha_entrega_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('fecha_entrega_final',$this->marvin->mysql_field_to_human('fecha_entrega_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_motor',$this->marvin->mysql_field_to_human('unidad_field_motor'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_patente',$this->marvin->mysql_field_to_human('unidad_field_patente'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_codigo_de_radio',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_radio'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_material_sap',$this->marvin->mysql_field_to_human('unidad_field_material_sap'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_descripcion_sap',$this->marvin->mysql_field_to_human('unidad_field_descripcion_sap'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_oblea',$this->marvin->mysql_field_to_human('unidad_field_oblea'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_certificado',$this->marvin->mysql_field_to_human('unidad_field_certificado'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_formulario_12',$this->marvin->mysql_field_to_human('unidad_field_formulario_12'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_formulario_01',$this->marvin->mysql_field_to_human('unidad_field_formulario_01'),
			'trim'
		);
		
		
		$this->form_validation->set_rules('cliente',$this->marvin->mysql_field_to_human('cliente'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_field_numero_documento',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_conformidad_id[]',$this->marvin->mysql_field_to_human('cliente_conformidad_id'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_codigo_interno_id[]',$this->marvin->mysql_field_to_human('unidad_codigo_interno_id'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_codigo_interno_id[]',$this->marvin->mysql_field_to_human('unidad_codigo_interno_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_modelo_id[]',$this->marvin->mysql_field_to_human('auto_modelo_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_version_id[]',$this->marvin->mysql_field_to_human('auto_version_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_transmision_id[]',$this->marvin->mysql_field_to_human('auto_transmision_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_anio_id[]',$this->marvin->mysql_field_to_human('auto_anio_id'),
			'trim'
		);
		$this->form_validation->set_rules('tarjeta_garantia_field_fecha',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_fecha'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_id[]',$this->marvin->mysql_field_to_human('unidad_id'),
			'trim'
		);
		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		$this->form_validation->set_rules('tarjeta_garantia_field_admin_alta_id[]',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_admin_alta_id'),
			'trim'
		);
		$this->form_validation->set_rules('tarjeta_garantia_field_admin_modifica_id[]',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_admin_modifica_id'),
			'trim'
		);
		$this->form_validation->set_rules('tarjeta_garantia_estado_id[]',$this->marvin->mysql_field_to_human('tarjeta_garantia_estado_id'),
			'trim'
		);
		
		$this->form_validation->set_rules('excluir_cambio_propietario',$this->marvin->mysql_field_to_human('excluir_cambio_propietario'),
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
		$q->WhereIn(' id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]
		
		/*
		//------------ [select / checkbox / radio tarjeta_garantia_field_admin_alta_id] :(
		$tarjeta_garantia_field_admin_alta=new Admin();
		$q = $tarjeta_garantia_field_admin_alta->get_all();
		$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tarjeta_garantia_field_admin_alta_field_desc');
		$config['select'] = FALSE;
		$this->template['tarjeta_garantia_field_admin_alta_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tarjeta_garantia_field_admin_alta_id]

		//------------ [select / checkbox / radio tarjeta_garantia_field_admin_modifica_id] :(
		$tarjeta_garantia_field_admin_modifica=new Admin();
		$q = $tarjeta_garantia_field_admin_modifica->get_all();
		$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tarjeta_garantia_field_admin_modifica_field_desc');
		$config['select'] = FALSE;
		$this->template['tarjeta_garantia_field_admin_modifica_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tarjeta_garantia_field_admin_modifica_id]
		*/
		//------------ [select / checkbox / radio tarjeta_garantia_estado_id] :(
		$tarjeta_garantia_estado=new Tarjeta_Garantia_Estado();
		$q = $tarjeta_garantia_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tarjeta_garantia_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['tarjeta_garantia_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tarjeta_garantia_estado_id]
		
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
		
		//------------ [select / checkbox / radio unidad_codigo_interno_id] :(
		$unidad_codigo_interno=new Unidad_Codigo_Interno();
		$q = $unidad_codigo_interno->get_all();
		$config=array();
		$config['fields'] = array('unidad_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['unidad_codigo_interno_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_codigo_interno_id]
		
		//------------ [select / checkbox / radio cliente_codigo_interno_id] :(
		$cliente_codigo_interno=new Cliente_Codigo_Interno();
		$q = $cliente_codigo_interno->get_all();
		$config=array();
		$config['fields'] = array('cliente_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['cliente_codigo_interno_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_codigo_interno_id]
		
		//------------ [select / checkbox / radio cliente_conformidad_id] :(
		$cliente_conformidad=new Cliente_Conformidad();
		$q = $cliente_conformidad->get_all();
		$config=array();
		$config['fields'] = array('cliente_conformidad_field_desc');
		$config['select'] = FALSE;
		$this->template['cliente_conformidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_conformidad_id]
		
		$this->template['excluir_cambio_propietario'] = array(''=>'',1=>lang('si'));
		
		
		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
