<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Histórico Unidad - Versión para Imprimir </title>
<link rel="stylesheet" href="<?php echo site_url('public/css/bulk_print1.css');?>" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo site_url('public/css/tables.css');?>" type="text/css" media="all">
<style media="all" type="text/css">
body{width: 99% ;
  margin:0;
  padding:0;
  font-family: "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;
    font-style: normal;

    line-height: 1.2125em;
    
    text-rendering: optimizelegibility;
  }
h1{
	display: list-item !important;
    list-style-image: url('<?php echo site_url('public/css/default_print_images/harws_logo_print.gif');?>') !important;
    list-style-position: inside !important;
	width:180px;
	height:70px;
	}
h1,h2{float:left;}
h3 {clear:both;}
.noprint{display:none;}
fieldset{
border: 0px solid #CCCCCC;
margin:0px;
padding:0px;
clear:both;
}
legend {
    clear: both;
    color: #D9221A;
    display: block;
    font-weight: bolder;
    margin: 5px 0 5px 10px;
    padding: 0;
	font-size:16px;
}
label, span{
    display: block;
    font-size: 10px;
    line-height: 15px;
    width: 50%;
	float:left;
}
label{
color:#003399;
}
span{
	color:#444444;
}

.tsi label, .tsi span, .tarjeta_garantia label, .tarjeta_garantia span, .libro_servicio label, .libro_servicio span
{
	width: 100%;
}

table td{
	border-bottom: 1px dotted #CCCCCC;
	border-right: 1px dotted #CCCCCC;
	background-color:#fff;
}
#hor-zebra td {
   
    padding: 1px;
}
#hor-zebra {
    margin-bottom: 10px;
}


</style>

</head>

<body>

