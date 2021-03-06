<?php

/**
 * Unidad_Color_Exterior
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Unidad_Color_Exterior.php 691 2013-01-25 18:51:20Z slopez $
 */
class Unidad_Color_Exterior extends BaseUnidad_Color_Exterior
{
    public function setUp() { 
	
        $this->actAs('Timestampable');

		
	$this->hasMany('Unidad', array(
            'local' => 'id',
            'foreign' => 'unidad_color_exterior_id',
            ));
		
    }	

    public function get_all($activos = false)
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) . ' C ');

        if(true === $activos)
        {
                $query->leftJoin('C.Unidad U');
        }

        $query->where("1 = 1");

        if(true === $activos)
        {
                $query->addWhere('U.id != ?', false); //modelo honda
        }

        return $query;
    }
	
}