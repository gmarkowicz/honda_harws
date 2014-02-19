
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
				<label class="desc"><?=$this->marvin->mysql_field_to_human('Cliente');?></label>


					<span>
						<label <?php if(form_error('cliente_field_desc')){ echo 'class="error"';} ?>><?=$this->marvin->mysql_field_to_human('cliente_field_desc');?></label>
						<input id="cliente_field_desc" name="cliente_field_desc" class="field text <?php if(form_error('cliente_field_desc')){ echo 'error';} ?>" size="14" value="<?php echo set_value('cliente_field_desc'); ?>" type="text">
					</span>

				<label><?=$this->marvin->mysql_field_to_human('empresa_id');?></label>
				<div>
					<?php echo form_dropdown('empresa_id', $empresa_id, set_value('empresa_id'),'class="field"')?>
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