<div class="contenedor">
<?php $this->load->helper('text');?>
<div style="float:left">
<h1></h1>
</div>
<div style="float:right;">
<h3>Histórico Unidad</h3>
<h4><?php echo $this->marvin->mysql_datetime_to_human(date("Y-m-d H:i:s"));?></h4>
</div>
<fieldset>
	
	<legend>Unidad</legend>
	<table width="100%" border="0" id="hor-zebra">
	<tbody>
		<tr>
			<td width="33%">
				<label for="unidad"><?php echo lang('unidad_id');?>:</label>
				<span><?php echo $unidad[0]['unidad_field_unidad'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('vin');?>:</label>
				<span><?php echo $unidad[0]['unidad_field_vin'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('motor');?>:</label>
				<span><?php echo $unidad[0]['unidad_field_motor'];?></span>
			</td>
		</tr>
		<tr class="odd">
			<td width="33%">
				<label for="unidad"><?php echo lang('auto_modelo_id');?>:</label>
				<span><?php echo @$unidad[0]['Auto_Version']['Auto_Modelo']['auto_modelo_field_desc'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('auto_version_id');?>:</label>
				<span><?php echo @$unidad[0]['Auto_Version']['auto_version_field_desc'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('auto_anio_id');?>:</label>
				<span><?php echo @$unidad[0]['Auto_Anio']['auto_anio_field_desc'];?></span>
			</td>
		</tr>
		<tr>
			<td width="33%">
				<label for="unidad"><?php echo lang('codigo_de_llave');?>:</label>
				<span><?php echo $unidad[0]['unidad_field_codigo_de_llave'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('codigo_de_radio');?>:</label>
				<span><?php echo $unidad[0]['unidad_field_codigo_de_radio'];?></span>
			</td>
			<td width="33%"></td>
		</tr>
		<tr class="odd">
			<td width="33%">
				<label for="unidad"><?php echo lang('patente');?>:</label>
				<span><?php echo $unidad[0]['unidad_field_patente'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('kilometros');?>:</label>
				<span><?php echo @$unidad[0]['unidad_field_kilometros'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo $this->marvin->mysql_field_to_human('unidad_field_fecha_entrega');?>:</label>
				<span><?php echo $this->marvin->mysql_date_to_human($unidad[0]['unidad_field_fecha_entrega']);?></span>
			</td>
		</tr>
		<tr>
			<td width="33%">
				<label for="unidad"><?php echo lang('unidad_color_exterior_id');?>:</label>
				<span><?php echo $unidad[0]['unidad_color_exterior_id'];?> - <?php echo $unidad[0]['Unidad_Color_Exterior']['unidad_color_exterior_field_desc'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('unidad_color_interior_id');?>:</label>
				<span><?php echo $unidad[0]['unidad_color_interior_id'];?> - <?php echo $unidad[0]['Unidad_Color_Interior']['unidad_color_interior_field_desc'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('unidad_estado_id');?>:</label>
				<span><?php echo @$unidad[0]['Unidad_Estado']['unidad_estado_field_desc'];?></span>
			</td>
		</tr>
		<tr class="odd">
			<td width="33%">
				<label for="unidad"><?php echo lang('auto_puerta_cantidad_id');?>:</label>
				<span><?php echo $unidad[0]['Auto_Puerta_Cantidad']['auto_puerta_cantidad_field_desc'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('auto_transmision_id');?>:</label>
				<span><?php echo $unidad[0]['Auto_Transmision']['auto_transmision_field_desc'];?></span>
			</td>
			<td width="33%"></td>
			
		</tr>
		<!--
		<tr>
			<td width="33%">
				<label for="unidad"><?php echo lang('vin_procedencia_ktype_id');?>:</label>
				<span><?php echo @$unidad[0]['Vin_Procedencia_Ktype']['vin_procedencia_ktype_field_desc'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('auto_fabrica_id');?>:</label>
				<span><?php echo @$unidad[0]['Auto_Fabrica']['auto_fabrica_field_desc'];?></span>
			</td>
			<td width="33%"></td>
			
		</tr>
		-->
		<tr class="odd">
			<td width="33%">
				<label for="unidad"><?php echo lang('oblea');?>:</label>
				<span><?php echo @$unidad[0]['unidad_field_oblea'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('certificado');?>:</label>
				<span><?php echo @$unidad[0]['unidad_field_certificado'];?></span>
			</td>
			<td width="33%"></td>
			
		</tr>
		<tr>
			<td width="33%">
				<label for="unidad"><?php echo lang('formulario_12');?>:</label>
				<span><?php echo @$unidad[0]['unidad_field_formulario_12'];?></span>
			</td>
			<td width="33%">
				<label for="unidad"><?php echo lang('formulario_01');?>:</label>
				<span><?php echo @$unidad[0]['unidad_field_formulario_01'];?></span>
			</td>
			<td width="33%"></td>
			
		</tr>
		<tr class="odd">
			<td width="33%">
				<label for="unidad"><?php echo lang('unidad_estado_garantia_id');?>:</label>
				<span><?php echo @$unidad[0]['Unidad_Estado_Garantia']['unidad_estado_garantia_field_desc'];?></span>
			</td>
			<td width="33%">
				<?php if(in_array($unidad[0]['unidad_estado_garantia_id'],array(3,5))):?>
				<label for="unidad"><?php echo lang('motivo_garantia_anulada');?>:</label>
				<span><?php echo @$unidad[0]['unidad_field_motivo_garantia_anulada'];?></span>
				<?php endif;?>
			</td>
			<td width="33%">
				<?php if($unidad[0]['unidad_estado_garantia_id'] == 3):?>
				<label for="unidad"><?php echo lang('fecha_garantia_anulada');?>:</label>
				<span><?php echo @$unidad[0]['unidad_field_fecha_garantia_anulada'];?></span>
				<?php endif;?>
			</td>
			
			
			
		</tr>
		
	</tbody>
	</table>
</fieldset>


<fieldset class="tarjeta_garantia">
	
	<legend><?php echo lang('tarjeta_garantia_id');?></legend>
	
	<?php if(isset($tarjeta_garantia) && is_array($tarjeta_garantia) &&  count($tarjeta_garantia)>0):?>
		<?php foreach($tarjeta_garantia as $row):?>
			<table width="100%" border="0" id="hor-zebra">
			<tbody>
				<tr>
					<td width="33%">
						<label for="unidad"><?php echo lang('sucursal_id');?>:</label>
						<span><?php echo @$row['sucursal_id'];?> - <?php echo @$row['Sucursal']['sucursal_field_desc'];?></span>
					</td>
					
					<td width="33%">
						<label for="unidad"><?php echo lang('fecha_entrega');?>:</label>
						<span><?php echo $this->marvin->mysql_date_to_human($row['tarjeta_garantia_field_fecha_entrega']);?></span>
					</td>
					<td width="33%">
						<label for="unidad"><?php echo lang('cliente_id');?>:</label>
						<span>
						<?php if(isset($row['Many_Cliente'])):?>
							<?php echo element('cliente_sucursal_field_nombre',$row['Many_Cliente']);?>
							<?php echo element('cliente_sucursal_field_apellido',$row['Many_Cliente']);?>
							<?php echo element('cliente_sucursal_field_razon_social',$row['Many_Cliente']);?>
						<?php endif;?>
						</span>
					</td>
				</tr>
				
				
			</tbody>
			</table>
				
		<?php endforeach;?>
	<?php else:?>
		<h4>No se encontraron resultados</h4>
	
	<?php endif;?>
</fieldset>

<fieldset class="tsi">
	
	<legend><?php echo lang('tsi_id');?></legend>
	
	<?php if(isset($tsi) && is_array($tsi) &&  count($tsi)>0):?>
		<table width="100%" border="0" id="hor-zebra">
		<tbody>
			<tr>
				<td width="27%">
					<label for="unidad"><?php echo lang('sucursal_id');?>:</label>
				</td>
				<td width="13%">
					<label for="unidad"><?php echo lang('kilometros');?></label>
				</td>
				<td width="20%">
					<label for="unidad"><?php echo lang('fecha_de_egreso');?></label>
				</td>
				<td width="20%">
					<label><?php echo lang('tsi_tipo_servicio_id');?></label>
				</td>
				<td width="20%">
					<label for="unidad"><?php echo lang('cliente_id');?></label>
				</td>
				
			</tr>
		<?php foreach($tsi as $row):?>
				<tr>
					<td>
						<span><?php echo @$row['sucursal_id'];?> - <?php echo @$row['Sucursal']['sucursal_field_desc'];?></span>
					</td>
					<td>
						<span><?php echo @$row['tsi_field_kilometros'];?></span>
					</td>
					<td>
						<span><?php echo $this->marvin->mysql_date_to_human($row['tsi_field_fecha_de_egreso']);?></span>
					</td>
					<td>
						<span>
						<?php if(isset($row['Many_Tsi_Tipo_Servicio'])):?>
							<?php echo element('tsi_tipo_servicio_field_desc',$row['Many_Tsi_Tipo_Servicio']);?>
						<?php endif;?>
						</span>
					</td>
					<td>
						<span>
						<?php if(isset($row['Cliente'])):?>
							<?php echo element('cliente_sucursal_field_nombre',$row['Cliente']);?>
							<?php echo element('cliente_sucursal_field_apellido',$row['Cliente']);?>
							<?php echo element('cliente_sucursal_field_razon_social',$row['Cliente']);?>
						<?php endif;?>
						</span>
					</td>
				</tr>		
		<?php endforeach;?>
		</tbody>
		</table>
	<?php else:?>
		<h4>No se encontraron resultados</h4>
	
	<?php endif;?>
</fieldset>

<fieldset class="libro_servicio">
	
	<legend><?php echo lang('libro_servicio_id');?></legend>
	
	<?php if(isset($libro_servicio) && is_array($libro_servicio) &&  count($libro_servicio)>0):?>
		<table width="100%" border="0" id="hor-zebra">
		<tbody>
			<tr>
				<td width="30%">
					<label for="unidad"><?php echo lang('sucursal_id');?>:</label>
				</td>
				<td width="20%">
					<label for="unidad"><?php echo lang('fechahora_alta');?></label>
				</td>
				<td width="20%">
					<label for="unidad"><?php echo lang('kilometros');?></label>
				</td>
				<td width="10%">
					<label><?php echo lang('libro_servicio_estado_id');?></label>
				</td>
				<td width="20%">
					<label for="unidad"><?php echo lang('cliente_id');?></label>
				</td>
				
			</tr>
		<?php foreach($libro_servicio as $row):?>
				
				<tr>
					<td>
						<span><?php echo @$row['sucursal_id'];?> - <?php echo @$row['Sucursal']['sucursal_field_desc'];?></span>
					</td>
					<td>
						<span><?php echo $this->marvin->mysql_datetime_to_human($row['libro_servicio_field_fechahora_alta']);?></span>
					</td>
					<td>
						<span><?php echo $row['libro_servicio_field_kilometros'];?></span>
					</td>
					<td>
						<span>
						
							<?php echo @$row['Libro_Servicio_Estado']['libro_servicio_estado_field_desc'];?>
						
						</span>
					</td>
					<td>
						<span>
						<?php echo $row['libro_servicio_field_propietario_nombre'];?>
						<?php echo $row['libro_servicio_field_propietario_apellido'];?>
						<?php echo $row['libro_servicio_field_propietario_razon_social'];?>
						</span>
					</td>
				</tr>		
		<?php endforeach;?>
		</tbody>
		</table>
	<?php else:?>
		<h4>No se encontraron resultados</h4>
	
	<?php endif;?>
</fieldset>
</div>

</body>
</html>