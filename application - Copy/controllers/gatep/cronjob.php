<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {
  function __construct() {
	  parent::__construct();
    $this->load->model('gatep/report_model');
  }

 	
function pendingemail(){
    $this->load->model('communication');
    $dlist=$this->db->query("SELECT * FROM department_info  
    WHERE 1 ORDER BY department_id ASC")->result();
   foreach ($dlist as $value){
    $data['resultdetail']=$this->report_model->returnableResult($value->department_id);
    //print_r($data['resultdetail']); exit();
    if(count($data['resultdetail'])>0){
    $data['department_id']=$value->department_id;
    $data['from_date']='';
    $data['to_date']='';
    $data['pendingstatus']='Pending';
    $filename="$value->department_name";
    // $this->load->view('gatep/returnablepdf', $data); 
    // exit();
    $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$filename.".pdf";
    $filename="$filename.pdf";
    $this->load->library('mpdf');

    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $mpdf->useAdobeCJK = true;
    $mpdf->SetAutoFont(AUTOFONT_ALL);
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = true;

    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('gatep/returnablepdf', $data, true);
    $mpdf->setHtmlHeader($header);
    $mpdf->pagenumPrefix = '  Page ';
    $mpdf->pagenumSuffix = ' - ';
    $mpdf->nbpgPrefix = ' out of ';
    $mpdf->nbpgSuffix = '';
    $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath,'F');
    ///////////////////////
    $subject="Returnable Material List Notification";
    $message=$this->load->view('gatep/returnable_email_body',$data,true);
    $attach='Pdf/'.$filename;
    $this->communication->send($value->dept_head_email,$subject,$message,$attach);
    ///////////////////
    }
    
    }
   echo "success";

  }

	
}