<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="en" />
    <meta name="robots" content="noindex, nofollow" />
	
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/link_icons.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/baseline.grid.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/menu.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/jquery.smoothness/jquery-ui-1.8.custom.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/boutique.css" media="screen">
	
	
	<?php 
	if(isset($js_grid))
	{
	?>
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/flexigrid.css" media="screen">
	<?php
	}
	?>
	
	<?php 
	if(isset($js_rating))
	{
	?>
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/js/packs/jquery.rating/jquery.rating.css" media="screen">
	<?php
	}
	?>
	
	<?php
	if(isset($CKEDITOR))
	{
	?>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/ckeditor/ckeditor.js"></script>
	<?
	}
	?>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery.validate.js"></script>	
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery.validate.translate.js"></script>	
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery.livequery.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/basic-jquery-slider.js"></script>
	<?php 
	if(isset($js_grid))
	{
	?>
		<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/flexigrid.pack.js"></script>
	<?php
	}
	?>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/superfish.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/customInput.jquery.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery.MultiFile.min.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery.ajaxmanager.js"></script>
	
	<?php 
	if(isset($js_rating))
	{
	?>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/packs/jquery.rating/jquery.rating.pack.js"></script>
	<?php
	}
	?>
	
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/backend.js"></script>
	
	
	<link rel="shortcut icon" href="<?=$this->config->item('base_url');?>public/favicon.ico" />

	 
	 
	 
    <title>HARWS2 - Boutique</title>
	
	
</head>


<body>
	
		<div class="general">
			<div class="cabezal">
				<div class="botonera">
	
					<!-- cabezal -->
					<div class="cabezal_home">
						<div><a href="<?=$this->config->item('base_url').$this->config->item('backend_root').'index';?>" title="home"><h1 class="cabezal_logo"></h1></a></div>
						<div class="cabezal_datos">
							<?=$BACKEND_FECHA_ACTUAL;?><br />
							<span class="cabezal_datos_user"><?=$BACKEND_ADMINS_ONLINE;?> <?=lang('usuarios_online');?></span>
						</div>
						<div class="cabezal_login">
							<span class="cabezal_login_nombre"><?=$this->session->userdata('admin_field_nombre');?> <?=$this->session->userdata('admin_field_apellido');?></span> [<a href="<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>/login/logoff"> <?=lang('logoff');?> </a>]<br />
							<?=$this->session->userdata('empresa_field_desc');?> <?=$this->session->userdata('cliente_field_desc');?>.<br />
							<?=lang('ultimo_ingreso');?>: <?=$this->session->userdata('admin_field_fechahora_ultimo_login');?>
						</div>				
					</div>
				
				</div>
				<!-- cabezal -->

				<!-- menu -->
				
				
				<!-- menu -->
				
					<!-- menu -->
					<div id="menu">
						<div>
							<ul id="nav">
								<?php 
								
								$query_categories_boutique = Doctrine_Query::create();								
								$query_categories_boutique->from("boutique_categoria");
								$query_categories_boutique->where("boutique_categoria_estado_id = 1");
								$query_categories_boutique->orderBy("boutique_categoria_field_desc");
								$categories = $query_categories_boutique->execute()->toArray();								
								
								$link = $this->config->item('base_url') . $this->config->item('backend_root') . 'boutique_main'; 
								
								
								echo '<li><a class="' . (($this->input->get("cat")) ? '': 'active') . '" href="' . $link . '">HOME</li><div class="separador"> </div>';
								foreach($categories as $categories_array)
								{
                                                                    echo '<li><a class="' . (($this->input->get("cat") == $categories_array['id']) ? 'active' : '') . '"href="' . $link . '?cat=' . (int)$categories_array['id'] . '">' .  $categories_array['boutique_categoria_field_desc'] . '</a></li>';
                                                                ?>
                                                                    <div class="separador"> </div>
                                                                <?php
								}
								?>
							</ul>
						</div>
					</div>
					<!-- menu -->
			</div>
		
		
		
		
		
		
		
			<!-- -->
			<div id="central" class="clearfix">
				
					<?php 
					if(isset($tpl_include)){
						$this->load->view( $tpl_include );		
					}?>		
			
				<div class="aclaracion">
					<p> <?=lang('boutique_aclaracion_pie');?> </p>
				</div>
			</div>
		</div>
		<!-- -->
		
		<!-- PIE ------------------------------------------------------------------------------------------------------------------------------------- -->	

		<div class="fondo_pie" style="clear:both;">
			<div class="contenedor_pie">
				<!--
				Tiempo de generacin de la pgina: 0.002 seg.   /   Cantidad de consultas a la base de datos: 7
				-->
				<div class="logo_pie">harws 2.19 &copy 2006 - <?echo date("Y");?> Honda Motor de Argentina. Todos los derechos reservados<br />
				<img src="<?=$this->config->item('base_url');?>public/images/pie_logo.gif" width="182" height="25"/>
				</div>
			</div>
		</div>
		<!-- FIN PIE ------------------------------------------------------------------------------------------------------------------------------------- -->	

		
