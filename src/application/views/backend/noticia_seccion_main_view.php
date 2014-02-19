

	<div id="tabs">
		<ul>
<!-- 			<li><a href="#tabs-1"><img src="<?=$this->config->item('base_url');?>public/images/boton_principal.png"  /></a></li> -->
<!-- 			<li><a href="#tabs-2"><img src="<?=$this->config->item('base_url');?>public/images/boton_reporte.png" /></a></li> -->
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
		<form class="wufoo" autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>


		<fieldset>
		<li class="leftHalf">
			
			<label class="desc"><?=$this->marvin->mysql_field_to_human('Noticia_Seccion');?></label>

			<span>
				<label><?=$this->marvin->mysql_field_to_human('noticia_seccion_field_desc');?></label>
				<input id="noticia_seccion_field_desc" name="noticia_seccion_field_desc" class="field text " size="14" value="<?=set_value('noticia_seccion_field_desc');?>" type="text">
			</span>

			
		</li>
		<li class="rightHalf">
			<!-- :P -->
		</li>
		</fieldset>
		

		<fieldset>
		<li class="full">
		
			<label class="desc"><?=$this->marvin->mysql_field_to_human('backend_estado_id');?></label>
			<div class="checkbox">
			<?
				if(isset($backend_estado_id) && is_array($backend_estado_id))
				{
					while (list($key, $value) = each($backend_estado_id))
					{
			?>
					<span>
					<input name="backend_estado_id[]" id="backend_estado_id<?=$key;?>" value="<?=$key?>" type="checkbox"
					<?= $this->form_validation->set_checkbox('backend_estado_id[]', $key); ?>>
					<label class="CheckBoxLabelClass" for="backend_estado_id<?=$key;?>"><?=$value?></label>
					</span>
			<?
					}
				}
			?>
			</div>
			
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

