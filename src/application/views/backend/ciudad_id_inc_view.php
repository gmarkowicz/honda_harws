<?php
if(isset($error)){
	$label_class="unitx3 error";
}else{
	$label_class="unitx3";
}

					$config	=	array(
						'field_name'=>$input,
						'field_req'=>TRUE,
						'label_class'=>$label_class,
						'field_class'=>'',
						'field_type'=>'text',
						'field_selected'=>@$selected,
						'field_options'=>@$ciudad_id
					);
					echo $this->marvin->print_html_select($config)
			?>
