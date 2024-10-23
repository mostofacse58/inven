<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('payment/report_model');
     }
    
    function supplier(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Supplier Report';
		$data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
	    $data['display']='payment/supplierreport';
        $this->load->view('admin/master',$data);
        } else {
        redirect("logincontroller");
        }
    }
    function supplierResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Supplier Report';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        $this->form_validation->set_rules('department_id','Department Name','trim|required');
        $this->form_validation->set_rules('supplier_id','Supplier Name','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim');
        $this->form_validation->set_rules('to_date','To Date','trim');
        if ($this->form_validation->run() == TRUE) {
        $data['department_id']=$this->input->post('department_id');
        $from_date=alterDateFormat($this->input->post('from_date'));
        $to_date=alterDateFormat($this->input->post('to_date'));
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['resultdetail']=$this->report_model->supplierResult($data['department_id'],$data['supplier_id'],$from_date,$to_date);
        $data['display']='payment/supplierreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='payment/supplierreport';
        $this->load->view('admin/master',$data);
        }
        }else {
           redirect("logincontroller");
        } 
    }
    function supplierExcel($department_id,$supplier_id,$from_date=FALSE,$to_date=FALSE){
        $data['heading']='supplier Report';
        $data['resultdetail']=$this->report_model->supplierResult($department_id,$supplier_id,$from_date,$to_date);
        $data['department_id']=$department_id;
        $data['supplier_id']=$supplier_id;
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $this->load->view('payment/supplierreportExcel', $data);
    
    }
    function supplierPDF($department_id,$from_date,$to_date){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Supplier Report';
      $data['resultdetail']=$this->report_model->returnableResult($department_id,$from_date,$to_date);
        $data['department_id']=$department_id;
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $pdfFilePath='Returnable_report'.date('Y-m-d').'.pdf';
        $this->load->library('mpdf');
        $mpdf=new mPDF('utf-8');
        $mpdf = new mPDF('bn','L','','','15','15','28','15');
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('payment/returnablepdf', $data, true);
        $mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'D');
       }else{
        redirect("logincontroller");
      }
    }
   

}