<?php
class Itemreceivereport_model extends CI_Model {
	
	 function reportrResult($category_id,$department_id,$product_code,$from_date,$to_date,$reference_no=FALSE){
    $department_id1=$this->session->userdata('department_id');
    $condition='';
    if($category_id!='All'){
    $condition.=" AND p.category_id=$category_id ";
    }
    if($department_id!='All'){
    $condition.=" AND pum.department_id=$department_id ";
    }
    if($product_code!=''){
      $condition.=" AND p.product_code='$product_code' ";
    }
    if($reference_no!=''){
      $condition.=" AND pum.reference_no='$reference_no' ";
    }
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND pum.purchase_date BETWEEN '$from_date' AND '$to_date'";
    }
    $result=$this->db->query("SELECT p.*,c.category_name,
          pd.*,pum.purchase_date,pum.reference_no,
          u.unit_name,d.department_name,s.supplier_name
          FROM purchase_detail pd
          INNER JOIN  purchase_master pum ON(pd.purchase_id=pum.purchase_id)
          INNER JOIN supplier_info s ON(pum.supplier_id=s.supplier_id)
          INNER JOIN  product_info p ON(pd.product_id=p.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN department_info d ON(pum.department_id=d.department_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          WHERE p.product_type=2  AND pd.status!=5
          $condition
          ORDER BY pum.purchase_date ASC, p.product_id DESC")->result();
        return $result;
          
	}
 


}