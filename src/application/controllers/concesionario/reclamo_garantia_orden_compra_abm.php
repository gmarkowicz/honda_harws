<?php
define('ID_SECCION',3078);
class Reclamo_Garantia_Orden_Compra_Abm extends Backend_Controller{
	//objeto actual de doctrine
	var $registro_actual = FALSE;

	//filtra por sucursal?
	var $sucursal = FALSE;

	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;

	//subfix de archivos adjuntos
	var $upload_adjunto = array();

	//subfix de imagenes adjuntas
	var $upload_image = array();

	var $enviar_mail = FALSE;

	var $enviar_mail_a = array();

	function __construct()
	{
		parent::Backend_Controller();
	}



	//----------------------------------------------------------------
	//-------------------------[crea un registro a partir de post ]
	public function add()
	{

		show_404();
		if($this->input->post('_submit'))
		{
			if ($this->_validar_formulario() == TRUE)
			{
				//piso _this_registro_actual
				$this->registro_actual = new Reclamo_Garantia_Orden_Compra();
				$this->_grabar_registro_actual();
				$this->session->set_flashdata('add_ok', true);
				//seteo para dejarlo actualizar hasta que se vaya, ver plugin backend _verificar_permisos()
				$lasts = $this->session->userdata('last_add_' . $this->router->class );
				if(!is_array($lasts))
					$lasts = array();
				$lasts[] = $this->registro_actual->id;
				$this->session->set_userdata('last_add_'.$this->router->class,$lasts);
				//
				redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
			}
		}

		$this->_view();
	}
	//-------------------------[crea un registro a partir de post ]
	//----------------------------------------------------------------

	//----------------------------------------------------------------
	//-------------------------[rechaza registro actual]
	public function reject()
	{
		show_404();
		if($this->rechazar_registro === TRUE)
		{
			$this->_set_record($this->input->post('id'));
			if($this->_reject_record())
			{
				if($this->input->post('ajax'))
				{
					//le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
					$this->output->set_output("TRUE");
				}
			}
		}
	}

	//----------------------------------------------------------------
	//-------------------------[rechaza registro actual]

