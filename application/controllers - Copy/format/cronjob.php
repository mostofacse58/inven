<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {
  function __construct() {
    parent::__construct();
  }

  
function pendingpi(){
  $this->load->model('communication');
  $data['plist']=$this->db->query("SELECT p.*,d.department_name 
    FROM pi_master p
    INNER JOIN department_info d ON(d.department_id=p.department_id)  
    WHERE p.pi_status=6 
    ORDER BY p.department_id ASC,p.pi_no ASC")->result();
  if(count($data['plist'])>0){
    $emailaddress="malik.ma@ms.hkthewell.com";
    $subject="PI Approval Notification";
    $message=$this->load->view('for_approval_email', $data,true); 
    $this->communication->send($emailaddress,$subject,$message);

    }
  }

  
}