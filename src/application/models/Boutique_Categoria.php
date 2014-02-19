<?php

/**
 * Boutique_Categoria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Boutique_Categoria.php 119 2012-08-14 15:55:18Z mprado $
 */
class Boutique_Categoria extends BaseBoutique_Categoria
{
    public function setUp() {

		$this->actAs('Timestampable');
                
         $this->hasOne('Boutique_Categoria_Estado', array(
            'local' => 'boutique_categoria_estado_id',
            'foreign' => 'id',			
            ));

    }

    public function get_all()
    {
        $query = Doctrine_Query::create();		
        $query->from(get_class($this) .' BOUTIQUE_CATEGORIA ');
        $query->where("1 = 1");
        $query->leftJoin('BOUTIQUE_CATEGORIA.Boutique_Categoria_Estado BOUTIQUE_CATEGORIA_ESTADO');				
        return $query;
    }

}