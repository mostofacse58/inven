<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fixedassetreport extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('it/fixedassetreport_model');
     }
    function searchForm(){
        $department_id=$this->session->userdata('department_id');
        if ($this->session->userdata('user_id')) {
        $data['heading']='Fixed Asset Report';
        $data['llist']=$this->look_up_model->getlocation();
    	$data['clist']=$this->look_up_model->getCategory($department_id);
        $data['plist']=$this->look_up_model->getMainProduct($department_id);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='itreport/fixedassetreport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportResult(){
       $department_id=$this->session->userdata('department_id');
       if ($this->session->userdata('user_id')) {
        $data['heading']='Fixed Asset Report ';
        $data['clist']=$this->look_up_model->getCategory($department_id);
        $data['plist']=$this->look_up_model->getMainProduct($department_id);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['llist']=$this->look_up_model->getlocation();
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('product_id','Product Model','trim|required');
        $this->form_validation->set_rules('department_id','Department','trim|required');
        $this->form_validation->set_rules('ram_id','RAM','trim');
        $this->form_validation->set_rules('mlocation_id','main Location','trim|required');
        $this->form_validation->set_rules('location_id','location','trim|required');
        if ($this->form_validation->run() == TRUE) {
        $category_id=$this->input->post('category_id');
        $product_id=$this->input->post('product_id');
        $data['location_id']=$this->input->post('location_id');
        $data['asset_encoding']=$this->input->post('asset_encoding');
        $data['category_id']=$this->input->post('category_id');
        $data['product_id']=$this->input->post('product_id');
        $data['mlocation_id']=$this->input->post('mlocation_id');
        $data['ram_id']=$this->input->post('ram_id');
        $data['issue_status']=$this->input->post('issue_status');
        $data['department_id']=$this->input->post('department_id');
        $data['from_date']=alterDateFormat($this->input->post('from_date'));
        $data['to_date']=alterDateFormat($this->input->post('to_date'));
        $data['from_idate']=alterDateFormat($this->input->post('from_idate'));
        $data['to_idate']=alterDateFormat($this->input->post('to_idate'));
        $data['resultdetail']=$this->fixedassetreport_model->reportResult($category_id,$product_id,$data['location_id'],$data['issue_status'],$data['department_id'],$data['ram_id'],$data['mlocation_id'],$data['from_date'],$data['to_date'],$data['asset_encoding'],$data['from_idate'],$data['to_idate']);
        $data['display']='itreport/fixedassetreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='itreport/fixedassetreport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($category_id=FALSE,$product_id=FALSE,$location_id=FALSE,$issue_status=FALSE,$department_id=FALSE,$ram_id=FALSE,$mlocation_id=FALSE,$from_date=FALSE,$to_date=FALSE,$asset_encoding=FALSE) {
        $data['heading']='Fixed Asset Report ';
        $data['category_id']=$category_id;
        $data['product_id']=$product_id;
        $data['resultdetail']=$this->fixedassetreport_model->reportResult($category_id,$product_id,$location_id,$issue_status,$department_id,$ram_id,$mlocation_id,$from_date,$to_date,$asset_encoding);
        $this->load->view('itreport/fixedassetreportExcel',$data);
    }
    function downloadPdf($category_id=FALSE,$product_id=FALSE,$location_id=FALSE,$issue_status=FALSE,$department_id=FALSE,$ram_id=FALSE,$mlocation_id=FALSE,$from_date=FALSE,$to_date=FALSE,$asset_encoding=FALSE) {
        $data['heading']='Fixed Asset Report ';
        $data['category_id']=$category_id;
        $data['product_id']=$product_id;
        $data['resultdetail']=$this->fixedassetreport_model->reportResult($category_id,$product_id,$location_id,$issue_status,$department_id,$ram_id,$mlocation_id,$from_date,$to_date,$asset_encoding);
        //$this->load->view('itreport/fixedassetreportpdf', $data);
        //print_r($data['resultdetail']); exit();

        $pdfFilePath='AssetStockPdf'.date('Y-m-d H:i').'.pdf';
        $this->load->library('mpdf');
         $mpdf=new mPDF('utf-8');
        $mpdf = new mPDF('bn','L','','','15','15','28','15');
        //$mpdf->SetAutoFont();
        $mpdf->useAdobeCJK = true;
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('itreport/fixedassetreportpdf', $data, true);
        $mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
        $mpdf->AddPage('L');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
     function downloadPdf1($category_id=FALSE,$product_id=FALSE,$location_id=FALSE,$issue_status=FALSE,$department_id=FALSE,$ram_id=FALSE,$mlocation_id=FALSE,$asset_encoding=FALSE,$from_date=FALSE,$to_date=FALSE) {
        $data['heading']='Fixed Asset Report ';
        $data['category_id']=$category_id;
        $data['product_id']=$product_id;
        $data['resultdetail']=$this->fixedassetreport_model->reportResult($category_id,$product_id,$location_id,$issue_status,$department_id,$ram_id,$mlocation_id,$asset_encoding,$from_date,$to_date);
        $pdfFilePath='AssetStockPdf'.date('Y-m-d H:i').'.pdf';
        $this->load->library('mpdf');
         $mpdf=new mPDF('utf-8');
        $mpdf = new mPDF('bn','L','','','15','15','28','15');
        //$mpdf->SetAutoFont();
        $mpdf->useAdobeCJK = true;
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('itreport/fixedassetreportpdf1', $data, true);
        $mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
        $mpdf->AddPage('L');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    function printsticker($category_id=FALSE,$issue_status=FALSE,$department_id=FALSE,$from_date=FALSE,$to_date=FALSE,$asset_encoding=FALSE){
        $data['lists']=$this->fixedassetreport_model->printsticker($category_id,$issue_status,$department_id,$from_date,$to_date,$asset_encoding);
       $this->load->view('itreport/printsticker',$data);

    }
}