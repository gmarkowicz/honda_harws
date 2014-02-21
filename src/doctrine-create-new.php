<?php
// die on no cli call's
define("BASEPATH",".");
define("APPPATH",realpath(dirname(__FILE__).'/application'));
if(php_sapi_name() != 'cli' && !empty($_SERVER['REMOTE_ADDR'])) {
    die;
}
require_once dirname(__FILE__) . '/application/helpers/doctrine/lib/Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
spl_autoload_register(function($className){
	global $config_doctrine;
	$path = $config_doctrine['models_path'].'/generated/'.$className.'.php';
	if (file_exists($path))
	{
		require_once $path;
	}
});

	require_once dirname(__FILE__) . '/application/config/database.php';
	$connection_name = 'harws2';

	// local one
	$db['harws2']['hostname'] = "localhost";
	$db['harws2']['username'] = "root";
	$db['harws2']['password'] = "";
	$db['harws2']['database'] = "harws_local";
	$db['harws2']['dbdriver'] = "mysql";
	$db['harws2']['dbprefix'] = "";
	$db['harws2']['pconnect'] = FALSE;
	$db['harws2']['db_debug'] = TRUE;
	$db['harws2']['cache_on'] = FALSE;
	$db['harws2']['cachedir'] = "";
	$db['harws2']['char_set'] = "utf8";
	$db['harws2']['dbcollat'] = "utf8_general_ci";
	$db['harws2']['swap_pre'] = '';
	$db['harws2']['autoinit'] = FALSE;
	$db['harws2']['stricton'] = FALSE;

  // first we must convert to dsn format
  $dsn = $db[$connection_name]['dbdriver'] .
		'://' . $db[$connection_name]['username'] .
		':' . $db[$connection_name]['password'].
		'@' . $db[$connection_name]['hostname'] .
		'/' . $db[$connection_name]['database'];
  $conn = Doctrine_Manager::connection($dsn,$connection_name);
  $conn->setCharset($db[$connection_name]['char_set']);
  $conn->setCollate($db[$connection_name]['dbcollat']);

$cli = new Doctrine_Cli($config_doctrine);
$cli->run($_SERVER['argv']);
