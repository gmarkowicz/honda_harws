<?php

/**
 * Reclamo_Garantia_Version_Adjunto_Transporte
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Reclamo_Garantia_Version_Adjunto_Transporte.php 489 2012-11-29 22:43:51Z slopez $
 */
class Reclamo_Garantia_Version_Adjunto_Transporte extends BaseReclamo_Garantia_Version_Adjunto_Transporte
{
	 public function setUp() {
	
		$this->hasOne('Reclamo_Garantia_Version', array(
			'local' => 'reclamo_garantia_version_id',
            'foreign' => 'id'
        ));
	}
}