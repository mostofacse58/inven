<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apo extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/purhrequisn_model');
        $this->load->model('format/po_model');
        $this->load->model('format/apo_model');
     }
    
    function lists(){
    if($this->session->userdata('user_id')) {
    $data=array();
    if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=25;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/apo/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->apo_model->get_count();
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
      $data['lists']=$this->apo_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->look_up_model->departmentList();
      $data['slist']=$this->look_up_model->getSupplier();
      ////////////////////////////////////////
      $data['heading']='PO/WO Lists';
      $data['display']='format/apo_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }

function viewforapproved($po_id=FALSE){
      $data['show']=2;
      $data['info']=$this->po_model->get_info($po_id);
      $data['detail']=$this->po_model->getDetails($po_id);
      $data['heading']='PO/WO Information';
      $data['display']='format/woviewhtml';
      $this->load->view('admin/master',$data);
  }
  
 function approved($po_id=FALSE){
    $this->load->model('communication');
    // $data['info']=$this->po_model->get_info($po_id); 
    // $department_id=$data['info']->responsible_department;
    // $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
    // WHERE department_id=$department_id")->row('dept_head_email');
    // $subject="PI Receive Notification";
    // $message=$this->load->view('for_received_email', $data,true); 
    // $this->communication->send($emailaddress,$subject,$message);
    $check=$this->apo_model->approved($po_id);
      if($check){ 
         $this->session->set_userdata('exception','Approved successfully');
       }else{
         $this->session->set_userdata('exception','Failed');
      }
    redirect("format/apo/lists");
  }

  
  function returns($po_id=FALSE){
    $check=$this->apo_model->returns($po_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("format/apo/lists");
  }
   
}