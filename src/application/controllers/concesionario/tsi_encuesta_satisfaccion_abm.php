<?php
define('ID_SECCION',3025);
class Tsi_Encuesta_Satisfaccion_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	//filtra por sucursal?
	var $sucursal = FALSE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = TRUE;
	
	//subfix de archivos adjuntos 
	var $upload_adjunto = array();
	
	//subfix de imagenes adjuntas 
	var $upload_image = array();

	function __construct()
	{
		parent::Backend_Controller();
	}
				
	

	//----------------------------------------------------------------
	//-------------------------[crea un registro a partir de post ]
	public function add()
	{
		/*
		 a - El boton de agregar una encuesta manualmente no va, 
		 por el momento no se va a utilizar asi que este es al pedo y da para confusion, favor
         sacarlo.
		 entendido... los permisos estan al pedo
		*/
		redirect($this->get_main_url());
		
		if($this->input->post('_submit'))
		{		
			if ($this->_validar_formulario() == TRUE)
			{
				//piso _this_registro_actual
				$this->registro_actual = new Tsi_Encuesta_Satisfaccion();
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
			
	
	//-------------------------[le manda los datos a la view]
	//----------------------------------------------------------------
	private function _mostrar_registro_actual()
	{
			//paranoid (por las dudas vio)
			$_POST = array();
			if($this->registro_actual)
			{
				$registro_array = $this->registro_actual->toArray();
				$this->form_validation->set_defaults($registro_array);
				/*
				$unidad = array(
								'auto_modelo_field_desc'=>
								$registro_array['Tsi']['Unidad']['Auto_Version']['Auto_Modelo']['auto_modelo_field_desc'],
				);
				$this->form_validation->set_defaults($unidad);
				*/
				
				
				
				
				
				/*
				$this->template['TSI'] 		= $registro_array['Tsi'];
				$this->template['CLIENTE'] 	= $registro_array['Tsi']['Cliente'];
				$this->template['SUCURSAL']	= $registro_array['Tsi']['Sucursal'];
				*/
				
				$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
				$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
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
	
	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------
	public function toemail($id = FALSE)
	{
		
		$this->_set_record($id);
		$this->_mostrar_registro_actual($id);
		$this->_view();
		
		$html = $this->output->get_output();
		$this->load->library('dompdf_lib');
		//$html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
		// Convert to PDF
		$html = preg_replace("/<a[^>]*>(.*)<\/a>/iU", "$1", $html);
		$filename	=	url_title(
						$this->router->class 			. $id);
		
		$this->dompdf_lib->createPDF($html, $filename);  
		
		
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
			
			$registro_array=$this->registro_actual->toArray();
			
			$this->form_validation->set_defaults($registro->toArray());
			$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
			//$this->form_validation->set_defaults(array('TSI'=>$registro_array['Tsi']));

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
			
			if($this->router->method == 'add' )
			{
				$this->registro_actual->tsi_encuesta_satisfaccion_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->tsi_encuesta_satisfaccion_field_fechahora_alta = date('Y-m-d H:i:s', time());
				$this->registro_actual->tsi_encuesta_satisfaccion_estado_id = 2;
				$this->registro_actual->tsi_id = $this->input->post('tsi_id');
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->tsi_encuesta_satisfaccion_field_admin_modifica_id = $this->session->userdata('admin_id');
				$this->registro_actual->tsi_encuesta_satisfaccion_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
			}
			
			
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_01 = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_01');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_01a = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_01a');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_02a = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_02a');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_02b = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_02b');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_02c = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_02c');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_02d = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_02d');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_02e = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_02e');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_02f = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_02f');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_03a = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_03a');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_03b = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_03b');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_03c = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_03c');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_04a = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_04a');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_04b = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_04b');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_04c = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_04c');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_04d = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_04d');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_04e = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_04e');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_05 = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_05');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_06 = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_06');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_06a = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_06a');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_06b = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_06b');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_06b_otra = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_06b_otra');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_07a = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_07a');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_07b = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_07b');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_07c = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_07c');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_08 = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_08');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_pregunta_09 = $this->input->post('tsi_encuesta_satisfaccion_field_pregunta_09');
			$this->registro_actual->tsi_encuesta_satisfaccion_field_comentarios = $this->input->post('tsi_encuesta_satisfaccion_field_comentarios');
			

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
		//muestro js raiting
		$this->template['js_rating'] = TRUE;
		
		
		//------------ [5 estrellas] 
		$estrellas_5 = array(		1	=>'',
									2	=>'',
									3	=>'',
									4	=>'',
									5	=>''
		
		);
		$this->template['estrellas_5']=$estrellas_5;
		//------------ [5 estrellas]
		
		//------------ [4 estrellas] 
		$estrellas_4 = array(		1	=>'',
									2	=>'',
									3	=>'',
									4	=>''
		
		);
		$this->template['estrellas_4']=$estrellas_4;
		//------------ [4 estrellas]
		
		//------------ [si/no] 
		$si_no 		= array(		0	=>'',
									1	=>'No',
									2	=>'Sí'
		
		);
		$this->template['si_no']=$si_no;
		//------------ [si/no]
		
		//------------ [select / checkbox / radio visitas adicionales] :(
		$visitas_adicionales=new Tsi_Encuesta_Satisfaccion_Visitas_Adicionales();
		$q = $visitas_adicionales->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tsi_encuesta_satisfaccion_visitas_adicionales_field_desc');
		$config['select'] = TRUE;
		$this->template['visitas_adicionales']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio visitas adicionales]
		
			//------------ [select / checkbox / radio admin_estado_id] :(
		$razon_repetir_servicio=new Tsi_Encuesta_Satisfaccion_Razon_Repetir_Servicio();
		$q = $razon_repetir_servicio->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tsi_encuesta_satisfaccion_razon_repetir_servicio_field_desc');
		$config['select'] = TRUE;
		$config['order'] = 'id';
		$this->template['razon_repetir_servicio']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio admin_estado_id]
		
	
		
		
		if($this->rechazar_registro === TRUE){
			$this->template['SHOW_RECHAZAR_REGISTRO'] = TRUE;
		}
		else
		{
			$this->template['SHOW_RECHAZAR_REGISTRO'] = FALSE;
		}

	
		$this->_view_adjunto(); //muestro archivos adjuntos (si los hay); //definida $this->$upload_adjunto = array();
		$this->_view_image(); //muestro imagenes (si las hay); //definida $this->$upload_image = array();
		$this->load->view('backend/esqueleto_view',$this->template);
		/*
		$html = $this->output->get_output();
		$this->load->library('dompdf_lib');
		//$html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
		// Convert to PDF
		 $this->dompdf_lib->createPDF($html, 'myfilename');  
		*/
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
		if($this->router->method == 'add' )
		{
		$this->form_validation->set_rules('tsi_id',$this->marvin->mysql_field_to_human('tsi_id'),
				'trim|required|my_db_value_exist[Tsi.id]|my_unique_db[Tsi_Encuesta_Satisfaccion.tsi_id '.$id.']' );
		}
		
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
				'trim|required|alpha_numeric|my_exist_unidad['.$this->input->post('unidad_field_vin').']' );
		
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
				'trim|required|exact_length[17]|alpha_numeric' );
		
		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_01',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_01'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_01a',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_01a'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_02a',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_02a'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_02b',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_02b'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_02c',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_02c'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_02d',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_02d'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_02e',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_02e'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_02f',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_02f'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_03a',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_03a'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_03b',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_03b'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_03c',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_03c'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_04a',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_04a'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_04b',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_04b'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_04c',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_04c'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_04d',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_04d'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_04e',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_04e'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_05',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_05'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_06',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_06'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_06a',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_06a'),
				'trim' );


		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_06b',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_06b'),
				'trim' );


		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_06b_otra',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_06b_otra'),
				'trim|max_length[5000]' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_07a',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_07a'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_07b',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_07b'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_07c',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_07c'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_08',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_08'),
				'trim' );

		
		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_pregunta_09',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_pregunta_09'),
				'trim' );

		
		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_comentarios',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_comentarios'),
				'trim|max_length[5000]' );

		


		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------	
	
	
	//------ rechazando tarjeta de garantia
	private function _reject_record()
	{
		
		if(!$this->registro_actual || $this->registro_actual->tsi_encuesta_satisfaccion_estado_id==9 || !$this->backend->_permiso('admin'))
		{
			return FALSE;
		}
		
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			//				
				
				$this->registro_actual->tsi_encuesta_satisfaccion_field_rechazo_motivo	= $this->input->post('rechazo_motivo');
				$this->registro_actual->tsi_encuesta_satisfaccion_field_rechaza_id		= $this->session->userdata('admin_id');
				$this->registro_actual->tsi_encuesta_satisfaccion_estado_id				= 9;
				$this->registro_actual->save();
			//
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
		
		
		
		
		return TRUE;
	}
	
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
