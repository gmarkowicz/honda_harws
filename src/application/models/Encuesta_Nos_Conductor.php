<?php

/**
 * Encuesta_Nos_Conductor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Encuesta_Nos_Conductor.php 120 2012-08-14 16:04:21Z mprado $
 */
class Encuesta_Nos_Conductor extends BaseEncuesta_Nos_Conductor
{
    public function setUp() {
		
		$this->actAs('Timestampable');
		$this->actAs('SoftDelete');
		
		$this->hasMany('Encuesta_Nos', array(
            'local' => 'id',
            'foreign' => 'encuesta_nos_conductor_id',
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