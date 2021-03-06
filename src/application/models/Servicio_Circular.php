<?php

/**
 * Servicio_Circular
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Servicio_Circular.php 98 2012-08-02 19:31:55Z mprado $
 */
class Servicio_Circular extends BaseServicio_Circular
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	$this->hasOne('Servicio_Circular_Categoria', array(
            'local' => 'servicio_circular_categoria_id',
            'foreign' => 'id'
            ));
		
	$this->hasMany('Servicio_Circular_Adjunto', array(
            'local' => 'id',
            'foreign' => 'servicio_circular_id',
            ));		
    }

    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) .' SERVICIO_CIRCULAR ');
        $query->leftJoin('SERVICIO_CIRCULAR.Servicio_Circular_Categoria SERVICIO_CIRCULAR_CATEGORIA ');
        $query->leftJoin('SERVICIO_CIRCULAR.Servicio_Circular_Adjunto SERVICIO_CIRCULAR_ADJUNTO ');
        $query->where("1 = 1");
        return $query;
    }
}