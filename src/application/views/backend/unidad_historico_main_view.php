<script type='text/javascript'>
	$(document).ready(function() {
		$("#nuevoregistro").hide();
	});
</script>

	<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
			<li class="boton-tab"><a href="#tabs-2" id="reporte"><?=lang('reporte');?></a></li>
		</ul>
		<div id="tabs-1">
			<div class="botones_registros">
				<p><a id="versionimprenta" href="<?php echo $this->config->item('base_url');?><?=$this->config->item('backend_root');?>unidad_historico_main/to_print" target="_blank"><?=lang('imprimir');?></a></p>
			</div>	
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
		<legend><?=$this->marvin->mysql_field_to_human('unidad_id');?></legend>
		<li class="unitx4 f-left">
			<?php
				$config	=	array(
								'field_name'=>'unidad_field_unidad',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_vin',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
		</li>
		<li class="unitx4 f-left">
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_motor',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_patente',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				
		</li>
		<li class="unitx4 f-left">
				
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_codigo_de_llave',
								'field_req'=>FALSE,
								'label_class'=>'unitx2 first', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
				?>
				
				<?php
				$config	=	array(
								'field_name'=>'unidad_field_codigo_de_radio',
								'field_req'=>FALSE,
								'label_class'=>'unitx2', //first
								'field_class'=>'',
								'field_type'=>'text',
								
								);
							echo $this->marvin->print_html_input($config);
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

