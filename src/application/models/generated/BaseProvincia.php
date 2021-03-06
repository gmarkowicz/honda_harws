<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Provincia', 'harws2');

/**
 * BaseProvincia
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $provincia_field_desc
 * @property string $provincia_field_iso_code
 * @property integer $pais_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Doctrine_Collection $Admin
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProvincia extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('provincia');
        $this->hasColumn('id', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '2',
             ));
        $this->hasColumn('provincia_field_desc', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('provincia_field_iso_code', 'string', 4, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('pais_id', 'integer', 2, array(
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


        $this->index('provincia_field_desc', array(
             'fields' => 
             array(
              0 => 'provincia_field_desc',
             ),
             'type' => 'fulltext',
             ));
        $this->index('provincia_field_iso_code', array(
             'fields' => 
             array(
              0 => 'provincia_field_desc',
             ),
             'type' => 'fulltext',
             ));
        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Admin', array(
             'local' => 'id',
             'foreign' => 'provincia_id'));
    }
}