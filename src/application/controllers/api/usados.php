<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/My_REST_Controller.php';

class Usados extends My_REST_Controller
{

	/**
	 * Indica cuantos registros recuperar por página al paginar una consulta
	 * @var unknown
	 */
	private $_max_per_page = 25;

	/**
	 * Formatea y pagina una consulta
	 *
	 * @param Doctrine_Query $query
	 * @param int $page_num
	 * @param int $max_per_page
	 * @return array
	 */
	private function paginate(Doctrine_Query $query, $page_num = null, $max_per_page = null)
	{
		$max_per_page = $max_per_page ? $max_per_page : $this->_max_per_page;
		if ($page_num == null)
		{
			$page_num = $this->get('page') ? $this->get('page') : 1;
			if ($page_num < 1) $page_num = 0; // to avoid problems injecting non valid values
		}

		$total_record_count = $query->count();
		$query->limit($max_per_page);
		$query->offset(($page_num - 1) * $max_per_page);

		$results = $query->fetchArray();
		$record_count = count($results);
		$total_pages = ceil($total_record_count/ $max_per_page);


		return array(
			'records' => $results,
			'record_count' => $record_count,
			'total_record_count' => $total_record_count,
			'total_pages' => $total_pages,
			'page' => $page_num,
		);
	}

	/**
	 *  Aplica los filtros generales
	 *
	 * integer $usado_id filtrar por id de usado, separadas por coma
	 * integer $sucursal filtrar por id de sucursales que contengan autos usados, separadas por coma
	 * integer $version listar solo los elementos que contengan autos de las id de versiones indicadas, separadas por coma
	 * integer $modelo listar solo los elementos que contengan autos de los id de modelos indicados, separados por coma
	 * integer $marca listar solo los elementos que contengan autos de la marca indicada. Valores posibles: 1 = Honda, 2 = Otros, sin indicar es indistinto
	 * integer $combustible listar solo los elementos que contengan autos de id de tipo de combustible, separadas por coma
	 * integer $transmision listar solo los elementos que contengan autos de id de tipo de transmision, separadas por coma
	 * integer $puertas listar solo los elementos que contengan autos de con id de puertas, separadas por coma
	 * integer $anio_desde listar solo los elementos que contengan autos del año en adelante
	 * integer $anio_hasta listar solo los elementos que contengan autos hasta el año
	 * integer $km_desde listar solo los elementos que contengan autos con KM igual o mayor
	 * integer $km_hasta listar solo los elementos que contengan autos con KM igual o menor
	 *
	 * @param Doctrine_Query $query
	 * @return Doctrine_Query
	 *
	 */
	private function applyFilters(Doctrine_Query $query)
	{

		$query->where('Usado.backend_estado_id = 2');
		$query->addWhere('Usado.usado_tipo_venta_id = ?',0);

		// filtro obligatorio para restringir los resultados a solo las sucursales que el usuario puede acceder
		$query->andWhereIn('Sucursal.id', $this->_sucursal_id);

		if($this->get('usado_id'))
		{
			$usado_id = preg_split('/,/', $this->get('usado_id'));
			$query->andWhereIn('Usado.id', $usado_id);
		}

		if($this->get('sucursal'))
		{
			$sucursales = preg_split('/,/', $this->get('sucursal'));
			$query->andWhereIn('Sucursal.id', $sucursales);
		}


		if($this->get('version'))
		{
			$versiones = preg_split('/,/', $this->get('version'));
			$query->andWhereIn('Auto_Version.id', $versiones);
		}

		if($this->get('modelo'))
		{
			$modelos = preg_split('/,/', $this->get('modelo'));
			$query->andWhereIn('Auto_Modelo.id', $modelos);
		}

		if ($this->get('marca'))
		{
			if ($this->get('marca') == 1)
			{
				$query->addWhere('Auto_Marca.id = 100');
			} else if ($this->get('marca') == 2)
			{
				$query->addWhere('Auto_Marca.id <> 100');
			}
		}

		if($this->get('combustible'))
		{
			$combustible = preg_split('/,/', $this->get('combustible'));
			$query->andWhereIn('Auto_Combustible.id', $combustible);
		}

		if($this->get('transmision'))
		{
			$transmision = preg_split('/,/', $this->get('transmision'));
			$query->andWhereIn('Auto_Transmision.id', $transmision);
		}

		if($this->get('puertas'))
		{
			$puertas = preg_split('/,/', $this->get('puertas'));
			$query->andWhereIn('Auto_Puerta_Cantidad.id', $puertas);
		}

		if($this->get('anio_desde'))
		{
			$query->andWhere('Auto_Anio.auto_anio_field_desc >= ?', (int) $this->get('anio_desde'));
		}

		if($this->get('anio_hasta'))
		{
			$query->andWhere('Auto_Anio.auto_anio_field_desc <= ?', (int) $this->get('anio_hasta'));
		}

		if($this->get('km_desde'))
		{
			$query->andWhere('Usado.usado_field_kilometros >= ?', (int) $this->get('km_desde'));
		}

		if($this->get('km_hasta'))
		{
			$query->andWhere('Usado.usado_field_kilometros <= ?', (int) $this->get('km_hasta'));
		}

		return $query;
	}

