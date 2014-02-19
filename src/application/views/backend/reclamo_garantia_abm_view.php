<script type="text/javascript">
var read_only = false;
</script>

<?php
$moneda = 'AR$';
if(isset($GARANTIA_VERSION) && $GARANTIA_VERSION=='JAPON')
{
	$moneda = 'U$S';
}

if(	(isset($GARANTIA_VERSION) && $GARANTIA_VERSION == 'CONCESIONARIO') OR
	in_array($estado_actual,$estados_bloqueados) 
	OR $estado_actual == 13)
{
?>
	<script type="text/javascript">
		$(document).ready(function() {
			block_input();
			read_only = true;
			
		});
	</script>
			
<?php
}




$Reclamo_Garantia_Version = set_value('Reclamo_Garantia_Version');
if(!$Reclamo_Garantia_Version)
{
	$Reclamo_Garantia_Version = array();
}

?>

<script type="text/javascript">
	/* facebook mode :O*/
	$(document).ready(function() {
		
		<?php if($this->router->method=='show'):?>
		$('#versionimprenta').first().hide();
		<?php endif;?>
		$("input[name$='reclamo_garantia_field_valor_alca']").attr("disabled", 'disabled');
		
		<?php if($this->router->method!='add'):?>
		$("select[name$='reclamo_garantia_campania_id']").attr("disabled", 'disabled');
		<?php endif;?>
		
		
		//evitar envio de form con enter
		$('form').keypress(function(e){    
			if(e == 13){ 
			  return false; 
			} 
		  }); 
		 
		  $('input').keypress(function(e){ 
			if(e.which == 13){ 
			  return false; 
			} 
		  });
		 //evitar envio de form con enter
		
		
		var method = '<?php echo $this->router->method;?>';
		var link_frt = '';
		var regexp_bateria = "^31500";
		var regexp_bateria = 'fruta';
		if(method=='show' || read_only)
		{
			$(".minibuscador").remove();
			$(".eliminar_bloque").remove();
			$(".add_multi_frt").remove();
			$(".add_multi_repuesto").remove();
			$(".add_multi_trabajo_tercero").remove();
			$("#rechazar_registro").remove();
		}
		

		
		$.manageAjax.create('cola_frt_hora', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_repuesto_nombre', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_repuesto_precio', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_codigo_sintoma', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_codigo_defecto', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_garantia_tsi', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_tsi_sucursal', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_buscador_defecto', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_buscador_sintoma', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_buscador_frt', {queue: 'true', maxRequests: 1, abortOld: true});
		$.manageAjax.create('cola_campania', {queue: 'true', maxRequests: 1, abortOld: true});
		
		
		function tsi_ingresos_brutos()
		{
			if(method=='add')
			{
				$("#reclamo_ingresos_brutos").html("0");
				$("#reclamo_costo_mano_obra").html("0");
			}
			$("select[name$='tsi_id']").trigger('change');
			calcular_precio();		
			
		}
		
		$("select[name$='tsi_id']").live('change', function()
		 {
			/**/
				
				
				$.manageAjax.add('cola_tsi_sucursal', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_tsi_sucursal"></div>');
					},
					cache: false,
					dataType: 'json',
					type: "POST",
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax_json/get_tsi_sucursal_garantia",
					data: "tsi_id="+$("select[name$='tsi_id']").val(),
					success: function(json)
					{
						if(json.error!=1)
						{
							$("#reclamo_ingresos_brutos").html(json.response.ingresos_brutos);
							$("#reclamo_costo_mano_obra").html(json.response.valor_frt_hora);
							//$('#select_tsi').html('<select name="tsi_id">' + create_select_from_json(json) + '</select>');
							
							
						}
						calcular_precio();						
						$('._cola_tsi_sucursal').remove();
					
					
					}
				});	
				/**/
				
				
		 });
		
		
		
		if(method=='add')
		{
			/*si cambia el numero de unidad busco tsi*/
			 $("input[name$='_show_unidad_id']").livequery('change', function()
			{
				var unidad= $(this).val();
				if(is_numeric(unidad))
				{
					/**/
					$.manageAjax.add('cola_garantia_tsi', 
					{
						beforeSend: function()
						{
							$('._ajax_append').append('<div class="_ajax_loading _cola_garantia_tsi"></div>');
						},
						cache: false,
						dataType: 'json',
						type: "POST",
						url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax_json/get_garantia_tsi",
						data: "unidad_id="+unidad,
						success: function(json)
						{
							if(json.error!=1)
							{
								$('#select_tsi').html('<select name="tsi_id" id="tsi_id">' + create_select_from_json(json, $('#select_tsi').attr('rel') ) + '</select>');
								tsi_ingresos_brutos();
							}else{
								$('#select_tsi').html('<span class="respuesta_ajax">No se encontraron resultados</span>');
								tsi_ingresos_brutos();
							}
							$('._cola_garantia_tsi').remove();
						}
					});	
					/**/
				}else{
					$('#select_tsi').html('<span class="respuesta_ajax">No se encontraron resultados</span>');
					tsi_ingresos_brutos();
				}
				
			});
		}
		
		
		
		$("select[name$='reclamo_garantia_campania_id']").livequery('change', function()
		{
			
			if($(this).val()!=0)
			{
				$('.no_campania').hide();
			}else{
				$('.no_campania').show();
			}
			$("select[name$='reclamo_garantia_dtc_estado_id']").trigger('change'); //ocultamos dtc
		});
		
		//a ver si es campania?
		$("select[name$='reclamo_garantia_campania_id']").trigger('change');
		
		
		
		
		
		
		
		
		/*estado dtc*/
		$("select[name$='reclamo_garantia_dtc_estado_id']").change(function(e)
		{
			if($(this).val()==1)
			{
				$('.reclamo_garantia_field_dtc_codigo').hide();
			}else{
				$('.reclamo_garantia_field_dtc_codigo').show();
			}
		});
		$("select[name$='reclamo_garantia_dtc_estado_id']").trigger('change');
		
		/*codigo de sintoma*/
		$("input[name$='reclamo_garantia_codigo_sintoma_id']").change(function(e)
		{
			$(".codigo_sintoma_descripcion").html('');
			$.manageAjax.add('cola_codigo_sintoma', 
			{
				beforeSend: function()
				{
					$('._ajax_append').append('<div class="_ajax_loading _cola_codigo_sintoma"></div>');
				},
				cache: false,
				dataType: 'json',
				type: "POST",
				url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax_json/get_codigo_sintoma",
				data: "codigo_sintoma_id="+$(this).val(),
				success: function(json)
				{
					if(json.error!=1)
					{
						$(".codigo_sintoma_descripcion").html(json.response.descripcion);		
					}
					$('._cola_codigo_sintoma').remove();
				}
			});	
		});
		//inicio form lo ejectuto
		//$("input[name$='reclamo_garantia_codigo_sintoma_field_codigo_sintoma']").trigger('change');
		
		/*codigo de defecto*/
		$("input[name$='reclamo_garantia_codigo_defecto_id']").change(function(e)
		{
			$(".codigo_defecto_descripcion").html('');
			$.manageAjax.add('cola_codigo_defecto', 
			{
				beforeSend: function()
				{
					$('._ajax_append').append('<div class="_ajax_loading _cola_codigo_defecto"></div>');
				},
				cache: false,
				dataType: 'json',
				type: "POST",
				url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax_json/get_codigo_defecto",
				data: "codigo_defecto_id="+$(this).val(),
				success: function(json)
				{
					if(json.error!=1)
					{
						$(".codigo_defecto_descripcion").html(json.response.descripcion);		
					}
					$('._cola_codigo_defecto').remove();
				}
			});	
		});
		//inicio form lo ejectuto
		//$("input[name$='reclamo_garantia_codigo_defecto_field_codigo_defecto']").trigger('change');
		
		
		
		/*agregando bloque frt*/
		$(".add_multi_frt").click(function(e)
		{
			$('.add_frt').append($(".multi_frt").html());
			return false;
		});
		
		/*agregando bloque repuesto*/
		$(".add_multi_repuesto").click(function(e)
		{
			$('.add_repuesto').append($(".multi_repuesto").html());
			return false;
		});
		
		
		/*agregando bloque trabajo de tercero*/
		$(".add_multi_trabajo_tercero").click(function(e)
		{
			$('.bloque_trabajo_tercero').append($(".multi_trabajo_tercero").html());
			return false;
		});
		
		
		
		/*eliminando bloques dinamicos*/
		$(".eliminar_bloque").livequery('click', function(e)

		{
			$(this).parents("div.bloque").remove();
			calcular_precio();
			return false;
		});
		
		/*valores frt*/
		$("input[name$='frt[]']").livequery('keyup', function(e)
		{
			
			var input = $(this);
			$(this).parents("li").next('li').find("input[name$='frt_hora[]']").attr('readonly', 'readonly');
			if(!es_frt_valido($(this).val()))
			{
				
				//$(this).parents('li').css('background-color', 'red');
				$(this).parents("li").next('li').find("input[name$='frt_hora[]']").val('');
				$(this).parents("div.bloque").find(".frt_descripcion").html('');
				$(this).parents("li").next('li').find("input[name$='frt_hora[]']").trigger('keyup');
				
				return false;
			}
			var aux_hora = $(this).parents("li").next('li').find("input[name$='frt_hora[]']").val();
			
			$.manageAjax.add('cola_frt_hora', 
			{
				beforeSend: function()
				{
					$('._ajax_append').append('<div class="_ajax_loading _cola_frt_hora"></div>');
				},
				cache: false,
				dataType: 'json',
				type: "POST",
				url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax_json/get_frt_hora",
				data: "frt_id="+$(this).val()+"&unidad_field_vin="+$('#unidad_field_vin').val(),
				success: function(json)
				{
					if(json.error!=1)
					{
						input.parents("li").next('li').find("input[name$='frt_hora[]']").val(json.response.horas);
						input.parents("div.bloque").find(".frt_descripcion").html(json.response.descripcion);
						if(json.response.custom==1)
						{
							input.parents("li").next('li').find("input[name$='frt_hora[]']").removeAttr("readonly");
							input.parents("li").next('li').find("input[name$='frt_hora[]']").val(aux_hora);
						}						
						input.parents("li").next('li').find("input[name$='frt_hora[]']").trigger('keyup');
					}
					$('._cola_frt_hora').remove();
				}
			});

						
			
		});
		
		/*nombre del repuesto*/
		$("input[name$='repuesto[]']").livequery('change', function(e)
		{
			
			var input = $(this);
			$(this).parents('div.bloque').find(".repuesto_descripcion").html('');
			$.manageAjax.add('cola_repuesto_nombre', 
			{
				beforeSend: function()
				{
					$('._ajax_append').append('<div class="_ajax_loading _cola_repuesto_nombre"></div>');
				},
				cache: false,
				dataType: 'json',
				type: "POST",
				url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax_json/get_material_descripcion",
				data: "material_id="+input.val(),
				success: function(json)
				{
					if(json.error!=1)
					{
						input.parents('div.bloque').find(".repuesto_descripcion").html(json.response.descripcion);
					}
					input.parents('div.bloque').find("input[name$='factura_sap[]']").trigger("change");
					$('._cola_repuesto_nombre').remove();
					
				}
			});	
			
			
		
			
		
		});
		
		
		/*precio del repuesto*/
		$("input[name$='factura_sap[]']").livequery('change', function(e)
		{
			
			
			var input = $(this);
			//blanqueo precio unitario
			input.parents('div.bloque').find("input[name$='repuesto_precio_unitario[]']").val(0);
			//actualizo precio del repuesto
			input.parents('div.bloque').find("input[name$='repuesto_cantidad[]']").trigger("keyup");
			var material = input.parents('div.bloque').find("input[name$='repuesto[]']");
			
			if(material.length ==0)
			{
				return false;
			}
			$.manageAjax.add('cola_repuesto_precio', 
			{
				beforeSend: function()
				{
					$('._ajax_append').append('<div class="_ajax_loading _cola_repuesto_precio"></div>');
				},
				cache: false,
				dataType: 'json',
				type: "POST",
				
				<?php // a ver si busco precio fob o comun...
					$url_precio = 'get_material_precio';
					if(isset($GARANTIA_VERSION) && $GARANTIA_VERSION=='JAPON')
					$url_precio = 'get_material_precio_fob';
				?>
				url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax_json/<?php echo $url_precio;?>",
				data: "material="+material.val()+"&factura="+input.val()+"&sucursal=252&tsi_id="+$("select[name$='tsi_id']").val(),
				success: function(json)
				{
					
					if(json.error!=1)
					{
						input.parents('div.bloque').find("input[name$='repuesto_precio_unitario[]']").val(json.response.valor.toFixed(2));
						input.parents('div.bloque').find("input[name$='repuesto_cantidad[]']").trigger("keyup");
					}
					$('._cola_repuesto_precio').remove();
				}
			});	
		});
		
		
		/*cantidad de repuestos*/
		$("input[name$='repuesto_cantidad[]']").livequery('keyup', function(e)
		{
			var input = $(this);
			var precio = input.parents('li').find("input[name$='repuesto_precio_unitario[]']").val();
			var repuesto = input.parents('div').find("input[name$='repuesto[]']");
			var fix_bateria = 1;
			/*regla especial para bateria*/
			if(repuesto.hasClass('_material_principal'))
			{
				if (repuesto.val().match(regexp_bateria) && parseFloat($("#unidad_field_edad_meses").val())>24 ) 
				{
					var fix_bateria = 0.5; //el repuesto vale la mitad
					/*paso los frt a 0*/
					$("input[name$='frt_hora[]']").each(function()
					{
						$(this).val(0);
					});
				}
				
			}
			/*regla especial para bateria*/
			if(is_numeric(precio) && is_numeric(input.val()))
			{
				input.parents('li').find("input[name$='repuesto_precio_total[]']").val((precio*input.val()).toFixed(2)*fix_bateria);
			}else{
				input.parents('li').find("input[name$='repuesto_precio_total[]']").val(0);
			}
			
			
			
			
			calcular_precio();
		});
		
		
		/*transporte cambia precio*/
		$("input[name$='reclamo_garantia_version_field_valor_transporte']").livequery('keyup', function(e)
		{
			calcular_precio();
		});
		/*trabajo de tercero cambia precio*/
		$("input[name$='trabajo_tercero_importe[]']").livequery('keyup', function(e)
		{
			calcular_precio();
		});
		/*frt hora cambia precio*/
		$("input[name$='frt_hora[]']").livequery('keyup', function(e)
		{
			calcular_precio();
		});
		
		
		function calcular_precio()
		{
			
			var precio_total = parseFloat(0);
			var precio_subtotal = parseFloat(0);
			var precio_repuestos = parseFloat(0);
			var precio_transporte = parseFloat(0);
			var precio_trabajo_tercero = parseFloat(0);
			var ingresos_brutos = parseFloat($("#reclamo_ingresos_brutos").html());
			var precio_mano_nombra = parseFloat(0);
			var reclamo_costo_mano_obra = parseFloat($("#reclamo_costo_mano_obra").html());
			var reclamo_horas_mano_obra = parseFloat(0);
			
			if(is_numeric($("input[name$='reclamo_garantia_version_field_valor_transporte']").val()))
			{
				precio_total += parseFloat($("input[name$='reclamo_garantia_version_field_valor_transporte']").val());
				precio_transporte = parseFloat($("input[name$='reclamo_garantia_version_field_valor_transporte']").val());
			}
			
			
			
			$("input[name$='repuesto_precio_total[]']").each(function(){
				if(is_numeric($(this).val()))
				{
					var precio = parseFloat($(this).val());
					<?php if(isset($GARANTIA_VERSION) && $GARANTIA_VERSION == 'JAPON'):?>
						//multiplico por valor alca si es japon...
						precio = precio * parseFloat($("input[name$='reclamo_garantia_field_valor_alca']").val());
					<?php endif;?>
					precio_total += precio;
					precio_repuestos += precio;
				}
			});
			
			$("input[name$='trabajo_tercero_importe[]']").each(function(){
				if(is_numeric($(this).val()))
				{
					precio_total += parseFloat($(this).val());
					precio_trabajo_tercero += parseFloat($(this).val());
				}
			});
			
			
			$("input[name$='frt_hora[]']").each(function(){
				
				if(is_numeric($(this).val()))
				{	
					
					reclamo_horas_mano_obra += parseFloat($(this).val());
					precio_mano_nombra += parseFloat($(this).val() * reclamo_costo_mano_obra);
					precio_total += parseFloat($(this).val() * reclamo_costo_mano_obra);
				}
			});
			
			
			
			
			/*
			$("span.subtotal").html(total.toFixed(2));
		var porcentajeSumar = (total*ingresos_brutos)/100
		var totalIngreosBrutos = total+porcentajeSumar;
		$("span.total_reclamo").html(totalIngreosBrutos.toFixed(2));
			*/
			
			precio_subtotal = precio_total;
			
			$("#reclamo_precio_repuestos").html(precio_repuestos.toFixed(2));
			$("#reclamo_precio_transporte").html(precio_transporte.toFixed(2));
			$("#reclamo_precio_trabajo_tercero").html(precio_trabajo_tercero.toFixed(2));
			$("#reclamo_precio_mano_obra").html(precio_mano_nombra.toFixed(2));
			$("#reclamo_precio_subtotal").html(precio_subtotal.toFixed(2));
			$("#reclamo_horas_mano_obra").html(reclamo_horas_mano_obra.toFixed(2));
			<?php if($this->router->method=='add' OR $this->router->method=='show' OR (isset($GARANTIA_VERSION) AND $GARANTIA_VERSION != 'JAPON')):?>
				//sumo ingresos brutos
				precio_total += (precio_total*ingresos_brutos)/100
			<?php endif;?>
			$("#reclamo_precio_total").html(precio_total.toFixed(2));
			
			
		}
		
		
		/*------------- codigo defecto --------------*/
		//dialog codigo defcto
		$( "#buscador_codigo_defecto" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode",
			height: 500,
			width: 600,
		});

		$(".buscador_codigo_defecto" ).livequery('click', function(e)
		{
			
			var link = $(this);
			$('.buscador_codigo_defecto_respuesta').html('');
			
			$( "#buscador_codigo_defecto" ).dialog( "open" );
			$.manageAjax.add('cola_buscador_defecto', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_buscador_defecto"></div>');
					},
					cache: true,
					dataType: 'json',
					type: "POST",
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_reclamo_garantia_codigo_defecto_seccion",
					data: "seccion_id="+link.attr('id'),
					success: function(respuesta)
					{
						
						$('.buscador_codigo_defecto_respuesta').html(respuesta);
						$('._cola_buscador_defecto').remove();
					}
				});	
				
			return false;
		});
		
		$(".buscador_codigo_defecto_resultado").livequery('click', function(e)
		{
			$( "#buscador_codigo_defecto" ).dialog( "close" );
			$("input[name$='reclamo_garantia_codigo_defecto_id']").val($(this).attr('id'));
			$("input[name$='reclamo_garantia_codigo_defecto_id']").trigger('change');
			$('.buscador_codigo_defecto_respuesta').html('');
			return false;
		});	
		
		
		/*------------- fin codigo defecto --------------*/
		
		/*------------- codigo sintoma --------------*/
		//dialog codigo sintoma
		$( "#buscador_codigo_sintoma" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode",
			height: 500,
			width: 600,
		});

		$(".buscador_codigo_sintoma" ).livequery('click', function(e)
		{
			
			var link = $(this);
			$('.buscador_codigo_sintoma_respuesta').html('');
			$( "#buscador_codigo_sintoma" ).dialog( "open" );
			$.manageAjax.add('cola_buscador_sintoma', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_buscador_sintoma"></div>');
					},
					cache: true,
					dataType: 'json',
					type: "POST",
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_reclamo_garantia_codigo_sintoma_seccion",
					data: "seccion_id="+link.attr('id'),
					success: function(respuesta)
					{
						
						$('.buscador_codigo_sintoma_respuesta').html(respuesta);
						$('._cola_buscador_sintoma').remove();
						
					}
				});	
				
			return false;
		});
		
		$(".buscador_codigo_sintoma_resultado").livequery('click', function(e)
		{
			$("#buscador_codigo_sintoma").dialog( "close" );
			$("input[name$='reclamo_garantia_codigo_sintoma_id']").val($(this).attr('id'));
			$("input[name$='reclamo_garantia_codigo_sintoma_id']").trigger('change');
			$('.buscador_codigo_sintoma_respuesta').html('');
			return false;
		});	
		
		
		/*------------- fin codigo sintoma --------------*/
		
		/*------------- buscador frt --------------*/
		//dialog buscador frt
		$( "#buscador_frt" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode",
			height: 500,
			width: 600,
		});

		$(".buscador_frt" ).livequery('click', function(e)
		{
			
			link = $(this);
			if(link.attr('rel') =='form')
			{
				link_frt = link;
			}
			$('.buscador_frt_respuesta').html('');
			
			$( "#buscador_frt" ).dialog( "open" );
			$.manageAjax.add('cola_buscador_frt', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_buscador_frt"></div>');
					},
					cache: true,
					dataType: 'json',
					type: "POST",
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_frt_seccion",
					data: "seccion_id="+link.attr('id')+"&vin="+$('#unidad_field_vin').val(),
					success: function(respuesta)
					{
						
						$('.buscador_frt_respuesta').html(respuesta);
						$('._cola_buscador_frt').remove();	
					}
				});	
				
			return false;
		});
		
		$(".buscador_frt_resultado").livequery('click', function(e)
		{
			
			$("#buscador_frt").dialog( "close" );
			link_frt.parents('li').find("input[name$='frt[]']").val($(this).attr('id'));
			link_frt.parents('li').find("input[name$='frt[]']").trigger('keyup');
			//$("input[name$='reclamo_garantia_codigo_sintoma_field_codigo_sintoma']").val($(this).attr('id'));
			//$("input[name$='reclamo_garantia_codigo_sintoma_field_codigo_sintoma']").trigger('change');
			$('.buscador_frt_respuesta').html('');
			return false;
		});	
		
		
		/*------------- buscador frt --------------*/
		
	
		
		calcular_precio();
		
		
		
		
		
		
		
		
		
		/*------------- campanias --------------*/
		
		$("select[name$='reclamo_garantia_campania_id']").change(function(e)
		{
			
			var campania_id = $(this).val();
			
			$('.bloque_campania_custom').hide();
			
			if(campania_id!=0)
			{
				$.manageAjax.add('cola_campania', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_campania"></div>');
					},
					cache: false,
					dataType: 'json',
					type: "POST",
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax_json/get_reclamo_garantia_campania",
					data: "campania_id="+campania_id+"&vin="+$('#unidad_field_vin').val(),
					success: function(json)
					{
						if(json.error!=1)
						{
							
							/*elimino bloques secundarios....*/
							$("div.add_repuesto .bloque").each(function()
							{
								$(this).remove()
							});
							$("div.add_frt .bloque_frt").each(function()
							{
								$(this).remove()
							});
							
							
							
							var repuestos = json.response.repuestos;
							$.each(repuestos, function(i,item)
							{
								if(i==0)
								{
									$('div.bloque_repuesto').find("input[name$='repuesto[]']").val(item.material);
									$('div.bloque_repuesto').find("input[name$='factura_sap[]']").val('');
									$('div.bloque_repuesto').find("input[name$='precio_unitario[]']").val('');
									$('div.bloque_repuesto').find(".repuesto_descripcion").html(item.material_desc);
									$('div.bloque_repuesto').find("input[name$='repuesto_cantidad[]']").val(item.cantidad);
									$('div.bloque_repuesto').find("input[name$='repuesto_cantidad[]']").trigger('keyup');
								}else{
									//a agregar bloques se ha dicho...
									$('.add_multi_repuesto').trigger('click');
									$('div.add_repuesto div.bloque:last').find("input[name$='repuesto[]']").val(item.material);
									$('div.add_repuesto div.bloque:last').find("input[name$='factura_sap[]']").val('');
									$('div.add_repuesto div.bloque:last').find("input[name$='precio_unitario[]']").val('');
									$('div.add_repuesto div.bloque:last').find(".repuesto_descripcion").html(item.material_desc);
									$('div.add_repuesto div.bloque:last').find("input[name$='repuesto_cantidad[]']").val(item.cantidad);
									$('div.add_repuesto div.bloque:last').find("input[name$='repuesto_cantidad[]']").trigger('keyup');
								}
							});
							
							var frts = json.response.frts;
							$.each(frts, function(i,item)
							{
								if(i==0)
								{
									$('div.add_frt').find("input[name$='frt[]']").val(item.frt);
									$('div.add_frt').find("input[name$='frt_hora[]']").val(item.horas);
									$('div.add_frt').find(".frt_descripcion").html(item.frt_descripcion);
								}else{
									$('.add_multi_frt').trigger('click');
									$('div.add_frt div.bloque:last').find("input[name$='frt[]']").val(item.frt);
									$('div.add_frt div.bloque:last').find("input[name$='frt_hora[]']").val(item.horas);
									$('div.add_frt div.bloque:last').find(".frt_descripcion").html(item.frt_descripcion);
								}
							});
							
							if(campania_id =='5SD')
							{
								$(".campania_custom").show();
								$(".campania_5SD").show();
							}
							
						}
						$('._cola_campania').remove();
					}
				});	
			}
		
		calcular_precio();
		
		});
		/*------------- campanias --------------*/
		
		
	}); 
