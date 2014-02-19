
<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
		?>
<form class="wufoo" autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<fieldset>
				<li class="leftHalf">
				<label class="desc"><?=$this->marvin->mysql_field_to_human('Vin_Version');?></label>
				
				
			<span>
				<label><?=$this->marvin->mysql_field_to_human('vin_version_id');?></label>
				<input id="vin_version_id" name="vin_version_id" class="field text " size="14" value="<?=set_value('vin_version_id');?>" type="text">
			</span>
			
			<span>
				<label><?=$this->marvin->mysql_field_to_human('vin_modelo_id');?></label>
				<input id="vin_modelo_id" name="vin_modelo_id" class="field text " size="14" value="<?=set_value('vin_modelo_id');?>" type="text">
			</span>


				<!--
				<span>
					<label <?php if(form_error('vin_version_id')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('vin_version_id');?></label>
					<div>
						<?php echo form_dropdown('vin_version_id', $vin_version_id, set_value('vin_version_id'),'class="field"')?>
					</div>
				</span>

				<span>
					<label <?php if(form_error('vin_modelo_id')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('vin_modelo_id');?></label>
					<div>
						<?php echo form_dropdown('vin_modelo_id', $vin_modelo_id, set_value('vin_modelo_id'),'class="field"')?>
					</div>
				</span>
				-->
				<span>
					<label <?php if(form_error('auto_version_id')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('auto_version_id');?></label>
					<div>
						<?php echo form_dropdown('auto_version_id', $auto_version_id, set_value('auto_version_id'),'class="field"')?>
					</div>
				</span>

		</li>
		<li class="rightHalf">
			<!-- :P -->
		</li>
		</fieldset>

				
				<fieldset>
					<li class="buttons">
						<div>
							<input id="enviar" name="_submit" class="btTxt submit" value="<?=lang('enviar_form');?>" type="submit">
						</div>
					</li>
				</fieldset>
			</ul>
</form>
</div>
</div>
