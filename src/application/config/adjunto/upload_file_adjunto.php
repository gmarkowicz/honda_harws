<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
configuraciones para los adjuntos
*/;

$config['adjunto_path'] = FCPATH.'public/uploads/upload_file/adjunto/';


$config['adjunto_upload'] = array(
	'upload_path' => FCPATH.'public/uploads/TEMP',
	'allowed_types' => '*',
	'max_size'	=> '204800',
	'encrypt_name' => TRUE,
	'overwrite' => TRUE,
);

