<?php

class Frt_seccion3 extends CI_Controller{
    
    function __construct()
    {               
            parent::__construct();
    }  
	
	
	
	
    public function index()
    {   
		$this->load->helper('file');
		
		$statement = Doctrine_Manager::getInstance()->connection();
		
		//$ar=file_get_contents( dirname(__FILE__) . "/frt_seccion1.t","r");
		
		
		$path = dirname(__FILE__) . "/frt_seccion3.txt";
		$file = read_file($path);
		
		$data = explode("\n",$file);
		$i = 0;
		foreach($data as $line)
		{
			
			
			$frt_seccion =  substr($line, 0, 1);  // devuelve "abcde"
			$desc =  substr($line, 1);  // devuelve "abcde"
			
			
			
			
			$sql="UPDATE frt_seccion SET 
						frt_seccion_field_desc  = '".trim($desc)."'
				WHERE id  like '___".$frt_seccion."' and frt_seccion_field_desc !='Custom'";
			
			//echo $sql."<br />";
			
			$statement->execute($sql);
			
			
		}
		
		
	}
	
	
}
?>    