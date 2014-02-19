
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
		<legend><?=$this->marvin->mysql_field_to_human('libro_servicio_id');?></legend>
		<li class="unitx4">
			<?php
				$config	=	array(
								'field_name'=>'libro_servicio_field_propietario_nombre',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				<?php
				$config	=	array(
								'field_name'=>'libro_servicio_field_propietario_apellido',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				</li>
				<li class="unitx4 f-left">
				<?php
				$config	=	array(
								'field_name'=>'libro_servicio_field_propietario_razon_social',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				</li>
				<li class="unitx4 f-left both">
				<?php
					$config	=	array(
							'field_name'=>'libro_servicio_field_fechahora_alta_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
				<?php
					$config	=	array(
							'field_name'=>'libro_servicio_field_fechahora_alta_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
	
			
		</li>
	
		</fieldset>
		
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('unidad_id');?></legend>
		<li class="unitx4">
			<?php
				$config	=	array(
								'field_name'=>'unidad_field_unidad',
								'field_req'=>FALSE,
								'label_class'=>'unitx1 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_vin',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				
		</li>
		<li class="unitx4">
		</li>
		</fieldset>
		

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('libro_servicio_estado_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'libro_servicio_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$libro_servicio_estado_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

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
						echo $this->marvin->print_html_checkbox($config)
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

