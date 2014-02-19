

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
			
			<label class="desc"><?=$this->marvin->mysql_field_to_human('Backend_Estado');?></label>

			<span>
				<label><?=$this->marvin->mysql_field_to_human('backend_estado_field_desc');?></label>
				<input id="backend_estado_field_desc" name="backend_estado_field_desc" class="field text " size="14" value="<?=set_value('backend_estado_field_desc');?>" type="text">
			</span>

			
		</li>
		<li class="rightHalf">
			<!-- :P -->
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

