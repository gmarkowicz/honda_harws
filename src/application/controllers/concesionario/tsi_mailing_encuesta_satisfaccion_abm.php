<?php
/*
TODO
ojo, aca hay un bug, no esta validando sucursal id
*/
define('ID_SECCION',3027);
class Tsi_Mailing_Encuesta_Satisfaccion_Abm extends Backend_Controller{

	//objeto actual de doctrine
	var $registro_actual = FALSE;

	//filtra por sucursal?
	//var $sucursal = FALSE;

	//se puede rechazar el registro?
	var $rechazar_registro = FALSE;

	function __construct()
	{
		parent::Backend_Controller();
	}
        
	//----------------------------------------------------------------
	//-------------------------[rechaza registro actual]
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

	//----------------------------------------------------------------
	//-------------------------[rechaza registro actual]

	//----------------------------------------------------------------
	//-------------------------[elimina registro actual]
	public function del()
	{
            $this->_set_record($this->input->post('id'));
            try {
                $conn = Doctrine_Manager::connection();
                $conn->beginTransaction();
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
	//-------------------------[elimina registro actual]
	//----------------------------------------------------------------

	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------
	public function show($id = FALSE)
	{
		$this->_set_record($id);
		$this->_mostrar_registro_actual($id);
		$this->_view();
	}


	//-------------------------[ver/solo lectura registro actual]
	//----------------------------------------------------------------


        
	//----------------------------------------------------------------
	//-------------------------[edita el registro]
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
		}else{
			//no mando info, muestro la del registro por default
			$this->_mostrar_registro_actual();
		}
		//llamo a la vista
		$this->_view();

	}
	//-------------------------[edita el registro]
	//----------------------------------------------------------------

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

