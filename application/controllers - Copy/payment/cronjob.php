<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {
  function __construct() {
	  parent::__construct();
    
  }

 	
function pendingpa(){
  $this->load->model('communication');
  $approvalpa=$this->db->query("SELECT pm.*,u3.email_address as approved_email_address
      FROM  payment_application_master pm 
      LEFT JOIN user u3 ON(u3.id=pm.approved_by)
      WHERE pm.status=5 
      GROUP BY pm.approved_by")->result();
  foreach ($approvalpa as  $value) {
    $approved_by=$value->approved_by;
    $data['palist']=$this->db->query("SELECT pm.*,
      d.department_name
      FROM  payment_application_master pm 
      LEFT JOIN department_info d ON(pm.to_department_id=d.department_id)
      WHERE pm.status=5 AND pm.approved_by=$approved_by
      ORDER BY pm.payment_id  ASC")->result();

      /////////////////////////////
      $emailaddress=$value->approved_email_address;
      $subject="Payment Application Approval Notification";
      $message=$this->load->view('payment/applications_approved_email', $data,true); 
      $this->communication->send($emailaddress,$subject,$message);
      //////////////////////////////
      //$emailaddress='golam.mostofa@bdventura.com';
     // $this->communication->send($emailaddress,$subject,$message);
    }
    //echo "success";
    

  }

	
}