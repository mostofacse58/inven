<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rfir extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('proc/rfi_model');
        $this->load->model('proc/rfir_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'proc/rfir/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->rfir_model->get_count();
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
      $total_rows=$config['total_rows'];
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
      $data['list']=$this->rfir_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $this->form_validation->set_rules('department_id','Department','trim');
      $this->form_validation->set_rules('product_code','ITEM CODE','trim');
      $this->form_validation->set_rules('rfi_no','NO','trim');
      $data['dlist']=$this->look_up_model->departmentList();
      $data['heading']='RFI Receive Lists';
      $data['display']='proc/rfir_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }
 
    function delete($rfi_id=FALSE){
      $check=$this->rfir_model->delete($rfi_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("proc/rfir/lists");
    }
////////////////////////

    function received($rfi_id=FALSE){
      $check=$this->rfir_model->received($rfi_id);
        if($check){ 
           $this->session->set_userdata('exception','Approved successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("proc/rfir/lists");
    }
    function rejected($rfi_id=FALSE){
      $check=$this->rfir_model->rejected($rfi_id);
        if($check){ 
           $this->session->set_userdata('exception','Reject successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("proc/rfir/lists");
    }
    function returns($rfi_id=FALSE){
      $check=$this->rfir_model->returns($rfi_id);
      if($check){ 
         $this->session->set_userdata('exception','Return successfully');
       }else{
         $this->session->set_userdata('exception','Send Failed');
      }
      redirect("proc/rfir/lists");
    }
    function view($rfi_id=FALSE){
      $data['info']=$this->rfi_model->get_info($rfi_id);
      $data['detail']=$this->rfi_model->getDetails($rfi_id);
      $data['display']='proc/rfiview';
      $this->load->view('admin/master',$data);
    }

   
 }