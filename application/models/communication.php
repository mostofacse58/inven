<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Communication extends CI_Controller{
    

    function send($emailaddress,$subject,$message){
        // Load PHPMailer library
        //$emailaddress='golam.mostofa58@gmail.com';
        if($emailaddress=='atiqul.islam1@bdventura.com')  $emailaddress='atiqul.islam@bdventura.com';
        if($emailaddress=='shurid.khandokar2@bdventura.com')  $emailaddress='shurid.khandokar@bdventura.com';

        $this->load->library('phpmailer_lib');
        $this->load->library('parser');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        // SMTP configuration
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host     = 'mail.maatdrive.app';
        $mail->SMTPAuth = true;
        $mail->Username = 'mostofa@maatdrive.app';
        $mail->Password = 'GDG%$#24488';
        $mail->SMTPSecure = 'tls';
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
        $mail->addBCC('golam.mostofa@bdventura.com');
        // Email subject
        $mail->Subject = $subject;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = $message;
        $mail->Body = $mailContent;
        
        // Send email
        if(!$mail->send()){
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            //echo 'Message has been sent';
        }
    }
    
}