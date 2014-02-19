<?php
/*
TODO
ojo, aca hay un bug, no esta validando sucursal id
*/
define('ID_SECCION',6013);
class Boutique_Producto_Abm extends Backend_Controller{

	//objeto actual de doctrine
	var $registro_actual = FALSE;

	//filtra por sucursal?
	//var $sucursal = FALSE;

	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;

	//subfix de archivos adjuntos
	//var $upload_adjunto = array('adjunto');

	//subfix de imagenes adjuntas
	var $upload_image = array('imagen');

	function __construct()
	{
		parent::Backend_Controller();

		$this->load->config('imagen/' . strtolower($this->model) . '_imagen');
		$this->template['image_path'] = str_replace(FCPATH,'',$this->config->item('image_path'));
	}

	//----------------------------------------------------------------
	//-------------------------[crea un registro a partir de post ]
	public function add()
	{
		if($this->input->post('_submit'))
		{

			if ($this->_validar_formulario() == TRUE)
			{
				//piso _this_registro_actual
				$this->registro_actual = new Boutique_Producto();
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

			//$this->registro_actual->save();

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
	private function _mostrar_registro_actual()
	{
		//paranoid (por las dudas vio)
		$_POST = array();
		if($this->registro_actual)
		{
			$registro_array = $this->registro_actual->toArray();
			$this->form_validation->set_defaults($registro_array);


			//Categoria
			$categoria_array=array();
			foreach($this->registro_actual->Many_Boutique_Categoria as $relacion) {
				$categoria_array[]=$relacion->id;
			}
			$this->form_validation->set_defaults(array('many_boutique_categoria[]'=>$categoria_array));

			//Color
			$color_array=array();
			foreach($this->registro_actual->Many_Boutique_Color as $relacion) {
				$color_array[]=$relacion->id;
			}
			$this->form_validation->set_defaults(array('many_boutique_color[]'=>$color_array));

			//Talle
			$talle_array=array();
			foreach($this->registro_actual->Many_Boutique_Talle as $relacion) {
				$talle_array[]=$relacion->id;
			}
			$this->form_validation->set_defaults(array('many_boutique_talle[]'=>$talle_array));

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

	private function _grabar_registro_actual()
	{
		try
		{
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();


			/* esta preparando los datos que se van a guardar del post en la base Boutique Productos*/
			$this->registro_actual->admin_id                      = $this->session->userdata('admin_id');;
			$this->registro_actual->boutique_producto_field_name  = $this->input->post('boutique_producto_field_name');
			$this->registro_actual->boutique_producto_field_price = $this->input->post('boutique_producto_field_price');
			$this->registro_actual->boutique_disponibilidad_id    = $this->input->post('boutique_disponibilidad_id');
			$this->registro_actual->boutique_producto_estado_id   = $this->input->post('boutique_producto_estado_id');
            $this->registro_actual->boutique_producto_field_desc  = $this->input->post('boutique_producto_field_desc');


			/* Quito las clases referenciadas por el alias*/
			$this->registro_actual->unlink('Many_Boutique_Categoria');
			$this->registro_actual->unlink('Many_Boutique_Color');
			$this->registro_actual->unlink('Many_Boutique_Talle');

			$this->registro_actual->save();


			// Inserta los checked a la tabla boutique_producto_m_categoria
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_boutique_categoria')))
			{
				foreach($this->input->post('many_boutique_categoria') as $categoria_id) {
					$relacion=new Boutique_Producto_M_Categoria();
					$relacion->boutique_categoria_id = (int)$categoria_id;
					$relacion->boutique_producto_id = $this->registro_actual->id;
					$relacion->save();
				}
			}

			// Inserta los checked a la tabla boutique_producto_m_color
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_boutique_color')))
			{
				foreach($this->input->post('many_boutique_color') as $color_id) {
					$relacion=new Boutique_Producto_M_Color();
					$relacion->boutique_color_id = (int)$color_id;
					$relacion->boutique_producto_id = $this->registro_actual->id;
					$relacion->save();
				}
			}

			// Inserta los checked a la tabla boutique_producto_m_talle
			if($this->registro_actual!=FALSE && is_array($this->input->post('many_boutique_talle')))
			{
				foreach($this->input->post('many_boutique_talle') as $talle_id) {
					$relacion=new Boutique_Producto_M_Talle();
					$relacion->boutique_talle_id = (int)$talle_id;
					$relacion->boutique_producto_id = $this->registro_actual->id;
					$relacion->save();
				}
			}

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


		$this->backend->upload_images();

	}
	//-------------------------[graba registro en la base de datos]
	//----------------------------------------------------------------

	//-----------------------------------------------------------------------------
	//-------------------------[vista generica abm]
	private function _view()
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

		//------------ [select / checkbox / radio disponibilidad_id] :(
		$disponibilidad_producto = new Boutique_Disponibilidad();
		$q = $disponibilidad_producto->get_all();
		$config=array();
		$config['fields'] = array('boutique_disponibilidad_field_desc');
		$config['select'] = FALSE;
		$this->template['boutique_disponibilidad_id']=$this->_create_html_options($q, $config);


                //------------ [select / checkbox / radio disponibilidad_id] :(
		$estado_producto = new Boutique_Producto_Estado();
		$q = $estado_producto->get_all();
		$config=array();
		$config['fields'] = array('boutique_producto_estado_field_desc');
		$config['select'] = FALSE;
		$this->template['boutique_producto_estado_id']=$this->_create_html_options($q, $config);


		//------------ [select / checkbox / radio categoria_id] :(
		$categoria_producto = new Boutique_Categoria();
		$q = $categoria_producto->get_all();
		$config=array();
		$config['fields'] = array('boutique_categoria_field_desc');
		$config['select'] = FALSE;
		$this->template['many_boutique_categoria']=$this->_create_html_options($q, $config);

		//------------ [select / checkbox / radio color_id] :(
		$color_producto = new Boutique_Color();
		$q = $color_producto->get_all();
		$config=array();
		$config['fields'] = array('boutique_color_field_desc');
		$config['select'] = FALSE;
		$this->template['many_boutique_color']=$this->_create_html_options($q, $config);

		//------------ [select / checkbox / radio talle_id] :(
		$talle_producto = new Boutique_Talle();
		$q = $talle_producto->get_all();
		$config=array();
		$config['fields'] = array('boutique_talle_field_desc');
		$config['select'] = FALSE;
		$this->template['many_boutique_talle']=$this->_create_html_options($q, $config);


		$this->template['CKEDITOR'] = TRUE; //habilitamos editor html

		//$this->_view_adjunto(); //muestro archivos adjuntos (si los hay); //definida $this->$upload_adjunto = array();
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

		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));

		$this->form_validation->set_rules('boutique_producto_field_name',           $this->marvin->mysql_field_to_human('boutique_producto_field_name')         ,'trim|max_length[255]|required' );
		$this->form_validation->set_rules('boutique_disponibilidad_id',             $this->marvin->mysql_field_to_human('boutique_disponibilidad_id')           ,'trim|max_length[3]|required' );
		$this->form_validation->set_rules('boutique_producto_field_price',          $this->marvin->mysql_field_to_human('boutique_producto_field_price')        ,'trim|max_length[12]|required' );
		$this->form_validation->set_rules('boutique_producto_field_desc',           $this->marvin->mysql_field_to_human('boutique_producto_field_desc')         ,'trim|max_length[50000]|required' );

		/*$this->form_validation->set_rules('sucursal_id',$this->marvin->mysql_field_to_human('sucursal_id'),
				'trim' );*/


		return $this->form_validation->run();
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------


	//-------------------------[comunes imagenes y adjuntos]
	/*public function edit_image( $id_registro = FALSE, $id_imagen= FALSE )
	{
		$rs		= $this->backend->edit_image($id_registro, $id_imagen, $this->input->post('prefix'));
	}


	public function ordenar_imagenes( $id = FALSE ) {

		$rs		= $this->backend->ordenar_imagenes($id,$this->input->post('prefix'));
	}*/

	public function del_image( $id_registro = FALSE, $id_imagen= FALSE, $subfix = 'image'  )
	{
		$rs	= $this->backend->del_image($id_registro, $id_imagen, 'imagen');
	}


	/*public function del_adjunto( $id_registro = FALSE, $subfix = 'adjunto' )
	{

		$query = Doctrine_Query::create();
		$query->from(' UPLOAD_FILE_ADJUNTO ');
		$query->where( " upload_file_id = " . $id_registro);
		$result = $query->execute();
		foreach ($result as $row)
		{

			$rs = $this->backend->del_adjunto($id_registro, $row['id'], $subfix);

		}

	}*/
		//-------------------------[comunes imagenes y adjuntos]


}
