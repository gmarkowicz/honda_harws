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
                    <legend><?=$this->marvin->mysql_field_to_human('comunicacion_papeleria_title');?></legend>
                    <li class="unitx8 f-left">
                        <?php
                            $config = array(
                                'field_name'=>'comunicacion_papeleria_field_desc',
                                'field_req'=>true,
                                'label_class'=>'unitx4', //first
                                'field_class'=>'',
                                'field_type'=>'text',
                            );
                            echo $this->marvin->print_html_input($config);
                        ?>
                    </li>
		</fieldset>
		<fieldset>
			<legend><?=lang('adjuntos');?></legend>
		<?php
			if(isset($comunicacion_papeleria_adjunto) && count($comunicacion_papeleria_adjunto)>0)
			{
				?>
				<li class="unitx8">
					<?
					foreach ($comunicacion_papeleria_adjunto as $adjunto)
					{
						if(isset($adjunto['comunicacion_papeleria_adjunto_field_archivo']))
						{
					?>
						<div class="noticia_titulo_otras" id="<?=$adjunto['id'];?>">
							<a target="_blank" class="always" href="<?=$this->config->item('base_url');?>public/uploads/comunicacion/papeleria/adjunto/<?php echo $adjunto['comunicacion_papeleria_adjunto_field_archivo'] . '.' . $adjunto['comunicacion_papeleria_adjunto_field_extension'];?>"><?echo $adjunto['comunicacion_papeleria_adjunto_field_archivo'] . '.' . $adjunto['comunicacion_papeleria_adjunto_field_extension'];?></a>
							<?if ($this->backend->_permiso('del') && $this->router->method!='show'){?>
								<a href="#" class="eliminarAdjunto" id="<?=$adjunto['id'];?>" rel="adjunto"><img src="<?=$this->config->item('base_url');?>public/images/icons/delete.png"></a>
							<?}?>
						</div>
					<?
						}
					}
					?>
					<div class="noticia_titulo_otras"></div>
				</li>
				<?php
			}
			//cargo include de multiples imagenes
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
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