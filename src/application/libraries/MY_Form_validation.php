<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	function MY_Form_validation()
	{
		parent::__construct();
	}
	
	
	
	/**
	 * Get the value from a form
	 *
	 * Permits you to repopulate a form field with the value it was submitted
	 * with, or, if that value doesn't exist, with the default
	 *
	 * @access	public
	 * @param	string	the field name
	 * @param	string
	 * @return	void
	 */
	function set_value($field = '', $default = '')
	{
		if ( ! isset($this->_field_data[$field]))
		{
			return $default;
		}
		
		/* no se porq corno hacen esto, pero no me anda bien...
		
		
		// If the data is an array output them one at a time.
		//     E.g: form_input('name[]', set_value('name[]');
		if (is_array($this->_field_data[$field]['postdata']))
		{
			return array_shift($this->_field_data[$field]['postdata']);
		}
		*/
		return $this->_field_data[$field]['postdata'];
	}

	// --------------------------------------------------------------------
	
	/*OJO tiene que existir el post :S*/
	function my_force_error($data = FALSE)
	{	
		
		$this->CI->form_validation->set_message('my_force_error', $this->CI->lang->line('form_my_force_error'));		
		RETURN FALSE;
	}


		
	
	
	
	
	function my_unique_db($valor, $parametros)
	{
		$this->CI->form_validation->set_message('my_unique_db', $this->CI->lang->line('form_campo_duplicado'));
		
		$regla = explode(' ',$parametros);

		$id=$regla[1];
		list($tabla, $columna) = explode('.', $regla[0], 2);
		
		$q = Doctrine_Query::create()
		  ->from($tabla);

		if( count($regla) <= 2 ){
			$q ->where($columna . ' = ' . "'".$valor."'")
			->andWhere('id != '. "'".$id."'");
		}else{
			$q->where($regla[2].' = '. "'".$regla[3]."'")
			->andWhere('id != '. "'".$id."'")
			->andWhere($regla[4].' = '. "'".$regla[5]."'");
		}
		$resultado = $q->fetchArray();
		return (count($resultado)>0) ? FALSE : TRUE;
		
	}


	####################################################
	//DEPRECATED
	# chequeo que el select armado tenga info correcta #
	function db_id_exist( $valor, $parametros ){ 
		$this->CI->form_validation->set_message('db_id_exist', $this->CI->lang->line('select_unreal'));#leer y poner el error correcto
		
		$regla = explode(' ',$parametros);
/*		echo "<pre>";
		print_r($regla);
		echo "</pre>";*/
		
		$id=$regla[1];
		list($tabla, $columna) = explode('.', $regla[0] );
		//$valor=22;#un numero cualquiera fuera de rango para probar el error

		$q = Doctrine_Query::create()
		->from($tabla)
		->where($columna . ' =  ?',$valor);
#		echo $q->getSqlQuery();
		$resultado = $q->fetchArray();
		return (count($resultado)!=1) ? FALSE : TRUE;

	}
	
	####################################################
	# chequeo que el select armado tenga info correcta #
	function my_db_value_exist( $valor, $modelo_punto_campo )
	{
		$this->CI->form_validation->set_message('my_db_value_exist', $this->CI->lang->line('form_seleccione'));
		list($modelo, $campo) = explode('.', $modelo_punto_campo );
		$q = Doctrine_Query::create()
		->from($modelo)
		->where($campo . ' =  ?',$valor);
		$resultado = $q->fetchOne();
		RETURN (count($resultado)!=1) ? TRUE : FALSE;

	}



	//envia info por default a los forms
	function set_defaults($fields,$force = FALSE)
    {
        if (!is_array($fields))
            return FALSE;

        if(!$force)
		{
			if(!empty($_POST))
				return FALSE;
		}

        foreach ($fields as $key => $value)
        {
            if($force)
			{
				$this->set_rules($key,$key,'trim');
			}
			$this->_field_data[$key]['postdata'] = $value;
        }
    }
	
	
	
	
	function my_form_date_reverse($form_date)
    {
		
		
		
		if ( preg_match("#([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})#", $form_date) )
		{
			
			$arr 	= explode("-", $form_date);
			$return = $arr[2] . "-" . $arr[1] . "-" . $arr[0];
			return $return;
		}
		else
		{
			
			return $form_date;
		}
    }
	
	/**
    * @desc Validates a date format
    * @params format,delimiter
    * e.g. d/m/y,/ or y-m-d,-
    */
    function my_valid_date($str, $params)
    {
        $this->CI->form_validation->set_message('my_valid_date', $this->CI->lang->line('form_fecha_invalida'));
		
		// setup        
        $params = explode(',', $params);
        $delimiter = $params[1];
        $date_parts = explode($delimiter, $params[0]);
		$now = FALSE;
		if(isset($params[2]) && $params[2] ==1)
		{
			$now = TRUE;
		}

        // get the index (0, 1 or 2) for each part
        $di = $this->valid_date_part_index($date_parts, 'd');
        $mi = $this->valid_date_part_index($date_parts, 'm');
        $yi = $this->valid_date_part_index($date_parts, 'y');

        // regex setup
        $dre = "(0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31)";
        $mre = "(0?1|0?2|0?3|0?4|0?5|0?6|0?7|0?8|0?9|10|11|12)";
        $yre = "([0-9]{4})";
        $red = '\\'.$delimiter; // escape delimiter for regex
        $rex = "^[0]{$red}[1]{$red}[2]$";

        // do replacements at correct positions
        $rex = str_replace("[{$di}]", $dre, $rex);
        $rex = str_replace("[{$mi}]", $mre, $rex);
        $rex = str_replace("[{$yi}]", $yre, $rex);

        if (preg_match("#".$rex."#", $str, $matches)) {
            // skip 0 as it contains full match, check the date is logically valid
			// checkdate ( int $month , int $day , int $year )
            if (checkdate($matches[$mi + 1], $matches[$di + 1], $matches[$yi + 1])) {
                if($now)
				{
					$hoy = date_create( date('Y-m-d') );
					$ingreso = date_create( $matches[$yi + 1] . '-' . $matches[$mi + 1] . '-' . $matches[$di + 1] );
					if($ingreso<=$hoy)
					{
						return true;
					}
					else
					{
						return false;
					}
					
				}
				else
				{
					return true;
				}
				
				
            } else {
                // match but logically invalid
                return false;
            }
        } 

        // no match
		
        return false;
    }      

    function valid_date_part_index($parts, $search) {
        for ($i = 0; $i <= count($parts); $i++) {
            if ($parts[$i] == $search) {
                return $i;
            }
        }
    }
	//--------------------------------------------------

	
	
	function my_valid_cuit($cuit)
	{
		$this->CI->form_validation->set_message('my_valid_cuit', $this->CI->lang->line('form_cuit_invalido'));
		
		if(strlen($cuit)!=11 || !is_numeric($cuit))
		{
			return FALSE;
		}else{
			return TRUE;
		}
	}


	##documento
	function my_valid_documento( $documento ) {
		
		$this->CI->form_validation->set_message('my_valid_documento', $this->CI->lang->line('form_documento_invalido'));
		
		if(!is_numeric($documento)){
			return false;
		}else if(strlen($documento) > 9) {
			return false;
		}else if(strlen($documento)<7){
			return false;
		}else{
			return true;
		}
	}
	
	##codigo postal
	function my_valid_codigo_postal( $codigo_postal ) {
		
		$this->CI->form_validation->set_message('my_valid_codigo_postal', $this->CI->lang->line('form_codigo_postal_invalido'));
		
		if(strlen($codigo_postal)<4 || $codigo_postal=='0000')
		{
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	##url valida
	//TODO HACER
	function my_valid_url($url)
	{
		///^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,3}|info|mobi|aero|asia|name)(:\d{2,5})?(\/)?((\/).+)?$/i;
		RETURN TRUE;	
	}

	function my_valid_sucursal($sucursal_id)
	{
		$this->CI->form_validation->set_message('my_valid_sucursal', $this->CI->lang->line('form_seleccione'));
		
		if(in_array($sucursal_id, $this->CI->session->userdata('sucursales')))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	
	/*-------------------------customs de HARWS------------------------------*/
	function my_exist_unidad($unidad, $vin)
	{
		
		$this->CI->form_validation->set_message('my_exist_unidad', $this->CI->lang->line('form_unidad_inexistente'));
		$q = Doctrine_Query::create()
		  ->from('unidad')
		  ->where('unidad_field_unidad = ?', $unidad)
		  ->andWhere('unidad_field_vin = ?', $vin);
		$resultado = $q->fetchArray();
		
		return (count($resultado)==1) ? TRUE : FALSE;
		
	}
	
	function my_valid_patente($patente)
	{
		$this->CI->form_validation->set_message('my_valid_patente', $this->CI->lang->line('form_patente_invalida'));
		if (preg_match("#^[A-Z]{3}-[0-9]{3}$#", $patente ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function my_valid_codigo_de_llave($cod_llave)
	{
		$this->CI->form_validation->set_message('my_valid_codigo_de_llave', $this->CI->lang->line('form_codigo_de_llave_invalido'));
		if (preg_match("#^[A-Z]{1}-[0-9]{3}$#", $cod_llave ) OR preg_match("#^[0-9]{4}$#", $cod_llave ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function my_valid_codigo_de_radio($cod_radio)
	{
		$this->CI->form_validation->set_message('my_valid_codigo_de_radio', $this->CI->lang->line('form_codigo_de_radio_invalido'));
		if (preg_match("#^[1-6]{5}$#", $cod_radio) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	
	
	
	
	
	
	
	
}