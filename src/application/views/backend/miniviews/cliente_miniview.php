<?php
	if(isset($CLIENTE))
	{
		$cliente = $CLIENTE;
		
	?>
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('cliente_id');?></legend>
			<li>
				<table cellspacing="0" class="tabla_opciones" width="100%">
						
						<tbody>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('id');?></strong></td>
								<td><span><?php echo $cliente['id'];?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_nombre');?></strong></td>
								<td><span><?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_nombre'];?></span></td>
								
								
								<td><strong><?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_apellido');?></strong></td>
								<td><span><?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_apellido'];?></span></td>
							</tr>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_razon_social');?></strong></td>
								<td><span><?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_razon_social'];?></span></td>
								
								<td></td>
								<td></td>
								
								<td></td>
								<td></td>
								
							</tr>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion');?></strong></td>
								<td><span>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_calle'];?>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_numero'];?>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_depto'];?>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_piso'];?>
								</span></td>
								
								<td></td>
								<td></td>
								
								<td></td>
								<td></td>
								
							</tr>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_particular');?></strong></td>
								<td><span>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_particular_codigo'];?>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_particular_numero'];?>
								</span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_laboral');?></strong></td>
								<td><span>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_laboral_codigo'];?>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_laboral_numero'];?>
								</span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_movil');?></strong></td>
								<td><span>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_movil_codigo'];?>
									<?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_movil_numero'];?>
								</span></td>
								
							</tr>
						</tbody>
				</table>
			</li>
		</fieldset>
<?
}
?>