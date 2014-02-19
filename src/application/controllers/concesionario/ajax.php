<?php
//define('ID_SECCION',__DEFINIR_ID_SECCION);

class Ajax extends Backend_Controller {
	//variables que se le pasan al template



	function Ajax()
	{

		parent::Backend_Controller();


	}

	function get_unidad_propietario_original()
	{
		$tg=new Tarjeta_Garantia();
		$q = $tg->get_propietario_original($this->input->post('vin'), $this->input->post('unidad') );
		$row = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
		if($row)
		{

			$cliente = array();
			foreach($row['Many_Cliente'] as $este_cliente)
			{
				$cliente[$este_cliente['id']] = trim($este_cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_nombre'] . ' ' .
												$este_cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_apellido'] . ' ' .
												$este_cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_razon_social']);
			}

			//------------ [fin select / checkbox / radio auto_version_id]
			$this->load->view('backend/ajax_view',array(
				'show_propietario_actual'=>true,
				'cliente_id'=>$cliente)
				);

		}
	}
	
	function get_cliente_tsi()
	{
		$tsi_id = $this->input->post('tsi_id');
		
		$obj = new Tsi();
		$q = $obj->get_all();
		$q->addWhere('id = ?',$tsi_id);
		$q->WhereIn('TSI.sucursal_id',$this->session->userdata('sucursales'));
		if($q->count() == 1)
		{
			$row = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
			$this->load->view( 'backend/miniviews/cliente_miniview',array('CLIENTE'=>$row['Cliente']));
		}
		
	}


	function get_ciudades($provincia_id = FALSE, $selected = FALSE)
	{

		 $input_name = $this->input->post('input');
		 if(!$input_name)
		 {
			$input_name='provincia_id';
		 }
		//------------ [select / checkbox / radio auto_version_id] :(
		(int)$provincia_id;
		$ciudad=new Ciudad();
		$q = $ciudad->get_all();
		$q->addWhere('provincia_id = ?',$provincia_id);
		$q->orderBy('ciudad_field_desc');
		$config=array();
		$config['fields'] = array('ciudad_field_desc');
		$config['select'] = TRUE;

		//------------ [fin select / checkbox / radio auto_version_id]

		$nombre_input=str_replace('provincia_id','ciudad_id',$input_name);

		$this->load->view('backend/ciudad_id_inc_view',array(
				'input'=>$nombre_input,
				'ciudad_id'=>$this->_create_html_options($q, $config),
				'selected' => $selected
				)
				);
	}

	function get_unidad($string_unidad = FALSE,$string_vin=FALSE)
	{
		//RETURN FALSE
		//deprecated BORRAR

		#tomo datos de la unidad
		$unidad=new Unidad();
		$q = $unidad->get_all();
		$q->addWhere('unidad_field_unidad = ?',$string_unidad);
		$q->addWhere('unidad_field_vin = ?',$string_vin);
		$registro = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);


		if($registro){
			$this->load->view('backend/_unidad_datos_inc_view',$registro);
		}
	}


	function get_datos_unidad($string_unidad = FALSE,$string_vin=FALSE)
	{
		$return = FALSE;


		$unidad = new Unidad();
		$q= $unidad->get_all();
		$q->addWhere('unidad_field_vin = ?',$string_vin);
		$q->addWhere('unidad_field_unidad = ?',$string_unidad);
		$registro = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);

		/*print_r($registro);*/

