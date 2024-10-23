<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Deptrequisn extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/purhrequisn_model');
        $this->load->model('format/deptrequisn_model');
        $this->load->model('format/requisition_model');
        $this->load->model('shipping/import_model');
     }
    
    function lists(){
    if($this->session->userdata('user_id')) {
    $data=array();
    if($this->input->post('perpage')!='') 
      $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/deptrequisn/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->deptrequisn_model->get_count();
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
      $data['list']=$this->deptrequisn_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->look_up_model->departmentList();
      ////////////////////////////////////////
      $data['heading']='Safety Stock PI Lists (固定资产购买缩进清单)';
      $data['display']='format/sendreq_list';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }

  function add(){
    if($this->session->userdata('user_id')) {
      $data['collapse']='YES';
      $data['heading']='Add PI';
      $data['department_id']=$this->session->userdata('department_id');
      $data['clist']=$this->look_up_model->clist();
      $data['ptlist']=$this->look_up_model->getPIType();
      $data['dlist']=$this->look_up_model->departmentList();
      $data['detail1']=$this->deptrequisn_model->getsafetyStock();
      $data['flist']=$this->import_model->getdata('shipping_file_style_info');
      $data['display']='format/addpi';
      $this->load->view('admin/master',$data);
    }else{
      redirect("logincontroller");
    }
  }
  function edit($pi_id){
    if ($this->session->userdata('user_id')) {
      $data['collapse']='YES';
      $data['heading']='Edit PI';
      $data['department_id']=$this->session->userdata('department_id');
      $data['ptlist']=$this->look_up_model->getPIType();
      $data['clist']=$this->look_up_model->clist();
      $data['info']=$this->deptrequisn_model->get_info($pi_id);
      $data['flist']=$this->import_model->getdata('shipping_file_style_info');
      $data['dlist']=$this->look_up_model->departmentList();
      $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
      if($data['info']->pi_status==1){
        $data['display']='format/addpi';
        $this->load->view('admin/master',$data);
      }else{
        redirect("format/deptrequisn/lists");
      }
      } else {
         redirect("logincontroller");
      }
  }
  function prtopi($requisition_id){
      $data['collapse']='YES';
      $data['heading']='Edit PI';
      $data['copy']='YES';
      $data['ptlist']=$this->look_up_model->getPIType();
      $data['clist']=$this->look_up_model->clist();
      $data['dlist']=$this->look_up_model->departmentList();
      $info=$this->requisition_model->get_info($requisition_id);
      $data['detail']=$this->deptrequisn_model->getPRDetails($requisition_id);
      $data['department_id']=$info->department_id;
      $data['flist']=$this->import_model->getdata('shipping_file_style_info');
      $data['display']='format/addpi';
      $this->load->view('admin/master',$data);
  }

 function save($pi_id=FALSE){
   if($pi_id==FALSE){
        $this->form_validation->set_rules('pi_no','PI NO','trim|is_unique[pi_master.pi_no]');
        }else{
        $this->form_validation->set_rules('product_model','Model','trim');
      }  
    if ($this->form_validation->run() == TRUE) {
      $check=$this->deptrequisn_model->save($pi_id);
      if($check && !$pi_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $pi_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
    redirect("format/deptrequisn/lists");
  }else{
    $data['collapse']='YES';
    $data['heading']='Add PI';
    $data['department_id']=$this->session->userdata('department_id');
    $data['clist']=$this->look_up_model->clist();
    $data['ptlist']=$this->look_up_model->getPIType();
    $data['dlist']=$this->look_up_model->departmentList();
    $data['detail1']=$this->deptrequisn_model->getsafetyStock();
    $data['display']='format/addpi';
    $this->load->view('admin/master',$data);
  }
}
function delete($pi_id=FALSE){
  $check=$this->deptrequisn_model->delete($pi_id);
    if($check){ 
       $this->session->set_userdata('exception','Delete successfully');
     }else{
       $this->session->set_userdata('exception','Delete Failed');
    }
  redirect("format/deptrequisn/lists");
}
  /////////////////////////////
public function suggestions(){
    $date = date('Y-m-d');
    $threemonth = date('Y-m-d',strtotime($date." -3 month"));

    $term = $this->input->get('term', true);
    if (strlen($term) < 1 || !$term) {
        die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
    }
    $department_id=$this->session->userdata('department_id');
    
    $rows = $this->deptrequisn_model->getRequisitionProduct($term);
    if ($rows){
        $c = str_replace(".", "", microtime(true));
        $r = 0;
        foreach ($rows as $row) {
          if($department_id==12){
            $safety_qty=$row->minimum_stock;
          }else{
            $safety_qty=$row->minimum_stock;
          }
          $unit_price=$row->unit_price;

          // if($row->last_receive_date<$threemonth){
          //  $unit_price=0;
          // }
          $product_name="$row->product_name";
            $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id,'safety_qty' => $safety_qty, 'label' => $row->product_name . " (" . $row->product_code . ")". " (Stock=" . $row->main_stock . ")",'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'product_name' =>$product_name ,'product_code' => $row->product_code, 'unit_price' => $unit_price,'image_link' => $row->product_image, 'stock' =>$row->main_stock, 'currency' =>$row->currency, 'product_description' =>$row->product_description);
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
  
  function submit($pi_id=FALSE){
      $this->load->model('communication');
      $data['info']=$this->deptrequisn_model->get_info($pi_id); 
      $department_id=$data['info']->department_id;
      $emailaddress="charlotte.chan@bdventura.com ";
      
      $subject="PI Review Notification";
      $message=$this->load->view('pi_review_notification', $data,true); 
      $this->communication->send($emailaddress,$subject,$message);
    ////////////////////////
    // $user_id = 188;
    // $title= 'Test Title';
    // $body = 'Test message body';
    // $url = 'https://api.vlmbd.com/api/send_notification_by_department/'.$this->session->userdata('department_id').'/0';
    // $data = array(
    //     "title" => "Test Alldivision Title",
    //     "body" => "Test M Alldivision body",
    // );
    // //echo sprintf("%s?%s", $url, http_build_query($data));
    // $encodedData = json_encode($data);
    // $curl = curl_init($url);
    // $data_string = urlencode(json_encode($data));
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    // curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    // curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData);
    // $result = curl_exec($curl);
    // curl_close($curl);
    // print $result; exit;
    ///////////////////
    $check=$this->deptrequisn_model->submit($pi_id);
      if($check){ 
        $this->session->set_userdata('exception','Send successfully');
       }else{
        $this->session->set_userdata('exception','Send Failed');
      }
    redirect("format/deptrequisn/lists");
  }

  //////////////////////
  function deleteitem(){
    $pi_id=$this->input->post('pi_id');
    $product_id=$this->input->post('product_id');
    $chkiteminfo=$this->db->query("SELECT * FROM pi_item_details 
          WHERE pi_id=$pi_id AND product_id=$product_id")->row();

      if(count($chkiteminfo)>0){
       $textpi.=" Remove this item ".$chkiteminfo->product_name." qty ".$chkiteminfo->required_qty."<br>";
      }
    $returncheck=$this->db->query("SELECT * FROM pi_master 
        WHERE pi_id=$pi_id AND reject_note IS NOT NULL")->row();
    if(count($returncheck)>0){
     if($textpi!=''){
      $data4['update_text']=$textpi;
      $data4['update_date']=date('Y-m-d');
      $data4['pi_id']=$pi_id;
      $this->db->insert('pi_update_info',$data4);
     }
     }
     $this->db->WHERE('pi_id',$pi_id);
     $this->db->WHERE('product_id',$product_id);
     $this->db->delete('pi_item_details');
    echo TRUE;
  }
  function rejected($pi_id=FALSE){
    $check=$this->deptrequisn_model->rejected($pi_id);
      if($check){ 
        $this->session->set_userdata('exception','Reject successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("format/purhrequisn/lists");
  }
  /////////////////////////////////
  public function checkpino(){
    $pi_no = $this->input->post('pi_no');
    $pi_id = $this->input->post('pi_id');
    $pi_no=str_replace(" ","",$pi_no);
    $condition=' ';
    if ($pi_id!='') {
      $condition=$condition."  AND pm.pi_id!=$pi_id ";
    }
    $info=$this->db->query("SELECT pm.* 
        FROM  pi_master pm 
        WHERE pm.pi_no='$pi_no' $condition")->row();
    
    if(count($info)>0){
      $data=array('check'=>'YES');
    }else{
      $data=array('check'=>'NO');
    }
  echo json_encode($data);
 }
function viewpihtmlonly($pi_id=FALSE){
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Purchase Indent';
    $data['info']=$this->deptrequisn_model->get_info($pi_id);
    $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
    $data['display']='format/viewpihtmlonly';
  $this->load->view('admin/master',$data);     
  }
  function returns($pi_no=FALSE){
    $data=array();
    $data['pi_status']=1;
    $this->db->WHERE('pi_no',$pi_no);
    $query=$this->db->update('pi_master',$data);
    redirect("format/deptrequisn/lists");
  }
}