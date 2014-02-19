<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
configuraciones para las imagenes del sitio
*/
$config['image_library'] = 'GD2';
$config['image_path'] = FCPATH.'public/uploads/sucursal/imagen/';

$config['image_upload'] = array(
	'upload_path' => FCPATH.'public/uploads/TEMP',
	'allowed_types' => 'gif|jpg|png',
	'max_size'	=> '4048',
	'max_width'  => '4048',
	'max_height'  => '4048',
	'encrypt_name' => TRUE,
	'overwrite' => TRUE,
);

//TODO REVISAR ESTO PORQ ES CUALQUIERA LAS PROPORCIONES!
//tamaños de las imagenes de las sucursales
$config['sucursal_thumbs'] = array(
		//abm
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_bo',
			'width' 			=>	100,
			'height' 			=>	100,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_134',
			'width' 			=>	134,
			'height' 			=>	92,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_142',
			'width' 			=>	142,
			'height' 			=>	96,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_305',
			'width' 			=>	305,
			'height' 			=>	87,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_500',
			'width' 			=>	500,
			'height' 			=>	327,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_600',
			'width' 			=>	600,
			'height' 			=>	365,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_623',
			'width' 			=>	623,
			'height' 			=>	246,
		),
		array(
			'create_thumb' 		=> TRUE,
			'thumb_marker' 		=>	'_thumb_800',
			'width' 			=>	800,
			'height' 			=>	235,
		),
);

