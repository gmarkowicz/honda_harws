<?php

/**
 * Comunicacion_Evento
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Comunicacion_Evento.php 610 2013-01-15 06:43:25Z agusquiroga $
 */
class Comunicacion_Evento extends BaseComunicacion_Evento
{

	public function get_all()
	{
		$query = Doctrine_Query::create();
		$query->from(get_class($this));
		$query->where("1 = 1");
		return $query;
	}

}