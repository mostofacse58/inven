<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lgatepass extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/lgatepass_model');
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
        $config['base_url']=base_url().'gatep/lgatepass/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->lgatepass_model->get_count();
        $config['per_page'] = $perpage;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = 2;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = "Fast";
        $config['last_link'] = "Last";
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
        $data['list']=$this->lgatepass_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Gate Pass Lists';
        $data['display']='gatep/lgatepass';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }


    function view($lgatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['lgatepass_id']=$lgatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->lgatepass_model->get_info($lgatepass_id);
        $data['detail']=$this->lgatepass_model->get_detail($lgatepass_id);
        $data['display']='gatep/viewpass';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
     function gatein($gatepass_id){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Ckeck IN Laptop';
        $data2['gate_in_date']=date('Y-m-d');
        $data2['gate_in_time']=date('h:i A');
        $data2['gate_in_date_time']=date('Y-m-d H:i:s');
        $data2['gatepass_status']=2;
        $this->db->where('gatepass_id', $gatepass_id);
        $this->db->update('gatepass_laptop',$data2);
        redirect("gatep/lgatepass/lists"); 
      }else{
        redirect("logincontroller");
      } 
    }

   
 }