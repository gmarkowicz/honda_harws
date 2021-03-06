<?php
/**
 * Admin
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Admin.php 174 2012-08-30 01:07:28Z agusquiroga $
 */
class Admin extends BaseAdmin
{
    public function setUp() {
        $this->actAs('Timestampable');
        $this->actAs('SoftDelete');


        $this->hasMany('Sucursal as Many_Sucursal', array(
            'refClass' => 'Admin_M_Sucursal',
            'local' => 'admin_id',
            'foreign' => 'sucursal_id'
            ));

        $this->hasMany('Admin_Puesto as Many_Admin_Puesto', array(
            'refClass' => 'Admin_M_Admin_Puesto',
            'local' => 'admin_id',
            'foreign' => 'admin_puesto_id'
            ));

        $this->hasMany('Admin_Departamento as Many_Admin_Departamento', array(
            'refClass' => 'Admin_M_Admin_Departamento',
            'local' => 'admin_id',
            'foreign' => 'admin_departamento_id'
            ));

        $this->hasMany('Grupo as Many_Grupo', array(
            'refClass' => 'Admin_M_Grupo',
            'local' => 'admin_id',
            'foreign' => 'grupo_id'
            ));

	$this->hasOne('Sucursal', array(
            'local' => 'sucursal_id',
            'foreign' => 'id'
            ));
			
	$this->hasOne('Provincia', array(
            'local' => 'provincia_id',
            'foreign' => 'id'
            ));
	
	$this->hasOne('Ciudad', array(
            'local' => 'ciudad_id',
            'foreign' => 'id'
            ));
	
	
	$this->hasOne('Admin_Estado', array(
            'local' => 'admin_estado_id',
            'foreign' => 'id'
            ));

	$this->hasMany('Tarjeta_Garantia as Tarjeta_Alta', array(
            'local' => 'id',
            'foreign' => 'tarjeta_garantia_field_admin_alta_id'
            ));
		
        $this->hasMany('Tarjeta_Garantia as Tarjeta_Modifica', array(
            'local' => 'id',
            'foreign' => 'tarjeta_garantia_field_admin_modifica_id'
            ));
        
	$this->hasMany('Tarjeta_Garantia as Admin_Vende', array(
            'local' => 'id',
            'foreign' => 'tarjeta_garantia_field_admin_vende_id'
            ));

        $this->hasMany('Tarjeta_Garantia as Tarjeta_Garantia_Rechaza', array(
            'local' => 'id',
            'foreign' => 'tarjeta_garantia_field_admin_rechaza_id'
            ));

        $this->hasMany('Tsi as Tsi_Alta', array(
            'local' => 'id',
            'foreign' => 'tsi_field_admin_alta_id'
            ));
        
	$this->hasMany('Tsi as Tsi_Modifica', array(
            'local' => 'id',
            'foreign' => 'tsi_field_admin_modifica_id'
            ));
        
	$this->hasMany('Tsi as Tsi_Rechaza', array(
            'local' => 'id',
            'foreign' => 'tsi_field_admin_rechaza_id'
            ));

	$this->hasMany('Libro_Servicio as Libro_Servicio_Alta', array(
            'local' => 'id',
            'foreign' => 'libro_servicio_field_admin_alta_id'
            ));
        
	$this->hasMany('Libro_Servicio as Libro_Servicio_Modifica', array(
            'local' => 'id',
            'foreign' => 'libro_servicio_field_admin_modifica_id'
            ));

	$this->hasMany('Tsi as Admin_Recepcionista', array(
            'local' => 'id',
            'foreign' => 'tsi_field_admin_recepcionista_id'
            ));
        
	$this->hasMany('Tsi as Admin_Tecnico', array(
            'local' => 'id',
            'foreign' => 'tsi_field_admin_tecnico_id'
            ));
		
        $this->hasMany('Trafico_Pilot_Legend as Trafico_Pilot_Legend_Alta', array(
            'local' => 'id',
            'foreign' => 'trafico_pilot_legend_field_admin_alta_id'
            ));
		
        $this->hasMany('Trafico_Pilot_Legend as Trafico_Pilot_Legend_Modifica', array(
            'local' => 'id',
            'foreign' => 'trafico_pilot_legend_field_admin_modifica_id'
            ));
		
        $this->hasMany('Reclamo_Garantia as Reclamo_Garantia_Alta', array(
            'local' => 'id',
            'foreign' => 'reclamo_garantia_field_admin_alta_id'
            ));
		
        $this->hasMany('Reclamo_Garantia as Reclamo_Garantia_Modifica', array(
            'local' => 'id',
            'foreign' => 'reclamo_garantia_field_admin_modifica_id'
            ));
		
        $this->hasMany('Reclamo_Garantia as Reclamo_Garantia_Rechaza', array(
            'local' => 'id',
            'foreign' => 'reclamo_garantia_field_admin_rechaza_id'
            ));
		
        $this->hasMany('Reclamo_Garantia as Reclamo_Garantia_Admin_Pre_Aprueba', array(
            'local' => 'id',
            'foreign' => 'reclamo_garantia_field_admin_pre_aprueba_id'
            ));
        
    }

    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) .' A ');
        $query->where("1 = 1");

        $query->leftJoin('A.Admin_Estado AE ');
        $query->leftJoin('A.Sucursal S ');

        $query->leftJoin('A.Many_Admin_Puesto MAP ');
        $query->leftJoin('A.Many_Admin_Departamento MAD ');
        $query->leftJoin('A.Many_Grupo MG ');
		$query->leftJoin('A.Provincia Provincia ');
		$query->leftJoin('A.Ciudad Ciudad ');
        return $query;
    }


    //devuelvo todos los administradores que estan en el puesto vendedores
    public function get_vendedores( $config=array() )
    {
        $query= $this->get_all();
        $query->addWhere('admin_puesto_id = ?',26);
        $query->orderBy('admin_field_nombre ASC');
        $query->addOrderBy('admin_field_apellido ASC');

        return $query;

    }

    //devuelvo todos los administradores que estan en el puesto recepcionistas
	//Asesor de Servicio de servicio en TSI
    public function get_recepcionistas( $config=array() )
    {
            $query= $this->get_all();
            $query->whereIn('admin_puesto_id',array(30,42,29));
            $query->groupBy('id');
			$query->orderBy('admin_field_nombre ASC');
            $query->addOrderBy('admin_field_apellido ASC');

            return $query;

    }

    //devuelvo todos los administradores que estan en el puesto tecnicos
    public function get_tecnicos( $config=array() )
    {
            $query= $this->get_all();
            $query->whereIn('admin_puesto_id',array(37,34,41,30,42,35,43,29,16));
            $query->groupBy('id');
            $query->orderBy('admin_field_nombre ASC');
            $query->addOrderBy('admin_field_apellido ASC');

            return $query;

    }

}