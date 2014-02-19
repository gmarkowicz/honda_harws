<?php
/*TODO 
esto no va aca..., es para no pasarle los campos de la unidad
porque ahora se les ocurrio enviar por mail y hay cosas que vienen por ajax
PARCHE*/
if(set_value('unidad_field_vin'))
{
	$unidad = new Unidad();
	$q = $unidad->get_all();
	$q->addWhere('UNIDAD.unidad_field_vin = ?',set_value('unidad_field_vin'));
	$array_unidad = $q->fetchArray();
}
else
{
	$array_unidad = array();
}
?>
	
	<fieldset>
					<legend><?=$this->marvin->mysql_field_to_human('unidad_id');?></legend>
					<li>
					<table cellspacing="0" class="tabla_opciones" width="100%">		
						<tbody>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_unidad');?></strong></td>
								<td><span id="unidad_unidad_field_unidad"><?php echo element('unidad_field_unidad', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_vin');?></strong></td>
								<td><span id="unidad_unidad_field_vin"><?php echo element('unidad_field_vin', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_motor');?></strong></td>
								<td><span id="unidad_unidad_field_motor"><?php echo element('unidad_field_motor', $array_unidad);?></span></td>
								
								
							</tr>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('auto_modelo_field_desc');?></strong></td>
								<td><span id="unidad_auto_modelo_field_desc"><?php echo element('auto_modelo_field_desc', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('auto_version_field_desc');?></strong></td>
								<td><span id="unidad_auto_version_field_desc"><?php echo element('auto_version_field_desc', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('auto_transmision_field_desc');?></strong></td>
								<td><span id="unidad_auto_transmision_field_desc"><?php echo element('auto_transmision_field_desc', $array_unidad);?></span></td>
								
							</tr>
							<tr>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('auto_anio_field_desc');?></strong></td>
								<td><span id="unidad_auto_anio_field_desc"><?php echo element('auto_anio_field_desc', $array_unidad);?></span></td>
								
								
								<td><strong><?=$this->marvin->mysql_field_to_human('auto_puerta_cantidad_field_desc');?></strong></td>
								<td><span id="unidad_auto_puerta_cantidad_field_desc"><?php echo element('auto_puerta_cantidad_field_desc', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_material_sap');?></strong></td>
								<td><span id="unidad_unidad_field_material_sap"><?php echo element('unidad_field_material_sap', $array_unidad);?></span></td>
								
								
							</tr>
							<tr>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_descripcion_sap');?></strong></td>
								<td><span id="unidad_unidad_field_descripcion_sap"><?php echo element('unidad_field_descripcion_sap', $array_unidad);?></span></td>
								
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_color_exterior_field_desc');?></strong></td>
								<td><span id="unidad_color_exterior_field_desc"><?php echo element('unidad_color_exterior_field_desc', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_color_interior_field_desc');?></strong></td>
								<td><span id="unidad_color_exterior_field_desc"><?php echo element('unidad_color_interior_field_desc', $array_unidad);?></span></td>
								
							</tr>
							<tr>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('auto_marca_field_desc');?></strong></td>
								<td><span id="unidad_auto_marca_field_desc"><?php echo element('auto_marca_field_desc', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('vin_procedencia_ktype_field_desc');?></strong></td>
								<td><span id="unidad_vin_procedencia_ktype_field_desc"><?php echo element('vin_procedencia_ktype_field_desc', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('auto_fabrica_field_desc');?></strong></td>
								<td><span id="unidad_auto_fabrica_field_desc"><?php echo element('auto_fabrica_field_desc', $array_unidad);?></span></td>
								
							</tr>
							<tr>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('vin_procedencia_ktype_field_ktype');?></strong></td>
								<td><span id="unidad_vin_procedencia_ktype_field_ktype"><?php echo element('vin_procedencia_ktype_field_ktype', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_oblea');?></strong></td>
								<td><span id="unidad_unidad_field_oblea"><?php echo element('unidad_field_oblea', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_patente');?></strong></td>
								<td><span id="unidad_unidad_field_patente"><?php echo element('unidad_field_patente', $array_unidad);?></span></td>
								
							</tr>
							<tr>
								
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_codigo_de_llave');?></strong></td>
								<td><span id="unidad_unidad_field_codigo_de_llave"><?php echo element('unidad_field_codigo_de_llave', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_codigo_de_radio');?></strong></td>
								<td><span id="unidad_unidad_field_codigo_de_radio"><?php echo element('unidad_field_codigo_de_radio', $array_unidad);?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_fecha_entrega');?></strong></td>
								<td><span id="unidad_unidad_field_fecha_entrega"><?php echo element('unidad_field_fecha_entrega', $array_unidad);?></span></td>
								
							</tr>
							<tr>
								
								
								<td><strong><?=$this->marvin->mysql_field_to_human('unidad_field_kilometros');?></strong></td>
								<td><span id="unidad_unidad_field_kilometros"><?php echo element('unidad_field_kilometros', $array_unidad);?></span></td>
								
								<td></td>
								<td></td>
								
								<td></td>
								<td></td>
								
							</tr>
							
						</tbody>

						</table>
</li>
<div class="clear"></div>
				
						<div class="noprint clearfix">
							<li class="unitx4 noprint">
							<?php
							$config	=	array(
											'field_name'=>'unidad_field_unidad',
											'field_req'=>TRUE,
											'label_class'=>'unitx1 first', //first
											'field_class'=>'_unidad_field',
											'field_type'=>'text',
											
											);
										echo $this->marvin->print_html_input($config)
							?>
							
						<?php
						$config	=	array(
										'field_name'=>'unidad_field_vin',
										'field_req'=>TRUE,
										'label_class'=>'unitx2', //first
										'field_class'=>'_unidad_field',
										'field_type'=>'text',
										
										);
									echo $this->marvin->print_html_input($config)
						?>

						</li>
						<li class="unitx4 noprint">	
							<?
							if(!isset($basic_input))
							{
							?>
							
								<?php
									$config	=	array(
											'field_name'=>'unidad_field_codigo_de_llave',
											'field_req'=>FALSE,
											'label_class'=>'unitx1 first', //first
											'field_class'=>'',
											'field_type'=>'text',
											
											);
										echo $this->marvin->print_html_input($config)
								?>
								
								<?php
									$config	=	array(
											'field_name'=>'unidad_field_codigo_de_radio',
											'field_req'=>FALSE,
											'label_class'=>'unitx1', //first
											'field_class'=>'',
											'field_type'=>'text',
											
											);
										echo $this->marvin->print_html_input($config)
								?>
								<?php
									$config	=	array(
											'field_name'=>'unidad_field_patente',
											'field_req'=>FALSE,
											'label_class'=>'unitx1', //first
											'field_class'=>'',
											'field_type'=>'text',
											
											);
										echo $this->marvin->print_html_input($config)
								?>
							<?
							}
							?>
							<input type="hidden" value="" class="show_unidad_id" name="_show_unidad_id" id="_show_unidad_id" />
							<input type="hidden" value="" class="unidad_field_edad_meses" name="unidad_field_edad_meses" id="unidad_field_edad_meses" />
						</li>
					</div>
					
					
				</fieldset>