<script type="text/javascript">

$(document).ready(function() {
	$('select[name=usado_tipo_ingreso_id]').change(function () {
		if($(this).val()==1){
			$('.honda_0km').show();
		}else{
			$('.honda_0km').hide();
		}
	});
	$('select[name=usado_tipo_ingreso_id]').trigger('change');
}); 
</script>
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
				
				<?php
				if($this->router->method == 'add' || set_value('unidad_field_unidad'))
				{
					$this->load->view( 'backend/_inc_unidad_form_view',array('basic_input'=>TRUE));
				}
				?>
				<?
				if($this->router->method == 'add' || !set_value('unidad_field_unidad'))
				{
				?>
				
				<fieldset>
					<legend><?=lang('usado_otra_marca');?></legend>
						<li class="unitx4 f-left">
						<?php
						$config	=	array(
							'field_name'		=> 'auto_marca_id',
							'field_req'			=> TRUE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx2 first',
							'field_class'		=> 'select_auto_marca_id',
							'field_type'		=> 'text',
							'field_options'		=> $auto_marca_id
						);
						echo $this->marvin->print_html_select($config);
						?>
						
						<div id="select_modelo">
						<?php
						$config	=	array(
							'field_name'		=> 'auto_modelo_id',
							'field_req'			=> TRUE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx2',
							'field_class'		=> '',
							'field_type'		=> 'text',
							'field_options'	=> $auto_modelo_id
						);
						echo $this->marvin->print_html_select($config);
						?>
						</div>
						
						</li>
						<li class="unitx4 f-left">
						
							<?php
							$config	=	array(
								'field_name'		=> 'auto_version_id',
								'field_req'			=> TRUE,
								'field_selected'	=> FALSE,
								'label_class'		=> 'unitx3 first',
								'field_class'		=> '',
								'field_type'		=> 'text',
								'field_options'	=> $auto_version_id
							);
							echo $this->marvin->print_html_select($config);
							?>
						</li>
					
					
				</fieldset>
				<?
				}
				?>
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('usado_id');?></legend>
				<li class="unitx4 f-left">
					<?php
						$config	=	array(
							'field_name'		=>'usado_field_patente',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
					<?php
					$config	=	array(
						'field_name'		=> 'auto_anio_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $auto_anio_id
					);
					echo $this->marvin->print_html_select($config);
					?>
					
					<?php
					$config	=	array(
						'field_name'		=> 'auto_color_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $auto_color_id
					);
					echo $this->marvin->print_html_select($config);
					?>
					
					<?php
						$config	=	array(
							'field_name'		=>'usado_field_kilometros',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				
				<li class="unitx4 f-left">
					<?php
					$config	=	array(
						'field_name'		=> 'usado_tipo_ingreso_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $usado_tipo_ingreso_id
					);
					echo $this->marvin->print_html_select($config);
					?>
				
					<?php
						$config	=	array(
							'field_name'		=> 'sucursal_id',
							'field_req'			=> TRUE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx2',
							'field_class'		=> '',
							'field_type'		=> 'text',
							'field_options'	=> $sucursal_id
						);
						echo $this->marvin->print_html_select($config);
					?>
				</li>
				
				
				
				
				<li class="unitx4 f-left both">
					<label class="desc"><?=lang('precio_toma');?></label>
					<?php
					$config	=	array(
						'field_name'		=> 'moneda_precio_toma_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $moneda_precio_toma_id
					);
					echo $this->marvin->print_html_select($config);
					?>
					
					<?php
						$config	=	array(
							'field_name'		=>'usado_field_precio_toma',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				
				<li class="unitx4 f-left">
					<label class="desc"><?=lang('precio_venta');?></label>
					<?php
						$config	=	array(
							'field_name'		=> 'moneda_precio_venta_id',
							'field_req'			=> TRUE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx1 first',
							'field_class'		=> '',
							'field_type'		=> 'text',
							'field_options'	=> $moneda_precio_venta_id
						);
						echo $this->marvin->print_html_select($config);
					?>
					
					<?php
						$config	=	array(
							'field_name'		=>'usado_field_precio_venta',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					
				</li>
				
				<li class="unitx6 f-left">
					<?php
					$config	=	array(
						'field_name'		=>'usado_field_comentarios',
						'field_req'			=>FALSE,
						'label_class'		=>'unitx5 first',
						'field_class'		=>'',
						'textarea_rows'		=>4,
						'textarea_html'		=>FALSE
					);
					echo $this->marvin->print_html_textarea($config);
					?>
				</li>
				<li class="unitx2 f-left">
					<?php
					$config	=	array(
						'field_string'		=> 'usado_vizualizar_web', //piso field name original
						'field_name'		=> 'backend_estado_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $backend_estado_id
					);
					echo $this->marvin->print_html_select($config);
					?>
					
				</li>
		</fieldset>
		
		<fieldset class="honda_0km">
			<legend><?=lang('honda_okm');?></legend>
				<li class="unitx4 f-left">
				<?php
						$config	=	array(
							'field_name'		=>'unidad_0km',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
					<?php
						$config	=	array(
							'field_name'		=>'vin_0km',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				
				<li class="unitx4 f-left">
					
				</li>
			
		</fieldset>
		
		<fieldset>
			<legend><?=lang('fecha_venta');?></legend>
				<li class="unitx4 f-left">
				<?php
					$config	=	array(
							'field_name'		=>'usado_field_fecha_venta',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				</li>
				
				<li class="unitx4 f-left">
					<?php
					$config	=	array(
						'field_name'		=> 'usado_tipo_venta_id',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $usado_tipo_venta_id
					);
					echo $this->marvin->print_html_select($config);
				?>
				</li>
			
		</fieldset>

		
		<fieldset>
			<legend><?=lang('imagenes');?></legend>
		<?php
			//cargo include de multiples imagenes
			$config = array();
			$config['prefix'] = 'imagen';
			$config['model'] = strtolower($this->model);
			if(isset($usado_imagen) && count($usado_imagen)>0)
			{
				$config['images'] = $usado_imagen;
			}
			$this->load->view( 'backend/_imagen_upload_view',$config );
		?>
		
		</fieldset>
		
		
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
			if(isset($usado_adjunto) && count($usado_adjunto)>0)
			{
				$config['adjuntos'] = $usado_adjunto;
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
