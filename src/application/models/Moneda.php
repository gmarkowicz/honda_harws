<?php

/**
 * Moneda
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Moneda.php 226 2012-09-19 13:06:54Z slopez $
 */
class Moneda extends BaseMoneda
{
	public function setUp() {
		
        $this->actAs('Timestampable');
        $this->actAs('SoftDelete');
    }

    public function get_all($config = array())
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this));
        $query->where("1 = 1");
        return $query;
    }
}