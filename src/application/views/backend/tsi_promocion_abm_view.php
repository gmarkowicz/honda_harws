
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
				<legend><?=$this->marvin->mysql_field_to_human('tsi_promocion_id');?></legend>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'tsi_promocion_field_desc',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>


		</li>
		<li class="unitx4 f-left">
			<!-- :P -->
		</li>
		</fieldset>
		
		<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('vigencia');?></legend>
				<li class="unitx4 f-left">
				

					<?php
					$config	=	array(
							'field_name'		=>'tsi_promocion_field_fecha_inicio',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							'year_range'			=>"-100:+10"
							);
						echo $this->marvin->print_html_calendar($config)
					?>


		</li>
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'		=>'tsi_promocion_field_fecha_fin',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							'year_range'			=>"-100:+10"
							);
						echo $this->marvin->print_html_calendar($config)
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
			if(isset($tsi_promocion_adjunto) && count($tsi_promocion_adjunto)>0)
			{
				$config['adjuntos'] = $tsi_promocion_adjunto;
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
