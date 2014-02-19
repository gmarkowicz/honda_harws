<?
if($this->router->method!=='show')
{
?>
<script type="text/javascript">

	$(document).ready(function() {
		
	$('.add_cliente').click(function() {
	
	
		$.ajax({
				beforeSend: function(objeto){
					$('#_ajax_loading').show();
				},
				type: "POST",
				url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_client_html_form/",
				//data: "noticia_imagen_titulo="+$("#_imagen_titulo").val()+"&noticia_imagen_copete="+$("#_imagen_copete").val(),
				success: function(respuesta){			
					$(".clientes").append('<div class="cliente_ajax">'+respuesta+'</div>');
				return false;
				}
			});

		return false;
	});
	
	$('.sucursal_id').change(function () {
		$.ajax({
			beforeSend: function(objeto){
				$('#_ajax_loading').show();
			},
			type: "POST",
			url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_vendedores",
			data: "sucursal_id="+$('.sucursal_id').val()+"&ajax=true",
			success: function(respuesta){			
				$(".vendedores").html(respuesta);
			return false;
			}
		});
	});
	
	
	
	
	<?php
	if($this->router->method=='add' && !isset($many_cliente))
	{
	?>
		$('.add_cliente').trigger('click');
	<?php
	}
	?>
	
	$('select[name="sucursal_id"]').trigger('change');
			
}); 
// using live() will bind the event to all future
// elements as well as the existing ones
$('.remove_cliente').live('click', function() {
    $(this).parent(".cliente_ajax").remove();

    return false;
});

</script>
<style>
.cliente_ajax{
	border-bottom:2px dotted #CCCCCC;
	padding-bottom:5px;
	margin-bottom:5px;
}
</style>
<?
}
?>


<?php if($this->router->method=='add'):?>

<script type="text/javascript">
//tiene una tg anterior?
$(document).ready(function() {
	$('input._unidad_field').keyup(function(e)
			{
				e.preventDefault();
				if(!es_unidad_valida())
				{
					return false;
				}
				
				$.manageAjax.add('cola_tg', 
				{
                    beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_tg"></div>');
					},
					  
				    url: "<?php echo site_url($this->config->item('backend_root').'ajax/get_has_tarjeta_garantia');?>/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val(),
					type: "GET",
					success: function(respuesta)
					{
						$('._cola_tg').remove();
						
						if(respuesta=='true')
						{	
							alert('ADVERTENCIA: usted esta a punto de registrar un cambio de titular');
						}
						return false;
									
					
					}

                });
                   
				return false;
			});
});
</script>

<?php endif; ?>


<script type="text/javascript">
$(document).ready(function() {

<!-- ajax pdi -->
		$(document).ready(function() {
			
			$('input._unidad_field').keyup(function(e)
			{
				e.preventDefault();
				if(!es_unidad_valida())
				{
					return false;
				}
				
				$.manageAjax.add('cola_pdi', 
				{
                    beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_pdi"></div>');
					},
					  
				    url: "<?php echo site_url($this->config->item('backend_root').'ajax/get_has_pdi');?>/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val(),
					type: "GET",
					success: function(respuesta)
					{
						$('._cola_pdi').remove();
						
						if(respuesta=='false')
						{	
							$('#_sin_pdi').show();
							return false;
						}else{
							
							$('#_sin_pdi').hide();
						}
									
					
					}

                });
                   
				return false;
			});
		});
		<!-- ajax unidad -->
});
</script>







