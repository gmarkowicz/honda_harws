<?php 
$imagen_path = $this->config->item('base_url') . $image_path;
?>
<div id="tabs">
    <ul>
            <li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
    </ul>		
    <div id="tabs-1">
    <?php
        $this->load->view( 'backend/esqueleto_botones_view' );
        $model = strtolower($this->model);
    ?>
    <form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
        <ul>				
            <fieldset>
                <legend><?=$this->marvin->mysql_field_to_human($model.'_id');?></legend>
                <li class="unitx8 f-left">
                    <?php
                        $config = array(
                            'field_name'	=> $model . '_field_name',
                            'field_req'         => TRUE,
                            'label_class'	=> 'unitx4',
                            'field_class'	=> '',
                            'field_type'	=> 'text',						
                        );
                        echo $this->marvin->print_html_input($config);
                    ?>
                </li>				
                <li class="unitx8 f-left">					
                    <?php
                        $config = array(
                            'field_name'   => 'boutique_disponibilidad_id',
                            'field_req'    => TRUE,
                            'label_class'  => 'unitx2',
                            'field_class'  => '',
                            'field_options'=> $boutique_disponibilidad_id
                        );
                    echo $this->marvin->print_html_select($config)
                    ?>
                    <?php
                        $config = array(
                            'field_name'   => 'boutique_producto_estado_id',
                            'field_req'    => TRUE,
                            'label_class'  => 'unitx2',
                            'field_class'  => '',
                            'field_options'=> $boutique_producto_estado_id
                        );
                        echo $this->marvin->print_html_select($config)
                    ?>
                    <?php
                        $config = array(
                            'field_name'		=>$model . '_field_price',
                            'field_req'			=>TRUE,
                            'label_class'		=>'unitx2',
                            'field_class'		=>'',
                            'field_type'		=>'text',						
                        );
                        echo $this->marvin->print_html_input($config);
                    ?>
                </li>					
                </fieldset>             
                <fieldset>				
                    <legend><?=$this->marvin->mysql_field_to_human('boutique_categoria_id');?></legend>
                    <li class="unitx8 f-left">
                        <?php
                            $config	= array(
                                'field_name'    =>'many_boutique_categoria',
                                'field_req'     => TRUE,
                                'label_class'   => '',
                                'field_class'   => '',
                                'field_type'    => 'checkbox',
                                'field_options' => $many_boutique_categoria
                            );
                        echo $this->marvin->print_html_checkbox($config)
                        ?>
                    </li>				
                </fieldset>			
                <fieldset>				
                    <legend><?=$this->marvin->mysql_field_to_human('boutique_color_id');?></legend>
                    <li class="unitx8 f-left">
                        <?php
                            $config = array(
                                'field_name'=>'many_boutique_color',
                                'field_req'=>TRUE,
                                'label_class'=>'',
                                'field_class'=>'',
                                'field_type'=>'checkbox',
                                'field_options'=>$many_boutique_color
                            );
                        echo $this->marvin->print_html_checkbox($config)
                        ?>
                    </li>				
                </fieldset>			
                <fieldset>				
                    <legend><?=$this->marvin->mysql_field_to_human('boutique_talle_id');?></legend>
                    <li class="unitx8 f-left">
                        <?php
                            $config = array(
                                'field_name'=>'many_boutique_talle',
                                'field_req'=>TRUE,
                                'label_class'=>'',
                                'field_class'=>'',
                                'field_type'=>'checkbox',
                                'field_options'=>$many_boutique_talle
                            );
                        echo $this->marvin->print_html_checkbox($config)
                        ?>
                    </li>				
                </fieldset>
                <fieldset>
                    <legend><?=lang('imagenes');?></legend>
                    <?				
                    if(isset($boutique_producto_imagen) && count($boutique_producto_imagen)>0){

                    ?>
                    <li class="unitx8">
                        <!-- Sort -->
                        <div class="t-center">
                            <ul class="ui-sortable" id="sortable">
                                <?
                                while(list($id,$imagen) = each($boutique_producto_imagen)){
                                ?>
                                <li id="<?=$imagen['id'];?>" class="ui-state-default">
                                    <div class="imagen">
                                        <img src="<?=$imagen_path;?><?=$imagen['boutique_producto_imagen_field_archivo'] . '_bo' . $imagen['boutique_producto_imagen_field_extension'];?>" alt="">
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
                        <script type="text/javascript">
                                $(document).ready(function() {
                                        <!-- sort -->
                                        $("#sortable").sortable({
                                                placeholder: 'ui-state-highlight'
                                        });
                                        $("#sortable").bind('sortupdate', function() {
                                                $.ajax({
                                                                beforeSend: function(objeto){
                                                                        $('#_ajax_loading').show();
                                                                },
                                                                type: "POST",
                                                                url: "<?=$abm_url;?>/ordenar_imagenes/<?=set_value('id');?>",
                                                                data: "_noticia_imagen_orden="+$('#sortable').sortable('toArray'),
                                                                success: function(datos){
                                                                        $('#_ajax_loading').hide();
                                                                }
                                                });
                                        });

                                        <!-- sort -->
                                    });
                        </script>
                        <!-- Sort -->

                    </li>
                    <?
                    } //if(isset($imagenes) && count($imagenes)>0){

                    //cargo include de multiples imagenes
                    $config['prefix'] = 'imagen';
                    $config['model'] = strtolower($this->model);

                    $this->load->view( 'backend/_imagen_upload_view',$config );				
                    ?>				

                    </ul>
                </fieldset>			
				
                <fieldset>				
                        <legend><?=$this->marvin->mysql_field_to_human('boutique_producto_id');?></legend>
                        <li class="unitx8">
                            <?php
                                $config	= array(
                                    'field_name'=>$model.'_field_desc',
                                    'field_req'=>TRUE,
                                    'label_class'=>'unitx8 first',
                                    'field_class'=>'',
                                    'textarea_rows'=>4,
                                    'textarea_html'=>TRUE
                                );
                                echo $this->marvin->print_html_textarea($config);
                            ?>
                        </li>
                </fieldset>		
            </ul>
            <?php
                $this->load->view( 'backend/_inc_abm_submit_view' );
            ?>
        </form>
    </div>
</div>
