
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
				<legend><?=$this->marvin->mysql_field_to_human('servicio_circular_id');?></legend>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'servicio_circular_field_titulo',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

				

		</li>
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'		=>'servicio_circular_field_fecha',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>

				<?php
					$config	=	array(
						'field_name'		=> 'servicio_circular_categoria_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $servicio_circular_categoria_id
					);
					echo $this->marvin->print_html_select($config)
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
		<?php $this->config->load('adjunto/servicio_circular_adjunto');	
			$config = $this->config->item('adjunto_upload');
		?>
		<fieldset>
			<legend><?=lang('adjuntos');?> (<?php echo $config['allowed_types'];?>)</legend>
		<?php
			//cargo include de multiples adjuntos
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			if(isset($servicio_circular_adjunto) && count($servicio_circular_adjunto)>0)
			{
				$config['adjuntos'] = $servicio_circular_adjunto;
			}
			$this->load->view( 'backend/_adjunto_upload_view',$config );
		?>
		
		</fieldset>
			
		</ul>
		<?php
			$this->load->view( 'backend/_inc_abm_submit_view' );
		?>
</form>
</div>
</div>
