<?php

/**
 * Sucursal_Valor_Frt
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Sucursal_Valor_Frt.php 213 2012-09-17 13:36:03Z mprado $
 */
class Sucursal_Valor_Frt extends BaseSucursal_Valor_Frt
{
    public function setUp() {
		
        $this->actAs('Timestampable');
        //$this->actAs('SoftDelete');

        $this->hasOne('Sucursal', array(
            'local' => 'sucursal_id',
            'foreign' => 'id'
        ));


    }
	
    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) .' SUCURSAL_VALOR_FRT ');
        $query->where("1 = 1");
        return $query;
    }

}