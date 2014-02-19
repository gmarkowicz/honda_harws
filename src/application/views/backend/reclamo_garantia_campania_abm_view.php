<script type="text/javascript">

    $(document).ready(function(){

        //evitar envio de form con enter
        $('form').keypress(function(e){
                if(e == 13){
                    return false;
                }
        });

        $('input').keypress(function(e){
            if(e.which == 13){
                return false;
            }
        });

        var method = '<?php echo $this->router->method;?>';

        if(method=='show')
        {
            $(".minibuscador").remove();
            $(".eliminar_bloque").remove();
            $(".add_multi_frt").remove();
            $(".add_multi_repuesto").remove();
            $(".add_multi_trabajo_tercero").remove();
        }

        /*agregando bloque frt*/
        var id_frt = <?php if (isset($frts)){ echo count($frts);} else { echo '0';} ?>;
        var html_frt = $(".multi_frt").html();
        var html_frt_replace;
        $(".add_multi_frt").click(function(e)
        {
                ++id_frt;
                html_frt_replace = html_frt;

                $('input').each(function() {
                    html_frt_replace = html_frt_replace.replace('#id#', id_frt);
                });

                $('label').each(function() {
                    html_frt_replace = html_frt_replace.replace('#id#', id_frt);
                });

                $('.add_frt').append(html_frt_replace);

                $('input').customInput(); 	//checkbox imagen

                return false;
        });

        /*agregando bloque repuesto*/
        var id_repuesto = <?php if (isset($repuestos_secundarios)){ echo count($repuestos_secundarios);} else { echo '0';} ?>;
        var html_repuesto = $(".multi_repuesto").html();
        var html_repuesto_replace;

        $(".add_multi_repuesto").click(function(e)
        {
                ++id_repuesto;
                html_repuesto_replace = html_repuesto;

                $('input').each(function() {
                    html_repuesto_replace = html_repuesto_replace.replace('#id#', id_repuesto);
                });

                $('label').each(function() {
                    html_repuesto_replace = html_repuesto_replace.replace('#id#', id_repuesto);
                });

                $('.add_repuesto').append(html_repuesto_replace);

                $('input').customInput(); 	//checkbox imagen

                return false;
        });

        /*eliminando bloques dinamicos*/
        $(".eliminar_bloque").livequery('click', function(e)

        {
                $(this).parents("div.bloque").remove();

                return false;
        });

        /*------------- fin codigo sintoma --------------*/


    });
</script>

<?php
    if (isset($error_exist_id))
    {?>
        <div class="info_error">El codigo de campa&ntilde;a <strong><?=$error_exist_id?></strong> ya existe.</div>
    <?php }
