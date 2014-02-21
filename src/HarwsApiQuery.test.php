<?php
require 'HarwsApiQuery.class.php';

echo "<pre>";
$api = new HarwsApiQuery('5150348f39a4f', 'http://190.221.169.203/api/usados');
$api->setDebug(true);
$response = $api->call('/usado');
if (is_array($response['usado']))
{
	$pager = new HarwsApiQueryPager($response['usado']);
}
var_dump($pager->getNext());