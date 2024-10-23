<?php
class Checked_model extends CI_Model {
  public function get_count(){
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($department_id==15){
      $condition=$condition."  AND (pm.to_department_id=15 OR pm.to_department_id=8) ";
    }else{
      $condition=$condition."  AND pm.to_department_id='$department_id' ";
    }
    
    if($_GET){
      if($this->input->get('applications_no')!=''){
        $applications_no=$this->input->get('applications_no');
        $condition=$condition."  AND pm.applications_no='$applications_no' ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=alterDateFormat($this->input->get('from_date'));
        $to_date=alterDateFormat($this->input->get('to_date'));
        $condition.=" AND pm.applications_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    
    $query=$this->db->query("SELECT pm.*,d.department_name,
    	u.user_name, p.supplier_name
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.department_id=d.department_id)
      LEFT JOIN supplier_info p ON(pm.supplier_id=p.supplier_id) 
      LEFT JOIN user u ON(u.id=pm.prepared_by) 
      WHERE  pm.status>=2 $condition");
       
     $data = count($query->result());
     return $data;
    }
  function lists($limit,$start) {
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($department_id==15){
      $condition=$condition."  AND (pm.to_department_id=15 OR pm.to_department_id=8) ";
    }else{
      $condition=$condition."  AND pm.to_department_id='$department_id' ";
    }
    if($_GET){
      if($this->input->get('applications_no')!=''){
        $applications_no=$this->input->get('applications_no');
        $condition=$condition."  AND pm.applications_no='$applications_no' ";
      }
    if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=alterDateFormat($this->input->get('from_date'));
        $to_date=alterDateFormat($this->input->get('to_date'));
        $condition.=" AND pm.applications_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    $result=$this->db->query("SELECT pm.*,
      d.department_name,d.dept_head_email,
      u.user_name,u.email_address,
      u.mobile,p.supplier_name,
      u2.user_name as checked_by,u3.user_name as approved_by_name,
      u3.email_address as approved_email_address,
      d2.department_name as acc_department_name,
      d2.dept_head_email as acc_dept_head_email,
      u4.user_name as received_by
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.to_department_id=d.department_id)
      LEFT JOIN department_info d2 ON(pm.department_id=d2.department_id)
      INNER JOIN supplier_info p ON(pm.supplier_id=p.supplier_id)
      LEFT JOIN user u ON(u.id=pm.prepared_by) 
      LEFT JOIN user u2 ON(u2.id=pm.checked_by)
      LEFT JOIN user u3 ON(u3.id=pm.approved_by)
      LEFT JOIN user u4 ON(u4.id=pm.received_by) 
      WHERE  pm.status>=2 
      $condition
      ORDER BY pm.status  ASC,pm.payment_id  DESC 
      LIMIT $start,$limit")->result();
 
    return $result;
  }
  function reportrResult() {
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($department_id==15){
      $condition=$condition."  AND (pm.to_department_id=15 OR pm.to_department_id=8) ";
    }else{
      $condition=$condition."  AND pm.to_department_id='$department_id' ";
    }
 
    $result=$this->db->query("SELECT pm.*,
      d.department_name,d.dept_head_email,
      u.user_name,u.email_address,
      u.mobile,p.supplier_name,
      u2.user_name as checked_by,u3.user_name as approved_by_name,
      u3.email_address as approved_email_address,
      d2.department_name as acc_department_name,
      d2.dept_head_email as acc_dept_head_email,
      u4.user_name as received_by
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.to_department_id=d.department_id)
      LEFT JOIN department_info d2 ON(pm.department_id=d2.department_id)
      INNER JOIN supplier_info p ON(pm.supplier_id=p.supplier_id)
      LEFT JOIN user u ON(u.id=pm.prepared_by) 
      LEFT JOIN user u2 ON(u2.id=pm.checked_by)
      LEFT JOIN user u3 ON(u3.id=pm.approved_by)
      LEFT JOIN user u4 ON(u4.id=pm.received_by) 
      WHERE  pm.status>=2 
      $condition
      ORDER BY pm.status  ASC,pm.payment_id  DESC ")->result();
    return $result;
  }
   function approved($payment_id,$verification_need) {
        $data=array();
        if($verification_need=='YES')
        $data['status']=3;
        else $data['status']=4;
        $data['checked_by']=$this->session->userdata('user_id');
        $data['checked_date']=date('Y-m-d');
        $this->db->WHERE('payment_id',$payment_id);
        $query=$this->db->Update('payment_application_master',$data);
        return $query;
     }


  
}
