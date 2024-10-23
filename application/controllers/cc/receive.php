<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receive extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('cc/receive_model');
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
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
        else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'cc/receive/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->receive_model->get_count();
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
        $data['list']=$this->receive_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Courier Control Lists';
        $data['display']='cc/receivelists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
     function receiveview($courier_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['courier_id']=$courier_id;
        $data['heading']='Courier Control Details Information';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['view']='cc/callview';
        $data['display']='cc/receiveview';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
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
    public function received($courier_id=FALSE){
        $data2['courier_status']=4;
        $data2['received_by']=$this->session->userdata('user_id');
        $data2['received_date']=date('Y-m-d');
        $this->db->where('courier_id', $courier_id);
        $this->db->update('courier_master',$data2);
        $this->session->set_userdata('exception','Approved successfully');
        redirect("cc/receive/lists");
      }

     public function returns(){
        $courier_id=$this->input->post('courier_id');
        $data2['courier_status']=1;
        $data2['received_by']=$this->session->userdata('user_id');
        $data2['received_date']=date('Y-m-d');
        $data2['reject_note']=$this->session->userdata('user_name').':'.$this->input->post('reject_note');
        $this->db->where('courier_id', $courier_id);
        $this->db->update('courier_master',$data2);
        $this->session->set_userdata('exception','Return successfully');
        redirect("cc/receive/lists");
       }
    function loadpdf($courier_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='COURIER';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['courier_id']=$courier_id;
        $file_name='COURIER'.date('Ymdhi')."-$courier_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$file_name.".pdf";
        
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('cc/receivePdf', $data, true);
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
        $department_id=$this->session->userdata('user_id');
        $dept_head_email=$this->db->query("SELECT * FROM department_info
          WHERE department_id=$department_id")->row('dept_head_email');
        $data['courier_status']=5;
        $this->db->where('courier_id', $courier_id);
        $this->db->update('courier_master',$data);
        $this->session->set_userdata('exception','Submit successfully');
      redirect("cc/receive/lists");
    }
    function addinform($courier_id){
        $data['controller']=$this->router->fetch_class();
        $data['courier_id']=$courier_id;
        $data['clist']=$this->receive_model->getCCompany();
        $data['heading']='Courier Control Details Information';
        $data['info']=$this->courier_model->get_info($courier_id);
        $data['detail']=$this->courier_model->get_detail($courier_id);
        $data['display']='cc/addinform';
        $this->load->view('admin/master',$data);
    }

  public function saveinfo($courier_id=FALSE){
    $data['bd_eta']=alterDateFormat($this->input->post('bd_eta'));
    $data['bd_des']=$this->input->post('bd_des');
    $data['aws_no']=$this->input->post('aws_no');
    $data['courier_company']=$this->input->post('courier_company');
    $data['courier_company2']=$this->input->post('courier_company2');
    $data['bill_amount']=$this->input->post('bill_amount');
    $data['lcaws_no']=$this->input->post('lcaws_no');
    $data['lcaws_bill_amount']=$this->input->post('lcaws_bill_amount');
    $data['additional_charge']=$this->input->post('additional_charge');
    $this->db->where('courier_id', $courier_id);
    $this->db->update('courier_master',$data);
        $courier_detail_id=$this->input->post('courier_detail_id');
        $particulars=$this->input->post('particulars');
        $weight=$this->input->post('weight');
        $vol_weight=$this->input->post('vol_weight');
        $i=0;
        foreach($courier_detail_id as $value) {
          $data2['particulars']=$particulars[$i];
          $data2['weight']=$weight[$i];
          $data2['vol_weight']=$vol_weight[$i];
          $this->db->where('courier_detail_id', $value);
          $query=$this->db->update('courier_detail',$data2);
        $i++;
        }
    $this->session->set_userdata('exception','Save successfully');
    redirect("cc/receive/lists");
  }

   
 }