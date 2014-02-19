<script type="text/javascript">
	
	
	
	
	
	function tsi_tipo_servicio()
	{
		var mantenimiento = false;
		var reparacion = false;
		$('input:checkbox[name=many_tsi_tipo_servicio[]]:checked').each(function() {
			if($(this).val()==1)
			{	
				mantenimiento = true;
			}
			if($(this).val()==2 || $(this).val()==7)
			{
				reparacion = true;
			}
		});
		
		if(mantenimiento)
		{
			$('#tsi_tipo_mantenimiento_id').show();
		}else{
			$('#tsi_tipo_mantenimiento_id').hide();
		}
		
		if(reparacion)
		{
			$('#tsi_motivo_reparacion_id').show();
		}else{
			$('#tsi_motivo_reparacion_id').hide();
		}
		
		
		
	}
	
	$(document).ready(function() {
	
	//alert($('select[name="sucursal_id"]').val());
	
	
	
	
	
	$(".remove_cliente").hide();
	
	<?php if($this->router->method == 'edit' AND !$this->backend->_permiso('admin') ):?>
	$('#tsi_field_fecha_rotura').attr('disabled', 'disabled');
	<?php endif;?>
	
	$.manageAjax.create('cola_recepcionistas', {queue: 'clear', maxRequests: 1, abortOld: true});
	$.manageAjax.create('cola_tecnicos', {queue: 'clear', maxRequests: 1, abortOld: true});
	
	tsi_tipo_servicio();
	$('input:checkbox[name=many_tsi_tipo_servicio[]]').change(function() {
		tsi_tipo_servicio();
	});
	

	
	
	$('.sucursal_id').change(function () {
		/*
		$.ajax({
			beforeSend: function(objeto){
				$('#_ajax_loading').show();
			},
			type: "POST",
			url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_recepcionistas",
			data: "sucursal_id="+$('.sucursal_id').val()+"&ajax=true",
			success: function(respuesta){			
				$(".recepcionistas").html(respuesta);
			return false;
			}
		});
		*/
		 $.manageAjax.add('cola_recepcionistas', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_recepcionistas"></div>');
					},
					type: "POST",
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_recepcionistas",
					data: "sucursal_id="+$('.sucursal_id').val()+"&ajax=true",
					success: function(respuesta)
					{
						$(".recepcionistas").html(respuesta);
						$('._cola_recepcionistas').remove();
					}
                });
		/*
		$.ajax({
			beforeSend: function(objeto){
				$('#_ajax_loading').show();
			},
			type: "POST",
			url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_tecnicos",
			data: "sucursal_id="+$('.sucursal_id').val()+"&ajax=true",
			success: function(respuesta){			
				$(".tecnicos").html(respuesta);
			return false;
			}
		});
		*/
		 $.manageAjax.add('cola_tecnicos', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_tecnicos"></div>');
					},
						type: "POST",
						url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_tecnicos",
						data: "sucursal_id="+$('.sucursal_id').val()+"&ajax=true",
					success: function(respuesta)
					{
						$(".tecnicos").html(respuesta);
						$('._cola_tecnicos').remove();
					}
                });
	});
	<?php
		if($this->router->method == 'add'):
	?>
		$("select[name='sucursal_id']").trigger('change');
	<?php
		endif;
	?>
			
}); 
</script>
<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		
		<?php
			$data_botones = FALSE;
			if(set_value('id'))
			{
				$estado = set_value('Tsi_Estado');
				echo  $this->load->view( 'backend/miniviews/record_miniview',array('registro_estado'=>$estado['tsi_estado_field_desc']), TRUE );
				if($estado['id'] == 9)
				{
					$data_botones=array('rechazado'=>TRUE);
				}
			}
		?>
		
		
		<?php
				$this->load->view( 'backend/esqueleto_botones_view',$data_botones );
		?>
