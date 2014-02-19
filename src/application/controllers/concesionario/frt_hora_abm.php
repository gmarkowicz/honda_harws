<?php

define('ID_SECCION', 3077); //Id de Frt Horas
class Frt_Hora_Abm extends Backend_Controller
{

    //objeto actual de doctrine
    var $registro_actual = FALSE;

    //filtra por sucursal?
    //var $sucursal = FALSE;

    //se puede rechazar el registro?
    var $rechazar_registro = FALSE;

    function __construct()
    {
        parent::Backend_Controller();
        $this->template['image_path'] = str_replace(FCPATH,'',$this->config->item('image_path'));				
    }

    //-------------------------[crea un registro a partir de post ]
    public function add()
    {
        if($this->input->post('_submit'))
        {

            if ($this->_validar_formulario() == TRUE)
            {				
                //piso _this_registro_actual
                $this->registro_actual = new Frt_Hora();
                $this->_grabar_registro_actual();
                $this->session->set_flashdata('add_ok', true);
                //seteo para dejarlo actualizar hasta que se vaya, ver plugin backend _verificar_permisos()
				$lasts = $this->session->userdata('last_add_' . $this->router->class );
				if(!is_array($lasts))
					$lasts = array();
				$lasts[] = $this->registro_actual->id;
				$this->session->set_userdata('last_add_'.$this->router->class,$lasts);
				//
				redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
            }
        }

        $this->_view();
    }

    public function reject()
    {
        if($this->rechazar_registro === TRUE)
        {
            $this->_set_record($this->input->post('id'));
            if($this->_reject_record())
            {
                if($this->input->post('ajax'))
                {
                    //le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
                    $this->output->set_output("TRUE");
                }
            }
        }
    }

    public function del()
    {		

        $this->_set_record($this->input->post('id'));
        try {
            $conn = Doctrine_Manager::connection();
            $conn->beginTransaction();

            //$this->registro_actual->admin_deleted_id = $this->session->userdata('admin_id');
            //no borra los m2m con $this->registro_actual->delete(); :S              

            $this->registro_actual->delete();
            $conn->commit();	

        } catch(Doctrine_Exception $e) {
            $conn->rollback();
            $error=array();
            $error['line'] 		= __LINE__;
            $error['file'] 		= __FILE__;
            $error['error']		= $e->errorMessage();
            $error['sql'] 		= 'transaction';
            $this->backend->_log_error($error);
            show_error( $e->errorMessage()   );
        }
        $this->session->set_flashdata('del_ok', true);
        if($this->input->post('ajax'))
        {
            //le doy un ok al ajax que tiro el pedido, revisar se puede hacer automaticamente
            $this->output->set_output("TRUE");
        }
    }

    public function show($id = FALSE)
    {
            $this->_set_record($id);
            $this->_mostrar_registro_actual($id);
            $this->_view();
    }

    public function edit($id = FALSE)
    {
        $this->_set_record($id);
        if($this->input->post('_submit'))
        {
            //manda info
            if ($this->_validar_formulario() == TRUE)
            {
                //pasa validacion, grabo y redirecciono a edit
                $this->_grabar_registro_actual();
                $this->session->set_flashdata('edit_ok', true);
                redirect($this->get_abm_url().'/edit/'.$this->registro_actual->id);
            }
        }
        else
        {
            //no mando info, muestro la del registro por default
            $this->_mostrar_registro_actual();
        }

        $this->_view();
    }
    //-------------------------[edita el registro]

    //----------------------------------------------------------------
    private function _mostrar_registro_actual()
    {
            //paranoid (por las dudas vio)
            $_POST = array();
            if($this->registro_actual)
            {
                $registro_array = $this->registro_actual->toArray();
                $this->form_validation->set_defaults($registro_array);
            }
            else
            {
                $error=array();
                $error['line'] 		= __LINE__;
                $error['file'] 		= __FILE__;
                $error['error']		= 'no existe llamada a _set_record?';
                $this->backend->_log_error($error);
                show_error( $error['error']   );
            }
    }
    //----------------------------------------------------------------
    //-------------------------[le manda los datos a la view]	

