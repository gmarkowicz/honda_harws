<?php
// die on no cli call's
define("BASEPATH",".");
define("APPPATH",realpath(dirname(__FILE__).'/application'));
if(php_sapi_name() != 'cli' && !empty($_SERVER['REMOTE_ADDR'])) {
    die;
}
require_once dirname(__FILE__) . '/application/helpers/doctrine/lib/Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
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

$models = Doctrine::loadModels($config_doctrine['models_path'].'_old');

$present_yml = $config_doctrine['yaml_schema_path'].'/schema.yml';
$new_yml = $config_doctrine['yaml_schema_path'].'/schema_new.yml';
$yaml = sfYaml::load($present_yml);

foreach ($models as $model)
{
	$tmp = new $model();
	$options = $tmp->getTable()->getOptions();
	// busca el modelo correspondiente y aplica el indice al mismo
	foreach ($yaml as $yaml_key => $yaml_item)
	{
		if ($yaml_key != $model) 
			continue;
		else {
			if (count($options['indexes']))
			{
				$yaml[$yaml_key]['indexes'] = $options['indexes'];
			}
		}
	}
}
$content = sfYaml::dump($yaml,3);
file_put_contents($new_yml, $content);
