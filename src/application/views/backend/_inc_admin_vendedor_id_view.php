<?php
if(!isset($selected))
	$selected = FALSE;
	
echo form_dropdown('tarjeta_garantia_field_admin_vende_id', @$vendedor_id, @$selected,'class="select"')?>