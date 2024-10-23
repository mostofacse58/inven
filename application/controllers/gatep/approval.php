<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/approval_model');
        $this->load->model('gatep/gatepass_model');
        if($this->session->userdata('language')=='chinese'){
        $this->lang->load('chinese', "chinese");
        }else{
          $this->lang->load('english', "english");
        }
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'gatep/approval/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->approval_model->get_count();
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
        $data['list']=$this->approval_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Gate Pass Lists';
        $data['display']='gatep/approvallist';
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
        $data['display']='gatep/approvalview';
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
        $data2['gatepass_status']=4;
        $data2['approved_by']=$this->session->userdata('user_id');
        $data2['approved_date']=date('Y-m-d');
        $data2['approved_time']=date('h:i A');
        $this->db->where('gatepass_id', $gatepass_id);
        $this->db->update('gatepass_master',$data2);
        $this->session->set_userdata('exception','Approved successfully');
        redirect("gatep/approval/lists");

       }
       public function decline(){
        $gatepass_id=$this->input->post('gatepass_id');
        $data2['gatepass_status']=8;
        $data2['approved_by']=$this->session->userdata('user_id');
        $data2['approved_date']=date('Y-m-d');
        $data2['approved_time']=date('h:i A');
        $data2['reject_note']=$this->session->userdata('user_name').':'.$this->input->post('reject_note');
        $this->db->where('gatepass_id', $gatepass_id);
        $this->db->update('gatepass_master',$data2);
        $this->session->set_userdata('exception','Declined successfully');
        redirect("gatep/approval/lists");
       }
   
 
   
 }