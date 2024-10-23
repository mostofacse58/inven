<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pistatusreport extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/pistatusreport_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='PI Status Report';
        $data['ptlist']=$this->look_up_model->getPIType();
		//$data['clist']=$this->look_up_model->getCategory(12);
        $data['dlist']=$this->look_up_model->departmentList();
	    $data['display']='commonr/pistatusreport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='PI Status Report ';
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['ptlist']=$this->look_up_model->getPIType();
        $this->form_validation->set_rules('pi_no','PI NO','trim');
        $this->form_validation->set_rules('product_code','Code','trim');
        $this->form_validation->set_rules('from_date','Date','trim');
        $this->form_validation->set_rules('to_date','date','trim');
        $this->form_validation->set_rules('purchase_type_id','date','trim');
        if ($this->form_validation->run() == TRUE) {
        $data['pi_no']=$this->input->post('pi_no');
        $data['department_id']=$this->input->post('department_id');
        $data['product_code']=$this->input->post('product_code');
        $data['pi_status']=$this->input->post('pi_status');
        $data['purchase_type_id']=$this->input->post('purchase_type_id');
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        $data['resultdetail']=$this->pistatusreport_model->reportrResult($data['department_id'],$data['pi_status'],$data['pi_no'],$data['product_code'],$data['purchase_type_id'],$data['from_date'],$data['to_date']);
        $data['display']='commonr/pistatusreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='commonr/pistatusreport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($department_id,$pi_status,$pi_no,$product_code,$purchase_type_id,$from_date=FALSE,$to_date=FALSE) {
        $data['heading']='PI Status Report ';
        $data['resultdetail']=$this->pistatusreport_model->reportrResult($department_id,$pi_status,$pi_no,$product_code,$purchase_type_id,$from_date,$to_date);
        $this->load->view('commonr/pistatusreportExcel',$data);
    }
    function getBox(){
          $rack_id=$this->input->post('rack_id');
           $result=$this->db->query("SELECT *
            FROM box_info 
            WHERE department_id=12 
            and rack_id=$rack_id")->result();
        echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->box_id.'" >'.$value->box_name.'</option>';
      }
    exit;
   }
   function downloadPdf($category_id,$department_id,$product_code,$from_date,$to_date) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='PI Status Report ';
    $data['category_id']=$category_id;
    $data['product_code']=$product_code;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->itemreceivereport_model->reportrResult($category_id,$department_id,$product_code,$from_date,$to_date);
    $pdfFilePath='sparesReceivePdf'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('commonr/itemreceivereportPdf', $data, true);
    $mpdf->setHtmlHeader($header);
    $mpdf->pagenumPrefix = '  Page ';
    $mpdf->pagenumSuffix = ' - ';
    $mpdf->nbpgPrefix = ' out of ';
    $mpdf->nbpgSuffix = '';
    $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    } else {
       redirect("logincontroller");
    }
    }
    
}