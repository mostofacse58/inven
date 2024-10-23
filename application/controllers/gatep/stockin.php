<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockin extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/stockin_model');
        if($this->session->userdata('language')=='chinese'){
        $this->lang->load('chinese', "chinese");
        }else{
          $this->lang->load('english', "english");
        }
     }
    
    function lists(){
        

      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'gatep/stockin/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->stockin_model->get_count();
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
        $data['list']=$this->stockin_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Stock Return Lists';
        $data['display']='gatep/stockin';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }

    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Gate Pass';
        $data['display']='gatep/stockinadd';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($gatepass_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Gate Pass';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['display']='gatep/stockinadd';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows=$this->stockin_model->getData($term);
        if($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            //$pr=array();
            foreach ($rows as $row) {
              $pr[] = array('id' => ($c + $r), 
                'label' => $row->product_name . " (" . $row->product_code . ")",
                'unit_name' => $row->unit_name, 'product_name' => $row->product_name,'product_code' => $row->product_code);
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
    function save($gatepass_id=FALSE){
        $this->form_validation->set_rules('create_date','Date','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->stockin_model->save($gatepass_id);
            if($check && !$gatepass_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $gatepass_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("gatep/stockin/lists");
         }else{
            $data['heading']='Add Gate Pass';
            if($gatepass_id){
              $data['heading']='Edit Gate Pass';
              $data['info']=$this->stockin_model->get_info($gatepass_id); 
              $data['detail']=$this->stockin_model->get_detail($gatepass_id); 
            }
            $data['display']='gatep/stockinadd';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($gatepass_id){
      $this->stockin_model->delete($gatepass_id); 
      $this->session->set_userdata('exception','Delete successfully');
      redirect("gatep/stockin/lists");
    }
    function view($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['display']='gatep/stockinviewpass';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function loadpdf($gatepass_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='GATEPASS';
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['gatepass_id']=$gatepass_id;
        $file_name='GATEPASS'.date('Ymdhi')."-$gatepass_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$file_name.".pdf";
        
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('gatep/stockingatepassPdf', $data, true);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'F');
        } else {
        redirect("logincontroller");
        }
      }
      public function submit($gatepass_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $dept_head_email=$this->db->query("SELECT * FROM department_info
          WHERE department_id=$department_id")->row('dept_head_email');
        ////////////////////////////////////////
        $data['info']=$this->stockin_model->get_info($gatepass_id);
        $data['detail']=$this->stockin_model->get_detail($gatepass_id);
        $data['gatepass_id']=$gatepass_id;

        $data2['gatepass_status']=2;
        $this->db->where('gatepass_id', $gatepass_id);
        $this->db->update('gatepass_master_stock',$data2);
        ///////////////////
        $file_name='GATEPASS'.date('Ymdhi')."-$gatepass_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$file_name.".pdf";
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('gatep/gatepassPdf', $data, true);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'F');
        ////////////////////EMAIL SECTION///////////////////
        $this->load->library('email');
        $config['protocol'] = 'mail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->from("onlinegatepass@vlmbd.com","Online Gate Pass System.");
        $this->email->to($dept_head_email);
        $this->email->subject("Gate Pass Approval Notification");
        $message=$this->load->view('gatep/email_body', $data,true);
        $this->email->message($message);
        $this->email->attach('Pdf/'.$file_name);
        $this->email->send();
        $this->email->clear(TRUE);
        $this->session->set_userdata('exception','Send successfully');
      redirect("gatep/stockin/lists");
    }

 
   
 }