<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Boutique_Producto_M_Talle', 'harws2');

/**
 * BaseBoutique_Producto_M_Talle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $boutique_producto_id
 * @property integer $boutique_talle_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBoutique_Producto_M_Talle extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('boutique_producto_m_talle');
        $this->hasColumn('boutique_producto_id', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => '8',
             ));
        $this->hasColumn('boutique_talle_id', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => '8',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}