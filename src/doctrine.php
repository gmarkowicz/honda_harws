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
unset($db['harws']);
foreach ($db as $connection_name => $db_values) {

  // first we must convert to dsn format
  $dsn = $db[$connection_name]['dbdriver'] .
		'://' . $db[$connection_name]['username'] .
		':' . $db[$connection_name]['password'].
		'@' . $db[$connection_name]['hostname'] .
		'/' . $db[$connection_name]['database'];
  $conn = Doctrine_Manager::connection($dsn,$connection_name);
  $conn->setCharset($db[$connection_name]['char_set']);
  $conn->setCollate($db[$connection_name]['dbcollat']);
}

$cli = new Doctrine_Cli($config_doctrine);
$cli->run($_SERVER['argv']);
