<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title> </title>
<link rel="stylesheet" href="<?php echo site_url('public/css/bulk_print.css');?>" type="text/css" media="all">

<style media="all" type="text/css">
label {
font-weight:bold;
}

fieldset {
	border-color:#444444;
}

legend{
font-weight:bold;
}
</style>

</head>

<body>

<?php if(isset($records) && is_array($records)):?>

	<?php
		$cantidad = count($records);
		$loop = 0;
	?>

	<?php foreach($records as $record):?>
		
		<?php ++$loop;?>
		
		<table border="0" cellspacing="0" cellpadding="0" width="700">
		<tr>
			<td><span class="titulo">HARWS - Reclamo de Garant&iacute;a V. <?php echo $rg_version;?> - #<?php echo $record['id'];?></span></td>
		</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="0" width="700">
		<tr>
			<td>
				
				<fieldset>
				<legend>Datos del Reclamo</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="50%" valign="top">
						 <label>Id Reclamo: </label><span><?php echo $record['id'];?></span><br />
						 <label>Fecha de alta: </label><span><?php echo $record['reclamo_garantia_field_fechahora_alta'];?></span><br />
						 <label>&Uacute;ltima modificaci&oacute;n: </label><span><?php echo $record['reclamo_garantia_field_fechahora_modificacion'];?></span><br />
									</td>
					<td width="50%" valign="top">
						 <label>Estado: </label><span><?php echo $record['Reclamo_Garantia_Estado']['reclamo_garantia_estado_field_desc'];?></span><br />
						 <label>Usuario: </label><span><?php echo $record['Admin_Alta']['admin_field_usuario'];?></span><br />
						 <label>Usuario: </label><span><?php echo $record['Admin_Modifica']['admin_field_usuario'];?></span><br />
									</td>
				</tr>
				</table>
				</fieldset>
				
				<?php
					//busco datos del cliente
					$obj = new Cliente();
					$q = $obj->get_all();
					$q->leftJoin('Cliente_Sucursal.Ciudad Ciudad');
					$q->leftJoin('Ciudad.Provincia Provincia');
					$q->addWhere('Cliente.id = ?',$record['Tsi']['cliente_id']);
					$q->addWhere('Cliente_Sucursal.sucursal_id = ?',$record['Tsi']['sucursal_id']);	
					$cliente = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
					
				?>
				
				<fieldset>
				<legend>Datos del Cliente</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="50%" valign="top">
						<label>Cliente: </label><span><?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_nombre'];?> <?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_apellido'];?></span><br />
						<label>Direcci&oacute;n: </label><span><?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_calle'];?> <?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_numero'];?> <?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_piso'];?> <?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_direccion_depto'];?></span><br />
						<label>Localidad: </label><span><?php echo $cliente['Cliente_Sucursal'][0]['Ciudad']['ciudad_field_desc'];?></span><br />
					</td>
					<td width="50%" valign="top">
						<label>Provincia: </label><span><?php echo $cliente['Cliente_Sucursal'][0]['Ciudad']['Provincia']['provincia_field_desc'];?></span><br />
						<label>Tel&eacute;fono: </label><span> <?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_particular_codigo'];?> <?php echo $cliente['Cliente_Sucursal'][0]['cliente_sucursal_field_telefono_particular_numero'];?> </span>
					</td>
				</tr>
				</table>
				</fieldset>
				
				<?php
					
					$unidad = new Unidad();
					$q = $unidad->get_all();
					$q->addWhere('UNIDAD.id = ?',$record['Tsi']['unidad_id']);
					$array_unidad = $q->fetchArray();
				?>
				
				
				<fieldset>
				<legend>Datos del veh&iacute;culo</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="50%" valign="top">
						<label>VIN: </label><span><?php echo element('unidad_field_vin', $array_unidad);?></span><br />
						<label>Nº de motor:</label><span><?php echo element('unidad_field_motor', $array_unidad);?></span><br />
						<label>Fecha de Reparaci&oacute;n:</label><span><?php echo $record['Tsi']['tsi_field_fecha_de_egreso'];?></span><br />
						<label>Modelo:</label><span><?php echo element('auto_modelo_field_desc', $array_unidad);?></span><br />
						<label>Color Exterior:</label><span><?php echo element('unidad_color_exterior_field_desc', $array_unidad);?></span><br />
						<label>VDS:</label><span><?php echo substr(element('unidad_field_vin', $array_unidad), 3, 5);?></span><br />
						<label>Kms.:</label><span><?php echo $record['Tsi']['tsi_field_kilometros'];?></span><br />
					</td>
					<td width="50%" valign="top">
						<label>Unidad: </label><span><?php echo element('unidad_field_unidad', $array_unidad);?></span><br />
						<label>Fecha de Entrega: </label><span><?php echo element('unidad_field_fecha_entrega', $array_unidad);?></span><br />
						<label>Orden de Reparaci&oacute;n Nro.: </label><span><?php echo $record['Tsi']['tsi_field_orden_de_reparacion'];?></span><br />
						<label>Versión: </label><span><?php echo element('auto_version_field_desc', $array_unidad);?></span><br />
						<label>Transmi&oacute;n: </label><span><?php echo element('auto_transmision_field_desc', $array_unidad);?></span><br />
						<label>Patente: </label><span><?php echo element('unidad_field_patente', $array_unidad);?></span><br />
						<label>Año Modelo.: </label><span><?php echo element('auto_anio_field_desc', $array_unidad);?></span><br />
					</td>
				</tr>
				</table>
				</fieldset>
				
				<fieldset>
				<legend>Datos de la Garant&iacute;a</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="50%" valign="top">
						<label>Concesionario:</label><span><?php echo $record['Tsi']['Sucursal']['sucursal_field_desc'];?></span><br />
						<label>Estado:</label><span><?php echo $record['Reclamo_Garantia_Estado']['reclamo_garantia_estado_field_desc'];?></span><br />
						<?php /*<label>Estado de DTC:</label><span>Apagado</span><br /> */ ?>
						<label>Codigo de S&iacute;ntoma:</label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_codigo_sintoma_id'];?></span><br />
						<label>Campaña Nro.:</label><span><?php echo $record['reclamo_garantia_campania_id'];?></span><br />
					</td>
					<td width="50%" valign="top">
						<label>Fecha de rotura:</label><span><?php echo $record['Tsi']['tsi_field_fecha_rotura'];?></span><br />
						<label>Kms. Rotura:</label><span><?php echo $record['Tsi']['tsi_field_kilometros_rotura'];?></span><br />
						<label>Código de DTC: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_dtc_codigo'];?></span><br />
						<label>Codigo de Defecto: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_codigo_defecto_id'];?></span><br />
						<label>Boletín Nro.: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_boletin_numero'];?></span><br />
					</td>
				</tr>
				</table>
				</fieldset>
				
				<?php
					$total_horas_frt = 0;
				?>
				
				<?php if(isset($record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Frt'])):?> 
				<fieldset>
				<legend>FRT</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="100%" valign="top">
						<?php foreach($record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Frt'] as $frt):?>
						
						<?php
							
							$total_horas_frt += $frt['reclamo_garantia_frt_field_frt_horas'];
							
						?>
						
						<label>OP Mano de Obra Nro.</label><span><?php echo $frt['frt_id'];?> - <?php echo $frt['reclamo_garantia_frt_field_frt_horas'];?> Horas</span><br />
						<?php endforeach;?>
					</td>
				</tr>
				</table>
				</fieldset>
				<?php endif;?>
				
				<fieldset>
				<legend>Descripciones</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="100%" valign="top">
						<label>Descripci&oacute;n del s&iacute;ntoma:</label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_descripcion_sintoma'];?></span><br />
						<label>Descripci&oacute;n del tratamiento:</label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_descripcion_tratamiento'];?></span><br />
						<label>Descripci&oacute;n del diagn&oacute;stico:</label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_descripcion_diagnostico'];?></span><br />
						<label>Observaciones del Concesionario: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_observaciones'];?></span><br />
					</td>
				</tr>
				</table>
				</fieldset>
				
				<fieldset>
				<legend>Repuestos</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					
					<?php 
						$total_repuestos = 0;
						$este_precio = $record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Principal']['reclamo_garantia_material_field_precio'] * $record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Principal']['reclamo_garantia_material_field_cantidad'];
						$total_repuestos += $este_precio;
					?>
					
					<tr>
					<td valign="top" width="33%">
						<label>Nro. de Repuesto: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Principal']['material_id'];?></span><br />
						<label>Cantidad: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Principal']['reclamo_garantia_material_field_cantidad'];?></span><br />
					</td>
					<td valign="top" width="33%">
						<label>Repuesto: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Principal']['Material']['material_field_desc'];?></span><br />
						<label>Factura SAP: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Principal']['material_facturacion_field_documento_sap_id'];?></span><br />
					</td>
					<td valign="top" width="33%">
						<label>P. Unitario: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Principal']['reclamo_garantia_material_field_precio'];?></span><br />
						<label>Precio Total: </label><span><?php echo $este_precio;?></span><br />
					</td>
				</tr>
				<tr>
					<td colspan="3"><br /></td>
				</tr>
				
				<?php if(isset($record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Secundario'])):?>
					<?php foreach($record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Material_Secundario'] as $secundario):?>
						
						<?php
							$este_precio = $secundario['reclamo_garantia_material_field_precio'] * $secundario['reclamo_garantia_material_field_cantidad'];
							$total_repuestos += $este_precio;
						?>
						
						<tr>
							<td valign="top" width="33%">
								<label>Nro. de Repuesto: </label><span><?php echo $secundario['material_id'];?></span><br />
								<label>Cantidad: </label><span><?php echo $secundario['reclamo_garantia_material_field_cantidad'];?></span><br />
							</td>
							<td valign="top" width="33%">
								<label>Repuesto: </label><span><?php echo $secundario['Material']['material_field_desc'];?></span><br />
								<label>Factura SAP: </label><span><?php echo $secundario['material_facturacion_field_documento_sap_id'];?></span><br />
							</td>
							<td valign="top" width="33%">
								<label>P. Unitario: </label><span><?php echo $secundario['reclamo_garantia_material_field_precio'];?></span><br />
								<label>Precio Total: </label><span><?php echo $este_precio;?></span><br />
							</td>
						</tr>
						<tr>
							<td colspan="3"><br /></td>
						</tr>
						
						
					<?php endforeach;?>
				
				<?php endif;?>
				
				
			  </table>
			  </fieldset>
			 
			 
			 
			 <fieldset>
				<legend>Varios</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td valign="top" width="100%">
						<label>Costo de Transporte: </label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_valor_transporte'];?></span><br />
						<label>RTH Número:</label><span><?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_rth'];?></span><br />
					</td>
				</tr>
				</table>
				</fieldset>
				
				<?php 
					$total_trabajo_tercero = 0;
				?>
				
				<?php if(isset($record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Version_Trabajo_Tercero']) && count($record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Version_Trabajo_Tercero'])>0):?>
				
				<fieldset>
				<legend>Trabajo de Tercero</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td valign="top" width="100%">
						<?php foreach($record['Reclamo_Garantia_Version'][0]['Reclamo_Garantia_Version_Trabajo_Tercero'] as $tercero):?>
						<?php
							$total_trabajo_tercero+= $tercero['reclamo_garantia_version_trabajo_tercero_field_importe'];
						?>
						<label><?php echo $tercero['reclamo_garantia_trabajo_tercero_id'];?></label> <span>AR$ <?php echo $tercero['reclamo_garantia_version_trabajo_tercero_field_importe'];?></span><br />
						<?php endforeach;?>
						
				</td>
				</tr>
				</table>
				</fieldset>
				<?php endif;?>		
				<fieldset>
				<legend>Totales</legend>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td valign="top" width="50%">
						<label>Total Repuestos: </label><span>AR$ <?php echo $total_repuestos;?></span><br />
						<label>Total Transporte: </label><span>AR$ <?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_valor_transporte'];?></span><br />
					</td>
					<td valign="top" width="50%">
						<label>Total Mano Obra: </label><span>AR$ <?php echo $total_horas_frt * $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_valor_frt_hora'];?></span><br />
						<label>Total Trabajo de Tercero: </label><span>AR$ <?php echo $total_trabajo_tercero;?></span><br />
					</td>
				</tr>
				
				
				<tr>
					<td colspan="2">
						<?php
							$subtotal = $total_repuestos +
										$record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_valor_transporte'] +
										$total_horas_frt * $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_valor_frt_hora'] +
										$total_trabajo_tercero;
										
						?>
						
						<label>Subtotal: </label><span><?php echo $subtotal;?></span><br />
						<label>Gastos de facturación: </label><span><?php echo $record['reclamo_garantia_field_valor_ingresos_brutos'];?> % </span><br />
						<label>Total Reclamo: </label><span>AR$ <?php echo $record['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_valor_reclamado'];?></span><br />
					</td>
				</tr>
				</table>
				</fieldset>
				
			</td>
		</tr>
		</table>
		
		<?php if($cantidad>$loop):?>
			<DIV style="page-break-after:always"></DIV>
		<?php endif;?>
		
		
	<?php endforeach;?>
<?php endif;?>
</body>
</html>