<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Reclamo_Garantia_Version_Adjunto_Rth', 'harws2');

/**
 * BaseReclamo_Garantia_Version_Adjunto_Rth
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $reclamo_garantia_version_adjunto_rth_field_archivo
 * @property string $reclamo_garantia_version_adjunto_rth_field_extension
 * @property integer $reclamo_garantia_version_adjunto_rth_field_orden
 * @property string $reclamo_garantia_version_adjunto_rth_field_titulo
 * @property string $reclamo_garantia_version_adjunto_rth_field_copete
 * @property integer $reclamo_garantia_version_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReclamo_Garantia_Version_Adjunto_Rth extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('reclamo_garantia_version_adjunto_rth');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('reclamo_garantia_version_adjunto_rth_field_archivo', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('reclamo_garantia_version_adjunto_rth_field_extension', 'string', 4, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '4',
             ));
        $this->hasColumn('reclamo_garantia_version_adjunto_rth_field_orden', 'integer', 3, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '3',
             ));
        $this->hasColumn('reclamo_garantia_version_adjunto_rth_field_titulo', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('reclamo_garantia_version_adjunto_rth_field_copete', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
        $this->hasColumn('reclamo_garantia_version_id', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '8',
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
        
    }
}