<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Underservice extends My_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('it/underservice_model');
     }
    function lists(){
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=30;
        $this->load->library('pagination');
        $config['base_url']=base_url().'it/underservice/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->underservice_model->get_count();
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
        $data['list']=$this->underservice_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('line_id','Location','trim');
        $this->form_validation->set_rules('asset_encoding','TPM','trim');
        ////////////////////////////
        $data['heading']='Fixed Asset Issue Lists';
        $data['display']='it/underservicelist';
        $data['llist']=$this->look_up_model->getlocation();
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
       
    function takeoverForm($asset_issue_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Machine Take Over Form';
        $data['info']=$this->underservice_model->get_info($asset_issue_id);
        $data['display']='it/takeoverForm';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
    
    function saveTakeover($asset_issue_id){
      $data['take_over_status']=2;
      $data['takeover_date']=alterDateFormat($this->input->post('takeover_date'));;
      $data['takeover_man']=$this->session->userdata('user_id');
      $this->db->where('asset_issue_id', $asset_issue_id);
      $this->db->update('product_status_info',$data);
      $this->session->set_userdata('exception','Take Over successfully');
      redirect("it/underservice/lists");
    }
    function underService(){
        if ($this->session->userdata('user_id')) {
        $check=$this->underservice_model->underService();
        $this->session->set_userdata('exception','This asset go to Under Service');
        redirect("it/underservice/lists");
        } else {
          redirect("logincontroller");
        }
    }
     function returndate(){
        if ($this->session->userdata('user_id')) {
        $check=$this->underservice_model->returndate();
        $this->session->set_userdata('exception','Return successfully');
        redirect("it/underservice/lists");
        } else {
          redirect("logincontroller");
        }
    }
    function serviceDone($product_detail_id){
      $data['it_status']=2;
      $data['detail_status']=1;
      $this->db->where('product_detail_id', $product_detail_id);
      $this->db->update('product_detail_info',$data);
      $this->session->set_userdata('exception','Service Done Successfully');
      redirect("it/underservice/lists");
    }
    function damage(){
    $product_detail_id=$this->input->post('product_detail_id');
      $data['detail_status']=4;
      $data['it_status']=4;
      $data['despose_date']=date('Y-m-d');
      $data['despose_note']=$this->input->post('despose_note');
      $data['remarks']=$this->input->post('despose_note');
      $this->db->where('product_detail_id', $product_detail_id);
      $this->db->update('product_detail_info',$data);
      $this->session->set_userdata('exception','This Asset Damage successfully');
      redirect("it/underservice/lists");
    }
  

    }