<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Comunicacion_Multimedia_Imagen', 'harws2');

/**
 * BaseComunicacion_Multimedia_Imagen
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $comunicacion_multimedia_imagen_field_archivo
 * @property string $comunicacion_multimedia_imagen_field_extension
 * @property integer $comunicacion_multimedia_imagen_field_orden
 * @property integer $comunicacion_multimedia_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Comunicacion_Multimedia $Comunicacion_Multimedia
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseComunicacion_Multimedia_Imagen extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('comunicacion_multimedia_imagen');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('comunicacion_multimedia_imagen_field_archivo', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('comunicacion_multimedia_imagen_field_extension', 'string', 4, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('comunicacion_multimedia_imagen_field_orden', 'integer', 3, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '3',
             ));
        $this->hasColumn('comunicacion_multimedia_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
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
        $this->hasOne('Comunicacion_Multimedia', array(
             'local' => 'comunicacion_multimedia_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}