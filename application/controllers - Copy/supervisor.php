<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supervisor extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('supervisor_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Supervisor';
        $data['plist']=$this->look_up_model->postList();
        $data['list']=$this->supervisor_model->lists();
        $data['display']='admin/supervisorinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($supervisor_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Supervisor';
        $data['list']=$this->supervisor_model->lists();
        $data['plist']=$this->look_up_model->postList();
        $data['info']=$this->supervisor_model->get_info($supervisor_id);
        $data['display']='admin/supervisorinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($supervisor_id=FALSE){
        $this->form_validation->set_rules('supervisor_name','Name','trim|required');
        $this->form_validation->set_rules('post_id','Designation Name','trim|required');
        $this->form_validation->set_rules('mobile_no','Mobile No','trim');
        $this->form_validation->set_rules('id_no','ID NO','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->supervisor_model->save($supervisor_id);
            if($check && !$supervisor_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $supervisor_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("supervisor/lists");

         }else{
            $data['heading']='Add New Supervisor';
            $data['list']=$this->supervisor_model->lists();
            $data['plist']=$this->look_up_model->postList();
            if($supervisor_id){
              $data['heading']='Edit Supervisor';
              $data['info']=$this->supervisor_model->get_info($supervisor_id);  
            }
            $data['display']='admin/supervisorinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($supervisor_id=FALSE){
           $check=$this->supervisor_model->delete($supervisor_id);
        if($check){ 
           $this->session->set_userdata('exception','Supervisor Info delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("supervisor/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($supervisor_id){
        $chk=$this->db->query("SELECT * FROM machine_downtime_info 
          WHERE supervisor_id=$supervisor_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }