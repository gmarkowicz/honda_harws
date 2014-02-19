<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Flexigrid CodeIgniter implementation
 *
 * PHP version 5
 *
 * @category  CodeIgniter
 * @package   Backend CI
 * @author    Santiago (slopez@boxdata.com.ar)
 * @version   0.1
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
*/
class Backend
{
	/**
	* Constructor
	*
	* @access	public
	*/

	public function Backend()
    {
		$this->CI =& get_instance();
		
		//
		$this->CI->output->set_header('Pragma: no-cache');
		$this->CI->output->set_header('Cache-Control: no-cache, must-revalidate');
		$this->CI->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');


		
		
		log_message('debug', "Backend Class Initialized");
		$this->_log_user();
		$this->_verificar_permisos();
		$this->_contar_admin_online();
		$this->CI->lang->load('backend');
		$this->_prevenir_delete();
		

		$this->files_config = $this->CI->config->item('backend_files_config');

	}



	private function _verificar_permisos()
	{

		if(!$this->CI->session->userdata('backend_login') || $this->CI->session->userdata('backend_login')!=TRUE ){
			//las sessiones de CI sucks (tarde)
			//@session_destroy();

			//TODO
			//ha no pero que cabeza que sos
			if($this->CI->marvin->isset_ajax())
			{
				echo '<script type="text/javascript">
						<!--
						//'.$this->CI->router->method.'
						//'.$this->CI->router->class.'
						window.location = "'.$this->CI->config->item('base_url').
											$this->CI->config->item('backend_root').'login"

						//-->
						</script>
						';
				exit;
			}

			redirect(
			$this->CI->config->item('base_url').
			$this->CI->config->item('backend_root') .
			'login'
			);

		}
		else
		{
			//tomo el admin
			//
			$admin = Doctrine::getTable('Admin')->findOneByid($this->CI->session->userdata('admin_id'));
			if(!$admin)
			{
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= 'no puedo tomar el admin';
				$this->_log_error($error);
				show_error($error['error']);
			}
		}
		/*
		//actualizo ultima actividad
		$q = Doctrine_Query::create()
        ->update('Admin')
        ->set('admin_field_fechahora_ultima_actividad', '?', date('Y-m-d H:i:s', time()) )
        ->where('id = ?',$admin->id)
		->execute();
		*/
		//$admin->admin_field_fechahora_ultima_actividad =  date('Y-m-d H:i:s', time());
		//$admin->save();



		if(defined('ID_SECCION')){

			$permisos=$this->CI->session->userdata('permisos');

			if(!isset($permisos[ID_SECCION]) || $permisos[ID_SECCION]['view']!=1){

				$this->CI->session->set_flashdata('permisos_insuficientes', true);
				$error=array();
				$error['line'] 			= __LINE__;
				$error['file'] 			= __FILE__;
				$error['error']			= 'itentando acceder a seccion sin permisos';
				$error['ID_SECCION']	= ID_SECCION;
				$this->_log_error($error);
				$this->CI->session->unset_userdata();
				redirect($this->CI->config->item('base_url').$this->CI->config->item('backend_root') .'login');
			}

			/*
			//ejemplo $permisos[1][add];
			if(isset($permisos[ID_SECCION][$this->CI->router->method]))
			{
				//exepcion... en caso de que haya agregado el registro, lo dejamos actualizarlo
				if($this->CI->session->userdata('last_add_'.$this->CI->router->class) != $this->CI->uri->segment(4))
				{

					if($permisos[ID_SECCION][$this->CI->router->method]!='1'){
						$this->CI->session->set_flashdata('permisos_insuficientes', true);
						$error=array();
						$error['line'] 			= __LINE__;
						$error['file'] 			= __FILE__;
						$error['error']			= 'intentando acceder a seccion sin permisos';
						$error['ID_SECCION']	= ID_SECCION;
						$this->_log_error($error);
						$this->CI->session->unset_userdata();
						redirect($this->CI->config->item('base_url').$this->CI->config->item('backend_root') .'login');
					}
				}
			}
			*/
			
			//ejemplo $permisos[1][add];
			//ejemplo $permisos[1][add];
			if(isset($permisos[ID_SECCION][$this->CI->router->method]))
			{
				
				if($permisos[ID_SECCION][$this->CI->router->method]!=1)
				{
					
					$lasts = $this->CI->session->userdata('last_add_' . $this->CI->router->class );
					if(!is_array($lasts))
						$lasts = array();
					
					//exepcion... en caso de que haya agregado el registro, lo dejamos actualizarlo
					if($this->CI->router->method == 'edit' && in_array($this->CI->uri->segment(4),$lasts))
					{
					
					}
					else
					{
						$this->CI->session->set_flashdata('permisos_insuficientes', true);
						$error=array();
						$error['line'] 			= __LINE__;
						$error['file'] 			= __FILE__;
						$error['error']			= 'intentando acceder a seccion sin permisos';
						$error['ID_SECCION']	= ID_SECCION;
						$this->_log_error($error);
						$this->CI->session->unset_userdata();
						redirect($this->CI->config->item('base_url').$this->CI->config->item('backend_root') .'login');
					}
				}
				
				
			}
			
			
			
			
			
			//existe la seccion, ya que estamos tomamos el nombre
			$be = Doctrine::getTable('Backend_Menu')->findOneByid(ID_SECCION);
			if(!$be)
			{
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= 'no puedo tomar seccuib';
				$this->_log_error($error);
				show_error($error['error']);
			}
			$this->CI->template['SECCION_ACTUAL'] = $be->backend_menu_field_desc;
			if($be->getNode()->hasParent())
			{
				$this->CI->template['AREA_ACTUAL'] = $be->getNode()->getParent()->backend_menu_field_desc;
			}



		}
	}



