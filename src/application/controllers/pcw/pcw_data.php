<?php

class Pcw_Data extends CI_Controller{
    
    var $salto = "\r\n";
	
	
	function __construct()
    {               
            parent::__construct();
    }  
	
	
	public function index()
	{
		
		//no tenes query Gorosito
		$q = Doctrine_Query::create();
        //http://www.doctrine-project.org/jira/browse/DC-585
		$q->select('Reclamo_Garantia.id'); 																									#1
		$q->addSelect("DATE_FORMAT(Reclamo_Garantia.reclamo_garantia_field_fechahora_aprobacion, '01/%m/%Y') AS AppMonth");					#2
		$q->addSelect("Sucursal.id AS DealerNo");																							#3
		$q->addSelect("Sucursal.sucursal_field_desc AS DealerName");																		#4
		$q->addSelect("DATE_FORMAT(Unidad.unidad_field_fecha_entrega, '%d/%m/%Y') AS RegistDate ");											#5
		$q->addSelect("DATE_FORMAT(Tsi.tsi_field_fecha_rotura, '%d/%m/%Y') AS RepOrderDate ");												#6
		$q->addSelect("DATE_FORMAT(Tsi.tsi_field_fecha_de_egreso, '%d/%m/%Y') AS RepCompDate ");											#7
		$q->addSelect("Tsi.tsi_field_kilometros_rotura AS Mileage");																		#8
		$q->addSelect("Reclamo_Garantia_Version_Japon.reclamo_garantia_codigo_sintoma_id AS Symptom");										#9
		$q->addSelect("Reclamo_Garantia_Version_Japon.reclamo_garantia_codigo_defecto_id AS Defect");										#10
		$q->addSelect("Reclamo_Garantia.reclamo_garantia_campania_id AS Campaign");															#11
		$q->addSelect("SUBSTRING(Unidad.unidad_field_vin,4,5) AS ModelCode");																#12
		$q->addSelect("Unidad.unidad_field_vin AS VIN");																					#13
		$q->addSelect("SUBSTRING(Unidad.unidad_field_motor,1,5) AS EngineType");															#14
		$q->addSelect("SUBSTRING(Unidad.unidad_field_motor,6) AS EngineNo");																#15
		$q->addSelect("SUBSTRING(Unidad.unidad_field_vin,1,3) AS Destination");																#16
		$q->addSelect("Reclamo_Garantia_Version_Japon.reclamo_garantia_version_field_descripcion_sintoma AS CustomContDesc");				#17
		$q->addSelect("Reclamo_Garantia_Version_Japon.reclamo_garantia_version_field_descripcion_tratamiento AS RepairContDesc");			#18
		$q->addSelect("REPLACE(Reclamo_Garantia.reclamo_garantia_field_valor_hora_japon, '.',',') AS LaborUnitPrice");						#19
		$q->addSelect("Reclamo_Garantia_Material_Principal.material_id AS FailedPartNo");													#20
		$q->addSelect("REPLACE(Reclamo_Garantia_Version_Japon.reclamo_garantia_version_field_valor_reclamado, '.',',') AS TotalAmount");	#21	
		$q->addSelect("Reclamo_Garantia.reclamo_garantia_field_valor_alca AS PLCARate");													#22
		$q->addSelect("Reclamo_Garantia_Version_Japon.reclamo_garantia_dtc_estado_id AS MIL");												#23
		$q->addSelect("Reclamo_Garantia.reclamo_garantia_field_valor_dolar	AS aux_valor_dolar");											#24
		$q->addSelect("Reclamo_Garantia_Version_Japon.reclamo_garantia_version_field_dtc_codigo AS DTC");									#25
		$q->addSelect("DATE_FORMAT(Reclamo_Garantia.reclamo_garantia_field_fechahora_aprobacion, '%m') AS MesReclamo");						#26
		
		$q->from('Reclamo_Garantia Reclamo_Garantia');
		$q->leftJoin('Reclamo_Garantia.Reclamo_Garantia_Version Reclamo_Garantia_Version_Japon ON Reclamo_Garantia_Version_Japon.reclamo_garantia_id = Reclamo_Garantia.id AND Reclamo_Garantia_Version_Japon.reclamo_garantia_version_field_desc = "JAPON"');
		$q->leftJoin('Reclamo_Garantia_Version_Japon.Reclamo_Garantia_Material_Principal Reclamo_Garantia_Material_Principal ON Reclamo_Garantia_Version_Japon.id = Reclamo_Garantia_Material_Principal.reclamo_garantia_version_id AND Reclamo_Garantia_Material_Principal.reclamo_garantia_material_field_material_principal = 1');
		$q->leftJoin('Reclamo_Garantia.Tsi Tsi');
		$q->leftJoin('Tsi.Sucursal Sucursal');
		$q->leftJoin('Tsi.Unidad Unidad');
		
		$q->where('Reclamo_Garantia.reclamo_garantia_field_pcw != ?',1);
		$q->addWhere('Reclamo_Garantia_Version_Japon.id IS NOT NULL');
		$q->whereIn('Reclamo_Garantia.reclamo_garantia_estado_id', array(2,3) );
		//$q->addWhere('Reclamo_Garantia.id = ?',39584);
		//$q->addWhere('Reclamo_Garantia.id = ?',38062);
		
		
		$q->groupBy('Reclamo_Garantia.id');
		$q->orderBy('Reclamo_Garantia.reclamo_garantia_field_fechahora_pre_aprobacion ASC');
		$q->limit(20);
		
		//-----------------------------
		//comienzo archivo
		//access sucks 
		echo " " .$this->salto;
		//-----------------------------
		$r=$q->execute(array(), Doctrine::HYDRATE_ARRAY);
		
		
		
		foreach($r as $row)
		{
			echo "R*";
			$row['PLCARate'] = $this->plca( $row['PLCARate'] );
			$row['MIL'] = $this->dtc( $row['MIL']	);
			$row['FailedPartNo'] = str_replace('-','',$row['FailedPartNo']);
			//parche cambio de pieza campania a japon 17 mayo 2012
			if($row['Campaign'] == '5TZ' && $row['FailedPartNo'] == '37820R42A59')
			{
				$row['FailedPartNo'] = '37820R40K14';
			}
			
			foreach($row as $valor)
			{
				echo $this->san($valor) . '*';
			}
			echo $this->salto;
			
			
			//-------------------[frts]
			
			$sql="SELECT	
					reclamo_garantia.id,																		
					reclamo_garantia_frt.frt_id AS LaborNo,														
					REPLACE(reclamo_garantia_frt.reclamo_garantia_frt_field_frt_horas, '.',',') AS FRT			
					FROM reclamo_garantia
					LEFT JOIN reclamo_garantia_version ON reclamo_garantia_version.reclamo_garantia_id = reclamo_garantia.id
					LEFT JOIN reclamo_garantia_frt ON reclamo_garantia_version.id = reclamo_garantia_frt.reclamo_garantia_version_id
					WHERE reclamo_garantia.id = '". $row['id'] ."' AND 
					reclamo_garantia_version.reclamo_garantia_version_field_desc='JAPON' AND
					reclamo_garantia_frt.frt_id IS NOT NULL
					GROUP BY reclamo_garantia_frt.frt_id
					";
			$pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array());

			$r_frt = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$serial = 0;
			foreach($r_frt as $row_frt)
			{
				echo "F*";
				foreach($row_frt as $valorFrt)
				{
					echo $this->san($valorFrt) . '*';
				}
				echo ++$serial . '*'; //#4
				echo $this->salto;			
			}
			
			
			
			
			//-------------------[frts]
			
			
			//-------------------[repuestos]
			
			/*
			$sql="SELECT	
					R.id_reclamo AS Claim, 							#1
					R.material AS PartNo,							#2
					M.detalle AS PartName,							#3
					REPLACE(R.precio, '.',',') AS UnitPrice,		#4
					REPLACE(R.cantidad, '.',',') AS Quantity		#5
					
					FROM cms_reclamo_garantia_material R
					LEFT JOIN cms_sp4w_materiales M
					ON R.material = M.material
					WHERE id_reclamo = '". $row['id_reclamo']."' AND tipo_ingreso='3'
					ORDER BY material_principal DESC
						
			";
			*/
			
			$sql = "SELECT
				reclamo_garantia.id AS Claim,							 											#1
				reclamo_garantia_material.material_id AS PartNo,													#2
				material.material_field_desc AS PartName,															#3
				REPLACE(reclamo_garantia_material.reclamo_garantia_material_field_precio, '.',',') AS UnitPrice,	#4
				REPLACE(reclamo_garantia_material.reclamo_garantia_material_field_cantidad, '.',',') AS Quantity	#5
				
				FROM reclamo_garantia
				LEFT JOIN reclamo_garantia_version ON reclamo_garantia_version.reclamo_garantia_id = reclamo_garantia.id
				LEFT JOIN reclamo_garantia_material ON reclamo_garantia_version.id = reclamo_garantia_material.reclamo_garantia_version_id
				LEFT JOIN material ON reclamo_garantia_material.material_id = material.id
				
				WHERE 
				reclamo_garantia.id = '". $row['id'] ."' AND 
				reclamo_garantia_version.reclamo_garantia_version_field_desc='JAPON' AND
				reclamo_garantia_material.material_id IS NOT NULL
				
				GROUP BY reclamo_garantia_material.material_id
				
				ORDER BY reclamo_garantia_material_field_material_principal DESC
			";
			
			
			$pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array());
			$r_material = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$serial = 0;
			
			
			
			
			foreach($r_material as $rowM)
			{
				
				
				
				//parche cambio de pieza campania a japon 17 mayo 2012
				$rowM['PartNo'] = str_replace('-','',$rowM['PartNo']);
				if($row['Campaign'] == '5TZ' && $rowM['PartNo'] == '37820R42A59')
				{
					$rowM['PartNo'] = '37820R40K14';
				}

				
				echo "M*";
				
				foreach($rowM as $valorM)
				{	
					echo $this->san($valorM) . '*';
				}
				echo ++$serial . '*'; //#6
				echo $this->salto;			
			}
			//-------------------[repuestos]
		
		
		
		
			//-------------------[trabajo de terceros]
			/*
			$sql="SELECT	
						T.id_reclamo AS Claim,						#1
						T.id_trabajo_tercero AS Sublet,				#2
						T.importe AS Amount							#3					
						FROM cms_reclamo_garantia_trabajo T
						WHERE T.id_reclamo = '". $row['id_reclamo']."' AND T.tipo_ingreso='3'";
			*/
			
			
			$sql = "SELECT
					reclamo_garantia.id AS Claim,							 													#1
					reclamo_garantia_version_trabajo_tercero.reclamo_garantia_trabajo_tercero_id AS Sublet,						#2									#2
					reclamo_garantia_version_trabajo_tercero.reclamo_garantia_version_trabajo_tercero_field_importe AS Amount 	#3														#3
					
					
					FROM reclamo_garantia
					LEFT JOIN reclamo_garantia_version ON reclamo_garantia_version.reclamo_garantia_id = reclamo_garantia.id
					LEFT JOIN reclamo_garantia_version_trabajo_tercero ON reclamo_garantia_version.id = reclamo_garantia_version_trabajo_tercero.reclamo_garantia_version_id
					
