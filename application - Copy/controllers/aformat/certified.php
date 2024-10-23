<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Certified extends My_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('aformat/certified_model');
        $this->load->model('aformat/deptrequisnapp_model');
        $this->load->model('aformat/deptrequisn_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'aformat/certified/lists/';
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->certified_model->get_count();
      $config['per_page'] = $perpage;
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = 2;
      $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = 'First';
      $config['last_link'] = 'Last';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '<span aria-hidden="true">&laquo Prev</span>';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '<span aria-hidden="true">Next »</span>';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = "</a></li>";
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      ////////////////////////////////////////
      $this->pagination->initialize($config); 
      $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $data['pagination'] = $this->pagination->create_links();
      $data['list']=$this->certified_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      $data['heading']='Fixed Asset PI Lists  固定资产购买缩进清单';
      $data['display']='aformat/certified_list';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }
 
  
  function certify($pi_id=FALSE){
    $this->load->model('communication');
    $data['info']=$this->deptrequisn_model->get_info($pi_id); 
    $emailaddress="malik.ma@ms.hkthewell.com";
    $subject="PI Approval Notification";
    $message=$this->load->view('for_approval_email', $data,true); 
    //$this->communication->send($emailaddress,$subject,$message);
    ////////////////////////////////////
    $check=$this->certified_model->certify($pi_id);
      if($check){ 
         $this->session->set_userdata('exception','Certified successfully');
       }else{
         $this->session->set_userdata('exception','Failed');
      }
    redirect("aformat/certified/lists");
  }
   function returns($pi_id=FALSE){
    $check=$this->deptrequisn_model->returns($pi_id);
      if($check){ 
         $this->session->set_userdata('exception','Return successfully');
       }else{
         $this->session->set_userdata('exception','Failed');
      }
    redirect("aformat/certified/lists");
  }
    function rejected($pi_id=FALSE){
    $check=$this->deptrequisn_model->rejected($pi_id);
      if($check){ 
        $this->session->set_userdata('exception','Reject successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("aformat/certified/lists");
  }

   
 }