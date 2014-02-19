<?php

class Frt_es extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
			
    }  
	
	
	
	
    public function index()
    {   
		$this->load->helper('file');
		
		$statement = Doctrine_Manager::getInstance()->connection();
		
		
		
		
		$path = dirname(__FILE__) . "/frt_es.csv";
		$file = read_file($path);
		$data = explode("\n",$file);
		$i = 0;
		foreach($data as $line)
		{
			$string = explode(';',$line);
			$frt = trim($string[0]);
			$desc = trim(str_replace("'",'',$string[1]));
			
			
			$sql="UPDATE frt SET 
						frt_field_desc  = '".$desc."'
				WHERE id = '".$frt."'";
			
			//echo $sql . '<br />';
			
			$statement->execute($sql);
			
			++$i;
			
			
			
		}
		
		
	}
	
	
}
?>    