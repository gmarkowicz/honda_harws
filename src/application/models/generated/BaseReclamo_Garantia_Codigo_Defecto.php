<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Reclamo_Garantia_Codigo_Defecto', 'harws2');

/**
 * BaseReclamo_Garantia_Codigo_Defecto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $id
 * @property string $reclamo_garantia_codigo_defecto_field_desc
 * @property integer $reclamo_garantia_codigo_defecto_seccion_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property timestamp $deleted_at
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReclamo_Garantia_Codigo_Defecto extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('reclamo_garantia_codigo_defecto');
        $this->hasColumn('id', 'string', 5, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '5',
             ));
        $this->hasColumn('reclamo_garantia_codigo_defecto_field_desc', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('reclamo_garantia_codigo_defecto_seccion_id', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('deleted_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '25',
             ));


        $this->index('reclamo_garantia_codigo_defecto_field_desc', array(
             'fields' => 
             array(
              0 => 'reclamo_garantia_codigo_defecto_field_desc',
             ),
             'type' => 'fulltext',
             ));
        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}