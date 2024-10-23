<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archivestatus extends My_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('cctv/archivestatus_model');
        $this->load->model('cctv/camerastatus_model');
     }
      
    function lists(){
      
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'cctv/archivestatus/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->archivestatus_model->get_count();
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
      //////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->archivestatus_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('asset_encoding','CODE','trim');
        ////////////////////////////////////////
        $data['heading']='CCTV Status History';
        $data['display']='cctv/archivestatuslist';
        $data['llist']=$this->look_up_model->getlocation();
        $this->load->view('admin/master',$data);
        }else{
          redirect("logincontroller");
        }
       }
 }