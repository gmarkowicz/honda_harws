<?php

/**
 * Reclamo_Garantia_Trabajo_Tercero
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Reclamo_Garantia_Trabajo_Tercero.php 420 2012-11-15 19:07:38Z slopez $
 */
class Reclamo_Garantia_Trabajo_Tercero extends BaseReclamo_Garantia_Trabajo_Tercero
{
	public function setUp() {
		
		
		$this->hasMany('Reclamo_Garantia_Version_Trabajo_Tercero', array(
            'local' => 'id',
            'foreign' => 'reclamo_garantia_version_trabajo_tercero_id'
        ));
		
		$this->hasOne('Backend_Estado', array(
            'local' => 'backend_estado_id',
            'foreign' => 'id'
        ));
	}
	
	public function get_all()
	{
		$query = Doctrine_Query::create();
		$query->from(get_class($this));
		$query->where("1 = 1");
		return $query;
	}
}