<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'harws2';
$active_record = TRUE;


$db['harws']['hostname'] = "localhost";
$db['harws']['username'] = "harws";
$db['harws']['password'] = "mhhhhhhh";
$db['harws']['database'] = "harws";
$db['harws']['dbdriver'] = "mysql";
$db['harws']['dbprefix'] = "";
$db['harws']['pconnect'] = FALSE;
$db['harws']['db_debug'] = TRUE;
$db['harws']['cache_on'] = FALSE;
$db['harws']['cachedir'] = "";
$db['harws']['char_set'] = "utf8";
$db['harws']['dbcollat'] = "utf8_general_ci";
$db['harws']['swap_pre'] = '';
$db['harws']['autoinit'] = FALSE;
$db['harws']['stricton'] = FALSE;


$db['harws2']['hostname'] = "localhost";
$db['harws2']['username'] = "harws";
$db['harws2']['password'] = "H1rws01";
$db['harws2']['database'] = "harws2";
$db['harws2']['dbdriver'] = "mysql";
$db['harws2']['dbprefix'] = "";
$db['harws2']['pconnect'] = FALSE;
$db['harws2']['db_debug'] = TRUE;
$db['harws2']['cache_on'] = FALSE;
$db['harws2']['cachedir'] = "";
$db['harws2']['char_set'] = "utf8";
$db['harws2']['dbcollat'] = "utf8_unicode_ci";
$db['harws2']['swap_pre'] = '';
$db['harws2']['autoinit'] = FALSE;
$db['harws2']['stricton'] = FALSE;

$config_doctrine = array(
		'data_fixtures_path'  =>  APPPATH . '/data/fixtures',
		'models_path'         =>  APPPATH . '/models',
		'migrations_path'     =>  APPPATH . '/data/migrations',
		'sql_path'            =>  APPPATH . '/data/sql',
		'yaml_schema_path'    =>  APPPATH . '/data/schema',
		"generate_models_options" => array(
				"phpDocPackage"       => "Honda_HARWS",
				"phpDocSubpackage"    => "Doctrine",
		),
);
if(!defined('DOCTRINE_MODEL_DIR'))
{
define('DOCTRINE_MODEL_DIR', $config_doctrine['models_path']);
}

/* End of file database.php */
/* Location: ./application/config/database.php */