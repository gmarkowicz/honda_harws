<?php
define('ID_SECCION',5031);
class Trafico_Pilot_Legend_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	//filtra por sucursal?
	var $sucursal = TRUE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;
	
	//subfix de archivos adjuntos 
	var $upload_adjunto = array();
	
	//subfix de imagenes adjuntas 
	var $upload_image = array();

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
				$this->registro_actual = new Trafico_Pilot_Legend();
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
	private function _mostrar_registro_actual()
	{
		//paranoid (por las dudas vio)
		$_POST = array();
		if($this->registro_actual)
		{
			$registro_array = $this->registro_actual->toArray();
			$this->form_validation->set_defaults($registro_array);

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
		try
		{
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			
			if($this->router->method == 'add' )
			{
				$this->registro_actual->trafico_pilot_legend_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->trafico_pilot_legend_field_fechahora_alta = date('Y-m-d H:i:s', time());
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->trafico_pilot_legend_field_admin_modifica_id = $this->session->userdata('admin_id');
				$this->registro_actual->trafico_pilot_legend_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
			}
			
			$this->registro_actual->trafico_pilot_legend_field_fecha = $this->input->post('trafico_pilot_legend_field_fecha');
			$this->registro_actual->trafico_pilot_legend_field_vendedor_nombre = $this->input->post('trafico_pilot_legend_field_vendedor_nombre');
			$this->registro_actual->trafico_pilot_legend_field_nombre = $this->input->post('trafico_pilot_legend_field_nombre');
			$this->registro_actual->trafico_pilot_legend_field_apellido = $this->input->post('trafico_pilot_legend_field_apellido');
			$this->registro_actual->trafico_pilot_legend_field_razon_social = $this->input->post('trafico_pilot_legend_field_razon_social');
			$this->registro_actual->trafico_pilot_legend_field_telefono_contacto_codigo = $this->input->post('trafico_pilot_legend_field_telefono_contacto_codigo');
			$this->registro_actual->trafico_pilot_legend_field_telefono_contacto_numero = $this->input->post('trafico_pilot_legend_field_telefono_contacto_numero');
			$this->registro_actual->trafico_pilot_legend_field_email = $this->input->post('trafico_pilot_legend_field_email');
			$this->registro_actual->auto_modelo_interes_id = $this->input->post('auto_modelo_interes_id');
			$this->registro_actual->auto_modelo_actual_id = $this->input->post('auto_modelo_actual_id');
			$this->registro_actual->sucursal_id = $this->input->post('sucursal_id');
			$this->registro_actual->backend_estado_id = $this->input->post('backend_estado_id');
		

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
		
		$this->backend->upload_adjuntos();
		$this->backend->upload_images();
		
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

		//------------ [select / checkbox / radio auto_modelo_interes_id] :(
		$auto_modelo_interes=new Auto_Modelo();
		$q = $auto_modelo_interes->get_all();
		$q->whereIn('id',array(520,525));
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_modelo_interes_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_modelo_interes_id]

		//------------ [select / checkbox / radio auto_modelo_actual_id] :(
		$auto_modelo_actual=new Auto_Modelo();
		$q = $auto_modelo_actual->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_marca_field_desc','auto_modelo_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_modelo_actual_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_modelo_actual_id]

		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = TRUE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]

		//------------ [select / checkbox / radio backend_estado_id] :(
		$backend_estado=new Backend_Estado();
		$q = $backend_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('backend_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['backend_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio backend_estado_id]

		
	
		$this->_view_adjunto(); //muestro archivos adjuntos (si los hay); //definida $this->$upload_adjunto = array();
		$this->_view_image(); //muestro imagenes (si las hay); //definida $this->$upload_image = array();
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
		}else{
			$id = FALSE;
		}
				
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));

		$this->form_validation->set_rules('trafico_pilot_legend_field_fecha',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_fecha'),
				'trim|my_form_date_reverse|required|my_valid_date[y-m-d,-]' );

		$this->form_validation->set_rules('trafico_pilot_legend_field_vendedor_nombre',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_vendedor_nombre'),
				'trim|max_length[255]' );
		if(strlen($this->input->post('trafico_pilot_legend_field_razon_social'))>1)
		{
				$this->form_validation->set_rules('trafico_pilot_legend_field_razon_social',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_razon_social'),
				'trim|max_length[255]|required' );
				
		}else{

			$this->form_validation->set_rules('trafico_pilot_legend_field_nombre',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_nombre'),
					'trim|max_length[255]|required' );

			$this->form_validation->set_rules('trafico_pilot_legend_field_apellido',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_apellido'),
					'trim|max_length[255]|required' );
		}

		$this->form_validation->set_rules('trafico_pilot_legend_field_telefono_contacto_codigo',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_telefono_contacto_codigo|required'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('trafico_pilot_legend_field_telefono_contacto_numero',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_telefono_contacto_numero|required'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('trafico_pilot_legend_field_email',$this->marvin->mysql_field_to_human('trafico_pilot_legend_field_email'),
				'trim|max_length[255]|required|valid_email' );

		$this->form_validation->set_rules('auto_modelo_interes_id',$this->marvin->mysql_field_to_human('auto_modelo_interes_id'),
				'trim|required|my_db_value_exist[Auto_Modelo.id]' );

		$this->form_validation->set_rules('auto_modelo_actual_id',$this->marvin->mysql_field_to_human('auto_modelo_actual_id'),
				'trim' );

		$this->form_validation->set_rules('sucursal_id',$this->marvin->mysql_field_to_human('sucursal_id'),
				'trim|required||my_db_value_exist[Sucursal.id]|my_valid_sucursal' );

		$this->form_validation->set_rules('backend_estado_id',$this->marvin->mysql_field_to_human('backend_estado_id'),
				'trim|required||my_db_value_exist[Backend_Estado.id]');



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
	
	
	public function del_adjunto( $id_registro = FALSE, $id_adjunto= FALSE, $subfix = 'adjunto' ) 
	{	
		$rs		= $this->backend->del_adjunto($id_registro, $id_adjunto, $subfix);
	}			
		//-------------------------[comunes imagenes y adjuntos]
	
	
}       
