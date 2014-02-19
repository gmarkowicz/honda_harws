

	<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
			<li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
		</ul>
		<div id="tabs-1">
			<div class="botones_registros">
				<?php if(isset($js_grid)):?>
					<p><a id="exportarxls" href="<?php echo current_url();?>/export/xls"><?=lang('exportar');?></a></p>
				<?endif?>
				
				<p><a id="versionimprenta" href="<?php echo current_url();?>/imprimir" target="_blank"><?=lang('imprimir');?></a></p>				
			</div>
			
			<div class="grilla">
					<table id="flex1" style="display:none"></table>
			</div>
								
			</div>
	
	<div id="tabs-2">
		<form  autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>

		
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

