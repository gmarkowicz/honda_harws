<div id="tabs">
    <ul>
        <li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
        <li class="boton-tab"><a href="#tabs-2" id="principal"><?=lang('queued_mail');?></a></li>
    </ul>
    <?php
        if (isset($error_csv)) { ?>
            <div class="info_error">

                  <?php  foreach ($error_csv as $mensaje) {
                  	echo $mensaje;
                  }
                    ?>
             </div>
        <?php } ?>
    <div id="tabs-1">


        <ul>
            <fieldset>
                <legend><?=$this->marvin->mysql_field_to_human('fecha');?></legend>
                <?php echo form_open(base_url() . $this->config->item('backend_root') . 'tsi_mailing_encuesta_satisfaccion_main'); ?>
                <li class="unitx4 f-left both">
                    <?php

                    $config = array(
                        'field_name'=>'tsi_mailing_fecha_desde',
                        'field_req'=>FALSE,
                        'label_class'=>'unitx2 first', //first
                        'field_class'=>'',
                        'field_params' => 'autocomplete="off"');

                    echo $this->marvin->print_html_calendar($config);

                    $config = array(
                        'field_name'=>'tsi_mailing_fecha_hasta',
                        'field_req'=>FALSE,
                        'label_class'=>'unitx2', //first
                        'field_class'=>'',
                        'field_params' => 'autocomplete="off"');

                    echo $this->marvin->print_html_calendar($config);
                    ?>
                </li>
                <li class="unitx4 f-left both">
                    <?php echo form_submit('_filtrar', lang('filtrar'));?>
                </li>
            <?php echo form_close(); ?>
            </fieldset>
        </ul>
        <? if (isset($register_count_total) && $register_count_total > 0)
            { ?>
            <ul>
                <fieldset>
                    <legend><?=$this->marvin->mysql_field_to_human('register_count');?></legend>
                    <?php echo form_open(base_url() . $this->config->item('backend_root') . 'tsi_mailing_encuesta_satisfaccion_main/downloadcsv'); ?>
                    <li class="unitx4 f-left both">
                        <?php echo lang('tsi_mailing_fecha_desde') . ': <strong>'. $tsi_mailing_fecha_desde . '</strong>'; ?>
                    </li>
                    <li class="unitx4 f-left both">
                        <?php echo lang('tsi_mailing_fecha_hasta') . ': <strong>'. $tsi_mailing_fecha_hasta . '</strong>'; ?>
                    </li>

                    <li class="unitx4 f-left both">
                        <?php echo lang('registers_found_without_email') . ': <strong>'. ($register_count_total[0]['total'] - $register_count_valid[0]['total']) . '</strong>'; ?><br />
                        <?php echo lang('registers_found') . ': <strong>'. ($register_count_total[0]['total']) . '</strong>'; ?>
                    </li>

                    <li class="unitx4 f-left both">
                        <?php echo form_submit('_downloadcsv',lang('tsi_mailing_exportar_csv')); ?>
                    </li>
                    <?php
                        echo form_hidden('tsi_mailing_fecha_desde', $tsi_mailing_fecha_desde);
                        echo form_hidden('tsi_mailing_fecha_hasta', $tsi_mailing_fecha_hasta);
                        echo form_close();
                    ?>
                </fieldset>
            </ul>
        <?php
        }
        elseif($register_count === 0)
        {?>
            <ul>
                <li><strong> <?=lang('tsi_mailing_sin_dato_exportar')?></strong></li>
            </ul>
        <?php } ?>
        <ul>
            <fieldset>
                <legend><?=lang('tsi_new_poll');?></legend>
                <?php echo form_open_multipart(base_url() . $this->config->item('backend_root') . 'tsi_mailing_encuesta_satisfaccion_main/add');?>
                <li class="unitx4 f-left both">
                    <?php

                    $config = array(
                        'field_name'=>'tsi_encuesta_mailing_lote_envio_field_fecha',
                        'field_req'=>FALSE,
                        'label_class'=>'unitx2 first', //first
                        'field_class'=>'',
                        'field_params' => 'autocomplete="off"'
                    );

                    echo $this->marvin->print_html_calendar($config);
                ?>
                </li>
                <li class="unitx4 f-left both">
                    <?php
                    $config	= array(
                        'field_name'=>'tsi_encuesta_mailing_lote_envio_field_desc',
                        'field_req'=>FALSE,
                        'label_class'=>'unitx2 first', //first
                        'field_class'=>'',
                        'field_type'=>'text',
                    );
                    echo $this->marvin->print_html_input($config);?>
                </li>
                <li class="unitx4 f-left both">
                    <label><?=lang('upload_file');?></label>
                        <?php echo form_upload('csv_file'); ?>
                </li>
                <li class="unitx8 f-left">
                        <div class="ui-datepick" style="margin:">
                                <?php
					$config	=	array(
						'field_name'		=>'tsi_mailing_encuesta_satisfaccion_field_observacion',
						'field_req'			=>FALSE,
						'label_class'		=>'unitx6 true',
						'field_class'		=>'',
						'textarea_rows'		=>4,
						'textarea_html'		=>FALSE
					);
					echo $this->marvin->print_html_textarea($config);
					?>

                        </div>
                </li>
                <li class="unitx4 f-left both">
                    <?php echo form_submit('_add', lang('tsi_mailing_importar_csv')); ?>
                </li>
            <?php echo form_close(); ?>
            </fieldset>
        </ul>
    </div>
    <div id="tabs-2">
        <div class="grilla">
            <table id="flex1" style="display:none"></table>
        </div>
    </div>
</div>
<script type="text/javascript">
     $('.buscador').hide();
</script>