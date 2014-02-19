<ul class='minibuscador'>
	<li class="minihome">
		<p>
			<a href='#' id='' class='buscador_frt'>home</a>
			<?php if(isset($seccion_anterior[0])):?>
			<a href='#' id='<?php echo $seccion_anterior[0]['id'];?>' class='buscador_frt'><?php echo $seccion_anterior[0]['frt_seccion_field_desc'];?></a>
			<?php endif;?>
			<?php if(isset($seccion_actual[0])):?>
			<?php echo $seccion_actual[0]['frt_seccion_field_desc'];?>
			<?php endif;?>
		</p>
	</li>
<?php 
	if(isset($secciones))
	{
	
		reset($secciones);
		while(list($key,$val)=each($secciones))
		{
			echo "<li><strong>".$val['id']."</strong> - <a href='#' id='".$val['id']."' class='buscador_frt'>". $val['frt_seccion_field_desc']. "</a></li>";
		}
		
	}
?>
<?php
	if(isset($frts))
	{
		reset($frts);
		while(list($key,$val)=each($frts))
		{
			/*
			Array ( [id] => 264328 [frt_id] => 073710 [auto_modelo_id] => 513 [auto_anio_id] => 109 [frt_hora_field_horas] => 0.40 [created_at] => 0000-00-00 00:00:00 [updated_at] => 0000-00-00 00:00:00 [deleted_at] => [Frt] => Array ( [id] => 073710 [frt_field_desc] => [frt_seccion_id] => 0 [created_at] => 0000-00-00 00:00:00 [updated_at] => 0000-00-00 00:00:00 [deleted_at] => ) )
			*/
			echo "<li><a href='#' id='".$val['frt_id']."' class='buscador_frt_resultado'><strong>".$val['frt_id']. "</strong></a>: ".$val['Frt']['frt_field_desc']." (".$val['frt_hora_field_horas']." ".lang('horas')." )</li>";
		}
	}
?>

</ul>

