<?php
define('ID_SECCION',1071);
class Sucursal_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	//filtra por sucursal?
	var $sucursal = FALSE;
	
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
				$this->registro_actual = new Sucursal();
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
			
			$this->registro_actual->unlink('Sucursal_Valor_Frt');
			
			$this->registro_actual->unlink('Many_Admin');
			//borro las imagenes
			
			foreach($this->registro_actual->Noticia_Imagen as $imagen)
			{
				$this->del_image( $this->registro_actual->id, $imagen->id );
			}

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
	
	//-------------------------[le manda los datos a la view]
	//----------------------------------------------------------------
	private function _mostrar_registro_actual()
	{
			//paranoid (por las dudas vio)
			$_POST = array();
			if($this->registro_actual)
			{
				$this->form_validation->set_defaults($this->registro_actual->toArray());
				$actuales=array();
				foreach($this->registro_actual->Many_Admin as $relacion) {
					$actuales[]=$relacion->id;
				}
				$this->form_validation->set_defaults(array('many_admin[]'=>$actuales));				
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
	//-------------------------[edita el registro]
	public function editold($id = FALSE)
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
			$registro=$this->registro_actual;
			$this->form_validation->set_defaults($registro->toArray());
			$actuales=array();
			foreach($registro->Many_Admin as $relacion) {
				$actuales[]=$relacion->id . "\n";
			}
			$this->form_validation->set_defaults(array('many_admin[]'=>$actuales));

		}
		//llamo a la vista
		$this->_view();

	}
	//-------------------------[edita el registro]
	//----------------------------------------------------------------

	//----------------------------------------------------------------
	//-------------------------[graba registro en la base de datos]
	private function _grabar_registro_actual()
	{
		try
		{
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			/*
			if($this->router->method == 'add' )
			{
				$this->registro_actual->admin_created_id = $this->session->userdata('admin_id');
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->admin_updated_id = $this->session->userdata('admin_id');
			}
			*/
			
		
			
			
			$this->registro_actual->sucursal_field_desc = $this->input->post('sucursal_field_desc');
			
			$this->registro_actual->sucursal_field_direccion = $this->input->post('sucursal_field_direccion');
			$this->registro_actual->sucursal_field_codigo_postal = $this->input->post('sucursal_field_codigo_postal');
			$this->registro_actual->sucursal_field_telefono = $this->input->post('sucursal_field_telefono');
			$this->registro_actual->sucursal_field_email = $this->input->post('sucursal_field_email');
			
			$this->registro_actual->sucursal_field_pagina_web = $this->input->post('sucursal_field_pagina_web');
			$this->registro_actual->sucursal_field_fecha_inicio_actividad = $this->input->post('sucursal_field_fecha_inicio_actividad');
			$this->registro_actual->sucursal_field_fecha_fin_actividad = $this->input->post('sucursal_field_fecha_fin_actividad');
		
			$this->registro_actual->sucursal_field_fecha_fin_envio = $this->input->post('sucursal_field_fecha_fin_envio');
			$this->registro_actual->sucursal_field_ingresos_brutos = $this->input->post('sucursal_field_ingresos_brutos');
			/*$this->registro_actual->sucursal_field_valor_frt_hora = $this->input->post('sucursal_field_valor_frt_hora');*/
			$this->registro_actual->sucursal_field_latitud			 = $this->input->post('sucursal_field_latitud');
			$this->registro_actual->sucursal_field_longitud			 = $this->input->post('sucursal_field_longitud');
			$this->registro_actual->sucursal_field_horario_atencion			 = $this->input->post('sucursal_field_horario_atencion');
			$this->registro_actual->sucursal_field_descripcion_web			 = $this->input->post('sucursal_field_descripcion_web');
					
			$this->registro_actual->empresa_id = $this->input->post('empresa_id');
		
			$this->registro_actual->provincia_id = $this->input->post('provincia_id');
			
			$this->registro_actual->ciudad_id = $this->input->post('ciudad_id');
		
			$this->registro_actual->backend_estado_id = $this->input->post('backend_estado_id');
			$this->registro_actual->sucursal_field_reporte_usados = $this->input->post('sucursal_field_reporte_usados');
			
			$this->registro_actual->save();
			
			$this->registro_actual->unlink('Sucursal_Valor_Frt');
			$this->registro_actual->save();
			
			if(isset($_POST['valor_frt_hora_fecha_inicio']) && is_array($_POST['valor_frt_hora_fecha_inicio']) && count($_POST['valor_frt_hora_fecha_inicio'])>0)
			{
				reset($_POST['valor_frt_hora_fecha_inicio']);
				while(list($key,$val)=each($_POST['valor_frt_hora_fecha_inicio']))
				{
					//TODO revisar
					//esto no me gusta, se agotan los ids
					if(!isset($_POST['valor_frt_hora'][$key]) || !is_numeric($_POST['valor_frt_hora'][$key]))
					{
						$_POST['valor_frt_hora'][$key]=0;
					}
					$modelo = new Sucursal_Valor_Frt();
					$modelo->sucursal_id = $this->registro_actual->id;
					$modelo->sucursal_valor_frt_field_valor_frt_hora = $_POST['valor_frt_hora'][$key];
					$modelo->sucursal_valor_frt_field_fecha_inicio = $this->form_validation->my_form_date_reverse($_POST['valor_frt_hora_fecha_inicio'][$key]);
					$modelo->save();
					
				}
				
			}
			

			
			/* ojo que no vienen los admins ! BORRAR
			$this->registro_actual->unlink('Many_Admin');
			$this->registro_actual->save();
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_admin')))
			{
					foreach($this->input->post('many_admin') as $admin_id) {
						$relacion=new Many_Admin();
						$relacion->admin_id = (int)$admin_id;
						$relacion->sucursal_id = $this->registro_actual->id;
						$relacion->save();
					}
			}
			*/

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
		$this->backend->upload_images('imagen');
	}
	//-------------------------[graba registro en la base de datos]
	//----------------------------------------------------------------

	//-----------------------------------------------------------------------------
	//-------------------------[vista generica abm]
	private function _view()
	{
		////$this->output->enable_profiler();
	
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

		//------------ [select / checkbox / radio empresa_id] :(
		$empresa=new Empresa();
		$q = $empresa->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('empresa_field_desc');
		$config['select'] = TRUE;
		$this->template['empresa_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio empresa_id]

		//------------ [select / checkbox / radio provincia_id] :(
		$provincia=new Provincia();
		$q = $provincia->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('provincia_field_desc');
		$config['select'] = TRUE;
		$this->template['provincia_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio provincia_id]
		
		if($this->input->post('provincia_id'))
		{
			$provincia=$this->input->post('provincia_id');
		}
		else if(isset($this->registro_actual->provincia_id))
		{
			$provincia=$this->registro_actual->provincia_id;
		}else{
			$provincia=FALSE;
		}
		
		//------------ [select / checkbox / radio ciudad_id] :(
		$ciudad=new Ciudad();
		$q = $ciudad->get_all();
		$q->addWhere(' provincia_id = ?', $provincia);
		$config=array();
		$config['fields'] = array('ciudad_field_desc');
		$config['select'] = TRUE;
		$this->template['ciudad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio ciudad_id]

		//------------ [select / checkbox / radio backend_estado_id] :(
		$backend_estado=new Backend_Estado();
		$q = $backend_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('backend_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['backend_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio backend_estado_id]
		
		if($this->registro_actual)
		{
			#----- feo
			#despues de mucho renegar, no se como darle un order by por default a las imagenes asique....
			$imagenes= new Sucursal_Imagen();
			$q=$imagenes->get_all();
			$q->addWhere('sucursal_id = ?',$this->registro_actual->id);
			$q->orderBy('sucursal_imagen_field_orden ASC');
			$resultado = $q->execute();
			$imagenes=array();
			foreach($resultado as $imagen) {
       			$imagenes[$imagen->id] = $imagen->toArray();
   			}
			$this->template['sucursal_imagen'] = $imagenes;
			#----- feo
		}
		
		$this->template['CKEDITOR'] = TRUE; //habilitamos editor html
	
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
	private function _validar_formulario() {
		if($this->registro_actual)
		{
			$id=$this->registro_actual->id;
		}else{
			$id = FALSE;
		}
				
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));

		$this->form_validation->set_rules('sucursal_field_desc',$this->marvin->mysql_field_to_human('sucursal_field_desc'),
				'trim|required|max_length[255]' );

		$this->form_validation->set_rules('sucursal_field_direccion',$this->marvin->mysql_field_to_human('sucursal_field_direccion'),
				'trim|required|max_length[255]' );

		$this->form_validation->set_rules('sucursal_field_ciudad_tmp',$this->marvin->mysql_field_to_human('sucursal_field_ciudad_tmp'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('sucursal_field_codigo_postal',$this->marvin->mysql_field_to_human('sucursal_field_codigo_postal'),
				'trim|max_length[20]|my_valid_codigo_postal|required' );

		$this->form_validation->set_rules('sucursal_field_telefono',$this->marvin->mysql_field_to_human('sucursal_field_telefono'),
				'trim|max_length[100]|required' );

		$this->form_validation->set_rules('sucursal_field_email',$this->marvin->mysql_field_to_human('sucursal_field_email'),
				'trim|max_length[255]|required|valid_email' );
		
		$this->form_validation->set_rules('sucursal_field_latitud',$this->marvin->mysql_field_to_human('sucursal_field_latitud'),
				'trim|max_length[255]' );
		
		$this->form_validation->set_rules('sucursal_field_longitud',$this->marvin->mysql_field_to_human('sucursal_field_longitud'),
				'trim|max_length[255]' );
				
		$this->form_validation->set_rules('sucursal_field_horario_atencion',$this->marvin->mysql_field_to_human('sucursal_field_horario_atencion'),
				'trim|max_length[255]' );
		
		$this->form_validation->set_rules('sucursal_field_descripcion_web',$this->marvin->mysql_field_to_human('sucursal_field_descripcion_web'),
				'trim' );
		
		$this->form_validation->set_rules('sucursal_field_pagina_web',$this->marvin->mysql_field_to_human('sucursal_field_pagina_web'),
				'trim|max_length[255]|my_valid_url' );
				
		$this->form_validation->set_rules('sucursal_field_ingresos_brutos',$this->marvin->mysql_field_to_human('sucursal_field_ingresos_brutos'),
				'trim|numeric' );
		
		/*$this->form_validation->set_rules('sucursal_field_valor_frt_hora',$this->marvin->mysql_field_to_human('sucursal_field_valor_frt_hora'),
				'trim|numeric' );
		*/
		$this->form_validation->set_rules('sucursal_field_fecha_inicio_actividad',$this->marvin->mysql_field_to_human('sucursal_field_fecha_inicio_actividad'),
				'trim|my_form_date_reverse' );

		$this->form_validation->set_rules('sucursal_field_fecha_fin_actividad',$this->marvin->mysql_field_to_human('sucursal_field_fecha_fin_actividad'),
				'trim|my_form_date_reverse' );

		$this->form_validation->set_rules('sucursal_field_fecha_fin_envio',$this->marvin->mysql_field_to_human('sucursal_field_fecha_fin_envio'),
				'trim|my_form_date_reverse' );

		$this->form_validation->set_rules('empresa_id',$this->marvin->mysql_field_to_human('empresa_id'),
				'trim|is_natural_no_zero' );

		$this->form_validation->set_rules('provincia_id',$this->marvin->mysql_field_to_human('provincia_id'),
				'trim|is_natural_no_zero' );

		$this->form_validation->set_rules('ciudad_id',$this->marvin->mysql_field_to_human('ciudad_id'),
				'trim|is_natural_no_zero' );

		$this->form_validation->set_rules('backend_estado_id',$this->marvin->mysql_field_to_human('backend_estado_id'),
				'trim|is_natural_no_zero' );
				
		$this->form_validation->set_rules('sucursal_field_reporte_usados',$this->marvin->mysql_field_to_human('sucursal_field_reporte_usados'),
				'trim|is_natural_no_zero' );


		
		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------	
	
	
	public function ordenar_imagenes( $id = FALSE ) {
		$rs		= $this->backend->ordenar_imagenes($id,'imagen');
	}
	
	public function del_image( $id_registro = FALSE, $id_imagen= FALSE ) {
		$rs		= $this->backend->del_image($id_registro, $id_imagen, 'imagen');
	}

	public function edit_image( $id_registro = FALSE, $id_imagen= FALSE ) {
		$rs		= $this->backend->edit_image($id_registro, $id_imagen, 'imagen');
	}
	
	
	
	
}       
