<?
if($this->router->method == 'add' )
{
?>
<script type="text/javascript">
$(document).ready(function(){
	$('input._unidad_field').keyup(function(e){
		if(es_unidad_valida())
		{
			get_tsi_encuesta_seguimiento();
		}
	});
	
}); 
</script>
<?
}
?>
<script type="text/javascript">
$(document).ready(function(){
	
	
	
	$('select[name="tsi_encuesta_seguimiento_estado_id"]').change(function()
	{
		if($(this).val() == 1)
		{
			$('#encuesta').show();
		}else{
			$('#encuesta').hide();
		}
	
	});

	$('select[name="tsi_encuesta_seguimiento_estado_id"]').trigger('change');
}); 
</script>


<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		<?php
			
			
			$registro_estado = FALSE;
			$rechazo_motivo = FALSE;
			
			if(set_value('tsi_encuesta_seguimiento_estado_id') == 9)
			{
				$registro_estado = $current_record['Tsi_Encuesta_Seguimiento_Estado']['tsi_encuesta_seguimiento_estado_field_desc'];
				$rechazo_motivo = set_value('tsi_encuesta_seguimiento_field_rechazo_motivo');
				?>
					<script type="text/javascript">
					$(document).ready(function(){
						block_input();
					}); 
					</script>
				<?php
				
			
			}
			
			
			if(set_value('id'))
			{
				echo  $this->load->view( 'backend/miniviews/record_miniview',array('registro_estado'=>$registro_estado,'rechazo_motivo'=>$rechazo_motivo), TRUE );
			}			
			$this->load->view( 'backend/esqueleto_botones_view' );
				
		?>
<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<?php
				/*
				//echo var_dump(is_callable(array($this,"show")));
				//echo var_dump(method_exists($this,'show'));
				
				//echo get_class($this);
				
				$controller = new ReflectionClass($this);
				
				//print_r($controller->getMethods());
				foreach($controller as $method)
				{
					//echo $method."<br />";
				}
				*/
				
				$this->load->view( 'backend/_inc_unidad_form_view',array('basic_input'=>TRUE));
				if(set_value('id'))
				{
					//ya tiene que existir un registro
					
					$tsi = set_value('Tsi');
					echo  $this->load->view( 'backend/miniviews/tsi_miniview',FALSE, TRUE );
					echo  $this->load->view( 'backend/miniviews/sucursal_miniview',array('SUCURSAL'=>$tsi['Sucursal']), TRUE );
					echo  $this->load->view( 'backend/miniviews/cliente_miniview',array('CLIENTE'=>$tsi['Cliente']), TRUE );
					
					/*
					
					echo $this->load->view( 'backend/_inc_miniviews_view',array(	
																			'REGISTRO_INFO'=>TRUE,
																			'TSI'=>$TSI,
																			'CLIENTE'=>$CLIENTE,
																			'SUCURSAL'=>$SUCURSAL
																			),true);
					*/
				}else{
				?>
				<fieldset>
				<legend><?php echo lang('tsi_id');?></legend>
				<li class="unitx8 f-left both">
				<div id="select_tsi" rel="<?php echo set_value('tsi_id')?>"></div>
				</li>
				</fieldset>
				<?
				}
				?>
				
				<fieldset>
				<li class="unitx4 f-left">

				<?php
					$config	=	array(
						'field_name'		=> 'tsi_encuesta_seguimiento_estado_id',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $tsi_encuesta_seguimiento_estado_id
					);
					echo $this->marvin->print_html_select($config);
			?>

			</li>
				
				<li class="unitx4 f-left">
				

			
					<?php
						$config	=	array(
							'field_name'		=>'tsi_encuesta_seguimiento_field_entrevistador',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx3 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

			
					
			
			</li>
			</fieldset>
			
			
			
				
				<div id="encuesta">
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('trato_al_cliente');?></legend>
				
					<li class="unitx6 f-left both"><span><?php echo lang('seg_pregunta_01');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_seguimiento_field_seg_pregunta_01',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
				</fieldset>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('puntualidad');?></legend>
					<li class="unitx6 f-left both"><span><?php echo lang('seg_pregunta_02');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_seguimiento_field_seg_pregunta_02',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
				</fieldset>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('calidad');?></legend>
					<li class="unitx4 f-left">
					<?php
						$config	=	array(
							'field_name'		=> 'tsi_encuesta_seguimiento_field_seg_pregunta_03',
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
				</fieldset>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('valor');?></legend>
					<li class="unitx6 f-left both"><span><?php echo lang('seg_pregunta_04');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_seguimiento_field_seg_pregunta_04',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<li class="untix8 both f-left">
						<?php
						$config	=	array(
							'field_name'		=>'tsi_encuesta_seguimiento_field_seg_pregunta_04_comentarios',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3',
							'field_class'		=>'',
							'textarea_rows'	=>4,
							'textarea_html'	=>FALSE
						);
						echo $this->marvin->print_html_textarea($config);
						?>
					</li>
				</fieldset>
				
				<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('satisfaccion_general');?></legend>
					<li class="unitx6 f-left both"><span><?php echo lang('seg_pregunta_05');?></span></li>
					<li class="unitx2 f-left">
						<?php
						$config	=	array(
							'field_name'			=> 'tsi_encuesta_seguimiento_field_seg_pregunta_05',
							'field_req'				=> FALSE,
							'field_options'			=> $estrellas_5
							
							);
							echo $this->marvin->print_html_stars($config);
						?>
					</li>
					<li class="untix8 both f-left">
						<?php
						$config	=	array(
							'field_name'		=>'tsi_encuesta_seguimiento_field_seg_pregunta_05_comentarios',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3',
							'field_class'		=>'',
							'textarea_rows'	=>4,
							'textarea_html'	=>FALSE
						);
						echo $this->marvin->print_html_textarea($config);
						?>
					</li>
					
					<li class="unitx4 f-left both">
					<?php
						$config	=	array(
							'field_name'		=> 'tsi_encuesta_seguimiento_field_seg_pregunta_06',
							'field_req'			=> FALSE,
							'field_selected'	=> FALSE,
							'label_class'		=> 'unitx4 first',
							'field_class'		=> 'unitx1',
							'field_type'		=> 'text',
							'field_options'	=> $si_no
						);
						echo $this->marvin->print_html_select($config);
					?>
					<li class="unitx4 f-left">
					</li>
					<li class="untix8 both f-left both">
						<?php
						$config	=	array(
							'field_name'		=>'tsi_encuesta_seguimiento_field_seg_pregunta_06_comentarios',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx3',
							'field_class'		=>'',
							'textarea_rows'	=>4,
							'textarea_html'	=>FALSE
						);
						echo $this->marvin->print_html_textarea($config);
						?>
					</li>
				</fieldset>
				</div>
				
				
				


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
			if(isset($tsi_encuesta_seguimiento_adjunto) && count($tsi_encuesta_seguimiento_adjunto)>0)
			{
				$config['adjuntos'] = $tsi_encuesta_seguimiento_adjunto;
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
