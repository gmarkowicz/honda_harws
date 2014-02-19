
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
				<legend><?=$this->marvin->mysql_field_to_human('trafico_pilot_legend_id');?></legend>
				<li class="unitx4 f-left">
				

				<?php
					$config	=	array(
							'field_name'		=>'trafico_pilot_legend_field_fecha',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
					<?php
						$config	=	array(
							'field_name'		=>'trafico_pilot_legend_field_vendedor_nombre',
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
						'field_name'		=> 'sucursal_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $sucursal_id
					);
					echo $this->marvin->print_html_select($config);
				?>
				</li>
				
				<li class="unitx4 f-left both">
					<?php
						$config	=	array(
							'field_name'		=>'trafico_pilot_legend_field_nombre',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'trafico_pilot_legend_field_apellido',
							'field_req'			=>TRUE,
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
							'field_name'		=>'trafico_pilot_legend_field_razon_social',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				
				<li class="unitx4 f-left">
					

					
					<label class="unitx4"><strong><?=lang('telefono');?></strong></label>
					<?php
						$config	=	array(
							'field_name'		=>'trafico_pilot_legend_field_telefono_contacto_codigo',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx1 fist',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'trafico_pilot_legend_field_telefono_contacto_numero',
							'field_req'			=>TRUE,
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
							'field_name'		=>'trafico_pilot_legend_field_email',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				<li class="unitx4 f-left both">
				<?php
					$config	=	array(
						'field_name'		=> 'auto_modelo_interes_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $auto_modelo_interes_id
					);
					echo $this->marvin->print_html_select($config);
			?>

				<?php
					$config	=	array(
						'field_name'		=> 'auto_modelo_actual_id',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $auto_modelo_actual_id
					);
					echo $this->marvin->print_html_select($config);
			?>

				

			


		</li>
		<li class="unitx4 f-left">
				<?php
					$config	=	array(
						'field_string'		=> 'recibir_info_honda_modelo',
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

		<?php
		/*---- descomentar para imagenes
		?>
		
		<fieldset>
			<legend><?=lang('imagenes');?></legend>
		<?php
			//cargo include de multiples imagenes
			$config = array();
			$config['prefix'] = 'imagen';
			$config['images'] = array(); //inicializo por si tiene varios
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
			if(isset($trafico_pilot_legend_adjunto) && count($trafico_pilot_legend_adjunto)>0)
			{
				$config['adjuntos'] = $trafico_pilot_legend_adjunto;
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
