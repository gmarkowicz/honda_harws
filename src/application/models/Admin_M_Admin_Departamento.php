<?php

/**
 * Admin_M_Admin_Departamento
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Admin_M_Admin_Departamento.php 109 2012-08-09 18:04:11Z agusquiroga $
 */
class Admin_M_Admin_Departamento extends BaseAdmin_M_Admin_Departamento
{

    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this));
        $query->where("1 = 1");
        return $query;
    }
}