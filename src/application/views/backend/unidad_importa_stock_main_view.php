
	
	
	<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		
		<?php if(isset($importa_stock_upload_error)):?>
					
			<div class="info_error">
				<?php
				reset($importa_stock_upload_error);
				while (list(,$error) = each($importa_stock_upload_error))
				{
					echo $error . "<br />";
				}
				?>
			</div>
					
		<?php endif;?>
			
		
		
		<?php if(isset($unidades_importadas)):?>
			
			<div class="info_ok">
				<?php echo $unidades_importadas;?> <?php echo lang('registros_actualizados');?>
			</div>
			
		<?php endif;?>
		
		
		<div id="tabs-1">
		
			

		
		<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>
		

		<fieldset>
		<legend><?php echo lang('ingresar_adjunto');?></legend>
				<li class="unitx8 both">
					<label><?php echo lang('ingresar_adjunto');?><input  type="file" name="unidad_stock" size="20" accept="xls" /></label>
				</li>
		</fieldset>

		
		<li class="buttons">
			<fieldset>
			<div>
				<input id="enviar" name="_submit" class="btTxt submit" value="<?=lang('enviar_form');?>" type="submit">
			</div>
			</fieldset>
		</li>
			


	
		</ul>
		</form>		
			
								
			</div>
	
	
</div>

