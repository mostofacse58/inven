<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('project_model');
     }
    
    function lists(){
      $data=array();
        if($this->session->userdata('user_id')) {
        $data['heading']='Project Informatoion';
        $data['list']=$this->project_model->lists();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='project/lists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Project Informatoion';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='project/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($project_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Project Informatoion';
        $data['info']=$this->project_model->get_info($project_id);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='project/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function view($project_id=FALSE){
      $data['controller']=$this->router->fetch_class();
      $data['heading']='Project Details';
      $data['info']=$this->project_model->get_info($project_id);
      $data['detail']=$this->project_model->getDetails($project_id);
      $data['display']='project/view';
      $this->load->view('admin/master',$data);
    }
    function save($project_id=FALSE){
        $this->form_validation->set_rules('project_name','Project Name','trim');
        $this->form_validation->set_rules('project_coordinator','Co-oridinator 1','trim');
        $this->form_validation->set_rules('project_coordinator2','Co-oridinator 2','trim');
        $this->form_validation->set_rules('project_requirement','Requirement','trim');
        $this->form_validation->set_rules('start_date','Start Date','trim');
        $this->form_validation->set_rules('end_date','End Date','trim');
        $this->form_validation->set_rules('submit_date','Submit','trim');
        $this->form_validation->set_rules('priority','Pririty','trim');
        $this->form_validation->set_rules('project_status','Status','trim|required');
        $this->form_validation->set_rules('development_note','Note','trim');
        $this->form_validation->set_rules('special_note','Note','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->project_model->save($project_id);
            if($check && !$project_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $project_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("project/lists");
         }else{
            $data['heading']='Add New Project Informatoion';
            $data['dlist']=$this->look_up_model->departmentList();
            if($project_id){
              $data['heading']='Edit Project Informatoion';
              $data['info']=$this->project_model->get_info($project_id);  
            }
            $data['display']='project/add';
            $this->load->view('admin/master',$data);
         }
    }
    function delete($project_id=FALSE){
      $check=$this->project_model->delete($project_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("project/lists");
    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function receive($project_id){
        $data['project_status']=3;
        $data['received_by']=$this->session->userdata('user_name');
        $data['received_date']=date('Y-m-d');
        $this->db->WHERE('project_id',$project_id);
        $query=$this->db->update('project_management',$data);
        $this->session->set_userdata('exception','Received');
        redirect("project/lists");
    }

 
 }