<div class="botones_registros">
	<?
	if($this->router->method!=='show')
	{
	?>
		<?if(isset($abm_url) && $this->backend->_permiso('add')){?>
			<p><a id="nuevoregistro" href="<?=$abm_url?>/add"><?=lang('nuevo_registro');?></a></p>
		<?}?>
		<?if(set_value('id') && $this->backend->_permiso('del')){?>
			<p><a id="eliminar_registro" href="#"><?=lang('eliminar_registro');?></a></p>
		<?}?>
		<?if(set_value('id') && $this->backend->_permiso('admin') && (isset($SHOW_RECHAZAR_REGISTRO) && $SHOW_RECHAZAR_REGISTRO===TRUE) && !isset($rechazado)){?>
			<p><a id="rechazar_registro" href="#"><?=lang('rechazar_registro');?></a></p>
		<?}?>
		<?if(isset($js_grid)){?>
			<p><a id="exportarxls" href="<?php echo current_url();?>/export/xls"><?=lang('exportar');?></a></p>
		<?}?>
		<?php if(set_value('id') && $this->router->fetch_class()!='reclamo_garantia_abm'):?>
		<p><a id="versionimprenta" href="#" onclick="javascript:myPrint();"><?=lang('imprimir');?></a></p>
		<?php endif;?>
	
	<?
	}
	else
	{
	?>
		<p><a id="versionimprenta" href="#" onclick="javascript:myPrint();"><?=lang('imprimir');?></a></p>
		<?php if($this->router->fetch_class()=='tsi_encuesta_satisfaccion_abm'):?>
		<p><a id="enviarpormail" href="<?=$abm_url?>/toemail/<?php echo set_value('id');?>">enviar por mail</a></p>
		<?php endif;?>
	<?
	}
	?>
	
</div>


