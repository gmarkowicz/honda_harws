<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Json header params
|--------------------------------------------------------------------------
*/
$config['ofimatica_export_max_rows'] = 60000; //cantidad maxima de rows que exporta //0 para infinito
$config['ofimatica_records_per_query'] = 5000; //cantidad maxima de registros que traer por lopp
$config['ofimatica_pixels_to_xls_width'] = 0.2; //tamaño de las columnas del xls en base a los pixeles de la grilla flexigrid (multiplica los px por este numero)
$config['ofimatica_header_background_color_rgb'] = '717072'; //tamaño de las columnas del xls en base a los pixeles de la grilla flexigrid (multiplica los px por este numero)
$config['ofimatica_header_font_color_rgb'] = 'FF0000'; //tamaño de las columnas del xls en base a los pixeles de la grilla flexigrid (multiplica los px por este numero)
?>