<?php

class Indices_Encuesta_Satisfaccion extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
    }  
	
	
	function index()
	{
	
		
		
		$statement = Doctrine_Manager::getInstance()->connection();
		
		$sql="SELECT id FROM `tsi_encuesta_satisfaccion` WHERE  tsi_encuesta_satisfaccion_field_indice_capacidad = 101 limit 10000
		
		" ;
		$r = $statement->execute($sql);
		$result = $r->fetchAll();
		echo count($result) ."<br />";
		
		$i = 0;
		foreach($result as $row)
		{
			$obj = new Tsi_Encuesta_Satisfaccion();
			$obj->crear_indices_honda($row['id']);
			++$i;
		}
		echo $i;
		
		
	}
	
	
}
?>    