<?php
define('ID_SECCION',406);
class Comunicacion_Evento_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;

	//filtra por sucursal?
	var $sucursal = FALSE;

	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;

	/**
	 * Path al archivo subido
	 * @var string
	 */
	var $zip_path = null;

	//subfix de imagenes adjuntas
	var $upload_image = array('imagen');

	function __construct()
	{
		parent::Backend_Controller();

		$this->load->config('adjunto/upload_file_adjunto');
		$this->load->config('imagen/' . strtolower($this->model) . '_imagen');
		$this->template['imagen_path'] = str_replace(FCPATH,'',$this->config->item('image_path'));
	}



	//----------------------------------------------------------------
	//-------------------------[crea un registro a partir de post ]
	public function add()
	{
		$this->load->library('upload', $this->config->item('adjunto_upload'));

		if($this->input->post('_submit'))
		{
			if ($this->_validar_formulario() == TRUE)
			{
				$upload_result = $this->upload->do_upload('imagenes_zip');
				if ($upload_result)
				{
					$data = $this->upload->data();
					$this->zip_path = $data['full_path'];
				} else {
					$this->template['upload_error'] = $this->upload->display_errors();
				}
				if ($upload_result == true || $_FILES['imagenes_zip']['name']=='')
				{
					$this->registro_actual = new Comunicacion_Evento();
					$this->_grabar_registro_actual();
					$this->_delZip();
					$this->session->set_flashdata('add_ok', true);
					redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
				}
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

			$this->registro_actual->save();

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
		$this->template['registro_actual'] = $this->registro_actual;

		$this->template['imagenes'] = $this->registro_actual->Comunicacion_Evento_Imagen;

		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['main_url'] = $this->get_main_url();
		$this->template['tpl_include'] = 'backend/comunicacion_evento_show_view';
		$this->load->view('backend/esqueleto_view',$this->template);
	}


	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------

	//----------------------------------------------------------------
	//-------------------------[edita el registro]
	public function edit($id = FALSE)
	{
		$this->load->library('upload', $this->config->item('adjunto_upload'));

		$this->_set_record($id);
		if($this->input->post('_submit'))
		{
			//manda info
			if ($this->_validar_formulario() == TRUE)
			{
				$upload_result = $this->upload->do_upload('imagenes_zip');
				if ($upload_result)
				{
					$data = $this->upload->data();
					$this->zip_path = $data['full_path'];
				} else {
					$this->template['upload_error'] = $this->upload->display_errors();
					$upload_result = false;
				}
				if ($upload_result == true || $_FILES['imagenes_zip']['name']=='')
				{
					//pasa validacion, grabo y redirecciono a edit
					$this->_grabar_registro_actual();
					$this->_delZip();
					$this->session->set_flashdata('edit_ok', true);
					redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
				}
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
				$this->registro_actual->comunicacion_evento_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->comunicacion_evento_field_fechahora_alta = date('Y-m-d H:i:s');
				$this->registro_actual->created_at = date('Y-m-d H:i:s');
			} else if($this->router->method == 'edit' )
			{
				$this->registro_actual->comunicacion_evento_field_admin_modifica_id = $this->session->userdata('admin_id');
				$this->registro_actual->comunicacion_evento_field_fechahora_modificacion = date('Y-m-d H:i:s');
				$this->registro_actual->updated_at = date('Y-m-d H:i:s');
			}

			$this->registro_actual->comunicacion_evento_field_desc = $this->input->post('comunicacion_evento_field_desc');
			$this->registro_actual->comunicacion_evento_field_fecha = date('Y-m-d H:i:s', strtotime($this->input->post('comunicacion_evento_field_fecha')));
			$this->registro_actual->save();

			$conn->commit();

			if ($this->registro_actual->id)
			{
				if ($this->zip_path != '')
				{
					$this->_procesarZip();
				}
				$this->backend->upload_images();
			}
		}
		catch(Doctrine_Exception $e)
		{
			$conn->rollback();
			$this->_delZip();
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['sql'] 		= 'transaction';
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}
		$this->_delZip();
	}

	public function del_image( $id_registro = FALSE, $id_imagen= FALSE, $subfix = 'image'  )
	{
		$rs	= $this->backend->del_image($id_registro, $id_imagen, 'imagen');
	}

	private function _procesarZip()
	{
		$conn = Doctrine_Manager::connection();
		$q = $conn->createQuery()
			->update('comunicacion_evento_imagen')
			->select('MAX(comunicacion_evento_imagen_field_orden) as max')
			->where('comunicacion_evento_id = ?', $this->registro_actual->id);
		$offset = $q->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

		$tmp_folder = sys_get_temp_dir();
		$zip = new ZipArchive;
		$res = $zip->open($this->zip_path);

		if ($res === TRUE) {
			$files = array();
			for ($i = 0; $i < $zip->numFiles; $i++)
			{
				$files[$i] = $tmp_folder.DIRECTORY_SEPARATOR.$zip->getNameIndex($i);
			}
			$zip->extractTo($tmp_folder);

			$this->load->library('image_lib');

			foreach ($files as $key => $file)
			{
				$file_info = pathinfo($file);
				$new_name = $this->registro_actual->id . '-' . uniqid();
				$new_file = $this->config->item('image_path') . $new_name . '_full.' . $file_info['extension'];

				if (in_array(strtolower($file_info['extension']), array('png','gif','jpg')))
				{
					$configs = $this->config->item('comunicacion_evento_thumbs');
					foreach ($configs as $config)
					{
						$config['image_library'] = $this->config->item('image_library');;
						$config['source_image'] = $file;
						if (isset($config['proccess']) && $config['proccess'] == false)
						{
							$config['new_image'] = $this->config->item('image_path') . $new_name . $config['thumb_marker'] . '.' . $file_info['extension'];
							@copy($config['source_image'], $config['new_image']);
						} else {
						$config['new_image'] = $this->config->item('image_path') . $new_name . '.' . $file_info['extension'];
							$this->image_lib->initialize($config);
							$this->image_lib->resize();
							$this->image_lib->clear();
						}
					}
				}

				$evento_imagen = new Comunicacion_Evento_Imagen();
				$evento_imagen->set('comunicacion_evento_imagen_field_archivo', $new_name);
				$evento_imagen->set('comunicacion_evento_imagen_field_extension', '.'.$file_info['extension']);
				$evento_imagen->set('comunicacion_evento_imagen_field_desc', $this->_cleanFileName($file_info['filename']));
				$evento_imagen->set('comunicacion_evento_imagen_field_orden', ($key + $offset['max'] + 1));
				$evento_imagen->set('comunicacion_evento_id', $this->registro_actual->id);
				$evento_imagen->set('created_at', date('Y-m-d H:i:s'));
				$evento_imagen->set('updated_at', date('Y-m-d H:i:s'));
				$evento_imagen->save();

				@unlink($file);
			}
		}
		unset($zip);
		$this->_delZip();
	}

	/**
	 * Limpia una cadena de texto
	 * @param string $title
	 * @return string
	 */
	private function _cleanFileName($title)
	{
		$title = strtolower($title);
		$title = str_replace("[áàâãª]","a",$title);
		$title = str_replace("[íìî]","i",$title);
		$title = str_replace("[éèê]","e",$title);
		$title = str_replace("[óòôõº]","o",$title);
		$title = str_replace("[úùû]","u",$title);
		$title = str_replace("ç","c",$title);
		$title = str_replace("ñ","n",$title);
		$title = str_replace("ano","anio",$title);
		$title = preg_replace('/&.+?;/', '', $title); // kill entities
		$title = preg_replace('/[^a-z0-9 -]/', '', $title);
		$title = trim($title);
		$title = str_replace(' ', '_', $title);
		$title = preg_replace('|-+|', '_', $title);
		return $title;
	}

	private function _delZip()
	{
		@unlink($this->zip_path);
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
		if ($this->registro_actual)
		{
			$this->template['comunicacion_evento_imagen'] = $this->registro_actual->Comunicacion_Evento_Imagen;
		}
		if($this->rechazar_registro === TRUE){
			$this->template['SHOW_RECHAZAR_REGISTRO'] = TRUE;
		}
		else
		{
			$this->template['SHOW_RECHAZAR_REGISTRO'] = FALSE;
		}

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

		$this->form_validation->set_rules('comunicacion_evento_field_desc',$this->marvin->mysql_field_to_human('comunicacion_evento_field_desc'),
				'trim|max_length[255]|required' );

		$this->form_validation->set_rules('comunicacion_evento_field_fecha',$this->marvin->mysql_field_to_human('comunicacion_evento_field_fecha'),
				'trim|my_form_date_reverse|required' );


		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------
}
