<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * estaba entre marvin y paco pero marvin queda mas cool
 *
 * PHP version 5
 *
 * @category  CodeIgniter
 * @package   Helper CI
 * @author    propo
 * @version   0.1

 **/
class Marvin
{
	/**
	* Constructor
	* 
	* @access	public
	*/	
	public function Marvin()
    {
		$this->CI =& get_instance();
		$this->CI->lang->load('marvin');
		$this->CI->lang->load('calendar');
	}
	
	/**
	 *
	 *
	 * @access	public
	 * @param	mysql date
	 * @param	convierte un date de mysql a teletubbie mode
	 * @return	mixed
	 */
	public function mysql_date_to_human($mysql_date)
	{
		if ( preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})#", $mysql_date) )
		{
			$arr 	= explode("-", $mysql_date);
            $yyyy	= $arr[0];            
            $mm 	= $arr[1];
			$dd		= $arr[2];
            if(checkdate($mm, $dd, $yyyy)){
				//ojo si sacas strtolower...
				$day_of_the_week =	$this->CI->lang->line('cal_'. strtolower(date("l",mktime(0, 0, 0, $mm, $dd, $yyyy))) );
				$textual_month =	$this->CI->lang->line('cal_'. strtolower(date("F",mktime(0, 0, 0, $mm, $dd, $yyyy))) );
				return sprintf($this->CI->lang->line('marvin_mysql_date_to_human'), $dd, $mm, $yyyy, $day_of_the_week, $textual_month);
			}else{
				return FALSE;
			}
        } 
        else 
        {
			return FALSE;
		}
	}
	
	/**
	 *
	 *
	 * @access	public
	 * @param	mysql date
	 * @param	convierte un tymestamp de mysql a teletubbie mode
	 * @return	mixed
	 */
	public function mysql_datetime_to_human($mysql_datetime)
	{
		$fecha 	= explode(" ", $mysql_datetime);
		if ( preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})#", $fecha[0]) )
		{
			$arr 	= explode("-", $fecha[0]);
            $yyyy	= $arr[0];            
            $mm 	= $arr[1];
			$dd		= $arr[2];
            if(@checkdate($mm, $dd, $yyyy)){
				//ojo si sacas strtolower...
				$day_of_the_week =	$this->CI->lang->line('cal_'. strtolower(date("l",mktime(0, 0, 0, $mm, $dd, $yyyy))) );
				$textual_month =	$this->CI->lang->line('cal_'. strtolower(date("F",mktime(0, 0, 0, $mm, $dd, $yyyy))) );
				return sprintf($this->CI->lang->line('marvin_mysql_date_to_human'), $dd, $mm, $yyyy, $day_of_the_week, $textual_month) . ' ' . @$fecha[1];
			}else{
				return FALSE;
			}
        } 
        else 
        {
			return FALSE;
		}
	}
	
	/**
	 *
	 *
	 * @access	public
	 * @param	mysql date
	 * @param	convierte un tymestamp de mysql a teletubbie mode
	 * @return	mixed
	 */
	public function mysql_datetime_to_form($mysql_datetime)
	{
		$fecha 	= explode(" ", $mysql_datetime);
		if ( preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})#", $fecha[0]) )
		{
			$arr 	= explode("-", $fecha[0]);
            $yyyy	= $arr[0];            
            $mm 	= $arr[1];
			$dd		= $arr[2];
            if(@checkdate($mm, $dd, $yyyy)){
				//ojo si sacas strtolower...
				$day_of_the_week =	$this->CI->lang->line('cal_'. strtolower(date("l",mktime(0, 0, 0, $mm, $dd, $yyyy))) );
				$textual_month =	$this->CI->lang->line('cal_'. strtolower(date("F",mktime(0, 0, 0, $mm, $dd, $yyyy))) );
				return sprintf($this->CI->lang->line('marvin_mysql_datetime_to_form'), $dd, $mm, $yyyy, $fecha[1]);
			}else{
				return FALSE;
			}
        } 
        else 
        {
			return FALSE;
		}
	}
	
	/*------------------------------------------------*/
	
	
	
	/*------------------------------------------------*/
	public function mysql_date_to_form($mysql_date,$separador = '-')
	{
		
		if ( preg_match("#([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})#", $mysql_date) )
		{
			$arr 	= explode("-", $mysql_date);
            $yyyy	= $arr[0];            
            $mm 	= $arr[1];
			$dd		= $arr[2];
            if(checkdate($mm, $dd, $yyyy)){
				$data = sprintf($this->CI->lang->line('marvin_mysql_date_to_form'),$dd,$mm,$yyyy);
				return str_replace('-',$separador, $data);
			}else{
				//ojo, blanquea la fecha que le llega
				return FALSE;
				//return $mysql_date;
			}
        } 
        else 
        {
			//si no tiene el formato esperado tambien sacudo false
			return FALSE;
			return $mysql_date;
		}
	}
	/*------------------------------------------------*/
	
	
	/**
	 *
	 * @access	public
	 * @param	mysql_field_name (string)
	 * @param	saca prefix a un row
	 * @return	string
	 */
	public function remove_field_prefix($mysql_field_name)
	{		 
		$partes=explode('_field_',$mysql_field_name);
		if(count($partes)==2){
			$field = $partes[1];
			if($field == 'desc')
			{
				$field = $partes[0]."_id";
			}
		}else{
			$field = $mysql_field_name;
		}
		
		return $field;
	}
	/*------------------------------------------------*/
	
	
	
	
	/**
	 *
	 * @access	public
	 * @param	mysql_field_name (string)
	 * @param	intenta buscar el nombre del campo en el lenguaje, si no lo encuentra devuelve el nombre del campo
	 * @return	string
	 */
	public function mysql_field_to_human($mysql_field_name)
	{		 
		//exepcion
		if($mysql_field_name == 'unidad_field_fecha_entrega')
		{
			RETURN $this->CI->lang->line('unidad_field_fecha_entrega');
		}
		
		if(stristr($mysql_field_name, 'adjunto') != FALSE)
		{
			return $this->CI->lang->line('marvin_descargar_archivo');
		}
		
		$field = $this->remove_field_prefix($mysql_field_name);
		
		
		if($this->CI->lang->line($field)){
			return $this->CI->lang->line($field);
		}
		
		return '??'.$field; 
	}
	/*------------------------------------------------*/
	
	
	public function string_to_utf($in_str)
	{
		$cur_encoding = mb_detect_encoding($in_str) ;
		if($cur_encoding == "UTF-8" && mb_check_encoding($in_str,"UTF-8"))
		{
			RETURN $in_str;
		}
		else
		{
			RETURN utf8_encode($in_str); 
		}
	}
	
	
	/*
	
	devuelve extension de archivo
	recibe string
	*/
	public function get_file_extension($string)
	{
		RETURN strtolower(substr(strrchr($string, "."), 1));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	//-------[escribe el js del calendar para los htmls]
	public function print_js_calendar($fieldname,$config=array())
	{
		
		$range = "";
		if(isset($config['year_range']))
		{
			$range = "yearRange: '".$config['year_range']."',";
		}
		else
		{
			$range = 'yearRange: "-100:+0",';
		}
		
		
		return 
		"
		 <script type='text/javascript'>
			$(function()
			{
				$('#".$fieldname."').datepicker({
					$range
					//showOn: 'button',
					autoSize: true,
					//buttonImage: '".$this->CI->config->item('base_url')."public/images/calendar.png',
					//buttonImageOnly: true,
					dateFormat: 'dd-mm-yy',
					//minDate: '+0D',
					//maxDate: '+0',
					changeMonth: true,
					changeYear: true,
					numberOfMonths: 1,
					dayNamesMin:	[	'".$this->CI->lang->line('cal_su')."',
										'".$this->CI->lang->line('cal_mo')."',
										'".$this->CI->lang->line('cal_tu')."',
										'".$this->CI->lang->line('cal_we')."',
										'".$this->CI->lang->line('cal_th')."',
										'".$this->CI->lang->line('cal_fr')."',
										'".$this->CI->lang->line('cal_sa')."'
									],
					monthNamesShort:	[	'".$this->CI->lang->line('cal_january')."',
											'".$this->CI->lang->line('cal_february')."',
											'".$this->CI->lang->line('cal_march')."',
											'".$this->CI->lang->line('cal_april')."',
											'".$this->CI->lang->line('cal_mayl')."',
											'".$this->CI->lang->line('cal_june')."',
											'".$this->CI->lang->line('cal_july')."',
											'".$this->CI->lang->line('cal_august')."',
											'".$this->CI->lang->line('cal_september')."',
											'".$this->CI->lang->line('cal_october')."',
											'".$this->CI->lang->line('cal_november')."',
											'".$this->CI->lang->line('cal_december')."'
										]
								});
			});
		</script>
		";
	}
	
	public function print_html_input($config)
	{
		if(!isset($config['field_string'])) $config['field_string'] = $config['field_name'];
		if(!isset($config['field_type'])) $config['field_type']='text';
		if(!isset($config['field_params'])) $config['field_params']='';
		if(!isset($config['field_style'])) $config['field_style']='';
		$return = '<label class="'.$config['label_class'];
		if(form_error($config['field_name']))
		{
			$return.= ' error';
		}
		$return .='"';
		
		$return .=' for="'.$config['field_name'].'">';
		
		$return.= $this->mysql_field_to_human($config['field_string']);
		if($config['field_req'])
		{
			$return.= '<span class="req">*</span>';
		}
		$return.='<input style="'.$config['field_style'].'" id="'.$config['field_name'].'" name="'.$config['field_name'].'" class="';
		$return.=$config['field_type'] . ' field-' . $this->remove_field_prefix($config['field_name']);
		
		if(strlen($config['field_class'])>0)
		{
			$return .= ' '. $config['field_class'];
		}
		$return .='" ';
		//si es tipo password no retorna ningun valor en el "value"
		if($config['field_type']!='password')
		{
			
			$valor = set_value($config['field_name']);
			if($config['field_type']=='date')
			{
				$config['field_type']="text"; //chrome sux
				$valor = $this->mysql_date_to_form($valor);
			}
			$return .='value="'.$valor.'"';
		}
		$return .=' type="'.$config['field_type'].'" '.$config['field_params'].' >';
		$return .='</label>';
		return $return;
	}
	
	public function print_html_select($config)
	{
		
		if(!isset($config['field_string'])) $config['field_string'] = $config['field_name'];
		if(!isset($config['field_params'])) $config['field_params']='';
		
		if($this->CI->router->method=='toemail')
		{
			$return ="<div class='pdf_select_label'>".$this->mysql_field_to_human($config['field_string'])."</div>";
			
			$selected = set_value($config['field_name']);
			if(isset($config['field_options'][set_value($config['field_name'])]))
			{
				
				$return .="<div class='pdf_select'>" . $config['field_options'][set_value($config['field_name'])].'</div>';
			}
			
			RETURN $return;
			
		}
		else
		{
			
			$return = '<label class="'.$config['label_class'];
			if(form_error($config['field_name']))
			{
				$return.= ' error';
			}
			$return .='"';
			
			$return .=' for="'.$config['field_name'].'">';
			
			$return.= $this->mysql_field_to_human($config['field_string']);
			if($config['field_req'])
			{
				$return.= '<span class="req">*</span>';
			}
			/*
			<?php echo form_dropdown('unidad_color_exterior_id', $unidad_color_exterior_id, set_value('unidad_color_exterior_id'),'class="field" style=width:200px')?>
			*/
			$select_class="select field-" . $this->remove_field_prefix($config['field_name']);
			if(strlen($config['field_class'])>0)
			{
				$select_class .= ' '. $config['field_class'];
			}
			if(isset($config['field_selected']) && $config['field_selected']!=FALSE)
			{
				$selected=$config['field_selected'];
				
			}else{
				$selected = set_value($config['field_name']);
			}
			$return.= form_dropdown($config['field_name'],$config['field_options'], $selected, 'class="'.$select_class.'" '.$config['field_params']);
			$return .='</label>';
		}
		
		return $return;
	}
	
	public function print_html_textarea($config)
	{
		$return = '<label class="'.$config['label_class'];
		if(form_error($config['field_name']))
		{
			$return.= ' error';
		}
		$return .='"';
		
		$return .=' for="'.$config['field_name'].'">';
		
		$return.= $this->mysql_field_to_human($config['field_name']);
		if($config['field_req'])
		{
			$return.= '<span class="req">*</span>';
		}
		$return.= '<textarea id="'.$config['field_name'].'" rows="'.$config['textarea_rows'].'" name="'.$config['field_name'].'">'.set_value($config['field_name']).'</textarea>';
		$return .='</label>';
		
		if(isset($config['textarea_html']) && $config['textarea_html']==TRUE)
		{
			$return.='<script type="text/javascript">CKEDITOR.replace( \''.$config['field_name'].'\' );</script>';
		}
		
		return $return;
	}
	
	/**
	 *
	 * @access	public
	 * @param	array(field_name,field_req,label_class,field_class)
	 * @param	escribe html para el calendar de jquery
	 * @return	string
	 */
	public function print_html_calendar($config)
	{
		$config['field_class'].=' field-datepick ';
		$config['field_type']='date';
		$return='<div class="ui-datepick">';
		$return.=$this->print_html_input($config);
		$return.=$this->print_js_calendar($config['field_name'],$config);
		$return.='</div>';
		return $return;
	}
	
	/**
	 *
	 * @access	public
	 * @param	array(field_name,field_req,label_class,field_class)
	 * @param	escribe html con checkbox
	 * @return	string
	 */
	public function print_html_checkbox($config)
	{
		
		if(!isset($config['label_class']))
			$config['label_class'] = '';
		
		if($config['field_type']=='radio')
		{
			$field_name	=	$config['field_name'];
		}
		else
		{
			$field_name =	$config['field_name'].'[]';
		}
		
		$return='<div class="checkbox">';
		while (list($key, $value) = each($config['field_options']))
		{
		$return.=
		'
				
				<span>
				
				<input name="'.$field_name.'" id="'.$config['field_name'].$key.'" class="checkbox '.$config['field_class'].'" value="'.$key.'" type="'.$config['field_type'].'"
				'.$this->CI->form_validation->set_checkbox($field_name, $key) . '><label class="choice '.$config['label_class'].'" for="'.$config['field_name'].$key.'">'.$value.'</label>
				</span>
				
		';
		}
		$return .='</div>';
		
		return $return;
	}
	
	/**
	 *
	 * @access	public
	 * @param	array(field_name)
	 * @param	escribe radios para estrellas basado en http://www.fyneworks.com/jquery/star-rating/
	 * @return	string
	 */
	public function print_html_stars($config)
	{
		
		$return = "";
		if($this->CI->router->method=='toemail')
		{
			//pdf...
			$return .= "<table><tr>";
			$checked = 'pdf_star_on';
			
			//por ahi no puso ninguna...
			$flag = FALSE;
			while (list($key, $value) = each($config['field_options']))
			{
				if($this->CI->form_validation->set_checkbox($config['field_name'], $key, FALSE)!=FALSE)
				{
					$flag = TRUE;
				}
			}
			if(!$flag)
			{
				$checked = 'pdf_star_off';
			}
			//---
			
			$flag = FALSE;
			reset($config['field_options']);
			while (list($key, $value) = each($config['field_options']))
			{
				if(set_checkbox($config['field_name'], $key, FALSE)!=FALSE)
				{
					$flag = TRUE;
				}
				$return.= '<td class="pdf_star '.$checked.'">&nbsp;</td>';
				if($flag)
				{
					$checked = 'pdf_star_off';
				}
			}
			
			$return .= "</tr></table>";
		}
		else
		{
		
			//normal...
			while (list($key, $value) = each($config['field_options']))
			{
			$return.=
			'
					<input name="'.$config['field_name'].'" type="radio" value="'.$key.'" class="star" '.$this->CI->form_validation->set_checkbox($config['field_name'], $key) . '/>
					
			';
			}
		}

		
		
		return $return;
	}
	
	
	
	public function getmicrotime()
	{ 
	   list($usec, $sec) = explode(" ",microtime()); 
	   return ((float)$usec + (float)$sec); 
	}  
	
	
	
	
	public function isset_ajax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest");
	}
}
?>