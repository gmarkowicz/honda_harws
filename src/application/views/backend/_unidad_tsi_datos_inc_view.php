<li>
<fieldset>
			<legend><?=lang('tsi_registrados_mantenimiento');?></legend>
			<div id="unidad_tsi">
				<table class="tabla_opciones" width="100%" cellspacing="0">
					<tbody>
					<tr>
						<td width="80"><strong><?=lang('id')?></strong></td>
						<td><strong><?=lang('cliente')?></strong></td>
						<td width="90"><strong><?=lang('kilometros')?></strong></td>
						<td><strong><?=lang('fecha_de_egreso')?></strong></td>
						<td><strong><?=lang('fechahora_alta')?></strong></td>
					</tr>
					<?php
					if(isset($tsi) && is_array($tsi) && count($tsi)>0)
					{
						reset($tsi);
						while(list(,$datos)=each($tsi))
						{
						?>
							
							<tr>
								<td>#<?=$datos['id'];?></td>
								<td>
									<?=$datos['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_nombre'];?>
									<?=$datos['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_apellido'];?>
									<?=$datos['Cliente']['Cliente_Sucursal'][0]['cliente_sucursal_field_razon_social'];?>
								</td>
								<td><?=$datos['tsi_field_kilometros'];?></td>
								<td><?=$this->marvin->mysql_date_to_human($datos['tsi_field_fecha_de_egreso']);?></td>
								<td><?=$this->marvin->mysql_datetime_to_human($datos['tsi_field_fechahora_alta']);?></td>
							</tr>
						<?php
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="5"><?=lang('sin_resultados');?></td>
					</tr>
					<?php
					
					}
					
					?>
					</tbody>
				</table>
			<div>
		</fieldset>
</li>