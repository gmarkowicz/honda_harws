<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
				
				#minuscula para el model
				$model = strtolower($this->model);
		?>
		<form  autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human($model.'_id');?></legend>
				<li class="unitx4">
					<?php
				$config	=	array(
								'field_name'=>$model.'_field_titulo',
								'field_req'=>FALSE,
								'label_class'=>'unitx4 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								);
							echo $this->marvin->print_html_input($config)
				?>
				</li>
				<li class="unitx4">
					<?php
					$config	=	array(
						'field_name'=>'backend_estado_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$backend_estado_id
					);
					echo $this->marvin->print_html_select($config)
				?>
					
				</li>
				<li class="unitx8">
						<?php
						$config	=	array(
						'field_name'=>$model.'_field_copete',
						'field_req'=>TRUE,
						'label_class'=>'unitx8 first',
						'field_class'=>'',
						'textarea_rows'=>4,
						'textarea_html'=>TRUE
					);
					echo $this->marvin->print_html_textarea($config)
					?>
				</li>

					<li class="unitx8">
						<?php
						$config	=	array(
						'field_name'=>$model.'_field_desarrollo',
						'field_req'=>TRUE,
						'label_class'=>'unitx8 first',
						'field_class'=>'',
						'textarea_rows'=>4,
						'textarea_html'=>TRUE
					);
					echo $this->marvin->print_html_textarea($config)
					?>
				</li>				

				<li class="unitx4">
				
				<?php
					$var = $model."_seccion_id";
					$config	=	array(
						'field_name'=>$model.'_seccion_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2 first',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$$var
					);
					echo $this->marvin->print_html_select($config)
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
			if(isset($noticia_imagen) && count($noticia_imagen)>0)
			{
				$config['images'] = $noticia_imagen;
			}
			$this->load->view( 'backend/_imagen_upload_view',$config );
		?>
		
		</fieldset>
		
		
		<fieldset>
			<legend><?=lang('adjuntos');?></legend>
		<?php
			//cargo include de multiples adjuntos
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			if(isset($noticia_adjunto) && count($noticia_adjunto)>0)
			{
				$config['adjuntos'] = $noticia_adjunto;
			}
			$this->load->view( 'backend/_adjunto_upload_view',$config );
		?>
		
		</fieldset>
		
					</ul>
				</div>
			
			<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
			?>
</form>
</div>
</div>