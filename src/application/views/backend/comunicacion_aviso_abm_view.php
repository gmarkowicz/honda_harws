<div id="tabs">
    <ul>
            <li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
    </ul>
    <div id="tabs-1">
        <?php
            $this->load->view( 'backend/esqueleto_botones_view' );
        ?>
        <form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
            <ul>
                <fieldset>
                    <legend><?=$this->marvin->mysql_field_to_human('comunicacion_aviso_title');?></legend>
                    <li class="unitx4 f-left">
                        <?php
                            $config = array(
                                'field_name'	=>'comunicacion_aviso_field_desc',
                                'field_req'	=>TRUE,
                                'label_class'	=>'unitx4',
                                'field_class'	=>'',
                                'field_type'	=>'text',
                                );
                            echo $this->marvin->print_html_input($config);
                        ?>
                    </li>
                    <li class="unitx4 f-left">
                        <?php
							$config	=	array(
									'field_name'=>'comunicacion_aviso_field_fecha_publicacion',
									'field_req'=>FALSE,
									'label_class'=>'unitx2', //first
									'field_class'=>'',
									);
								echo $this->marvin->print_html_calendar($config);
							?>
                    </li>
                    <li class="unitx4">
                        <?php
						$config	=	array(
							'field_name'=>'comunicacion_producto_id',
							'field_req'=>true,
							'field_selected'	=> false,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							'field_options'=> $comunicacion_producto_id
							);
						echo $this->marvin->print_html_select($config)
					?>
                    </li>
		</fieldset>
		<fieldset>
                    <legend><?=lang('imagenes');?></legend>
                    <?
                    if(isset($comunicacion_aviso_imagen) && count($comunicacion_aviso_imagen)>0){

                    ?>
                    <li class="unitx8">
                        <div class="t-center">
                            <ul class="ui-sortable" id="sortable">
                                <?
								foreach ($comunicacion_aviso_imagen as $imagen) { ?>
                                <li id="<?=$imagen['id'];?>" class="ui-state-default" style="height: auto;">
                                    <div class="imagen">
                                        <a href="<?php echo $this->config->item('base_url').$image_path.$imagen['comunicacion_aviso_imagen_field_archivo'] . '_full' . $imagen['comunicacion_aviso_imagen_field_extension'];?>?>" rel="images" class="fancybox always">
                                        <img src="<?php echo (in_array(strtolower($imagen['comunicacion_aviso_imagen_field_extension']), array('flv','swf'))) ? $this->config->item('base_url').'public/images/FlashVideo.png' : $this->config->item('base_url').$image_path.$imagen['comunicacion_aviso_imagen_field_archivo'] . '_bo' . $imagen['comunicacion_aviso_imagen_field_extension'];?>" alt="">
                                    </a>
                                    </div>
                                    <div class="acciones">
                                        <div class="f-left">
                                            <?if ($this->backend->_permiso('del') && $this->router->method!='show'){?>
                                                    <a href="#" class="modalInput eliminarImagen" rel="#eliminarnto" id="<?=$imagen['id'];?>"><img src="<?=$this->config->item('base_url');?>public/images/icons/delete.png"></a>
                                            <?}?>
                                        </div>
                                    </div>
                                </li>
                                <?
                                }//while(list($id,$imagen) = each($noticia_imagen)){
                                ?>
                            </ul>
                        </div>
                    </li>
                    <?
                    } //if(isset($imagenes) && count($imagenes)>0){

                    //cargo include de multiples imagenes
                    $config['prefix'] = 'imagen';
                    $config['model'] = strtolower($this->model);

                    $this->load->view( 'backend/_imagen_upload_view',$config );
                    ?>

                </fieldset>
                <fieldset>
			<legend><?=lang('adjuntos');?></legend>
		<?php
			if(isset($comunicacion_aviso_adjunto) && count($comunicacion_aviso_adjunto)>0)
			{
				?>
				<li class="unitx8">
					<?
					foreach ($comunicacion_aviso_adjunto as $adjunto)
					{
						if(isset($adjunto['comunicacion_aviso_adjunto_field_archivo']))
						{
					?>
						<div class="noticia_titulo_otras" id="<?=$adjunto['id'];?>">
							<a target="_blank" class="always" href="<?=$this->config->item('base_url');?>public/uploads/comunicacion/avisos/adjunto/<?php echo $adjunto['comunicacion_aviso_adjunto_field_archivo'] . '.' . $adjunto['comunicacion_aviso_adjunto_field_extension'];?>"><?echo $adjunto['comunicacion_aviso_adjunto_field_archivo'] . '.' . $adjunto['comunicacion_aviso_adjunto_field_extension'];?></a>
							<?if ($this->backend->_permiso('del') && $this->router->method!='show'){?>
								<a href="#" class="eliminarAdjunto" id="<?=$adjunto['id'];?>" rel="adjunto"><img src="<?=$this->config->item('base_url');?>public/images/icons/delete.png"></a>
							<?}?>
						</div>
					<?
						}
					}
					?>
					<div class="noticia_titulo_otras"></div>
				</li>
				<?php
			}
			//cargo include de multiples imagenes
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			$this->load->view( 'backend/_adjunto_upload_view',$config );
		?>

		</fieldset>
            </ul>
            <?php
                $this->load->view( 'backend/_inc_abm_submit_view' );
            ?>
        </form>
    </div>
</div>
<script type="text/javascript" src="/public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<style>
<!--
@IMPORT url("/public/js/fancybox/jquery.fancybox-1.3.4.css");
-->
</style>
<script>
$(document).ready(function() {
	$(".fancybox").fancybox();
});
</script>