<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
configuraciones para las imagenes del sitio
*/
$config['image_library'] = 'GD2';
$config['image_path'] = FCPATH.'public/uploads/boutique_producto/imagen/';
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


//tamanios de las imagenes de boutique
$config['boutique_producto_thumbs'] = array(
		//abm
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_bo',
			'width' 			=>	100,
			'height' 			=>	100,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_140',
			'width' 			=>	140,
			'height' 			=>	140,
		),
		//view
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_280',
			'width' 			=>	280,
			'height' 			=>	280,
		),
		
);

