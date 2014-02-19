<?php
class Index extends Backend_Controller{
		
	function __construct()
	{
        parent::Backend_Controller();
		$this->load->config('imagen/noticia_imagen');
		$this->load->config('adjunto/noticia_adjunto');
		
		$this->template['image_path'] = str_replace(FCPATH,'',$this->config->item('image_path'));
		$this->template['adjunto_path'] = str_replace(FCPATH,'',$this->config->item('adjunto_path'));
		
	}
	
	
	public function index()
	{
	
		
		//----------- [noticias de administracion]
		$administracion=new Noticia();
		$q = $administracion->get_all();
		$q->addWhere(' noticia_seccion_id = ? ', 1);
		$q->addWhere(' backend_estado_id = ? ', 2);
		$q->orderBy(' id DESC ');
		$q->addOrderBy('noticia_imagen_field_orden ASC');
		$q->limit(5);
		try {
			$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['message']	= $e->getPortableMessage();
			$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->getPortableMessage() . ' ' . $q->getSqlQuery()   );
		}
		
		
		$this->template['administracion']=$resultado;
		//----------- [noticias de administracion]
		
		
		//----------- [noticias de servicio]
		$administracion=new Noticia();
		$q = $administracion->get_all();
		$q->addWhere(' noticia_seccion_id = ? ', 2);
		$q->addWhere(' backend_estado_id = ? ', 2);
		$q->orderBy(' id DESC ');
		$q->addOrderBy('noticia_imagen_field_orden ASC');
		$q->limit(5);
		try {
			$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['message']	= $e->getPortableMessage();
			$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->getPortableMessage() . ' ' . $q->getSqlQuery()   );
		}
		
		$this->template['servicio']=$resultado;
		//----------- [noticias de servicio]
		
		//----------- [noticias de comercial]
		$administracion=new Noticia();
		$q = $administracion->get_all();
		$q->addWhere(' noticia_seccion_id = ? ', 3);
		$q->addWhere(' backend_estado_id = ? ', 2);
		$q->orderBy(' id DESC ');
		$q->addOrderBy('noticia_imagen_field_orden ASC');
		$q->limit(5);
		try {
			$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['message']	= $e->getPortableMessage();
			$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->getPortableMessage() . ' ' . $q->getSqlQuery()   );
		}
		
		
		$this->template['comercial']=$resultado;
		//----------- [noticias de comercial]
		
		
		
		
		//$this->output->enable_profiler();
		$this->template['tpl_include'] = 'backend/home_view';
		$this->load->view('backend/esqueleto_view',$this->template);
	}
	
	
	
	public function noticia($id = FALSE)
	{
		
	
		$noticia = new Noticia();
		$q = $noticia->get_all();
		$q->addWhere('id = ?',$id);
		$q->addWhere(' backend_estado_id = ? ', 2);
		
		
		
		$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		if(!$resultado)
		{
			redirect($this->config->item('base_url').'backend');
		}
		else
		{
			$this->template['noticia']=$resultado[0];
			
			//tomo otras noticias != de la que estoy mostrando
			$noticia = new Noticia();
			$q = $noticia->get_all();
			$q->orderBy(' id DESC ');
			$q->addWhere('id != ?',$resultado[0]['id']);
			$q->addWhere('noticia_seccion_id = ?',$resultado[0]['noticia_seccion_id']);
			$q->addWhere('backend_estado_id = ?', 2);
			$q->limit('25');
			$noticias=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$this->template['noticias']=$noticias;
			
			
			
			
			$this->template['tpl_include'] = 'backend/noticia_desarrollo_view';
			$this->load->view('backend/esqueleto_view',$this->template);
		}
	
	}
	
	
	
	
}       
        
