<?php

class Vins_Cambio_Anio_Modelo extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
    }  
	
	
	function index()
	{
	
		$this->load->helper('file');
		$statement = Doctrine_Manager::getInstance()->connection();
		
		$path = dirname(__FILE__) . "/vins_cambio_anio_modelo.csv";
		$file = read_file($path);
		
		$i=0;
		$line = explode("\n",$file);
		foreach($line as $data)
		{
			++$i;
			$vin = explode(';',$data);
			
			$sql="UPDATE unidad SET 
						auto_anio_id  = 102, unidad_field_fixed=''
				WHERE unidad_field_vin = '".trim($vin[0])."'";
			
			echo $sql . '<br />';
			
			$statement->execute($sql);
			
			
			
		}
	}
	
	
}
?>    