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
                    <legend><?=$this->marvin->mysql_field_to_human('comunicacion_eventos_title');?></legend>
                    <li class="unitx4 f-left">
                        <?php
                            $config = array(
                                'field_name'	=>'comunicacion_evento_field_desc',
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
									'field_name'=>'comunicacion_evento_field_fecha',
									'field_req'=>FALSE,
									'label_class'=>'unitx2', //first
									'field_class'=>'',
									);
								echo $this->marvin->print_html_calendar($config);
							?>
                    </li>
                    <li class="unitx4 f-left">
                        <?php
                            $config = array(
                                'field_name'	=>'imagenes_zip',
                                'field_req'	=> false,
                                'label_class'	=>'unitx4',
                                'field_class'	=>'',
                                'field_type'	=>'file',
                                );
                            echo $this->marvin->print_html_input($config);
                        ?>
                    </li>
		</fieldset>
		<fieldset>
                    <legend><?=lang('imagenes');?></legend>
                    <?
                    if(isset($comunicacion_evento_imagen) && count($comunicacion_evento_imagen)>0){

                    ?>
                    <li class="unitx8">
                        <div class="t-center">
                            <ul class="ui-sortable" id="sortable">
                                <?
								foreach ($comunicacion_evento_imagen as $imagen) { ?>
                                <li id="<?=$imagen['id'];?>" class="ui-state-default" style="height: auto;">
                                    <div class="imagen">
                                    <a href="<?php echo $this->config->item('base_url').$imagen_path.$imagen['comunicacion_evento_imagen_field_archivo'] . '_full' . $imagen['comunicacion_evento_imagen_field_extension'];?>?>" rel="images" title="<?php echo $imagen['comunicacion_evento_imagen_field_desc']?>" class="fancybox">
                                        <img src="<?php echo (in_array(strtolower($imagen['comunicacion_evento_imagen_field_extension']), array('flv','swf'))) ? $this->config->item('base_url').'public/images/FlashVideo.png' : $this->config->item('base_url').$imagen_path.$imagen['comunicacion_evento_imagen_field_archivo'] . '_thumb_140' . $imagen['comunicacion_evento_imagen_field_extension'];?>" alt="">
                                    </a>
                                    </div>
                                    <div class="acciones">
                                        <div class="f-left">
                                            <?if ($this->backend->_permiso('del')){?>
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