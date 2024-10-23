<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('report_model');
     }
    
    function customer_wise_report(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='customer wise report ';
		$data['clist']=$this->report_model->customer_list('Regular');
	    $data['display']='report/customer_wise_report';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
 
    }
	
    function customer_wise_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='customer wise report ';
		$data['clist']=$this->report_model->customer_list('Regular');
		$this->form_validation->set_rules('customer_id','Customer Name','trim|required');
		if ($this->form_validation->run() == TRUE) {
	     $data['info']=$this->report_model->customer_info();
	     $data['detail']=$this->report_model->customer_wise_report();
         $data['addcost']=$this->report_model->customer_add_cost();
    
         $pdfFilePath='customer_wise_report.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        $html.= $this->load->view('report/customer_wise_report2', $data, true);
        
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $mpdf->WriteHTML($html);
          $mpdf->Output($pdfFilePath,'D');
		 
		}else{
        $data['display']='report/customer_wise_report';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
    }
     function dcustomer_wise_report(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Default customer wise report ';
        $data['clist']=$this->report_model->customer_list('Default');
        $data['display']='report/dcustomer_wise_report';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function dcustomer_wise_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Default customer wise report ';
        $data['clist']=$this->report_model->customer_list('Default');
        $this->form_validation->set_rules('customer_id','Customer Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data['info']=$this->report_model->customer_info();
            $data['detail']=$this->report_model->dcustomer_wise_report();
            $pdfFilePath='dcustomer_wise_report.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','15','15','15','18');
            $html = $this->load->view('header', $data, true);
            $html.=$this->load->view('report/dcustomer_wise_report2', $data, true);
            
            //$mpdf->setHtmlHeader($header);
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath,'D');
         
        }else{
        $data['display']='report/dcustomer_wise_report';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
        
    }
    function employee_deposit_amount(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Employee Deposit Amount';
        $data['list']=$this->report_model->employee_deposit_amount();
        $data['display']='employee/deposit_amount';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
	 function corporate_sim_user(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='corporate sim user';
		$data['simlist']=$this->report_model->corporate_sim_user();
	    $data['display']='employee/cor_sim_user';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
     function corporate_sim_user2(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='corporate sim user';
        $data['simlist']=$this->report_model->corporate_sim_user();
        //$pdfFilePath='corporate_sim_user.pdf';
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('employee/cuserpdf', $data, true);
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath);
        } else {
           redirect("logincontroller");
        }
        
    }
	 function employee_loan_report(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='employee loan report ';
		$data['elist']=$this->report_model->employee_list();
	    $data['display']='report/employee_loan_report';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
	
    function employee_loan_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='employee loan report ';
		$data['elist']=$this->report_model->employee_list();
		$this->form_validation->set_rules('loan_id','Employee Name','trim|required');
		if ($this->form_validation->run() == TRUE) {
	     $data['info']=$this->report_model->loan_info();
	     $data['detail']=$this->report_model->employee_loan_report();
         $pdfFilePath='employee_loan_report.pdf';
         $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        //
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $html.=$this->load->view('report/employee_loan_report2', $data, true);
          $mpdf->WriteHTML($html);
          $mpdf->Output($pdfFilePath,'D');
		}else{
        $data['display']='report/employee_loan_report';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
        
    }
	function cheque_book_register(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Cheque Book Register';
		$data['list']=$this->report_model->book_list();
        $data['banklist']=$this->look_up_model->getbank();
	    $data['display']='report/cheque_book_register';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
	
    function cheque_book_register_search(){
        if ($this->session->userdata('user_id')) {
        $data['heading']=' Cheque Book Register';
		$data['list']=$this->report_model->book_list();
        $data['banklist']=$this->look_up_model->getbank();
		$this->form_validation->set_rules('book_no','Book No','trim|required');
        $this->form_validation->set_rules('bank_id','Bank Name','trim|required');
		if ($this->form_validation->run() == TRUE) {
	   $data['detail1']=$this->report_model->cheque_book_register(1);
           $data['detail2']=$this->report_model->cheque_book_register(2);
           $data['detail3']=$this->report_model->cheque_book_register(3);
           $data['detail4']=$this->report_model->cheque_book_register(4);
         $pdfFilePath='cheque_book_register.pdf';
         $this->load->library('mpdf');
         $mpdf = new mPDF('bn','A4','','','15','15','15','18');
         $html = $this->load->view('header', $data, true);
         $html.=$this->load->view('report/cheque_book_register2', $data, true);
         //$mpdf->setHtmlHeader($header);
         $mpdf->pagenumPrefix = '  Page ';
         $mpdf->pagenumSuffix = ' - ';
         $mpdf->nbpgPrefix = ' out of ';
         $mpdf->nbpgSuffix = '';
         $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
         $mpdf->WriteHTML($html);
         $mpdf->Output($pdfFilePath,'D');

		}else{ 
        $data['display']='report/cheque_book_register';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
        
    }
    function contractor_payment_statement(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='contractor payment statement';
        $data['list']=$this->report_model->contractor_list();
        $data['list2']=$this->report_model->conproject_list();
        $data['display']='report/contractor_payment_statement';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function contractor_payment_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='contractor payment statement';
        $data['list']=$this->report_model->contractor_list();
        $this->form_validation->set_rules('contractor_id','Contractor Name','trim|required');
        $this->form_validation->set_rules('project_id','Project Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->contractor_info();
         $data['info2']=$this->report_model->project_info();
         $data['detail']=$this->report_model->contractor_payment_statement();
         $pdfFilePath='contractor_payment_statement.pdf';
         $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
         $html.=$this->load->view('report/contractor_payment_statement2', $data, true);
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
         $mpdf->WriteHTML($html);
         $mpdf->Output($pdfFilePath,'D');
        }else{
        $data['display']='report/contractor_payment_statement';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
    function product_purchase_sheet(){
        if ($this->session->userdata('user_id')) {
        $data['heading']=' Product Purchase Sheet';
        $data['list']=$this->report_model->project_list();
        $data['list2']=$this->report_model->product_list();
        $data['display']='report/product_purchase_sheet';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function product_purchase_sheet_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Product Purchase Sheet';
        $data['list']=$this->report_model->project_list();
        $data['list2']=$this->report_model->product_list();
        $this->form_validation->set_rules('project_id','Project Name','trim|required');
        $this->form_validation->set_rules('sproduct_id','Product Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->project_info();
         $data['info2']=$this->report_model->product_info();
         $data['detail']=$this->report_model->product_purchase_sheet();
         $pdfFilePath='product_purchase_sheet.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
         $html.=$this->load->view('report/product_purchase_sheet2', $data, true);
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
         $mpdf->WriteHTML($html);
         $mpdf->Output($pdfFilePath,'D');
        }else{ 
        $data['display']='report/product_purchase_sheet';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
        
    }
     function share_money_sheet(){
        if ($this->session->userdata('user_id')) {
        $data['heading']=' Share Money Sheet';
        $data['list']=$this->report_model->director_list();
        $data['display']='report/share_money_sheet';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function share_money_sheet_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']=' Share Money Sheet';
        $data['list']=$this->report_model->director_list();
        $this->form_validation->set_rules('share_id','Employee Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->share_info();
         $data['detail']=$this->report_model->share_money_sheet();
         // $this->load->view('report/share_money_sheet2', $data);
         $pdfFilePath='share_money_sheet.pdf';
         $this->load->library('mpdf');
          $mpdf = new mPDF('bn','A4','','','15','15','15','18');
       // $mpdf->AddPage('L');
          $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('report/share_money_sheet2', $data, true);
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'D');

        }else{
        $data['display']='report/share_money_sheet';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
    function supplier_payment_statement(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='supplier payment statement';
        $data['list']=$this->report_model->supplier_list();
        $data['display']='report/supplier_payment_statement';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function supplier_payment_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='supplier payment statement';
        $data['list']=$this->report_model->supplier_list();
        $this->form_validation->set_rules('supplier_id','Supplier Name','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->supplier_info();
         $data['detail']=$this->report_model->supplier_payment_statement();
         //print_r($data['detail']);
        /// exit();

        $pdfFilePath='supplier_payment_statement.pdf';
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('report/supplier_payment_statement2', $data, true);
        
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
         $mpdf->WriteHTML($html);
         $mpdf->Output($pdfFilePath,'D');
        }else{
        $data['display']='report/supplier_payment_statement';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
    function project_wise_customer(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise customer';
        $data['list']=$this->report_model->project_list();
        $data['display']='report/project_wise_customer';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function project_wise_customerr(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise customer';
        $data['list']=$this->report_model->project_list();
        $this->form_validation->set_rules('project_id','Project Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->project_info();
         $data['detail']=$this->report_model->project_wise_customer();
   
         $pdfFilePath='project_wise_customer.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        //$mpdf->AddPage('L');
           $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('report/project_wise_customer2', $data, true);
        
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $mpdf->WriteHTML($html);
          $mpdf->Output($pdfFilePath,'D');
         
        }else{
        $data['display']='report/project_wise_customer';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
        
    }
    function project_wise_dcustomer(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise D.customer';
        $data['list']=$this->report_model->project_list();
        $data['display']='report/project_wise_dcustomer';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function project_wise_dcustomer_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise D.customer';
        $data['list']=$this->report_model->project_list();
        $this->form_validation->set_rules('project_id','Project Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->project_info();
         $data['detail']=$this->report_model->project_wise_dcustomer();
   
         $pdfFilePath='project_wise_dcustomer.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('report/project_wise_dcustomer2', $data, true);
        
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $mpdf->WriteHTML($html);
          $mpdf->Output($pdfFilePath,'D');
         
        }else{
        $data['display']='report/project_wise_dcustomer';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
        
    }
     function project_wise_supplier(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise supplier';
        $data['list']=$this->report_model->project_list();
        $data['display']='report/project_wise_supplier';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function project_wise_supplier_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise supplier';
        $data['list']=$this->report_model->project_list();
        $this->form_validation->set_rules('project_id','Project Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->project_info();
         $data['detail']=$this->report_model->project_wise_supplier();
   
         $pdfFilePath='project_wise_supplier.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('report/project_wise_supplier2', $data, true);
        
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $mpdf->WriteHTML($html);
          $mpdf->Output($pdfFilePath,'D');
         
        }else{
        $data['display']='report/project_wise_supplier';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
        
    }
    function project_wise_contractor(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise contractor';
        $data['list']=$this->report_model->project_list();
        $data['display']='report/project_wise_contractor';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function project_wise_contractor_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise contractor';
        $data['list']=$this->report_model->project_list();
        $this->form_validation->set_rules('project_id','Project Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->project_info();
         $data['detail']=$this->report_model->project_wise_contractor();
   
         $pdfFilePath='project_wise_contractor.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('report/project_wise_contractor2', $data, true);
        
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $mpdf->WriteHTML($html);
          $mpdf->Output($pdfFilePath,'D');
         
        }else{
        $data['display']='report/project_wise_contractor';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
        
    }
    function project_wise_broker(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise broker';
        $data['list']=$this->report_model->project_list();
        $data['display']='report/project_wise_broker';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function project_wise_broker_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise broker';
        $data['list']=$this->report_model->project_list();
        $this->form_validation->set_rules('project_id','Project Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->project_info();
         $data['detail']=$this->report_model->project_wise_broker();
   
         $pdfFilePath='project_wise_broker.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('report/project_wise_broker2', $data, true);
        
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $mpdf->WriteHTML($html);
          $mpdf->Output($pdfFilePath,'D');
         
        }else{
        $data['display']='report/project_wise_broker';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
        
    }
    function project_wise_landowner(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise Landowner';
        $data['list']=$this->report_model->project_list();
        $data['display']='report/project_wise_landowner';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function project_wise_landowner_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project wise Landowner';
        $data['list']=$this->report_model->project_list();
        $this->form_validation->set_rules('project_id','Project Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->project_info();
         $data['detail']=$this->report_model->project_wise_landowner();
   
         $pdfFilePath='project_wise_landowner.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html = $this->load->view('header', $data, true);
        $html.=$this->load->view('report/project_wise_landowner2', $data, true);
        
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $mpdf->WriteHTML($html);
          $mpdf->Output($pdfFilePath,'D');
         
        }else{
        $data['display']='report/project_wise_landowner';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        }
        
    }
    function broker_payment_statement(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='broker payment statement';
        $data['list']=$this->report_model->broker_list();
        $data['display']='report/broker_payment_statement';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function broker_payment_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='broker payment statement';
        $data['list']=$this->report_model->broker_list();
        $this->form_validation->set_rules('broker_id','Broker Name','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
         $data['info']=$this->report_model->broker_info();
         $data['detail']=$this->report_model->broker_payment_statement();
         $pdfFilePath='broker_payment_statement.pdf';
         $this->load->library('mpdf');
           $mpdf = new mPDF('bn','A4','','','15','15','15','18');
         $html = $this->load->view('header', $data, true);
         $html.=$this->load->view('report/broker_payment_statement2', $data, true);
         
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
         $mpdf->WriteHTML($html);
         $mpdf->Output($pdfFilePath,'D');
        }else{
        $data['display']='report/broker_payment_statement';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
    function landowner_payment_statement(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='landowner payment statement';
        $data['list']=$this->report_model->landowner_list();
        $data['display']='report/landowner_payment_statement';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    
    function landowner_payment_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='landowner payment statement';
        $data['list']=$this->report_model->landowner_list();
        $this->form_validation->set_rules('landowner_id','Landowner Name','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data['info']=$this->report_model->landowner_info();
            $data['detail']=$this->report_model->landowner_payment_statement();
            $pdfFilePath='landowner_payment_statement.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','15','15','15','18');
            $html = $this->load->view('header', $data, true);
            $html.=$this->load->view('report/landowner_payment_statement2', $data, true);
            
            //$mpdf->setHtmlHeader($header);
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath,'D');
        }else{
        $data['display']='report/landowner_payment_statement';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
     function employee_salary_sheet(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='employee salary sheet';
        $data['display']='employee/employee_salary_sheet';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
   function employee_salary_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='employee salary sheet';

        $this->form_validation->set_rules('month','Month','trim|required');
        if ($this->form_validation->run() == TRUE) {
             $data['month']=$this->input->post('month');
            $data['detail']=$this->report_model->employee_salary_sheet();
            $pdfFilePath='employee_salary_sheet.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','15','15','15','18');
            $html = $this->load->view('header', $data, true);
            $html.=$this->load->view('employee/employee_salary_sheet2', $data, true);
            
            //$mpdf->setHtmlHeader($header);
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath,'D');
        }else{
        $data['display']='employee/employee_salary_sheet';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
      function director_honourium_sheet(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='director honourium sheet';
        $data['display']='director/director_honourium_sheet';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
        
    }
    function director_honourium_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='director honourium sheet';

        $this->form_validation->set_rules('month','Month','trim|required');
        if ($this->form_validation->run() == TRUE) {
             $data['month']=$this->input->post('month');
            $data['detail']=$this->report_model->director_honourium_sheet();
            $pdfFilePath='director_honourium_sheet.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','15','15','15','18');
            $html = $this->load->view('header', $data, true);
            $html.=$this->load->view('director/director_honourium_sheet2', $data, true);
            
            //$mpdf->setHtmlHeader($header);
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath,'D');
        }else{
        $data['display']='director/director_honourium_sheet';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
  
    function expense_report(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Expense Report';
        $data['list']=$this->report_model->getcategory();
        $data['display']='report/expense_report';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
       function expense_report_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Expense Report';
        $data['list']=$this->report_model->getcategory();
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        $this->form_validation->set_rules('cat_id','Category','trim|required');
        if ($this->form_validation->run() == TRUE) {
            $cat=$this->input->post('cat_id');
            if($cat!='Project'&&$cat!='Office'){
            $data['cat_name']=$this->db->query("SELECT cat_name FROM expense_category WHERE cat_id=$cat")->row('cat_name');
            }
            $data['month']=$this->input->post('month');
            $data['cat_id']=$this->input->post('cat_id');
            $data['detail']=$this->report_model->expense_report();
            $pdfFilePath='expense_report.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','15','15','15','18');
            $html = $this->load->view('header', $data, true);
            $html.=$this->load->view('report/expense_report2', $data, true);
            
            //$mpdf->setHtmlHeader($header);
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath,'D');
        }else{
        $data['display']='report/expense_report';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
    function project_report(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project Report';
        $data['list']=$this->report_model->project_list();
        $data['display']='report/project_report';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function project_result(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='project Report';
        $data['list']=$this->report_model->project_list();
        $this->form_validation->set_rules('project_id','Project name','trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data['info']=$this->report_model->project_info();
            $data['selllist']=$this->report_model->project_selllist();
            $data['customerlist']=$this->report_model->project_customerlist();
            $data['dcustomerlist']=$this->report_model->project_dcustomerlist();
            $data['supplierlist']=$this->report_model->project_supplierlist();
            $data['contractorlist']=$this->report_model->project_contractorlist();
            $data['landownerlist']=$this->report_model->project_landownerlist();
            $data['brokerlist']=$this->report_model->project_brokerlist();
            $data['buylist']=$this->report_model->project_buylist();
            $pdfFilePath='project_report.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','15','15','15','18');
            $html = $this->load->view('header', $data, true);
            $html.=$this->load->view('report/project_report2', $data, true);
            
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath,'D');
        }else{
        $data['display']='report/project_report';
        $this->load->view('admin/master',$data);
        }} else {
           redirect("logincontroller");
        }
    }
    



 }