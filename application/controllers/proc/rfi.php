<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rfi extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('shipping/import_model');
        $this->load->model('proc/rfi_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'proc/rfi/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->rfi_model->get_count();
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
      $total_rows=$config['total_rows'];
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
      $data['list']=$this->rfi_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['heading']='Rfi Lists';
      $data['display']='proc/rfi_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }
  function add(){
    if($this->session->userdata('user_id')) {
      $data['heading']='Add Rfi';
      $data['display']='proc/addrfi';
      $this->load->view('admin/master',$data);
    }else{
      redirect("logincontroller");
    }
  }
  function edit($rfi_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Edit Rfi';
    $data['info']=$this->rfi_model->get_info($rfi_id);
    $data['detail']=$this->rfi_model->getDetails($rfi_id);
    $data['display']='proc/addrfi';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
    }
   function save($rfi_id=FALSE){
      $check=$this->rfi_model->save($rfi_id);
      if($check && !$rfi_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $rfi_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("proc/rfi/lists");
    }
    function delete($rfi_id=FALSE){
      $check=$this->rfi_model->delete($rfi_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("proc/rfi/lists");
    }
////////////////////////
public function suggestions(){
        $term = $this->input->get('term', true);
        $pr_type = $this->input->get('pr_type', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->rfi_model->getRfiProduct($pr_type,$term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              $product_name="$row->product_name";
                $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 
                  'label' => $row->product_name . " (" . $row->product_code . ")". " (Stock=" . $row->main_stock . ")", 
                  'category_name' => $row->category_name ,
                  'unit_name' => $row->unit_name,
                  'product_name' =>$product_name ,'product_code' => $row->product_code, 'unit_price' => $row->unit_price,'image_link' => $row->product_image, 'stock' =>$row->main_stock);
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
    function view($rfi_id=FALSE){
      $data['info']=$this->rfi_model->get_info($rfi_id);
      $data['detail']=$this->rfi_model->getDetails($rfi_id);
      $data['display']='proc/rfiview';
      $this->load->view('admin/master',$data);
    }
    function pdf($rfi_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Rfi Form';
          $data['info']=$this->rfi_model->get_info($rfi_id);
          $data['detail']=$this->rfi_model->getDetails($rfi_id);
          $pdfFilePath='Rfi'.date('Y-m-d H:i').'.pdf';
          $this->load->library('mpdf');
          $mpdf = new mPDF('bn','L','','','15','15','10','18');
          $mpdf->useAdobeCJK = true;
          $mpdf->SetAutoFont(AUTOFONT_ALL);
          $mpdf->autoScriptToLang = true;
          $mpdf->autoLangToFont = true;
          $mpdf->AddPage('L');
          $header = $this->load->view('header', $data, true);
          $footer = $this->load->view('footer', $data, true);
          $html=$this->load->view('proc/rfipdf', $data, true);
          $mpdf->setHtmlFooter($footer);
          $mpdf->WriteHTML($html);
          $mpdf->Output();
        } else {
           redirect("logincontroller");
        }
      }
    function excelload($rfi_id=FALSE){
      $data['heading']='Rfi Form';
      $data['info']=$this->rfi_model->get_info($rfi_id);
      $data['detail']=$this->rfi_model->getDetails($rfi_id);
      $this->load->view('proc/rfiExcel', $data);
    }
    function submit($rfi_id=FALSE){
      $this->load->model('communication');
      $data['info']=$this->rfi_model->get_info($rfi_id); 
      $department_id=$data['info']->department_id;
      $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
        WHERE department_id=$department_id")->row('dept_head_email');
      $subject="Rfi Approval Notification";
      $message=$this->load->view('req_email_format', $data,true); 
     // $this->communication->send($emailaddress,$subject,$message);
      $check=$this->rfi_model->submit($rfi_id);
        if($check){ 
           $this->session->set_userdata('exception','Send successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("proc/rfi/lists");
    }

   
 }