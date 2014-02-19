<?php
define('ID_SECCION',3030);

class Tsi_Encuesta_Satisfaccion_Reporte_Main extends Backend_Controller {
	
	var $sucursal = TRUE;

	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
	
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(
										
										'MATCH( 
												unidad_field_unidad,
												unidad_field_vin,
												unidad_field_motor,
												unidad_field_patente,
												cliente_sucursal_field_nombre,
												cliente_sucursal_field_apellido,
												cliente_sucursal_field_razon_social,
												cliente_sucursal_field_email
										) against (? IN BOOLEAN MODE)'
										
										), //definir campos a buscar
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>FALSE,
				 
			),
		//solo para filtrar
		
		//--------------------------------------[comun unidades]
		'unidad_field_unidad'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_vin'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>110,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'unidad_field_motor'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>80,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_patente'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'unidad_field_codigo_de_llave'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'unidad_field_codigo_de_radio'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'unidad_field_oblea'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'unidad_field_descripcion_sap'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'unidad_field_material_sap'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'unidad_field_certificado'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'unidad_field_formulario_12'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'unidad_field_formulario_01'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		//--------------------------------------[comun unidades]
		
			
		'auto_modelo_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		
			
		'auto_modelo_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'auto_version_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
			),
		
		'auto_version_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>40,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'auto_transmision_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'auto_transmision_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),

		'auto_anio_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),

		'auto_anio_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'unidad_codigo_interno_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_codigo_interno_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_sucursal_field_nombre'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
			),
		'cliente_sucursal_field_apellido'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
			),
		'cliente_sucursal_field_razon_social'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
			),
		
		
		'documento_tipo_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
			),
		'cliente_field_numero_documento'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'cliente_codigo_interno_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		'cliente_codigo_interno_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		'cliente_sucursal_field_email'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
			),
		
		'ciudad_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
			),
		'provincia_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
			),
		
		'sucursal_id'=>
			array(
				 'sql_filter'	=>array('TSI.sucursal_id'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'sucursal_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'tsi_field_fecha_de_egreso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'tsi_field_fecha_de_egreso_inicial'=>
			array(
				 'sql_filter'	=>array('tsi_field_fecha_de_egreso >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'tsi_field_fecha_de_egreso_final'=>
			array(
				 'sql_filter'	=>array('tsi_field_fecha_de_egreso <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'tsi_tipo_servicio_id'=>
			array(
				 'sql_filter'	=>array('TSI.sucursal_id'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'tsi_tipo_servicio_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		'tsi_field_admin_recepcionista_id'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		
		'tsi_field_admin_tecnico_id'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		

		
		
		
		
		'tsi_encuesta_satisfaccion_field_fechahora_alta'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		'tsi_encuesta_satisfaccion_field_fechahora_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_encuesta_satisfaccion_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'tsi_encuesta_satisfaccion_field_fechahora_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_encuesta_satisfaccion_field_fechahora_alta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		

/*		
		//para descargar
		'tsi_encuesta_satisfaccion_adjunto'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'		=>TRUE,
				 'rules'		=>FALSE,
				 
			),
		
*/
		
		
		//--------- preguntas
		
		'tsi_encuesta_satisfaccion_field_pregunta_01'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_01a'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_02a'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_02b'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_02c'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_02d'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_02e'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_02f'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_03a'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_03b'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_03c'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_04a'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_04b'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_04c'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_04d'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_04e'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_05'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_06'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_06a'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_06b'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_06b_otra'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_07a'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_07b'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_07c'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_pregunta_08'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		/*
		'tsi_encuesta_satisfaccion_field_pregunta_08bis'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		*/
		'tsi_encuesta_satisfaccion_field_pregunta_09'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		/*
		'tsi_encuesta_satisfaccion_field_pregunta_09bis'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		*/
		'tsi_encuesta_satisfaccion_field_comentarios'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		//--------- preguntas
		
		
		
		
		
		'tsi_encuesta_satisfaccion_field_indice_capacidad'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>true,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_indice_interpersonal'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>true,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		'tsi_encuesta_satisfaccion_field_indice_calidad'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>true,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		
		
		
		);
    
    function __construct()
    {
        parent::__construct();	
    }

   function index()
	{	
		
	
		
		
		//-------------------------[buscador ]
		
		$config['campos'] = $this->default_valid_fields;
		
		//borramos en caso de que haya algun filtro previo
		$this->session->unset_userdata('filtro_'.$this->router->class);
				
		//->filtros del buscador por post
		if($this->input->post('_filtro'))
		{
			if($this->_validar_filtros())
			{ //validamos los datos que envia...
				$filtro=$this->_create_filters($config['campos']);
					
					#--------------------------
				if(count($filtro)>0)
				{
						//ya no se si me gusta el ajax
					$this->session->set_userdata('filtro_'.$this->router->class,$filtro);
				}
					#--------------------------
			}
		
			$this->_report();
		
		}
		
		$this->_view();
		
	}
	
	#se que es una cabeceada esto pero los numeros no dan contra el sistema viejo (buscar .old.php)
	/*
		se aplica la siguente logica
		si la pregunta viene 0 se toma que no contesto y no se toma en el promedio (que vivos)
		1 contesto y 0% al promedio
		2 contesto y 25% al promedio
		----
		5 contesto y 100% al promedio
		se suman todos los puntajes, se resta la cantidad de respuestas, se lo multiplica por 25% y ahi esan los porcentajes
	*/
	private function _report()
	{
		//$this->output->enable_profiler(TRUE);
		
		$this->_create_query();
		
		if($this->query->count()>0)
		{
			
			$stat_filtro = $this->_stat($this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY));
			//query full, para comparar con los demas concesionarios...
			$sucursales = $this->input->post('sucursal_id');
			if(is_array($sucursales) && count($sucursales)>0)
			{
				
				$filtro_original=$this->session->userdata('filtro_'.$this->router->class);
				$nuevo_filtro = $filtro_original;
				foreach($nuevo_filtro as $k=>$where)
				{
					if(is_array($where) AND isset($where[0]) AND $where[0] == 'TSI.sucursal_id')
					{
						unset($nuevo_filtro[$k]);
					}	
				}
				$this->session->set_userdata('filtro_'.$this->router->class,$nuevo_filtro);
				$this->_create_query();
				//vuelvo el filtro para atras
				$this->session->set_userdata('filtro_'.$this->router->class,$filtro_original);
				$stat_distribuidor = $this->_stat($this->query->execute(array(),Doctrine_Core::HYDRATE_ARRAY));
			}
			else
			{
				$stat_distribuidor = $stat_filtro;
			}
			
			
			$this->template['stat_filtro'] 			= $stat_filtro;
			$this->template['stat_distribuidor']	= $stat_distribuidor;
			
			
			
		}
		else
		{
			$this->template['sin_resultados'] = TRUE;
		}
	}
	
	
	private function _stat($result)
	{
			
			$total = 0;
			$pregunta_1 = array('si'=>number_format( 0, 1, '.', ''),
								'no'=>number_format( 0, 1, '.', ''),
								'nsnc'=>number_format( 0, 1, '.', '')
			);
			
			$pregunta_1a_suma = 0;
			$pregunta_1a = number_format( 0, 1, '.', '');
			$pregunta_1a_total = 0;
			
			$pregunta_2a_suma = 0;
			$pregunta_2a = number_format( 0, 1, '.', '');
			$pregunta_2a_total = 0;
			
			$pregunta_2b_suma = 0;
			$pregunta_2b = number_format( 0, 1, '.', '');
			$pregunta_2b_total = 0;
			
			$pregunta_2c_suma = 0;
			$pregunta_2c = number_format( 0, 1, '.', '');
			$pregunta_2c_total = 0;
			
			$pregunta_2d_suma = 0;
			$pregunta_2d = number_format( 0, 1, '.', '');
			$pregunta_2d_total = 0;
			
			$pregunta_2e_suma = 0;
			$pregunta_2e = number_format( 0, 1, '.', '');
			$pregunta_2e_total = 0;
			
			$pregunta_2f_suma = 0;
			$pregunta_2f = number_format( 0, 1, '.', '');
			$pregunta_2f_total = 0;
			
			$pregunta_3a_suma = 0;
			$pregunta_3a = number_format( 0, 1, '.', '');
			$pregunta_3a_total = 0;
			
			$pregunta_3b_suma = 0;
			$pregunta_3b = number_format( 0, 1, '.', '');
			$pregunta_3b_total = 0;
			
			$pregunta_3c_suma = 0;
			$pregunta_3c = number_format( 0, 1, '.', '');
			$pregunta_3c_total = 0;
			
			$pregunta_4a_suma = 0;
			$pregunta_4a = number_format( 0, 1, '.', '');
			$pregunta_4a_total = 0;
			
			$pregunta_4b_suma = 0;
			$pregunta_4b = number_format( 0, 1, '.', '');
			$pregunta_4b_total = 0;
			
			$pregunta_4c_suma = 0;
			$pregunta_4c = number_format( 0, 1, '.', '');
			$pregunta_4c_total = 0;
			
			$pregunta_4d_suma = 0;
			$pregunta_4d = number_format( 0, 1, '.', '');
			$pregunta_4d_total = 0;
			
			$pregunta_4e_suma = 0;
			$pregunta_4e = number_format( 0, 1, '.', '');
			$pregunta_4e_total = 0;
			
			$pregunta_5_suma = 0;
			$pregunta_5 = number_format( 0, 1, '.', '');
			$pregunta_5_total = 0;
			
			$pregunta_6 = array('si'=>number_format( 0, 1, '.', ''),
								'no'=>number_format( 0, 1, '.', ''),
								'nsnc'=>number_format( 0, 1, '.', '')
			);
			$pregunta_6a = array(	'una'=>number_format( 0, 1, '.', ''),
									'dos'=>number_format( 0, 1, '.', ''),
									'tres'=>number_format( 0, 1, '.', ''),
									'cuatro'=>number_format( 0, 1, '.', ''),
									'cinco'=>number_format( 0, 1, '.', ''),
									'seis'=>number_format( 0, 1, '.', ''),
									'nsnc'=>number_format( 0, 1, '.', '')
			);
			$pregunta_6b_suma = 0;
			$pregunta_6a_total = 0;
			$pregunta_6b = array(	'uno'=>number_format( 0, 1, '.', ''),
									'dos'=>number_format( 0, 1, '.', ''),
									'tres'=>number_format( 0, 1, '.', ''),
									'cuatro'=>number_format( 0, 1, '.', ''),
									'nsnc'=>number_format( 0, 1, '.', '')
			);
			$pregunta_6b_suma = 0;
			$pregunta_6b_total = 0;
			
			$pregunta_7a_suma = 0;
			$pregunta_7a = number_format( 0, 1, '.', '');
			$pregunta_7a_total = 0;
			
			$pregunta_7b_suma = 0;
			$pregunta_7b = number_format( 0, 1, '.', '');
			$pregunta_7b_total = 0;
			
			$pregunta_7c_suma = 0;
			$pregunta_7c = number_format( 0, 1, '.', '');
			$pregunta_7c_total = 0;
			
			$pregunta_8_suma = 0;
			$pregunta_8 = number_format( 0, 1, '.', '');
			$pregunta_8_total = 0;
			
			$pregunta_9_suma = 0;
			$pregunta_9 = number_format( 0, 1, '.', '');
			$pregunta_9_total = 0;
			
			
			$indice_capacidad = number_format( 0, 1, '.', '');
			$indice_capacidad_total = 0;
			
			$indice_interpersonal = number_format( 0, 1, '.', '');
			$indice_interpersonal_total = 0;
			
			$indice_calidad = number_format( 0, 1, '.', '');
			$indice_calidad_total = 0;
			
			
			foreach($result as $row)
			{
				++$total;
				
				//pregunta_01 ¿solicitó usted su turno con anticipación? 2si 1no !=nsnc
				if($row['tsi_encuesta_satisfaccion_field_pregunta_01'] == 1)
				{
					++$pregunta_1['no'];
				}
				else if($row['tsi_encuesta_satisfaccion_field_pregunta_01'] == 2)
				{
					++$pregunta_1['si'];
				}
				else
				{
					++$pregunta_1['nsnc'];
				}
				//-----------------------------------------------------------------------
				
				
				//pregunta_01a Cuán satisfecho está usted con la prontitud o conveniencia del turno que le dio su Concesionario
				if($row['tsi_encuesta_satisfaccion_field_pregunta_01a']>0 && $row['tsi_encuesta_satisfaccion_field_pregunta_01'] == 2)
				{
					$pregunta_1a_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_01a'];
					++$pregunta_1a_total;
					$pregunta_1a+= ($row['tsi_encuesta_satisfaccion_field_pregunta_01a']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_02a Prontitud en el saludo y en tomar su orden de servicio
				if($row['tsi_encuesta_satisfaccion_field_pregunta_02a']>0)
				{
					$pregunta_2a_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_02a'];
					++$pregunta_2a_total;
					$pregunta_2a+= ($row['tsi_encuesta_satisfaccion_field_pregunta_02a']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_02b
				if($row['tsi_encuesta_satisfaccion_field_pregunta_02b']>0)
				{
					$pregunta_2b_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_02b'];
					++$pregunta_2b_total;
					$pregunta_2b+= ($row['tsi_encuesta_satisfaccion_field_pregunta_02b']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_02c
				if($row['tsi_encuesta_satisfaccion_field_pregunta_02c']>0)
				{
					$pregunta_2c_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_02c'];
					++$pregunta_2c_total;
					$pregunta_2c+= ($row['tsi_encuesta_satisfaccion_field_pregunta_02c']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_02d
				if($row['tsi_encuesta_satisfaccion_field_pregunta_02d']>0)
				{
					$pregunta_2d_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_02d'];
					++$pregunta_2d_total;
					$pregunta_2d+= ($row['tsi_encuesta_satisfaccion_field_pregunta_02d']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_02e
				if($row['tsi_encuesta_satisfaccion_field_pregunta_02e']>0)
				{
					$pregunta_2e_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_02e'];
					++$pregunta_2e_total;
					$pregunta_2e+= ($row['tsi_encuesta_satisfaccion_field_pregunta_02e']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_02f
				if($row['tsi_encuesta_satisfaccion_field_pregunta_02f']>0)
				{
					$pregunta_2f_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_02f'];
					++$pregunta_2f_total;
					$pregunta_2f+= ($row['tsi_encuesta_satisfaccion_field_pregunta_02f']-1) * 25; //5 100%, 4 80% etc	
				}
				//------------------------------------------------------------------------
				
				//pregunta_03a El tiempo que demoraron para realizar el Servicio o Reparación
				if($row['tsi_encuesta_satisfaccion_field_pregunta_03a']>0)
				{
					$pregunta_3a_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_03a'];
					++$pregunta_3a_total;
					$pregunta_3a+= ($row['tsi_encuesta_satisfaccion_field_pregunta_03a']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_03b 
				if($row['tsi_encuesta_satisfaccion_field_pregunta_03b']>0)
				{
					$pregunta_3b_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_03b'];
					++$pregunta_3b_total;
					$pregunta_3b+= $this->formatea_numero_tsi(($row['tsi_encuesta_satisfaccion_field_pregunta_03b']-1) * 25); //5 100%, 4 80% etc	
				}
				//------------------------------------------------------------------------
				
				//pregunta_03c 
				if($row['tsi_encuesta_satisfaccion_field_pregunta_03c']>0)
				{
					$pregunta_3c_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_03c'];
					++$pregunta_3c_total;
					$pregunta_3c+= ($row['tsi_encuesta_satisfaccion_field_pregunta_03c']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				
				//pregunta_04a Su vehículo estuvo cuando lo prometieron
				if($row['tsi_encuesta_satisfaccion_field_pregunta_04a']>0)
				{
					$pregunta_4a_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_04a'];
					++$pregunta_4a_total;
					$pregunta_4a+= ($row['tsi_encuesta_satisfaccion_field_pregunta_04a']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_04b
				if($row['tsi_encuesta_satisfaccion_field_pregunta_04b']>0)
				{
					$pregunta_4b_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_04b'];
					++$pregunta_4b_total;
					$pregunta_4b+= ($row['tsi_encuesta_satisfaccion_field_pregunta_04b']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_04c
				if($row['tsi_encuesta_satisfaccion_field_pregunta_04c']>0)
				{
					$pregunta_4c_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_04c'];
					++$pregunta_4c_total;
					$pregunta_4c+= ($row['tsi_encuesta_satisfaccion_field_pregunta_04c']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_04d
				if($row['tsi_encuesta_satisfaccion_field_pregunta_04d']>0)
				{
					$pregunta_4d_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_04d'];
					++$pregunta_4d_total;
					$pregunta_4d+= ($row['tsi_encuesta_satisfaccion_field_pregunta_04d']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_04e
				if($row['tsi_encuesta_satisfaccion_field_pregunta_04e']>0)
				{
					$pregunta_4e_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_04e'];
					++$pregunta_4e_total;
					$pregunta_4e+= ($row['tsi_encuesta_satisfaccion_field_pregunta_04e']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_05 ¿Después que llevó su Honda a casa, cuán satisfecho estuvo usted con la CALIDAD DEL TRABAJO REALIZADO?
				if($row['tsi_encuesta_satisfaccion_field_pregunta_05']>0)
				{
					$pregunta_5_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_05'];
					++$pregunta_5_total;
					$pregunta_5+= ($row['tsi_encuesta_satisfaccion_field_pregunta_05']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				
				//pregunta_06 Quedó usted SATISFECHO CON LA REPARACIÓN que le hicieron EN SU PRIMER VISITA ?
				if($row['tsi_encuesta_satisfaccion_field_pregunta_06'] == 1)
				{
					++$pregunta_6['no'];
				}
				else if($row['tsi_encuesta_satisfaccion_field_pregunta_06'] == 2)
				{
					++$pregunta_6['si'];
				}
				else
				{
					++$pregunta_6['nsnc'];
				}
				//-----------------------------------------------------------------------
				
				//pregunta 6a ¿Cuántas VISITAS ADICIONALES fueron requeridas?
				if($row['tsi_encuesta_satisfaccion_field_pregunta_06'] == 1) //no esta satisfecho...
				{
					
					++$pregunta_6a_total;
					
					if($row['tsi_encuesta_satisfaccion_field_pregunta_06a'] == 1)
					{
						++$pregunta_6a['una'];
					}
					else if($row['tsi_encuesta_satisfaccion_field_pregunta_06a'] == 2)
					{
						++$pregunta_6a['dos'];
					}
					else if($row['tsi_encuesta_satisfaccion_field_pregunta_06a'] == 3)
					{
						++$pregunta_6a['tres'];
					}
					else if($row['tsi_encuesta_satisfaccion_field_pregunta_06a'] == 4)
					{
						++$pregunta_6a['cuatro'];
					}
					else if($row['tsi_encuesta_satisfaccion_field_pregunta_06a'] == 5)
					{
						++$pregunta_6a['cinco'];
					}
					else if($row['tsi_encuesta_satisfaccion_field_pregunta_06a'] == 6)
					{
						++$pregunta_6a['seis'];
					}
					else
					{
						++$pregunta_6a['nsnc'];
					}
				}
				//-----------------------------------------------------------------------
				
				//pregunta 6b ¿Cuál de las siguientes frases describe de la mejor forma la razón por la cual usted necesitó REPETIR EL SERVICIO O VOLVER A HACER EL SERVICIO?
				if($row['tsi_encuesta_satisfaccion_field_pregunta_06'] == 1) //no esta satisfecho...
				{
					
					++$pregunta_6b_total;
					
					if($row['tsi_encuesta_satisfaccion_field_pregunta_06b'] == 1)
					{
						++$pregunta_6b['uno'];
					}
					else if($row['tsi_encuesta_satisfaccion_field_pregunta_06b'] == 2)
					{
						++$pregunta_6b['dos'];
					}
					else if($row['tsi_encuesta_satisfaccion_field_pregunta_06b'] == 3)
					{
						++$pregunta_6b['tres'];
					}
					else if($row['tsi_encuesta_satisfaccion_field_pregunta_06b'] == 4)
					{
						++$pregunta_6b['cuatro'];
					}
					else
					{
						++$pregunta_6b['nsnc'];
					}
				}
				//-----------------------------------------------------------------------
				
				//pregunta_7a Desempeño en la reparación
				if($row['tsi_encuesta_satisfaccion_field_pregunta_07a']>0)
				{
					$pregunta_7a_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_07a'];
					++$pregunta_7a_total;
					$pregunta_7a+= ($row['tsi_encuesta_satisfaccion_field_pregunta_07a']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_7b
				if($row['tsi_encuesta_satisfaccion_field_pregunta_07b']>0)
				{
					$pregunta_7b_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_07b'];
					++$pregunta_7b_total;
					$pregunta_7b+= ($row['tsi_encuesta_satisfaccion_field_pregunta_07b']-1) * 25; //5 100%, 4 80% etc
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_7c
				if($row['tsi_encuesta_satisfaccion_field_pregunta_07c']>0)
				{
					$pregunta_7c_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_07c'];
					++$pregunta_7c_total;
					$pregunta_7c+= ($row['tsi_encuesta_satisfaccion_field_pregunta_07c']-1) * 25; //5 100%, 4 80% etc
				}
				//------------------------------------------------------------------------
				
				//pregunta_8 //Basándose en la experiencia que usted tuvo con el Servicio ¿CUAN PROBABLE SERIA QUE USTED LO RECOMIENDE a sus amigos o parientes?
				if($row['tsi_encuesta_satisfaccion_field_pregunta_08']>0)
				{
					$pregunta_8_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_08'];
					++$pregunta_8_total;
					$pregunta_8+= $row['tsi_encuesta_satisfaccion_field_pregunta_08'] * 25; //aca son 4 estrellas....
					
				}
				//------------------------------------------------------------------------
				
				//pregunta_9 Basándose en su experiencia en general como dueño y en la experiencia que obtuvo en el Servicio de este automóvil ¿CUAN PROBABLE SERIA QUE USTED VUELVA A COMPRAR OTRO HONDA?
				if($row['tsi_encuesta_satisfaccion_field_pregunta_09']>0)
				{
					$pregunta_9_suma+= $row['tsi_encuesta_satisfaccion_field_pregunta_09'];
					++$pregunta_9_total;
					$pregunta_9+= $row['tsi_encuesta_satisfaccion_field_pregunta_09'] * 25; //aca son 4 estrellas....
					
				}
				//------------------------------------------------------------------------
				
				
				++$indice_capacidad_total;
				$indice_capacidad+= $row['tsi_encuesta_satisfaccion_field_indice_capacidad'];
				
				
				
				++$indice_interpersonal_total;
				$indice_interpersonal+= $row['tsi_encuesta_satisfaccion_field_indice_interpersonal'];
				
				
				++$indice_calidad_total;
				$indice_calidad+= $row['tsi_encuesta_satisfaccion_field_indice_calidad'];
				
				
				
			}
			
			
			$pregunta_1['si']	= $this->formatea_numero_tsi( ($pregunta_1['si']*100)	/$total);
			$pregunta_1['no']	= $this->formatea_numero_tsi( ($pregunta_1['no']*100) 	/ $total);
			$pregunta_1['nsnc'] = $this->formatea_numero_tsi( ($pregunta_1['nsnc']*100)	/ $total);
			
			if($pregunta_1a_total>0)
				$pregunta_1a = $this->formatea_numero_tsi( ($pregunta_1a*100)	/ ($pregunta_1a_total *5*20) );
			
			if($pregunta_2a_total>0)
				$pregunta_2a = $this->formatea_numero_tsi( ($pregunta_2a*100)	/ ($pregunta_2a_total *5*20));
			if($pregunta_2b_total>0)
				$pregunta_2b = $this->formatea_numero_tsi( ($pregunta_2b*100)	/ ($pregunta_2b_total *5*20));
			if($pregunta_2c_total>0)
				$pregunta_2c = $this->formatea_numero_tsi( ($pregunta_2c*100)	/ ($pregunta_2c_total *5*20));
			if($pregunta_2d_total>0)
				$pregunta_2d = $this->formatea_numero_tsi( ($pregunta_2d*100)	/ ($pregunta_2d_total *5*20));
			if($pregunta_2e_total>0)
				$pregunta_2e = $this->formatea_numero_tsi( ($pregunta_2e*100)	/ ($pregunta_2e_total *5*20));
			if($pregunta_2f_total>0)
				$pregunta_2f = $this->formatea_numero_tsi( ($pregunta_2f*100)	/ ($pregunta_2f_total *5*20));
			
			if($pregunta_3a_total>0)
				$pregunta_3a = $this->formatea_numero_tsi( ($pregunta_3a*100)	/ ($pregunta_3a_total *5*20));
			if($pregunta_3b_total>0)
				$pregunta_3b = $this->formatea_numero_tsi( ($pregunta_3b*100)	/ ($pregunta_3b_total *5*20));
			if($pregunta_3c_total>0)
				$pregunta_3c = $this->formatea_numero_tsi( ($pregunta_3c*100)	/ ($pregunta_3c_total *5*20));
			
			if($pregunta_4a_total>0)
				$pregunta_4a = $this->formatea_numero_tsi( ($pregunta_4a*100)	/ ($pregunta_4a_total *5*20));
			if($pregunta_4b_total>0)
				$pregunta_4b = $this->formatea_numero_tsi( ($pregunta_4b*100)	/ ($pregunta_4b_total *5*20));
			if($pregunta_4c_total>0)
				$pregunta_4c = $this->formatea_numero_tsi( ($pregunta_4c*100)	/ ($pregunta_4c_total *5*20));
			if($pregunta_4d_total>0)
				$pregunta_4d = $this->formatea_numero_tsi( ($pregunta_4d*100)	/ ($pregunta_4d_total *5*20));
			if($pregunta_4e_total>0)
				$pregunta_4e = $this->formatea_numero_tsi( ($pregunta_4e*100)	/ ($pregunta_4e_total *5*20));
			
			if($pregunta_5_total>0)
				$pregunta_5 = $this->formatea_numero_tsi( ($pregunta_5*100)	/ ($pregunta_5_total *5*20));
			
			$pregunta_6['si']	= $this->formatea_numero_tsi( ($pregunta_6['si']*100) 	/ $total);
			$pregunta_6['no']	= $this->formatea_numero_tsi( ($pregunta_6['no']*100) 	/ $total);
			$pregunta_6['nsnc'] = $this->formatea_numero_tsi( ($pregunta_6['nsnc']*100)	/ $total);
			
			if($pregunta_6a_total>0)
			{
				$pregunta_6a['una']		= $this->formatea_numero_tsi( ($pregunta_6a['una']*100) 	/ $pregunta_6a_total);
				$pregunta_6a['dos']		= $this->formatea_numero_tsi( ($pregunta_6a['dos']*100) 	/ $pregunta_6a_total);
				$pregunta_6a['tres']	= $this->formatea_numero_tsi( ($pregunta_6a['tres']*100)	/ $pregunta_6a_total);
				$pregunta_6a['cuatro']	= $this->formatea_numero_tsi( ($pregunta_6a['cuatro']*100) / $pregunta_6a_total);
				$pregunta_6a['cinco']	= $this->formatea_numero_tsi( ($pregunta_6a['cinco']*100) 	/ $pregunta_6a_total);
				$pregunta_6a['seis']	= $this->formatea_numero_tsi( ($pregunta_6a['seis']*100) 	/ $pregunta_6a_total);
				$pregunta_6a['nsnc']	= $this->formatea_numero_tsi( ($pregunta_6a['nsnc']*100) 	/ $pregunta_6a_total);
			}
			
			if($pregunta_6b_total>0)
			{
				$pregunta_6b['uno']			= $this->formatea_numero_tsi( ($pregunta_6b['uno']*100) 		/ $pregunta_6b_total);
				$pregunta_6b['dos']			= $this->formatea_numero_tsi( ($pregunta_6b['dos']*100) 		/ $pregunta_6b_total);
				$pregunta_6b['tres']		= $this->formatea_numero_tsi( ($pregunta_6b['tres']*100) 	/ $pregunta_6b_total);
				$pregunta_6b['cuatro']		= $this->formatea_numero_tsi( ($pregunta_6b['cuatro']*100) 	/ $pregunta_6b_total);
				$pregunta_6b['nsnc']		= $this->formatea_numero_tsi( ($pregunta_6b['nsnc']*100) 	/ $pregunta_6b_total);
			}
			
			
			if($pregunta_7a_total>0)
				$pregunta_7a = $this->formatea_numero_tsi( ($pregunta_7a*100)	/ ($pregunta_7a_total *5*20));
			if($pregunta_7b_total>0)
				$pregunta_7b = $this->formatea_numero_tsi( ($pregunta_7b*100)	/ ($pregunta_7b_total *5*20));
			if($pregunta_7c_total>0)
				$pregunta_7c = $this->formatea_numero_tsi( ($pregunta_7c*100)	/ ($pregunta_7c_total *5*20));
			
			
			if($pregunta_8_total>0)
				$pregunta_8 = $this->formatea_numero_tsi( ($pregunta_8*100)	/ ($pregunta_8_total *4*25));
			if($pregunta_9_total>0)
				$pregunta_9 = $this->formatea_numero_tsi( ($pregunta_9*100)	/ ($pregunta_9_total *4*25));
			
			//nobody's waiting for me, on the other side
			
			if($indice_capacidad_total>0)
			$indice_capacidad		= $this->formatea_numero_tsi( $indice_capacidad/$indice_capacidad_total);
			if($indice_interpersonal_total>0)
			$indice_interpersonal	= $this->formatea_numero_tsi( $indice_interpersonal/$indice_interpersonal_total);
			if($indice_calidad_total>0)
			$indice_calidad			= $this->formatea_numero_tsi( $indice_calidad/$indice_calidad_total);
			
			
			$indice_capacidad=0;
			if($pregunta_1a_total>0)
				$indice_capacidad+=(($pregunta_1a_suma-$pregunta_1a_total)*0.7*25)/$pregunta_1a_total;
			if($pregunta_2a_total>0)
				$indice_capacidad+=(($pregunta_2a_suma-$pregunta_2a_total)*1.4*25)/$pregunta_2a_total;
			if($pregunta_3a_total>0)
				$indice_capacidad+=(($pregunta_3a_suma-$pregunta_3a_total)*0.95*25)/$pregunta_3a_total;
			if($pregunta_3b_total>0)
				$indice_capacidad+=(($pregunta_3b_suma-$pregunta_3b_total)*0.55*25)/$pregunta_3b_total;
			if($pregunta_3c_total>0)
				$indice_capacidad+=(($pregunta_3c_suma-$pregunta_3c_total)*0.55*25)/$pregunta_3c_total;
			if($pregunta_4a_total>0)
				$indice_capacidad+=(($pregunta_4a_suma-$pregunta_4a_total)*0.8*25)/$pregunta_4a_total;
			if($pregunta_4b_total>0)
				$indice_capacidad+=(($pregunta_4b_suma-$pregunta_4b_total)*0.9*25)/$pregunta_4b_total;
			if($pregunta_4e_total>0)
				$indice_capacidad+=(($pregunta_4e_suma-$pregunta_4e_total)*0.95*25)/$pregunta_4e_total;
			
			$indice_capacidad = ($indice_capacidad/680)*100;
			$indice_capacidad = $this->formatea_numero_tsi($indice_capacidad);
			
			$indice_interpersonal=0;
			if($pregunta_2b_total>0)
				$indice_interpersonal+=(($pregunta_2b_suma-$pregunta_2b_total)*0.6*25)/$pregunta_2b_total;
			if($pregunta_2c_total>0)
				$indice_interpersonal+=(($pregunta_2c_suma-$pregunta_2c_total)*0.7*25)/$pregunta_2c_total;
			if($pregunta_2d_total>0)
				$indice_interpersonal+=(($pregunta_2d_suma-$pregunta_2d_total)*0.7*25)/$pregunta_2d_total;
			if($pregunta_2e_total>0)
				$indice_interpersonal+=(($pregunta_2e_suma-$pregunta_2e_total)*0.65*25)/$pregunta_2e_total;
			if($pregunta_2f_total>0)
				$indice_interpersonal+=(($pregunta_2f_suma-$pregunta_2f_total)*0.65*25)/$pregunta_2f_total;
			if($pregunta_4c_total>0)
				$indice_interpersonal+=(($pregunta_4c_suma-$pregunta_4c_total)*0.5*25)/$pregunta_4c_total;
			if($pregunta_4d_total>0)
				$indice_interpersonal+=(($pregunta_4d_suma-$pregunta_4d_total)*0.5*25)/$pregunta_4d_total;
			if($pregunta_7b_total>0)
				$indice_interpersonal+=(($pregunta_7b_suma-$pregunta_7b_total)*0.7*25)/$pregunta_7b_total;
			
			$indice_interpersonal = ($indice_interpersonal/500)*100;
			$indice_interpersonal = $this->formatea_numero_tsi($indice_interpersonal);
			
			
			$indice_calidad=0;
			$indice_calidad = $indice_calidad + ( ($pregunta_5 * 20) / 100 ); 
			$indice_calidad = $indice_calidad + ( ($pregunta_6['si'] * 50) / 100 );
			$indice_calidad = $indice_calidad + ( ($pregunta_7a * 14) / 100 );
			$indice_calidad = $indice_calidad + ( ($pregunta_7c * 16) / 100 );
			$indice_calidad = $this->formatea_numero_tsi($indice_calidad);
			
			//------------
		
			$return = array();
			
			$return['total'] 			= $total;
			$return['pregunta_1'] 		= $pregunta_1;
			$return['pregunta_1a'] 		= $pregunta_1a;
			
			$return['pregunta_2a'] 		= $pregunta_2a;
			$return['pregunta_2b'] 		= $pregunta_2b;
			$return['pregunta_2c'] 		= $pregunta_2c;
			$return['pregunta_2d'] 		= $pregunta_2d;
			$return['pregunta_2e'] 		= $pregunta_2e;
			$return['pregunta_2f'] 		= $pregunta_2f;
			
			$return['pregunta_3a'] 		= $pregunta_3a;
			$return['pregunta_3b'] 		= $pregunta_3b;
			$return['pregunta_3c'] 		= $pregunta_3c;
			
			$return['pregunta_4a'] 		= $pregunta_4a;
			$return['pregunta_4b'] 		= $pregunta_4b;
			$return['pregunta_4c'] 		= $pregunta_4c;
			$return['pregunta_4d'] 		= $pregunta_4d;
			$return['pregunta_4e'] 		= $pregunta_4e;
			
			$return['pregunta_5'] 		= $pregunta_5;
			
			$return['pregunta_6'] 		= $pregunta_6;
			$return['pregunta_6a'] 		= $pregunta_6a;
			$return['pregunta_6b'] 		= $pregunta_6b;
			
			$return['pregunta_7a'] 		= $pregunta_7a;
			$return['pregunta_7b'] 		= $pregunta_7b;
			$return['pregunta_7c'] 		= $pregunta_7c;
			
			$return['pregunta_8'] 		= $pregunta_8;
			$return['pregunta_9'] 		= $pregunta_9;
			
			$return['indice_capacidad'] 	= $indice_capacidad;
			$return['indice_interpersonal'] = $indice_interpersonal;
			$return['indice_calidad'] 		= $indice_calidad;
			
			return $return;
			
	}
	
	
	// validation fields
	private function _validar_filtros() {		
		//-------------------------[valida datos del buscador]
		// validation rules
		
		$this->form_validation->set_rules('_buscador_general',$this->marvin->mysql_field_to_human('_buscador_general'),
			'trim'
		);
		
		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_fechahora_alta_inicial',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('tsi_encuesta_satisfaccion_field_fechahora_alta_final',$this->marvin->mysql_field_to_human('tsi_encuesta_satisfaccion_field_fechahora_alta_final'),
			'trim|my_form_date_reverse'
		);
		
		
		//---['unidad']
		$this->form_validation->set_rules('unidad_field_unidad',$this->marvin->mysql_field_to_human('unidad_field_unidad'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_vin',$this->marvin->mysql_field_to_human('unidad_field_vin'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_motor',$this->marvin->mysql_field_to_human('unidad_field_motor'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_codigo_de_llave',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_codigo_de_radio',$this->marvin->mysql_field_to_human('unidad_field_codigo_de_radio'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_patente',$this->marvin->mysql_field_to_human('unidad_field_patente'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_oblea',$this->marvin->mysql_field_to_human('unidad_field_oblea'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_material_sap',$this->marvin->mysql_field_to_human('unidad_field_material_sap'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_descripcion_sap',$this->marvin->mysql_field_to_human('unidad_field_descripcion_sap'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_certificado',$this->marvin->mysql_field_to_human('unidad_field_certificado'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_formulario_12',$this->marvin->mysql_field_to_human('unidad_field_formulario_12'),
			'trim'
		);
		$this->form_validation->set_rules('unidad_field_formulario_01',$this->marvin->mysql_field_to_human('unidad_field_formulario_01'),
			'trim'
		);
		
		//---['unidad']
		
		$this->form_validation->set_rules('cliente',$this->marvin->mysql_field_to_human('cliente'),
			'trim'
		);
		$this->form_validation->set_rules('cliente_field_numero_documento',$this->marvin->mysql_field_to_human('cliente_field_numero_documento'),
			'trim'
		);
		
		$this->form_validation->set_rules('tsi_field_fecha_de_egreso_inicial',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('tsi_field_fecha_de_egreso_final',$this->marvin->mysql_field_to_human('tsi_encuesta_seguimiento_field_fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		
		$this->form_validation->set_rules('sucursal_id[]',$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		
		$this->form_validation->set_rules('auto_modelo_id[]',$this->marvin->mysql_field_to_human('auto_modelo_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_version_id[]',$this->marvin->mysql_field_to_human('auto_version_id'),
			'trim'
		);
		
		
		return $this->form_validation->run();
		//-------------------------[/valida datos del buscador]
	}
	
	private function _view()
	{
		//-------------------------[vista generica]
		//$this->output->enable_profiler();
		
		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		$q->WhereIn(' id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = FALSE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]
		
		//------------ [select / checkbox / radio auto_modelo_id] :(
		$auto_modelo=new Auto_Modelo();
		$q = $auto_modelo->get_all();
		$q->addWhere(' auto_marca_id = ? ', 100); //honda
		$q->orderBy('auto_modelo_field_desc');
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_modelo_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_modelo_id]
		
		//------------ [select / checkbox / radio auto_version_id] :(
		$auto_version=new Auto_Version();
		$q = $auto_version->get_all();
		$q->addWhere('auto_marca_id = ?',100);
		$q->orderBy('auto_modelo_field_desc');
		$q->addOrderBy('auto_version_field_desc');
		$q->whereIn('auto_modelo_id',$this->input->post('auto_modelo_id'));
		$config=array();
		$config['fields'] = array('auto_modelo_field_desc','auto_version_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_version_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_version_id]
		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}
	
	//la llaman los _main
	public function _create_query()
	{
		
		//deja la query lista para usar en $this->query
		$objeto = new Tsi_Encuesta_Satisfaccion();
		$this->query = $objeto->get_report();
		$this->query->expireQueryCache(TRUE);
		$this->query->expireResultCache(TRUE); //borra la cache
		$this->flexigrid->validate_post();
		$this->flexigrid->build_query();
		
		if($this->sucursal)
		{
			$this->query->whereIn('TSI.sucursal_id',$this->session->userdata('sucursales'));
		}
		
		
		
		
	}
	
	function formatea_numero_tsi($numero){
	
		//$numero = number_format($numero,4);
		return number_format(round($numero, 2), 2, '.', '');
	}
}
