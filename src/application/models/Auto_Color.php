<?php

/**
 * Auto_Color
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Auto_Color.php 97 2012-08-01 21:57:04Z mprado $
 */
class Auto_Color extends BaseAuto_Color
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	$this->hasMany('Usado', array(
            'local' => 'id',
            'foreign' => 'auto_color_id',
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