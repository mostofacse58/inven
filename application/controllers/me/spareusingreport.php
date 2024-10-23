<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spareusingreport extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('report/spareusingreport_model');
     }
    
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Spares Using Report';
		$data['clist']=$this->look_up_model->getCategory(12);
        $data['flist']=$this->look_up_model->getFloor();
	    $data['display']='report/sparesusingreport';
        $this->load->view('admin/master',$data);
        } else {
        redirect("logincontroller");
        }
    }
    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Spares Using Report ';
        $this->form_validation->set_rules('floor_id','Location','trim|required');
        $this->form_validation->set_rules('category_id','category Name','trim|required');
        $this->form_validation->set_rules('product_detail_id','Machine Name','trim|required');
        $this->form_validation->set_rules('from_date','From Date','trim');
        $this->form_validation->set_rules('use_type','Type','trim');
        $this->form_validation->set_rules('to_date','To Date','trim');
        $this->form_validation->set_rules('product_code','Code','trim');
        if ($this->form_validation->run() == TRUE) {
            $data['product_detail_id']=$this->input->post('product_detail_id');
            $data['from_date']=$this->input->post('from_date');
            $data['to_date']=$this->input->post('to_date');
            $data['resultdetail']=$this->spareusingreport_model->reportrResult();
            $data['info']=$this->spareusingreport_model->getMachineInfo();
            $this->load->view('excel/sparesUsingreport',$data);
        }else{
        $data['flist']=$this->look_up_model->getFloor();
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['display']='report/sparesusingreport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("logincontroller");
        } 
    }
    function getMachineTPM(){
        $category_id=$this->input->post('category_id');
        $result=$this->db->query("SELECT pd.product_detail_id,
        CONCAT(p.product_name,' (',pd.tpm_serial_code,')') as product_name
        FROM product_detail_info pd
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        WHERE p.department_id=12 
        and p.category_id=$category_id")->result();
        echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->product_detail_id.'" >'.$value->product_name.'</option>';
      }
    exit;
   }
}