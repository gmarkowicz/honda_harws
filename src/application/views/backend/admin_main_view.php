
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
		<form  autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('fecha');?></legend>
		<li class="unitx4">

			<?php
					$config	=	array(
							'field_name'=>'fecha_ingreso_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					
		<?php
					$config	=	array(
							'field_name'=>'fecha_ingreso_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>

			
		</li>
		<li class="unitx4">
			<?php
					$config	=	array(
							'field_name'=>'fecha_egreso_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					
		<?php
					$config	=	array(
							'field_name'=>'fecha_egreso_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		<li class="unitx4">
			<?php
					$config	=	array(
							'field_name'=>'fecha_nacimiento_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					
		<?php
					$config	=	array(
							'field_name'=>'fecha_nacimiento_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		<li class="unitx4">
		</li>
		
		</fieldset>
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('admin_id');?></legend>
		<li class="unitx4">

			<?php
				$config	=	array(
								'field_name'=>'admin_field_usuario',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
		</li>
		<li class="unitx4">

			<?php
				$config	=	array(
								'field_name'=>'admin_field_nombre',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>

			<?php
				$config	=	array(
								'field_name'=>'admin_field_apellido',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>

		</li>
		<li class="unitx4">
			<?php
				$config	=	array(
								'field_name'=>'admin_field_email',
								'field_req'=>FALSE,
								'label_class'=>'unitx3 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
		</li>
		<li class="unitx4">
			<?php
				$config	=	array(
								'field_name'=>'admin_field_telefono_celular',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				<?php
				$config	=	array(
								'field_name'=>'admin_field_dni',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
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
		
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('admin_puesto_id');?></legend>
		<li class="unitx8">
		
			<?php
					$config	=	array(
						'field_name'=>'admin_puesto_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$admin_puesto_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			
		</li>
		</fieldset>
		
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('admin_departamento_id');?></legend>
		<li class="unitx8">
		
			<?php
					$config	=	array(
						'field_name'=>'admin_departamento_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$admin_departamento_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			
		</li>
		</fieldset>
		
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('grupo_id');?></legend>
		<li class="unitx8">
		
			<?php
					$config	=	array(
						'field_name'=>'grupo_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$grupo_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			
		</li>
		</fieldset>
		
		
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('admin_estado_id');?></legend>
		<li class="unitx8">
		
			<?php
					$config	=	array(
						'field_name'=>'admin_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$admin_estado_id
						
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

