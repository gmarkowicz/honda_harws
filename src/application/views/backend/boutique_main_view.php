<div class="productos">	
<?php 
	$imagen_path = $this->config->item('base_url') . $image_path;
	$link = $this->config->item('base_url') . $this->uri->uri_string();
	if ($producto_array)
	{		
            foreach($producto_array as $producto_row)
            {?>	
                <div class="detalle">									
                        <div class="foto">
		    		<?php
				
				$image_file = $this->config->item('base_url') . 'public/css/boutique_images/sin_imagen.gif';
				$image_temp = "";
				
				foreach ($producto_row['Boutique_Producto_Imagen'] as $images)
				{
					
                                    $image_temp = $imagen_path  . $images['boutique_producto_imagen_field_archivo'] . '_thumb_140' . $images['boutique_producto_imagen_field_extension'];								

                                    if(file_exists($image_temp) == true)
                                    {

                                    }
                                    else
                                    {
                                        $image_file = $image_temp;
                                    }

                                    break;						
				}
							
				echo '<a href="' . $link . '/view/' . $producto_row['id'] . '"><img src="' . $image_file . '" /></a>';
				?>
				</div>
				<div class="informacion">
				<?php 
				echo '<a href="' . $link . '/view/' . $producto_row['id'] . '">'. $producto_row['boutique_producto_field_name'] . '</a><div class="precio"> $ ' . $producto_row['boutique_producto_field_price'] . '</div>';
				?>
				</div>
			</div>
				
		<?php 
		}		
	}
	else
	{?>
		<div class="detalle"><h1><?=lang('boutique_sin_producto');?></h1></div>
	<?php }
	?>
		
	
	
	</div>
	<div id="carro_compras" class="carro">
		<div class="carro_info">
			<?php 
				if ($this->cart->total_items() < 1)
				{
					echo lang('boutique_pedido_vacio');
				}
				else
				{
					echo '<div class="ver"><a title="' . lang('boutique_ver_pedido') . '" href="' . $this->config->item('base_url') . $this->config->item('backend_root') . 'boutique_main/pedido/">' . lang('boutique_ver_carrito') . '</a></div>';
					echo '<div class="finalizar"><a title="' . lang('boutique_finalizar_pedido') . '" href="' . $this->config->item('base_url') . $this->config->item('backend_root') . 'boutique_main/pedido/">' . lang('boutique_finalizar_pedido') . '</a></div>' . lang('boutique_usted_tiene') . ' ' . $this->cart->total_items() . ' ' . lang('boutique_pedido_producto') . (($this->cart->total_items() > 1)? 's' : ''). ' ' . lang('boutique_pedido_total_carrito') . ' ' . $this->cart->total(). ' ';	
				
				}					
			?> </div>
		<div class="carro_pie"> </div>
	</div>