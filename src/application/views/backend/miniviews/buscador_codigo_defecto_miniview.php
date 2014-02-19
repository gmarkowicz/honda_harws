<ul class='minibuscador'>
	<li class="minihome"><p><a href='#' id='0' class='buscador_codigo_defecto'>home</a></p></li>
<?php 
	if(isset($secciones))
	{
	
		reset($secciones);
		while(list($key,$val)=each($secciones))
		{
			echo "<li><a href='#' id='".$val['id']."' class='buscador_codigo_defecto'>".$val['reclamo_garantia_codigo_defecto_seccion_field_desc']. "</a></li>";
		}
		
	}
?>
<?php
	if(isset($defectos))
	{
		reset($defectos);
		while(list($key,$val)=each($defectos))
		{
			
			echo "<li><a href='#' id='".$val['id']."' class='buscador_codigo_defecto_resultado'><strong>".$val['id']. "</strong></a>: ".$val['reclamo_garantia_codigo_defecto_field_desc']."</li>";
		}
	}
?>

</ul>

