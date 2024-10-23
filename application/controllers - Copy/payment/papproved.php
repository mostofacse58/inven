<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Papproved extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('payment/applications_model');
        $this->load->model('payment/papproved_model');
     }
    
    function lists(){
    $data=array();
    if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=15;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'payment/papproved/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->papproved_model->get_count();
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
      $data['lists']=$this->papproved_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->look_up_model->departmentList();
      $data['palist']=$this->look_up_model->getSupplier();
      ////////////////////////////////////////
      if($_GET){
      $data['status']=$this->input->get('status');
      }else{
      $data['status']=5;
      }
      $data['heading']='Payment Application Lists';
      $data['display']='payment/papprovedlists';
      $this->load->view('admin/master',$data);

  }


  function view($payment_id=FALSE){
      $data['heading']='Payment Application';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->applications_model->get_info($payment_id);
      $data['detail3']=$this->applications_model->getDetails3($payment_id);
      $data['detail4']=$this->applications_model->getDetails4($payment_id);
      $data['detail']=$this->applications_model->getDetails($payment_id);
      $data['heading']='Payment Application';
      $data['display']='payment/viewhtml';
      $this->load->view('admin/master',$data);
      
    }

    function viewpahtml($payment_id=FALSE){
      $data['heading']='Payment Application';
      //$data['collapse']='YES';
      $data['lists']=$this->papproved_model->getpendingPA(5,$payment_id);
      if(count($data['lists'])==0)
      redirect("payment/papproved/lists");
      $data['display']='payment/paApprovalView';
      $this->load->view('admin/master',$data);
  }
  function approved($payment_id=FALSE){
    $this->load->model('communication');
    $data['info']=$this->applications_model->get_info($payment_id); 
    $emailaddress=$data['info']->dept_head_email;
    $subject="Payment Application Done Notification";
    $message=$this->load->view('payment/applications_done_email', $data,true);
    //$this->communication->send($emailaddress,$subject,$message);
    ////////////////////////
    $check=$this->papproved_model->approved($payment_id);
      if($check){ 
        $this->session->set_userdata('exception','Approve successfully');
       }else{
        $this->session->set_userdata('exception','Send Failed');
      }
    //redirect("payment/papproved/lists");

    $lists=$this->papproved_model->getpendingPA(5);
    if(count($lists)>0){
      redirect("payment/papproved/viewpahtml");
    }else{
      redirect("payment/papproved/lists");
    }
  }

   
  function decisions(){
    $payment_id=$this->input->post('payment_id');
    $check=$this->applications_model->decisions($payment_id);
      if($check){ 
        if($this->input->post('status')==1)
        $this->session->set_userdata('exception','Return successfully');
        else 
        $this->session->set_userdata('exception','Reject successfully');  
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    $lists=$this->papproved_model->getpendingPA(5);
    if(count($lists)>0){
      redirect("payment/papproved/viewpahtml");
    }else{
      redirect("payment/papproved/lists");
    }
  }
   
}