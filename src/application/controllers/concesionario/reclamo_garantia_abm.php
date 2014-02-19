<?php
define('ID_SECCION',3071);
class Reclamo_Garantia_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	var $infladores = array('5SD');
	
	//filtra por sucursal?
	var $sucursal = FALSE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = TRUE;
	
	//subfix de archivos adjuntos 
	var $upload_adjunto = array('adjunto_transporte','adjunto_trabajo_tercero','adjunto_rth');
	
	//estados que no puede cambiar desde este form
	var $estados_invalidos =  array(2,3,9); //aprobado, orden compra generada, rechazado
	
	//subfix de imagenes adjuntas 
	var $upload_image = array();
	
	function __construct()
	{
		
		parent::Backend_Controller();
		$this->load->library('r_garantia');
		
		/*upload y validaciones de archivo...*/
		$this->load->helper('inflector');
		$this->load->library('upload');
		$this->lang->load('upload');
		$this->load->helper('string');
		$this->load->library('Multi_upload');
		
		
	}
				
	

	//----------------------------------------------------------------
	//-------------------------[crea un registro a partir de post ]
	public function add()
	{
		
		if($this->r_garantia->set_version('CONCESIONARIO'));
		
		
		if($this->input->post('_submit'))
		{		
			if ($this->_validar_formulario() == TRUE)
			{
				//piso _this_registro_actual
				$this->registro_actual = new Reclamo_Garantia();
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
			$this->_set_record($this->input->post('id'),array('TSI.sucursal_id' => $this->session->userdata('sucursales') ));
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
		$this->_set_record($this->input->post('id'), array('TSI.sucursal_id' => $this->session->userdata('sucursales') ));
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
		$this->_set_record($id, array('TSI.sucursal_id' => $this->session->userdata('sucursales') ));
		$this->_mostrar_registro_actual($id);
		$this->_view();
	}
	
	
	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------
	
	//----------------------------------------------------------------
	//-------------------------[edita el registro]
	public function edit($id = FALSE,$version='CONCESIONARIO',$comodin = FALSE)
	{
		
		$version=strtoupper($version);
		if(!$this->r_garantia->set_version($version))
		{
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= 'no tiene permisos para la version '.$version;
			$error['sql'] 		= '';
			$this->backend->_log_error($error);	
			redirect($this->get_main_url());
		}
		
		
		
		$this->template['RG_VERSION'] = $this->get_template_view();
		$this->template['GARANTIA_VERSION'] = $this->r_garantia->get_version();
		
		if($comodin==='GENERAR' && $this->r_garantia->get_version()==='JAPON')
		{
			$this->generar_version_japon($id);
			redirect($this->get_abm_url()."/edit/".$id.'/JAPON');	
		}
		
		
		$this->_set_record($id,
			array('RECLAMO_GARANTIA_VERSION.reclamo_garantia_version_field_desc = ?'=>$this->r_garantia->get_version(),
				  'TSI.sucursal_id' => $this->session->userdata('sucursales') )
			);
		
		if(empty($this->registro_actual->Reclamo_Garantia_Version))
		{
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= 'no existe la version pedida';
			$error['sql'] 		= '';
			$this->backend->_log_error($error);
			redirect($this->get_main_url());
		
		}
		$this->template['id'] = $this->registro_actual->id;
		$this->template['current_record'] = $this->registro_actual->id;
		if($this->input->post('_submit'))
		{
			
			
			
			if(in_array($this->registro_actual->reclamo_garantia_estado_id,$this->estados_invalidos))
			{
				show_error('el registro se encuentra bloqueado');
			}
			
			
			
			
			//manda info
			if ($this->_validar_formulario() == TRUE)
			{
				//pasa validacion, grabo y redirecciono a edit
				$this->_grabar_registro_actual();
				$this->session->set_flashdata('edit_ok', true);
				redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id . '/' . $this->r_garantia->get_version());
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
		$_POST = array();
		if($this->registro_actual)
		{
			$registro_array = $this->registro_actual->toArray();
			
			$this->template['current_record'] = $this->registro_actual->id;
						
			$version = $registro_array['Reclamo_Garantia_Version'][0];
			unset($version['id']);
			unset($registro_array['Unidad_Estado_Garantia']['id']);
			
			if(isset($version['Reclamo_Garantia_Codigo_Sintoma']))
			{
				$codigo_sintoma = $version['Reclamo_Garantia_Codigo_Sintoma'];
				unset($codigo_sintoma['id']);
				$this->form_validation->set_defaults($codigo_sintoma);
			}
			
			if(isset($version['Reclamo_Garantia_Codigo_Defecto']))
			{
				$codigo_defecto = $version['Reclamo_Garantia_Codigo_Defecto'];
				unset($codigo_defecto['id']);
				$this->form_validation->set_defaults($codigo_defecto);
			
			}
		
			
			$this->form_validation->set_defaults($registro_array);
			$this->form_validation->set_defaults(@$registro_array['Unidad_Estado_Garantia']);
			$this->form_validation->set_defaults($version);
			$this->form_validation->set_defaults(array('kilometros'=>$registro_array['Tsi']['tsi_field_kilometros']));
			$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
			
			
			if($this->backend->_permiso('admin'))
			{
				//tiene la version japon generada?
				$q = Doctrine_Query::create();
				$q->select('Reclamo_Garantia.id, Reclamo_Garantia_Version.id');
				$q->from('Reclamo_Garantia Reclamo_Garantia');
				$q->leftJoin('Reclamo_Garantia.Reclamo_Garantia_Version Reclamo_Garantia_Version');
				$q->where('Reclamo_Garantia.id = ?',$this->registro_actual->id);
				$q->addWhere('Reclamo_Garantia_Version.reclamo_garantia_version_field_desc = ?','JAPON');
				if($q->count() == 1)
				{
					$this->form_validation->set_defaults(array('version_japon'=>TRUE));
				}
				//tiene la version japon generada?
				
				//busco los tsis que tiene el registro para mostrarselos al admin
				$q = Doctrine_Query::create();
				$q->from('Tsi Tsi');
				$q->leftJoin('Tsi.Many_Tsi_Tipo_Servicio Many_Tsi_Tipo_Servicio ');
				$q->leftJoin('Tsi.Sucursal Sucursal ');
				$q->where('Tsi.unidad_id = ?',$registro_array['Tsi']['unidad_id']);
				$q->whereIn('Tsi.sucursal_id',$this->session->userdata('sucursales'));
				$q->orderBy('Tsi.tsi_field_fecha_de_egreso DESC');
				$this->template['tsis_registrados']=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
				
				//busco los reclamos de garantia que tiene la unidad para mostrarselos al admin
				
				$obj = new Reclamo_Garantia();
				$q = $obj->get_all();
				$q->addWhere('UNIDAD.id = ?',$this->registro_actual->Tsi->Unidad->id);
				$q->addWhere('RECLAMO_GARANTIA_VERSION.reclamo_garantia_version_field_desc = ?','HONDA');
				$q->whereIn('TSI.sucursal_id',$this->session->userdata('sucursales'));
				$q->orderBy('RECLAMO_GARANTIA.id DESC');
				$this->template['reclamos_registrados']=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
				
			}
			
			
			
			

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
	
		
		$this->valor_reclamado = 0;
		
		try {
				$conn = Doctrine_Manager::connection();
				$conn->beginTransaction();
			
				
				
				
				if($this->router->method == 'add' )
				{
					$this->registro_actual->reclamo_garantia_field_admin_alta_id = $this->session->userdata('admin_id');
					$this->registro_actual->reclamo_garantia_field_fechahora_alta = date('Y-m-d H:i:s', time());
					$this->registro_actual->tsi_id = $this->input->post('tsi_id');
					$this->registro_actual->reclamo_garantia_estado_id = 1; //pendiente;
					$this->registro_actual->reclamo_garantia_campania_id = $this->input->post('reclamo_garantia_campania_id');
					$this->reclamo_garantia_field_pcw = 0; 
				}
				else if($this->router->method == 'edit' )
				{
					$this->registro_actual->reclamo_garantia_field_admin_modifica_id = $this->session->userdata('admin_id');
					$this->registro_actual->reclamo_garantia_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
					if($this->r_garantia->get_version()=='HONDA')
					{
						$this->registro_actual->reclamo_garantia_estado_id = $this->input->post('reclamo_garantia_estado_id');
						if($this->input->post('reclamo_garantia_estado_id') == 13)
						{
							$this->registro_actual->reclamo_garantia_field_fechahora_pre_aprobacion = date('Y-m-d H:i:s', time());
						}
						else
						{
							$this->registro_actual->reclamo_garantia_field_fechahora_pre_aprobacion = FALSE;
						}
					}
					
				}
				
				$this->registro_actual->save();
				
				
				$info = $this->r_garantia->get_info($this->registro_actual->tsi_id);
				$this->registro_actual->reclamo_garantia_field_problemas 					= $info['garantia_problemas']; 
				$this->registro_actual->unidad_estado_garantia_id 							= $info['unidad_estado_garantia_id']; 
				$this->registro_actual->reclamo_garantia_field_mantenimientos_esperados 		= $info['mantenimientos_esperados']; 
				$this->registro_actual->reclamo_garantia_field_mantenimientos_realizados		= $info['mantenimientos_realizados']; 
				
				$this->registro_actual->save();
				
				$valores = $this->r_garantia->get_tsi_valores_garantia($this->registro_actual->tsi_id);
				if($this->r_garantia->get_version()=='HONDA')
				{
					$valores['valor_dolar'] = $this->input->post('reclamo_garantia_field_valor_dolar');
				}
							
				$this->registro_actual->reclamo_garantia_field_valor_alca = $valores['valor_alca'];
				$this->registro_actual->reclamo_garantia_field_valor_hora_japon = $valores['valor_hora_japon'];
				$this->registro_actual->reclamo_garantia_field_valor_dolar = $valores['valor_dolar'];
				$this->registro_actual->reclamo_garantia_field_valor_ingresos_brutos = $valores['valor_ingresos_brutos'];
				//grabamos
				$this->registro_actual->save();
				$this->_crear_versiones();
				
			}
			catch(Doctrine_Exception $e) {
				$conn->rollback();
				print_r($e->errorMessage());
				$error=array();
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= __LINE__ . 'error grabando reclamo de garantia ' . $e->errorMessage();
				$error['sql'] 		= 'error grabando reclamo de garantia ';
				$this->backend->_log_error($error);
				show_error( $error['error']   );
			}
			
			
		
	}
	//-------------------------[graba registro en la base de datos]
	//----------------------------------------------------------------

	//-----------------------------------------------------------------------------
	//-------------------------[vista generica abm]
	private function _view()
	{
		
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

		//------------ [select / checkbox / radio reclamo_garantia_campania_id] :(
		$reclamo_garantia_campania=new Reclamo_Garantia_Campania();
		$q = $reclamo_garantia_campania->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('id');
		$config['select'] = TRUE;
		$this->template['reclamo_garantia_campania_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_campania_id]

		//------------ [select / checkbox / radio reclamo_garantia_dtc_estado_id] :(
		$reclamo_garantia_dtc_estado=new Reclamo_Garantia_Dtc_Estado();
		$q = $reclamo_garantia_dtc_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('reclamo_garantia_dtc_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['reclamo_garantia_dtc_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_dtc_estado_id]

		

		//------------ [select / checkbox / radio reclamo_garantia_estado_id] :(
		$reclamo_garantia_estado=new Reclamo_Garantia_Estado();
		$q = $reclamo_garantia_estado->get_all();
		$q->whereNotIn('id', $this->estados_invalidos);
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('reclamo_garantia_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['reclamo_garantia_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_estado_id]
		
		//------------ [select / checkbox / radio reclamo_garantia_estado_id] :(
		$reclamo_garantia_estado=new Reclamo_Garantia_Estado();
		$q = $reclamo_garantia_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('reclamo_garantia_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['tabla_reclamo_garantia_estado']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_estado_id]

		//------------ [select / checkbox / radio reclamo_garantia_codigo_rechazo_principal_id] :(
		$reclamo_garantia_codigo_rechazo_principal=new Reclamo_Garantia_Codigo_Rechazo_Principal();
		$q = $reclamo_garantia_codigo_rechazo_principal->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('reclamo_garantia_codigo_rechazo_principal_field_desc');
		$config['select'] = TRUE;
		$this->template['reclamo_garantia_codigo_rechazo_principal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_codigo_rechazo_principal_id]

		//------------ [select / checkbox / radio reclamo_garantia_codigo_rechazo_secundario_id] :(
		$reclamo_garantia_codigo_rechazo_secundario=new Reclamo_Garantia_Codigo_Rechazo_Secundario();
		$q = $reclamo_garantia_codigo_rechazo_secundario->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('reclamo_garantia_codigo_rechazo_secundario_field_desc');
		$config['select'] = TRUE;
		$this->template['reclamo_garantia_codigo_rechazo_secundario_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_codigo_rechazo_secundario_id]
		
		//------------ [select / checkbox / radio reclamo_garantia_trabajo_tercero] :(
		$reclamo_garantia_trabajo_tercero=new Reclamo_Garantia_Trabajo_Tercero();
		$q = $reclamo_garantia_trabajo_tercero->get_all();
		$q->addWhere(' backend_estado_id = ? ', 2);
		$config=array();
		$config['fields'] = array('id','reclamo_garantia_trabajo_tercero_field_desc');
		$config['select'] = TRUE;
		$this->template['reclamo_garantia_trabajo_tercero_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_codigo_rechazo_secundario_id]
		
		
		$this->template['estados_bloqueados'] = $this->estados_invalidos;
		if($this->registro_actual)
		{
			$this->template['estado_actual'] = $this->registro_actual->reclamo_garantia_estado_id;
		}
		else
		{
			$this->template['estado_actual'] = FALSE;
		}
		
		/*-esto es a mano baby*/
		if($this->registro_actual)
		{
			$this->template['reclamo_garantia_version_adjunto_transporte']	=
											$this->registro_actual->Reclamo_Garantia_Version[0]->Reclamo_Garantia_Version_Adjunto_Transporte->toArray();
			$this->template['reclamo_garantia_version_adjunto_rth'] 		= 
											$this->registro_actual->Reclamo_Garantia_Version[0]->Reclamo_Garantia_Version_Adjunto_Rth->toArray();
			$this->template['reclamo_garantia_version_adjunto_trabajo_tercero']		= 
											$this->registro_actual->Reclamo_Garantia_Version[0]->Reclamo_Garantia_Version_Adjunto_Trabajo_Tercero->toArray();
			
		}
	
		
	
		//$this->_view_adjunto(); //muestro archivos adjuntos (si los hay); //definida $this->$upload_adjunto = array();
		//$this->_view_image(); //muestro imagenes (si las hay); //definida $this->$upload_image = array();
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
			$version_actual = $this->registro_actual->Reclamo_Garantia_Version->toArray();
			/*esto no se puede cambiar*/
			$_POST['unidad_field_unidad'] = $this->registro_actual->Tsi->Unidad->unidad_field_unidad;
			$_POST['unidad_field_vin'] = $this->registro_actual->Tsi->Unidad->unidad_field_vin;
			$_POST['tsi_id'] = $this->registro_actual->tsi_id;
			$_POST['reclamo_garantia_campania_id'] = $this->registro_actual->reclamo_garantia_campania_id;
			$valores = $this->r_garantia->get_tsi_valores_garantia($this->registro_actual->tsi_id);
			$_POST['reclamo_garantia_field_valor_alca'] = $valores['valor_alca'];
			
			
			
			
			
			/*esto no se puede cambiar*/
		}else{
			$id = FALSE;
			$version_actual = FALSE;
		}
		
		//ojo , siempre primero se setea el tsi, despues la campaña, hay algo raro con los callbacks
		
		$this->r_garantia->set_tsi($this->input->post('tsi_id'));
		$this->r_garantia->set_campania($this->input->post('reclamo_garantia_campania_id'));
	
		
		
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
				'trim|required|alpha_numeric|my_exist_unidad['.$this->input->post('unidad_field_vin').']' );
		
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
				'trim|required|exact_length[17]|alpha_numeric|callback_valid_tarjeta' );
		
		
		$this->form_validation->set_rules('tsi_id',$this->marvin->mysql_field_to_human('tsi_id'),
				'trim|callback_valid_tsi|required' );
		
		
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));

	
		$this->form_validation->set_rules('reclamo_garantia_campania_id',$this->marvin->mysql_field_to_human('reclamo_garantia_campania_id'),
			'trim|callback_valid_campania' );
		
		
		//TODO esta validacion se podria mejorar...
		if(strlen($this->input->post('reclamo_garantia_campania_id'))<2)
		{
			
			$_POST['reclamo_garantia_campania_id']	= NULL;
		
			//si no es campaña validamos esto
			//------[codigo defecto]
			$this->form_validation->set_rules('reclamo_garantia_codigo_defecto_id',$this->marvin->mysql_field_to_human('reclamo_garantia_codigo_defecto_field_codigo_defecto'),
					'trim|max_length[5]|my_db_value_exist[Reclamo_Garantia_Codigo_Defecto.id]|required' );
			//envio la descripcion al form
			$codigo_defecto = new Reclamo_Garantia_Codigo_Defecto();
			$this->form_validation->set_defaults(array('reclamo_garantia_codigo_defecto_field_desc'=>$codigo_defecto->get_desc($this->input->post('reclamo_garantia_codigo_defecto_field_codigo_defecto'))),TRUE);
		
			//------[codigo defecto]
			
			//------[codigo sintoma]
			$this->form_validation->set_rules('reclamo_garantia_codigo_sintoma_id',$this->marvin->mysql_field_to_human('reclamo_garantia_codigo_sintoma_field_codigo_sintoma'),
					'trim|max_length[5]|my_db_value_exist[Reclamo_Garantia_Codigo_Sintoma.id]|required' );
			//envio la descripcion al form
			$codigo_sintoma = new Reclamo_Garantia_Codigo_Sintoma();
			$this->form_validation->set_defaults(array('reclamo_garantia_codigo_sintoma_field_desc'=>$codigo_sintoma->get_desc($this->input->post('reclamo_garantia_codigo_sintoma_field_codigo_sintoma'))),TRUE);
			//------[codigo sintoma]
			
			$this->form_validation->set_rules('reclamo_garantia_dtc_estado_id',$this->marvin->mysql_field_to_human('reclamo_garantia_dtc_estado_id'),
			'trim|required|my_db_value_exist[Reclamo_Garantia_Dtc_Estado.id]' );
		
			if($this->input->post('reclamo_garantia_dtc_estado_id')==2)
			{
				$this->form_validation->set_rules('reclamo_garantia_version_field_dtc_codigo',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_dtc_codigo'),
					'trim|max_length[255]|required' );
			}
			
			$this->form_validation->set_rules('reclamo_garantia_version_field_descripcion_sintoma',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_descripcion_sintoma'),
				'trim|max_length[255]|required' );
		
			$this->form_validation->set_rules('reclamo_garantia_version_field_descripcion_diagnostico',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_descripcion_diagnostico'),
					'trim|max_length[255]|required' );
			
			$this->form_validation->set_rules('reclamo_garantia_version_field_descripcion_tratamiento',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_descripcion_tratamiento'),
					'trim|max_length[255]|required' );
			$this->form_validation->set_rules('reclamo_garantia_version_field_valor_transporte',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_valor_transporte'),
				'trim|max_length[255]|numeric' );
				
			$this->form_validation->set_rules('reclamo_garantia_version_adjunto_transporte',$this->marvin->mysql_field_to_human('reclamo_garantia_version_adjunto_transporte'),
				'callback_valid_adjunto_transporte' );
			
			$this->form_validation->set_rules('reclamo_garantia_version_adjunto_trabajo_tercero',$this->marvin->mysql_field_to_human('reclamo_garantia_version_adjunto_trabajo_tercero'),
				'callback_valid_adjunto_trabajo_tercero' );
			
			$this->form_validation->set_rules('reclamo_garantia_version_adjunto_rth',$this->marvin->mysql_field_to_human('reclamo_garantia_version_adjunto_rth'),
				'callback_valid_adjunto_rth' );
	
		}
		else
		{
			//cuentas claras conservan la amistad....
			$_POST['reclamo_garantia_codigo_defecto_id'] 		= NULL;
			$_POST['reclamo_garantia_codigo_sintoma_id'] 		= NULL;
			$_POST['reclamo_garantia_dtc_estado_id'] 			= NULL;
			$_POST['reclamo_garantia_version_field_dtc_codigo'] = NULL;
			$_POST['reclamo_garantia_version_field_descripcion_sintoma'] = NULL;
			$_POST['reclamo_garantia_version_field_descripcion_diagnostico'] = NULL;
			$_POST['reclamo_garantia_version_field_descripcion_tratamiento'] = NULL;
			$_POST['reclamo_garantia_version_field_valor_transporte'] = 0;
			
			
		}
		
		
		$this->form_validation->set_rules('reclamo_garantia_version_field_observaciones',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_observaciones'),
				'trim|max_length[255]' );
		
		
		
		
		$this->form_validation->set_rules('reclamo_garantia_field_evaluacion_tecnica',$this->marvin->mysql_field_to_human('reclamo_garantia_field_evaluacion_tecnica'),
				'trim|max_length[255]' );
		
		
		$this->form_validation->set_rules('reclamo_garantia_version_field_boletin_numero',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_boletin_numero'),
				'trim|max_length[20]' );

		$this->form_validation->set_rules('reclamo_garantia_field_valor_alca',$this->marvin->mysql_field_to_human('reclamo_garantia_field_valor_alca'),
				'trim' );

		$this->form_validation->set_rules('reclamo_garantia_field_valor_hora_japon',$this->marvin->mysql_field_to_human('reclamo_garantia_field_valor_hora_japon'),
				'trim' );

		if($this->r_garantia->get_version() == 'HONDA')
		{
			$this->form_validation->set_rules('reclamo_garantia_field_valor_dolar',$this->marvin->mysql_field_to_human('reclamo_garantia_field_valor_dolar'),
				'trim|required|numeric|callback_valid_valor_dolar' );
				
		}
		
		//------[ingresos brutos, lo fuerzo si esta en edit..]
		if($this->registro_actual)
		{
			$this->form_validation->set_defaults(array('reclamo_garantia_field_valor_ingresos_brutos'=>
														$this->registro_actual->reclamo_garantia_field_valor_ingresos_brutos)
														,TRUE
												);
		}
		
		
		
		if($this->r_garantia->get_version() === 'HONDA')
		{
			$this->form_validation->set_rules('reclamo_garantia_estado_id',$this->marvin->mysql_field_to_human('reclamo_garantia_estado_id'),
					'trim|my_db_value_exist[Reclamo_Garantia_Estado.id]|callback_valid_reclamo_garantia_estado|required' );
		}

		$this->form_validation->set_rules('reclamo_garantia_codigo_rechazo_principal_id',$this->marvin->mysql_field_to_human('reclamo_garantia_codigo_rechazo_principal_id'),
				'trim' );

		$this->form_validation->set_rules('reclamo_garantia_codigo_rechazo_secundario_id',$this->marvin->mysql_field_to_human('reclamo_garantia_codigo_rechazo_secundario_id'),
				'trim' );

		$this->form_validation->set_rules('reclamo_garantia_field_admin_rechaza_id',$this->marvin->mysql_field_to_human('reclamo_garantia_field_admin_rechaza_id'),
				'trim' );

		$this->form_validation->set_rules('reclamo_garantia_field_rechazo_motivo',$this->marvin->mysql_field_to_human('reclamo_garantia_field_rechazo_motivo'),
				'trim' );


		$this->form_validation->set_rules('reclamo_garantia_field_fechahora_pre_aprobacion',$this->marvin->mysql_field_to_human('reclamo_garantia_field_fechahora_pre_aprobacion'),
				'trim' );

		$this->form_validation->set_rules('reclamo_garantia_field_admin_pre_aprueba_id',$this->marvin->mysql_field_to_human('reclamo_garantia_field_admin_pre_aprueba_id'),
				'trim' );
		
		$this->form_validation->set_rules('reclamo_garantia_version_field_rth',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_rth'),
				'trim' );
		
		$this->form_validation->set_rules('reclamo_garantia_version_field_rth',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_rth'),
			'trim' );
		$this->form_validation->set_rules('repuesto_principal',$this->marvin->mysql_field_to_human('repuesto_principal'),
			'trim' );
		$this->form_validation->set_rules('repuesto_secundario',$this->marvin->mysql_field_to_human('repuesto_secundario'),
			'trim' );
		
		if(in_array($this->input->post('reclamo_garantia_campania_id'), $this->infladores))
		{
			$this->form_validation->set_rules('reclamo_garantia_version_field_serie_inflador_original',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_serie_inflador_original'),
			'trim|required' );
			$this->form_validation->set_rules('reclamo_garantia_version_field_serie_inflador_colocado',$this->marvin->mysql_field_to_human('reclamo_garantia_version_field_serie_inflador_colocado'),
				'trim|required' );
		}
		
		
		
		
		
		
		
		/*----------[le paso el material principal ]*/
		$repuesto_principal = array();
		if(isset($_POST['repuesto'][0]) && strlen(trim($_POST['repuesto'][0]))>0)
		{
			$_POST['repuesto'][0] = strtoupper($_POST['repuesto'][0]);
			
			$error = FALSE;
			//es fulido? no puede ser el material principal
			if($this->r_garantia->es_fluido($_POST['repuesto'][0]))
			{
				$error = TRUE;
			}
			
			if(!$this->r_garantia->campania_material_principal($_POST['repuesto'][0]))
			{
				$error = TRUE;
			}
			
			
			if(!isset($_POST['factura_sap'][0]))
			{
				$_POST['factura_sap'][0]='';
			}
			else if(strlen($_POST['factura_sap'][0])==0 && $this->r_garantia->get_version()!='JAPON')
			{
				//no tiene factura, paso los demas valores a 0 si no es version japon
				$_POST['repuesto_cantidad'][0] = 0;
			}
			if(!isset($_POST['repuesto_cantidad'][0]))
			{
				$_POST['repuesto_cantidad'][0]=0;
			}
			if(!$this->r_garantia->validar_material_cantidad($_POST['repuesto'][0],$_POST['repuesto_cantidad'][0]))
			{
				$error = TRUE;
			}
		
			
			if($this->r_garantia->get_version() == 'JAPON')
			{
				$repuesto = array();
				$repuesto['precio'] 		= $this->r_garantia->get_precio_fob($_POST['repuesto'][0]);
				$repuesto['material'] 		= $_POST['repuesto'][0];
				$repuesto['documento_sap'] 	= '';
			}
			else
			{
				//TODO REVISAR SUCURSAL!
				$repuesto = $this->r_garantia->get_material_precio($_POST['factura_sap'][0],
																		$_POST['repuesto'][0],
																		FALSE
																		);
			}
			$descripcion = $this->r_garantia->get_material_descripcion($_POST['repuesto'][0]);
			if($descripcion)
			{
				$repuesto_descripcion = $descripcion['descripcion'];
			}
			else
			{
				$error = TRUE;
				$repuesto_descripcion = '';
			}
			if($repuesto && !$error)
			{
				
				$repuesto['repuesto_precio_total'] = $repuesto['precio']*$_POST['repuesto_cantidad'][0];
				$repuesto['repuesto_precio_total'] = round($repuesto['repuesto_precio_total'],2);
				
				//si no hay errores normalizo todo para la db...
				$_POST['repuesto'][0] 				= $repuesto['material'];
				$_POST['factura_sap'][0] 			= $repuesto['documento_sap'];
				$_POST['repuesto_precio_total'][0] 	= $repuesto['repuesto_precio_total'];
				$_POST['repuesto_descripcion'][0] 	= $repuesto_descripcion;
				$_POST['repuesto_cantidad'][0] 		= $_POST['repuesto_cantidad'][0]; //es boludo pero queda igual
				
				$repuesto_principal=array(
					'material_id'									=>$repuesto['material'],
					'material_facturacion_field_documento_sap_id'	=>$repuesto['documento_sap'],
					'reclamo_garantia_material_field_cantidad' 		=>$_POST['repuesto_cantidad'][0],
					'reclamo_garantia_material_field_precio'		=>$repuesto['precio'],
					'reclamo_garantia_material_field_total'			=>$repuesto['repuesto_precio_total'],
					'Material'										=>array('material_field_desc'=>$repuesto_descripcion)
				);
			}
			else
			{
				
				if(!isset($repuesto['precio']))
				{
					$repuesto['precio'] = 0;
				}
				$this->form_validation->set_rules('repuesto',$this->marvin->mysql_field_to_human('repuesto_principal'),'my_force_error' );
				$repuesto_principal=array(
					'material_id'									=>$_POST['repuesto'][0],
					'material_facturacion_field_documento_sap_id'	=>$_POST['factura_sap'][0],
					'reclamo_garantia_material_field_cantidad' 		=>$_POST['repuesto_cantidad'][0],
					'reclamo_garantia_material_field_precio'		=>$repuesto['precio'],
					'Material'										=>array('material_field_desc'=>$repuesto_descripcion),
					'reclamo_garantia_material_field_total'			=>0,
					'error'											=>TRUE
				);			
			}
		}
		else
		{
			$this->form_validation->set_rules('repuesto',$this->marvin->mysql_field_to_human('repuesto_principal'),'my_force_error' );
		}
		$this->template['repuesto_principal'] = $repuesto_principal;
		/*----------[le paso el material principal ]*/
		
		//OJO la validacion de frt tiene que estar despues de material principal,
		/*----------[le paso el frt y por las dudas lo normalizo]*/
		
		//si estoy editando, paso el valor frt horas que ya deberia estar cargado..
		if($version_actual)
		{
			$this->form_validation->set_defaults(
				array
				(
					'reclamo_garantia_version_field_valor_frt_hora'=>
					$version_actual[0]['reclamo_garantia_version_field_valor_frt_hora']
				),TRUE
			);
		}
		
		$frt = array();
		if(isset($_POST['frt']) && is_array($_POST['frt']))
		{
			reset($_POST['frt']);
			while(list($key,$val)=each($_POST['frt']))
			{
				
				$_POST['frt'][$key] = strtoupper($_POST['frt'][$key]);
				
				$error_frt_custom= FALSE;
				
				if(!isset($_POST['frt_hora'][$key]))
				{
					$_POST['frt_hora'][$key] = '';
				}
				
				$resultado = $this->r_garantia->get_frt_data($_POST['frt'][$key], $this->input->post('unidad_field_vin'), $_POST['frt_hora'][$key] );
				if(!$resultado)
				{
					//fuerzo el error, devuelvo los campos que mando
					$this->form_validation->set_rules('frt',$this->marvin->mysql_field_to_human('frt_id'),'my_force_error' );
					$frt[]=array(
						'frt_id'=>$_POST['frt'][$key],
						'reclamo_garantia_frt_field_frt_horas'=>$_POST['frt_hora'][$key],
						'reclamo_garantia_frt_field_frt_descripcion'=>'',
						'error' => TRUE
					);
				}
				else
				{
					if($resultado['custom']==1)
					{
						
						if(!is_numeric($_POST['frt_hora'][$key]))
						{
							$this->form_validation->set_rules('frt',$this->marvin->mysql_field_to_human('frt_id'),'my_force_error' );
							$error_frt_custom = TRUE;
						}
						else
						{
							$resultado['horas'] = $_POST['frt_hora'][$key];
							
						}
					}
					if($this->r_garantia->get_fix_bateria() )
					{
						/*fix bateria TODAS las horas de los frt pasan a 0*/
						$resultado['horas'] = 0;
						$_POST['frt_hora'][$key] = 0;
					
					}
					if($error_frt_custom)
					{
						$frt[]=array(
							'frt_id'=>$resultado['frt_id'],
							'reclamo_garantia_frt_field_frt_horas'=>$resultado['horas'],
							'reclamo_garantia_frt_field_frt_descripcion'=>$resultado['descripcion'],
							'error'=>TRUE
						);
					}
					else
					{
						$frt[]=array(
							'frt_id'=>$resultado['frt_id'],
							'reclamo_garantia_frt_field_frt_horas'=>$resultado['horas'],
							'reclamo_garantia_frt_field_frt_descripcion'=>$resultado['descripcion'],
						);
					}
				}
				
			
			$this->frt_procesados[$_POST['frt'][$key]] = TRUE;
			}
			
			//si es una campaña, verificamos que esten ingresados los frts requeridos
			if(!$this->r_garantia->campania_frt_ingresados())
			{
				$this->form_validation->set_rules('frt',$this->marvin->mysql_field_to_human('frt_id'),'my_force_error' );
			}
			
			
			
			
		}
		else
		{
			$this->form_validation->set_rules('frt',$this->marvin->mysql_field_to_human('frt_id'),'my_force_error' );
		}
		$this->template['frt'] = $frt;
		
		/*----------[le paso el frt ]*/
		
		
		/*----------[normalizando materiales secundarios ]*/
		$repuestos_secundarios = array();
		if(isset($_POST['repuesto'][1]))
		{
			$repuesto_secundario = $_POST['repuesto'];
			unset($repuesto_secundario[0]);  //el 0 es el repuesto / material principal
			while(list($key,$val)=each($repuesto_secundario))
			{
				
				if(strlen($_POST['repuesto'][$key])>1)
				{
					
					
					$_POST['repuesto'][$key] = strtoupper($_POST['repuesto'][$key]);
					
					$error = FALSE;
					if(!isset($_POST['factura_sap'][$key]))
					{
						$_POST['factura_sap'][$key]='';
					}
					else if(strlen($_POST['factura_sap'][$key])==0 && $this->r_garantia->get_version() != 'JAPON')
					{
						//no tiene factura, paso los demas valores a 0
						$_POST['repuesto_cantidad'][$key] = 0;
					}
					
					if(!isset($_POST['repuesto_cantidad'][$key]))
					{
						$_POST['repuesto_cantidad'][$key]=0;
					}
					if(!$this->r_garantia->validar_material_cantidad($_POST['repuesto'][$key],$_POST['repuesto_cantidad'][$key]))
					{
						$error = TRUE;
					}
					
					if($this->r_garantia->get_version() == 'JAPON')
					{
						$repuesto = array();
						$repuesto['precio'] 	= $this->r_garantia->get_precio_fob($_POST['repuesto'][$key]);
						$repuesto['material'] 	= $_POST['repuesto'][$key];
						$repuesto['documento_sap'] 	= '';
					}
					else
					{
						//TODO REVISAR SUCURSAL!
						$repuesto = $this->r_garantia->get_material_precio($_POST['factura_sap'][$key],
																					$_POST['repuesto'][$key],
																					FALSE
																					);																			
					}
					
					$descripcion = $this->r_garantia->get_material_descripcion($_POST['repuesto'][$key]);
					if($descripcion)
					{
						$repuesto_descripcion = $descripcion['descripcion'];
					}
					else
					{
						$error = TRUE;
						$repuesto_descripcion = '';
					}
					if($repuesto && !$error)
					{
						
						$_POST['repuesto'][$key] 				= $repuesto['material'];
						$_POST['factura_sap'][$key] 			= $repuesto['documento_sap'];
						$_POST['repuesto_precio_total'][$key] 	= $repuesto['repuesto_precio_total'] = $repuesto['precio']*$_POST['repuesto_cantidad'][$key];
						$_POST['repuesto_descripcion'][$key] 	= $repuesto_descripcion;
						$_POST['repuesto_cantidad'][$key] 		= $_POST['repuesto_cantidad'][$key]; //es boludo pero queda igual
						
						
						$repuestos_secundarios[]=array(
							'material_id'									=>$repuesto['material'],
							'material_facturacion_field_documento_sap_id'	=>$repuesto['documento_sap'],
							'reclamo_garantia_material_field_cantidad' 		=>$_POST['repuesto_cantidad'][$key],
							'reclamo_garantia_material_field_precio'		=>$repuesto['precio'],
							'Material'										=>array('material_field_desc'=>$repuesto_descripcion)
						);
					}
					else
					{
						if(!isset($repuesto['precio']))
						{
							$repuesto['precio'] = 0;
						}
						//set rules tiene que existe el post por lo que veo :S
						$this->form_validation->set_rules('repuesto_cantidad',$this->marvin->mysql_field_to_human('repuesto_secundario'),'my_force_error' );
						$repuestos_secundarios[]=array(
							'material_id'									=>$_POST['repuesto'][$key],
							'material_facturacion_field_documento_sap_id'	=>$_POST['factura_sap'][$key],
							'reclamo_garantia_material_field_cantidad' 		=>$_POST['repuesto_cantidad'][$key],
							'reclamo_garantia_material_field_precio'		=>$repuesto['precio'],
							'Material'										=>array('material_field_desc'=>$repuesto_descripcion),
							'error'											=>TRUE
						);			
					}
			
				}
				else
				{
					unset($repuesto_secundario[$key]);
				}//if strlen repuesto
			
			}
			
		}
		if(!$this->r_garantia->campania_materiales_ingresados())
		{
			$this->form_validation->set_rules('repuesto_cantidad',$this->marvin->mysql_field_to_human('numero_repuesto'),'my_force_error' );
		}
		$this->template['repuestos_secundarios'] = $repuestos_secundarios;
		
		
		/*----------[le paso trabajo de tercero ]*/
		$trabajo_tercero = array();
		if(isset($_POST['reclamo_garantia_trabajo_tercero_id']) && is_array($_POST['reclamo_garantia_trabajo_tercero_id']))
		{
			reset($_POST['reclamo_garantia_trabajo_tercero_id']);
			while(list($key,$val)=each($_POST['reclamo_garantia_trabajo_tercero_id']))
			{
				
				if(strlen($_POST['reclamo_garantia_trabajo_tercero_id'][$key])>1)
				{
					
					$trabajo_tercero_error = FALSE;
					
					if(!$this->valid_trabajo_tercero($_POST['reclamo_garantia_trabajo_tercero_id'][$key]))
					{
						$trabajo_tercero_error = TRUE;
					}
					
					if(!isset($_POST['trabajo_tercero_importe'][$key]))
					{
						$trabajo_tercero_error = TRUE;
						$_POST['trabajo_tercero_importe'][$key] = 0;
						
					}
					else if (!is_numeric($_POST['trabajo_tercero_importe'][$key]) || $_POST['trabajo_tercero_importe'][$key]<0)
					{
						$trabajo_tercero_error = TRUE;
					}
					
					$trabajo_tercero[]=array(
						
						'reclamo_garantia_version_trabajo_tercero_field_importe'=>$_POST['trabajo_tercero_importe'][$key],
						'reclamo_garantia_trabajo_tercero_id'=>$_POST['reclamo_garantia_trabajo_tercero_id'][$key],
						'error'=>$trabajo_tercero_error
					);
					if($trabajo_tercero_error)
					{
						$this->form_validation->set_rules('reclamo_garantia_trabajo_tercero_id',$this->marvin->mysql_field_to_human('reclamo_garantia_trabajo_tercero_id'),'my_force_error' );	
					}
				}
				else
				{
					unset($_POST['reclamo_garantia_trabajo_tercero_id'][$key]);
					unset($_POST['trabajo_tercero_importe'][$key]);
				}
				
				
			}
		}
		$this->template['trabajo_tercero'] = $trabajo_tercero;
		/*----------[le paso trabajo de tercero ]*/
		
		if($this->router->method!='add')
		{
			
			//$this->form_validation->set_defaults(array('Tsi'=>$this->registro_actual->Tsi->toArray()));
			$this->template['tsi'] = $this->registro_actual->Tsi->toArray();
			
		}
		
		$this->template['repuestos_secundarios'] = $repuestos_secundarios;
		/*----------[le paso los materiales secundarios ]*/
		
		
		/*
		Array
(
    [0] => Array
        (
            [id] => 35703
            [reclamo_garantia_version_id] => 35527
            [frt_id] => 218199
            [reclamo_garantia_frt_field_frt_horas] => 8.00
            [reclamo_garantia_frt_field_frt_descripcion] => Personalizado
            [created_at] => 0000-00-00 00:00:00
            [updated_at] => 0000-00-00 00:00:00
            [Reclamo_Garantia_Version] => 
        )

)


		*/
		
		

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
	
	/*
		TODO REVISAR
		
		esto no esta del todo seguro
	*/
	public function del_adjunto( $id_reclamo = FALSE, $id_adjunto= FALSE, $tabla = FALSE ) 
	{	
		
		if(!in_array($tabla,$this->upload_adjunto))
		{
			RETURN FALSE;
		}
		
		
		if(!$this->backend->_permiso('del') || !is_numeric($id_adjunto))
		{
			$error=array();
			$error['line'] 			= __LINE__;
			$error['file'] 			= __FILE__;
			$error['error']			= 'itentando eliminar adjunto sin permisos DEL y/o ID no numerica';
			$error['ID_REGISTRO']	= $id_registro;
			$error['ID_ADJUNTO']	= $id_adjunto;
			$this->backend->_log_error($error);
		}
		else
		{
			
			$modelo = str_replace('_',' ',$tabla);
			$modelo = ucwords($modelo);
			$modelo = str_replace(' ','_',$modelo);
			
			
			
			
			$q = Doctrine_Query::create()
			->from('Reclamo_Garantia_Version_'.$modelo.' Reclamo_Garantia_Version_'.$modelo)
			->leftJoin('Reclamo_Garantia_Version_'.$modelo.'.Reclamo_Garantia_Version Reclamo_Garantia_Version')
			->leftJoin('Reclamo_Garantia_Version.Reclamo_Garantia Reclamo_Garantia')
			->where('Reclamo_Garantia.id = ?',$id_reclamo)
			->addWhere('Reclamo_Garantia_Version_'.$modelo.'.id = ?', $id_adjunto);
			
			
			if($q->count()!=1)
			{
				$error=array();
				$error['line'] 			= __LINE__;
				$error['file'] 			= __FILE__;
				$error['error']			= 'No existe el adjunto';
				$error['sql'] 			= $q->getSqlQuery();
				$error['ID_REGISTRO']	= $id_registro;
				$error['ID_ADJUNTO']	= $id_adjunto;
				$this->_log_error($error);
				show_error('no se encuentra el adjunto'); //a la mierda
			}
			
			$adjunto=$q->fetchOne();
			$this->config->load('adjunto/reclamo_garantia_version_'.$tabla);
			
			$aux_archivo = 'reclamo_garantia_version_'.$tabla.'_field_archivo';
			$aux_extension = 'reclamo_garantia_version_'.$tabla.'_field_extension';
			
			@rename(
					$this->config->item('adjunto_path') . $adjunto->$aux_archivo . '.' . $adjunto->$aux_extension,
					$this->config->item('adjunto_path') . '_DELETED_' .$adjunto->$aux_archivo . '.' . $adjunto->$aux_extension
			);
			
			
				
			if(!$adjunto->delete()){
				$error=array();
				$error['line'] 			= __LINE__;
				$error['file'] 			= __FILE__;
				$error['error']			= 'no puedo eliminar Adjunto';
				$error['ID_REGISTRO']	= $id_registro;
				$error['ID_ADJUNTO']		= $id_adjunto;
				$this->_log_error($error);
			}else{
				if($this->input->post('ajax')){
					$this->output->set_output("TRUE");
				}
			}
				
				
		}	
	}
		
		
		
		
		
		//$rs		= $this->backend->del_adjunto($id_registro, $id_adjunto, $subfix);
				
		//-------------------------[comunes imagenes y adjuntos]
	
	//reset version japon
	
	public function reset($id)
	{
		//tiene la version japon generada?
		if($this->backend->_permiso('admin'))
		{
			try {
					$conn = Doctrine_Manager::connection();
					$conn->beginTransaction();		
			
					$this->_set_record($id, array('TSI.sucursal_id' => $this->session->userdata('sucursales') ));
					//TODO REVISAR ORDEN DE COMPRA!
					
					if($this->registro_actual->reclamo_garantia_estado_id == 3)
					{
						show_error('Orden de compra existente');
					}
					
					
					//paso a pendiente
					$this->registro_actual->reclamo_garantia_estado_id = 1; //pendiente;
					$this->registro_actual->save();
					
					//a ver si tiene vesion japon?
					foreach($this->registro_actual->Reclamo_Garantia_Version as $version)
					{
						if($version->reclamo_garantia_version_field_desc == 'JAPON' )
						{
							$version->Reclamo_Garantia_Frt->delete();
							$version->Reclamo_Garantia_Material_Principal->delete();
							$version->Reclamo_Garantia_Material_Secundario->delete();
							$version->Reclamo_Garantia_Version_Adjunto_Transporte->delete();
							$version->Reclamo_Garantia_Version_Adjunto_Rth->delete();
							$version->Reclamo_Garantia_Version_Adjunto_Trabajo_Tercero->delete();
							$version->Reclamo_Garantia_Version_Trabajo_Tercero->delete();
							$version->delete();
						}
					}
					
			}
			catch(Doctrine_Exception $e) {
				$conn->rollback();
				$error=array();
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= $e->errorMessage();
				$error['sql'] 		= 'error generando version japon';
				$this->backend->_log_error($error);
				show_error( $e->errorMessage()   );
			}
		
		redirect($this->get_abm_url()."/edit/".$id.'/HONDA');	
		}
		
	}
	
	
	
	
	/*
	*
	* Genera la version Japon a Partir de la Version HONDA :(
	* deberia ser con ->clone() pero no me funca
	*/
	
	private function generar_version_japon($id)
	{
				
		//tiene la version japon generada?
		if($this->backend->_permiso('admin'))
		{
			try {
				$conn = Doctrine_Manager::connection();
				$conn->beginTransaction();
				
				//tomo datos del reclamo de garantia...
				$rg = new Reclamo_Garantia();
				$q = $rg->get_all();
				$q->addWhere('RECLAMO_GARANTIA.id = ?',$id);
				$rg = $q->execute();
				$this->r_garantia->set_tsi($rg[0]->tsi_id);
				
				//tomo version honda
				$garantia = new Reclamo_Garantia_Version();
				$q = $garantia->get_all();
				$q->addWhere('reclamo_garantia_id = ?',$id);
				$q->addWhere('reclamo_garantia_version_field_desc = ?','HONDA');
				$version_honda=$q->execute();
				
				$valores = $this->r_garantia->get_tsi_valores_garantia($rg[0]->tsi_id);
				
				
				$rg[0]->reclamo_garantia_field_valor_hora_japon = $valores['valor_hora_japon'];
				$rg[0]->reclamo_garantia_field_valor_dolar = $valores['valor_dolar'];
				$rg->save();
				
				
				
				
				
				
				//existe version japon?
				$garantia = new Reclamo_Garantia_Version();
				$q = $garantia->get_all();
				$q->addWhere('reclamo_garantia_id = ?',$id);
				$q->addWhere('reclamo_garantia_version_field_desc = ?','JAPON');
				$version_japon=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
				
				
				if($version_honda && !$version_japon)
				{
					
					$this->valor_reclamado = 0;
					
					$japon = new Reclamo_Garantia_Version();
					$japon->reclamo_garantia_version_field_desc							= 'JAPON';
					$japon->reclamo_garantia_version_field_valor_reclamado 				= 0;
					$japon->reclamo_garantia_id 										= $version_honda[0]['reclamo_garantia_id'];
					$japon->reclamo_garantia_codigo_sintoma_id 							= $version_honda[0]['reclamo_garantia_codigo_sintoma_id'];
					$japon->reclamo_garantia_codigo_defecto_id 							= $version_honda[0]['reclamo_garantia_codigo_defecto_id'];
					$japon->reclamo_garantia_version_field_boletin_numero 				= $version_honda[0]['reclamo_garantia_version_field_boletin_numero'];
					$japon->reclamo_garantia_version_field_dtc_codigo 					= $version_honda[0]['reclamo_garantia_version_field_dtc_codigo'];
					$japon->reclamo_garantia_version_field_serie_inflador_original 		= $version_honda[0]['reclamo_garantia_version_field_serie_inflador_original'];
					$japon->reclamo_garantia_version_field_serie_inflador_colocado 		= $version_honda[0]['reclamo_garantia_version_field_serie_inflador_colocado'];
					$japon->reclamo_garantia_version_field_descripcion_sintoma 			= $version_honda[0]['reclamo_garantia_version_field_descripcion_sintoma'];
					$japon->reclamo_garantia_version_field_descripcion_diagnostico 		= $version_honda[0]['reclamo_garantia_version_field_descripcion_diagnostico'];
					$japon->reclamo_garantia_version_field_descripcion_tratamiento 		= $version_honda[0]['reclamo_garantia_version_field_descripcion_tratamiento'];
					$japon->reclamo_garantia_version_field_observaciones 				= $version_honda[0]['reclamo_garantia_version_field_observaciones'];
					$japon->reclamo_garantia_version_field_rth 							= $version_honda[0]['reclamo_garantia_version_field_rth'];
					$japon->reclamo_garantia_version_field_qic 							= $version_honda[0]['reclamo_garantia_version_field_qic'];
					$japon->reclamo_garantia_version_field_valor_frt_hora 				= $valores['valor_hora_japon'];
					$japon->reclamo_garantia_version_field_valor_transporte 			= 0; //transporte no se reclama a japon
					$japon->reclamo_garantia_version_field_valor_trabajo_tercero 		= $version_honda[0]['reclamo_garantia_version_field_valor_trabajo_tercero'];
					//$japon->reclamo_garantia_version_field_total_valor_reclamado 		= $version_honda[0]['reclamo_garantia_version_field_total_valor_reclamado'];
					$japon->reclamo_garantia_dtc_estado_id 								= $version_honda[0]['reclamo_garantia_dtc_estado_id'];
					$japon->reclamo_garantia_version_field_fechahora_alta 				= date('Y-m-d H:i:s', time());
					$japon->reclamo_garantia_version_field_admin_alta_id 				= $this->session->userdata('admin_id');
					$japon->save();
					
					//frts
					$frts = $version_honda[0]['Reclamo_Garantia_Frt'];
					foreach($frts as $frt)
					{
						$frtJ = $frt->copy(false);
						$frtJ->reclamo_garantia_version_id = $japon->id;
						$frtJ->save();
						$this->valor_reclamado+= $frtJ->reclamo_garantia_frt_field_frt_horas * $valores['valor_hora_japon'];
					}
					
					//repuesto principal
					$repuesto = $version_honda[0]->Reclamo_Garantia_Material_Principal->copy(false);
					$repuesto->reclamo_garantia_version_id = $japon->id;
					$repuesto->reclamo_garantia_material_field_precio = $this->r_garantia->get_precio_fob($repuesto->material_id);
					$repuesto->save();
					
					$this->valor_reclamado+= $repuesto->reclamo_garantia_material_field_precio * $repuesto->reclamo_garantia_material_field_cantidad * $valores['valor_alca'];
					
					//repuesto secundario
					if(isset($version_honda[0]['Reclamo_Garantia_Material_Secundario']))
					{
						foreach($version_honda[0]['Reclamo_Garantia_Material_Secundario'] as $repuesto_secundario)
						{
							$repuesto_secundarioJ = $repuesto_secundario->copy(false);
							$repuesto_secundarioJ->reclamo_garantia_version_id = $japon->id;
							$repuesto_secundarioJ->reclamo_garantia_material_field_precio = $this->r_garantia->get_precio_fob($repuesto_secundarioJ->material_id);
							$repuesto_secundarioJ->save();
							$this->valor_reclamado+= $repuesto_secundarioJ->reclamo_garantia_material_field_precio * $repuesto_secundarioJ->reclamo_garantia_material_field_cantidad * $valores['valor_alca'];
						}
					}
					
					
					//trabajo de tercero
					foreach($version_honda[0]['Reclamo_Garantia_Version_Trabajo_Tercero'] as $trabajo_tercero)
					{
						$tt = $trabajo_tercero->copy(false);
						$tt->reclamo_garantia_version_id = $japon->id;
						$tt->reclamo_garantia_version_trabajo_tercero_field_importe = $trabajo_tercero->reclamo_garantia_version_trabajo_tercero_field_importe / $valores['valor_dolar'];
						$this->valor_reclamado+= $tt->reclamo_garantia_version_trabajo_tercero_field_importe;
						$tt->save();
					}
					
					$japon->reclamo_garantia_version_field_valor_reclamado 				= $this->valor_reclamado;
					$japon->save();
					
				}else{
					$error=array();
					$error['line'] 		= __LINE__;
					$error['file'] 		= __FILE__;
					$error['error']		= 'intentando generar version JAPON de registro Inexistente id ='.$id;
					$error['sql'] 		= '';
					$this->backend->_log_error($error);	
					redirect($this->get_main_url());
				}
			
		
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
		
		
		
		
		}
		
		//tiene la version japon generada?

		
	}
	
	
	/*
		callbacks form validation
	*/
	
	
	function valid_valor_dolar($valor_dolar)
	{
		
		$this->form_validation->set_message('valid_valor_dolar', $this->lang->line('valid_valor_dolar'));
		
		if(!is_numeric($valor_dolar) || $valor_dolar<=0)
		{
			RETURN FALSE;
		}
		
		RETURN TRUE;
	}
	
	
	function valid_tarjeta($vin)
	{
		$this->form_validation->set_message('valid_tarjeta', $this->lang->line('valid_tarjeta'));
		//me fijo que tenga una tarjeta de garnatia activa
		$q = Doctrine_Query::create();
        $q->from('Tarjeta_Garantia Tarjeta_Garantia');
		$q->leftJoin('Tarjeta_Garantia.Unidad Unidad');
		$q->where('Unidad.unidad_field_vin = ?',$vin);
		$q->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id = ?',2);
		
		if($q->count()==1 || ($this->r_garantia->tsi_actual && $this->r_garantia->tsi_actual->tsi_field_kilometros_rotura <= 200) )
		{
			RETURN TRUE;
		}
		
		RETURN FALSE;
	}
	
	function valid_reclamo_garantia_estado($id_estado)
	{
		if(in_array($id_estado,$this->estados_invalidos))
		{
			RETURN FALSE;
		}
		
		RETURN TRUE;
	}
	
	
	public function valid_trabajo_tercero($id)
	{
		$this->form_validation->set_message('valid_trabajo_tercero', $this->lang->line('valid_trabajo_tercero'));		
		$q = Doctrine_Query::create()
		  ->from('reclamo_garantia_trabajo_tercero')
		  ->where('id = ?', $id);
		return ($q->count()==1) ? TRUE : FALSE;
		
	}
	
	public function valid_campania($id_campania)
	{
			
	
		
		$this->form_validation->set_message('valid_campania', $this->lang->line('valid_campania'));	
		if(strlen($id_campania)>1)
		{
			
			$id_reclamo = FALSE;
			if($this->registro_actual)
			{
				$id_reclamo=$this->registro_actual->id;
			}
			
			if($this->r_garantia->es_campania($id_campania))
			{
				
				//que la campaña no este ya ingresada para este auto
				if($this->r_garantia->es_campania_duplicada($id_campania, $id_reclamo ))
				{
					$this->form_validation->set_message('valid_campania', $this->lang->line('campania_duplicada'));		
				}
				else
				{
					RETURN TRUE;
				}
				
			}
		}
		else
		{
			$_POST['reclamo_garantia_campania_id'] = NULL;
			RETURN TRUE;
		}
		
		RETURN FALSE;
		
	}
	
	
	public function valid_tsi($tsi_id)
	{	
		
		$fecha = FALSE;
		if($this->router->method == 'add')
			$fecha = TRUE; //chequea que no hayan pasado mas de 30 dias
		if(!$this->r_garantia->set_tsi($tsi_id , $fecha))
		{
			$this->form_validation->set_message('valid_tsi', $this->lang->line('tsi_invalido'));
			RETURN FALSE;
		}
		$material = FALSE;
		if(isset($_POST['repuesto'][0]))
		{
			$material = $_POST['repuesto'][0];
		}
		
		
		
		//busco que no exista un reclamo de garantia para el mismo repuesto principal /tsi
		$q = Doctrine_Query::create()
		->from('Reclamo_Garantia Reclamo_Garantia')
		->leftJoin('Reclamo_Garantia.Reclamo_Garantia_Version Reclamo_Garantia_Version')
		->leftJoin('Reclamo_Garantia_Version.Reclamo_Garantia_Material_Principal Reclamo_Garantia_Material_Principal')
		->where('Reclamo_Garantia.tsi_id = ?',$tsi_id)
		->addWhere('Reclamo_Garantia_Material_Principal.material_id = ?',$material)
		->addWhere('Reclamo_Garantia_Material_Principal.reclamo_garantia_material_field_material_principal = ?',1)
		->addWhere('Reclamo_Garantia.reclamo_garantia_estado_id != ?',9);
		if($this->registro_actual)
		{
			$q->addWhere('Reclamo_Garantia.id != ?',$this->registro_actual->id);
		}
		
		
		
		if($q->count()!=0)
		{
			$this->form_validation->set_message('valid_tsi', $this->lang->line('tsi_repuesto_duplicado'));
			RETURN FALSE;
		}
		
		RETURN TRUE;
		
		
	}
	
	public function valid_adjunto_transporte()
	{
		if($this->r_garantia->get_version()=='JAPON')
		{
			//japon no lleva adjunto transporte
			RETURN TRUE;
		}
		
		$this->config->load('adjunto/reclamo_garantia_version_adjunto_transporte');	
		$this->upload->initialize($this->config->item('adjunto_upload'));
		$files = $this->multi_upload->go_upload('reclamo_garantia_version_adjunto_transporte');
	
		if ($files === FALSE )       
		{
			$data = $this->upload->data();
			$this->form_validation->set_message('valid_adjunto_transporte', $this->multi_upload->display_errors() .' ' .@$data['file_type']);
			RETURN FALSE;
		} 
		
		RETURN TRUE;
	}
	

	
	public function valid_adjunto_trabajo_tercero()
	{
		
		$this->config->load('adjunto/reclamo_garantia_version_adjunto_trabajo_tercero');	
		$this->upload->initialize($this->config->item('adjunto_upload'));
		$files = $this->multi_upload->go_upload('reclamo_garantia_version_adjunto_trabajo_tercero');
		
		if ($files === FALSE )      
		{	
			$data = $this->upload->data();
			$this->form_validation->set_message('valid_adjunto_trabajo_tercero', $this->multi_upload->display_errors() .' ' .@$data['file_type']);
			RETURN FALSE;
		} 
		
		RETURN TRUE;
	}
	
	public function valid_adjunto_rth()
	{
		
		$this->config->load('adjunto/reclamo_garantia_version_adjunto_rth');	
		$this->upload->initialize($this->config->item('adjunto_upload'));
		$files = $this->multi_upload->go_upload('reclamo_garantia_version_adjunto_rth');
		if ($files === FALSE )  
		{
			$data = $this->upload->data();
			$this->form_validation->set_message('valid_adjunto_rth', $this->multi_upload->display_errors() .' ' .@$data['file_type']);

			RETURN FALSE;
		} 
		
		RETURN TRUE;
	}
	
	//------------------------------------------------------------------------
	
	
	
	
	private function _crear_versiones()
	{
		/*
		$objRecord = Doctrine_Core::getTable('Table')->find(1);
$objRecord->RelationshipOne;
$objRecord->RelationshipTwo;
$objRecord2 = $objRecord->copy( true );
$objRecord2->save();
		*/
		//para los uploads...
		
		
		$valores = $this->r_garantia->get_tsi_valores_garantia($this->registro_actual->tsi_id);
		
		if($this->router->method!='add')
		{
			$versionActual = $this->registro_actual->Reclamo_Garantia_Version[0];
		}
		else
		{
			$versionActual = new Reclamo_Garantia_Version();
			
		}
		
		if($this->r_garantia->get_version()=='JAPON')
		{
			$valores['valor_frt_hora'] = $valores['valor_hora_japon'];
			$_POST['reclamo_garantia_version_field_valor_transporte'] = 0; //transporte no se reclama a japon
		}
		if($this->r_garantia->get_version()=='HONDA')
		{
			$valores['valor_dolar'] = $this->input->post('reclamo_garantia_field_valor_dolar');
		}
		
		
		$versionActual->reclamo_garantia_version_field_admin_alta_id = $this->session->userdata('admin_id');
		$versionActual->reclamo_garantia_version_field_fechahora_alta = date('Y-m-d H:i:s', time());
		$versionActual->reclamo_garantia_version_field_desc = $this->r_garantia->get_version();
		$versionActual->reclamo_garantia_id = $this->registro_actual->id;
		$versionActual->reclamo_garantia_version_field_valor_reclamado = 0; //TODO
		$versionActual->reclamo_garantia_version_field_evaluacion_tecnica = $this->input->post('reclamo_garantia_field_evaluacion_tecnica');
		$versionActual->reclamo_garantia_codigo_sintoma_id = $this->input->post('reclamo_garantia_codigo_sintoma_id');
		$versionActual->reclamo_garantia_codigo_defecto_id = $this->input->post('reclamo_garantia_codigo_defecto_id');
		$versionActual->reclamo_garantia_version_field_boletin_numero = $this->input->post('reclamo_garantia_version_field_boletin_numero');
		$versionActual->reclamo_garantia_dtc_estado_id = $this->input->post('reclamo_garantia_dtc_estado_id');
		$versionActual->reclamo_garantia_version_field_dtc_codigo = $this->input->post('reclamo_garantia_version_field_dtc_codigo');
		if(!in_array($this->registro_actual->reclamo_garantia_campania_id, $this->infladores))
		{
			$_POST['reclamo_garantia_version_field_serie_inflador_original'] = NULL;
			$_POST['reclamo_garantia_version_field_serie_inflador_colocado'] = NULL;
		}
		$versionActual->reclamo_garantia_version_field_serie_inflador_original = $this->input->post('reclamo_garantia_version_field_serie_inflador_original');
 		$versionActual->reclamo_garantia_version_field_serie_inflador_colocado = $this->input->post('reclamo_garantia_version_field_serie_inflador_colocado');
		$versionActual->reclamo_garantia_version_field_descripcion_sintoma = $this->input->post('reclamo_garantia_version_field_descripcion_sintoma');
		$versionActual->reclamo_garantia_version_field_descripcion_diagnostico = $this->input->post('reclamo_garantia_version_field_descripcion_diagnostico');
		$versionActual->reclamo_garantia_version_field_descripcion_tratamiento = $this->input->post('reclamo_garantia_version_field_descripcion_tratamiento');
		$versionActual->reclamo_garantia_version_field_observaciones = $this->input->post('reclamo_garantia_version_field_observaciones');
		$versionActual->reclamo_garantia_version_field_rth = $this->input->post('reclamo_garantia_version_field_rth');
		$versionActual->reclamo_garantia_version_field_qic = NULL; //nunca se uso...
		$versionActual->reclamo_garantia_version_field_valor_frt_hora = $valores['valor_frt_hora'];
		$versionActual->reclamo_garantia_version_field_valor_transporte = $this->input->post('reclamo_garantia_version_field_valor_transporte');
		$versionActual->reclamo_garantia_version_field_valor_trabajo_tercero = 0;
		
		$versionActual->save();
			
		$this->valor_reclamado = $this->valor_reclamado + $this->input->post('reclamo_garantia_version_field_valor_transporte');
		
		
		
		if($this->router->method=='add')
		{
			$versionH = $versionActual->copy(false);
			$versionH->reclamo_garantia_version_field_desc = 'HONDA';
			$versionH->save();
		}		
		
		//-----------upload adjunto transpporte
		$this->config->load('adjunto/reclamo_garantia_version_adjunto_transporte');	
		$this->upload->initialize($this->config->item('adjunto_upload'));
		$files = $this->multi_upload->go_upload('reclamo_garantia_version_adjunto_transporte');
		if ( ! $files )        
		{
			//$this->session->set_flashdata('upload_error', $this->multi_upload->display_errors());	
		}    
		else
		{
			$resultado = array('upload_data' => $files);
			while(list(,$archivo) = each($resultado['upload_data']))
			{
				//no se porq a veces viene con un punto
				$archivo['ext'] = str_replace(".",'',$archivo['ext']);
				
				$nuevo_nombre = url_title($versionActual->id . '-' . str_replace('.'.$archivo['ext'],'',$archivo['name']) . '-'. random_string('unique') );
				copy($archivo['file'], FCPATH . 'public/uploads/reclamo_garantia_version/adjunto_transporte/' . $nuevo_nombre . '.' . $archivo['ext']);
				
				//---[grabo el adjunto en la base]
				$objeto=new Reclamo_Garantia_Version_Adjunto_Transporte();
				$objeto->reclamo_garantia_version_adjunto_transporte_field_archivo = $nuevo_nombre;
				$objeto->reclamo_garantia_version_adjunto_transporte_field_extension = $archivo['ext'];
				$objeto->reclamo_garantia_version_id = $versionActual->id;
				$objeto->save();
				if($this->router->method=='add')
				{
					$nuevo_nombre = url_title($versionH->id . '-' . str_replace('.'.$archivo['ext'],'',$archivo['name']) . '-'. random_string('unique') );
					copy($archivo['file'], FCPATH . 'public/uploads/reclamo_garantia_version/adjunto_transporte/' . $nuevo_nombre . '.' . $archivo['ext']);
					$objeto=new Reclamo_Garantia_Version_Adjunto_Transporte();
					$objeto->reclamo_garantia_version_adjunto_transporte_field_archivo = $nuevo_nombre;
					$objeto->reclamo_garantia_version_adjunto_transporte_field_extension = $archivo['ext'];
					$objeto->reclamo_garantia_version_id = $versionH->id;
					$objeto->save();
				}	
			
			
				unlink($archivo['file']);
			
			}	
				
		}
		//-----------upload adjunto trasnporte
		
		//-----------upload adjunto trabajo de tercero
		$this->config->load('adjunto/reclamo_garantia_version_adjunto_trabajo_tercero');	
		$this->upload->initialize($this->config->item('adjunto_upload'));
		$files = $this->multi_upload->go_upload('reclamo_garantia_version_adjunto_trabajo_tercero');
		if ( ! $files )        
		{
			//$this->session->set_flashdata('upload_error', $this->multi_upload->display_errors());	
		}    
		else
		{
			$resultado = array('upload_data' => $files);
			while(list(,$archivo) = each($resultado['upload_data']))
			{
				//no se porq a veces viene con un punto
				$archivo['ext'] = str_replace(".",'',$archivo['ext']);
				
				$nuevo_nombre = url_title($versionActual->id . '-' . str_replace('.'.$archivo['ext'],'',$archivo['name']) . '-'. random_string('unique') );
				copy($archivo['file'], FCPATH . 'public/uploads/reclamo_garantia_version/adjunto_trabajo_tercero/' . $nuevo_nombre . '.' . $archivo['ext']);
				
				//---[grabo el adjunto en la base]
				$objeto=new Reclamo_Garantia_Version_Adjunto_Trabajo_Tercero();
				$objeto->reclamo_garantia_version_adjunto_trabajo_tercero_field_archivo = $nuevo_nombre;
				$objeto->reclamo_garantia_version_adjunto_trabajo_tercero_field_extension = $archivo['ext'];
				$objeto->reclamo_garantia_version_id = $versionActual->id;
				$objeto->save();
				if($this->router->method=='add')
				{
					$nuevo_nombre = url_title($versionH->id . '-' . str_replace('.'.$archivo['ext'],'',$archivo['name']) . '-'. random_string('unique') );
					copy($archivo['file'], FCPATH . 'public/uploads/reclamo_garantia_version/adjunto_trabajo_tercero/' . $nuevo_nombre . '.' . $archivo['ext']);
					$objeto=new Reclamo_Garantia_Version_Adjunto_Trabajo_Tercero();
					$objeto->reclamo_garantia_version_adjunto_trabajo_tercero_field_archivo = $nuevo_nombre;
					$objeto->reclamo_garantia_version_adjunto_trabajo_tercero_field_extension = $archivo['ext'];
					$objeto->reclamo_garantia_version_id = $versionH->id;
					$objeto->save();
				}	
			
			
				unlink($archivo['file']);
			
			}	
				
		}
		//-----------upload adjunto trabajo tercero
		
		
		//-----------upload adjunto rth
		$this->config->load('adjunto/reclamo_garantia_version_adjunto_rth');	
		$this->upload->initialize($this->config->item('adjunto_upload'));
		$files = $this->multi_upload->go_upload('reclamo_garantia_version_adjunto_rth');
		if ( ! $files )        
		{
			//$this->session->set_flashdata('upload_error', $this->multi_upload->display_errors());	
		}    
		else
		{
			$resultado = array('upload_data' => $files);
			while(list(,$archivo) = each($resultado['upload_data']))
			{
				//no se porq a veces viene con un punto
				$archivo['ext'] = str_replace(".",'',$archivo['ext']);
				
				$nuevo_nombre = url_title($versionActual->id . '-' . str_replace('.'.$archivo['ext'],'',$archivo['name']) . '-'. random_string('unique') );
				copy($archivo['file'], FCPATH . 'public/uploads/reclamo_garantia_version/adjunto_rth/' . $nuevo_nombre . '.' . $archivo['ext']);
				
				//---[grabo el adjunto en la base]
				$objeto=new Reclamo_Garantia_Version_Adjunto_Rth();
				$objeto->reclamo_garantia_version_adjunto_rth_field_archivo = $nuevo_nombre;
				$objeto->reclamo_garantia_version_adjunto_rth_field_extension = $archivo['ext'];
				$objeto->reclamo_garantia_version_id = $versionActual->id;
				$objeto->save();
				if($this->router->method=='add')
				{
					$nuevo_nombre = url_title($versionH->id . '-' . str_replace('.'.$archivo['ext'],'',$archivo['name']) . '-'. random_string('unique') );
					copy($archivo['file'], FCPATH . 'public/uploads/reclamo_garantia_version/adjunto_rth/' . $nuevo_nombre . '.' . $archivo['ext']);
					$objeto=new Reclamo_Garantia_Version_Adjunto_Rth();
					$objeto->reclamo_garantia_version_adjunto_rth_field_archivo = $nuevo_nombre;
					$objeto->reclamo_garantia_version_adjunto_rth_field_extension = $archivo['ext'];
					$objeto->reclamo_garantia_version_id = $versionH->id;
					$objeto->save();
				}	
			
			
				unlink($archivo['file']);
			
			}	
				
		}
		//-----------upload adjunto rth
		
		
		
		
		
		//ingreso los frts...
		$versionActual->Reclamo_Garantia_Frt->delete();
		$versionActual->save();
		$frts = $this->template['frt'];
		reset($frts);
		while(list($key,$val)=each($frts))
		{
			$reclamo_frt = new Reclamo_Garantia_Frt();
			$reclamo_frt->reclamo_garantia_version_id 					= $versionActual->id;
			$reclamo_frt->frt_id 										= $val['frt_id'];
			$reclamo_frt->reclamo_garantia_frt_field_frt_horas 			= $val['reclamo_garantia_frt_field_frt_horas'];
			$reclamo_frt->reclamo_garantia_frt_field_frt_descripcion 	= $val['reclamo_garantia_frt_field_frt_descripcion'];
			$reclamo_frt->save();
				
			$this->valor_reclamado = $this->valor_reclamado + ($val['reclamo_garantia_frt_field_frt_horas'] * $valores['valor_frt_hora']);
			if($this->router->method=='add')
			{			
				//si es version concesionario, creo la version honda con los mismos datos
				$reclamo_frtH = $reclamo_frt->copy(false);
				$reclamo_frtH->reclamo_garantia_version_id 				= $versionH->id;
				$reclamo_frtH->save();
			}
		}
		//fin ingreso los frts...
	
		//ingreso material principal
		//$versionActual->Reclamo_Garantia_Material_Principal->delete();
		//$versionActual->save();
		
		
		
		$repuesto_principal = $this->template['repuesto_principal'];
		$reclamo_repuesto = $versionActual->Reclamo_Garantia_Material_Principal;
		$reclamo_repuesto->reclamo_garantia_version_id = $versionActual->id;
		$reclamo_repuesto->material_id 											= $repuesto_principal['material_id'];
		$reclamo_repuesto->reclamo_garantia_material_field_cantidad 			= $repuesto_principal['reclamo_garantia_material_field_cantidad'];
		$reclamo_repuesto->reclamo_garantia_material_field_precio 				= $repuesto_principal['reclamo_garantia_material_field_precio'];
		$reclamo_repuesto->material_facturacion_field_documento_sap_id 			= $repuesto_principal['material_facturacion_field_documento_sap_id'];
		$reclamo_repuesto->reclamo_garantia_material_field_material_principal	= 1;
		$reclamo_repuesto->save();
		

		
		//a la version japon se multiplica el valor de los repuestos por un valor alca/plca
		if($this->r_garantia->get_version()=='JAPON')
		{
			$this->valor_reclamado = $this->valor_reclamado + ($repuesto_principal['reclamo_garantia_material_field_precio'] * $repuesto_principal['reclamo_garantia_material_field_cantidad'] * $valores['valor_alca']);
		}
		else
		{
			$this->valor_reclamado = $this->valor_reclamado + ($repuesto_principal['reclamo_garantia_material_field_precio'] * $repuesto_principal['reclamo_garantia_material_field_cantidad']);
		}
		
		if($this->router->method=='add')
		{			
			
			//si es version concesionario, creo la version honda con los mismos datos	
			$reclamo_repuestoH = new Reclamo_Garantia_Material();
			$reclamo_repuestoH->reclamo_garantia_version_id = $versionH->id;
			$reclamo_repuestoH->material_id = $reclamo_repuesto->material_id ;
			$reclamo_repuestoH->reclamo_garantia_material_field_cantidad = $reclamo_repuesto->reclamo_garantia_material_field_cantidad;
			$reclamo_repuestoH->reclamo_garantia_material_field_precio = $reclamo_repuesto->reclamo_garantia_material_field_precio;
			$reclamo_repuestoH->material_facturacion_field_documento_sap_id = $reclamo_repuesto->material_facturacion_field_documento_sap_id;
			$reclamo_repuestoH->reclamo_garantia_material_field_material_principal = $reclamo_repuesto->reclamo_garantia_material_field_material_principal;
			$reclamo_repuestoH->save();
		}
		//fin ingreso material principal

		
		if(isset($versionActual['Reclamo_Garantia_Material_Secundario']))
		{
			$versionActual->Reclamo_Garantia_Material_Secundario->delete();
			$versionActual->save();
		}
		//ingreso materiales secundarios
		
		
		
		$repuestos_secundarios = $this->template['repuestos_secundarios'];
		
		reset($repuestos_secundarios);
		while(list($key,$repuesto_secundario)=each($repuestos_secundarios))
		{
			
			$reclamo_repuesto = new Reclamo_Garantia_Material();
			$reclamo_repuesto->reclamo_garantia_version_id = $versionActual->id;
			$reclamo_repuesto->material_id 											= $repuesto_secundario['material_id'];
			$reclamo_repuesto->reclamo_garantia_material_field_cantidad 			= $repuesto_secundario['reclamo_garantia_material_field_cantidad'];
			$reclamo_repuesto->reclamo_garantia_material_field_precio 				= $repuesto_secundario['reclamo_garantia_material_field_precio'];
			$reclamo_repuesto->material_facturacion_field_documento_sap_id 			= $repuesto_secundario['material_facturacion_field_documento_sap_id'];
			$reclamo_repuesto->reclamo_garantia_material_field_material_principal	= 0;
			$reclamo_repuesto->save();
			
			//a la version japon se multiplica el valor de los repuestos por un valor alca/plca
			if($this->r_garantia->get_version()=='JAPON')
			{
				$this->valor_reclamado = $this->valor_reclamado + ($repuesto_secundario['reclamo_garantia_material_field_cantidad'] * $repuesto_secundario['reclamo_garantia_material_field_precio'] * $valores['valor_alca']);
			}
			else
			{
				$this->valor_reclamado = $this->valor_reclamado + ($repuesto_secundario['reclamo_garantia_material_field_cantidad'] * $repuesto_secundario['reclamo_garantia_material_field_precio']);
			}
			
			
			
			if($this->router->method=='add')
			{
				$reclamo_repuestoH = new Reclamo_Garantia_Material();
				$reclamo_repuestoH->reclamo_garantia_version_id = $versionH->id;
				$reclamo_repuestoH->material_id = $reclamo_repuesto->material_id ;
				$reclamo_repuestoH->reclamo_garantia_material_field_cantidad = $reclamo_repuesto->reclamo_garantia_material_field_cantidad;
				$reclamo_repuestoH->reclamo_garantia_material_field_precio = $reclamo_repuesto->reclamo_garantia_material_field_precio;
				$reclamo_repuestoH->material_facturacion_field_documento_sap_id = $reclamo_repuesto->material_facturacion_field_documento_sap_id;
				$reclamo_repuestoH->reclamo_garantia_material_field_material_principal = $reclamo_repuesto->reclamo_garantia_material_field_material_principal;
				$reclamo_repuestoH->save();
			}
		}
		//fin materiales secundarios
		
		
		
		
		
		//trabajo de terceros..
		$versionActual->Reclamo_Garantia_Version_Trabajo_Tercero->delete();
		$versionActual->save();
		$trabajo_terceros = $this->template['trabajo_tercero'];
		reset($trabajo_terceros);
		while(list($key,$trabajo_tercero)=each($trabajo_terceros))
		{
			
			$ttC = new Reclamo_Garantia_Version_Trabajo_Tercero();
			$ttC->reclamo_garantia_version_id = $versionActual->id;
			$ttC->reclamo_garantia_trabajo_tercero_id = $trabajo_tercero['reclamo_garantia_trabajo_tercero_id'];
			$ttC->reclamo_garantia_version_trabajo_tercero_field_importe = $trabajo_tercero['reclamo_garantia_version_trabajo_tercero_field_importe'];
			$ttC->save();
			
			$this->valor_reclamado = $this->valor_reclamado + $trabajo_tercero['reclamo_garantia_version_trabajo_tercero_field_importe'];
				
			if($this->router->method=='add')
			{
				//si es version concesionario, creo la version honda con los mismos datos	
				$ttH = new Reclamo_Garantia_Version_Trabajo_Tercero();
				$ttH->reclamo_garantia_version_id = $versionH->id;
				$ttH->reclamo_garantia_trabajo_tercero_id = $ttC->reclamo_garantia_trabajo_tercero_id;
				$ttH->reclamo_garantia_version_trabajo_tercero_field_importe =$ttC->reclamo_garantia_version_trabajo_tercero_field_importe;
				$ttH->save();
			}
		}	
		//fin trabajo de terceros
			
			
			
		//gastos de facturacion....
		if($this->r_garantia->get_version()!='JAPON')
		{
			$this->valor_reclamado = $this->valor_reclamado + ( ($valores['valor_ingresos_brutos'] * $this->valor_reclamado)/100  );
		}	
			
			
		$versionActual->reclamo_garantia_version_field_valor_reclamado = $this->valor_reclamado;
		$versionActual->save();
		if($this->router->method=='add')
		{
			$versionH->reclamo_garantia_version_field_valor_reclamado = $this->valor_reclamado;
			$versionH->save();
		}
		// fin nuevo reclamo de garantia
		
		
		
	}
	
	private function _reject_record()
	{
		if(in_array($this->registro_actual->reclamo_garantia_estado_id,$this->estados_invalidos) OR
			$this->registro_actual->reclamo_garantia_orden_compra_id > 0)
		{
			RETURN FALSE;
		}
		
		
		$this->registro_actual->reclamo_garantia_estado_id = 9;
		$this->registro_actual->reclamo_garantia_field_admin_rechaza_id = $this->session->userdata('admin_id');
		$this->registro_actual->reclamo_garantia_field_rechazo_motivo = $this->form_validation->xss_clean($this->input->post('rechazo_motivo'));;
		$this->registro_actual->reclamo_garantia_field_admin_modifica_id = $this->session->userdata('admin_id');
		$this->registro_actual->reclamo_garantia_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
		$this->registro_actual->save();
		
		RETURN TRUE;
	}
	
	
	
	
	
	
	
	
}       
