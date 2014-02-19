<?php

	//this is what you get when you mess with us
	if(!isset($cliente_sucursal_field_direccion_piso))
		$cliente_sucursal_field_direccion_piso = '';
	
	if(!isset($documento_tipo_id))
		$documento_tipo_id = '';
		
	if(!isset($cliente_field_numero_documento))
		$cliente_field_numero_documento = '';
	
	if(!isset($sexo_id))
		$sexo_id = '';
	
	if(!isset($tratamiento_id))
		$tratamiento_id = '';
	
	if(!isset($cliente_sucursal_field_razon_social))
		$cliente_sucursal_field_razon_social = '';
	
	if(!isset($cliente_sucursal_field_nombre))
		$cliente_sucursal_field_nombre = '';
	
	if(!isset($cliente_sucursal_field_apellido))
		$cliente_sucursal_field_apellido = '';
	
	if(!isset($cliente_sucursal_field_fecha_nacimiento))
		$cliente_sucursal_field_fecha_nacimiento = '';
	
	if(!isset($cliente_sucursal_field_email))
		$cliente_sucursal_field_email = '';
	
	if(!isset($cliente_sucursal_field_direccion_calle))
		$cliente_sucursal_field_direccion_calle = '';
	
	if(!isset($cliente_sucursal_field_direccion_numero))
		$cliente_sucursal_field_direccion_numero = '';
	
	if(!isset($cliente_sucursal_field_direccion_piso))
		$cliente_sucursal_field_direccion_piso = '';
	
	if(!isset($cliente_sucursal_field_direccion_depto))
		$cliente_sucursal_field_direccion_depto = '';
	
	if(!isset($cliente_sucursal_field_localidad_aux))
		$cliente_sucursal_field_localidad_aux = '';
	
	if(!isset($provincia_id))
		$provincia_id = '';
		
	if(!isset($ciudad_id))
		$ciudad_id = '';
	
	if(!isset($cliente_sucursal_field_direccion_codigo_postal))
		$cliente_sucursal_field_direccion_codigo_postal = '';
		
	if(!isset($cliente_sucursal_field_telefono_particular_codigo))
		$cliente_sucursal_field_telefono_particular_codigo = '';
	
	if(!isset($cliente_sucursal_field_telefono_particular_numero))
		$cliente_sucursal_field_telefono_particular_numero = '';
		
	if(!isset($cliente_sucursal_field_telefono_laboral_codigo))
		$cliente_sucursal_field_telefono_laboral_codigo = '';	
		
	if(!isset($cliente_sucursal_field_telefono_laboral_numero))
		$cliente_sucursal_field_telefono_laboral_numero = '';

	if(!isset($cliente_sucursal_field_telefono_movil_codigo))
		$cliente_sucursal_field_telefono_movil_codigo = '';
	
	if(!isset($cliente_sucursal_field_telefono_movil_numero))
		$cliente_sucursal_field_telefono_movil_numero = '';
		
	if(!isset($cliente_sucursal_field_fax_codigo))
		$cliente_sucursal_field_fax_codigo = '';
	
	if(!isset($cliente_sucursal_field_fax_numero))
		$cliente_sucursal_field_fax_numero = '';
		
	if(!isset($cliente_conformidad_id))
		$cliente_conformidad_id = '';	
	
	
	
	
	
