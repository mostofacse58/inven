<?php
class Report_model extends CI_Model {
  function __construct(){
    parent::__construct();
    //$msdb = $this->load->database('msdb', TRUE);
 }
  

  public  function importExcel(){
    $condition=' ';
    if($_POST){
      if($this->input->post('start_date')!=''&& $this->input->post('end_date')!=''){
        $ex_fty_date=$this->input->post('ex_fty_date');
        $condition=$condition."  AND g.ex_fty_date BETWEEN '$start_date' AND '$end_date' ";
      }

     //  if($this->input->post('port_of_loading')!='All'){
     //    $port_of_loading=$this->input->post('port_of_loading');
     //    $condition=$condition."  AND g.port_of_loading LIKE '%$port_of_loading%' ";
     //  }
     //  if($this->input->post('port_of_discharge')!='All'){
     //    $port_of_discharge=$this->input->post('port_of_discharge');
     //    $condition=$condition."  AND g.port_of_discharge='$port_of_discharge' ";
     //  }
     //  if($this->input->post('customer_name')!='All'){
     //    $customer_name=$this->input->post('customer_name');
     //    $condition=$condition."  AND g.customer_name LIKE '%$customer_name%' ";
     //  }

     //  if($this->input->post('supplier_name')!='All'){
     //    $supplier_name=$this->input->post('supplier_name');
     //    $condition=$condition."  AND g.supplier_name='$supplier_name' ";
     //  }

     //  if($this->input->post('file_no')!=''){
     //    $file_no=$this->input->post('file_no');
     //    $file_no=implode(",",$file_no); 
     //    $condition=$condition."  AND g.file_no LIKE '%$file_no%' ";
     //  }
     // if($this->input->post('import_number')!=''){
     //    $import_number=$this->input->post('import_number');
     //    $condition=$condition."  AND (g.import_number LIKE '%$import_number%' OR AND g.invoice_no LIKE '%$import_number%') ";
     //  }
     }

    
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT *
      FROM  shipping_import_master g 
      WHERE g.department_id=$department_id 
      $condition
      ORDER BY g.import_id DESC ")->result();
    return $result;
  }
  

 
  
}
