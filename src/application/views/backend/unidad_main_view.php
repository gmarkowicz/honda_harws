

	<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
			<li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
		</ul>
		<div id="tabs-1">
			<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
			?>
								
			<div class="grilla">
					<table id="flex1" style="display:none"></table>
			</div>
								
			</div>
	
	<div id="tabs-2">
		<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>


		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('fecha');?></legend>
		<li class="unitx4">
		<?php
					$config	=	array(
							'field_name'=>'unidad_field_fecha_facturacion_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
				<?php
					$config	=	array(
							'field_name'=>'unidad_field_fecha_venta_inicial',
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
							'field_name'=>'unidad_field_fecha_entrega_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		<li class="unitx4">
		<?php
					$config	=	array(
							'field_name'=>'unidad_field_fecha_facturacion_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
				<?php
					$config	=	array(
							'field_name'=>'unidad_field_fecha_venta_final',
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
							'field_name'=>'unidad_field_fecha_entrega_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
		</li>
		</fieldset>
		
		<?php
				$this->load->view( 'backend/_inc_unidad_filtro_view' );
		?>
		

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('unidad_color_exterior_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'unidad_color_exterior_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$unidad_color_exterior_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('unidad_color_interior_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'unidad_color_interior_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$unidad_color_interior_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('vin_procedencia_ktype_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'vin_procedencia_ktype_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$vin_procedencia_ktype_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('sucursal_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'sucursal_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$sucursal_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		

		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('auto_modelo_id');?></legend>
		<li class="unitx8">
			
				<?php
					$config	=	array(
						'field_name'=>'auto_modelo_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'auto_modelo_id',
						'field_type'=>'checkbox',
						'field_options'=>$auto_modelo_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			</li>
		</fieldset>
		
		<div id="div_auto_version_id">
			<?$this->load->view( 'backend/auto_version_id_inc_view' );?>
		</div>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('auto_puerta_cantidad_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'auto_puerta_cantidad_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$auto_puerta_cantidad_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('auto_transmision_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'auto_transmision_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$auto_transmision_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('auto_anio_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'auto_anio_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$auto_anio_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		<?php if($this->session->userdata('show_unidad_codigo_interno') == TRUE):?>
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('unidad_codigo_interno_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'unidad_codigo_interno_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$unidad_codigo_interno_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
		</fieldset>
		<?php endif;?>
		
		
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('unidad_estado_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'unidad_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$unidad_estado_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('unidad_estado_garantia_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'unidad_estado_garantia_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$unidad_estado_garantia_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
				
			</li>
			</fieldset>

		
		<li class="buttons">
			<fieldset>
			<div>
				<input id="enviar" name="_filtro" class="btTxt submit" value="<?=lang('filtrar')?>" type="submit">
			</div>
			</fieldset>
		</li>
			


	
		</ul>
		</form>
	</div>
</div>

