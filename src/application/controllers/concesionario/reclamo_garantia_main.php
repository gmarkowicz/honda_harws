<?php
define('ID_SECCION',3071);

class Reclamo_Garantia_Main extends Backend_Controller {
		
	var $dias_default = 30;
	
	//filtra por sucursal?
	var $sucursal = FALSE;
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
	
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(
										
										'MATCH( 
												unidad_field_unidad,
												unidad_field_vin,
												unidad_field_material_sap
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
		
		'reclamo_id'=>
			array(
				 'sql_filter'	=>array('RECLAMO_GARANTIA.id = ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE
				 
			),
		
		
		
		//------------------[unidad]
		'unidad_field_unidad'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		'unidad_field_vin'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>TRUE,
				 'width'		=>120,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
			
		'unidad_field_motor'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
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
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_codigo_de_radio'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_material_sap'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_descripcion_sap'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),

		'reclamo_garantia_version_field_descripcion_sintoma'=>
			array(
				 'sql_filter'	=>array(),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
            
		'reclamo_garantia_version_field_descripcion_diagnostico'=>
			array(
				 'sql_filter'	=>array(),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
            
		'reclamo_garantia_version_field_descripcion_tratamiento'=>
			array(
				 'sql_filter'	=>array(),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
            
		'unidad_codigo_interno_id'=>
			array(
				'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_codigo_interno_field_desc'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE
				 
			),
		
		'unidad_field_oblea'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_certificado'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_formulario_12'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		
		'unidad_field_formulario_01'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE
				 
			),
		//------------------[unidad]
		
		//------------------['modelo']
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
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				
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
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		//solo reporte
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
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		
		//solo para reporte
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
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				
			),
		//------------------['modelo']
		
		'unidad_field_fecha_entrega'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		

		'tsi_field_fecha_rotura'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		
		'tsi_field_kilometros_rotura'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		/*	
			'reclamo_garantia_field_fechahora_aprobacion'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>true,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		*/	
			
			
			
		'tsi_field_fecha_rotura_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_rotura) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'tsi_field_fecha_rotura_final'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_rotura) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		
		
		'unidad_field_fecha_entrega_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(unidad_field_fecha_entrega) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'unidad_field_fecha_entrega_final'=>
			array(
				 'sql_filter'	=>array('DATE(unidad_field_fecha_entrega) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'reclamo_garantia_field_fechahora_pre_aprobacion_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(reclamo_garantia_field_fechahora_pre_aprobacion) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'reclamo_garantia_field_fechahora_pre_aprobacion_final'=>
			array(
				 'sql_filter'	=>array('DATE(reclamo_garantia_field_fechahora_pre_aprobacion) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		
		'reclamo_garantia_field_fechahora_aprobacion_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(reclamo_garantia_field_fechahora_aprobacion) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'reclamo_garantia_field_fechahora_aprobacion_final'=>
			array(
				 'sql_filter'	=>array('DATE(reclamo_garantia_field_fechahora_aprobacion) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		
		
		'tsi_field_fecha_de_egreso'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>80,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		'tsi_field_kilometros'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>80,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		 
		
		'tsi_field_fecha_de_egreso_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_de_egreso) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'tsi_field_fecha_de_egreso_final'=>
			array(
				 'sql_filter'	=>array('DATE(tsi_field_fecha_de_egreso) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
		
		'sucursal_id'=>
			array(
				 'sql_filter'	=>array('SUCURSAL.id'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'sucursal_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>150,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		
		'reclamo_garantia_field_evaluacion_tecnica'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_codigo_sintoma_id'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_codigo_defecto_id'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_field_boletin_numero'=>
			array(
				 'sql_filter'	=>array('MATCH( %THIS% ) against (? IN BOOLEAN MODE)'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_field_valor_alca'=>
			array(
				 'sql_filter'	=>array('%THIS% >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_field_valor_hora_japon'=>
			array(
				 'sql_filter'	=>array('%THIS% >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_field_valor_dolar'=>
			array(
				 'sql_filter'	=>array('%THIS% >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_field_valor_ingresos_brutos'=>
			array(
				 'sql_filter'	=>array('%THIS% >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_campania_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),
		/*
		'reclamo_garantia_campania_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>50,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		*/
		'reclamo_garantia_dtc_estado_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_version_field_dtc_codigo'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),

		
		'reclamo_garantia_estado_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_estado_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),

		'reclamo_garantia_codigo_rechazo_principal_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_codigo_rechazo_principal_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),

		'reclamo_garantia_codigo_rechazo_secundario_id'=>
			array(
				 'sql_filter'	=>array('%THIS%'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),

		'reclamo_garantia_codigo_rechazo_secundario_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'frt_id'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'reclamo_garantia_frt_field_frt_horas'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		//ver parche gabriel
		'material_id'=>
			array(
				 'sql_filter'	=>array('material_id'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'reclamo_garantia_material_field_cantidad'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'reclamo_garantia_material_field_precio'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'material_facturacion_field_documento_sap_id'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'reclamo_garantia_material_field_material_principal'=>
			array(
				 'sql_filter'	=>array('RECLAMO_GARANTIA_MATERIAL_PRINCIPAL.material_id = ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),

		'reclamo_garantia_material_field_material_secundario'=>
			array(
				 'sql_filter'	=>array('RECLAMO_GARANTIA_MATERIAL_SECUNDARIO.material_id = ?'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'reclamo_garantia_version_field_serie_inflador_original'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		'reclamo_garantia_version_field_serie_inflador_colocado'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'reclamo_garantia_version_field_desc'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		'reclamo_garantia_version_field_valor_reclamado'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'		=>FALSE,
				 'print'		=>TRUE,
				 'rules'		=>'align[left]|width[100]|print|',
				
			),
		
		
		
		
		
		'reclamo_garantia_field_fechahora_alta'=>
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
		'reclamo_garantia_field_fechahora_alta_inicial'=>
			array(
				 'sql_filter'	=>array('DATE(reclamo_garantia_field_fechahora_alta) >= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'reclamo_garantia_field_fechahora_alta_final'=>
			array(
				 'sql_filter'	=>array('DATE(reclamo_garantia_field_fechahora_alta) <= ?'),
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'   	=>FALSE,
				 'print'	   	=>FALSE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			),
			
		'reclamo_garantia_version_id'=>
			array(
				 'sql_filter'	=>array('RECLAMO_GARANTIA_VERSION.reclamo_garantia_version_field_desc'),
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>FALSE,
				 'align'		=>'left',
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>'align[left]|width[100]|print|',
				 
			),
		

/*		
		//para descargar
		'reclamo_garantia_adjunto'=>
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

		);
			
			
	function Reclamo_Garantia_Main()
	{
		parent::Backend_Controller();
		if($this->backend->_permiso('admin'))
		{
			$this->default_valid_fields['reclamo_garantia_field_fechahora_pre_aprobacion'] =
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>FALSE,
				 'width'		=>100,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'	   	=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[100]|',
				 
			);
			
			
		}
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
					while(list($k,$v) =each($filtro)){
						if (in_array("material_id", $v)) {
							$filtro[$k][0] = "(RECLAMO_GARANTIA_MATERIAL_PRINCIPAL.material_id = ? OR RECLAMO_GARANTIA_MATERIAL_SECUNDARIO.material_id = '".$filtro[$k][1]."')";
						}
						
					}
					
					
					#--------------------------
					if(count($filtro)>0)
					{
						//ya no se si me gusta el ajax
						$this->session->set_userdata('filtro_'.$this->router->class,$filtro);
					}
					#--------------------------
				}
			}
			//->filtros del buscador por post
				
			//->selecciones del buscador
			
			//-------------------------[/buscador ]
			
			
			//-------------------------[configuracion de grilla ]
			//->grilla
			/*
			 * 0 - display name
			 * 1 - width
			 * 2 - sortable
			 * 3 - align
			 * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.) // no se usa
			 */
			
			$esqueleto_grid=$this->_create_grid_template($config['campos']);
			
			if($this->backend->_permiso('admin'))
			{
				$checkbox = array(lang('imprimir'),'40',1,'center',0);
				array_push($esqueleto_grid,$checkbox);
			}
			
			$buttons=false;
		
			//Build js
			//View helpers/flexigrid_helper.php for more information about the params on this function
			$this->template['js_grid'] = build_grid_js
			(
					'flex1', //html name
					$this->get_grid_url(), //url a la que apunta
					$esqueleto_grid,
					$this->default_sortname, //default order
					$this->default_sortorder, //default order 
					$this->config->item('gridParams'),
					$buttons
			);
		//-------------------------[/configuracion de grilla ]
		
		$this->_view();
		
	}

	function grid()
	{
		
		$config['campos'] = $this->default_valid_fields;
		//agrego para que pueda filtrar por id
		$this->default_valid_fields['id']['sorteable'] = TRUE;
		
		$this->_create_query();
		
		/*parche material id, busca en 2 campos (Gabriel) */
		
		
		
		
		if(!$this->backend->_permiso('admin'))
		{
			$this->query->addWhere('reclamo_garantia_version_field_desc = ?','CONCESIONARIO');
			unset($config['campos']['reclamo_garantia_field_valor_alca']);
			unset($config['campos']['reclamo_garantia_field_valor_hora_japon']);
			unset($config['campos']['reclamo_garantia_field_valor_dolar']);
		}
		//-------[PARCHE]
		//si no envio data desde el reporte mostramos los primeros x registros
		if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
		{
			/*
			$q = Doctrine_Query::create();
			$q->from('Reclamo_Garantia Reclamo_Garantia');
			$q->orderBy('id DESC');
			$q->limit(1);
			$r=$q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
						
			$this->query->AddWhere("RECLAMO_GARANTIA.id > ?",$r['id']-100);
			*/
			
			
			$rg = new Reclamo_Garantia();
			$this->query = $rg->get_grid();
			if(!$this->backend->_permiso('admin'))
			{
				//$this->query->addWhere('reclamo_garantia_version_field_desc = ?','CONCESIONARIO');
			}
			$this->flexigrid->validate_post();
			$this->flexigrid->build_query();
			
		}
		//------[PARCHE]
		
		$this->query->whereIn('SUCURSAL.id',$this->session->userdata('sucursales'));
		
		
		
		
		
		
		//-------------------------[escribe la grilla]
		$pager = new Doctrine_Pager(
				$this->query,
				$this->post_info['page'], //flexigrid genera este dato
				$this->post_info['rp']	//flexigrid genera este dato
		 );
			
		
			
		/*
		 * Json build WITH json_encode. If you do not have this function please read
		 * http://flexigrid.eyeviewdesign.com/index.php/flexigrid/example#s3 to know how to use the alternative
		 */
		$record_items=array();
		try {
			$resultado=$pager->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			//$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}
		foreach ($resultado as $row)
		{
			//agrego checkbox para bulk print
			
			$data = $this->_create_grid_data($row,$config['campos']);
			if($this->backend->_permiso('admin'))
			{
				$checkbox = '<input value="'.$row['id'].'" class="bulk" type="checkbox" name="bulk[]">';
				array_push($data,$checkbox);
			}
			
			
			$record_items[] = $data;
		}
		
		//Print please
		$this->output->set_header($this->config->item('json_header'));
		$this->output->set_output($this->flexigrid->json_build($pager->getNumResults(),$record_items));
		//-------------------------[/escribe la grilla]
	}
		
	
	//exporta registros a xls
	function export()
	{
	
		//$this->output->enable_profiler();
		
		$this->load->library('ofimatica');
		$config['campos']	=	$this->default_valid_fields;
		if(!$this->backend->_permiso('admin'))
		{
			unset($config['campos']['reclamo_garantia_field_valor_alca']);
			unset($config['campos']['reclamo_garantia_field_valor_hora_japon']);
			unset($config['campos']['reclamo_garantia_field_valor_dolar']);
		}
		
		
		$this->ofimatica->make_file();
		
		//----seteo campos a exportar para aliviar el while
		$export_fields = array();
		reset($config['campos']);
		while (list($field_name,$val) = each ($config['campos']))
		{
			if(isset($val['export']) && $val['export'] === TRUE)
			{
				$export_fields[] = $field_name;
			}
		}
		//----seteo campos a exportar para aliviar el while
		
		
	
		
		
		//creo el header
		reset($export_fields);
		$this->ofimatica->add_row();
		$this->ofimatica->add_header( 'ID',100 );
		while(list(,$field_name)=each($export_fields))
		{
			$this->ofimatica->add_header( $this->marvin->mysql_field_to_human($field_name),$config['campos'][$field_name]['width'] );
		}
		if($this->backend->_permiso('admin'))
		{
			$this->ofimatica->add_header( 'Total LON Horas',100 );
		}
		//creo el header
		
		
		
		
		$this->_create_query(); //creo query
		if(!$this->backend->_permiso('admin'))
		{
			$this->query->addWhere('reclamo_garantia_version_field_desc = ?','CONCESIONARIO');
		}
		//-------[PARCHE]
		//si no envio data desde el reporte mostramos los primeros x registros
		if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
		{
			$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
			$desde_fecha = date('Y-m-d', $dia); //Formatea dia
			$this->query->AddWhere("RECLAMO_GARANTIA.reclamo_garantia_field_fechahora_alta>=?",$desde_fecha);
		}
		//------[PARCHE]
		$this->query->whereIn('SUCURSAL.id',$this->session->userdata('sucursales'));
		$total = $this->query->count(); //cuento total
		
		$maximos_registos = $this->ofimatica->get_export_max_rows();
		
		$registros_por_query = $this->ofimatica->get_records_per_query();
		#vamos a aprobechar la limitacion del xls para ahorrrar memoria
		if($maximos_registos>0 && $total>$maximos_registos)	$total=$maximos_registos;	
		
		$cantidad_querys=ceil($total/$registros_por_query);
		
		
		
		//$cantidad_querys=1;
		for($pagina=0;$pagina<$cantidad_querys;$pagina++)
		{
			//el hydrate, tuve que separar las querys parece que no queda otra amigo
			//-------[PARCHE]
			//si no envio data desde el reporte mostramos los primeros x registros
			if(!is_array($this->session->userdata('filtro_'.$this->router->class)))
			{
				$dia = time()-($this->dias_default*24*60*60); //restamos 120 dias
				$desde_fecha = date('Y-m-d', $dia); //Formatea dia
				$this->query->AddWhere("RECLAMO_GARANTIA.reclamo_garantia_field_fechahora_alta>=?",$desde_fecha);
			}
			//------[PARCHE]
			$this->_create_query();
			if(!$this->backend->_permiso('admin'))
			{
				$this->query->addWhere('reclamo_garantia_version_field_desc = ?','CONCESIONARIO');
			}
			$this->query->whereIn('SUCURSAL.id',$this->session->userdata('sucursales'));
			$this->query->limit($registros_por_query);
			$this->query->offset($pagina*$registros_por_query);
			$this->query->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
			
			$result=$this->query->execute(array());
			$this->query->free();
			
			foreach($result as $row)
			{
				
				
				
				$this->ofimatica->add_row();
				$this->ofimatica->add_data( $row['id'] );
				reset($export_fields);
				while(list(,$field_name)=each($export_fields))
				{
					$this->ofimatica->add_data( element($field_name, $row) );
					//$this->ofimatica->add_data( 'asd' );
				}
				if($this->backend->_permiso('admin'))
				{
					$total_horas = '';
					foreach($row['Reclamo_Garantia_Version'] as $version)
					{
						$horas = element('reclamo_garantia_frt_field_frt_horas',$version);
						$horas = explode('|',$horas);
						$total = 0;
						foreach($horas as $hora)
						{
							$total+= $hora;
						}
						$total_horas.=$total .'|';
						
					}
					
					$this->ofimatica->add_data( $total_horas );
					
				}
				
			}
		}
		
		
		$this->ofimatica->send_file( );
		
		
		//-------------------------[exporta la mostrada en la grilla a xls]
			
	}


	// validation fields
	private function _validar_filtros() {		
		//-------------------------[valida datos del buscador]
		// validation rules
		
		$this->form_validation->set_rules('reclamo_id',$this->marvin->mysql_field_to_human('id'),
			'trim'
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
		
		$this->form_validation->set_rules('_buscador_general',$this->marvin->mysql_field_to_human('_buscador_general'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_fechahora_pre_aprobacion_inicial',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_fechahora_pre_aprobacion_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_fechahora_pre_aprobacion_final',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_fechahora_pre_aprobacion_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_fechahora_aprobacion_inicial',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_fechahora_aprobacion_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_fechahora_aprobacion_final',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_fechahora_aprobacion_final'),
			'trim|my_form_date_reverse'
		);
		
		$this->form_validation->set_rules('material_id',
			$this->marvin->mysql_field_to_human('material_id'),
			'trim'
		);
		
		$this->form_validation->set_rules('reclamo_garantia_material_field_material_principal',
			$this->marvin->mysql_field_to_human('reclamo_garantia_material_field_material_principal'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_material_field_material_secundario',
			$this->marvin->mysql_field_to_human('reclamo_garantia_material_field_material_principal'),
			'trim'
		);
		
		
		$this->form_validation->set_rules('tsi_field_fecha_de_egreso_inicial',
			$this->marvin->mysql_field_to_human('tsi_field_fecha_de_egreso_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('tsi_field_fecha_de_egreso_final',
			$this->marvin->mysql_field_to_human('tsi_field_fecha_de_egreso_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_fecha_entrega_inicial',
			$this->marvin->mysql_field_to_human('unidad_field_fecha_entrega_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('unidad_field_fecha_entrega_final',
			$this->marvin->mysql_field_to_human('unidad_field_fecha_entrega_final'),
			'trim|my_form_date_reverse'
		);
		
		$this->form_validation->set_rules('tsi_field_fecha_rotura_inicial',
			$this->marvin->mysql_field_to_human('tsi_field_fecha_rotura_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_fecha_rotura_final',
			$this->marvin->mysql_field_to_human('tsi_field_field_fecha_rotura_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('tsi_field_fecha_rotura',
			$this->marvin->mysql_field_to_human('tsi_field_fecha_rotura'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_evaluacion_tecnica',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_evaluacion_tecnica'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_codigo_sintoma',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_codigo_sintoma'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_codigo_defecto',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_codigo_defecto'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_boletin_numero',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_boletin_numero'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_valor_alca',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_valor_alca'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_valor_hora_japon',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_valor_hora_japon'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_valor_dolar',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_valor_dolar'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_valor_ingresos_brutos',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_valor_ingresos_brutos'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_campania_id[]',
			$this->marvin->mysql_field_to_human('reclamo_garantia_campania_id'),
			'trim'
		);
		$this->form_validation->set_rules('sucursal_id[]',
			$this->marvin->mysql_field_to_human('sucursal_id'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_dtc_estado_id[]',
			$this->marvin->mysql_field_to_human('reclamo_garantia_dtc_estado_id'),
			'trim'
		);
		$this->form_validation->set_rules('tsi_id[]',
			$this->marvin->mysql_field_to_human('tsi_id'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_estado_id[]',
			$this->marvin->mysql_field_to_human('reclamo_garantia_estado_id'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_codigo_rechazo_principal_id[]',
			$this->marvin->mysql_field_to_human('reclamo_garantia_codigo_rechazo_principal_id'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_codigo_rechazo_secundario_id[]',
			$this->marvin->mysql_field_to_human('reclamo_garantia_codigo_rechazo_secundario_id'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_fechahora_alta_inicial',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_fechahora_alta_inicial'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_fechahora_alta_final',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_fechahora_alta_final'),
			'trim|my_form_date_reverse'
		);
		$this->form_validation->set_rules('reclamo_garantia_field_fechahora_alta',
			$this->marvin->mysql_field_to_human('reclamo_garantia_field_fechahora_alta'),
			'trim|my_form_date_reverse'
		);
		
		$this->form_validation->set_rules('auto_modelo_id[]',
			$this->marvin->mysql_field_to_human('auto_modelo_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_version_id[]',
			$this->marvin->mysql_field_to_human('auto_version_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_transmision_id[]',
			$this->marvin->mysql_field_to_human('auto_transmision_id'),
			'trim'
		);
		$this->form_validation->set_rules('auto_anio_id[]',
			$this->marvin->mysql_field_to_human('auto_anio_id'),
			'trim'
		);
		$this->form_validation->set_rules('reclamo_garantia_version_id[]',
			$this->marvin->mysql_field_to_human('version'),
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
		
		//------------ [select / checkbox / radio reclamo_garantia_campania_id] :(
		$reclamo_garantia_campania=new Reclamo_Garantia_Campania();
		$q = $reclamo_garantia_campania->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('id');
		$config['select'] = FALSE;
		$this->template['reclamo_garantia_campania_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_campania_id]

		//------------ [select / checkbox / radio reclamo_garantia_dtc_estado_id] :(
		$reclamo_garantia_dtc_estado=new Reclamo_Garantia_Dtc_Estado();
		$q = $reclamo_garantia_dtc_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('reclamo_garantia_dtc_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['reclamo_garantia_dtc_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_dtc_estado_id]

		

		//------------ [select / checkbox / radio reclamo_garantia_estado_id] :(
		$reclamo_garantia_estado=new Reclamo_Garantia_Estado();
		$q = $reclamo_garantia_estado->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('reclamo_garantia_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['reclamo_garantia_estado_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_estado_id]

		//------------ [select / checkbox / radio reclamo_garantia_codigo_rechazo_principal_id] :(
		$reclamo_garantia_codigo_rechazo_principal=new Reclamo_Garantia_Codigo_Rechazo_Principal();
		$q = $reclamo_garantia_codigo_rechazo_principal->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		//$config['fields'] = array('reclamo_garantia_codigo_rechazo_principal_field_desc');
		$config['fields'] = array('id');
		$config['select'] = FALSE;
		$this->template['reclamo_garantia_codigo_rechazo_principal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_codigo_rechazo_principal_id]

		//------------ [select / checkbox / radio reclamo_garantia_codigo_rechazo_secundario_id] :(
		$reclamo_garantia_codigo_rechazo_secundario=new Reclamo_Garantia_Codigo_Rechazo_Secundario();
		$q = $reclamo_garantia_codigo_rechazo_secundario->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		//$config['fields'] = array('reclamo_garantia_codigo_rechazo_secundario_field_desc');
		$config['fields'] = array('id');
		$config['select'] = FALSE;
		$this->template['reclamo_garantia_codigo_rechazo_secundario_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio reclamo_garantia_codigo_rechazo_secundario_id]
		
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
		
		//------------ [select / checkbox / radio auto_transmision_id] :(
		$auto_transmision=new Auto_Transmision();
		$q = $auto_transmision->get_all();
		$config=array();
		$config['fields'] = array('auto_transmision_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_transmision_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_transmision_id]
		
		//------------ [select / checkbox / radio auto_anio_id] :(
		$auto_anio=new Auto_Anio();
		$q = $auto_anio->get_all();
		$q->leftJoin('Auto_Anio.Unidad');
		$q->addWhere('auto_anio_id !=' , FALSE);
		$q->groupBy('id');
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('auto_anio_field_desc');
		$config['select'] = FALSE;
		$this->template['auto_anio_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio auto_anio_id]

		
		//------------ [select / checkbox / radio reclamo_garantia_Version] :(
		$reclamo_garantia_version_id = array(
			'CONCESIONARIO'=>'CONCESIONARIO',
			'HONDA'=>'HONDA',
			'JAPON'=>'JAPON'
		);
		$this->template['reclamo_garantia_version_id']=$reclamo_garantia_version_id;
		//------------ [fin select / checkbox / radio reclamo_garantia_Version]

		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
