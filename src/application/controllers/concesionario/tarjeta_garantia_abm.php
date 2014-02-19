<?php
define('ID_SECCION',3012);
/*
	TODO
	maxima cantidad d edias entre fecha de venta de unidad y fecha de entrega
	cambiar el estado de la unidad al rechazar una tarjeta
*/

class Tarjeta_Garantia_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	
	//TODO !
	//maxima diferencia de dias entre fecha de de venta de unidad y fecha de entrega
	var $maxima_diferencia_dias = 15;
	
	//filtra por sucursal?
	var $sucursal = TRUE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = TRUE;
		

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
				$this->registro_actual = new Tarjeta_Garantia();
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
					$this->session->set_flashdata('reject_ok', true);
					$this->output->set_output("TRUE");
				}
			}
			
		}
	}
	//----------------------------------------------------------------
	//-------------------------[rechaza registro actual]
	
	//----------------------------------------------------------------
	//-------------------------[aprueba registro esperando aprobacion]
	public function approve()
	{
		$this->_set_record($this->input->post('id'));
		
		if($this->_approve_record())
		{
			if($this->input->post('ajax'))
			{
				//le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
				$this->session->set_flashdata('approve_ok', true);
				$this->output->set_output("TRUE");
			}
		}
			
	}
	
	//----------------------------------------------------------------
	//-------------------------[aprueba registro esperando aprobacion]
	
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
			$this->registro_actual->unlink('Many_Cliente');
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
			$many_cliente=array();
			$registro=$this->registro_actual;
			
			
			$encuesta_nos = $this->registro_actual->Encuesta_Nos->toArray();
			if(!empty($encuesta_nos))
			{
					$this->template['rechaza_nos'] = TRUE;
			}
			
			
			
			$registro_array=$registro->toArray();
			
			//$_POST['sucursal_id']=$registro_array['sucursal_id'];
			
			$this->form_validation->set_defaults($registro_array);
			$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_codigo_de_radio'=>element('unidad_field_codigo_de_radio',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_codigo_de_llave'=>element('unidad_field_codigo_de_llave',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_patente'=>element('unidad_field_patente',$registro_array)));
			foreach($registro->Many_Cliente as $este_cliente)
			{
				$cliente = $este_cliente->toArray();
				//dios
				$data=array();
				$data['id']													=uniqid();
				$data['documento_tipo_id']									=element('documento_tipo_id',$cliente);
				$data['cliente_conformidad_id']								=element('cliente_conformidad_id',$cliente);
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
				
			}
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
			$many_cliente=array();
			$registro=$this->registro_actual;
			
			$registro_array=$registro->toArray();
			
			//$_POST['sucursal_id']=$registro_array['sucursal_id'];
			
			$this->form_validation->set_defaults($registro_array);
			$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_codigo_de_radio'=>element('unidad_field_codigo_de_radio',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_codigo_de_llave'=>element('unidad_field_codigo_de_llave',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_patente'=>element('unidad_field_patente',$registro_array)));
			foreach($registro->Many_Cliente as $este_cliente)
			{
				$cliente = $este_cliente->toArray();
				//dios
				$data=array();
				$data['id']													=uniqid();
				$data['documento_tipo_id']									=element('documento_tipo_id',$cliente);
				$data['cliente_conformidad_id']								=element('cliente_conformidad_id',$cliente);
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
				
			}
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
				$error['error']		= 'no encuentro unidad';
				$this->backend->_log_error($error);
				show_error($error['error']);
			}
			
			// actualizo datos de la unidad
			$flag_unidad = FALSE;
			if(strlen($this->input->post('unidad_field_codigo_de_llave'))>0)
			{
				$flag_unidad = TRUE;
				$unidad->unidad_field_codigo_de_llave = $this->input->post('unidad_field_codigo_de_llave');
			}
			if(strlen($this->input->post('unidad_field_codigo_de_radio'))>0)
			{
				$flag_unidad = TRUE;
				$unidad->unidad_field_codigo_de_radio = $this->input->post('unidad_field_codigo_de_radio');
			}
			if(strlen($this->input->post('unidad_field_patente'))>0)
			{
				$flag_unidad = TRUE;
				$unidad->unidad_field_patente = $this->input->post('unidad_field_patente');
			}
			if($flag_unidad)
			{
				$unidad->save();
			}
			// actualizo datos de la unidad
			
			if($this->router->method == 'add' )
			{
				$this->registro_actual->unidad_id = $unidad->id;
				$this->registro_actual->tarjeta_garantia_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->tarjeta_garantia_field_fechahora_alta = date('Y-m-d H:i:s', time());
				
				
				//si existe un registro previo lo pongo como esperando aprobacion
				$tarjeta_garantia = new Tarjeta_Garantia();
				$q=$tarjeta_garantia->get_all();
				$q->addWhere('unidad_id = ?',$unidad->id);
				$q->addWhere('tarjeta_garantia_estado_id = ?',2); //estado activo
				$tarjeta = $q->fetchOne();
				if(!$tarjeta)
				{
					
					$this->registro_actual->tarjeta_garantia_estado_id = 2; //activa
					//actualizo fecha de entrega de la unidad
					$unidad->unidad_field_fecha_entrega = $this->input->post('tarjeta_garantia_field_fecha_entrega');
					//pongo unidad con garantia
					$unidad->unidad_estado_garantia_id = 1;
					$unidad->save();
					
					if($this->backend->_permiso('add',3051))
					{
						//para que cargue directamente la encuesta NOS....
						$this->session->set_flashdata('encuesta_nos', array('unidad'=>$unidad->unidad_field_unidad, 'vin'=>$unidad->unidad_field_vin));
					}
					
				}
				else
				{
					$this->registro_actual->tarjeta_garantia_estado_id = 3; //esperando aprobacion
				}
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->tarjeta_garantia_field_admin_modifica_id = $this->session->userdata('admin_id');
				$this->registro_actual->tarjeta_garantia_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
			}
			
			
			
			
			$this->registro_actual->tarjeta_garantia_field_admin_vende_id = $this->input->post('tarjeta_garantia_field_admin_vende_id');
			$this->registro_actual->tarjeta_garantia_field_fecha_entrega = $this->input->post('tarjeta_garantia_field_fecha_entrega');
			
			$this->registro_actual->sucursal_id = $this->input->post('sucursal_id');
			
			
			

			$this->registro_actual->save();
			$this->registro_actual->unlink('Many_Cliente');
			$this->registro_actual->save();
			//ingreso los clientes...
			$many_cliente = new Cliente_Sucursal();
			$config=array();
			
			$id_clientes = $many_cliente->ingresar_clientes($_POST,$this->input->post('sucursal_id'),$config);
			if(!is_array($id_clientes) || count($id_clientes)<1)
			{
				
				$conn->rollback();
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= 'no se ingresaron clientes';
				$this->backend->_log_error($error);
				show_error($error['error']);
			}			
			foreach($id_clientes as $key=>$cliente_id) {
				$relacion=new Tarjeta_Garantia_M_Cliente();
				$relacion->tarjeta_garantia_id = $this->registro_actual->id;
				$relacion->cliente_id = $cliente_id;
				$relacion->save();
			}

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

		

		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn('id', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = TRUE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]


		//------------ [select / checkbox / radio tarjeta_garantia_estado_id] :(
		$tarjeta_garantia_estado=new Tarjeta_Garantia_Estado();
		$q = $tarjeta_garantia_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tarjeta_garantia_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['tarjeta_garantia_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tarjeta_garantia_estado_id]
		
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
		
		
		
		/*
		//------------ [select / checkbox / radio ciudad_id] :(
		$ciudad=new Ciudad();
		$q = $ciudad->get_all();
		$q->Where('id = ?', 0);
		$config=array();
		$config['fields'] = array('ciudad_field_desc');
		$config['select'] = TRUE;
		$this->template['options_ciudad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio ciudad_id]
		*/
		//------------ [select / checkbox / radio admin_vende_id] :(
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
		$vendedor=new Admin();
		$q = $vendedor->get_vendedores();
		$q->Where('sucursal_id = ?', $sucursal);
		$config=array();
		$config['fields'] = array('admin_field_nombre','admin_field_apellido');
		$config['select'] = TRUE;
		$this->template['tarjeta_garantia_field_admin_vende_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio admin_vende_id]
		
		//------------ [select / checkbox / radio documento_tipo_id] :(
		$documento_tipo=new Documento_Tipo();
		$q = $documento_tipo->get_all();
		$config=array();
		$config['fields'] = array('documento_tipo_field_desc');
		$config['select'] = TRUE;
		$this->template['options_documento_tipo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio ciudad_id]
		
		//------------ [select / checkbox / radio documento_tipo_id] :(
		$cliente_conformidad=new Cliente_Conformidad();
		$q = $cliente_conformidad->get_all();
		$config=array();
		$config['fields'] = array('cliente_conformidad_field_desc');
		$config['select'] = TRUE;
		$this->template['options_cliente_conformidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio ciudad_id]
	
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
		
		$this->form_validation->set_rules('tarjeta_garantia_field_admin_vende_id',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_admin_vende_id'),
				'trim' );
		
		$this->form_validation->set_rules('tarjeta_garantia_field_vendedor_nombre_aux',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_vendedor_nombre_aux'),
					'trim' );
		$this->form_validation->set_rules('tarjeta_garantia_field_fecha_entrega',$this->marvin->mysql_field_to_human('tarjeta_garantia_field_fecha_entrega'),
				'trim|my_form_date_reverse|required|my_valid_date[y-m-d,-,1]' );

		//TODO validar sucursal valida
		$this->form_validation->set_rules('sucursal_id',$this->marvin->mysql_field_to_human('sucursal_id'),
				'trim|required|is_natural_no_zero|my_valid_sucursal' );

		$this->form_validation->set_rules('tarjeta_garantia_estado_id',$this->marvin->mysql_field_to_human('tarjeta_garantia_estado_id'),
				'trim' );
		
		if(strlen($this->input->post('unidad_field_codigo_de_radio'))>0)
		{
			$this->form_validation->set_rules('unidad_field_codigo_de_radio',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_radio'),
				'trim|my_valid_codigo_de_radio' );
		}
				
		if(strlen($this->input->post('unidad_field_codigo_de_llave'))>0)
		{
			$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
				'trim|my_valid_codigo_de_llave' );
		}else{
			$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
				'trim' );
		}
		
		if(strlen($this->input->post('unidad_field_patente'))>0)
		{
			$this->form_validation->set_rules('unidad_field_patente',$this->marvin->mysql_field_to_human('unidad_field_patente'),
				'strtoupper|trim|my_valid_patente' );
		}else{
				$this->form_validation->set_rules('unidad_field_patente',$this->marvin->mysql_field_to_human('unidad_field_patente'),
				'trim' );
		}
		
		
		//Limitación de carga de fecha de alta (relacionada con fecha facturación)
		//TODO no esta enviando la fecha al form....
		$tablaUnidad = Doctrine_Core::getTable('Unidad');
		$unidad = $tablaUnidad->findOneByUnidad_field_unidad( $this->input->post('unidad_field_unidad') );
		if(!$unidad)
		{
			//show_error('no encuentro unidad ' . $this->input->post('unidad_field_unidad') );
		}
		else
		{
			
			
			if(strlen($unidad->unidad_field_fecha_venta)>1)
			{
				$fecha_retail = new DateTime($unidad->unidad_field_fecha_venta);
				$fecha_entrega = new DateTime($this->form_validation->my_form_date_reverse($this->input->post('tarjeta_garantia_field_fecha_entrega')));
				if($fecha_retail>$fecha_entrega)
				{
					
					$_POST['tarjeta_garantia_field_fecha_entrega'] = $this->form_validation->my_form_date_reverse($this->input->post('tarjeta_garantia_field_fecha_entrega'));
					
					$this->form_validation->set_rules('tarjeta_garantia_field_fecha_entrega',
														$this->marvin->mysql_field_to_human('tarjeta_garantia_field_fecha_entrega'),
													  'my_force_error' );		
					
					
				}
				
			}
			
			if(strlen($unidad->unidad_field_fecha_facturacion)>1)
			{
				$fecha_facturacion = new DateTime($unidad->unidad_field_fecha_facturacion);
				$fecha_entrega = new DateTime($this->form_validation->my_form_date_reverse($this->input->post('tarjeta_garantia_field_fecha_entrega')));
				
				
				if($fecha_facturacion>$fecha_entrega)
				{
					$_POST['tarjeta_garantia_field_fecha_entrega'] = $this->form_validation->my_form_date_reverse($this->input->post('tarjeta_garantia_field_fecha_entrega'));
					
					$this->form_validation->set_rules('tarjeta_garantia_field_fecha_entrega',
														$this->marvin->mysql_field_to_human('tarjeta_garantia_field_fecha_entrega'),
													  'my_force_error' );													  
				}
			}
			
		
		}
		////Limitación de carga de fecha de alta (relacionada con fecha facturación)
		
		
		
		//$error = FALSE;
		
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
					
				$_POST[$key]['cliente_conformidad_id']								=
					@$_POST['cliente']['cliente_conformidad_id'][$key];
					
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
				$this->form_validation->set_rules($key.'[cliente_conformidad_id]',$this->marvin->mysql_field_to_human('cliente_conformidad_id'),
					'trim|required|is_natural_no_zero' );
				
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
				if(strlen($_POST[$key]['cliente_sucursal_field_razon_social'])>0 && 
					(strlen($_POST[$key]['cliente_sucursal_field_nombre'])>0 || strlen($_POST[$key]['cliente_sucursal_field_apellido'])>0)
					){
					
					
					
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
					'trim|required|my_valid_date[y-m-d,-]' );
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
		
		if(!$this->registro_actual || $this->registro_actual->tarjeta_garantia_estado_id==9 || !$this->backend->_permiso('admin'))
		{
			return FALSE;
		}
		
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			//
				if($this->registro_actual->tarjeta_garantia_estado_id==2) //la tarjeta esta activa?
				{
					
					
					$tg = new Tarjeta_Garantia();
					$q = $tg->get_all();
					$q->addWhere('unidad_id = ? ',$this->registro_actual->unidad_id);
					$q->addWhere('tarjeta_garantia_estado_id = ? ',1); //inactiva
					$q->orderBy('tarjeta_garantia_field_fecha_entrega DESC');
					$q->limit(1); //inactiva
					$tajeta_inactiva = $q->fetchOne();
					if($tajeta_inactiva)
					{
						
						//paso la tarjeta a inactiva a activa
						$tajeta_inactiva->tarjeta_garantia_estado_id=2;
						$tajeta_inactiva->save();
					}
					else
					{
						//no tiene tarjeta de garantia, paso la unidad a estado desconocido
						$tablaUnidad = Doctrine_Core::getTable('Unidad');
						$unidad = $tablaUnidad->findOneById( $this->registro_actual->unidad_id );
						if(!$unidad)
						{
							show_error('no encuentro unidad ' . $this->registro_actual->unidad_id );
						}
						
						$unidad->unidad_estado_garantia_id = 4;
						$unidad->unidad_field_fecha_entrega = NULL;
						$unidad->save();
					}
					
					
				}
			
				
				
				$this->registro_actual->tarjeta_garantia_field_rechazo_motivo	= $this->input->post('rechazo_motivo');
				$this->registro_actual->tarjeta_garantia_field_admin_rechaza_id	= $this->session->userdata('admin_id');
				$this->registro_actual->tarjeta_garantia_estado_id				= 9;
				$this->registro_actual->save();
				
				/* rechazo tambien encuesta nos*/
				$encuesta_nos = $this->registro_actual->Encuesta_Nos->toArray();
				if(!empty($encuesta_nos))
				{
					$encuesta = new Encuesta_Nos();
					$q = $encuesta->get_all();
					$q->addWhere('tarjeta_garantia_id = ?',$this->registro_actual->id);
					$q->addWhere('encuesta_nos_estado_id = ?',2);
					$resultado = $q->fetchOne();
					if($resultado)
					{
						$resultado->encuesta_nos_estado_id = 9;
						$resultado->save();
					}
				}
			
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
	
	
	private function _approve_record()
	{
		if(!$this->registro_actual || $this->registro_actual->tarjeta_garantia_estado_id!=3 || !$this->backend->_permiso('admin'))
		{
			return FALSE;
		}
		
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			//
				
				//busco la tarjeta activa anterior para pasarna a inactiva
				$tg = new Tarjeta_Garantia();
				$q = $tg->get_all();
				$q->addWhere('unidad_id = ? ',$this->registro_actual->unidad_id);
				$q->addWhere('tarjeta_garantia_estado_id = ? ',2); //activa
				$q->orderBy('tarjeta_garantia_field_fecha_entrega DESC');
				$q->limit(1); 
				
				$tajeta_activa = $q->fetchOne();
				
				if($tajeta_activa)
				{
					
					//paso la tarjeta de activa a inactiva
					$tajeta_activa->tarjeta_garantia_estado_id=1;
					$tajeta_activa->save();
				}
				
				$this->registro_actual->tarjeta_garantia_field_admin_aprueba_cambio_titular_id	= $this->session->userdata('admin_id');
				$this->registro_actual->tarjeta_garantia_estado_id				= 2; //activa
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
	
	
	
	
	
}       
