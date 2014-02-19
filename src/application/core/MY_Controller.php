<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend_Controller extends CI_Controller {
	
	//variables que se le pasan al template
	var $template = array();
	
	//modelo doctrine con el cual laburamos
	var $model = FALSE;
	
	//feligrid default order 
	var $default_sortname = 'id';
	//feligrid default order 
	var $default_sortorder = 'DESC';
	//query lista para execute(); 
	var $query = FALSE;
	
	
	
	function Backend_Controller()
    {
        //agarrate catalina
		parent::__construct();
		
		$this->_set_model();
		
		//configs
		$this->config->load	('backend');
		$this->config->load	('flexigrid');
		
		//librerias
		$this->load->library	('backend');
		$this->load->library	('flexigrid');
		$this->load->helper		('flexigrid');
		$this->load->helper		('array');
		$this->load->helper		('inflector');
			
    }
	
	//TODO: revistar esta cabeceada. saca _main y _abm al nombre del modelo
	private function _set_model($model_name = FALSE)
	{
		
		if(!$model_name)
		{
			$model_name='';
			$partes = explode('_',$this->router->class);
			$cantidad = count($partes);
			for($i=0;$i<$cantidad;$i++)
			{
				if($i+1<$cantidad)
				{
					$model_name.=ucfirst(strtolower($partes[$i])) . '_';
				}
			}
			$model_name = substr_replace($model_name, '', -1, 1); //saco ultimo_gion
		}
		
		$this->model = $model_name;
	}
	
	
	
	//-----------------------------------------------------------------------------------
	//devuelve el nombre del archivo abm a partir del nombre de la clase
	public function get_abm_url()
	{
		$url = 	$this->config->item('base_url').
				$this->config->item('backend_root') .
				str_replace('_main','_abm',strtolower($this->router->class));
		return $url;
	}
	//-----------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------
	//devuelve el nombre del archivo main a partir del nombre de la clase
	public function get_main_url()
	{
		$url = 	$this->config->item('base_url').
				$this->config->item('backend_root') .
				str_replace('_abm','_main',strtolower($this->router->class));
		
		return $url;
	}
	//-----------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------
	//genera la url que apunta al controller de la grilla main
	public function get_grid_url()
	{
		
		$url = 	$this->config->item('base_url').
				$this->config->item('backend_root') .
				strtolower($this->router->class).'/grid';
		return $url;
	}
	//-----------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------
	//devuelve el nombre del archivo template a partir de la clase
	public function get_template_view()
	{
		$file_path = 'backend/'.strtolower($this->router->class.'_view');
		return $file_path;
	}
	//-----------------------------------------------------------------------------------
	
	
	//la llaman los mains, return array
	public function _create_filters($campos)
	{
		$filtro=array();
		
		if(is_array($campos))
		{
			
			reset($campos);
			while(list($field_name,$val) = each($campos))
			{
				if($this->input->post($field_name) && isset($val['sql_filter']) && is_array($val['sql_filter']))
				{
					while(list(,$sql) = each($val['sql_filter']))
					{
						if(is_array($this->input->post($field_name)))
						{
							//$data=array_values($this->input->post($field_name));
							//$data=implode(",", $this->input->post($field_name));
							//print_r($data);
							$data=$this->input->post($field_name);
						}else{
							$data=$this->input->post($field_name);
						}
						
						$filtro[]=array(
									str_replace('%THIS%', $field_name, $sql), 
								  	$data
									);
					}
				}
					
			}
		}
		
		return $filtro;
	}
	//-----------------------------------------------------------------------------------
	
	//la llaman los mains, return array
	//devuelve array con configuracion para la grilla
	public function _create_grid_template($campos)
	{
		/*
			 * 0 - display name
			 * 1 - width
			 * 2 - sortable
			 * 3 - align
			 * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.) // no se usa
		*/
		
		$return['id'] = array($this->lang->line('id'),40,TRUE,'center',1);
		$return['actions'] = array($this->lang->line('acciones'),50, FALSE, 'right',0);
		
		if(is_array($campos))
		{
			
			reset($campos);
			while(list($field_name,$val) = each($campos))
			{
				if(isset($val['grid']) && $val['grid'] === TRUE )
				{
					$return[$field_name] = array($this->marvin->mysql_field_to_human($field_name),$val['width'], $val['sorteable'], $val['align'],0);
				}
					
			}
		}
		return $return;
	}
	//-----------------------------------------------------------------------------------
	
	//la llaman los mains, return array
	//devuelve array con los datos para la grilla
	public function _create_grid_data($row,$campos,$params = array())
	{	
		
		$this->load->helper('url');
		$config_archivos = $this->config->item('backend_files_config');
		
		
		$return = array($row['id'],
				$row['id'],
				$this->backend->_grid_links($row['id'],$params),
		);
		
		if(is_array($campos))
		{
			
			reset($campos);
			$data=array();
			while(list($field_name,$val) = each($campos))
			{
				if(isset($val['grid']) && $val['grid'] === TRUE )
				{
					
					//todo este lio para bajar
					if(isset($val['download']) && $val['download']===TRUE) //solo para descargar archivos
					{
						
						$folder = explode('_adjunto',$field_name);
						
						$link = $this->config->item('backend_uploads_root');
						$link.= $folder[0] . '/';
						$link.= 'adjunto' . $folder[1] . '/'; //ojo, el nombre de la tabla tiene que empezar con adjunto					
						
						
						$archivos = explode('|',element($field_name . $config_archivos['archivo'], $row));
						$extensiones = explode('|',element($field_name . $config_archivos['extension'], $row));
						$return_link = '';
						while(list($key,$val)=each($archivos))
						{
								if(strlen($val)>5)
								{
									$return_link.= anchor($link . trim($val) .'.'.trim($extensiones[$key]),
													trim($extensiones[$key]),
													array('title' => lang('descargar_archivo'))
													);
								}
						}
						$return[]= $return_link;
					}
					//todo este lio para bajar
					else
					{
					
						//$string = $this->marvin->string_to_utf(element($field_name, $row));
						$string = element($field_name, $row);
						if(stristr($field_name, '_fechahora') != FALSE)
						{
							$return[]= $this->marvin->mysql_datetime_to_form($string);
							//$return[]= $string;
						}
						else if(stristr($field_name, '_fecha') != FALSE)
						{
							$return[]= $this->marvin->mysql_date_to_form($string);
						}
						else
						{
							$return[]= $string;
						}
					
					}
				}
					
			}
		}
		
		RETURN $return;
	}
	//-----------------------------------------------------------------------------------
	
	//-----------------------------------------------------------------------------------
	
	// Solo para descarga en zip
	//la llaman los mains, return array
	//devuelve array con los datos para la grilla
	public function _create_grid_data_zip($row,$campos,$params = array())
	{
	
		$this->load->helper('url');
		
		
		$config_archivos = $this->config->item('backend_files_config');
	
	
		$return = array($row['id'],
				$row['id'],
				$this->backend->_grid_links($row['id'],$params),
		);
	
		if(is_array($campos))
		{
				
			reset($campos);
			$data=array();
			while(list($field_name,$val) = each($campos))
			{
				if(isset($val['grid']) && $val['grid'] === TRUE )
				{
						
					//todo este lio para bajar
					if(isset($val['download']) && $val['download']===TRUE) //solo para descargar archivos
					{
	
						$folder = explode('_adjunto',$field_name);
	
						$link = $this->config->item('backend_uploads_root');
						$link.= $folder[0] . '/';
						$link.= 'adjunto' . $folder[1] . '/'; //ojo, el nombre de la tabla tiene que empezar con adjunto
						$link = urlencode($link);
	
						$archivos = explode('|',element($field_name . $config_archivos['archivo'], $row));
						$extensiones = explode('|',element($field_name . $config_archivos['extension'], $row));
						$return_link = '';
						
						
						$return_link.= anchor($this->config->item('base_url').$this->config->item('backend_root').'upload_file_main/zip?files=' . $row['id'] . '&amp;filename=' . $row['id'] . '.zip',
										lang('descargar_archivo'),
										array('title' => lang('Descargar Archivo'),
											  'target' => '_blank')
							);
						
						$return[]= $return_link;
	
					}
					//todo este lio para bajar
					else
					{
							
						//$string = $this->marvin->string_to_utf(element($field_name, $row));
						$string = element($field_name, $row);
						if(stristr($field_name, '_fechahora') != FALSE)
						{
							$return[]= $this->marvin->mysql_datetime_to_form($string);
							//$return[]= $string;
						}
						else if(stristr($field_name, '_fecha') != FALSE)
						{
							$return[]= $this->marvin->mysql_date_to_form($string);
						}
						else
						{
							$return[]= $string;
						}
							
					}
				}
					
			}
		}
	
		RETURN $return;
	}
	//-----------------------------------------------------------------------------------
	
	
	
	//----------------------------------------------------------------
	//-------------------------[establece el registro sobre el cual se va a trabajar ]
	//llamada por los abms
	public function _set_record($id = FALSE,$filters=array())
	{
		if(!$id)
		{
			$error=array();
			$error['line'] 	= __LINE__;
			$error['file'] 	= __FILE__;
			$error['error']	= 'id false';
			$error['ID']	= $id;
			$this->backend->_log_error($error);
			redirect($this->get_main_url());
		}
		$objeto = new $this->model();
		$q = $objeto->get_all();
		$q->addWhere('id = ?',$id);
		
				
		//if(isset($this->sucursal)){
		if(isset($this->sucursal) && $this->sucursal === TRUE)
		{
			$q->whereIn('sucursal_id',$this->session->userdata('sucursales'));
		}
		/* wtf
		else {
			$q->whereIn(' 1 = 1 ');		
		}
		*/
		if(!empty($filters))
		{
			while(list($key,$val)=each($filters))
			{
				if(is_array($val))
				{
					$q->whereIn($key, $val);
				}
				else
				{
					$q->addWhere($key, $val);
				}
			}
		}
		
		$registro = $q->fetchOne();
		
		if(!$registro)
		{	
			
			$error=array();
			$error['line'] 	= __LINE__;
			$error['file'] 	= __FILE__;
			$error['error']	= 'no existe el registro o no tiene permisos';
			//$error['sql'] 	= $q->getSqlQuery();
			$error['ID']	= $id;
			$this->backend->_log_error($error);
			
			redirect($this->get_main_url());
		}
		else
		{
			$this->registro_actual = $registro;
			unset($registro);
		}
	}
	//-------------------------[establece el registro sobre el cual se va a trabajar ]
	//----------------------------------------------------------------
	
	
	//la llaman los _main
	public function _create_query()
	{
		
		
		/*
		$cacheDriver->deleteBySuffix($sufijo): borra las entradas de la cache que contengan el sufijo indicado.
#

$cacheDriver->deleteByRegularExpression($regex): borra las entradas de la cache cuya clave cumpla con la expresi�n regular indicada.
#

$cacheDriver->deleteAll(): borra todas las
		*/
		
		
		
		
		//deja la query lista para usar en $this->query
		$objeto = new $this->model();
		$this->query = $objeto->get_all();
		//$this->query->useQueryCache(TRUE); //creo q es al dope porque cachea por default
		
		$this->query->expireQueryCache(TRUE);
		$this->query->expireResultCache(TRUE); //borra la cache
		
		
		if($this->sucursal){
			$this->query->whereIn('sucursal_id',$this->session->userdata('sucursales'));
		}
		$this->flexigrid->validate_post();
		$this->flexigrid->build_query();
		
		//$this->query->useResultCache(TRUE, 3600, strtolower($this->model) . '__' . $this->query->getSqlQuery());
		
		
		//echo $this->query->getSqlQuery();
		//exit;
		/*
		$manager = Doctrine_Manager::getInstance();
		$cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
		if ($cacheDriver->contains($this->model))
		{
		  echo 'cache exists';
		}
		else
		{
		  echo 'cache does not exist';
		}
		$cacheDriver->deleteByPrefix($this->model);
		*/
		/*
		$manager = Doctrine_Manager::getInstance();
		$cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
		$cacheDriver->deleteByPrefix($this->model);
		*/
		
	}
	
		//-----------------------------------------------------------------------------------
	public function _create_html_options($q, $config=array() )
	{
		if(!isset($config['fields']))		$config['fields']=array('id');
		if(!isset($config['select']))		$config['select'] = FALSE;
		if(!isset($config['separator']))	$config['separator'] = ' ';
		if(!isset($config['order']))		$config['order'] = FALSE;
		if(!isset($config['force_black']))	$config['force_black'] = FALSE;
		if(!isset($config['index']))		$config['index'] = 'id';
		
		$return =array();
		
		//auto order by!
		if(count($config['fields'])==1 && !$config['order'])
		{
			$q->orderBy($config['fields'][0]);
		}
		
		$q->useQueryCache(true);
		$q->useResultCache(true);

		
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
		if(count($resultado) > 1 && $config['select'] == TRUE){
			//$return[0] = $this->lang->line('seleccione');
			$return[0] = '';
		}
		
		if($config['select'] == TRUE && $config['force_black'] == TRUE && count($resultado) == 1)
		{
				$return[0] = '';
		}
		
		foreach($resultado as $row) {
			reset($config['fields']);
			$string='';
			while(list(,$field_name) = each ($config['fields'])){
				$data = element($field_name, $row);
				if($data != NULL){
					$string.=$data . $config['separator'];
				}
			}
			//$return [$row['id']] = $this->marvin->string_to_utf($string);
			//$return [$row['id']] = utf8_encode($string);
			$return [$row[$config['index']]] = $string;
		}
		return $return;
	}
	//-----------------------------------------------------------------------------------
	
	public function _view_adjunto()
	{
		if($this->registro_actual)
		{
			if($this->backend->isset_adjunto())
			{
				reset($this->upload_adjunto);
				while(list($key,$subfix)=each($this->upload_adjunto))
				{
					$modelo = str_replace(' ','_',humanize($this->model . '_' . $subfix));
					$adjuntos= new $modelo();
					$q=$adjuntos->get_all();
					$q->addWhere(strtolower($this->model) . '_id = ?',$this->registro_actual->id);
					$q->orderBy('id DESC');
					$resultado = $q->execute(); //TODO hydrate array
					$data = array();
					foreach($resultado as $adjunto) {
						$data[$adjunto->id] = $adjunto->toArray();
					}
					$this->template[strtolower($modelo)] = $data;
				}
			}
			
			
		}
	}
	
	
	public function _view_image()
	{
		if($this->registro_actual)
		{
			if($this->backend->isset_image())
			{
				reset($this->upload_image);
				while(list($key,$subfix)=each($this->upload_image))
				{
					$modelo = str_replace(' ','_',humanize($this->model . '_' . $subfix));
					$adjuntos= new $modelo();
					$q=$adjuntos->get_all();
					$q->addWhere(strtolower($this->model) . '_id = ?',$this->registro_actual->id);
					$q->orderBy(strtolower($modelo . $this->backend->get_files_config('orden')));
					$resultado = $q->execute(); //TODO hydrate array
					$data = array();
					foreach($resultado as $adjunto) {
						$data[$adjunto->id] = $adjunto->toArray();
					}
					
					
					$this->template[strtolower($modelo)] = $data;
				}
			}
			
			
		}
	}
	
	
	
	
}
