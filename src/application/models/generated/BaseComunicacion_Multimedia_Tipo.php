<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Comunicacion_Multimedia_Tipo', 'harws2');

/**
 * BaseComunicacion_Multimedia_Tipo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $comunicacion_multimedia_tipo_field_desc
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Doctrine_Collection $Comunicacion_Multimedia
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseComunicacion_Multimedia_Tipo extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('comunicacion_multimedia_tipo');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('comunicacion_multimedia_tipo_field_desc', 'string', 255, array(
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

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Comunicacion_Multimedia', array(
             'local' => 'id',
             'foreign' => 'comunicacion_multimedia_tipo_id'));
    }
}