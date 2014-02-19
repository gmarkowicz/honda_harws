<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Tsi_Mailing_Encuesta_Satisfaccion_Estado', 'harws2');

/**
 * BaseTsi_Mailing_Encuesta_Satisfaccion_Estado
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $tsi_mailing_encuesta_satisfaccion_estado_field_desc
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property timestamp $deleted_at
 * @property Doctrine_Collection $Tsi_Mailing_Encuesta_Satisfaccion
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTsi_Mailing_Encuesta_Satisfaccion_Estado extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('tsi_mailing_encuesta_satisfaccion_estado');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('tsi_mailing_encuesta_satisfaccion_estado_field_desc', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '25',
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
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
        $this->hasMany('Tsi_Mailing_Encuesta_Satisfaccion', array(
             'local' => 'id',
             'foreign' => 'tsi_mailing_encuesta_satisfaccion_estado_id'));
    }
}