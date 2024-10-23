<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Androidcon1 extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('android_model1');
     }
    function search(){
        $resarray=array();
        $resarray['status']=200;
        $resarray['englishname']=' ';
        $resarray['chinaname']=' ';
        $resarray['assetno']=' ';
        $resarray['tpmcode']=' ';
        $resarray['invoiceno']=' ';
        $resarray['brandname']=' ';
        $resarray['lineno']=' ';
        $resarray['categoryname']=' ';
        $resarray['productmodel']=' ';
        $resarray['purchasedate']=' ';
        $resarray['chk']='NO';
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            $resarray['chk']="NO";
        }else{
        $params = $_REQUEST;
        $sn_no = $params['sn_no'];
        $sn_no=str_replace("%20", " ", $sn_no);
        $sn_no=strtoupper($sn_no);
       
        $info=$this->android_model1->search($sn_no);
        $info1=$this->android_model1->assets($sn_no);
        if(count($info)>0){

            $tolocation='CENTRAL GODOWN';
            $ventura_code=$info->ventura_code;
            $psinfo=$this->db->query("SELECT pd.*
               FROM  product_status_info pd 
               WHERE pd.department_id=12 
               AND pd.take_over_status=2
               AND pd.ventura_code='$ventura_code' 
               ORDER BY pd.product_status_id DESC ")->row();
            if(count($psinfo)>0){
               $tolocation=$psinfo->to_location_name;
            }

            $resarray['englishname']=$info->product_name;
            $resarray['chinaname']=$info->china_name;
            $resarray['assetno']=$info->ventura_code;
            $resarray['tpmcode']=$info->tpm_serial_code;
            $resarray['invoiceno']=$info->invoice_no;
            $resarray['brandname']=$info->brand_name;
            $resarray['linename']="Current: $info->line_no -> From: $tolocation";
            $resarray['categoryname']=$info->category_name;
            $resarray['productmodel']=$info->product_code;
            $resarray['purchasedate']="$info->purchase_date, AssignDate: $info->assign_date";
            $resarray['chk']='YES';
        }elseif(count($info1)>0){
            $resarray['englishname']=$info1->product_name;
            $resarray['chinaname']=$info1->china_name;
            $resarray['assetno']=$info1->ventura_code;
            $resarray['tpmcode']=" ";
            $resarray['invoiceno']=$info1->invoice_no;
            $resarray['brandname']=$info1->brand_name;
            $resarray['linename']="$info1->location_name->$info1->department_name -> $info1->employee_name";
            $resarray['categoryname']=$info1->category_name;
            $resarray['productmodel']=$info1->product_code;
            $resarray['purchasedate']=$info1->purchase_date;
            $resarray['chk']='YES';
        }else{
          $resarray['chk']="NO";
        }
       }
     json_output($resarray['status'],$resarray);  
   }
}