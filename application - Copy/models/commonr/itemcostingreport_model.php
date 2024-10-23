<?php
class Itemcostingreport_model extends CI_Model {
	
	 function reportrResult($category_id,$mlocation_id,$location_id,$from_date,$to_date,$product_code){
    $department_id=$this->session->userdata('department_id');
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
    if($product_code!=''){
      $condition.=" AND p.product_code='$product_code' ";
    }
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND sim.issue_date BETWEEN '$from_date' AND '$to_date'";
    }
    $result=$this->db->query("SELECT ml.mlocation_name,l.location_name,
          IFNULL(SUM(iid.sub_total),0) as amount
          FROM store_issue_master sim 
          INNER JOIN  item_issue_detail iid ON(iid.issue_id=sim.issue_id)
          INNER JOIN  product_info p ON(iid.product_id=p.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN location_info l ON(sim.location_id=l.location_id)
          LEFT JOIN main_location ml ON(l.mlocation_id=ml.mlocation_id)
          WHERE p.product_type=2 AND p.machine_other=2 
          AND sim.department_id=$department_id
          $condition
          GROUP BY l.location_id 
          ORDER BY l.location_name ASC")->result();
        return $result;
          
	}
 


}