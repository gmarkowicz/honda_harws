

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
		<li class="unitx4">

			<?php
					$config	=	array(
							'field_name'=>'fecha_alta_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					
		<?php
					$config	=	array(
							'field_name'=>'fecha_alta_final',
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
		<legend><?=$this->marvin->mysql_field_to_human('cliente_id');?></legend>
		
		<li class="unitx4 f-left">
			<?php
				$config	=	array(
								'field_name'=>'cliente_field_numero_documento',
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
		
		<li class="unitx4 f-left both">
			<?php
				$config	=	array(
								'field_name'=>'cliente_sucursal_field_nombre',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'cliente_sucursal_field_apellido',
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
								'field_name'=>'cliente_sucursal_field_razon_social',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'cliente_sucursal_field_email',
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
								'field_name'=>'cliente_sucursal_field_direccion',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'cliente_sucursal_field_direccion_codigo_postal',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
		</li>
		<li class="unitx4 f-left">
			
		</li>
		<!-- -->
		<li class="unitx4 f-left both">
			<?php
				$config	=	array(
								'field_name'=>'cliente_sucursal_field_telefono_particular',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'cliente_sucursal_field_telefono_laboral',
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
								'field_name'=>'cliente_sucursal_field_telefono_movil',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
		</li>
		
		</fieldset>
		
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('sexo_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'sexo_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$sexo_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>
		
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('tratamiento_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'tratamiento_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$tratamiento_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('documento_tipo_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'documento_tipo_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$documento_tipo_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>
			
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('cliente_conformidad_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'cliente_conformidad_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$cliente_conformidad_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>	
			
			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('cliente_codigo_interno_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'cliente_codigo_interno_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$cliente_codigo_interno_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>	
			
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('provincia_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'provincia_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$provincia_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
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

