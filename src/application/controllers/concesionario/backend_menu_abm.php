<?php
define('ID_SECCION',1051);
class Backend_Menu_abm extends Backend_Controller{
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
				$this->registro_actual = new Backend_Menu();
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

			$this->registro_actual->unlink('Backend_Menu_M_Grupo');

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

			$actuales=array();
			foreach($registro->Backend_Menu_M_Grupo as $relacion) {
				$actuales[]=$relacion->id . "\n";
			}
			$this->form_validation->set_defaults(array('backend_menu_m_grupo[]'=>$actuales));

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
			$this->registro_actual->backend_menu_field_desc = $this->input->post('backend_menu_field_desc');
			$this->registro_actual->backend_menu_field_url = $this->input->post('backend_menu_field_url');
			$this->registro_actual->root_id = $this->input->post('root_id');
			$this->registro_actual->lft = $this->input->post('lft');
			$this->registro_actual->rgt = $this->input->post('rgt');
			$this->registro_actual->level = $this->input->post('level');

			$this->registro_actual->save();

			$this->registro_actual->unlink('Backend_Menu_M_Grupo');
			$this->registro_actual->save();
			if($this->registro_actual!=FALSE && is_array($this->input->post('backend_menu_m_grupo')))
			{
					foreach($this->input->post('backend_menu_m_grupo') as $grupo_id) {
						$relacion=new Backend_Menu_M_Grupo();
						$relacion->grupo_id = (int)$grupo_id;
						$relacion->backend_menu_id = $this->registro_actual->id;
						$relacion->save();
					}
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

		//------------ [select / checkbox / radio root_id] :(
		$root=new Root();
		$q = $root->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('root_field_desc');
		$config['select'] = TRUE;
		$this->template['root_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio root_id]

		//------------ [checkbox Backend_Menu_M_Grupo]
		$grupo=new Grupo();
		$q = $grupo->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('grupo_field_desc');
		$config['select'] = FALSE;
		$this->template['backend_menu_m_grupo']=$this->_create_html_options($q, $config);
		//------------ [fin checkbox Backend_Menu_M_Grupo]
	
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

		$this->form_validation->set_rules('backend_menu_field_desc',$this->marvin->mysql_field_to_human('backend_menu_field_desc'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('backend_menu_field_url',$this->marvin->mysql_field_to_human('backend_menu_field_url'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('root_id',$this->marvin->mysql_field_to_human('root_id'),
				'trim' );

		$this->form_validation->set_rules('lft',$this->marvin->mysql_field_to_human('lft'),
				'trim' );

		$this->form_validation->set_rules('rgt',$this->marvin->mysql_field_to_human('rgt'),
				'trim' );

		$this->form_validation->set_rules('level',$this->marvin->mysql_field_to_human('level'),
				'trim' );


		$this->form_validation->set_rules('backend_menu_m_grupo[]',$this->marvin->mysql_field_to_human('grupo_id'),
			'trim' );

		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------	
}       
