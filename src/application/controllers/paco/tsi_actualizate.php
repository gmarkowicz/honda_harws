<?php

class Tsi_Actualizate extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
			exit;
    }  
	
	
	function index()
	{
	
		$this->load->helper('file');
		$statement = Doctrine_Manager::getInstance()->connection();
		
		$path = dirname(__FILE__) . "/tsi_actualizate.csv";
		$file = read_file($path);
		
		$i=0;
		$line = explode("\n",$file);
		foreach($line as $data)
		{
			++$i;
			$tsi_id = $data;
			
			$sql="UPDATE tsi SET 
						tsi_promocion_id=2
				WHERE id = '".trim($data)."'";
			
			echo $sql . '<br />';
			
			
			$statement->execute($sql);
			
			
			
			
		}
	}
	
	
}
?>    