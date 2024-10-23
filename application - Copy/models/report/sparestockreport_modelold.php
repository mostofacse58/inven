<?php
class Sparestockreport_model extends CI_Model {
  
   function reportrResult($category_id,$rack_id,$box_id,$color_code,$product_code){
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
    if($color_code==1)
    $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,CONCAT(r.rack_name,' (',bo.box_name,')') as rack_name,u.unit_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN rack_info r ON(bo.rack_id=r.rack_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          WHERE p.department_id=12 and p.product_type=2 AND p.main_stock>p.minimum_stock
          $condition
          ORDER BY p.product_id ASC")->result();
    elseif($color_code==2)
      $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,CONCAT(r.rack_name,' (',bo.box_name,')') as rack_name,u.unit_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN rack_info r ON(bo.rack_id=r.rack_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          WHERE p.department_id=12 and p.product_type=2 AND p.main_stock<p.minimum_stock
          $condition
          ORDER BY p.product_id ASC")->result();
    else
      $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,CONCAT(r.rack_name,' (',bo.box_name,')') as rack_name,u.unit_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN rack_info r ON(bo.rack_id=r.rack_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          WHERE p.department_id=12 and p.product_type=2
          $condition
          ORDER BY p.product_id ASC")->result();
        return $result;
          
  }
  function checkLastDate($product_id){
        $info=$this->db->query("SELECT p.purchase_date
            FROM purchase_detail pd,purchase_master p
            WHERE pd.purchase_id=p.purchase_id
            AND pd.product_id=$product_id 
            ORDER BY pd.purchase_detail_id DESC")->row();
        if(count($info)>0)
        return $info->purchase_date;
       else  return 0;

   }
 


}