		if($registro)
		{
			//print_R($registro);

			$return = array(
				'id' 								=> $registro['id'],
				'unidad' 							=> $registro['unidad_field_unidad'],
				'vin' 								=> $registro['unidad_field_vin'],
				'marca' 							=> $registro['Auto_Version']['Auto_Modelo']['Auto_Marca']['auto_marca_field_desc'],
				'modelo' 							=> $registro['Auto_Version']['Auto_Modelo']['auto_modelo_field_desc'],
				'version' 							=> $registro['Auto_Version']['auto_version_field_desc'],
				'descripcion_sap'					=> $registro['unidad_field_descripcion_sap'],
				'transmision'						=> $registro['Auto_Transmision']['auto_transmision_field_desc'],
				'puerta_cantidad'					=> $registro['Auto_Puerta_Cantidad']['auto_puerta_cantidad_field_desc'],
				'motor'								=> $registro['unidad_field_motor'],
				'color_exterior'					=> $registro['Unidad_Color_Exterior']['unidad_color_exterior_field_desc'],
				'color_interior'					=> @$registro['Unidad_Color_Interior']['unidad_color_interior_field_desc'],
				'oblea'								=> $registro['unidad_field_oblea'],
				'codigo_de_llave'					=> $registro['unidad_field_codigo_de_llave'],
				'codigo_de_radio'					=> $registro['unidad_field_codigo_de_radio'],
				'patente'							=> $registro['unidad_field_patente'],
				'material_sap'						=> $registro['unidad_field_material_sap'],
				'anio_modelo'						=> $registro['Auto_Anio']['auto_anio_field_desc'],
				'fabrica'							=> $registro['Auto_Fabrica']['auto_fabrica_field_desc'],
				'procedencia'						=> $registro['Vin_Procedencia_Ktype']['vin_procedencia_ktype_field_desc'],
				'ktype'								=> $registro['Vin_Procedencia_Ktype']['vin_procedencia_ktype_field_ktype'],
				'fecha_venta'						=> $this->marvin->mysql_date_to_form($registro['unidad_field_fecha_venta']),
				'fecha_entrega'						=> $this->marvin->mysql_date_to_form($registro['unidad_field_fecha_entrega']),
				'edad_meses'						=> $registro['unidad_field_edad_meses'],
				'kilometros'						=> $registro['unidad_field_kilometros']
			);
		}

