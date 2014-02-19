<form method="post" action="<?php echo current_url();?>">
		<ul>	
				<fieldset>
				<legend><?=lang('autor');?></legend>
				<li <?php if(form_error('noticia_autor_nombre')){ echo 'class="error"';} ?>>
					<label class="desc" id="noticia_autor_nombre" for="noticia_autor_nombre"><?=lang('nombre');?></label>
					<div><input id="noticia_autor_nombre" name="noticia_autor_nombre" class="field text medium" value="<?php echo set_value('noticia_autor_nombre'); ?>" type="text"></div>
				</li>
				<li <?php if(form_error('noticia_autor_apellido')){ echo 'class="error"';} ?>>
					<label class="desc" id="noticia_autor_apellido" for="noticia_autor_apellido"><?=lang('apellido');?></label>
					<div><input id="noticia_autor_apellido" name="noticia_autor_apellido" class="field text medium" value="<?php echo set_value('noticia_autor_apellido'); ?>" type="text"></div>
				</li>
				<li <?php if(form_error('noticia_autor_email')){ echo 'class="error"';} ?>>
					<label class="desc" id="noticia_autor_email" for="noticia_autor_email"><?=lang('email');?></label>
					<div><input id="noticia_autor_email" name="noticia_autor_email" class="field text medium" value="<?php echo set_value('noticia_autor_email'); ?>" type="text"></div>
				</li>
			</fieldset>
			</ul>
			
			
			<?php
				$this->load->view( 'backend/_inc_abm_submit_view' );
			?>
</form>