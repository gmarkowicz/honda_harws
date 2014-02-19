<?php

class Actualiza_Estado_Garantia extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
    }  
	
	
	/*
		pasa a vencida las unidades con mas de 3 años
		(este dato sale de la tarjeta de garantia)
	*/
	
    public function actualizar_por_tarjeta()
    {   
		
		$sql =
		'
		UPDATE unidad SET 
		unidad_field_fecha_garantia_vencida = DATE_ADD(unidad_field_fecha_entrega,INTERVAL "3" YEAR),
		unidad_estado_garantia_id = 2
		WHERE (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), unidad_field_fecha_entrega)), "%Y")+0>2)
		AND unidad_estado_garantia_id = 1
		';
		
		$statement = Doctrine_Manager::getInstance()->connection();  
		$statement->execute($sql);  
		
		
	}
	
	/*
		pasa a vencida las unidades con mas de 100k kilometros
	*/
	
	 public function actualizar_por_tsi()
	 {
		$sql=
		"
		UPDATE unidad U
		LEFT JOIN tsi T ON T.unidad_id = U.id
		,(SELECT unidad_id, min(tsi_field_fecha_de_egreso) AS fecha_anulacion FROM tsi WHERE tsi_field_kilometros>=100000 AND tsi_estado_id = 2 GROUP BY unidad_id) T2 
		SET 
		U.unidad_field_fecha_garantia_vencida = T.tsi_field_fecha_de_egreso,
		U.unidad_estado_garantia_id = 2
		
		WHERE 
		T.unidad_id = T2.unidad_id AND T.tsi_field_fecha_de_egreso = T2.fecha_anulacion
		AND T.tsi_estado_id = 2
		AND U.unidad_estado_garantia_id = 1
		";
		$statement = Doctrine_Manager::getInstance()->connection();  
		$statement->execute($sql);  
	 }
	

}
?>    