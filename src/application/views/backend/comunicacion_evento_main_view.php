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
                    <legend><?=$this->marvin->mysql_field_to_human('comunicacion_eventos_title');?></legend>
                    <li class="unitx4 f-left">
                        <?php
                            $config = array(
                                'field_name'=>'comunicacion_evento_field_desc',
                                'field_req'=>FALSE,
                                'label_class'=>'unitx3 first', //first
                                'field_class'=>'',
                                'field_type'=>'text',
                            );
                            echo $this->marvin->print_html_input($config);
                        ?>
                    </li>
                    <li class="unitx4">
                        <?php
						$config	=	array(
							'field_name'=>'fecha_inicial',
							'field_req'=>FALSE,
							'label_class'=>'unitx2 first', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
					?>
                        <?php
						$config	=	array(
							'field_name'=>'fecha_final',
							'field_req'=>FALSE,
							'label_class'=>'unitx2', //first
							'field_class'=>'',
							);
						echo $this->marvin->print_html_calendar($config)
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