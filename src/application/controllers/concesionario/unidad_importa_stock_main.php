<?php
define('ID_SECCION',1026);

class Unidad_importa_stock_main extends Backend_Controller {
	
			
			
	function Unidad_importa_stock_main()
	{
		parent::Backend_Controller();
		ini_set('max_execution_time',1330360);
		ini_set('memory_limit', '3000M');
		
	}


	function index()
	{	
		
		$this->load->helper('spreadsheet_excel_reader');
		$data = new Spreadsheet_Excel_Reader();
		
		if($this->input->post('_submit'))
		{
			//
			$aux_array_error=array();
			$z=0;

			## upload archivo ##
			if(isset($_FILES['unidad_stock'])){
				//require(APP_ROOT . '/' . INCLUDES_DIR . '/' . CLASSES_DIR . '/excelreader/reader.php');
				

				//$this->load->helper('spreadsheet_excel_reader');
				$pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
				
				
				$data->setOutputEncoding('CP1251');
				$data->read($_FILES['unidad_stock']['tmp_name']);
				
				$registros=count($data->sheets[0]['cells']);
				
				$unidades=array();
				for ($i = 2; $i<=$registros; $i++) {
					if(is_numeric($data->sheets[0]['cells'][$i][1]) && strlen($data->sheets[0]['cells'][$i][3])>0){			
						if(isset($data->sheets[0]['cells'][$i][9])){
							$fecha1 = ($data->sheets[0]['cells'][$i][9] + 1 - 25569.874999) * 86400;
							$fecha = date("Y-m-d",$fecha1);
						}else{
							$fecha="";
						}
						
							$id_concesionario=trim($data->sheets[0]['cells'][$i][1]);
							$unidad=trim($data->sheets[0]['cells'][$i][3]);
							$estado=trim($data->sheets[0]['cells'][$i][6]);
							

							if(!isset($unidades[$unidad]))
							{
								$unidades[$unidad]=TRUE;
							}
							else
							{
								//los humanos tienen muchos errores....
								$aux_array_error[]=$unidad.": registro duplicado";
							}
							
							
							#busco unidad
							
							$q = "SELECT id FROM unidad WHERE unidad_field_unidad = :param1";
							$stmt = $pdo->prepare($q);
							$params = array(
							  "param1"  => $unidad
							);
							$stmt->execute($params);

							$unidad = $stmt->fetch();  
							if(!$unidad)
							{
								$aux_array_error[]="no se encuentra unidad: ".$unidad;
							}
							else
							{
								//$sql="UPDATE ".$_config['db']['prefix']."unidad SET id_concesionario='".sql_in($id_concesionario)."', id_estado='".sql_in($estado)."', fecha_venta='".sql_in($fecha)."' WHERE unidad='".sql_in($unidad)."'";
					
								
								$q = "UPDATE unidad SET sucursal_id = :param1, unidad_estado_id = :param2, unidad_field_fecha_venta = :param3, updated_at = NOW() WHERE id = :param4 ";
								$stmt = $pdo->prepare($q);
								$params = array(
								  "param1"  => $id_concesionario,
								  'param2'	=> $estado,
								  'param3'	=> $fecha,
								  'param4'	=> $unidad['id']
								);
								$stmt->execute($params);
								
								$z++;
							}
							
							
							unset($unidad);
						
					}
					

				}
				
				
				
				$this->template['unidades_importadas'] =  $z;
				
				if(count($aux_array_error)>0)
				{
					$this->template['importa_stock_upload_error'] =  $aux_array_error;
				}
				
				/*
				if(count($aux_array_error)>0){
					$smarty->assign('SHOW_ERROR', true);
					while (list(,$val) = each($aux_array_error)) {
						$smarty->append('ERRORES', array(
							'ERROR'=>$val,
						));
					}
				}
				*/
				
				//$smarty->assign('SHOW_UNIDADES_IMPORTADAS', true);
				//$smarty->assign('CANTIDAD_UNIDADES', $z);
			}
			//
		}
		
		
		$this->_view();
		
	}

	
		
	
	

	private function _view()
	{
		
		$this->template['tpl_include'] = 'backend/unidad_importa_stock_main_view';
		$this->load->view('backend/esqueleto_view',$this->template);
		//-------------------------[/vista generica]
	}

}
