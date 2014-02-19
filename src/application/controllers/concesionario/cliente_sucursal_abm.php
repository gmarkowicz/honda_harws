<?php
define('ID_SECCION',1081);
class Cliente_Sucursal_Abm extends Backend_Controller{
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
				$this->registro_actual = new Cliente_Sucursal();
				if ($this->_grabar_registro_actual())
				{
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
				if ($this->_grabar_registro_actual())
				{
					$this->session->set_flashdata('edit_ok', true);
					redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
				}
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
			
			$actuales=array();
			foreach($this->registro_actual->Cliente->Many_Cliente_Codigo_Interno as $relacion) {
				$actuales[]=$relacion->id;
			}
			$this->form_validation->set_defaults(array('cliente_codigo_interno_id[]'=>$actuales));	

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

			$_POST['cliente_sucursal_field_nombre'] = (@$_POST['cliente_sucursal_field_razon_social']=='')?@$_POST['cliente_sucursal_field_nombre']:'';
			$_POST['cliente_sucursal_field_apellido'] = (@$_POST['cliente_sucursal_field_razon_social']=='')?@$_POST['cliente_sucursal_field_apellido']:'';

			$this->registro_actual->cliente_sucursal_field_razon_social = $this->input->post('cliente_sucursal_field_razon_social');
			$this->registro_actual->cliente_sucursal_field_nombre = $this->input->post('cliente_sucursal_field_nombre');
			$this->registro_actual->cliente_sucursal_field_apellido = $this->input->post('cliente_sucursal_field_apellido');
			$this->registro_actual->cliente_sucursal_field_direccion_calle = $this->input->post('cliente_sucursal_field_direccion_calle');
			$this->registro_actual->cliente_sucursal_field_direccion_numero = $this->input->post('cliente_sucursal_field_direccion_numero');
			$this->registro_actual->cliente_sucursal_field_direccion_piso = $this->input->post('cliente_sucursal_field_direccion_piso');
			$this->registro_actual->cliente_sucursal_field_direccion_depto = $this->input->post('cliente_sucursal_field_direccion_depto');
			$this->registro_actual->cliente_sucursal_field_direccion_codigo_postal = $this->input->post('cliente_sucursal_field_direccion_codigo_postal');
			$this->registro_actual->cliente_sucursal_field_telefono_particular_codigo = $this->input->post('cliente_sucursal_field_telefono_particular_codigo');
			$this->registro_actual->cliente_sucursal_field_telefono_particular_numero = $this->input->post('cliente_sucursal_field_telefono_particular_numero');
			$this->registro_actual->cliente_sucursal_field_telefono_laboral_codigo = $this->input->post('cliente_sucursal_field_telefono_laboral_codigo');
			$this->registro_actual->cliente_sucursal_field_telefono_laboral_numero = $this->input->post('cliente_sucursal_field_telefono_laboral_numero');
			$this->registro_actual->cliente_sucursal_field_telefono_movil_codigo = $this->input->post('cliente_sucursal_field_telefono_movil_codigo');
			$this->registro_actual->cliente_sucursal_field_telefono_movil_numero = $this->input->post('cliente_sucursal_field_telefono_movil_numero');
			$this->registro_actual->cliente_sucursal_field_fax_codigo = $this->input->post('cliente_sucursal_field_fax_codigo');
			$this->registro_actual->cliente_sucursal_field_fax_numero = $this->input->post('cliente_sucursal_field_fax_numero');
			$this->registro_actual->cliente_sucursal_field_email = $this->input->post('cliente_sucursal_field_email');
			$this->registro_actual->cliente_sucursal_field_localidad_aux = $this->input->post('cliente_sucursal_field_localidad_aux');
			$this->registro_actual->cliente_sucursal_field_fecha_nacimiento = $this->input->post('cliente_sucursal_field_fecha_nacimiento');
			$this->registro_actual->sexo_id = $this->input->post('sexo_id');
			$this->registro_actual->tratamiento_id = $this->input->post('tratamiento_id');
			$this->registro_actual->pais_id = $this->input->post('pais_id');
			$this->registro_actual->provincia_id = $this->input->post('provincia_id');
			$this->registro_actual->ciudad_id = $this->input->post('ciudad_id');
			$this->registro_actual->sucursal_id = $this->input->post('sucursal_id');
			$this->registro_actual->cliente_id = $this->input->post('cliente_id');
			
			
			if($this->router->method == 'add' )
			{
				$this->registro_actual->cliente_sucursal_field_admin_alta_id = $this->session->userdata('admin_id');
				$this->registro_actual->cliente_sucursal_field_fechahora_alta = date('Y-m-d H:i:s', time());

				if ($this->registro_actual->cliente_id == null || $this->registro_actual->cliente_id == false)
				{
					// Revisamos si existe un cliente con el DNI indicado para no duplicarlo
					$query = Doctrine_Query::create();
					$query->from('Cliente');
					$query->andWhere('cliente_field_numero_documento = ?', $this->input->post('cliente_field_numero_documento'));
					$query->andWhere('documento_tipo_id = ?', $this->input->post('documento_tipo_id'));
					$cliente = $query->fetchOne();

					if ($cliente == null)
					{
						// si no existe un cliente con el DNI indicado lo generamos
						$cliente = new Cliente();
						$cliente->set('documento_tipo_id', $this->input->post('documento_tipo_id'));
						$cliente->set('cliente_conformidad_id', $this->input->post('cliente_conformidad_id'));
						$cliente->set('cliente_field_numero_documento', $this->input->post('cliente_field_numero_documento'));
						$cliente->set('cliente_field_admin_alta_id', $this->session->userdata('admin_id'));
						$cliente->set('created_at', date('Y-m-d H:i:s', time()));
						$cliente->set('updated_at', date('Y-m-d H:i:s', time()));
						$cliente->save();
						
						//no hay que crearle un registro a honda si la empresa seleccionada es honda
						if($this->input->post('sucursal_id')!= 1000)
						{
							$registro_array = $this->registro_actual->toArray();
							$registro_array['sucursal_id'] = 1000;
							$registro_array['cliente_id'] = $cliente->id;
							$deHonda = new Cliente_Sucursal();
							$deHonda->fromArray($registro_array);
							$deHonda->save();
						}
					}
					// usamos el cliente Nuevo o Existente para el usuario
					$this->registro_actual->cliente_id = $cliente->id;
				}
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->cliente_sucursal_field_admin_modifica_id = $this->session->userdata('admin_id');
				$this->registro_actual->cliente_sucursal_field_fechahora_alta = date('Y-m-d H:i:s', time());
				$this->registro_actual->Cliente->cliente_conformidad_id = $this->input->post('cliente_conformidad_id');
			}
			
			
			
			
						
			// Revisamos si existe ya un cliente para esa sucursal, para no duplicarlo
			if ($this->_validateClienteSucursal($this->registro_actual->sucursal_id, $this->registro_actual->cliente_id))
			{
				$this->registro_actual->save();
				
				if($this->sucursal)
				{
					$update_arr = array(
							'cliente_sucursal_field_nombre' => $this->input->post('cliente_sucursal_field_nombre'),
							'cliente_sucursal_field_apellido' => $this->input->post('cliente_sucursal_field_apellido'),
							'cliente_sucursal_field_razon_social' => $this->input->post('cliente_sucursal_field_razon_social'),
							'cliente_sucursal_field_direccion_calle' => $this->input->post('cliente_sucursal_field_direccion_calle'),
							'cliente_sucursal_field_direccion_numero' => $this->input->post('cliente_sucursal_field_direccion_numero'),
							'cliente_sucursal_field_direccion_piso' => $this->input->post('cliente_sucursal_field_direccion_piso'),
							'cliente_sucursal_field_direccion_depto' => $this->input->post('cliente_sucursal_field_direccion_depto'),
							'cliente_sucursal_field_direccion_codigo_postal' => $this->input->post('cliente_sucursal_field_direccion_codigo_postal'),
							'cliente_sucursal_field_telefono_particular_codigo' => $this->input->post('cliente_sucursal_field_telefono_particular_codigo'),
							'cliente_sucursal_field_telefono_particular_numero' => $this->input->post('cliente_sucursal_field_telefono_particular_numero'),
							'cliente_sucursal_field_telefono_laboral_codigo' => $this->input->post('cliente_sucursal_field_telefono_laboral_codigo'),
							'cliente_sucursal_field_telefono_laboral_numero' => $this->input->post('cliente_sucursal_field_telefono_laboral_numero'),
							'cliente_sucursal_field_telefono_movil_codigo' => $this->input->post('cliente_sucursal_field_telefono_movil_codigo'),
							'cliente_sucursal_field_telefono_movil_numero' => $this->input->post('cliente_sucursal_field_telefono_movil_numero'),
							'cliente_sucursal_field_fax_codigo' => $this->input->post('cliente_sucursal_field_fax_codigo'),
							'cliente_sucursal_field_fax_numero' => $this->input->post('cliente_sucursal_field_fax_numero'),
							'cliente_sucursal_field_email' => $this->input->post('cliente_sucursal_field_email'),
							'cliente_sucursal_field_localidad_aux' => $this->input->post('cliente_sucursal_field_localidad_aux'),
							'cliente_sucursal_field_fecha_nacimiento' => $this->input->post('cliente_sucursal_field_fecha_nacimiento'),
							'sexo_id' => $this->input->post('sexo_id'),
							'tratamiento_id' => $this->input->post('tratamiento_id'),
							'pais_id' => $this->input->post('pais_id'),
							'provincia_id' => $this->input->post('provincia_id'),
							'ciudad_id' => $this->input->post('ciudad_id'),
							'cliente_sucursal_field_admin_modifica_id' => $this->session->userdata('admin_id'),
							'cliente_sucursal_field_fechahora_modificacion' => date('Y-m-d H:i:s', time()),
					);
					// 'sucursal_id' => $this->input->post('sucursal_id'),

					//$q = $conn->createQuery()
					$q = Doctrine_Query::create()
					->update('cliente_sucursal')
					->where('cliente_id = ?', $this->registro_actual->cliente_id)
					->whereIn('sucursal_id',$this->session->userdata('sucursales'))
					->set($update_arr);
					$q->execute();
				}
				
				
				//tomo el cliente para actualizar el codigo interno, no se porque no funciona bien cuando toco this->registro_actual->Cliente
				//y no tengo ganas de renegar
				if($this->session->userdata('show_cliente_codigo_interno') == TRUE)
				{
					$q = Doctrine_Query::create()
					->from('Cliente')
					->where('id = ?',$this->registro_actual->cliente_id);
					if($q->count()!=1)
					{
						show_error(__LINE__ . ' no encuentro cliente ');
					}
					$cliente = $q->fetchOne();
					$cliente->unlink('Many_Cliente_Codigo_Interno');
					$cliente->save();
					
					if(is_array($this->input->post('cliente_codigo_interno_id')))
					{
							foreach($this->input->post('cliente_codigo_interno_id') as $cliente_codigo_interno_id) {
								$relacion=new Cliente_M_Cliente_Codigo_Interno();
								$relacion->cliente_codigo_interno_id = (int)$cliente_codigo_interno_id;
								$relacion->cliente_id = $cliente->id;
								$relacion->save();
							}
					}
				}
				//
				
				
				

				
				
				
				
				
				$conn->commit();
			} else {
				return false;
			}

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
		return true;
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

		// data cliente
		if($this->router->method != 'add' )
		{
			$cliente = $this->registro_actual->Cliente;
			$this->template['cliente'] = $cliente;
		}


		//------------ [select / checkbox / radio cliente_conformidad_id] :(
		$sexo=new Cliente_Conformidad();
		$q = $sexo->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('cliente_conformidad_field_desc');
		$config['select'] = TRUE;
		$this->template['cliente_conformidades']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_conformidad_id]

