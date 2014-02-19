<?php
/*
TODO
ojo, aca hay un bug, no esta validando sucursal id
 */
define('ID_SECCION', 3081);
class Reclamo_Garantia_Campania_Abm extends Backend_Controller {

	//objeto actual de doctrine
	var $registro_actual = FALSE;

	//filtra por sucursal?
	//var $sucursal = FALSE;

	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;

	//subfix de archivos adjuntos
	var $upload_adjunto = array('adjunto');

	//separador CSV
	var $separador_vin = ";";

	//Path archivo CSV
	var $path_vin = "";

	//Vines Inexistentes
	var $not_vin;

	//subfix de imagenes adjuntas
	//var $upload_image = array();

	function __construct() {
		parent::Backend_Controller();
	}

	public function add() {

		$this->template['register_count'] = false;

		$config = array();

		$config['upload_path'] = FCPATH
				. 'public/uploads/reclamo_garantia_campania/vin';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '100000';
		$config['encrypt_name'] = TRUE;
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);

		if ($this->input->post('_submit')) {

			if ($this->_validar_formulario() == TRUE) {
				if (!$this->upload->do_upload('vin_file')
						&& $this->router->method == 'add') {
					$this->template['upload_error'] = $this->lang
							->line('reclamo_garantia_file_error');
				} else {
					$data = $this->upload->data();
					$this->path_vin = $data['full_path'];
					if ($this->validateCsv($this->path_vin)) {
						$this->registro_actual = $this->registro_actual
								!= null ? $this->registro_actual
								: new Reclamo_Garantia_Campania();
						$do_save = $this->_grabar_registro_actual();
						if (!empty($this->redirect_to_edit_on_add)
								|| $do_save) {
							$this->session->set_flashdata('add_ok', true);
							$this->session
									->set_userdata(
											'last_add_'
													. $this->router->class,
											$this->registro_actual->id);
							if (!empty($this->template['upload_error'])
									&& is_array(
											$this->template['upload_error']))
								$this->session
										->set_flashdata('upload_error',
												$this
														->template['upload_error']);
							redirect(
									$this->get_abm_url() . '/edit/'
											. $this->registro_actual->id);
						}
					}
				}
			}
		}