</script>




<div id="tabs">
		
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		
		<?php if (set_value('reclamo_garantia_field_problemas') == 1):?>
			<div class="mensaje_sistema">
				<div class="info_error" style="background-image:none;">
					<?php echo lang('garantia_problemas');?>
				</div>
			</div>
		<?php endif;?>
		
		
		<?php if(set_value('reclamo_garantia_field_mantenimientos_esperados')):?>
		<div class="mensaje_sistema">
			<?php if(set_value('reclamo_garantia_field_mantenimientos_esperados') <= set_value('reclamo_garantia_field_mantenimientos_realizados')):?>
				<div class="info_ok" style="background-image:none;">
			<?php else:?>
				<div class="info_error" style="background-image:none;">
			<?php endif;?>
				<?php echo lang('mantenimientos_realizados');?>: <strong><?php echo set_value('reclamo_garantia_field_mantenimientos_realizados');?></strong> / <?php echo lang('mantenimientos_esperados');?>: <strong><?php echo set_value('reclamo_garantia_field_mantenimientos_esperados');?></strong> 
				</div>
		</div>
		<?php endif;?>
		
		
		<?php if(set_value('kilometros') && set_value('kilometros')>$this->r_garantia->get_kilometros_maximos()):?>
			<div class="mensaje_sistema">
				<div class="info_error" style="background-image:none;">
					Kilometraje máximo excedido <strong>(<?php echo set_value('kilometros');?>)</strong> 
				</div>
			</div>
		<?php endif;?>
		
		
		
		
		<?php if(set_value('unidad_estado_garantia_id')):?>
			<div class="mensaje_sistema">
				<?php if(set_value('unidad_estado_garantia_id') == 1):?>
					<div class="info_ok" style="background-image:none;">
				<?php else:?>
					<div class="info_error" style="background-image:none;">
				<?php endif;?>
						<?php echo lang('unidad_estado_garantia_id');?>: <strong><?php echo set_value('unidad_estado_garantia_field_desc');?></strong>
					</div>
			</div>
		<?php endif;?>
		
		
		
		
		
		<?if(isset($GARANTIA_VERSION)){
			$aux_base_url = base_url() . $this->config->item('backend_root') . $this->router->class . '/' . $this->router->method . '/' . $id . '/';
		?>
			<div class="noticia_titulo">
				<?php echo lang('version') .": ". $GARANTIA_VERSION;?> <?php if(isset($current_record)) echo '#'.$current_record;?> 
				<?php if($this->router->method!='add' && $this->backend->_permiso('admin') && $estado_actual!=3):?>
					<div class="fr">( <?php echo anchor( base_url() . $this->config->item('backend_root') . $this->router->class . '/reset/' .$id . '/','reset' ) ;?> )</div>
				<?php endif; ?>
			</div>
			<div class="f-left">
				<?php if($this->router->method!='add' && $this->backend->_permiso('admin')):?>
					
					<?php if($GARANTIA_VERSION!='CONCESIONARIO'):?>
						<?php echo anchor( $aux_base_url . 'CONCESIONARIO' , lang('version') . ' CONCESIONARIO', "");?>
					<?php endif; ?>
					<?php if($GARANTIA_VERSION!='HONDA'):?>
						<?php echo anchor( $aux_base_url . 'HONDA' , lang('version') . ' HONDA', "");?>
					<?php endif; ?>
					<?php if($GARANTIA_VERSION!='JAPON'):?>
						<?php if(set_value('version_japon')):?>
							<?php echo anchor( $aux_base_url . 'JAPON' , lang('version') . ' JAPON', "");?>
							
						<?php elseif(!in_array($estado_actual,$estados_bloqueados) AND $estado_actual != 13 ): ?>
							<?php echo anchor( $aux_base_url . 'JAPON/GENERAR' , ' GENERAR JAPON', "");?>
						<?php endif; ?>
					<?php endif; ?>
					
				<?php endif; ?>
				
			</div>
		<?
		}
		else if($this->router->method == 'show')
		{
			if(isset($current_record))
			{
				?>
				<div class="noticia_titulo">
				<?php
				echo 'Reclamo de Garantía #'.$current_record; 
				?>
				</div>
				<?
				
			}
		}
		?>
		
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
		?>
		<?php if(isset($current_record) ):?>
		
		
		<div class="botones_registros">
				<p><a id="versionimprenta" href="<?php echo $this->config->item('base_url').$this->config->item('backend_root');?>reclamo_garantia_bulk_print/show/<?php echo $current_record;?>" target="_bulkprint"><?=lang('imprimir');?></a></p>
			</div>
		<?php endif;?>
