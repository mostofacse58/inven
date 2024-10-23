<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Oldpr extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/oldpr_model');
     }
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/oldpr/lists/';
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->oldpr_model->get_count();
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
      $data['list']=$this->oldpr_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      $data['heading']='Requisition Lists';
      $data['display']='format/oldpr';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }
  function add(){
    if($this->session->userdata('user_id')) {
      $data['heading']='Add Requisition';
      $data['detail1']=$this->oldpr_model->getsafetyStock();
      $data['display']='format/addsendreq';
      $this->load->view('admin/master',$data);

    }else{
      redirect("logincontroller");
    }
  }
  function edit($deptrequisn_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Edit Requisition';
    $data['info']=$this->oldpr_model->get_info($deptrequisn_id);
    $data['detail']=$this->oldpr_model->getDetails($deptrequisn_id);
    $data['display']='format/addsendreq';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
    }
   function save($deptrequisn_id=FALSE){
      $check=$this->oldpr_model->save($deptrequisn_id);
      if($check && !$deptrequisn_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $deptrequisn_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("format/deptrequisn/lists");
    }
    function delete($deptrequisn_id=FALSE){
      $check=$this->oldpr_model->delete($deptrequisn_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("format/deptrequisn/lists");
    }
////////////////////////
public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->oldpr_model->getRequisitionProduct($term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              $product_name="$row->product_name($row->product_code)";
                $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 'label' => $row->product_name . " (" . $row->product_code . ")". " (Stock=" . $row->main_stock . ")", 'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'product_name' =>$product_name ,'product_code' => $row->product_code, 'unit_price' => $row->unit_price,'image_link' => $row->product_image, 'stock' =>$row->main_stock);
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
    function view($deptrequisn_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Requisition Form';
            $data['info']=$this->oldpr_model->get_info($deptrequisn_id);
            $data['detail']=$this->oldpr_model->getDetails($deptrequisn_id);
            $pdfFilePath='Requisition'.date('Y-m-d H:i').'.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','L','','','15','15','10','18');
            $mpdf->useAdobeCJK = true;
            $mpdf->SetAutoFont(AUTOFONT_ALL);
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('L');
            $header = $this->load->view('header', $data, true);
            $footer = $this->load->view('footer', $data, true);
            $html=$this->load->view('format/sendreqView', $data, true);
            $mpdf->setHtmlFooter($footer);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
           redirect("logincontroller");
        }
      }
      function submit($deptrequisn_id=FALSE){
        $this->load->model('communication');
        $data['info']=$this->oldpr_model->get_info($deptrequisn_id); 
        $department_id=$data['info']->department_id;
        $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
        WHERE department_id=$department_id")->row('dept_head_email');

        $subject="Purchase Requisition Approval Notification";
        $message=$this->load->view('req_email_format1', $data,true); 
      ///$this->communication->send($emailaddress,$subject,$message);
      ////////////////////////
      $check=$this->oldpr_model->submit($deptrequisn_id);
        if($check){ 
           $this->session->set_userdata('exception','Send successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("format/deptrequisn/lists");
    }

   
 }