<?php

/**
 * Vin_Fabrica
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Vin_Fabrica.php 97 2012-08-01 21:57:04Z mprado $
 */
class Vin_Fabrica extends BaseVin_Fabrica
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	$this->hasOne('Auto_Fabrica', array(
            'local' => 'auto_fabrica_id',
            'foreign' => 'id'
            ));
    }
	
    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) . ' F ');
        $query->where("1 = 1");

        $query->leftJoin('F.Auto_Fabrica AF ');

        return $query;
    }
}