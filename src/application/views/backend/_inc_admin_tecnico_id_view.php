<?php
if(!isset($selected))
	$selected = FALSE;
echo form_dropdown('tsi_field_admin_tecnico_id', @$tecnico_id, @$selected,'class="select"')?>