<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Issueto extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/issueto_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Issue To';
        $data['list']=$this->issueto_model->lists();
        $data['display']='gatep/issuetoinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    	
    }

    function edit($issue_to){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Issue To';
        $data['list']=$this->issueto_model->lists();
        $data['info']=$this->issueto_model->get_info($issue_to);
        $data['display']='gatep/issuetoinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }

    }
    
    function save($issue_to=FALSE){
        $this->form_validation->set_rules('issue_to_name','Name','trim|required');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('mobile_no','Mobile No','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->issueto_model->save($issue_to);
            if($check && !$issue_to){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $issue_to){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("gatep/issueto/lists");

         }else{
            $data['heading']='Add New Issue To';
            $data['list']=$this->issueto_model->lists();
            if($issue_to){
              $data['heading']='Edit Issue To';
              $data['info']=$this->issueto_model->get_info($issue_to);  
            }
            $data['display']='gatep/issuetoinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($issue_to=FALSE){
        $check=$this->issueto_model->delete($issue_to);
        if($check){ 
           $this->session->set_userdata('exception','Information delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("gatep/issueto/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($issue_to){
        $chk=$this->db->query("SELECT * FROM gatepass_master 
          WHERE issue_to=$issue_to")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    

    


 }