?>

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
                    <legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_campania_field_desc');?></legend>
                    	<li class="unitx4">
                        <?php
                            $config = array(
                                'field_name'	=>'id',
                                'field_req'	=>TRUE,
                                'label_class'	=>'unitx3',
                                'field_class'	=>'',
                                'field_type'	=>'text',
                                );
							if ($this->router->method != 'add') $config['field_params'] = 'readonly="readonly"';
                            echo $this->marvin->print_html_input($config);
                        ?>
                    	</li>
                    <li class="unitx4">
                        <?php
                            $config = array(
                                'field_name'	=>'reclamo_garantia_campania_field_desc',
                                'field_req'	=>TRUE,
                                'label_class'	=>'unitx4 first',
                                'field_class'	=>'',
                                'field_type'	=>'text',
                                );
                            echo $this->marvin->print_html_input($config);
                        ?>
                    </li>
				</fieldset>
                <fieldset>
                    <legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_campania_field_comentario');?></legend>
                    <li class="unitx8">
                        <?php
                            $config	=	array(
                            'field_name'=> 'reclamo_garantia_campania_field_comentario',
                            'field_req'=>false,
                            'label_class'=>'unitx6',
                            'field_class'=>'',
                            'textarea_rows'=>4,
                            'textarea_html'=>false
                            );
                            echo $this->marvin->print_html_textarea($config)
                        ?>
                    </li>
                </fieldset>

		<fieldset>
                    <legend><?=$this->marvin->mysql_field_to_human('upload_vin');?></legend>
                    <?php
			echo form_upload('vin_file','Vin');
			if ($this->router->method != 'add'):
				echo '<br /><a href="./../unidades/'.$registro_actual['id'].'" class="always" title="Descargar">+ Descargar</a><br /><br />';
			endif;
                    ?>
		</fieldset>
                <fieldset>
                    <legend><?=$this->marvin->mysql_field_to_human('frt_id');?><a href="#" class="add_multi_frt"><?=lang('agregar');?></a></legend>

                        <label class="desc"><?php echo lang('operacion_mano_obra');?></label>
                            <div class="add_frt">
                                    <?php
                                    if(!isset($frts))
                                    {
                                        $frts = set_value('Reclamo_Garantia_Frt');
                                    }

                                    if(is_array($frts) && count($frts)>0)
                                    {
                                            $id_frt = 0;
                                            reset($frts);
                                            foreach($frts as $frt)
                                            {



                                            ?>
                                            <div class="bloque">
                                                <li class="unitx2 f-left both">
                                                    <label class="unitx1 <?php if(isset($frt['error'])){echo " error";}?>"><?echo lang('frt[]');?><span class="req">*</span>
                                                        <input id="frt[]" name="many_frt_id[]" class="text field-frt[]" value="<?php echo @$frt['frt_id']?>" type="text">
                                                    </label>
                                                </li>
                                                <li class="unitx2 f-left">
                                                    <label class="unitx1 first<?php if(isset($frt['error'])){echo " error";}?>"><?echo lang('frt_hora[]');?><span class="req">*</span>
                                                        <input id="frt_hora[]" name="many_frt_hora[]" class="text field-frt_hora[]" value="<?php echo @$frt['frt_hora']?>" type="text">
                                                    </label>
                                                </li>
                                                <li class="unitx2 f-left">
                                                    <label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>
                                                </li>
                                                <li class="unitx1 f-left">
                                                    <label class="unitx1"><?echo lang('requerido');?><span class="req">*</span>
                                                        <input id="frt_requerido_<?php echo $id_frt;?>[]" name="many_frt_requerido[<?php echo $id_frt;?>]" class="text frt_requerido[]" value="1" <?php if(isset($frt['frt_requerido'])){echo ($frt['frt_requerido'] == 1 ? "checked='checked'" : '');}?> type="checkbox">
                                                    </label>
                                                    <label for="frt_requerido_<?php echo $id_frt;?>[]" class="choice">Requerido </label>
                                                </li>
                                                <li class="unitx8 both separador">
                                                    <span class="frt_descripcion respuesta_ajax"></span>
                                                </li>
                                            </div>
                                    <?php
                                            $id_frt++;

                                            }
                                    }
                                    else
                                    {
                                    ?>
                                        <div class="bloque">
                                            <li class="unitx2 f-left both">
                                                <label class="unitx1"><?echo lang('frt[]');?><span class="req">*</span>
                                                        <input id="frt[]" name="many_frt_id[]" class="text field-frt[]" value="" type="text">
                                                </label>
                                            </li>
                                            <li class="unitx2 f-left">
                                                <label class="unitx1 first"><?echo lang('frt_hora[]');?><span class="req">*</span>
                                                    <input id="frt_hora[]" name="many_frt_hora[]" class="text field-frt_hora[]" value=""  type="text">
                                                </label>
                                            </li>
                                            <li class="unitx2 f-left">
                                                <label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque hide"><?php echo lang('eliminar');?></a></label>
                                            </li>
                                            <li class="unitx1 f-left">
                                                    <label class="unitx1"><?echo lang('requerido');?><span class="req">*</span>
                                                        <input id="frt_requerido[]" name="many_frt_requerido[0]" class="text frt_requerido[]" value="1" type="checkbox">
                                                    </label>
                                                    <label for="frt_requerido[]" class="choice">Requerido </label>
                                                </li>
                                            <li class="unitx8 both separador">
                                                <span class="frt_descripcion respuesta_ajax"></span>
                                            </li>
                                        </div>
                                    <?php
                                    }
                                    ?>
                            </div>
                </fieldset>
                <fieldset>
                        <legend><?=$this->marvin->mysql_field_to_human('repuesto_principal');?></legend>
                        <div class="bloque_repuesto">
                                <div class="bloque">
                                        <?
                                        $repuesto_error = '';
                                        if(!isset($repuesto_principal))
                                        {
                                            $repuesto_principal= set_value('Reclamo_Garantia_Material_Principal');
                                        }

                                        if(!is_array($repuesto_principal))
                                        {
                                            $repuesto_principal = array();
                                        }

                                        if(isset($repuesto_principal['error']))
                                        {
                                            $repuesto_error = 'error';
                                        }

                                        ?>

                                        <li class="unitx5 f-left">
                                            <label class="unitx2 <?php echo $repuesto_error;?>"><?echo lang('numero_repuesto');?><span class="req">*</span>
                                                <input id="repuesto[]" name="many_repuesto_id[]" class="text repuesto[] _material_principal" value="<?php if(isset($repuesto_principal[0]['material_id'])){echo $repuesto_principal[0]['material_id'];}?>" type="text">
                                            </label>
                                        </li>
                                        <li class="unitx2 f-left">
                                            <label class="unitx1 first <?php echo $repuesto_error;?>"><?echo lang('cantidad');?><span class="req">*</span>
                                                <input id="repuesto_cantidad[]" name="many_repuesto_cantidad[]" class="text repuesto_cantidad[]" value="<?php if(isset($repuesto_principal[0]['material_cantidad'])){echo $repuesto_principal[0]['material_cantidad'];}?>" type="text">
                                            </label>
                                        </li>

                                        <li class="unitx8 both separador">
                                            <span class="repuesto_descripcion respuesta_ajax"><?php if(isset($repuesto_principal['Material']['material_field_desc'])){echo $repuesto_principal['Material']['material_field_desc'];}?></span>
                                        </li>
                                </div>
                        </div>
                </fieldset>
                <fieldset>
                        <legend><?=$this->marvin->mysql_field_to_human('repuesto_secundario');?> <a href="#" class="add_multi_repuesto"><?=lang('agregar');?></a></legend>
                        <div class="add_repuesto">
                        <?php
                                if(!isset($repuestos_secundarios))
                                {
                                        $repuestos_secundarios = set_value('Reclamo_Garantia_Material_Secundario');
                                }
                                if(is_array($repuestos_secundarios) && !empty($repuestos_secundarios))
                                {
                                    $id_material = 0;
                                    reset($repuestos_secundarios);
                                    foreach($repuestos_secundarios as $repuesto_secundario)
                                    {
                                        $id_material++;
                                        $repuesto_error='';
                                        if(isset($material['error']))
                                        {
                                                $repuesto_error = 'error';
                                        }
                                        ?>
                                        <div class="bloque">
                                            <li class="unitx4 f-left">
                                                <label class="unitx2 <?php echo $repuesto_error;?>"><?echo lang('numero_repuesto');?><span class="req">*</span>
                                                    <input id="many_repuesto_id[]" name="many_repuesto_id[]" class="text repuesto[]" value="<?php if(isset($repuesto_secundario['material_id'])){echo $repuesto_secundario['material_id'];}?>" type="text">
                                                </label>
                                            </li>
                                            <li class="unitx1 f-left">
                                                <label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>
                                            </li>
                                            <li class="unitx2 f-left">
                                                <label class="unitx1 first <?php echo $repuesto_error;?>"><?echo lang('cantidad');?><span class="req">*</span>
                                                    <input id="many_repuesto_cantidad[]" name="many_repuesto_cantidad[]" class="text repuesto_cantidad[]" value="<?php if(isset($repuesto_secundario['material_cantidad'])){echo $repuesto_secundario['material_cantidad'];}?>" type="text" />
                                                </label>
                                            </li>
                                            <li class="unitx1 f-left">
                                                <label class="unitx1 <?php echo $repuesto_error;?>"><?echo lang('requerido');?><span class="req">*</span>
                                                    <input id="repuesto_requerido_<?php echo $id_material;?>[]"  class="repuesto_requerido[]" type="checkbox" value="1" <?php if(isset($repuesto_secundario['material_requerido'])){echo ($repuesto_secundario['material_requerido'] == 1 ? "checked='checked'" : '');}?> name="many_repuesto_requerido[<?php echo $id_material;?>]" />
                                                    <label class="choice" for="repuesto_requerido_<?php echo $id_material;?>[]" >Requerido </label>
                                                </label>
                                            </li>
                                            <li class="unitx8 both separador">
                                                <span class="repuesto_descripcion respuesta_ajax"><?php if(isset($material['Material']['material_field_desc'])){echo $material['Material']['material_field_desc'];}?></span>
                                            </li>
                                        </div>
                                        <?
                                }
                            }
                        ?>

                        </div>
                </fieldset>
            </ul>
            <?php
                $this->load->view( 'backend/_inc_abm_submit_view' );
            ?>
        </form>
    </div>