	public function _contar_admin_online()
	{

		$tiempo = time() - (60 * 10); 
		
		//revisar esto q no anda
		$q = Doctrine_Core::getTable('ci_sessions')
		->createQuery('a')
		->select('COUNT(*)')
		->where("last_activity > '".$tiempo."'")
		->addWhere("user_data != ?",'');

		$this->CI->template['BACKEND_ADMINS_ONLINE'] = $q->fetchOne(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
		$this->CI->template['BACKEND_FECHA_ACTUAL']=$this->CI->marvin->mysql_date_to_human(date("Y-m-d"));
	}

	//---------------------------------------------------------
	//string = view || add || edit || del || admin ||
	//verifica los permisos del admin contra determinada seccion
	public function _permiso($string,$id_seccion=FALSE)
	{

		if(!defined('ID_SECCION') && !$id_seccion){
			return FALSE;
		}
		if($id_seccion){
			$seccion=$id_seccion;
		}else{
			$seccion=ID_SECCION;
		}

		$permisos=$this->CI->session->userdata('permisos');
		if(isset($permisos[$seccion][$string]) && $permisos[$seccion][$string]==1){
			return TRUE;
		}

		return FALSE;
	}

	public function _grid_links($id_registro,$params = array())
	{
		if(!defined('ID_SECCION')){
			return FALSE;
		}
		if(isset($params['no_link']))
		{
			return "";
		}
		$return ="";
		$permisos=$this->CI->session->userdata('permisos');
		// TODO revisar si existe el metodo show antes de rediccionarlo
		//ojito para ver

		//var_dump(method_exists('tsi_encuesta_seguimiento_abm','show'));
		//echo strtolower($this->CI->model . '_Abm');
		$return .= '<a href="'.$this->CI->get_abm_url().'/show/'.$id_registro.'" class="grid_link_view" title="ver" id="'.$id_registro.'"><img src="'.$this->CI->config->item('base_url').'/public/images/icons/eye.png" alt="Ver"></a>'."\n";


		if(isset($permisos[ID_SECCION]['edit']) && $permisos[ID_SECCION]['edit']=='1'){
			//lapiz editar
			$return .= '<a href="'.$this->CI->get_abm_url().'/edit/'.$id_registro.'" class="grid_link_edit" title="editar" id="'.$id_registro.'"><img src="'.$this->CI->config->item('base_url').'/public/images/icons/pencil.png" alt="Editar"></a>'."\n";
		}
		return $return;
	}
	//---------------------------------------------------------

	//---------------------------------------------------------
	//impide delete si antes no edito el registro
	public function _prevenir_delete()
	{
		if($this->CI->router->method=='edit')
		{
			$this->CI->session->set_userdata('last_'.$this->CI->router->class, $this->CI->uri->segment(4));
		}
		else if($this->CI->router->method=='del')
		{
			if(!$this->CI->session->userdata('last_'.$this->CI->router->class) || ($this->CI->session->userdata('last_'.$this->CI->router->class)!=$this->CI->input->post('id'))  )
			{
				$error=array();
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= 'intentando eliminar registro sin haberlo visualizado';
				$error['ID_SECCION']   = ID_SECCION;
				$this->_log_error($error);
				redirect($this->CI->config->item('base_url').$this->CI->config->item('backend_root') .'login');
			}
		}
	}
	//---------------------------------------------------------


	//escribe log en system/logs
	public function _log_error($array = array())
	{
		$error="\n";
		while(list($key,$mensaje) = each($array)){
			$error.=$key . ": " . $mensaje ."\n";
		}
		$error.= 'admin id: '	. $this->CI->session->userdata('admin_id')	."\n";
		$error.= 'funcion: '		. $this->CI->router->method					."\n";
		$error.= 'clase: '	. $this->CI->router->class					."\n";
		$error.= '_GET:' ."\n";
		if(!isset($_GET) || !is_array($_GET) || count($_GET)==0){
			$error.= "\t no se encontraron datos\n";
		}else{
			reset($_GET);
			while(list($key,$val)=each($_GET)){
				$error.= "\t ".$key.": \t ".$val."\n";
			}
		}
		$error.= '_POST:' ."\n";
		if(!isset($_POST) || !is_array($_POST) || count($_POST)==0){
			$error.= "\t no se encontraron datos\n";
		}else{
			reset($_POST);
			while(list($key,$val)=each($_POST)){
				if(is_array($val))
				{
					$error.= "\t ".$key.": \t ".$this->implode_r(",", $val)."\n";
				}
				else
				{
					$error.= "\t ".$key.": \t ".$val."\n";
				}
				
			}
		}
		$error.= '_SERVER:' ."\n";
		if(!isset($_SERVER) || !is_array($_SERVER) || count($_SERVER)==0){
			$error.= "\t no se encontraron datos\n";
		}else{
			reset($_SERVER);
			while(list($key,$val)=each($_SERVER)){
				if(is_array($val))
				{
					$error.= "\t ".$key.": \t ".$this->implode_r(",", $val)."\n";
				}
				else
				{
					$error.= "\t ".$key.": \t ".$val."\n";
				}
			}
		}
		$error.= '_SESSION:' ."\n";
		$session = $this->CI->session->all_userdata();
		if(!isset($session) || !is_array($session) || count($session)==0){
			$error.= "\t no se encontraron datos\n";
		}else{
			reset($session);
			while(list($key,$val)=each($session)){
				if(is_array($val))
				{
					$error.= "\t ".$key.": \t ".$this->implode_r(",", $val)."\n";
				}
				else
				{
					$error.= "\t ".$key.": \t ".$val."\n";
				}
			}
		}
		$error.= '_____________'											."\n";
		log_message('error',$error);
		$this->CI->session->set_flashdata('backend_error', true);
	}

	/*
	multiple upload de adjuntos
	graba adjuntos en la base
	*/

	public function upload_adjuntos()
	{
		//un par de chequeos :O
		if(!$this->CI->registro_actual || !$this->isset_adjunto())
		{
			RETURN FALSE;
		}

		$this->CI->load->helper('inflector');

		$this->CI->load->library('upload');
		$this->CI->lang->load('upload');
		$this->CI->load->helper('string');
		$this->CI->load->library('Multi_upload');

		reset($this->CI->upload_adjunto);
		while(list(,$subfix) = each($this->CI->upload_adjunto))
		{

			//TODO DONT DRY
			$modelo = strtolower($this->CI->model);
			$prefix_field = '_' . strtolower($subfix); // _adjunto
			//$subfix_model = '_' . ucfirst(strtolower($subfix)); // _Adjunto
			$subfix_model = '_' . str_replace(' ','_',humanize($subfix));


			$this->CI->config->load('adjunto/' . $modelo . $prefix_field);
			$this->CI->upload->initialize($this->CI->config->item('adjunto_upload'));

			$files = $this->CI->multi_upload->go_upload($modelo . $prefix_field);
			if ( ! $files )
			{
				$data = $this->CI->upload->data();
				$this->CI->session->set_flashdata('upload_error', $this->CI->multi_upload->display_errors() .' ' .@$data['file_type']);
			}
			else
			{
				$resultado = array('upload_data' => $files);
				while(list(,$archivo) = each($resultado['upload_data']))
				{
					//no se porq a veces viene con un punto
					$archivo['ext'] = str_replace(".",'',$archivo['ext']);

					$nuevo_nombre = url_title($this->CI->registro_actual->id . '-' . str_replace('.'.$archivo['ext'],'',$archivo['name']) . '-'. random_string('unique') );
					copy($archivo['file'], $this->CI->config->item('adjunto_path') . $nuevo_nombre . '.' . $archivo['ext']);
					unlink($archivo['file']);

					//---[grabo el adjunto en la base]
					$doctrine_model = $this->CI->model . $subfix_model;
					$objeto=new $doctrine_model();

					$row_archivo 	= $modelo . $prefix_field . $this->files_config['archivo'];
					$objeto->$row_archivo = $nuevo_nombre;

					$row_extension 	= $modelo . $prefix_field . $this->files_config['extension'];
					$objeto->$row_extension  = $archivo['ext'];

					$row_relacion_id = $modelo . '_id';
					$objeto->$row_relacion_id = $this->CI->registro_actual->id;

					//TODO no estoy ordenando

					$objeto->save();
					//---[grabo el adjunto en la base]

				}


			}
		}
	}


	/*
	multiple upload de imagenes
	estala imagenes subidas
	graba imagenes en la base
	*/

	public function upload_images()
	{

		if(!$this->CI->registro_actual || !$this->isset_image())
		{
			RETURN FALSE;
		}

		$this->CI->load->helper('inflector');

		reset($this->CI->upload_image);
		while(list(,$subfix) = each($this->CI->upload_image))
		{

			$modelo = strtolower($this->CI->model);
			$prefix_field = '_' . strtolower($subfix); // _imagen
			//$subfix_model = '_' . ucfirst(strtolower($subfix)); // _Imagen
			$subfix_model = '_' . str_replace(' ','_',humanize($subfix));




			$this->CI->config->load('imagen/' . $modelo . $prefix_field);
			$this->CI->load->library('upload' );
			$this->CI->upload->initialize($this->CI->config->item('image_upload'));
			$this->CI->load->library('Multi_upload');

			$this->CI->load->helper('string');
			$this->CI->load->library('image_lib');
			$this->CI->lang->load('upload');

			$files = $this->CI->multi_upload->go_upload($modelo . $prefix_field);
			if ( ! $files )
			{


				//TODO REVISAR ESTO NO ESTA VALIDANDO ALGUNOS ERRORES (MAX WIDTH por ejemplo)
				$this->CI->session->set_flashdata('upload_error', $this->CI->multi_upload->display_errors());
				//problema cuando es mas de un input con imagen, comentado el return para que siga el bucle
				//RETURN FALSE;
			}
			else
			{
				$resultado = array('upload_data' => $files);
				while(list(,$archivo) = each($resultado['upload_data']))
				{
					$nuevo_nombre = url_title($this->CI->registro_actual->id . '-' . str_replace('.'.$archivo['ext'],'',$archivo['name']) . '-'. random_string('unique') );

					//---[escalo imagen subida]
					$thumbs = $this->CI->config->item($modelo . '_thumbs');
					while(list(,$config) = each($thumbs))
					{
						$this->CI->image_lib->clear();
						$config['image_library'] = $this->CI->config->item('image_library');
						$config['source_image'] = $archivo['file'];

						if (isset($config['proccess']) && $config['proccess'] == false)
						{
							$config['new_image'] = $this->CI->config->item('image_path') . $nuevo_nombre . $config['thumb_marker'] .$archivo['ext'];
							@copy($config['source_image'], $config['new_image']);
						} else {
							$config['new_image'] = $this->CI->config->item('image_path') . $nuevo_nombre .$archivo['ext'];
							$this->CI->image_lib->initialize($config);  // asignar parametros de configuracion a la libreria
							$this->CI->image_lib->resize();
						}
					}
					@unlink($archivo['file']);
					//---[escalo imagen subida]

					//---[grabo la imagen en la base]
					$doctrine_model = $this->CI->model . $subfix_model;
					$objeto=new $doctrine_model();

					$row_archivo 	= $modelo . $prefix_field . $this->files_config['archivo'];
					$objeto->$row_archivo = $nuevo_nombre;

					$row_extension 	= $modelo . $prefix_field . $this->files_config['extension'];
					$objeto->$row_extension  = $archivo['ext'];

					$row_relacion_id = $modelo . '_id';
					$objeto->$row_relacion_id = $this->CI->registro_actual->id;

					$row_orden 		= $modelo . $prefix_field  . $this->files_config['orden'];
					$tabla = $this->CI->model . $subfix_model;
					$objeto->$row_orden = $this->CI->registro_actual->$tabla->count() + 1; //cantidad de imagenes actuales + 1
					$objeto->save();
					//---[grabo la imagen en la base]

				}

				//RETURN TRUE;
			}
		}

	}


	//-------------------------[le da un orden a las imagenes asociadas del registro]
	// ajax
	public function ordenar_imagenes($id = FALSE, $table = 'imagen')
	{

		$this->CI->load->helper('inflector');
		$modelo = strtolower($this->CI->model);
		$prefix_field = '_' . strtolower($table); // _imagen
		//$subfix_model = '_' . ucfirst(strtolower($table)); // _Imagen
		$subfix_model = '_' . str_replace(' ','_',humanize($table));


		$this->CI->_set_record($id);
		if($this->CI->input->post('_'.$modelo . $prefix_field . $this->files_config['orden'])){ //_noticia_imagen_field_orden
			$array = explode (",",$this->CI->input->post('_'.$modelo . $prefix_field .  $this->files_config['orden']));
			$array = array_flip($array); // array (id_imagen=>imagen_orden)

			$tabla = $this->CI->model . $subfix_model;
			foreach($this->CI->registro_actual->$tabla as $imagen) {
				if(!isset($array[$imagen->id]) && is_numeric($array[$imagen->id])){
					$error=array();
					$error['line'] 			= __LINE__;
					$error['file'] 			= __FILE__;
					$error['error']			= 'no existe orden o no es numerico para '.$imagen->id;
					$error['ID_REGISTRO']	= $id;
					$this->_log_error($error);
				}else{
					$row_orden 		= $modelo . $prefix_field  . $this->files_config['orden'];
					$nuevo_orden = $array[$imagen->id]+1;
					$imagen->$row_orden = $nuevo_orden;
					$imagen->save();
				}
			}
			//por las dudas que quede algo colgado reordeno las imagenes
			//$this->_reordenar_imagenes($table);
			//le mando un TRUE al ajax para que informe
			$this->CI->output->set_output("TRUE");
		}
	}
	//-------------------------[le da un orden a las imagenes asociadas del registro]

	//-------------------------[ordena automaticamente las imagenes asociadas a un registro]
	//
	private function _reordenar_imagenes($table = 'imagen')
	{


		//TODO dont DRY
		$this->CI->load->helper('inflector');
		$modelo = strtolower($this->CI->model);
		$prefix_field = '_' . strtolower($table); // _imagen
		//$subfix_model = '_' . ucfirst(strtolower($table)); // _Imagen
		$subfix_model = '_' . str_replace(' ','_',humanize($table));

		$doctrine_model = $this->CI->model . $subfix_model;
		$row_orden 		= $modelo . $prefix_field  . $this->files_config['orden'];

		$imagenes = new $doctrine_model();

		$q = $imagenes->get_all();
		$q->addWhere($modelo . '_id = ?',$this->CI->registro_actual->id);
		$q->orderBy( $row_orden . ' ASC');
		$resultado = $q->execute();
		$orden=0;
		foreach($resultado as $imagen) {
       		$imagen->$row_orden=++$orden;
			$imagen->save();
		}
	}
	//----------------------------------------------------------------
	//-------------------------[ordena automaticamente las imagenes asociadas a un registro]


	//-------------------------[elimina imagen asociada a registro actual]
	public function del_image($id_registro = FALSE, $id_imagen = FALSE, $table = 'imagen')
	{

		if(!$this->isset_image() && !in_array($table,$this->CI->upload_image))
		{
			RETURN FALSE;
			//TODO log error
		}


		$this->CI->load->helper('inflector');
		//TODO dont DRY
		$modelo = strtolower($this->CI->model);
		$prefix_field = '_' . strtolower($table); // _imagen
		//$subfix_model = '_' . ucfirst(strtolower($table)); // _Imagen
		$subfix_model = '_' . str_replace(' ','_',humanize($table));

		if(!$this->_permiso('del') || !is_numeric($id_imagen))
		{
			$error=array();
			$error['line'] 			= __LINE__;
			$error['file'] 			= __FILE__;
			$error['error']			= 'itentando eliminar imagen sin permisos DEL y/o ID no numerica';
			$error['ID_REGISTRO']	= $id_registro;
			$error['ID_IMAGEN']		= $id_imagen;
			$this->_log_error($error);
		}else{

			$this->CI->_set_record($id_registro);

			$doctrine_model = $this->CI->model . $subfix_model;


			$imagen = new $doctrine_model();
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
				$this->_log_error($error);
			}else{
				$this->CI->config->load('imagen/' . $modelo . $prefix_field );
				//tomo los prefix de las imagenes para borrarlas todas del disco
				$thumbs = $this->CI->config->item($modelo . '_thumbs');
				while(list(,$config) = each($thumbs))
				{
					$row_archivo 	= $modelo . $prefix_field . $this->files_config['archivo'];
					$row_extension 	= $modelo . $prefix_field . $this->files_config['extension'];
					//le cambio el nombre por las dudas
					@rename(
						$this->CI->config->item('image_path') . $registro->$row_archivo . $config['thumb_marker'] . $registro->$row_extension,
						$this->CI->config->item('image_path') . '_DELETED_' .$registro->$row_archivo . $config['thumb_marker'] . $registro->$row_extension
						);
				}
				// por si tiene una imagen original
				@rename(
						$this->CI->config->item('image_path') . $registro->$row_archivo . '_full' . $registro->$row_extension,
						$this->CI->config->item('image_path') . '_DELETED_' .$registro->$row_archivo . '_full' . $registro->$row_extension
				);
				if(!$registro->delete()){
					$error=array();
					$error['line'] 			= __LINE__;
					$error['file'] 			= __FILE__;
					$error['error']			= 'no puedo eliminar imagen';
					$error['ID_REGISTRO']	= $id_registro;
					$error['ID_IMAGEN']		= $id_imagen;
					$this->_log_error($error);
				}else{
					$this->_reordenar_imagenes($table);
					if($this->CI->input->post('ajax')){
						$this->CI->output->set_output("TRUE");
					}
				}

			}
		}
	}
	//-------------------------[/elimina imagen asociada a registro actual]



