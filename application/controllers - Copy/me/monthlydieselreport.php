<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monthlydieselreport extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('me/dieselissue_model');
        $this->load->model('report/monthlydieselreport_model');
     }
  function searchForm(){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Monthly Diesel Report Report';
    $data['mlist']=$this->dieselissue_model->getDropdown('motor_info');
    $data['tlist']=$this->dieselissue_model->getDropdown('driver_info');
    $data['dlist']=$this->dieselissue_model->getDropdown('fuel_using_dept');
	$data['display']='report/monthlydieselreport';
    $this->load->view('admin/master',$data);
    } else {
      redirect("logincontroller");
    }
  }

function reportrResult(){
   if ($this->session->userdata('user_id')) {
    $data['heading']='Monthly Diesel Report Report ';
    $data['mlist']=$this->dieselissue_model->getDropdown('motor_info');
    $data['tlist']=$this->dieselissue_model->getDropdown('driver_info');
    $data['dlist']=$this->dieselissue_model->getDropdown('fuel_using_dept');
    $this->form_validation->set_rules('motor_id','Vehicle Name','trim|required');
    $this->form_validation->set_rules('fuel_using_dept_id','Department','trim|required');
    $this->form_validation->set_rules('driver_id','Taken By','trim|required');
    $this->form_validation->set_rules('from_date','From Date','trim');
    $this->form_validation->set_rules('to_date','To Date','trim');
    if ($this->form_validation->run() == TRUE) {
    $motor_id=$this->input->post('motor_id');
    $fuel_using_dept_id=$this->input->post('fuel_using_dept_id');
    $from_date=alterDateFormat($this->input->post('from_date'));
    $to_date=alterDateFormat($this->input->post('to_date'));
    $data['motor_id']=$this->input->post('motor_id');
    $data['from_date']=$from_date;
    $data['to_date']=$to_date;
    $data['fuel_using_dept_id']=$this->input->post('fuel_using_dept_id');
    $data['driver_id']=$this->input->post('driver_id');
    $data['resultdetail']=$this->monthlydieselreport_model->reportrResult($motor_id,$fuel_using_dept_id,$data['driver_id'],$from_date,$to_date);
    $data['display']='report/monthlydieselreport';
    $this->load->view('admin/master',$data);
    }else{
    $data['display']='report/monthlydieselreport';
    $this->load->view('admin/master',$data);
    }
    } else {
       redirect("logincontroller");
    } 
}
    function downloadExcel($motor_id=FALSE,$fuel_using_dept_id=FALSE,$driver_id=FALSE,$from_date=FALSE,$to_date=FALSE) {
        $data['heading']='Monthly Diesel Report Report ';
        $data['motor_id']=$motor_id;
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['fuel_using_dept_id']=$fuel_using_dept_id;
        $data['resultdetail']=$this->monthlydieselreport_model->reportrResult($motor_id,$fuel_using_dept_id,$driver_id,$from_date,$to_date);
        $this->load->view('excel/monthlydieselreportExcel',$data);
    }

  function downloadPdf($motor_id=FALSE,$fuel_using_dept_id=FALSE,$driver_id=FALSE,$product_code=FALSE) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='Monthly Diesel Report Report ';
    $data['motor_id']=$motor_id;
    $data['product_code']=$product_code;
    $data['fuel_using_dept_id']=$fuel_using_dept_id;
    $data['resultdetail']=$this->monthlydieselreport_model->reportrResult($motor_id,$fuel_using_dept_id,$driver_id,$product_code);
    $pdfFilePath='dieselusingPdf'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('pdf/monthlydieselreportPdf', $data, true);
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