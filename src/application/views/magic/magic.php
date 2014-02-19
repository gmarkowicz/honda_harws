<h1>en casa de herrero cuchillo de palo</h1>

<table border="1">
	
	
	<tr>
		<td>
		<p>Datos Actuales:</p>
		Modelo: <?=@$modelo;?><br />
		</td>
	</tr>
	
	<tr>
		<td></td>
	</tr>
	
	<tr>
		<td>
		<h2>Form Modelo</h2>
		<form action="<?=site_url();?>magic/magic/set_modelo" method="post">
			<label for="modelo">Modelo:</label><input type="text" id="modelo" name="modelo" value="<?=@$modelo;?>">
			
		<h2>Columnas Grilla</h2>
		
			<table border="1">
			<?
							if(isset($columnas) && is_array($columnas)){
								while (list($campo, $value) = each($columnas)) {
							?>
								<tr>
								<td>
								<input name="columnas_main[]" id="columnas_main<?=$campo;?>" value="<?=$campo?>" type="checkbox"
								<?= $this->form_validation->set_checkbox('columnas_main[]', $campo); ?>
								>
								<label class="choice" for="columnas_main<?=$campo;?>"><?=$campo?></label>
								</tr>
								</td>
							<?
								}
							}
						?>
			</table>
			<p><input type="submit" value="go go go!" name="submit"></p>
		</form>
		
		</td>
	</tr>
	<tr>
		<td>
			<a href="<?=site_url();?>magic/magic/create">Crear</a>
		</td>
	</tr>

	
	
	
</table>


