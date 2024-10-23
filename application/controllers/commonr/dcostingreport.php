<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dcostingreport extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('commonr/dcostingreport_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Department Wise Costing Report';
        $data['dlist']=$this->look_up_model->departmentList2();
        $data['hdlist']=$this->look_up_model->hdepartmentList();
	    $data['display']='commonr/dcostingreport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Department Wise Costing Report ';
        $data['dlist']=$this->look_up_model->departmentList2();
        $data['hdlist']=$this->look_up_model->hdepartmentList();
        $this->form_validation->set_rules('from_date','Date','trim');
        $this->form_validation->set_rules('to_date','date','trim');
        if ($this->form_validation->run() == TRUE) {
        $data['collapse']='YES';
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        //$data['scost11'] =$this->dcostingreport_model->SparesCostResult(1,1,$data['from_date'],$data['to_date']);

        foreach ($data['dlist'] as $value) {
        	$tdid=$value->department_id;
        	foreach ($data['hdlist'] as $value1) {
        	$did=$value1->department_id;
        	$dd="scost$tdid$did";
            $data[$dd] =$this->dcostingreport_model->SparesCostResult($tdid,$did,$data['from_date'],$data['to_date']);

        }
        }
        foreach ($data['hdlist'] as $value1) {
            $did=$value1->department_id;
            $data["fullfactorycost$did"] =$this->dcostingreport_model->fullfactorySpares($did,$data['from_date'],$data['to_date']);
        }
        //print_r($data); exit();
        $data['display']='commonr/dcostingreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='commonr/dcostingreport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($department_id=FALSE,$from_date=FALSE,$to_date=FALSE) {
    	 // $data["fcost$tdid$did"] =$this->dcostingreport_model->FixedCostResult($tdid,$did,$data['from_date'],$data['to_date']);
            //$data["sercost$tdid$did"] =$this->dcostingreport_model->ServicingCostResult($tdid,$did,$data['from_date'],$data['to_date']);
           // print_r($data); exit();
            //print_r($data["scost$tdid$did"]); exit();
        $data['heading']='Department Wise Costing Report';
        $data['category_id']=$category_id;
        $data['product_code']=$product_code;
        $data['resultdetail']=$this->dcostingreport_model->reportrResult($department_id,$from_date,$to_date);
        $this->load->view('commonr/dcostingreportExcel',$data);
    }
    
   function downloadPdf($category_id=FALSE,$rack_id=FALSE,$box_id=FALSE,$product_code=FALSE) {
    if ($this->session->userdata('user_id')) {
    $data['heading']='Items Issue Report ';
    $data['category_id']=$category_id;
    $data['product_code']=$product_code;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->dcostingreport_model->reportrResult($category_id,$rack_id,$box_id,$product_code);
    $pdfFilePath='sparesIssuePdf'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('commonr/itemissuePdf', $data, true);
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