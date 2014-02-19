<?php
		 //bloqueo inputs en caso de lectura
		 if($this->router->method=='show' || $this->router->method=='toemail')
		 {
			?>
				<script type="text/javascript">
				$(document).ready(function() {
					block_input();
				
			<?
			//bloqueo las fuckings estrellas...
			if(isset($js_rating))
			{
				echo "$('input').rating('readOnly',true)";
			}
			?>
				});
				</script>
			<?
		 }
?>

<div style="display:none" class="preload_cache noprint"></div>


<script type="text/javascript">

	

	
	$(document).ready(function() {
        
		//var a = $.manageAjax.create('queue', {queue: 'clear', maxRequests: 1, abortOld: true});
		//$.manageAjax.create('cola_unidad', {queue: 'clear', maxRequests: 1, abortOld: true});
		
		
		
		
		
		
		
		$('ul.sf-menu').superfish({delay:1000}); //1 segundo de delay
		
		<!-- tabs -->
		$("#tabs").tabs({ selected: 0 });
		/*
		
		*/
		//$('#tabs > ul').tabs({ selected: 2 });
		<!-- tabls -->
		
		
		<!-- datepicker -->
		/*
		$(function() {
				$("#datepicker").datepicker({
									showOn: 'button',
									buttonImage: '<?=$this->config->item('base_url');?>public/images/calendar.png',
									buttonImageOnly: true,
									dateFormat: 'yy-mm-dd',
									//minDate: '+0D',
									//maxDate: '+1Y',
									changeMonth: true,
									changeYear: true,
									numberOfMonths: 1,
									dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
									monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
										'Junio', 'Julio', 'Agosto', 'Septiembre',
										'Octubre', 'Noviembre', 'Diciembre'],
									monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
										'May', 'Jun', 'Jul', 'Ago',
										'Sep', 'Oct', 'Nov', 'Dic']
								});
		});
		*/
		<!-- datepicker -->
		
		<?
		// dialog ajax titulo y copete de imagenes
		if(set_value('id') && $this->backend->_permiso('edit')){
		?>
		$("#_imagen_descripcion").dialog("destroy");
		$("#_imagen_descripcion").dialog({
			autoOpen: false,
			resizable: false,
			height: 300,
			width: 700,
			modal: true,
			buttons: {
				'<?=lang('enviar_form');?>': function() {
					//-------
					$.ajax({
						beforeSend: function(objeto){
							$('#_ajax_loading').show();
						},
						type: "POST",
						url: "<?=$abm_url.'/edit_image/'.set_value('id').'/'?>"+$("#_edit_imagen_id").val(),
						data: "prefix="+$("#_table_prefix").val()+"&imagen_titulo="+$("#_imagen_titulo").val()+"&imagen_copete="+$("#_imagen_copete").val(),
						success: function(respuesta){
							
							$("#_imagen_descripcion").dialog('close');
							if(respuesta == 'TRUE'){
								//agrego los datos al div
								$('#_imagen_titulo'+$("#_edit_imagen_id").val()).val( $("#_imagen_titulo").val() )
								$('#_imagen_copete'+$("#_edit_imagen_id").val()).val( $("#_imagen_copete").val() )
								$('#_span_imagen_titulo'+$("#_edit_imagen_id").val()).html( $("#_imagen_titulo").val() )
								$('#_span_imagen_copete'+$("#_edit_imagen_id").val()).html( $("#_imagen_copete").val() )
							}else{
								
							}
							$('#_ajax_loading').hide();
							return false;
						}
					});
					//-------
				},
				'<?=lang('cancelar');?>': function() {
					
					$(this).dialog('close');
				}
			}
		});
		$('.actualizarDescripcion').click(function() {
			id=$(this).attr("id");
			prefix=$(this).attr("rel");
			$('#_table_prefix').val(prefix);
			$('#_edit_imagen_id').val( id );
			$('#_imagen_titulo').val( $('#_imagen_titulo'+id).val() );
			$('#_imagen_copete').val( $('#_imagen_copete'+id).val() );
			//$('#_editar_imagen_background').css('background', 'url('+$('#_imagen_url'+id).val()+') no-repeat right;');
			
			$('#_imagen_descripcion').dialog('open');
			return false;
		});
		<?
		}
		?>
		
		
		<!-- dialog -->
		<?
		if(set_value('id') && $this->backend->_permiso('del')){
		?>
		$("#dialog-delete").dialog("destroy");
		$("#dialog-delete").dialog({
			autoOpen: false,
			resizable: false,
			height:200,
			modal: true,
			buttons: {
				'<?=lang('eliminar');?>': function() {
					//-------
					$.ajax({
						beforeSend: function(objeto){
							$('#_ajax_loading').show();
						},
						type: "POST",
						url: "<?=$abm_url.'/del';?>",
						data: "id=<?=set_value('id');?>&ajax=true",
						success: function(datos){
							if(datos=='TRUE'){
								window.location="<?=$main_url;?>";
							}
							$('#_ajax_loading').hide();
							return false;
						}
					});
					//-------
				},
				'<?=lang('cancelar');?>': function() {
					$(this).dialog('close');
				}
			}
		});
		
		
		
		$("#dialog-image-delete").dialog("destroy");
		$("#dialog-image-delete").dialog({
			autoOpen: false,
			resizable: false,
			height:200,
			modal: true,
			buttons: {
				'<?=lang('eliminar')?>': function() {
					//-------
					$.ajax({
						beforeSend: function(objeto){
							$('#_ajax_loading').show();
						},
						type: "POST",
						url: "<?=$abm_url.'/del_image/'.set_value('id').'/'?>"+$("#delete_imagen_id").val()+'/'+$("#delete_imagen_rel").val(),
						data: "ajax=true",
						success: function(datos){
							if(datos=='TRUE'){
								$("li #"+$("#delete_imagen_id").val()).remove();
							}
							
							$("#dialog-image-delete").dialog('close');
							$('#_ajax_loading').hide();
							return false;
						}
					});
					//-------
				},
				'<?=lang('cancelar')?>': function() {
					$(this).dialog('close');
				}
			}
		});
		
		$("#dialog-adjunto-delete").dialog("destroy");
		$("#dialog-adjunto-delete").dialog({
			autoOpen: false,
			resizable: false,
			height:200,
			modal: true,
			buttons: {
				'<?=lang('eliminar')?>': function() {
					//-------
					$.ajax({
						beforeSend: function(objeto){
							$('#_ajax_loading').show();
						},
						type: "POST",
						url: "<?=$abm_url.'/del_adjunto/'.set_value('id').'/'?>"+$("#delete_adjunto_id").val()+'/'+$("#delete_adjunto_rel").val(),
						data: "ajax=true",
						success: function(datos){
							if(datos=='TRUE'){
								$("div #"+$("#delete_adjunto_id").val()).remove();
							}
							
							$("#dialog-adjunto-delete").dialog('close');
							$('#_ajax_loading').hide();
							return false;
						}
					});
					//-------
				},
				'<?=lang('cancelar')?>': function() {
					$(this).dialog('close');
				}
			}
		});
		
		$('#eliminar_registro').click(function() {
			$('#dialog-delete').dialog('open');
			return false;
		});
		$(".eliminarImagen").click(function(e) { 
			$("#delete_imagen_id").val($(this).attr("id"));
			$("#delete_imagen_rel").val($(this).attr("rel"));
			$('#dialog-image-delete').dialog('open');
			return false;
			});
		$(".eliminarAdjunto").click(function(e) { 
			$("#delete_adjunto_id").val($(this).attr("id"));
			$("#delete_adjunto_rel").val($(this).attr("rel"));
			$('#dialog-adjunto-delete').dialog('open');
			return false;
			});
		<?}?>
		
		<?
		if(set_value('id') && $this->backend->_permiso('admin') && (isset($SHOW_RECHAZAR_REGISTRO) && $SHOW_RECHAZAR_REGISTRO===TRUE)){
		?>
		$("#dialog-rechazar").dialog("destroy");
		$("#dialog-rechazar").dialog({
			autoOpen: false,
			resizable: false,
			height:280,
			modal: true,
			buttons: {
				'<?=lang('rechazar');?>': function() {
					//-------
					$.ajax({
						beforeSend: function(objeto){
							$('#_ajax_loading').show();
						},
						type: "POST",
						url: "<?=$abm_url.'/reject';?>",
						data: "id=<?=set_value('id');?>&ajax=true&rechazo_motivo="+$("#_rechazo_motivo").val(),
						success: function(datos){
							if(datos=='TRUE'){
								window.location="<?=current_url();?>";
							}
							$('#_ajax_loading').hide();
							return false;
						}
					});
					//-------
				},
				'<?=lang('cancelar');?>': function() {
					$(this).dialog('close');
				}
			}
		});
		
		$('#rechazar_registro').click(function() {
			$('#dialog-rechazar').dialog('open');
			return false;
		});
		<?}?>
		
		
		<?
			//aprobar registro
		if(set_value('id') && $this->backend->_permiso('admin') ){
		?>
		$("#dialog-aprobar").dialog("destroy");
		$("#dialog-aprobar").dialog({
			autoOpen: false,
			resizable: false,
			height:200,
			modal: true,
			buttons: {
				'<?=lang('aprobar_registro');?>': function() {
					//-------
					$.ajax({
						beforeSend: function(objeto){
							$('#_ajax_loading').show();
						},
						type: "POST",
						url: "<?=$abm_url.'/approve';?>",
						data: "id=<?=set_value('id');?>&ajax=true",
						success: function(datos){
							if(datos=='TRUE'){
								window.location="<?echo current_url();?>";
							}
							$('#_ajax_loading').hide();
							return false;
						}
					});
					//-------
				},
				'<?=lang('cancelar');?>': function() {
					$(this).dialog('close');
				}
			}
		});
		
		$('#aprobar_registro').click(function() {
			$('#dialog-aprobar').dialog('open');
			return false;
		});
		<?
		//aprobar registro
		}
		?>
		

		<!-- dialog -->
	
			<!-- form -->
				//Wesified.
				$(document).ready(function() {
			//On input focus (tabbed or clicked)..it will..
					$("input,textarea,select").livequery('focus', function() { 
			//grab the parent nested LI of that input and add the bg color
							$(this).parents('li').css('background-color','#F5F5F5');
						}).blur(function() {
			//Then get rid of it
					$(this).parents('li').css('background-color','#F0F0F2');
			});
		});
		<!-- form -->
		
		<!-- ajax marca -->
		$(document).ready(function() {
				$("input.auto_marca_id").change(function(){
					$.manageAjax.create('cola_auto_marca_id', {queue: 'clear', maxRequests: 1, abortOld: true});
					var marcas = new Array();
					var modelos = new Array();
					var versiones = new Array();
					$("input.auto_marca_id:checked").each(function() {marcas.push($(this).val());});
					$("input[name$='auto_modelo_id[]']:checked").each(function() {modelos.push($(this).val());});
					$("input[name$='auto_version_id[]']:checked").each(function() {versiones.push($(this).val());});
					 $.manageAjax.add('cola_auto_marca_id', 
						{
							beforeSend: function()
							{
								$('._ajax_append').append('<div class="_ajax_loading _cola_auto_marca_id"></div>');
							},
							type: "GET",
							 url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_auto_modelo/"+marcas.join('-')+"/"+modelos.join('-')+"/"+versiones.join('-'),
							
							success: function(respuesta)
							{
								 $("#div_auto_modelo_id").html(respuesta);	
								$('._cola_auto_marca_id').remove();
							}
						});

					

				return false;
			});
		});
		<!-- ajax modelo -->
		
		
		<!-- ajax modelo -->
		$(document).ready(function() {
				$.manageAjax.create('cola_auto_modelo_id', {queue: 'clear', maxRequests: 1, abortOld: true});
				$("input.auto_modelo_id").livequery('change', function() { 
					var modelos = new Array();
					var versiones = new Array();
					$("input.auto_modelo_id:checked").each(function() {modelos.push($(this).val());});
					$("input[name$='auto_version_id[]']:checked").each(function() {versiones.push($(this).val());});
					/*
					$.ajax({
					   type: "GET",
					   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_auto_version/"+modelos.join('-')+"/"+versiones.join('-'),
					   timeout: 5000,
					   success: function(respuesta){
							 $("#div_auto_version_id").html(respuesta);	
					   }
					 });
					 */
					 $.manageAjax.add('cola_auto_modelo_id', 
						{
							beforeSend: function()
							{
								$('._ajax_append').append('<div class="_ajax_loading _cola_auto_modelo_id"></div>');
							},
							type: "GET",
							 url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_auto_version/"+modelos.join('-')+"/"+versiones.join('-'),
							
							success: function(respuesta)
							{
								 $("#div_auto_version_id").html(respuesta);	
								$('._cola_auto_modelo_id').remove();
							}
						});

					

				return false;
			});
		});
		<!-- ajax modelo -->
		
		<!-- ajax provincia -->
		$(document).ready(function() {
			$.manageAjax.create('cola_provincia', {queue: 'clear', maxRequests: 1, abortOld: true});

			$(".provincia_id").livequery('change', function() { 
			var input = $(this);
			// use the helper function hover to bind a mouseover and mouseout event 
			
			 $.manageAjax.add('cola_provincia', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_provincia"></div>');
					},
					type: "POST",
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_ciudades/"+$(this).val(),
					data: "input="+input.attr("name"),
					success: function(respuesta)
					{
						//$(this).parent().parent(".ciudad_id").append(respuesta);
							//$(this).next("select").css("background-color", "yellow");						  
						  //$(this).(".ciudad_id:first").append(respuesta);
						  //$(this).parent("div").next("div").remove();
						input.parents('li').find(".ciudad_id").html(respuesta);
						$('._cola_provincia').remove();
					}
                });
			
			/*
             $.ajax({
				   type: "POST",
				   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_ciudades/"+$(this).val(),
				   data: "input="+input.attr("name"),
				   timeout: 5000, //
				   success: function(respuesta){
						   //$(this).parent().parent(".ciudad_id").append(respuesta);
							//$(this).next("select").css("background-color", "yellow");						  
						  //$(this).(".ciudad_id:first").append(respuesta);
						  //$(this).parent("div").next("div").remove();
						input.parents('li').find(".ciudad_id").html(respuesta);
				   }
				});  
				*/
			});

			
		});
		<!-- ajax provincia -->
		
		<!-- ajax unidad -->
		$(document).ready(function() {
			
			$('input._unidad_field').keyup(function(e){
				e.preventDefault();
				$('#unidad_field_unidad').val( $.trim( $('#unidad_field_unidad').val() ) );
				$('#unidad_field_vin').val( $.trim( $('#unidad_field_vin').val() ) );
				
				if(!es_unidad_valida())
				{
					_blanquear_ajax_unidad();
					return false;
				}
				
				$.manageAjax.add('cola_unidad', {
                     
                      beforeSend: function()
						{
							$('._ajax_append').append('<div class="_ajax_loading _cola_unidad"></div>');
						},
					  
					  url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_datos_unidad/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val(),
					  type: "GET",
					  //data: "hola=si",
					   success: function(respuesta){
									if(respuesta=='false')
									{
										_blanquear_ajax_unidad();
										$('._cola_unidad').remove();
										return false;
									}
									var unidad = jQuery.parseJSON(respuesta);
									$("input[name$='_show_unidad_id']").val(unidad.id);
									
									
									$('#unidad_unidad_field_unidad').html(unidad.unidad);
									$('#unidad_unidad_field_vin').html(unidad.vin);
									$('#unidad_auto_marca_field_desc').html(unidad.marca);
									$('#unidad_auto_modelo_field_desc').html(unidad.modelo);
									$('#unidad_auto_version_field_desc').html(unidad.version);
									$('#unidad_unidad_field_descripcion_sap').html(unidad.descripcion_sap);
									$('#unidad_auto_transmision_field_desc').html(unidad.transmision);
									$('#unidad_auto_puerta_cantidad_field_desc').html(unidad.puerta_cantidad);
									$('#unidad_unidad_field_motor').html(unidad.motor);
									$('#unidad_color_exterior_field_desc').html(unidad.color_exterior);
									$('#unidad_color_interior_field_desc').html(unidad.color_interior);
									$('#unidad_unidad_field_oblea').html(unidad.oblea);
									$('#unidad_unidad_field_codigo_de_llave').html(unidad.codigo_de_llave);
									$('#unidad_unidad_field_codigo_de_radio').html(unidad.codigo_de_radio);
									$('#unidad_unidad_field_patente').html(unidad.patente);
									$('#unidad_unidad_field_material_sap').html(unidad.material_sap);
									$('#unidad_auto_anio_field_desc').html(unidad.anio_modelo);
									$('#unidad_auto_fabrica_field_desc').html(unidad.fabrica);
									$('#unidad_vin_procedencia_ktype_field_desc').html(unidad.procedencia);
									$('#unidad_vin_procedencia_ktype_field_ktype').html(unidad.ktype);
									$('#unidad_unidad_field_fecha_venta').html(unidad.fecha_venta);
									$('#unidad_unidad_field_fecha_entrega').html(unidad.fecha_entrega);
									$('#unidad_unidad_field_kilometros').html(unidad.kilometros);
									
									$('#unidad_field_codigo_de_llave').val(unidad.codigo_de_llave);
									$('#unidad_field_codigo_de_radio').val(unidad.codigo_de_radio);
									$('#unidad_field_patente').val(unidad.patente);
									$('#unidad_field_edad_meses').val(unidad.edad_meses);
									
									$('._cola_unidad').remove();
									
									
									$("input[name$='_show_unidad_id']").trigger('change');
								//alert(respuesta);
								//$('#unidad_field_codigo_de_llave').val(respuesta);
						   }

                   });
                   
				   return false;
			});
		});
		<!-- ajax unidad -->
}); 
	
	
	function _blanquear_ajax_unidad()
	{	
		$("input[name$='_show_unidad_id']").val('');
		$('#unidad_unidad_field_unidad').html('');
		$('#unidad_unidad_field_vin').html('');
		$('#unidad_auto_marca_field_desc').html('');
		$('#unidad_auto_modelo_field_desc').html('');
		$('#unidad_auto_version_field_desc').html('');
		$('#unidad_unidad_field_descripcion_sap').html('');
		$('#unidad_auto_transmision_field_desc').html('');
		$('#unidad_auto_puerta_cantidad_field_desc').html('');
		$('#unidad_unidad_field_motor').html('');
		$('#unidad_color_exterior_field_desc').html('');
		$('#unidad_color_interior_field_desc').html('');
		$('#unidad_unidad_field_oblea').html('');
		$('#unidad_unidad_field_codigo_de_llave').html('');
		$('#unidad_unidad_field_codigo_de_radio').html('');
		$('#unidad_unidad_field_patente').html('');
		$('#unidad_unidad_field_material_sap').html('');
		$('#unidad_auto_anio_field_desc').html('');
		$('#unidad_auto_fabrica_field_desc').html('');
		$('#unidad_vin_procedencia_ktype_field_desc').html('');
		$('#unidad_vin_procedencia_ktype_field_ktype').html('');
		$('#unidad_unidad_field_fecha_venta').html('');
		$('#unidad_unidad_field_fecha_entrega').html('');
		$('#unidad_field_codigo_de_llave').val('');
		$('#unidad_field_codigo_de_radio').val('');
		$('#unidad_field_patente').val('');
		$('#unidad_field_edad_meses').val('');
		$("input[name$='_show_unidad_id']").trigger('change');
	}
	
	/*
	function _ajax_unidad()
	{
		if(	
			$('#unidad_field_unidad').val().length ==0 ||
			$('#unidad_field_vin').val().length !=17
		)
		{
			_blanquear_ajax_unidad();
			return false;
		}
		
		    $('#region1 a').click(function(e){
                   var $this = $(this);
				   e.preventDefault();
                   a.add({
                      url: $this.attr('href') + "?asd=" +randomString(),
					  type: "POST",
					  data: "hola=si",

                   });
                   return false;
                });
		
		$.ajax({
						   type: "GET",
						   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_datos_unidad/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val(),
						   timeout: 30000, //
						   success: function(respuesta){
									if(respuesta=='false')
									{
										_blanquear_ajax_unidad();
										return false;
									}
									var unidad = jQuery.parseJSON(respuesta);
									$('#unidad_unidad_field_unidad').html(unidad.unidad);
									$('#unidad_unidad_field_vin').html(unidad.vin);
									$('#unidad_auto_marca_field_desc').html(unidad.marca);
									$('#unidad_auto_modelo_field_desc').html(unidad.modelo);
									$('#unidad_auto_version_field_desc').html(unidad.version);
									$('#unidad_unidad_field_descripcion_sap').html(unidad.descripcion_sap);
									$('#unidad_auto_transmision_field_desc').html(unidad.transmision);
									$('#unidad_auto_puerta_cantidad_field_desc').html(unidad.puerta_cantidad);
									$('#unidad_unidad_field_motor').html(unidad.motor);
									$('#unidad_color_exterior_field_desc').html(unidad.color_exterior);
									$('#unidad_color_interior_field_desc').html(unidad.color_interior);
									$('#unidad_unidad_field_oblea').html(unidad.oblea);
									$('#unidad_unidad_field_codigo_de_llave').html(unidad.codigo_de_llave);
									$('#unidad_unidad_field_codigo_de_radio').html(unidad.codigo_de_radio);
									$('#unidad_unidad_field_patente').html(unidad.patente);
									$('#unidad_unidad_field_material_sap').html(unidad.material_sap);
									$('#unidad_auto_anio_field_desc').html(unidad.anio_modelo);
									$('#unidad_auto_fabrica_field_desc').html(unidad.fabrica);
									$('#unidad_vin_procedencia_ktype_field_desc').html(unidad.procedencia);
									$('#unidad_vin_procedencia_ktype_field_ktype').html(unidad.ktype);
									$('#unidad_unidad_field_fecha_venta').html(unidad.fecha_venta);
									$('#unidad_unidad_field_fecha_entrega').html(unidad.fecha_entrega);
									
									$('#unidad_field_codigo_de_llave').val(unidad.codigo_de_llave);
									$('#unidad_field_codigo_de_radio').val(unidad.codigo_de_radio);
									$('#unidad_field_patente').val(unidad.patente);
									
								//alert(respuesta);
								//$('#unidad_field_codigo_de_llave').val(respuesta);
						   }
						});
	}
	*/
	
	
	
	/*
	function unidad_ajax()
	{
		  
return false;		 
		 $.ajax({
				   //mode: 'queue', 
				   type: "GET",
				   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_unidad/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val(),
				   timeout: 3000, //
				   success: function(respuesta){
						$('#datos_unidad').html(respuesta);
						if(respuesta.length>10)
						{
						//tomo llave, radio, patente
						$.ajax({
						   type: "GET",
						   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_datos_unidad/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val(),
						   timeout: 3000, //
						   success: function(respuesta){
								var unidad = jQuery.parseJSON(respuesta);
								alert( unidad.id);
								
								//alert(respuesta);
								//$('#unidad_field_codigo_de_llave').val(respuesta);
						   }
						});
						$.ajax({
						   type: "GET",
						   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_unidad_codigo_radio/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val(),
						   timeout: 3000, //
						   success: function(respuesta){
								$('#unidad_field_codigo_de_radio').val(respuesta);
						   }
						});
						$.ajax({
						   type: "GET",
						   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_unidad_patente/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val(),
						   timeout: 3000, //
						   success: function(respuesta){
								$('#unidad_field_patente').val(respuesta);
						   }
						});
						//tomo llave, radio, patente
						}
				   
				   }
				});
		  
		  
		  
		  
	}
	
	*/
	
	<!-- ajax cliente -->
		$(document).ready(function() {
			$.manageAjax.create('cola_cliente', {queue: 'clear', maxRequests: 1, abortOld: true});
			
			$(".cliente_field_numero_documento").livequery('keyup', function() { 
			
			var input = $(this);
			cliente_field_numero_documento = input.val();
			documento_tipo_id = input.parents('div').find(".documento_tipo_id").val();
			sucursal_id = $("select[name$='sucursal_id']").val();
			if(sucursal_id>0 && documento_tipo_id>0 && cliente_field_numero_documento.length>1)
			{
				 
				/*
				 $.ajax({
				   type: "GET",
				   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_client_html_form/"+cliente_field_numero_documento+"/"+documento_tipo_id+"/"+sucursal_id,
				   timeout: 3000, //
				   success: function(respuesta){
						if(respuesta)
						{
							input.closest('.cliente_ajax').html(respuesta);
						}
				   }
				});
				*/
				
				 $.manageAjax.add('cola_cliente', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_cliente"></div>');
					},
					type: "POST",
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_client_html_form/"+cliente_field_numero_documento+"/"+documento_tipo_id+"/"+sucursal_id,
					success: function(respuesta)
					{
						if(respuesta)
						{
							input.closest('.cliente_ajax').html(respuesta);
						}else{
							//TODO BORRAR DATOS CLIENTE
							//c
							//input.closest('.cliente_ajax').html(respuesta);
							//input.closest("#cliente_sucursal_field_nombre").val("asd");
							
							//$("select[name$='sucursal_id']").val();
							//cliente_sucursal[cliente_sucursal_field_fecha_nacimiento][]
						}
						$('._cola_cliente').remove();
					}
                });
				
			}
			//input.parents('div').find(".cliente_ajax").html('hola');
			// use the helper function hover to bind a mouseover and mouseout event 
				/*
             $.ajax({
				   type: "POST",
				   url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_ciudades/"+$(this).val(),
				   data: "input="+input.attr("name"),
				   timeout: 5000, //
				   success: function(respuesta){
						   //$(this).parent().parent(".ciudad_id").append(respuesta);
							//$(this).next("select").css("background-color", "yellow");						  
						  //$(this).(".ciudad_id:first").append(respuesta);
						  //$(this).parent("div").next("div").remove();
						input.parents('li').find(".ciudad_id").html(respuesta);
				   }
				}); 
				*/
				
			});
			
			
			
			
			<!-- blanquea el buscar -->
			$(document).ready(function() {
			
				$('.buscador_campo').focusin(function() {
					var string = $(this).val();
					if(string=='<?=lang('buscar')?>')
					{
						$(this).val('');
					}
					/*
					if(input.val()=='<?=lang('buscar');?>')
					{
						input.val()='';
					}
					*/
				});
				$('.buscador_campo').focusout(function() {
					
					var string = $(this).val();
					if(string=='')
					{
						$(this).val('<?=lang('buscar')?>');
					}
					/*
					if(input.val()=='<?=lang('buscar');?>')
					{
						input.val()='';
					}
					*/
				});
				
			});
			<!-- blanquea el buscar -->
			
			
		});
		<!-- ajax provincia -->
		
		
		

	
	</script>	
	<script type="text/javascript">
	
	//-----------------
	//preload imagenes print
	$(document).ready(function() {	
		var preload1 = $('<img />').attr('src', '<?php echo $this->config->item('base_url') . 'public/css/default_print_images/harws_logo_print.gif'?>');
		var preload2 = $('<img />').attr('src', '<?php echo $this->config->item('base_url') . 'public/css/default_print_images/blueskies.png'?>');
		var preload3 = $('<img />').attr('src', '<?php echo $this->config->item('base_url') . 'public/css/default_print_images/star-on.png'?>');
		var preload4 = $('<img />').attr('src', '<?php echo $this->config->item('base_url') . 'public/css/default_print_images/star-off.png'?>');
	
		$('.preload_cache').append(preload1);
		$('.preload_cache').append(preload2);
		$('.preload_cache').append(preload3);
		$('.preload_cache').append(preload4);

	}); 
	
	//-----------------
	
	// Run the script on DOM ready:
	//$(".cliente_field_numero_documento").livequery('keyup', function() { 
	
	
	$(document).ready(function() {	
		$("input._unidad_field").trigger("keyup");
	}); 
	
	$(function(){
		$('input').customInput(); 	//checkbox imagen
		
		$('#multiple_upload').MultiFile({ //TODO revisar no funciona, cambia remove por imagen en multiple upload
			STRING: {
				remove: '<img src="<?=$this->config->item('base_url');?>public/images/icons/delete.png" height="16" width="16" alt="x"/>'
			}
		});

	});
	</script>
	<?
	//flexigrid
	if(isset($js_grid)){
		echo $js_grid;
	}
	?>
<script type="text/javascript">
	
	//-----------------
	//preload imagenes print
	$(document).ready(function() {	
	
		$('.buscador').hide();

	}); 
	
	
	</script>
	

<script type="text/javascript">
//carga del servidor

function ajax_cpu()
	{
		$.manageAjax.add('cola_cpu', 
		{
					
			cache: false,
			url: "<?=$this->config->item('base_url');?>status/cpu.php",
			timeout: 2000,
			success: function(respuesta)
			{
				$('#cpu').html(respuesta);
			},
			error: function(x, t, m) 
			{
				if(t==="timeout")
				{
					$('#cpu').html("CPU: 100%");
				}
			}
			
		});
	}

	<?php if($this->session->userdata('admin_field_super_admin')===TRUE):?>
	$(document).ready(function(){ 
		ajax_cpu();
		setInterval('ajax_cpu()',10000);
	}); 
	<?php endif;?>

</script>	
	