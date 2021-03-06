<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="es" />
    <meta name="robots" content="noindex, nofollow" />
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/backend.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/form.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/menu.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/jquery.smoothness/jquery-ui-1.8.custom.css" media="screen">
	
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/flexigrid.css" media="screen">
	
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/jquery-ui-1.8.custom.min.js"></script>
	
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/flexigrid.pack.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('base_url');?>public/js/superfish.js"></script>
    
	<link rel="shortcut icon" href="<?=$this->config->item('base_url');?>public/favicon.ico" />


<script type="text/javascript">
$(document).ready(function(){
	$(".checkbox input").change(function(){
		if($(this).is(":checked")){
			$(this).next("label").addClass("LabelSelected");
		}else{
			$(this).next("label").removeClass("LabelSelected");
		}
	});
	$(".RadioClass").change(function(){
		if($(this).is(":checked")){
			$(".RadioSelected:not(:checked)").removeClass("RadioSelected");
			$(this).next("label").addClass("RadioSelected");
		}
	});	
});
</script>
<!-- <style>
 	.CheckBoxClass,.RadioClass{
		display: none;
	}
	.CheckBoxLabelClass{
		background: url("<?=$this->config->item('base_url');?>public/CustomizeHTMLControls/UnCheck.png") no-repeat;
		padding-left: 30px;
		padding-top: 3px;
		margin: 5px;
		height: 28px;	
		width: 150px;
		display: block;
	}
	.CheckBoxLabelClass:hover, .RadioLabelClass:hover{
		text-decoration: underline;
	}
	.LabelSelected{
		background: url("<?=$this->config->item('base_url');?>public/CustomizeHTMLControls/Check.png") no-repeat;
	}
	.RadioLabelClass{
		background: url("<?=$this->config->item('base_url');?>public/CustomizeHTMLControls/RUnCheck.png") no-repeat;
		padding-left: 30px;
		padding-top: 3px;
		margin: 5px;
		height: 28px;	
		width: 70px;
		display: block;	
		float: left;
	}
	.RadioSelected{
		background: url("<?=$this->config->item('base_url');?>public/CustomizeHTMLControls/RCheck.png") no-repeat;
	}
</style> -->

	 
    <title>HARWS</title>
	
	


</head>


<body>
	
		<div class="fondo_interior">
			<div class="contenedor_home">

				<!-- cabezal -->
				<div class="cabezal_home">
					<div class="cabezal_logo"></div>
					<div class="cabezal_datos">
						Miercoles 10 de Febrero<br />
						<span class="cabezal_datos_user">9 Usuarios on line</span>
					</div>
					<div class="cabezal_login">
						<span class="cabezal_login_nombre"><?=$this->session->userdata('admin_field_nombre');?> <?=$this->session->userdata('admin_field_apellido');?></span> [<a href="<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>/login/logoff"> CERRAR </a>]<br />
						<?=$this->session->userdata('empresa_field_desc');?> <?=$this->session->userdata('sucursal_field_desc');?>.<br />
						Ultimo Ingreso: 10/07/2009 - 10:23 hs.
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
								<li><a href="<?=$this->config->item('base_url').$this->config->item('backend_root').'/index';?>">Home</a></li>
					<?
					$arbol = Doctrine::getTable('Backend_Menu')->getTree();
					$rootColumnName = $arbol->getAttribute('rootColumnName');
					foreach ($arbol->fetchRoots() as $root) {
					$options = array('root_id' => $root->$rootColumnName,'orderBy');
					foreach($arbol->fetchTree($options) as $node) {
						if($node->getNode()->isRoot() && $this->backend->_permiso('view',$node->id))
						{
							echo "<li>\n";
							if(strlen($node->backend_menu_field_url)>0)
							{
								$link=$this->config->item('base_url').$this->config->item('backend_root').$node->backend_menu_field_url;
							}else{
								$link="#";
							}
							echo "<a href='".$link."'>#". $node->id." ".$node->backend_menu_field_desc."</a>";
							if($node->getNode()->hasChildren())
							{
								echo "<ul>\n";
								$areas = $node->getNode()->getChildren();
								foreach ($areas as $area) {
									if($this->backend->_permiso('view',$area->id)){
										echo "<li>\n";
										if(strlen($area->backend_menu_field_url)>0)
										{
											$link=$this->config->item('base_url').$this->config->item('backend_root').$area->backend_menu_field_url;
										}else{
											$link="#";	
										}
										echo "<a href='".$link."'># ". $area->id ." ".$area->backend_menu_field_desc."</a>";
										if($area->getNode()->hasChildren())
										{
											echo "<ul>";
											$secciones = $area->getNode()->getChildren();
											foreach ($secciones as $seccion) {
												if($this->backend->_permiso('view',$seccion->id)){
													if(strlen($seccion->backend_menu_field_url)>0)
													{
														$link=$this->config->item('base_url').$this->config->item('backend_root').$seccion->backend_menu_field_url;
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
													
													
													echo "<li>\n";
													echo "<a href='".$link."'>#".$seccion->id . ' ' . $seccion->backend_menu_field_desc."</a>";
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
		<div class="contenedor_main clearfix" style="background-color:#E20001" >
				
				<div class="contenedor_home">
					<div class="status_interior"><a href="<?= $this->config->item('base_url').$this->config->item('backend_root') . $SECCION_ACTUAL_LINK;?>"><?=$SECCION_ACTUAL?></a><br />
						<span class="sub_status_interior"><?=$ZONA_ACTUAL?> > <?=$AREA_ACTUAL?></span>
					</div>
					<div class="buscador">
						<input type="text" name="textfield" id="textfield" value="BUSCAR" class="buscador_campo" />
						<input type="submit" name="button" id="button" value=" " class="buscador_boton"/>
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
				<?php if($this->session->flashdata('del_image_ok')){?>
					<div class="info_ok"><?=lang('imagen_eliminada');?></div>
				<?}?>
				<?php if(validation_errors() ||isset($SHOW_ERROR_BUSCADOR)){?>
					<div class="info_error">
						<span class="info_titulo">Error!</span>
						<?php  echo validation_errors('<p>','</p>'); ?>
				
					</div>
				<?}?>
				<?php if($this->session->flashdata('upload_error')){?>
					<div class="info_error">
						<span class="info_titulo">Error!</span><br />
						<?print_r($this->session->flashdata('upload_error'));?>
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
				Tiempo de generacin de la pgina: 0.002 seg.   /   Cantidad de consultas a la base de datos: 7
				<div class="logo_pie"> 2009 Honda Motor de Argentina. Todos los derechos reservados<br />
				<img src="<?=$this->config->item('base_url');?>public/images/pie_logo.gif" width="182" height="25"/>
				</div>
			</div>
		</div>
		<!-- FIN PIE ------------------------------------------------------------------------------------------------------------------------------------- -->	

		
		
<div id="_ajax_loading" style="display:none;"></div>

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
	</form>
</div>
<?}?>
<?php
	$this->load->view( 'backend/esqueleto_header_view' );
	?>
</body>
</html>
