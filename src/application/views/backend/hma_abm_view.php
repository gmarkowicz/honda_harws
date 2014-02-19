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
                    <legend><?=$this->marvin->mysql_field_to_human('hma_title');?></legend>
                    <li class="unitx4 f-left">
                        <?php
                            $config = array(
                                'field_name'	=>'hma_field_desc',
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
                    <legend><?=lang('adjuntos');?></legend>
                    <?php
			//cargo include de multiples adjuntos
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			if(isset($hma_adjunto) && count($hma_adjunto)>0)
			{
				$config['adjuntos'] = $hma_adjunto;
			}
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