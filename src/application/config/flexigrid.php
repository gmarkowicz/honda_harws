<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Json header params
|--------------------------------------------------------------------------
*/
//TODO REVISAR $config['json_header'], no deberia ser un array;
/*
$config['json_header'] = array(
"Expires: Mon, 26 Jul 1997 05:00:00 GMT",
"Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT",
"Cache-Control: no-cache, must-revalidate",
"Pragma: no-cache",
"Content-type: text/x-json");
*/ 

$config['json_header']='';


$config['ajax_header'] = array(
"Expires: Mon, 26 Jul 1997 05:00:00 GMT",
"Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT",
"Cache-Control: no-cache, must-revalidate",
"Pragma: no-cache",
"Content-type: text/plain");

/*
|--------------------------------------------------------------------------
| Starting page number
|--------------------------------------------------------------------------
*/
$config['page_number'] = 1;

/*
|--------------------------------------------------------------------------
| Default number of records per page
|--------------------------------------------------------------------------
*/
$config['per_page'] = 25;

$config['gridParams'] = array(
			'width' => 'auto',
			'height' => 400,
			'rp' => 25,
			'rpOptions' => '[25,50,100]',
			'pagestat' => 'Mostrando: {from} a {to} de {total} registros.',
			'procmsg'=>'Procesando ...',
			'showTableToggleBtn' => TRUE
		);



?>