<?php

/**
 * Servicio_Noticia
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Servicio_Noticia extends BaseServicio_Noticia
{
	public function get_all()
    {
	$query = Doctrine_Query::create();
	$query->from(get_class($this) .' SERVICIO_NOTICIA ');
	$query->leftJoin('SERVICIO_NOTICIA.Servicio_Noticia_Adjunto SERVICIO_NOTICIA_ADJUNTO ');
	$query->where("1 = 1");
	return $query;
    }
}