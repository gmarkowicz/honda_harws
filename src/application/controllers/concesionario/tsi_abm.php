<?php
define('ID_SECCION',3021);
class Tsi_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	//TODO !
	//maxima diferencia de dias entre fecha de egreso y fecha de carga (now)
	var $maxima_diferencia_dias = 15; 
	
	//filtro para los tsi tih
	var $tih = array();
	
	
	//filtra por sucursal?
	var $sucursal = TRUE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = TRUE;

	function __construct()
	{
		parent::Backend_Controller();
		
		//-------[PARCHE]
		if($this->session->userdata('show_tsi_tih') != TRUE )
		{
			//ocultamos servicios tih
			$this->tih = array('TSI_TIPO_SERVICIO.id != ?'=>9);
		}
		//-------[PARCHE]
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
				$this->registro_actual = new Tsi();
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
			$this->_set_record($this->input->post('id'), $this->tih);
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
		$this->_set_record($this->input->post('id'), $this->tih);
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			//$this->registro_actual->admin_deleted_id = $this->session->userdata('admin_id');
			//no borra los m2m con $this->registro_actual->delete(); :S

			$this->registro_actual->unlink('Many_Tsi_Tipo_Servicio');

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
				//no mando info, muestro la del registro por default
				$registro=$this->registro_actual;
				$registro_array = $registro->toArray();
				
				$this->form_validation->set_defaults($registro_array);
				
				$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
				$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
				$this->form_validation->set_defaults(array('unidad_field_codigo_de_radio'=>element('unidad_field_codigo_de_radio',$registro_array)));
				$this->form_validation->set_defaults(array('unidad_field_codigo_de_llave'=>element('unidad_field_codigo_de_llave',$registro_array)));
				$this->form_validation->set_defaults(array('unidad_field_patente'=>element('unidad_field_patente',$registro_array)));
				
				
				
				$actuales=array();
				foreach($registro->Many_Tsi_Tipo_Servicio as $relacion) {
					$actuales[]=$relacion->id;
				}
				$this->form_validation->set_defaults(array('many_tsi_tipo_servicio[]'=>$actuales));

							
				$cliente = $registro->Cliente->toArray();
				
				
					//$cliente = $este_cliente->toArray();
					//dios
					
					
					
					$data=array();
					$data['id']													=uniqid();
					$data['documento_tipo_id']									=element('documento_tipo_id',$cliente);
					//$data['cliente_conformidad_id']								=element('cliente_conformidad_id',$cliente);
					$data['cliente_field_numero_documento']						=element('cliente_field_numero_documento',$cliente);
					$data['cliente_sucursal_field_nombre']						=element('cliente_sucursal_field_nombre',$cliente);
					$data['cliente_sucursal_field_apellido']					=element('cliente_sucursal_field_apellido',$cliente);
					$data['cliente_sucursal_field_razon_social']				=element('cliente_sucursal_field_razon_social',$cliente);
					$data['cliente_sucursal_field_direccion_calle']				=element('cliente_sucursal_field_direccion_calle',$cliente);
					$data['cliente_sucursal_field_direccion_numero']			=element('cliente_sucursal_field_direccion_numero',$cliente);
					$data['cliente_sucursal_field_direccion_depto']				=element('cliente_sucursal_field_direccion_depto',$cliente);
					$data['cliente_sucursal_field_direccion_piso']				=element('cliente_sucursal_field_direccion_piso',$cliente);
					$data['cliente_sucursal_field_direccion_codigo_postal']		=element('cliente_sucursal_field_direccion_codigo_postal',$cliente);
					$data['cliente_sucursal_field_telefono_particular_codigo']	=element('cliente_sucursal_field_telefono_particular_codigo',$cliente);
					$data['cliente_sucursal_field_telefono_particular_numero']	=element('cliente_sucursal_field_telefono_particular_numero',$cliente);
					$data['cliente_sucursal_field_telefono_laboral_codigo']		=element('cliente_sucursal_field_telefono_laboral_codigo',$cliente);
					$data['cliente_sucursal_field_telefono_laboral_numero']		=element('cliente_sucursal_field_telefono_laboral_numero',$cliente);
					$data['cliente_sucursal_field_telefono_movil_codigo']		=element('cliente_sucursal_field_telefono_movil_codigo',$cliente);
					$data['cliente_sucursal_field_telefono_movil_numero']		=element('cliente_sucursal_field_telefono_movil_numero',$cliente);
					$data['cliente_sucursal_field_fax_codigo']					=element('cliente_sucursal_field_fax_codigo',$cliente);
					$data['cliente_sucursal_field_fax_numero']					=element('cliente_sucursal_field_fax_numero',$cliente);
					$data['cliente_sucursal_field_email']						=element('cliente_sucursal_field_email',$cliente);
					$data['cliente_sucursal_field_localidad_aux']				=element('cliente_sucursal_field_localidad_aux',$cliente);
					$data['cliente_sucursal_field_fecha_nacimiento']			=element('cliente_sucursal_field_fecha_nacimiento',$cliente);
					$data['sexo_id']											=element('sexo_id',$cliente);
					$data['tratamiento_id']										=element('tratamiento_id',$cliente);
					$data['pais_id']											=element('pais_id',$cliente);
					$data['provincia_id']										=$cliente['Cliente_Sucursal'][0]['provincia_id'];
					$data['ciudad_id']											=element('ciudad_id',$cliente);
					//------------ [select / checkbox / radio ciudad_id] :(
					
					
					
					$ciudad=new Ciudad();
					$q = $ciudad->get_all();
					$q->Where('provincia_id = ?', $data['provincia_id']);
					$q->orderBy('ciudad_field_desc');
					$config=array();
					$config['fields'] = array('ciudad_field_desc');
					$config['select'] = TRUE;
					$data['options_ciudad_id']=$this->_create_html_options($q, $config);
					
					$many_cliente[]=$data;
					
				
				//$this->form_validation->set_defaults(array('many_cliente'=>$many_cliente));
				$this->template['many_cliente'] = $many_cliente;
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
		$this->_set_record($id,$this->tih);
		$this->_mostrar_registro_actual($id);
		$this->_view();
	}
	
	
	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------
	
	//----------------------------------------------------------------
	//-------------------------[edita el registro]
	public function edit($id = FALSE)
	{
		$this->_set_record($id, $this->tih);
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
		
		$this->_set_record($id, $this->tih);
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
			$registro_array = $registro->toArray();
			
			$this->form_validation->set_defaults($registro_array);
		
			
			$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_codigo_de_radio'=>element('unidad_field_codigo_de_radio',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_codigo_de_llave'=>element('unidad_field_codigo_de_llave',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_patente'=>element('unidad_field_patente',$registro_array)));
			
			$actuales=array();
			foreach($registro->Many_Tsi_Tipo_Servicio as $relacion) {
				$actuales[]=$relacion->id;
			}
			$this->form_validation->set_defaults(array('many_tsi_tipo_servicio[]'=>$actuales));

						
			$cliente = $registro->Cliente->toArray();
			
			
				//$cliente = $este_cliente->toArray();
				//dios
				
				
				
				$data=array();
				$data['id']													=uniqid();
				$data['documento_tipo_id']									=element('documento_tipo_id',$cliente);
				//$data['cliente_conformidad_id']								=element('cliente_conformidad_id',$cliente);
				$data['cliente_field_numero_documento']						=element('cliente_field_numero_documento',$cliente);
				$data['cliente_sucursal_field_nombre']						=element('cliente_sucursal_field_nombre',$cliente);
				$data['cliente_sucursal_field_apellido']					=element('cliente_sucursal_field_apellido',$cliente);
				$data['cliente_sucursal_field_razon_social']				=element('cliente_sucursal_field_razon_social',$cliente);
				$data['cliente_sucursal_field_direccion_calle']				=element('cliente_sucursal_field_direccion_calle',$cliente);
				$data['cliente_sucursal_field_direccion_numero']			=element('cliente_sucursal_field_direccion_numero',$cliente);
				$data['cliente_sucursal_field_direccion_depto']				=element('cliente_sucursal_field_direccion_depto',$cliente);
				$data['cliente_sucursal_field_direccion_piso']				=element('cliente_sucursal_field_direccion_piso',$cliente);
				$data['cliente_sucursal_field_direccion_codigo_postal']		=element('cliente_sucursal_field_direccion_codigo_postal',$cliente);
				$data['cliente_sucursal_field_telefono_particular_codigo']	=element('cliente_sucursal_field_telefono_particular_codigo',$cliente);
				$data['cliente_sucursal_field_telefono_particular_numero']	=element('cliente_sucursal_field_telefono_particular_numero',$cliente);
				$data['cliente_sucursal_field_telefono_laboral_codigo']		=element('cliente_sucursal_field_telefono_laboral_codigo',$cliente);
				$data['cliente_sucursal_field_telefono_laboral_numero']		=element('cliente_sucursal_field_telefono_laboral_numero',$cliente);
				$data['cliente_sucursal_field_telefono_movil_codigo']		=element('cliente_sucursal_field_telefono_movil_codigo',$cliente);
				$data['cliente_sucursal_field_telefono_movil_numero']		=element('cliente_sucursal_field_telefono_movil_numero',$cliente);
				$data['cliente_sucursal_field_fax_codigo']					=element('cliente_sucursal_field_fax_codigo',$cliente);
				$data['cliente_sucursal_field_fax_numero']					=element('cliente_sucursal_field_fax_numero',$cliente);
				$data['cliente_sucursal_field_email']						=element('cliente_sucursal_field_email',$cliente);
				$data['cliente_sucursal_field_localidad_aux']				=element('cliente_sucursal_field_localidad_aux',$cliente);
				$data['cliente_sucursal_field_fecha_nacimiento']			=element('cliente_sucursal_field_fecha_nacimiento',$cliente);
				$data['sexo_id']											=element('sexo_id',$cliente);
				$data['tratamiento_id']										=element('tratamiento_id',$cliente);
				$data['pais_id']											=element('pais_id',$cliente);
				$data['provincia_id']										=$cliente['Cliente_Sucursal'][0]['provincia_id'];
				$data['ciudad_id']											=element('ciudad_id',$cliente);
				//------------ [select / checkbox / radio ciudad_id] :(
				
				
				
				$ciudad=new Ciudad();
				$q = $ciudad->get_all();
				$q->Where('provincia_id = ?', $data['provincia_id']);
				$q->orderBy('ciudad_field_desc');
				$config=array();
				$config['fields'] = array('ciudad_field_desc');
				$config['select'] = TRUE;
				$data['options_ciudad_id']=$this->_create_html_options($q, $config);
				
				$many_cliente[]=$data;
				
			
			//$this->form_validation->set_defaults(array('many_cliente'=>$many_cliente));
			$this->template['many_cliente'] = $many_cliente;

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
			
			
			//verifico que la unidad sea valida
			$unidad = Doctrine::getTable('Unidad')->findOneByunidad_field_vin($this->input->post('unidad_field_vin'));
			if(!$unidad)
			{
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= 'no encuentro unidad!';
				$this->backend->_log_error($error);
				show_error($error['error']);
			}
			
			$this->registro_actual->unidad_id = $unidad->id;
			
			// actualizo datos de la unidad
			$unidad->unidad_field_codigo_de_llave = $this->input->post('unidad_field_codigo_de_llave');
			$unidad->unidad_field_codigo_de_radio = $this->input->post('unidad_field_codigo_de_radio');
			$unidad->unidad_field_patente = $this->input->post('unidad_field_patente');
			$unidad->unidad_field_kilometros = $this->input->post('tsi_field_kilometros');
			//a ver si inactivo por kilometros...
			if($unidad->unidad_estado_garantia_id == 1 && $this->input->post('tsi_field_kilometros')>100000)
			{
				$unidad->unidad_estado_garantia_id = 2;
				$unidad->unidad_field_fecha_garantia_vencida = $this->input->post('tsi_field_fecha_de_egreso');
			}
			$unidad->save();
			// actualizo datos de la unidad
			
			if($this->router->method == 'add' )
			{
				$this->registro_actual->tsi_field_fechahora_alta = date('Y-m-d H:i:s', time());
				$this->registro_actual->tsi_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->tsi_estado_id = 2; //activo
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->tsi_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
				$this->registro_actual->tsi_field_admin_modifica_id = $this->session->userdata('admin_id');
			}
			
			$this->registro_actual->tsi_tipo_mantenimiento_id = $this->input->post('tsi_tipo_mantenimiento_id');
			$this->registro_actual->tsi_motivo_reparacion_id = $this->input->post('tsi_motivo_reparacion_id');
			
			$this->registro_actual->tsi_field_fecha_de_ingreso = $this->input->post('tsi_field_fecha_de_ingreso');
			$this->registro_actual->tsi_field_fecha_de_egreso = $this->input->post('tsi_field_fecha_de_egreso');
			$this->registro_actual->tsi_field_fecha_rotura = $this->input->post('tsi_field_fecha_rotura');
			
			$this->registro_actual->tsi_field_orden_de_reparacion = $this->input->post('tsi_field_orden_de_reparacion');
			$this->registro_actual->tsi_field_kilometros = $this->input->post('tsi_field_kilometros');
			$this->registro_actual->tsi_field_kilometros_rotura = $this->input->post('tsi_field_kilometros_rotura');
			$this->registro_actual->tsi_field_admin_recepcionista_id = $this->input->post('tsi_field_admin_recepcionista_id');
			$this->registro_actual->tsi_field_admin_tecnico_id = $this->input->post('tsi_field_admin_tecnico_id');
			$this->registro_actual->tsi_promocion_id = $this->input->post('tsi_promocion_id');
			$this->registro_actual->sucursal_id = $this->input->post('sucursal_id');
					
			$this->registro_actual->save();		
					
			
			
			

			$this->registro_actual->unlink('Many_Tsi_Tipo_Servicio');
			$this->registro_actual->save();
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_tsi_tipo_servicio')))
			{
					foreach($this->input->post('many_tsi_tipo_servicio') as $tsi_tipo_servicio_id) {
						$relacion=new Tsi_M_Tsi_Tipo_Servicio();
						$relacion->tsi_tipo_servicio_id = (int)$tsi_tipo_servicio_id;
						$relacion->tsi_id = $this->registro_actual->id;
						$relacion->save();
					}
			}
			
			//ingreso los clientes...
			$many_cliente = new Cliente_Sucursal();
			$config=array();
			
			$id_cliente = $many_cliente->ingresar_clientes($_POST,$this->input->post('sucursal_id'),$config);
			if(!is_array($id_cliente) || count($id_cliente)!=1)
			{
				
				$conn->rollback();
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= 'no se ingresaron clientes';
				$this->backend->_log_error($error);
				show_error($error['error']);
			}		
			
			$this->registro_actual->cliente_id = $id_cliente[0];
			$this->registro_actual->save();
			//echo $id_cliente[0] . ' ' . $this->registro_actual->cliente_id;
			//exit;
			//ingreso los clientes...


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
		
		
		//------------ [select / checkbox / radio admin_recepcionista_id] :(
		if($this->input->post('sucursal_id'))
		{
			$sucursal=$this->input->post('sucursal_id');
		}
		else if(isset($this->registro_actual->sucursal_id))
		{
			$sucursal=$this->registro_actual->sucursal_id;
		}else{
			$sucursal=FALSE;
		}
		$admin=new Admin();
		$q = $admin->get_recepcionistas();
		$q->Where('sucursal_id = ?', $sucursal);
		$config=array();
		$config['fields'] = array('admin_field_nombre','admin_field_apellido');
		$config['select'] = TRUE;
		$this->template['tsi_field_admin_recepcionista_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio admin_recepcionista_id]
		
		
		//------------ [select / checkbox / radio admin_tecnico_id] :(
		if($this->input->post('sucursal_id'))
		{
			$sucursal=$this->input->post('sucursal_id');
		}
		else if(isset($this->registro_actual->sucursal_id))
		{
			$sucursal=$this->registro_actual->sucursal_id;
		}else{
			$sucursal=FALSE;
		}
		$admin=new Admin();
		$q = $admin->get_tecnicos();
		$q->Where('sucursal_id = ?', $sucursal);
		$config=array();
		$config['fields'] = array('admin_field_nombre','admin_field_apellido');
		$config['select'] = TRUE;
		$this->template['tsi_field_admin_tecnico_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio admin_tecnico_id]
		
		
		/*

		//------------ [select / checkbox / radio tsi_field_admin_tecnico_id] :(
		$tsi_field_admin_tecnico=new Tsi_Field_Admin_Tecnico();
		$q = $tsi_field_admin_tecnico->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tsi_field_admin_tecnico_field_desc');
		$config['select'] = TRUE;
		$this->template['tsi_field_admin_tecnico_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tsi_field_admin_tecnico_id]

		*/
		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = TRUE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]


		//------------ [checkbox Many_Tsi_Tipo_Servicio]
		$tsi_tipo_servicio=new Tsi_Tipo_Servicio();
		$q = $tsi_tipo_servicio->get_all();
		//-------[PARCHE]
		if($this->session->userdata('show_tsi_tih')!=TRUE)
		{
			//ocultamos servicios tih
			$q->AddWhere("id != ?",9);
		}
		//ocultamos tipo de servicio promocion para los nuevos registros
		if($this->router->method == 'add' OR !$this->backend->_permiso('edit'))
		{
			$q->AddWhere("id != ?",6);
		}
		
		//-------[PARCHE]
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tsi_tipo_servicio_field_desc');
		$config['select'] = FALSE;
		$this->template['many_tsi_tipo_servicio']=$this->_create_html_options($q, $config);
		//------------ [fin checkbox Many_Tsi_Tipo_Servicio]

		//------------ [select / checkbox / radio  tsi_motivo_de_reparacion_id]
		$tsi_motivo_reparacion_id=new Tsi_Motivo_Reparacion();
		$q = $tsi_motivo_reparacion_id->get_all();
		$q->orderBy('id ASC');
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tsi_motivo_reparacion_field_desc');
		$config['select'] = TRUE;
		$config['order']  = TRUE;
		$this->template['tsi_motivo_reparacion_id']=$this->_create_html_options($q, $config);
		//------------ [select / checkbox / radio  checkbox tsi_motivo_reparacion]
		
		//------------ [select / checkbox / radio  tsi_tipo_de_mantenimiento]
		$tsi_tipo_de_mantenimiento=new Tsi_Tipo_Mantenimiento();
		$q = $tsi_tipo_de_mantenimiento->get_all();
		$q->orderBy('created_at DESC');
		$q->addOrderBy('id ASC');
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tsi_tipo_mantenimiento_field_desc');
		$config['select'] = TRUE;
		$config['order']  = TRUE;
		$this->template['tsi_tipo_mantenimiento_id']=$this->_create_html_options($q, $config);
		//------------ [select / checkbox / radio  checkbox tsi_tipo_de_mantenimiento]
		
		//------------ [select / checkbox / radio documento_tipo_id] :(
		$documento_tipo=new Documento_Tipo();
		$q = $documento_tipo->get_all();
		$config=array();
		$config['fields'] = array('documento_tipo_field_desc');
		$config['select'] = TRUE;
		$this->template['options_documento_tipo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio documento_tipo_id]
		
		//------------ [select / checkbox / radio cliente_conformidad] :(
		$cliente_conformidad=new Cliente_Conformidad();
		$q = $cliente_conformidad->get_all();
		$config=array();
		$config['fields'] = array('cliente_conformidad_field_desc');
		$config['select'] = TRUE;
		$this->template['options_cliente_conformidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_conformidad]
		
		//------------ [select / checkbox / radio sexo_id] :(
		$sexo=new Sexo();
		$q = $sexo->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sexo_field_desc');
		$config['select'] = TRUE;
		$this->template['options_sexo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sexo_id]
		
		//------------ [select / checkbox / radio tratamiento_id] :(
		$tratamiento=new Tratamiento();
		$q = $tratamiento->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tratamiento_field_desc');
		$config['select'] = TRUE;
		$this->template['options_tratamiento_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tratamiento_id]

		//------------ [select / checkbox / radio provincia_id] :(
		$provincia=new Provincia();
		$q = $provincia->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('provincia_field_desc');
		$config['select'] = TRUE;
		$this->template['options_provincia_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio provincia_id]
		
		//------------ [select / checkbox / radio tsi_promocion_id] :(
		$obj=new Tsi_Promocion();
		$q = $obj->get_all();
		$q->expireResultCache(TRUE); //borra la cache
		if($this->router->method == 'add')
		{
				$q->addWhere('TO_DAYS( NOW() ) - TO_DAYS(tsi_promocion_field_fecha_fin) <= ?',15);
		}
		$q->orderBy('TSI_PROMOCION.tsi_promocion_field_desc ASC');
		
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tsi_promocion_field_desc');
		$config['select'] = TRUE;
		$config['order']  = TRUE;
		$this->template['tsi_promocion_id']=$this->_create_html_options($q, $config);
		
		//------------ [fin select / checkbox / radio provincia_id]
			
		
		
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
			if(!$this->backend->_permiso('admin'))
			{
				$_POST['tsi_field_fecha_rotura'] = $this->marvin->mysql_date_to_form($this->registro_actual->tsi_field_fecha_rotura); //esto es por si hay un reclamo de garantia...
			}
		}else{
			$id = FALSE;
		}
				
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));
		
		
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
				'trim|required|alpha_numeric|my_exist_unidad['.$this->input->post('unidad_field_vin').']' );
		
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
				'trim|required|exact_length[17]|alpha_numeric' );
		
		$this->form_validation->set_rules('tsi_field_fecha_de_ingreso',$this->marvin->mysql_field_to_human('tsi_field_fecha_de_ingreso'),
				'trim|required|my_form_date_reverse|my_valid_date[y-m-d,-,1]' );
		
		$this->form_validation->set_rules('tsi_field_fecha_de_egreso',$this->marvin->mysql_field_to_human('tsi_field_fecha_de_egreso'),
				'trim|required|my_form_date_reverse|my_valid_date[y-m-d,-,1]|callback_valid_fecha_egreso' );
				
				
		$this->form_validation->set_rules('tsi_field_fecha_rotura',$this->marvin->mysql_field_to_human('tsi_field_fecha_rotura'),
				'trim|required|my_form_date_reverse|my_valid_date[y-m-d,-,1]|callback_valid_fecha_rotura' );
				
		if(strlen($this->input->post('unidad_field_codigo_de_llave'))>0)
		{
			$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
				'trim|my_valid_codigo_de_llave' );
		}else{
			$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
				'trim' );
		}
		
		
		$this->form_validation->set_rules('unidad_field_patente',$this->marvin->mysql_field_to_human('unidad_field_patente'),
			'strtoupper|trim|my_valid_patente' );
		
		
		
		
		if(strlen($this->input->post('unidad_field_codigo_de_radio'))>0)
		{
			$this->form_validation->set_rules('unidad_field_codigo_de_radio',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_radio'),
				'trim|my_valid_codigo_de_radio' );
		}
				
		
		$this->form_validation->set_rules('tsi_promocion_id',$this->marvin->mysql_field_to_human('tsi_promocion_id'),
				'trim|callback_valid_promocion' );
		
		$this->form_validation->set_rules('sucursal_id',$this->marvin->mysql_field_to_human('sucursal_id'),
				'trim|required|is_natural_no_zero|my_valid_sucursal' );
		
		$this->form_validation->set_rules('tsi_field_orden_de_reparacion',$this->marvin->mysql_field_to_human('tsi_field_orden_de_reparacion'),
				'trim|max_length[50]|' );

		$this->form_validation->set_rules('tsi_field_kilometros',$this->marvin->mysql_field_to_human('tsi_field_kilometros'),
				'trim|required|integer|callback_valid_kilometros' );
				
		$this->form_validation->set_rules('tsi_field_kilometros_rotura',$this->marvin->mysql_field_to_human('tsi_field_kilometros_rotura'),
				'trim|required|integer|callback_valid_kilometros_rotura' );
		

		$this->form_validation->set_rules('tsi_field_admin_recepcionista_id',$this->marvin->mysql_field_to_human('tsi_field_admin_recepcionista_id'),
				'trim' );

		$this->form_validation->set_rules('tsi_field_recepcionista_old',$this->marvin->mysql_field_to_human('tsi_field_recepcionista_old'),
				'trim|max_length[50]' );

		$this->form_validation->set_rules('tsi_field_admin_tecnico_id',$this->marvin->mysql_field_to_human('tsi_field_admin_tecnico_id'),
				'trim' );

		$this->form_validation->set_rules('tsi_field_tecnico_old',$this->marvin->mysql_field_to_human('tsi_field_tecnico_old'),
				'trim|max_length[50]' );

		$this->form_validation->set_rules('many_tsi_tipo_servicio[]',$this->marvin->mysql_field_to_human('tsi_tipo_servicio_id'),
			'trim|required|callback_valid_tsi_tipo_servicio' );
		
		$tipo_servicio = $this->input->post('many_tsi_tipo_servicio');
		if(is_array($tipo_servicio) && (in_array(1, $tipo_servicio))) 
		{
			$this->form_validation->set_rules('tsi_tipo_mantenimiento_id',$this->marvin->mysql_field_to_human('tsi_tipo_mantenimiento_id'),
				'trim|required|is_natural_no_zero' );
		}else{
			$_POST['tsi_tipo_mantenimiento_id'] = NULL;
			$this->form_validation->set_rules('tsi_tipo_mantenimiento_id',$this->marvin->mysql_field_to_human('tsi_tipo_mantenimiento_id'),
				'trim' );
		}
		
		//--reparacion y reparacion en garantia requieren un motivo de reparacion
		if(is_array($tipo_servicio) && (in_array(2, $tipo_servicio) || in_array(7, $tipo_servicio))) 
		{
			$this->form_validation->set_rules('tsi_motivo_reparacion_id',$this->marvin->mysql_field_to_human('tsi_motivo_reparacion_id'),
				'trim' );
			/* parece que ahora no es requerido....
			$this->form_validation->set_rules('tsi_motivo_reparacion_id',$this->marvin->mysql_field_to_human('tsi_motivo_reparacion_id'),
				'trim|required|is_natural_no_zero' );
			*/
		}
		else
		{
			$_POST['tsi_motivo_reparacion_id'] = NULL;
			$this->form_validation->set_rules('tsi_motivo_reparacion_id',$this->marvin->mysql_field_to_human('tsi_motivo_reparacion_id'),
				'trim' );
		}
		//--reparacion y reparacion en garantia requieren un motivo de reparacion
		
		//bue, esto se complica.... asigno los many clientes a post para que los tome el form validation
		//ver cliente_sucursal_inc_view
		$many_cliente=array();
		
		//quilombo revisar..
		$many_cliente = $this->_validar_cliente_desde_post();
		//asigno los clientes a la vista
		$this->template['many_cliente']=$many_cliente;
		
		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------


	//return array $many_cliente
	//TODO esto tiene que ir en una libreria!
	private function _validar_cliente_desde_post()
	{
		$many_cliente=array();
		$documentos=array();
		
		if(isset($_POST['cliente']['documento_tipo_id']) && is_array($_POST['cliente']['documento_tipo_id']))
		{
			foreach($_POST['cliente']['documento_tipo_id'] as $key=>$value)
			{
				$data=array();
				$_POST[$key]['id']													=
					$key;
					
				$_POST[$key]['documento_tipo_id']									=
					@$_POST['cliente']['documento_tipo_id'][$key];
				/*	
				$_POST[$key]['cliente_conformidad_id']								=
					@$_POST['cliente']['cliente_conformidad_id'][$key];
				*/
				$_POST[$key]['cliente_field_numero_documento']						=
					@$_POST['cliente']['cliente_field_numero_documento'][$key];
					
				$_POST[$key]['cliente_sucursal_field_nombre']						=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_nombre'][$key];
					
				$_POST[$key]['cliente_sucursal_field_apellido']						=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_apellido'][$key];
					
				$_POST[$key]['cliente_sucursal_field_razon_social']					=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_razon_social'][$key];
					
				$_POST[$key]['cliente_sucursal_field_direccion_calle']				=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_direccion_calle'][$key];
					
				$_POST[$key]['cliente_sucursal_field_direccion_numero']				=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_direccion_numero'][$key];
					
				$_POST[$key]['cliente_sucursal_field_direccion_depto']				=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_direccion_depto'][$key];
					
				$_POST[$key]['cliente_sucursal_field_direccion_piso']				=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_direccion_piso'][$key];
					
				$_POST[$key]['cliente_sucursal_field_direccion_codigo_postal']		=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_direccion_codigo_postal'][$key];
					
				$_POST[$key]['cliente_sucursal_field_telefono_particular_codigo']	=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_telefono_particular_codigo'][$key];
					
				$_POST[$key]['cliente_sucursal_field_telefono_particular_numero']	=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_telefono_particular_numero'][$key];
					
				$_POST[$key]['cliente_sucursal_field_telefono_laboral_codigo']		=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_telefono_laboral_codigo'][$key];
				
				$_POST[$key]['cliente_sucursal_field_telefono_laboral_numero']		=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_telefono_laboral_numero'][$key];
				
				$_POST[$key]['cliente_sucursal_field_telefono_movil_codigo']		=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_telefono_movil_codigo'][$key];
					
				$_POST[$key]['cliente_sucursal_field_telefono_movil_numero']		=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_telefono_movil_numero'][$key];
				
				$_POST[$key]['cliente_sucursal_field_fax_codigo']					=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_fax_codigo'][$key];
				
				$_POST[$key]['cliente_sucursal_field_fax_numero']					=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_fax_numero'][$key];
					
				$_POST[$key]['cliente_sucursal_field_email']						=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_email'][$key];
					
				$_POST[$key]['cliente_sucursal_field_localidad_aux']				=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_localidad_aux'][$key];
					
				$_POST[$key]['cliente_sucursal_field_fecha_nacimiento']				=
					@$_POST['cliente_sucursal']['cliente_sucursal_field_fecha_nacimiento'][$key];
				
				
				$_POST[$key]['cliente_sucursal_field_fecha_nacimiento'] = $this->form_validation->my_form_date_reverse($_POST[$key]['cliente_sucursal_field_fecha_nacimiento']);
				if($_POST[$key]['cliente_sucursal_field_fecha_nacimiento']=='0000-00-00')
				{
					$_POST[$key]['cliente_sucursal_field_fecha_nacimiento']=FALSE;
				}
				
				$_POST['cliente_sucursal']['pais_id'][$key] = 1;
				
				
				$_POST[$key]['sexo_id']			=@$_POST['cliente_sucursal']['sexo_id'][$key];
				$_POST[$key]['tratamiento_id']	=@$_POST['cliente_sucursal']['tratamiento_id'][$key];
				$_POST[$key]['pais_id']			=@$_POST['cliente_sucursal']['pais_id'][$key];
				$_POST[$key]['provincia_id']	=@$_POST['cliente_sucursal']['provincia_id'][$key];
				$_POST[$key]['ciudad_id']		=@$_POST['cliente_sucursal']['ciudad_id'][$key];
				
				#creo el select de ciudad acorde a la provincia del cliente
				$ciudad=new Ciudad();
				$q = $ciudad->get_all();
				$q->Where('provincia_id = ?', @$_POST[$key]['provincia_id']);
				$q->orderBy('ciudad_field_desc');
				$config=array();
				$config['fields'] = array('ciudad_field_desc');
				$config['select'] = TRUE;
				$_POST[$key]['options_ciudad_id']=$this->_create_html_options($q, $config);
				
				
				//-----form validation
				
				
				$this->form_validation->set_rules($key.'[documento_tipo_id]',$this->marvin->mysql_field_to_human('documento_tipo_id'),
					'trim|required|is_natural_no_zero|' );
				/*
				$this->form_validation->set_rules($key.'[cliente_conformidad_id]',$this->marvin->mysql_field_to_human('cliente_conformidad_id'),
					'trim|required|is_natural_no_zero' );
				*/
				if($_POST[$key]['documento_tipo_id']==4)
				{
					$this->form_validation->set_rules($key.'[cliente_field_numero_documento]',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
					'trim|required|integer|my_valid_cuit' );
				}else{
					$this->form_validation->set_rules($key.'[cliente_field_numero_documento]',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
					'trim|required|integer|my_valid_documento' );
				}
				//que el documento no este repetido!
				if(in_array($_POST[$key]['cliente_field_numero_documento'], $documentos))
				{
					//que forma fea de forzar un error :S	
					$this->form_validation->set_rules($key.'[cliente_field_numero_documento]',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
					'trim|required|my_valid_codigo_de_llave' );
				}
				
				if(strlen($_POST[$key]['cliente_sucursal_field_razon_social'])>0)
				{
					#existe el campo razon social desecho nombre y apellido
					//$_POST[$key]['cliente_sucursal_field_nombre'] = FALSE;
					//$_POST[$key]['cliente_sucursal_field_apellido'] = FALSE;
					$this->form_validation->set_rules($key.'[cliente_sucursal_field_razon_social]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_razon_social'),
					'trim|required|min_length[3]|max_length[255]' );
					
				}else{
					$this->form_validation->set_rules($key.'[cliente_sucursal_field_nombre]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_nombre'),
					'trim|required|min_length[3]|max_length[255]' );
					
					
				$this->form_validation->set_rules($key.'[cliente_sucursal_field_apellido]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_apellido'),
					'trim|required|min_length[3]|max_length[255]' );
				}
				
				if(strlen($_POST[$key]['cliente_sucursal_field_email'])>0)
				{
				
					$this->form_validation->set_rules($key.'[cliente_sucursal_field_email]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_email'),
						'trim|required|valid_email' );
				}
				else
				{
					$this->form_validation->set_rules($key.'[cliente_sucursal_field_email]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_email'),
						'trim' );
				}
				
				/*cliente y razon social no pueden venir juntos*/
				if(strlen($_POST[$key]['cliente_sucursal_field_razon_social'])>0 && (strlen($_POST[$key]['cliente_sucursal_field_apellido'])>0 || strlen($_POST[$key]['cliente_sucursal_field_nombre'])>0))
				{
					$this->form_validation->set_rules($key.'[cliente_sucursal_field_apellido]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_apellido'),
					'required|my_force_error' );
					$this->form_validation->set_rules($key.'[cliente_sucursal_field_nombre]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_nombre'),
					'required|my_force_error' );
					$this->form_validation->set_rules($key.'[cliente_sucursal_field_razon_social]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_razon_social'),
					'required|my_force_error' );
				}
				
				$this->form_validation->set_rules($key.'[tratamiento_id]',$this->marvin->mysql_field_to_human('tratamiento_id'),
					'trim|required|is_natural_no_zero' );
					
					$this->form_validation->set_rules($key.'[sexo_id]',$this->marvin->mysql_field_to_human('sexo_id'),
					'trim' );
					
				$this->form_validation->set_rules($key.'[cliente_sucursal_field_direccion_calle]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_calle'),
					'trim|required|min_length[3]|max_length[255]' );
				
				$this->form_validation->set_rules($key.'[cliente_sucursal_field_direccion_numero]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_numero'),
					'trim|required|numeric' );
				
				$this->form_validation->set_rules($key.'[cliente_sucursal_field_direccion_piso]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_piso'),
					'trim' );
				$this->form_validation->set_rules($key.'[cliente_sucursal_field_direccion_depto]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_depto'),
					'trim' );
				
				$this->form_validation->set_rules($key.'[cliente_sucursal_field_direccion_codigo_postal]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_codigo_postal'),
					'trim|required|alpha_numeric|min_length[4]' );
				
				$this->form_validation->set_rules($key.'[provincia_id]',$this->marvin->mysql_field_to_human('provincia_id'),
					'trim|required|is_natural_no_zero' );
				
				$this->form_validation->set_rules($key.'[ciudad_id]',$this->marvin->mysql_field_to_human('ciudad_id'),
					'trim|required|is_natural_no_zero' );
					
				$this->form_validation->set_rules($key.'[cliente_sucursal_field_localidad_aux]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_localidad_aux'),
					'trim' );
				
					
				
				
				if(strlen($_POST[$key]['cliente_sucursal_field_fecha_nacimiento'])>0)
				{
				$this->form_validation->set_rules($key.'[cliente_sucursal_field_fecha_nacimiento]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_fecha_nacimiento'),
					'trim|my_valid_date[y-m-d,-,1]' );
				}else{
					$this->form_validation->set_rules($key.'[cliente_sucursal_field_fecha_nacimiento]',$this->marvin->mysql_field_to_human('cliente_sucursal_field_fecha_nacimiento'),
					'trim' );
				
				}
				
				
				
				$documentos[]=$_POST[$key]['cliente_field_numero_documento'];
				
				//-----form validation
				
				$many_cliente[]=$_POST[$key];
			}
		}else{
				$this->form_validation->set_rules('[documento_tipo_id]',$this->marvin->mysql_field_to_human('documento_tipo_id'),
					'trim|required|is_natural_no_zero|' );
		}
		return $many_cliente;
	}
	
	
	//------ rechazando tarjeta de garantia
	private function _reject_record()
	{
		
		if(!$this->registro_actual || $this->registro_actual->tsi_estado_id!=2 || !$this->backend->_permiso('admin'))
		{
			return FALSE;
		}
		
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			//
				
				
				$this->registro_actual->tsi_field_rechazo_motivo	= $this->input->post('rechazo_motivo');
				$this->registro_actual->tsi_field_admin_rechaza_id	= $this->session->userdata('admin_id');
				$this->registro_actual->tsi_estado_id				= 9;
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
	
	function valid_fecha_egreso($fecha)
	{
		
		$this->form_validation->set_message('valid_fecha_egreso', sprintf($this->lang->line('valid_fecha_egreso'), $this->lang->line('fecha_de_egreso'), $this->lang->line('fecha_de_ingreso')));
		
		
		$ingreso = date_create($this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_de_ingreso')));
		$egreso = date_create($this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_de_egreso')));
		
		if($egreso>=$ingreso)
			RETURN TRUE;
		
		RETURN FALSE;
		
	}
	
	function valid_fecha_rotura($fecha)
	{
		$tipo_servicio = $this->input->post('many_tsi_tipo_servicio');
		if(!is_array($tipo_servicio))
		{
			$tipo_servicio = array();
		}
		
		$ingreso = date_create( $this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_de_ingreso')) );
		$rotura = date_create( $this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_rotura')) );
		if($ingreso<$rotura)
		{
			$this->form_validation->set_message('valid_fecha_rotura', sprintf($this->lang->line('valid_fecha_rotura'), $this->lang->line('fecha_rotura'), $this->lang->line('fecha_de_ingreso')));
			RETURN FALSE;
		}
		
		
		//saco el pdi si existe, y valido los demas tipos de servicio
		$r = array_search(4, $tipo_servicio);
		if($r!==FALSE)
		{
			unset($tipo_servicio[$r]);
		}
		if(count($tipo_servicio)>0)
		{
			//busco la fecha de entrega de la unidad, a ver si se rompio antes de entregar en caso que no sea PDI...
			$q = Doctrine_Query::create()
				->select('Unidad.unidad_field_fecha_entrega')
				->from('Unidad Unidad')
				->where('Unidad.unidad_field_vin = ?',$this->input->post('unidad_field_vin'))
				;
			if($q->count()==0)
			{
				$this->form_validation->set_message('valid_fecha_rotura', $this->lang->line('no_existe_tarjeta_garantia'));
				RETURN FALSE;
			}
			else
			{
				$unidad = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
				$fecha_unidad_entrega = date_create( $unidad['unidad_field_fecha_entrega'] );
				$fecha_rotura = date_create( $this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_rotura')) );
				if($fecha_rotura<$fecha_unidad_entrega)
				{
					$this->form_validation->set_message('valid_fecha_rotura', sprintf($this->lang->line('fecha_rotura_mayor_fecha_entrega_unidad'), $this->lang->line('fecha_rotura'), $this->marvin->mysql_field_to_human('unidad_field_fecha_entrega')));
					RETURN FALSE;
				}
			}
		}
		
		RETURN TRUE;
	}
	
	function valid_kilometros($kilometros)
	{
		
		
		$tipo_servicio = $this->input->post('many_tsi_tipo_servicio');
		if(!is_array($tipo_servicio))
		{
			$tipo_servicio = array();
		}
		if(in_array(4, $tipo_servicio) && $kilometros>200) 
		{
			//si hay pdi tiene que tener menos de 200km
			$this->form_validation->set_message('valid_kilometros', $this->lang->line('pdi_200_kms'));
			RETURN FALSE;
		}
		
		/*
		//saco el pdi y accesorios si existen, y valido los demas tipos de servicio
		$r = array_search(4, $tipo_servicio);
		if($r!==FALSE)
		{
			unset($tipo_servicio[$r]);
		}
		$r = array_search(5, $tipo_servicio);
		if($r!==FALSE)
		{
			unset($tipo_servicio[$r]);
		}
		if(count($tipo_servicio)>0 && $kilometros<100)
		{
			$this->form_validation->set_message('valid_kilometros', sprintf($this->lang->line('error_tipo_servicio_kms'), $this->lang->line('kilometros')));
			RETURN FALSE;
		}
		*/
		
		
		$tipo_servicio = $this->input->post('many_tsi_tipo_servicio');
		if(!is_array($tipo_servicio))
		{
			$tipo_servicio = array();
		}
		//se validan SOLO los tipos de servicio que van a garantias contra los anteriores
		if(in_array(7, $tipo_servicio) OR in_array(4, $tipo_servicio) OR in_array(8, $tipo_servicio) )
		{
			
			//busco tsi anteriores con mas kilometros
			if($this->registro_actual)
			{
				$registro_id=$this->registro_actual->id;
			}else{
				$registro_id = FALSE;
			}
			
			$q = Doctrine_Query::create()
				->select('Tsi.id')
				->addSelect('Tsi.tsi_field_kilometros')
				->addSelect('Tsi.tsi_field_fecha_de_egreso')
				->from('Tsi Tsi')
				->leftJoin('Tsi.Unidad Unidad')
				->where('Tsi.tsi_estado_id = ?',2) //activo
				->addWhere('Unidad.unidad_field_vin = ?',$this->input->post('unidad_field_vin'))
				->addWhere('Tsi.id != ?',$registro_id)
				->addWhere('Tsi.tsi_field_fecha_de_egreso <= ?',$this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_de_egreso')))
				->addWhere('Tsi.tsi_field_kilometros > ?',$kilometros)
				;
				
			
			if($q->count()>0)
			{
				$this->form_validation->set_message('valid_kilometros', sprintf($this->lang->line('error_kilometraje_previo'), $this->lang->line('kilometros')));
				RETURN FALSE;
			}
		}
		
		
		RETURN TRUE;
	}
	
	function valid_promocion( $tsi_promocion_id = FALSE )
	{
		$tsi_promocion_id = (int)$tsi_promocion_id;
		if($tsi_promocion_id > 0)
		{
			//busco la promocion
			$q = Doctrine_Query::create()
			->from('Tsi_Promocion Tsi_Promocion')
			->where('Tsi_Promocion.id = ?',$tsi_promocion_id);
			
			if($q->count()!=1)
			{
				$this->form_validation->set_message('valid_promocion', $this->lang->line('form_seleccione'));
				RETURN FALSE;
			}
			
			$promo = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
			$fecha_inicio = date_create( $promo['tsi_promocion_field_fecha_inicio'] );
			$fecha_fin = date_create( $promo['tsi_promocion_field_fecha_fin'] );
			$fecha_ingreso = date_create( $this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_de_ingreso')) );
			
			if($fecha_ingreso<$fecha_inicio OR $fecha_ingreso>$fecha_fin)
			{
				$this->form_validation->set_message('valid_promocion', $this->lang->line('promocion_fuera_rango'));
				RETURN FALSE;
			}
			
			RETURN TRUE;
			
			
			
			
			
		}
		else
		{
			//de paso la blanqueo
			$_POST['tsi_promocion_id'] = NULL;
			RETURN TRUE;
		}
		
	}
	
	function valid_kilometros_rotura($kilometros_rotura)
	{
		
		if($kilometros_rotura>$this->input->post('tsi_field_kilometros'))
		{
			
			$this->form_validation->set_message('valid_kilometros_rotura', sprintf($this->lang->line('error_kilometraje_mayor_kilometraje_rotura'), $this->lang->line('kilometros'), $this->lang->line('kilometros_rotura')));
			RETURN FALSE;
		}
		
		
		if($this->registro_actual)
		{
			$registro_id=$this->registro_actual->id;
		}else{
			$registro_id = FALSE;
		}
		
		$tipo_servicio = $this->input->post('many_tsi_tipo_servicio');
		if(!is_array($tipo_servicio))
		{
			$tipo_servicio = array();
		}
		//se validan SOLO los tipos de servicio que van a garantias contra los anteriores
		if(array_search(7, $tipo_servicio) OR array_search(4, $tipo_servicio) OR array_search(8, $tipo_servicio) )
		{
			//busco tsi anteriores con mas kilometros de rotura...
			
			
			$q = Doctrine_Query::create()
				->select('Tsi.id')
				->addSelect('Tsi.tsi_field_kilometros_rotura')
				->addSelect('Tsi.tsi_field_fecha_rotura')
				->from('Tsi Tsi')
				->leftJoin('Tsi.Unidad Unidad')
				->where('Tsi.tsi_estado_id = ?',2) //activo
				->addWhere('Unidad.unidad_field_vin = ?',$this->input->post('unidad_field_vin'))
				->addWhere('Tsi.id != ?',$registro_id)
				->addWhere('Tsi.tsi_field_fecha_rotura <= ?',$this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_rotura')))
				->addWhere('Tsi.tsi_field_kilometros_rotura > ?',$kilometros_rotura)
				;
				
			
			if($q->count()>0)
			{
				
				//'El kilometraje de rotura no puede ser menor al registrado previamente'
				$this->form_validation->set_message('valid_kilometros_rotura', sprintf($this->lang->line('error_kilometraje_rotura_previo'), $this->lang->line('kilometros_rotura')));
				RETURN FALSE;
			}
		}
		
		//En el caso de que se realicen 2 reclamos de garantía para un mismo vehículo con una misma fecha de rotura el Kilometraje de Rotura NO puede ser diferente. 
		
		$q = Doctrine_Query::create()
			->select('Tsi.id')
			->from('Tsi Tsi')
			->leftJoin('Tsi.Unidad Unidad')
			->where('Tsi.tsi_estado_id = ?',2) //activo
			->addWhere('Unidad.unidad_field_vin = ?',$this->input->post('unidad_field_vin'))
			->addWhere('Tsi.id != ?',$registro_id)
			->addWhere('Tsi.tsi_field_fecha_rotura = ?',$this->form_validation->my_form_date_reverse($this->input->post('tsi_field_fecha_rotura')))
			->addWhere('Tsi.tsi_field_kilometros != ?',$this->input->post('tsi_field_kilometros_rotura'))
			;
		if($q->count()!=0)
		{
			//$this->form_validation->set_message('valid_fecha_rotura', sprintf($this->lang->line('fecha_rotura_mayor_fecha_entrega_unidad'), $this->lang->line('fecha_rotura'), $this->marvin->mysql_field_to_human('unidad_field_fecha_entrega')));
			$this->form_validation->set_message('valid_kilometros_rotura', sprintf($this->lang->line('kilometros_rotura_distintos_anterior_tsi'), $this->lang->line('kilometros'), $this->lang->line('fecha_rotura')));
			RETURN FALSE;
		}
		
		
		
		
		RETURN TRUE;
	}
	
	
	function valid_tsi_tipo_servicio()
	{
		//si no es una unidad desconocida
		//si no es accesorios o pdi tiene que tener una tarjeta de garantia
		if(strpos($this->input->post('unidad_field_unidad'), 'DD') !== FALSE)
		{
			RETURN TRUE;
		}
		
		
		$tipo_servicio = $this->input->post('many_tsi_tipo_servicio');
		if(!is_array($tipo_servicio))
		{
			$tipo_servicio = array();
		}
		
		//saco el pdi si existe
		$r = array_search(4, $tipo_servicio);
		if($r!==FALSE)
		{
			unset($tipo_servicio[$r]);
		}
		//saco accesorios si existe
		$r = array_search(5, $tipo_servicio);
		if($r!==FALSE)
		{
			unset($tipo_servicio[$r]);
		}
		
		if(count($tipo_servicio)>0)
		{
			$q = Doctrine_Query::create()
			->select('Tarjeta_Garantia.id')
			->from('Tarjeta_Garantia Tarjeta_Garantia')
			->leftJoin('Tarjeta_Garantia.Unidad Unidad')
			->where('Unidad.unidad_field_vin = ?',$this->input->post('unidad_field_vin'))
			->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id = ?',2);
			;
			if($q->count()!=1)
			{
				$this->form_validation->set_message('valid_tsi_tipo_servicio', $this->lang->line('no_existe_tarjeta_garantia'));
				RETURN FALSE;
			}
			else
			{
				RETURN TRUE;
			}
		}
		else
		{
			RETURN TRUE;
		}
		
	}
	
	
	
}       
