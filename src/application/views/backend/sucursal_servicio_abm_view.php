
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
				<legend><?=$this->marvin->mysql_field_to_human('sucursal_servicio_id');?></legend>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'sucursal_servicio_field_desc',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				<li class="unitx4 f-left">
				
					<?php
					$config	=	array(
						'field_name'		=> 'sucursal_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $sucursal_id
					);
					echo $this->marvin->print_html_select($config);
					?>
					
				</li>
				<li class="unitx4 f-left both">
				</li>
				<li class="unitx4 f-left">
				
				<?php
					$config	=	array(
						'field_name'		=> 'backend_estado_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $backend_estado_id
					);
					echo $this->marvin->print_html_select($config);
			?>
				</li>
				
				<li class="unitx4 f-left">
					<?php
						$config	=	array(
							'field_name'		=>'sucursal_servicio_field_direccion',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
					
					<?php
						$config	=	array(
							'field_name'		=>'sucursal_servicio_field_codigo_postal',
							'field_req'			=>TRUE,
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
						'field_name'		=> 'provincia_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1 first',
						'field_class'		=> 'provincia_id',
						'field_type'		=> 'text',
						'field_options'	=> $provincia_id
					);
					echo $this->marvin->print_html_select($config);
			?>

				<div class="ciudad_id">
				<?php
					$config	=	array(
						'field_name'=>'ciudad_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx3',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$ciudad_id
					);
					echo $this->marvin->print_html_select($config)
				?>
				</div>
					
			</li>
					
			<li class="unitx4 f-left both">
				<?php
						$config	=	array(
							'field_name'		=>'sucursal_servicio_field_telefono',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
			</li>
			<li class="unitx4 f-left">
					

					

					<?php
						$config	=	array(
							'field_name'		=>'sucursal_servicio_field_email',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
			</li>
			
		</fieldset>
		
		<fieldset>
		<legend><?=lang('pagina_web');?></legend>
			<li class="unitx4 f-left">
				<?php
						$config	=	array(
							'field_name'		=>'sucursal_servicio_field_pagina_web',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				
			</li>
			<li class="unitx4 f-left">
				<?php
						$config	=	array(
							'field_name'		=>'sucursal_servicio_field_latitud',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'sucursal_servicio_field_longitud',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
			
			</li>
			<li class="unitx8">
						<?php
						$config	=	array(
						'field_name'=>'sucursal_servicio_field_horario_atencion',
						'field_req'=>FALSE,
						'label_class'=>'unitx8 first',
						'field_class'=>'',
						'textarea_rows'=>2,
						'textarea_html'=>FALSE
					);
					echo $this->marvin->print_html_textarea($config)
					?>
				</li>
		
		<li class="unitx8">
						<?php
						$config	=	array(
						'field_name'=>'sucursal_servicio_field_descripcion_web',
						'field_req'=>TRUE,
						'label_class'=>'unitx8 first',
						'field_class'=>'',
						'textarea_rows'=>4,
						'textarea_html'=>FALSE
					);
					echo $this->marvin->print_html_textarea($config)
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
			if(isset($sucursal_servicio_imagen) && count($sucursal_servicio_imagen)>0)
			{
				$config['images'] = $sucursal_servicio_imagen;
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
			if(isset($sucursal_servicio_adjunto) && count($sucursal_servicio_adjunto)>0)
			{
				$config['adjuntos'] = $sucursal_servicio_adjunto;
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