    /**
     *  Obtiene un listado de sucursales que poseen usados registrados
     *  @see Usados::applyFilters para detalle de filtros adicionales
     *
     */
    public function sucursal_get()
    {

        $query = Doctrine_Query::create()
			->addSelect('Sucursal.id, Sucursal.sucursal_field_desc as name, count(CASE WHEN Usado.id > 0 THEN 1 END) as usado_count')
            ->from('Sucursal Sucursal')
            ->leftJoin('Sucursal.Usado Usado')
            ->leftJoin('Usado.Unidad Unidad')
            ->leftJoin('Usado.Auto_Version Auto_Version')
            ->leftJoin('Auto_Version.Auto_Modelo Auto_Modelo')
            ->leftJoin('Auto_Modelo.Auto_Marca Auto_Marca')
            ->leftJoin('Unidad.Auto_Combustible Auto_Combustible')
            ->leftJoin('Unidad.Auto_Transmision Auto_Transmision')
            ->leftJoin('Unidad.Auto_Puerta_Cantidad Auto_Puerta_Cantidad')
            ->leftJoin('Usado.Auto_Anio Auto_Anio')
            ->groupBy('Sucursal.id')
            ->having('usado_count > 0')
        	->orderBy('name');
		$query = $this->applyFilters($query);

        $this->response(array('sucursal' => $this->paginate($query)), 200); // 200 being the HTTP response code
    }

    /**
     *  Obtiene un listado de versiones de usados disponibles
     *  @see Usados::applyFilters para detalle de filtros adicionales
     */
    public function version_get()
    {
        $query = Doctrine_Query::create()
			->addSelect('Auto_Version.id, Auto_Version.auto_version_field_desc as name, count(CASE WHEN Usado.id > 0 THEN 1 END) as usado_count')
            ->from('Auto_Version Auto_Version')
            ->leftJoin('Auto_Version.Usado Usado')
            ->leftJoin('Usado.Sucursal Sucursal')
            ->leftJoin('Usado.Unidad Unidad')
            ->leftJoin('Auto_Version.Auto_Modelo Auto_Modelo')
            ->leftJoin('Auto_Modelo.Auto_Marca Auto_Marca')
            ->leftJoin('Unidad.Auto_Combustible Auto_Combustible')
            ->leftJoin('Unidad.Auto_Transmision Auto_Transmision')
            ->leftJoin('Unidad.Auto_Puerta_Cantidad Auto_Puerta_Cantidad')
            ->leftJoin('Usado.Auto_Anio Auto_Anio')
            ->groupBy('Auto_Version.id')
            ->having('usado_count > 0')
        	->orderBy('name');
		$query = $this->applyFilters($query);

        $this->response(array('version' => $this->paginate($query)), 200); // 200 being the HTTP response code
    }

    /**
     *  Obtiene un listado de modelos de usados disponibles
     *  @see Usados::applyFilters para detalle de filtros adicionales
     */
    public function modelo_get()
    {
    	$query = Doctrine_Query::create()
	    	->addSelect('Auto_Modelo.id, Auto_Modelo.auto_modelo_field_desc as name, count(CASE WHEN Usado.id > 0 THEN 1 END) as usado_count')
	    	->from('Auto_Modelo Auto_Modelo')
	    	->leftJoin('Auto_Modelo.Auto_Version Auto_Version')
	    	->leftJoin('Auto_Version.Usado Usado')
	    	->leftJoin('Usado.Sucursal Sucursal')
	    	->leftJoin('Usado.Unidad Unidad')
	    	->leftJoin('Auto_Modelo.Auto_Marca Auto_Marca')
	    	->leftJoin('Unidad.Auto_Combustible Auto_Combustible')
	    	->leftJoin('Unidad.Auto_Transmision Auto_Transmision')
	    	->leftJoin('Unidad.Auto_Puerta_Cantidad Auto_Puerta_Cantidad')
	    	->leftJoin('Usado.Auto_Anio Auto_Anio')
	    	->groupBy('Auto_Modelo.id')
	    	->having('usado_count > 0')
	    	->orderBy('name');
    	$query = $this->applyFilters($query);

    	$this->response(array('modelo' => $this->paginate($query)), 200); // 200 being the HTTP response code
    }

