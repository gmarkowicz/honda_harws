<?php

/**
 * Auto_Modelo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Auto_Modelo.php 174 2012-08-30 01:07:28Z agusquiroga $
 */
class Auto_Modelo extends BaseAuto_Modelo
{
    public function setUp() {
		
        $this->actAs('Timestampable');
        $this->actAs('SoftDelete');

        $this->hasOne('Auto_Marca', array(
            'local' => 'auto_marca_id',
            'foreign' => 'id'
            ));
		
        $this->hasMany('Auto_Version', array(
            'local' => 'id',
            'foreign' => 'auto_modelo_id'
            ));		
		
	$this->hasMany('Vin_Modelo', array(
            'local' => 'id',
            'foreign' => 'auto_modelo_id'
            ));
		
	$this->hasMany('Servicio_Boletin', array(
            'local' => 'id',
            'foreign' => 'auto_modelo_id'
            ));
		
	$this->hasMany('Trafico_Pilot_Legend', array(
            'local' => 'id',
            'foreign' => 'auto_modelo_interes_id'
            ));
		
	$this->hasMany('Trafico_Pilot_Legend', array(
            'local' => 'id',
            'foreign' => 'auto_modelo_actual_id'
            ));	
    }
	
    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) .' AUTO_MODELO ');
        $query->leftJoin('AUTO_MODELO.Auto_Marca AUTO_MARCA ');
        $query->where("1 = 1");
        return $query;
    }
}