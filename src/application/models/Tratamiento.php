<?php

/**
 * Tratamiento
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Tratamiento.php 118 2012-08-14 15:48:03Z mprado $
 */
class Tratamiento extends BaseTratamiento
{
    public function setUp() {
		
		$this->actAs('Timestampable');
		$this->actAs('SoftDelete');
		
		$this->hasMany('Cliente_Sucursal', array(
            'local' => 'id',
            'foreign' => 'tratamiento_id',
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