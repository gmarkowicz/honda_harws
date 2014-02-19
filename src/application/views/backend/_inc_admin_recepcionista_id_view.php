<?php
if(!isset($selected))
	$selected = FALSE;
echo form_dropdown('tsi_field_admin_recepcionista_id', @$recepcionista_id, @$selected,'class="select"')?>