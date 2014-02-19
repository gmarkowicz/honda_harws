<?php
define('ID_SECCION',6011);

class Boutique_Cart extends Backend_Controller {

	//filtra por sucursal?
	var $sucursal = FALSE;
        var $message_body_email;
        var $message_head_email;
        var $message_foot_email;


	function add()
	{

		$cantidad = (int)$this->input->post('cantidad');
		$exist_prod = false;
		$idProducto = (int)$this->input->post('boutique_producto_id') . '-' . (int)$this->input->post('id_color') . '-' . (int)$this->input->post('id_talle') . '-' . (int)$this->input->post('proovedor_id');
		$carts = $this->cart->contents();

		foreach ($carts as $item)
		{
			if ($item['id'] == $idProducto)
			{
				$exist_cart = true;
				$cantidad = $cantidad + $item['qty'];
			}
		}

                $this->cart->product_name_rules = "\.\:\-_ a-z0-9#Ññ'´áéíóúÁÉÍÓÚ(),\/";


		$data = array(
				'id' => $idProducto,
				'name' => $this->input->post('nombre'),
				'qty' => $cantidad,
				'price' => (int)$this->input->post('precio'),
				'option' => array()
		);

		if ($exist_prod)
			$this->cart->update($data);
		else
			$this->cart->insert($data);

		redirect('concesionario/boutique_main/pedido');

	}

	function delete($rowid = false)
	{

		if($rowid)
		{
			$this->cart->update(array(
					'rowid' => $rowid,
					'qty'	=> 0
				)
			);
		}

		if($this->cart->total_items())
			redirect('concesionario/boutique_main/pedido');
		else
			redirect('concesionario/boutique_main');

	}

	function clear()
	{
            if ($this->cart->destroy())
                return true;
            else
                return false;
	}

	function update_cart()
	{

		if(is_array($this->input->post('unidades')))
		{
                    //$this->cart->update();
                    foreach($this->input->post('unidades') as $key => $value)
                    {
                        $data = array(
                                        'rowid'    => $key,
                                        'qty'	=> (int)$value,
                                        );

                        $this->cart->update($data);
                    }

		}

		redirect('concesionario/boutique_main/pedido');

	}

	//Confirmar Compra
	function confirm_cart()
	{
            try
            {
                if ($this->cart->total_items() > 0)
                {

                    if($this->input->post('confirmar_pedido'))
                    {

                        //piso _this_registro_actual
                        $this->registro_actual = new Boutique_Pedido();
                        $this->_grabar_registro_actual();
                        $this->session->set_flashdata('add_ok', true);
                        //seteo para dejarlo actualizar hasta que se vaya, ver plugin backend _verificar_permisos()
                        $this->session->set_userdata('last_add_'.$this->router->class,$this->registro_actual->id);

                        $this->clear();

                        redirect('concesionario/boutique_pedido_main/');

                    }

                }
                else
                {
                        redirect('concesionario/boutique_main/');
                }


            }
            catch(Doctrine_Exception $e)
            {
                $conn->rollback();
                $error=array();
                $error['line'] 		= __LINE__;
                $error['file'] 		= __FILE__;
                $error['error']		= $e->errorMessage();
                $error['sql'] 		= 'transaction';
                $this->backend->_log_error($error);
                show_error( $e->errorMessage()   );
            }
	}


