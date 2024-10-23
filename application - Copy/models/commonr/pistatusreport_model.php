<?php
class Pistatusreport_model extends CI_Model {
   function reportrResult($department_id,$pi_status,$pi_no,$product_code,$purchase_type_id,$from_date=FALSE,$to_date=FALSE){
    $condition='';
    if($pi_no!=''&&$pi_no!='All'){
      $condition.=" AND pm.pi_no='$pi_no'";
    }
    if($product_code!=''&&$product_code!='All'){
      $condition.=" AND pd.product_code='$product_code'";
    }
    if($purchase_type_id!=''&&$purchase_type_id!='All'){
      $condition.=" AND pm.purchase_type_id=$purchase_type_id ";
    }
    if($from_date!=''&&$to_date !=' '){
      $condition.=" AND pm.pi_date BETWEEN '$from_date' AND '$to_date'";
    }

    if($pi_status=='All'){
      $result=$this->db->query("SELECT pd.*,pm.*,SUM(pd.purchased_qty) as purchased_qty,

       (SELECT IFNULL(SUM(po.quantity),0) FROM po_pline po 
        WHERE pd.product_id=po.product_id 
        AND po.pi_no=pm.pi_no) as po_qty,

        (SELECT IFNULL(SUM(pud.quantity),0) FROM purchase_detail pud 
        WHERE pd.product_id=pud.product_id 
        AND pud.pi_no=pm.pi_no AND pud.status!=5) as in_qty

      FROM pi_item_details pd,  pi_master pm 
      WHERE  pd.pi_id=pm.pi_id AND pm.department_id=$department_id 
      AND pm.pi_status=7 $condition
      GROUP BY pd.product_code,pd.pi_id
      ORDER BY pm.demand_date ASC ")->result();

    }elseif($pi_status==1){
      $result=$this->db->query("SELECT pd.*,pm.*,
       (SELECT IFNULL(SUM(po.quantity),0) FROM po_pline po 
        WHERE pd.product_id=po.product_id AND po.pi_no=pm.pi_no AND po.po_status=3) as po_qty,

        (SELECT IFNULL(SUM(pud.quantity),0) FROM purchase_detail pud 
        WHERE pd.product_id=pud.product_id AND pud.pi_no=pm.pi_no AND pud.status!=5) as in_qty

      FROM pi_item_details pd,  pi_master pm 
      WHERE  pd.pi_id=pm.pi_id AND pm.department_id=$department_id AND pm.pi_status=7
      AND pd.purchased_qty=(SELECT IFNULL(SUM(pud.quantity),0) FROM purchase_detail pud 
      WHERE pd.product_id=pud.product_id AND pud.pi_no=pm.pi_no AND pud.status!=5)
      $condition
      ORDER BY pm.demand_date ASC ")->result();
    }elseif($pi_status==2){
      $result=$this->db->query("SELECT pd.*,pm.*,
       (SELECT IFNULL(SUM(po.quantity),0) FROM po_pline po 
        WHERE pd.product_id=po.product_id AND po.pi_no=pm.pi_no AND po.po_status=3) as po_qty,

       (SELECT IFNULL(SUM(pud.quantity),0) FROM purchase_detail pud 
        WHERE pd.product_id=pud.product_id AND pud.pi_no=pm.pi_no AND pud.status!=5) as in_qty

      FROM pi_item_details pd,  pi_master pm 
      WHERE  pd.pi_id=pm.pi_id AND pm.department_id=$department_id  AND pm.pi_status=7 
      AND pd.purchased_qty>(SELECT IFNULL(SUM(pud.quantity),0) FROM purchase_detail pud 
        WHERE pd.product_id=pud.product_id AND pud.pi_no=pm.pi_no AND pud.status!=5)
      $condition
      ORDER BY pm.demand_date ASC  ")->result();
    }elseif($pi_status==3){
      $result=$this->db->query("SELECT pd.*,pm.*,
       (SELECT IFNULL(SUM(po.quantity),0) FROM po_pline po 
        WHERE pd.product_id=po.product_id AND po.pi_no=pm.pi_no AND po.po_status=3) as po_qty,

        (SELECT IFNULL(SUM(pud.quantity),0) FROM purchase_detail pud 
        WHERE pd.product_id=pud.product_id AND pud.pi_no=pm.pi_no AND pud.status!=5) as in_qty

      FROM pi_item_details pd, pi_master pm 
      WHERE  pd.pi_id=pm.pi_id AND pm.department_id=$department_id AND pm.pi_status=7
      AND pd.purchased_qty<(SELECT IFNULL(SUM(pud.quantity),0) FROM purchase_detail pud 
        WHERE pd.product_id=pud.product_id AND pud.pi_no=pm.pi_no AND pud.status!=5)
      $condition
      ORDER BY pm.demand_date ASC ")->result();
    }
    
    return $result;
  }
 
}