<?
if($this->router->method == 'add' )
{
?>
<script type="text/javascript">
$(document).ready(function(){
	$('input._unidad_field').keyup(function(e){
		if(es_unidad_valida())
		{
			get_unidad_propietario_original();
		}
	});
}); 
</script>
<?
}
?>

<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		<?php
				
				$data_botones = FALSE;
				if(set_value('id'))
				{
					$estado = set_value('Encuesta_Nos_Estado');
					
					echo  $this->load->view( 'backend/miniviews/record_miniview',array(
																					'registro_estado'=>$estado['encuesta_nos_estado_field_desc'],
																					'rechazo_motivo'=>set_value('encuesta_nos_field_rechazo_motivo')
																					
																			), TRUE );
				
					if($estado['id'] == 9)
					{
						$data_botones=array('rechazado'=>TRUE);
					}
				}		
				$this->load->view( 'backend/esqueleto_botones_view',$data_botones );
		?>
<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<?php
				$this->load->view( 'backend/_inc_unidad_form_view',array('basic_input'=>TRUE));
				if(set_value('id'))
				{
					echo  $this->load->view( 'backend/miniviews/cliente_miniview',array('CLIENTE'=>set_value('Cliente')), TRUE );
				}
				?>
					
			<fieldset>
			
				<li class="unitx8 f-left both">
					<div id="propietario_original"></div>
				</li>
				<li class="unitx3 f-left both">
				

			

				<?php
					$config	=	array(
						'field_name'		=> 'sexo_id',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $sexo_id
					);
					echo $this->marvin->print_html_select($config);
			?>

				<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_edad_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $encuesta_nos_edad_id
					);
					echo $this->marvin->print_html_select($config);
			?>

				<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_grupo_familiar_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx1',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $encuesta_nos_grupo_familiar_id
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			<li class="unitx5 f-left">
				<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_ocupacion_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $encuesta_nos_ocupacion_id
					);
					echo $this->marvin->print_html_select($config);
			?>

				<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_financiacion_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $encuesta_nos_financiacion_id
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			<li class="unitx4 f-left">

				<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_tipo_automovil_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $encuesta_nos_tipo_automovil_id
					);
					echo $this->marvin->print_html_select($config);
			?>

				<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_conductor_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $encuesta_nos_conductor_id
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			
			<li class="unitx4 f-left">
			</li>
			</fieldset>
			
			
				<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('uso_automovil');?></legend>
			<li class="unitx3  f-left">
				<label><?=lang('uso_negocios');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_uso_negocios',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $automovil_usos
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('uso_transporte_trabajo');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_uso_transporte_trabajo',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $automovil_usos
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('uso_transporte_escuela');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_uso_transporte_escuela',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $automovil_usos
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('uso_general');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_uso_general',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $automovil_usos
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('uso_placer');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_uso_placer',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $automovil_usos
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>
			
			<fieldset>
			<legend><?php echo lang('exprese_sus_opiniones');?></legend>
			<li class="unitx4  f-left">
			<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_opinion_investigacion',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $opiniones_honda
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			<li class="unitx4  f-left">
			<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_opinion_originalidad',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $opiniones_honda
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			<li class="unitx4  f-left">
			<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_opinion_carreras',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $opiniones_honda
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			<li class="unitx4  f-left">
			<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_opinion_seguridad',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $opiniones_honda
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			<li class="unitx4  f-left">
			<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_opinion_medio_ambiente',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $opiniones_honda
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			<li class="unitx4  f-left">
			<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_opinion_eficiencia',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx4 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $opiniones_honda
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			</fieldset>
			<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('encuesta_nos_opinion_interes_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'			=> 'many_encuesta_nos_opinion_interes',
						'field_req'			=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'checkbox',
						'field_options'		=> $many_encuesta_nos_opinion_interes
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx8">
			<?php
						$config	=	array(
						'field_name'		=>'encuesta_nos_field_opinion_interes_otros',
						'field_req'		=>FALSE,
						'label_class'		=>'unitx8',
						'field_class'		=>'',
						'textarea_rows'		=>4,
						'textarea_html'	=>FALSE
					);
					echo $this->marvin->print_html_textarea($config);
					?>
			</li>
			</fieldset>
			
			
			<fieldset>
			<legend><?php echo lang('caracteristicas_influenciaron');?></legend>
			<li class="unitx3  f-left">
				<label><?=lang('influencia_estilo');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_estilo',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('influencia_tamanio');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_tamanio',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('influencia_potencia');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_potencia',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('influencia_respuesta');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_respuesta',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('influencia_maniobrabilidad');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_maniobrabilidad',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_economia');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_economia',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('influencia_precio');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_precio',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_financiacion');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_financiacion',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('influencia_garantia');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_garantia',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			<li class="unitx3  f-left">
				<label><?=lang('influencia_modelo');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_modelo',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_empresa');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_empresa',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_disenio');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_disenio',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_comodidad');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_comodidad',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_practicidad');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_practicidad',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_seguridad');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_seguridad',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_confiabilidad');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_confiabilidad',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_longevidad');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_longevidad',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_prestigio');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_prestigio',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_calidad');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_calidad',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_disponibilidad');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_disponibilidad',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_accesorios');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_accesorios',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			
			<li class="unitx3  f-left">
				<label><?=lang('influencia_servicio');?></label>
			</li>
			<li class="unitx5  f-left">
				<?php
					$config	=	array(
						'field_name'			=> 'encuesta_nos_field_influencia_servicio',
						'field_req'				=> FALSE,
						'label_class'			=> '',
						'field_class'			=> '',
						'field_type'			=> 'radio',
						'field_options'		=> $caracteristicas_infuenciaron
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
			</li>
			</fieldset>
			
			<fieldset>
			<legend><?php echo lang('para_comprar_su_honda');?></legend>
			
			<li class="unitx4 f-left both">
					
					
					
					<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_comparo_otra_marca',
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
			<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_comparo_otra_marca_1',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_comparo_otra_anio_1',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_comparo_otra_modelo_1',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
			</li>
			<li class="unitx4 f-left">
			</li>
			<li class="unitx4 f-left">

					

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_comparo_otra_marca_2',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_comparo_otra_anio_2',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_comparo_otra_modelo_2',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				<li class="unitx4 f-left">
					<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_primer_automovil',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> 'unitx1',
						'field_type'		=> 'text',
						'field_options'	=> $si_no
					);
					echo $this->marvin->print_html_select($config);
				?>
				</li>
				<li class="unitx4 f-left">
					<label class="unitx4"><strong><?php echo lang('automovil_anterior_cual');?></strong></label>
					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_automovil_anterior_marca',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_automovil_anterior_anio',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_automovil_anterior_modelo',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>
				</li>
				<li class="unitx4 f-left">
					<?php
					$config	=	array(
						'field_name'		=> 'encuesta_nos_field_automovil_otro',
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
					

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_automovil_otro_marca',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_automovil_otro_anio',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
					?>

					<?php
						$config	=	array(
							'field_name'		=>'encuesta_nos_field_automovil_otro_modelo',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							);
						echo $this->marvin->print_html_input($config);
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
