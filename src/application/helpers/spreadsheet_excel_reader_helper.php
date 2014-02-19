<?php

$path = dirname(__FILE__).'/spreadsheet_excel_reader/lib/reader.php';
if(!is_file($path))
{
	die(__LINE__ . __FILE__ );
}

include $path;

