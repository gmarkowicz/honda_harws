DEPRECATED!!!!

<?php
	if(isset($REGISTRO_INFO) && $REGISTRO_INFO!= FALSE && $this->router->method != 'add')
	{
		$Admin_Alta 	= set_value('Admin_Alta');
		$Admin_Modifica = set_value('Admin_Modifica');
		$usuario_alta='';
		$usuario_modifica='';
		if(is_array($Admin_Alta))
		{
			$usuario_alta =$Admin_Alta['admin_field_usuario'];
		}
		if(is_array($Admin_Modifica))
		{
			$usuario_modifica =$Admin_Modifica['admin_field_usuario'];
		}
	?>
	<div class="notice_light">
	<!-- fieldset class="record_info" -->
		<!-- legend><? echo lang('registro');?></legend -->
		<li class="unitx8">
		<table  width="100%" cellspacing="2" class="tablaopciones">
		<tr>
				<td><strong>#ID</strong> <?=set_value('id');?></td>
		</tr>
		<tr>
			<td>
				<strong><?=lang('registro_alta');?>:</strong>
				<?=$this->marvin->mysql_datetime_to_form(set_value(strtolower($this->model) . '_field_fechahora_alta'));?>
				<?$usuario_alta?>
			</td>
			<td>
				<strong><?=lang('registro_ultima_modificacion');?>:</strong>
				<?=$this->marvin->mysql_datetime_to_form(set_value(strtolower($this->model) . '_field_fechahora_modificacion'));?>
				<?$usuario_modifica?>
			</td>
		</tr>
		
		
		</table>
		</li>
	</div>
	<!-- fieldset -->	
	<?
	}
	?>


	


<?php
	
	if(isset($TSI))
	{
		$tsi = $TSI;
	?>
		<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('tsi_id');?></legend>
			<li>
				<table cellspacing="0" class="tabla_opciones" width="100%">
							
						<tbody>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('id');?></strong></td>
								<td><span><?php echo $tsi['id'];?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('tsi_field_fecha_de_egreso');?></strong></td>
								<td><span><?php echo $this->marvin->mysql_date_to_form($tsi['tsi_field_fecha_de_egreso']);?></span></td>
								
								
								<td><strong><?=$this->marvin->mysql_field_to_human('tsi_field_fechahora_alta');?></strong></td>
								<td><span><?=$this->marvin->mysql_datetime_to_form($tsi['tsi_field_fechahora_alta']);?></span></td>
							</tr>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('tsi_tipo_servicio_id');?></strong></td>
								<td><span><?=element('tsi_tipo_servicio_field_desc',$tsi['Many_Tsi_Tipo_Servicio']);?></span></td>
								
								<td></td>
								<td></td>
								
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


