<script type="text/javascript">
	
	 
	 $(document).ready(function() {
		$.manageAjax.create('cola_publicidad_show', {queue: 'clear', maxRequests: 1, abortOld: true});
		$(".grid_link_view").livequery('click', function() { 
			
			 $.manageAjax.add('cola_publicidad_show', 
						{
							beforeSend: function()
							{
								$('._ajax_append').append('<div class="_ajax_loading _cola_publicidad_show"></div>');
							},
							type: "GET",
							 url: "<?=$abm_url?>/show/"+$(this).attr("id"),
							success: function(respuesta)
							{
								 $('#publicidad_show').html(respuesta);
								 $('._cola_publicidad_show').remove();
								 //
								 $( "#publicidad_show" ).dialog({
									width: 860,
									height: 490,
									modal: true
									});
								 //
							}
						});
			
			

			return false;
		});
		
	});
	
</script>

<div id="publicidad_show" title="" class="hide">
	
</div>



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
		<legend><?=$this->marvin->mysql_field_to_human('publicidad_id');?></legend>
		<li class="unitx4 f-left">
			<?php
				$config	=	array(
								'field_name'=>'publicidad_field_desc',
								'field_req'=>FALSE,
								'label_class'=>'unitx3 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				
	
			
		</li>
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'=>'publicidad_field_fecha_publicacion_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'publicidad_field_fecha_publicacion_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		</li>
		</fieldset>
		

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('publicidad_medida_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'publicidad_medida_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$publicidad_medida_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('publicidad_ubicacion_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'publicidad_ubicacion_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$publicidad_ubicacion_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('publicidad_medio_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'publicidad_medio_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$publicidad_medio_id
						
						);
						echo $this->marvin->print_html_checkbox($config);
						?>
				
			</li>
			</fieldset>

		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('publicidad_producto_id');?></legend>
			<li class="unitx8">
				<?php
					$config	=	array(
						'field_name'=>'publicidad_producto_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$publicidad_producto_id
						
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

