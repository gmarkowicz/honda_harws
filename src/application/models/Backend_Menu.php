<?php

/**
 * Backend_Menu
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Backend_Menu.php 97 2012-08-01 21:57:04Z mprado $
 */
class Backend_Menu extends BaseBackend_Menu
{
    
    public function setUp()
    {
        $options = array(
                'hasManyRoots'     => true,
                'rootColumnName'   => 'root_id',
                'orderBy'          => 'backend_menu_field_desc ASC'
            );
        
        $this->actAs('NestedSet', $options);
		
	$this->hasMany('Grupo as Backend_Menu_M_Grupo', array(
                'refClass' => 'Grupo_M_Backend_Menu',
                'local' => 'backend_menu_id',
                'foreign' => 'grupo_id'
            ));		
    }
	
    public function get_all()
    {
        $query = Doctrine_Query::create();
        $query->from(get_class($this));
        $query->where("1 = 1");
        return $query;
    }

}