<?php

/**
 * Comunicacion_Aviso_Adjunto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Comunicacion_Aviso_Adjunto.php 1037 2013-05-17 19:00:17Z slopez $
 */
class Comunicacion_Aviso_Adjunto extends BaseComunicacion_Aviso_Adjunto
{
	public function get_all()
	{
		$query = Doctrine_Query::create();
		$query->from(get_class($this));
		$query->where("1 = 1");
		return $query;
	}
}