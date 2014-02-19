<?php

/**
 * Tarjeta_Garantia_M_Cliente
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Tarjeta_Garantia_M_Cliente.php 97 2012-08-01 21:57:04Z mprado $
 */
class Tarjeta_Garantia_M_Cliente extends BaseTarjeta_Garantia_M_Cliente
{
    public function setUp() {
		
		
	$this->hasOne('Tarjeta_Garantia', array(
                'local' => 'tarjeta_garantia_id',
                'foreign' => 'id',
		'onDelete' => 'CASCADE'
            ));
        
        $this->hasOne('Cliente', array(
                'local' => 'cliente_id',
                'foreign' => 'id',
		'onDelete' => 'CASCADE'
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