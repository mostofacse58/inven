<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courier extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('cc/courier_model');
        $this->load->model('cc/chargeback_model');
        if($this->session->userdata('language')=='chinese'){
        $this->lang->load('chinese', "chinese");
        }else{
          $this->lang->load('english', "english");
        }
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
        else $perpage=10;
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
        $data['collapse']='YES';
        $data['ilist']=$this->chargeback_model->lists();
        $data['ulist']=$this->courier_model->Userlists();
        $data['slist']=$this->courier_model->ShipTolists();
        $data['display']='cc/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($courier_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Courier Control';
        $data['collapse']='YES';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['ilist']=$this->chargeback_model->lists();
        $data['ulist']=$this->courier_model->Userlists();
        $data['slist']=$this->courier_model->ShipTolists();
        $data['display']='cc/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
  
    function save($courier_id=FALSE){
        $this->form_validation->set_rules('issuer','Issuer','trim|required');
        $this->form_validation->set_rules('authorised_by','authorised_by','trim|required');
        $this->form_validation->set_rules('issue_date','issue_date','trim|required');
        $this->form_validation->set_rules('ship_id','Ship','trim|required');
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
            $data['ilist']=$this->chargeback_model->lists();
            $data['ulist']=$this->courier_model->Userlists();
            $data['slist']=$this->courier_model->ShipTolists();
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
        $data['display']='cc/view';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function loadpdf($courier_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='COURIER';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['courier_id']=$courier_id;
        $file_name='COURIER'.date('Ymdhi')."-$courier_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/pdf/".$file_name.".pdf";
        
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
        $file_name='COURIER'.date('Ymdhi')."-$courier_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/pdf/".$file_name;
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
        $this->session->set_userdata('exception','Submit successfully');
      redirect("cc/courier/lists");
    }
    public function getShipTo(){
      $ship_id = $this->input->post('ship_id');
      $info=$this->db->query("SELECT*   
          FROM  ship_to_info  
          WHERE ship_id=$ship_id ")->row();
        $data=array('ship_name'=>$info->ship_name,'ship_address'=>$info->ship_address,'ship_attention'=>$info->ship_attention,'ship_telephone'=>$info->ship_telephone,'ship_email'=>$info->ship_email);
      echo  json_encode($data);
    }
    
 
   
 }