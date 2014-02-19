
<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
				if(set_value('id'))
				{
					echo  $this->load->view( 'backend/miniviews/record_miniview',FALSE, TRUE );
				}		
		?>
<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<?php
				$this->load->view( 'backend/_inc_unidad_form_view',array('basic_input'=>TRUE));
				?>
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('codigo_radio_solicitud_id');?></legend>
				
				
				<li class="unitx4 f-left">
				<?php
					$config	=	array(
						'field_name'		=> 'sucursal_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $sucursal_id
					);
					echo $this->marvin->print_html_select($config);
				?>
				</li>
				<li class="unitx4 f-left">
				
				<?php
					//si es admin y esta editando o si estoy mostrando el registro en solo lectura muestro campo
					if(($this->router->method == 'edit' && $this->backend->_permiso('admin')  ) || $this->router->method == 'show')
					{
						
							$config	=	array(
								'field_name'		=> 'codigo_radio_solicitud_estado_id',
								'field_req'			=> FALSE,
								'field_selected'	=> FALSE,
								'label_class'		=> 'unitx2 first',
								'field_class'		=> '',
								'field_type'		=> 'text',
								'field_options'	=> $codigo_radio_solicitud_estado_id
							);
							echo $this->marvin->print_html_select($config);
					} 
			?>
				</li>
				
				<?php
				//si es admin y esta editando o si estoy mostrando el registro en solo lectura muestro campo
				if(($this->router->method == 'edit' && $this->backend->_permiso('admin')  ) || $this->router->method == 'show')
				{
				?>
				<li class="unitx4 f-left">
				<?php
						$config	=	array(
							'field_name'		=>'codigo_radio_solicitud_field_resultado',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				<li class="unitx4 fleft">
				</li>
				<?
				}
				?>
				
				<li class="unitx4 f-left both">
				

					<?php
						$config	=	array(
							'field_name'		=>'codigo_radio_solicitud_field_numero_serial',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'codigo_radio_solicitud_field_numero_parte',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

		</li>
		<li class="unitx4 f-left">
			<?php
						$config	=	array(
							'field_name'		=>'codigo_radio_solicitud_field_numero_referencia',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
		</li>
		<li class="unitx8 f-left both">
			<?php
					$config	=	array(
						'field_name'		=>'codigo_radio_solicitud_field_observaciones',
						'field_req'			=>FALSE,
						'label_class'		=>'unitx6 true',
						'field_class'		=>'',
						'textarea_rows'		=>4,
						'textarea_html'		=>FALSE
					);
					echo $this->marvin->print_html_textarea($config);
					?>

		</li>
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
			if(isset($codigo_radio_solicitud_adjunto) && count($codigo_radio_solicitud_adjunto)>0)
			{
				$config['adjuntos'] = $codigo_radio_solicitud_adjunto;
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
