<?php

/**
 * Boutique_Talle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Boutique_Talle.php 98 2012-08-02 19:31:55Z mprado $
 */
class Boutique_Talle extends BaseBoutique_Talle
{
    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) .' BOUTIQUE_TALLE ');
        $query->where("1 = 1");
        return $query;
    }
}