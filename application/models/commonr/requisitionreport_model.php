<?php
class Requisitionreport_model extends CI_Model {
	 function reportrResult($requisition_status,$requisition_no,$product_code,$take_department_id,$from_date,$to_date){
    $department_id=$this->session->userdata('department_id');
    $condition='';
    if($requisition_no!=''&&$requisition_no!='All'){
      $condition.=" AND pm.requisition_no='$requisition_no'";
    }
    if($product_code!=''&&$product_code!='All'){
      $condition.=" AND pd.product_code='$product_code'";
    }
    if($take_department_id!=''&&$take_department_id!='All'){
      $condition.=" AND pm.department_id=$take_department_id ";
    }
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND pm.requisition_date BETWEEN '$from_date' AND '$to_date'";
    }
    $result=$this->db->query("SELECT pm.*,pd.*,
      0 as tpm_qty,

      0 as store_qty

      FROM requisition_item_details pd, requisition_master pm 
      WHERE  pd.requisition_id=pm.requisition_id  AND pm.pr_type=1
      AND pm.responsible_department=$department_id AND pm.requisition_status!=1
      $condition
      ORDER BY pm.requisition_date ASC ")->result();
    return $result;
	}
 
}