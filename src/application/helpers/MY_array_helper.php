<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



#funcion para reiniciar session element cada vez que hago busqueda.
function element( $item, $array, $default = NULL )
{
	if(isset($_SESSION['element']))
	{
		unset($_SESSION['element']);
	}

	$resultado = _bBreak($item, $array );
	$cantidad = count($resultado);
	
	
	if($cantidad>0){
		if($cantidad==1)
		{
			return $resultado[0];
		}else{
			return join(" | ", $resultado);
		}
	}else{
		return $default;
	}
}

/*optimizada bastante se tiene q optimizar mas!*/
function _bBreak( $item, $array )
{

	if(is_array($array))
	{
		if(isset($array[$item]))
		{
			$_SESSION['element'][] = $array[$item];
		}else{
			foreach( $array as $k=>$v )
			{
				if( is_array( $v ))
				{
					_bBreak( $item, $v );
				}
			}
		}
	}
	

	if(isset($_SESSION['element']) && is_array($_SESSION['element']) && !empty($_SESSION['element']))
	{
		return $_SESSION['element'];
	}
	else
	{
		if(isset($_SESSION['element']))
		{
			unset($_SESSION['element']);
		}
		return array();
	}

}#funcion que obtiene data por campo





#funcion para reiniciar session element cada vez que hago busqueda.
function element2( $item, $array, $default = NULL )
{
	
	
	$resultado = _bBreak2($item, $array );
	if(count($resultado)>0){
		
		if(count($resultado)==1)
		{
			
			
			return $resultado[0];
		}else{
			
			return join(" | ", $resultado);
		}
	}else{
		return $default;
	}
}

/*optimizada bastante se tiene q optimizar mas!*/
function _bBreak2( $item, $array )
{
	
	
	$return = array();
	
	if(isset($array[$item]))
	{
		$return[] = $array[$item];
	}else{
		foreach( $array as $k=>$v )
		{
			if( is_array( $v ))
			{
				$resultado = _bBreak2( $item, $v );

					while(list(,$valor) = each ($resultado))
					{
						$return[]=$valor;
					}
					
				
			}
		}
	}
	
	return $return;

}#funcion que obtiene data por campo




/* 
function _bBreak( $item, $array )
{

	foreach( $array as $k=>$v )
	{
		if( is_array( $v ))
		{
			_bBreak( $item, $v );
		}
		else if( $k == $item )
		{
			$_SESSION['element'][] = $v;
		}
	}#para cada uno

	if(isset($_SESSION['element']) && is_array($_SESSION['element']) && !empty($_SESSION['element']))
	{
		return $_SESSION['element'];
	}
	else
	{
		if(isset($_SESSION['element']))
		{
			unset($_SESSION['element']);
		}
		return FALSE;
	}

}#funcion que obtiene data por campo
*/


/* End of file My_array_helper.php */
/* Location: ./application/helpers/My_array_helper.php */