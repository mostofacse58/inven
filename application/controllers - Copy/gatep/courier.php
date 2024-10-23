<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gatepass extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
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
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'cc/courier/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->courier_model->get_count();
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
        $data['list']=$this->courier_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Courier Control Lists';
        $data['display']='cc/draftlists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }

    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Courier Control';
        $data['ilist']=$this->courier_model->getIssueTo();
        $data['display']='cc/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($courier_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Courier Control';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['ilist']=$this->courier_model->getIssueTo();
        $data['display']='cc/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    public function suggestions(){
        $term = $this->input->get('term', true);
        $data_from = $this->input->get('data_from', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows=$this->courier_model->getData($data_from,$term);
        if($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            //$pr=array();
            foreach ($rows as $row) {
              $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 
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
    function save($courier_id=FALSE){
        $this->form_validation->set_rules('wh_whare','Location','trim|required');
        $this->form_validation->set_rules('issue_to','Issue To','trim');
        $this->form_validation->set_rules('employee_id','ID','trim|required');
        $this->form_validation->set_rules('carried_by','Employee','trim|required');
        $this->form_validation->set_rules('courier_type','Type','trim|required');
        $this->form_validation->set_rules('create_date','Date','trim|required');
        $this->form_validation->set_rules('data_from','Data From','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->courier_model->save($courier_id);
            if($check && !$courier_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $courier_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                   $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("cc/courier/lists");
         }else{
            $data['heading']='Add Courier Control';
            if($courier_id){
              $data['heading']='Edit Courier Control';
              $data['info']=$this->courier_model->get_info($courier_id); 
              $data['detail']=$this->courier_model->get_detail($courier_id); 
            }
            $data['ilist']=$this->courier_model->getIssueTo();
            $data['ulist']=$this->courier_model->getProductUnit();
            $data['display']='cc/add';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($courier_id){
      $this->courier_model->delete($courier_id); 
      $this->session->set_userdata('exception','Delete successfully');
      redirect("cc/courier/lists");
    }
    function view($courier_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['courier_id']=$courier_id;
        $data['heading']='Courier Control Details Information';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['display']='cc/viewpass';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function loadpdf($courier_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='GATEPASS';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['courier_id']=$courier_id;
        $file_name='GATEPASS'.date('Ymdhi')."-$courier_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$file_name.".pdf";
        
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('cc/courierPdf', $data, true);
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
      public function submit($courier_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $dept_head_email=$this->db->query("SELECT * FROM department_info
          WHERE department_id=$department_id")->row('dept_head_email');
        ////////////////////////////////////////
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['courier_id']=$courier_id;

        $data2['courier_status']=2;
        $this->db->where('courier_id', $courier_id);
        $this->db->update('courier_master',$data2);
        ///////////////////
        $file_name='GATEPASS'.date('Ymdhi')."-$courier_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$file_name.".pdf";
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('cc/courierPdf', $data, true);
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
        $this->email->from("onlinecourier@vlmbd.com","Online Courier Control System.");
        $this->email->to($dept_head_email);
        $this->email->subject("Courier Control Approval Notification");
        $message=$this->load->view('cc/email_body', $data,true);
        $this->email->message($message);
        $this->email->attach('Pdf/'.$file_name);
        $this->email->send();
        $this->email->clear(TRUE);
        $this->session->set_userdata('exception','Send successfully');
      redirect("cc/courier/lists");
    }
     function addNewByAjax(){
        $department_id=$this->session->userdata('department_id');
        $data['issue_to_name'] = $this->input->post('issue_to_name');
        $data['mobile_no'] = $this->input->post('mobile_no');
        $data['address'] = $this->input->post('address');
        $data['department_id']=$this->session->userdata('department_id');
        $this->db->insert('issue_to_master', $data);
        $data1=$this->db->query("SELECT *
                  FROM issue_to_master WHERE department_id=$department_id")->result();
         echo '<option value="">Select any one</option>';
        foreach ($data1 as $value) {
         echo '<option value="'.$value->issue_to.'" >'.$value->issue_to_name.'</option>';
         }
        exit;
    }
 
   
 }