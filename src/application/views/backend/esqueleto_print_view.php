<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title></title>
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url');?>public/css/print.css">
<style>

</style>
</head>
<body>

<div class="header clearfix">
	<div class="logo">
	</div>
	
	<div class="title">
	
		<?php if(isset($SECCION_ACTUAL)):?>
			<?php if(isset($AREA_ACTUAL)):?>
				<strong><?php echo $AREA_ACTUAL;?></strong>
			<?php endif;?>
			
			<span><?php echo $SECCION_ACTUAL;?></span>
		<?php endif;?>
	
		<?php
			if(isset($registros_encontrados)):
				echo "<br /><strong>" . $registros_encontrados . "</strong> " . lang('registros_encontrados');
			endif;
		?>
		<br >
		<?php echo $this->marvin->mysql_date_to_human(date("Y-m-d")) . date(" H:i:s"); ?>
		
	</div>
</div>
<div class="content">
<?php 
	if(isset($tpl_include)):
		$this->load->view( $tpl_include );		
	endif;
?>
</div>

<p class="pie">HARWS 2.19 &copy 2006 - <?echo date("Y");?> Honda Motor de Argentina. Todos los derechos reservados</p>


</body>
</html>


