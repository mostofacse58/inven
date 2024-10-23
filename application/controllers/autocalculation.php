<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Autocalculation extends CI_Controller {
  function __construct() {
	  parent::__construct();
    $this->load->model('commonr/itemstock_model');
  }

 function index(){
    $date = date('2022-01');
    $sixmonth = date('Y-m',strtotime($date." -6 month"));
    $fivemonth = date('Y-m',strtotime($date." -5 month"));
    $fourmonth = date('Y-m',strtotime($date." -4 month"));
    $threemonth = date('Y-m',strtotime($date." -3 month"));
    $twomonth = date('Y-m',strtotime($date." -2 month"));
    $onemonth = date('Y-m',strtotime($date." -1 month"));
    $pdata=$this->db->query("SELECT * FROM product_info 
      WHERE product_type=2 
    ORDER BY product_id ASC 
    LIMIT 0,1000")->result();
    
    foreach ($pdata as  $row){
      $monthqty=$this->look_up_model->get_monthlyqty($row->product_id);
      $sixqty=0;
      $fiveqty=0;
      $fourqty=0;
      $threeqty=0;
      $twoqty=0;
       $oneqty=0;
      if(count($monthqty)>0){
        foreach ($monthqty as $value) {
          if($value->month==$sixmonth) $sixqty=$value->total_quantity;
          if($value->month==$fivemonth)  $fiveqty=$value->total_quantity;
          if($value->month==$fourmonth)  $fourqty=$value->total_quantity;
          if($value->month==$threemonth)  $threeqty=$value->total_quantity;
          if($value->month==$twomonth)  $twoqty=$value->total_quantity;
          if($value->month==$onemonth)  $oneqty=$value->total_quantity;
        }
      } 

      // if(count($monthqty)>0){
      //   foreach ($monthqty as  $value) {
          
      //   }
      // } 
      
      // if(count($monthqty)>0){
      //   foreach ($monthqty as  $value) {
          
      //   }
      // } 
      
      // if(count($monthqty)>0){
      //   foreach ($monthqty as  $value) {
          
      //   }
      // } 
      
      // if(count($monthqty)>0){
      //   foreach ($monthqty as  $value) {
          
      //   }
      // } 
     
      // if(count($monthqty)>0){
      //   foreach ($monthqty as  $value) {
          
      //   }
      // } 

      $dataarray=array();
      $dataarray['oneqty']=$oneqty;
      $dataarray['twoqty']=$twoqty;
      $dataarray['threeqty']=$threeqty;
      $dataarray['fourqty']=$fourqty;
      $dataarray['fiveqty']=$fiveqty;
      $dataarray['sixqty']=$sixqty;
      if($oneqty==0&&$twoqty==0&&$threeqty==0&&$fourqty==0&&$fiveqty==0&&$sixqty==0){
      $dataarray['last_six_month_qty']=0;
      $dataarray['avg_use_per_month']=0;
      //////////////
      $onedayqty=number_format(($sixqty+$fiveqty+$fourqty+$threeqty+$twoqty+$oneqty)/180,4);
      ///////////////////////
      $dataarray['lead_time_stock_qty']=0;
      $dataarray['one_month_stock']=0;
      $dataarray['twenty_per_stock']=0;
      //$dataarray['reorder_level']=0;
      //$dataarray['re_order_qty']=0;
      }else{
      $minimum_stock=$row->minimum_stock;
      $dataarray['last_six_month_qty']=$sixqty+$fiveqty+$fourqty+$threeqty+$twoqty+$oneqty;
      $dataarray['avg_use_per_month']=number_format(($sixqty+$fiveqty+$fourqty+$threeqty+$twoqty+$oneqty)/6,2);
      //////////////
      $onedayqty=number_format(($sixqty+$fiveqty+$fourqty+$threeqty+$twoqty+$oneqty)/180,4);
      ///////////////////////
      $dataarray['lead_time_stock_qty']=$onedayqty*$row->lead_time;
      $dataarray['one_month_stock']=$dataarray['avg_use_per_month'];
      $dataarray['twenty_per_stock']=$dataarray['lead_time_stock_qty']+$dataarray['avg_use_per_month'];
      //$dataarray['reorder_level']=$minimum_stock-$dataarray['avg_use_per_month'];
      //$dataarray['re_order_qty']=$dataarray['lead_time_stock_qty']+$dataarray['avg_use_per_month'];
      }
      $dataarray['lmonth_closing_stock']=$row->main_stock;
      $dataarray['lmonth_closing_amount']=$row->amount_hkd;
      $this->db->WHERE('product_id',$value->product_id);
      $this->db->UPDATE('product_info',$dataarray);
    }
   
     echo "Success";
     exit();
  }
  function yearlyupdate(){
    $date = date('202');
    $pdata=$this->db->query("SELECT * FROM product_info 
      WHERE product_type=2 
    ORDER BY product_id ASC
    LIMIT 0,2000 ")->result();
    foreach ($pdata as  $row){
      $product_id=$row->product_id;
      $before_year_qty=$this->db->query("SELECT IFNULL(SUM(total_quantity),0) as totalquantity
        FROM every_month_using_qty 
        WHERE product_id=$product_id  
        AND month LIKE '$date-%'")->row('totalquantity');
      $dataarray=array();
      $dataarray['before_year_qty']=$before_year_qty;
      $this->db->WHERE('product_id',$row->product_id);
      $this->db->UPDATE('product_info',$dataarray);
    }
    echo "Success";
    exit();
  }
///
  // INSERT INTO msm_additional_subject_info (SELECT NULL as id,11 as class_id, p.group_id ,p.com_subject_id,
  //                                        p.com_subject_id2,p.add_subject_id,p.add_subject_id2,p.student_id,
  //                                        p.school_id, 3 as session_id, p.status, p.create_at,p.update_at  FROM msm_additional_subject_info  p WHERE p.`class_id`=10 and p.`group_id`=2 AND p.`session_id`=2)
  //////////////////////
//  function sixmonth(){
//   $month=date('2019-10');
// 		$data=$this->db->query("INSERT INTO every_month_using_qty (SELECT NULL as id, p.product_id,'2022-02' as month, (SELECT IFNULL(SUM(ad.quantity),0) FROM spares_use_detail ad WHERE p.product_id=ad.product_id AND ad.date LIKE '2022-02%') as total_quantity, p.department_id,'2022-02-28' as last_update FROM product_info p WHERE p.department_id=12 AND p.product_type=2)")->result();

  //    $data=$this->db->query("INSERT INTO every_month_using_qty (SELECT NULL as id, p.product_id,'2022-01' as month, (SELECT IFNULL(SUM(ad.quantity),0) FROM item_issue_detail ad WHERE p.product_id=ad.product_id AND ad.date LIKE '2022-01%') as total_quantity, p.department_id,'2022-01-28' as last_update FROM product_info p WHERE p.department_id!=12 AND p.product_type=2)")->result();




//     //$this->db->insert('every_month_using_qty', $data); 
//     //print_r($data); 
//      // INSERT INTO every_month_using_qty (SELECT p.product_id,'2019-10' as month,
//      //  (SELECT IFNULL(SUM(ad.quantity),0) FROM spares_use_detail ad 
//      //  WHERE p.product_id=ad.product_id AND ad.date LIKE '2019-10%') as total_quantity,
//      //  p.department_id 
//      //  FROM product_info p
//      //  WHERE p.department_id=12 AND product_type=2 LIMIT 0,20)

// 		// foreach ($rplists as  $value){
//   //       $iqty=$this->look_up_model->getIssueTotalQty($value->requisition_no,$value->product_id);
//   //       if($iqty>0){

//   //         $data=array();
//   //         $data['issued_qty']=$iqty;
//   //         if($iqty==$value->required_qty){
//   //           $data['issue_status']=2;
//   //         }

//   //     $this->db->WHERE('requisition_detail_id',$value->requisition_detail_id);
//   //     $this->db->UPDATE('requisition_item_details',$data);
//   //       }
//     "INSERT INTO stock_master_detail (SELECT NULL as id, 
//       'OPENING' as TRX_TYPE,
//       p.department_id, 
//       NULL as received_department_id, 
//       p.create_date as INDATE,
//       p.product_id ,
//       p.product_code as ITEM_CODE,
//       CONCAT('1912300',p.product_id) as FIFO_CODE,
//       'BHRO1' as LOCATION,
//       NULL as LOCATION1,
//       p.currency as CRRNCY,
//       NULL as EXCH_RATE,
//       p.stock_quantity as QUANTITY,
//       p.unit_price as UPRICE,
//       p.unit_price*p.stock_quantity as TOTALAMT,
//       p.unit_price*p.stock_quantity as TOTALAMT_T,
//       p.unit_price*p.stock_quantity as TOTALPRICE,
//       NULL as po_id,
//       NULL as pi_id,
//       NULL as receive_id,
//       NULL as issue_id,
//       NULL as REF_CODE,
//       NULL as supplier_id,
//       p.user_id as CRT_USER,
//       p.create_date as CRT_DATE,
//       p.user_id 
//       FROM product_info p
//       WHERE p.product_type=2 AND p.product_code='BDMEDEEAD000200' AND p.product_id=2830)"

//       /////////////////// purchase insert////////
      // "INSERT INTO stock_master_detail (SELECT NULL as id, 
      // 'GRN' as TRX_TYPE,
      // p.department_id, 
      // NULL as received_department_id, 
      // pm.purchase_date as INDATE,
      // p.product_id,
      // p.product_code as ITEM_CODE,
      // CONCAT('1912300',p.product_id) as FIFO_CODE,
      // 'BHRO1' as LOCATION,
      // NULL as LOCATION1,
      // p.currency as CRRNCY,
      // p.cnc_rate_in_hkd as EXCH_RATE,
      // p.quantity as QUANTITY,
      // p.unit_price as UPRICE,
      // p.unit_price*p.quantity as TOTALAMT,
      // p.unit_price*p.quantity as TOTALAMT_T,
      // p.unit_price*p.quantity as TOTALPRICE,
      // NULL as po_id,
      // NULL as pi_id,
      // p.purchase_id as receive_id,
      // NULL as issue_id,
      // pm.reference_no as REF_CODE,
      // NULL as supplier_id,
      // pm.user_id as CRT_USER,
      // pm.purchase_date as CRT_DATE,
      // pm.user_id 
      // FROM purchase_detail p,purchase_master pm
      // WHERE pm.purchase_id=p.purchase_id AND p.product_code='BDMEDEEAD000200' AND p.product_id=2830)"


//       /////////////////// Issue insert////////
//       "INSERT INTO stock_master_detail (SELECT NULL as id, 
//       'ISSUE' as TRX_TYPE,
//       p.department_id, 
//       pm.take_department_id as received_department_id, 
//       pm.issue_date as INDATE,
//       p.product_id,
//       p.product_code as ITEM_CODE,
//       CONCAT('1912300',p.product_id) as FIFO_CODE,
//       'BHRO1' as LOCATION,
//       'BP01' as LOCATION1,
//       p.currency as CRRNCY,
//       p.cnc_rate_in_hkd as EXCH_RATE,
//       -p.quantity as QUANTITY,
//       p.unit_price as UPRICE,
//       -p.unit_price*p.quantity as TOTALAMT,
//       p.unit_price*p.quantity as TOTALAMT_T,
//       p.unit_price*p.quantity as TOTALPRICE,
//       NULL as po_id,
//       NULL as pi_id,
//       NULL as receive_id,
//       p.issue_id,
//       pm.issue_ref_no as REF_CODE,
//       NULL as supplier_id,
//       pm.user_id as CRT_USER,
//       pm.issue_date as CRT_DATE,
//       pm.user_id 
//       FROM item_issue_detail p,store_issue_master pm
//       WHERE pm.issue_id=p.issue_id  AND p.product_code='BDMEDEEAD000200' AND p.product_id=2830)"

//       /////////////////// Issue insert TPM////////
//       "INSERT INTO stock_master_detail (SELECT NULL as id, 
//       'ISSUETPM' as TRX_TYPE,
//       p.department_id, 
//       pm.take_department_id as received_department_id, 
//       pm.use_date as INDATE,
//       p.product_id,
//       p.product_code as ITEM_CODE,
//       CONCAT('1912300',p.product_id) as FIFO_CODE,
//       'BHRO1' as LOCATION,
//       'BP01' as LOCATION1,
//       p.currency as CRRNCY,
//       p.cnc_rate_in_hkd as EXCH_RATE,
//       -p.quantity as QUANTITY,
//       p.unit_price as UPRICE,
//       -p.unit_price*p.quantity as TOTALAMT,
//       p.unit_price*p.quantity as TOTALAMT_T,
//       p.unit_price*p.quantity as TOTALPRICE,
//       NULL as po_id,
//       NULL as pi_id,
//       NULL as receive_id,
//       p.spares_use_id as issue_id,
//       pm.using_ref_no as REF_CODE,
//       NULL as supplier_id,
//       pm.user_id as CRT_USER,
//       pm.use_date as CRT_DATE,
//       pm.user_id 
//       FROM spares_use_detail p,spares_use_master pm
//       WHERE pm.spares_use_id=p.spares_use_id)"
//     //////////////////////////////////////

// ////////////////////////////////////////////////////////////
//       /////////////////////////////////////////////////////
//       ////////////////////////////////////////////////////
//       ////////////////////////////////////////////////////


//       /////////////////////////////////////////////////
//       ///////////////////////////////////////////////
//       ///////////////////////////////////////////////
//       //////////////////////////////////////////////
//       /////////////////////////////////////////////
//       ////////////////////////////////////////////
//       ///////////////////////////////////////////
//       //////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'OPENING' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// p.stock_quantity as QUANTITY,
// p.unit_price as UPRICE,
// CASE WHEN p.currency='BDT' THEN p.unit_price*p.stock_quantity
// ELSE p.unit_price*p.stock_quantity*10.99
// END AS TOTALAMT,
// CASE WHEN p.currency='HKD' THEN p.unit_price*p.stock_quantity
// ELSE p.unit_price*p.stock_quantity*0.091
// END AS TOTALAMT_HKD,
// p.unit_price*p.stock_quantity as TOTALAMT_T,
// p.unit_price*p.stock_quantity as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// NULL as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2)"
// /////////////////////////////////


// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'GRN' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// (SELECT SUM(pdd.quantity) as dddd FROM purchase_detail pdd WHERE pdd.product_id=p.product_id AND pdd.status!=5) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.product_id>=0 AND p.product_id<=1000)"
// ///////////////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'GRN' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// (SELECT SUM(pdd.quantity) as dddd FROM purchase_detail pdd WHERE pdd.product_id=p.product_id AND pdd.status!=5) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.product_id>=1001 AND p.product_id<=2000)"
// //////////////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'GRN' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// (SELECT SUM(pdd.quantity) as dddd FROM purchase_detail pdd WHERE pdd.product_id=p.product_id AND pdd.status!=5) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.product_id>=2001 AND p.product_id<=3000)"
// //////////////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'GRN' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// (SELECT SUM(pdd.quantity) as dddd FROM purchase_detail pdd WHERE pdd.product_id=p.product_id AND pdd.status!=5) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.product_id>=3001 AND p.product_id<=4700)"

// ///////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'GRN' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// (SELECT SUM(pdd.quantity) as dddd FROM purchase_detail pdd WHERE pdd.product_id=p.product_id AND pdd.status!=5) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.product_id>=4701 AND p.product_id<=5500)"
// ///////////////////////////////////////////////
// /////////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=0 AND p.product_id<=500)"
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=501 AND p.product_id<=1000)"
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=1001 AND p.product_id<=1500)"
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=1501 AND p.product_id<=2000)"
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=2001 AND p.product_id<=2500)"
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=2501 AND p.product_id<=3000)"
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=3001 AND p.product_id<=3500)"
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=3501 AND p.product_id<=4000)"
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=4001 AND p.product_id<=4700)"
// ///////////////////////////////////////////////
// ////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'ISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM item_issue_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=2 AND p.product_id>=4701 AND p.product_id<=5500)"
// ///////////////////////////////////////////////
// ////////////////TPM ITEMS////////////////

// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=0 AND p.product_id<=500)"
// ///////////////////////////////////////////////
// ///////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=501 AND p.product_id<=1500)"
// ///////////////////////////////////////////
// ///////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=1501 AND p.product_id<=2000)"
// ///////////////////////////////////////////
// ///////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=2001 AND p.product_id<=2500)"
// ///////////////////////////////////////////
// ///////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=2501 AND p.product_id<=3000)"
// ///////////////////////////////////////////
// ///////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=3001 AND p.product_id<=3500)"
// ///////////////////////////////////////////
// ///////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=3501 AND p.product_id<=4000)"
// ///////////////////////////////////////////
// ///////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=4001 AND p.product_id<=4700)"
// ///////////////////////////////////////////
// "INSERT INTO stock_master_detail (SELECT NULL as id, 
// 'TPMISSUE' as TRX_TYPE,
// p.department_id, 
// NULL as received_department_id, 
// p.create_date as INDATE,
// p.product_id ,
// p.product_code as ITEM_CODE,
// CONCAT('1912300',p.product_id) as FIFO_CODE,
// 'BHRO1' as LOCATION,
// NULL as LOCATION1,
// p.currency as CRRNCY,
// NULL as EXCH_RATE,
// -(SELECT SUM(pdd.quantity) as dddd FROM spares_use_detail pdd WHERE pdd.product_id=p.product_id) as QUANTITY,
// p.unit_price as UPRICE,
// 0 as TOTALAMT,
// 0 as TOTALAMT_HKD,
// 0 as TOTALAMT_T,
// 0 as TOTALPRICE,
// NULL as po_id,
// NULL as pi_id,
// 1 as receive_id,
// NULL as issue_id,
// NULL as REF_CODE,
// NULL as supplier_id,
// p.user_id as CRT_USER,
// p.create_date as CRT_DATE,
// p.user_id 
// FROM product_info p
// WHERE p.product_type=2 AND p.machine_other=1 AND p.product_id>=4701 AND p.product_id<=5500)"
// ///////////////////////////////////////////
// /////////////////////////////////////////////////
//  exit();
// }

	
   

	
}