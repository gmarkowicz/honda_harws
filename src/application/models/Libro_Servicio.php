<?php

/**
 * Libro_Servicio
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Libro_Servicio.php 98 2012-08-02 19:31:55Z mprado $
 */
class Libro_Servicio extends BaseLibro_Servicio
{
    public function setUp() {
		
	$this->actAs('Timestampable');	
		
	$this->hasOne('Libro_Servicio_Estado', array(
            'local' => 'libro_servicio_estado_id',
            'foreign' => 'id'
            ));
		
	$this->hasOne('Unidad', array(
            'local' => 'unidad_id',
            'foreign' => 'id'
            ));
		
	$this->hasOne('Sucursal', array(
            'local' => 'sucursal_id',
            'foreign' => 'id'
            ));
		
	$this->hasOne('Admin as Admin_Alta', array(
            'local' => 'libro_servicio_field_admin_alta_id',
            'foreign' => 'id'
            ));
        
	$this->hasOne('Admin as Admin_Modifica', array(
            'local' => 'libro_servicio_field_admin_modifica_id',
            'foreign' => 'id'
            ));
		
	$this->hasMany('Libro_Servicio_Adjunto', array(
            'local' => 'id',
            'foreign' => 'libro_servicio_id',
            ));		
		
    }

    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) .' LIBRO_SERVICIO ');
        $query->where("1 = 1");

        //--[unidad]
        $query->leftJoin('LIBRO_SERVICIO.Unidad UNIDAD ');
        $query->leftJoin('UNIDAD.Vin_Procedencia_Ktype VP ');
        $query->leftJoin('UNIDAD.Many_Unidad_Codigo_Interno UCI ');
        $query->leftJoin('UNIDAD.Unidad_Color_Interior CI ');
        $query->leftJoin('UNIDAD.Unidad_Color_Exterior CE ');
        $query->leftJoin('UNIDAD.Auto_Transmision AT ');
        $query->leftJoin('UNIDAD.Auto_Anio AA ');
        $query->leftJoin('UNIDAD.Auto_Puerta_Cantidad PC ');
        $query->leftJoin('UNIDAD.Auto_Version AUTO_VERSION ');
        $query->leftJoin('AUTO_VERSION.Auto_Modelo AM ');
        //--[fin unidad]

        $query->leftJoin('LIBRO_SERVICIO.Libro_Servicio_Estado LIBRO_SERVICIO_ESTADO ');
        $query->leftJoin('LIBRO_SERVICIO.Sucursal SUCURSAL ');

        $query->leftJoin('LIBRO_SERVICIO.Admin_Alta AALTA ');
        $query->leftJoin('LIBRO_SERVICIO.Admin_Modifica AMODIFICA ');

        return $query;
    }
	
}