<script type="text/javascript">
	/* facebook mode :O*/
	$(document).ready(function() {
		
		$(".ckeckall_sucursales").click(function(e)
		{
			
			 $("input[name$='many_sucursal[]']").each(function()
			 {
				
				
			 });
			 
			return false;
		});
		
		$(".selectall").change(function() {
			var select = $(this);
			if(select.is(':checked')){
				$('.autocheck').addClass('checked');
				$('.autocheck').attr('checked', true);
			}
			else
			{
				$('.autocheck').removeClass('checked');
				$('.autocheck').attr('checked', false);
			}
			
			
			
		
		
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
				<legend><?=$this->marvin->mysql_field_to_human('admin_id');?></legend>
				<li class="unitx4">
				

				<?php
				$config	=	array(
								'field_name'=>'admin_field_usuario',
								'field_req'=>TRUE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				<?php
					if($this->session->userdata('admin_field_super_admin')===TRUE AND set_value('id')):
				?>
					<a href="<?=$this->config->item('base_url').$this->config->item('backend_root').'login/act_as/'.set_value('id');?>">ActAs</a>
				<?php endif;?>
				</li>
				<li class="unitx4">
				<?php
				$config	=	array(
								'field_name'=>'admin_field_password',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'password',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
					
				<?php
				$config	=	array(
								'field_name'=>'admin_field_password_repite',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'password',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				</li>
				<li class="unitx4">

					<?php
				$config	=	array(
								'field_name'=>'admin_field_nombre',
								'field_req'=>TRUE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>

					<?php
				$config	=	array(
								'field_name'=>'admin_field_apellido',
								'field_req'=>TRUE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				</li>
				<li class="unitx4">
				
				<?php
				$config	=	array(
								'field_name'=>'admin_field_email',
								'field_req'=>TRUE,
								'label_class'=>'unitx3 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>

		</li>
		<li class="unitx4">


				<?php
				$config	=	array(
								'field_name'=>'admin_field_dni',
								'field_req'=>FALSE,
								'label_class'=>'unitx1 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				
					
				<?php
					$config	=	array(
						'field_name'=>'admin_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'unitx1',
						'field_class'=>'',
						'field_options'=>$admin_estado_id
					);
					echo $this->marvin->print_html_select($config)
			?>
		</li>
		<li class="unitx4">
				<?php
				$config	=	array(
								'field_name'=>'admin_field_telefono_celular',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>		
	
				<?php
					$config	=	array(
						'field_name'=>'sucursal_id',
						'field_req'=>TRUE,
						'label_class'=>'unitx2',
						'field_class'=>'',
						'field_type'=>'text',
						'field_options'=>$sucursal_id
					);
					echo $this->marvin->print_html_select($config)
			?>
		</li>
		
		
		<li class="unitx4">
			<?php
				$config	=	array(
								'field_name'=>'admin_field_direccion',
								'field_req'=>FALSE,
								'label_class'=>'unitx3 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				

				
		</li>
		<li class="unitx4">
			
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
			
			<div class="ciudad_id left">
				<?php if(isset($ciudad_id)):?>
				
				<?php
					$config	=	array(
						'field_name'=>'ciudad_id',
						'field_req'=>FALSE,
						'label_class'=>'unitx3',
						'field_class'=>'ciudad_id',
						'field_type'=>'text',
						'field_options'=>$ciudad_id
					);
					echo $this->marvin->print_html_select($config)
			?>
				
				<?php endif;?>
			</div>
		</li>
		
		
		
		
		
		<li class="unitx4 both">
			<?php
					$config	=	array(
							'field_name'=>'admin_field_fecha_ingreso',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					
					<?php
					$config	=	array(
							'field_name'=>'admin_field_fecha_egreso',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		<li class="unitx4">
			
			<?php
					$config	=	array(
							'field_name'=>'admin_field_fecha_nacimiento',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
                    <?php
				$config	=	array(
								'field_name'=>'token',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
                                'field_params' => ' readonly="true" '
								
								);
							echo $this->marvin->print_html_input($config)
				?>	
		</li>
		
		<li class="unitx4">
		
		<?php
						$config	=	array(
						'field_name'=>'admin_field_estudios',
						'field_req'	=>FALSE,
						'label_class'=>'unitx4 first',
						'field_class'=>'',
						'textarea_rows'=>4,
						'textarea_html'=>FALSE
					);
					echo $this->marvin->print_html_textarea($config)
					?>
		
		</li>

		<li class="unitx4">
			<?php
				$config	=	array(
								'field_name'=>'admin_field_idioma',
								'field_req'=>FALSE,
								'label_class'=>'unitx3 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
		</li>
		</fieldset>

			
			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('admin_departamento_id');?></legend>
			<li class="unitx8">
				
			
					<?php
					$config	=	array(
						'field_name'=>'many_admin_departamento',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$many_admin_departamento
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>
			
			
			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('admin_puesto_id');?></legend>
			<li class="unitx8">
				
			
					<?php
					$config	=	array(
						'field_name'=>'many_admin_puesto',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$many_admin_puesto
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>
			
			
			<fieldset>
			<legend  style="padding-bottom:40px;"><?=$this->marvin->mysql_field_to_human('sucursal_id');?>
			<div class="custom-checkbox" style="padding:5px 0;"><input type="checkbox" name="all" id="all" class="selectall"><label for="all" class="choice"><strong>Marcar / Desmarcar todos</strong> </label></div></legend>
			
					
					
					
					
				
			<li class="unitx8">
				
			
					<?php
					$config	=	array(
						'field_name'=>'many_sucursal',
						'field_req'=>FALSE,
						'label_class'=>'autocheck',
						'field_class'=>'autocheck',
						'field_type'=>'checkbox',
						'field_options'=>$many_sucursal
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('grupo_id');?></legend>
			<li class="unitx8">
				
			
					<?php
					$config	=	array(
						'field_name'=>'many_grupo',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$many_grupo
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>
			</ul>
			
			
			<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
			?>
				
			
</form>
</div>
</div>
