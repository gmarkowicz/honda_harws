<?php

/**
 * Reclamo_Garantia_Valor_Alca
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Reclamo_Garantia_Valor_Alca extends BaseReclamo_Garantia_Valor_Alca
{
	public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) .' RECLAMO_GARANTIA_VALOR_ALCA ');
        $query->where("1 = 1");
        return $query;
    }
}