    private function _grabar_registro_actual()
    {
        try
        {
            $conn = Doctrine_Manager::connection();
            $conn->beginTransaction();
            
            $frt = new Frt();
            $frts = $frt->get_all()->addWhere('id = ?', $this->input->post('frt_id'))->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
            
            if($frts)
            {            
            }
            else
            {    
                $relacion = new Frt();
                $relacion->id               = $this->input->post('frt_id');
                $relacion->frt_field_desc   = $this->input->post('frt_field_desc');
                $relacion->frt_seccion_id   = '0000';
                $relacion->save();
            }
            
            

            /* esta preparando los datos que se van a guardar del post en la base Boutique Productos*/
            $this->registro_actual->frt_id                          = $this->input->post('frt_id');
            $this->registro_actual->frt_hora_field_horas            = $this->input->post('frt_hora_field_horas');
            $this->registro_actual->auto_modelo_id                  = $this->input->post('auto_modelo_id');							
            $this->registro_actual->auto_anio_id                    = $this->input->post('auto_anio_id');
            $this->registro_actual->save();
            
            
            

            $conn->commit();			

        }
        catch(Doctrine_Exception $e)
        {
            $conn->rollback();
            $error=array();
            $error['line'] 		= __LINE__;
            $error['file'] 		= __FILE__;
            $error['error']		= $e->errorMessage();
            $error['sql'] 		= 'transaction';
            $this->backend->_log_error($error);
            show_error( $e->errorMessage()   );
        }
    }

    //-------------------------[vista generica abm]
    private function _view()
    {
            //$this->output->enable_profiler();

            $this->template['abm_url'] = $this->get_abm_url();
            $this->template['main_url'] = $this->get_main_url();
            $this->template['tpl_include'] = $this->get_template_view();

            if($this->rechazar_registro === TRUE)
            {
                $this->template['SHOW_RECHAZAR_REGISTRO'] = TRUE;
            }
            else
            {
                $this->template['SHOW_RECHAZAR_REGISTRO'] = FALSE;
            }

            //------------ [select / checkbox / radio disponibilidad_id] :(
            $auto_modelo = new Auto_Modelo();
            $q = $auto_modelo->get_all();
			$q->addWhere('auto_marca_id = ?',100);
			$q->orderBy('auto_modelo_field_desc');
            $config=array();
            $config['fields'] = array('auto_modelo_field_desc');
            $config['select'] = FALSE;
            $this->template['auto_modelo_id']=$this->_create_html_options($q, $config);


            //------------ [select / checkbox / radio disponibilidad_id] :(
            $auto_anio = new Auto_Anio();
            $q = $auto_anio->get_all();
            $config=array();
            $config['fields'] = array('auto_anio_field_desc');
            $config['select'] = FALSE;
            $this->template['auto_anio_id']=$this->_create_html_options($q, $config);

            //$this->_view_adjunto(); //muestro archivos adjuntos (si los hay); //definida $this->$upload_adjunto = array();
            $this->load->view('backend/esqueleto_view',$this->template);
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
        if($this->registro_actual)
        {
                $id=$this->registro_actual->id;
        }else{
                $id = FALSE;
        }

        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));

        $this->form_validation->set_rules('frt_id',                 $this->marvin->mysql_field_to_human('frt_id')                   ,'trim|max_length[7]|required' );
        $this->form_validation->set_rules('frt_hora_field_horas',   $this->marvin->mysql_field_to_human('frt_hora_field_horas')     ,'trim|max_length[255]|required' );
        $this->form_validation->set_rules('auto_modelo_id',         $this->marvin->mysql_field_to_human('auto_modelo_id')           ,'trim|max_length[10]|required' );
        $this->form_validation->set_rules('auto_anio_id',           $this->marvin->mysql_field_to_human('auto_anio_id')             ,'trim|max_length[10]|required' );

        return $this->form_validation->run();
    }
    //-------------------------[validacion de formulario]
}
