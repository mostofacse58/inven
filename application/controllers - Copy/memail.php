<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memail extends CI_Controller{
    
    function  __construct(){
        parent::__construct();
    }
    
    function send(){
        $this->load->library('parser');
        $emailaddress=$this->input->get('emailaddress');
        $subject=$this->input->get('subject');
        $message=$this->input->get('message');
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        // SMTP configuration
        $mail->isSMTP();
        $mail->SMTPDebug = 1;
        $mail->Host     = 'mail.anjapex.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mostofa@anjapex.com';
        $mail->Password = 'GDG%$#24488';
        $mail->SMTPSecure = 'TLS';
        $mail->Port     = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsHTML(true);
        
        $mail->setFrom('it@vlmbd.com', 'VLMBD');
        $mail->addReplyTo('it@vlmbd.com', 'VLMBD');
        
        // Add a recipient
        $mail->addAddress($emailaddress);
        
        // Add cc or bcc 
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = $subject;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = $message;
        $mail->Body = $mailContent;
        
        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }
    }
    
}