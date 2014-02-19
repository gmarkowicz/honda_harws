<?php
define('ID_SECCION',3026);
class Tsi_Encuesta_Seguimiento_Abm extends Backend_Controller{
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
		if($this->input->post('_submit'))
		{		
			if ($this->_validar_formulario() == TRUE)
			{
				//piso _this_registro_actual
				$this->registro_actual = new Tsi_Encuesta_Seguimiento();
				$this->_grabar_registro_actual();
				$this->session->set_flashdata('add_ok', true);
				//seteo para dejarlo actualizar hasta que se vaya, ver plugin backend _verificar_permisos()
				$lasts = $this->session->userdata('last_add_' . $this->router->class );
				if(!is_array($lasts))
					$lasts = array();
				$lasts[] = $this->registro_actual->id;
				$this->session->set_userdata('last_add_'.$this->router->class,$lasts);
				//
				redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id, 'refresh');
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
				$this->template['TSI'] 		= $registro_array['Tsi'];
				$this->template['CLIENTE'] 	= $registro_array['Tsi']['Cliente'];
				$this->template['SUCURSAL']	= $registro_array['Tsi']['Sucursal'];
				*/
				$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
				$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
				
				$this->template['current_record'] = $registro_array;
			
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
			if($this->registro_actual->tsi_encuesta_seguimiento_estado_id == 9)
			{
				//esta rechazada... a otra cosa
				redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
			}
			
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
			$registro_array = $registro->toArray();
			$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
			$this->form_validation->set_defaults(array('TSI'=>$registro_array['Tsi']));

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
				$this->registro_actual->tsi_encuesta_seguimiento_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->tsi_encuesta_seguimiento_field_fechahora_alta = date('Y-m-d H:i:s', time());
				$this->registro_actual->tsi_id = $this->input->post('tsi_id');
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->tsi_encuesta_seguimiento_field_admin_modifica_id = $this->session->userdata('admin_id');
				$this->registro_actual->tsi_encuesta_seguimiento_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
				
			}
			
			$this->registro_actual->tsi_encuesta_seguimiento_field_entrevistador = $this->input->post('tsi_encuesta_seguimiento_field_entrevistador');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_01 = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_01');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_02 = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_02');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_03 = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_03');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_04 = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_04');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_04_comentarios = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_04_comentarios');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_05 = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_05');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_05_comentarios = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_05_comentarios');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_06 = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_06');
			$this->registro_actual->tsi_encuesta_seguimiento_field_seg_pregunta_06_comentarios = $this->input->post('tsi_encuesta_seguimiento_field_seg_pregunta_06_comentarios');
			$this->registro_actual->tsi_encuesta_seguimiento_estado_id = $this->input->post('tsi_encuesta_seguimiento_estado_id');

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
		
		//muestro js raiting
		$this->template['js_rating'] = TRUE;
	
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
		
		
		//------------ [5 estrellas] 
		$estrellas_5 = array(		1	=>'',
									2	=>'',
									3	=>'',
									4	=>'',
									5	=>''
		
		);
		$this->template['estrellas_5']=$estrellas_5;
		
		//------------ [si/no] 
		$si_no 		= array(		0	=>'',
									1	=>'No',
									2	=>'Sí'
		
		);
		$this->template['si_no']=$si_no;
		//------------ [si/no]

		//------------ [select / checkbox / radio tsi_encuesta_seguimiento_estado_id] :(
		$tsi_encuesta_seguimiento_estado=new Tsi_Encuesta_Seguimiento_Estado();
		$q = $tsi_encuesta_seguimiento_estado->get_all();
		$q->addWhere('id != ?',9); //sacamos los rechazados
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tsi_encuesta_seguimiento_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['tsi_encuesta_seguimiento_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tsi_encuesta_seguimiento_estado_id]
	
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
	private function _validar_formulario() {
		if($this->registro_actual)
		{
			$id=$this->registro_actual->id;
		}else{
			$id = FALSE;
		}
				
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));
		
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
				'trim|required|alpha_numeric|my_exist_unidad['.$this->input->post('unidad_field_vin').']' );
		
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
				'trim|required|exact_length[17]|alpha_numeric' );
		
		
		$this->form_validation->set_rules('tsi_id',$this->marvin->mysql_field_to_human('tsi_id'),
				'trim|requied|my_db_value_exist[Tsi.id]|callback_valid_tsi_fecha' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_entrevistador',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_entrevistador'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_01',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_01'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_02',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_02'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_03',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_03'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_04',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_04'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_04_comentarios',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_04_comentarios'),
				'trim|max_length[5000]' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_05',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_05'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_05_comentarios',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_05_comentarios'),
				'trim|max_length[5000]' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_06',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_06'),
				'trim' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_field_seg_pregunta_06_comentarios',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_seg_pregunta_06_comentarios'),
				'trim|max_length[5000]' );

		$this->form_validation->set_rules('tsi_encuesta_seguimiento_estado_id',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_estado_id'),
				'trim|requied|my_db_value_exist[Tsi_Encuesta_Seguimiento_Estado.id]' );


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
	
	//------ rechazando tarjeta de garantia
	private function _reject_record()
	{
		
		if(!$this->registro_actual || $this->registro_actual->tsi_encuesta_seguimiento_estado_id==9 || !$this->backend->_permiso('admin'))
		{
			return FALSE;
		}
		
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
				
				$this->registro_actual->tsi_encuesta_seguimiento_estado_id = 9;
				$this->registro_actual->tsi_encuesta_seguimiento_field_rechazo_motivo	= $this->input->post('rechazo_motivo');
				$this->registro_actual->tsi_encuesta_seguimiento_field_admin_rechaza_id	= $this->session->userdata('admin_id');
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
	
	
	function valid_tsi_fecha()
	{
		if($this->router->method == 'add' )
		{
			$this->form_validation->set_message('valid_tsi_fecha', $this->lang->line('form_seleccione'));
			$q = Doctrine_Query::create()
			->from('Tsi TSI')
			->leftJoin('TSI.Unidad UNIDAD')
			->where('TSI.id =  ?',$this->input->post('tsi_id'))
			->addWhere('UNIDAD.unidad_field_vin = ?',$this->input->post('unidad_field_vin'))
			->addWhere('UNIDAD.unidad_field_unidad = ?',$this->input->post('unidad_field_unidad'))
			->addWhere('(TO_DAYS(NOW()) - TO_DAYS(TSI.tsi_field_fecha_de_egreso)) <= ?',15)
			->WhereIn('TSI.sucursal_id', $this->session->userdata('sucursales'));
			if($q->count()!=1)
			{
				RETURN FALSE;
			}
		}
		RETURN TRUE;
	}
		
}       
