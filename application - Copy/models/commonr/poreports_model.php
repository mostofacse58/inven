<?php
class Poreports_model extends CI_Model {
	 function reportrResult($take_department_id,$po_status,$supplier_id,$po_number,$product_code,$from_date,$to_date){
    $department_id=$this->session->userdata('department_id');
    $condition='';
    if($po_number!=''&&$po_number!='All'){
      $condition.=" AND pm.po_number='$po_number'";
    }
    if($product_code!=''&&$product_code!='All'){
      $condition.=" AND pd.product_code='$product_code'";
    }
    if($take_department_id!=''&&$take_department_id!='All'){
      $condition.=" AND pm.department_id=$take_department_id ";
    }
    if($supplier_id!=''&&$supplier_id!='All'){
      $condition.=" AND pm.supplier_id=$supplier_id ";
    }
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND pm.po_date BETWEEN '$from_date' AND '$to_date'";
    }
    $result=$this->db->query("SELECT pm.*,pd.*
      FROM po_pline pd
      INNER JOIN po_master pm ON(pd.po_id=pm.po_id)
      WHERE 1
      $condition
      ORDER BY pm.po_date ASC ")->result();
    return $result;
	}
 
}