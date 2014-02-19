<?php if(!$this->input->post()):?>
<script type="text/javascript">
$(document).ready(function(){
	 $('#reporte').trigger('click');

}); 
</script>
<?endif?>

	<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
			<li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
		</ul>
		<div id="tabs-1">
			
			<div class="botones_registros">
				<?php if(isset($js_grid)):?>
					<p><a id="exportarxls" href="<?php echo current_url();?>/export/xls"><?=lang('exportar');?></a></p>
				<?php endif;?>
			</div>
			
			<?php
				//$this->load->view( 'backend/esqueleto_botones_view' );
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
		
		<li class="unitx4 f-left">
			<?php
					$config	=	array(
							'field_name'=>'unidad_field_fecha_entrega_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
				<?php
					$config	=	array(
							'field_name'=>'unidad_field_fecha_entrega_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config);
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