</div>


<div class="multi_frt hide">
    <div class="bloque">
        <li class="unitx2 f-left both">
            <label class="unitx1 first"><?echo lang('frt[]');?><span class="req">*</span>
                <input id="frt[]" name="many_frt_id[]" class="text field-frt[]" value="" type="text">
            </label>
        </li>
        <li class="unitx2 f-left">
            <label class="unitx1 first"><?echo lang('frt_hora[]');?><span class="req">*</span>
                <input id="frt_hora[]" name="many_frt_hora[]" class="text field-frt_hora[]" value=""  type="text">
            </label>
        </li>
        <li class="unitx2 f-left">
            <label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>
        </li>
        <li class="unitx1 f-left">
            <label class="unitx1 <?php echo $repuesto_error;?>"><?echo lang('requerido');?><span class="req">*</span>
                <input id="frt_requerido_#id#[]" class="frt_requerido[]" type="checkbox" value="1" name="many_frt_requerido[#id#]">
                <label class="choice" for="frt_requerido_#id#[]">Requerido </label>
            </label>
        </li>
        <li class="unitx8 both separador">
            <span class="frt_descripcion respuesta_ajax"></span>
        </li>
    </div>
</div>

<div class="multi_repuesto hide">
    <div class="bloque">
        <li class="unitx4 f-left">
            <label class="unitx2 first"><?echo lang('numero_repuesto');?><span class="req">*</span>
                <input id="repuesto[]" name="many_repuesto_id[]" class="text repuesto[]" value="" type="text" />
            </label>
        </li>
        <li class="unitx1 f-left">
            <label class="unitx1 first desc" style="margin-top:15px;"><a href="#" class="eliminar_bloque"><?php echo lang('eliminar');?></a></label>
        </li>
        <li class="unitx2 f-left">
            <label class="unitx1 first <?php echo $repuesto_error;?>"><?echo lang('cantidad');?><span class="req">*</span>
                <input id="repuesto_cantidad[]" name="many_repuesto_cantidad[]" class="text repuesto_cantidad[]" value="<?php if(isset($material['reclamo_garantia_material_field_cantidad'])){echo $material['reclamo_garantia_material_field_cantidad'];}?>" type="text" />
            </label>
        </li>
        <li class="unitx1 f-left">
            <label class="unitx1 <?php echo $repuesto_error;?>"><?echo lang('requerido');?><span class="req">*</span>
                <input id="repuesto_requerido_#id#[]" class="repuesto_requerido[]" type="checkbox" value="1" name="many_repuesto_requerido[#id#]">
                <label class="choice" for="repuesto_requerido_#id#[]">Requerido </label>
            </label>
        </li>
        <li class="unitx8 both separador">
            <span class="repuesto_descripcion respuesta_ajax"></span>
        </li>
    </div>
</div>


