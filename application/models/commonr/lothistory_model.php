<?php
class Lothistory_model extends CI_Model {
	
    function reportrResult($product_code=FALSE,$LOCATION=FALSE,$po_no=FALSE,$FIFO_CODE=FALSE,$from_date=FALSE,$to_date=FALSE){
        $department_id=$this->session->userdata('department_id');
        $condition='';
        if($product_code!=''&&$product_code!='All'){
          $condition.=" AND a.ITEM_CODE='$product_code' ";
        }
        if($LOCATION!=''&&$LOCATION!='All'){
          $condition.=" AND a.LOCATION='$LOCATION' ";
        }
        if($po_no!=''){
          $condition.=" AND a.po_number='$po_no' ";
        }
        
        if($FIFO_CODE!=''&&$FIFO_CODE!='All'){
          $condition.=" AND a.FIFO_CODE='$FIFO_CODE' ";
        }
        if($from_date!=''&&$to_date!=''){
          $from_date="$from_date  00:00:00";
          $to_date="$to_date  00:00:00"; 
          $condition.=" AND a.INDATE BETWEEN '$from_date' AND '$to_date' ";
        }
        $result=$this->db->query("SELECT a.*,a.QUANTITY,
            p.product_id,
            p.product_name,p.product_code,
            u.unit_name
            FROM stock_master_detail a
            INNER JOIN product_info p ON(p.product_id=a.product_id)
            INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
            WHERE p.product_type=2 
            AND a.department_id=$department_id 
            $condition 
            ORDER BY a.product_id, a.FIFO_CODE,a.INDATE ASC")->result();
        return $result;
    }






}