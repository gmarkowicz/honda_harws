<?
$model = strtolower($this->model);
$publicidad_producto =set_value('Publicidad_Producto');
$publicidad_medida =set_value('Publicidad_Medida');
$publicidad_ubicacion =set_value('Publicidad_Ubicacion');
$publicidad_medio =set_value('Publicidad_Medio');
?>
<table width="100%" class="tabla_opciones">
<tr>
	<td valign="top" colspan="2"><h1><?echo set_value('publicidad_field_desc');?></h1></td>
</tr>
<tr>
	<td valign="top" width="540">
	<?
	if(isset($publicidad_imagen) && count($publicidad_imagen)>0)
		{
			$prefix = 'imagen';
			reset($publicidad_imagen);
			while(list($id,$imagen) = each($publicidad_imagen))
			{
				
			
				?>
				<div class="imagen">
													<img src="<?=$this->config->item('base_url');?>public/uploads/<?=$model;?>/<?=$prefix;?>/<?=$imagen['publicidad_imagen_field_archivo'];?>_thumb_530<?=$imagen['publicidad_imagen_field_extension'];?>" alt="">
												</div>
				<?
			
			}
		}
	?>
	</td>
	
	<td style="vertical-align:top;">
		<strong><?=lang('publicidad_producto_id');?>:</strong> <?=$publicidad_producto['publicidad_producto_field_desc'];?> <br />
		<?
		if(isset($publicidad_imagen_medio) && count($publicidad_imagen_medio)>0)
		{
			$prefix = 'imagen_medio';
			reset($publicidad_imagen_medio);
			while(list($id,$imagen) = each($publicidad_imagen_medio))
			{
				
			
				?>
				<div class="imagen">
													<img src="<?=$this->config->item('base_url');?>public/uploads/<?=$model;?>/<?=$prefix;?>/<?=$imagen['publicidad_imagen_medio_field_archivo'];?>_thumb_140<?=$imagen['publicidad_imagen_medio_field_extension'];?>" alt="">
												</div>
				<?
			
			}
		}
		?>
		<strong><?=lang('publicidad_medio_id');?>:</strong><?=$publicidad_medio['publicidad_medio_field_desc'];?><br />
		<strong><?=lang('fecha_publicacion');?>:</strong> <?=$this->marvin->mysql_date_to_form(set_value('publicidad_field_fecha_publicacion'));?><br />
		<strong><?=lang('publicidad_medida_id');?>:</strong> <?=$publicidad_medida['publicidad_medida_field_desc'];?><br />
		<strong><?=lang('publicidad_ubicacion_id');?>:</strong> <?=$publicidad_ubicacion['publicidad_ubicacion_field_desc'];?><br />






	</td>
	
</tr>
</table>
