<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tpmapi extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('tpmapi_model');
     }

    function search(){
        $resarray=array();
        $resarray['status']=200;
        $resarray['englishname']=' ';
        $resarray['chinaname']=' ';
        $resarray['tpmcode']=' ';
        $resarray['venturacode']=' ';
        $resarray['lineno']=' ';
        $resarray['productmodel']=' ';
        $resarray['lastassigndate']=' ';
        $resarray['lastid']=' ';
        $resarray['chk']='NO';
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'POST'){
            $resarray['chk']="NO";
        }else{
        $params = $_REQUEST;
        $sn_no = $params['sn_no'];
        $sn_no=str_replace("%20", " ", $sn_no);
        $sn_no=strtoupper($sn_no);
        $info=$this->tpmapi_model->search($sn_no);
        if(count($info)>0){
            $machinestatus=CheckStatus($info->machine_status);
            $resarray['englishname']=$info->product_name;
            $resarray['chinaname']=$info->china_name;
            $resarray['tpmcode']=$info->tpm_serial_code;
            $resarray['venturacode']=$info->ventura_code;
            $resarray['lineno']=$info->to_location_name."($machinestatus)";
            $resarray['productmodel']=$info->product_code;
            $resarray['lastassigndate']=$info->assign_date_time;
            $resarray['lastid']=$info->product_status_id;
            $resarray['chk']='YES';
        }else{
          $resarray['chk']="NO";
        }
       }
     json_output($resarray['status'],$resarray);  
   }
   function save(){
        $returnarray=array();
        $returnarray['status']=200;

        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'POST'){
            $params = $_REQUEST;
            $ventura_code=$params['venturacode'];
            $returnarray['ventura_code']=$ventura_code;
            $info=$this->db->query("SELECT pd.*
              FROM  product_detail_info pd 
              WHERE pd.ventura_code='$ventura_code' ")->row();
            $froml=$params['fromlocation'];
            $larray=explode("(",$froml);

            $inarray['product_detail_id']= $info->product_detail_id;
            $inarray['machine_status']= $params['status'];
            $inarray['assign_date']= date('Y-m-d');
            $inarray['assign_date_time']= date('Y-m-d H:i:s');
            //$inarray['release_date']=$params['release_date'];
            $inarray['department_id']= 12;
            $inarray['user_id']= 4;
            $inarray['from_location_name']=$larray[0];
            $inarray['to_location_name']= $params['tolocation'];
            $inarray['line_id']=getLineId($inarray['to_location_name']);
            $inarray['ventura_code']= $params['venturacode'];
            $inarray['jsonss']=json_encode($params);
            $this->db->insert('product_status_info',$inarray);
            ////////////////////////////////////
            $lastid= $params['lastid'];
            $tdata['takeover_date']=date('Y-m-d');
            $tdata['takeover_date_time']=date('Y-m-d H:i:s');
            $tdata['take_over_status']=2;
            $this->db->WHERE('product_status_id',$lastid);
            $this->db->update('product_status_info',$tdata);

            $product_detail_id=$info->product_detail_id;
            $data3['tpm_status']=$params['status'];
            $data3['line_id']=getLineId($inarray['to_location_name']); 
            $data3['assign_date']=date('Y-m-d');
            $data3['takeover_date']=date('Y-m-d');
            $this->db->WHERE('product_detail_id',$product_detail_id);
            $query=$this->db->update('product_detail_info',$data3);
            
        }
        //$returnarray['line_id']=$inarray['line_id'];
        json_output($returnarray['status'],$returnarray);
          
   }

    function location(){
        $resarray=array();
        $location=$this->tpmapi_model->location();
        $resarray['status']=200;
        $resarray['location']=$location;
        json_output($resarray['status'],$resarray);
    }
    function status(){
        $resarray = [
            "status" => 200,
            "data" => [
                ["name" => "USED", "value" => "1"],
                ["name" => "IDLE", "value" => "2"],
                ["name" => "UNDER SERVICE", "value" => "3"],
            ],
        ];
        json_output($resarray['status'],$resarray);
    }
}