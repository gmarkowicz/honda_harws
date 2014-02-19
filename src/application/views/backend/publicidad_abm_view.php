
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
				<legend><?=$this->marvin->mysql_field_to_human('publicidad_id');?></legend>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'publicidad_field_desc',
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
							'field_name'		=>'publicidad_field_fecha_publicacion',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx2 fist', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				</li>
				
				<li class="unitx4 f-left">
					<?php
					$config	=	array(
						'field_name'		=> 'publicidad_medida_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $publicidad_medida_id
					);
					echo $this->marvin->print_html_select($config);
			?>

				
				</li>
				<li class="unitx4 f-left">
					<?php
					$config	=	array(
						'field_name'		=> 'publicidad_ubicacion_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $publicidad_ubicacion_id
					);
					echo $this->marvin->print_html_select($config);
			?>
				</li>
				
				
				<li class="unitx4 f-left both">
					<?php
							$config	=	array(
								'field_name'		=> 'publicidad_producto_id',
								'field_req'		=> FALSE,
								'field_selected'	=> FALSE,
								'label_class'		=> 'unitx2 first',
								'field_class'		=> '',
								'field_type'		=> 'text',
								'field_options'	=> $publicidad_producto_id
							);
							echo $this->marvin->print_html_select($config);
					?>
				</li>
				<li class="unitx4 f-left">
				</li>
				<fieldset>
				<legend><?=lang('imagenes');?></legend>
				<?php
					//cargo include de multiples imagenes
					$config = array();
					$config['images'] = array();
					$config['prefix'] = 'imagen';
					$config['model'] = strtolower($this->model);
					if(isset($publicidad_imagen) && count($publicidad_imagen)>0)
					{
						$config['images'] = $publicidad_imagen;
					}
					$this->load->view( 'backend/_imagen_upload_view',$config );
				?>
				
				</fieldset>
				
				
				<li class="unitx4 f-left both">
				
				<?php
					$config	=	array(
						'field_name'		=> 'publicidad_medio_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $publicidad_medio_id
					);
					echo $this->marvin->print_html_select($config);
				?>
				</li>
		
				<li class="unitx4 f-left"></li>
				
				<fieldset>
				<legend><?=lang('imagenes');?></legend>
				<?php
					//cargo include de multiples imagenes
					$config = array();
					$config['images'] = array();
					$config['prefix'] = 'imagen_medio';
					$config['model'] = strtolower($this->model);
					if(isset($publicidad_imagen_medio) && count($publicidad_imagen_medio)>0)
					{
						$config['images'] = $publicidad_imagen_medio;	
					}
					$this->load->view( 'backend/_imagen_upload_view',$config);
					
				?>
				
				</fieldset>
		
		</fieldset>

		<?php
		/*---- descomentar para imagenes
		?>
		
		<fieldset>
			<legend><?=lang('imagenes');?></legend>
		<?php
			//cargo include de multiples imagenes
			$config = array();
			$config['prefix'] = 'imagen';
			$config['model'] = strtolower($this->model);
			if(isset(MODELO_IMAGEN) && count(MODELO_IMAGEN)>0)
			{
				$config['images'] = MODELO_IMAGEN;
			}
			$this->load->view( 'backend/_imagen_upload_view',$config );
		?>
		
		</fieldset>
		*/
		?>
		
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
			if(isset($publicidad_adjunto) && count($publicidad_adjunto)>0)
			{
				$config['adjuntos'] = $publicidad_adjunto;
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
