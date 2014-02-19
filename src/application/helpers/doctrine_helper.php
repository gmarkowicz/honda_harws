<?php
// system/application/plugins/doctrine_pi.php

// load Doctrine library
//require_once APPPATH.'/plugins/doctrine/lib/Doctrine.compiled.mysql.php';
require_once dirname(__FILE__) . '/doctrine/lib/Doctrine.php';

// load database configuration from CodeIgniter
require_once APPPATH.'/config/database.php';

// this will allow Doctrine to load Model classes automatically
spl_autoload_register(array('Doctrine', 'autoload'));
spl_autoload_register('docAutoload');
function docAutoload($className){
	global $config_doctrine;
	$path = DOCTRINE_MODEL_DIR.'/generated/'.$className.'.php';
	if (file_exists($path))
	{
		require_once $path;
	}
}
//optional compilamos para mysql
//Doctrine_Core::compile('Doctrine.compiled.php', array('mysql'));

// we load our database connections into Doctrine_Manager
// this loop allows us to use multiple connections later on
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

// CodeIgniter's Model class needs to be loaded
require_once BASEPATH.'/core/Model.php';

Doctrine_Manager::getInstance()->setAttribute('model_loading', 'conservative');

// telling Doctrine where our models are located
Doctrine::loadModels(APPPATH.'/models');

// (OPTIONAL) CONFIGURATION BELOW

//softdelete

Doctrine_Manager::getInstance()->setAttribute(
	Doctrine::ATTR_USE_DQL_CALLBACKS, true);

// this will allow us to use "mutators"
/*
Doctrine_Manager::getInstance()->setAttribute(
	Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
*/

	
Doctrine_Manager::getInstance()->setAttribute(
	Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS,
	true
);

/*
Doctrine_Manager::getInstance()->registerHydrator('custom', 'Doctrine_Hydrator_Custom'); //TODO deprecated, eliminar archivo y eliminar hydrator
*/
/*
It is correct for query cache, once enabled, it  
is used on all queries except if you explicitly disable it on a  
specific query. The result cache on the other hand works the other way  
around, after you've set the cache driver to use, you need to tell  
individual queries to use it.

They behave this way for logical reasons. It usually doesnt make sense  
to use a query cache only on some queries and it usually doesnt make  
sense to cache the results of all queries, giving you potentially  
stale data everywhere. 
*/


$manager = Doctrine_Manager::getInstance();
$manager->setAttribute(Doctrine_Core::ATTR_QUERY_CACHE, new Doctrine_Cache_Apc());
$manager->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, new Doctrine_Cache_Apc());
//$manager->setAttribute(Doctrine_Core::ATTR_QUERY_CACHE, new Doctrine_Cache_Array());
//$manager->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, new Doctrine_Cache_Array());

$manager->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE_LIFESPAN, 3600);



// this sets all table columns to notnull and unsigned (for ints) by default
Doctrine_Manager::getInstance()->setAttribute(
	Doctrine::ATTR_DEFAULT_COLUMN_OPTIONS,
	array('notnull' => true, 'unsigned' => true));

// set the default primary key to be named 'id', integer, 4 bytes
Doctrine_Manager::getInstance()->setAttribute(
	Doctrine::ATTR_DEFAULT_IDENTIFIER_OPTIONS,
	array('name' => 'id', 'type' => 'integer', 'length' => 4));

//if you wish to use native enum types for your DBMS if it supports it then you must set the following attribute:
Doctrine_Manager::getInstance()->setAttribute(
	Doctrine::ATTR_USE_NATIVE_ENUM, true);
