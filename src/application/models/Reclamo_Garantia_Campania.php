<?php

/**
 * Reclamo_Garantia_Campania
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Reclamo_Garantia_Campania.php 240 2012-09-19 17:06:37Z mprado $
 */
class Reclamo_Garantia_Campania extends BaseReclamo_Garantia_Campania
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	/*$this->hasMany('Reclamo_Garantia', array(
            'local' => 'id',
            'foreign' => 'reclamo_garantia_campania_id',
            ));*/
    }

    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this));
        $query->where("1 = 1");
        return $query;
    }
}