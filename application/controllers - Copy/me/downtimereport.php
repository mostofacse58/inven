<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downtimereport extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('report/downtimereport_model');
     }
    
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Down Time Report';
		$data['flist']=$this->downtimereport_model->getFloor();
	    $data['display']='report/downtimereport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
 
    }
    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Down Time Report ';
        $this->form_validation->set_rules('floor_id','Floor No','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim|required');
        $this->form_validation->set_rules('to_date','To Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data['from_date']=$this->input->post('from_date');
            $data['to_date']=$this->input->post('to_date');
            $data['resultdetail']=$this->downtimereport_model->reportrResult();
            $this->load->view('excel/downtimereport',$data);
        }else{
        $data['flist']=$this->downtimereport_model->getFloor();
        $data['display']='report/downtimereport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function getMachineTPM(){
          $floor_id=$this->input->post('floor_id');
           $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.tpm_serial_code,') (',fl.line_no,')') as product_name
            FROM product_status_info ps
            INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
            INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
            INNER JOIN floor_info f ON(fl.floor_id=f.floor_id)
            INNER JOIN product_info p ON(p.product_id=pd.product_id)
            WHERE pd.department_id=12 
            and f.floor_id=$floor_id")->result();
        echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->product_detail_id.'" >'.$value->product_name.'</option>';
      }
    exit;
   }
}