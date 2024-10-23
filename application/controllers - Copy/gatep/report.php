<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/report_model');
     }
    
    function returnable(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Returnable Item Report';
		$data['dlist']=$this->report_model->getDepartment();
	    $data['display']='gatep/returnablereport';
        $this->load->view('admin/master',$data);
        } else {
        redirect("logincontroller");
        }
    }
    function returnableResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Returnable Item Report';
        $data['dlist']=$this->report_model->getDepartment();
        $this->form_validation->set_rules('department_id','Department Name','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim');
        $this->form_validation->set_rules('to_date','To Date','trim');
        if ($this->form_validation->run() == TRUE) {
        $data['department_id']=$this->input->post('department_id');
        $from_date=alterDateFormat($this->input->post('from_date'));
        $to_date=alterDateFormat($this->input->post('to_date'));
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['pendingstatus']=$this->input->post('pendingstatus');
        $data['resultdetail']=$this->report_model->returnableResult($data['department_id'],$from_date,$to_date);
        //print_r($data['resultdetail']);
        $data['display']='gatep/returnablereport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='gatep/returnablereport';
        $this->load->view('admin/master',$data);
        }
        }else {
           redirect("logincontroller");
        } 
    }
    function returnablePDF($pendingstatus,$department_id,$from_date=FALSE,$to_date=FALSE){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Returnable Item Report';
      $data['resultdetail']=$this->report_model->returnableResult($department_id,$from_date,$to_date);
        $data['department_id']=$department_id;
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['pendingstatus']=$pendingstatus;
        $pdfFilePath='Returnable_report'.date('Y-m-d').'.pdf';
        $this->load->library('mpdf');
        $mpdf=new mPDF('utf-8');
        $mpdf = new mPDF('bn','L','','','15','15','28','15');
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('gatep/returnablepdf', $data, true);
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
    ////////////////////////////////////
    function nonreturnable(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Non-Returnable Item Report';
        $data['dlist']=$this->report_model->getDepartment();
        $data['display']='gatep/nonreturnablereport';
        $this->load->view('admin/master',$data);
        } else {
        redirect("logincontroller");
        }
    }
    function nonreturnableResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Non-Returnable Item Report';
        $data['dlist']=$this->report_model->getDepartment();
        $this->form_validation->set_rules('department_id','Department Name','trim|required');
        $this->form_validation->set_rules('gatepass_type','Type','trim|required');
        $this->form_validation->set_rules('issue_from','From','trim|required');
        $this->form_validation->set_rules('wh_whare','To','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim');
        $this->form_validation->set_rules('to_date','To Date','trim');
        if ($this->form_validation->run() == TRUE) {
        $data['department_id']=$this->input->post('department_id');
        $data['gatepass_type']=$this->input->post('gatepass_type');
        $data['issue_from']=$this->input->post('issue_from');
        $data['wh_whare']=$this->input->post('wh_whare');
        $from_date=alterDateFormat($this->input->post('from_date'));
        $to_date=alterDateFormat($this->input->post('to_date'));
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['resultdetail']=$this->report_model->nonreturnableResult($data['department_id'],$data['gatepass_type'],$data['issue_from'],$data['wh_whare'],$from_date,$to_date);
        $data['display']='gatep/nonreturnablereport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='gatep/nonreturnablereport';
        $this->load->view('admin/master',$data);
        }
        }else {
           redirect("logincontroller");
        } 
    }
    function nonreturnablePDF($department_id,$gatepass_type,$issue_from,$wh_whare,$from_date,$to_date){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Non-Returnable Item Report';
      $data['resultdetail']=$this->report_model->nonreturnableResult($department_id,$gatepass_type,$issue_from,$wh_whare,$from_date,$to_date);
        $data['department_id']=$department_id;
        $data['gatepass_type']=$gatepass_type;
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $pdfFilePath='NonReturnable_report'.date('Y-m-d').'.pdf';
        $this->load->library('mpdf');
        $mpdf=new mPDF('utf-8');
        $mpdf = new mPDF('bn','L','','','15','15','28','15');
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('gatep/nonreturnablePDF', $data, true);
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
    function nonreturnableExcel($department_id,$gatepass_type,$issue_from,$wh_whare,$from_date=FALSE,$to_date=FALSE){
        $data['heading']='Non-Returnable Item Report';
        $data['resultdetail']=$this->report_model->nonreturnableResult($department_id,$gatepass_type,$issue_from,$wh_whare,$from_date,$to_date);
        $data['department_id']=$department_id;
        $data['gatepass_type']=$gatepass_type;
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $this->load->view('gatep/nonreturnablePDF', $data);
    
    }

}