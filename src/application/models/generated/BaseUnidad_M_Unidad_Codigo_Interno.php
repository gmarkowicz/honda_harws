<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Unidad_M_Unidad_Codigo_Interno', 'harws2');

/**
 * BaseUnidad_M_Unidad_Codigo_Interno
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $unidad_id
 * @property integer $unidad_codigo_interno_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUnidad_M_Unidad_Codigo_Interno extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('unidad_m_unidad_codigo_interno');
        $this->hasColumn('unidad_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('unidad_codigo_interno_id', 'integer', 2, array(
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