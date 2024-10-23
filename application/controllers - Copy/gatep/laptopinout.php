<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laptopinout extends MY_Controller {
	function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/laptopinout_model');
     }
    function searchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Ckecking Laptop';
        $data['display']='gatep/laptopinout';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function search(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Ckecking Laptop';
        $data['info']=$this->laptopinout_model->checkingBarcode();
        if(count($data['info'])>0){
        $data['checkout']=$this->laptopinout_model->checkOutlaptop();
        if(count($data['checkout'])>0){
            $gatepass_id=$data['checkout']->gatepass_id;
            $laptop_id=$data['checkout']->laptop_id;
           ///////////////////////
            $datetimeold=$data['checkout']->gate_date_time;
            $currentdatetime=date('Y-m-d H:i:s');
            $date1Timestamp = strtotime($datetimeold);
            $date2Timestamp = strtotime($currentdatetime);
            $difference = $date2Timestamp - $date1Timestamp;
            $difference=$difference/60;
            if($difference>1){
                $data2['gate_in_date']=date('Y-m-d');
                $data2['gate_in_time']=date('h:i A');
                $data2['gate_in_date_time']=date('Y-m-d H:i:s');
                $data2['gatepass_status']=2;
                $this->db->where('gatepass_id', $gatepass_id);
                $this->db->update('gatepass_laptop',$data2);
                $data['chk']=2;
            }else{
                $data['chk']=3;
            }
           ///////////////////////
        }else{
            $data['checkin']=$this->laptopinout_model->checkINlaptop();
            ///////////////////////
            if(count($data['checkin'])>1){
                $laptop_id=$data['info']->laptop_id;
                $datetimeold=$data['checkin']->gate_in_date_time;
                $currentdatetime=date('Y-m-d H:i:s');
                $date1Timestamp = strtotime($datetimeold);
                $date2Timestamp = strtotime($currentdatetime);
                $difference = $date2Timestamp - $date1Timestamp;
                $difference=$difference/60;
                if($difference>1){
                    $no_count=$this->db->query("SELECT max(no_count) as counts FROM gatepass_laptop 
                      WHERE 1")->row('counts');
                    $data2['gatepass_no']=$this->session->userdata('short_code').'-'.date('Ymdhi').'-'.str_pad($no_count + 1, 4, '0', STR_PAD_LEFT);
                    $data2['no_count']=$no_count + 1;
                    $data2['laptop_id']=$laptop_id;
                    $data2['gatepass_status']=1;
                    $data2['user_id']=$this->session->userdata('user_id');
                    $data2['gatepass_date']=date('Y-m-d');
                    $data2['gatepass_time']=date('h:i A');
                    $data2['gate_date_time']=date('Y-m-d H:i:s');
                    $this->db->insert('gatepass_laptop',$data2);
                    $data['chk']=1;
                }else{
                    $data['chk']=4;
                }
            }else{
                $laptop_id=$data['info']->laptop_id;
                $no_count=$this->db->query("SELECT max(no_count) as counts FROM gatepass_laptop 
                      WHERE 1")->row('counts');
                $data2['gatepass_no']=$this->session->userdata('short_code').'-'.date('Ymdhi').'-'.str_pad($no_count + 1, 4, '0', STR_PAD_LEFT);
                $data2['no_count']=$no_count + 1;
                $data2['laptop_id']=$laptop_id;
                $data2['gatepass_status']=1;
                $data2['user_id']=$this->session->userdata('user_id');
                $data2['gatepass_date']=date('Y-m-d');
                $data2['gatepass_time']=date('h:i A');
                $data2['gate_date_time']=date('Y-m-d H:i:s');
                $this->db->insert('gatepass_laptop',$data2);
                $data['chk']=1;
            }
            
           ///////////////////////
        }
        
        }
        $data['display']='gatep/laptopinout';
        $this->load->view('admin/master',$data);
    } else {
           redirect("logincontroller");
    } 
    }
    function android(){
        $data['heading']='Ckecking Laptop';
        $data['info']=$this->laptopinout_model->checkingBarcode();
        if(count($data['info'])>0){
        $data['checkout']=$this->laptopinout_model->checkOutlaptop();
        if(count($data['checkout'])>0){
            $gatepass_id=$data['checkout']->gatepass_id;
            $laptop_id=$data['checkout']->laptop_id;
           ///////////////////////
            $datetimeold=$data['checkout']->gate_date_time;
            $currentdatetime=date('Y-m-d H:i:s');
            $date1Timestamp = strtotime($datetimeold);
            $date2Timestamp = strtotime($currentdatetime);
            $difference = $date2Timestamp - $date1Timestamp;
            $difference=$difference/60;
            if($difference>1){
                $data2['gate_in_date']=date('Y-m-d');
                $data2['gate_in_time']=date('h:i A');
                $data2['gate_in_date_time']=date('Y-m-d H:i:s');
                $data2['gatepass_status']=2;
                $this->db->where('gatepass_id', $gatepass_id);
                $this->db->update('gatepass_laptop',$data2);
                $data['chk']=2;
            }else{
                $data['chk']=3;
            }
           ///////////////////////
        }else{
            $data['checkin']=$this->laptopinout_model->checkINlaptop();
            ///////////////////////
            if(count($data['checkin'])>1){
                $laptop_id=$data['info']->laptop_id;
                $datetimeold=$data['checkin']->gate_in_date_time;
                $currentdatetime=date('Y-m-d H:i:s');
                $date1Timestamp = strtotime($datetimeold);
                $date2Timestamp = strtotime($currentdatetime);
                $difference = $date2Timestamp - $date1Timestamp;
                $difference=$difference/60;
                if($difference>1){
                    $no_count=$this->db->query("SELECT max(no_count) as counts FROM gatepass_laptop 
                      WHERE 1")->row('counts');
                    $data2['gatepass_no']=$this->session->userdata('short_code').'-'.date('Ymdhi').'-'.str_pad($no_count + 1, 4, '0', STR_PAD_LEFT);
                    $data2['no_count']=$no_count + 1;
                    $data2['laptop_id']=$laptop_id;
                    $data2['gatepass_status']=1;
                    $data2['user_id']=$this->session->userdata('user_id');
                    $data2['gatepass_date']=date('Y-m-d');
                    $data2['gatepass_time']=date('h:i A');
                    $data2['gate_date_time']=date('Y-m-d H:i:s');
                    $this->db->insert('gatepass_laptop',$data2);
                    $data['chk']=1;
                }else{
                    $data['chk']=4;
                }
            }else{
                $laptop_id=$data['info']->laptop_id;
                $no_count=$this->db->query("SELECT max(no_count) as counts FROM gatepass_laptop 
                      WHERE 1")->row('counts');
                $data2['gatepass_no']=$this->session->userdata('short_code').'-'.date('Ymdhi').'-'.str_pad($no_count + 1, 4, '0', STR_PAD_LEFT);
                $data2['no_count']=$no_count + 1;
                $data2['laptop_id']=$laptop_id;
                $data2['gatepass_status']=1;
                $data2['user_id']=$this->session->userdata('user_id');
                $data2['gatepass_date']=date('Y-m-d');
                $data2['gatepass_time']=date('h:i A');
                $data2['gate_date_time']=date('Y-m-d H:i:s');
                $this->db->insert('gatepass_laptop',$data2);
                $data['chk']=1;
            }
            
           ///////////////////////
        }
        
        }
        $data['display']='gatep/laptopinout';
        $this->load->view('admin/master',$data);
    }


 }