<?php

/**
 * Tsi_Mailing_Encuesta_Satisfaccion_Estado
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Tsi_Mailing_Encuesta_Satisfaccion_Estado extends BaseTsi_Mailing_Encuesta_Satisfaccion_Estado
{
     public function get_all($id = false)
     {
        $query = Doctrine_Query::create();
        $query->from(get_class($this) . ' TSI_ENCUESTA_SATISFACCION_ESTADO ');

        $query->where("1 = 1");
        
        if ($id == 1 || $id == 2) {
            $query->where(" id IN (1, 2)");            
        }    
        elseif ($id == 3) {
            $query->where(" id IN (3, 4)");
        }
        elseif ($id == 4)
        {            
            $query->where(" id IN (4)");
        }
        elseif ($id == 5)
        {            
            $query->where(" id IN (5)");
        }
        else
        {                  
            $query->where(" id IN (1)");        
        }
        
        return $query;
     }
}