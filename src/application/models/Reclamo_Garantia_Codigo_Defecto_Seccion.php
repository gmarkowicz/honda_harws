<?php

/**
 * Reclamo_Garantia_Codigo_Defecto_Seccion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Reclamo_Garantia_Codigo_Defecto_Seccion.php 294 2012-10-03 18:45:36Z slopez $
 */
class Reclamo_Garantia_Codigo_Defecto_Seccion extends BaseReclamo_Garantia_Codigo_Defecto_Seccion
{
	
	public function get_all()
	{
		$query = Doctrine_Query::create();
		$query->from(get_class($this));
		$query->where("1 = 1");
		return $query;
	}
	
	
}