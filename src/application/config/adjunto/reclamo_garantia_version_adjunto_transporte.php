<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
configuraciones para los adjuntos
*/;

$config['adjunto_path'] = FCPATH.'public/uploads/reclamo_garantia_version/adjunto_transporte/';


$config['adjunto_upload'] = array(
	'upload_path' => FCPATH.'public/uploads/TEMP',
	'allowed_types' => 'xls|xlsx|pdf|doc|zip|rar|txt|jpg',
	'max_size'	=> '14048',
	'encrypt_name' => TRUE,
	'overwrite' => TRUE,
);

