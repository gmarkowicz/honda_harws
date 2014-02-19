<div id="tabs">
    <ul>
        <li class="boton-tab"><a href="#tabs-1" id="principal"><?=lang('principal');?></a></li>
    </ul>		
    <div id="tabs-1">
        <?php
        if ($type_user == 'N')
        {
        ?>
            <ul>
                <li>
                    Usted no tiene privilegios para ver este pedido o no existe el pedido.
                </li>
            </ul>
        <?php
        }
        else
        {    
            $boutique_pedido = element(0, $boutique_pedido);
            $model = strtolower($this->model);
        ?>			
        <ul>				
            <fieldset>
                <legend><?=lang('boutique_pedido');?></legend>				
                <li class="unitx8 f-left">				
                    <label class="unitx4"><?=lang('usuario')?>
                        <p>
                                <?= $boutique_pedido['Admin']['admin_field_usuario'];?>
                        </p>
                    </label>				
                    <label class="unitx4"><?=lang('sucursal_id');?>
                        <p>
                                <?= $boutique_pedido['Sucursal']['sucursal_field_desc'];?>
                        </p>
                    </label>									
                </li>
                <li class="unitx8 f-left">				
                    <label class="unitx4"><?=lang('boutique_pedido_observacion')?>
                        <p>
                            <?=$boutique_pedido[$model . '_observacion'];?>
                        </p>
                    </label>				
                    <label class="unitx1"><?=lang('boutique_pedido_total');?>
                        <p>
                            AR$ <?php
                                    if($type_user == 'A' || $type_user == 'U')
                                    {
                                        echo $boutique_pedido[$model . '_total'];
                                    }
                                    elseif($type_user == 'P')
                                    {
                                        echo $total_proovedor;
                                    }
                                ?>
                        </p>
                    </label>
                    <label class="unitx2"><?=lang('created_at');?>
                        <p>
                                <?= $boutique_pedido['created_at'];?>
                        </p>
                    </label>				
                </li>
            </fieldset>
        </ul>
        <form autocomplete="off" enctype="multipart/form-data" method="post" action="<?php echo current_url();?>">
            <ul>				
                <fieldset>
                    <legend><?=lang('boutique_pedido_estado');?></legend>			
                    <li class="unitx8 f-left">		
                        <?php
                            $config = array(
                            'field_name'   => 'boutique_pedido_estado',
                            'field_req'    => TRUE,
                            'field_selected' => $boutique_pedido['Boutique_Pedido_Estado']['id'],						
                            'label_class'  => 'unitx2',
                            'field_class'  => '',
                            'field_options'=> $boutique_pedido_estado
                            );				
                        echo $this->marvin->print_html_select($config);?>
                        <div style="padding: 13px">					
                            <?php		
                                $this->load->view( 'backend/_inc_abm_submit_view' );
                            ?>
                        </div>
                    </li>					
                </fieldset>
            </ul>		
	</form>		
        <ul>
            <fieldset>
                <legend><?=lang('boutique_pedido_detalle');?></legend>
                <div id="grid_detalle_producto">
                    <table>
                        <tr>
                            <th><strong><?=lang('pedido_producto');?></strong></th>
                            <th><strong><?=lang('pedido_categoria');?></strong></th>
                            <th><strong><?=lang('pedido_color');?></strong></th>
                            <th><strong><?=lang('pedido_talle');?></strong></th>
                            <th><strong><?=lang('pedido_precio_unitario');?></strong></th>
                            <th><strong><?=lang('pedido_cantidad');?></strong></th>
                            <th><strong><?=lang('pedido_subtotal');?></strong></th>
                            <th><strong><?=lang('pedido_proovedor');?></strong></th>
                        </tr>
                        <?php
                            $tr_count = 0; 
                            foreach($boutique_pedido_detalle as $productos)
                            {	    
                                if ($tr_count > 1) $tr_count = 0;
                        ?>
                                 <tr class="file<?=$tr_count;?>">
                                    <td><?=$productos['Boutique_Producto']['boutique_producto_field_name']?></td>
                                    <td>
                                        <?php 
                                        foreach($productos['Boutique_Producto']['Many_Boutique_Categoria'] as $producto_categoria)
                                        {
                                            echo @$producto_categoria['boutique_categoria_field_desc'] . '<br />';
                                        }		

                                        ?>
                                    </td>
                                    <td><?=@$productos['Boutique_Color']['boutique_color_field_desc']?>
                                    <td><?=@$productos['Boutique_Talle']['boutique_talle_field_desc']?></td>						    
                                    <td><?=@$productos['boutique_pedido_price'] ?></td>
                                    <td><?=@$productos['boutique_pedido_qty'] ?></td>							    	
                                    <td><?=@($productos['boutique_pedido_price'] * $productos['boutique_pedido_qty'])?></td>
                                    <td><?=@$productos['Proovedor']['admin_field_nombre']?>&nbsp;<?=@$productos['Proovedor']['admin_field_apellido']?></td>
                                    </tr>
                                <?php                                 
                                    ++$tr_count;
                                }
                            ?>
                    </table>
                </div>
            </fieldset>
        </ul>
        <?php } ?>
    </div>
</div>

