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
                    <legend><?=$this->marvin->mysql_field_to_human('comunicacion_multimedia_title');?></legend>
                    <li class="unitx8 f-left">
                        <?php
                            $config = array(
                                'field_name'=>'comunicacion_multimedia_field_desc',
                                'field_req'=>true,
                                'label_class'=>'unitx4', //first
                                'field_class'=>'',
                                'field_type'=>'text',
                            );
                            echo $this->marvin->print_html_input($config);
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
                    <li class="unitx4 f-left">
                        <?php
						$config	=	array(
							'field_name'=>'comunicacion_multimedia_tipo_id',
							'field_req'=>true,
							'field_selected'	=> false,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							'field_options'=> $comunicacion_multimedia_tipo_id
							);
						echo $this->marvin->print_html_select($config)
					?>
                    </li>
		</fieldset>
		<fieldset>
                    <legend><?=lang('imagenes');?></legend>
                    <?
                    if(isset($comunicacion_multimedia_imagen) && count($comunicacion_multimedia_imagen)>0){

                    ?>
                    <li class="unitx8">
                        <div class="t-center">
                            <ul class="ui-sortable" id="sortable">
                                <?
								foreach ($comunicacion_multimedia_imagen as $imagen) { ?>
                                <li id="<?=$imagen['id'];?>" class="ui-state-default" style="margin: 3px 3px 3px 30px; height: 125px;">
                                    <div class="imagen">
                                        <a href="<?php echo $this->config->item('base_url').$image_path.$imagen['comunicacion_multimedia_imagen_field_archivo'] . '_full' . $imagen['comunicacion_multimedia_imagen_field_extension'];?>" rel="images" class="fancybox always">
                                        <img src="<?php
                                        $image_thumb = "";
                                        if (in_array(strtolower($imagen['comunicacion_multimedia_imagen_field_extension']), array('.flv','.swf', '.avi', '.mpg', '.mpeg')))
                                        {
                                        	$image_thumb = $this->config->item('base_url').'public/images/FlashVideo.png';
                                        } elseif (in_array(strtolower($imagen['comunicacion_multimedia_imagen_field_extension']), array('.jpg','.png', '.gif', '.bmp', '.tif', '.tiff')))
                                        {
                                        	$image_thumb = $this->config->item('base_url').$image_path.$imagen['comunicacion_multimedia_imagen_field_archivo'] . '_bo' . $imagen['comunicacion_multimedia_imagen_field_extension'];
                                        } else {
											$image_thumb = $this->config->item('base_url').'public/images/File.png';
										}
                                        echo $image_thumb; ?>" alt="">
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