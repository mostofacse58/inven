<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Received extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('payment/applications_model');
        $this->load->model('payment/received_model');
     }
    
    function lists(){
    $data=array();
    if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=15;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'payment/received/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->received_model->get_count();
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
      $data['lists']=$this->received_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->look_up_model->departmentList();
      $data['palist']=$this->look_up_model->getSupplier();
      ////////////////////////////////////////
      if($_GET){
      $data['status']=$this->input->get('status');
      }else{
      $data['status']='All';
      }
      $data['heading']='Payment Application Lists';
      $data['display']='payment/receivedlists';
      $this->load->view('admin/master',$data);

  }
   function edit($payment_id){
    if ($this->session->userdata('user_id')) {
      $data['heading']='Edit Payment Application';
      $data['department_id']=$this->session->userdata('department_id');
      $data['info']=$this->applications_model->get_info($payment_id);
      $data['palist']=$this->look_up_model->getSupplier();
      $data['plist']=$this->look_up_model->payment_term();
      $data['clist']=$this->look_up_model->getCode();
      $data['ulist']=$this->look_up_model->approvedUserList();
      $data['hlist']=$this->applications_model->getAccountHead();
      $data['detail1']=$this->received_model->getDetails($payment_id);
      $data['detail']=$this->applications_model->getDetails($payment_id);
      $data['display']='payment/editAccount';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }

 function save($payment_id=FALSE){
    $this->form_validation->set_rules('supplier_id','Pay to Name','trim|required');
    $this->form_validation->set_rules('pa_type','Pay type','trim|required');
    $this->form_validation->set_rules('currency','currency','trim|required');
    $this->form_validation->set_rules('approved_by','Approve By','trim|required');
    $this->form_validation->set_rules('applications_date','Date','trim|required');
    $this->form_validation->set_rules('currency_rate_in_hkd','Rate','trim|required');
    $this->form_validation->set_rules('pay_term','Pay term','trim|required');
    $this->form_validation->set_rules('description','description','trim');
    if ($this->form_validation->run() == TRUE) {
      $check=$this->received_model->save($payment_id);
      $this->session->set_userdata('exception','Update successfully');
      redirect("payment/received/lists");
    }else{
        $data['department_id']=$this->session->userdata('department_id');
        $data['palist']=$this->look_up_model->getSupplier();
        $data['plist']=$this->look_up_model->payment_term();
        $data['clist']=$this->look_up_model->getCode();
        $data['ulist']=$this->look_up_model->approvedUserList();
        $data['hlist']=$this->applications_model->getAccountHead();
        $data['heading']='Edit Payment Application';
        $data['detail4']=$this->applications_model->getDetails4($payment_id);
        $data['detail']=$this->applications_model->getDetails($payment_id);
        $data['info']=$this->applications_model->get_info($payment_id);
      }        
      $data['display']='payment/editAccount';
      $this->load->view('admin/master',$data);
  }

  function view($payment_id=FALSE){
      $data['heading']='Payment Application';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->applications_model->get_info($payment_id);
      $data['detail4']=$this->applications_model->getDetails4($payment_id);
      $data['detail']=$this->applications_model->getDetails($payment_id);
      $data['detail3']=$this->applications_model->getDetails3($payment_id);
      $data['heading']='Payment Application';
      $data['display']='payment/viewhtml';
      $this->load->view('admin/master',$data);
      
    }

  function approved($payment_id=FALSE){
    $data['info']=$this->applications_model->get_info($payment_id);
    $user_id=$data['info']->approved_by;
    $applications_no=$data['info']->applications_no;
    $url = 'https://api.vlmbd.com/api/send_notification_by_id/'.$user_id;
    $subject="Payment Application Approval Notification";
    $data2 = array(
        "title" => "$subject",
        "body" => "Payment Application no: $applications_no",
    );
    //echo sprintf("%s?%s", $url, http_build_query($data));
    $encodedData = json_encode($data2);
    $curl = curl_init($url);
    $data_string = urlencode(json_encode($data2));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData);
    $result = curl_exec($curl);
    curl_close($curl);
    ///////////////// 
    $check=$this->received_model->approved($payment_id);
      if($check){ 
        $this->session->set_userdata('exception','Receive successfully');
       }else{
        $this->session->set_userdata('exception','Send Failed');
      }
    redirect("payment/received/lists");
    }
  function paid($payment_id=FALSE){
    //$this->load->model('communication');
    //$data['info']=$this->applications_model->get_info($payment_id); 
    //$emailaddress=$data['info']->approved_email_address;
    //$subject="Payment Application Approval Notification";
    //$message=$this->load->view('payment/applications_approved_email', $data,true); 
    //$this->communication->send($emailaddress,$subject,$message);
    ////////////////////////
    $check=$this->received_model->paid($payment_id);
      if($check){ 
        $this->session->set_userdata('exception','Paid successfully');
       }else{
        $this->session->set_userdata('exception','Send Failed');
      }
    redirect("payment/received/lists");
  }
 
  function decisions($payment_id=FALSE){
    $check=$this->applications_model->decisions($payment_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/received/lists");
  }
   
}