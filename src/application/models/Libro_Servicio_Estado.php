<?php

/**
 * Libro_Servicio_Estado
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Libro_Servicio_Estado.php 98 2012-08-02 19:31:55Z mprado $
 */
class Libro_Servicio_Estado extends BaseLibro_Servicio_Estado
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	$this->hasMany('Libro_Servicio', array(
            'local' => 'id',
            'foreign' => 'libro_servicio_estado_id',
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