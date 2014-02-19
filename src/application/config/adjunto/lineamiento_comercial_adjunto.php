<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
configuraciones para los adjuntos
*/;

$config['adjunto_path'] = FCPATH.'public/uploads/lineamiento_comercial/adjunto/';


$config['adjunto_upload'] = array(
	'upload_path' => FCPATH.'public/uploads/TEMP',
	'allowed_types' => 'xls|xlsx|pdf|doc|zip|rar',
	'max_size'	=> '4048',
	'encrypt_name' => TRUE,
	'overwrite' => TRUE,
);

