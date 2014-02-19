<?php
define('ID_SECCION', 3027);

class Tsi_Mailing_Encuesta_Satisfaccion_Main extends Backend_Controller
{

    //registro actual de doctrine
    var $registro_actual = FALSE;

    //agregar los id de los servicios a excluir
    var $id_servicios_exclude = array(
        4, 5
    );

    //agregar los id de los codigos de lo clientes a excluir
    var $id_cliente_codigo_interno_excluir = array(
        1
    );

    //subir csv
    var $upload_adjunto = array(
        'adjunto'
    );

    //separador CSV
    var $separador_csv = ";";

    //Path archivo CSV
    var $path_csv = "";

    //filtra por sucursal?
    var $sucursal = FALSE;

    //error mensaje
    var $error_csv = null;

    var $info_csv = false;

    //columnas por las que se puede ordenar la data //List of all fields that can be sortable
    var $default_valid_fields = array(
            'tsi_mailing_encuesta_satisfaccion_field_desc' => array(
                    'sql_filter' => FALSE, 'grid' => TRUE, 'width' => 300, 'sorteable' => TRUE, 'align' => 'left', 'export' => TRUE, 'download' => FALSE, 'print' => TRUE,
                    'rules' => 'align[left]|width[500]|print|',
            ),
            'tsi_mailing_encuesta_satisfaccion_field_cantidad' => array(
                    'sql_filter' => false, 'grid' => TRUE, 'width' => 80, 'sorteable' => TRUE, 'align' => 'left', 'export' => TRUE, 'download' => FALSE, 'print' => TRUE,
                    'rules' => 'align[left]|width[80]|print|',
            ),
            'tsi_mailing_encuesta_satisfaccion_field_fecha' => array(
                    'sql_filter' => array(
                        'DATE(tsi_mailing_encuesta_satisfaccion_field_fecha) >= ?'
                    ), 'grid' => TRUE, 'width' => 100, 'sorteable' => TRUE, 'align' => 'left', 'export' => TRUE, 'download' => FALSE, 'print' => TRUE, 'rules' => 'align[left]|width[100]|print|',
            ),
            'tsi_mailing_encuesta_satisfaccion_estado_field_desc' => array(
                    'sql_filter' => FALSE, 'grid' => TRUE, 'width' => 95, 'sorteable' => TRUE, 'align' => 'left', 'export' => TRUE, 'download' => FALSE, 'print' => TRUE,
                    'rules' => 'align[left]|width[95]|print|',
            ),
            'tsi_mailing_encuesta_satisfaccion_download' => array(
                'sql_filter' => FALSE, 'grid' => TRUE, 'width' => 100, 'sorteable' => FALSE, 'align' => 'left', 'export' => FALSE, 'download' => TRUE, 'rules' => FALSE
            ),
    );

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
                    'form', 'url'
                ));

        $config['campos'] = $this->default_valid_fields;

        $esqueleto_grid = $this->_create_grid_template($config['campos']);
        $buttons = false;

        //Build js
        //View helpers/flexigrid_helper.php for more information about the params on this function
        $this->template['js_grid'] = build_grid_js('flex1', //html name
        $this->get_grid_url(), //url a la que apunta
        $esqueleto_grid, $this->default_sortname, //default order
        $this->default_sortorder, //default order
        $this->config->item('gridParams'), $buttons);

    }

    function Tsi_Mailing_Encuesta_Satisfaccion_Main()
    {
        parent::Backend_Controller();
    }

    function index()
    {
        //borramos en caso de que haya algun filtro previo
        $this->session->unset_userdata('filtro_' . $this->router->class);
        $this->template['register_count'] = false;

        if ($this->input->post('_filtrar')) {

            $this->template['register_count_total'] = $this->getSqlQuery($this->input->post('tsi_mailing_fecha_desde'), $this->input->post('tsi_mailing_fecha_hasta'), true, false);
            $this->template['register_count_valid'] = $this->getSqlQuery($this->input->post('tsi_mailing_fecha_desde'), $this->input->post('tsi_mailing_fecha_hasta'), true, true);
            $this->template['tsi_mailing_fecha_desde'] = $this->input->post('tsi_mailing_fecha_desde');
            $this->template['tsi_mailing_fecha_hasta'] = $this->input->post('tsi_mailing_fecha_hasta');

        }

        $this->_view();
    }

    function grid()
    {

        $config['campos'] = $this->default_valid_fields;

        //agrego para que pueda filtrar por id
        $this->default_valid_fields['id']['sorteable'] = TRUE;

        $this->_create_query();

        $pager = new Doctrine_Pager($this->query, $this->post_info['page'], //flexigrid genera este dato
        $this->post_info['rp'] //flexigrid genera este dato
        );

        /*
         * Json build WITH json_encode. If you do not have this function please read
         * http://flexigrid.eyeviewdesign.com/index.php/flexigrid/example#s3 to know how to use the alternative
         */
        $record_items = array();

        $resultado = $pager->execute(array())->toArray();

        foreach ($resultado as $row) {
            $record_items[] = $this->_create_grid_data_tsi_mail($row, $config['campos']);
        }

        //Print please
        $this->output->set_header($this->config->item('json_header'));
        $this->output->set_output($this->flexigrid->json_build($pager->getNumResults(), $record_items));
    }

    function downloadcsv()
    {
        if ($this->input->post('_downloadcsv')) {

            $filename = $this->input->post('tsi_mailing_fecha_desde') . '_' . $this->input->post('tsi_mailing_fecha_hasta') . ' tsi_mailing.csv';

            ob_implicit_flush(true);
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-type: text/csv; charset=iso-8859-1");
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $this->getcsvReport($this->input->post('tsi_mailing_fecha_desde'), $this->input->post('tsi_mailing_fecha_hasta'));
        }

    }

    protected function _view()
    {
        $this->template['error_csv'] = $this->error_csv;
        $this->template['abm_url'] = $this->get_abm_url();
        $this->template['tpl_include'] = $this->get_template_view();
        $this->load->view('backend/esqueleto_view', $this->template);
    }

    function add()
    {
        $this->template['register_count'] = false;

        $config = array();
        $config['upload_path'] = FCPATH . 'public/uploads/tsi_mailing';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '100000';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->input->post('_add')) {

            if ($this->_validar_formulario() == TRUE) {
                if ($this->upload->do_upload('csv_file')) {
                    $data = $this->upload->data();

                    $this->path_csv = $data['full_path'];
                    $this->registro_actual = new Tsi_Mailing_Encuesta_Satisfaccion();
                    if ($this->_grabar_registro_actual()) {
                        $this->session->set_flashdata('add_ok', true);
                        $this->session->set_userdata('last_add_' . $this->router->class, $this->registro_actual->id);
                        redirect($this->get_abm_url() . '/edit/' . $this->registro_actual->id);
                    }
                } else {
                    $this->error_csv[] = $this->upload->display_errors();
                }
            }

            /*$this->template['info_csv'] = $this->info_csv;
            $this->template['error_mensaje'] = $this->error_mensaje;
            $this->template['tpl_include'] = 'backend/'.strtolower($this->router->class.'_readcsv_view');
            $this->load->view('backend/esqueleto_view',$this->template);  */

            $this->_view();
        }

    }

    private function _grabar_registro_actual()
    {

        $array_csv = array();

        $conn = Doctrine_Manager::connection();
        $conn->beginTransaction();

        $this->registro_actual->tsi_mailing_encuesta_satisfaccion_field_fecha = $this->input->post('tsi_encuesta_mailing_lote_envio_field_fecha');
        $this->registro_actual->tsi_mailing_encuesta_satisfaccion_field_desc = $this->input->post('tsi_encuesta_mailing_lote_envio_field_desc');
        $this->registro_actual->tsi_mailing_encuesta_satisfaccion_estado_id = 1;
        $this->registro_actual->tsi_mailing_encuesta_satisfaccion_field_observacion = $this->input->post('tsi_mailing_encuesta_satisfaccion_field_observacion');
        $this->registro_actual->admin_id = $this->session->userdata('admin_id');

        $this->registro_actual->save();

        if ($this->registro_actual != false) {
            $cantidad_envios = 0;

            $data_csv = array(
                'tsi_id', 'cliente_id'
            );
            $array_csv = $this->getCSVtoArray($this->path_csv, $data_csv);

            /**
             *  Si el formato del archivo CSV es incorrecto el valor devuelto es false
             *  de lo contrario sera un array
             */
            if ($array_csv == false) {
                $this->error_csv[] = lang('error_formato');
                return false;
            } elseif (is_array($array_csv)) {

                foreach ($array_csv as $field) {
                    if (!empty($field['tsi_id']) && !empty($field['cliente_id'])) {
                        $relacion = new Tsi_Mailing_Encuesta_Satisfaccion_Clientes();
                        $relacion->tsi_mailing_encuesta_satisfaccion_id = $this->registro_actual->id;
                        $relacion->tsi_id = $field['tsi_id'];
                        $relacion->cliente_id = $field['cliente_id'];
                        $relacion->token = uniqid();
                        $relacion->tsi_mailing_encuesta_satisfaccion_clientes_estado_id = 1;
                        $relacion->save();

                        if ($relacion) {
                            $cantidad_envios++;
                        }
                    }
                }

                $file_to_rename = pathinfo($this->path_csv);

                rename($file_to_rename['dirname'] . '/' . $file_to_rename['basename'], $file_to_rename['dirname'] . '/' . $this->registro_actual->id . '.' . $file_to_rename['extension']);

                if ($cantidad_envios) {
                    $update = Doctrine_Query::create();
                    $update->update(' tsi_mailing_encuesta_satisfaccion TSI_MES ')->set(' TSI_MES.tsi_mailing_encuesta_satisfaccion_field_cantidad', '?', $cantidad_envios)
                            ->where('TSI_MES.id = ?', $this->registro_actual->id);
                    $update->execute();
                }
                $conn->commit();

                return true;
            }

        }

    }

    private function _validar_formulario()
    {

        if ($this->registro_actual) {
            $id = $this->registro_actual->id;
        } else {
            $id = FALSE;
        }

        $this->load->helper(array(
                    'date'
                ));

        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));
        $this->form_validation
                ->set_rules('tsi_encuesta_mailing_lote_envio_field_desc', $this->marvin->mysql_field_to_human('tsi_encuesta_mailing_lote_envio_field_desc'), 'trim|required|max_length[255]');
        $this->form_validation
                ->set_rules('tsi_encuesta_mailing_lote_envio_field_fecha', $this->marvin->mysql_field_to_human('tsi_encuesta_mailing_lote_envio_field_fecha'),
                        'trim|my_form_date_reverse|required|my_valid_date[y-m-d,-]');

        return $this->form_validation->run();

    }

    var $harws2;

    /**
     * Consulta SQL de TSI entre fechas
     *
     * Verificar tipo de clientes y tipos de servicios a excluir en:
     * id_servicios_exclude = array (linea 7)
     * id_cliente_codigo_interno_excluir = array (linea 10)
     *
     * @param boolean $start_date desde la fecha
     * @param boolean $end_date   hasta la fecha
     * @param boolean $only_valid      solo los que son validos para enviar (tienen mail, etc)
     * @return array
     */
    function getSqlQuery($start_date, $end_date, $onlyCount = false, $only_valid = true)
    {

        $db = $this->load->database('harws2', TRUE);
        $dns = 'mysql:host=' . $db->hostname . ';dbname=' . $db->database . ';';
        $user = $db->username;
        $pass = $db->password;

        try {
            $db = new PDO($dns, $user, $pass);

            if ($onlyCount == true) {
                $select_query = "
                                    count(*) as total
                                ";
            } else {
                $select_query = "TSI.unidad_id,
                                TSI.id AS tsi_id,
                                TSI.cliente_id,
                                TSI.tsi_field_fecha_de_egreso,
                                CLIENTE.id,
                                SUCURSAL.sucursal_field_desc,
                                CLIENTE_SUCURSAL.id AS cliente_id,
                                CLIENTE_SUCURSAL.cliente_sucursal_field_nombre,
                                CLIENTE_SUCURSAL.cliente_sucursal_field_apellido,
                                CLIENTE_SUCURSAL.cliente_sucursal_field_razon_social,
                                CLIENTE_SUCURSAL.cliente_sucursal_field_email,
                                TTS.id AS tts_id,
                                TTS.tsi_tipo_servicio_field_desc,
                                U.unidad_field_vin,
                                U.unidad_field_unidad,
                                CCODI.cliente_codigo_interno_field_desc,
                                UCODI.unidad_codigo_interno_field_desc";
            }

            $string_squery = "SELECT " . $select_query
                    . " FROM tsi AS TSI
                LEFT JOIN
                    cliente AS CLIENTE
                  ON
                    TSI.cliente_id = CLIENTE.id
                LEFT JOIN
                    sucursal AS SUCURSAL
                  ON
                    TSI.sucursal_id = SUCURSAL.id
                LEFT JOIN
                    tsi_m_tsi_tipo_servicio AS T_M_TTS
                  ON
                    TSI.id = T_M_TTS.tsi_id
                LEFT JOIN
                    tsi_tipo_servicio AS TTS
                  ON
                    TTS.id = T_M_TTS.tsi_tipo_servicio_id
                    AND TTS.id IS NOT NULL
                    AND TTS.id NOT IN (" . implode(",", $this->id_servicios_exclude)
                    . ")
                LEFT JOIN
                    cliente_sucursal AS CLIENTE_SUCURSAL
                  ON
                    CLIENTE.id = CLIENTE_SUCURSAL.cliente_id
                  AND
                    CLIENTE_SUCURSAL.sucursal_id = TSI.sucursal_id
                LEFT JOIN
                    cliente_m_cliente_codigo_interno AS CCI
                  ON
                    CLIENTE.id = CCI.cliente_id
                    AND CCI.cliente_codigo_interno_id NOT IN (" . join(",", $this->id_cliente_codigo_interno_excluir)
                    . ")
                LEFT JOIN
                    cliente_codigo_interno AS CCODI
                  ON
                    CCI.cliente_codigo_interno_id = CCODI.id
                LEFT JOIN
                    unidad AS U
                 ON
                    U.id = TSI.unidad_id
                LEFT JOIN
                    unidad_m_unidad_codigo_interno AS U_M_UCI
                  ON
                    U.id = U_M_UCI.unidad_id
                LEFT JOIN
                    unidad_codigo_interno AS UCODI
                  ON
                    U_M_UCI.unidad_codigo_interno_id = UCODI.id
                LEFT JOIN
                    tsi_encuesta_satisfaccion AS TSI_ES
                  ON
                   TSI_ES.tsi_id = TSI.id
                   AND TSI_ES.id IS NULL
                WHERE
                    (TSI.tsi_field_fecha_de_egreso BETWEEN '" . date('Y-m-d', strtotime($start_date)) . "' AND '" . date('Y-m-d', strtotime($end_date)) . "')
                    " . ($only_valid == true ? 'AND CLIENTE_SUCURSAL.cliente_sucursal_field_email <> ""' : '')
                    . "
                GROUP BY TSI.unidad_id
                ORDER BY
                    TSI.tsi_field_fecha_de_egreso
                  DESC
                ";
            if ($onlyCount == true) {
                $string_squery = "select count(*) as total from ({$string_squery}) as totales";
            }

            $query = $db->prepare($string_squery, array(
                        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE
                    ));

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            //$db->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Genera el archivo CSV
     *
     * @param type $start_date
     * @param type $end_date
     * @return string
     */
    function getCSVReport($start_date, $end_date)
    {

        $csv_terminated = "\n";

        //Obtengo el array
        $aResultsCSV = $this->getSqlQuery($start_date, $end_date, false);

        echo "tsi_id" . $this->separador_csv . "cliente_id" . $this->separador_csv . "nombre" . $this->separador_csv . "apellido" . $this->separador_csv . "email" . $this->separador_csv . "empresa"
                . $this->separador_csv . "fecha_egreso" . $this->separador_csv . "sucursal_desc" . $this->separador_csv . "tipo_servicio" . $this->separador_csv . "unidad_vin" . $this->separador_csv
                . "unidad" . $this->separador_csv . "unidad codigo interno" . $this->separador_csv . "cliente codigo interno" . $csv_terminated;

        // Format the data
        foreach ($aResultsCSV as $aResultcsv) {
            $tsi_id = str_replace($this->separador_csv, " ", $aResultcsv['tsi_id']);
            $cliente_id = str_replace($this->separador_csv, " ", $aResultcsv['cliente_id']);
            $cliente_sucursal_field_nombre = str_replace($this->separador_csv, " ", $aResultcsv['cliente_sucursal_field_nombre']);
            $cliente_sucursal_field_apellido = str_replace($this->separador_csv, " ", $aResultcsv['cliente_sucursal_field_apellido']);
            $cliente_sucursal_field_email = str_replace($this->separador_csv, " ", $aResultcsv['cliente_sucursal_field_email']);
            $cliente_sucursal_field_razon_social = str_replace($this->separador_csv, " ", $aResultcsv['cliente_sucursal_field_razon_social']);
            $tsi_field_fecha_de_egreso = str_replace($this->separador_csv, " ", $aResultcsv['tsi_field_fecha_de_egreso']);
            $sucursal_field_desc = str_replace($this->separador_csv, " ", $aResultcsv['sucursal_field_desc']);
            $tsi_tipo_servicio_field_desc = str_replace($this->separador_csv, " ", $aResultcsv['tsi_tipo_servicio_field_desc']);
            $unidad_field_vin = str_replace($this->separador_csv, " ", $aResultcsv['unidad_field_vin']);
            $unidad_field_unidad = str_replace($this->separador_csv, " ", $aResultcsv['unidad_field_unidad']);
            $cliente_codigo_interno_field_desc = str_replace($this->separador_csv, " ", $aResultcsv['cliente_codigo_interno_field_desc']);
            $unidad_codigo_interno_field_desc = str_replace($this->separador_csv, " ", $aResultcsv['unidad_codigo_interno_field_desc']);

            echo $tsi_id . $this->separador_csv;
            echo $cliente_id . $this->separador_csv;
            echo $cliente_sucursal_field_nombre . $this->separador_csv;
            echo $cliente_sucursal_field_apellido . $this->separador_csv;
            echo $cliente_sucursal_field_email . $this->separador_csv;
            echo $cliente_sucursal_field_razon_social . $this->separador_csv;
            echo $tsi_field_fecha_de_egreso . $this->separador_csv;
            echo $sucursal_field_desc . $this->separador_csv;
            echo $tsi_tipo_servicio_field_desc . $this->separador_csv;
            echo $unidad_field_vin . $this->separador_csv;
            echo $unidad_field_unidad . $this->separador_csv;
            echo $unidad_codigo_interno_field_desc . $this->separador_csv;
            echo $cliente_codigo_interno_field_desc . $csv_terminated;
        }

    }

    /**
     * Lectura del archivo CSV asociandolo a array
     *
     * @param type $file_path  Path del archivo a leer
     * @param type $fields     Encabezados que quiero leer del archivo CSV
     * @return array
     */
    function getCSVtoArray($file_path, $fields)
    {
        $count_fields = count($fields);

        $d_value = 0;
        $row = 0;
        $final_array = array();

        if (($handle = fopen($file_path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, "", $this->separador_csv)) !== false) {

                $count_data = count($data);

                if ($count_data >= $count_fields) {

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
                } else {
                    return false;
                }
            }

            fclose($handle);
        }
        return $final_array;
    }

    public function _create_grid_data_tsi_mail($row, $campos, $params = array())
    {

        $this->load->helper('url');
        //$config_archivos = $this->config->item('backend_files_config');

        $return = array(
            $row['id'], $row['id'], $this->backend->_grid_links($row['id'], $params),
        );

        if (is_array($campos)) {

            reset($campos);
            $data = array();
            while (list($field_name, $val) = each($campos)) {
                if (isset($val['grid']) && $val['grid'] === TRUE) {

                    //todo este lio para bajar
                    if (isset($val['download']) && $val['download'] === true) //solo para descargar archivos
 {

                        $link = '/public/uploads/tsi_mailing/';

                        $return_link = anchor($link . $row['id'] . '.csv', lang('Descargar_Listado'), array(
                            'title' => lang('descargar_archivo')
                        ));

                        $return[] = $return_link;

                    }
                    //todo este lio para bajar
 else {

                        //$string = $this->marvin->string_to_utf(element($field_name, $row));
                        $string = element($field_name, $row);
                        if (stristr($field_name, '_fechahora') != FALSE) {
                            $return[] = $this->marvin->mysql_datetime_to_form($string);
                            //$return[]= $string;
                        } else if (stristr($field_name, '_fecha') != FALSE) {
                            $return[] = $this->marvin->mysql_date_to_form($string);
                        } else {
                            $return[] = $string;
                        }

                    }
                }

            }
        }

        RETURN $return;
    }

}
