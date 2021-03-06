<?php

/**
 * Lineamiento_Comercial_Adjunto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Lineamiento_Comercial_Adjunto.php 98 2012-08-02 19:31:55Z mprado $
 */
class Lineamiento_Comercial_Adjunto extends BaseLineamiento_Comercial_Adjunto
{
    public function setUp() {
	
	$this->actAs('Timestampable');
		
	$this->hasOne('Lineamiento_Comercial', array(
            'local' => 'lineamiento_comercial_id',
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