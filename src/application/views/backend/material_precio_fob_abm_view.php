<!--
<script type="text/javascript">
	$(document).ready(function() {
		$('#nuevoregistro').hide();
	});
</script>
-->
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
				<legend><?=$this->marvin->mysql_field_to_human('material_precio_fob_id');?></legend>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'material_precio_fob_field_precio_fob',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>

				
			

		</li>
		<li class="unitx4 f-left">
			<?php
						$config	=	array(
							'field_name'		=>'material_id',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
			<?php
					$config	=	array(
						'field_name'=>'moneda_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2',
						'field_class'=>'',
						'field_options'=>$moneda_id,
						'field_params'	=>'',
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
			if(isset($material_precio_fob_adjunto) && count($material_precio_fob_adjunto)>0)
			{
				$config['adjuntos'] = $material_precio_fob_adjunto;
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