<div class="_ajax_append"></div>

<?
if(set_value('id') && $this->backend->_permiso('del')){
?>
<div id="dialog-delete" title="Confirmaci&oacute;n">
	<div class="info sys_warning">
		<h2><?=lang('eliminar_registro');?></h2>
		<div><?=lang('eliminar_registro_advertencia');?></div>
	</div>
</div>
<div id="dialog-image-delete" title="Confirmaci&oacute;n">
	<div class="info sys_warning">
		<h2><?=lang('eliminar_imagen');?></h2>
		<div><?=lang('eliminar_registro_advertencia');?></div>
		<input type="hidden" id="delete_imagen_id" value="">
		<input type="hidden" id="delete_imagen_rel" value="">
	</div>
</div>
<div id="dialog-adjunto-delete" title="Confirmaci&oacute;n">
	<div class="info sys_warning">
		<h2><?=lang('eliminar_adjunto');?></h2>
		<div><?=lang('eliminar_adjunto_advertencia');?></div>
		<input type="hidden" id="delete_adjunto_id" value="">
		<input type="hidden" id="delete_adjunto_rel" value="">
	</div>
</div>
<?}?>
<?
if(set_value('id') && $this->backend->_permiso('admin') && (isset($SHOW_RECHAZAR_REGISTRO) && $SHOW_RECHAZAR_REGISTRO===TRUE)){
?>
<div id="dialog-rechazar" title="Confirmaci&oacute;n">
	<div class="info sys_warning">
		<h2><?=lang('rechazar_registro');?></h2>
		<div><?=lang('rechazar_registro_advertencia');?></div>
		
	</div>
	<div>
		<span><?=lang('rechazar_registro_motivo');?>:</span>
		<textarea id="_rechazo_motivo" style="width:100%;height:80px;"></textarea>
	</div>
</div>
<?}?>
<?
if(set_value('id') && $this->backend->_permiso('admin')){
?>
<div id="dialog-aprobar" title="Confirmaci&oacute;n">
	<div class="info sys_warning">
		<h2><?=lang('aprobar_registro');?></h2>
		<div><?=lang('aprobar_registro_advertencia');?></div>
	</div>
</div>
<?}?>
<?
if(set_value('id') && $this->backend->_permiso('edit')){
?>
<div id="_imagen_descripcion" title="<?=lang('editar_imagen');?>">
	<form>
	<ul>
		<li>
		
			<label class="desc" for="_imagen_titulo"><?=lang('titulo');?></label>
			<div id="_editar_imagen_background"><input id="_imagen_titulo" class="field text medium" value="" type="text">
			
			</div>
						
		</li>
		<li>
			<label class="desc" for="_imagen_copete"><?=lang('copete');?></label>
			<div>
				<textarea id="_imagen_copete" class="field textarea medium" rows="5" cols="50"></textarea>
			</div>
						
		</li>
	</ul>
		<input type="hidden" id="_edit_imagen_id" value="">
		<input type="hidden" id="_table_prefix" value="">
	</form>
</div>
<?}?>
<?php
	$this->load->view( 'backend/esqueleto_header_view' );
	?>
</body>
</html>
