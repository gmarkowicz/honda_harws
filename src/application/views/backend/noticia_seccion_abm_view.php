
<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
<!-- 			<li><a href="#tabs-1"><img src="<?=$this->config->item('base_url');?>public/images/boton_principal.png"  /></a></li> -->
		</ul>
		<div id="tabs-1">
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
		?>
<form class="wufoo" autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<fieldset>
				<li class="leftHalf">
				<label class="desc"><?=$this->marvin->mysql_field_to_human('noticia_seccion_id');?></label>
				

					<span>
						<label <?php if(form_error('noticia_seccion_field_desc')){ echo 'class="error"';} ?>>
							<?=$this->marvin->mysql_field_to_human('noticia_seccion_field_desc');?><span class="req">*</span>
						</label>
						<input id="noticia_seccion_field_desc" name="noticia_seccion_field_desc" class="field text <?php if(form_error('noticia_seccion_field_desc')){ echo 'error';} ?>" size="26" value="<?php echo set_value('noticia_seccion_field_desc'); ?>" type="text">
					</span>

				<label <?php if(form_error('backend_estado_id')){ echo 'class="error"';} ?>>
					<?=$this->marvin->mysql_field_to_human('backend_estado_id');?><span class="req">*</span>
				</label>
				<div>
					<?php echo form_dropdown('backend_estado_id', $backend_estado_id, set_value('backend_estado_id'),'class="field" style="width:200px"')?>
				</div>

		</li>
		<li class="rightHalf">
			<!-- :P -->
		</li>
		</fieldset>

		</ul>
		<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
		?>
</form>
</div>
</div>
