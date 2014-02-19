

	<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
			<li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
		</ul>
		<div id="tabs-1">
			<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
			?>
			
			<?php if($this->backend->_permiso('admin')):?>
			
			<div class="botones_registros">
				<p><a id="versionimprenta" href="#"><?=lang('imprimir');?></a></p>
			</div>
			<?php endif;?>
								
			<div class="grilla">
					<table id="flex1" style="display:none"></table>
			</div>
								
			</div>
	
	<div id="tabs-2">
		<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>


		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('fecha');?></legend>
		
		
		<li class="unitx4 f-left">
				<?php
					$config	=	array(
							'field_name'=>'tsi_field_fecha_rotura_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'tsi_field_fecha_rotura_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		</li>
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'=>'tsi_field_fecha_de_egreso_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'tsi_field_fecha_de_egreso_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		</li>
		
		<li class="unitx4 f-left">
		<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_field_fechahora_alta_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_field_fechahora_alta_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		</li>
		<li class="unitx4 f-left">
		
			<?php
					$config	=	array(
							'field_name'=>'unidad_field_fecha_entrega_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'unidad_field_fecha_entrega_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		
		</li>
		
		<li class="unitx4 f-left">
		
			<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_field_fechahora_pre_aprobacion_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_field_fechahora_pre_aprobacion_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		
		</li>
		
		<li class="unitx4 f-left">
		
			<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_field_fechahora_aprobacion_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_field_fechahora_aprobacion_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		
		</li>
		
		</fieldset>
		
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_id');?></legend>
		
				
				<li class="unitx4 f-left">
				<?php
				$config	=	array(
								'field_name'=>'reclamo_id',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				
				
				</li>
				<li class="unitx4 f-left">
				<?php
				$config	=	array(
								'field_name'=>'reclamo_garantia_field_codigo_sintoma',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'reclamo_garantia_field_codigo_defecto',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				</li>
				<li class="unitx4 f-left">
					<?php
						$config	=	array(
								'field_name'=>'material_id',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				</li>
				<li class="unitx4 f-left">
					<?php
						$config	=	array(
								'field_name'=>'reclamo_garantia_material_field_material_principal',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
					<?php
						$config	=	array(
								'field_name'=>'reclamo_garantia_material_field_material_secundario',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 ', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				</li>
			
		
		</fieldset>
		<?php if($this->backend->_permiso('admin')):?>
		<fieldset>
			<legend><?php echo lang('version');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'reclamo_garantia_version_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$reclamo_garantia_version_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
		</fieldset>
		<?php endif;?>
		
		
		
		
		
		<?php
				$this->load->view( 'backend/_inc_unidad_filtro_view' );
		?>
		
		<?php
			//filtros para el auto
				$this->load->view( 'backend/_inc_auto_filtro_view' );
		?>
		
		
		
		
		
		
		
		
		
			
		
		
		
		
		
		
		
		

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_campania_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'reclamo_garantia_campania_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$reclamo_garantia_campania_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_dtc_estado_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'reclamo_garantia_dtc_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$reclamo_garantia_dtc_estado_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>

		
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_estado_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'reclamo_garantia_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$reclamo_garantia_estado_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>

		<!--
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_codigo_rechazo_principal_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'reclamo_garantia_codigo_rechazo_principal_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$reclamo_garantia_codigo_rechazo_principal_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>
		-->
		<!--
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_codigo_rechazo_secundario_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'reclamo_garantia_codigo_rechazo_secundario_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$reclamo_garantia_codigo_rechazo_secundario_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>
		-->
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('sucursal_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'sucursal_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$sucursal_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>

		
		<li class="buttons">
		
			<div>
				<input id="enviar" name="_filtro" class="btTxt submit" value="<?=lang('filtrar')?>" type="submit">
			</div>
		
		</li>
			


	
		</ul>
		</form>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {
	
		
	
	
	
		$('#versionimprenta').click(function(e){
			e.preventDefault();
			var allVals = [];
			$('.bulk').livequery(function() { 
				if($(this).is(':checked')){
					allVals.push($(this).val());
				}
			 });
			 
			
			if(allVals.length > 0)
			{
				window.open("<?=$this->config->item('base_url').$this->config->item('backend_root');?>reclamo_garantia_bulk_print/show/"+allVals.join('-'),'_bulkprint');
				
			}
		});
	
	});
</script>
