<?php
	if(!isset($tsi))
	{
	$tsi = set_value('Tsi');
	}
	if($tsi)
	{
?>
		<select name="tsi_id" style="display:none">
			<option value="<?php echo $tsi['id'];?>"></option>
		</select>
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('tsi_id');?></legend>
			<li>
				<table cellspacing="0" class="tabla_opciones" width="100%">
							
						<tbody>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('id');?></strong></td>
								<td><?php if($this->backend->_permiso('view',3021)):?><a href="<?= $this->config->item('base_url').$this->config->item('backend_root') . 'tsi_abm/show/' . $tsi['id'] ?>" class="always" target="_blanck"><?php endif;?><span><?php echo $tsi['id'];?></span><?php if($this->backend->_permiso('view',3021)):?></a><?php endif;?></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('tsi_field_fecha_de_egreso');?></strong></td>
								<td><span><?php echo $this->marvin->mysql_date_to_form($tsi['tsi_field_fecha_de_egreso']);?></span></td>
								
								
								<td><strong><?=$this->marvin->mysql_field_to_human('tsi_field_fechahora_alta');?></strong></td>
								<td><span><?=$this->marvin->mysql_datetime_to_form($tsi['tsi_field_fechahora_alta']);?></span></td>
							</tr>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('tsi_tipo_servicio_id');?></strong></td>
								<td><span><?=element('tsi_tipo_servicio_field_desc',$tsi['Many_Tsi_Tipo_Servicio']);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('sucursal_id');?></strong></td>
								<td colspan="4"><?php echo $tsi['Sucursal']['sucursal_field_desc'];?></td>
							</tr>
							<tr>
								<td><strong><?php echo lang('kilometros_rotura');?></strong></td>
								<td><?php echo $tsi['tsi_field_kilometros_rotura'];?></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('tsi_field_fecha_rotura');?></strong></td>
								<td><span><?php echo $this->marvin->mysql_date_to_form($tsi['tsi_field_fecha_rotura']);?></span></td>
								
								<td></td>
								<td></td>
								
							</tr>
						</tbody>
				</table>
			</li>
		</fieldset>
<?
}
?>