
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
				<legend><?=$this->marvin->mysql_field_to_human('servicio_manuales_guias_id');?></legend>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'servicio_manuales_guias_field_titulo',
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
							'field_name'		=>'servicio_manuales_guias_field_fecha',
							'field_req'		=>FALSE,
							'label_class'		=>'unitx1', //first
							'field_class'		=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		</fieldset>
		<?php $this->config->load('adjunto/servicio_manuales_guias_adjunto');	
			$config = $this->config->item('adjunto_upload');
		?>
		<fieldset>
			<legend><?=lang('adjuntos');?> (<?php echo $config['allowed_types'];?>)</legend>
		<?php
			//cargo include de multiples adjuntos
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			if(isset($servicio_manuales_guias_adjunto) && count($servicio_manuales_guias_adjunto)>0)
			{
				$config['adjuntos'] = $servicio_manuales_guias_adjunto;
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
