<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['backend_root'] = 'concesionario/';
$config['backend_uploads_root'] = 'public/uploads/';
//subfix para las imagenes / archivos adjuntos
$config['backend_files_config'] = array(
								'archivo' 	=>'_field_archivo',
								'extension' =>'_field_extension',
								'orden'		=>'_field_orden',
								'titulo'	=>'_field_titulo',
								'copete'	=>'_field_copete',
							);