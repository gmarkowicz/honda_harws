<div id="tabs">
    <ul>
        <li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
        <li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
    </ul>
    <div id="tabs-1">
        <?php
        if($this->backend->_permiso('add',ID_SECCION))
        {
            $this->load->view( 'backend/esqueleto_botones_view' );
        }
        ?>
        <div class="grilla">
            <table id="flex1" style="display:none"></table>
        </div>
    </div>
    <div id="tabs-2">
        <form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
            <ul>
		<fieldset>
                    <legend><?=$this->marvin->mysql_field_to_human('comunicacion_multimedia_title');?></legend>
                    <li class="unitx8 f-left">
                        <?php
                            $config = array(
                                'field_name'=>'comunicacion_multimedia_field_desc',
                                'field_req'=>FALSE,
                                'label_class'=>'unitx4', //first
                                'field_class'=>'',
                                'field_type'=>'text',
                            );
                            echo $this->marvin->print_html_input($config);
                        ?>
                    </li>
		</fieldset>
		<fieldset>
        <legend><?=$this->marvin->mysql_field_to_human('comunicacion_producto_id');?></legend>
                    <li class="unitx8">
                        <?php
						$config	=	array(
							'field_name'=>'comunicacion_producto_id',
							'field_req'=>FALSE,
							'field_selected'	=> FALSE,
							'label_class'=>'', //first
							'field_class'=>'',
							'field_type'=>'checkbox',
							'field_options'=> $comunicacion_producto_id
							);
						echo $this->marvin->print_html_checkbox($config)
					?>
                    </li>
		</fieldset>
		<fieldset>
        <legend><?=$this->marvin->mysql_field_to_human('comunicacion_multimedia_tipo_id');?></legend>
                    <li class="unitx8">
                        <?php
						$config	=	array(
							'field_name'=>'comunicacion_multimedia_tipo_id',
							'field_req'=>FALSE,
							'field_selected'	=> FALSE,
							'label_class'=>'', //first
							'field_class'=>'',
							'field_type'=>'checkbox',
							'field_options'=> $comunicacion_multimedia_tipo_id
							);
						echo $this->marvin->print_html_checkbox($config)
					?>
                    </li>
		</fieldset>
		<li class="buttons">
                    <div>
                        <input id="enviar" name="_filtro" class="btTxt submit" value="<?=lang('filtrar')?>" type="submit">
                    </div>
		</li>
            </ul>
        </form>
    </div>
</div>
<script>$('#exportarxls').hide();</script>