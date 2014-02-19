<?php

/**
 * Comunicacion_Multimedia
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Comunicacion_Multimedia.php 610 2013-01-15 06:43:25Z agusquiroga $
 */
class Comunicacion_Multimedia extends BaseComunicacion_Multimedia
{

	public function setUp()
	{
		parent::setUp();
		$this->hasOne('Publicidad_Producto', array(
				'local' => 'comunicacion_producto_id',
				'foreign' => 'id'));
	}

	public function get_all()
	{
		$query = Doctrine_Query::create();
		$query->from(get_class($this));
		$query->where("1 = 1");
		$query->leftJoin("Comunicacion_Multimedia.Publicidad_Producto Publicidad_Producto ");
		$query->leftJoin("Comunicacion_Multimedia.Comunicacion_Multimedia_Tipo Comunicacion_Multimedia_Tipo ");
		return $query;
	}

}