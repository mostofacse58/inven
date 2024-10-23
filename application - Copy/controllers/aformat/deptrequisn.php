<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Deptrequisn extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('aformat/deptrequisn_model');
        $this->load->model('format/requisition_model');
        
     }
    
    function lists(){
    if($this->session->userdata('user_id')) {
    $data=array();
    if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'aformat/deptrequisn/lists/';
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->deptrequisn_model->get_count();
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
      $data['list']=$this->deptrequisn_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->look_up_model->departmentList();
      ////////////////////////////////////////
      $data['heading']='Fixed Asset PI Lists 固定资产购买缩进清单';
      $data['display']='aformat/deptpi_list';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }
  function add(){
    if($this->session->userdata('user_id')) {
      $data['collapse']='YES';
      $data['heading']='Add PI';
      $data['clist']=$this->look_up_model->clist();
      $data['ptlist']=$this->look_up_model->getPIType();
      $data['dlist']=$this->look_up_model->departmentList();
      $data['display']='aformat/addpi';
      $this->load->view('admin/master',$data);
    }else{
      redirect("logincontroller");
    }
  }
  function edit($pi_id){
    if ($this->session->userdata('user_id')) {
      $data['collapse']='YES';
      $data['heading']='Edit PI';
      $data['clist']=$this->look_up_model->clist();
      $data['ptlist']=$this->look_up_model->getPIType();
      $data['info']=$this->deptrequisn_model->get_info($pi_id);
      $data['dlist']=$this->look_up_model->departmentList();
      $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
      $data['display']='aformat/addpi';
      $this->load->view('admin/master',$data);
      } else {
         redirect("logincontroller");
      }
  }
 function prtopi($requisition_id){
      $data['collapse']='YES';
      $data['heading']='Edit PI';
      $data['ptlist']=$this->look_up_model->getPIType();
      $data['clist']=$this->look_up_model->clist();
      $data['dlist']=$this->look_up_model->departmentList();
      $info=$this->requisition_model->get_info($requisition_id);
      $data['detail']=$this->deptrequisn_model->getPRDetails($requisition_id);
      $data['department_id']=$info->department_id;
      $data['display']='aformat/addpi';
      $this->load->view('admin/master',$data);
  }
 function save($pi_id=FALSE){
      $check=$this->deptrequisn_model->save($pi_id);
      if($check && !$pi_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $pi_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
    redirect("aformat/deptrequisn/lists");
  }
  function delete($pi_id=FALSE){
    $check=$this->deptrequisn_model->delete($pi_id);
      if($check){ 
         $this->session->set_userdata('exception','Delete successfully');
       }else{
         $this->session->set_userdata('exception','Delete Failed');
      }
    redirect("aformat/deptrequisn/lists");
  }
  /////////////////////////////
  public function suggestions(){
      $term = $this->input->get('term', true);
      if (strlen($term) < 1 || !$term) {
          die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
      }
      $rows = $this->deptrequisn_model->getPIProduct($term);
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
  
    function submit($pi_id=FALSE){
      $this->load->model('communication');
      $data['info']=$this->deptrequisn_model->get_info($pi_id); 
      $department_id=$data['info']->department_id;
      if($department_id==8||$department_id==15||$department_id==22||$department_id==6){
        $emailaddress="robert.luo@bdventura.com";
      }elseif($department_id==9){
        $emailaddress="sarwar.hossen@bdventura.com";
      }elseif($department_id==4){
        $emailaddress="jwel.ahmmed@bdventura.com";
      }elseif($department_id==28){
        $emailaddress="jack.tang@bdventura.com;steven.xu@bdventura.com";
      }elseif($department_id==29){
        $emailaddress="devin@bdventura.com;steven.xu@bdventura.com";
      }elseif($department_id==5||$department_id==12||$department_id==17||$department_id==18||$department_id==28){
        $emailaddress="steven.xu@bdventura.com";
      }else{
        $emailaddress="thomas.zou@bdventura.com";
      }
    $subject="PI Certify Notification";
    $message=$this->load->view('for_certify_email', $data,true); 
    //$this->communication->send($emailaddress,$subject,$message);
    ////////////////////////
    $check=$this->deptrequisn_model->submit($pi_id);
      if($check){ 
        $this->session->set_userdata('exception','Send successfully');
       }else{
        $this->session->set_userdata('exception','Send Failed');
      }
    redirect("aformat/deptrequisn/lists");
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
     if($textpi!=''){
      $data4['update_text']=$textpi;
      $data4['update_date']=date('Y-m-d');
      $data4['pi_id']=$pi_id;
      $this->db->insert('pi_update_info',$data4);
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
    redirect("aformat/purhrequisn/lists");
  }
  function viewpihtmlonly($pi_id=FALSE){
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Purchase Indent';
    $data['info']=$this->deptrequisn_model->get_info($pi_id);
    $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
    $data['display']='format/viewpihtmlonly';
  $this->load->view('admin/master',$data);     
}
   
}