<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<?php
				$this->load->view( 'backend/_inc_unidad_form_view',array('basic_input'=>TRUE));
				?>
				
				<?php if(isset($GARANTIA_VERSION) && $GARANTIA_VERSION == 'HONDA'):?>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_estado_id');?></legend>
					
					<li class="unitx4 f-left">
						<?php if(in_array($estado_actual,$estados_bloqueados) ):?>
							
							<?php if($estado_actual == 9):?>
								<div class="info_error" style="border:0px;"><strong><?php echo $tabla_reclamo_garantia_estado[$estado_actual];?></strong><br /><?php echo set_value('reclamo_garantia_field_rechazo_motivo');?></div>
							<?php else:?>
								<div class="info_ok" style="border:0px;"><strong><?php echo $tabla_reclamo_garantia_estado[$estado_actual];?></strong></div>
							<?php endif;?>
							
							
							
						<?php else:?>
							<?php
							$config	=	array(
								'field_name'		=> 'reclamo_garantia_estado_id',
								'field_req'			=> FALSE,
								'field_selected'	=> FALSE,
								'label_class'		=> 'unitx2 first',
								'field_class'		=> '',
								'field_type'		=> 'text',
								'field_options'	=> $reclamo_garantia_estado_id
							);
							echo $this->marvin->print_html_select($config);
							?>
						<?php endif;?>
					</li>
					<li class="unitx4 f-left">
						
					</li>
					
				</fieldset>
				<?php endif;?>
				
				
				
				<?php if( ($this->router->method == 'show') OR (isset($GARANTIA_VERSION) && $GARANTIA_VERSION == 'JAPON') ):?>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_estado_id');?></legend>
					
					<li class="unitx4 f-left">
						<?php if($estado_actual == 9):?>
							<div class="info_error" style="border:0px;"><strong><?php echo $tabla_reclamo_garantia_estado[$estado_actual];?></strong></div>
						<?php elseif(in_array($estado_actual,array(2,3,13))):?>
							<div class="info_ok" style="border:0px;"><strong><?php echo $tabla_reclamo_garantia_estado[$estado_actual];?></strong></div>
						<?php else:?>
							<div class="info_ok" style="border:0px;color:#000;"><strong><?php echo $tabla_reclamo_garantia_estado[$estado_actual];?></strong></div>
						
						<?php endif;?>
						
						
					</li>
					<li class="unitx4 f-left">
						
					</li>
					
				</fieldset>
				
				<?php endif;?>
				
				
				
				
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_campania_id');?></legend>
					
					<li class="unitx4 f-left">
						<?php
						$config	=	array(
							'field_name'		=> 'reclamo_garantia_campania_id',
							'field_req'			=> FALSE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx2 first',
							'field_class'		=> '',
							'field_type'		=> 'text',
							'field_options'	=> $reclamo_garantia_campania_id
						);
						echo $this->marvin->print_html_select($config);
						?>
					</li>
					<li class="unitx4 f-left">
						
					</li>
					
				</fieldset>
				
				
				
				<?php
				if(!isset($tsi))
				{
					$tsi = set_value('Tsi');
				}
				if(is_array($tsi))
				{
					
					
					
					//ya tiene que existir un registro
					
					
					echo  $this->load->view( 'backend/miniviews/tsi_miniview',$tsi, TRUE );
					//echo  $this->load->view( 'backend/miniviews/sucursal_miniview',array('SUCURSAL'=>$tsi['Sucursal']), TRUE );
					//echo  $this->load->view( 'backend/miniviews/cliente_miniview',array('CLIENTE'=>$tsi['Cliente']), TRUE );
					
					/*
					
					echo $this->load->view( 'backend/_inc_miniviews_view',array(	
																			'REGISTRO_INFO'=>TRUE,
																			'TSI'=>$TSI,
																			'CLIENTE'=>$CLIENTE,
																			'SUCURSAL'=>$SUCURSAL
																			),true);
					*/
				}else{
				?>
				<fieldset>
				<legend><?php echo lang('tsi_id');?></legend>
				<li class="unitx8 f-left both">
				<div id="select_tsi" rel="<?php echo set_value('tsi_id')?>"></div>
				</li>
				</fieldset>
				<?
				}
				?>
				
				
				<?php if(isset($tsis_registrados)):?>
				<fieldset class="noprint">
					<legend><?php echo lang('tsi_registrados');?></legend>
						
						<li class="unitx8 f-left both">
							<table class="tabla_opciones" width="100%" cellspacing="0">
								<?php foreach($tsis_registrados as $tsi_registrado):?>
								<tr>
									<td><?php if($this->backend->_permiso('view',3021)):?><a href="<?= $this->config->item('base_url').$this->config->item('backend_root') . 'tsi_abm/show/' . $tsi_registrado['id'] ?>" class="always" target="_blanck"><?php endif;?><span><?php echo $tsi_registrado['id'];?></span><?php if($this->backend->_permiso('view',3021)):?></a><?php endif;?></td>
									<td><?php echo $this->marvin->mysql_date_to_form($tsi_registrado['tsi_field_fecha_de_egreso']);?></td>
									<td><?php echo $tsi_registrado['tsi_field_kilometros'];?> <?php echo lang('kilometros');?></td>
									<td><?php echo $tsi_registrado['Sucursal']['sucursal_field_desc'];?></td>
									<td><?php echo element('tsi_tipo_servicio_field_desc',$tsi_registrado['Many_Tsi_Tipo_Servicio']);?></td>
								</tr>
								<?php endforeach;?>
							</table>
							
						</li>
					</li>
				</fieldset>
				<?php endif;?>
				
				<?php if(isset($reclamos_registrados) && count($reclamos_registrados)>0):?>
				<fieldset class="noprint">
					<legend><?php echo lang('reclamos_registrados');?></legend>
						
						<li class="unitx8 f-left both">
							<table class="tabla_opciones" width="100%" cellspacing="0">
								<tr>
									<th style="width:50px;"><?php echo lang('id');?></th>
									<th><?php echo lang('fecha_rotura');?></th>
									<th><?php echo lang('kilometros_rotura');?></th>
									<th><?php echo lang('fecha_de_egreso');?></th>
									<th style="width:70px;"><?php echo lang('kilometros');?></th>
									<th style="width:70px;"><?php echo lang('reclamo_garantia_campania_id');?></th>
									<th style="width:150px;"><?php echo lang('material_id');?></th>
									<th><?php echo lang('reclamo_garantia_estado_id');?></th>
								</tr>
								<?php foreach($reclamos_registrados as $reclamo_registrado):?>
								<tr>
									<td><?php if($this->backend->_permiso('view',3071)):?><a href="<?= $this->config->item('base_url').$this->config->item('backend_root') . 'reclamo_garantia_abm/show/' . $reclamo_registrado['id'] ?>" class="always" target="_blanck"><?php endif;?><span><?php echo $reclamo_registrado['id'];?></span><?php if($this->backend->_permiso('view',3071)):?></a><?php endif;?></td>
									<td><?php echo $this->marvin->mysql_date_to_form($reclamo_registrado['Tsi']['tsi_field_fecha_rotura']);?></td>
									<td><?php echo $reclamo_registrado['Tsi']['tsi_field_kilometros_rotura'];?></td>
									<td><?php echo $this->marvin->mysql_date_to_form($reclamo_registrado['Tsi']['tsi_field_fecha_de_egreso']);?></td>
									<td><?php echo $reclamo_registrado['Tsi']['tsi_field_kilometros'];?></td>
									<td><?php echo $reclamo_registrado['reclamo_garantia_campania_id'];?></td>
									<td><?php echo str_replace('|','<br />',element('material_id',$reclamo_registrado));?></td>
									<td><?php echo $reclamo_registrado['Reclamo_Garantia_Estado']['reclamo_garantia_estado_field_desc'];?></td>
								</tr>
								<?php endforeach;?>
							</table>
							
						</li>
					</li>
				</fieldset>
				<?php endif;?>
				
				
				<fieldset class="bloque_campania_custom campania_custom<?php if(set_value('reclamo_garantia_campania_id')!='5SD'):echo ' hide';endif?>">
					<legend><?=lang('campania_datos_adicionales');?></legend>
					<div class="bloque_campania_custom campania_5SD<?php if(set_value('reclamo_garantia_campania_id')!='5SD'):echo ' hide';endif?>">
						<li class="unitx4 f-left">
							<?php
								$config	=	array(
									'field_name'		=>'reclamo_garantia_version_field_serie_inflador_original',
									'field_req'			=>FALSE,
									'label_class'		=>'unitx2 first',
									'field_class'		=>'',
									'field_type'		=>'text',
									);
								echo $this->marvin->print_html_input($config);
							?>
							<?php
								$config	=	array(
									'field_name'		=>'reclamo_garantia_version_field_serie_inflador_colocado',
									'field_req'			=>FALSE,
									'label_class'		=>'unitx2',
									'field_class'		=>'',
									'field_type'		=>'text',
									);
								echo $this->marvin->print_html_input($config);
							?>
						</li>
						<li class="unitx4 f-left">
						</li>
						
					</div>
				</fieldset>
				
				
				<fieldset class="no_campania">
				<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_id');?></legend>
				<li class="unitx4 f-left">
					
					<?php
					
					$config	=	array(
							'field_name'		=>'reclamo_garantia_version_field_fecha_rotura',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							);
					//	echo $this->marvin->print_html_calendar($config);
					?>
				
				</li>
				<li class="unitx4 f-left no_campania">
					
						<?php
						$config	=	array(
							'field_name'		=> 'reclamo_garantia_dtc_estado_id',
							'field_req'			=> TRUE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx1 first no_campania ',
							'field_class'		=> '',
							'field_type'		=> 'text',
							'field_options'	=> $reclamo_garantia_dtc_estado_id
						);
						echo $this->marvin->print_html_select($config);
						?>
						<?php
							$config	=	array(
								'field_name'		=>'reclamo_garantia_version_field_dtc_codigo',
								'field_req'			=>TRUE,
								'label_class'		=>'unitx1 no_campania reclamo_garantia_field_dtc_codigo',
								'field_class'		=>'',
								'field_type'		=>'text',
								);
							echo $this->marvin->print_html_input($config);
						?>
					
				</li>
				
				<li class="unitx4 f-left both no_campania">
				
					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_codigo_sintoma_id',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2 first ',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
					<label class="unitx1" style="margin-top:15px;"><a href="#" id="0" class="buscador_codigo_sintoma minibuscador"><?php echo lang('buscar');?></a></label>
				</li>
				
				<li class="unitx4 f-left no_campania">
					
					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_codigo_defecto_id',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
					<label class="unitx1" style="margin-top:15px;"><a href="#" id="0" class="buscador_codigo_defecto minibuscador"><?php echo lang('buscar');?></a></label>

				</li>
				
				<li class="unitx4 f-left both no_campania" style="padding-top:0px;padding-bottom:0px;"><span class="codigo_sintoma_descripcion respuesta_ajax"><?php echo set_value('reclamo_garantia_codigo_sintoma_field_desc');?></span></li>
				<li class="unitx4 f-left no_campania" style="padding-top:0px;padding-bottom:0px;"><span class="codigo_defecto_descripcion respuesta_ajax"><?php echo set_value('reclamo_garantia_codigo_defecto_field_desc');?></span></li>
				
				<li class="unitx4 f-left both">
					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_version_field_boletin_numero',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first no_campania',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				<li class="unitx4 f-left"></li>
				</fieldset>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('frt_id');?><a href="#" class="add_multi_frt"><?=lang('agregar');?></a></legend>
					<label class="desc"><?php echo lang('operacion_mano_obra');?></label>
					
					<div class="add_frt">
						<?php
						if(!isset($frt))
						{
							$frt= set_value('Reclamo_Garantia_Frt');
						}
						
						if(is_array($frt) && count($frt)>0)
						{
							reset($frt);
							while(list($key,$val)=each($frt))
							{
							
							?>
							<div class="bloque <?php if($key!=0){echo "bloque_frt";}?>">
								<li class="unitx2 f-left both">
									<label class="unitx1 first<?php if(isset($val['error'])){echo " error";}?>"><?echo lang('frt[]');?><span class="req">*</span>
										<input id="frt[]" name="frt[]" class="text field-frt[]" value="<?php echo $val['frt_id']?>" type="text">
									</label>
									<label class="unitx1" style="margin-top:15px;"><a href="#" id="" class="buscador_frt minibuscador" rel="form"><?php echo lang('buscar');?></a></label>
								</li>
								<li class="unitx1 f-left">
									<label class="unitx1 first<?php if(isset($val['error'])){echo " error";}?>"><?echo lang('frt_hora[]');?><span class="req">*</span>
										<input id="frt_hora[]" name="frt_hora[]" class="text field-frt_hora[]" value="<?php echo $val['reclamo_garantia_frt_field_frt_horas'];?>" <?php if(substr($val['frt_id'], -2)!=99){ echo 'readonly="readonly"';}?> type="text">
									</label>						
								</li>
								<li class="unitx5 f-left">
									<label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque <?if($key==0){ echo "hide";}?>"><?php echo lang('eliminar');?></a></label>
									
								</li>
								<li class="unitx8 both separador">
									<span class="frt_descripcion respuesta_ajax"><?php echo $val['reclamo_garantia_frt_field_frt_descripcion'];?></span>
								</li>
							</div>
						<?php
							}
						}else{
						?>	
							<div class="bloque">
								<li class="unitx2 f-left both">
									<label class="unitx1 first"><?echo lang('frt[]');?><span class="req">*</span>
										<input id="frt[]" name="frt[]" class="text field-frt[]" value="" type="text">
									</label>
									<label class="unitx1" style="margin-top:15px;"><a href="#" id="" class="buscador_frt minibuscador" rel="form"><?php echo lang('buscar');?></a></label>
								</li>
								<li class="unitx1 f-left">
									<label class="unitx1 first"><?echo lang('frt_hora[]');?><span class="req">*</span>
										<input id="frt_hora[]" name="frt_hora[]" class="text field-frt_hora[]" value=""  readonly="readonly" type="text">
									</label>						
								</li>
								<li class="unitx5 f-left">
									<label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque hide"><?php echo lang('eliminar');?></a></label>
								</li>
								<li class="unitx8 both separador">
									<span class="frt_descripcion respuesta_ajax"></span>
								</li>								
							</div>
						<?php
						}
						?>
					</div>
					
				</fieldset>
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('descripciones');?></legend>
				<li class="unitx8 no_campania">
				<?php
							$config	=	array(
							'field_name'		=>'reclamo_garantia_version_field_descripcion_sintoma',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx8',
							'field_class'		=>'',
							'textarea_rows'		=>3,
							'textarea_html'	=>FALSE
						);
						echo $this->marvin->print_html_textarea($config);
						?>
				</li>
				<li class="unitx8 no_campania">
				<?php
							$config	=	array(
							'field_name'		=>'reclamo_garantia_version_field_descripcion_diagnostico',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx8',
							'field_class'		=>'',
							'textarea_rows'		=>3,
							'textarea_html'		=>FALSE
						);
						echo $this->marvin->print_html_textarea($config);
						?>
				</li>
				<li class="unitx8 no_campania">
				<?php
							$config	=	array(
							'field_name'		=>'reclamo_garantia_version_field_descripcion_tratamiento',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx8',
							'field_class'		=>'',
							'textarea_rows'		=>3,
							'textarea_html'		=>FALSE
						);
						echo $this->marvin->print_html_textarea($config);
						?>
				</li>
				<li class="unitx8">
				<?php
							$config	=	array(
							'field_name'		=>'reclamo_garantia_version_field_observaciones',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx8',
							'field_class'		=>'',
							'textarea_rows'		=>3,
							'textarea_html'		=>FALSE
						);
						echo $this->marvin->print_html_textarea($config);
						?>
				</li>
				</fieldset>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('repuesto_principal');?></legend>
					<div class="bloque_repuesto">
						<div class="bloque">
							<?
							$repuesto_error = '';
							if(!isset($repuesto_principal))
							{
								$repuesto_principal= set_value('Reclamo_Garantia_Material_Principal');
							}
							if(!is_array($repuesto_principal))
							{
								$repuesto_principal = array();
							}
							if(isset($repuesto_principal['error']))
							{
								$repuesto_error = 'error';
							}
							
							if(!isset($repuesto_principal['reclamo_garantia_material_field_total']))
							{
								
								$repuesto_principal['reclamo_garantia_material_field_total'] = 0;
								if	(
								isset($repuesto_principal['reclamo_garantia_material_field_cantidad']) && is_numeric($repuesto_principal['reclamo_garantia_material_field_cantidad'])
								&& isset($repuesto_principal['reclamo_garantia_material_field_precio']) && is_numeric($repuesto_principal['reclamo_garantia_material_field_precio'])
								)
								{
									
									$repuesto_principal['reclamo_garantia_material_field_total'] = $repuesto_principal['reclamo_garantia_material_field_cantidad'] * $repuesto_principal['reclamo_garantia_material_field_precio'];
								}	
							}
							
							?>
							
							
							<li class="unitx5 f-left">
								<label class="unitx2 first <?php echo $repuesto_error;?>"><?echo lang('numero_repuesto');?><span class="req">*</span>
									<input id="repuesto[]" name="repuesto[]" class="text repuesto[] _material_principal" value="<?php if(isset($repuesto_principal['material_id'])){echo $repuesto_principal['material_id'];}?>" type="text">
								</label>
								
								
								<?php if($this->router->method=='add' OR (isset($GARANTIA_VERSION) AND $GARANTIA_VERSION != 'JAPON')):?>
								<label class="unitx2 <?php echo $repuesto_error;?>"><?echo lang('factura_sap');?>
									<input id="factura_sap[]" name="factura_sap[]" class="text factura_sap[]" value="<?php if(isset($repuesto_principal['material_facturacion_field_documento_sap_id'])){echo $repuesto_principal['material_facturacion_field_documento_sap_id'];}?>" type="text">
								</label>
								<?php else: ?>
									<input id="factura_sap[]" name="factura_sap[]" class="text factura_sap[]" value="" type="hidden">
								<?php endif;?>
								
							
							
							</li>
							<li class="unitx3 f-left">
								<label class="unitx1 first <?php echo $repuesto_error;?>"><?echo lang('cantidad');?><span class="req">*</span>
									<input id="repuesto_cantidad[]" name="repuesto_cantidad[]" class="text repuesto_cantidad[]" value="<?php if(isset($repuesto_principal['reclamo_garantia_material_field_cantidad'])){echo $repuesto_principal['reclamo_garantia_material_field_cantidad'];}?>" type="text">
								</label>
								
								<label class="unitx1"><?echo lang('precio_unitario');?>
									<input id="repuesto_precio_unitario[]" name="repuesto_precio_unitario[]" disabled="disabled" class="text repuesto_precio_unitario[]" value="<?php if(isset($repuesto_principal['reclamo_garantia_material_field_precio'])){echo $repuesto_principal['reclamo_garantia_material_field_precio'];}?>" type="text">
								</label>
								<label class="unitx1"><?echo lang('precio_total');?>
									<input id="repuesto_precio_total[]" name="repuesto_precio_total[]" disabled="disabled" class="text repuesto_precio_total[]" value="<?php if(isset($repuesto_principal['reclamo_garantia_material_field_total'])){echo $repuesto_principal['reclamo_garantia_material_field_total'];}?>" type="text">
								</label>
							</li>
							<li class="unitx8 both separador">
								<span class="repuesto_descripcion respuesta_ajax"><?php if(isset($repuesto_principal['Material']['material_field_desc'])){echo $repuesto_principal['Material']['material_field_desc'];}?></span>
							</li>
						</div>
					</div>
				</fieldset>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('repuesto_secundario');?> <a href="#" class="add_multi_repuesto"><?=lang('agregar');?></a></legend>
					<div class="add_repuesto">
					<?php 
						
						
						
						if(!isset($repuestos_secundarios))
						{
							$repuestos_secundarios = set_value('Reclamo_Garantia_Material_Secundario');
						}
						if(is_array($repuestos_secundarios) && !empty($repuestos_secundarios))
						{
							reset($repuestos_secundarios);
							while(list($key,$material)=each($repuestos_secundarios))
							{
							$repuesto_error='';
							if(isset($material['error']))
							{
								$repuesto_error = 'error';
							}
							$precio = 0;
							if	(
								isset($material['reclamo_garantia_material_field_cantidad']) && is_numeric($material['reclamo_garantia_material_field_cantidad'])
								&& isset($material['reclamo_garantia_material_field_precio']) && is_numeric($material['reclamo_garantia_material_field_precio'])
								)
							{
								$precio = $material['reclamo_garantia_material_field_precio'] * $material['reclamo_garantia_material_field_cantidad'];
							}	
							?>
								<div class="bloque">
									
									<li class="unitx4 f-left">
										<label class="unitx2 first <?php echo $repuesto_error;?>"><?echo lang('numero_repuesto');?><span class="req">*</span>
											<input id="repuesto[]" name="repuesto[]" class="text repuesto[]" value="<?php if(isset($material['material_id'])){echo $material['material_id'];}?>" type="text">
										</label>
										<?php if($this->router->method=='add' OR (isset($GARANTIA_VERSION) AND $GARANTIA_VERSION != 'JAPON')):?>
										<label class="unitx2 <?php echo $repuesto_error;?>"><?echo lang('factura_sap');?>
											<input id="factura_sap[]" name="factura_sap[]" class="text factura_sap[]" value="<?php if(isset($material['material_facturacion_field_documento_sap_id'])){echo $material['material_facturacion_field_documento_sap_id'];}?>" type="text">
										</label>
										<?php else: ?>
											<input id="factura_sap[]" name="factura_sap[]" class="text factura_sap[]" value="" type="hidden">
										<?php endif;?>
									</li>
									<li class="unitx1 f-left">
										<label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>
									</li>
									<li class="unitx3 f-left">
										<label class="unitx1 first <?php echo $repuesto_error;?>"><?echo lang('cantidad');?><span class="req">*</span>
											<input id="repuesto_cantidad[]" name="repuesto_cantidad[]" class="text repuesto_cantidad[]" value="<?php if(isset($material['reclamo_garantia_material_field_cantidad'])){echo $material['reclamo_garantia_material_field_cantidad'];}?>" type="text">
										</label>
										
										<label class="unitx1"><?echo lang('precio_unitario');?>
											<input id="repuesto_precio_unitario[]" name="repuesto_precio_unitario[]" disabled="disabled" class="text repuesto_precio_unitario[]" value="<?php if(isset($material['reclamo_garantia_material_field_precio'])){echo $material['reclamo_garantia_material_field_precio'];}?>" type="text">
										</label>
										<label class="unitx1"><?echo lang('precio_total');?>
											<input id="repuesto_precio_total[]" name="repuesto_precio_total[]" disabled="disabled" class="text repuesto_precio_total[]" value="<?php echo $precio;?>" type="text">
										</label>
									</li>
									<li class="unitx8 both separador">
										<span class="repuesto_descripcion respuesta_ajax"><?php if(isset($material['Material']['material_field_desc'])){echo $material['Material']['material_field_desc'];}?></span>
									</li>
								</div>
							<?
							}
						}
					?>
					
					</div>
				</fieldset>
				
				<?php if(isset($GARANTIA_VERSION) && $GARANTIA_VERSION == 'JAPON'):?>
				<?php else:?>
				<fieldset class="no_campania">
					<?php $this->config->load('adjunto/reclamo_garantia_version_adjunto_transporte');	
						$config = $this->config->item('adjunto_upload');
					?>
					<legend><?=$this->marvin->mysql_field_to_human('varios');?> (<?php echo $config['allowed_types'];?>)</legend>
					<li class="unitx4 f-left">
						<?php
						
						$config	=	array(
							'field_name'		=>'reclamo_garantia_version_field_valor_transporte',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first no_campania',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
						?>
						
						<p><strong>(<?php echo lang('sin_impuestos');?>)</strong></p>
						
						
					</li>
					<li class="unitx4 f-left">
						
						<?php
							//cargo include de multiples adjuntos
							$config = array();
							$config['prefix'] = 'adjunto_transporte';
							$config['model'] = 'reclamo_garantia_version';
							if(isset($reclamo_garantia_version_adjunto_transporte) && count($reclamo_garantia_version_adjunto_transporte)>0)
							{
								$config['adjuntos'] = $reclamo_garantia_version_adjunto_transporte;
							}
							echo $this->load->view( 'backend/_adjunto_upload_view',$config,TRUE );
						?>
						
					</li>
				</fieldset>
				<?php endif;?>
				
				<?php $this->config->load('adjunto/reclamo_garantia_version_adjunto_trabajo_tercero');	
						$config = $this->config->item('adjunto_upload');
					?>
				<fieldset class="no_campania">
					<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_trabajo_tercero_id');?> (<?php echo $config['allowed_types'];?>) <a href="#" class="add_multi_trabajo_tercero"><?=lang('agregar');?></a></legend>
						<div class="bloque_trabajo_tercero">
							<?
							if(!isset($trabajo_tercero))
							{
								$trabajo_tercero = set_value('Reclamo_Garantia_Version_Trabajo_Tercero');
							}
							if(is_array($trabajo_tercero) && !empty($trabajo_tercero))
							{
								reset($trabajo_tercero);
								while(list($key,$trabajo)=each($trabajo_tercero))
								{
									$error = "";
									if(isset($trabajo['error']) && $trabajo['error']==TRUE)
									{
										$error = 'error';
									}
								?>
									<div class="bloque">
									<li class="unitx4 f-left both">
										<?php
										$config	=	array(
											'field_name'		=> 'reclamo_garantia_trabajo_tercero_id[]',
											'field_string'		=> 'reclamo_garantia_trabajo_tercero_id',
											'field_req'			=> FALSE,
											'field_selected'	=> $trabajo['reclamo_garantia_trabajo_tercero_id'],
											'label_class'		=> 'unitx3 first '.$error,
											'field_class'		=> '',
											'field_type'		=> 'text',
											'field_options'	=> $reclamo_garantia_trabajo_tercero_id
										);
										echo $this->marvin->print_html_select($config);
										?>
										
										<label class="unitx1 <?php echo $error;?>" for="trabajo_tercero_importe[]"><?echo lang('importe');?><span class="req"></span>
												<input id="trabajo_tercero_importe[]" name="trabajo_tercero_importe[]" class="text field-trabajo_tercero_importe[]" value="<? echo $trabajo['reclamo_garantia_version_trabajo_tercero_field_importe'];?>"  type="text">
										</label>		
									</li>
									<li class="unitx4 f-left"><?if($key!=0){?><label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label><?php } ?></li>
									
								</div>
								<?
								}
								
							}
							else
							{
							?>
							<div class="bloque">
								<li class="unitx4 f-left">
									<?php
									$config	=	array(
										'field_name'		=> 'reclamo_garantia_trabajo_tercero_id[]',
										'field_string'		=> 'reclamo_garantia_trabajo_tercero_id',
										'field_req'			=> FALSE,
										'field_selected'	=> FALSE,
										'label_class'		=> 'unitx3 first',
										'field_class'		=> '',
										'field_type'		=> 'text',
										'field_options'	=> $reclamo_garantia_trabajo_tercero_id
									);
									echo $this->marvin->print_html_select($config);
									?>
									
									<label class="unitx1 " for="trabajo_tercero_importe[]"><?echo lang('importe');?><span class="req"></span>
											<input id="trabajo_tercero_importe[]" name="trabajo_tercero_importe[]" class="text field-trabajo_tercero_importe[]" value=""  type="text">
									</label>		
								</li>
								<li class="unitx4 f-left">
								</li>
								
							</div>
							<?php
							}
							?>
							<p><strong>(<?php echo lang('sin_impuestos');?>)</strong></p>
							
						</div>
					<li class="unitx4 f-left both">
									
									<?php
										//cargo include de multiples adjuntos
										$config = array();
										$config['prefix'] = 'adjunto_trabajo_tercero';
										$config['model'] = 'reclamo_garantia_version';
										if(isset($reclamo_garantia_version_adjunto_trabajo_tercero) && count($reclamo_garantia_version_adjunto_trabajo_tercero)>0)
										{
											$config['adjuntos'] = $reclamo_garantia_version_adjunto_trabajo_tercero;
										}
										$this->load->view( 'backend/_adjunto_upload_view',$config );
									?>
									
								</li>
								<li class="unitx4 f-left">
								</li>
				</fieldset>
				<?php $this->config->load('adjunto/reclamo_garantia_version_adjunto_rth');	
						$config = $this->config->item('adjunto_upload');
					?>
				<fieldset class="no_campania">
					<legend><?=$this->marvin->mysql_field_to_human('rth');?> (<?php echo $config['allowed_types'];?>)</legend>
					<li class="unitx4 f-left">
						<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_version_field_rth',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
						?>
					</li>
					<li class="unitx4 f-left">
						
						<?php
							//cargo include de multiples adjuntos
							$config = array();
							$config['prefix'] = 'adjunto_rth';
							$config['model'] = 'reclamo_garantia_version';
							if(isset($reclamo_garantia_version_adjunto_rth) && count($reclamo_garantia_version_adjunto_rth)>0)
							{
								$config['adjuntos'] = $reclamo_garantia_version_adjunto_rth;
							}
						
							echo $this->load->view( 'backend/_adjunto_upload_view',$config,TRUE );
						?>
						
					</li>
				</fieldset>
				
				<?php if(isset($GARANTIA_VERSION) && $GARANTIA_VERSION == 'JAPON'):?>
					<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('coheficientes');?></legend>
					<li class="unitx4 f-left">
						<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_field_valor_alca',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
						?>
					</li>
					
				</fieldset>
				<?php endif;?>
				
				<?php if(isset($GARANTIA_VERSION) && $GARANTIA_VERSION == 'HONDA'):?>
					<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('coheficientes');?></legend>
					<li class="unitx4 f-left">
						<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_field_valor_dolar',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
						?>
					</li>
				</fieldset>
				<?php endif;?>
				
		
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('totales_reclamados');?></legend>
					<li class="unitx8 f-left">
					
						<table class="tabla_opciones" width="100%" cellpadding="10">
							<tr>
								<td><?php echo lang('total_repuestos');?></td>
								<td><?php echo $moneda;?>  <span id="reclamo_precio_repuestos"></span></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo lang('total_mano_obra');?></td>
								<td><?php echo $moneda;?> <span id="reclamo_precio_mano_obra"></span> <span style="font-size: 9px;">*</span></td>
								<td><span style="font-size: 9px;">*<?php echo lang('costo_mano_obra');?> <?php echo $moneda;?> <span id="reclamo_costo_mano_obra"><?php echo set_value('reclamo_garantia_version_field_valor_frt_hora');?></span>/h - * <?php echo lang('frt_reclamado');?> <span id="reclamo_horas_mano_obra"></span> <?php echo lang('horas');?></td>
							</tr>
							<tr>
								<td><?php echo lang('total_transporte');?></td>
								<td><?php echo $moneda;?> <span id="reclamo_precio_transporte"></span></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo lang('total_trabajo_tercero');?></td>
								<td><?php echo $moneda;?> <span id="reclamo_precio_trabajo_tercero"></span></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo lang('subtotal');?></td>
								<td><?php echo $moneda;?> <span id="reclamo_precio_subtotal"></span></td>
								<td></td>
							</tr>
							
							<?php if($this->router->method=='add' OR $this->router->method=='show' OR (isset($GARANTIA_VERSION) AND $GARANTIA_VERSION != 'JAPON')):?>
							
							<tr>
								<?php
								//estos son los ingresos brutos...
								?>
								<td><?php echo lang('gastos_de_facturacion');?></td>
								<td><span id="reclamo_ingresos_brutos"><?php echo set_value('reclamo_garantia_field_valor_ingresos_brutos');?></span> %</td>
								<td></td>
							</tr>
							<?php endif;?>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
							<tr>
								<td><span style="font-size: 15px;font-weight:bold;"><?php echo lang('total_reclamo');?></span></td>
								<td><span style="font-size: 15px;font-weight:bold;"><?php echo $moneda;?> <span id="reclamo_precio_total"></span></span></td>
								<td></td>
							</tr>				 
						</table>
					</li>
				</fieldset>
				
				<?php
				/*
				<fieldset>
				
				<li class="unitx4 f-left">
				

				

					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_field_evaluacion_tecnica',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						//echo $this->marvin->print_html_input($config); version honda
					?>

					

					

					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_field_valor_alca',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						//echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_field_valor_hora_japon',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						//echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_field_valor_dolar',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						//echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_field_valor_ingresos_brutos',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						//echo $this->marvin->print_html_input($config);
					?>

				

				
				
				

				<?php
					$config	=	array(
						'field_name'		=> 'reclamo_garantia_estado_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $reclamo_garantia_estado_id
					);
					//echo $this->marvin->print_html_select($config);
			?>

				<?php
					$config	=	array(
						'field_name'		=> 'reclamo_garantia_codigo_rechazo_principal_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $reclamo_garantia_codigo_rechazo_principal_id
					);
				//	echo $this->marvin->print_html_select($config);
			?>

				<?php
					$config	=	array(
						'field_name'		=> 'reclamo_garantia_codigo_rechazo_secundario_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $reclamo_garantia_codigo_rechazo_secundario_id
					);
					//echo $this->marvin->print_html_select($config);
			?>

				
					
		

			

		</li>
		<li class="unitx4 f-left">
			<!-- :P -->
		</li>
		</fieldset>
		*/
		?>
		
		<?php
		/*---- descomentar para imagenes
		?>
		
		<fieldset>
			<legend><?=lang('imagenes');?></legend>
		<?php
			//cargo include de multiples imagenes
			$config = array();
			$config['prefix'] = 'imagen';
			$config['images'] = array(); //inicializo por si tiene varios
			$config['model'] = strtolower($this->model);
			if(isset(MODELO_IMAGEN) && count(MODELO_IMAGEN)>0)
			{
				$config['images'] = MODELO_IMAGEN;
			}
			$this->load->view( 'backend/_imagen_upload_view',$config );
		?>
		
		</fieldset>
		*/
		?>
		
		<?php
		/*---- descomentar para adjuntos
		?>
		<fieldset>
			<legend><?=lang('adjuntos');?></legend>
		<?php
			//cargo include de multiples adjuntos
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			if(isset($reclamo_garantia_adjunto) && count($reclamo_garantia_adjunto)>0)
			{
				$config['adjuntos'] = $reclamo_garantia_adjunto;
			}
			$this->load->view( 'backend/_adjunto_upload_view',$config );
		?>
		
		</fieldset>
		*/
		?>
			
		</ul>
		<?php
			$this->load->view( 'backend/_inc_abm_submit_view' );	
		?>
</form>
</div>
</div>


<div class="multi_frt hide noprint">
	<div class="bloque bloque_frt">
		<li class="unitx2 f-left both">
			<label class="unitx1 first"><?echo lang('frt[]');?><span class="req">*</span>
				<input id="frt[]" name="frt[]" class="text field-frt[]" value="" type="text">
			</label>
			<label class="unitx1" style="margin-top:15px;"><a href="#" id="" class="buscador_frt minibuscador" rel="form"><?php echo lang('buscar');?></a></label>
		</li>
		<li class="unitx1 f-left">
			<label class="unitx1 first"><?echo lang('frt_hora[]');?><span class="req">*</span>
				<input id="frt_hora[]" name="frt_hora[]" class="text field-frt_hora[]" value=""  readonly="readonly" type="text">
			</label>						
		</li>
		<li class="unitx5 f-left">
			<label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>
			
		</li>
<li class="unitx8 f-left both separador">
			<span class="frt_descripcion respuesta_ajax"></span>
		</li>				
	</div>
</div>

<div class="multi_repuesto hide noprint">
	<div class="bloque">
					
					<li class="unitx4 f-left">
						<label class="unitx2 first"><?echo lang('numero_repuesto');?><span class="req">*</span>
							<input id="repuesto[]" name="repuesto[]" class="text repuesto[]" value="" type="text">
						</label>
						<?php if($this->router->method=='add' OR (isset($GARANTIA_VERSION) AND $GARANTIA_VERSION != 'JAPON')):?>
						<label class="unitx2"><?echo lang('factura_sap');?>
							<input id="factura_sap[]" name="factura_sap[]" class="text factura_sap[]" value="" type="text">
						</label>
						<?php else: ?>
							<input id="factura_sap[]" name="factura_sap[]" class="text factura_sap[]" value="" type="hidden">
						<?php endif;?>
					</li>
					<li class="unitx1 f-left">
					<label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>
					</li>
					<li class="unitx3 f-left">
						<label class="unitx1 first"><?echo lang('cantidad');?><span class="req">*</span>
							<input id="repuesto_cantidad[]" name="repuesto_cantidad[]" class="text repuesto_cantidad[]" value="" type="text">
						</label>
						
						<label class="unitx1"><?echo lang('precio_unitario');?>
							<input id="repuesto_precio_unitario[]" name="repuesto_precio_unitario[]" disabled="disabled" class="text repuesto_precio_unitario[]" value="" type="text">
						</label>
						<label class="unitx1"><?echo lang('precio_total');?>
							<input id="repuesto_precio_total[]" name="repuesto_precio_total[]" disabled="disabled" class="text repuesto_precio_total[]" value="" type="text">
						</label>
					</li>
					<li class="unitx8 both separador">
						<span class="repuesto_descripcion respuesta_ajax"></span>
					</li>
	</div>
</div>

<div class="multi_trabajo_tercero hide noprint">
	<div class="bloque">
		<li class="unitx4 f-left both">
		<?php
			$config	=	array(
						'field_name'		=> 'reclamo_garantia_trabajo_tercero_id[]',
						'field_string'		=> 'reclamo_garantia_trabajo_tercero_id',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $reclamo_garantia_trabajo_tercero_id
						);
			echo $this->marvin->print_html_select($config);
		?>
										
		<label class="unitx1 "><?echo lang('importe');?><span class="req"></span>
				<input id="trabajo_tercero_importe[]" name="trabajo_tercero_importe[]" class="text field-trabajo_tercero_importe[]" value=""  type="text">
		</label>		
		</li>
		<li class="unitx4 f-left"><label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label></li>
	</div>
</div>




<div id="buscador_codigo_defecto" class="hide noprint" title="<?php echo lang('buscar');?>: <?php echo lang('reclamo_garantia_codigo_defecto_id');?>">
	<p class="buscador_codigo_defecto_respuesta"></p>
</div>

<div id="buscador_codigo_sintoma" class="hide noprint" title="<?php echo lang('buscar');?>: <?php echo lang('reclamo_garantia_codigo_sintoma_id');?>">
	<p class="buscador_codigo_sintoma_respuesta"></p>
</div>
<div id="buscador_frt" class="hide noprint" title="<?php echo lang('buscar');?>: <?php echo lang('frt_id');?>">
	<p class="buscador_frt_respuesta"></p>
</div>






