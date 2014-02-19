
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
				<label class="desc"><?=$this->marvin->mysql_field_to_human('Backend_Estado');?></label>
				

					<span>
						<label <?php if(form_error('backend_estado_field_desc')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('backend_estado_field_desc');?></label>
						<input id="backend_estado_field_desc" name="backend_estado_field_desc" class="field text <?php if(form_error('backend_estado_field_desc')){ echo 'error';} ?>" size="14" value="<?php echo set_value('backend_estado_field_desc'); ?>" type="text">
					</span>

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
