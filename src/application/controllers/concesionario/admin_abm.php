<?php
define('ID_SECCION',1011);
class Admin_abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;


	//filtra por sucursal?
	var $sucursal = FALSE;

	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;

	 //especial para aca
	var $actualizar_password = FALSE;

	function __construct()
	{
		parent::Backend_Controller();
	}

	//----------------------------------------------------------------
	//-------------------------[crea un registro a partir de post ]
	public function add()
	{
		//actualizamos la pass
		$this->actualizar_password	=	TRUE;

		if($this->input->post('_submit'))
		{
			if ($this->_validar_formulario() == TRUE)
			{
				//piso _this_registro_actual
				$this->registro_actual = new Admin();
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

			$this->registro_actual->unlink('Many_Sucursal');

			$this->registro_actual->unlink('Many_Grupo');

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
				$this->form_validation->set_defaults($this->registro_actual->toArray());

				$actuales=array();
				foreach($this->registro_actual->Many_Sucursal as $relacion) {
					$actuales[]=$relacion->id;
				}
				$this->form_validation->set_defaults(array('many_sucursal[]'=>$actuales));

				$actuales=array();
				foreach($this->registro_actual->Many_Grupo as $relacion) {
					$actuales[]=$relacion->id;
				}
				$this->form_validation->set_defaults(array('many_grupo[]'=>$actuales));

				$actuales=array();
				foreach($this->registro_actual->Many_Admin_Departamento as $relacion) {
					$actuales[]=$relacion->id;
				}
				$this->form_validation->set_defaults(array('many_admin_departamento[]'=>$actuales));

				$actuales=array();
				foreach($this->registro_actual->Many_Admin_Puesto as $relacion) {
					$actuales[]=$relacion->id;
				}
				$this->form_validation->set_defaults(array('many_admin_puesto[]'=>$actuales));
				//
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

			if($this->input->post('admin_field_password') != FALSE && strlen($this->input->post('admin_field_password'))>0){
				$this->actualizar_password = TRUE;
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
			$registro=$this->registro_actual;
			$this->form_validation->set_defaults($registro->toArray());

			$actuales=array();
			foreach($registro->Many_Sucursal as $relacion) {
				$actuales[]=$relacion->id . "\n";
			}
			$this->form_validation->set_defaults(array('many_sucursal[]'=>$actuales));

			$actuales=array();
			foreach($registro->Many_Grupo as $relacion) {
				$actuales[]=$relacion->id . "\n";
			}
			$this->form_validation->set_defaults(array('many_grupo[]'=>$actuales));

			$actuales=array();
			foreach($registro->Many_Admin_Departamento as $relacion) {
				$actuales[]=$relacion->id . "\n";
			}
			$this->form_validation->set_defaults(array('many_admin_departamento[]'=>$actuales));

			$actuales=array();
			foreach($registro->Many_Admin_Puesto as $relacion) {
				$actuales[]=$relacion->id . "\n";
			}
			$this->form_validation->set_defaults(array('many_admin_puesto[]'=>$actuales));

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
		/*try
		{*/
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
			$this->registro_actual->admin_field_usuario = $this->input->post('admin_field_usuario');
			if($this->actualizar_password){
				$this->registro_actual->admin_field_password = md5($this->input->post('admin_field_password'));
			}
			$this->registro_actual->admin_field_nombre = $this->input->post('admin_field_nombre');
			$this->registro_actual->admin_field_apellido = $this->input->post('admin_field_apellido');
			$this->registro_actual->admin_field_email = $this->input->post('admin_field_email');
			$this->registro_actual->admin_field_telefono_celular = $this->input->post('admin_field_telefono_celular');
			$this->registro_actual->admin_field_dni = $this->input->post('admin_field_dni');
			$this->registro_actual->admin_field_fecha_ingreso = ($this->input->post('admin_field_fecha_ingreso') ? $this->input->post('admin_field_fecha_ingreso') : '0000-00-00');
			$this->registro_actual->admin_field_fecha_egreso = ($this->input->post('admin_field_fecha_egreso') ? $this->input->post('admin_field_fecha_egreso') : '0000-00-00');
			$this->registro_actual->admin_field_fecha_nacimiento = ($this->input->post('admin_field_fecha_nacimiento') ? $this->input->post('admin_field_fecha_nacimiento') : '0000-00-00');
			$this->registro_actual->sucursal_id = $this->input->post('sucursal_id');
			$this->registro_actual->admin_estado_id = $this->input->post('admin_estado_id');
			$this->registro_actual->admin_field_direccion = $this->input->post('admin_field_direccion');
			$this->registro_actual->provincia_id = $this->input->post('provincia_id');
			$this->registro_actual->ciudad_id = $this->input->post('ciudad_id');
			$this->registro_actual->admin_field_estudios = $this->input->post('admin_field_estudios');
			$this->registro_actual->admin_field_idioma = $this->input->post('admin_field_idioma');
			
			
			
			
			
			
			if ($this->registro_actual->token == '')
			{
				$this->registro_actual->token = uniqid();
			}


			$this->registro_actual->save();

			$this->registro_actual->unlink('Many_Sucursal');
			$this->registro_actual->save();
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_sucursal')))
			{
					foreach($this->input->post('many_sucursal') as $sucursal_id) {
						$relacion=new Admin_M_Sucursal();
						$relacion->sucursal_id = (int)$sucursal_id;
						$relacion->admin_id = $this->registro_actual->id;
						$relacion->save();
					}
			}

			$this->registro_actual->unlink('Many_Grupo');
			$this->registro_actual->save();
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_grupo')))
			{
					foreach($this->input->post('many_grupo') as $grupo_id) {
						$relacion=new Admin_M_Grupo();
						$relacion->grupo_id = (int)$grupo_id;
						$relacion->admin_id = $this->registro_actual->id;
						$relacion->save();
					}
			}

			$this->registro_actual->unlink('Many_Admin_Puesto');
			$this->registro_actual->save();
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_admin_puesto')))
			{
					foreach($this->input->post('many_admin_puesto') as $puesto_id) {
						$relacion=new Admin_M_Admin_Puesto();
						$relacion->admin_puesto_id = (int)$puesto_id;
						$relacion->admin_id = $this->registro_actual->id;
						$relacion->save();
					}
			}
			$this->registro_actual->unlink('Many_Admin_Departamento');
			$this->registro_actual->save();
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_admin_departamento')))
			{
					foreach($this->input->post('many_admin_departamento') as $departamento_id) {
						$relacion=new Admin_M_Admin_Departamento();
						$relacion->admin_departamento_id = (int)$departamento_id;
						$relacion->admin_id = $this->registro_actual->id;
						$relacion->save();
					}
			}

			$conn->commit();
		/*}
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
		}*/
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

		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = TRUE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]
		
		//------------ [select / checkbox / radio provincia_id] :(
		$provincia=new Provincia();
		$q = $provincia->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('provincia_field_desc');
		$config['select'] = TRUE;
		$this->template['provincia_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]
		
		$provincia_id = FALSE;
		if($this->input->post('provincia_id'))
		{
			$provincia_id = $this->input->post('provincia_id');
		}
		else if($this->registro_actual)
		{
			$provincia_id = $this->registro_actual->provincia_id;
		}
		if($provincia_id)
		{
			//------------ [select / checkbox / radio provincia_id] :(
			$ciudad=new Ciudad();
			$q = $ciudad->get_all();
			$q->addWhere('provincia_id = ?',$provincia_id);
			//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
			$config=array();
			$config['fields'] = array('ciudad_field_desc');
			$config['select'] = TRUE;
			$this->template['ciudad_id']=$this->_create_html_options($q, $config);
			//------------ [fin select / checkbox / radio sucursal_id]
		}
		
		
		//------------ [select / checkbox / radio admin_estado_id] :(
		$admin_estado=new Admin_Estado();
		$q = $admin_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('admin_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['admin_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio admin_estado_id]

		//------------ [checkbox Many_sucursal]
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['many_sucursal']=$this->_create_html_options($q, $config);
		//------------ [fin checkbox Many_sucursal]

		//------------ [checkbox Many_Grupo]
		$grupo=new Grupo();
		$q = $grupo->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('grupo_field_desc');
		$config['select'] = FALSE;
		$this->template['many_grupo']=$this->_create_html_options($q, $config);
		//------------ [fin checkbox Many_Grupo]

		//------------ [checkbox Many_Admin_Departamento]
		$admin_departamento=new Admin_Departamento();
		$q = $admin_departamento->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('admin_departamento_field_desc');
		$config['select'] = FALSE;
		$this->template['many_admin_departamento']=$this->_create_html_options($q, $config);
		//------------ [fin checkbox Many_Admin_Departamento]

		//------------ [checkbox Many_Admin_Puesto]
		$admin_puesto=new Admin_Puesto();
		$q = $admin_puesto->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('admin_puesto_field_desc');
		$config['select'] = FALSE;
		$this->template['many_admin_puesto']=$this->_create_html_options($q, $config);
		//------------ [fin checkbox Many_Admin_Puesto]
		
		

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

		$this->form_validation->set_rules('admin_field_usuario',$this->marvin->mysql_field_to_human('admin_field_usuario'),
				'trim|max_length[255]|required' );

		#paja
		if($this->actualizar_password OR strlen($this->input->post('admin_field_password'))>1)
		{
			$this->actualizar_password = TRUE;
			$this->form_validation->set_rules('admin_field_password',$this->marvin->mysql_field_to_human('admin_field_password'),
				'trim|required|min_length[6]|max_length[100]'
			);
			$this->form_validation->set_rules('admin_field_password_repite',$this->marvin->mysql_field_to_human('admin_field_password_repite'),
				'trim|required|matches[admin_field_password]'
			);
		}
		$this->form_validation->set_rules('admin_field_nombre',$this->marvin->mysql_field_to_human('admin_field_nombre'),
				'trim|max_length[255]|required' );

		$this->form_validation->set_rules('admin_field_apellido',$this->marvin->mysql_field_to_human('admin_field_apellido'),
				'trim|max_length[255]|required' );

		$this->form_validation->set_rules('admin_field_email',$this->marvin->mysql_field_to_human('admin_field_email'),
				'trim|max_length[255]|valid_email|required' );

		$this->form_validation->set_rules('admin_field_telefono_celular',$this->marvin->mysql_field_to_human('admin_field_telefono_celular'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('admin_field_dni',$this->marvin->mysql_field_to_human('admin_field_dni'),
				'trim|max_length[32]' );

		$this->form_validation->set_rules('admin_field_fecha_ingreso',$this->marvin->mysql_field_to_human('admin_field_fecha_ingreso'),
				'trim|my_form_date_reverse' );
		$this->form_validation->set_rules('admin_field_fecha_egreso',$this->marvin->mysql_field_to_human('admin_field_fecha_egreso'),
				'trim|my_form_date_reverse' );
		$this->form_validation->set_rules('admin_field_fecha_nacimiento',$this->marvin->mysql_field_to_human('admin_field_fecha_nacimiento'),
				'trim|my_form_date_reverse' );

		$this->form_validation->set_rules('sucursal_id',$this->marvin->mysql_field_to_human('sucursal_id'),
				'trim|required|is_natural_no_zero' );

		$this->form_validation->set_rules('admin_estado_id',$this->marvin->mysql_field_to_human('admin_estado_id'),
				'trim' );
		
		$this->form_validation->set_rules('provincia_id',$this->marvin->mysql_field_to_human('provincia_id'),
				'trim' );
		$this->form_validation->set_rules('ciudad_id',$this->marvin->mysql_field_to_human('ciudad_id'),
				'trim' );
		$this->form_validation->set_rules('admin_field_direccion',$this->marvin->mysql_field_to_human('admin_field_direccion'),
				'trim' );
		$this->form_validation->set_rules('admin_field_idioma',$this->marvin->mysql_field_to_human('admin_field_idioma'),
				'trim' );
		$this->form_validation->set_rules('admin_field_estudios',$this->marvin->mysql_field_to_human('admin_field_estudios'),
				'trim' );
		
		$this->form_validation->set_rules('many_sucursal[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim' );

		$this->form_validation->set_rules('many_grupo[]',$this->marvin->mysql_field_to_human('grupo_id'),
			'trim' );
			
		$this->form_validation->set_rules('many_admin_departamento[]',$this->marvin->mysql_field_to_human('admin_departamento_id'),
			'trim' );
		
		$this->form_validation->set_rules('many_admin_puesto[]',$this->marvin->mysql_field_to_human('admin_puesto_id'),
			'trim' );

		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------
}
