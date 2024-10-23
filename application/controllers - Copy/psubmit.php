<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Psubmit extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('psubmit_model');
        $this->load->model('project_model');
     }
    
    function lists(){
      $data=array();
        if($this->session->userdata('user_id')) {
        $data['heading']='Project Informatoion';
        $data['list']=$this->psubmit_model->lists();
        $data['display']='project/reqlists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Project Informatoion';
        $data['plist']=$this->psubmit_model->lists();
        $data['display']='project/addreq';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($project_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Project Informatoion';
        $data['info']=$this->psubmit_model->get_info($project_id);
        $data['plist']=$this->psubmit_model->lists();
        $data['display']='project/addreq';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function save($project_id=FALSE){
        $this->form_validation->set_rules('project_name','Project Name','trim|required');
        $this->form_validation->set_rules('project_coordinator','Co-oridinator 1','trim|required');
        $this->form_validation->set_rules('project_coordinator2','Co-oridinator 2','trim');
        $this->form_validation->set_rules('project_requirement','Requirement','trim|required');
        $this->form_validation->set_rules('priority','Pririty','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->psubmit_model->save($project_id);
            if($check && !$project_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $project_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("psubmit/lists");
         }else{
            $data['heading']='Add New Project Informatoion';
            $data['plist']=$this->psubmit_model->lists();
            if($project_id){
              $data['heading']='Edit Project Informatoion';
              $data['info']=$this->psubmit_model->get_info($project_id);  
            }
            $data['display']='project/addreq';
            $this->load->view('admin/master',$data);
         }
    }
    function delete($project_id=FALSE){
      $check=$this->psubmit_model->delete($project_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("project/lists");
    }
    function view($project_id=FALSE){
      $data['controller']=$this->router->fetch_class();
      $data['heading']='Project Details';
      $data['info']=$this->project_model->get_info($project_id);
      $data['detail']=$this->project_model->getDetails($project_id);
      $data['display']='project/view';
      $this->load->view('admin/master',$data);
    }
     function submit($project_id){
        $data['project_status']=2;
        $data['submit_date']=date('Y-m-d');
        $this->db->WHERE('project_id',$project_id);
        $query=$this->db->update('project_management',$data);
        $this->session->set_userdata('exception','Sumitted');
        redirect("psubmit/lists");
    }


 }