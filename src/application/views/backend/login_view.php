<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HARWS</title>
<link href="<?=$this->config->item('base_url');?>public/css/login.css" rel="stylesheet" type="text/css" />

</head>

<body>
	<div class="fondo_interior">
		<div class="contenedor_home">
		<div class="centro_fondo">
							<form method="post" action="<?php echo current_url();?>">
								<label  for="admin_field_usuario">USUARIO<br />
								<input id="admin_field_usuario" name="admin_field_usuario" class="campo" value="<?=@$this->session->flashdata('admin_field_usuario');?>" type="text">
								</label><br />
								<label for="admin_field_password" class="">CONTRASE&Ntilde;A<br />
								<input id="admin_field_password" name="admin_field_password" class="campo" value="" type="password">
								</label>
								<input id="saveForm" name="_backend_login" class="boton" value="IDENTIFICARSE" type="submit">	
							</form>
						<?php 
						if($this->session->flashdata('login_error')){
							echo '<div class="errores"><strong>Datos Incorrectos</strong></div>';
						}
						if($this->session->flashdata('usuario_deshabilitado')){
							echo '<div class="errores"><strong>Usuario deshabilitado</strong></div>';
						}
						if($this->session->flashdata('permisos_insuficientes')){
							echo '<div class="errores"><strong>Permisos insuficientes</strong></div>';
						}
						?>
									
		</div>

		</div>
</div>

<!-- PIE ------------------------------------------------------------------------------------------------------------------------------------- -->	

	<div class="fondo_pie" class="clearfix">
		<div class="contenedor_pie">
		<div class="logo_pie"> <?=date("Y");?> Honda Motor de Argentina. Todos los derechos reservados<br />
		<img src="<?=$this->config->item('base_url');?>public/images/pie_logo.gif" width="182" height="25"/>
		</div>
	</div>
<!-- FIN PIE ------------------------------------------------------------------------------------------------------------------------------------- -->	
	</div>

</body>
</html>
