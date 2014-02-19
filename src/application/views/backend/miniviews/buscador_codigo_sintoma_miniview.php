<ul class='minibuscador'>
	<li class="minihome"><p><a href='#' id='0' class='buscador_codigo_sintoma'>home</a></p></li>
<?php 
	if(isset($secciones) && !empty($secciones))
	{
	
		reset($secciones);
		while(list($key,$val)=each($secciones))
		{
			
			echo "<li><a href='#' id='".$val['id']."' class='buscador_codigo_sintoma'>".$val['reclamo_garantia_codigo_sintoma_seccion_field_desc']. "</a></li>";
		}
		
	}
?>
<?php
	if(isset($sintomas) && !empty($sintomas))
	{
		reset($sintomas);
		while(list($key,$val)=each($sintomas))
		{
			
			echo "<li><a href='#' id='".$val['id']."' class='buscador_codigo_sintoma_resultado'><strong>".$val['id']. "</strong></a>: ".$val['reclamo_garantia_codigo_sintoma_field_desc']."</li>";
		}
	}
?>

</ul>

