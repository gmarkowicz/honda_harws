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
                    <legend><?=$this->marvin->mysql_field_to_human('comunicacion_logo_title');?></legend>
                    <li class="unitx8 f-left">
                        <?php
                            $config = array(
                                'field_name'=>'comunicacion_logo_field_desc',
                                'field_req'=>true,
                                'label_class'=>'unitx4', //first
                                'field_class'=>'',
                                'field_type'=>'text',
                            );
                            echo $this->marvin->print_html_input($config);
                        ?>
                    </li>
		</fieldset>
		<fieldset>
                    <legend><?=lang('imagenes');?></legend>
                    <?
                    if(isset($comunicacion_logo_imagen) && count($comunicacion_logo_imagen)>0){

                    ?>
                    <li class="unitx8">
                        <div class="t-center">
                            <ul class="ui-sortable" id="sortable">
                                <?
								foreach ($comunicacion_logo_imagen as $imagen) { ?>
                                <li id="<?=$imagen['id'];?>" class="ui-state-default" style="height: auto;">
                                    <div class="imagen">
                                        <a href="<?php echo $this->config->item('base_url').$image_path.$imagen['comunicacion_logo_imagen_field_archivo'] . '_full' . $imagen['comunicacion_logo_imagen_field_extension'];?>?>" rel="images" class="fancybox always">
                                        <img src="<?php echo (in_array(strtolower($imagen['comunicacion_logo_imagen_field_extension']), array('flv','swf'))) ? $this->config->item('base_url').'public/images/FlashVideo.png' : $this->config->item('base_url').$image_path.$imagen['comunicacion_logo_imagen_field_archivo'] . '_bo' . $imagen['comunicacion_logo_imagen_field_extension'];?>" alt="">
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
			if(isset($comunicacion_logo_adjunto) && count($comunicacion_logo_adjunto)>0)
			{
				?>
				<li class="unitx8">
					<?
					foreach ($comunicacion_logo_adjunto as $adjunto)
					{
						if(isset($adjunto['comunicacion_logo_adjunto_field_archivo']))
						{
					?>
						<div class="noticia_titulo_otras" id="<?=$adjunto['id'];?>">
							<a target="_blank" class="always" href="<?=$this->config->item('base_url');?>public/uploads/comunicacion/logos/adjunto/<?php echo $adjunto['comunicacion_logo_adjunto_field_archivo'] . '.' . $adjunto['comunicacion_logo_adjunto_field_extension'];?>"><?echo $adjunto['comunicacion_logo_adjunto_field_archivo'] . '.' . $adjunto['comunicacion_logo_adjunto_field_extension'];?></a>
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