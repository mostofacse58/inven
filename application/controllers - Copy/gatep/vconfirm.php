<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vconfirm extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/vconfirm_model');
        $this->load->model('gatep/gatepass_model');
     
        
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'gatep/vconfirm/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->vconfirm_model->get_count();
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
        $data['pagination'] = $this->pagination->create_links();
        //echo $data["page"]; exit();///////////
        $data['list']=$this->vconfirm_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Gate Pass Lists';
        $data['display']='gatep/vconfirmlist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }

  function viewapproved($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->gatepass_model->get_detail($gatepass_id);
        $data['view']='gatep/callgatepassview';
        $data['display']='gatep/vconfirmview';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }


    function view($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['gatepass_id']=$gatepass_id;
        $data['controller']=$this->router->fetch_class();
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->gatepass_model->get_detail($gatepass_id);
        $data['display']='gatep/viewpass';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
 
public function approved($gatepass_id=FALSE){
    $this->load->model('communication');
    $data['info']=$this->gatepass_model->get_info($gatepass_id); 
    $department_id=$this->session->userdata('department_id');
    if($department_id==6 ||$department_id==34 ||$department_id==22 ||$department_id==15){
      $emailaddress="robert.luo@bdventura.com";
    }elseif($department_id==17){
      $emailaddress="spark.zhong@bdventura.com";
    }elseif($department_id==28){
      $emailaddress="jack.tang@bdventura.com";
    }elseif($department_id==7){
      $emailaddress="melody.xie@bdventura.com";
    }elseif($department_id==18){
      $emailaddress="evan.chen@bdventura.com";
    }elseif($department_id==29){
      $emailaddress="devin@bdventura.com";
    }elseif($department_id==19){
      $emailaddress="ajay.kumar@bdventura.com";
    }elseif($department_id==12){
      $emailaddress="charles.liao@bdventura.com";
    }elseif($department_id==5){
      $emailaddress="santo.chen@bdventura.com";
    }else{
      $emailaddress="thomas.zou@bdventura.com";
    }

    $subject="Gatepass Approval Notification";
    $message=$this->load->view('gatep/approval_email', $data,true); 
     //echo "$department_id $emailaddress,$subject,$message"; exit();
    //$this->communication->send($emailaddress,$subject,$message);
    $data2['gatepass_status']=3;
    $data2['confirmed_by']=$this->session->userdata('user_id');
    $data2['confirmed_date']=date('Y-m-d');
    $this->db->where('gatepass_id', $gatepass_id);
    $this->db->update('gatepass_master',$data2);
    $this->session->set_userdata('exception','Approved successfully');
    redirect("gatep/vconfirm/lists");

   }
   public function returns(){
    $gatepass_id=$this->input->post('gatepass_id');
    $data2['gatepass_status']=1;
    $data2['confirmed_by']=$this->session->userdata('user_id');
    $data2['confirmed_date']=date('Y-m-d');
    $data2['reject_note']=$this->session->userdata('user_name').':'.$this->input->post('reject_note');
    $this->db->where('gatepass_id', $gatepass_id);
    $this->db->update('gatepass_master',$data2);
    $this->session->set_userdata('exception','Return successfully');
    redirect("gatep/vconfirm/lists");
   }
   
 
   
 }