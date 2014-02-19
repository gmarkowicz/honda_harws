<?php
define('ID_SECCION',6011);

class Boutique_Main extends Backend_Controller {
		
	//filtra por sucursal?
	var $sucursal = FALSE;
	
	//modelo doctrine con el cual laburamos
	var $model = 'Boutique_Producto';
	
	var $producto = false;
	
	public $query;
		
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

			'boutique_producto_disponibilidad_field_desc'=>
			array(
					'sql_filter'	=>FALSE,
					'grid'			=>TRUE,
					'width'			=>70,
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
			
			
	function Boutique_Main()
	{
		parent::Backend_Controller();
	}
	
	
	function __construct()
	{
		parent::Backend_Controller();
	
		$this->load->config('imagen/' . strtolower($this->model) . '_producto_imagen');
		$this->template['image_path'] = str_replace(FCPATH,'',$this->config->item('image_path'));
		
	}
	


	function index()
	{		
		
		$this->query_sql = Doctrine_Query::create();
		$this->query_sql->from(' Boutique_Producto BOUTIQUE_PRODUCTO ');		
		
		//Joins Disponibildiad
		$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Boutique_Disponibilidad MBD ");
		
		 //Joins Admin
                $this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Admin BOUTIQUE_PRODUCTO_ADMIN ");
                
		//Join Categoria
		$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Categoria MBCa");
		
		//Join Color
		$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Color MBCo");
		
		//Join Talle
		$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Talle MBT");
		
                //Join Imagenes
		$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Boutique_Producto_Imagen BOUTIQUE_PRODUCTO_IMAGEN");
		
		//$query->whereIn("BOUTIQUE_PRODUCTO");		
		
		
		if($this->input->get('cat'))
		{
                    $this->query_sql->where("boutique_categoria_id = " . (int)$this->input->get('cat'));
		}
                
                $this->query_sql->addWhere("boutique_producto_estado_id = 1");
                
                $this->query_sql->addWhere("admin_estado_id = 2");		
			
		$this->query_sql->orderBy('id DESC');
		$this->query_sql->limit(5);		
		
		
		
		$this->template['tpl_include'] = $this->get_template_view();
		
		$this->_view();
		
	}
	
	
	function view($id = false)
	{
		if ($id)
		{
			$this->query_sql = Doctrine_Query::create();
			$this->query_sql->from(' Boutique_Producto BOUTIQUE_PRODUCTO ');
                        
                         //Joins Admin
                        $this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Admin BOUTIQUE_PRODUCTO_ADMIN ");                
			
			//Joins Disponibildiad
			$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Boutique_Disponibilidad BOUTIQUE_DISPONIBILIDAD ");
			
			//Join Categoria
			$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Categoria MBCa");
			
			//Join Color
			$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Color MBCo");
			
			//Join Talle
			$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Many_Boutique_Talle MBT");
			//Join Imagenes
			$this->query_sql->leftJoin("BOUTIQUE_PRODUCTO.Boutique_Producto_Imagen BOUTIQUE_PRODUCTO_IMAGEN");
			
			//$query->whereIn("BOUTIQUE_PRODUCTO");		
			
			
			$this->query_sql->where("id = " . (int)$id);
                        
                        $this->query_sql->addWhere("admin_estado_id = 2");

			$this->query_sql->orderBy('id DESC');
	
			$this->query_sql->limit(1);			
			
			$this->template['tpl_include'] = 'backend/boutique_detalle_main_view';
			$this->_view();		
		}			
	
	}
	
	public function pedido()
	{
		
		if($this->cart->total_items() > 0)
		{			
			$color_producto = new Boutique_Color();
			$color = $color_producto->get_all()->execute(array(),Doctrine_core::HYDRATE_ARRAY);
			
			$talle_productos = new Boutique_Talle();
			$talles = $talle_productos->get_all()->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
			
			$this->template['talles_list'] = $talles;
			$this->template['color_list'] = $color;
                        
                        // Sucursales Disiponibles para seleccionar
                        $sucursal=new Sucursal();
                        $q = $sucursal->get_all();
                        $q->WhereIn(' id ', $this->session->userdata('sucursales'));
                        $config=array();
                        $config['fields'] = array('sucursal_field_desc');
                        $config['select'] = FALSE;
                        
                        $this->template['sucursales_disponibles']=$this->_create_html_options($q, $config);                      
                        
			$this->template['tpl_include'] = "backend/boutique_detalle_pedido_view";
			
			$this->load->view('backend/esqueleto_boutique_view',$this->template);
		}
		else{
			redirect('concesionario/boutique_main/');
		}
		
	}
	
	
	private function _view()
	{		

		$producto = array();
		
		$result = $this->query_sql->execute(array(),Doctrine_Core::HYDRATE_ARRAY);		
		 
		foreach ($result as $row)
		{
			$producto[] = $row;
		}			
		
		$this->template['producto_array'] = $producto;		
		
		$this->load->view('backend/esqueleto_boutique_view',$this->template);		
		//-------------------------[/vista generica]
	}

}
