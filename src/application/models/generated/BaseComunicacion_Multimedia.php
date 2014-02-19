<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Comunicacion_Multimedia', 'harws2');

/**
 * BaseComunicacion_Multimedia
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $comunicacion_multimedia_tipo_id
 * @property integer $comunicacion_producto_id
 * @property string $comunicacion_multimedia_field_desc
 * @property timestamp $comunicacion_multimedia_field_fechahora_alta
 * @property integer $comunicacion_multimedia_field_admin_alta_id
 * @property timestamp $comunicacion_multimedia_field_fechahora_modificacion
 * @property integer $comunicacion_multimedia_field_admin_modifica_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Admin $Admin
 * @property Comunicacion_Multimedia_Tipo $Comunicacion_Multimedia_Tipo
 * @property Doctrine_Collection $Comunicacion_Multimedia_Imagen
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseComunicacion_Multimedia extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('comunicacion_multimedia');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('comunicacion_multimedia_tipo_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('comunicacion_producto_id', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '2',
             ));
        $this->hasColumn('comunicacion_multimedia_field_desc', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('comunicacion_multimedia_field_fechahora_alta', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('comunicacion_multimedia_field_admin_alta_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('comunicacion_multimedia_field_fechahora_modificacion', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('comunicacion_multimedia_field_admin_modifica_id', 'integer', 4, array(
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


        $this->index('comunicacion_multimedia_field_desc', array(
             'fields' => 
             array(
              0 => 'comunicacion_multimedia_field_desc',
             ),
             'type' => 'fulltext',
             ));
        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Admin', array(
             'local' => 'comunicacion_multimedia_field_admin_modifica_id',
             'foreign' => 'id'));

        $this->hasOne('Comunicacion_Multimedia_Tipo', array(
             'local' => 'comunicacion_multimedia_tipo_id',
             'foreign' => 'id'));

        $this->hasMany('Comunicacion_Multimedia_Imagen', array(
             'local' => 'id',
             'foreign' => 'comunicacion_multimedia_id'));
    }
}