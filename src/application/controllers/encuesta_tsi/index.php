<?php

class Index extends CI_Controller{
		
    var $tsi_id = false;
    var $token = false;
    
    function __construct()
    {               
            parent::__construct();
    }  

    public function index()
    {   
        $this->template['mostrar_encuesta']       = false;
        $this->template['encuesta_ingresada']     = false;
        $this->template['mostrar_gracias']        = false;
        $this->template['show_datos_incorrectos'] = false;                   

        $this->tsi_id = (int) $this->input->get_post('tsi');
        $this->token  = trim(@mysql_escape_string($this->input->get_post('token')));
        $gracias      = (int) $this->input->get_post('gracias');
		
        if ($gracias && !empty($this->tsi_id))
        {
            $query_tsi_es = Doctrine_Query::create();
            $query_tsi_es->from('tsi_encuesta_satisfaccion');
            $query_tsi_es->where('tsi_id = ?', $this->tsi_id);
            $query_tsi_es->limit(1);
            $query_tsi_es_count = $query_tsi_es->count();
            
            if ($query_tsi_es_count)
            {
                $this->template['mostrar_gracias'] = true;
            } else {
            	$this->template['show_datos_incorrectos'] = true;
            }
            return $this->_view();
        }
        
        if (empty($this->tsi_id) || empty($this->token))
        {
        	$this->template['show_datos_incorrectos'] = true;
        	return $this->_view();
        }
        
        //Comprueba si ya se respondio la encuesta con respecto a tsi_id
        $query_tsi_es = Doctrine_Query::create();
        $query_tsi_es->from('tsi_encuesta_satisfaccion');
        $query_tsi_es->leftJoin(' tsi_mailing_encuesta_satisfaccion_clientes ON tsi_encuesta_satisfaccion.tsi_id = tsi_mailing_encuesta_satisfaccion_clientes.tsi_id');
        $query_tsi_es->where('tsi_id = ?', $this->tsi_id);
        $query_tsi_es->addWhere('token = ?', $this->token);
        $query_tsi_es->limit(1);
        $query_tsi_es_count = $query_tsi_es->count();
        if ($query_tsi_es_count)
        {
            $this->template['encuesta_ingresada'] = true;
            return $this->_view();
        }
	
        $query_tsi = Doctrine_Query::create();
        $query_tsi->from(' tsi_mailing_encuesta_satisfaccion_clientes ');
        $query_tsi->addwhere('tsi_id = ?', $this->tsi_id);
        $query_tsi->addwhere('token = ?', $this->token);
        $query_tsi->limit(1);        
        $query_tsi_count = $query_tsi->count();
        if(!$query_tsi_count)
        {
        	$this->template['show_datos_incorrectos'] = true;
        	return $this->_view();
        }
		else
        {
        	$this->template['mostrar_encuesta'] = true;
            // Chequea si tiene que ingresar las respuestas de la encuenta
            // de lo contrario muestra las preguntas
            if($this->input->post('send'))
            {
                $this->_save_encuesta_tsi();
            }
            else
            {
                $this->_datos_del_cliente();
            }
            return $this->_view();
        }
        
    }
    
    
    function _datos_del_cliente()
    {
        $this->load->helper('array');
        
        $tsi = new Tsi();
        $q = $tsi->get_all();
        $q->addWhere('id = ?', $this->tsi_id);
        //$q->addWhere('tsi_field_md5 = ?', $token);
        $q->limit(1);

        $result = $q->execute(array())->toArray();

        //Mostrar encuesta
        $this->template['mostrar_encuesta']       = true;
        $this->template['tsi_id']                 = $this->tsi_id;
        $this->template['token']                  = $this->token;

       
        //Datos de la Sucursal
         $this->template['sucursal_field_desc']                    = $result[0]['Sucursal']['sucursal_field_desc'];
        //Fecha de Ingreso
        $this->template['tsi_field_fecha_de_egreso']              = element('tsi_field_fecha_de_egreso', $result) ;
    
        //Datos recepcionista
        $this->template['recepcion_admin_field_nombre']           = @$result[0]['Recepcionista']['admin_field_nombre'] ;        
        $this->template['recepcion_admin_field_apellido']         = @$result[0]['Recepcionista']['admin_field_apellido'] ;

        //Datos tecnicos
        $this->template['tecnico_admin_field_nombre']             = @$result[0]['Tecnico']['admin_field_nombre'] ;
        $this->template['tecnico_admin_field_apellido']           = @$result[0]['Tecnico']['admin_field_apellido'] ;

        //Datos de la unidad
        $this->template['unidad_field_vin']                        = element('unidad_field_vin', $result);       
        $this->template['auto_anio_field_desc']                    = element('auto_anio_field_desc', $result);
        $this->template['auto_modelo_field_desc']                  = element('auto_modelo_field_desc', $result);
        $this->template['auto_version_field_desc']                 = element('auto_version_field_desc', $result); 
        
        //Datos del Cliente
        $this->template['cliente_sucursal_field_nombre']           = element('cliente_sucursal_field_nombre', $result);
        $this->template['cliente_sucursal_field_apellido']         = element('cliente_sucursal_field_apellido', $result);
        $this->template['cliente_sucursal_field_razon_social']     = element('cliente_sucursal_field_razon_social', $result);        
        
    }    
    
