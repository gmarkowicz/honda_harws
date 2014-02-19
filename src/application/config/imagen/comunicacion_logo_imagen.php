<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
configuraciones para las imagenes del sitio
*/
$config['image_library'] = 'GD2';
$config['image_path'] = FCPATH.'public/uploads/comunicacion/logos/imagen/';
$config['maintain_ratio'] = TRUE;

$config['image_upload'] = array(
	'upload_path' => FCPATH.'public/uploads/TEMP',
	'allowed_types' => 'gif|jpg|png',
	'max_size'	=> '40048',
	'max_width'  => '40048',
	'max_height'  => '40048',
	'encrypt_name' => TRUE,
	'overwrite' => TRUE,
);


//tamanios de las imagenes de boutique
$config['comunicacion_logo_thumbs'] = array(
		//abm
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_bo',
			'width' 			=>	100,
			'height' 			=>	100,
		),
		array(
				'proccess'	 		=> false,
				'thumb_marker' 		=>	'_full',
		)
);

