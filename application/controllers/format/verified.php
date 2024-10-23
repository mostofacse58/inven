<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verified extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/deptrequisn_model');
        $this->load->model('format/verified_model');
     }
    
    function lists(){
    $data=array();
    if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
      else $perpage=15;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/verified/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->verified_model->get_count();
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
      $data['list']=$this->verified_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->look_up_model->departmentList();
      ////////////////////////////////////////
      $data['pi_no']=$this->input->get('pi_no');
      $data['department_id']=$this->input->get('department_id');
      if($_GET){
      $data['pi_status']=$this->input->get('pi_status');
      }else{
      $data['pi_status']=4;
      }
      $data['pencount']=$this->verified_model->statuscount(4);
      $data['vercount']=$this->verified_model->statuscount(5);
      $data['reccount']=$this->verified_model->statuscount(6);
      $data['appcount']=$this->verified_model->statuscount(7);

      $data['heading']='PI Lists';
      $data['display']='format/verified_lists';
      $this->load->view('admin/master',$data);
     
  }
  function viewpihtml($pi_id=FALSE){
    $data['heading']='Purchase Indent';
    $data['collapse']='YES';
    $data['lists']=$this->deptrequisn_model->getpendingPi(4,$pi_id);
    if(count($data['lists'])==0)
    redirect("format/verified/lists");
    $data['display']='format/piverifiedhtml';
    $this->load->view('admin/master',$data);
  }

function viewpihtmlonly($pi_id=FALSE){
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Purchase Indent';
    $data['info']=$this->deptrequisn_model->get_info($pi_id);
    $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
    $data['display']='format/viewpihtmlonly';
  $this->load->view('admin/master',$data);     
}
function returns(){
  $pi_id=$this->input->post('pi_id');
  $check=$this->verified_model->returns($pi_id);
  if($check){ 
   if($this->input->post('pi_status')==5)
    $this->session->set_userdata('exception','Verify successfully');
     elseif($this->input->post('pi_status')==8)
    $this->session->set_userdata('exception','Reject successfully');
    else
    $this->session->set_userdata('exception','Return successfully');  
   }else{
     $this->session->set_userdata('exception','Failed');
  }
  $plists=$this->deptrequisn_model->getpendingPi(4);
  if(count($plists)>0){
    redirect("format/verified/viewpihtml");
  }else{
    redirect("format/verified/lists");
  }
}

function approved($pi_id){
    $this->load->model('communication');
    $data['info']=$this->deptrequisn_model->get_info($pi_id); 
      $department_id=$data['info']->responsible_department;
      $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
      WHERE department_id=$department_id")->row('dept_head_email');
      $subject="PI Receive Notification";
      $message=$this->load->view('for_received_email', $data,true); 
      //$this->communication->send($emailaddress,$subject,$message);
      
    $check=$this->verified_model->approved($pi_id);
    if($check){ 
       $this->session->set_userdata('exception','Verified successfully');
     }else{
       $this->session->set_userdata('exception','Failed');
    }
    $plists=$this->deptrequisn_model->getpendingPi(4);
    if(count($plists)>0){
      redirect("format/verified/viewpihtml");
    }else{
      redirect("format/verified/lists");
    }
}


   
 }