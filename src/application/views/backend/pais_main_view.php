

	<div id="tabs">
		<!--ul>
			<li><a href="#tabs-1"><img src="<?=$this->config->item('base_url');?>public/images/boton_principal.png"  /></a></li>
			<li><a href="#tabs-2"><img src="<?=$this->config->item('base_url');?>public/images/boton_reporte.png" /></a></li>
		</ul-->
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
			<li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
		</ul>
		<div id="tabs-1">
			<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
			?>
								
			<div class="grilla">
					<table id="flex1" style="display:none"></table>
			</div>
								
			</div>
	
	<div id="tabs-2">
		<form  autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>	
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('pais_id');?></legend>
				<li class="unitx8">
				

					<?php
				$config	=	array(
								'field_name'=>'pais_field_desc',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>

		</li>
	
		</fieldset>

				
		
					<li class="buttons">
						<div>
							<input id="enviar" name="_submit" class="btTxt submit" value="<?=lang('enviar_form');?>" type="submit">
						</div>
					</li>
		
			</ul>
		</form>
	</div>
</div>

