
<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
		?>
<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('unidad_id');?></legend>
				<li class="unitx4 align-left">
				

					<?php
						$config	=	array(
							'field_name'=>'unidad_field_unidad',
							'field_req'=>TRUE,
							'label_class'=>'unitx1 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					<?php
						$config	=	array(
							'field_name'=>'unidad_field_vin',
							'field_req'=>TRUE,
							'label_class'=>'unitx2',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					<?php
						$config	=	array(
							'field_name'=>'unidad_field_motor',
							'field_req'=>TRUE,
							'label_class'=>'unitx1',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
			</li>
			<li class="unitx4 align-left">
					<?php
						$config	=	array(
							'field_name'=>'unidad_field_codigo_de_llave',
							'field_req'=>FALSE,
							'label_class'=>'unitx1 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					<?php
						$config	=	array(
							'field_name'=>'unidad_field_codigo_de_radio',
							'field_req'=>FALSE,
							'label_class'=>'unitx1',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
			</li>
			
			<li class="unitx4 align-left">
					<?php
						$config	=	array(
							'field_name'=>'unidad_field_patente',
							'field_req'=>TRUE,
							'label_class'=>'unitx1 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
					<?php
					$config	=	array(
						'field_name'=>'unidad_estado_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$unidad_estado_id
					);
					echo $this->marvin->print_html_select($config)
			?>
			</li>
			<li class="unitx4 align-left">
			<?php
					$config	=	array(
						'field_name'=>'unidad_color_exterior_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2 first',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$unidad_color_exterior_id
					);
					echo $this->marvin->print_html_select($config)
			?>

				<?php
					$config	=	array(
						'field_name'=>'unidad_color_interior_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx1',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$unidad_color_interior_id
					);
					echo $this->marvin->print_html_select($config)
			?>

			
			</li>
			</fieldset>
			<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('vin');?></legend>
				<li class="unitx4 align-left">
				
				<?php
					$config	=	array(
						'field_name'=>'auto_version_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2 first',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$auto_version_id
					);
					echo $this->marvin->print_html_select($config)
			?>

				<?php
					$config	=	array(
						'field_name'=>'auto_puerta_cantidad_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx1',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$auto_puerta_cantidad_id
					);
					echo $this->marvin->print_html_select($config)
			?>

				<?php
					$config	=	array(
						'field_name'=>'auto_transmision_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx1',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$auto_transmision_id
					);
					echo $this->marvin->print_html_select($config)
			?>
			<?php
					$config	=	array(
						'field_name'=>'auto_anio_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx1 first',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$auto_anio_id
					);
					echo $this->marvin->print_html_select($config)
			?>
				
				</li>
				<li class="unitx4 align-left">
					<?php
					$config	=	array(
						'field_name'=>'vin_procedencia_ktype_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2 first',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$vin_procedencia_ktype_id
					);
					echo $this->marvin->print_html_select($config)
			?>
			<?php
					$config	=	array(
						'field_name'=>'auto_fabrica_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$auto_fabrica_id
					);
					echo $this->marvin->print_html_select($config)
			?>
				</li>
			</fieldset>
			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('documentacion_concesionario');?></legend>
			<li class="unitx4 align-left">

					<?php
						$config	=	array(
							'field_name'=>'unidad_field_oblea',
							'field_req'=>FALSE,
							'label_class'=>'unitx1 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					<?php
						$config	=	array(
							'field_name'=>'unidad_field_certificado',
							'field_req'=>FALSE,
							'label_class'=>'unitx1',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					<?php
						$config	=	array(
							'field_name'=>'unidad_field_formulario_12',
							'field_req'=>FALSE,
							'label_class'=>'unitx1',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					<?php
						$config	=	array(
							'field_name'=>'unidad_field_formulario_01',
							'field_req'=>FALSE,
							'label_class'=>'unitx1',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
				</li>
				</fieldset>
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('unidad_estado_garantia_id');?></legend>
				<li class="unitx4 align-left">
					<?php
					$config	=	array(
						'field_name'=>'unidad_estado_garantia_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2 first',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$unidad_estado_garantia_id
					);
					echo $this->marvin->print_html_select($config)
				?>
				</li>
				<li class="unitx4 align-left">
				<?php
					$config	=	array(
							'field_name'		=>'unidad_field_fecha_garantia_anulada',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
				</li>
				<li class="unitx4 align-left">
				
				</li>
				
				<li class="unitx4 align-left">
					<?php
						$config	=	array(
						'field_name'=>'unidad_field_motivo_garantia_anulada',
						'field_req'=>FALSE,
						'label_class'=>'unitx4 first',
						'field_class'=>'',
						'textarea_rows'=>4
					);
					echo $this->marvin->print_html_textarea($config)
					?>
					
	

		</li>
		<li class="unitx4 align-left">
			<!-- :P -->
		</li>
		</fieldset>
		
		<?php if($this->session->userdata('show_unidad_codigo_interno') == TRUE):?>
			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('unidad_codigo_interno_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'many_unidad_codigo_interno',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$many_unidad_codigo_interno
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>
		<?php endif;?>
</ul>
		<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
		?>
</form>
</div>
</div>
