

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
		<form class="wufoo" autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>


		<fieldset>
		<li class="leftHalf">
			
			<label class="desc"><?=$this->marvin->mysql_field_to_human('Backend_Menu');?></label>

			<span>
				<label><?=$this->marvin->mysql_field_to_human('backend_menu_field_desc');?></label>
				<input id="backend_menu_field_desc" name="backend_menu_field_desc" class="field text " size="14" value="<?=set_value('backend_menu_field_desc');?>" type="text">
			</span>

			<span>
				<label><?=$this->marvin->mysql_field_to_human('backend_menu_field_url');?></label>
				<input id="backend_menu_field_url" name="backend_menu_field_url" class="field text " size="14" value="<?=set_value('backend_menu_field_url');?>" type="text">
			</span>

			<span>
				<label><?=$this->marvin->mysql_field_to_human('lft');?></label>
				<input id="lft" name="lft" class="field text " size="14" value="<?=set_value('lft');?>" type="text">
			</span>

			<span>
				<label><?=$this->marvin->mysql_field_to_human('rgt');?></label>
				<input id="rgt" name="rgt" class="field text " size="14" value="<?=set_value('rgt');?>" type="text">
			</span>

			<span>
				<label><?=$this->marvin->mysql_field_to_human('level');?></label>
				<input id="level" name="level" class="field text " size="14" value="<?=set_value('level');?>" type="text">
			</span>

			
		</li>
		<li class="rightHalf">
			<!-- :P -->
		</li>
		</fieldset>
		

		<fieldset>
		<li class="full">
		
			<label class="desc"><?=$this->marvin->mysql_field_to_human('root_id');?></label>
			<div class="checkbox">
			<?
				if(isset($root_id) && is_array($root_id))
				{
					while (list($key, $value) = each($root_id))
					{
			?>
					<span>
					<input name="root_id[]" id="root_id<?=$key;?>" class="field checkbox" value="<?=$key?>" type="checkbox"
					<?= $this->form_validation->set_checkbox('root_id[]', $key); ?>>
					<label class="choice" for="root_id<?=$key;?>"><?=$value?></label>
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

