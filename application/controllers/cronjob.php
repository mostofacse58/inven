<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {
  function __construct() {
	  parent::__construct();
    $this->load->model('commonr/itemstock_model');
  }

 function requisitiondata(){
		$rplists=$this->db->query("SELECT r.*,rd.* 
      FROM requisition_item_details rd,requisition_master r 
      WHERE r.requisition_id=rd.requisition_id 
      AND rd.issue_status=1")->result();
     // print_r($rplists); exit();

		foreach ($rplists as  $value){
        $iqty=$this->look_up_model->getIssueTotalQty($value->requisition_no,$value->product_id);
        if($iqty>0){
          $data=array();
          $data['issued_qty']=$iqty;
          if($iqty==$value->required_qty){
            $data['issue_status']=2;
          }

      $this->db->WHERE('requisition_detail_id',$value->requisition_detail_id);
      $this->db->UPDATE('requisition_item_details',$data);
        }
      
		
     }
     exit();
    }
//     UPDATE store_issue_master INNER JOIN employee_idcard_info
//     ON store_issue_master.employee_id =employee_idcard_info.employee_cardno
// SET store_issue_master.employee_name = employee_idcard_info.employee_name,
// store_issue_master.sex = employee_idcard_info.sex WHERE store_issue_master.employee_name!='';
	
function safetystockemail(){
  $dlist=$this->db->query("SELECT * FROM department_info 
    WHERE stock_holder=1 
    ORDER BY department_id ASC")->result();
  foreach ($dlist as $value){
    $data['resultdetail']=$this->itemstock_model->safetyitem($value->department_id);
    $filename="$value->department_name";
    $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/pdffile/".$filename.".pdf";
    $filename="$filename.pdf";
    $this->load->library('mpdf');

    $mpdf = new mPDF('bn','A4','','','15','15','30','18');
    $mpdf->useAdobeCJK = true;
    $mpdf->SetAutoFont(AUTOFONT_ALL);
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = true;
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('commonr/itemstockPdf', $data, true);
    $mpdf->setHtmlHeader($header);
    $mpdf->pagenumPrefix = '  Page ';
    $mpdf->pagenumSuffix = ' - ';
    $mpdf->nbpgPrefix = ' out of ';
    $mpdf->nbpgSuffix = '';
    $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output($pdfFilePath,'F');
    ///////////////////////
    $this->load->library('email');
    $config['protocol'] = 'mail';
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $this->email->initialize($config);
    $this->email->from("it@vlmbd.com","VLMBD");
    $this->email->to("$value->dept_head_email");
    //$this->email->bcc("golam.mostofa@bdventura.com");
    $this->email->subject("Safety Stock Notification");
    $messages=$this->load->view('for_safety_email_body',$data,true);
    $this->email->message($messages);
    $this->email->attach('pdffile/'.$filename);
    $this->email->send();
    ///////////////////
    $this->email->clear(TRUE);
    
    }


  }

	
}