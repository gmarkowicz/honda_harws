<?php 
	$link = $this->config->item('base_url') . $this->config->item('backend_root') . 'boutique_cart/'; 
?> 
		
            <div class="ficha">
                <div class="informacion_resumen">
                    <div class="titulo_ficha">
                            <?=lang('boutique_su_orden');?>
                    </div>             
                    
                    <?php
                                
                                echo form_open($link . 'update_cart', 'class="cssform" id="form_boutique_update_cart"');?>
				<table width="600px" cellspacing="1" cellpadding="5">
					<tr class="tabla_titulos">
						<td scope="row" width="195px">
							<?=lang('pedido_producto');?>
						</td>
						<td width="75px">
							<?=lang('pedido_color');?>
						</td>
						<td width="90px">
							<?=lang('pedido_talle');?>
						</td>
						<td width="70px">
							<?=lang('pedido_precio_unitario');?>
						</td>
						<td width="50px">
							<?=lang('pedido_cantidad');?>
						</td>
						<td width="90px">
							<?=lang('pedido_subtotal');?>
						</td>
						<td width="50px">
							<?=lang('pedido_eliminar');?>
						</td>
					</tr>
					
					<?php				
					
					
					foreach($this->cart->contents() as $item)
					{
					 $ids = preg_split('/-/', $item['id']); ?>
						<tr class="tabla_detalles">
						<td scope="row">
							<?php echo $item['name']; ?>
						</td>						
						<td><?php 
						foreach($color_list as $color)
						{
							if ($ids[1] == $color['id'])
							{	
								echo $color['boutique_color_field_desc'];
								break;
							}	
						}
						?></td>
						<td><?php					
						foreach ($talles_list as $talle)
						{
							 if ($ids[2] == $talle['id'])
							 {	
							 	echo $talle['boutique_talle_field_desc'];
							 	break;
							 }
						};						
						?>						
						</td>
						<td>
						 <?php echo $item['price']; ?>
						</td>
						<td>
						<?php echo form_input('unidades[' . $item['rowid'] . ']', $item['qty'], 'class="cssform_campos_45 required numeric" maxlength="2" required="required" id="unidades[' . $item['id'] . ']"'); ?>
						</td>
						<td>
						 <?=lang('pedido_moneda')?> <?php echo $item['subtotal']; ?>
						</td>
						<td>
						<a href="<?php echo $this->config->item('base_url') . $this->config->item('backend_root') . 'boutique_cart/delete/' . $item['rowid']; ?>" class="opcion"><img src="<?php echo $this->config->item('base_url')?>/public/css/boutique_images/x.gif" width="16" height="16" border="0"/></a>
						</td>
						</tr>
						
					<?php }	?>				
					</table>
					<?php echo form_submit('actualizar_pedido', lang('pedido_actualizar_cantidades'), 'class="cssform_boton2"') ;?>
					<div class="subtitulo_ficha">
						<?=lang('pedido_total')?>
					</div>
					<div class="precio_ficha">
						<?=lang('pedido_moneda')?> <?php echo $this->cart->total();?>
					</div>				
				<?php 
				echo form_close();
				echo form_open($link . 'confirm_cart', 'class="cssform" id="form_boutique_confirm_cart"')
				?>				
					<script>
						$("#form_boutique_update_cart").validate({
							 rules: {
								 unidades: {
									min: 1
									 }

							},
							 submitHandler: function(form) {
							   form.submit();
							 }
						});
  					</script>
                                         
                                        <div class="titulo_ficha">
						<?=lang('pedido_sucursal')?>:
					</div> 
                                        <div class="sucursales_disponibles">
                                                <?php                        
                                                    $config = array(
                                                    'field_name'   => 'sucursal_id',
                                                    'field_req'    => TRUE,
                                                    'label_class'  => 'unitx4',
                                                    'field_class'  => '',
                                                    'field_options'=> $sucursales_disponibles
                                                );
                                                echo $this->marvin->print_html_select($config);                      
                                                ?>
                                            
                                         </div>
					
					<div class="titulo_ficha">
						<?=lang('pedido_observaciones');?>:
					</div>
					<div>
						<?php echo form_textarea('boutique_pedido_observacion','','style="width:500px; height:150px;" class="cssform_campos"')?>
					</div>					
					<div>
						<?php echo form_submit('confirmar_pedido',lang('pedido_confirmar_compra'),'class="cssform_boton3"');?>						
					</div>	
				<?php echo form_close()?>
			</div>
		</div>
