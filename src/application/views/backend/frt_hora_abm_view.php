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
                            'field_name'	=> 'frt_id',
                            'field_req'         => TRUE,
                            'label_class'	=> 'unitx4',
                            'field_class'	=> '',
                            'field_type'	=> 'text',						
                        );
                        echo $this->marvin->print_html_input($config);
                    ?>
                    <?php
                        $config = array(
                            'field_name'		=>$model . '_field_horas',
                            'field_req'			=>TRUE,
                            'label_class'		=>'unitx2',
                            'field_class'		=>'',
                            'field_type'		=>'text',						
                        );
                        echo $this->marvin->print_html_input($config);
                    ?>
                </li>
                <li class="unitx8 f-left desc_frt" style="display:none">
                    <?php
                        $config = array(
                            'field_name'	=> 'frt_field_desc',
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
                            'field_name'   => 'auto_modelo_id',
                            'field_req'    => TRUE,
                            'label_class'  => 'unitx2',
                            'field_class'  => '',
                            'field_options'=> $auto_modelo_id
                        );
                        echo $this->marvin->print_html_select($config)
                    ?>
                    <?php
                        $config = array(
                            'field_name'   => 'auto_anio_id',
                            'field_req'    => TRUE,
                            'label_class'  => 'unitx2',
                            'field_class'  => '',
                            'field_options'=> $auto_anio_id
                        );
                        echo $this->marvin->print_html_select($config)
                    ?>                   
                </li>					
                </fieldset>               
            </ul>
            <?php
                $this->load->view( 'backend/_inc_abm_submit_view' );
            ?>
        </form>
    </div>
    <script>
        
        var frt_id = 0;
        var frt_id_temp = 0;
        $('#frt_id').blur(function(){
            
            frt_id_temp = $('#frt_id').val();
            
            if(frt_id != frt_id_temp)
            {
                frt_id = frt_id_temp;
                
               $.manageAjax.add('cola_buscador_frt', 
                {
                    beforeSend: function()
                    {
                            $('._ajax_append').append('<div class="_ajax_loading _cola_buscador_frt"></div>');
                    },
                    cache: true,
                    dataType: 'json',
                    type: "POST",
                    url: "<?=$this->config->item('base_url');?><?=$this->config->item('backend_root');?>ajax/get_frt",
                    data: "frt_id="+$(this).val(),
                    success: function(respuesta)
                    {
                        if (respuesta == false)
                        {
                            $('.desc_frt').fadeIn(1000);
                        }
                        else
                        {
                            $('.desc_frt').fadeOut(1000);
                        }
                        $('._cola_buscador_frt').remove();	
                    }
                });
            }    
            
        });
    </script>
</div>