    /**
     *  Obtiene un listado de marcas de usados disponibles
     *  @see Usados::applyFilters para detalle de filtros adicionales
     */
    public function marca_get()
    {
    	$query = Doctrine_Query::create()
	    	->addSelect('Auto_Marca.id, Auto_Marca.auto_marca_field_desc as name, count(CASE WHEN Usado.id > 0 THEN 1 END) as usado_count')
	    	->from("Auto_Marca Auto_Marca")
	    	->leftJoin('Auto_Marca.Auto_Modelo Auto_Modelo ON Auto_Modelo.auto_marca_id = Auto_Marca.id')
	    	->leftJoin('Auto_Modelo.Auto_Version Auto_Version')
	    	->leftJoin('Auto_Version.Usado Usado')
	    	->leftJoin('Usado.Sucursal Sucursal')
	    	->leftJoin('Usado.Unidad Unidad')
	    	->leftJoin('Unidad.Auto_Combustible Auto_Combustible')
	    	->leftJoin('Unidad.Auto_Transmision Auto_Transmision')
	    	->leftJoin('Unidad.Auto_Puerta_Cantidad Auto_Puerta_Cantidad')
	    	->leftJoin('Usado.Auto_Anio Auto_Anio')
	    	->groupBy('Auto_Marca.id')
	    	->having('usado_count > 0')
	    	->orderBy('name');
    	$query = $this->applyFilters($query);

    	$this->response(array('marca' => $this->paginate($query)), 200); // 200 being the HTTP response code
    }


     /**
     *  Obtiene un listado de cantidades de puertas de usados disponibles
     *  @see Usados::applyFilters para detalle de filtros adicionales
     */
    public function puertas_get()
    {
        $query = Doctrine_Query::create()
			->addSelect('Auto_Puerta_Cantidad.id, Auto_Puerta_Cantidad.auto_puerta_cantidad_field_desc as name, count(CASE WHEN Usado.id > 0 THEN 1 END) as usado_count')
            ->from('Auto_Puerta_Cantidad Auto_Puerta_Cantidad')
            ->leftJoin('Auto_Puerta_Cantidad.Unidad Unidad ON Auto_Puerta_Cantidad.id = Unidad.auto_puerta_cantidad_id')
            ->leftJoin('Unidad.Usado Usado ON Unidad.id = Usado.unidad_id')
            ->leftJoin('Usado.Sucursal Sucursal')
            ->leftJoin('Usado.Auto_Version Auto_Version')
            ->leftJoin('Auto_Version.Auto_Modelo Auto_Modelo')
            ->leftJoin('Auto_Modelo.Auto_Marca Auto_Marca')
            ->leftJoin('Unidad.Auto_Combustible Auto_Combustible')
            ->leftJoin('Unidad.Auto_Transmision Auto_Transmision')
            ->leftJoin('Usado.Auto_Anio Auto_Anio')
            ->groupBy('Auto_Puerta_Cantidad.id')
            ->having('usado_count > 0')
        	->orderBy('name');
		$query = $this->applyFilters($query);

    	$this->response(array('puertas' => $this->paginate($query)), 200); // 200 being the HTTP response code
    }

    /**
     *  Obtiene un listado de tipos de transmisión de usados disponibles
     *  @see Usados::applyFilters para detalle de filtros adicionales
     */
    public function transmision_get()
    {
        $query = Doctrine_Query::create()
			->addSelect('Auto_Transmision.id, Auto_Transmision.auto_transmision_field_desc as name, count(CASE WHEN Usado.id > 0 THEN 1 END) as usado_count')
            ->from('Auto_Transmision Auto_Transmision')
            ->leftJoin('Auto_Transmision.Unidad Unidad ON Unidad.auto_transmision_id = Auto_Transmision.id')
            ->leftJoin('Unidad.Usado Usado ON Unidad.id = Usado.unidad_id')
            ->leftJoin('Usado.Sucursal Sucursal')
            ->leftJoin('Usado.Auto_Version Auto_Version')
            ->leftJoin('Auto_Version.Auto_Modelo Auto_Modelo')
            ->leftJoin('Auto_Modelo.Auto_Marca Auto_Marca')
            ->leftJoin('Unidad.Auto_Combustible Auto_Combustible')
            ->leftJoin('Unidad.Auto_Puerta_Cantidad Auto_Puerta_Cantidad')
            ->leftJoin('Usado.Auto_Anio Auto_Anio')
            ->groupBy('Auto_Transmision.id')
            ->having('usado_count > 0')
        	->orderBy('name');
		$query = $this->applyFilters($query);

        $this->response(array('transmision' => $this->paginate($query)), 200); // 200 being the HTTP response code
    }

