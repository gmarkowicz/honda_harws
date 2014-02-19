<?php
/*

	aprueba reclamos de garantia pre aprobados

*/
define('ID_SECCION',3072);

class Reclamo_Garantia_Aprobar_Main extends Backend_Controller {
	
	
	var $base_query = FALSE;
	var $maximo_importe_auto = 5000;
	
	
	function Reclamo_Garantia_Aprobar_Main()
	{
		parent::Backend_Controller();
		$this->base_query = Doctrine_Query::create();
        $this->base_query->from('Reclamo_Garantia RECLAMO_GARANTIA ');
		$this->base_query->leftJoin('RECLAMO_GARANTIA.Reclamo_Garantia_Version RECLAMO_GARANTIA_VERSION ');
		$this->base_query->leftJoin('RECLAMO_GARANTIA.Tsi TSI ');
		$this->base_query->leftJoin('TSI.Sucursal SUCURSAL ');
		$this->base_query->leftJoin('TSI.Unidad UNIDAD ');
        $this->base_query->where('RECLAMO_GARANTIA.reclamo_garantia_estado_id = ?',13); // pre aprobado
		$this->base_query->addWhere('RECLAMO_GARANTIA.reclamo_garantia_orden_compra_id < ?',1); //no tiene orden de compra
		$this->base_query->whereIn('RECLAMO_GARANTIA_VERSION.reclamo_garantia_version_field_desc',array('HONDA','JAPON')); //version honda
		
	}


	function index()
	{	
		
		$q = clone $this->base_query;
		$result = $q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		
		
		//busco garantias sin problemas
		
		$q = clone $this->base_query;
		$q->addWhere('RECLAMO_GARANTIA.reclamo_garantia_field_problemas != ?',1); //no tiene problemas
		$q->addWhere('RECLAMO_GARANTIA_VERSION.reclamo_garantia_version_field_valor_reclamado <= ?',$this->maximo_importe_auto); //tiene menos de 5k de precio
		$result1 = $q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		$sin_problemas = array();
		foreach($result1 as $sin_problema)
		{
			$sin_problemas[$sin_problema['id']] = TRUE;
		}
		
		$this->template['result'] = $result;
		$this->template['sin_problemas'] = $sin_problemas;
		
		
		$this->_view();
		
		
	}
	
	
	public function reject($id_reclamo)
	{
		$q = clone $this->base_query;
		$q->addWhere('RECLAMO_GARANTIA.id = ?',$id_reclamo);
		if($q->count()==1)
		{
			$reclamo = $q->fetchOne();
			//paso reclamo a estado rechazado
			$reclamo->reclamo_garantia_estado_id = 9;
			$reclamo->reclamo_garantia_field_admin_rechaza_id = $this->session->userdata('admin_id');
			$reclamo->reclamo_garantia_field_rechazo_motivo = NULL;
			$reclamo->reclamo_garantia_field_admin_modifica_id = $this->session->userdata('admin_id');
			$reclamo->reclamo_garantia_field_fechahora_modificacion = date('Y-m-d H:i:s', time());
			$reclamo->save();
			$this->session->set_flashdata('edit_ok', true);
		}
		
		redirect($this->get_main_url());
	}
	
	public function aprueba($id_reclamo)
	{
		if($this->input->post('_submit'))
		{
			$q = clone $this->base_query;
			$q->addWhere('RECLAMO_GARANTIA.id = ?',$id_reclamo);
			if($q->count()==1)
			{
				$reclamo = $q->fetchOne();
				//apruebo el reclamo
				$reclamo->reclamo_garantia_estado_id = 2;
				$reclamo->reclamo_garantia_field_admin_aprueba_id = $this->session->userdata('admin_id');
				$reclamo->reclamo_garantia_field_fechahora_aprobacion = date('Y-m-d H:i:s', time());
				$reclamo->reclamo_garantia_field_aprueba_comentarios = $this->form_validation->xss_clean($this->input->post('comentarios'));
				$reclamo->save();
				$this->session->set_flashdata('edit_ok', true);
			}
		}
		
		
		redirect($this->get_main_url());
	}
	
	
	public function auto_aprueba()
	{
		if($this->input->post('AprobarAuto'))
		{
			$q = clone $this->base_query;
			$q->addWhere('RECLAMO_GARANTIA.reclamo_garantia_field_problemas != ?',1); //no tiene problemas
			$q->addWhere('RECLAMO_GARANTIA_VERSION.reclamo_garantia_version_field_valor_reclamado <= ?',$this->maximo_importe_auto); //tiene menos de 5k de precio
			
		try {
			$cantidad =  $q->count();
			if($cantidad>0)
			{
				$reclamos = $q->execute();
				foreach($reclamos as $reclamo)
				{
					//apruebo el reclamo
					$reclamo->reclamo_garantia_estado_id = 2;
					$reclamo->reclamo_garantia_field_admin_aprueba_id = $this->session->userdata('admin_id');
					$reclamo->reclamo_garantia_field_fechahora_aprobacion = date('Y-m-d H:i:s', time());
					$reclamo->reclamo_garantia_field_aprueba_comentarios = NULL;
					$reclamo->save();
				}
				
				$this->session->set_flashdata('reclamos_aprobados', $cantidad);
			}
		} catch (Doctrine_Connection_Exception $e) {
			$error=array();
			$error['line'] 		= __LINE__;
			$error['file'] 		= __FILE__;
			$error['error']		= 'error aprobando reclamos';
			$error['message']	= $e->getPortableMessage();
			$error['sql'] 		= $q->getSqlQuery();
			$this->backend->_log_error($error);
			show_error( $e->getPortableMessage() . __LINE__ . __FILE__ );
		}
			
			
			
			
		}
		
		redirect($this->get_main_url());
	}
	
	
	
	private function _view()
	{
		
		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['tpl_include'] = $this->get_template_view();
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
