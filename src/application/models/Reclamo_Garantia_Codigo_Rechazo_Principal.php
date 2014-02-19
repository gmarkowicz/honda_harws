<?php

/**
 * Reclamo_Garantia_Codigo_Rechazo_Principal
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Reclamo_Garantia_Codigo_Rechazo_Principal.php 98 2012-08-02 19:31:55Z mprado $
 */
class Reclamo_Garantia_Codigo_Rechazo_Principal extends BaseReclamo_Garantia_Codigo_Rechazo_Principal
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	$this->hasMany('Reclamo_Garantia', array(
            'local' => 'id',
            'foreign' => 'reclamo_garantia_codigo_rechazo_principal_id',
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