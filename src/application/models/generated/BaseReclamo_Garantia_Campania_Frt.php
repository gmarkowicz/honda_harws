<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Reclamo_Garantia_Campania_Frt', 'harws2');

/**
 * BaseReclamo_Garantia_Campania_Frt
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $reclamo_garantia_campania_id
 * @property string $frt_id
 * @property string $frt_hora
 * @property enum $frt_requerido
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property timestamp $deleted_at
 * @property Reclamo_Garantia_Campania $Reclamo_Garantia_Campania
 * @property Frt $Frt
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReclamo_Garantia_Campania_Frt extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('reclamo_garantia_campania_frt');
        $this->hasColumn('reclamo_garantia_campania_id', 'string', 4, array(
             'type' => 'string',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('frt_id', 'string', 7, array(
             'type' => 'string',
             'primary' => true,
             'length' => '7',
             ));
        $this->hasColumn('frt_hora', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('frt_requerido', 'enum', 1, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => '0',
              1 => '1',
             ),
             'length' => '1',
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

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Reclamo_Garantia_Campania', array(
             'local' => 'reclamo_garantia_campania_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Frt', array(
             'local' => 'frt_id',
             'foreign' => 'frt_seccion_id',
             'onDelete' => 'CASCADE'));
    }
}