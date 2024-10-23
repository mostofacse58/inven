<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downtimechart extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('report/downtimechart_model');
     }
    
    function SearchForm(){
        if($this->session->userdata('user_id')) {
        $data['heading']='Down Time Report  With Graph';
        $data['display']='report/downtimechartreport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
 
    }
    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Down Time Report With Graph';
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data['from_date']=alterDateFormat($this->input->post('from_date'));
            $data['to_date']=alterDateFormat($this->input->post('to_date'));
            $data['modelwisereport']=$this->downtimechart_model->modelwisereport($data['from_date'],$data['to_date']);
            $data['floorwisereport']=$this->downtimechart_model->floorwisereport($data['from_date'],$data['to_date']);
            $data['treewisereport']=$this->downtimechart_model->treewisereport($data['from_date'],$data['to_date']);
            $data['display']='report/downtimechartreport';
            $this->load->view('admin/master',$data);
        }else{
        $data['display']='report/downtimechartreport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    public function downloadexcel($from_date,$to_date){
        $data['heading']='Down Time Report With Graph';
        $data['from_date']=$from_date;
        $data['to_date']=$to_date;
        $data['modelwisereport']=$this->downtimechart_model->modelwisereport($from_date,$to_date);
        $data['floorwisereport']=$this->downtimechart_model->floorwisereport($from_date,$to_date);
        $data['treewisereport']=$this->downtimechart_model->treewisereport($from_date,$to_date);
        //$this->load->view('excel/downtimechartreport',$data);
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        //$html = $this->load->view('header', $data, true);
        $html=$this->load->view('excel/downtimechartreport', $data, true);
        //$mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath);

    }
   
}