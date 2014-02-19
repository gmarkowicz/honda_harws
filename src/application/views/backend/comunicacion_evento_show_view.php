<script type="text/javascript" src="/public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<style>
<!--
@IMPORT url("/public/js/fancybox/jquery.fancybox-1.3.4.css");
-->
</style>
<div id="tabs">
    <ul>
            <li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
    </ul>
    <div id="tabs-1" class="eventos-show">
        <?php
            //$this->load->view( 'backend/esqueleto_botones_view' );
        ?>
        <h1><?php echo $registro_actual['comunicacion_evento_field_desc']; ?></h1>
        <div><?php echo $this->marvin->mysql_field_to_human('comunicacion_eventos_title'); ?>:  <?php echo date('d/m/Y', strtotime($registro_actual['comunicacion_evento_field_fecha'])); ?></div>
        <ul class="evento-imagenes">
        	<?php
        	$i = 0;
        	$images_path = $this->config->item('base_url') . 'public/uploads/comunicacion/eventos/imagen/';
        	foreach ($imagenes as $imagen):
        		if ($i++ == 5)
	        	{
	        		echo '<li style="clear: all; float: left; width: 100%;"></li>';
	        		$i = 1;
	        	}
        		$image_thumb = strtolower($imagen['comunicacion_evento_imagen_field_extension']) == '.flv' || strtolower($imagen['comunicacion_evento_imagen_field_extension']) == '.swf' ? $this->config->item('base_url').'public/images/FlashVideo.png' : $images_path.$imagen['comunicacion_evento_imagen_field_archivo'].'_thumb_140'.$imagen['comunicacion_evento_imagen_field_extension'];
        		$image_full = $images_path.$imagen['comunicacion_evento_imagen_field_archivo'].'_full'.$imagen['comunicacion_evento_imagen_field_extension'];
        	?>
        	<li class="evento-imagen">
				<a class="fancybox" rel="eventos" href="<?php echo $image_full?>" alt="<?php echo $imagen['comunicacion_evento_imagen_field_desc'];?>" title="<?php echo $imagen['comunicacion_evento_imagen_field_desc'] ?>"><img src="<?php echo $image_thumb; ?> ?>" border="0" /></a>
				<div class="evento-title"><?php echo $imagen['comunicacion_evento_imagen_field_desc'] ?></div>
        	</li>
        	<?php endforeach; ?>
        </ul>
        <br clear="all" />
    </div>
</div>
<script>
$(document).ready(function() {
	$(".fancybox").fancybox();
});
</script>