	//-------------------------[elimina adjunto asociado a registro actual]
	public function del_adjunto($id_registro = FALSE, $id_adjunto = FALSE, $table = 'adjunto')
	{

		if(!$this->isset_adjunto() || !in_array($table,$this->CI->upload_adjunto))
		{
			RETURN FALSE;
			//TODO log error
		}
		$this->CI->load->helper('inflector');
		//TODO dont DRY
		$modelo = strtolower($this->CI->model);
		$prefix_field = '_' . strtolower($table); // _adjunto
		//$subfix_model = '_' . ucfirst(strtolower($table)); // _Adjunto
		$subfix_model = '_' . str_replace(' ','_',humanize($table));

		if(!$this->_permiso('del') || !is_numeric($id_adjunto))
		{
			$error=array();
			$error['line'] 			= __LINE__;
			$error['file'] 			= __FILE__;
			$error['error']			= 'itentando eliminar adjunto sin permisos DEL y/o ID no numerica';
			$error['ID_REGISTRO']	= $id_registro;
			$error['ID_ADJUNTO']	= $id_adjunto;
			$this->_log_error($error);
		}else{
			$this->CI->_set_record($id_registro);
			$doctrine_model = $this->CI->model . $subfix_model;
			$adjunto = new $doctrine_model();
			$q = $adjunto->get_all();
			$q->addWhere('id = ?',$id_adjunto);
			$registro = $q->fetchOne();
			if(!$registro){
				$error=array();
				$error['line'] 			= __LINE__;
				$error['file'] 			= __FILE__;
				$error['error']			= 'No existe el adjunto';
				$error['sql'] 			= $q->getSqlQuery();
				$error['ID_REGISTRO']	= $id_registro;
				$error['ID_ADJUNTO']	= $id_adjunto;
				$this->_log_error($error);
			}else{
				$this->CI->config->load('adjunto/' . $modelo . $prefix_field );
				$row_archivo 	= $modelo . $prefix_field . $this->files_config['archivo'];
				$row_extension 	= $modelo . $prefix_field . $this->files_config['extension'];
				//le cambio el nombre por las dudas
				@rename(
						$this->CI->config->item('adjunto_path') . $registro->$row_archivo . '.' . $registro->$row_extension,
						$this->CI->config->item('adjunto_path') . '_DELETED_' .$registro->$row_archivo . '.' . $registro->$row_extension
						);

				if(!$registro->delete()){
					$error=array();
					$error['line'] 			= __LINE__;
					$error['file'] 			= __FILE__;
					$error['error']			= 'no puedo eliminar Adjunto';
					$error['ID_REGISTRO']	= $id_registro;
					$error['ID_ADJUNTO']		= $id_adjunto;
					$this->_log_error($error);
				}else{
					if($this->CI->input->post('ajax')){
						$this->CI->output->set_output("TRUE");
					}
				}

			}
		}
	}
	//-------------------------[elimina adjunto asociado a registro actual]




