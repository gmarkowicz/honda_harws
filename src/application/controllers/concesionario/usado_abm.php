<?php
define('ID_SECCION',5011);
class Usado_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	//filtra por sucursal?
	var $sucursal = TRUE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;
	
	//subfix de archivos adjuntos 
	var $upload_adjunto = array();
	
	//subfix de imagenes adjuntas 
	var $upload_image = array('imagen');

	function __construct()
	{
		parent::Backend_Controller();
	}
				
	

	//----------------------------------------------------------------
	//-------------------------[crea un registro a partir de post ]
	public function add()
	{
		if($this->input->post('_submit'))
		{		
			if ($this->_validar_formulario() == TRUE)
			{
				//piso _this_registro_actual
				$this->registro_actual = new Usado();
				$this->_grabar_registro_actual();
				$this->session->set_flashdata('add_ok', true);
				//seteo para dejarlo actualizar hasta que se vaya, ver plugin backend _verificar_permisos()
				$lasts = $this->session->userdata('last_add_' . $this->router->class );
				if(!is_array($lasts))
					$lasts = array();
				$lasts[] = $this->registro_actual->id;
				$this->session->set_userdata('last_add_'.$this->router->class,$lasts);
				//
				redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
			}
		}
		
		$this->_view();
	}
	//-------------------------[crea un registro a partir de post ]
	//----------------------------------------------------------------
	
	//----------------------------------------------------------------
	//-------------------------[rechaza registro actual]
	public function reject()
	{
		if($this->rechazar_registro === TRUE)
		{
			$this->_set_record($this->input->post('id'));
			if($this->_reject_record())
			{
				if($this->input->post('ajax'))
				{
					//le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
					$this->output->set_output("TRUE");
				}
			}
		}
	}
	
	//----------------------------------------------------------------
	//-------------------------[rechaza registro actual]
	
	//----------------------------------------------------------------
	//-------------------------[elimina registro actual]
	public function del()
	{
		$this->_set_record($this->input->post('id'));
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			//$this->registro_actual->admin_deleted_id = $this->session->userdata('admin_id');
			//no borra los m2m con $this->registro_actual->delete(); :S
			


			//------- elimino imagenes (si las hay)
			if($this->backend->isset_image())
			{
				while(list($key,$subfix)=each($this->upload_image))
				{
					$modelo = str_replace(' ','_',humanize($this->model . '_' . $subfix));
					foreach($this->registro_actual->$modelo as $imagen)
					{
						$this->del_image( $this->registro_actual->id, $imagen->id, $subfix );
					}
				}
			}
			//------- elimino imagenes (si las hay)
			
			//------- elimino archivos adjuntos (si los hay)
			if($this->backend->isset_adjunto())
			{
				while(list($key,$subfix)=each($this->upload_adjunto))
				{
					$modelo = str_replace(' ','_',humanize($this->model . '_' . $subfix));
					foreach($this->registro_actual->$modelo as $adjunto)
					{
						$this->del_adjunto( $this->registro_actual->id, $adjunto->id, $subfix );
					}
				}
			}
			//------- elimino archivos adjuntos (si los hay)
			
			

			$this->registro_actual->save();
			$this->registro_actual->delete();
			$conn->commit();
		} catch(Doctrine_Exception $e) {
			$conn->rollback();
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['sql'] 		= 'transaction';
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}
		$this->session->set_flashdata('del_ok', true);
		if($this->input->post('ajax'))
		{
			//le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
			$this->output->set_output("TRUE");
		}
	}
	//-------------------------[elimina registro actual]
	//----------------------------------------------------------------
			
	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------
	public function show($id = FALSE)
	{
		$this->_set_record($id);
		$this->_mostrar_registro_actual($id);
		$this->_view();
	}
	
	
	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------
	
	//----------------------------------------------------------------
	//-------------------------[edita el registro]
	public function edit($id = FALSE)
	{
		$this->_set_record($id);
		if($this->input->post('_submit'))
		{
			//manda info
			if ($this->_validar_formulario() == TRUE)
			{
				//pasa validacion, grabo y redirecciono a edit
				$this->_grabar_registro_actual();
				$this->session->set_flashdata('edit_ok', true);
				redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
			}	
		}else{
			//no mando info, muestro la del registro por default
			$this->_mostrar_registro_actual();
		}
		//llamo a la vista
		$this->_view();

	}
	//-------------------------[edita el registro]
	//----------------------------------------------------------------		

	//----------------------------------------------------------------
	private function _mostrar_registro_actual()
	{
		//paranoid (por las dudas vio)
		//$_POST = array();
		if($this->registro_actual)
		{
			$registro_array = $this->registro_actual->toArray();
			$this->form_validation->set_defaults($registro_array);
			if(isset($registro_array['Unidad']))
			{
				$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array['Unidad'])));
				$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array['Unidad'])));
			}
			
			$this->form_validation->set_defaults(array('auto_modelo_id'=>$registro_array['Auto_Version']['Auto_Modelo']['id']));
			$this->form_validation->set_defaults(array('auto_marca_id'=>$registro_array['Auto_Version']['Auto_Modelo']['Auto_Marca']['id']));
			if(isset($registro_array['Unidad_Entregada']))
			{
				$this->form_validation->set_defaults(array('unidad_0km'=>$registro_array['Unidad_Entregada']['unidad_field_unidad']));
				$this->form_validation->set_defaults(array('vin_0km'=>$registro_array['Unidad_Entregada']['unidad_field_vin']));
			}
			/*
			if(!$this->input->post('_submit')) //despues dicen que ajax es mas facil de programar..
			{
				$_POST['auto_marca_id'] 	 = $registro_array['Auto_Version']['Auto_Modelo']['Auto_Marca']['id'];
				$_POST['auto_modelo_id']	 = $registro_array['Auto_Version']['Auto_Modelo']['id'];
				$_POST['auto_version_id']	 = $registro_array['Auto_Version']['id'];
			}
			*/
		}
		else
		{
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= 'no existe llamada a _set_record?';
			$this->backend->_log_error($error);
			show_error( $error['error']   );
		}
	}
	//----------------------------------------------------------------
	//-------------------------[le manda los datos a la view]

	//----------------------------------------------------------------
	//-------------------------[graba registro en la base de datos]
	private function _grabar_registro_actual()
	{
		try
		{
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			
			//verifico que la unidad sea valida
			$unidad = Doctrine::getTable('Unidad')->findOneByunidad_field_vin($this->input->post('unidad_field_vin'));
			if($this->input->post('usado_tipo_ingreso_id') == 1)
			{
				//verifico que la unidad sea valida
				$unidad_entregada = Doctrine::getTable('Unidad')->findOneByunidad_field_vin($this->input->post('vin_0km'));
				if(!$unidad_entregada)
				{
					$error['line'] 		= __LINE__;
					$error['file'] 		= __FILE__;
					$error['error']		= 'no encuentro unidad entregada';
					$this->backend->_log_error($error);
					show_error($error['error']);
				}
			}
			
			if($this->router->method == 'add' )
			{
				$this->registro_actual->usado_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->usado_field_fechahora_alta = date('Y-m-d H:i:s', time());
				
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->usado_field_admin_modifica_id = $this->session->userdata('admin_id');
				$this->registro_actual->usado_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
			}
			
			if($unidad)
			{
				$this->registro_actual->unidad_id = $unidad->id;
				$this->registro_actual->auto_version_id 			= $unidad->auto_version_id;
			}else{
				$this->registro_actual->auto_version_id 			= $this->input->post('auto_version_id');
			}
			if($this->input->post('usado_tipo_ingreso_id') == 1)
			{
				$this->registro_actual->unidad_entregada_id = $unidad_entregada->id;
			}
			
			$this->registro_actual->usado_field_kilometros 		= $this->input->post('usado_field_kilometros');
			$this->registro_actual->usado_field_precio_toma 	= $this->input->post('usado_field_precio_toma');
			$this->registro_actual->moneda_precio_toma_id 		= $this->input->post('moneda_precio_toma_id');
			$this->registro_actual->usado_field_precio_venta 	= $this->input->post('usado_field_precio_venta');
			$this->registro_actual->moneda_precio_venta_id 		= $this->input->post('moneda_precio_venta_id');
			$this->registro_actual->usado_field_fecha_venta 	= $this->input->post('usado_field_fecha_venta');
			$this->registro_actual->usado_field_comentarios 	= $this->input->post('usado_field_comentarios');
			$this->registro_actual->usado_field_patente 		= $this->input->post('usado_field_patente');
			$this->registro_actual->auto_anio_id 				= $this->input->post('auto_anio_id');
			$this->registro_actual->auto_color_id 				= $this->input->post('auto_color_id');
			$this->registro_actual->sucursal_id 				= $this->input->post('sucursal_id');
			$this->registro_actual->usado_tipo_venta_id 		= $this->input->post('usado_tipo_venta_id');
			$this->registro_actual->usado_tipo_ingreso_id 		= $this->input->post('usado_tipo_ingreso_id');
			$this->registro_actual->backend_estado_id 			= $this->input->post('backend_estado_id');
			
			$this->registro_actual->save();

			$conn->commit();
		}
		catch(Doctrine_Exception $e)
		{
			$conn->rollback();
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['sql'] 		= 'transaction';
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}
		
		$this->backend->upload_adjuntos();
		$this->backend->upload_images();
		
	}
	//-------------------------[graba registro en la base de datos]
	//----------------------------------------------------------------

	//-----------------------------------------------------------------------------
	//-------------------------[vista generica abm]
	private function _view()
	{
		//$this->output->enable_profiler();
	
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['main_url'] = $this->get_main_url();
		$this->template['tpl_include'] = $this->get_template_view();
		if($this->rechazar_registro === TRUE){
			$this->template['SHOW_RECHAZAR_REGISTRO'] = TRUE;
		}
		else
		{
			$this->template['SHOW_RECHAZAR_REGISTRO'] = FALSE;
		}

		//------------ [select / checkbox / radio moneda_precio_toma_id] :(
		$moneda_precio_toma=new Moneda();
		$q = $moneda_precio_toma->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('moneda_field_desc');
		$config['select'] = TRUE;
		$this->template['moneda_precio_toma_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio moneda_precio_toma_id]

		//------------ [select / checkbox / radio moneda_precio_venta_id] :(
		$moneda_precio_venta=new Moneda();
		$q = $moneda_precio_venta->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('moneda_field_desc');
		$config['select'] = TRUE;
		$this->template['moneda_precio_venta_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio moneda_precio_venta_id]

		//------------ [select / checkbox / radio auto_version_id] :(
		$auto_version=new Auto_Version();
		$q = $auto_version->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_version_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_version_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_version_id]
		
		/*
		//------------ [select / checkbox / radio unidad_id] :(
		$unidad=new Unidad();
		$q = $unidad->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('unidad_field_desc');
		$config['select'] = TRUE;
		$this->template['unidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_id]
		*/
		/*
		//------------ [select / checkbox / radio unidad_entregada_id] :(
		$unidad_entregada=new Unidad_Entregada();
		$q = $unidad_entregada->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('unidad_entregada_field_desc');
		$config['select'] = TRUE;
		$this->template['unidad_entregada_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_entregada_id]
		*/
		//------------ [select / checkbox / radio auto_anio_id] :(
		$auto_anio=new Auto_Anio();
		$q = $auto_anio->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_anio_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_anio_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_anio_id]

		//------------ [select / checkbox / radio auto_color_id] :(
		$auto_color=new Auto_Color();
		$q = $auto_color->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_color_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_color_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_color_id]

		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn('id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = TRUE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]

		//------------ [select / checkbox / radio usado_tipo_venta_id] :(
		$usado_tipo_venta=new Usado_Tipo_Venta();
		$q = $usado_tipo_venta->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('usado_tipo_venta_field_desc');
		$config['select'] = TRUE;
		$this->template['usado_tipo_venta_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio usado_tipo_venta_id]

		//------------ [select / checkbox / radio usado_tipo_ingreso_id] :(
		$usado_tipo_ingreso=new Usado_Tipo_Ingreso();
		$q = $usado_tipo_ingreso->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('usado_tipo_ingreso_field_desc');
		$config['select'] = TRUE;
		$this->template['usado_tipo_ingreso_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio usado_tipo_ingreso_id]

		//------------ [select / checkbox / radio backend_estado_id] :(
		$backend_estado=new Backend_Estado();
		$q = $backend_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('backend_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['backend_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio backend_estado_id]
		
		//------------ [select / checkbox / radio backend_estado_id] :(
		$auto_marca=new Auto_Marca();
		$q = $auto_marca->get_all();
		$q->addWhere('id != ? ',100); //saco marca honda, tiene que vernir x vin
		$config=array();
		$config['fields'] = array('auto_marca_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_marca_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio backend_estado_id]
		
		//------------ [select / checkbox / radio auto_modelo_id] :(
		$auto_modelo=new Auto_Modelo();
		$q = $auto_modelo->get_all();
		if($this->form_validation->set_value('auto_marca_id')!=NULL)
		{
			$q->WhereIn(' auto_marca_id ', $this->form_validation->set_value('auto_marca_id'));
		}else{
			$q->WhereIn(' auto_marca_id ', 0);
		}
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_modelo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_modelo_id]
	
		//------------ [select / checkbox / radio auto_version_id] :(
		$auto_version=new Auto_Version();
		$q = $auto_version->get_all();
		if($this->form_validation->set_value('auto_modelo_id')!=NULL)
		{
			$q->WhereIn(' auto_modelo_id ', $this->form_validation->set_value('auto_modelo_id'));
		}else{
			$q->WhereIn(' auto_modelo_id ', 0);
		}
		$config=array();
		$config['fields'] = array('auto_version_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_version_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_version_id]
	
		$this->_view_adjunto(); //muestro archivos adjuntos (si los hay); //definida $this->$upload_adjunto = array();
		$this->_view_image(); //muestro imagenes (si las hay); //definida $this->$upload_image = array();
		$this->load->view('backend/esqueleto_view',$this->template);
	}
	//-------------------------[vista generica]
	//-----------------------------------------------------------------------------

	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------
	//http://codeigniter.com/user_guide/libraries/form_validation.html
	//required|matches[form_item]|min_length[6]|max_length[12]|exact_length[8]|alpha|alpha_numeric|
	//alpha_dash|numeric|integer|is_natural|is_natural_no_zero|valid_email|valid_emails|valid_ip|valid_base64
	//my_unique_db[Modelo.tabla_field_campo '.$id.']	
	//mysql_date_to_form my_form_date_reverse
	//my_db_value_exist[Modelo.campo]
	private function _validar_formulario() {
		if($this->registro_actual)
		{
			$id=$this->registro_actual->id;
		}else{
			$id = FALSE;
		}
				
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));
		
		
		if(strlen($this->input->post('unidad_field_unidad'))>0)
		{
				$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
						'trim|required|alpha_numeric|my_exist_unidad['.$this->input->post('unidad_field_vin').']' );
				
				$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
						'trim|required|exact_length[17]|alpha_numeric' );
		}else{
				$this->form_validation->set_rules('auto_marca_id',$this->marvin->mysql_field_to_human('auto_marca_id'),
				'trim|required|my_db_value_exist[Auto_Marca.id]' );
				$this->form_validation->set_rules('auto_modelo_id',$this->marvin->mysql_field_to_human('auto_modelo_id'),
				'trim|required|my_db_value_exist[Auto_Modelo.id]' );
				$this->form_validation->set_rules('auto_version_id',$this->marvin->mysql_field_to_human('auto_version_id'),
				'trim|required|my_db_value_exist[Auto_Version.id]' );
		}
		
		
		if($this->input->post('usado_tipo_ingreso_id') == 1)
		{
			$this->form_validation->set_rules('unidad_0km',$this->marvin->mysql_field_to_human('unidad_0km'),
					'trim|required|alpha_numeric|my_exist_unidad['.$this->input->post('vin_0km').']' );
			
			$this->form_validation->set_rules('vin_0km',$this->marvin->mysql_field_to_human('vin_0km'),
					'trim|required|exact_length[17]|my_db_value_exist[Unidad.unidad_field_vin]' );
		}
		else
		{	
			$this->form_validation->set_rules('unidad_0km',$this->marvin->mysql_field_to_human('unidad_0km'),
					'trim' );
			
			$this->form_validation->set_rules('vin_0km',$this->marvin->mysql_field_to_human('vin_0km'),
					'trim' );
		}
	
		

		$this->form_validation->set_rules('usado_field_kilometros',$this->marvin->mysql_field_to_human('usado_field_kilometros'),
				'trim|required|integer' );

		$this->form_validation->set_rules('usado_field_precio_toma',$this->marvin->mysql_field_to_human('usado_field_precio_toma'),
				'trim|required|integer' );

		$this->form_validation->set_rules('moneda_precio_toma_id',$this->marvin->mysql_field_to_human('moneda_precio_toma_id'),
				'trim|required|my_db_value_exist[Moneda.id]' );

		$this->form_validation->set_rules('usado_field_precio_venta',$this->marvin->mysql_field_to_human('usado_field_precio_venta'),
				'trim|required|integer' );

		$this->form_validation->set_rules('moneda_precio_venta_id',$this->marvin->mysql_field_to_human('moneda_precio_venta_id'),
				'trim|required|my_db_value_exist[Moneda.id]' );

		$this->form_validation->set_rules('usado_field_fecha_venta',$this->marvin->mysql_field_to_human('usado_field_fecha_venta'),
				'trim|my_form_date_reverse|my_valid_date[y-m-d,-]' );
		
		if(strlen($this->input->post('usado_field_fecha_venta'))>0)
		{
			$this->form_validation->set_rules('usado_tipo_venta_id',$this->marvin->mysql_field_to_human('usado_tipo_venta_id'),
				'trim|required|my_db_value_exist[Usado_Tipo_Venta.id]' );
		}else{
			$this->form_validation->set_rules('usado_tipo_venta_id',$this->marvin->mysql_field_to_human('usado_tipo_venta_id'),
				'trim' );
		}
		
		$this->form_validation->set_rules('usado_field_comentarios',$this->marvin->mysql_field_to_human('usado_field_comentarios'),
				'trim|max_length[2500]' );

		$this->form_validation->set_rules('usado_field_patente',$this->marvin->mysql_field_to_human('usado_field_patente'),
				'strtoupper|trim|max_length[7]|required|my_valid_patente' );


		$this->form_validation->set_rules('auto_anio_id',$this->marvin->mysql_field_to_human('auto_anio_id'),
				'trim|required|my_db_value_exist[Auto_Anio.id]' );

		$this->form_validation->set_rules('auto_color_id',$this->marvin->mysql_field_to_human('auto_color_id'),
				'trim|required|my_db_value_exist[Auto_Color.id]' );

		$this->form_validation->set_rules('sucursal_id',$this->marvin->mysql_field_to_human('sucursal_id'),
				'trim|required|my_db_value_exist[Sucursal.id]|my_valid_sucursal' );

		
		$this->form_validation->set_rules('usado_tipo_ingreso_id',$this->marvin->mysql_field_to_human('usado_tipo_ingreso_id'),
				'trim|required|my_db_value_exist[Usado_Tipo_Ingreso.id]' );

		$this->form_validation->set_rules('backend_estado_id',$this->marvin->mysql_field_to_human('backend_estado_id'),
				'trim|required|my_db_value_exist[Backend_Estado.id]' );


		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------	
	
	
	//-------------------------[comunes imagenes y adjuntos]
	public function edit_image( $id_registro = FALSE, $id_imagen= FALSE ) 
	{
		$rs		= $this->backend->edit_image($id_registro, $id_imagen, $this->input->post('prefix'));
	}
	
	
	public function ordenar_imagenes( $id = FALSE ) {
		
		$rs		= $this->backend->ordenar_imagenes($id,$this->input->post('prefix'));
	}
	
	public function del_image( $id_registro = FALSE, $id_imagen= FALSE, $subfix = 'image'  )
	{
		$rs		= $this->backend->del_image($id_registro, $id_imagen, 'imagen');
	}
	
	
	public function del_adjunto( $id_registro = FALSE, $id_adjunto= FALSE, $subfix = 'adjunto' ) 
	{	
		$rs		= $this->backend->del_adjunto($id_registro, $id_adjunto, $subfix);
	}			
		//-------------------------[comunes imagenes y adjuntos]
	
	
}       
