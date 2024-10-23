<?php
class Itemstock_model extends CI_Model {
	
	 function reportrResult($category_id,$rack_id,$box_id,$department_id,$product_code=FALSE){
    $condition='';
    if($category_id!='All'){
    $condition.=" AND p.category_id=$category_id ";
    }
    if($rack_id!='All'){
    $condition.=" AND r.rack_id=$rack_id ";
    }
    if($product_code!=''){
      $condition.=" AND (p.product_code LIKE '%$product_code%' OR p.product_name LIKE '%$product_code%' OR p.china_name LIKE '%$product_code%') ";
    }
    if($box_id!='All'){
    $condition.=" AND bo.box_id=$box_id ";
    }
    $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
      b.brand_name,
      CONCAT(r.rack_name,' (',bo.box_name,')') as rack_name,
      u.unit_name
      FROM  product_info p
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
      LEFT JOIN rack_info r ON(bo.rack_id=r.rack_id)
      LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
      LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
      LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
      WHERE p.department_id=$department_id 
      and p.product_type=2  AND p.product_status=1 AND p.machine_other=2
      $condition
      ORDER BY p.product_id DESC")->result();
    return $result;
	}
  function safetyitem($department_id){
    if($department_id==12){
      $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,CONCAT(r.rack_name,' (',bo.box_name,')') as rack_name,u.unit_name,
          (SELECT IFNULL(SUM(ss.TOTALAMT_HKD),0) FROM stock_master_detail ss 
           WHERE ss.product_id=p.product_id) as stock_value
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN rack_info r ON(bo.rack_id=r.rack_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          WHERE p.department_id=$department_id 
          AND p.product_type=2 AND p.product_status=1 AND p.machine_other=2
          AND p.main_stock<p.reorder_level
          ORDER BY p.product_id DESC")->result();
    }else{
      $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,CONCAT(r.rack_name,' (',bo.box_name,')') as rack_name,u.unit_name,
          (SELECT IFNULL(SUM(ss.TOTALAMT_HKD),0) FROM stock_master_detail ss 
           WHERE ss.product_id=p.product_id) as stock_value
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN rack_info r ON(bo.rack_id=r.rack_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          WHERE p.department_id=$department_id 
          AND p.product_type=2 AND p.product_status=1
          AND p.main_stock<p.minimum_stock
          ORDER BY p.product_id DESC")->result();
    }
  return $result;
}
function loadExcel(){
        $condition='';
        $result=$this->db->query("SELECT md.date,m.employee_id,md.product_code,p.product_name,md.quantity,
            (SELECT group_concat(sym.symptoms_name separator ',') as symptoms_group  
            FROM issued_symptoms isym, symptoms_info sym 
            WHERE isym.symptoms_id=sym.symptoms_id AND isym.issue_id=m.issue_id 
            GROUP BY m.issue_id) as symptoms_group
            FROM `item_issue_detail` md
            INNER JOIN product_info p ON(p.product_id=md.product_id)
            INNER JOIN store_issue_master m ON(m.issue_id=md.issue_id)
            WHERE p.category_id=57
            ORDER BY md.date ASC")->result();
        return $result;
    }
 


}