	public function add()
        {
            
            $this->template['register_count'] = false;

        $config = array();

        $config['upload_path']   = FCPATH.'public/uploads/reclamo_garantina_campania/vin';
        $config['allowed_types'] = 'csv';
        $config['max_size']      = '100000';
        $config['encrypt_name']  = TRUE;
        $config['overwrite']     = TRUE;		

        $this->load->library('upload', $config);

        if ($this->input->post('_add'))
        {  

            if ($this->_validar_formulario() == TRUE)
            { 
                if ($this->upload->do_upload('vin_file'))
                {   
                    $data = $this->upload->data();

                    $this->path_csv = $data['full_path'];
                    $this->registro_actual = new Tsi_Mailing_Encuesta_Satisfaccion();
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
                else
                {                    
                    $this->error_mensaje = array('error' => $this->upload->display_errors());
                }                    
            }
	
            /*$this->template['info_csv'] = $this->info_csv; 
            $this->template['error_mensaje'] = $this->error_mensaje;           
            $this->template['tpl_include'] = 'backend/'.strtolower($this->router->class.'_readcsv_view');
            $this->load->view('backend/esqueleto_view',$this->template);  */

            $this->_view();
        }


            //redirect(base_url() . $this->config->item('backend_root') . 'tsi_mailing_encuesta_satisfaccion_main');
        }
	

	//-----------------------------------------------------------------------------
	//-------------------------[vista generica abm]
	private function _view()
	{
		
            
                $estado_envios = 0;

		$this->template['abm_url'] = $this->get_abm_url();
		$this->template['main_url'] = $this->get_main_url();
		$this->template['tpl_include'] = $this->get_template_view();
		
                if($this->rechazar_registro === TRUE){
                    $this->template['SHOW_RECHAZAR_REGISTRO'] = TRUE;
		}
		else
		{
                    $this->template['SHOW_RECHAZAR_REGISTRO'] = FALSE;
		}
                
                $estado_registro = $this->registro_actual->toArray();
                
                 /**
                 * Estado actual de la cola de envio de cada email
                 */
                $estados_envios_clientes = new Tsi_Mailing_Encuesta_Satisfaccion_Clientes();
                $query = $estados_envios_clientes->get_all(); 
                $query->Select('TSI_MESC.*');
                $query->addSelect('TSI_MESCE.*');
                $query->addSelect('COUNT(TSI_MESC.tsi_mailing_encuesta_satisfaccion_clientes_estado_id) as cantidad');
                $query->andWhere(" TSI_MESC.tsi_mailing_encuesta_satisfaccion_id = ? ", $this->registro_actual->id);                
                $query->groupBy(" TSI_MESC.tsi_mailing_encuesta_satisfaccion_clientes_estado_id ");
                $result_eec = $query->execute(array())->toArray();     
                
                $estado_envios = array();
                foreach($result_eec as $result_array)
                {
                  $estado_envios[element('tsi_mailing_encuesta_satisfaccion_clientes_estado_field_desc', $result_array)] =  element('cantidad', $result_array);
                }                
                
                //------------ [select / checkbox / radio disponibilidad_id] :(
		$estado_mailing = new Tsi_Mailing_Encuesta_Satisfaccion_Estado();
		$q = $estado_mailing->get_all($estado_registro['tsi_mailing_encuesta_satisfaccion_estado_id']);
		$config=array();
                
		$config['fields'] = array('tsi_mailing_encuesta_satisfaccion_estado_field_desc');
		$config['select'] = FALSE;
		
                $this->template['estado_envios'] = $estado_envios;                
                $this->template['estado_registro'] = $estado_registro['tsi_mailing_encuesta_satisfaccion_estado_id'];
                $this->template['tsi_mailing_encuesta_satisfaccion_estado_id']=$this->_create_html_options($q, $config);
		
		$this->load->view('backend/esqueleto_view',$this->template);
	}
	//-------------------------[vista generica]
	//-----------------------------------------------------------------------------

	


        private function _grabar_registro_actual()
	{
		try
		{
                    
                   
                    $conn = Doctrine_Manager::connection();
                    $conn->beginTransaction();                  
                    
                    $this->registro_actual->tsi_mailing_encuesta_satisfaccion_field_fecha           = $this->input->post('tsi_mailing_encuesta_satisfaccion_field_fecha');
                    $this->registro_actual->tsi_mailing_encuesta_satisfaccion_field_desc            = $this->input->post('tsi_mailing_encuesta_satisfaccion_field_desc');
                    $this->registro_actual->tsi_mailing_encuesta_satisfaccion_estado_id             = $this->input->post('tsi_mailing_encuesta_satisfaccion_estado_id');;
                    $this->registro_actual->tsi_mailing_encuesta_satisfaccion_field_observacion     = $this->input->post('tsi_mailing_encuesta_satisfaccion_field_observacion');;

                     
                    
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
                    $id = $this->registro_actual->id;
		}else{
                    $id = FALSE;
		}

                if (strtotime($this->input->post('tsi_mailing_encuesta_satisfaccion_field_fecha') . ' +23 hours 45 minutes') < time())
                {                    
                    $this->form_validation->my_force_error('tsi_encuesta_mailing_lote_envio_field_fecha', lang('date_less'));
                    $this->form_validation->set_rules('tsi_mailing_encuesta_satisfaccion_field_fecha' , $this->marvin->mysql_field_to_human('tsi_mailing_encuesta_satisfaccion_field_fecha'), 'trim|my_form_date_reverse|required|my_valid_date[y-m-d,-]|my_force_error');              
                }
                else
                {
                    $this->form_validation->set_rules('tsi_mailing_encuesta_satisfaccion_field_fecha' , $this->marvin->mysql_field_to_human('tsi_mailing_encuesta_satisfaccion_field_fecha'), 'trim|my_form_date_reverse|required|my_valid_date[y-m-d,-]');		                
                }             
                
                
                $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));
                $this->form_validation->set_rules('tsi_mailing_encuesta_satisfaccion_field_desc'  , $this->marvin->mysql_field_to_human('tsi_mailing_encuesta_satisfaccion_field_desc') , 'trim|max_length[255]|required' );
                $this->form_validation->set_rules('tsi_mailing_encuesta_satisfaccion_estado_id', $this->marvin->mysql_field_to_human('tsi_mailing_encuesta_satisfaccion_estado_id')  , 'trim|required' );          

                return $this->form_validation->run();
	}	


}
