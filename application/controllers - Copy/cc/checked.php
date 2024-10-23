<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checked extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('cc/checked_model');
        $this->load->model('cc/courier_model');
        if($this->session->userdata('language')=='chinese'){
        $this->lang->load('chinese', "chinese");
        }else{
          $this->lang->load('english', "english");
        }
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
        else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'cc/checked/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->checked_model->get_count();
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
        $data['list']=$this->checked_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Courier Control Lists';
        $data['display']='cc/checkedlists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
     function checkedview($courier_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['courier_id']=$courier_id;
        $data['heading']='Courier Control Details Information';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['view']='cc/callview';
        $data['display']='cc/checkedview';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function view($courier_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['courier_id']=$courier_id;
        $data['heading']='Courier Control Details Information';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['display']='cc/view';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    public function checkedd($courier_id=FALSE){
        $data2['courier_status']=4;
        $data2['checked_by']=$this->session->userdata('user_id');
        $data2['checked_date']=date('Y-m-d');
        $this->db->where('courier_id', $courier_id);
        $this->db->update('courier_master',$data2);
        $this->session->set_userdata('exception','Approved successfully');
        redirect("cc/checked/lists");
      }

     public function returns(){
        $courier_id=$this->input->post('courier_id');
        $data2['courier_status']=1;
        $data2['checked_by']=$this->session->userdata('user_id');
        $data2['checked_date']=date('Y-m-d');
        $data2['reject_note']=$this->session->userdata('user_name').':'.$this->input->post('reject_note');
        $this->db->where('courier_id', $courier_id);
        $this->db->update('courier_master',$data2);
        $this->session->set_userdata('exception','Return successfully');
      redirect("cc/checked/lists");
    }

    function addinform($courier_id){
        $data['controller']=$this->router->fetch_class();
        $data['courier_id']=$courier_id;
        $data['heading']='Courier Control Details Information';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['display']='cc/accupdate';
        $this->load->view('admin/master',$data);
    }

  public function saveinfo($courier_id=FALSE){
    $data['payment_date']=date('Y-m-d');
    $data['payment_status']=$this->input->post('payment_status');
    $data['charges_status']=$this->input->post('charges_status');
    $this->db->where('courier_id', $courier_id);
    $this->db->update('courier_master',$data);
    $this->session->set_userdata('exception','Update successfully');
    redirect("cc/checked/lists");
  }

   
 }