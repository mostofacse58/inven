<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Overseapi extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/overseapi_model');
        $this->load->model('format/deptrequisnapp_model');
        $this->load->model('format/deptrequisn_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/overseapi/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->overseapi_model->get_count();
      $total_rows=$config['total_rows'];
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
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>'; 
      $data['list']=$this->overseapi_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      $data['heading']='Oversea PI Lists';
      $data['display']='format/purhrequisn_ov_list';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }
 
    function received($pi_id=FALSE){
      $this->load->model('communication');
      $data['info']=$this->deptrequisn_model->get_info($pi_id); 
       $department_id=$data['info']->department_id;
      $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
      WHERE department_id=$department_id")->row('dept_head_email');
      $subject="PI Receive Completed";
      $message=$this->load->view('for_received_completed_email', $data,true); 
      //$this->communication->send($emailaddress,$subject,$message);
      ////////////////////////////////////
      $check=$this->overseapi_model->received($pi_id);
        if($check){ 
           $this->session->set_userdata('exception','Receive successfully');
         }else{
           $this->session->set_userdata('exception','Failed');
        }
      redirect("format/purhrequisn/lists");
    }
    function returns($pi_id=FALSE){
      $check=$this->deptrequisn_model->returns($pi_id);
        if($check){ 
           $this->session->set_userdata('exception','Return successfully');
         }else{
           $this->session->set_userdata('exception','Failed');
        }
      redirect("format/purhrequisn/lists");
    }
      function rejected($pi_id=FALSE){
      $check=$this->deptrequisn_model->rejected($pi_id);
        if($check){ 
          $this->session->set_userdata('exception','Reject successfully');
         }else{
          $this->session->set_userdata('exception','Failed');
        }
      redirect("format/purhrequisn/lists");
    }
    function viewpihtmlonly($pi_id=FALSE){
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Purchase Indent';
    $data['info']=$this->deptrequisn_model->get_info($pi_id);
    $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
    $data['display']='format/viewpihtmlonly';
  $this->load->view('admin/master',$data);     
  }
  
 }