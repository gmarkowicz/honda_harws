<?php 
$imagen_path = $this->config->item('base_url') . $image_path;

foreach($producto_array as $producto_row)
{ ?>	

<div class="productos">		
<div class="ficha">	
    <div class="titulo_ficha"><?php echo $producto_row['boutique_producto_field_name'];?></div>
        <div class="foto_ficha" id="image_galery">
            <ul class="bjqs">   
                <?php

                $image_file = $this->config->item('base_url') . 'public/css/boutique_images/sin_imagen.gif';
                $image_temp = "";

                foreach ($producto_row['Boutique_Producto_Imagen'] as $images)
                {

                    $image_temp = $imagen_path  . $images['boutique_producto_imagen_field_archivo'] . '_thumb_280' . $images['boutique_producto_imagen_field_extension'];								

                    if(file_exists($image_temp))
                    {
                        $image_file = $image_temp;

                    }
                    else
                    {
                        $image_file = $image_temp;
                    }										
                    echo '<li><img style="width:280px;height:280px;" src="' . $image_file . '" /></li>';
                }						

                ?>
            </ul>
        </div>
        <?php if (count($producto_row['Boutique_Producto_Imagen']) > 1)
        { ?>    
        <script>
            $("#image_galery").bjqs({
                'height' : 280,
                'width' : 280,
                'animationDuration' : 1200,
                'showMarkers' : false,
                'centerControls' :false,                                
                'useCaptions' : false,
                'keyboardNav' : false,
                'showControls' : false
            });
        </script>
        <?php } 
        else {
        ?>
        <script>
            $("div#image_galery ul").css('display','block')
        </script>    
        <?php } ?>
        <div class="informacion_ficha">
                <div class="precio_ficha">
                <?php echo lang('pedido_moneda') . ' ' . $producto_row['boutique_producto_field_price']; ?>
                </div>
                <?php echo form_open($this->config->item('base_url') . $this->config->item('backend_root') . 'boutique_cart/add', 'class="cssform" id="form_boutique_producto"')?>
                <p>											
                        <?php 
                        echo form_label('Cantidad');
                        echo form_input('cantidad',1,'class="cssform_campos required digits" id="cantidad" required="required"')?>					
                </p>
                <p>
                        <label><?=lang('pedido_color');?></label>
                        <select class="cssform_campos" name="id_color">							
                                <?php foreach ($producto_row['Many_Boutique_Color'] as $colores)
                                {
                                        echo '<option value="'. $colores ['id']. '">'.$colores['boutique_color_field_desc'] . '</option>';
                                }
                                ?>

                        </select>
                </p>
                <p>
                        <label><?=lang('pedido_talle');?></label>						
                                <select class="cssform_campos" name="id_talle">																	

                                                <?php foreach ($producto_row['Many_Boutique_Talle'] as $talles)
                                                {
                                                        echo '<option value="'. $talles['id']. '">'. $talles['boutique_talle_field_desc'] . '</option>';
                                                }
                                                ?>

                                </select>						  
                </p>
                <p>
                        <label><?=lang('pedido_disponibilidad');?></label><strong><?php	echo $producto_row['Boutique_Disponibilidad']['boutique_disponibilidad_field_desc']; ?></strong>
                </p>
                <p>
                        <?php 
                                echo form_hidden('boutique_producto_id', $producto_row['id']);							
                                echo form_hidden('nombre', $producto_row['boutique_producto_field_name']);
                                echo form_hidden('precio', $producto_row['boutique_producto_field_price']);
                                echo form_hidden('proovedor_id', $producto_row['admin_id']);
                                echo form_submit('action', 'Agregar');
                        ?>					
                </p>
                <?php form_close()?>
                <script>
                        $("#form_boutique_producto").validate({
                                    rules: {
                                            cantidad: {
                                                min: 1
                                                    }

                                },
                                    submitHandler: function(form) {
                                    form.submit();
                                    }
                        });
                </script>				
        </div>
        <div class="producto_descripcion_texto">
                <p><?php echo $producto_row['boutique_producto_field_desc']?></p>
        </div>
</div>			
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
                        echo '<div class="ver"><a title="' . lang('boutique_ver_carrito') . '" href="' . $this->config->item('base_url') . $this->config->item('backend_root') . 'boutique_main/pedido/">' . lang('boutique_ver_carrito') . '</a></div>';
                        echo '<div class="finalizar"><a title="' . lang('boutique_finalizar_pedido') . '" href="' . $this->config->item('base_url') . $this->config->item('backend_root') . 'boutique_main/pedido/">' . lang('boutique_finalizar_pedido') . '</a></div>' . lang('boutique_usted_tiene'). ' ' . $this->cart->total_items() . ' ' . lang('boutique_pedido_producto') . (($this->cart->total_items() > 1)? 's' : ''). ' ' . lang('boutique_pedido_total_carrito') . $this->cart->total(). ' ';
                }					
        ?> </div>
    <div class="carro_pie"> </div>
</div>
		
<?php }?>