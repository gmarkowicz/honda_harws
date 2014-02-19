<script type="text/javascript">
	// Run the script on DOM ready:
	//$(".cliente_field_numero_documento").livequery('keyup', function() { 
	$(function(){
		$('input').customInput();
	});
	</script>

		<fieldset>
		<legend><?=$this->marvin->mysql_field_to_human('auto_modelo_id');?></legend>
		<li class="unitx8">
			
				<?php
					$config	=	array(
						'field_name'=>'auto_modelo_id',
						'field_req'=>FALSE,
						'label_class'=>'',
						'field_class'=>'auto_modelo_id',
						'field_type'=>'checkbox',
						'field_options'=>$auto_modelo_id
						
						);
						echo $this->marvin->print_html_checkbox($config)
						?>
			</li>
		</fieldset>