<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="registro"><?=lang('registro');?></a></li>
		</ul>
		<div id="tabs-1">
		
		<?php
		$nos = $this->session->flashdata('encuesta_nos');
		if(is_array($nos)):
		?>
		
		<div class="notice light">
			<table class="miniview">
			<tr>
				<td><a href="<?php echo site_url( $this->config->item('backend_root') .'encuesta_nos_abm/add/'.$nos['unidad'].'/'.$nos['vin'] )?>"><?php echo $this->lang->line('ingresar_encuesta_nos');?></a></td>
			</tr>
			</table>
		</div>
		<?php endif;?>
			

		
		
		<?php
			$data_botones = FALSE;
			if(set_value('id'))
			{
				$estado = set_value('Tarjeta_Garantia_Estado');
				if($estado['id']==3 && $this->backend->_permiso('admin'))
				{
				?>
				<div class="notice_light clearfix">
					<div class="f-right">
						<a href="#" class="positive" id="aprobar_registro"><?=lang('aprobar_registro');?></a>
					</div>
				</div>
				<?
				}
				
				
				echo  $this->load->view( 'backend/miniviews/record_miniview',array(
																					'registro_estado'=>$estado['tarjeta_garantia_estado_field_desc'],
																					'rechazo_motivo'=>set_value('tarjeta_garantia_field_rechazo_motivo')
																			), TRUE );
				if($estado['id'] == 9)
				{
					$data_botones=array('rechazado'=>TRUE);
				}
			}
		
		$this->load->view( 'backend/esqueleto_botones_view',$data_botones );
		?>
		
		
		
		
		
		<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		
		<ul>
	
				
				<?php
				$this->load->view( 'backend/_inc_unidad_form_view' );
				?>
				
				<li class="unitx8 hide" id="_sin_pdi">
					<table class="miniview">
					<tr>
						<td><?php echo lang('unidad_sin_pdi');?></td>
					</tr>
					
					</table>
				</li>
				
				
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('tarjeta_garantia_id');?></legend>
				<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'sucursal_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx3 first',
						'field_class'=>'sucursal_id',
						'field_type'=>'text',
						'field_options'=>$sucursal_id
					);
					echo $this->marvin->print_html_select($config)
			?>
				
				
				<label class="unitx2   <?php if(form_error('tarjeta_garantia_field_admin_vende_id')){ echo 'error';} ?>">
				<input type="hidden" id="tarjeta_garantia_field_vendedor_nombre_aux" name="tarjeta_garantia_field_vendedor_nombre_aux" value="<?=set_value('tarjeta_garantia_field_vendedor_nombre_aux')?>">
				<?=$this->marvin->mysql_field_to_human('tarjeta_garantia_field_admin_vende_id');?> (<?=set_value('tarjeta_garantia_field_vendedor_nombre_aux')?>)
					<span class="vendedores">
					<?php echo form_dropdown('tarjeta_garantia_field_admin_vende_id', $tarjeta_garantia_field_admin_vende_id, set_value('tarjeta_garantia_field_admin_vende_id'),'class="select"' )?>
					</span>
				</label>
				
				
				
				
				
				<?php
					$config	=	array(
							'field_name'=>'tarjeta_garantia_field_fecha_entrega',
							'field_req'=>TRUE,
							'label_class'=>'unitx2 ', //first
							'field_class'=>'',
							
							);
						echo $this->marvin->print_html_calendar($config)
					?>
				
				<?/*

				<span>
					<label <?php if(form_error('admin_vende_id')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('sucursal_vendedor_id');?> (<?php echo set_value('tarjeta_garantia_field_vendedor_nombre_aux'); ?>) <span class="req">*</span></label>
					<div class="vendedores">
						<?php echo form_dropdown('admin_vende_id', $tarjeta_garantia_field_admin_vende_id, set_value('tarjeta_garantia_field_admin_vende_id'),'class="field" style="width:260px;"' )?>
					</div>
				</span>
				*/
				?>				
		</li>
		
		</fieldset>

		
		<fieldset>

		<legend><?=$this->marvin->mysql_field_to_human('propietario');?>
		
		<?
		if($this->router->method!=='show')
		{
		?>
			<a href="#" class="add_cliente"><?=lang('agregar');?></a>
		<?
		}
		?>
		</legend>
		
		<div class="clientes">
			<?
			
			
		
			
			
			//$many_cliente=set_value('many_cliente');
			
			
			
			if(isset($many_cliente) && is_array($many_cliente))
			{
				while(list(,$datos)=each($many_cliente))
				{
					
					
					$datos['options_documento_tipo_id'] 		= $options_documento_tipo_id;
					$datos['options_sexo_id'] 					= $options_sexo_id;
					$datos['options_tratamiento_id']			= $options_tratamiento_id;
					$datos['options_provincia_id'] 				= $options_provincia_id;
					$datos['options_ciudad_id'] 				= $datos['options_ciudad_id'];
					$datos['options_cliente_conformidad_id'] 	= $options_cliente_conformidad_id;
					echo "<div class='cliente_ajax clearfix'>";			
						$this->load->view('backend/cliente_sucursal_abm_inc_view',$datos);
					echo "</div>";
				}
			}
			?>
		</div>
		
		</fieldset>

	</ul>
		<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
		?>
</form>
</div>
</div>
