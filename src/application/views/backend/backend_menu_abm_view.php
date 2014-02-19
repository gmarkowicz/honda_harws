
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
				<label class="desc"><?=$this->marvin->mysql_field_to_human('Backend_Menu');?></label>
				

					<span>
						<label <?php if(form_error('backend_menu_field_desc')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('backend_menu_field_desc');?></label>
						<input id="backend_menu_field_desc" name="backend_menu_field_desc" class="field text <?php if(form_error('backend_menu_field_desc')){ echo 'error';} ?>" size="14" value="<?php echo set_value('backend_menu_field_desc'); ?>" type="text">
					</span>

					<span>
						<label <?php if(form_error('backend_menu_field_url')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('backend_menu_field_url');?></label>
						<input id="backend_menu_field_url" name="backend_menu_field_url" class="field text <?php if(form_error('backend_menu_field_url')){ echo 'error';} ?>" size="14" value="<?php echo set_value('backend_menu_field_url'); ?>" type="text">
					</span>

				<span>
					<label <?php if(form_error('root_id')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('root_id');?></label>
					<div>
						<?php echo form_dropdown('root_id', $root_id, set_value('root_id'),'class="field"')?>
					</div>
				</span>

		</li>
		<li class="rightHalf">
			<!-- :P -->
		</li>
		</fieldset>

			<fieldset>
			<li class="full">
				
				<label class="desc"><?=$this->marvin->mysql_field_to_human('grupo_id');?></label>
				
				<div class="checkbox">
								<?
								if(isset($backend_menu_m_grupo) && is_array($backend_menu_m_grupo)){
									while (list($key, $value) = each($backend_menu_m_grupo)) {
								?>
									<span>
									<input name="backend_menu_m_grupo[]" id="backend_menu_m_grupo<?=$key;?>" class="field checkbox" value="<?=$key?>" type="checkbox"
									<?= $this->form_validation->set_checkbox('backend_menu_m_grupo[]', $key); ?>
									>
									<label class="choice" for="backend_menu_m_grupo<?=$key;?>"><?=$value?></label>
									</span>
								<?
									}
								}
								?>
								
							</div>
				
			</li>
			</fieldset>

			</ul>
			
			
			<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
			?>
</form>
</div>
</div>
