<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Head extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('audit/head_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Head';
        $data['list']=$this->head_model->lists();
        $data['display']='audit/headinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($head_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Head';
        $data['list']=$this->head_model->lists();
        $data['info']=$this->head_model->get_info($head_id);
        $data['display']='audit/headinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($head_id=FALSE){
        $this->form_validation->set_rules('head_name','Head','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->head_model->save($head_id);

            if($check && !$head_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $head_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("audit/head/lists");

         }else{
            $data['heading']='Add New Head';
            $data['list']=$this->head_model->lists();
            if($head_id){
              $data['heading']='Edit Head';
              $data['info']=$this->head_model->get_info($head_id);  
            }
            $data['display']='audit/headinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($head_id=FALSE){
           $check=$this->head_model->delete($head_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("audit/head/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($head_id){
        $chk=$this->db->query("SELECT *
         FROM audit_package
          WHERE head_id=$head_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }