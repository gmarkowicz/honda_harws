<?php
define('ID_SECCION',3091);

class Unidad_Historico_Main extends Backend_Controller {
		
	//filtra por sucursal?
	var $sucursal = FALSE;
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
	
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(
										
										'MATCH( 
												unidad_field_unidad,
												unidad_field_vin,
												unidad_field_motor,
												unidad_field_codigo_de_llave,
												unidad_field_codigo_de_radio,
												unidad_field_patente
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
	
		'descripcion'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>130,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'sucursal_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'unidad_field_unidad'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'unidad_field_vin'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>120,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'unidad_field_motor'=>
			array(
				'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>80,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'unidad_field_patente'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'unidad_estado_garantia_field_desc'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'auto_modelo_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		'auto_anio_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'tsi_field_kilometros'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		'tsi_tipo_servicio_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'tsi_field_fecha_de_egreso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'cliente_sucursal_field_nombre'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		'cliente_sucursal_field_apellido'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		'cliente_sucursal_field_razon_social'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		'unidad_field_fecha_entrega'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
			
		'unidad_field_motivo_garantia_anulada'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'tarjeta_garantia_field_fecha_entrega'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		'unidad_field_codigo_de_llave'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'unidad_field_codigo_de_radio'=>
			array(
				 'sql_filter'	=>array('%THIS% = ?'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		
			
		
		'auto_transmision_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'auto_version_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'auto_puerta_cantidad_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'unidad_color_exterior_id'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		'unidad_color_exterior_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		'unidad_color_interior_id'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		'unidad_color_interior_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),
		
		
		
		
		
		
		
		

/*		
		//para descargar
		'unidad_adjunto'=>
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
			
			
	function Unidad_Historico_Main()
	{
		parent::Backend_Controller();
		/*
		if(!$this->backend->_permiso('admin'))
		{
			unset($this->default_valid_fields['cliente_sucursal_field_nombre']);
			unset($this->default_valid_fields['cliente_sucursal_field_apellido']);
			unset($this->default_valid_fields['cliente_sucursal_field_razon_social']);
		}
		*/
	}
	
	/*
		DONT DRY
		lo quieren para ayer (ser o no ser)
	*/
	
	function to_print()
	{
		$f = $this->session->userdata('filtro_'.$this->router->class);
		if(!$f)
			show_404();
		
		$record_items=array();
		
		$config['campos'] = $this->default_valid_fields;
		//agrego para que pueda filtrar por id
		$this->default_valid_fields['id']['sorteable'] = FALSE;
		
		$total = 0;
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//buscamos unidades.....
			$this->_create_query_unidad();
			$this->template['unidad']=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			
			
			//buscamos unidades.....
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//buscamos tarjetas de garantia.... 
			$this->_create_query_tarjeta_garantia();
			$this->template['tarjeta_garantia']=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			
			//buscamos tarjetas de garantia.... 
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//buscamos tsis.... 
			$this->_create_query_tsi();
			$this->template['tsi'] = $this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			
			//buscamos tarjetas de garantia.... 
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//buscamos libros de servicio.... 
			$this->_create_query_libro_servicio();
			$this->template['libro_servicio']=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			//buscamos libros de servicio....
			//------------------------------------------------------------------------------------------------
		}
		
		
		$this->load->view('backend/unidad_historico_main_print_view',$this->template);
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
			//------------------------------------------------------------------------------------------------
			//buscamos unidades.....
			$this->_create_query_unidad();
			$resultado=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$total += count($resultado);
			$aux = array();
			foreach ($resultado as $row)
			{
				
				//si esta anulada /observada se la resaltamos al usuario
				if(in_array($row['unidad_estado_garantia_id'],array(3,5)))
				{
					$row['Unidad_Estado_Garantia']['unidad_estado_garantia_field_desc'] = "<div class='highlight'><abbr title='".$row['unidad_field_motivo_garantia_anulada']."'>".$row['Unidad_Estado_Garantia']['unidad_estado_garantia_field_desc']."</abbr></div>";
				}
				$aux[] = $this->_create_grid_data($row,$config['campos']);
			}
			reset($aux);
			while(list($k,)=each($aux))
			{
				$string = '';
				if($this->backend->_permiso('view',1021))
				{
					$string .='<a href="'.site_url( $this->config->item('backend_root') . 'unidad_abm/show/' .$aux[$k][0] ).'" class="grid_link_view" title="ver" id="'.$aux[$k][0].'" target="_blank"><img src="'.site_url('public/images/icons/eye.png').'" alt="Ver"></a>';
				}
				if($this->backend->_permiso('edit',1021))
				{
					$string .='<a href="'.site_url( $this->config->item('backend_root') . 'unidad_abm/edit/' .$aux[$k][0] ).'" class="grid_link_view" title="ver" id="'.$aux[$k][0].'" target="_blank"><img src="'.site_url('public/images/icons/pencil.png').'" alt="Editar"></a>';
				}
				
				
				$aux[$k][2] = $string; 
				$aux[$k][3] = lang('unidad_id');
				$record_items[] = $aux[$k];
			}
			
			//buscamos unidades.....
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//buscamos tarjetas de garantia.... 
			$this->_create_query_tarjeta_garantia();
			$resultado=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$total += count($resultado);
			$aux = array();
			foreach ($resultado as $row)
			{
				$aux[] = $this->_create_grid_data($row,$config['campos']);
			}
			reset($aux);
			while(list($k,)=each($aux))
			{
				$string = '';
				if(in_array($resultado[$k]['sucursal_id'],$this->session->userdata('sucursales')))
				{
					//si puede manejar la sucursal lo dejo ingresar
					if($this->backend->_permiso('view',3012))
					{
						$string .='<a href="'.site_url( $this->config->item('backend_root') . 'tarjeta_garantia_abm/show/' .$aux[$k][0] ).'" class="grid_link_view" title="ver" id="'.$aux[$k][0].'" target="_blank"><img src="'.site_url('public/images/icons/eye.png').'" alt="Ver"></a>';
					}
					if($this->backend->_permiso('edit',3012))
					{
						$string .='<a href="'.site_url( $this->config->item('backend_root') . 'tarjeta_garantia_abm/edit/' .$aux[$k][0] ).'" class="grid_link_view" title="ver" id="'.$aux[$k][0].'" target="_blank"><img src="'.site_url('public/images/icons/pencil.png').'" alt="Editar"></a>';
					}
				}
					
				$aux[$k][2] = $string; 
				$aux[$k][3] = lang('tarjeta_garantia_id');
				$record_items[] = $aux[$k];
			
			}
			//buscamos tarjetas de garantia.... 
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//buscamos tsis.... 
			$this->_create_query_tsi();
			$resultado=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$total += count($resultado);
			$aux = array();
			foreach ($resultado as $row)
			{
				$aux[] = $this->_create_grid_data($row,$config['campos']);
			}
			reset($aux);
			while(list($k,)=each($aux))
			{
				
				$string = '';
				if(in_array($resultado[$k]['sucursal_id'],$this->session->userdata('sucursales')))
				{
					if($this->backend->_permiso('view',3021))
					{
						$string .='<a href="'.site_url( $this->config->item('backend_root') . 'tsi_abm/show/' .$aux[$k][0] ).'" class="grid_link_view" title="ver" id="'.$aux[$k][0].'" target="_blank"><img src="'.site_url('public/images/icons/eye.png').'" alt="Ver"></a>';
					}
					if($this->backend->_permiso('edit',3021))
					{
						$string .='<a href="'.site_url( $this->config->item('backend_root') . 'tsi_abm/edit/' .$aux[$k][0] ).'" class="grid_link_view" title="ver" id="'.$aux[$k][0].'" target="_blank"><img src="'.site_url('public/images/icons/pencil.png').'" alt="Editar"></a>';
					}
				}
				
				$aux[$k][2] = $string; 
				$aux[$k][3] = lang('tsi_id');
				$record_items[] = $aux[$k];
			
			}
			//buscamos tarjetas de garantia.... 
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//buscamos libros de servicio.... 
			$this->_create_query_libro_servicio();
			$resultado=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$total += count($resultado);
			$aux = array();
			foreach ($resultado as $row)
			{
				$row['cliente_sucursal_field_nombre'] = $row['libro_servicio_field_propietario_nombre'];
				$row['cliente_sucursal_field_apellido'] = $row['libro_servicio_field_propietario_apellido'];
				$row['cliente_sucursal_field_razon_social'] = $row['libro_servicio_field_propietario_razon_social'];
				$aux[] = $this->_create_grid_data($row,$config['campos']);
			}
			reset($aux);
			while(list($k,)=each($aux))
			{
				
				$string = '';
				if(in_array($resultado[$k]['sucursal_id'],$this->session->userdata('sucursales')))
				{
					if($this->backend->_permiso('view',3041))
					{
						$string .='<a href="'.site_url( $this->config->item('backend_root') . 'tsi_abm/show/' .$aux[$k][0] ).'" class="grid_link_view" title="ver" id="'.$aux[$k][0].'" target="_blank"><img src="'.site_url('public/images/icons/eye.png').'" alt="Ver"></a>';
					}
					if($this->backend->_permiso('edit',3041))
					{
						$string .='<a href="'.site_url( $this->config->item('backend_root') . 'tsi_abm/edit/' .$aux[$k][0] ).'" class="grid_link_view" title="ver" id="'.$aux[$k][0].'" target="_blank"><img src="'.site_url('public/images/icons/pencil.png').'" alt="Editar"></a>';
					}
				}
				
				
				$aux[$k][2] = $string; 
				$aux[$k][3] = lang('libro_servicio_id');
				$record_items[] = $aux[$k];
			
			}
			//buscamos libros de servicio....
			//------------------------------------------------------------------------------------------------
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
		
		$this->load->library('ofimatica');
		$config['campos']	=	$this->default_valid_fields;
		
		$f = $this->session->userdata('filtro_'.$this->router->class);
		if(!$f)
		{
			$this->flexigrid->validate_post();
		}
		
		
		
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
		$this->ofimatica->add_header( $this->marvin->mysql_field_to_human('id'),50 );
		while(list(,$field_name)=each($export_fields))
		{
			$this->ofimatica->add_header( $this->marvin->mysql_field_to_human($field_name),$config['campos'][$field_name]['width'] );
		}
		//creo el header
		
		unset($export_fields[0]); //sacampos descripcion
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//exportarmos unidades....
			$this->_create_query_unidad();
			$result=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);	
			foreach($result as $row)
			{
				
				$this->ofimatica->add_row();
				$this->ofimatica->add_data( $row['id']);
				$this->ofimatica->add_data( lang('unidad_id'));
				
				reset($export_fields);
				while(list(,$field_name)=each($export_fields))
				{
					$this->ofimatica->add_data( element($field_name, $row) );
				}
				
			}
			//exportarmos unidades....
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//exportarmos tarjeta de garantia....
			$this->_create_query_tarjeta_garantia();
			$result=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);	
			foreach($result as $row)
			{
				
				$this->ofimatica->add_row();
				$this->ofimatica->add_data( $row['id']);
				$this->ofimatica->add_data( lang('tarjeta_garantia_id'));
				
				reset($export_fields);
				while(list(,$field_name)=each($export_fields))
				{
					$this->ofimatica->add_data( element($field_name, $row) );
				}
				
			}
			//exportarmos tarjeta_garatia....
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//exportarmos tsi....
			$this->_create_query_tsi();
			$result=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);	
			foreach($result as $row)
			{
				
				$this->ofimatica->add_row();
				$this->ofimatica->add_data( $row['id']);
				$this->ofimatica->add_data( lang('tsi_id'));
				
				reset($export_fields);
				while(list(,$field_name)=each($export_fields))
				{
					$this->ofimatica->add_data( element($field_name, $row) );
				}
				
			}
			//exportarmos tsi....
			//------------------------------------------------------------------------------------------------
		}
		
		if($f)
		{
			//------------------------------------------------------------------------------------------------
			//exportarmos libro de servicio....
			$this->_create_query_libro_servicio();
			$result=$this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);	
			foreach($result as $row)
			{
				
				$this->ofimatica->add_row();
				$this->ofimatica->add_data( $row['id']);
				$this->ofimatica->add_data( lang('libro_servicio_id'));
				
				reset($export_fields);
				while(list(,$field_name)=each($export_fields))
				{
					$this->ofimatica->add_data( element($field_name, $row) );
				}
				
			}
			//exportarmos libro de servicio....
			//------------------------------------------------------------------------------------------------
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
		
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_motor',$this->marvin->mysql_field_to_human('unidad_field_motor'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_codigo_de_radio',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_radio'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_patente',$this->marvin->mysql_field_to_human('unidad_field_patente'),
			'trim'
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
		show_error(__LINE__ . __FILE__);
		$this->query = Doctrine_Query::create();
        $this->query->from('Unidad UNIDAD');
		$this->query->leftJoin('UNIDAD.Tsi TSI');
		$this->query->leftJoin('UNIDAD.Tarjeta_Garantia TARJETA_GARANTIA');
		//$this->query->leftJoin('UNIDAD.Libro_Servicio LIBRO_SERVICIO');
		
		$this->query->where("1 = 1");
		
		$this->flexigrid->validate_post();
		$this->flexigrid->build_query();
	}
	
	function _create_query_unidad()
	{
		$this->query = Doctrine_Query::create();
        $this->query->from('Unidad UNIDAD');
		$this->query->leftJoin('UNIDAD.Auto_Version AUTO_VERSION');
		$this->query->leftJoin('UNIDAD.Unidad_Estado UNIDAD_ESTADO');
		$this->query->leftJoin('UNIDAD.Unidad_Estado_Garantia UNIDAD_ESTADO_GARANTIA');
        $this->query->leftJoin('AUTO_VERSION.Auto_Modelo AUTO_MODELO');
		$this->query->leftJoin('UNIDAD.Auto_Anio AUTO_ANIO ');
		$this->query->leftJoin('UNIDAD.Auto_Transmision AUTO_TRANSMISION ');
        $this->query->leftJoin('UNIDAD.Auto_Puerta_Cantidad AUTO_PUERTA_CANTIDAD ');
		$this->query->leftJoin('UNIDAD.Unidad_Color_Exterior UNIDAD_COLOR_EXTERIOR ');
        $this->query->leftJoin('UNIDAD.Unidad_Color_Interior UNIDAD_COLOR_INTERIOR ');
		$this->query->leftJoin('UNIDAD.Vin_Procedencia_Ktype VIN_PROCEDENCIA_KTYPE ');
		$this->query->leftJoin('UNIDAD.Auto_Fabrica AUTO_FABRICA ');
		$this->flexigrid->post_info['sortname']  = 'UNIDAD.unidad_field_unidad';
		$this->flexigrid->post_info['sortorder'] = 'ASC';
		
		$this->query->where("1 = 1");
		
		
		$this->flexigrid->validate_post();
		$this->flexigrid->build_query();
	}
	
	function _create_query_tarjeta_garantia()
	{
		$this->query = Doctrine_Query::create();
        $this->query->from('Tarjeta_Garantia TARJETA_GARANTIA');
		$this->query->leftJoin('TARJETA_GARANTIA.Sucursal SUCURSAL');
		$this->query->leftJoin('TARJETA_GARANTIA.Many_Cliente MANY_CLIENTE ');
		$this->query->leftJoin('MANY_CLIENTE.Cliente_Sucursal CLIENTE_SUCURSAL ON MANY_CLIENTE.id = CLIENTE_SUCURSAL.cliente_id AND CLIENTE_SUCURSAL.sucursal_id = TARJETA_GARANTIA.sucursal_id');
	
		$this->query->leftJoin('TARJETA_GARANTIA.Unidad UNIDAD');
		$this->query->leftJoin('UNIDAD.Auto_Version AUTO_VERSION');
        $this->query->leftJoin('AUTO_VERSION.Auto_Modelo AUTO_MODELO');
		$this->query->leftJoin('UNIDAD.Auto_Anio AUTO_ANIO ');
		$this->query->leftJoin('UNIDAD.Auto_Transmision AUTO_TRANSMISION ');
        $this->query->leftJoin('UNIDAD.Auto_Puerta_Cantidad AUTO_PUERTA_CANTIDAD ');
		$this->query->leftJoin('UNIDAD.Unidad_Color_Exterior UNIDAD_COLOR_EXTERIOR ');
        $this->query->leftJoin('UNIDAD.Unidad_Color_Interior UNIDAD_COLOR_INTERIOR ');
		$this->query->where("1 = 1");
		$this->query->addWhere('TARJETA_GARANTIA.tarjeta_garantia_estado_id != ?',9); //rechadazao
		
		$this->flexigrid->validate_post();
		$this->flexigrid->post_info['sortname']  = 'TARJETA_GARANTIA.tarjeta_garantia_field_fecha_entrega';
		$this->flexigrid->post_info['sortorder'] = 'ASC';
		$this->flexigrid->build_query();
	}
	
	function _create_query_tsi()
	{
		$this->query = Doctrine_Query::create();
        $this->query->from('Tsi TSI');
		$this->query->leftJoin('TSI.Sucursal SUCURSAL');
		$this->query->leftJoin('TSI.Many_Tsi_Tipo_Servicio MANY_TSI_TIPO_SERVICIO ');
		$this->query->leftJoin('TSI.Cliente CLIENTE ');
		$this->query->leftJoin('CLIENTE.Cliente_Sucursal CLIENTE_SUCURSAL ON CLIENTE.id = CLIENTE_SUCURSAL.cliente_id AND CLIENTE_SUCURSAL.sucursal_id = TSI.sucursal_id');
	
		$this->query->leftJoin('TSI.Unidad UNIDAD');
		$this->query->leftJoin('UNIDAD.Auto_Version AUTO_VERSION');
        $this->query->leftJoin('AUTO_VERSION.Auto_Modelo AUTO_MODELO');
		$this->query->leftJoin('UNIDAD.Auto_Anio AUTO_ANIO ');
		$this->query->leftJoin('UNIDAD.Auto_Transmision AUTO_TRANSMISION ');
        $this->query->leftJoin('UNIDAD.Auto_Puerta_Cantidad AUTO_PUERTA_CANTIDAD ');
		$this->query->leftJoin('UNIDAD.Unidad_Color_Exterior UNIDAD_COLOR_EXTERIOR ');
        $this->query->leftJoin('UNIDAD.Unidad_Color_Interior UNIDAD_COLOR_INTERIOR ');
		$this->query->where("1 = 1");
		$this->query->addWhere('TSI.tsi_estado_id != ?',9); //rechadazao
		
		$this->flexigrid->validate_post();
		
		$this->flexigrid->post_info['sortname']  = 'TSI.tsi_field_fecha_de_egreso';
		$this->flexigrid->post_info['sortorder'] = 'ASC';
		$this->flexigrid->build_query();
		
		
	}
	
	function _create_query_libro_servicio()
	{
		$this->query = Doctrine_Query::create();
        $this->query->from('Libro_Servicio LIBRO_SERVICIO');
		$this->query->leftJoin('LIBRO_SERVICIO.Sucursal SUCURSAL');
		$this->query->leftJoin('LIBRO_SERVICIO.Unidad UNIDAD');
		$this->query->leftJoin('LIBRO_SERVICIO.Libro_Servicio_Estado LIBRO_SERVICIO_ESTADO');
		$this->query->leftJoin('UNIDAD.Auto_Version AUTO_VERSION');
        $this->query->leftJoin('AUTO_VERSION.Auto_Modelo AUTO_MODELO');
		$this->query->leftJoin('UNIDAD.Auto_Anio AUTO_ANIO ');
		$this->query->leftJoin('UNIDAD.Auto_Transmision AUTO_TRANSMISION ');
        $this->query->leftJoin('UNIDAD.Auto_Puerta_Cantidad AUTO_PUERTA_CANTIDAD ');
		$this->query->leftJoin('UNIDAD.Unidad_Color_Exterior UNIDAD_COLOR_EXTERIOR ');
        $this->query->leftJoin('UNIDAD.Unidad_Color_Interior UNIDAD_COLOR_INTERIOR ');
		$this->query->where("1 = 1");
		$this->query->addWhere('LIBRO_SERVICIO.libro_servicio_estado_id != ?',5); //rechadazao
		
		$this->flexigrid->validate_post();
		$this->flexigrid->post_info['sortname']  = 'LIBRO_SERVICIO.libro_servicio_field_fechahora_alta';
		$this->flexigrid->post_info['sortorder'] = 'ASC';
		$this->flexigrid->build_query();
	}
	
	
	
	
	
	
}
