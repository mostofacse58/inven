<?php
class Sparestockreport_model extends CI_Model {
	
	 function reportResult($department_id){
    $result=$this->db->query("SELECT p.*,c.category_name,m.mtype_name,
          b.brand_name,CONCAT(r.rack_name,' (',bo.box_name,')') as rack_name,u.unit_name
          FROM  product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN box_info bo ON(p.box_id=bo.box_id)
          LEFT JOIN rack_info r ON(bo.rack_id=r.rack_id)
          LEFT JOIN product_unit u ON(p.unit_id=u.unit_id)
          LEFT JOIN material_info m ON(p.mtype_id=m.mtype_id)
          LEFT JOIN brand_info b ON(p.brand_id=b.brand_id)
          WHERE p.department_id=$department_id and p.product_type=2
          ORDER BY p.product_id DESC")->result();
    //print_r($result); exit();
        return $result;
          
	}
  function get_sparesStock($product_id,$department_id){
      $stockin=$this->db->query("SELECT stock_quantity as stockin 
        FROM product_info WHERE product_id=$product_id")->row('stockin');

      $purchaseqty=$this->db->query("SELECT IFNULL(SUM(quantity),0) as purchaseqty 
        FROM purchase_detail WHERE product_id=$product_id")->row('purchaseqty');

      $stockout1=$this->db->query("SELECT IFNULL(SUM(quantity),0) as stockout1 
        FROM spares_use_detail WHERE product_id=$product_id")->row('stockout1');

      $stockout2=$this->db->query("SELECT IFNULL(SUM(quantity),0) as stockout2 
        FROM item_issue_detail WHERE product_id=$product_id")->row('stockout2');
      return ($stockin+$purchaseqty-$stockout1-$stockout2);
    }
    function get_PIStock($product_id,$department_id){
      $piqty=$this->db->query("SELECT IFNULL(SUM(purchased_qty),0) as piqty 
        FROM pi_item_details WHERE product_id=$product_id AND department_id=$department_id")->row('piqty');
      $purchaseqty=$this->db->query("SELECT IFNULL(SUM(quantity),0) as purchaseqty 
        FROM purchase_detail WHERE product_id=$product_id AND department_id=$department_id")->row('purchaseqty');
      return ($piqty-$purchaseqty);
    }
 


}