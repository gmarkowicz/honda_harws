<?php

/**
 * Auto_Anio
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Auto_Anio.php 97 2012-08-01 21:57:04Z mprado $
 */
class Auto_Anio extends BaseAuto_Anio
{
    public function setUp() {
		
        $this->actAs('Timestampable');
        $this->actAs('SoftDelete');

        $this->hasMany('Unidad', array(
            'local' => 'id',
            'foreign' => 'auto_anio_id'
            ));

        $this->hasMany('Usado', array(
            'local' => 'id',
            'foreign' => 'auto_anio_id'
            ));

        $this->hasMany('Vin_Anio', array(
            'local' => 'id',
            'foreign' => 'auto_anio_id'
            ));
    }

    public function get_all($config = array())
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this));
        $query->where("1 = 1");
        return $query;
    }
}