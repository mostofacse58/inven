<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machinetype extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('me/machinetype_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Machine Type';
        $data['list']=$this->machinetype_model->lists();
        $data['display']='me/machinetype';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function edit($machine_type_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Machine Type';
        $data['list']=$this->machinetype_model->lists();
        $data['info']=$this->machinetype_model->get_info($machine_type_id);
        $data['display']='me/machinetype';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($machine_type_id=FALSE){
        $this->form_validation->set_rules('machine_type_name','Machine Type','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->machinetype_model->save($machine_type_id);
            if($check && !$machine_type_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $machine_type_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("me/machinetype/lists");

         }else{
            $data['heading']='Add New Machine Type';
            $data['list']=$this->machinetype_model->lists();
            if($machine_type_id){
              $data['heading']='Edit Machine Type';
              $data['info']=$this->machinetype_model->get_info($machine_type_id);  
            }
            $data['display']='me/machinetype';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($machine_type_id=FALSE){
           $check=$this->machinetype_model->delete($machine_type_id);
        if($check){ 
           $this->session->set_userdata('exception','Machine type delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("me/machinetype/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkMachinetype($machine_type_id){
        $chk=$this->db->query("SELECT * FROM product_info WHERE machine_type_id=$machine_type_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }