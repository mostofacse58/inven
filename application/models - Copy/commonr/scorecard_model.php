<?php
class Scorecard_model extends CI_Model {
  
   function reportrResult($supplier_id=FALSE,$po_number=FALSE,$from_date=FALSE,$to_date=FALSE){
    $department_id=$this->session->userdata('department_id');
    $condition='';
    if($supplier_id!=''&&$supplier_id!='All'){
      $condition.=" AND a.supplier_id='$supplier_id' ";
    }
    if($po_number!=''&&$po_number!='All'){
      $condition.=" AND a.po_number='$po_number'";
    }
    if($from_date!=''&&$to_date!=''){
        $condition.=" AND a.po_date BETWEEN '$from_date' AND '$to_date' ";
    }
    $result=$this->db->query("SELECT a.*,s.*,
        (SELECT IFNULL(SUM(p.quality_rate),0)/count(p.purchase_id) as qualityrate 

        FROM purchase_master p WHERE p.po_number=a.po_number) as qualityrate 
        FROM po_master a
        INNER JOIN supplier_info s ON(s.supplier_id=a.supplier_id)
        WHERE 1
        $condition 
        ORDER BY a.po_number,a.po_date DESC")->result();
      return $result;
         
  }
  /////////////////////
  function getDelivery($po_number='') {
    $poinfo=$this->db->query("SELECT a.* FROM po_master a
        WHERE a.po_number='$po_number'")->row();

    $pinfo=$this->db->query("SELECT a.* FROM purchase_master a
        WHERE a.po_number='$po_number' AND a.status!=5
        ORDER BY a.purchase_id DESC")->row();

  if (!empty($pinfo)) {
    $add3= date('Y-m-d',strtotime($poinfo->delivery_date3." +3 days"));
    $add7= date('Y-m-d',strtotime($poinfo->delivery_date3." +7 days"));

    if($poinfo->delivery_date>=$pinfo->challan_date){
      return 5;
    }elseif($poinfo->delivery_date2>=$pinfo->challan_date){
      return 4;
    }elseif($poinfo->delivery_date3>=$pinfo->challan_date){
      return 3;
    }elseif($add3>=$pinfo->challan_date){
      return 2;
    }elseif($add7>=$pinfo->challan_date){
      return 1;
    }else{
      return 0;
    }}else {
      return 0;
    }
  }

  function getPayment($po_number=''){
    $poinfo=$this->db->query("SELECT a.* FROM po_master a
        WHERE a.po_number='$po_number'")->row();

    $puinfo=$this->db->query("SELECT a.* FROM purchase_master a
        WHERE a.po_number='$po_number' AND a.status!=5
        ORDER BY a.purchase_id DESC")->row();


    $pinfo=$this->db->query("SELECT a.* FROM payment_application_master a, payment_po_amount p
        WHERE a.payment_id=p.payment_id AND p.po_number='$po_number' 
        ORDER BY  a.payment_id DESC")->row();

   if (!empty($pinfo)&&!empty($puinfo)) {
      if($pinfo->delivery_date){  
        $days=$poinfo->credit_days;
        $days2=$poinfo->credit_days*2;

        $popaymentdate= date('Y-m-d',strtotime($puinfo->challan_date." +$days days"));
        ///////////////////////////////////////////
        $podoubledate= date('Y-m-d',strtotime($puinfo->challan_date." +$days2 days"));
        if($pinfo->delivery_date<$popaymentdate||$pinfo->delivery_date>$podoubledate){
          return 1;
        }else{
          return 5;
        }
      }else{
       return 1;
      }
    }else{
       return 0;
    }
  }
  ///////////////////////////////////

  function getQuality($po_number=''){
    $pinfo=$this->db->query("SELECT IFNULL(SUM(pd.quantity),0) as totalqty,
        IFNULL(SUM(pd.unqualified_qty),0) as totalunqty
        FROM purchase_master p, purchase_detail pd
        WHERE p.purchase_id=pd.purchase_id AND p.po_number='$po_number' ")->row();

      $percentage=0;
      if(!empty($pinfo)&&$pinfo->totalqty>0){

        $percentage=(100/($pinfo->totalqty+$pinfo->totalunqty))*$pinfo->totalqty;


        if($percentage>=100){  
          return 5;
        }elseif($percentage>94){  
          return 4;
        }elseif($percentage>89){
          return 3;
        }elseif($percentage>84){
          return 2;
        }elseif($percentage>79){
          return 1;
        }else{
          return 0;
        }
        
      }else{
         return 0;
      }
  }

 


}