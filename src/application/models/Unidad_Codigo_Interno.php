<?php

/**
 * Unidad_Codigo_Interno
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Unidad_Codigo_Interno.php 97 2012-08-01 21:57:04Z mprado $
 */
class Unidad_Codigo_Interno extends BaseUnidad_Codigo_Interno
{
    public function setUp() { 
	
        $this->actAs('Timestampable');
		
		
	$this->hasMany('Unidad as Many_Unidad', array(
                'refClass' => 'Unidad_M_Unidad_Codigo_interno',
                'local' => 'unidad_codigo_interno_id',
                'foreign' => 'unidad_id'
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