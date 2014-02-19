<?php
define('ID_SECCION',3051);
class Encuesta_Nos_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;
	
	//filtra por sucursal?
	var $sucursal = FALSE;
	
	//se puede rechazar el registro?
	var $rechazar_registro = TRUE;
	
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
	public function add( $unidad = FALSE, $vin = FALSE )
	{
		if($this->input->post('_submit'))
		{		
			if ($this->_validar_formulario() == TRUE)
			{
				//piso _this_registro_actual
				$this->registro_actual = new Encuesta_Nos();
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
			//por ahi viene desde la tarjeta de garantia....
			$this->form_validation->set_defaults(array('unidad_field_unidad'=>$unidad, 'unidad_field_vin'=>$vin));
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

			$this->registro_actual->unlink('Many_Encuesta_Nos_Opinion_Interes');
			


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
	
	
	private function _mostrar_registro_actual()
	{
			//paranoid (por las dudas vio)
			$_POST = array();
			if($this->registro_actual)
			{
				$registro_array = $this->registro_actual->toArray();
				$this->form_validation->set_defaults($registro_array);
				$actuales=array();
				foreach($this->registro_actual->Many_Encuesta_Nos_Opinion_Interes as $relacion) {
					$actuales[]=$relacion->id;
				}
				$this->form_validation->set_defaults(array('many_encuesta_nos_opinion_interes[]'=>$actuales));
				$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
				$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
				
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
			$registro_array = $this->registro_actual->toArray();
			$this->form_validation->set_defaults($registro->toArray());

			$actuales=array();
			foreach($registro->Many_Encuesta_Nos_Opinion_Interes as $relacion) {
				$actuales[]=$relacion->id;
			}
			$this->form_validation->set_defaults(array('many_encuesta_nos_opinion_interes[]'=>$actuales));
			$this->form_validation->set_defaults(array('unidad_field_unidad'=>element('unidad_field_unidad',$registro_array)));
			$this->form_validation->set_defaults(array('unidad_field_vin'=>element('unidad_field_vin',$registro_array)));
			
			
		}
		$registro_array = $this->registro_actual->toArray();
		$this->form_validation->set_defaults(array('cliente'=>$registro_array['Cliente']));
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
			
			//tomo propietario original
			$tg=new Tarjeta_Garantia();
			$q = $tg->get_propietario_original($this->input->post('unidad_field_vin'), $this->input->post('unidad_field_unidad') );
			$tarjeta_garantia = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
			if(!$tarjeta_garantia)
			{
				$error['line'] 		= __LINE__;
				$error['file'] 		= __FILE__;
				$error['error']		= 'no existe tarjeta de garantia';
				$this->backend->_log_error($error);
				show_error($error['error']);
			}
			
			if($this->router->method == 'add' )
			{
				$this->registro_actual->encuesta_nos_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->encuesta_nos_field_fechahora_alta = date('Y-m-d H:i:s', time());
				$this->registro_actual->tarjeta_garantia_id = $tarjeta_garantia['id'];
				$this->registro_actual->cliente_id = $this->input->post('cliente_id');
				$this->registro_actual->encuesta_nos_estado_id = 2; //activa
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->encuesta_nos_field_admin_modifica_id = $this->session->userdata('admin_id');
				$this->registro_actual->encuesta_nos_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
			}
			
			
			
			
			//
			//
			$this->registro_actual->sexo_id = $this->input->post('sexo_id');
			$this->registro_actual->encuesta_nos_edad_id = $this->input->post('encuesta_nos_edad_id');
			$this->registro_actual->encuesta_nos_grupo_familiar_id = $this->input->post('encuesta_nos_grupo_familiar_id');
			$this->registro_actual->encuesta_nos_ocupacion_id = $this->input->post('encuesta_nos_ocupacion_id');
			$this->registro_actual->encuesta_nos_financiacion_id = $this->input->post('encuesta_nos_financiacion_id');
			$this->registro_actual->encuesta_nos_tipo_automovil_id = $this->input->post('encuesta_nos_tipo_automovil_id');
			$this->registro_actual->encuesta_nos_conductor_id = $this->input->post('encuesta_nos_conductor_id');
			$this->registro_actual->encuesta_nos_field_uso_negocios = $this->input->post('encuesta_nos_field_uso_negocios');
			$this->registro_actual->encuesta_nos_field_uso_transporte_trabajo = $this->input->post('encuesta_nos_field_uso_transporte_trabajo');
			$this->registro_actual->encuesta_nos_field_uso_transporte_escuela = $this->input->post('encuesta_nos_field_uso_transporte_escuela');
			$this->registro_actual->encuesta_nos_field_uso_general = $this->input->post('encuesta_nos_field_uso_general');
			$this->registro_actual->encuesta_nos_field_uso_placer = $this->input->post('encuesta_nos_field_uso_placer');
			$this->registro_actual->encuesta_nos_field_opinion_investigacion = $this->input->post('encuesta_nos_field_opinion_investigacion');
			$this->registro_actual->encuesta_nos_field_opinion_originalidad = $this->input->post('encuesta_nos_field_opinion_originalidad');
			$this->registro_actual->encuesta_nos_field_opinion_carreras = $this->input->post('encuesta_nos_field_opinion_carreras');
			$this->registro_actual->encuesta_nos_field_opinion_seguridad = $this->input->post('encuesta_nos_field_opinion_seguridad');
			$this->registro_actual->encuesta_nos_field_opinion_medio_ambiente = $this->input->post('encuesta_nos_field_opinion_medio_ambiente');
			$this->registro_actual->encuesta_nos_field_opinion_eficiencia = $this->input->post('encuesta_nos_field_opinion_eficiencia');
			$this->registro_actual->encuesta_nos_field_opinion_interes_otros = $this->input->post('encuesta_nos_field_opinion_interes_otros');
			$this->registro_actual->encuesta_nos_field_influencia_estilo = $this->input->post('encuesta_nos_field_influencia_estilo');
			$this->registro_actual->encuesta_nos_field_influencia_tamanio = $this->input->post('encuesta_nos_field_influencia_tamanio');
			$this->registro_actual->encuesta_nos_field_influencia_potencia = $this->input->post('encuesta_nos_field_influencia_potencia');
			$this->registro_actual->encuesta_nos_field_influencia_respuesta = $this->input->post('encuesta_nos_field_influencia_respuesta');
			$this->registro_actual->encuesta_nos_field_influencia_maniobrabilidad = $this->input->post('encuesta_nos_field_influencia_maniobrabilidad');
			$this->registro_actual->encuesta_nos_field_influencia_economia = $this->input->post('encuesta_nos_field_influencia_economia');
			$this->registro_actual->encuesta_nos_field_influencia_precio = $this->input->post('encuesta_nos_field_influencia_precio');
			$this->registro_actual->encuesta_nos_field_influencia_financiacion = $this->input->post('encuesta_nos_field_influencia_financiacion');
			$this->registro_actual->encuesta_nos_field_influencia_garantia = $this->input->post('encuesta_nos_field_influencia_garantia');
			$this->registro_actual->encuesta_nos_field_influencia_modelo = $this->input->post('encuesta_nos_field_influencia_modelo');
			$this->registro_actual->encuesta_nos_field_influencia_empresa = $this->input->post('encuesta_nos_field_influencia_empresa');
			$this->registro_actual->encuesta_nos_field_influencia_disenio = $this->input->post('encuesta_nos_field_influencia_disenio');
			$this->registro_actual->encuesta_nos_field_influencia_comodidad = $this->input->post('encuesta_nos_field_influencia_comodidad');
			$this->registro_actual->encuesta_nos_field_influencia_practicidad = $this->input->post('encuesta_nos_field_influencia_practicidad');
			$this->registro_actual->encuesta_nos_field_influencia_seguridad = $this->input->post('encuesta_nos_field_influencia_seguridad');
			$this->registro_actual->encuesta_nos_field_influencia_confiabilidad = $this->input->post('encuesta_nos_field_influencia_confiabilidad');
			$this->registro_actual->encuesta_nos_field_influencia_longevidad = $this->input->post('encuesta_nos_field_influencia_longevidad');
			$this->registro_actual->encuesta_nos_field_influencia_prestigio = $this->input->post('encuesta_nos_field_influencia_prestigio');
			$this->registro_actual->encuesta_nos_field_influencia_calidad = $this->input->post('encuesta_nos_field_influencia_calidad');
			$this->registro_actual->encuesta_nos_field_influencia_disponibilidad = $this->input->post('encuesta_nos_field_influencia_disponibilidad');
			$this->registro_actual->encuesta_nos_field_influencia_accesorios = $this->input->post('encuesta_nos_field_influencia_accesorios');
			$this->registro_actual->encuesta_nos_field_influencia_servicio = $this->input->post('encuesta_nos_field_influencia_servicio');
			$this->registro_actual->encuesta_nos_field_comparo_otra_marca = $this->input->post('encuesta_nos_field_comparo_otra_marca');
			$this->registro_actual->encuesta_nos_field_comparo_otra_marca_1 = $this->input->post('encuesta_nos_field_comparo_otra_marca_1');
			$this->registro_actual->encuesta_nos_field_comparo_otra_anio_1 = $this->input->post('encuesta_nos_field_comparo_otra_anio_1');
			$this->registro_actual->encuesta_nos_field_comparo_otra_modelo_1 = $this->input->post('encuesta_nos_field_comparo_otra_modelo_1');
			$this->registro_actual->encuesta_nos_field_comparo_otra_marca_2 = $this->input->post('encuesta_nos_field_comparo_otra_marca_2');
			$this->registro_actual->encuesta_nos_field_comparo_otra_anio_2 = $this->input->post('encuesta_nos_field_comparo_otra_anio_2');
			$this->registro_actual->encuesta_nos_field_comparo_otra_modelo_2 = $this->input->post('encuesta_nos_field_comparo_otra_modelo_2');
			$this->registro_actual->encuesta_nos_field_primer_automovil = $this->input->post('encuesta_nos_field_primer_automovil');
			$this->registro_actual->encuesta_nos_field_automovil_anterior_marca = $this->input->post('encuesta_nos_field_automovil_anterior_marca');
			$this->registro_actual->encuesta_nos_field_automovil_anterior_anio = $this->input->post('encuesta_nos_field_automovil_anterior_anio');
			$this->registro_actual->encuesta_nos_field_automovil_anterior_modelo = $this->input->post('encuesta_nos_field_automovil_anterior_modelo');
			$this->registro_actual->encuesta_nos_field_automovil_otro = $this->input->post('encuesta_nos_field_automovil_otro');
			$this->registro_actual->encuesta_nos_field_automovil_otro_marca = $this->input->post('encuesta_nos_field_automovil_otro_marca');
			$this->registro_actual->encuesta_nos_field_automovil_otro_anio = $this->input->post('encuesta_nos_field_automovil_otro_anio');
			$this->registro_actual->encuesta_nos_field_automovil_otro_modelo = $this->input->post('encuesta_nos_field_automovil_otro_modelo');
			
		
			$this->registro_actual->save();

			$this->registro_actual->unlink('Many_Encuesta_Nos_Opinion_Interes');
			$this->registro_actual->save();
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_encuesta_nos_opinion_interes')))
			{
					foreach($this->input->post('many_encuesta_nos_opinion_interes') as $encuesta_nos_opinion_interes_id) {
						$relacion=new Encuesta_Nos_M_Encuesta_Nos_Opinion_Interes();
						$relacion->encuesta_nos_opinion_interes_id = (int)$encuesta_nos_opinion_interes_id;
						$relacion->encuesta_nos_id = $this->registro_actual->id;
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

		

		//------------ [select / checkbox / radio sexo_id] :(
		$sexo=new Sexo();
		$q = $sexo->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sexo_field_desc');
		$config['select'] = TRUE;
		$this->template['sexo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sexo_id]

		//------------ [select / checkbox / radio encuesta_nos_edad_id] :(
		$encuesta_nos_edad=new Encuesta_Nos_Edad();
		$q = $encuesta_nos_edad->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('encuesta_nos_edad_field_desc');
		$config['select'] = TRUE;
		$this->template['encuesta_nos_edad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio encuesta_nos_edad_id]

		//------------ [select / checkbox / radio encuesta_nos_grupo_familiar_id] :(
		$encuesta_nos_grupo_familiar=new Encuesta_Nos_Grupo_Familiar();
		$q = $encuesta_nos_grupo_familiar->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('encuesta_nos_grupo_familiar_field_desc');
		$config['select'] = TRUE;
		$this->template['encuesta_nos_grupo_familiar_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio encuesta_nos_grupo_familiar_id]

		//------------ [select / checkbox / radio encuesta_nos_ocupacion_id] :(
		$encuesta_nos_ocupacion=new Encuesta_Nos_Ocupacion();
		$q = $encuesta_nos_ocupacion->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('encuesta_nos_ocupacion_field_desc');
		$config['select'] = TRUE;
		$this->template['encuesta_nos_ocupacion_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio encuesta_nos_ocupacion_id]

		//------------ [select / checkbox / radio encuesta_nos_financiacion_id] :(
		$encuesta_nos_financiacion=new Encuesta_Nos_Financiacion();
		$q = $encuesta_nos_financiacion->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('encuesta_nos_financiacion_field_desc');
		$config['select'] = TRUE;
		$this->template['encuesta_nos_financiacion_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio encuesta_nos_financiacion_id]

		//------------ [select / checkbox / radio encuesta_nos_tipo_automovil_id] :(
		$encuesta_nos_tipo_automovil=new Encuesta_Nos_Tipo_Automovil();
		$q = $encuesta_nos_tipo_automovil->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('encuesta_nos_tipo_automovil_field_desc');
		$config['select'] = TRUE;
		$this->template['encuesta_nos_tipo_automovil_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio encuesta_nos_tipo_automovil_id]

		//------------ [select / checkbox / radio encuesta_nos_conductor_id] :(
		$encuesta_nos_conductor=new Encuesta_Nos_Conductor();
		$q = $encuesta_nos_conductor->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('encuesta_nos_conductor_field_desc');
		$config['select'] = TRUE;
		$this->template['encuesta_nos_conductor_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio encuesta_nos_conductor_id]
		
		//------------ [Qué uso le da a su automóvil?]
		$automovil_usos = array(1	=>'Principal',
								2	=>'Secundario',
								3	=>'Ns/Nc'
		
		);
		$this->template['automovil_usos']=$automovil_usos;
		//------------ [Qué uso le da a su automóvil?]
		
		//------------ [opiones sobre Honda]
		$opiniones_honda = array(	0	=>'Seleccione',
									1	=>'Más de lo normal',
									2	=>'Normal',
									3	=>'Debajo de lo normal',
									4	=>'Ns/Nc'
		
		);
		$this->template['opiniones_honda']=$opiniones_honda;
		//------------ [opiones sobre Honda]
		
		//------------ [Qué características lo influenciaron]
		$caracteristicas_infuenciaron = array(	1	=>'Importante',
									2				=>'Secundario',
									3				=>'Ns/Nc'
		);
		$this->template['caracteristicas_infuenciaron']=$caracteristicas_infuenciaron;
		//------------ [Qué características lo influenciaron]
		
		//------------ [Qué características lo influenciaron]
		$si_no = 			array(	1	=>'No',
									2	=>'Si'
		);
		$this->template['si_no']=$si_no;
		//------------ [Qué características lo influenciaron]
		
		

		//------------ [checkbox Many_Encuesta_Nos_Opinion_Interes]
		$encuesta_nos_opinion_interes=new Encuesta_Nos_Opinion_Interes();
		$q = $encuesta_nos_opinion_interes->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('encuesta_nos_opinion_interes_field_desc');
		$config['select'] = FALSE;
		$this->template['many_encuesta_nos_opinion_interes']=$this->_create_html_options($q, $config);
		//------------ [fin checkbox Many_Encuesta_Nos_Opinion_Interes]
	
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
	private function _validar_formulario() {
		if($this->registro_actual)
		{
			$id=$this->registro_actual->id;
		}else{
			$id = FALSE;
		}
		
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
				'trim|required|alpha_numeric|my_exist_unidad['.$this->input->post('unidad_field_vin').']' );
		
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
				'trim|required|exact_length[17]|alpha_numeric' );
		
		//que no exista otra encuesta
		if($this->router->method == 'add' )
		{
			$nos = new Encuesta_Nos();
			$q = $nos->get_all();
			$q->addWhere('unidad_field_unidad = ?',	$this->input->post('unidad_field_unidad'));
			$q->addWhere('unidad_field_vin = ?',	$this->input->post('unidad_field_vin'));
			$resultado = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
			if($resultado)
			{
				//epa, existe otra encuesta, fuerzo el error
				$this->form_validation->my_force_error('unidad_field_unidad',$this->lang->line('form_registro_existente') );
			}
		}
		
		
		
		
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));

		
		$this->form_validation->set_rules('sexo_id',$this->marvin->mysql_field_to_human('sexo_id'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_edad_id',$this->marvin->mysql_field_to_human('encuesta_nos_edad_id'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_grupo_familiar_id',$this->marvin->mysql_field_to_human('encuesta_nos_grupo_familiar_id'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_ocupacion_id',$this->marvin->mysql_field_to_human('encuesta_nos_ocupacion_id'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_financiacion_id',$this->marvin->mysql_field_to_human('encuesta_nos_financiacion_id'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_tipo_automovil_id',$this->marvin->mysql_field_to_human('encuesta_nos_tipo_automovil_id'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_conductor_id',$this->marvin->mysql_field_to_human('encuesta_nos_conductor_id'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_uso_negocios',$this->marvin->mysql_field_to_human('encuesta_nos_field_uso_negocios'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_uso_transporte_trabajo',$this->marvin->mysql_field_to_human('encuesta_nos_field_uso_transporte_trabajo'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_uso_transporte_escuela',$this->marvin->mysql_field_to_human('encuesta_nos_field_uso_transporte_escuela'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_uso_general',$this->marvin->mysql_field_to_human('encuesta_nos_field_uso_general'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_uso_placer',$this->marvin->mysql_field_to_human('encuesta_nos_field_uso_placer'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_opinion_investigacion',$this->marvin->mysql_field_to_human('encuesta_nos_field_opinion_investigacion'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_opinion_originalidad',$this->marvin->mysql_field_to_human('encuesta_nos_field_opinion_originalidad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_opinion_carreras',$this->marvin->mysql_field_to_human('encuesta_nos_field_opinion_carreras'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_opinion_seguridad',$this->marvin->mysql_field_to_human('encuesta_nos_field_opinion_seguridad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_opinion_medio_ambiente',$this->marvin->mysql_field_to_human('encuesta_nos_field_opinion_medio_ambiente'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_opinion_eficiencia',$this->marvin->mysql_field_to_human('encuesta_nos_field_opinion_eficiencia'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_opinion_interes_otros',$this->marvin->mysql_field_to_human('encuesta_nos_field_opinion_interes_otros'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_estilo',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_estilo'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_tamanio',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_tamanio'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_potencia',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_potencia'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_respuesta',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_respuesta'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_maniobrabilidad',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_maniobrabilidad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_economia',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_economia'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_precio',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_precio'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_financiacion',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_financiacion'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_garantia',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_garantia'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_modelo',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_modelo'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_empresa',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_empresa'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_disenio',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_disenio'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_comodidad',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_comodidad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_practicidad',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_practicidad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_seguridad',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_seguridad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_confiabilidad',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_confiabilidad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_longevidad',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_longevidad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_prestigio',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_prestigio'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_calidad',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_calidad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_disponibilidad',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_disponibilidad'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_accesorios',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_accesorios'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_influencia_servicio',$this->marvin->mysql_field_to_human('encuesta_nos_field_influencia_servicio'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_comparo_otra_marca',$this->marvin->mysql_field_to_human('encuesta_nos_field_comparo_otra_marca'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_comparo_otra_marca_1',$this->marvin->mysql_field_to_human('encuesta_nos_field_comparo_otra_marca_1'),
				'trim|max_length[150]' );

		$this->form_validation->set_rules('encuesta_nos_field_comparo_otra_anio_1',$this->marvin->mysql_field_to_human('encuesta_nos_field_comparo_otra_anio_1'),
				'trim|max_length[4]' );

		$this->form_validation->set_rules('encuesta_nos_field_comparo_otra_modelo_1',$this->marvin->mysql_field_to_human('encuesta_nos_field_comparo_otra_modelo_1'),
				'trim|max_length[150]' );

		$this->form_validation->set_rules('encuesta_nos_field_comparo_otra_marca_2',$this->marvin->mysql_field_to_human('encuesta_nos_field_comparo_otra_marca_2'),
				'trim|max_length[150]' );

		$this->form_validation->set_rules('encuesta_nos_field_comparo_otra_anio_2',$this->marvin->mysql_field_to_human('encuesta_nos_field_comparo_otra_anio_2'),
				'trim|max_length[4]' );

		$this->form_validation->set_rules('encuesta_nos_field_comparo_otra_modelo_2',$this->marvin->mysql_field_to_human('encuesta_nos_field_comparo_otra_modelo_2'),
				'trim|max_length[150]' );

		$this->form_validation->set_rules('encuesta_nos_field_primer_automovil',$this->marvin->mysql_field_to_human('encuesta_nos_field_primer_automovil'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_automovil_anterior_marca',$this->marvin->mysql_field_to_human('encuesta_nos_field_automovil_anterior_marca'),
				'trim|max_length[150]' );

		$this->form_validation->set_rules('encuesta_nos_field_automovil_anterior_anio',$this->marvin->mysql_field_to_human('encuesta_nos_field_automovil_anterior_anio'),
				'trim|max_length[4]' );

		$this->form_validation->set_rules('encuesta_nos_field_automovil_anterior_modelo',$this->marvin->mysql_field_to_human('encuesta_nos_field_automovil_anterior_modelo'),
				'trim|max_length[150]' );

		$this->form_validation->set_rules('encuesta_nos_field_automovil_otro',$this->marvin->mysql_field_to_human('encuesta_nos_field_automovil_otro'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_automovil_otro_marca',$this->marvin->mysql_field_to_human('encuesta_nos_field_automovil_otro_marca'),
				'trim|max_length[150]' );

		$this->form_validation->set_rules('encuesta_nos_field_automovil_otro_anio',$this->marvin->mysql_field_to_human('encuesta_nos_field_automovil_otro_anio'),
				'trim|max_length[4]' );

		$this->form_validation->set_rules('encuesta_nos_field_automovil_otro_modelo',$this->marvin->mysql_field_to_human('encuesta_nos_field_automovil_otro_modelo'),
				'trim|max_length[150]' );

		$this->form_validation->set_rules('encuesta_nos_field_fechahora_alta',$this->marvin->mysql_field_to_human('encuesta_nos_field_fechahora_alta'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_admin_alta_id',$this->marvin->mysql_field_to_human('encuesta_nos_field_admin_alta_id'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_fechahora_modificacion',$this->marvin->mysql_field_to_human('encuesta_nos_field_fechahora_modificacion'),
				'trim' );

		$this->form_validation->set_rules('encuesta_nos_field_admin_modifica_id',$this->marvin->mysql_field_to_human('encuesta_nos_field_admin_modifica_id'),
				'trim' );


		$this->form_validation->set_rules('many_encuesta_nos_opinion_interes[]',$this->marvin->mysql_field_to_human('encuesta_nos_opinion_interes_id'),
			'trim' );

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
	
	//------ rechazando tarjeta de garantia
	private function _reject_record()
	{
		
		if(!$this->registro_actual || $this->registro_actual->encuesta_nos_estado_id==9 || !$this->backend->_permiso('admin'))
		{
			return FALSE;
		}
		
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			//
				
				
				
				$this->registro_actual->encuesta_nos_field_rechazo_motivo	= $this->input->post('rechazo_motivo');
				$this->registro_actual->encuesta_nos_field_admin_rechaza_id	= $this->session->userdata('admin_id');
				$this->registro_actual->encuesta_nos_estado_id				= 9;
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
