<?php
/*
TODO
ojo, aca hay un bug, no esta validando sucursal id
*/
define('ID_SECCION',6011);
class Boutique_Pedido_Abm extends Backend_Controller{

    //objeto actual de doctrine
    var $registro_actual = FALSE;

    //filtra por sucursal?
    //var $sucursal = FALSE;

    //se puede rechazar el registro?
    var $rechazar_registro = FALSE;

    //subfix de archivos adjuntos
    //var $upload_adjunto = array('adjunto');

    //subfix de imagenes adjuntas
    var $upload_image = array('imagen');
	
    function __construct()
    {
        parent::Backend_Controller();	

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
            //------- elimino imagenes (si las hay)
            if($this->backend->isset_image())
            {
                while(list($key,$subfix)=each($this->upload_image))
                {
                    $modelo = str_replace(' ','_',humanize($this->model . '_' . $subfix));
                    foreach($this->registro_actual->$modelo as $imagen)
                    {
                            $this->del_image( $this->registro_actual->id, $imagen->id, $subfix );
                    }
                }
            }
            //------- elimino imagenes (si las hay)

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
        $this->_view($id);		
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

        //llamo a la vista
        $this->_view($id);

    }
	
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
	
    private function _grabar_registro_actual()
    {
        try
        {
            $conn = Doctrine_Manager::connection();
            $conn->beginTransaction();

            /* esta preparando los datos que se van a guardar del post en la base Boutique Productos*/
            $this->registro_actual->boutique_pedido_estado  = $this->input->post('boutique_pedido_estado');

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
	
    private function _view($id = false)
    {
        
        /**
         *  $type_user es para distinguie si el usuario es super_administrador, usuario del pedido o proovedor
         * 
         *  $type_user => N  : Inicialmente es N (Ningun tipo de usuario)
         *  $type_user => A  : es (Super) Administrador (puede ver todos los listados)
         *  $type_user => U  : es el Usuario que realizo el pedido (puede ver todos sus pedidos)
         *  $type_user => P  : es proovedor de unos de sus producto (puede ver solo sus productos)
         * 
         */
        $type_user = 'N';
        $total_proovedor = 0;
        //$this->output->enable_profiler();

        $this->template['abm_url'] = $this->get_abm_url();
        $this->template['main_url'] = $this->get_main_url();


        if($this->rechazar_registro === TRUE){
                $this->template['SHOW_RECHAZAR_REGISTRO'] = TRUE;
        }
        else
        {
                $this->template['SHOW_RECHAZAR_REGISTRO'] = FALSE;
        }
    
        //------------ [select / checkbox / radio categoria_id] :(
        $estado_pedido = new Boutique_Pedido_Estado();
        $q = $estado_pedido->get_all();
        $config = array();
        $config['fields'] = array('boutique_pedido_estado_field_desc');
        $config['select'] = FALSE;
        $this->template['boutique_pedido_estado'] = $this->_create_html_options($q, $config);

        //Consulta todos los pedidos que hay en boutique
        $boutique_pedido = new Boutique_Pedido();
        $query_pedido = $boutique_pedido->get_all();
        $query_pedido->addWhere('id = ' . (int)$id);

        if($this->session->userdata('admin_field_super_admin') === true)
        {
            //filtros para super usuario            
        }
        else
        {
            //filtros para los NO super usauario (usuario del pedido o proovedor)
            $query_pedido->addWhere('admin_id = ' . $this->session->userdata('admin_id'));
            $query_pedido->orWhere('proovedor_id = ' . $this->session->userdata('admin_id'));
            //$query_pedido->addWhere('sucursal_id = ' . $this->session->userdata('sucursal_id'));
        }

        $query_pedido->limit(1);
        $array_pedido = $query_pedido->execute()->toArray();        
        
        if($this->session->userdata('admin_field_super_admin') === true)
        {
            $type_user = 'A'; //Es Super Administrador
        }
        elseif($array_pedido)
        {            
            if($array_pedido[0]['Admin']['id'] == $this->session->userdata('admin_id'))
            {
                $type_user = 'U'; //Es el usuario que realizo el pedido
            }
            else
            {
                foreach($array_pedido[0]['Boutique_Pedido_Detalle'] as $pedido_proovedor)
                {
                    if ($pedido_proovedor['proovedor_id'] == $this->session->userdata('admin_id'))
                    {
                        $type_user = 'P'; //Es el proovedor de uno de los productos
                    }
                }

            }
        }    

        $this->template['boutique_pedido'] = $array_pedido;

        $boutique_pedido_detalle = new Boutique_Pedido_Detalle();
        $query_detalle = $boutique_pedido_detalle->get_all();
        $query_detalle->addWhere('boutique_pedido_id = ' . (int)$id);
        
        if ($type_user == 'P')
        {
            $query_detalle->addWhere('proovedor_id = ?', (int)$id);
        }
        
        $array_detalle = $query_detalle->execute()->toArray();
        
        if ($type_user == 'P')
        {
            foreach($array_detalle as $detalle)
            {
                $total_proovedor += $detalle['boutique_pedido_subtotal'];
            }
        }
        
        $this->template['boutique_pedido_detalle'] = $array_detalle;
        $this->template['type_user']         = $type_user;
        $this->template['total_proovedor']   = $total_proovedor;
        $this->template['tpl_include'] = $this->get_template_view();
        $this->load->view('backend/esqueleto_view',$this->template);		
    }
	
	
    private function _validar_formulario() {
        if($this->registro_actual)
        {
            $id=$this->registro_actual->id;
        }else
        {
            $id = FALSE;
        }

        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('form_seleccione'));
        $this->form_validation->set_rules('boutique_pedido_estado',$this->marvin->mysql_field_to_human('boutique_pedido_estado'),'trim|max_length[255]|required' );

        return $this->form_validation->run();
    }	
}
	