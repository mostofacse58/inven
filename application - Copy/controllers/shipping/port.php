<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Port extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('shipping/port_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Port';
        $data['list']=$this->port_model->lists();
        $data['display']='shipping/portinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Port';
        $data['list']=$this->port_model->lists();
        $data['info']=$this->port_model->get_info($id);
        $data['display']='shipping/portinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($id=FALSE){
        $this->form_validation->set_rules('port_of_loading','Port','trim|required');
        $this->form_validation->set_rules('supplier_name2','Supplier ','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->port_model->save($id);

            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("shipping/port/lists");

         }else{
            $data['heading']='Add New Port';
            $data['list']=$this->port_model->lists();
            if($id){
              $data['heading']='Edit Port';
              $data['info']=$this->port_model->get_info($id);  
            }
            $data['display']='shipping/portinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
           $check=$this->port_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("shipping/port/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($id){
        $chk=$this->db->query("SELECT i.*
         FROM shipping_import_master i,shipping_supplier_port p 
          WHERE i.port_of_loading=p.port_of_loading 
          AND p.id=$id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }