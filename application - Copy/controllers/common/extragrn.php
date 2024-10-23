<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Extragrn extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('common/extragrn_model');
     }
    function lists(){
       $data=array();
       if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'common/extragrn/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->extragrn_model->get_count();
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
        $data['list']=$this->extragrn_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        ////////////////////////////
        $data['heading']='Extra Received List';
        $data['display']='common/extragrnlist';
        $this->load->view('admin/master',$data);
       }


    function add(){
      if($this->session->userdata('user_id')) {
        $data['heading']='Add Extra Receive';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        $data['clist']=$this->look_up_model->clist();
        $data['display']='common/addextragrn';
        $this->load->view('admin/master',$data);
      }else{
        redirect("logincontroller");
      }
    }
    
    function edit($purchase_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Extra Receive';
        $data['info']=$this->extragrn_model->get_info($purchase_id);
        $data['slist']=$this->look_up_model->getSupplier();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['clist']=$this->look_up_model->clist();
        $data['detail']=$this->extragrn_model->getDetails($purchase_id);
        $data['display']='common/addextragrn';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
   function save($purchase_id=FALSE){
        $check=$this->extragrn_model->save($purchase_id);
        if($check && !$purchase_id){
         $this->session->set_userdata('exception','Saved successfully');
         }elseif($check&& $purchase_id){
             $this->session->set_userdata('exception','Update successfully');
         }else{
           $this->session->set_userdata('exception','Submission Failed');
         }
      redirect("common/extragrn/lists");
    }
    function delete($purchase_id=FALSE){
      $check=$this->extragrn_model->delete($purchase_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("common/extragrn/lists");
    }
////////////////////////
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
              $stock=$row->main_stock;
              $description="Category: $row->category_name";
              $pr[] = array('id' => ($c + $r), 'product_id' =>$row->product_id, 'label' => $row->product_name . " (" . $row->product_code . ")",'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'description' => $description, 'product_name' => $row->product_name,'product_code' => $row->product_code, 'unit_price' => $row->unit_price, 'stock' =>$stock);
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
  function view($purchase_id=FALSE){
      $data['show']=1;
      $data['controller']=$this->router->fetch_class();
      $data['heading']='Extra Receive Form';
      $data['info']=$this->extragrn_model->get_info($purchase_id);
      $data['detail']=$this->extragrn_model->getDetails($purchase_id);
      $data['display']='common/receiveformhtml';
      $this->load->view('admin/master',$data);
    }
function viewpdf($purchase_id=FALSE){
  if ($this->session->userdata('user_id')) {
  $data['heading']='Extra Receive Items ';
      $data['info']=$this->extragrn_model->get_info($purchase_id);
      $data['detail']=$this->extragrn_model->getDetails($purchase_id);
      $pdfFilePath='ItemReceiveInvoice'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','A4','','','5','5','10','18');
      $mpdf->useAdobeCJK = true;
      $mpdf->SetAutoFont(AUTOFONT_ALL);
      $mpdf->autoScriptToLang = true;
      $mpdf->autoLangToFont = true;
      $header = $this->load->view('header', $data, true);
      $html=$this->load->view('common/viewItemsInvoice', $data, true);
      $mpdf->setHtmlHeader($header);
      $mpdf->pagenumPrefix = '  Page ';
      $mpdf->pagenumSuffix = ' - ';
      $mpdf->nbpgPrefix = ' out of ';
      $mpdf->nbpgSuffix = '';
      $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
      $mpdf->WriteHTML($html);
      $mpdf->Output($pdfFilePath,'D');
  } else {
     redirect("logincontroller");
  }
}

function submit($purchase_id=FALSE){
    $this->load->model('communication');
    $data['info']=$this->extragrn_model->get_info($purchase_id); 
    $department_id=$data['info']->for_department_id;
    $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
      WHERE department_id=$department_id")->row('dept_head_email');
    $subject="GRN Received Notification";
    $message=$this->load->view('grn_received_email', $data,true); 
    //$this->communication->send($emailaddress,$subject,$message);
  ////////////////////////
  $check=$this->extragrn_model->submit($purchase_id);
    if($check){ 
      $this->session->set_userdata('exception','Send successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("common/extragrn/lists");
  }

      
 }