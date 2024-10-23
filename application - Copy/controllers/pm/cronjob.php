<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {
  function __construct() {
	  parent::__construct();
  }

 	
function pendingpm(){
  $this->load->model('communication');
  $date=date('Y-m-d');
  $date7 = date('Y-m',strtotime($date." +7 days"));
  $plist=$this->db->query("SELECT pm.*,
      u.email_address as approved_email_address
      FROM  pm_master pm 
      LEFT JOIN user u ON(u.id=pm.user_id)
      WHERE pm.pm_status='Pending' AND pm.pm_date='$date7'
      GROUP BY pm.pm_date")->result();
  foreach ($plist as  $value) {
    $user_id=$value->user_id;
    $data['lists']=$this->db->query("SELECT pm.*
      FROM  pm_master pm 
      WHERE pm.pm_status='Pending'  AND pm.pm_date='$date7' 
      AND user_id=$user_id
      ORDER BY pm.tpm_code  ASC")->result();

      /////////////////////////////
      $emailaddress=$value->approved_email_address;
      $subject="PM Notification for Asset.";
      $message=$this->load->view('pm/email_body1', $data,true); 
      $this->communication->send($emailaddress,$subject,$message);
    }
   $plist=$this->db->query("SELECT pm.*,
      u.email_address as approved_email_address
      FROM  pm_master pm 
      LEFT JOIN user u ON(u.id=pm.user_id)
      WHERE pm.pm_status='Pending' AND pm.pm_date='$date'
      GROUP BY pm.pm_date")->result();
  foreach ($plist as  $value) {
    $user_id=$value->user_id;
    $data['lists']=$this->db->query("SELECT pm.*
      FROM  pm_master pm 
      WHERE pm.pm_status='Pending'  AND pm.pm_date='$date' 
      AND user_id=$user_id
      ORDER BY pm.tpm_code  ASC")->result();

      /////////////////////////////
      $emailaddress=$value->approved_email_address;
      $subject="PM Notification for Asset.";
      $message=$this->load->view('pm/email_body2', $data,true); 
      $this->communication->send($emailaddress,$subject,$message);
    }

    echo "success";
    

  }

	
}