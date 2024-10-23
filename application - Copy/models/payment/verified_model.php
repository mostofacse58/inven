<?php
class Verified_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('applications_no')!=''){
        $applications_no=$this->input->get('applications_no');
        $condition=$condition."  AND pm.applications_no='$applications_no' ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('department_id')!='All'){
        $department_id=$this->input->get('department_id');
        $condition=$condition."  AND pm.to_department_id='$department_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=alterDateFormat($this->input->get('from_date'));
        $to_date=alterDateFormat($this->input->get('to_date'));
        $condition.=" AND pm.applications_date BETWEEN '$from_date' AND '$to_date'";
      }
     if($this->input->get('status')!='All'){
          $status=$this->input->get('status');
          $condition=$condition."  AND pm.status='$status' ";
        }
     }else{
         $condition=$condition."  AND pm.status=3 ";
     }
    $department_id=$this->session->userdata('department_id');
    $query=$this->db->query("SELECT pm.*,d.department_name,
    	u.user_name, p.supplier_name
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.department_id=d.department_id)
      LEFT JOIN supplier_info p ON(pm.supplier_id=p.supplier_id) 
      LEFT JOIN user u ON(u.id=pm.prepared_by) 
      WHERE pm.status>=3 AND pm.verification_need='YES' $condition");
       
     $data = count($query->result());
     return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('applications_no')!=''){
        $applications_no=$this->input->get('applications_no');
        $condition=$condition."  AND pm.applications_no='$applications_no' ";
      }
    
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id='$supplier_id' ";
      }
      if($this->input->get('department_id')!='All'){
        $department_id=$this->input->get('department_id');
        $condition=$condition."  AND pm.to_department_id='$department_id' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=alterDateFormat($this->input->get('from_date'));
        $to_date=alterDateFormat($this->input->get('to_date'));
        $condition.=" AND pm.applications_date BETWEEN '$from_date' AND '$to_date'";
      }
     if($this->input->get('status')!='All'){
          $status=$this->input->get('status');
          $condition=$condition."  AND pm.status='$status' ";
        }
     }else{
         $condition=$condition."  AND pm.status=3 ";
     }
  $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT pm.*,
      d.department_name,d.dept_head_email,u.user_name,u.email_address,
      u.mobile,p.supplier_name,
      u2.user_name as checked_by,u3.user_name as approved_by_name,
      u3.email_address as approved_email_address,
      d2.department_name as acc_department_name,
      d2.dept_head_email as acc_dept_head_email,
      u4.user_name as verified_by
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.to_department_id=d.department_id)
      LEFT JOIN department_info d2 ON(pm.department_id=d2.department_id)
      INNER JOIN supplier_info p ON(pm.supplier_id=p.supplier_id)
      LEFT JOIN user u ON(u.id=pm.prepared_by) 
      LEFT JOIN user u2 ON(u2.id=pm.checked_by)
      LEFT JOIN user u3 ON(u3.id=pm.approved_by)
      LEFT JOIN user u4 ON(u4.id=pm.verified_by)
      WHERE pm.status>=3  AND pm.verification_need='YES'
      $condition
      ORDER BY pm.status  ASC,pm.payment_id  DESC
      LIMIT $start,$limit")->result();
    return $result;
  }

  function approved($payment_id) {
    $info=$this->db->query("SELECT pm.* FROM payment_application_master pm
      WHERE pm.payment_id=$payment_id")->row();
    $data=array();
    $data['status']=4;
    $data['verified_by']=$this->session->userdata('user_id');
    $data['verified_date']=date('Y-m-d');
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->update('payment_application_master',$data);
    return $query;
  }
  function pass($payment_id) {
    $data=array();
    $data['status']=4;
    $this->db->WHERE('payment_id',$payment_id);
    $query=$this->db->update('payment_application_master',$data);
    return $query;
  }
  function save($payment_id) {
      $data['supplier_id']=$this->input->post('supplier_id');
      $data['pa_type']=$this->input->post('pa_type');
      $data['approved_by']=$this->input->post('approved_by');
      $data['description']=$this->input->post('description');
      $data['vat_add_per']=$this->input->post('vat_add_per');
      $data['vat_add_amount']=$this->input->post('vat_add_amount');
      $data['ait_add_per']=$this->input->post('ait_add_per');
      $data['ait_add_amount']=$this->input->post('ait_add_amount');
      $data['sub_total']=$this->input->post('sub_total');
      $data['vat_less_per']=$this->input->post('vat_less_per');
      $data['vat_less_amount']=$this->input->post('vat_less_amount');
      $data['ait_less_per']=$this->input->post('ait_less_per');
      $data['ait_less_amount']=$this->input->post('ait_less_amount');
      $data['other_note']=$this->input->post('other_note');
      $data['other_plus_minus']=$this->input->post('other_plus_minus');
      $data['other_amount']=$this->input->post('other_amount');
      $data['total_amount']=$this->input->post('total_amount');
      $data['dtotal_amount']=$this->input->post('dtotal_amount');
      $data['pay_term']=$this->input->post('pay_term');
      $data['currency_rate_in_hkd']=$this->input->post('currency_rate_in_hkd');
      $data['edit_by']=$this->session->userdata('user_id');
        $this->db->WHERE('payment_id',$payment_id);
        $query=$this->db->UPDATE('payment_application_master',$data);
        $this->db->WHERE('payment_id',$payment_id);
        $this->db->delete('payment_application_detail');
        $this->db->WHERE('payment_id',$payment_id);
        $this->db->delete('payment_dept_amount');
      $head_id=$this->input->post('head_id');
      $amount=$this->input->post('amount');
      $remarks=$this->input->post('remarks');
      $i=0;
      foreach ($head_id as $value) {
         $data1['head_id']=$value;
         $data1['payment_id']=$payment_id;
         $data1['amount']=$amount[$i];
         $data1['remarks']=$remarks[$i];
         $data1['pa_type']=$this->input->post('pa_type');
         $query=$this->db->insert('payment_application_detail',$data1);
         $i++;
       }
      $dcode=$this->input->post('dcode');
      $damount=$this->input->post('damount');
      $percentage=$this->input->post('percentage');
      $i=0;
      foreach ($dcode as $value) {
        if($damount[$i]!=0){
         $data2['dcode']=$value;
         $data2['payment_id']=$payment_id;
         $data2['damount']=$damount[$i];
         $data2['percentage']=$percentage[$i];
         $data2['pa_type']=$this->input->post('pa_type');
         $query=$this->db->insert('payment_dept_amount',$data2);
        }
         $i++;
       }
    return $query;
  }


  
}
