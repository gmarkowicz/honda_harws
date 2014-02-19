
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
				<legend><?=$this->marvin->mysql_field_to_human('servicio_boletin_id');?></legend>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'servicio_boletin_field_titulo',
							'field_req'			=>TRUE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					<?php
						$config	=	array(
							'field_name'		=>'servicio_boletin_field_numero',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

				

		</li>
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'		=>'servicio_boletin_field_fecha',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1 first', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>

		</li>
		
		<li class="unitx4 f-left">
		
				<?php
					$config	=	array(
						'field_name'		=> 'servicio_boletin_categoria_id',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $servicio_boletin_categoria_id
					);
					echo $this->marvin->print_html_select($config)
			?>

				<?php
					$config	=	array(
						'field_name'		=> 'auto_modelo_id',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $auto_modelo_id
					);
					echo $this->marvin->print_html_select($config)
			?>
		</li>
		<li class="unitx4 f-left both">
		</li>
		</fieldset>
		<fieldset>
			<legend><?=lang('adjuntos');?></legend>
		<?php
			//cargo include de multiples adjuntos
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			if(isset($servicio_boletin_adjunto) && count($servicio_boletin_adjunto)>0)
			{
				$config['adjuntos'] = $servicio_boletin_adjunto;
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
