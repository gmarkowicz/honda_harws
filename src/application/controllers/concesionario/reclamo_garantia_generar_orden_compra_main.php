<?php
/*

	genera la orden de compra a partir de los reclamos pre aprobados....

*/
define('ID_SECCION',3073);

class Reclamo_Garantia_Generar_Orden_Compra_Main extends Backend_Controller {
			
	function Reclamo_Garantia_Generar_Orden_Compra_Main()
	{
		parent::Backend_Controller();
	}


	function index()
	{	
		
		$rg = new Reclamo_Garantia();
		$q = $rg->get_all();
		$q->addWhere('RECLAMO_GARANTIA.reclamo_garantia_estado_id = ?',2); // aprobados
		$q->orderBy('SUCURSAL.sucursal_field_desc');
		$result = $q->execute(array(),Doctrine_Core::HYDRATE_ARRAY);
		$this->template['result'] = $result;
		$this->_view();
		
	}
	
	
	
	public function generar()
	{
		if(isset($_POST['aprobar']) && is_array($_POST['aprobar']))
		{
			$form_error = FALSE;
			$ingresar = array();
			
			while (list(,$id_reclamo) = each($_POST['aprobar']))
			{
				if(is_numeric($id_reclamo))
				{
					
					
					$q = Doctrine_Query::create();
					$q->select('SUCURSAL.id AS sucursal_id,
								RECLAMO_GARANTIA.id as reclamo_garantia_id,
								RECLAMO_GARANTIA_VERSION_HONDA.reclamo_garantia_version_field_valor_reclamado as valor_reclamado_honda,
								RECLAMO_GARANTIA_VERSION_JAPON.reclamo_garantia_version_field_valor_reclamado as valor_reclamado_japon
								');
					
					$q->from('Reclamo_Garantia RECLAMO_GARANTIA ');
					$q->leftJoin('RECLAMO_GARANTIA.Reclamo_Garantia_Version RECLAMO_GARANTIA_VERSION_HONDA ON RECLAMO_GARANTIA_VERSION_HONDA.reclamo_garantia_id = RECLAMO_GARANTIA.id AND RECLAMO_GARANTIA_VERSION_HONDA.reclamo_garantia_version_field_desc = ? ','HONDA');
					$q->leftJoin('RECLAMO_GARANTIA.Reclamo_Garantia_Version RECLAMO_GARANTIA_VERSION_JAPON ON RECLAMO_GARANTIA_VERSION_JAPON.reclamo_garantia_id = RECLAMO_GARANTIA.id AND RECLAMO_GARANTIA_VERSION_JAPON.reclamo_garantia_version_field_desc = ? ','JAPON');
					$q->leftJoin('RECLAMO_GARANTIA.Tsi TSI ');
					$q->leftJoin('TSI.Sucursal SUCURSAL ');
					$q->where('RECLAMO_GARANTIA.reclamo_garantia_estado_id = ?',2); //aprobados
					$q->addWhere('RECLAMO_GARANTIA.reclamo_garantia_orden_compra_id < ?',1); //no tiene orden de compra
					$q->addWhere('RECLAMO_GARANTIA.id = ?',$id_reclamo);
				
					if($q->count()!=1)
					{
						$form_error = TRUE;
					}
					else
					{
						$row = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
						$ingresar[ $row['sucursal_id'] ] [$row['reclamo_garantia_id']] ['honda'] = $row['valor_reclamado_honda'];
						$ingresar[ $row['sucursal_id'] ] [$row['reclamo_garantia_id']] ['japon'] = $row['valor_reclamado_japon'];
						//$ingresar[ $row['sucursal_id'] ] [$row['reclamo_garantia_id']] ['fecha'] = $row['reclamo_fecha'];
						//$ingresar[ $row['sucursal_id'] ] [$row['reclamo_garantia_id']] ['nombre'] = $row['concesionario_nombre'];
					}
					
					
				}
			}
		
			if(!$form_error && count($ingresar)>0)
			{
				reset($ingresar);
				try {
					while (list($sucursal_id,$datos) = each($ingresar))
					{
						$total_honda = 0;
						$total_japon = 0;
						
						$orden_compra = new Reclamo_Garantia_Orden_Compra();
						$orden_compra->sucursal_id = $sucursal_id;
						$orden_compra->reclamo_garantia_orden_compra_field_admin_alta_id = $this->session->userdata('admin_id');
						$orden_compra->reclamo_garantia_orden_compra_field_mail_enviado = 0;
						$orden_compra->save();
						
						
						
						while (list($reclamo_garantia_id,$valor) = each($datos)) 
						{
							
							if(!is_numeric($valor['japon']))
								$valor_japon = 0;
							
							if(!is_numeric($valor['honda']))
								$valor_honda = 0;
							
							$total_japon+=$valor['japon'];
							$total_honda+=$valor['honda'];
							
							//actualizo la orden de compra a id 3 (orden de compra generada) al reclamo correspondiente 
							$q = Doctrine_Query::create()
							->update('Reclamo_Garantia')
							->set('reclamo_garantia_estado_id', 3)
							->set('reclamo_garantia_orden_compra_id', $orden_compra->id)
							->where('id = ?',$reclamo_garantia_id);
							$rows = $q->execute();
							if($rows != 1)
							{
								show_error(__LINE__ . __FILE__ . ' error actualizando estado');
							}
						
						}
						
					
						$orden_compra->reclamo_garantia_orden_compra_field_valor_honda = $total_honda;
						$orden_compra->reclamo_garantia_orden_compra_field_valor_japon = $total_japon;
						$orden_compra->save();
					
					}
				} catch (Doctrine_Connection_Exception $e) {
					$error=array();
					$error['line'] 		= __LINE__;
					$error['file'] 		= __FILE__;
					$error['error']		= 'error generando ordenes de compra';
					$error['message']	= $e->getPortableMessage();
					$error['sql'] 		= $q->getSqlQuery();
					$this->backend->_log_error($error);
					show_error( $e->getPortableMessage() . __LINE__ . __FILE__ );
				}
			
			
				$this->session->set_flashdata('ordenes_de_compra_generadas', count($ingresar));
			
			}
			else
			{
				
				$this->session->set_flashdata('error_generando_orden_compra',TRUE);
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
