<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Requisitionreport extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/requisitionreport_model');
     }
    function SearchForm(){
        $data['heading']='Requisition Report';
        $data['dlist']=$this->look_up_model->departmentList();
	    $data['display']='commonr/requisitionreport';
        $this->load->view('admin/master',$data);
     }

    function reportrResult(){
        $data['heading']='Requisition Report ';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['ptlist']=$this->look_up_model->getPIType();
        $this->form_validation->set_rules('requisition_no','Requisition No','trim');
        $this->form_validation->set_rules('product_code','Code','trim');
        $this->form_validation->set_rules('from_date','Date','trim');
        $this->form_validation->set_rules('to_date','date','trim');
        $this->form_validation->set_rules('take_department_id','date','trim');
        if ($this->form_validation->run() == TRUE) {
        $data['requisition_no']=$this->input->post('requisition_no');
        $data['product_code']=$this->input->post('product_code');
        $data['requisition_status']=$this->input->post('requisition_status');
        $data['take_department_id']=$this->input->post('take_department_id');
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        $data['resultdetail']=$this->requisitionreport_model->reportrResult($data['requisition_status'],$data['requisition_no'],$data['product_code'],$data['take_department_id'],$data['from_date'],$data['to_date']);
        $data['display']='commonr/requisitionreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='commonr/requisitionreport';
        $this->load->view('admin/master',$data);
        }
    }
    function downloadExcel($take_department_id=FALSE,$requisition_status,$requisition_no=FALSE,$product_code=FALSE,$from_date=FALSE,$to_date=FALSE) {
        $data['heading']='Requisition Report ';
        $data['resultdetail']=$this->requisitionreport_model->reportrResult($requisition_status,$requisition_no,$product_code,$take_department_id,$from_date,$to_date);
        $this->load->view('commonr/requisitionreportExcel',$data);
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
    $data['heading']='Requisition Report ';
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