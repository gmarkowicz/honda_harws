<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Reclamo_Garantia_Codigo_Sintoma_M_Seccion', 'harws2');

/**
 * BaseReclamo_Garantia_Codigo_Sintoma_M_Seccion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $reclamo_garantia_codigo_sintoma_id
 * @property integer $reclamo_garantia_codigo_sintoma_seccion_id
 * @property Reclamo_Garantia_Codigo_Sintoma $Reclamo_Garantia_Codigo_Sintoma
 * @property Reclamo_Garantia_Codigo_Sintoma_Seccion $Reclamo_Garantia_Codigo_Sintoma_Seccion
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReclamo_Garantia_Codigo_Sintoma_M_Seccion extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('reclamo_garantia_codigo_sintoma_m_seccion');
        $this->hasColumn('reclamo_garantia_codigo_sintoma_id', 'string', 5, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => '5',
             ));
        $this->hasColumn('reclamo_garantia_codigo_sintoma_seccion_id', 'integer', 2, array(
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
        $this->hasOne('Reclamo_Garantia_Codigo_Sintoma', array(
             'local' => 'reclamo_garantia_codigo_sintoma_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Reclamo_Garantia_Codigo_Sintoma_Seccion', array(
             'local' => 'reclamo_garantia_codigo_sintoma_seccion_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}