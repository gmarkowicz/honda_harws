

	<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
			<li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
		</ul>
		<div id="tabs-1">
			<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
			?>
								
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
							'field_name'=>'trafico_pilot_legend_field_fechahora_alta_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'trafico_pilot_legend_field_fechahora_alta_final',
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
							'field_name'=>'trafico_pilot_legend_field_fecha_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'trafico_pilot_legend_field_fecha_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		</li>
		</fieldset>
<!--
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('trafico_pilot_legend_id');?></legend>
		
		<li class="unitx4 f-left both">
		<?php
				$config	=	array(
								'field_name'=>'trafico_pilot_legend_field_vendedor_nombre',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
		</li>
		<li class="unitx4 f-left">
		</li>
		
		<li class="unitx5 f-left both">
			
			<?php
				$config	=	array(
								'field_name'=>'trafico_pilot_legend_field_nombre',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'trafico_pilot_legend_field_apellido',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				
		</li>
		<li class="unixt3 f-left">
			<?php
				$config	=	array(
								'field_name'=>'trafico_pilot_legend_field_razon_social',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
			
		</li>
		
		<li class="unitx4 f-left both">
			
					<?php
				$config	=	array(
								'field_name'=>'trafico_pilot_legend_field_email',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
		</li>
		<li class="unitx4 f-left">		
				<label class="unitx4 first"><strong><?=lang('telefono_contacto');?></strong></label>
				<?php
				$config	=	array(
								'field_name'=>'trafico_pilot_legend_field_telefono_contacto_codigo',
								'field_req'=>FALSE,
								'label_class'=>'unitx1 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'trafico_pilot_legend_field_telefono_contacto_numero',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				
				
	
			
		</li>
		
		</fieldset>
-->		

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('auto_modelo_interes_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'auto_modelo_interes_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$auto_modelo_interes_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>
<!--
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('auto_modelo_actual_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'auto_modelo_actual_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$auto_modelo_actual_id
						
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

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('recibir_info_honda_modelo');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'backend_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$backend_estado_id
						
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