?>										
						<a href="#" class="remove_cliente f-right" style="position:absolute;right:25px;" border="2"><?=lang('eliminar');?></a>
					
					
					<?
					if(!isset($id))
					{
						$id=uniqid(); // :O
					}
					?>
					
					<li class="unitx4 f-left">
						<label class="unitx2 first  <?php if(form_error($id.'[documento_tipo_id]')){ echo 'error';} ?>">
							<?=$this->marvin->mysql_field_to_human('documento_tipo_id');?><span class="req">*</span>
							<?php echo form_dropdown('cliente[documento_tipo_id][]', $options_documento_tipo_id, @$documento_tipo_id,'class="select documento_tipo_id"')?>
							</label>
						
					
					<label  class="unitx2  <?php if(form_error($id.'[cliente_field_numero_documento]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_field_numero_documento');?><span class="req">*</span>
						<input type="text" value="<?=@$cliente_field_numero_documento;?>" class="text cliente_field_numero_documento" id="cliente_field_numero_documento" name="cliente[cliente_field_numero_documento][]">
					</label>
					
					
					
					</li>
					<li class="unitx4 f-left">
						<?if(isset($tsi_form)){
					
						}else{
						?>
							
							<label class="unitx2 first  <?php if(form_error($id.'[cliente_conformidad_id]')){ echo 'error';} ?>">
							<?=$this->marvin->mysql_field_to_human('cliente_conformidad_id');?> <span class="req">*</span>
							<?php echo form_dropdown('cliente[cliente_conformidad_id][]', $options_cliente_conformidad_id, @$cliente_conformidad_id,'class="select cliente_conformidad_id"')?></label>
						<?}?>
						
						<label class="unitx1  <?php if(form_error($id.'[sexo_id]')){ echo 'error';} ?>">
							<?=$this->marvin->mysql_field_to_human('sexo_id');?> 
							<?php echo form_dropdown('cliente_sucursal[sexo_id][]', $options_sexo_id, @$sexo_id,'class="select sexo_id"')?>
						</label>
						
					</li>
					<div class="both"></div>
					
					<li class="unitx4 f-left">
							
						
						
						<label class="unitx1 first  <?php if(form_error($id.'[tratamiento_id]')){ echo 'error';} ?>">
							<?=$this->marvin->mysql_field_to_human('tratamiento_id');?> <span class="req">*</span>
							<?php echo form_dropdown('cliente_sucursal[tratamiento_id][]', $options_tratamiento_id, @$tratamiento_id,'class="select tratamiento_id"')?>
						</label>
						

						<label  class="unitx3  <?php if(form_error($id.'[cliente_sucursal_field_razon_social]')){ echo 'error';} ?>" id="auto_cliente">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_razon_social');?><span class="req">*</span>
						<input type="text" value="<?=@$cliente_sucursal_field_razon_social;?>" class="text cliente_sucursal_field_razon_social" id="cliente_sucursal_field_razon_social" name="cliente_sucursal[cliente_sucursal_field_razon_social][]">
						</label>
						
					
					</li>
						
						
						
					
					
					<li class="unitx4 f-left">
						
						
						<label  class="unitx2 first  <?php if(form_error($id.'[cliente_sucursal_field_nombre]')){ echo 'error';} ?>" id="auto_cliente">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_nombre');?><span class="req">*</span>
						<input type="text" value="<?=@$cliente_sucursal_field_nombre;?>" class="text cliente_sucursal_field_nombre" id="cliente_sucursal_field_nombre" name="cliente_sucursal[cliente_sucursal_field_nombre][]">
					</label>

						<label  class="unitx2 <?php if(form_error($id.'[cliente_sucursal_field_apellido]')){ echo 'error';} ?>" id="auto_cliente">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_apellido');?><span class="req">*</span>
						<input type="text" value="<?=@$cliente_sucursal_field_apellido;?>" class="text cliente_sucursal_field_apellido" id="cliente_sucursal_field_apellido" name="cliente_sucursal[cliente_sucursal_field_apellido][]">
					</label>
						
						
					</li>
					<div class="both"></div>
				
						
					<li class="unitx4 f-left">
					
					
						<label class="unitx2 first<?php if(form_error($id.'[cliente_sucursal_field_fecha_nacimiento]')){ echo 'error';} ?>" for="cliente_sucursal_field_fecha_nacimiento"><?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_fecha_nacimiento');?>
								<input id="cliente_sucursal_field_fecha_nacimiento<?=$id?>" name="cliente_sucursal[cliente_sucursal_field_fecha_nacimiento][]" class="text field-datepick" value="<?=$this->marvin->mysql_date_to_form(@$cliente_sucursal_field_fecha_nacimiento);?>" type="text">
							
							
							<?php //echo $this->marvin->print_js_calendar('cliente_sucursal_field_fecha_nacimiento'.$id);?>
							<?php echo $this->marvin->print_js_calendar('cliente_sucursal_field_fecha_nacimiento'.$id,array('year_range'=>'1900:'.(date("Y")-17)));?>
							 
						</label>
					</li>
					<li class="unitx4 f-lef">
						<label  class="unitx3 first <?php if(form_error($id.'[cliente_sucursal_field_email]')){ echo 'error';} ?>">
							<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_email');?>
							<input type="text" value="<?=@$cliente_sucursal_field_email;?>" class="text cliente_sucursal_field_email" id="cliente_sucursal_field_email" name="cliente_sucursal[cliente_sucursal_field_email][]">
							</label>
					</li>
					
					
					

					
					
					<li class="unitx4 f-left both">
						<label class="desc"><?=$this->marvin->mysql_field_to_human('direccion');?></label>
						
						<label  class="unitx2 first <?php if(form_error($id.'[cliente_sucursal_field_direccion_calle]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_calle');?><span class="req">*</span>
						<input type="text" value="<?=@$cliente_sucursal_field_direccion_calle;?>" class="text cliente_sucursal_field_direccion_calle" id="cliente_sucursal_field_direccion_calle" name="cliente_sucursal[cliente_sucursal_field_direccion_calle][]">
						</label>
						
						<label  class="unitx1 <?php if(form_error($id.'[cliente_sucursal_field_direccion_numero]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_numero');?><span class="req">*</span>
						<input type="text" value="<?=@$cliente_sucursal_field_direccion_numero;?>" class="text cliente_sucursal_field_direccion_numero" id="cliente_sucursal_field_direccion_numero" name="cliente_sucursal[cliente_sucursal_field_direccion_numero][]">
						</label>
						
						<label  class="unitx1 <?php if(form_error($id.'[cliente_sucursal_field_direccion_piso]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_piso');?>
						<input type="text" value="<?=@$cliente_sucursal_field_direccion_piso;?>" class="text cliente_sucursal_field_direccion_piso" id="cliente_sucursal_field_direccion_piso" name="cliente_sucursal[cliente_sucursal_field_direccion_piso][]">
						</label>
					</li>
					<li class="unitx4 f-left">
						<label class="desc">&nbsp;</label>
						<label  class="unitx1 first <?php if(form_error($id.'[cliente_sucursal_field_direccion_depto]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_depto');?>
						<input type="text" value="<?=@$cliente_sucursal_field_direccion_depto;?>" class="text cliente_sucursal_field_direccion_depto" id="cliente_sucursal_field_direccion_depto" name="cliente_sucursal[cliente_sucursal_field_direccion_depto][]">
						</label>
						
						
					</li>
					<li class="unitx5 f-left">
						
						<label class="unitx2 first   <?php if(form_error($id.'[provincia_id]')){ echo 'error';} ?>">
							<?=$this->marvin->mysql_field_to_human('provincia_id');?> <span class="req">*</span> <span class="cliente_provincia_old">(<?php echo @$cliente_sucursal_field_localidad_aux;?>)</span>
							<?php echo form_dropdown('cliente_sucursal[provincia_id][]', $options_provincia_id, @$provincia_id,'class="select provincia_id"')?>
						</label>
						<input type="hidden" id="cliente_sucursal_field_localidad_aux" name="cliente_sucursal[cliente_sucursal_field_localidad_aux][]" value="<?=@$cliente_sucursal_field_localidad_aux;?>">
						<div class="ciudad_id left">
						<?=$this->load->view('backend/ciudad_id_inc_view',array(
						'input'=>'cliente_sucursal[ciudad_id][]',
						'ciudad_id'=>@$options_ciudad_id,
						'selected'=>@$ciudad_id,
						'error'=>form_error($id.'[ciudad_id]'),
						)
						);?>
						</div>
						
					
					</li>
					<li class="unitx3 f-left">
						<label  class="unitx1 <?php if(form_error($id.'[cliente_sucursal_field_direccion_codigo_postal]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_direccion_codigo_postal');?><span class="req">*</span>
						<input type="text" value="<?=@$cliente_sucursal_field_direccion_codigo_postal;?>" class="text cliente_sucursal_field_direccion_codigo_postal" id="cliente_sucursal_field_direccion_codigo_postal" name="cliente_sucursal[cliente_sucursal_field_direccion_codigo_postal][]">
						</label>
					</li>
					
					
					<li class="unitx4 f-left">
						<label class="desc"><?=$this->marvin->mysql_field_to_human('telefono_particular');?></label>
						
							<label  class="unitx1 first <?php if(form_error($id.'[cliente_sucursal_field_telefono_particular_codigo]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_particular_codigo');?>
						<input type="text" value="<?=@$cliente_sucursal_field_telefono_particular_codigo;?>" class="text cliente_sucursal_field_telefono_particular_codigo" id="cliente_sucursal_field_telefono_particular_codigo" name="cliente_sucursal[cliente_sucursal_field_telefono_particular_codigo][]">
						</label>
						
							<label  class="unitx2 <?php if(form_error($id.'[cliente_sucursal_field_telefono_particular_numero]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_particular_numero');?>
						<input type="text" value="<?=@$cliente_sucursal_field_telefono_particular_numero;?>" class="text cliente_sucursal_field_telefono_particular_numero" id="cliente_sucursal_field_telefono_particular_numero" name="cliente_sucursal[cliente_sucursal_field_telefono_particular_numero][]">
						</label>

						
					
					</li>
					
					<li class="unitx4 f-left">
							<label class="desc"><?=$this->marvin->mysql_field_to_human('telefono_laboral');?></label>
						
							<label  class="unitx1 first <?php if(form_error($id.'[cliente_sucursal_field_telefono_laboral_codigo]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_laboral_codigo');?>
						<input type="text" value="<?=@$cliente_sucursal_field_telefono_laboral_codigo;?>" class="text cliente_sucursal_field_telefono_laboral_codigo" id="cliente_sucursal_field_telefono_laboral_codigo" name="cliente_sucursal[cliente_sucursal_field_telefono_laboral_codigo][]">
						</label>
						
							<label  class="unitx2 <?php if(form_error($id.'[cliente_sucursal_field_telefono_laboral_numero]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_laboral_numero');?>
						<input type="text" value="<?=@$cliente_sucursal_field_telefono_laboral_numero;?>" class="text cliente_sucursal_field_telefono_laboral_numero" id="cliente_sucursal_field_telefono_laboral_numero" name="cliente_sucursal[cliente_sucursal_field_telefono_laboral_numero][]">
						</label>

					
					</li>
					
					<li class="unitx4 f-left">
								<label class="desc"><?=$this->marvin->mysql_field_to_human('telefono_movil');?></label>
						
							<label  class="unitx1 first <?php if(form_error($id.'[cliente_sucursal_field_telefono_movil_codigo]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_movil_codigo');?>
						<input type="text" value="<?=@$cliente_sucursal_field_telefono_movil_codigo;?>" class="text cliente_sucursal_field_telefono_movil_codigo" id="cliente_sucursal_field_telefono_movil_codigo" name="cliente_sucursal[cliente_sucursal_field_telefono_movil_codigo][]">
						</label>
						
							<label  class="unitx2 <?php if(form_error($id.'[cliente_sucursal_field_telefono_movil_numero]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_telefono_movil_numero');?>
						<input type="text" value="<?=@$cliente_sucursal_field_telefono_movil_numero;?>" class="text cliente_sucursal_field_telefono_movil_numero" id="cliente_sucursal_field_telefono_movil_numero" name="cliente_sucursal[cliente_sucursal_field_telefono_movil_numero][]">
						</label>

					
					</li>
					
					<li class="unitx4 f-left">
							<label class="desc"><?=$this->marvin->mysql_field_to_human('fax');?></label>
						
							<label  class="unitx1 first <?php if(form_error($id.'[cliente_sucursal_field_fax_codigo]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_fax_codigo');?>
						<input type="text" value="<?=@$cliente_sucursal_field_fax_codigo;?>" class="text cliente_sucursal_field_fax_codigo" id="cliente_sucursal_field_fax_codigo" name="cliente_sucursal[cliente_sucursal_field_fax_codigo][]">
						</label>
						
							<label  class="unitx2 <?php if(form_error($id.'[cliente_sucursal_field_fax_numero]')){ echo 'error';} ?>">
						<?=$this->marvin->mysql_field_to_human('cliente_sucursal_field_fax_numero');?>
						<input type="text" value="<?=@$cliente_sucursal_field_fax_numero;?>" class="text cliente_sucursal_field_fax_numero" id="cliente_sucursal_field_fax_numero" name="cliente_sucursal[cliente_sucursal_field_fax_numero][]">
						</label>
					</li>
			
				
				<div class="both"></div>
