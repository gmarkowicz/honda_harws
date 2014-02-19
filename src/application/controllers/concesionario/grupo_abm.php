<?php
define('ID_SECCION',1012);
class Grupo_abm extends Backend_Controller{
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
				$this->registro_actual = new Grupo();
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

			$this->registro_actual->unlink('Many_Admin');

			$this->registro_actual->unlink('Many_Backend_Menu');

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
				//
				//no mando info, muestro la del registro por default
				$this->form_validation->set_defaults($this->registro_actual->toArray());

				$actuales=array();
				$add=array();
				$del=array();
				$admin=array();
				$edit=array();
				
				foreach($this->registro_actual->Many_Backend_Menu as $be_menu) {
					
					$actuales[]=$be_menu->id;
					
					if($be_menu->Grupo_M_Backend_Menu[0]->p_add=='1'){
						$add[]=$be_menu->id;
					}
					if($be_menu->Grupo_M_Backend_Menu[0]->p_del=='1'){
						$del[]=$be_menu->id;
					}
					if($be_menu->Grupo_M_Backend_Menu[0]->p_admin=='1'){
						$admin[]=$be_menu->id;
					}
					if($be_menu->Grupo_M_Backend_Menu[0]->p_edit=='1'){
						$edit[]=$be_menu->id;
					}
				}
				$this->form_validation->set_defaults(array('grupo_m_backend_menu[]'=>$actuales));
				$this->form_validation->set_defaults(array('add[]'=>$add));
				$this->form_validation->set_defaults(array('del[]'=>$del));
				$this->form_validation->set_defaults(array('admin[]'=>$admin));
				$this->form_validation->set_defaults(array('edit[]'=>$edit));
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
			$add=array();
			$del=array();
			$admin=array();
			$edit=array();
			
			foreach($registro->Many_Backend_Menu as $be_menu) {
				
       			$actuales[]=$be_menu->id;
				
				if($be_menu->Grupo_M_Backend_Menu[0]->p_add=='1'){
					$add[]=$be_menu->id;
				}
				if($be_menu->Grupo_M_Backend_Menu[0]->p_del=='1'){
					$del[]=$be_menu->id;
				}
				if($be_menu->Grupo_M_Backend_Menu[0]->p_admin=='1'){
					$admin[]=$be_menu->id;
				}
				if($be_menu->Grupo_M_Backend_Menu[0]->p_edit=='1'){
					$edit[]=$be_menu->id;
				}
   			}
			$this->form_validation->set_defaults(array('grupo_m_backend_menu[]'=>$actuales));
			$this->form_validation->set_defaults(array('add[]'=>$add));
			$this->form_validation->set_defaults(array('del[]'=>$del));
			$this->form_validation->set_defaults(array('admin[]'=>$admin));
			$this->form_validation->set_defaults(array('edit[]'=>$edit));

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
			$this->registro_actual->grupo_field_desc = $this->input->post('grupo_field_desc');

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
		
		$this->ingresar_menu();
		
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
		
		if($this->registro_actual)
		{
			$this->template['many_admin']  = $this->registro_actual->Many_Admin->toArray();
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

		$this->form_validation->set_rules('grupo_field_desc',$this->marvin->mysql_field_to_human('grupo_field_desc'),
				'trim|required|max_length[255]|my_unique_db[Grupo.grupo_field_desc '.$id.']' );
		
		$this->form_validation->set_rules('grupo_m_backend_menu[]','Menu',
			'trim|is_natural_no_zero'
		);
		$this->form_validation->set_rules('add[]','Menu',
			'trim|is_natural_no_zero'
		);
		$this->form_validation->set_rules('delete[]','Menu',
			'trim|is_natural_no_zero'
		);
		$this->form_validation->set_rules('edit[]','Menu',
			'trim|is_natural_no_zero'
		);
		$this->form_validation->set_rules('admin[]','Menu',
			'trim|is_natural_no_zero'
		);

		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------	
	
	
	//-------------------------------------------------------------------------------
	private function ingresar_menu()
	{
		$this->registro_actual->unlink('Many_Backend_Menu');
		$this->registro_actual->save();
		
		//$q = Doctrine_Query::create()->delete('Grupo_M_Be_Menu')->Where('grupo_id = ?', $this->registro_actual->id);
		//$q->execute();
		
		#ingreso grupos para el usuario
		if($this->registro_actual!=FALSE && is_array($this->input->post('grupo_m_backend_menu')))
			{	
				foreach($this->input->post('grupo_m_backend_menu') as $be_menu_id) {
					$be_menu_id=(int)$be_menu_id;
					$add=0;
					$del=0;
					$edit=0;
					$admin=0;
					if (is_array($this->input->post('add')) && in_array($be_menu_id,$this->input->post('add'))) {
						$add=1;
					}
					if (is_array($this->input->post('del')) && in_array($be_menu_id,$this->input->post('del'))) {
						$del=1;
					}
					if (is_array($this->input->post('edit')) && in_array($be_menu_id,$this->input->post('edit'))) {
						$edit=1;
					}
					if (is_array($this->input->post('admin')) && in_array($be_menu_id,$this->input->post('admin'))) {
						$admin=1;
					}
					
					$menu_grupo=new Grupo_M_Backend_Menu();
					$menu_grupo->backend_menu_id = $be_menu_id;
					$menu_grupo->grupo_id = $this->registro_actual->id;
					$menu_grupo->p_add = $add;
					$menu_grupo->p_edit = $edit;
					$menu_grupo->p_admin = $admin;
					$menu_grupo->p_del = $del;
					$menu_grupo->save();
					
				}
			}
	}
	//-------------------------------------------------------------------------------
	
}       