	//----------------------------------------------------------------
	//-------------------------[elimina registro actual]
	public function del()
	{
		show_404();
		$this->_set_record($this->input->post('id'));
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();
			//$this->registro_actual->admin_deleted_id = $this->session->userdata('admin_id');
			//no borra los m2m con $this->registro_actual->delete(); :S



			//------- elimino imagenes (si las hay)
			if($this->backend->isset_image())
			{
				while(list($key,$subfix)=each($this->upload_image))
				{
					$modelo = str_replace(' ','_',humanize($this->model . '_' . $subfix));
					foreach($this->registro_actual->$modelo as $imagen)
					{
						$this->del_image( $this->registro_actual->id, $imagen->id, $subfix );
					}
				}
			}
			//------- elimino imagenes (si las hay)

			//------- elimino archivos adjuntos (si los hay)
			if($this->backend->isset_adjunto())
			{
				while(list($key,$subfix)=each($this->upload_adjunto))
				{
					$modelo = str_replace(' ','_',humanize($this->model . '_' . $subfix));
					foreach($this->registro_actual->$modelo as $adjunto)
					{
						$this->del_adjunto( $this->registro_actual->id, $adjunto->id, $subfix );
					}
				}
			}
			//------- elimino archivos adjuntos (si los hay)



			$this->registro_actual->save();
			$this->registro_actual->delete();
			$conn->commit();
		} catch(Doctrine_Exception $e) {
			$conn->rollback();
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= $e->errorMessage();
			$error['sql'] 		= 'transaction';
			$this->backend->_log_error($error);
			show_error( $e->errorMessage()   );
		}
		$this->session->set_flashdata('del_ok', true);
		if($this->input->post('ajax'))
		{
			//le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
			$this->output->set_output("TRUE");
		}
	}
	//-------------------------[elimina registro actual]
	//----------------------------------------------------------------

	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------
	public function show($id = FALSE)
	{
		$this->_set_record($id);
		$this->_mostrar_registro_actual($id);
		$this->_view();
	}


	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------

	//----------------------------------------------------------------
	//-------------------------[edita el registro]
	public function edit($id = FALSE)
	{
		$this->_set_record($id);
		if($this->input->post('_submit'))
		{
			//manda info
			if ($this->_validar_formulario() == TRUE)
			{
				//pasa validacion, grabo y redirecciono a edit
				$this->_grabar_registro_actual();
				$this->session->set_flashdata('edit_ok', true);
				if($this->enviar_mail)
				{
					$this->_send_mail();
				}
				redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
			}
		}else{
			//no mando info, muestro la del registro por default
			$this->_mostrar_registro_actual();
		}
		//llamo a la vista
		$this->_view();

	}
	//-------------------------[edita el registro]
	//----------------------------------------------------------------

	//----------------------------------------------------------------
	protected function _mostrar_registro_actual()
	{
		//paranoid (por las dudas vio)
		$_POST = array();
		if($this->registro_actual)
		{
			$registro_array = $this->registro_actual->toArray();
			$this->form_validation->set_defaults($registro_array);


		}
		else
		{
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= 'no existe llamada a _set_record?';
			$this->backend->_log_error($error);
			show_error( $error['error']   );
		}
	}
	//----------------------------------------------------------------
	//-------------------------[le manda los datos a la view]

	//----------------------------------------------------------------
	//-------------------------[graba registro en la base de datos]
	private function _grabar_registro_actual()
	{
		try
		{
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();


			if($this->router->method == 'add' )
			{
				$this->registro_actual->reclamo_garantia_orden_compra_field_admin_alta_id = $this->session->userdata('admin_id');
			}
			else if($this->router->method == 'edit' )
			{
				$this->registro_actual->reclamo_garantia_orden_compra_field_admin_modifica_id = $this->session->userdata('admin_id');
			}


			//cuando pone la orden de compra se envia el mail.
			if(strlen($this->registro_actual->reclamo_garantia_orden_compra_field_desc) == 0)
			{
				$this->registro_actual->reclamo_garantia_orden_compra_field_desc = $this->input->post('reclamo_garantia_orden_compra_field_desc');

			}

			if($this->registro_actual->reclamo_garantia_orden_compra_field_mail_enviado !=1)
			{
				$this->enviar_mail = TRUE;
			}

			$this->registro_actual->reclamo_garantia_orden_compra_field_factura = $this->input->post('reclamo_garantia_orden_compra_field_factura');
			$this->registro_actual->reclamo_garantia_orden_compra_field_fecha_factura = $this->input->post('reclamo_garantia_orden_compra_field_fecha_factura');

			$this->registro_actual->save();

			$conn->commit();

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

		$this->backend->upload_adjuntos();
		$this->backend->upload_images();

	}
	//-------------------------[graba registro en la base de datos]
	//----------------------------------------------------------------

	//-----------------------------------------------------------------------------
	//-------------------------[vista generica abm]
	protected function _view()
	{
		//$this->output->enable_profiler();

		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['main_url'] = $this->get_main_url();
		$this->template['tpl_include'] = $this->get_template_view();
		if($this->rechazar_registro === TRUE){
			$this->template['SHOW_RECHAZAR_REGISTRO'] = TRUE;
		}
		else
		{
			$this->template['SHOW_RECHAZAR_REGISTRO'] = FALSE;
		}

		//------------ [select / checkbox / radio sucursal_id] :(
		$sucursal=new Sucursal();
		$q = $sucursal->get_all();
		//$q->WhereIn(' sucursal_id ', $this->session->userdata('sucursales'));
		$config=array();
		$config['fields'] = array('sucursal_field_desc');
		$config['select'] = TRUE;
		$this->template['sucursal_id']=$this->_create_html_options($q, $config);
		//------------ [fin select / checkbox / radio sucursal_id]

		$this->template['current_record']=$this->registro_actual->toArray();

		//reclamos de garantia de la orden de compra..
		$q = Doctrine_Query::create();
		$q->select('
					RECLAMO_GARANTIA.id as reclamo_garantia_id,
					RECLAMO_GARANTIA_VERSION_HONDA.reclamo_garantia_version_field_valor_reclamado as valor_reclamado_honda,
					RECLAMO_GARANTIA_VERSION_JAPON.reclamo_garantia_version_field_valor_reclamado as valor_reclamado_japon,
					RECLAMO_GARANTIA.reclamo_garantia_field_fechahora_aprobacion,
					RECLAMO_GARANTIA.reclamo_garantia_field_fechahora_alta
		');

		$q->from('Reclamo_Garantia RECLAMO_GARANTIA ');
		$q->leftJoin('RECLAMO_GARANTIA.Reclamo_Garantia_Version RECLAMO_GARANTIA_VERSION_HONDA ON RECLAMO_GARANTIA_VERSION_HONDA.reclamo_garantia_id = RECLAMO_GARANTIA.id AND RECLAMO_GARANTIA_VERSION_HONDA.reclamo_garantia_version_field_desc = ? ','HONDA');
		$q->leftJoin('RECLAMO_GARANTIA.Reclamo_Garantia_Version RECLAMO_GARANTIA_VERSION_JAPON ON RECLAMO_GARANTIA_VERSION_JAPON.reclamo_garantia_id = RECLAMO_GARANTIA.id AND RECLAMO_GARANTIA_VERSION_JAPON.reclamo_garantia_version_field_desc = ? ','JAPON');
		$q->where('RECLAMO_GARANTIA.reclamo_garantia_orden_compra_id = ?',$this->registro_actual->id); //aprobados
		$q->orderBy('RECLAMO_GARANTIA.id');
		$this->template['reclamos_garantia'] = $q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);




		$this->_view_adjunto(); //muestro archivos adjuntos (si los hay); //definida $this->$upload_adjunto = array();
		$this->_view_image(); //muestro imagenes (si las hay); //definida $this->$upload_image = array();
		$this->load->view('backend/esqueleto_view',$this->template);
	}
	//-------------------------[vista generica]
	//-----------------------------------------------------------------------------

	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------
	//http://codeigniter.com/user_guide/libraries/form_validation.html
	//required|matches[form_item]|min_length[6]|max_length[12]|exact_length[8]|alpha|alpha_numeric|
	//alpha_dash|numeric|integer|is_natural|is_natural_no_zero|valid_email|valid_emails|valid_ip|valid_base64
	//my_unique_db[Modelo.tabla_field_campo '.$id.']
	//mysql_date_to_form my_form_date_reverse
	//my_db_value_exist[Modelo.campo]
	private function _validar_formulario() {
		if($this->registro_actual)
		{
			$id=$this->registro_actual->id;
		}else{
			$id = FALSE;
		}

		$this->form_validation->set_rules('reclamo_garantia_orden_compra_field_desc',$this->marvin->mysql_field_to_human('reclamo_garantia_orden_compra_field_desc'),
				'trim|required|max_length[50]' );

		$this->form_validation->set_rules('reclamo_garantia_orden_compra_field_factura',$this->marvin->mysql_field_to_human('reclamo_garantia_orden_compra_field_factura'),
				'trim|max_length[50]' );


		if(strlen($this->input->post('reclamo_garantia_orden_compra_field_factura'))>1)
		{
			$this->form_validation->set_rules('reclamo_garantia_orden_compra_field_fecha_factura',$this->marvin->mysql_field_to_human('reclamo_garantia_orden_compra_field_fecha_factura'),
				'trim|required|my_form_date_reverse|my_valid_date[y-m-d,-]' );
		}


		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------


	//-------------------------[comunes imagenes y adjuntos]
	public function edit_image( $id_registro = FALSE, $id_imagen= FALSE )
	{
		$rs		= $this->backend->edit_image($id_registro, $id_imagen, $this->input->post('prefix'));
	}


	public function ordenar_imagenes( $id = FALSE ) {

		$rs		= $this->backend->ordenar_imagenes($id,$this->input->post('prefix'));
	}

	public function del_image( $id_registro = FALSE, $id_imagen= FALSE, $subfix = 'image'  )
	{
		$rs		= $this->backend->del_image($id_registro, $id_imagen, 'imagen');
	}


	public function del_adjunto( $id_registro = FALSE, $id_adjunto= FALSE, $subfix = 'adjunto' )
	{
		$rs		= $this->backend->del_adjunto($id_registro, $id_adjunto, $subfix);
	}
		//-------------------------[comunes imagenes y adjuntos]


	private function _send_mail()
	{

		$this->load->config('email');
		$email_config = $this->config->item('email_config');
		$this->load->library('MyMailer');

		$html = file_get_contents(APPPATH . 'views/backend/reclamo_garantia_orden_compra_mail_view.php');

		//tomo todos los datos de la orden de compra
		$q = Doctrine_Query::create();
		$q->from('Reclamo_Garantia_Orden_Compra Reclamo_Garantia_Orden_Compra ');
		$q->leftJoin('Reclamo_Garantia_Orden_Compra.Sucursal Sucursal');
		$q->leftJoin('Sucursal.Sucursal_Servicio Sucursal_Servicio');
		$q->leftJoin('Reclamo_Garantia_Orden_Compra.Many_Reclamo_Garantia Reclamo_Garantia');
		$q->leftJoin('Reclamo_Garantia.Reclamo_Garantia_Version Reclamo_Garantia_Version_Honda ON Reclamo_Garantia_Version_Honda.reclamo_garantia_id = Reclamo_Garantia.id AND Reclamo_Garantia_Version_Honda.reclamo_garantia_version_field_desc = ? ','HONDA');
		$q->leftJoin('Reclamo_Garantia.Admin_Alta Admin_Alta');
		$q->where('Reclamo_Garantia.reclamo_garantia_orden_compra_id = ?',$this->registro_actual->id); //aprobados
		$q->addWhere('Reclamo_Garantia_Orden_Compra.id = ?',$this->registro_actual->id);
		if($q->count()!=1)
		{

			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= 'error tomando orden de compra';
			$this->backend->_log_error($error);
			show_error( $error['error']   );
		}

		$orden_compra = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
	    $importe_aceptado = 0;
		$i = 0;
		$informacion ='';
		reset($orden_compra['Many_Reclamo_Garantia']);
		while (list(,$row) = each($orden_compra['Many_Reclamo_Garantia']))
		{
			$importe_aceptado+= $row['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_valor_reclamado'];
			++$i;
			$bgcolor="#ffffff";
			if($i%2)
				$bgcolor="#eeeeee";

			$informacion.='
					<tr>
						<td bgcolor="'.$bgcolor.'"><strong><font size="2" face="Arial, Helvetica, sans-serif">#'.$row['id'].'</font></strong></td>
						<td bgcolor="'.$bgcolor.'" align="center"><font size="2" face="Arial, Helvetica, sans-serif">'.$row['reclamo_garantia_field_fechahora_alta'].'</font></td>
						<td bgcolor="'.$bgcolor.'" align="right" width="100"><strong><font size="2" face="Arial, Helvetica, sans-serif">AR$</font></strong></td>
						<td bgcolor="'.$bgcolor.'" align="right" width="10"><strong><font size="2" face="Arial, Helvetica, sans-serif">'.$row['Reclamo_Garantia_Version'][0]['reclamo_garantia_version_field_valor_reclamado'].'</font></strong></td>
						<td bgcolor="'.$bgcolor.'" align="center"><font size="2" face="Arial, Helvetica, sans-serif">'.$row['reclamo_garantia_field_fechahora_aprobacion'].'</font></td>
					</tr>
					';


			if($this->form_validation->valid_email($row['Admin_Alta']['admin_field_email']))
			{
				$this->enviar_mail_a[$row['Admin_Alta']['admin_field_email']] = TRUE;
			}

		}

		$html = str_replace('##CONCESIONARIO_NOMBRE##',$orden_compra['Sucursal']['sucursal_field_desc'],$html);
		$html = str_replace('##INFORMACION##',$informacion,$html);
		$html = str_replace('##ORDEN_COMPRA_NUMERO##',$orden_compra['id'],$html);
		$html = str_replace('##ORDEN_COMPRA_SAP##',$orden_compra['reclamo_garantia_orden_compra_field_desc'],$html);
		$html = str_replace('##INFORME_DIA##',date("Y-m-d"),$html);
		$html = str_replace('##IMPORTE_ACEPTADO##',$importe_aceptado,$html);




        //Creamos el mailer pasándole el transport con la configuración
        $mailer = $this->mymailer->getNewInstance();

		$message = Swift_Message::newInstance()
                   ->setSubject("HARWS: Resumen de Aprobación de Garantías #".$orden_compra['id'])
                   ->setFrom($email_config['smtp_user']);

		if($this->form_validation->valid_email($orden_compra['Sucursal']['sucursal_field_email']))
		{
			$this->enviar_mail_a[$orden_compra['Sucursal']['sucursal_field_email']] = TRUE;
		}

		if(isset($orden_compra['Sucursal']['Sucursal_Servicio']) && is_array($orden_compra['Sucursal']['Sucursal_Servicio']))
		{
			foreach($orden_compra['Sucursal']['Sucursal_Servicio'] as $servicio)
			{
				if($this->form_validation->valid_email($servicio['sucursal_servicio_field_email']))
				{
					$this->enviar_mail_a[$servicio['sucursal_servicio_field_email']] = TRUE;
				}
			}
		}

		while(list($k,)=each($this->enviar_mail_a))
		{
			$message->addTo($k);
		}


		$message->setCc(array(
		  'Celeste_Aguero@honda.com.ar',
		  'Gabriel_Saracano@honda.com.ar'
		));


		$message->setBcc(array(
			'log@boxdata.com.ar',
		));


		//$message->addTo('propoleoz@gmail.com');


		$html = str_replace('pie.jpg',$message->embed(Swift_Image::fromPath(APPPATH . 'views/backend/images_mail/pie.jpg')),$html);
		$html = str_replace('fondo.gif',$message->embed(Swift_Image::fromPath(APPPATH . 'views/backend/images_mail/fondo.gif')),$html);
		$html = str_replace('separador.gif',$message->embed(Swift_Image::fromPath(APPPATH . 'views/backend/images_mail/separador.gif')),$html);
		$html = str_replace('cabezal.jpg',$message->embed(Swift_Image::fromPath(APPPATH . 'views/backend/images_mail/cabezal.jpg')),$html);


		$message->setBody($html, 'text/html');

		if (!$mailer->send($message))
		{
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= 'error enviando mail';
			$this->backend->_log_error($error);
			show_error( $error['error']   );
		}
		else
		{
			$this->registro_actual->reclamo_garantia_orden_compra_field_mail_enviado = 1;
			$this->registro_actual->save();
		}


	}


}
