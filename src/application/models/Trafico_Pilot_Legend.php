<?php

/**
 * Trafico_Pilot_Legend
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Trafico_Pilot_Legend.php 98 2012-08-02 19:31:55Z mprado $
 */
class Trafico_Pilot_Legend extends BaseTrafico_Pilot_Legend
{
    public function setUp() {
		
	$this->actAs('Timestampable');
	$this->actAs('SoftDelete');
		
	$this->hasOne('Sucursal', array(
            'local' => 'sucursal_id',
            'foreign' => 'id'
            ));
		
	$this->hasOne('Auto_Modelo as Auto_Modelo_Interes', array(
            'local' => 'auto_modelo_interes_id',
            'foreign' => 'id'
            ));
		
	$this->hasOne('Auto_Modelo as Auto_Modelo_Actual', array(
            'local' => 'auto_modelo_actual_id',
            'foreign' => 'id'
            ));
    	
        $this->hasOne('Backend_Estado', array(
            'local' => 'backend_estado_id',
            'foreign' => 'id'
            ));
		
	$this->hasOne('Admin as Admin_Alta', array(
            'local' => 'trafico_pilot_legend_field_admin_alta_id',
            'foreign' => 'id'
            ));
	
        $this->hasOne('Admin as Admin_Modifica', array(
            'local' => 'trafico_pilot_legend_field_admin_modifica_id',
            'foreign' => 'id'
            ));		
    }
	
    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) . ' TRAFICO_PILOT_LEGEND');
        $query->where("1 = 1");
        $query->leftJoin('TRAFICO_PILOT_LEGEND.Sucursal SUCURSAL ');
        $query->leftJoin('TRAFICO_PILOT_LEGEND.Auto_Modelo_Actual AUTO_MODELO_ACTUAL ');
        $query->leftJoin('AUTO_MODELO_ACTUAL.Auto_Marca AUTO_MARCA_ACTUAL ');
        $query->leftJoin('TRAFICO_PILOT_LEGEND.Auto_Modelo_Interes AUTO_MODELO_INTERES ');
        $query->leftJoin('TRAFICO_PILOT_LEGEND.Backend_Estado BACKEND_ESTADO ');
        $query->leftJoin('TRAFICO_PILOT_LEGEND.Admin_Alta ADMIN_ALTA ');
        $query->leftJoin('TRAFICO_PILOT_LEGEND.Admin_Modifica ADMIN_MODIFICA ');
        return $query;
    }
}