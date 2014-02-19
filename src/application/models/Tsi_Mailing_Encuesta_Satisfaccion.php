<?php

/**
 * Tsi_Mailing_Encuesta_Satisfaccion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Tsi_Mailing_Encuesta_Satisfaccion extends BaseTsi_Mailing_Encuesta_Satisfaccion
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	$this->hasOne('Tsi_Mailing_Encuesta_Satisfaccion_Estado', array(
            'local' => 'tsi_mailing_encuesta_satisfaccion_estado_id',
            'foreign' => 'id'
        ));
    }
    
    public function get_all()
    {
        $query = Doctrine_Query::create();		
        $query->from(get_class($this) .' TSI_MAILING_ENCUESTA ');
        $query->where("1 = 1");
        $query->leftJoin('TSI_MAILING_ENCUESTA.Tsi_Mailing_Encuesta_Satisfaccion_Estado TSI_MAILING_ENCUESTA_ESTADO');				
        return $query;
    }
}