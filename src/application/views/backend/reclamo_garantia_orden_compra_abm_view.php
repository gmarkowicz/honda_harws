
<div id="tabs">
		<ul>
			<li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
		</ul>
		<div id="tabs-1">
		<?php
				$this->load->view( 'backend/esqueleto_botones_view' );
		?>
<form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
			
		<ul>	
				
				<fieldset>
			<legend><?=$this->marvin->mysql_field_to_human('sucursal_id');?></legend>
			<li>
				<table cellspacing="2" class="tabla_opciones" cellpadding="2" width="100%">
						
						
						<tbody>
							<tr>
								<td><strong><?=$this->marvin->mysql_field_to_human('id');?></strong></td>
								<td><span><?php echo $current_record['id'];?></span></td>
								
								<td><strong><?=$this->marvin->mysql_field_to_human('sucursal_field_desc');?></strong></td>
								<td><span><?php echo $current_record['Sucursal']['sucursal_field_desc'];?></span></td>
								<td><strong><?php echo lang('fechahora_alta');?>: </td>
								<td><span><?php echo $this->marvin->mysql_datetime_to_human($current_record['created_at']);?></span></td>
							</tr>
							
							<tr>
								<td><strong><?php echo lang('valor_honda');?></strong></td>
								<td colspan="3">AR$ <?php echo $current_record['reclamo_garantia_orden_compra_field_valor_honda'];?></td>
								<td><strong><?php echo lang('valor_japon');?></strong></td>
								<td colspan="2">U$S <?php echo $current_record['reclamo_garantia_orden_compra_field_valor_japon'];?></td>
							</tr>
							
						</tbody>
				</table>
			</li>
		</fieldset>
		
		<?php if(isset($reclamos_garantia)):?>
		
		<?php $odd = 1;?>
		<fieldset style="background-color:#fff;background-image:none;">		
		<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_id');?></legend>
		<table id="hor-zebra" summary="">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Fecha Alta</th>
						<th scope="col">Fecha Aprobación</th>
						<th scope="col">Importe Honda</th>
						<th scope="col">Importe Japón</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($reclamos_garantia as $reclamo):?>
					<tr <?php if(($odd % 2) == 1) echo 'class="odd"';?>>
						<td><?php if($this->backend->_permiso('view',3071)):?><a href="<?= $this->config->item('base_url').$this->config->item('backend_root') . 'reclamo_garantia_abm/show/' . $reclamo['id'] ?>" class="always" target="_blanck"><?php endif;?><?php echo $reclamo['id'];?><?php if($this->backend->_permiso('view',3071)):?></a><?php endif;?></td>
						<td><?php echo $reclamo['reclamo_garantia_field_fechahora_alta'];?></td>
						<td><?php echo $reclamo['reclamo_garantia_field_fechahora_aprobacion'];?></td>
						<td>AR$ <?php echo $reclamo['valor_reclamado_honda'];?></td>
						<td>U$S <?php echo $reclamo['valor_reclamado_japon'];?></td>
					</tr>
				
				<?php ++$odd;?>
				<?php endforeach;?>
				
				</tbody>
		</table>
		</fieldset>
		<?php endif;?>
				
				
				<fieldset>
				<legend><?=$this->marvin->mysql_field_to_human('reclamo_garantia_orden_compra_id');?></legend>
				<li class="unitx4 f-left">
				

				

					<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_orden_compra_field_desc',
							'field_req'		=>TRUE,
							'label_class'		=>'unitx2 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>

				

					


				
		</li>
		<li class="unitx4 f-left">
			
				
				<?php
						$config	=	array(
							'field_name'		=>'reclamo_garantia_orden_compra_field_factura',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx1 first',
							'field_class'		=>'',
							'field_type'		=>'text',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_input($config);
					?>
				
				<?php
					$config	=	array(
							'field_name'		=>'reclamo_garantia_orden_compra_field_fecha_factura',
							'field_req'			=>FALSE,
							'label_class'		=>'unitx2', //first
							'field_class'		=>'',
							'field_params'	=>'',
							);
						echo $this->marvin->print_html_calendar($config);
					?>
		</li>
		</fieldset>

		<?php
		/*---- descomentar para imagenes
		?>
		
		<fieldset>
			<legend><?=lang('imagenes');?></legend>
		<?php
			//cargo include de multiples imagenes
			$config = array();
			$config['prefix'] = 'imagen';
			$config['images'] = array(); //inicializo por si tiene varios
			$config['model'] = strtolower($this->model);
			if(isset(MODELO_IMAGEN) && count(MODELO_IMAGEN)>0)
			{
				$config['images'] = MODELO_IMAGEN;
			}
			$this->load->view( 'backend/_imagen_upload_view',$config );
		?>
		
		</fieldset>
		*/
		?>
		
		<?php
		/*---- descomentar para adjuntos
		?>
		<fieldset>
			<legend><?=lang('adjuntos');?></legend>
		<?php
			//cargo include de multiples adjuntos
			$config = array();
			$config['prefix'] = 'adjunto';
			$config['model'] = strtolower($this->model);
			if(isset($reclamo_garantia_orden_compra_adjunto) && count($reclamo_garantia_orden_compra_adjunto)>0)
			{
				$config['adjuntos'] = $reclamo_garantia_orden_compra_adjunto;
			}
			$this->load->view( 'backend/_adjunto_upload_view',$config );
		?>
		
		</fieldset>
		*/
		?>
			
		</ul>
		<?php
			$this->load->view( 'backend/_inc_abm_submit_view' );
		?>
</form>
</div>
</div>
