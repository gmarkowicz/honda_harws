<?php

/**
 * Encuesta_Nos_Edad
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Encuesta_Nos_Edad.php 120 2012-08-14 16:04:21Z mprado $
 */
class Encuesta_Nos_Edad extends BaseEncuesta_Nos_Edad
{
    public function setUp() {
		
		$this->actAs('Timestampable');
		$this->actAs('SoftDelete');
		
		$this->hasMany('Encuesta_Nos', array(
            'local' => 'id',
            'foreign' => 'encuesta_nos_edad_id',
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