
<script type="text/javascript">
	$(document).ready(function() {
		$("#nuevoregistro").hide();
	});
</script>
<?php if($this->router->method == 'add' ): ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$('input._unidad_field').keyup(function(e){
			if(es_unidad_valida())
			{
				get_tsi_encuesta_satisfaccion();
			}
		});
	}); 
	</script>
<?php endif;?>


<div id="tabs">
		
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		
		<div id="tabs-1" >
		<?php if($this->router->method!='toemail'):?>
		<?php
				
			if(set_value('id'))
			{
				echo  $this->load->view( 'backend/miniviews/record_miniview',FALSE, TRUE );
			}			
			$this->load->view( 'backend/esqueleto_botones_view' );
				
				
		?>
		<?php endif;?>
		<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<?php
				$this->load->view( 'backend/_inc_unidad_form_view',array('basic_input'=>TRUE));
				if(set_value('id'))
				{
					
					$tsi = set_value('Tsi');
					echo  $this->load->view( 'backend/miniviews/tsi_miniview',FALSE, TRUE );
					echo  $this->load->view( 'backend/miniviews/sucursal_miniview',array('SUCURSAL'=>$tsi['Sucursal']), TRUE );
					echo  $this->load->view( 'backend/miniviews/cliente_miniview',array('CLIENTE'=>$tsi['Cliente']), TRUE );
					
				}else{
				?>
				<fieldset class="clearfix">
				<legend><?php echo lang('tsi_id');?></legend>
				<li class="unitx8 f-left both">
				<div id="select_tsi"></div>
				</li>
				</fieldset>
				<?
				}
				?>
						
					
				
				<fieldset class="clearfix">
				<legend><?=$this->marvin->mysql_field_to_human('haciendo_una_cita');?></legend>
				<li class="unitx4 f-left">
				<?php
					$config	=	array(
						'field_name'		=> 'tsi_encuesta_satisfaccion_field_pregunta_01',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx4 first',
						'field_class'		=> 'unitx1',
						'field_type'		=> 'text',
						'field_options'	=> $si_no
					);
					echo $this->marvin->print_html_select($config);
				?>
				</li>
				<li class="unitx4 f-left">
				</li>
				<li class="unitx8 both clearfix"></li>
				
				<li class="unitx6 f-left both"><span><?php echo lang('pregunta_01a');?></span></li>
				<li class="unitx2 f-left">
					<?php
					$config	=	array(
						'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_01a',
						'field_req'				=> FALSE,
						'field_options'			=> $estrellas_5
						
						);
						echo $this->marvin->print_html_stars($config);
					?>
					
				</li>
				<?php if($this->router->method=='toemail'):?>
					<li class="unitx8 both clearfix" style="padding-bottom:20px;">&nbsp;</li>
				<?php endif; ?>
				</fieldset>
				
				
				
				<fieldset class="clearfix">
					<legend><?=$this->marvin->mysql_field_to_human('llevando_honda_servicio');?></legend>
					<li class="unitx8 fleft both"><span><strong><?php echo lang('evaluacion_recepcionista');?></strong></span></li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_02a');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_02a',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_02b');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_02b',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_02c');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_02c',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_02d');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_02d',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_02e');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_02e',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_02f');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_02f',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					
					
				</fieldset>
				
				<fieldset class="clearfix">
					<legend><?=$this->marvin->mysql_field_to_human('durante_el_servicio_reparacion');?></legend>
					<li class="unitx8 fleft both"><span><strong><?php echo lang('evaluacion_honda');?></strong></span></li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_03a');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_03a',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_03b');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_03b',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_03c');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_03c',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
				</fieldset>
				
				<fieldset class="clearfix">
					<legend><?=$this->marvin->mysql_field_to_human('recogiendo_su_honda');?></legend>
					<div class="both"></div>
					<li class="unitx8 fleft both"><span><strong><?php echo lang('evaluacion__recoger_vehiculo');?></strong></span></li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_04a');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_04a',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_04b');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_04b',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_04c');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_04c',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_04d');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_04d',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_04e');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_04e',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
				</fieldset>
				
				<fieldset class="clearfix">
						<legend><?=$this->marvin->mysql_field_to_human('llevando_honda_a_casa');?></legend>
						<div class="both"></div>
						<li class="unitx6 f-left both"><span><?php echo lang('pregunta_05');?></span></li>
						<li class="unitx2 f-left">
							<?php
							$config	=	array(
								'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_05',
								'field_req'				=> FALSE,
								'field_options'			=> $estrellas_5
								
								);
								echo $this->marvin->print_html_stars($config);
							?>
						</li>
						<div class="both"></div>
						<li class="unitx4 f-left">
						<?php
							$config	=	array(
								'field_name'		=> 'tsi_encuesta_satisfaccion_field_pregunta_06',
								'field_req'			=> FALSE,
								'field_selected'	=> FALSE,
								'label_class'		=> 'unitx6 first',
								'field_class'		=> 'unitx1',
								'field_type'		=> 'text',
								'field_options'	=> $si_no
							);
							echo $this->marvin->print_html_select($config);
						?>
						</li>
						<li class="unitx4 f-left">
						</li>
						<div class="both"></div>
						<li class="unitx8 f-left both">
							<?php
							$config	=	array(
								'field_name'		=> 'tsi_encuesta_satisfaccion_field_pregunta_06a',
								'field_req'			=> FALSE,
								'field_selected'	=> FALSE,
								'label_class'		=> 'unitx6 first',
								'field_class'		=> 'unitx1',
								'field_type'		=> 'text',
								'field_options'	=> $visitas_adicionales
							);
							echo $this->marvin->print_html_select($config);
						?>
						</li>
						<div class="both"></div>
						<li class="unitx8 f-left both">
						<?php
							$config	=	array(
								'field_name'		=> 'tsi_encuesta_satisfaccion_field_pregunta_06b',
								'field_req'			=> FALSE,
								'field_selected'	=> FALSE,
								'label_class'		=> 'unitx6 first',
								'field_class'		=> 'unitx1',
								'field_type'		=> 'text',
								'field_options'	=> $razon_repetir_servicio
							);
							echo $this->marvin->print_html_select($config);
						?>
							
						</li>
						<div class="both"></div>
						<li class="unitx8 f-left both">
						
						<?php
							$config	=	array(
								'field_name'		=>'tsi_encuesta_satisfaccion_field_pregunta_06b_otra',
								'field_req'			=>FALSE,
								'label_class'		=>'unitx6',
								'field_class'		=>'',
								'textarea_rows'		=>	7,
								'textarea_html'		=>FALSE
							);
							echo $this->marvin->print_html_textarea($config);
							?>
					</li>
						
				</fieldset>
				
				<fieldset class="clearfix">
					<legend><?=$this->marvin->mysql_field_to_human('sumario');?></legend>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_07a');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_07a',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_07b');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_07b',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_07c');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_07c',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_08');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_08',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_4
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					<li class="unitx6 f-left both"><span><?php echo lang('pregunta_09');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_satisfaccion_field_pregunta_09',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_4
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<div class="both"></div>
					
					<li class="unitx8 f-left both">
						
						<?php
							$config	=	array(
								'field_name'		=>'tsi_encuesta_satisfaccion_field_comentarios',
								'field_req'			=>FALSE,
								'label_class'		=>'unitx6',
								'field_class'		=>'',
								'textarea_rows'		=>	7,
								'textarea_html'		=>FALSE
							);
							echo $this->marvin->print_html_textarea($config);
							?>
					</li>
					<?php if($this->router->method=='toemail'):?>
					<li class="unitx8 both clearfix" style="margin-bottom:100px;">&nbsp;</li>
					<?php endif; ?>
				</fieldset>
			
			
		</ul>
		<?php
			$this->load->view( 'backend/_inc_abm_submit_view' );
		?>
</form>
</div>
</div>
