<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * estaba entre marvin y paco pero marvin queda mas cool
 *
 * PHP version 5
 *
 * @category  CodeIgniter
 * @package   exporta a lo que se pueda...
 * @author    propo
 * @version   0.1
 
 
 
 Excel does not read UTF-8 special characters like é. If you have a UTF-8 database and need to export to Excel you might want to add
$value = utf8_decode($value);
 
 
 
 
 

 **/
class Ofimatica
{
	/**
	* Constructor
	* 
	* @access	public
	*/
	public $start = null;
	var $file = NULL ;
	var $current_row=-1;
	var $current_colum=0;
	var $columns = array(
		'0' =>'A',
		'1' =>'B',
		'2' =>'C',
		'3' =>'D',
		'4' =>'E',
		'5' =>'F',
		'6' =>'G',
		'7' =>'H',
		'8' =>'I',
		'9' =>'J',
		'10' =>'L',
		'11' =>'M',
		'12' =>'N',
		'13' =>'O',
		'14' =>'P',
		'15' =>'Q',
		'16' =>'R',
		'17' =>'S',
		'18' =>'T',
		'19' =>'U',
		'20' =>'V',
		'21' =>'W',
		'22' =>'X',
		'23' =>'Y',
		'24' =>'Z',
		'25' =>'A1',
		'26' =>'A2',
		'27' =>'A3',
		'28' =>'A4',
		'29' =>'A5',
		'30' =>'A6',
		'31' =>'A7',
		'32' =>'A8',
		'33' =>'A9',
		'34' =>'A10',
		'35' =>'A11',
		'36' =>'A12',
		'37' =>'A13',
		'38' =>'A14',
		'39' =>'A15',
		'40' =>'A16',
		'41' =>'A17',
		'42' =>'A18',
		'43' =>'A19',
		'44' =>'A21',
		'45' =>'A22',
		'46' =>'A23',
		'47' =>'A24',
		'48' =>'A25',
		'49' =>'A26',
		'50' =>'A27',
		'51' =>'A28',
		'52' =>'A29',
		'53' =>'A30',
		'54' =>'A31',
		'55' =>'A32',
		'56' =>'A33',
		'57' =>'A34',
		'58' =>'A35',
		'59' =>'A36',
		'60' =>'A37',
		
	);
	
	var $width = array();
	
	
	
	
	
	
	public function Ofimatica()
    {
		$this->CI =& get_instance();
		$this->CI->load->helper('psxlsgen');
		ini_set('max_execution_time',10360);
		ini_set('memory_limit', '-1');
		$this->CI->config->load	('ofimatica');
		//http://bugs.php.net/bug.php?id=33595
		$this->CI->load->helper('text');
		
		$this->start = microtime(true);
	}
	
	
	public function get_export_max_rows()
	{
		return $this->CI->config->item('ofimatica_export_max_rows');
	}
	
	public function get_records_per_query()
	{
		if($this->get_export_max_rows()<$this->CI->config->item('ofimatica_records_per_query'))
		{
			return $this->get_export_max_rows();
		}else{
			return $this->CI->config->item('ofimatica_records_per_query');
		}
		
	}
	
	public function make_file()
	{
		
		$this->file = new PhpSimpleXlsGen();
		//$this->file->ChangeDefaultDir(APPPATH.'/tmp/');
		//$this->file->totalcol = 10;
	}
	
	public function add_row()
	{
		//echo "nuevo row<br />";
		$this->current_row++;
		$this->current_colum = 0;
	}
	
	public function add_data($data, $cordenada = FALSE)
	{
		if(!$cordenada)
		{
			$cordenada = $this->columns[$this->current_colum] . $this->current_row;
			
		}
		//$this->file->ChangePos($this->current_row,$this->current_colum);
		//if($this->current_row<65536)
		//{

			$this->file->WriteText_pos($this->current_row,$this->current_colum, $this->normalize_field($data) ); 
			/*
			$data = $this->normalize_field($data);
			$type = $this->get_type($data);
			$this->file->getActiveSheet()->getCell($cordenada)->setValueExplicit($data, $type);
			$this->current_colum++;
			*/
			$this->current_colum++;
		//}
	}
	
