<div class="info utils">
	<p class="f-right"><a href="<?php echo current_url();?>/export/xls" class="exportar_xls"><?=lang('exportar');?></a></p>
</div>
<!-- tabs -->
<div id="tabs">
	<ul>
		<li><a href="#tabs-1"><?=lang('principal');?></a></li>
		<li><a href="#tabs-2"><?=lang('reporte');?></a></li>
	</ul>
	<div id="tabs-1">
		<!-- grilla -->
		<div class="grilla">
			<table id="flex1" style="display:none"></table>
		</div>
		<!-- grilla -->
	</div>
	<div id="tabs-2">
		<!-- a ver a ver -->
		<form method="post" action="<?php echo current_url();?>">
		<ul>
			<fieldset>
				<li>
				
							<label class="desc"><?=lang('noticia');?></label>
							<span>
								<input id="noticia_titulo" name="noticia_titulo" class="field text fn" value="<?=set_value('noticia_titulo');?>" size="20" type="text">
								<label for="noticia_titulo"><?=lang('titulo');?></label>
							</span>
							<span>
								<input id="noticia_copete" name="noticia_copete" class="field text fn" value="<?=set_value('noticia_copete');?>" size="20" type="text">
								<label for="noticia_copete"><?=lang('copete');?></label>
							</span>
							<span>
								<input id="noticia_desarrollo" name="noticia_desarrollo" class="field text fn" value="<?php echo set_value('desarrollo'); ?>" size="20" type="text">
								<label for="admin_apellido"><?=lang('desarrollo');?></label>
							</span>			
							
						
				</li>
				</fieldset>
				<fieldset>				
				<fieldset>
				<li class="buttons">
					<div>
						<input id="enviar" name="_filtro" class="btTxt submit" value="<?=lang('filtrar')?>" type="submit">
					</div>
				</li>
			</fieldset>
				
			</ul>
		</form>
		<!-- a ver a ver -->
	</div>
</div>

