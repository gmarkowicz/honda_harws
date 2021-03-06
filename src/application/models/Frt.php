<?php

/**
 * Frt
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Frt.php 290 2012-10-03 18:43:44Z slopez $
 */
class Frt extends BaseFrt
{
	public function setUp() {
		
        $this->actAs('Timestampable');
		
		$this->hasOne('Frt_Seccion', array(
            'local' => 'frt_seccion_id',
            'foreign' => 'id'
		));
        
    }
	
    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) . ' Frt ');
		$query->where("1 = 1");
        return $query;
    }
}