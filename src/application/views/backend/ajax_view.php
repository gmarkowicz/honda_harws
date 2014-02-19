<?php
if(isset($show_propietario_actual))
{

					$config	=	array(
						'field_name'		=> 'cliente_id',
						'field_req'			=> FALSE,
						'field_selected'	=> FALSE,
						'label_class'		=> 'unitx3 first',
						'field_class'		=> '',
						'field_type'		=> 'text',
						'field_options'	=> $cliente_id
					);
					echo $this->marvin->print_html_select($config);
}
?>