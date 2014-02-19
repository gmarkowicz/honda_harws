<?php
$admin_alta = set_value('Admin_Alta');
$admin_modifica = set_value('Admin_Modifica');
if(is_array($admin_alta))
{
	$usuario_alta =$admin_alta['admin_field_usuario'];
}
if(is_array($admin_modifica))
{
	$usuario_modifica =$admin_modifica['admin_field_usuario'];
}
if(!isset($registro_estado))
{
	$registro_estado = FALSE;
}


if(!isset($rechazo_motivo))
{
	$rechazo_motivo = FALSE;
}

?>

	
	<table class="miniview">
	<?
	if($registro_estado)
	{
	?>
		<tr>
			<td colspan="4"><?echo lang('backend_estado_id')?>: <strong><?=$registro_estado;?></strong> <?php echo $rechazo_motivo;?></td>
		</tr>
	<?
	}
	?>
	<tr>
		<td width="10%"><strong>ID #</strong><?php echo set_value('id');?></td>
		<td width="40%">
				<?if(isset($usuario_alta)){?>
					 <strong><?=lang('registro_alta');?>:</strong>
					<?=$this->marvin->mysql_datetime_to_form(set_value(strtolower($this->model) . '_field_fechahora_alta'));?>
					<strong><?php echo $usuario_alta;?></strong>
				<?}?>
		</td>
		<td width="40%">
				<?if(isset($usuario_modifica)){?>
					 <strong><?=lang('registro_ultima_modificacion');?>:</strong>
					<?=$this->marvin->mysql_datetime_to_form(set_value(strtolower($this->model) . '_field_fechahora_modificacion'));?>
					<strong><?php echo $usuario_modifica?></strong>
				<?}?>
		</td>
		<td width="15%"><a href="#" class="cerrar_tabla">cerrar</a></td>
	</tr>
	
	</table>




	

