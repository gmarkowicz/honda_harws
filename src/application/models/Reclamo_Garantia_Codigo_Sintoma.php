<?php

/**
 * Reclamo_Garantia_Codigo_Sintoma
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Reclamo_Garantia_Codigo_Sintoma.php 295 2012-10-03 18:46:02Z slopez $
 */
class Reclamo_Garantia_Codigo_Sintoma extends BaseReclamo_Garantia_Codigo_Sintoma
{
	
	
	public function setUp() {
		
        $this->actAs('Timestampable');
		
		$this->hasMany('Reclamo_Garantia_Codigo_Sintoma_Seccion as Many_Reclamo_Garantia_Codigo_Sintoma_Seccion', array(
            'refClass' => 'Reclamo_Garantia_Codigo_Sintoma_M_Seccion',
            'local' => 'reclamo_garantia_codigo_sintoma_id',
            'foreign' => 'reclamo_garantia_codigo_sintoma_seccion_id'
            ));
		
    }
	
	
	
	public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) . ' Reclamo_Garantia_Codigo_Sintoma ');
		$query->leftJoin('Reclamo_Garantia_Codigo_Sintoma.Many_Reclamo_Garantia_Codigo_Sintoma_Seccion Many_Reclamo_Garantia_Codigo_Sintoma_Seccion ');
		$query->where("1 = 1");
        return $query;
    }
	
	public function get_desc($id = FALSE)
	{
		$q = Doctrine_Query::create();
		$q->from(get_class($this));
		$q->where('id = ?',$id);
		$resultado = $q->fetchOne();
		if(!$resultado)
		{
			RETURN FALSE;
		}
		else
		{
			RETURN $resultado['reclamo_garantia_codigo_sintoma_field_desc'];
		}
	}
	
	
	
}