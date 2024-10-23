
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup extends CI_Controller {
	 function __construct() {
      parent::__construct();
    }
public  function index(){
       ini_set('memory_limit', '1024M');
	   $this->load->dbutil();   
       $backup =& $this->dbutil->backup();  
       $this->load->helper('file');
       $name=date('Y-m-d H i s');
       write_file("bb/$name.zip", $backup);
         ////////////////////EMAIL SECTION///////////////////
        // $name.='.zip';
        // $this->load->library('email');
        // $config['protocol'] = 'mail';
        // //$config['mailpath'] = '/usr/sbin/sendmail';
        // $config['mailtype'] = 'html';
        // $config['charset'] = 'utf-8';
        // $config['wordwrap'] = TRUE;
        // $this->email->initialize($config);
        // $this->email->from("info@bstibillingsoft.org","BSTI");
        // $this->email->to("golam.mostofa58@gmail.com");
        // $this->email->subject("Database Backup date $name");
        // $message='<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
        // </head><body>
        // <div style="background-color:#F7F2F7;width:100%;padding:30px 0px;">
        // Please do not Share this file</div></body></html>';
        // $this->email->message($message);
        // $this->email->attach("assets/$name");
        // $chk=$this->email->send();
        // //////////////


    }
    // public function mailsend()
    // {
    // 	    $this->load->library('email');
    //         $config['protocol'] = 'sendmail';
    //         $config['mailpath'] = '/usr/sbin/sendmail';
    //         $config['charset'] = 'iso-8859-1';
    //         $config['wordwrap'] = TRUE; 
    //         $this->email->initialize($config);

    //         $this->email->from('info@bstibillingsoft.org', 'Your Name');
    //         $this->email->to('golam.mostofa58@gmail.com'); 
    //         $this->email->subject('Email Test');
    //         $this->email->message('Testing the email class.');  

    //         $this->email->send();

    //         echo $this->email->print_debugger();


    // }
}