<?php

/**
 * Boutique_Disponibilidad
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Boutique_Disponibilidad.php 98 2012-08-02 19:31:55Z mprado $
 */
class Boutique_Disponibilidad extends BaseBoutique_Disponibilidad
{
    public function get_all()
    { 
	$query = Doctrine_Query::create();	
	$query->from(get_class($this) .' BOUTIQUE_DISPONIBILIDAD ');
	$query->where("1 = 1");			
	return $query;
    }
}