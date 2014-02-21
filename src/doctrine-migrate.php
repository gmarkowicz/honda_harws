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
function delAllFiles($path)
{
	foreach(glob($path . '/*') as $file) {
		unlink($file);
	}
}
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

	echo "\nLeyendo base de datos...";
	$db_yml = $config_doctrine['yaml_schema_path'].'/db.yml';
	$new_yml = $config_doctrine['yaml_schema_path'].'/schema.yml';
	$db_empty = false;
	try {
		Doctrine::generateYamlFromDb($db_yml, array('harws2'));
	} catch (Exception $e)
	{
		echo "\n".$e->getMessage();
		if ($e->getMessage()=='No models generated from your databases')
		{
			$db_empty = true;
		} else {
			throw $e;
		}
	}
	
	echo "\nGenerando nuevas clases...";
	Doctrine::generateModelsFromYaml($config_doctrine['yaml_schema_path'], $config_doctrine['models_path']);
	
	if ($db_empty == false)
	{
		echo "\nCalculando diferencia...";
		Doctrine::generateMigrationsFromDiff($config_doctrine['migrations_path'], $db_yml, $new_yml);
		unlink($db_yml);
		echo "\nPor favor, ejecute el comando \"php doctrine.php migrate\"";
	} else {
		echo "\nCreando la base de datos ...";
		Doctrine::createTablesFromModels($config_doctrine['models_path']);
	}
	
	
	echo "\nTerminado...";
	