	//-------------------------[cambia datos de la imagen]
	// ajax
	public function edit_image($id_registro = FALSE, $id_archivo = FALSE, $table = 'imagen'){


		if(!$this->isset_image() || !in_array($table,$this->CI->upload_image))
		{
			RETURN FALSE;
			//TODO log error
		}

		$this->CI->load->helper('inflector');
		//TODO dont DRY
		$modelo = strtolower($this->CI->model);
		$prefix_field = '_' . strtolower($table); // _imagen
		//$subfix_model = '_' . ucfirst(strtolower($table)); // _Imagen
		$subfix_model = '_' . str_replace(' ','_',humanize($table));


		if(!$this->_permiso('edit') || !is_numeric($id_archivo)){
			$error=array();
			$error['line'] 			= __LINE__;
			$error['file'] 			= __FILE__;
			$error['error']			= 'no tiene permidos edit y/o ID imagen no numerica';
			$error['ID_REGISTRO']	= $id_registro;
			$error['ID_ARCHIVO']		= $id_archivo;
			$this->_log_error($error);
		}else{
			$this->CI->_set_record($id_registro);
			$doctrine_model = $this->CI->model . $subfix_model;
			$objeto = new $doctrine_model();
			$q = $objeto->get_all();
			$q->addWhere('id = ?',$id_archivo);
			$registro = $q->fetchOne();
			if(!$registro){
				$this->CI->session->set_flashdata('backend_error', true);
				$error=array();
				$error['line'] 			= __LINE__;
				$error['file'] 			= __FILE__;
				$error['error']			= 'no existe el archivo a editar';
				$error['ID_REGISTRO']	= $id_registro;
				$error['ID_ARCHIVO']		= $id_archivo;
				$this->_log_error( $error);
			}else{
				$row_titulo = $modelo . $prefix_field . $this->files_config['titulo'] ;
				$row_copete = $modelo . $prefix_field . $this->files_config['copete'] ;;

				$registro->$row_titulo	=	$this->CI->input->post('imagen_titulo');
				$registro->$row_copete	=	$this->CI->input->post('imagen_copete');
				$registro->save();
				//le mando un TRUE al ajax para que informe
				$this->CI->output->set_output("TRUE");
			}
		}
	}
	//-------------------------[/cambia datos de la imagen]


