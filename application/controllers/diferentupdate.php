<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diferentupdate extends CI_Controller {
	function __construct(){
        parent::__construct();
        
     }
    
    
    function priceupdate(){
      // $result=$this->db->query("SELECT id.*,p.*
      //     FROM  item_issue_detail id,product_info p   
      //     WHERE p.product_type=2 AND p.product_id=id.product_id 
      //     AND p.department_id=3 AND id.item_issue_detail_id>=17623
      //     AND id.item_issue_detail_id<=22211
      //     ORDER BY id.issue_id ASC")->result();
        $result=$this->db->query("SELECT id.*,p.*
          FROM  item_issue_detail id,product_info p   
          WHERE p.product_type=2 AND p.product_id=id.product_id 
          AND p.department_id=3 AND p.unit_price<1 AND p.medical_yes=1
          ORDER BY id.issue_id ASC")->result();

        foreach ($result as  $value) {
        $data['unit_price']=$value->unit_price;
        $data['sub_total']=$value->unit_price*$value->quantity;
        echo "$value->item_issue_detail_id <br>";
        echo $value->unit_price*$value->quantity;exit();
        //$this->db->WHERE('item_issue_detail_id',$value->item_issue_detail_id);
        //$query=$this->db->update('item_issue_detail',$data);
        }
      echo "done";
    }
    function changecode(){
        $result=$this->db->query("SELECT p.*
          FROM  product_detail_info p   
          WHERE p.department_id=3 AND p.machine_other=2
          ORDER BY p.product_detail_id ASC")->result();
        $code_count=0;
        foreach ($result as  $value) {
        $data['ventura_code']='ADMIN'.str_pad($code_count + 1, 6, '0', STR_PAD_LEFT);
        $data['code_count']=$code_count + 1;
        $this->db->WHERE('product_detail_id',$value->product_detail_id);
        $query=$this->db->update('product_detail_info',$data);
        $code_count++;
        }
        echo "done";
        /// Machine id=6341
    }
    
    function htdpriceupdate(){
      CASE WHEN p.currency='BDT' THEN p.unit_price*p.stock_quantity
ELSE p.unit_price*p.stock_quantity*11.35
END AS TOTALAMT,
CASE WHEN p.currency='HKD' THEN p.unit_price*p.stock_quantity
ELSE p.unit_price*p.stock_quantity*0.088
END AS TOTALAMT_HKD,


      $result=$this->db->query("SELECT p.*
          FROM  product_info p   
          WHERE p.product_type=2 
          ORDER BY p.product_id ASC
          ")->result();

    " UPDATE product_info p SET p.amount=(CASE WHEN p.currency='BDT' THEN p.unit_price*p.stock_quantity
    ELSE p.unit_price*p.stock_quantity*11.35), 
    p.amount_hkd=(CASE WHEN p.currency='HKD' THEN p.unit_price*p.stock_quantity
ELSE p.unit_price*p.stock_quantity*0.088) WHERE 1 " 

" UPDATE product_info p SET p.amount=p.unit_price*p.stock_quantity, 
    p.amount_hkd=p.unit_price*p.stock_quantity*0.088 WHERE p.currency='BDT' " 

    " UPDATE product_info p SET p.amount=p.unit_price*p.stock_quantity, 
    p.amount_hkd=p.unit_price*p.stock_quantity*1.10 WHERE p.currency='RMB' " 
        " UPDATE product_info p SET p.amount=p.unit_price*p.stock_quantity, 
    p.amount_hkd=p.unit_price*p.stock_quantity*7.750 WHERE p.currency='USD' " 

" UPDATE product_info p SET p.amount=p.unit_price*p.stock_quantity, 
    p.amount_hkd=p.unit_price*p.stock_quantity WHERE p.currency='HKD' " 

        foreach ($result as  $value) {
          $hkdrate=getHKDRate($value->currency);
          $data['amount']=$value->unit_price*$value->stock_quantity;
          $data['amount_hkd']=$value->unit_price*$value->stock_quantity*$hkdrate;
          $this->db->WHERE('product_id',$value->product_id);
          $query=$this->db->update('product_info',$data);
        }
        ///////////////////////////purchase update///////////////////

        $result=$this->db->query("SELECT p.*
          FROM  purchase_detail p   
          WHERE 1
          ORDER BY p.purchase_detail_id ASC")->result();
////////////////////////////
        " UPDATE purchase_detail p SET p.amount=p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*0.088 WHERE p.currency='BDT' " 

    " UPDATE purchase_detail p SET p.amount=p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*1.100 WHERE p.currency='RMB' " 

        " UPDATE purchase_detail p SET p.amount=p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*7.750 WHERE p.currency='USD' " 

" UPDATE purchase_detail p SET p.amount=p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity WHERE p.currency='HKD' " 

////////////////////////////////////////////////////

        foreach ($result as  $value) {
          $hkdrate=getHKDRate($value->currency);
          $data['amount']=$value->unit_price*$value->quantity;
          $data['amount_hkd']=$value->unit_price*$value->quantity*$hkdrate;
          $this->db->WHERE('purchase_detail_id',$value->purchase_detail_id);
          $query=$this->db->update('purchase_detail',$data);
        }
        ///////////////////////////Issue update///////////////////
        $result=$this->db->query("SELECT p.*
          FROM  item_issue_detail p   
          WHERE 1
          ORDER BY p.item_issue_detail_id ASC")->result();
        
        ////////////////////////////
        " UPDATE item_issue_detail p SET p.sub_total =p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*0.088 WHERE p.currency='BDT' " 

     " UPDATE item_issue_detail p SET p.sub_total =p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*1.100 WHERE p.currency='RMB' " 

     " UPDATE item_issue_detail p SET p.sub_total =p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*7.750 WHERE p.currency='USD' " 

" UPDATE item_issue_detail p SET p.sub_total =p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity WHERE p.currency='HKD' " 

////////////////////////////////////////////////////

        foreach ($result as  $value) {
          $hkdrate=getHKDRate($value->currency);
          $data['amount']=$value->unit_price*$value->quantity;
          $data['amount_hkd']=$value->unit_price*$value->quantity*$hkdrate;
          $this->db->WHERE('item_issue_detail_id',$value->item_issue_detail_id);
          $query=$this->db->update('item_issue_detail',$data);
        }


        ////////////////////////////
        " UPDATE spares_use_detail p SET p.amount=p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*0.088 WHERE p.currency='BDT' " 
          ////////////////////////////
        " UPDATE spares_use_detail p SET p.amount=p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*1.100 WHERE p.currency='RMB' " 

     " UPDATE spares_use_detail p SET p.amount=p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity*7.750 WHERE p.currency='USD' " 


" UPDATE spares_use_detail p SET p.amount=p.unit_price*p.quantity, 
    p.amount_hkd=p.unit_price*p.quantity WHERE p.currency='HKD' " 
       ///////////////////////////Issue update TPM///////////////////
        $result=$this->db->query("SELECT p.*
          FROM  spares_use_detail p   
          WHERE 1
          ORDER BY p.spares_use_detail_id ASC")->result();
        foreach ($result as  $value) {
          $hkdrate=getHKDRate($value->currency);
          $data['amount']=$value->unit_price*$value->quantity;
          $data['amount_hkd']=$value->unit_price*$value->quantity*$hkdrate;
          $this->db->WHERE('spares_use_detail_id',$value->spares_use_detail_id);
          $query=$this->db->update('spares_use_detail',$data);
        }



//////////////////////////////////////////////
" UPDATE stock_master_detail p SET p.TOTALAMT=(p.UPRICE*p.QUANTITY), 
    p.TOTALAMT_HKD=(p.UPRICE*p.QUANTITY*0.088) WHERE p.CRRNCY='BDT' " 

" UPDATE stock_master_detail p SET p.TOTALAMT=p.UPRICE*p.QUANTITY, 
    p.TOTALAMT_HKD=(p.UPRICE*p.QUANTITY*1.10) WHERE p.CRRNCY='RMB' " 

" UPDATE stock_master_detail p SET p.TOTALAMT=p.UPRICE*p.QUANTITY, 
    p.TOTALAMT_HKD=(p.UPRICE*p.QUANTITY*7.750) WHERE p.CRRNCY='USD' " 

" UPDATE stock_master_detail p SET p.TOTALAMT=p.UPRICE*p.QUANTITY, 
    p.TOTALAMT_HKD=p.UPRICE*p.QUANTITY WHERE p.CRRNCY='HKD' " 

    }
   


 }