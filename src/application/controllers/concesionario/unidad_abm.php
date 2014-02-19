<?php
define('ID_SECCION',1021);
class Unidad_abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	
	//filtra por sucursal?
	var $sucursal = FALSE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;

	function __construct()
	{
		parent::Backend_Controller();
		ini_set('max_execution_time',10360);
		ini_set('memory_limit', '-1');
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
				$this->registro_actual = new Unidad();
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
		else
		{
			//busco ultima unidad desconocida agregada...
			$statement = Doctrine_Manager::getInstance()->connection();
			
			$sql = "SELECT  max(unidad_field_unidad) as max, unidad_field_unidad FROM unidad 
        		WHERE unidad_field_unidad LIKE '%DD'";
			$unidad = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($sql);
			if(count($unidad) == 1)
			{
				$unidad = substr($unidad[0]['max'],0,-2);
				$this->form_validation->set_defaults(array('unidad_field_unidad'=>++$unidad.'DD'));	
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

			$this->registro_actual->unlink('Many_Unidad_Codigo_Interno');

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
				$this->form_validation->set_defaults($this->registro_actual->toArray());

				$actuales=array();
				foreach($this->registro_actual->Many_Unidad_Codigo_Interno as $relacion) {
					$actuales[]=$relacion->id;
				}
				$this->form_validation->set_defaults(array('many_unidad_codigo_interno[]'=>$actuales));	
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
			foreach($registro->Many_Unidad_Codigo_Interno as $relacion) {
				$actuales[]=$relacion->id . "\n";
			}
			$this->form_validation->set_defaults(array('many_unidad_codigo_interno[]'=>$actuales));

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
		
			$this->registro_actual->unidad_field_unidad = $this->input->post('unidad_field_unidad');
			$this->registro_actual->unidad_field_vin = $this->input->post('unidad_field_vin');
			$this->registro_actual->unidad_field_motor = $this->input->post('unidad_field_motor');
			$this->registro_actual->unidad_field_codigo_de_llave = $this->input->post('unidad_field_codigo_de_llave');
			$this->registro_actual->unidad_field_codigo_de_radio = $this->input->post('unidad_field_codigo_de_radio');
			$this->registro_actual->unidad_field_patente = $this->input->post('unidad_field_patente');
			$this->registro_actual->unidad_field_oblea = $this->input->post('unidad_field_oblea');
			
			$this->registro_actual->unidad_field_certificado = $this->input->post('unidad_field_certificado');
			$this->registro_actual->unidad_field_formulario_12 = $this->input->post('unidad_field_formulario_12');
			$this->registro_actual->unidad_field_formulario_01 = $this->input->post('unidad_field_formulario_01');
			
			$this->registro_actual->unidad_color_exterior_id = $this->input->post('unidad_color_exterior_id');
			$this->registro_actual->unidad_color_interior_id = $this->input->post('unidad_color_interior_id');
			$this->registro_actual->vin_procedencia_ktype_id = $this->input->post('vin_procedencia_ktype_id');
			$this->registro_actual->auto_fabrica_id = $this->input->post('auto_fabrica_id');
			$this->registro_actual->auto_version_id = $this->input->post('auto_version_id');
			$this->registro_actual->auto_puerta_cantidad_id = $this->input->post('auto_puerta_cantidad_id');
			$this->registro_actual->auto_transmision_id = $this->input->post('auto_transmision_id');
			$this->registro_actual->auto_anio_id = $this->input->post('auto_anio_id');
			$this->registro_actual->unidad_estado_garantia_id = $this->input->post('unidad_estado_garantia_id');
			$this->registro_actual->unidad_estado_id = $this->input->post('unidad_estado_id');
			$this->registro_actual->unidad_field_fixed = 1;
			if($this->input->post('unidad_estado_garantia_id') == 3)
			{
				$this->registro_actual->unidad_field_motivo_garantia_anulada = $this->input->post('unidad_field_motivo_garantia_anulada');
				$this->registro_actual->unidad_field_fecha_garantia_anulada = $this->input->post('unidad_field_fecha_garantia_anulada');
			}
			else if($this->input->post('unidad_estado_garantia_id') == 5) //pbservada
			{
				$this->registro_actual->unidad_field_motivo_garantia_anulada = $this->input->post('unidad_field_motivo_garantia_anulada');
				$this->registro_actual->unidad_field_fecha_garantia_anulada = FALSE;
			}
			else
			{
				$this->registro_actual->unidad_field_motivo_garantia_anulada = FALSE;
				$this->registro_actual->unidad_field_fecha_garantia_anulada = FALSE;
			}

			$this->registro_actual->save();
			
			if($this->session->userdata('show_unidad_codigo_interno') == TRUE)
			{
				$this->registro_actual->unlink('Many_Unidad_Codigo_Interno');
				$this->registro_actual->save();
				if($this->registro_actual!=FALSE && is_array($this->input->post('many_unidad_codigo_interno')))
				{
						foreach($this->input->post('many_unidad_codigo_interno') as $unidad_codigo_interno_id) {
							$relacion=new Unidad_M_Unidad_Codigo_Interno();
							$relacion->unidad_codigo_interno_id = (int)$unidad_codigo_interno_id;
							$relacion->unidad_id = $this->registro_actual->id;
							$relacion->save();
						}
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
		
		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal(FALSE);
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = TRUE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_color_exterior_id]
		
		//------------ [select / checkbox / radio sucursal_id] :(
		$unidad_estado_garantia=new Unidad_Estado_Garantia();
		$q = $unidad_estado_garantia->get_all();
		$config=array();
		$config['fields'] = array('unidad_estado_garantia_field_desc');
		$config['select'] = TRUE;
		$this->template['unidad_estado_garantia_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_color_exterior_id]
		
			//------------ [select / checkbox / radio sucursal_id] :(
		$unidad_estado=new Unidad_Estado();
		$q = $unidad_estado->get_all();
		$config=array();
		$config['fields'] = array('unidad_estado_field_desc');
		$config['select'] = TRUE;
		$this->template['unidad_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_color_exterior_id]
		
		//------------ [select / checkbox / radio unidad_color_exterior_id] :(
		$unidad_color_exterior=new Unidad_Color_Exterior(FALSE);
		$q = $unidad_color_exterior->get_all();
		$q->groupBy('id');
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('id','unidad_color_exterior_field_desc');
		$config['select'] = TRUE;
		$this->template['unidad_color_exterior_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_color_exterior_id]

		//------------ [select / checkbox / radio unidad_color_interior_id] :(
		$unidad_color_interior=new Unidad_Color_Interior();
		$q = $unidad_color_interior->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('unidad_color_interior_field_desc');
		$config['select'] = TRUE;
		$this->template['unidad_color_interior_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio unidad_color_interior_id]

		//------------ [select / checkbox / radio vin_procedencia_id] :(
		$vin_procedencia_ktype=new Vin_Procedencia_Ktype();
		$q = $vin_procedencia_ktype->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('vin_procedencia_ktype_field_desc');
		$config['select'] = TRUE;
		$this->template['vin_procedencia_ktype_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio vin_procedencia_id]

		//------------ [select / checkbox / radio auto_fabrica_id] :(
		$auto_fabrica=new Auto_Fabrica();
		$q = $auto_fabrica->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_fabrica_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_fabrica_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_fabrica_id]
		
		//------------ [select / checkbox / radio auto_version_id] :(
		$auto_version=new Auto_Version();
		$q = $auto_version->get_all();
		$q->addWhere('auto_marca_id = ?',100);
		$q->orderBy('auto_modelo_field_desc');
		$q->addOrderBy('auto_version_field_desc');
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc','auto_version_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_version_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_version_id]

		//------------ [select / checkbox / radio auto_puerta_cantidad_id] :(
		$auto_puerta_cantidad=new Auto_Puerta_Cantidad();
		$q = $auto_puerta_cantidad->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_puerta_cantidad_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_puerta_cantidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_puerta_cantidad_id]

		//------------ [select / checkbox / radio auto_transmision_id] :(
		$auto_transmision=new Auto_Transmision();
		$q = $auto_transmision->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_transmision_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_transmision_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_transmision_id]

		//------------ [select / checkbox / radio auto_anio_id] :(
		$auto_anio=new Auto_Anio();
		$q = $auto_anio->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_anio_field_desc');
		$config['select'] = TRUE;
		$this->template['auto_anio_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_anio_id]

		//------------ [checkbox Many_Unidad_Codigo_Interno]
		$unidad_codigo_interno=new Unidad_Codigo_Interno();
		$q = $unidad_codigo_interno->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('unidad_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['many_unidad_codigo_interno']=$this->_create_html_options($q, $config);
		//------------ [fin checkbox Many_Unidad_Codigo_Interno]
		
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

		//revisar unique!!
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
				'trim|max_length[20]|required|my_unique_db[Unidad.unidad_field_unidad '.$id.']' );

		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
				'trim|exact_length[17]|required|my_unique_db[Unidad.unidad_field_vin '.$id.']' );

		$this->form_validation->set_rules('unidad_field_motor',$this->marvin->mysql_field_to_human('unidad_field_motor'),
				'trim|max_length[30]|required|my_unique_db[Unidad.unidad_field_motor '.$id.']' );

		$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
				'trim|max_length[30]' );

		$this->form_validation->set_rules('unidad_field_codigo_de_radio',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_radio'),
				'trim|max_length[30]' );
		
		$this->form_validation->set_rules('unidad_field_patente',$this->marvin->mysql_field_to_human('unidad_field_patente'),
				'trim|max_length[7]|required|my_unique_db[Unidad.unidad_field_patente '.$id.']' );
		
		$this->form_validation->set_rules('unidad_field_oblea',$this->marvin->mysql_field_to_human('unidad_field_oblea'),
				'trim|max_length[50]' );
		
		$this->form_validation->set_rules('unidad_field_certificado',$this->marvin->mysql_field_to_human('unidad_field_certificado'),
				'trim|max_length[50]' );
		
		$this->form_validation->set_rules('unidad_field_formulario_12',$this->marvin->mysql_field_to_human('unidad_field_formulario_12'),
				'trim|max_length[50]' );
			
		$this->form_validation->set_rules('unidad_field_formulario_01',$this->marvin->mysql_field_to_human('unidad_field_formulario_01'),
				'trim|max_length[50]' );

		$this->form_validation->set_rules('unidad_color_exterior_id',$this->marvin->mysql_field_to_human('unidad_color_exterior_id'),
				'trim|max_length[30]|required|my_db_value_exist[Unidad_Color_Exterior.id]' );

		$this->form_validation->set_rules('unidad_color_interior_id',$this->marvin->mysql_field_to_human('unidad_color_interior_id'),
				'trim|max_length[30]|required|my_db_value_exist[Unidad_Color_Interior.id]' );

		$this->form_validation->set_rules('vin_procedencia_ktype_id',$this->marvin->mysql_field_to_human('vin_procedencia_ktype_id'),
				'trim|max_length[3]|required|my_db_value_exist[Vin_Procedencia_Ktype.id]' );

		$this->form_validation->set_rules('auto_fabrica_id',$this->marvin->mysql_field_to_human('auto_fabrica_id'),
				'trim|required|my_db_value_exist[Auto_Fabrica.id]' );
		
		$this->form_validation->set_rules('unidad_estado_garantia_id',$this->marvin->mysql_field_to_human('unidad_estado_garantia_id'),
			'trim|required|my_db_value_exist[Unidad_Estado_Garantia.id]' );
		
		$this->form_validation->set_rules('unidad_estado_id',$this->marvin->mysql_field_to_human('unidad_estado_id'),
			'trim|required|my_db_value_exist[Unidad_Estado.id]' );
		


		
		if($this->input->post('unidad_estado_garantia_id') == 3)
		{
		$this->form_validation->set_rules('unidad_field_motivo_garantia_anulada',$this->marvin->mysql_field_to_human('unidad_field_motivo_garantia_anulada'),
			'trim|required|min_length[10]' );
		
		$this->form_validation->set_rules('unidad_field_fecha_garantia_anulada',$this->marvin->mysql_field_to_human('unidad_field_fecha_garantia_anulada'),
			'trim|required|my_form_date_reverse|my_valid_date[y-m-d,-,1]' );
		
		
		
		}else{
			$this->form_validation->set_rules('unidad_field_motivo_garantia_anulada',$this->marvin->mysql_field_to_human('unidad_field_motivo_garantia_anulada'),
			'trim' );
		}
		
		//tira todo junto
		$this->form_validation->set_rules('auto_version_id',$this->marvin->mysql_field_to_human('auto_modelo_id'),
				'trim|required|my_db_value_exist[Auto_Version.id]' );

		$this->form_validation->set_rules('auto_puerta_cantidad_id',$this->marvin->mysql_field_to_human('auto_puerta_cantidad_id'),
				'trim|required|my_db_value_exist[Auto_Puerta_Cantidad.id]' );

		$this->form_validation->set_rules('auto_transmision_id',$this->marvin->mysql_field_to_human('auto_transmision_id'),
				'trim|required|my_db_value_exist[Auto_Transmision.id]' );

		$this->form_validation->set_rules('auto_anio_id',$this->marvin->mysql_field_to_human('auto_anio_id'),
				'trim|required|my_db_value_exist[Auto_Anio.id]' );

		$this->form_validation->set_rules('unidad_field_fixed',$this->marvin->mysql_field_to_human('unidad_field_fixed'),
				'trim' );


		$this->form_validation->set_rules('many_unidad_codigo_interno[]',$this->marvin->mysql_field_to_human('unidad_codigo_interno_id'),
			'trim' );

		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------	
}       
