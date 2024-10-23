<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carrier extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('shipping/carrier_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Carrier';
        $data['list']=$this->carrier_model->lists();
        $data['display']='shipping/carrierinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Carrier';
        $data['list']=$this->carrier_model->lists();
        $data['info']=$this->carrier_model->get_info($id);
        $data['display']='shipping/carrierinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($id=FALSE){
        $this->form_validation->set_rules('carrier_name','Supplier','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->carrier_model->save($id);

            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("shipping/carrier/lists");

         }else{
            $data['heading']='Add New Carrier';
            $data['list']=$this->carrier_model->lists();
            if($id){
              $data['heading']='Edit Carrier';
              $data['info']=$this->carrier_model->get_info($id);  
            }
            $data['display']='shipping/carrierinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
           $check=$this->carrier_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("shipping/carrier/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($id){
        $chk=$this->db->query("SELECT i.*
         FROM shipping_imcarrier_master i,shipping_carrier_info p 
          WHERE i.carrier_name=p.carrier_name 
          AND p.id=$id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }