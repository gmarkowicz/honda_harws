<?php
define('ID_SECCION',6011);

class Boutique_Detalle_Main extends Backend_Controller {
		
	//filtra por sucursal?
	var $sucursal = FALSE;
	
	//modelo doctrine con el cual laburamos
	var $model = 'Boutique_Producto';
		
	//columnas por las que se puede ordenar la data //List of all fields that can be sortable
	var $default_valid_fields = array(
	
		//solo para filtrar
		'_buscador_general'=>
			array(
				'sql_filter'	=>array(
										
										'MATCH( 
												boutique_producto_field_desc
										) against (? IN BOOLEAN MODE)'
										
										), //definir campos a buscar
				 'grid'			=>FALSE,
				 'width'		=>FALSE,
				 'sorteable'	=>FALSE,
				 'align'		=>FALSE,
				 'export'		=>FALSE,
				 'download'  	=>FALSE,
				 'print'  		=>FALSE,
				 'rules'		=>FALSE,
				 
			),
			//solo para filtrar
	
	

			//Columnas a mostrar en el grid		
			
			'boutique_producto_field_name'=>
			array(
				 'sql_filter'	=>FALSE,
				 'grid'			=>TRUE,
				 'width'		=>200,
				 'sorteable'	=>TRUE,
				 'align'		=>'left',
				 'export'		=>TRUE,
				 'download'  	=>FALSE,
				 'print'  		=>TRUE,
				 'rules'		=>'grid|sorteable|export|print|align[left]|width[200]|print|',
				 
			),
			
			'boutique_categoria_field_desc'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'			=>120,
					'sorteable'		=>TRUE,
					'align'			=>'left',
					'export'		=>TRUE,
					'download'  	=>FALSE,
					'print'  		=>TRUE,
					'rules'			=>'grid|sorteable|export|print|align[left]|width[200]|print|',
			
			),				
			
			'boutique_producto_field_desc'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'			=>380,
					'sorteable'		=>TRUE,
					'align'			=>'left',
					'export'		=>TRUE,
					'download'  	=>FALSE,
					'print'  		=>TRUE,
					'rules'			=>'grid|sorteable|export|print|align[left]|width[300]|print|',
						
			),
		);
			
			
	function Boutique_Detalle_Main()
	{
		parent::Backend_Controller();
	}
	
	
	function __construct()
	{
		parent::Backend_Controller();
	
		//$this->load->config('imagen/' . $this->model . '_producto_imagen');
		$this->template['image_path'] = str_replace(FCPATH,'',$this->config->item('image_path'));
	}
	


	function index()
	{		
		
		$producto = array();
		
		$query = Doctrine_Query::create();
		$query->from(' Boutique_Producto BOUTIQUE_PRODUCTO ');		
		
		//Joins Disponibildiad
		$query->leftJoin("BOUTIQUE_PRODUCTO.Boutique_Disponibilidad BOUTIQUE_DISPONIBILIDAD ");
		
		//Join Categoria
		$query->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Categoria MBCa");
		
		//Join Color
		$query->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Color MBCo");
		
		//Join Talle
		$query->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Talle MBT");
		//Join Imagenes
		$query->leftJoin("BOUTIQUE_PRODUCTO.Boutique_Producto_Imagen BOUTIQUE_PRODUCTO_IMAGEN");
		
		//$query->whereIn("BOUTIQUE_PRODUCTO");
		
		
		
		
		if($this->input->get('cat'))
		{
			$query->where("boutique_categoria_id = " . (int)$this->input->get('cat'));
		}
		
			
		$query->orderBy('id DESC');
		$query->limit(5);		
		
		$result = $query->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		
		foreach ($result as $row)
		{
			$producto[] = $row;	
		}
		
		
		$this->template['producto_array'] = $producto;
		$this->_view();
		
	}



	

	private function _view()
	{		

		//$this->output->enable_profiler();		
		
		//------------ [select / checkbox / radio categoria_id] :(
		$categoria_producto = new Boutique_Categoria();
		$q = $categoria_producto->get_all();
		$config=array();
		$config['fields'] = array('boutique_categoria_field_desc');
		$config['select'] = FALSE;
		$this->template['boutique_categoria_id']=$this->_create_html_options($q, $config);		
		
		//------------ [fin select / checkbox / radio sucursal_id]		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_boutique_view',$this->template);
		//print_r ($this->template);
		
		//-------------------------[/vista generica]
	}

}
