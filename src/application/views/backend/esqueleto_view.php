<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="es" />
	<meta http-equiv="pragma" content="nocache" />
    <meta name="robots" content="noindex, nofollow" />
	<?php if($this->router->method=='toemail'):?>
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/default_pdf.css" media="print">
	<?php else: ?>
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/yahoo_css_reset.css" media="print">
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/default_print.css" media="print">
	<?php endif; ?>
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/backend.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/link_icons.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/baseline.grid.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/menu.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/jquery.smoothness/jquery-ui-1.8.custom.css" media="screen">
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



	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/tables.css" media="screen">



	<?php
	if(isset($CKEDITOR))
	{
	?>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/ckeditor/ckeditor.js"></script>
	<?
	}
	?>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery-ui-1.8.custom.min.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery.livequery.js"></script>
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




    <title>HARWS2</title>


</head>


<body>

		<div class="fondo_interior">
			<div class="contenedor_home">




				<!-- cabezal -->
				<div class="cabezal_home">
					<div><a href="<?=$this->config->item('base_url').$this->config->item('backend_root').'index';?>" title="home"><h1 class="cabezal_logo"></h1></a></div>
					<div class="cabezal_logo toprint"><img src="<?=$this->config->item('base_url').'public/css/default_print_images/harws_logo_print.gif';?>"></div>
					<div class="cabezal_datos">
						<span class="cabezal_fecha"><?=$BACKEND_FECHA_ACTUAL;?></span><br />
						<span class="cabezal_datos_user"><?=$BACKEND_ADMINS_ONLINE;?> <?=lang('usuarios_online');?></span><br />
						<span id="cpu"></span>
						
					</div>
					<div class="cabezal_login">
						<span class="cabezal_login_nombre"><?=$this->session->userdata('admin_field_nombre');?> <?=$this->session->userdata('admin_field_apellido');?></span> [<a href="<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>/login/logoff"> <?=lang('logoff');?> </a>]<br />
						<?=$this->session->userdata('empresa_field_desc');?> <?=$this->session->userdata('cliente_field_desc');?>.<br />
						<?=lang('ultimo_ingreso');?>: <?=$this->session->userdata('admin_field_fechahora_ultimo_login');?>
					</div>
				</div>
				<!-- cabezal -->

				<!-- menu -->


				<!-- menu -->
				<div id="botonera_h">
					<!-- menu -->
					<div id="menu">
						<div class="t-center">
							<ul class="sf-menu">

					<?
					/*
                                         *
                                         TODO: Esto tiene que estar en memoria !
                                         *
                                         */
					$arbol = Doctrine::getTable('Backend_Menu')->getTree();
					$rootColumnName = $arbol->getAttribute('rootColumnName');
					foreach ($arbol->fetchRoots() as $root) {

					$options = array('root_id' => $root->$rootColumnName,'orderBy');
					foreach($arbol->fetchTree($options) as $node) {
						if($node->getNode()->isRoot() && $this->backend->_permiso('view',$node->id))
						{
							$target = "";
							echo "<li rel='root'>\n";
							if(strlen($node->backend_menu_field_url)>0)
							{

								$link=$this->config->item('base_url').$this->config->item('backend_root').$node->backend_menu_field_url;
								if(strlen($node->backend_menu_field_target)>0)
								{
									$target = 'target = "'.$node->backend_menu_field_target.'"';
								}
							}else{
								$link="#";
							}
							echo "<a href='".$link."' ".$target."><!--#". $node->id." -->".$node->backend_menu_field_desc."</a>";
							if($node->getNode()->hasChildren())
							{
								echo "<ul>\n";
								$areas = $node->getNode()->getChildren();
								foreach ($areas as $area) {
									$target = "";
									if($this->backend->_permiso('view',$area->id)){
										echo "<li>\n";
										if(strlen($area->backend_menu_field_url)>0)
										{
											$link=$this->config->item('base_url').$this->config->item('backend_root').$area->backend_menu_field_url;
											if(strlen($area->backend_menu_field_target)>0)
											{
												$target = 'target = "'.$area->backend_menu_field_target.'"';
											}
										}else{
											$link="#";
										}
										$class = '';
										if($area->backend_menu_field_admin == 2 && !$area->getNode()->hasChildren())
										{
											$class='class="key"';
										}
										echo "<a href='".$link."' $class ".$target."><!--# ". var_export($area->id, true) ." -->".$area->backend_menu_field_desc."</a>";

										if(defined('ID_SECCION') && ID_SECCION==$area->id){
											$SECCION_ACTUAL = $area->backend_menu_field_desc;
											$SECCION_ACTUAL_LINK = $area->backend_menu_field_url;
											$AREA_ACTUAL = $area->backend_menu_field_desc;
											$ZONA_ACTUAL = $area->getNode()->getParent()->backend_menu_field_desc;
										}

										if($area->getNode()->hasChildren())
										{
											echo "<ul>";
											$secciones = $area->getNode()->getChildren();
											foreach ($secciones as $seccion) {
												$target = "";
												if($this->backend->_permiso('view',$seccion->id)){
													if(strlen($seccion->backend_menu_field_url)>0)
													{
														$link=$this->config->item('base_url').$this->config->item('backend_root').$seccion->backend_menu_field_url;
														if(strlen($seccion->backend_menu_field_target)>0)
														{
															$target = 'target = "'.$seccion->backend_menu_field_target.'"';
														}
													}else{
														$link="#";
													}
													//---------
													if(defined('ID_SECCION') && ID_SECCION==$seccion->id){
														$SECCION_ACTUAL = $seccion->backend_menu_field_desc;
														$SECCION_ACTUAL_LINK = $seccion->backend_menu_field_url;
														if($seccion->getNode()->hasParent()){
															$padre = $seccion->getNode()->getParent();
															$AREA_ACTUAL = $padre->backend_menu_field_desc;
															if($padre->getNode()->hasParent()){
																$padre = $padre->getNode()->getParent();
																$ZONA_ACTUAL = $padre->backend_menu_field_desc;
															}
														}
													}
													//---------


													//iconito para el menu
													$class="";
													if($seccion->backend_menu_field_admin == 2)
													{
														$class='class="key"';
													}


													echo "<li>\n";
													echo "<a href='".$link."' ".$class." ".$target."><!-- #".var_export($seccion->id, true). '-->' . $seccion->backend_menu_field_desc."</a>";
													echo "</li>\n";
												}
											}
											echo "</ul>";

										}
										echo "</li>\n";
									}
								}
								echo "</ul>\n";
							}
							echo "</li>\n";

						}

					}
				}
					?>


							</ul>
						</div>
					</div>
					<!-- menu -->
				</div>
				<!-- menu -->

				<!-- menu -->




			</div>

		</div>

		<?if(isset($SECCION_ACTUAL)){?>
		<div class="contenedor_main clearfix" >

				<div class="contenedor_home">
					<div class="status_interior"><a href="<?= $this->config->item('base_url').$this->config->item('backend_root') . $SECCION_ACTUAL_LINK;?>"><?=$SECCION_ACTUAL?></a>
						<span class="sub_status_interior"><?=$ZONA_ACTUAL?> > <?=$AREA_ACTUAL?></span>
					</div>
					<div class="buscador">
						<form action="<?= $this->config->item('base_url').$this->config->item('backend_root') . $SECCION_ACTUAL_LINK;?>" method="post" class="always">
						<input type="text" name="_buscador_general" id="textfield" value="<?if(set_value('_buscador_general')){echo set_value('_buscador_general');}else{echo lang('buscar');}?>" class="buscador_campo" />
						<input type="submit" name="_filtro" id="button" value=" " class="buscador_boton always buscador_campo"/>

						</form>
					</div>
				</div>

		</div>
		<?
		}
		?>

		<div class="mensaje_sistema">
			<div class="contenedor_home">
				<?php if($this->session->flashdata('add_ok')){?>
					<div class="info_ok"><?=lang('registro_ingresado');?></div>
				<?}?>
				<?php if($this->session->flashdata('edit_ok')){?>
					<div class="info_ok"><?=lang('registro_actualizado');?></div>
				<?}?>
				<?php if($this->session->flashdata('del_ok')){?>
					<div class="info_ok"><?=lang('registro_eliminado');?></div>
				<?}?>
				<?php if($this->session->flashdata('reject_ok')){?>
					<div class="info_ok"><?=lang('registro_rechazado');?></div>
				<?}?>
				<?php if($this->session->flashdata('approve_ok')){?>
					<div class="info_ok"><?=lang('registro_aprobado');?></div>
				<?}?>
				<?php if($this->session->flashdata('del_image_ok')){?>
					<div class="info_ok"><?=lang('imagen_eliminada');?></div>
				<?}?>
				<?php if(validation_errors() ||isset($SHOW_ERROR_BUSCADOR) || isset($upload_error)){?>
					<div class="info_error">
						<?php  echo validation_errors('<p>','</p>'); ?>
						<?php echo isset($upload_error) && !is_array($upload_error) ? $upload_error : ''; ?>
						<?php if (isset($upload_error) && is_array($upload_error)): ?>
						<ul>
						<?php foreach ($upload_error as $error): ?><li><?php echo $error; ?></li><?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div>
				<?}?>

				<?php if($this->session->flashdata('upload_error')){
					$_upload_error = $this->session->flashdata('upload_error');
					?>
					<div class="info_error">
						<?php if (is_array($_upload_error)):
						?>
						<ul>
						<?php foreach ($_upload_error as $error): ?><li><?php echo $error; ?></li><?php endforeach; ?>
						</ul>
						<?php
						else:
							echo $_upload_error;
						endif; ?>
					</div>
				<?}?>


				<!--div class="contenedor_home">

						<div class="info_error"><span class="info_titulo">Error!</span><br>Este es un mensaje de error. Usted hizo algo mal, el sistema no se equivoca.</div>
					<div class="info_warning"><span class="info_titulo">Warning</span><br />Este es un mensaje de advertencia. Usted hizo algo mal, el sistema no se equivoca.</div>
						<div class="info_ok"><span class="info_titulo">OK!</span><br />Al fin lo hizo bien, el sistema no se equivoca.</div>
						<div	class="info_sistema"><span class="info_titulo">Le aviso</span><br />Puedo dejar de funcionar en cualquier momento.</div>



				</div-->

			</div>
		</div>

		<!-- -->
		<div class="main">
			<div class="contenedor_home">
				<div class="botonera_interior" >
				<?php
				if(isset($tpl_include)){
					$this->load->view( $tpl_include );
				}?>
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
				<div class="logo_pie">harws 2.19 &copy; 2006 - <?echo date("Y");?> Honda Motor de Argentina. Todos los derechos reservados<br />
				<img src="<?=$this->config->item('base_url');?>public/images/pie_logo.gif"/>
				</div>
			</div>
		</div>
		<!-- FIN PIE ------------------------------------------------------------------------------------------------------------------------------------- -->

<?php if($this->router->method!='toemail'):?>

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
<?php endif;?>
</body>
</html>