	public function get_files_config($item = FALSE)
	{
		if(isset($this->files_config[$item]))
		{
			RETURN $this->files_config[$item];
		}
		return $this->files_config;
	}

	public function isset_adjunto()
	{
		if(!isset($this->CI->upload_adjunto) || !is_array($this->CI->upload_adjunto) || count($this->CI->upload_adjunto)<1)
		{
			RETURN FALSE;
		}

		RETURN TRUE;
	}

	public function isset_image()
	{
		if(!isset($this->CI->upload_image) || !is_array($this->CI->upload_image) || count($this->CI->upload_image)<1)
		{
			RETURN FALSE;
		}

		RETURN TRUE;
	}


	private function _log_user()
	{
	
		if(is_numeric($this->CI->session->userdata('admin_id')))
		{
			$file = APPPATH . 'tmp/userlog/' .$this->CI->session->userdata('admin_id') . '.log';
			$log = fopen ($file, "a") or die(__LINE__.__FILE__.'error generando log'); 
			
			fputs($log,date("d/m/Y H:i:s")."\n");
			fputs($log,'_PAGINA: '.$_SERVER["PHP_SELF"]."\n");
			fputs($log,"_GET:\n");
			if(isset($_GET))
			{
				foreach($_GET as $varName => $value) 
				{
					if(is_array($value))
					{
						fputs($log,"Var: ".$varName." Value: ".$this->implode_r(",", $value)."\n");
					}
					else
					{
						fputs($log,"Var: ".$varName." Value: ".$value."\n");
					}
				}
			}

			fputs($log,"_POST:\n");
			if(isset($_POST)){
				foreach($_POST as $varName => $value) {
					if(is_array($value))
					{
						fputs($log,"Var: ".$varName." Value: ".$this->implode_r(",", $value)."\n");
					}
					else
					{
						fputs($log,"Var: ".$varName." Value: ".$value."\n");
					}
				}
			}
			fputs($log,"---------------\n");
			fclose($log);
		}
	
	}
	
	//CI SESSION SUCKS
	function unset_only()
	{
		$user_data = $this->session->all_userdata();

		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
	}
	
	//implode recursive
	function implode_r($glue,$arr){
        $ret_str = "";
        foreach($arr as $a){
                $ret_str .= (is_array($a)) ? $this->implode_r($glue,$a) : "," . $a;
        }
        return $ret_str;
}
	
	
	
}
?>