	<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('unidad_id');?></legend>
		<!-- -->
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
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_motor',
								'field_req'=>FALSE,
								'label_class'=>'unitx1', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				
				
			
				
	
			
		</li>
		<li class="unitx4">
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_patente',
								'field_req'=>FALSE,
								'label_class'=>'unitx1 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_codigo_de_llave',
								'field_req'=>FALSE,
								'label_class'=>'unitx1', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_codigo_de_radio',
								'field_req'=>FALSE,
								'label_class'=>'unitx1', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				
		</li>
			<!-- -->
		<li class="unitx4">
			<?php
				$config	=	array(
								'field_name'=>'unidad_field_material_sap',
								'field_req'=>FALSE,
								'label_class'=>'unitx1 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_descripcion_sap',
								'field_req'=>FALSE,
								'label_class'=>'unitx1', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
		</li>
		<li class="unitx4">
		<?php
				$config	=	array(
								'field_name'=>'unidad_field_oblea',
								'field_req'=>FALSE,
								'label_class'=>'unitx1 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_certificado',
								'field_req'=>FALSE,
								'label_class'=>'unitx1', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_formulario_12',
								'field_req'=>FALSE,
								'label_class'=>'unitx1', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_formulario_01',
								'field_req'=>FALSE,
								'label_class'=>'unitx1', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
		</li>
		</fieldset>