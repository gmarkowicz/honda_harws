<?php
class Login extends CI_Controller{
		
	function __construct()
	{
        parent::__construct();
		$this->config->load('backend');
		$this->load->view('backend/login_view',false);
	}
	
	
	public function index()
	{
		if($this->input->post('_backend_login'))
		{
			$this->_login();
		}
	}
	
	public function logoff()
	{
		
		$this->session->sess_destroy();
		redirect(
			$this->config->item('base_url').
			$this->config->item('backend_root') .
			'login'
		);
		
	}
	
	private function _login()
	{
		$this->session->unset_userdata();
		$admin=new Admin();
		$q=$admin->get_all();
		
		//$q->addWhere('admin_estado_id > ?' ,1); //id estado 1 inactivo por default
		$q->addWhere('admin_field_usuario = ?' ,$this->input->post('admin_field_usuario'));
		$q->addWhere('admin_field_password = ?' ,md5($this->input->post('admin_field_password')));
		$admin = $q->fetchOne();
		
		if(!$admin){
			$this->session->set_flashdata('login_error', true);
			$this->session->set_flashdata('admin_field_usuario', $this->input->post('admin_field_usuario'));
			redirect(current_url());
		}else{
			if($admin->admin_estado_id =='1'){
					$this->session->set_flashdata('usuario_deshabilitado', true);
					$this->session->set_flashdata('admin_field_usuario', $this->input->post('admin_field_usuario'));
					redirect(current_url());
			
			}else{
				
				
				
				//go go go
				$this->session->set_userdata('backend_login', TRUE);
				$this->session->set_userdata('admin_id', $admin->id);
				$this->session->set_userdata('admin_field_usuario', $admin->admin_field_usuario);
				$this->session->set_userdata('admin_field_nombre', $admin->admin_field_nombre);
				$this->session->set_userdata('admin_field_apellido', $admin->admin_field_apellido);
				$this->session->set_userdata('admin_field_email', @$admin->admin_field_email);
				$this->session->set_userdata('sucursal_id', @$admin->Sucursal->id);				
				$this->session->set_userdata('sucursal_field_desc', @$admin->Sucursal->sucursal_field_desc);
				$this->session->set_userdata('empresa_field_desc', @$admin->Sucursal->Empresa->empresa_field_desc);
				$this->session->set_userdata('admin_field_fechahora_ultimo_login', $this->marvin->mysql_datetime_to_human(@$admin->admin_field_fechahora_ultimo_login));
				//super admin
					if($admin->admin_field_super_admin=='1'){
						$this->session->set_userdata('admin_field_super_admin', TRUE);
					}else{
						$this->session->set_userdata('admin_field_super_admin', FALSE);
					}
				//super admin
				
				//actualizo ultimo login
				date_default_timezone_set('America/Argentina/Buenos_Aires'); //TODO sacar de acA!
				$admin->admin_field_fechahora_ultimo_login = date('Y-m-d H:i:s', time());
				$admin->save();
				
				//-----------------------------------------------------------------------
				//tsi TIH
				$this->session->set_userdata('show_tsi_tih', FALSE);
				if($this->session->userdata('sucursal_id') == 1000)
				{
					$this->session->set_userdata('show_tsi_tih', TRUE);
				}
				//-----------------------------------------------------------------------
				
				//------------------------------------------------------------------------
				//grupos a los que pertenece...
				if($this->session->userdata('admin_field_super_admin')===TRUE){
					//es super admin, le doy privilegios sobre todas las secciones....
					$permisos_menu=new Backend_Menu();
					$q=$permisos_menu->get_all();
					$resultado = $q->execute();
					foreach ($resultado as $row){
						//le doy permisos sobre todo el sistema
						$permisos[$row->id] = array(
							'view'=>1,
							'add'=>1,
							'edit'=>1,
							'del'=>1,
							'admin'=>1,
						);
					}
				
				}else{
					//NO es super admin, tomo los grupos
					$grupo_id=array();
					foreach($admin->Many_Grupo as $grupo){
						$grupo_id[]=$grupo->id;
					}
					//permisos sobre las secciones
					$permisos_menu=new Grupo_M_Backend_Menu();
					$q=$permisos_menu->get_all();
					$q->whereIn('grupo_id', $grupo_id);
					//$q->groupBy('backend_menu_id');
					$resultado = $q->execute();
					$permisos=array();
					foreach ($resultado as $row){
						
						
						
						//sumo permisos por si tiene varios grupos
						$permisos[$row->backend_menu_id]['view']=1;
						
						if($row->p_add==1){
							$permisos[$row->backend_menu_id]['add']=1;
						}
						if($row->p_edit==1){
							$permisos[$row->backend_menu_id]['edit']=1;
						}
						if($row->p_del==1){
							$permisos[$row->backend_menu_id]['del']=1;
						}
						if($row->p_admin==1){
							$permisos[$row->backend_menu_id]['admin']=1;
						}
						
						/*
						$permisos[$row->backend_menu_id] = array(
							'view'=>1,
							'add'=>$row->p_add,
							'edit'=>$row->p_edit,
							'del'=>$row->p_del,
							'admin'=>$row->p_admin,
						);
						*/
					}
					//paso permisos a 0 de los que no tuvo por suma
					reset($permisos);
					while(list($key,) = each($permisos))
					{
						if(!isset($permisos[$key]['add']))
						{
							$permisos[$key]['add']=FALSE;
						}
						if(!isset($permisos[$key]['edit']))
						{
							$permisos[$key]['edit']=FALSE;
						}
						if(!isset($permisos[$key]['del']))
						{
							$permisos[$key]['del']=FALSE;
						}
						if(!isset($permisos[$key]['admin']))
						{
							$permisos[$key]['admin']=FALSE;
						}
					}
					
					
				}
				$this->session->set_userdata('permisos', $permisos);
				//grupos a los que pertenece...
				//------------------------------------------------------------------------
				
				//permisos especiales para codigos internos... 
				//a 3 dias de pasar a produccion "No Santiago. En la semana te paso el requerimiento para cambiarlo porque eso no es lo que Valeria pidió. "
				$this->session->set_userdata('show_unidad_codigo_interno', FALSE);
				$this->session->set_userdata('show_cliente_codigo_interno', FALSE);
				
				if($this->session->userdata('sucursal_id') == 1000)
				{
					$this->session->set_userdata('show_unidad_codigo_interno', TRUE);
					$this->session->set_userdata('show_cliente_codigo_interno', TRUE);
				}
				
				//preparado para asignarlo a grupos (que esperen)
				/*
				if($this->session->userdata('admin_field_super_admin') === TRUE OR (isset($permisos[1]) AND $permisos[1]== TRUE ) )
				{
					$this->session->set_userdata('show_unidad_codigo_interno', TRUE);
				}
				if($this->session->userdata('admin_field_super_admin') === TRUE OR (isset($permisos[2]) AND $permisos[2]== TRUE ) )
				{
					$this->session->set_userdata('show_cliente_codigo_interno', TRUE);
				}
				*/
				
				
				
				//------------------------------------------------------------------------
				//sucursales con los que puede operar
				if($this->session->userdata('admin_field_super_admin')===TRUE){
					$admin_sucursales=array();
					$sucursales = new Sucursal();
					$q= $sucursales->get_all();
					$resultado = $q->execute();
					foreach($resultado as $row){
						$admin_sucursales[]=$row->id;
					}
					
				}else{
					$admin_sucursales=array('0');
					foreach($admin->Many_Sucursal as $sucursal){
						$admin_sucursales[]=$sucursal->id;
					}
				}
				$this->session->set_userdata('sucursales', $admin_sucursales);
				//sucursales con los que puede operar
				//------------------------------------------------------------------------
				
				
				redirect(
					$this->config->item('base_url').
					$this->config->item('backend_root') .
					'index'
				);
			}
		}
	}
	
	
	
	
}       
        
