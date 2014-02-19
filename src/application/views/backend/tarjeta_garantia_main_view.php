

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
		<form  autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>


		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('fecha');?></legend>
		<li class="unitx4">

			<?php
					$config	=	array(
							'field_name'=>'fecha_alta_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					
		<?php
					$config	=	array(
							'field_name'=>'fecha_alta_final',
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
							'field_name'=>'fecha_entrega_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
					
		<?php
					$config	=	array(
							'field_name'=>'fecha_entrega_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
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
			<legend><?=$this->marvin->mysql_field_to_human('cliente_id');?></legend>
		<li class="unitx8">
			<?php
				$config	=	array(
								'field_name'=>'cliente',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
				
				<?php
				$config	=	array(
								'field_name'=>'cliente_field_numero_documento',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>
			</li>
		</fieldset>
			
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('cliente_conformidad_id');?></legend>
		<li class="unitx8">
			
				<?php
					$config	=	array(
						'field_name'=>'cliente_conformidad_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$cliente_conformidad_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			</li>
		</fieldset>
		
		
		
		<?php if($this->session->userdata('show_cliente_codigo_interno') == TRUE):?>
		
		<fieldset>
		<legend>Excluir <?=$this->marvin->mysql_field_to_human('cliente_codigo_interno_id');?></legend>
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
		
		<?php
			//filtros para el auto
				$this->load->view( 'backend/_inc_auto_filtro_view' );
		?>

		

		

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
		<legend><?=$this->marvin->mysql_field_to_human('tarjeta_garantia_estado_id');?></legend>
		<li class="unitx8">
			
				<?php
					$config	=	array(
						'field_name'=>'tarjeta_garantia_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$tarjeta_garantia_estado_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			</li>
		</fieldset>
		
		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('excluir_cambio_propietario');?></legend>
		<li class="unitx8">
			
				<?php
					$config	=	array(
						'field_name'=>'excluir_cambio_propietario',
						'field_req'=>FALSE,
						'label_class'=>'unitx2 first',
						'field_class'=>'excluir_cambio_propietario',
						'field_type'=>'text',
						'field_options'=>$excluir_cambio_propietario
					);
					echo $this->marvin->print_html_select($config)
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

