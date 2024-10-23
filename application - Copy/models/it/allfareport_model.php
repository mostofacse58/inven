<?php
class Allfareport_model extends CI_Model {

function reportResult($department_id,$category_id,$product_id,$location_id,$issue_status,$take_department_id,$mlocation_id,$asset_encoding){
    $condition='';
    if($category_id!='All'){
      $condition.=" AND p.category_id=$category_id";
    }
    if($product_id!='All'){
      $condition.=" AND p.product_id=$product_id";
    }
    if($location_id!='All'){
      $condition.=" AND l.location_id=$location_id";
    }
    if($mlocation_id!='All'){
      $condition.=" AND ml.mlocation_id= $mlocation_id";
    }
    if($issue_status!='All'){
      $condition.=" AND pd.it_status='$issue_status'";
    }
    if($take_department_id!='All'){
      $condition.=" AND aim.take_department_id=$take_department_id";
    }
    if($department_id!='All'){
      $condition.=" AND pd.department_id=$department_id";
    }
    if($asset_encoding!=''){
    $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%') ";
    }
    /////////////////
    $result=$this->db->query("SELECT pd.*,p.product_name,
        p.product_code,p.china_name,r.ram_type,
        c.category_name,b.brand_name,l.location_name,
        s.supplier_name,aim.employee_id,
        aim.real_ip_address,aim.issue_type,
        pd.it_status,d.department_name,d.head_id,e.employee_name
        FROM  product_detail_info pd 
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
        LEFT JOIN supplier_info s ON(pd.supplier_id=s.supplier_id)
        LEFT JOIN asset_issue_master aim ON(pd.product_detail_id=aim.product_detail_id AND aim.take_over_status=1)
        LEFT JOIN location_info l ON(aim.location_id=l.location_id)
        LEFT JOIN main_location ml ON(l.mlocation_id=ml.mlocation_id)
        LEFT JOIN ram_info r ON(pd.ram_id=r.ram_id)
        LEFT JOIN department_info d ON(aim.take_department_id=d.department_id)
        LEFT JOIN employee_idcard_info e ON(aim.employee_id=e.employee_cardno)
        WHERE  pd.machine_other=2 $condition 
        GROUP BY pd.product_detail_id
        ORDER BY pd.ventura_code ASC")->result();
      return $result;
          
	}
  
}