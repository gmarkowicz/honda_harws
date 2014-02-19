<?php
define('ID_SECCION',3071);
class Reclamo_Garantia_Bulk_Print extends Backend_Controller{
	
	
	var $estados_invalidos =  array(2,3,9); //aprobado, orden compra generada, rechazado
	
	
	function __construct()
	{
		
		parent::Backend_Controller();
		$this->load->library('r_garantia');
		
		/*upload y validaciones de archivo...*/
		$this->load->helper('inflector');
		$this->load->library('upload');
		$this->lang->load('upload');
		$this->load->helper('string');
		$this->load->library('Multi_upload');
		
		
		
		
	}
				
	

	
	public function show( $params = '')
	{
		
		
		
		$ids = explode('-',$params);
		if(count($ids)>0)
		{
			$rg = new Reclamo_Garantia();
			$q = $rg->get_all();
			$q->whereIn('TSI.sucursal_id',$this->session->userdata('sucursales'));
			$q->whereIn('RECLAMO_GARANTIA.id',$ids);
			if(!$this->backend->_permiso('admin'))
			{
				$q->addWhere('RECLAMO_GARANTIA_VERSION.reclamo_garantia_version_field_desc = ?','CONCESIONARIO');
				$this->template['rg_version'] = 'CONCESIONARIO';
			}
			else
			{
				$q->addWhere('RECLAMO_GARANTIA_VERSION.reclamo_garantia_version_field_desc = ?','HONDA');
				$this->template['rg_version'] = 'HONDA';
			}
			
			if($q->count()>0)
			{
				$this->template['records'] = $q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
				
				$this->load->view('backend/reclamo_garantia_bulk_print_view',$this->template);
			}
		}
		
	}
	
	
	
	
	
}       
