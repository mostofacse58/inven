<?php
class Stockhistory_model extends CI_Model {
	
	 function reportrResult($product_code=FALSE,$LOCATION=FALSE,$po_no=FALSE,$FIFO_CODE=FALSE,$from_date=FALSE,$to_date=FALSE){
    $department_id=$this->session->userdata('department_id');
    $condition='';
    if($product_code!=''&&$product_code!='All'){
      $condition.=" AND a.ITEM_CODE='$product_code' ";
    }
    if($LOCATION!=''&&$LOCATION!='All'){
      $condition.=" AND a.LOCATION='$LOCATION' ";
    }
    if($po_no!=''&&$po_no!='All'){
      $condition.=" AND a.po_number='$po_no'";
    }
    if($FIFO_CODE!=''&&$FIFO_CODE!='All'){
      $condition.=" AND a.FIFO_CODE='$FIFO_CODE' ";
    }
    if($from_date!=''&&$to_date!=''){
        $from_date="$from_date 00:00:00";
        $to_date="$to_date 00:00:00"; 
        $condition.=" AND a.INDATE BETWEEN '$from_date' AND '$to_date' ";
    }
    /*$result=$this->db->query("SELECT a.*,IFNULL(SUM(a.QUANTITY),0) as out_qty,
        (SELECT IFNULL(SUM(sm.QUANTITY),0) as out_qty FROM stock_master_detail sm 
        WHERE  sm.FIFO_CODE=a.FIFO_CODE AND sm.TRX_TYPE!='GRN' AND sm.TRX_TYPE!='OPENING') as out_qty,
        p.product_id,
        p.product_name,p.product_code,
        u.unit_name
        FROM stock_master_detail a
        INNER JOIN product_info p ON(p.product_id=a.product_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=2 AND a.department_id=$department_id
        AND (SELECT IFNULL(SUM(sm1.QUANTITY),0) as out_qty FROM stock_master_detail sm1 
        WHERE  sm1.FIFO_CODE=a.FIFO_CODE AND sm1.TRX_TYPE!='GRN' AND sm1.TRX_TYPE!='OPENING')<a.QUANTITY
        AND (a.TRX_TYPE='GRN' OR a.TRX_TYPE='OPENING')
        $condition 
        GROUP BY a.FIFO_CODE
        ORDER BY p.product_code ASC")->result();
        */
    $result=$this->db->query("SELECT a.*,IFNULL(SUM(a.QUANTITY),0) as main_stock,
        p.product_id,
        p.product_name,p.product_code,
        u.unit_name
        FROM stock_master_detail a
        INNER JOIN product_info p ON(p.product_id=a.product_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=2 
        AND a.department_id=$department_id 
        $condition 
        GROUP BY a.FIFO_CODE,a.product_id
        ORDER BY a.ITEM_CODE,a.FIFO_CODE ASC")->result();
      return $result;
         
	}

 


}