		//------------ [select / checkbox / radio sexo_id] :(
		$sexo=new Sexo();
		$q = $sexo->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sexo_field_desc');
		$config['select'] = TRUE;
		$this->template['sexo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sexo_id]

		//------------ [select / checkbox / radio tratamiento_id] :(
		$tratamiento=new Tratamiento();
		$q = $tratamiento->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tratamiento_field_desc');
		$config['select'] = TRUE;
		$this->template['tratamiento_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tratamiento_id]

		//------------ [select / checkbox / radio pais_id] :(
		$pais=new Pais();
		$q = $pais->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('pais_field_desc');
		$config['select'] = TRUE;
		$this->template['pais_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio pais_id]

		//------------ [select / checkbox / radio provincia_id] :(
		$provincia=new Provincia();
		$q = $provincia->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('provincia_field_desc');
		$config['select'] = TRUE;
		$this->template['provincia_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio provincia_id]

		//------------ [select / checkbox / radio ciudad_id] :(
		$ciudad=new Ciudad();
		$q = $ciudad->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('ciudad_field_desc');
		$config['select'] = TRUE;
		$this->template['ciudad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio ciudad_id]

		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = TRUE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]

		//------------ [select / checkbox / radio documento_tipo_id] :(
		 		$documentos=new Documento_Tipo();
		 		$q = $documentos->get_all();
		 		$config=array();
		 		$config['fields'] = array('documento_tipo_field_desc');
		 		$config['select'] = TRUE;
		 		$this->template['documentos']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_id]
		
		//------------ [select / checkbox / radio cliente_conformidad_id] :(
		$obj=new Cliente_Codigo_Interno();
		$q = $obj->get_all();
		$config=array();
		$config['fields'] = array('cliente_codigo_interno_field_desc');
		$config['select'] = FALSE;
		$this->template['cliente_codigo_interno_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_conformidad_id]
		
		
		//------------ [select / checkbox / radio cliente_id] :(
// 		$cliente=new Cliente();
// 		$q = $cliente->get_all();
// 		$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
// 		$config=array();
// 		$config['fields'] = array('cliente_field_desc');
// 		$config['select'] = TRUE;
// 		$this->template['cliente_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_id]

		/*
		//------------ [select / checkbox / radio cliente_sucursal_field_admin_alta_id] :(
		$cliente_sucursal_field_admin_alta=new Cliente_Sucursal_Field_Admin_Alta();
		$q = $cliente_sucursal_field_admin_alta->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('cliente_sucursal_field_admin_alta_field_desc');
		$config['select'] = TRUE;
		$this->template['cliente_sucursal_field_admin_alta_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_sucursal_field_admin_alta_id]

		//------------ [select / checkbox / radio cliente_sucursal_field_admin_modifica_id] :(
		$cliente_sucursal_field_admin_modifica=new Cliente_Sucursal_Field_Admin_Modifica();
		$q = $cliente_sucursal_field_admin_modifica->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('cliente_sucursal_field_admin_modifica_field_desc');
		$config['select'] = TRUE;
		$this->template['cliente_sucursal_field_admin_modifica_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio cliente_sucursal_field_admin_modifica_id]
		*/
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

		if($this->router->method == 'add' )
		{
			$this->form_validation->set_rules('documento_tipo_id',$this->marvin->mysql_field_to_human('documento_tipo_id'),
					'trim|required|is_natural_no_zero' );

			if($_POST['documento_tipo_id']==4)
			{
				$this->form_validation->set_rules('cliente_field_numero_documento',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
						'trim|required|integer|my_valid_cuit' );
				$this->form_validation->set_rules('sexo_id',$this->marvin->mysql_field_to_human('sexo_id'),
						'trim' );

				$this->form_validation->set_rules('tratamiento_id',$this->marvin->mysql_field_to_human('tratamiento_id'),
						'trim' );
			}else{
				$this->form_validation->set_rules('cliente_field_numero_documento',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
						'trim|required|integer|my_valid_documento' );
				$this->form_validation->set_rules('sexo_id',$this->marvin->mysql_field_to_human('sexo_id'),
						'trim|required|is_natural_no_zero' );

				$this->form_validation->set_rules('tratamiento_id',$this->marvin->mysql_field_to_human('tratamiento_id'),
						'trim|required|is_natural_no_zero' );

			}

		} else {
			$this->form_validation->set_rules('cliente_id',$this->marvin->mysql_field_to_human('cliente_id'),
					'trim|required|is_natural_no_zero' );
		}

		$this->form_validation->set_rules('sucursal_id',$this->marvin->mysql_field_to_human('sucursal_id'),
				'trim|required|is_natural_no_zero|my_valid_sucursal' );

		$this->form_validation->set_rules('cliente_sucursal_field_razon_social',$this->marvin->mysql_field_to_human('cliente_sucursal_field_razon_social'),
				'trim|min_length[3]|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_nombre',$this->marvin->mysql_field_to_human('cliente_sucursal_field_nombre'),
				'trim|min_length[3]|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_apellido',$this->marvin->mysql_field_to_human('cliente_sucursal_field_apellido'),
				'trim|min_length[3]|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_localidad_aux',$this->marvin->mysql_field_to_human('cliente_sucursal_field_localidad_aux'),
				'trim|max_length[255]' );


		if(strlen($_POST['cliente_sucursal_field_fecha_nacimiento'])>0)
		{
			$this->form_validation->set_rules('cliente_sucursal_field_fecha_nacimiento',$this->marvin->mysql_field_to_human('cliente_sucursal_field_fecha_nacimiento'),
					'trim|my_form_date_reverse|required|my_valid_date[y-m-d,-]' );
		}else{
			$this->form_validation->set_rules('cliente_sucursal_field_fecha_nacimiento',$this->marvin->mysql_field_to_human('cliente_sucursal_field_fecha_nacimiento'),
					'trim' );

		}
		
		if(strlen($_POST['cliente_sucursal_field_email'])>0)
		{
		$this->form_validation->set_rules('cliente_sucursal_field_email',$this->marvin->mysql_field_to_human('cliente_sucursal_field_email'),
				'trim|required|max_length[255]|valid_email' );
		}
		else
		{
			$this->form_validation->set_rules('cliente_sucursal_field_email',$this->marvin->mysql_field_to_human('cliente_sucursal_field_email'),
				'trim' );
		}
		$this->form_validation->set_rules('cliente_sucursal_field_direccion_calle',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_calle'),
				'trim|required|min_length[3]|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_direccion_numero',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_numero'),
				'trim|required|numeric' );

		$this->form_validation->set_rules('cliente_sucursal_field_direccion_piso',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_piso'),
				'trim|max_length[5]' );

		$this->form_validation->set_rules('cliente_sucursal_field_direccion_depto',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_depto'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_direccion_codigo_postal',$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_codigo_postal'),
				'trim|required|alpha_numeric|min_length[4]' );

		$this->form_validation->set_rules('cliente_sucursal_field_telefono_particular_codigo',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_particular_codigo'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_telefono_particular_numero',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_particular_numero'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_telefono_laboral_codigo',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_laboral_codigo'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_telefono_laboral_numero',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_laboral_numero'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_telefono_movil_codigo',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_movil_codigo'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_telefono_movil_numero',$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_movil_numero'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_fax_codigo',$this->marvin->mysql_field_to_human('cliente_sucursal_field_fax_codigo'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('cliente_sucursal_field_fax_numero',$this->marvin->mysql_field_to_human('cliente_sucursal_field_fax_numero'),
				'trim|max_length[255]' );

		$this->form_validation->set_rules('pais_id',$this->marvin->mysql_field_to_human('pais_id'),
				'trim|required|is_natural_no_zero' );

		$this->form_validation->set_rules('provincia_id',$this->marvin->mysql_field_to_human('provincia_id'),
				'trim|required|is_natural_no_zero' );

		$this->form_validation->set_rules('ciudad_id',$this->marvin->mysql_field_to_human('ciudad_id'),
				'trim|required|is_natural_no_zero' );

		$this->form_validation->set_rules('cliente_sucursal_field_admin_alta_id',$this->marvin->mysql_field_to_human('cliente_sucursal_field_admin_alta_id'),
				'trim' );

		$this->form_validation->set_rules('cliente_sucursal_field_admin_modifica_id',$this->marvin->mysql_field_to_human('cliente_sucursal_field_admin_modifica_id'),
				'trim' );

		$this->form_validation->set_rules('cliente_conformidad_id',$this->marvin->mysql_field_to_human('cliente_conformidad_id'),
				'trim' );
		
		$this->form_validation->set_rules('cliente_codigo_interno_id[]',$this->marvin->mysql_field_to_human('cliente_codigo_interno_id'),
			'trim' );

		$validate_names = $this->_validateNames();
		$validate_sucursal = $this->_validateClienteSucursal();
		return $this->form_validation->run() && $validate_sucursal && $validate_names;
	}

	private function _validateClienteSucursal($sucursal = null, $cliente_id = null)
	{
		$sucursal = $sucursal == null ? $this->input->post('sucursal_id') : $sucursal;
		$cliente_id = $cliente_id == null ? $this->input->post('cliente_id') : $cliente_id;
		$return = true;
		$errores = array();
		if (!empty($cliente_id) && !empty($sucursal))
		{
			$query = Doctrine_Query::create();
			$query->from('Cliente_Sucursal');
			$query->andWhere('sucursal_id = ?', $sucursal);
			$query->andWhere('cliente_id = ?', $cliente_id);
			if ($this->registro_actual->id != '')
			{
				$query->andWhere('id <> ?', $this->registro_actual->id);
			}
			$cliente = $query->fetchOne();
			if ($cliente != null)
			{
				$errores[] = $this->lang->line('cliente_sucursal_duplicado').' <a href="'.site_url($this->config->item('backend_root')).'/cliente_sucursal_abm/edit/'.$cliente['id'].'">'.$this->lang->line('cliente_sucursal_duplicado_ver').'</a>';
			}
		}
		if (count($errores)>0)
		{
			$return = false;
			if (isset($this->template['upload_error']) && !is_array($this->template['upload_error']))
			{
				$this->template['upload_error'][] = $this->template['upload_error'];
			} elseif (empty($this->template['upload_error'])) {
				$this->template['upload_error'] = array();
			}
			$this->template['upload_error'] = $this->template['upload_error'] + $errores;
		}
		return $return;
	}

	private function _validateNames()
	{
		$razon_social = $this->input->post('cliente_sucursal_field_razon_social');
		$nombre = $this->input->post('cliente_sucursal_field_nombre');
		$apellido = $this->input->post('cliente_sucursal_field_apellido');
		$errores = array();
		$return = true;
		if (trim($razon_social)=='' && trim($apellido)=='' && trim($nombre)=='')
		{
			$errores[] = $this->lang->line('cliente_sucursal_razon_social_error');
		} else {
			if (trim($razon_social)=='' && (trim($nombre) == '' || trim($apellido) == ''))
			{
				$errores[] = $this->lang->line('cliente_sucursal_nombre_error');
			}
		}
		if (count($errores)>0)
		{
			$return = false;
			if (isset($this->template['upload_error']) && !is_array($this->template['upload_error']))
			{
				$this->template['upload_error'][] = $this->template['upload_error'];
				} elseif (empty($this->template['upload_error'])) {
				$this->template['upload_error'] = array();
			}
			$this->template['upload_error'] = $this->template['upload_error'] + $errores;
		}
		return $return;
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
