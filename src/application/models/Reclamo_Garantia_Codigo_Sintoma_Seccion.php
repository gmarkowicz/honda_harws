<?php

/**
 * Reclamo_Garantia_Codigo_Sintoma_Seccion
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Reclamo_Garantia_Codigo_Sintoma_Seccion.php 318 2012-10-17 17:58:59Z agusquiroga $
 */
class Reclamo_Garantia_Codigo_Sintoma_Seccion extends BaseReclamo_Garantia_Codigo_Sintoma_Seccion
{
	public function setUp() {

		$this->actAs('Timestampable');
		$this->actAs('SoftDelete');

		$this->hasOne('Reclamo_Garantia_Codigo_Sintoma_Seccion', array(
            'local' => 'reclamo_garantia_codigo_sintoma_seccion_field_padre_id',
            'foreign' => 'id'
        ));

		$this->hasMany('Reclamo_Garantia_Codigo_Sintoma', array(
            'local' => 'id',
            'foreign' => 'reclamo_garantia_codigo_sintoma_seccion_id',
            )
        );
	}

	public function get_all()
	{
		$query = Doctrine_Query::create();
		$query->from(get_class($this));
		$query->where("1 = 1");
		return $query;
	}
}