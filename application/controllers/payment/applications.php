<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Applications extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('payment/applications_model');
  
     }
    
    function lists(){
    $data=array();
    if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=15;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'payment/applications/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->applications_model->get_count();
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
      $data['lists']=$this->applications_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->look_up_model->departmentList();
      $data['palist']=$this->look_up_model->getSupplier();
      ////////////////////////////////////////
      $data['heading']='Payment Application Lists';
      $data['display']='payment/lists';
      $this->load->view('admin/master',$data);
  }
  function renames(){
    $lists=$this->applications_model->renames();
    foreach($lists as $row){
        $oldname=$row->attachemnt_file;
        $newname=$row->applications_no.'.pdf';
        if(file_exists("./payment/$oldname")){
          rename("./payment/".$oldname, "./payment/".$newname);
          $data['attachemnt_file']=$newname;
          $payment_id=$row->payment_id;
          $this->db->WHERE('payment_id',$payment_id);
          $this->db->UPDATE('payment_application_master',$data);
        }
    }
    echo "Success";
  }

  function add(){
      $data['heading']='Add Payment Application';
      $data['collapse']='YES';
      $data['department_id']=$this->session->userdata('department_id');
      $data['blist']=$this->look_up_model->getBranch();
      $data['palist']=$this->look_up_model->getSupplier();
      $data['plist']=$this->look_up_model->payment_term();
      $data['ulist']=$this->look_up_model->approvedUserList();
      $data['hlist']=$this->applications_model->getAccountHead();
      $data['clist']=$this->look_up_model->getCode();
      $data['polist']=$this->look_up_model->getPOLists();
     // print_r($data['ulist']); exit();
      $data['display']='payment/add';
      $this->load->view('admin/master',$data);
  }

  function edit($payment_id){
    if ($this->session->userdata('user_id')) {
      $data['collapse']='YES';
      $data['payment_id']=$payment_id;
      $data['heading']='Edit Payment Application';
      $data['department_id']=$this->session->userdata('department_id');
      $data['info']=$this->applications_model->get_info($payment_id);
      $data['palist']=$this->look_up_model->getSupplier();
      $data['plist']=$this->look_up_model->payment_term();
      $data['clist']=$this->look_up_model->getCode();
      $data['blist']=$this->look_up_model->getBranch();
      $data['ulist']=$this->look_up_model->approvedUserList();
      $data['hlist']=$this->applications_model->getAccountHead();
      $data['polist']=$this->look_up_model->getPOLists($payment_id);
      $data['detail']=$this->applications_model->getDetails($payment_id);
      $data['detail3']=$this->applications_model->getDetails3($payment_id);
      $data['detail4']=$this->applications_model->getDetails4($payment_id);
      $data['display']='payment/add';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }

 function save($payment_id=FALSE){
  //echo "<pre>"; print_r($_POST);echo "<pre>";  exit();
   $imgchk=1;
   $datas=array();
    if($payment_id==FALSE){
        $data=array();
        if($_FILES['attachemnt_file']['name']!=""){
            $config['upload_path'] = './payment/';
            $config['allowed_types'] = 'pdf|PDF|jpg|jpeg|png|JPG';
            $config['max_size'] = '300000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
          if ($this->upload->do_upload("attachemnt_file")){
            $upload_info = $this->upload->data();
            $datas['attachemnt_file']=$upload_info['file_name'];
        }else{
          $imgchk=2;
          $error=$this->upload->display_errors();
          $data['exception_err']=$error;
        }
      }else{
          $imgchk=2;
          $data['exception_err']='File is required';
      }
    }else{
        if($_FILES['attachemnt_file']['name']!=""){
            $config['upload_path'] = './payment/';
            $config['allowed_types'] = 'pdf|PDF|jpg|jpeg|png|JPG';
            $config['max_size'] = '300000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
          if ($this->upload->do_upload("attachemnt_file")){
            $upload_info = $this->upload->data();
            $datas['attachemnt_file']=$upload_info['file_name'];
        }else{
          $imgchk=2;
          $error=$this->upload->display_errors();
          $data['exception_err']=$error;
        }
      }else{
        $datas['attachemnt_file']=$this->input->post('attachemnt_file_p');
      }
    }

    $this->form_validation->set_rules('supplier_id','Pay to Name','trim|required');
    $this->form_validation->set_rules('pa_type','Pay type','trim|required');
    $this->form_validation->set_rules('currency','currency','trim|required');
    $this->form_validation->set_rules('approved_by','Approve By','trim|required');
    $this->form_validation->set_rules('applications_date','Date','trim|required');
    $this->form_validation->set_rules('description','description','trim');
    if ($this->form_validation->run() == TRUE&&$imgchk==1) {

      $check=$this->applications_model->save($datas,$payment_id);
      if($check && !$payment_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $payment_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
       
      redirect("payment/applications/lists");
    }else{
        $data['heading']='Add Payment Application';
        $data['department_id']=$this->session->userdata('department_id');
        $data['blist']=$this->look_up_model->getBranch();
        $data['palist']=$this->look_up_model->getSupplier();
        $data['plist']=$this->look_up_model->payment_term();
        $data['clist']=$this->look_up_model->getCode();
        $data['ulist']=$this->look_up_model->approvedUserList();
        $data['hlist']=$this->applications_model->getAccountHead();
        if($payment_id!=''){
          $data['payment_id']=$payment_id;
          $data['heading']='Edit Payment Application';
          $data['detail1']=$this->applications_model->getDetails1($payment_id);
          $data['detail']=$this->applications_model->getDetails($payment_id);
          $data['detail3']=$this->applications_model->getDetails3($payment_id);
          $data['detail4']=$this->applications_model->getDetails4($payment_id);
          $data['info']=$this->applications_model->get_info($payment_id);
        }
        $data['polist']=$this->look_up_model->getPOLists($payment_id);
        $data['display']='payment/add';
        $this->load->view('admin/master',$data);
    }
  }
  function deletes($payment_id=FALSE){
    $check=$this->applications_model->delete($payment_id);
      if($check){ 
         $this->session->set_userdata('exception','Delete successfully');
       }else{
         $this->session->set_userdata('exception','Delete Failed');
      }
    redirect("payment/applications/lists");
  }
  /////////////////////////////
  public function suggestions(){
      $term = $this->input->get('term', true);
      $for_department_id = $this->input->get('for_department_id', true);
      if (strlen($term) < 1 || !$term) {
          die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
      }
      $rows = $this->look_up_model->getdepartmentwiseItem($for_department_id,$term);
      if ($rows){
          $c = str_replace(".", "", microtime(true));
          $r = 0;
          foreach ($rows as $row) {
            $product_name="$row->product_name";
              $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id,'safety_qty' => $row->minimum_stock, 'label' => $row->product_name . " (" . $row->product_code . ")". " (Stock=" . $row->main_stock . ")",'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'product_name' =>$product_name ,'product_code' => $row->product_code, 'unit_price' => $row->unit_price,'image_link' => $row->product_image, 'stock' =>$row->main_stock, 'currency' =>$row->currency);
              $r++;
          }
          header('Content-Type: application/json');
          die(json_encode($pr));
          exit;
      }else{
          $dsad='';
          header('Content-Type: application/json');
          die(json_encode($dsad));
          exit;
      }
  }
  function view($payment_id=FALSE){
      $data['heading']='Payment Application';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->applications_model->get_info($payment_id);
      $data['detail']=$this->applications_model->getDetails($payment_id);
      $data['detail3']=$this->applications_model->getDetails3($payment_id);
      $data['detail4']=$this->applications_model->getDetails4($payment_id);
      $data['heading']='Payment Application';
      $data['display']='payment/viewhtml';
      $this->load->view('admin/master',$data);
    }

  function submit($payment_id=FALSE){
    $this->load->model('communication');
    $department_id=$this->session->userdata('department_id');
    $data['info']=$this->applications_model->get_info($payment_id);
    if($department_id==8){
      $emailaddress='roc.tan@bdventura.com';
    }else{
      $emailaddress=$data['info']->dept_head_email;
    }
    
    $subject="Payment Application Confirmation Notification";
    $message=$this->load->view('payment/applications_check_email', $data,true); 
    //$this->communication->send($emailaddress,$subject,$message);
    ////////////////////////
    $applications_no=$data['info']->applications_no;
    $url = 'https://api.vlmbd.com/api/send_notification_by_department/'.$department_id.'/0/';
    //https://api.vlmbd.com/api/send_notification_by_department/1/1
    //first parameter is department id
    //Second parameter is flag : flag=1 dept head,2-same daprt division head, flag=0 deprt all employee////
    ////$url = 'https://api.vlmbd.com/api/send_notification_by_id/'.$user_id;
    /////send one user
    
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
    ///////////////////////////////
  $check=$this->applications_model->submit($payment_id);
    if($check){ 
      $this->session->set_userdata('exception','Send successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
   redirect("payment/applications/lists");
  }

  //////////////////////
 
  function rejected($payment_id=FALSE){
    $check=$this->applications_model->rejected($payment_id);
      if($check){ 
        $this->session->set_userdata('exception','Reject successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/purhrequisn/lists");
  }
  function getPOAmount(){
        $po_number = $this->input->post('po_number');
        $ammount=$this->db->query("SELECT IFNULL(SUM(a.pamount),0) as ammount 
          FROM payment_po_amount a 
          WHERE a.po_number='$po_number'")->row('ammount');
        if($this->session->userdata('user_id')==1){
          $cngrn_amount=$this->db->query("SELECT IFNULL(SUM(a.grand_total),0) as grn_amount 
          FROM purchase_master_cn a 
          WHERE a.po_number='$po_number'")->row('grn_amount');
        }else{
          $grn_amount=$this->db->query("SELECT IFNULL(SUM(a.grand_total),0) as grn_amount 
          FROM purchase_master a 
          WHERE a.po_number='$po_number' AND a.status!=5 ")->row('grn_amount');
        }        
        $fourigit=substr($po_number,0,4);
        if($fourigit=='BDWA'){
          $info=$this->db->query("SELECT total_amount as amount, currency,discount_amount 
            FROM po_master 
            WHERE  po_number='$po_number'")->row();
          $data['amount']=$info->amount;
          $data['pocurrency']=$info->currency;
          $data['due_amount']=$info->amount-$ammount;
          $data['grn_amount']=$grn_amount-$info->discount_amount;
        }else{
          $info=$this->db->query("SELECT TOTAL_AMT as amount, CURRENCY 
            FROM bd_po_summary 
            WHERE  PO_NUMBER='$po_number'")->row();
          $data['amount']=$info->amount;
          $data['pocurrency']=$info->CURRENCY;
          $data['due_amount']=$info->amount-$ammount;
          $data['grn_amount']=$grn_amount;
        }
      echo json_encode($data);
    }
    /////////////////////////////
    function getLimit(){
        $user_id = $this->input->post('userid');
        $info=$this->db->query("SELECT pa_limit
          FROM user  
          WHERE id='$user_id'")->row();
          $data['pa_limit']=$info->pa_limit;
      echo json_encode($data);

    }
   
}