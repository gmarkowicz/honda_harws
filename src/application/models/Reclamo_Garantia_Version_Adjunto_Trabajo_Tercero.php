<?php

/**
 * Reclamo_Garantia_Version_Adjunto_Trabajo_Tercero
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Honda_HARWS
 * @subpackage Doctrine
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Reclamo_Garantia_Version_Adjunto_Trabajo_Tercero.php 523 2012-12-11 19:04:21Z slopez $
 */
class Reclamo_Garantia_Version_Adjunto_Trabajo_Tercero extends BaseReclamo_Garantia_Version_Adjunto_Trabajo_Tercero
{
	 public function setUp() {
	
		$this->hasOne('Reclamo_Garantia_Version', array(
			'local' => 'reclamo_garantia_version_id',
            'foreign' => 'id'
        ));
	}
}