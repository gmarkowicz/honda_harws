<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
configuraciones para las imagenes del sitio
*/
$config['image_library'] = 'GD2';
$config['image_path'] = FCPATH.'public/uploads/publicidad/imagen/';
$config['maintain_ratio'] = TRUE;

$config['image_upload'] = array(
	'upload_path' => FCPATH.'public/uploads/TEMP',
	'allowed_types' => 'gif|jpg|png',
	'max_size'	=> '4048',
	'max_width'  => '4048',
	'max_height'  => '4048',
	'encrypt_name' => TRUE,
	'overwrite' => TRUE,
);


//tama?os de las imagenes de las noticias
$config['publicidad_thumbs'] = array(
		//abm
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_bo',
			'width' 			=>	100,
			'height' 			=>	100,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_530',
			'width' 			=>	530,
			'height' 			=>	400,
		)
);