	private function _grabar_registro_actual()
	{
                $this->message_email = '';

                $colorQuery= new Boutique_Color();
                $colores = $colorQuery->get_all();
                $colores = $colores->execute()->toArray();

                foreach ($colores as $color_f){
                    $color[$color_f['id']] = $color_f['boutique_color_field_desc'];
                }

                $tallesQuery = new Boutique_Talle();
                $talles = $tallesQuery->get_all();
                $talles = $talles->execute()->toArray();

                foreach($talles as $talle_f){
                    $talle[$talle_f['id']] = $talle_f['boutique_talle_field_desc'];
                }

                $productosQuery = new Boutique_Producto();
                $productos = $productosQuery->get_all()->addWhere('boutique_producto_estado_id = ?', 1);
                $productos = $productos->execute()->toArray();

                foreach($productos as $producto_f){
                    $producto[$producto_f['id']] = $producto_f['boutique_producto_field_name'];
                }

                $sucursalQuery = new Sucursal();
                $sucursales = $sucursalQuery->get_all()->addWhere('id = ?', $this->input->post('sucursal_id'))->limit(1);
                $sucursales = $sucursales->execute()->toArray();

                foreach($sucursales as $sucursal_f){
                    $sucursal = $sucursal_f;
                }

		try
		{
                    $conn = Doctrine_Manager::connection();
                    $conn->beginTransaction();

                    /* esta preparando los datos que se van a guardar del post en la base Boutique Pedido*/
                    $this->registro_actual->admin_id                     = $this->session->userdata('admin_id');
                    $this->registro_actual->boutique_pedido_observacion  = $this->input->post('boutique_pedido_observacion');
                    $this->registro_actual->boutique_pedido_total        = $this->cart->total();
                    $this->registro_actual->sucursal_id                  = $this->input->post('sucursal_id');
                    $this->registro_actual->boutique_pedido_estado       = '1';

                    $this->registro_actual->save();

                    // Inserta los productos por separado en  boutique_pedido_detalle
                    if($this->registro_actual != false)
                    {
                        $this->message_head_email = '';
                        $this->message_body_email = '';
                        $this->message_foot_email = '';

                        $this->message_head_email .= '<div>Numero de pedido:<strong> ' . $this->registro_actual->id . '</strong></div>';
                        $this->message_head_email .= '<div>Pedido el: <strong>' . date('d-M-y') . ' a las ' . date('H:i') . '</strong></div>';
                        $this->message_head_email .= '<div>Usuario: <strong>' . $this->session->userdata('admin_field_nombre') . ' ' . $this->session->userdata('admin_field_apellido') . '</strong></div>';
                        $this->message_head_email .= '<div>Sucursal: <strong>' . $sucursal['sucursal_field_desc'] . '</strong></div><br /><br />';
                        $this->message_head_email .= '<table><tr><td>Producto</td><td>Color</td><td>Talle</td><td>Precio</td><td>Cantidad</td><td>Subtotal</td></tr>';

                        $array_proveedor = array();

                        foreach($this->cart->contents() as $item){

                            $relacion = new Boutique_Pedido_Detalle();

                            $ids = preg_split('/-/', $item['id']);

                            $relacion->boutique_producto_id        = (int)$ids[0];
                            $relacion->boutique_color              = (int)$ids[1];
                            $relacion->boutique_talle              = (int)$ids[2];
                            $relacion->proovedor_id                = (int)$ids[3];

                            $relacion->boutique_pedido_id          = (int)$this->registro_actual->id;
                            $relacion->boutique_pedido_price       = (int)$item['price'];
                            $relacion->boutique_pedido_qty         = (int)$item['qty'];
                            $relacion->boutique_pedido_subtotal    = (int)$item['subtotal'];

                            if($relacion->trySave() == true)
                            {
                                @$this->message_body_email .= '<tr><td>' . @$producto[(int)$ids[0]] . '</td><td>' . @$color[(int)$ids[1]] . '</td><td>' . @$talle[(int)$ids[2]] . '</td><td>' . @(int)$item['price'] . '</td><td>' . @(int)$item['qty'] . '</td><td>' . @(int)$item['subtotal'] . '</td></tr>';

                                /**
                                 *  Contruyo array dimensional de acuerdo a los diferentes proovedores
                                 *  para luego enviarle email con su producto agrupados
                                 */
                                @$array_proveedor[$relacion->proovedor_id]['id_proveedor'] = @$relacion->proovedor_id;
                                @$array_proveedor[$relacion->proovedor_id]['detalle_pedido_proveedor'][] .= '<tr><td>' . @$producto[(int)$ids[0]] . '</td><td>' . @$color[(int)$ids[1]] . '</td><td>' . @$talle[(int)$ids[2]] . '</td><td>' . @(int)$item['price'] . '</td><td>' . @(int)$item['qty'] . '</td><td>' . @(int)$item['subtotal'] . '</td></tr>';
                                @$array_proveedor[$relacion->proovedor_id]['total_pedido_proveedor']   += @(int)$item['subtotal'];
                            }
                            else
                            {
                                @$array_proveedor[$relacion->proovedor_id] = false;
                            }
                        }

                        $this->message_foot_email = '</table>';
                        $this->message_foot_email .= '<div>Total: ' . $this->cart->total() . '</div>';
                        $this->message_foot_email .= '<div>Observacion: ' . $this->input->post('boutique_pedido_observacion') . '</div>';
                    }

                    $conn->commit();

                    /**
                     * Mensaje al admin que realizo el pedido y a la sucursal
                     */
                    $this->load->library('mymailer');
                    $mailer = $this->mymailer->getNewInstance();
                    $message = Swift_Message::newInstance()
	                    ->setSubject('Pedido Producto de Boutique')
	                    ->setFrom('robot@harws.com')
	                    ->setTo($this->session->userdata('admin_field_email'))
	                    ->setBody($this->message_head_email . $this->message_body_email . $this->message_foot_email, 'text/html');
                    if ($sucursal['sucursal_field_email'] != '') $message->setCc($sucursal['sucursal_field_email']);
                    $mailer->send($message);

                    /**
                     *
                     * Envio de email a los proovedores
                     *
                     */
                     foreach($array_proveedor as $detalle_pedido_array)
                     {
                        $this->message_body_email = '';

                        foreach($detalle_pedido_array['detalle_pedido_proveedor'] as $detalle_pedido_proveedor)
                        {
                            $this->message_body_email .= $detalle_pedido_proveedor;
                        }
                        $id_proveedor    = $detalle_pedido_array['id_proveedor'];
                        $total_proveedor = $detalle_pedido_array['total_pedido_proveedor'];

                        $this->message_foot_email = '</table>';
                        $this->message_foot_email .= '<div>Total: ' . $total_proveedor . '</div>';
                        $this->message_foot_email .= '<div>Observacion: ' . $this->input->post('boutique_pedido_observacion') . '</div>';

                        /**
                         * Obtengo el email de proveedor
                         */
                        $query_proveedor = new Admin();
                        $result_proveedor = $query_proveedor->get_all()->addWhere('id = ?' , $id_proveedor)->limit(1)->execute()->toArray();
                        $email_proveedor = $result_proveedor[0]['admin_field_email'];

                        /**
                         *  Los producots estan agrupados por proveedor
                         *  Los correos seran enviados
                         */
                        $message = Swift_Message::newInstance()
	                        ->setSubject('Pedido Producto de Boutique - Proveedores')
	                        ->setFrom('robot@harws.com')
	                        ->setTo($email_proveedor)
	                        ->setBody($this->message_head_email . $this->message_body_email . $this->message_foot_email, 'text/html');
                        $mailer->send($message);
                     }
                }
		catch(Doctrine_Exception $e)
		{
			$conn->rollback();
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['sql'] 		= 'transaction';
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}

	}



}
