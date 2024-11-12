<?php
class Itemissuereport_model extends CI_Model {
	
	 function reportrResult($category_id,$department_id,$take_department_id,$mlocation_id,$location_id,$product_code,$employee_no,$from_date,$to_date){
    $condition='';
    if($category_id!='All'){
    $condition.=" AND p.category_id=$category_id ";
    }
    if($mlocation_id!='All'){
    $condition.=" AND l.mlocation_id=$mlocation_id ";
    }
    if($location_id!='All'){
    $condition.=" AND sim.location_id=$location_id ";
    }
    if($take_department_id!='All'){
    $condition.=" AND sim.take_department_id=$take_department_id ";
    }
    if($product_code!=''&&$product_code!='All'){
      $condition.=" AND iid.product_code='$product_code' ";
    }
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND sim.issue_date BETWEEN '$from_date' AND '$to_date'";
    }
    if($employee_no!=''&&$employee_no!='All'){
      $condition.=" AND sim.employee_id='$employee_no' ";
    }
    $result=$this->db->query("SELECT sim.employee_name,
          iid.*,sim.issue_date,
          l.location_name,sim.employee_id,
          d.department_name,sim.issue_for,sim.product_detail_id,u.unit_name
          FROM item_issue_detail iid
          INNER JOIN store_issue_master sim ON(iid.issue_id=sim.issue_id)
          INNER JOIN  product_info p ON(iid.product_id=p.product_id)
          LEFT JOIN department_info d ON(sim.take_department_id=d.department_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN location_info l ON(sim.location_id=l.location_id)
          WHERE  sim.department_id=$department_id 
          $condition
          ORDER BY sim.issue_date ASC")->result();
        return $result;
          
	}
  function getAssetCode($product_detail_id='')
  { 
    if($product_detail_id=='') return '';
    $result=$this->db->query("SELECT pd.asset_encoding,pd.ventura_code
          FROM  product_detail_info pd 
          WHERE pd.product_detail_id=$product_detail_id")->row();
    return $result->ventura_code;
  }
 


}