	public function add_header($data,$width){
		
		$this->width['data'] = $width;
		$this->file->WriteText_pos($this->current_row,$this->current_colum, $this->normalize_field($data) );
		$this->current_colum++;
	}
	
	public function send_file($extension = 'xls')
	{
		
		
		if($this->CI->session->userdata('admin_field_super_admin')===TRUE)
		{
			$this->add_row();
			$this->add_data('Tiempo:' . substr(microtime(true)-$this->start,0,6));
			$this->add_row();
			$this->add_data('Memoria:' . number_format(memory_get_peak_usage()));
		}
		
		$this->CI->load->helper('string');
		//$this->CI->load->library('zip');
		$separador  = '---'; 
		$filename	=	url_title
						(
						$this->CI->router->class 		. $separador .
						date('l jS \of F Y H_i_s ')		. $separador .
						random_string('unique')			. $separador 
						)	.'.' . $extension;
		
		/*
		#tamaño automatico para las columnas
		for($i=0;$i<$this->current_colum;$i++)
		{
			$this->file->getActiveSheet()->getColumnDimension($this->columns[$i])->setWidth(25);
		}
		
		
		
		if($extension == 'xls'){
			
			$objWriter = new PHPExcel_Writer_Excel5($this->file);
		}else if($extension == 'pdf'){
			//ojo ojo revisar... anda muyyyyyyyyy mal
			return FALSE;
			$objWriter = new PHPExcel_Writer_PDF($this->file);
		}else{
			return FALSE;
		}
		*/
		//$this->file->SendFile();
		$this->file->SaveFile(APPPATH.'tmp/'.$filename);
		/*
		//vamos a tratar de darle tamaño
		$this->CI->load->plugin('phpexcel');
		$objReader = new PHPExcel_Reader_Excel5(); 
		$file = $objReader->load(APPPATH.'tmp/'.$filename);
		
		#tamaño automatico para las columnas
		$i=0;
		reset($this->width);
		while(list($key,$width) = each($this->width))
		{
			$file->getActiveSheet()->getColumnDimension($this->columns[$i])->setWidth($width);
			$i++;
		}
		
		$objWriter = IOFactory::createWriter($file, 'Excel5');
		$objWriter->save(APPPATH.'/tmp/'.$filename);
		*/
		//$this->CI->zip->read_file(APPPATH.'/tmp/'.$filename); 
		//@unlink(APPPATH.'/tmp/'.$filename);
		//$this->CI->zip->download($filename.'.zip');
		
		$zip = new ZipArchive();
		if ($zip->open(APPPATH.'tmp/'.$filename .'.zip', ZipArchive::CREATE)!==TRUE) {
			exit("cannot open <$filename>\n");
		}
		
		$zip->addFile(APPPATH.'tmp/'.$filename,$filename);
		$zip->close();
		unlink(APPPATH.'tmp/'.$filename);
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename(APPPATH.'tmp/'.$filename.'.zip'));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize(APPPATH.'tmp/'.$filename.'.zip'));
		ob_clean();
		flush();
		readfile(APPPATH.'/tmp/'.$filename .'.zip');
		exit;
		
		
		
		
		/*
		
		 header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$filename\"\n");
		$fp=fopen(APPPATH.'tmp/'.$filename, "r");
		fpassthru($fp);
		*/
		
		
		//$this->CI->output->enable_profiler();		
		/*
		$objWriter->save(APPPATH.'/tmp/'.$filename);
		$this->CI->zip->read_file(APPPATH.'/tmp/'.$filename); 
		@unlink(APPPATH.'/tmp/'.$filename);
		$this->CI->zip->download($filename.'.zip'); 
		*/
	}
	/**/
	
	private function normalize_field($data)
	{
		//return $this->CI->marvin->string_to_utf($data);

		RETURN character_limiter(utf8_decode(html_entity_decode(strip_tags($data))),200,'...');
		//RETURN utf8_decode(html_entity_decode(strip_tags($data)));
	}
	private function get_type($data)
	{
		return PHPExcel_Cell_DataType::TYPE_STRING;
	}
	//---------------------- excel --------------------------*/
	
	
	
}
?>