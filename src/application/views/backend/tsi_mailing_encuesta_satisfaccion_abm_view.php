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
                    <legend><?=$this->marvin->mysql_field_to_human('edit_tsi_mailing');?></legend>
                    <li class="unitx8 f-left">
                        <?php
                            $config = array(
                                'field_name'		=>'tsi_mailing_encuesta_satisfaccion_field_desc',
                                'field_req'			=>TRUE,
                                'label_class'		=>'unitx4',
                                'field_class'		=>'',
                                'field_type'		=>'text',
                                'field_params' => 'autocomplete="off" ' . (($estado_registro > 2) ? ' readonly="true" ' : '' )
                            );
                            echo $this->marvin->print_html_input($config);
                        ?>
                   
                        <?php
                            $config = array(
                                'field_name'   => 'tsi_mailing_encuesta_satisfaccion_estado_id',
                                'field_req'    => TRUE,
                                'label_class'  => 'unitx2',
                                'field_class'  => '',
                                'field_options'=> $tsi_mailing_encuesta_satisfaccion_estado_id
                            );
                            echo $this->marvin->print_html_select($config)
                        ?>
                    </li>
                    <li class="unitx8 f-left" <?php echo (($estado_registro > 2) ? ' style="display:none"' : '' );?> > 
                        <?php
                            $config = array(
                                'field_name'=>'tsi_mailing_encuesta_satisfaccion_field_fecha',
                                'field_req'=>FALSE,
                                'label_class'=>'unitx2', //first
                                'field_class'=>'',
                                'field_params' => 'autocomplete="off" ');
                            echo $this->marvin->print_html_calendar($config);
                        ?>        
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
		</fieldset>                
		</ul>
            <ul>
               <fieldset>
                    <legend><?=$this->marvin->mysql_field_to_human('status_emails_sent');?></legend>
                    <li>
                        <table style="width:400px;margin:20px auto">
                            <tr>
                                <th style="width:200px;height:35px">Estado</th><th>Cantidad</th>
                            </tr>
                        <?php                       
                            foreach($estado_envios as $estados_key => $estados_value)
                            {
                                echo '<tr><td style="height:30px;text-align:center">' . $estados_key . '</td><td style="text-align:center"><strong>' . $estados_value . '</strong></td></tr>';
                            }
                        ?>
                        </table>
                   </li>
               </fieldset>
            </ul>
		<?php
                    $this->load->view( 'backend/_inc_abm_submit_view' );
		?>
            </form>
        </div>
</div>
<script type="text/javascript">
     $('.buscador').hide();
     $('#nuevoregistro').hide();
     $('li.buttons div').append('<input type="button" value="Volver" onclick="window.location=\'<?php echo $main_url;?>\'" />');
</script>