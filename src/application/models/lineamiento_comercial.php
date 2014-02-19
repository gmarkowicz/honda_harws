<?php

/**
 * Lineamiento_Comercial
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Lineamiento_Comercial extends BaseLineamiento_Comercial
{
    public function setUp() {

	$this->actAs('Timestampable');

	$this->hasOne('Sucursal', array(
            'local' => 'sucursal_id',
            'foreign' => 'id'
            ));
	
        $this->hasMany('Lineamiento_Comercial_Adjunto', array(
            'local' => 'id',
            'foreign' => 'lineamiento_comercial_id',
            ));
    }


    public function get_all()
    {
	$query = Doctrine_Query::create();
	$query->from(get_class($this) .' LINEAMIENTO_COMERCIAL ');
	$query->where("1 = 1");
	$query->leftJoin('LINEAMIENTO_COMERCIAL.Sucursal SUCURSAL');
	$query->leftJoin('LINEAMIENTO_COMERCIAL.Lineamiento_Comercial_Adjunto LINEAMIENTO_COMERCIAL_ADJUNTO');
	return $query;
    }
}