
<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
		?>
<form  autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('unidad_estado_garantia_id');?></legend>
		<li class="unitx8">
				
				<?php
				$config	=	array(
								'field_name'=>'unidad_estado_garantia_field_desc',
								'field_req'=>TRUE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
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
