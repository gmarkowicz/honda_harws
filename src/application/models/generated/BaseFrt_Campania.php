<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Frt_Campania', 'harws2');

/**
 * BaseFrt_Campania
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $frt_campamia_field_code
 * @property string $frt_campamia_field_desc
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFrt_Campania extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('frt_campania');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('frt_campamia_field_code', 'string', 3, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '3',
             ));
        $this->hasColumn('frt_campamia_field_desc', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
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


        $this->index('frt_campamia_field_code', array(
             'fields' => 
             array(
              0 => 'frt_campamia_field_code',
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