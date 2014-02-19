<script language="javascript">

		
		
		<!-- ajax tsis -->
		$(document).ready(function() {
		
			//$('._ajax_append').append('<div class="_ajax_loading"></div>');
			//var a = $.manageAjax.create('queue', {queue: 'clear', maxRequests: 1, abortOld: true});
			$.manageAjax.create('cola_tsi', {queue: 'clear', maxRequests: 1, abortOld: true});
			
			$('input._unidad_field').keyup(function(e){
				e.preventDefault();
				if(!es_unidad_valida())
				{
					
					$('#datos_unidad_tsi').html('');
					return false;
				}
				
				 $.manageAjax.add('cola_tsi', 
				{
					beforeSend: function()
					{
						$('._ajax_append').append('<div class="_ajax_loading _cola_tsi"></div>');
					},
					url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_unidad_tsi/"+$('#unidad_field_unidad').val()+"/"+$('#unidad_field_vin').val()+"/1",
					type: "GET",
					success: function(respuesta)
					{
						$('#datos_unidad_tsi').html(respuesta);
						$('._cola_tsi').remove();
					}
                });
				
				  
				  
                   return false;
			});
		});
		<!-- ajax unidad -->
		
		
		
		
	

		
		
		
</script>


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
					$data=array('basic_input' => TRUE);
				$this->load->view( 'backend/_inc_unidad_form_view',$data );
				?>
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('libro_servicio_id');?></legend>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'libro_servicio_field_propietario_nombre',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					<?php
						$config	=	array(
							'field_name'		=>'libro_servicio_field_propietario_apellido',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
				</li>
				<li class="unitx4 f-left">
				

					<?php
						$config	=	array(
							'field_name'		=>'libro_servicio_field_propietario_razon_social',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					

				

					

				

				
				
				
		</li>
		
		<li class="unitx4 both">
		
			<?php
						$config	=	array(
							'field_name'		=>'libro_servicio_field_kilometros',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
			
			<?php
					
					$config	=	array(
						'field_name'		=> 'sucursal_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $sucursal_id
					);
					echo $this->marvin->print_html_select($config)
			?>

			
		</li>
		<li class="unitx4">
				<?php
				if($this->backend->_permiso('admin') && $this->router->method=='edit')
				{
					$config	=	array(
						'field_name'		=> 'libro_servicio_estado_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $libro_servicio_estado_id
					);
					echo $this->marvin->print_html_select($config);
				}
			?>
			
		</li>
		
		
		<li class="unitx8 both">
			<?php
						$config	=	array(
						'field_name'=>'libro_servicio_field_motivo_requerimiento',
						'field_req'	=>FALSE,
						'label_class'=>'unitx4 first',
						'field_class'=>'',
						'textarea_rows'=>4,
						'textarea_html'=>FALSE
					);
					echo $this->marvin->print_html_textarea($config)
					?>
		</li>
		<li class="unitx8 both">
			
			<?php
				if( ($this->backend->_permiso('admin') && $this->router->method=='edit') OR ($this->router->method=='show' AND set_value('libro_servicio_estado_id') == 5   ) )
				{
					$config	=	array(
						'field_name'=>'libro_servicio_field_observaciones',
						'field_req'=>FALSE,
						'label_class'=>'unitx4 first',
						'field_class'=>'',
						'textarea_rows'=>4,
						'textarea_html'=>FALSE
					);
					echo $this->marvin->print_html_textarea($config);
				}
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
		<div id="datos_unidad_tsi"></div>
		
		<?php $this->config->load('adjunto/libro_servicio_adjunto');	
			$config = $this->config->item('adjunto_upload');
		?>
		
		<fieldset>
			<legend><?=lang('adjuntar_tsi_adicionales');?> (<?php echo $config['allowed_types'];?>)</legend>
		<?php
			//cargo include de multiples adjuntos
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			if(isset($libro_servicio_adjunto) && count($libro_servicio_adjunto)>0)
			{
				$config['adjuntos'] = $libro_servicio_adjunto;
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