<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>
				
				<?php
				$this->load->view( 'backend/_inc_unidad_form_view' );
				?>
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('tsi_id');?></legend>
				
				<li class="unitx4 f-left both">
			
			<?php
					$config	=	array(
						'field_name'		=> 'sucursal_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> 'sucursal_id',
						'field_type'		=> 'text',
						'field_options'	=> $sucursal_id
					);
					echo $this->marvin->print_html_select($config)
			?>
			<?php
						$config	=	array(
							'field_name'		=>'tsi_field_orden_de_reparacion',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
			
			
		</li>
				
				
		<li class="unitx4 f-left">
		</li>
		
		<li class="unitx4 f-left both">
	

					
				
				<label class="unitx3  first <?php if(form_error('tsi_field_admin_recepcionista_id')){ echo 'error';} ?>">
				<input type="hidden" id="tsi_field_recepcionista_old" name="tsi_field_recepcionista_old" value="<?=set_value('tsi_field_recepcionista_old')?>">
				<?=$this->marvin->mysql_field_to_human('tsi_field_admin_recepcionista_id');?> (<?=set_value('tsi_field_recepcionista_old')?>)
					<span class="recepcionistas">
					<?php echo form_dropdown('tsi_field_admin_recepcionista_id', $tsi_field_admin_recepcionista_id, set_value('tsi_field_admin_recepcionista_id'),'class="select"' )?>
					</span>
				</label>

				
				
				

					

				
		</li>
		
		<li class="unitx4 f-left">
			
			<label class="unitx3 first   <?php if(form_error('tsi_field_admin_tecnico_id')){ echo 'error';} ?>">
				<input type="hidden" id="tsi_field_admin_tecnico_old" name="tsi_field_admin_tecnico_old" value="<?=set_value('tsi_field_tecnico_old')?>">
				<?=$this->marvin->mysql_field_to_human('tsi_field_admin_tecnico_id');?> (<?=set_value('tsi_field_tecnico_old')?>)
					<span class="tecnicos">
					<?php echo form_dropdown('tsi_field_admin_tecnico_id', $tsi_field_admin_tecnico_id, set_value('tsi_field_admin_tecnico_id'),'class="select"' )?>
					</span>
				</label>
					
		</li>
		<li class="unitx4 f-left both">
			<?php
					$config	=	array(
							'field_name'		=>'tsi_field_fecha_rotura',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		<li class="unitx4 f-left">
			<?php
						$config	=	array(
							'field_name'		=>'tsi_field_kilometros_rotura',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_style'		=>'width:101px !important'
							);
						echo $this->marvin->print_html_input($config)
					?>
		</li>
		
		<li class="unitx4 f-left both">
			<?php
					$config	=	array(
							'field_name'		=>'tsi_field_fecha_de_ingreso',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx3 first', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		<li class="unitx4 f-left">
		</li>
		
		<li class="unitx4 f-left both">
			<?php
					$config	=	array(
							'field_name'		=>'tsi_field_fecha_de_egreso',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx3 first', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		<li class="unitx4 f-left">
			<?php
						$config	=	array(
							'field_name'		=>'tsi_field_kilometros',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
		</li>
		
		
		
		
		
		
		
		
		
		
		</fieldset>

			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('tsi_tipo_servicio_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'			=> 'many_tsi_tipo_servicio',
						'field_req'			=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'checkbox',
						'field_options'		=> $many_tsi_tipo_servicio
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

			<div id="tsi_tipo_mantenimiento_id">
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('tsi_tipo_mantenimiento_id');?></legend>
				<li class="unitx8">
					<?php
						$config	=	array(
							'field_name'		=> 'tsi_tipo_mantenimiento_id',
							'field_req'		=> FALSE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx2 first',
							'field_class'		=> 'tsi_tipo_mantenimiento_id',
							'field_type'		=> 'text',
							'field_options'	=> $tsi_tipo_mantenimiento_id
						);
						echo $this->marvin->print_html_select($config)
				?>
				</li>
				</fieldset>
			</div>
			
			<div id="tsi_motivo_reparacion_id">
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('tsi_motivo_reparacion_id');?></legend>
				<li class="unitx8">
				<?php
						$config	=	array(
							'field_name'		=> 'tsi_motivo_reparacion_id',
							'field_req'		=> FALSE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx2 first',
							'field_class'		=> 'tsi_motivo_reparacion_id',
							'field_type'		=> 'text',
							'field_options'	=> $tsi_motivo_reparacion_id
						);
						echo $this->marvin->print_html_select($config)
				?>
				</li>
				</fieldset>
			</div>
			
			<?php
				if(count($tsi_promocion_id)==1)
				{
					$tsi_promocion_id = array('') + $tsi_promocion_id;
				}
			?>
			<div id="tsi_promocion_id">
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('tsi_promocion_id');?></legend>
				<li class="unitx8">
					<?php
						$config	=	array(
							'field_name'		=> 'tsi_promocion_id',
							'field_req'		=> FALSE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx2 first',
							'field_class'		=> 'tsi_promocion_id',
							'field_type'		=> 'text',
							'field_options'	=> $tsi_promocion_id
						);
						echo $this->marvin->print_html_select($config)
				?>
				</li>
				</fieldset>
			</div>
			
			
			<fieldset>

		<legend><?=$this->marvin->mysql_field_to_human('propietario');?></legend>
		<div class="clientes">
			<?
			
			$datos['tsi_form'] = TRUE;
			if(isset($many_cliente) && is_array($many_cliente))
			{
				
				while(list(,$datos)=each($many_cliente))
				{
					
					
					//quita algunos input que no se piden en tsi....
					$datos['tsi_form'] = TRUE;
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
			}else{
				//quita algunos input que no se piden en tsi....
				$datos['tsi_form'] = TRUE;
				$datos['options_documento_tipo_id'] 		= $options_documento_tipo_id;
				$datos['options_sexo_id'] 					= $options_sexo_id;
				$datos['options_tratamiento_id']			= $options_tratamiento_id;
				$datos['options_provincia_id'] 				= $options_provincia_id;
				$datos['options_ciudad_id'] 				= array();
				$datos['options_cliente_conformidad_id'] 	= $options_cliente_conformidad_id;
				echo "<div class='cliente_ajax clearfix'>";			
					$this->load->view('backend/cliente_sucursal_abm_inc_view',$datos);
				echo "</div>";
			
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
