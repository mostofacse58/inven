<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Allfareport extends My_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('it/allfareport_model');
     }
    function searchForm(){
        $department_id=$this->session->userdata('department_id');
        if ($this->session->userdata('user_id')) {
        $data['heading']='Fixed Asset Report';
        $data['llist']=$this->look_up_model->getlocation();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='itreport/allfareport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

    function reportResult(){
       if($this->session->userdata('user_id')) {
        $data['heading']='Fixed Asset Report ';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['llist']=$this->look_up_model->getlocation();
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('product_id','Product Model','trim|required');
        $this->form_validation->set_rules('department_id','Department','trim|required');
        $this->form_validation->set_rules('take_department_id','Department','trim|required');
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
        $data['issue_status']=$this->input->post('issue_status');
        $data['department_id']=$this->input->post('department_id');
        $data['take_department_id']=$this->input->post('take_department_id');
        $data['resultdetail']=$this->allfareport_model->reportResult($data['department_id'],$category_id,$product_id,$data['location_id'],$data['issue_status'],$data['take_department_id'],$data['mlocation_id'],$data['asset_encoding']);
        $data['display']='itreport/allfareport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='itreport/allfareport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function downloadExcel($department_id,$category_id=FALSE,$product_id=FALSE,$location_id=FALSE,$issue_status=FALSE,$take_department_id=FALSE,$mlocation_id=FALSE,$asset_encoding=FALSE) {
        $data['heading']='Fixed Asset Report ';
        $data['category_id']=$category_id;
        $data['product_id']=$product_id;
        $data['resultdetail']=$this->allfareport_model->reportResult($department_id,$category_id,$product_id,$location_id,$issue_status,$take_department_id,$mlocation_id,$asset_encoding);
        $this->load->view('itreport/allfareportExcel',$data);
    }
    function downloadPdf($department_id,$category_id=FALSE,$product_id=FALSE,$location_id=FALSE,$issue_status=FALSE,$take_department_id=FALSE,$mlocation_id=FALSE,$asset_encoding=FALSE) {
        $data['heading']='Fixed Asset Report ';
        $data['category_id']=$category_id;
        $data['product_id']=$product_id;
        $data['resultdetail']=$this->allfareport_model->reportResult($department_id,$category_id,$product_id,$location_id,$issue_status,$department_id,$mlocation_id,$asset_encoding);
        $pdfFilePath='AssetreportPdf'.date('Y-m-d H:i').'.pdf';
        $this->load->library('mpdf');
         $mpdf=new mPDF('utf-8');
        $mpdf = new mPDF('bn','L','','','15','15','28','15');
        //$mpdf->SetAutoFont();
        $mpdf->useAdobeCJK = true;
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('itreport/allfareportpdf', $data, true);
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
  function getcategory(){
      $department_id=$this->input->post('department_id');
       $result=$this->db->query("SELECT *
        FROM category_info 
        WHERE department_id=$department_id")->result();
      echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->category_id.'" >'.$value->category_name.'</option>';
      }
   exit;
  }
  function getAssetlist(){
      $department_id=$this->input->post('department_id');
       $result=$this->db->query("SELECT *
        FROM product_info 
        WHERE department_id=$department_id 
        AND product_type=1 AND machine_other=2")->result();
      echo '<option value="All">All</option>';
      foreach($result as $value) {
        echo '<option value="'.$value->product_id.'" >'.$value->product_name.'</option>';
      }
   exit;
  }
}