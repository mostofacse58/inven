<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Requisitionrec extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/requisition_model');
        $this->load->model('format/requisitionrec_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/requisitionrec/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->requisitionrec_model->get_count();
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
      $data['list']=$this->requisitionrec_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $this->form_validation->set_rules('department_id','Department','trim');
      $this->form_validation->set_rules('product_code','ITEM CODE','trim');
      $this->form_validation->set_rules('requisition_no','NO','trim');
      $data['dlist']=$this->look_up_model->departmentList();
      $data['heading']='Requisition Lists';
      $data['display']='format/requisitionrec_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }
 
    function delete($requisition_id=FALSE){
      $check=$this->requisitionrec_model->delete($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("format/requisitionrec/lists");
    }
////////////////////////

    function received($requisition_id=FALSE){
      $check=$this->requisitionrec_model->received($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Approved successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("format/requisitionrec/lists");
    }
    function rejected($requisition_id=FALSE){
      $check=$this->requisitionrec_model->rejected($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Reject successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("format/requisitionrec/lists");
    }
    function returns($requisition_id=FALSE){
      $check=$this->requisitionrec_model->returns($requisition_id);
      if($check){ 
         $this->session->set_userdata('exception','Return successfully');
       }else{
         $this->session->set_userdata('exception','Send Failed');
      }
      redirect("format/requisitionrec/lists");
    }
    function view2($requisition_id=FALSE){
      $data['info']=$this->requisition_model->get_info($requisition_id);
            $data['detail']=$this->requisition_model->getDetails($requisition_id);
      $data['display']='format/requisitionView2';
      $this->load->view('admin/master',$data);
    }

   
 }