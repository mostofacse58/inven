<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logincontroller extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('login_model');
  }
    public function index() {
    if($this->session->userdata('loggedinventory')==TRUE){
      redirect('dashboard'); 
      }else{
      $data['title']='Login';
      $this->load->view('login',$data);
    }
  }
    public function logInCheck(){
      $this->form_validation->set_rules('email_address', 'Email Address', 'required|max_length[50]');
      $this->form_validation->set_rules('password', 'Password', 'required|max_length[50]');
      if ($this->form_validation->run() == FALSE) {
          $data['title']='Login';
          $this->load->view('login', $data);
        } else {
            $email_address = $this->input->post('email_address');
            $email_address = str_replace(' ', '', $email_address);
            $email_address = strtolower($email_address);  
            $password = $this->input->post('password');
            $trycheck = $this->login_model->trycheck($email_address);
            if(is_null($trycheck)&&$trycheck->try_wrong_password>=4){
              $this->session->set_userdata('exception', "Your account is locked. due to a 4 times password wrong!!");
                redirect('logincontroller');
            }
            $checkUser = $this->login_model->checkValidUser($email_address, $password);
            if ($checkUser) {
                if($checkUser->status=='DEACTIVATED'):
                  $this->session->set_userdata('exception', "Sorry, your account has been deactivated for some reason.");
                     redirect('logincontroller');
                else:
                    $pass['try_wrong_password']=0;
                    $this->db->where('email_address', $email_address);
                    $this->db->update('user',$pass);
                $cominfo = $this->db->query("SELECT * from company_info where id='1'")->row();
                $sesdata = array();
                $localIP = getHostByName(getHostName());  $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $this->session->set_userdata("computer_id", $localIP);
                $this->session->set_userdata("pc_name", $host_name);
                $this->session->set_userdata("user_id", $checkUser->id);        
                $this->session->set_userdata("org_id", $checkUser->org_id);
                $this->session->set_userdata("user_name", $checkUser->user_name);
                $this->session->set_userdata("medical_yes", $checkUser->medical_yes);
                $this->session->set_userdata("org_name", $checkUser->org_name);
                $this->session->set_userdata("stock_holder", $checkUser->stock_holder);
                $this->session->set_userdata("mlocation_id", $checkUser->mlocation_id);
                $this->session->set_userdata("post_name", $checkUser->post_name);
                $this->session->set_userdata("user_type", $checkUser->super_user);
                $this->session->set_userdata("department_id", $checkUser->department_id);
                $this->session->set_userdata("department_name", $checkUser->department_name);
                $this->session->set_userdata("login_token", $checkUser->login_token);
                $this->session->set_userdata("dept_shortcode", $checkUser->dept_shortcode);
                $this->session->set_userdata("user_cat", $checkUser->user_cat);
                $this->session->set_userdata("password", $checkUser->password);
                $this->session->set_userdata("email_address", $checkUser->email_address);
                $this->session->set_userdata("photo", $checkUser->photo);     
                $this->session->set_userdata("bd_cn_type", $checkUser->bd_cn_type);               
                $this->session->set_userdata("update", $checkUser->update);
                $this->session->set_userdata("delete", $checkUser->delete);
                $this->session->set_userdata("logo", $cominfo->logo);
                $this->session->set_userdata("company_name", $cominfo->company_name);
                $this->session->set_userdata("caddress", $cominfo->address);
                $this->session->set_userdata("cemail_address", $cominfo->email_address);
                $this->session->set_userdata("website", $cominfo->website);
                $this->session->set_userdata("loggedinventory",TRUE);
                $user_id=$checkUser->id;
                $checkdispose = $this->db->query("SELECT sys_user_role.*,sys_menu.*
                FROM sys_user_role
                INNER JOIN sys_menu
                ON sys_user_role.menu_id=sys_menu.menu_id
                WHERE sys_user_role.user_id=$user_id 
                AND sys_menu.menu_indicator='Dispose_management'")->result();
                if(is_array($checkdispose)){
                    $this->session->set_userdata("checkdispose", 1);
                }else{
                    $this->session->set_userdata("checkdispose", 2);
                }
                $clist=$this->db->query("SELECT * FROM currency_convert_table")->result();
                foreach ($clist as $rows) {
                  $this->session->set_userdata("$rows->currency-$rows->in_currency", $rows->convert_rate);
                }
                // if (isset($_SESSION['redirect_to']))
                //     redirect($_SESSION['redirect_to']);
                // else
                redirect_back();
                endif;
            } else {
                $data['title']='Login';
                $this->session->set_userdata('exception', "Email Address or Password is not valid!");
                $this->db->set('try_wrong_password', "try_wrong_password+1", FALSE);
                $this->db->where('email_address', $email_address);
                $this->db->update('user');
                /////////////
                redirect('logincontroller');
            }
        }
    }

    public function forgotPassword(){
      $data['heading']='Forgot Password';
      $this->load->view('forgotpassword',$data);
     }
    public function reset(){
        $this->load->model('communication');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email_address', 'Email Address', 'required|max_length[50]|valid_email');
        if ($this->form_validation->run() == FALSE){
           $data['heading']='Forgot Password';
           $this->load->view('forgotpassword',$data);
        }else{ 
           $email_address = $this->input->post('email_address');
           $checkUser = $this->login_model->checkValidEmail($email_address);
           if ($checkUser) {
            $randomPswd=strtoupper(substr(md5('VLMBD.COM'.mt_rand(0,100)),0,8));
            $pass['password']=md5($randomPswd);
            $pass['try_wrong_password']=0;
            $pass['pw_change_date']=date('Y-m-d');
            $this->db->where('email_address', $email_address);
            $this->db->update('user',$pass);
            ////////////////////EMAIL SECTION///////////////////
            $message='<!DOCTYPE html><html lang="en"><head>
            <meta charset="UTF-8"></head>
            <body><div style="background-color:#F7F2F7;width:743px;padding:30px 0px;">
            <div style="margin:0px 30px;font-family:arial;background-color:#fff;border:5px solid #747999;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;padding:0px;color:#666;">';
            $message.='<div style="padding:10px;font-size:18px;text-align:center;color:#747999;font-family:arial;border-bottom:1px solid #999;">
            <h2 style="margin:0px;">Your password has been reset by your request</h2></div>
            <div style="width:100%;padding:10px;margin-bottom:0px;padding-bottom:10px;">';
            $message.='<p align="center" style="margin-bottom:20px;">Your reset password is : <b style="background-color:#e2e2e2;padding:6px 10px;font-size:22px;border-radius:4px;">'.$randomPswd.'</b>. Please keep it safely, you can also change it later.</p>';
            $message.='<p align="center"><a href="'.base_url().'" style="background-color:#747999;text-align:center;color:#fff;font-family:arial;font-size:20px;padding:6px 20px;text-decoration:none;border:1px solid #747999;border-radius:5px">Login</a> </p>';
            $message.='</div>';
            $message.='<div style="padding:10px;text-align:center;border-top:1px solid #999;"><p style="margin:0px;">Password has been generated by:</p>
            <p style="margin:0px;"><a href="http://www.vlmbd.com" target="_blank">vlmbd</a></b></p></div></div></div></body></html>';
         
            $this->communication->send($email_address,'Password has been reset',$message);
                               /////////////////////////////////////////////////
            $this->session->set_userdata('exceptionw',"Your password has been reset successfully, Please check your Email!!!");
            redirect("logincontroller");
            }else{
                   $this->session->set_userdata('exception', "Email Address not found in the User List!");
                   redirect('logincontroller/forgotPassword');
            }

           }
        }
    public function logout(){
    if ($this->session->userdata('user_id')) {
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('role');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('login');
            $this->session->sess_destroy();
            redirect('logincontroller/index');
        } else {
            redirect("logincontroller/index","refresh");
        }
  }
  
  public function login_by_token($_token){
        $checkUser=$this->db->query("SELECT u.*,o.org_name,p.post_name,
        d.department_name,d.stock_holder,d.dept_shortcode
        FROM user u 
        LEFT JOIN org_info o ON(u.org_id=o.org_id) 
        LEFT JOIN post p ON(u.post_id=p.post_id)
        LEFT JOIN department_info d ON(u.department_id=d.department_id)
        WHERE  1 and 
        u.login_token='$_token'")->row();

        if($checkUser->status=='DEACTIVATED'):
            $this->session->set_userdata('exception', "Sorry, your account has been deactivated for some reason.");
            redirect('logincontroller');
        else:
            $cominfo = $this->db->query("SELECT * from company_info where id='1'")->row();
            $sesdata = array();
            $localIP = getHostByName(getHostName());  $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $this->session->set_userdata("computer_id", $localIP);
            $this->session->set_userdata("pc_name", $host_name);
            $this->session->set_userdata("user_id", $checkUser->id);
            $this->session->set_userdata("org_id", $checkUser->org_id);
            $this->session->set_userdata("user_name", $checkUser->user_name);
            $this->session->set_userdata("medical_yes", $checkUser->medical_yes);
            $this->session->set_userdata("org_name", $checkUser->org_name);
            $this->session->set_userdata("stock_holder", $checkUser->stock_holder);
            $this->session->set_userdata("post_name", $checkUser->post_name);
            $this->session->set_userdata("user_type", $checkUser->super_user);
            $this->session->set_userdata("department_id", $checkUser->department_id);
            $this->session->set_userdata("department_name", $checkUser->department_name);
            $this->session->set_userdata("login_token", $checkUser->login_token);
            $this->session->set_userdata("dept_shortcode", $checkUser->dept_shortcode);
            $this->session->set_userdata("user_cat", $checkUser->user_cat);
            $this->session->set_userdata("password", $checkUser->password);
            $this->session->set_userdata("email_address", $checkUser->email_address);
            $this->session->set_userdata("photo", $checkUser->photo);
            $this->session->set_userdata("bd_cn_type", $checkUser->bd_cn_type);
            $this->session->set_userdata("update", $checkUser->update);
            $this->session->set_userdata("delete", $checkUser->delete);
            $this->session->set_userdata("logo", $cominfo->logo);
            $this->session->set_userdata("company_name", $cominfo->company_name);
            $this->session->set_userdata("caddress", $cominfo->address);
            $this->session->set_userdata("cemail_address", $cominfo->email_address);
            $this->session->set_userdata("website", $cominfo->website);
            $this->session->set_userdata("loggedinventory",TRUE);
            $user_id=$checkUser->id;
            $checkdispose = $this->db->query("SELECT sys_user_role.*,sys_menu.*
                FROM sys_user_role
                INNER JOIN sys_menu
                ON sys_user_role.menu_id=sys_menu.menu_id
                WHERE sys_user_role.user_id=$user_id AND sys_menu.menu_indicator='Dispose_management'")->result();
            if(count($checkdispose)>0){
                $this->session->set_userdata("checkdispose", 1);
            }else{
                $this->session->set_userdata("checkdispose", 2);
            }
          
            redirect('dashboard');
        endif;

    }

}

