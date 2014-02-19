

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
		<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_orden_compra_id');?></legend>
		<li class="unitx4 f-left">
			
				<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_orden_compra_field_fecha_factura_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_orden_compra_field_fecha_factura_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
	
			
		</li>
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_orden_compra_field_fecha_alta_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'reclamo_garantia_orden_compra_field_fecha_alta_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		</li>
		
		<li class="unitx4 f-left">
			<?php
				$config	=	array(
								'field_name'=>'reclamo_garantia_orden_compra_field_factura',
								'field_req'=>FALSE,
								'label_class'=>'unitx1 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				
			<?php
				$config	=	array(
								'field_name'=>'reclamo_garantia_orden_compra_field_desc',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
		</li>
		<li class="unitx4 f-left">
		</li>
		
		<li class="unitx8 f-left both">
			
			<div class="checkbox">
				
				<span>
				
				<input name="registros_sin_factura" id="registros_sin_factura" class="checkbox" value="1" type="checkbox"
				<?php echo $this->form_validation->set_checkbox('registros_sin_factura', 1);?>><label class="choice" for="registros_sin_factura">Registros sin factura</label>
				</span>
				
			</div>
			
			<div class="checkbox">
				
				<span>
				
				<input name="registros_sin_orden_compra" id="registros_sin_orden_compra" class="checkbox" value="1" type="checkbox"
				<?php echo $this->form_validation->set_checkbox('registros_sin_orden_compra', 1);?>><label class="choice" for="registros_sin_orden_compra">Registros sin orden de compra</label>
				</span>
				
			</div>
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
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>

		
		<li class="buttons">
		
			<div>
				<input id="enviar" name="_filtro" class="btTxt submit" value="<?=lang('filtrar')?>" type="submit">
			</div>
		
		</li>
			


	
		</ul>
		</form>
	</div>
</div>

