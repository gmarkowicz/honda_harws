<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Cliente_M_Cliente_Codigo_Interno', 'harws2');

/**
 * BaseCliente_M_Cliente_Codigo_Interno
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $cliente_id
 * @property integer $cliente_codigo_interno_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCliente_M_Cliente_Codigo_Interno extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('cliente_m_cliente_codigo_interno');
        $this->hasColumn('cliente_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('cliente_codigo_interno_id', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => '2',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}