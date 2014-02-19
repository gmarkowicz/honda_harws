<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
configuraciones para las imagenes del sitio
*/
$config['image_library'] = 'GD2';
$config['image_path'] = FCPATH.'public/uploads/comunicacion/multimedia/imagen/';
$config['maintain_ratio'] = TRUE;

$config['image_upload'] = array(
	'upload_path' => FCPATH.'public/uploads/TEMP',
	'allowed_types' => '*',
	'max_size'	=> '100000',
	'max_width'  => '100000',
	'max_height'  => '100000',
	'encrypt_name' => TRUE,
	'overwrite' => TRUE,
);


//tama�os de las imagenes de las noticias
$config['comunicacion_multimedia_thumbs'] = array(
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