    /**
     *  Obtiene un listado de tipos de transmisión de usados disponibles
     *  @see Usados::applyFilters para detalle de filtros adicionales
     */
    public function combustible_get()
    {
    	$query = Doctrine_Query::create()
			->addSelect('Auto_Combustible.id, Auto_Combustible.auto_combustible_field_desc as name, count(CASE WHEN Usado.id > 0 THEN 1 END) as usado_count')
            ->from('Auto_Combustible Auto_Combustible')
            ->leftJoin('Auto_Combustible.Unidad Unidad ON Unidad.auto_combustible_id = Auto_Combustible.id')
            ->leftJoin('Unidad.Usado Usado ON Unidad.id = Usado.unidad_id')
            ->leftJoin('Usado.Sucursal Sucursal')
            ->leftJoin('Usado.Auto_Version Auto_Version')
            ->leftJoin('Auto_Version.Auto_Modelo Auto_Modelo')
            ->leftJoin('Auto_Modelo.Auto_Marca Auto_Marca')
            ->leftJoin('Unidad.Auto_Transmision Auto_Transmision')
            ->leftJoin('Unidad.Auto_Puerta_Cantidad Auto_Puerta_Cantidad')
            ->leftJoin('Usado.Auto_Anio Auto_Anio')
            ->groupBy('Auto_Combustible.id')
            ->having('usado_count > 0')
        	->orderBy('name');
		$query = $this->applyFilters($query);

        $this->response(array('combustible' => $this->paginate($query)), 200); // 200 being the HTTP response code
    }

   /**
    *  Obtiene las unidades que contienen la tabla usados.
	*  @see Usados::applyFilters para detalle de filtros adicionales
    *
    */
    public function usado_get()
    {
    	$this->load->config('imagen/usado_imagen');
    	$image_path = $this->config->item('base_url') . str_replace(FCPATH,'',$this->config->item('image_path'));

        $query = Doctrine_Query::create()
			->addSelect('
					Usado.id,
					Auto_Anio.auto_anio_field_desc as anio,
					Usado.usado_field_kilometros as kilometros,
					Usado.usado_field_precio_venta as precio_venta,
					Moneda_Venta.moneda_field_desc as moneda_name,
					Auto_Marca.auto_marca_field_desc as marca_name,
					Auto_Modelo.auto_modelo_field_desc as modelo_name,
					Auto_Version.auto_version_field_desc as version_name,
					Auto_Color.auto_color_field_desc as color_name,
					Auto_Color.auto_color_field_hexadecimal as color_hexadecimal,
					Auto_Puerta_Cantidad.auto_puerta_cantidad_field_desc as puertas_name,
					Auto_Combustible.auto_combustible_field_desc as combustible_name,
					Auto_Transmision.auto_transmision_field_desc as transmision_name,
					Usado.usado_field_comentarios as comentarios,
					Usado_Imagen.usado_imagen_field_archivo,
					Usado_Imagen.usado_imagen_field_extension,
					Sucursal.id as sucursal_id,
					Sucursal.sucursal_field_desc as sucursal_name
						')
            ->from('Usado Usado')
            ->leftJoin('Usado.Unidad Unidad')
            ->leftJoin('Usado.Sucursal Sucursal')
            ->leftJoin('Usado.Auto_Version Auto_Version')
            ->leftJoin('Usado.Moneda_Venta Moneda_Venta ON Moneda_Venta.id = Usado.moneda_precio_venta_id')
            ->leftJoin('Usado.Auto_Color Auto_Color')
            ->leftJoin('Auto_Version.Auto_Modelo Auto_Modelo')
            ->leftJoin('Auto_Modelo.Auto_Marca Auto_Marca')
            ->leftJoin('Unidad.Auto_Combustible Auto_Combustible')
            ->leftJoin('Unidad.Auto_Transmision Auto_Transmision')
            ->leftJoin('Unidad.Auto_Puerta_Cantidad Auto_Puerta_Cantidad')
            ->leftJoin('Usado.Auto_Anio Auto_Anio')
            ->leftJoin('Usado.Usado_Imagen Usado_Imagen')
         	->orderBy('Usado.id, Usado_Imagen.usado_imagen_field_orden');
		$query = $this->applyFilters($query);

        $this->response(array('usado' => $this->paginate($query),'images_base_url'=>$image_path), 200); // 200 being the HTTP response code
    }


}

?>