<?php

class Vins_codigo_llave extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
			exit;
    }  
	
	
	
	
    public function index()
    {   
		$this->load->helper('file');
		
		$statement = Doctrine_Manager::getInstance()->connection();
		
		
		
		
		$path = dirname(__FILE__) . "/vins_codigo_llave.csv";
		$file = read_file($path);
		$data = explode("\n",$file);
		$i = 0;
		foreach($data as $line)
		{
			
			//unidad_field_codigo_de_llave
			$sql ="UPDATE unidad set unidad_field_codigo_de_llave='' WHERE unidad_field_vin='".trim($line)."'";
			
			$statement->execute($sql);
			
			++$i;
			
			
			
		}
		
		
	}
	
	
}
?>    