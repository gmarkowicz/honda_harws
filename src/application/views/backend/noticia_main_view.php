	<div id="tabs">
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
		<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
		<ul>


		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('noticia_id');?></legend>
		<li class="unitx4">

			<?php
				$config	=	array(
								'field_name'=>'noticia_field_titulo',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config)
				?>

		
		</li>
		<li class="unitx4">
			

		</li>
		</fieldset>
		

		<fieldset>
		<li class="unitx8">
			<legend><?=$this->marvin->mysql_field_to_human('backend_estado_id');?></legend>
			<?php
					$config	=	array(
						'field_name'=>'backend_estado_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$backend_estado_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			
		</li>
		</fieldset>

		<fieldset>
		<li class="unitx8">
			<legend><?=$this->marvin->mysql_field_to_human('noticia_seccion_id');?></legend>
			<?php
					$config	=	array(
						'field_name'=>'noticia_seccion_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'',
						'field_type'=>'checkbox',
						'field_options'=>$noticia_seccion_id
						
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

