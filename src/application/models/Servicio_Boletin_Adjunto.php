<?php

/**
 * Servicio_Boletin_Adjunto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Servicio_Boletin_Adjunto.php 98 2012-08-02 19:31:55Z mprado $
 */
class Servicio_Boletin_Adjunto extends BaseServicio_Boletin_Adjunto
{
    public function setUp() {
	
	$this->actAs('Timestampable');
		
	$this->hasOne('Servicio_Boletin', array(
            'local' => 'servicio_boletin_id',
            'foreign' => 'id'
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