		$this->output->set_output(json_encode($return));



	}





	function get_unidad_codigo_llave($string_unidad = FALSE,$string_vin=FALSE)
	{
		//deprecated, borrar
		return FALSE;

		#tomo datos de la unidad
		$unidad=new Unidad();
		$q = $unidad->get_all();
		$q->addWhere('unidad_field_unidad = ?',$string_unidad);
		$q->addWhere('unidad_field_vin = ?',$string_vin);
		$registro = $q->fetchOne();

		if($registro){
			echo $registro->unidad_field_codigo_de_llave;
		}
	}

	function get_unidad_codigo_radio($string_unidad = FALSE,$string_vin=FALSE)
	{

		return FALSE;
		//deprecated, borrar
		#tomo datos de la unidad
		$unidad=new Unidad();
		$q = $unidad->get_all();
		$q->addWhere('unidad_field_unidad = ?',$string_unidad);
		$q->addWhere('unidad_field_vin = ?',$string_vin);
		$registro = $q->fetchOne();

		if($registro){
			echo $registro->unidad_field_codigo_de_radio;
		}
	}

	function get_unidad_patente($string_unidad = FALSE,$string_vin=FALSE)
	{

		//deprecated borrar
		return false;

		#tomo datos de la unidad
		$unidad=new Unidad();
		$q = $unidad->get_all();
		$q->addWhere('unidad_field_unidad = ?',$string_unidad);
		$q->addWhere('unidad_field_vin = ?',$string_vin);
		$registro = $q->fetchOne();

		if($registro){
			echo $registro->unidad_field_patente;
		}
	}



	function get_client_html_form($cliente_field_numero_documento = FALSE,$documento_tipo_id = FALSE, $sucursal_id=FALSE)
	{
		$template=array();

		if($cliente_field_numero_documento && $documento_tipo_id && $sucursal_id)
		{

			$cliente_sucursal = new Cliente_Sucursal();
			$q= $cliente_sucursal->get_all();
			$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
			$q->addWhere('cliente_field_numero_documento = ?',$cliente_field_numero_documento);
			$q->addWhere('documento_tipo_id = ?',$documento_tipo_id);
			$q->addWhere('sucursal_id = ?',$sucursal_id);
			$cliente = $q->fetchOne();
			if(!$cliente)
			{
				exit;
			}
			else
			{
				$cliente = $cliente->toArray();
				$template['documento_tipo_id']									=element('documento_tipo_id',$cliente);
				$template['cliente_conformidad_id']								=element('cliente_conformidad_id',$cliente);
				$template['cliente_field_numero_documento']						=element('cliente_field_numero_documento',$cliente);
				$template['cliente_sucursal_field_nombre']						=element('cliente_sucursal_field_nombre',$cliente);
				$template['cliente_sucursal_field_apellido']					=element('cliente_sucursal_field_apellido',$cliente);
				$template['cliente_sucursal_field_razon_social']				=element('cliente_sucursal_field_razon_social',$cliente);
				$template['cliente_sucursal_field_direccion_calle']				=element('cliente_sucursal_field_direccion_calle',$cliente);
				$template['cliente_sucursal_field_direccion_numero']			=element('cliente_sucursal_field_direccion_numero',$cliente);
				$template['cliente_sucursal_field_direccion_depto']				=element('cliente_sucursal_field_direccion_depto',$cliente);
				$template['cliente_sucursal_field_direccion_codigo_postal']		=element('cliente_sucursal_field_direccion_codigo_postal',$cliente);
				$template['cliente_sucursal_field_telefono_particular_codigo']	=element('cliente_sucursal_field_telefono_particular_codigo',$cliente);
				$template['cliente_sucursal_field_telefono_particular_numero']	=element('cliente_sucursal_field_telefono_particular_numero',$cliente);
				$template['cliente_sucursal_field_telefono_laboral_codigo']		=element('cliente_sucursal_field_telefono_laboral_codigo',$cliente);
				$template['cliente_sucursal_field_telefono_laboral_numero']		=element('cliente_sucursal_field_telefono_laboral_numero',$cliente);
				$template['cliente_sucursal_field_telefono_movil_codigo']		=element('cliente_sucursal_field_telefono_movil_codigo',$cliente);
				$template['cliente_sucursal_field_telefono_movil_numero']		=element('cliente_sucursal_field_telefono_movil_numero',$cliente);
				$template['cliente_sucursal_field_fax_codigo']					=element('cliente_sucursal_field_fax_codigo',$cliente);
				$template['cliente_sucursal_field_fax_numero']					=element('cliente_sucursal_field_fax_numero',$cliente);
				$template['cliente_sucursal_field_email']						=element('cliente_sucursal_field_email',$cliente);
				$template['cliente_sucursal_field_localidad_aux']				=element('cliente_sucursal_field_localidad_aux',$cliente);
				$template['cliente_sucursal_field_fecha_nacimiento']			=element('cliente_sucursal_field_fecha_nacimiento',$cliente);
				$template['sexo_id']											=element('sexo_id',$cliente);
				$template['tratamiento_id']										=element('tratamiento_id',$cliente);
				$template['pais_id']											=element('pais_id',$cliente);
				$template['provincia_id']										=element('provincia_id',$cliente);
				$template['ciudad_id']											=element('ciudad_id',$cliente);
			}
		}




		$template['id'] = uniqid();

		//------------ [select / checkbox / radio sexo_id] :(
		$sexo=new Sexo();
		$q = $sexo->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sexo_field_desc');
		$config['select'] = TRUE;
		$template['options_sexo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sexo_id]

		//------------ [select / checkbox / radio tratamiento_id] :(
		$tratamiento=new Tratamiento();
		$q = $tratamiento->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('tratamiento_field_desc');
		$config['select'] = TRUE;
		$template['options_tratamiento_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio tratamiento_id]

		//------------ [select / checkbox / radio provincia_id] :(
		$provincia=new Provincia();
		$q = $provincia->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('provincia_field_desc');
		$config['select'] = TRUE;
		$template['options_provincia_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio provincia_id]

		//------------ [select / checkbox / radio ciudad_id] :(
		if(!isset($template['provincia_id']))
			$template['provincia_id'] = FALSE;
		$ciudad=new Ciudad();
		$q = $ciudad->get_all();
		$q->Where('provincia_id = ?', @$template['provincia_id']);
		$config=array();
		$config['fields'] = array('ciudad_field_desc');
		$config['select'] = TRUE;
		$template['options_ciudad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio ciudad_id]

		//------------ [select / checkbox / radio documento_tipo_id] :(
		$documento_tipo=new Documento_Tipo();
		$q = $documento_tipo->get_all();
		$config=array();
		$config['fields'] = array('documento_tipo_field_desc');
		$config['select'] = TRUE;
		$template['options_documento_tipo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio ciudad_id]

		//------------ [select / checkbox / radio conformidad_id] :(
		$cliente_conformidad=new Cliente_Conformidad();
		$q = $cliente_conformidad->get_all();
		$config=array();
		$config['fields'] = array('cliente_conformidad_field_desc');
		$config['select'] = TRUE;
		$template['options_cliente_conformidad_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio ciudad_id]

		//TODO REVISAR :O
		//oculto datos si viene por tsi
		if(strstr($_SERVER['HTTP_REFERER'], 'tsi_abm'))
		{
			$template['tsi_form']=TRUE;
		}

		$this->load->view('backend/cliente_sucursal_abm_inc_view',$template);

	}

	function get_auto_modelo($marcas = FALSE, $modelos = FALSE,$versiones = FALSE)
	{
		//------------ [select / checkbox / radio auto_version_id] :(
		$marcas_array =explode("-",$marcas);
		$auto_modelo=new Auto_Modelo();
		$q = $auto_modelo->get_all();
		$q->whereIn('auto_marca_id',$marcas_array);
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc','auto_version_field_desc');
		$config['select'] = FALSE;

		$this->form_validation->set_defaults(array('auto_modelo_id[]'=>explode("-",$modelos)));
		$this->form_validation->set_rules('auto_modelo_id[]',$this->marvin->mysql_field_to_human('auto_modelo_id'),
			'trim'
		);
		$this->template['auto_modelo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_version_id]


		$this->load->view('backend/auto_modelo_id_inc_view',$this->template);
	}


	function get_auto_version($modelos = FALSE,$versiones = FALSE)
	{
		//------------ [select / checkbox / radio auto_version_id] :(
		$modelos_array =explode("-",$modelos);
		$auto_version=new Auto_Version();
		//$q = $auto_version->get_versiones_honda();
		$q = $auto_version->get_all();
		$q->whereIn('auto_modelo_id',$modelos_array);
		$q->orderBy('auto_marca_field_desc');
		$q->addOrderBy('auto_modelo_field_desc');
		$q->addOrderBy('auto_version_field_desc');
		/*
		$q->addWhere('auto_marca_id = ?',100);
		$q->orderBy('auto_modelo_field_desc');
		$q->addOrderBy('auto_version_field_desc');
		*/
		$config=array();
		$config['fields'] = array('auto_marca_field_desc','auto_modelo_field_desc','auto_version_field_desc');
		$config['select'] = FALSE;

		$this->form_validation->set_defaults(array('auto_version_id[]'=>explode("-",$versiones)));
		$this->form_validation->set_rules('auto_version_id[]',$this->marvin->mysql_field_to_human('auto_version_id'),
			'trim'
		);
		$this->template['auto_version_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_version_id]


		$this->load->view('backend/auto_version_id_inc_view',$this->template);
	}


	function get_vendedores()
	{
		//------------ [select / checkbox / radio auto_version_id] :(
		$sucursal_id = (int)$this->input->post('sucursal_id');
		$vendedores=new Admin();
		$config=array();
		$q = $vendedores->get_vendedores($config);
		$q->addWhere('sucursal_id = ?',$sucursal_id);
		$config=array();
		$config['fields'] = array('admin_field_nombre','admin_field_apellido');
		$config['select'] = TRUE;

		//------------ [fin select / checkbox / radio auto_version_id]

		$this->load->view('backend/_inc_admin_vendedor_id_view',array(
				'vendedor_id'=>$this->_create_html_options($q, $config))
				);
	}

	function get_recepcionistas()
	{
		//------------ [select / checkbox / radio auto_version_id] :(
		$sucursal_id = (int)$this->input->post('sucursal_id');
		$vendedores=new Admin();
		$config=array();
		$q = $vendedores->get_recepcionistas($config);
		$q->addWhere('sucursal_id = ?',$sucursal_id);
		$config=array();
		$config['fields'] = array('admin_field_nombre','admin_field_apellido');
		$config['select'] = TRUE;

		//------------ [fin select / checkbox / radio auto_version_id]

		$this->load->view('backend/_inc_admin_recepcionista_id_view',array(
				'recepcionista_id'=>$this->_create_html_options($q, $config))
				);
	}

	function get_tecnicos()
	{
		//------------ [select / checkbox / radio auto_version_id] :(
		$sucursal_id = (int)$this->input->post('sucursal_id');
		$vendedores=new Admin();
		$config=array();
		$q = $vendedores->get_tecnicos($config);
		$q->addWhere('sucursal_id = ?',$sucursal_id);
		$config=array();
		$config['fields'] = array('admin_field_nombre','admin_field_apellido');
		$config['select'] = TRUE;

		//------------ [fin select / checkbox / radio auto_version_id]

		$this->load->view('backend/_inc_admin_tecnico_id_view',array(
				'tecnico_id'=>$this->_create_html_options($q, $config))
				);
	}


	function get_unidad_tsi($string_unidad = FALSE,$string_vin=FALSE, $tipo_servicio = FALSE)
	{


		#tomo datos de la unidad
		$tsi=new Tsi();
		$q = $tsi->get_all();
		$q->addWhere('unidad_field_unidad = ?',$string_unidad);
		$q->addWhere('unidad_field_vin = ?',$string_vin);
		if(is_numeric($tipo_servicio))
		{
			$q->addWhere('tsi_tipo_servicio_id = ?',$tipo_servicio);
		}
		$resultado=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		$this->load->view('backend/_unidad_tsi_datos_inc_view',array('tsi'=>$resultado));
	}

	function get_has_pdi($string_unidad = FALSE,$string_vin=FALSE)
	{

		$resultado = 'false';
		#tomo datos de la unidad
		$tsi=new Tsi();
		$q = $tsi->get_all();
		$q->addWhere('unidad_field_unidad = ?',$string_unidad);
		$q->addWhere('unidad_field_vin = ?',$string_vin);
		$q->addWhere('tsi_tipo_servicio_id = ?',4); //PDI

		$registro = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
		if($registro)
		{
			$resultado = 'true';
		}

		$this->output->set_output($resultado);


	}
	
	function get_has_tarjeta_garantia($string_unidad = FALSE,$string_vin=FALSE)
	{

		$resultado = 'false';
		$q = Doctrine_Query::create()
			->from('Tarjeta_Garantia Tarjeta_Garantia')
			->leftJoin('Tarjeta_Garantia.Unidad Unidad')
			->where('Unidad.unidad_field_unidad = ?',$string_unidad)
			->addWhere('Unidad.unidad_field_vin = ?',$string_vin)
			->addWhere('Tarjeta_Garantia.tarjeta_garantia_estado_id = ?',2);
		
		if($q->count()==1)
		{
			$resultado = 'true';
		}

		$this->output->set_output($resultado);
	}


	function get_reclamo_garantia_codigo_defecto_seccion()
	{

		if($this->input->post('seccion_id')>0)
		{
			$codigo_defecto = new Reclamo_Garantia_Codigo_Defecto();
			$q = $codigo_defecto->get_all();
			$q->addWhere('reclamo_garantia_codigo_defecto_seccion_id = ?',$this->input->post('seccion_id'));
			$q->orderBy('id');
			$result=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$resultado = $this->load->view('backend/miniviews/buscador_codigo_defecto_miniview',array('defectos'=>$result),TRUE);
		}else{
			$codigo_defecto = new Reclamo_Garantia_Codigo_Defecto_Seccion();
			$q = $codigo_defecto->get_all();
			$q->orderBy('reclamo_garantia_codigo_defecto_seccion_field_desc');
			$result=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			$resultado = $this->load->view('backend/miniviews/buscador_codigo_defecto_miniview',array('secciones'=>$result),TRUE);
		}

		$this->output->set_output(json_encode($resultado));
	}

	function get_reclamo_garantia_codigo_sintoma_seccion()
	{

		$secciones = array();
		$sintomas = array();

		$codigo_sintoma = new Reclamo_Garantia_Codigo_Sintoma_Seccion();
		$q = $codigo_sintoma->get_all();
		$q->addWhere('reclamo_garantia_codigo_sintoma_seccion_field_padre_id = ?',$this->input->post('seccion_id'));
		$q->orderBy('reclamo_garantia_codigo_sintoma_seccion_field_desc');
		$secciones=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);

		if($this->input->post('seccion_id')>0)
		{
			$codigo_sintoma = new Reclamo_Garantia_Codigo_Sintoma();
			$q = $codigo_sintoma->get_all();
			$q->addWhere('reclamo_garantia_codigo_sintoma_seccion_id = ?',$this->input->post('seccion_id'));
			$q->orderBy('reclamo_garantia_codigo_sintoma_field_desc');
			$sintomas=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		}



		$resultado = $this->load->view('backend/miniviews/buscador_codigo_sintoma_miniview',array(	'secciones'=>$secciones,
																									'sintomas'=>$sintomas)
																									,TRUE
									);

		$this->output->set_output(json_encode($resultado));
	}

	function get_frt_seccion()
	{
		$secciones 	= array();
		$frts		= array();
		$unidad = new Unidad();
		$q = $unidad->get_all();
		$q->addWhere('unidad_field_vin = ?',$this->input->post('vin'));
		$resultado = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
		if($resultado)
		{

			//busco secciones
			$frt_seccion = new Frt_Seccion();
			$q = $frt_seccion->get_all();
			if(strlen($this->input->post('seccion_id'))==0)
			{
				$q->addWhere('frt_seccion_field_padre_id IS NULL');
			}
			else
			{
				$q->addWhere('frt_seccion_field_padre_id = ?',$this->input->post('seccion_id'));
			}
			/*
			if(strlen($this->input->post('seccion_id'))==3)
			{
				 $q->leftJoin('Frt_Seccion.Frt_Hora Frt_Hora ON Frt_Seccion.id = Frt_Hora.frt_seccion_id');
			}
			*/
			$q->orderBy('id');
			$secciones=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);


			$seccion_actual = array();
			/*
			if(strlen($this->input->post('seccion_id'))>0)
			{
				#busco la seccion que esta parado
				$q = $frt_seccion->get_all();
				$q->addWhere('id = ?',$this->input->post('seccion_id'));
				$q->limit(1);
				$seccion_actual=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);

			}
			*/


			$seccion_anterior = array();
			/*
			if(strlen($this->input->post('seccion_id'))>1)
			{
				#busco la seccion anterior
				$q = $frt_seccion->get_all();
				$q->addWhere('frt_seccion_field_padre_id = ?',$this->input->post('seccion_id'));
				$q->limit(1);
				$seccion_anterior=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
				print_r($seccion_anterior);
			}
			*/





			//busco frts
			$frt_hora = new Frt_Hora();
			$q = $frt_hora->get_all();
			$q->addWhere('frt_seccion_id = ?',$this->input->post('seccion_id'));
			$q->addWhere('auto_anio_id = ?',$resultado['Auto_Anio']['id']);
			$q->addWhere('auto_modelo_id = ?',$resultado['Auto_Version']['auto_modelo_id']);
			$q->orderBy('frt_id');



			$frts=$q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);



			$output = $this->load->view('backend/miniviews/buscador_frt_miniview',array(	'secciones'=>$secciones,
																							'frts'=>$frts,
																							'seccion_anterior'=>$seccion_anterior,
																							'seccion_actual'=>$seccion_actual
																							)
																							,TRUE
									);

			$this->output->set_output(json_encode($output));
		}else{
			$this->output->set_output(json_encode(FALSE));
		}

	}

	function get_frt()
	{
		$secciones 	= array();
		$frts		= array();
		$unidad = new Frt();
		$q = $unidad->get_all();
		$q->addWhere('id = ?',$this->input->post('frt_id'));
		$resultado = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
		if($resultado)
		{
			$this->output->set_output(json_encode(TRUE));
		}else{
			$this->output->set_output(json_encode(FALSE));
		}

	}



}
