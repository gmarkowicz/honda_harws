<?php

/**
 * Publicidad_Medida
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Publicidad_Medida.php 98 2012-08-02 19:31:55Z mprado $
 */
class Publicidad_Medida extends BasePublicidad_Medida
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	$this->hasMany('Publicidad', array(
            'local' => 'id',
            'foreign' => 'publicidad_medida_id',
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