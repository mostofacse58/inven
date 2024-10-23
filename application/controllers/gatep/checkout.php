<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends MY_Controller {
	function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/checkout_model');
        $this->load->model('gatep/stockin_model');
     }

     function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'gatep/checkout/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->checkout_model->get_count();
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
        $data['list']=$this->checkout_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Gate Pass Lists';
        $data['display']='gatep/stockinchecklists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
    function view($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['display']='gatep/stockinviewpass';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function searchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Ckecking Gate Pass';
        $data['display']='gatep/checkout';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function search(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Ckecking Gate Pass';
        $data['info']=$this->checkout_model->checkoutBarcode();
        if(count($data['info'])>0){
        $gatepass_id=$data['info']->gatepass_id;
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['display']='gatep/checkinView';
        $this->load->view('admin/master',$data);
        }
        $data['display']='gatep/checkout';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        } 
    }
    
     function viewapproved($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['display']='gatep/checkinView';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

 public function approved($gatepass_id=FALSE){
    $data2['gatepass_status']=5;
    $data2['checked_by']=$this->session->userdata('user_id');
    $data2['checked_date']=date('Y-m-d');
    $data2['checked_time']=date('h:i A');
    $this->db->where('gatepass_id', $gatepass_id);
    $this->db->update('gatepass_master_stock',$data2);
    $this->session->set_userdata('exception','Checkout successfully');
    redirect("gatep/checkout/lists");

   }
  
 
    function lists2(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'gatep/checkout/lists2/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->checkout_model->get_count2();
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
        $data['list']=$this->checkout_model->lists2($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Gate Pass Lists';
        $data['display']='gatep/stockinchecklists2';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
function view2($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['display']='gatep/stockinviewpass2';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function viewapproved2($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['display']='gatep/checkoutin';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

 public function approved2($gatepass_id=FALSE){
    $data2['gatepass_status']=6;
    $data2['checkin_by']=$this->session->userdata('user_id');
    $data2['checkin_datetime']=date('Y-m-d H:i:s');
    $this->db->where('gatepass_id', $gatepass_id);
    $this->db->update('gatepass_master_stock',$data2);
    $this->session->set_userdata('exception','Checkin successfully');
    redirect("gatep/checkout/lists2");

   }
 function searchInForm(){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Ckecking Gate Pass';
    $data['display']='gatep/stockinSearchIn';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
}

    function searchIn(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Ckecking Gate Pass';
        $data['info']=$this->checkout_model->checkinInproduct();
        if(count($data['info'])>0){
        $gatepass_id=$data['info']->gatepass_id;
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['display']='gatep/checkoutin';
        $this->load->view('admin/master',$data);
        }
        $data['display']='gatep/stockinSearchIn';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        } 
    }

   
 }