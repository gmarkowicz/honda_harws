
<script type="text/javascript">
	/* facebook mode :O*/
	$(document).ready(function()
	{
		
		var method = '<?php echo $this->router->method;?>';
		
		
		
		/*agregando bloque sucursal_hora*/
		$(".add_multi_hora").click(function(e)
		{
			$('.add_hora').append($(".multi_hora").html());
			return false;
		});
		
		/*eliminando bloques dinamicos*/
		/*TODO DONT DRY*/
		$(".eliminar_bloque").livequery('click', function(e)
		{
			$(this).parents("div.bloque").remove();
			return false;
		});
	
	});
</script>


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
				<legend><?=$this->marvin->mysql_field_to_human('sucursal_id');?></legend>
				<li class="unitx4 align-left">
				

					<?php
						$config	=	array(
							'field_name'=>'sucursal_field_desc',
							'field_req'=>TRUE,
							'label_class'=>'unitx3 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					

		</li>
		<li class="unitx4 align-left">
			<?php
					$config	=	array(
						'field_name'=>'empresa_id',
						'field_req'=>FALSE,
						'label_class'=>'unitx3 first',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$empresa_id
					);
					echo $this->marvin->print_html_select($config)
			?>
		</li>
		<div class="both"></div>
		<li class="unitx4 align-left">
				<?php
					$config	=	array(
							'field_name'=>'sucursal_field_fecha_inicio_actividad',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					<?php
					$config	=	array(
							'field_name'=>'sucursal_field_fecha_fin_actividad',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>

		</li>
		<li class="unitx4 align-left">
				<?php
					$config	=	array(
							'field_name'=>'sucursal_field_fecha_fin_envio',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					<?php
					$config	=	array(
						'field_name'=>'backend_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'unitx1',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$backend_estado_id
					);
					echo $this->marvin->print_html_select($config)
			?>
				
		</li>
		<div class="both"></div>
		<li class="unitx4 align-left">
			<?php
						$config	=	array(
							'field_name'=>'sucursal_field_direccion',
							'field_req'=>TRUE,
							'label_class'=>'unitx2 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
			<?php
						$config	=	array(
							'field_name'=>'sucursal_field_codigo_postal',
							'field_req'=>TRUE,
							'label_class'=>'unitx1',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
		</li>
		<li class="unitx4 align-left">
		<?php
					$config	=	array(
						'field_name'=>'provincia_id',
						'field_req'=>FALSE,
						'label_class'=>'unitx1 first',
						'field_class'=>'provincia_id',
						'field_type'=>'text',
						'field_options'=>$provincia_id
					);
					echo $this->marvin->print_html_select($config)
			?>
			<div class="ciudad_id">
				<?php
					$config	=	array(
						'field_name'=>'ciudad_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx3',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$ciudad_id
					);
					echo $this->marvin->print_html_select($config)
			?>
			</div>
		</li>
		<div class="both"></div>
		<li class="unitx4 align-left">
			<?php
						$config	=	array(
							'field_name'=>'sucursal_field_telefono',
							'field_req'=>TRUE,
							'label_class'=>'unitx3 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
		</li>
		<li class="unitx4 align-left">
			<?php
						$config	=	array(
							'field_name'=>'sucursal_field_email',
							'field_req'=>TRUE,
							'label_class'=>'unitx2 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>

					

		</li>
		<li class="unitx4 align-left">
			
			<?php
						$config	=	array(
							'field_name'=>'sucursal_field_ingresos_brutos',
							'field_req'=>TRUE,
							'label_class'=>'unitx2 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
					
			
			<?php
						$config	=	array(
							'field_name'=>'sucursal_field_valor_frt_hora',
							'field_req'=>TRUE,
							'label_class'=>'unitx2',
							'field_class'=>'',
							'field_type'=>'text',
							);
						//echo $this->marvin->print_html_input($config)
					?>
			</li>
			<li class="unitx4 align-left">
			<?php
					$config	=	array(
						'field_name'=>'sucursal_field_reporte_usados',
						'field_req'=>FALSE,
						'label_class'=>'unitx1 first',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$backend_estado_id
					);
					echo $this->marvin->print_html_select($config)
			?>
		</li>
		</fieldset>
		
		<fieldset>
		<legend><?=lang('reclamo_garantia_id');?> <?=lang('valor_frt_hora');?><a href="#" class="add_multi_hora _ajax_add"><?=lang('agregar');?></a></legend>
			<?php
			//esto deberia ser por ajax pero ya cansa....
			if(!isset($valor_frt_hora))
			{
				$valor_frt_hora= set_value('Sucursal_Valor_Frt');
			}
			
			
			if(is_array($valor_frt_hora) && count($valor_frt_hora)>0)
			{
				reset($valor_frt_hora);
				while(list($key,$row)=each($valor_frt_hora))
				{
				
					
					?>
					
						<div class="bloque">
							<li class="unitx4 align-left">
								<label for="" class="unitx2 first"><?php echo lang('valor_frt_hora_fecha_inicio')?>*
									<input type="text" value="<?php echo $this->marvin->mysql_date_to_form($row['sucursal_valor_frt_field_fecha_inicio']);?>" class="text field-valor_frt_hora_fecha_inicio[]" name="valor_frt_hora_fecha_inicio[]" id="valor_frt_hora_fecha_inicio[]"></label>
										
							</li>
							<li class="unitx4 align-left">
								
								<label class="unitx2 first" for=""><?php echo lang('valor_frt_hora')?><input id="valor_frt_hora[]" name="valor_frt_hora[]" class="text field-valor_frt_hora[]" value="<?php echo $row['sucursal_valor_frt_field_valor_frt_hora'];?>" type="text"></label>
					<label class="unitx1 desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>			
							</li>	
						</div>
					<?
				}
			}	
			
			?>
			

			<div class="add_hora"></div>
			<li class="unitx8 align-left">
				* <?php echo lang('fecha_de_egreso');?>
			</li>
		</fieldset>
		
		<fieldset>
		<legend><?=lang('pagina_web');?></legend>
		<li class="unitx4 align-left both">
		
			<?php
						$config	=	array(
							'field_name'=>'sucursal_field_pagina_web',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
		
		</li>
		<li class="unitx4 align-left">
		
			
			<?php
						$config	=	array(
							'field_name'=>'sucursal_field_latitud',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
			
				<?php
						$config	=	array(
							'field_name'=>'sucursal_field_longitud',
							'field_req'=>FALSE,
							'label_class'=>'unitx2',
							'field_class'=>'',
							'field_type'=>'text',
							);
						echo $this->marvin->print_html_input($config)
					?>
		
			
		</li>
		<li class="unitx8">
						<?php
						$config	=	array(
						'field_name'=>'sucursal_field_horario_atencion',
						'field_req'=>FALSE,
						'label_class'=>'unitx8 first',
						'field_class'=>'',
						'textarea_rows'=>1,
						'textarea_html'=>FALSE
					);
					echo $this->marvin->print_html_textarea($config)
					?>
				</li>
		
		<li class="unitx8">
						<?php
						$config	=	array(
						'field_name'=>'sucursal_field_descripcion_web',
						'field_req'=>TRUE,
						'label_class'=>'unitx8 first',
						'field_class'=>'',
						'textarea_rows'=>4,
						'textarea_html'=>TRUE
					);
					echo $this->marvin->print_html_textarea($config)
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
			if(isset($sucursal_imagen) && count($sucursal_imagen)>0)
			{
				$config['images'] = $sucursal_imagen;
			}
			$this->load->view( 'backend/_imagen_upload_view',$config );
		?>
		
		</fieldset>

			
</ul>
		<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
		?>
</form>
</div>
</div>


<div class="multi_hora hide">
	
<div class="bloque">
		<li class="unitx4 align-left">
			<label for="" class="unitx2 first"><?php echo lang('valor_frt_hora_fecha_inicio')?>
				<input type="text" value="" class="text field-valor_frt_hora_fecha_inicio[]" name="valor_frt_hora_fecha_inicio[]" id="valor_frt_hora_fecha_inicio[]"></label>
					
		</li>
		<li class="unitx4 align-left">
			
			<label class="unitx2 first" for=""><?php echo lang('valor_frt_hora')?><input id="valor_frt_hora[]" name="valor_frt_hora[]" class="text field-valor_frt_hora[]" value="" type="text"></label>
<label class="unitx1 desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>			
		</li>	
	</div>
</div>