					WHERE 
					reclamo_garantia.id = '". $row['id'] ."' AND 
					reclamo_garantia_version.reclamo_garantia_version_field_desc='JAPON' AND
					reclamo_garantia_version_trabajo_tercero.id IS NOT NULL
					
					GROUP BY reclamo_garantia_version_trabajo_tercero.id
				";
				
			$pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array());
			$serial = 0;
			
			$resultT = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($resultT as $rowT)
			{
				echo "T*";
				
				
				
				//$rowT['Amount'] = ($rowT['Amount']) * 1.21;
				
				$rowT['Amount'] = number_format($rowT['Amount'], 2, ',', '');
				
				
				foreach($rowT as $valorT)
				{
					echo $this->san($valorT) . '*';
				}
				echo ++$serial . '*'; //#4
				echo $this->salto;			
			}
			
			//-------------------[trabajo de terceros]
		
		
			
			$sql = "UPDATE reclamo_garantia SET reclamo_garantia_field_pcw='1' WHERE id = '".$row['id']."'";
			$pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array());
			
		}
		
		
		
		
		
		
		
		
		
		//-----------------------------
		//fin archivo
		//access sucks 
		echo " " .$this->salto;
		//-----------------------------
		
	}
	
	
	
	
	
	private function san($string)
	{
		
		$string = str_replace("*","",$string);
		
		$string = $this->elimina_acentos($string);
		$string = preg_replace('/\s+/', ' ',$string);
		$string = preg_replace('#[\r\n]#', ' ', $string);
		$string = str_replace("\\t",'',$string);
		$string = preg_replace('/(\v|\s)+/', ' ', $string);
		$string = str_replace(array("\r", "\n"), ' ', $string);
		$string = trim( preg_replace( '/\s+/', ' ', $string ) ); 
		$string = trim($string);
		if(strlen($string)==0)
		{
			$string = ' ';
		}
		
		RETURN $string;  
		
	}



	private function elimina_acentos($cadena)
	{
		$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
		$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
		RETURN (strtr($cadena,$tofind,$replac));
	}




	private function plca($string)
	{
		$plca = 0;
		$entero = intval($string);
		if($entero>0)
		{
			$plca = ($string - $entero) * ($entero * 100);
		}
		
		$string = number_format($plca, 4, ',', '');
		
		RETURN $string;
	}

	private function dtc($string)
	{
		//db 1 apagado 2 prendido
		//access 2 apagado 1 prendido
		
		$dtc = 2; //default off
		
		if($string == 2)
		{
			$dtc = 1;
		}
		
		RETURN $dtc;
		
	}
	
	
	
	
	
	
	

}
?>    