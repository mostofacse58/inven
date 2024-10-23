<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Machineryreport extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('report/machineryreport_model');
        $this->load->model('me/machinestatus_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Machinery Report';
        $data['flist']=$this->look_up_model->getFloor();
		$data['clist']=$this->look_up_model->getCategory(12);
        $data['plist']=$this->look_up_model->getMainProductMachine(12);
	    $data['display']='report/machineryreport';
        $this->load->view('admin/master',$data);
        }else{
           redirect("logincontroller");
        }
    }

    function reportResult(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Machinery Report ';
        $data['clist']=$this->look_up_model->getCategory(12);
        $data['plist']=$this->look_up_model->getMainProductMachine(12);
        $data['flist']=$this->look_up_model->getFloor();
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('product_id','Product Model','trim|required');
        if ($this->form_validation->run() == TRUE) {
        $category_id=$this->input->post('category_id');
        $product_id=$this->input->post('product_id');
        $data['floor_id']=$this->input->post('floor_id');
        $data['line_id']=$this->input->post('line_id');
        $data['tpm_serial_code']=$this->input->post('tpm_serial_code');
        $data['category_id']=$this->input->post('category_id');
        $data['product_id']=$this->input->post('product_id');
        $data['detail_status']=$this->input->post('detail_status');
        $data['tpm_status']=$this->input->post('tpm_status');
        $detail_status=$this->input->post('detail_status');
        $tpm_status=$this->input->post('tpm_status');
        $data['resultdetail']=$this->machineryreport_model->reportResult($category_id,$product_id,$data['floor_id'],$data['line_id'],$detail_status,$tpm_status,$data['tpm_serial_code']);
        // foreach($data['resultdetail'] as $value){
        //       $product_detail_id=$value->product_detail_id;
        //       $data3['tpm_status']=$value->machine_status;
        //       if($value->machine_status=='')
        //       $data3['tpm_status']=NULL;
        //       $data3['line_id']=$value->line_id;
        //       $data3['assign_date']=$value->assign_date;
        //       $data3['takeover_date']=$value->takeover_date;
        //       $this->db->WHERE('product_detail_id',$product_detail_id);
        //       $query=$this->db->update('product_detail_info',$data3);
        //     }
        // exit();
        $data['display']='report/machineryreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='report/machineryreport';
        $this->load->view('admin/master',$data);
        }
        }else{
          redirect("logincontroller");
        } 
    }
function downloadExcel($category_id=FALSE,$product_id=FALSE,$floor_id=FALSE,$line_id=FALSE,$detail_status,$tpm_status,$tpm_serial_code=FALSE) {
        $data['heading']='Machinery Report ';
        $data['category_id']=$category_id;
        $data['product_id']=$product_id;
        $data['resultdetail']=$this->machineryreport_model->reportResult($category_id,$product_id,$floor_id,$line_id,$detail_status,$tpm_status,$tpm_serial_code);
        $this->load->view('excel/machineryreportExcel',$data);
    }
    
}