    function _save_encuesta_tsi()
    {
        $query = new Tsi_Encuesta_Satisfaccion();
        
        $query->tsi_id = $this->tsi_id;
       
        $query->tsi_encuesta_satisfaccion_field_pregunta_01  = $this->input->post('pregunta_1');
        $query->tsi_encuesta_satisfaccion_field_pregunta_01a = $this->input->post('pregunta_1a');
        
        $query->tsi_encuesta_satisfaccion_field_pregunta_02a = $this->input->post('pregunta_2a');
        $query->tsi_encuesta_satisfaccion_field_pregunta_02b = $this->input->post('pregunta_2b');
        $query->tsi_encuesta_satisfaccion_field_pregunta_02c = $this->input->post('pregunta_2c');
        $query->tsi_encuesta_satisfaccion_field_pregunta_02d = $this->input->post('pregunta_2d');
        $query->tsi_encuesta_satisfaccion_field_pregunta_02e = $this->input->post('pregunta_2e');
        $query->tsi_encuesta_satisfaccion_field_pregunta_02f = $this->input->post('pregunta_2f');
        
        $query->tsi_encuesta_satisfaccion_field_pregunta_03a = $this->input->post('pregunta_3a');
        $query->tsi_encuesta_satisfaccion_field_pregunta_03b = $this->input->post('pregunta_3b');
        $query->tsi_encuesta_satisfaccion_field_pregunta_03c = $this->input->post('pregunta_3c');
        
        $query->tsi_encuesta_satisfaccion_field_pregunta_04a = $this->input->post('pregunta_4a');
        $query->tsi_encuesta_satisfaccion_field_pregunta_04b = $this->input->post('pregunta_4b');
        $query->tsi_encuesta_satisfaccion_field_pregunta_04c = $this->input->post('pregunta_4c');
        $query->tsi_encuesta_satisfaccion_field_pregunta_04d = $this->input->post('pregunta_4d');
        $query->tsi_encuesta_satisfaccion_field_pregunta_04e = $this->input->post('pregunta_4e');
        
        $query->tsi_encuesta_satisfaccion_field_pregunta_05 = $this->input->post('pregunta_5');
        
        $query->tsi_encuesta_satisfaccion_field_pregunta_06  = $this->input->post('pregunta_6');
        $query->tsi_encuesta_satisfaccion_field_pregunta_06a = $this->input->post('pregunta_6a');
        $query->tsi_encuesta_satisfaccion_field_pregunta_06b = $this->input->post('pregunta_6b');        
        $query->tsi_encuesta_satisfaccion_field_pregunta_06b_otra = $this->input->post('pregunta_6b4_otra');
        
        $query->tsi_encuesta_satisfaccion_field_pregunta_07a = $this->input->post('pregunta_7a');
        $query->tsi_encuesta_satisfaccion_field_pregunta_07b = $this->input->post('pregunta_7b');
        $query->tsi_encuesta_satisfaccion_field_pregunta_07c = $this->input->post('pregunta_7c');
        
        $query->tsi_encuesta_satisfaccion_field_pregunta_08 = $this->input->post('pregunta_8');
        
        $query->tsi_encuesta_satisfaccion_field_pregunta_09 = $this->input->post('pregunta_9');
        
        $query->tsi_encuesta_satisfaccion_field_comentarios = $this->input->post('comentarios');
        
        $query->tsi_encuesta_satisfaccion_field_fechahora_alta = date('Y-m-d H:i:s');

        $query->tsi_encuesta_satisfaccion_field_pregunta_08bis = 0;
        $query->tsi_encuesta_satisfaccion_field_pregunta_09bis = 0;
        $query->tsi_encuesta_satisfaccion_field_admin_alta_id = 0;        
        $query->tsi_encuesta_satisfaccion_field_fechahora_modificacion = date('Y-m-d H:i:s');
        $query->tsi_encuesta_satisfaccion_field_admin_modifica_id = 0;
        $query->tsi_encuesta_satisfaccion_field_admin_rechaza_id = 0;
        $query->tsi_encuesta_satisfaccion_field_rechazo_motivo = '';
        $query->tsi_encuesta_satisfaccion_estado_id = 2;
        
        $query->save();
        
        return redirect(current_url() . '?tsi=' . $this->tsi_id . '&gracias=1');
    }
    
    private function _validar_formulario()
    {
        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));
        $this->form_validation->set_rules('sucursal_id',$this->marvin->mysql_field_to_human('sucursal_id'),
				'trim|required|is_natural_no_zero|my_valid_sucursal' );
    }
    
    private function _view()
    {
        $this->load->view('encuesta_tsi/encuesta_tsi_view', $this->template);   
    }

}
?>    