<?php

/**
 * Comunicacion_Logo_Adjunto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Comunicacion_Logo_Adjunto.php 1038 2013-05-17 19:00:33Z slopez $
 */
class Comunicacion_Logo_Adjunto extends BaseComunicacion_Logo_Adjunto
{
	public function get_all()
	{
		$query = Doctrine_Query::create();
		$query->from(get_class($this));
		$query->where("1 = 1");
		return $query;
	}
}