		$this->_view();
	}

	public function edit($id = FALSE) {
		$config = array();

		$config['upload_path'] = FCPATH
				. 'public/uploads/reclamo_garantia_campania/vin';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '100000';
		$config['encrypt_name'] = TRUE;
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);

		$this->_set_record($id);
		if ($this->input->post('_submit')) {
			if ($this->_validar_formulario() == TRUE) {
				if (!$this->upload->do_upload('vin_file')
						&& $this->router->method == 'add') {
					$this->template['upload_error'] = $this->lang
							->line('reclamo_garantia_file_error');
				} else {
					$data = $this->upload->data();
					$this->path_vin = $data['full_path'];
					if ($this->validateCsv($this->path_vin, false))
					{
						if ($this->_grabar_registro_actual())
						{
							$this->session->set_flashdata('edit_ok', true);
							$this->session
									->set_userdata(
											'last_add_' . $this->router->class,
											$this->registro_actual->id);
							redirect(
									$this->get_abm_url() . '/edit/'
											. $this->registro_actual->id);
						}
					}
				}
			}
		} else {
			//no mando info, muestro la del registro por default
			$this->_mostrar_registro_actual();
		}
		//llamo a la vista
		$this->_view();
	}

	protected function validateCsv($path, $required = true) {
		// campos que debe tener
		if ($path != '' && is_file($path)) {
			$must = array('vin');
			$file = fopen($path, 'r');
			$header = fgetcsv($file, null, $this->separador_vin);
			$return = true;
			if (count($header) != count($must)) {
				$this->template['upload_error'] = $this->lang
						->line('reclamo_garantia_format_error');
				$return = false;
			} else {
				foreach ($must as $pos => $value) {
					if ($header[$pos] != $value) {
						$return = false;
						$this->template['upload_error'] = sprintf(
								$this->lang
										->line('reclamo_garantia_field_error'),
								$header[$pos]);
						break;
					}
				}
			}
		} else {
			$return = $required ? false : true;
		}
		return $return;
	}

	public function reject() {
		if ($this->rechazar_registro === TRUE) {
			$this->_set_record($this->input->post('id'));
			if ($this->_reject_record()) {
				if ($this->input->post('ajax')) {
					//le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
					$this->output->set_output("TRUE");
				}
			}
		}
	}

	public function del() {
		$this->_set_record($this->input->post('id'));
		try {
			$conn = Doctrine_Manager::connection();
			$conn->beginTransaction();

			$delete = new Reclamo_Garantia_Campania_Material();
			$d = $delete->get_all()
					->addWhere('reclamo_garantia_campania_id = ?',
							$this->registro_actual->id)->delete()->execute();

			$delete = new Reclamo_Garantia_Campania_Frt();
			$d = $delete->get_all()
					->addWhere('reclamo_garantia_campania_id = ?',
							$this->registro_actual->id)->delete()->execute();

			$rel = new Reclamo_Garantia_Campania_Unidad();
			$relQuery = $rel->get_all()
					->addWhere(' reclamo_garantia_campania_id = ? ',
							$this->input->post('id'))->delete();

			$this->registro_actual->delete();
			$conn->commit();

		} catch (Doctrine_Exception $e) {
			$conn->rollback();
			$error = array();
			$error['line'] = __LINE__;
			$error['file'] = __FILE__;
			$error['error'] = $e->errorMessage();
			$error['sql'] = 'transaction';
			$this->backend->_log_error($error);
			show_error($e->errorMessage());
		}
		$this->session->set_flashdata('del_ok', true);
		if ($this->input->post('ajax')) {
			//le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
			$this->output->set_output("TRUE");
		}
	}

	public function show($id = FALSE) {
		$this->_set_record($id);
		$this->_mostrar_registro_actual($id);
		$this->_view();
	}

	private function _mostrar_registro_actual() {
		//paranoid (por las dudas vio)
		$_POST = array();
		if ($this->registro_actual) {
			$registro_array = $this->registro_actual->toArray();
			$this->form_validation->set_defaults($registro_array);
			$this->template['registro_actual'] = $this->registro_actual
					->toArray();
		} else {
			$error = array();
			$error['line'] = __LINE__;
			$error['file'] = __FILE__;
			$error['error'] = 'no existe llamada a _set_record?';
			$this->backend->_log_error($error);
			show_error($error['error']);
		}
	}

	private function _grabar_registro_actual() {
		$return = false;
		$conn = Doctrine_Manager::connection();
		$conn->beginTransaction();

		$this->registro_actual->id = $this->input->post('id');
		$this->registro_actual->reclamo_garantia_campania_field_desc = $this
				->input->post('reclamo_garantia_campania_field_desc');
		$this->registro_actual->reclamo_garantia_campania_field_comentario = $this
				->input->post('reclamo_garantia_campania_field_comentario');
		try {
			if ($this->registro_actual->trySave()) {
				$this->redirect_to_edit_on_add = true;
				if ($this->registro_actual != false) {
					if ($this->proccFrts() && $this->proccMaterial()
							&& $this->proccVins()) {
						$return = true;
					}
				}
				$conn->commit();
			} else {
				$conn->rollback();
			}
		} catch (Doctrine_Validator_Exception $e) {
		}
		return $return;
	}
	//-------------------------[graba registro en la base de datos]
	//----------------------------------------------------------------

	private function proccVins() {
		$errores = array();
		$return = true;
		if ($this->path_vin != '' && is_file($this->path_vin)) {
			$data_csv = array('vin');
			$array_csv = $this->getCSVtoArray($this->path_vin, $data_csv);

			$this->not_vin = '';

			//Borra las unidades asociadas para guardar las nuevas
			$delete = new Reclamo_Garantia_Campania_Unidad();
			$d = $delete->get_all()
					->addWhere('reclamo_garantia_campania_id = ?',
							$this->registro_actual->id)->delete()->execute();

			// borramos todos los registros asociados

			foreach ($array_csv as $field) {

				$relacion = new Reclamo_Garantia_Campania_Unidad();

				$unidadSql = new Unidad();
				$unidadSql = $unidadSql->get_all()->addSelect('id')
						->addWhere('unidad_field_vin = ?', $field['vin'])
						->limit(1);

				$unidad = $unidadSql->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

				if ($unidad) {
					$relacion->reclamo_garantia_campania_id = $this
							->registro_actual->id;
					$relacion->unidad_field_vin = element('unidad_field_vin',
							$unidad);
					$relacion->created_at = date('Y-m-d H:m:i');
					try {
						$relacion->save();
					} catch (Exception $e) {
						$errores[] = sprintf(
								$this->lang->line('reclamo_garantia_vin_error'),
								$field['vin']);
					}
				} else {
					$errores[] = sprintf(
							$this->lang->line('reclamo_garantia_vin_invalid'),
							$field['vin']);
				}
			}
		} else {
			if ($this->router->method == 'add')
			{
				$errores[] = $this->lang->line('reclamo_garantia_vin_notfound');
			}
		}
		if (is_array($errores) && count($errores) > 0) {
			$return = false;
			$this->template['upload_error'] = (!empty(
					$this->template['upload_error']) ? $this
							->template['upload_error'] : array()) + $errores;
		}
		return $return;
	}

	private function proccFrts() {
		$errores = array();
		$return = true;

		//Borra los FRT asociados a la campaña para guardar los nuevos FRT
		$delete = new Reclamo_Garantia_Campania_Frt();
		$d = $delete->get_all()
				->addWhere('reclamo_garantia_campania_id = ?',
						$this->registro_actual->id)->delete()->execute();

		// Inserta los checked a la tabla reclamo_garantia_campania_frt
		if ($this->registro_actual != false
				&& is_array($this->input->post('many_frt_id'))) {
			//Asocia en un array el valor de las horas por FRT id
			$frt_hora_array = $this->input->post('many_frt_hora');
			//Asocia en un array el valor de los requeridos por FRT id;
			$frt_requerido_array = $this->input->post('many_frt_requerido');

			$frt_array = array_unique($this->input->post('many_frt_id'));

			foreach ($frt_array as $key_frt => $frt_value_id) {
				$relacion = new Reclamo_Garantia_Campania_Frt();
				$relacion->frt_id = $frt_value_id;
				$relacion->frt_hora = $frt_hora_array[$key_frt];
				$relacion->frt_requerido = (isset(
						$frt_requerido_array[$key_frt])
						&& ($frt_requerido_array[$key_frt] == 1)) ? 1 : 0;
				$relacion->reclamo_garantia_campania_id = $this
						->registro_actual->id;
				$relacion->created_at = date('Y-m-d H:m:i');
				$relacion->updated_at = date('Y-m-d H:m:i');
				try {
					$relacion->save();
				} catch (Exception $e) {
					$errores[] = sprintf(
							$this->lang->line('reclamo_garantia_lon_error'),
							$frt_value_id);
				}
			}
		}

		if (is_array($errores) && count($errores) > 0) {
			$return = false;
			$this->template['upload_error'] = (!empty(
					$this->template['upload_error']) ? $this
							->template['upload_error'] : array()) + $errores;
		}
		return true;
	}

	private function proccMaterial() {
		$errores = array();
		$return = true;

		$delete = new Reclamo_Garantia_Campania_Material();
		$d = $delete->get_all()
				->addWhere('reclamo_garantia_campania_id = ?',
						$this->registro_actual->id)->delete()->execute();

		// Inserta los checked a la tabla reclamo_garantia_campania_repuesto
		if ($this->registro_actual != false
				&& is_array($this->input->post('many_repuesto_id'))) {
			$material_no_exist = array();
			//Asocia en un array el valor de las horas por Repuesto id
			$repuesto_cantidad_array = $this->input
					->post('many_repuesto_cantidad');
			//Asocia en un array el valor de los requeridos por Repuesto id
			$repuesto_requerido_array = $this->input
					->post('many_repuesto_requerido');

			$materiales_array = array_unique(
					$this->input->post('many_repuesto_id'));

			foreach ($materiales_array as $key_material => $material_value_id) {

				if ($material_value_id != '') {
					$relacion = new Reclamo_Garantia_Campania_Material();
					$relacion->material_id = $material_value_id;
					$relacion->material_cantidad = $repuesto_cantidad_array[$key_material];
					$relacion->material_principal = ($key_material == 0) ? 1
							: 0;
					$relacion->material_requerido = (isset(
							$repuesto_requerido_array[$key_material])
							&& ($repuesto_requerido_array[$key_material]
									== 1)) ? 1 : 0;
					$relacion->reclamo_garantia_campania_id = $this
							->registro_actual->id;
					$relacion->created_at = date('Y-m-d H:m:i');
					$relacion->updated_at = date('Y-m-d H:m:i');
					try {
						$relacion->save();
					} catch (Exception $e) {
						$errores[] = sprintf(
								$this->lang
										->line(
												'reclamo_garantia_lon_add_error'),
								$frt_value_id);
					}
				}

			}
		}
		if (is_array($errores) && count($errores) > 0) {
			$return = false;
			$this->template['upload_error'] = (!empty(
					$this->template['upload_error']) ? $this
							->template['upload_error'] : array()) + $errores;
		}
		return $return;
	}

	//-----------------------------------------------------------------------------
	//-------------------------[vista generica abm]
	private function _view() {

		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['main_url'] = $this->get_main_url();
		$this->template['tpl_include'] = $this->get_template_view();
		if ($this->rechazar_registro === TRUE) {
			$this->template['SHOW_RECHAZAR_REGISTRO'] = TRUE;
		} else {
			$this->template['SHOW_RECHAZAR_REGISTRO'] = FALSE;
		}

		if ($this->router->method != 'add') {
			if (!isset($this->template['frts'])) {
				//------------ [select / checkbox / radio reclamo_garantia_campania_id] :(
				$reclamo_garantia_campania_frt = new Reclamo_Garantia_Campania_Frt();
				$q = $reclamo_garantia_campania_frt->get_all();
				$q
						->addWhere('reclamo_garantia_campania_id = ?',
								$this->registro_actual->id);
				$q = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
				$this->template['frts'] = $q;
			}
			if (!isset($this->template['repuesto_principal'])) {
				//------------ [select / checkbox / radio reclamo_garantia_campania_id] :(
				$reclamo_garantia_campania_material = new Reclamo_Garantia_Campania_Material();
				$q = $reclamo_garantia_campania_material->get_all();
				$q
						->addWhere('reclamo_garantia_campania_id = ?',
								$this->registro_actual->id);
				$q->addWhere('material_principal = ?', 1);
				$q = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
				$this->template['repuesto_principal'] = $q;
			}

			if (!isset($this->template['repuestos_secundarios'])) {
				//------------ [select / checkbox / radio reclamo_garantia_campania_id] :(
				$reclamo_garantia_campania_material = new Reclamo_Garantia_Campania_Material();
				$q = $reclamo_garantia_campania_material->get_all();
				$q
						->addWhere('reclamo_garantia_campania_id = ?',
								$this->registro_actual->id);
				$q
						->addWhere(
								'(material_principal <> ? OR material_principal IS NULL)',
								1);
				$q = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
				$this->template['repuestos_secundarios'] = $q;
			}
		}
		$this->template['registro_actual'] = $this->registro_actual;
		$this->load->view('backend/esqueleto_view', $this->template);
	}
	//-------------------------[vista generica]
	//-----------------------------------------------------------------------------

	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------
	//http://codeigniter.com/user_guide/libraries/form_validation.html
	//required|matches[form_item]|min_length[6]|max_length[12]|exact_length[8]|alpha|alpha_numeric|
	//alpha_dash|numeric|integer|is_natural|is_natural_no_zero|valid_email|valid_emails|valid_ip|valid_base64
	//my_unique_db[Modelo.tabla_field_campo '.$id.']
	//mysql_date_to_form my_form_date_reverse
	//my_db_value_exist[Modelo.campo]
	private function _validar_formulario() {
		if ($this->registro_actual) {
			$id = $this->registro_actual->id;
		} else {
			$id = FALSE;
		}

		$this->form_validation
				->set_message('is_natural_no_zero',
						$this->lang->line('form_seleccione'));
		$this->form_validation
				->set_rules('id', $this->marvin->mysql_field_to_human('id'),
						'trim|max_length[4]|required');
		$this->form_validation
				->set_rules('reclamo_garantia_campania_field_desc',
						$this->marvin
								->mysql_field_to_human(
										'reclamo_garantia_campania_field_desc'),
						'trim|max_length[255]|required');
		$this->form_validation
				->set_rules('reclamo_garantia_campania_field_comentario',
						$this->marvin
								->mysql_field_to_human(
										'reclamo_garantia_campania_field_comentario'),
						'trim|max_length[255]');
		// validar id de campaña como unico
		$existId = false;
		if (trim($this->input->post('id')) != '' && $id == FALSE)
		{
			$existId = new Reclamo_Garantia_Campania();
			$existIdQuery = $existId->get_all()->addWhere(' id = ? ', $this->input->post('id'))->limit(1);
			$existId = $existIdQuery->execute()->toArray();
			if ($existId) {
				$this->template['error_exist_id'] = $this->input->post('id');
			}
		}
		$val1 = $this->_validateRelationsManoDeObra();
		$val2 = $this->_validateRelationsRepuestos();
		return $this->form_validation->run() && $val1 && $val2 && !$existId;
	}
	//-------------------------[validacion de formulario]
	//-----------------------------------------------------------------------------

	private function _validateRelationsManoDeObra() {
		$repuesto_array = $this->input->post('many_frt_id');
		$repuesto_horas_array = $this->input->post('many_frt_hora');
		$repuesto_requerido_array = $this->input->post('many_frt_requerido');
		$errores = array();
		$return = true;
		if (!is_array($repuesto_array) || count($repuesto_array) < 1
				|| !is_array($repuesto_horas_array)
				|| count($repuesto_horas_array) < 1) {
			$errores[] = $this->lang->line('reclamo_garantia_lon_required');
		} else {
			$has_empty_val = false;
			foreach ($repuesto_array as $key => $val) {
				if (empty($val) || empty($repuesto_horas_array[$key]))
					$has_empty_val = true;
				if (!preg_match('/^[0-9\.;]+$/im', $repuesto_horas_array[$key]))
				{
					$errores[] = sprintf(
							$this->lang
							->line('reclamo_garantia_lon_invalid_hours'),
							$val);
				}
				if (!empty($val) && !$this->valid_frt($val)) {
					$errores[] = sprintf(
							$this->lang->line('reclamo_garantia_lon_invalid'),
							$val);
				}
				$this->template['frts'][] = array('frt_id' => $val,
						'frt_hora' => @$repuesto_horas_array[$key],
						'frt_requerido' => @$repuesto_requerido_array[$key],);
			}

			if ($has_empty_val == true) {
				$errores[] = $this->lang
						->line('reclamo_garantia_lon_uncomplete');
			}
		}
		if (count($errores) > 0) {
			$return = false;
			if (!isset($this->template['upload_error']))
			{
				$this->template['upload_error'] = array();
			}
			foreach ($errores as $err)
			{
				$this->template['upload_error'][] = $err;
			}
		}
		return $return;
	}

	private function _validateRelationsRepuestos() {
		$repuesto_array = $this->input->post('many_repuesto_id');
		$repuesto_horas_array = $this->input->post('many_repuesto_cantidad');
		$repuesto_requerido_array = $this->input
				->post('many_repuesto_requerido');
		$errores = array();
		$return = true;
		if (!is_array($repuesto_array) || count($repuesto_array) < 1
				|| !is_array($repuesto_horas_array)
				|| count($repuesto_horas_array) < 1) {
			$errores[] = $this->lang
					->line('reclamo_garantia_material_required');
		} else {
			$has_one_req = false;
			$has_empty_val = false;
			foreach ($repuesto_array as $key => $val) {
				if (empty($val) || (empty($repuesto_horas_array[$key]) && $repuesto_horas_array[$key] !== '0'))
					$has_empty_val = true;
				if (!preg_match('/^[0-9\.;]+$/im', $repuesto_horas_array[$key]))
				{
					$errores[] = sprintf(
							$this->lang
							->line('reclamo_garantia_material_invalid_hours'),
							$val);
				}
				if (!empty($val) && !$this->valid_repuesto($val)) {
					$errores[] = sprintf(
							$this->lang
									->line('reclamo_garantia_material_invalid'),
							$val);
				}
				if ($key == 0) {
					$this->template['repuesto_principal'][] = array(
							'material_id' => $val,
							'material_cantidad' => @$repuesto_horas_array[$key],
							'material_requerido' => 1);
				} else {
					$this->template['repuestos_secundarios'][] = array(
							'material_id' => $val,
							'material_cantidad' => @$repuesto_horas_array[$key],
							'material_requerido' => @$repuesto_requerido_array[$key]);
				}
			}

			if ($has_empty_val == true) {
				$errores[] = $this->lang
						->line('reclamo_garantia_material_uncomplete');
			}
		}
		if (count($errores) > 0) {
			$return = false;
			if (!isset($this->template['upload_error']))
			{
				$this->template['upload_error'] = array();
			}
			foreach ($errores as $err)
			{
				$this->template['upload_error'][] = $err;
			}
		}
		return $return;
	}

	public function del_adjunto($id_registro = FALSE, $id_adjunto = FALSE,
			$subfix = 'adjunto') {
		$rs = $this->backend->del_adjunto($id_registro, $id_adjunto, $subfix);
	}

	//-------------------------[comunes imagenes y adjuntos]

	/**
	 * Lectura del archivo CSV asociandolo a array
	 *
	 * @param type $file_path  Path del archivo a leer
	 * @param type $fields     Encabezados que quiero leer del archivo CSV
	 * @return array
	 */
	function getCSVtoArray($file_path, $fields) {
		$d_value = 0;
		$row = 0;
		$final_array = array();
		$q_location = array();

		if (($handle = fopen($file_path, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, null, $this->separador_vin))
					!== FALSE) {
				if ($row == 0) {
					foreach ($fields as $key => $value) {
						foreach ($data as $d_key => $d_value) {
							if ($data[$d_key] == $value) {
								$q_location[$value] = $d_key;
							}
						}
					}
				} else {
					foreach ($fields as $key => $value) {
						$new_row = $row - 1;
						$final_array[$new_row][$value] = $data[$q_location[$value]];
					}
				}

				$row++;
			}
			fclose($handle);
		}
		return $final_array;
	}

	private function valid_frt($frt_value_id = 0) {

		$return = false;

		if (substr($frt_value_id, -2) == '99') {
			$id_seccion = substr($frt_value_id, 0, -2);

			$sqlSeccion = new Frt_Seccion();
			$seccionFRT = $sqlSeccion->get_all()
					->addWhere('id = ?', $id_seccion)->limit(1)->execute()
					->toArray();

			if ($seccionFRT) {
				$return = true;
			} else {
				$return = false;
			}

		} else {
			$sqlFrt = new Frt();
			$sqlFrt = $sqlFrt->get_all()->addWhere('id = ?', $frt_value_id)
					->limit(1);
			$frt = $sqlFrt->execute()->toArray();

			if ($frt) {
				$return = true;
			} else {
				$return = false;
			}
		}

		return $return;
	}

	private function valid_repuesto($id) {
		$return = false;
		$sqlMaterial = new Material();
		$sqlMaterial = $sqlMaterial->get_all()->addWhere('id = ?', $id)
				->limit(1);
		$material = $sqlMaterial->execute()->toArray();
		$return = $material ? true : false;
		return $return;
	}

	public function unidades($id) {

		$this->load->library('zip');

		if ($this->backend->_permiso('view', ID_SECCION)) {

			$unidades = new Reclamo_Garantia_Campania_Unidad();
			$result = $unidades->get_all()
					->addWhere('reclamo_garantia_campania_id = ?', $id)
					->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

			if (count($result) < 1) {
				die('No se encontraron unidades afectadas a la campaña');
			} else {
				$filename = "Reclamo_Garantia_Campania_Unidades-{$id}.csv";
				ob_implicit_flush(true);
				header(
						"Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-type: text/csv; charset=iso-8859-1");
				header(
						'Content-Disposition: attachment; filename="'
								. $filename . '"');
				echo "vin\n";
				foreach ($result as $vin)
					echo $vin['unidad_field_vin'] . "\n";
			}
		} else {
			die($this->lang->line('reclamo_garantia_download_restricted'));
		}

	}
}
