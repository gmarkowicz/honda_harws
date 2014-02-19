<?php
define('ID_SECCION',2011);
class Noticia_abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	

	//filtra por sucursal?
	var $sucursal = FALSE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;
		
	
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
				$this->registro_actual = new Noticia();
				$this->_grabar_registro_actual();
				$this->session->set_flashdata('add_ok', true);
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
			$this->registro_actual->noticia_field_titulo = $this->input->post('noticia_field_titulo');
			$this->registro_actual->noticia_field_copete = $this->input->post('noticia_field_copete');
			$this->registro_actual->noticia_field_desarrollo = $this->input->post('noticia_field_desarrollo');
			$this->registro_actual->noticia_field_fecha = $this->input->post('noticia_field_fecha');
			$this->registro_actual->backend_estado_id = $this->input->post('backend_estado_id');
			$this->registro_actual->noticia_seccion_id = $this->input->post('noticia_seccion_id');

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
		
		//imagenes
		if(isset($_FILES['noticia_imagen']) && $_FILES['noticia_imagen']['error']==FALSE){
			$this->_upload_imagen();
		}
	}
	//-------------------------[graba registro en la base de datos]
	//----------------------------------------------------------------

	//-----------------------------------------------------------------------------
	//-------------------------[vista generica abm]
	private function _view()
	{
		//$this->output->enable_profiler();
	
		$this->template['CKEDITOR'] = TRUE;
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

		//------------ [select / checkbox / radio backend_estado_id] :(
		$backend_estado=new Backend_Estado();
		$q = $backend_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('backend_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['backend_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio backend_estado_id]

		//------------ [select / checkbox / radio noticia_seccion_id] :(
		$noticia_seccion=new Noticia_Seccion();
		$q = $noticia_seccion->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('noticia_seccion_field_desc');
		$config['select'] = TRUE;
		$this->template['noticia_seccion_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio noticia_seccion_id]
		
		if($this->registro_actual)
		{
			#----- feo
			#despues de mucho renegar, no se como darle un order by por default a las imagenes asique....
			$imagenes= new Noticia_Imagen();
			$q=$imagenes->get_all();
			$q->addWhere('noticia_id = ?',$this->registro_actual->id);
			$q->orderBy('noticia_imagen_field_orden ASC');
			$resultado = $q->execute();
			$imagenes=array();
			foreach($resultado as $imagen) {
       			$imagenes[$imagen->id] = $imagen->toArray();
   			}
			$this->template['noticia_imagen'] = $imagenes;
			#----- feo
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

		$this->form_validation->set_rules('noticia_field_titulo',$this->marvin->mysql_field_to_human('noticia_field_titulo'),
				'trim|max_length[255]|required' );

		$this->form_validation->set_rules('noticia_field_copete',$this->marvin->mysql_field_to_human('noticia_field_copete'),
				'trim|max_length[5000]' );

		$this->form_validation->set_rules('noticia_field_desarrollo',$this->marvin->mysql_field_to_human('noticia_field_desarrollo'),
				'trim' );

		$this->form_validation->set_rules('noticia_field_fecha',$this->marvin->mysql_field_to_human('noticia_field_fecha'),
				'trim|my_form_date_reverse' );

		$this->form_validation->set_rules('backend_estado_id',$this->marvin->mysql_field_to_human('backend_estado_id'),
				'trim' );

		$this->form_validation->set_rules('noticia_seccion_id',$this->marvin->mysql_field_to_human('noticia_seccion_id'),
				'trim' );


		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------	
	
	//feo feo feo feo feo
	
	private function _upload_imagen()
	{
		
		
		$this->config->load('backend_images');
		$image_upload=$this->config->item('image_upload');
		$this->load->library('upload', $image_upload);
		$this->load->helper('string');
		$this->load->library('image_lib');
		
		if ( ! $this->upload->do_upload('noticia_imagen')){
				$this->session->set_flashdata('upload_error', $this->upload->display_errors());
		}else{
			
			$archivo_subido = $this->upload->data();
			$imagen_nuevo_nombre = url_title($this->registro_actual->noticia_field_titulo).'-'.random_string('unique');
			
			//----- agrego la imagen en la base
			
			$imagen=new Noticia_Imagen();
			
			$imagen->noticia_imagen_field_archivo = $imagen_nuevo_nombre;
			$imagen->noticia_imagen_field_extension = $archivo_subido['file_ext'];
			$imagen->noticia_id = $this->registro_actual->id;
			$imagen->noticia_imagen_field_orden = $this->registro_actual->Noticia_Imagen->count() + 1; //cantidad de imagenes actuales + 1
			$imagen->save();
			
			//----- agrego la imagen en la base
				
			$thumbs = $this->config->item('noticia_thumbs');
			while(list(,$config) = each($thumbs)){
				$this->image_lib->clear();
				$config['image_library'] = $this->config->item('image_library');
				$config['source_image'] = $archivo_subido['full_path'];
				$config['new_image'] = $this->config->item('image_path') . $imagen_nuevo_nombre .$archivo_subido['file_ext'];
				$this->image_lib->initialize($config);  // asignar parametros de configuracion a la libreria
				$this->image_lib->resize();
			}
			//unlink($archivo_subido['full_path']);
		}
		
			
		
	}
	
	//-------------------------[elimina imagen asociada a registro actual]
	// ajax y del()
	public function del_image($id_registro = FALSE, $id_imagen = FALSE){
		if(!$this->backend->_permiso('del') || !is_numeric($id_imagen)){
			$error=array();
			$error['line'] 			= __LINE__;
			$error['file'] 			= __FILE__;
			$error['error']			= 'itentando eliminar imagen sin permisos DEL y/o ID no numerica';
			$error['ID_REGISTRO']	= $id_registro;
			$error['ID_IMAGEN']		= $id_imagen;
			$this->backend->_log_error($error);
		}else{
			$this->_set_record($id_registro);
			$imagen = new Noticia_Imagen();
			$q = $imagen->get_all();
			$q->addWhere('id = ?',$id_imagen);
			$registro = $q->fetchOne();
			if(!$registro){
				$error=array();
				$error['line'] 			= __LINE__;
				$error['file'] 			= __FILE__;
				$error['error']			= 'No existe la imagen o no tiene permisos';
				$error['sql'] 			= $q->getSqlQuery();
				$error['ID_REGISTRO']	= $id_registro;
				$error['ID_IMAGEN']		= $id_imagen;
				$this->backend->_log_error($error);
			}else{
				$this->config->load('backend_images');
				//tomo los prefix de las imagenes para borrarlas todas del disco
				$thumbs = $this->config->item('noticia_thumbs');
				while(list(,$config) = each($thumbs)){
					@unlink($this->config->item('image_path').$registro->noticia_imagen_field_archivo.$config['thumb_marker'].$registro->noticia_imagen_field_extension);
				}
				if(!$registro->delete()){
					$error=array();
					$error['line'] 			= __LINE__;
					$error['file'] 			= __FILE__;
					$error['error']			= 'no puedo eliminar imagen';
					$error['ID_REGISTRO']	= $id_registro;
					$error['ID_IMAGEN']		= $id_imagen;
					$this->backend->_log_error($error);
				}else{
					$this->_reordenar_imagenes();
					if($this->input->post('ajax')){
						$this->output->set_output("TRUE");
					}
				}
				
			}	
		}
	}
	//-------------------------[/elimina imagen asociada a registro actual]
	
	//-------------------------[cambia datos de la imagen]
	// ajax
	public function edit_image($id_registro = FALSE, $id_imagen = FALSE){
		if(!$this->backend->_permiso('edit') || !is_numeric($id_imagen)){
			$error=array();
			$error['line'] 			= __LINE__;
			$error['file'] 			= __FILE__;
			$error['error']			= 'no tiene permidos edit y/o ID imagen no numerica';
			$error['ID_REGISTRO']	= $id_registro;
			$error['ID_IMAGEN']		= $id_imagen;
			$this->backend->_log_error($error);
		}else{
			$this->_set_record($id_registro);
			$imagen = new Noticia_Imagen();
			$q = $imagen->get_all();
			$q->addWhere('id = ?',$id_imagen);
			$registro = $q->fetchOne();
			if(!$registro){
				$this->session->set_flashdata('backend_error', true);
				$this->log_backend_error(
					__LINE__ , __FILE__ , 'No existe el registro o no tiene permisos ',$q->getSql() . ' ID = '.$id_imagen);
			}else{
				$registro->noticia_imagen_field_titulo=$this->input->post('noticia_imagen_titulo');
				$registro->noticia_imagen_field_copete=$this->input->post('noticia_imagen_copete');
				$registro->save();
				//le mando un TRUE al ajax para que informe
				$this->output->set_output("TRUE");
			}	
		}
	}
	//-------------------------[/cambia datos de la imagen]
	
	//-------------------------[le da un orden a las imagenes asociadas del registro]
	// ajax
	public function ordenar_imagenes($id = FALSE)
	{
		$this->_set_record($id);
		if($this->input->post('_noticia_imagen_orden')){
			$array = explode (",",$this->input->post('_noticia_imagen_orden'));
			$array = array_flip($array); // array (id_imagen=>imagen_orden)
			foreach($this->registro_actual->Noticia_Imagen as $imagen) {
				if(!isset($array[$imagen->id]) && is_numeric($array[$imagen->id])){
					$error=array();
					$error['line'] 			= __LINE__;
					$error['file'] 			= __FILE__;
					$error['error']			= 'no existe orden o no es numerico para '.$imagen->id;
					$error['ID_REGISTRO']	= $id;
					$this->backend->_log_error($error);
				}else{
					$imagen->noticia_imagen_field_orden = $array[$imagen->id]+1;
					$imagen->save();
				}
			}
			//por las dudas que quede algo colgado reordeno las imagenes
			$this->_reordenar_imagenes();
			//le mando un TRUE al ajax para que informe
			$this->output->set_output("TRUE");
		}
	}
	//-------------------------[le da un orden a las imagenes asociadas del registro]
	
	//-------------------------[ordena automaticamente las imagenes asociadas a un registro]
	//
	private function _reordenar_imagenes()
	{
		$imagenes = new Noticia_Imagen();
		$q = $imagenes->get_all();
		$q->addWhere('noticia_id = ?',$this->registro_actual->id);
		$q->orderBy('noticia_imagen_field_orden ASC');
		$resultado = $q->execute();
		$orden=0;
		foreach($resultado as $imagen) {
       		$imagen->noticia_imagen_field_orden=++$orden;
			$imagen->save();
		}
	}
	//----------------------------------------------------------------
	//-------------------------[ordena automaticamente las imagenes asociadas a un registro]
	
	
	
}       
