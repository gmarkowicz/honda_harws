
<div id="tabs">
  <ul>
    <li class="boton-tab"><a href="#tabs-1" id="principal">
      <?=lang('principal');?>
      </a></li>
  </ul>
  <div id="tabs-1">
    <?php $this->load->view('backend/esqueleto_botones_view'); ?>
    <form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
    <?php if (isset($cliente)): ?>
    	<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('cliente_id');?></legend>
			<li>
				<table cellspacing="0" cellpadding="4" class="tabla_opciones" width="100%">
						<tbody>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('id');?></strong></td>
								<td><span><?php echo $cliente['id'];?><input type="hidden" name="cliente_id" value="<?php echo $cliente['id'];?>" /></span></td>

								<td><strong><?=$this->marvin->mysql_field_to_human('documento_tipo_id');?></strong></td>
								<td><span><?php echo $cliente['Documento_Tipo']['documento_tipo_field_desc'];?><input type="hidden" name="documento_tipo_id" value="<?php echo $cliente['documento_tipo_id'];?>" /></span></td>

								<td><strong><?=$this->marvin->mysql_field_to_human('cliente_field_numero_documento');?></strong></td>
								<td><span><?php echo $cliente['cliente_field_numero_documento'];?><input type="hidden" name="cliente_field_numero_documento" value="<?php echo $cliente['cliente_field_numero_documento'];?>" /></span></td>
							</tr>
							<tr>
								<td colspan="6"><?php
									$config	=	array(
										'field_name'		=> 'cliente_conformidad_id',
										'field_req'		=> FALSE,
										'field_selected'	=> $cliente['cliente_conformidad_id'],
										'label_class'		=> 'unitx4 first',
										'field_class'		=> '',
										'field_type'		=> 'text',
										'field_options'	=> $cliente_conformidades
									);
									echo $this->marvin->print_html_select($config);
								?></td>
							</tr>
						</tbody>
				</table>
			</li>
		</fieldset>
	<?php else: ?>
	<ul>
		<fieldset>
          <legend>
          <?=$this->marvin->mysql_field_to_human('cliente_id');?>
          </legend>
			<li class="unitx4">
            <?php
					$config	=	array(
						'field_name'		=> 'documento_tipo_id',
						'field_req'			=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx4 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $documentos
					);
					echo $this->marvin->print_html_select($config);
				?>
          	</li>
          	<li class="unitx4">
            <?php
					$config	=	array(
						'field_name'		=>'cliente_field_numero_documento',
						'field_req'		=>TRUE,
						'label_class'		=>'unitx4',
						'field_class'		=>'',
						'field_type'		=>'text',
						'field_params'	=>'',
						);
					echo $this->marvin->print_html_input($config);
				?>
          	</li>
          	<li class="unitx4">
            <?php
					$config	=	array(
						'field_name'		=> 'cliente_conformidad_id',
						'field_req'		=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx4 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $cliente_conformidades
					);
					echo $this->marvin->print_html_select($config);
				?>
          	</li>
        </fieldset>
	</ul>
	<?php endif; ?>

      <ul>
        <fieldset>
          <legend>
          <?=$this->marvin->mysql_field_to_human('cliente_sucursal_id');?>
          </legend>
          <li class="unitx4">
            <?php
					$config	=	array(
						'field_name'		=> 'sucursal_id',
						'field_req'		=> TRUE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx4 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $sucursal_id
					);
					echo $this->marvin->print_html_select($config);
				?>
          </li>
          <li class="unitx4">
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_razon_social',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx4',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
          </li>
          <li class="unitx4">
            <?php
					$config	=	array(
						'field_name'		=> 'sexo_id',
						'field_req'		=> true,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $sexo_id
					);
					echo $this->marvin->print_html_select($config);
			?>
            <?php
					$config	=	array(
						'field_name'		=> 'tratamiento_id',
						'field_req'		=> true,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $tratamiento_id
					);
					echo $this->marvin->print_html_select($config);
					?>
          </li>
          <li class="unitx4">
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_nombre',
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
							'field_name'		=>'cliente_sucursal_field_apellido',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
          </li>
          <li class="unitx4">
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_email',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx4 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
          <li class="unitx4">
          <?php
					$config	=	array(
							'field_name'		=>'cliente_sucursal_field_fecha_nacimiento',
							'field_req'		=>false,
							'label_class'		=>'unitx2 first', //first
							'field_class'		=>'',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
          </li>
        </fieldset>
        <fieldset>
          <legend>
          <?=$this->marvin->mysql_field_to_human('telefono_contacto');?>
          </legend>
          <li class="unitx4 f-left">
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_telefono_particular_codigo',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_telefono_particular_numero',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2',
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
							'field_name'		=>'cliente_sucursal_field_telefono_laboral_codigo',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_telefono_laboral_numero',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2',
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
							'field_name'		=>'cliente_sucursal_field_telefono_movil_codigo',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_telefono_movil_numero',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2',
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
							'field_name'		=>'cliente_sucursal_field_fax_codigo',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_fax_numero',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
          </li>
        </fieldset>
        <fieldset>
          <legend>
          <?=$this->marvin->mysql_field_to_human('direccion');?>
          </legend>
          <li class="unitx4">
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_direccion_calle',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx4 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
			</li>
			<li class="unitx4">
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_direccion_numero',
							'field_req'		=>true,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_direccion_piso',
							'field_req'		=>false,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_direccion_depto',
							'field_req'		=>false,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
            <?php
						$config	=	array(
							'field_name'		=>'cliente_sucursal_field_direccion_codigo_postal',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx1',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
			</li>
			<li class="unitx4">
            <?php
					$config	=	array(
						'field_name'		=> 'pais_id',
						'field_req'		=> true,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $pais_id
					);
					echo $this->marvin->print_html_select($config);
			?>
            <?php
					$config	=	array(
						'field_name'		=> 'provincia_id',
						'field_req'		=> true,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx2',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $provincia_id
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
			<li class="unitx4">
            <?php
					$config	=	array(
						'field_name'		=> 'ciudad_id',
						'field_req'		=> true,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $ciudad_id
					);
					echo $this->marvin->print_html_select($config);
			?>
			</li>
          <li class="unitx4">
            <!-- :P -->
          </li>
        </fieldset>
		<?php if($this->session->userdata('show_cliente_codigo_interno') == TRUE):?>
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('cliente_codigo_interno_id');?></legend>
		<li class="unitx8">
			
				<?php
					$config	=	array(
						'field_name'=>'cliente_codigo_interno_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$cliente_codigo_interno_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			</li>
		</fieldset>
		<?php endif;?>
		
		
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
			if(isset($cliente_sucursal_adjunto) && count($cliente_sucursal_adjunto)>0)
			{
				$config['adjuntos'] = $cliente_sucursal_adjunto;
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
<script>
$(function(){
	reloadCiudades($('select[name="ciudad_id"] option:selected').val());
	$('label[for="provincia_id"]').change(function(e){
		reloadCiudades();
	});

	function reloadCiudades(ciudad_id)
	{
		$.get('<?php echo $this->config->item('base_url').$this->config->item('backend_root'); ?>/ajax/get_ciudades/'+$('select[name="provincia_id"]').val()+(typeof(ciudad_id)!='undefined'?'/'+ciudad_id:''), function(data) {
			$('label[for="ciudad_id"]').replaceWith(data);
		});
	}
});
</script>
