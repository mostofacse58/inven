<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configcontroller extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('config_model');
     }
	public function changeCompanyInfo(){
		if ($this->session->userdata('user_id')) {
		$data['heading']='Change Company Info';
		$data['display']='admin/update_company_info';
		$this->load->view('admin/master',$data);
		} else {
           redirect("logincontroller");
        }
	}

	public function saveInfo(){
       if ($this->session->userdata('user_id')) {
        $this->form_validation->set_rules("company_name", "Company Name", "trim|required|max_length[50]|xss_clean");
        if($this->input->post('website')&&$this->input->post('website')!=''):
            $this->form_validation->set_rules("website", "Website", "trim|callback_validUrlFormat|max_length[255]|xss_clean");
        endif;
        $this->form_validation->set_rules("address", "Address", "trim|required|max_length[255]|xss_clean");
        $this->form_validation->set_rules("short_name", "Short Code", "trim|required|max_length[20]|xss_clean");
        $this->form_validation->set_rules("phone", "Phone", "trim|required|callback_valid_phone|max_length[50]|xss_clean");
        $this->form_validation->set_rules("email_address", "Email Address", "trim|required|valid_email|max_length[50]|xss_clean");
        if ($this->form_validation->run() == TRUE) {
           
            if($_FILES['logo']['name']!=""){
                $config['upload_path'] = './logo/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|swf|JPG';
                $config['max_size'] = '10000';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload("logo")) {
                    $upload_info = $this->upload->data();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './logo/' . $upload_info['file_name'];
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = '334';
                    $config['height'] = '105';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $existing_logo = $this->db->query("select * from company_info where id='1'")->row();

                    if (file_exists("./logo/" . $existing_logo->logo)) {
                        unlink("./logo/" . $existing_logo->logo);
                    }

                    $data['logo']=$upload_info['file_name'];
                }else{
                    
                    $data['file_error']=$this->upload->display_errors();
                    $data['display']='admin/update_company_info';
                    $this->load->view('admin/master',$data);
                }
                }
            $data['company_name'] = $this->input->post("company_name");
            $data['short_name'] =$this->input->post("short_name");
            $data['address'] =$this->input->post("address");
            $data['website'] =$this->input->post("website");
            $data['phone'] =$this->input->post("phone");
            $data['email_address'] = $this->input->post("email_address");
            $this->db->where('id','1');
            $this->db->update('company_info', $data);
            $this->session->set_userdata('exception', "Company Information has been updated successfully!");
            redirect('configcontroller/changeCompanyInfo');
        } else{
            $data['heading']='Change Company Info';
		    $data['display']='admin/update_company_info';
            $this->load->view('admin/master',$data);
        } } else {
           redirect("logincontroller");
        }


    }
     function valid_url_format($str) {
        $pattern = "@^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9/][a-z0-9\-/]*$@i";
        if (!preg_match($pattern, $str)) {
            $this->form_validation->set_message('valid_url_format', 'URL should be valid.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
//////////////////////////////VALID Name///////////////
    function valid_name($str) {
        $pattern = "@^([a-zA-Z\s\.])*$@i";
        if (!preg_match($pattern, $str)) {
            $this->form_validation->set_message('valid_name', 'Character may contain alphabate,space and dot');
            return FALSE;
        } else {
            return TRUE;
        }
    }
//////////////////////////////VALID Phone///////////////

    function valid_phone($str){
        $pattern="@^(\+)?[0-9]*$@i";
        if(!preg_match($pattern,$str)){
            $this->form_validation->set_message('valid_phone','Phone number may contain only + and number');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
///////////////////////UNIQ EMAIL CHECKING CALLBACK FUNCTION//////////////////
    function unique_email($email,$id){
        $data=$this->db->query("select * from user where email_address='$email' AND id!='$id'");
        $count=$data->num_rows();
        if($count>0){
            $this->form_validation->set_message('unique_email', 'The email already exists');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

/////////////////////// UNIQ EMAIL CHECKING CALLBACK FUNCTION ENDS HERE//////////////////
///////////////////////CUSTOMER UNIQ EMAIL CHECKING CALLBACK FUNCTION//////////////////
    function customer_unique_email($email,$id){
        $data=$this->db->query("select * from customer_info where email_address='$email' AND id!='$id'");
        $count=$data->num_rows();
        if($count>0){
            $this->form_validation->set_message('customer_unique_email', 'The email already exists');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
        function checksEmail($str,$id){
        $row=$this->db->query("SELECT * FROM user WHERE id='$id' AND email_address='$str'")->num_rows();
        if($row<1){
            $this->form_validation->set_message('checksEmail', 'Email Address does not exists');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function checksPassword($str,$id){
        $row=$this->db->query("SELECT * FROM user WHERE id='$id' AND password='$str'")->num_rows();
        if($row<1){
            $this->form_validation->set_message('checksPassword', 'Current Password does not match');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function validUrlFormat($str) {
        if($str!=""):
            $pattern = "@^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9/][a-z0-9\-/]*$@i";
            if (!preg_match($pattern, $str)) {
                $this->form_validation->set_message('validUrlFormat', 'URL should be valid.');
                return FALSE;
            } else {
                return TRUE;
            }
        endif;
    }
    function userList(){
    	if ($this->session->userdata('user_id')) {
		$data['heading']='User List';
		$data['userlist']=$this->config_model->userList();
		$data['display']='admin/userList';
		$this->load->view('admin/master',$data);
		} else {
           redirect("logincontroller");
        }

    }
public function addUserForm($id=null){
    if ($this->session->userdata('user_id')) {
        $data['heading'] = "Add User";
        $data['postlist']=$this->look_up_model->postList();
        $data['dlist']=$this->look_up_model->departmentList();
         ///////////
        $department_id=$this->session->userdata('department_id');
        if($this->session->userdata('user_type')==1){
        $menu_info = $this->db->query("SELECT * FROM sys_menu 
            ORDER BY menu_id ASC ")->result();
        }else{
        $menu_info = $this->db->query("SELECT * FROM sys_menu 
            WHERE department_id=$department_id OR department_id=0
            ORDER BY menu_id ASC ")->result();  
        }
        foreach ($menu_info as $items) {
            $menu['parents'][$items->parent][] = $items;
        }
        $data['result'] = $this->buildChild(0, $menu);
        if (!empty($id)) {
            $data['heading'] = "Edit User";
            $data['user_id'] = $id;
            $data['user_info'] = $this->config_model->get_user_info($data['user_id']);
        } else {
            $data['user_id'] = null;
            $data['user_info'] = array();
        }
        if ($data['user_info']) {
            $role = $this->config_model->SELECT_user_roll_by_employee_id($data['user_id']);
            if ($role) {
                foreach ($role as $value) {
                    $result[$value->menu_id] = $value->menu_id;
                }
                $data['roll'] = $result;
            }
        }
        ////////////////////
        $data['display']='admin/add_new_user';
        $this->load->view('admin/master',$data);
        } else {
            redirect("admin/index");
        }
    }
    public function buildChild($parent, $menu) {
        if (isset($menu['parents'][$parent])) {
            foreach ($menu['parents'][$parent] as $ItemID) {
                if (!isset($menu['parents'][$ItemID->menu_id])) {
                    $result[$ItemID->menu_label] = $ItemID->menu_id;
                }
                if (isset($menu['parents'][$ItemID->menu_id])) {
                    $result[$ItemID->menu_label][$ItemID->menu_id] = self::buildChild($ItemID->menu_id, $menu);
                }
            }
        }
        return $result;
    }

    ////////////////////////////////////////////////
    ////////// SAVE USER
    ////////////////////////////////////////////////
    public function  saveUser($id=FALSE){
        if($this->session->userdata('user_id')){
            $data=array();
            if($_FILES['photo']['name']!=""){
                $config['upload_path'] = './asset/photo/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG';
                $config['max_size'] = '30000';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload("photo")){
                    $upload_info = $this->upload->data();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './asset/photo/' . $upload_info['file_name'];
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = '200';
                    $config['height'] = '200';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $data['photo']=$upload_info['file_name'];
                }
            }

            $data['user_name']=$this->input->post('user_name');
            $data['email_address']=$this->input->post('email_address');
            $data['employee_id_no']=$this->input->post('employee_id_no');
            $data['mobile']=$this->input->post('mobile');
            $data['pa_limit']=$this->input->post('pa_limit');
            $data['post_id']=$this->input->post('post_id');
            $data['department_id']=$this->input->post('department_id');
            $data['org_id']=$this->session->userdata('org_id');
            $data['login_token']=substr(sha1(time()), 0, 50);
            
            if($this->input->post('update')=='YES'){
            $data['update']=$this->input->post('update');
            }else{
               $data['update']='NO'; 
            }
            if($this->input->post('delete')=='YES'){
            $data['delete']=$this->input->post('delete');
            }else{
               $data['delete']='NO'; 
            }
            if($this->input->post('password')!=''&&$this->input->post('password')!=0){
              $data['password']=md5($this->input->post('password'));  
            }
            if($id==FALSE){
            $data['password']=md5($this->input->post('password'));
            $this->db->insert('user',$data);
            $user_id=$this->db->insert_id();
            $this->session->set_userdata('exception','User has been added successfully, an email has been sent to user\'s email containing an auto generated password and login url.  ');
            $mdata['menu_id'] = 1;
            $mdata['user_id'] = $user_id;
            $this->db->insert('sys_user_role',$mdata);
            }else{
            $this->db->where('id', $id);
            $this->db->update('user',$data);
            $this->db->delete("sys_user_role",["user_id"=>$id]);
            $user_id=$id;
            $this->session->set_userdata('exception','User information has been updated successfully');
            }
            $menu = $this->input->post('menu');

            if (!empty($menu)) {
                foreach ($menu as $value) {
                    $mdata['menu_id'] = $value;
                    $mdata['user_id'] = $user_id;
                    $this->db->insert('sys_user_role',$mdata);
            }}
            if($id==FALSE){
            ////////////////////EMAIL SECTION///////////////////
            $this->load->library('email');
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $this->email->initialize($config);
            $this->email->from("golam.mostofa@bdventura.com","VLMBD LTD");
            $this->email->to($this->input->post('email_address'));
            $this->email->subject("Keep Your Password Safely");

            $message='<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Email Template</title></head><body><div style="background-color:#F7F2F7;width:650px;padding:30px 0px;"><div style="margin:0px 30px;font-family:arial;background-color:#fff;border:5px solid #0c5889;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;padding:0px;color:#666;">';
            $message.='<div style="padding:10px;font-size:22px;text-align:center;color:#0c5889;font-family:arial;border-bottom:1px solid #999;"><h2 style="margin:0px;">Registration Password</h2></div><div style="width:100%;padding:10px;margin-bottom:0px;padding-bottom:10px;">';
            $message.='<p align="center">Congratulation '.$this->input->post('user_name').'! You have been registered successfully.</p>';
            $message.='<p align="center" style="margin-bottom:20px;">Your password is : <b style="background-color:#e2e2e2;padding:6px 10px;font-size:22px;border-radius:4px;">'.$this->input->post('password').'</b>. Please keep it safely or change later.</p>';
            $message.='<p align="center"><a href="'.base_url().'logincontroller" style="background-color:#0c5889;text-align:center;color:#fff;font-family:arial;font-size:20px;padding:6px 20px;text-decoration:none;border:1px solid blue;border-radius:6px;">Login</a> </p>';
            $message.='</div>';
            $message.='<div style="padding:10px;text-align:center;border-top:1px solid #999;"><p style="margin:0px;">Password has been generated by:</p><p style="margin:0px;"><b>vlmbd</b></p>Ventura IT By <a href="http://vlmbd.com" align="center">VLMBD</a></div></div></div></body></html>';
            $this->email->message($message);
            $this->email->send();
            }
            /////////////////////////////////////////////////
            redirect("configcontroller/userList");
            }else{
            redirect("logincontroller");
            }
    }  
     public function deactivateUser($id=null) {
        $data1=array('status'=>'DEACTIVATED');
        $this->db->where('id',$id);
        $this->db->update('user',$data1);
        $this->session->set_userdata('exception','The user has been deactivated');
        redirect("configcontroller/userList");
    }
    ////////////////////////////////////////////////
    ////////// ACTIVATE USER
    ////////////////////////////////////////////////
    public function activateUser($id=null) {
        $data1=array('status'=>'ACTIVE');
        $this->db->where('id',$id);
        $this->db->update('user',$data1);
        $this->session->set_userdata('exception','The user has been activated');
        redirect("configcontroller/userList");
    }
    ////////////////////////////////////////////////
    ////////// Reset PAss USER
    ////////////////////////////////////////////////
    public function resetpassworduser($id=null) {
        $info = $this->config_model->get_user_info($id);
        $data1 = array(
            'password' => md5(1234567),
            'pw_change_date' => date('Y-m-d'),
            'pre_password' => $info->password,
            'try_wrong_password' => 0
        );
        $this->db->where('id',$id);
        $this->db->update('user',$data1);
        $this->session->set_userdata('exception','Password Reset successfully');
        redirect("configcontroller/userList");
      }
     public function deleteUser($id){
        $this->db->delete("user",["id"=>$id]);
         $this->session->set_userdata('exception','User has been deleted successfully');
        redirect("configcontroller/userList");
    }
    function postList(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Designation List';
        $data['postlist']=$this->config_model->postList();
        $data['display']='admin/postList';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

     function addPostForm() {
        if ($this->session->userdata('user_id')) {
            $data['heading']='Add New Designation';
            $data['display']='admin/add_new_post';
            $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function editPostForm($post_id) {
        if ($this->session->userdata('user_id')) {
            $data['heading']='Edit Designation';
            $data['post_info'] = $this->db->query("select * from post where post_id=$post_id")->row();
            $data['display']='admin/edit_post';
            $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    public function  savePost($post_id=FALSE){
        if($this->session->userdata('user_id')){
            $this->form_validation->set_rules('post_name','Designation Name','trim|required|callback_valid_name|max_length[60]|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $check=$this->config_model->savePost($post_id);
                if($check && !$post_id){
               $this->session->set_userdata('exception','Designation has been Saved successfully');
               }elseif($check&& $post_id){
                   $this->session->set_userdata('exception','Designation has been Update successfully');
               }else{
                  $this->session->set_userdata('exception','Designation does not Submitted');
                }
             redirect("configcontroller/postList");
            }else{
                if($post_id){
                $data['heading']='Edit Designation';
                $data['post_info'] = $this->db->query("select * from post where post_id=$post_id")->row();
                $data['display']='admin/edit_post';
                $this->load->view('admin/master',$data);
               
              }else{
                $data['heading']='Add New Designation';
                $data['display']='admin/add_new_post';
                $this->load->view('admin/master',$data);
              }
           
            }
        }else{
           redirect("logincontroller");
        }
    }
     public function deletePost($post_id){
        $this->db->delete("post",array("post_id"=>$post_id));
         $this->session->set_userdata('exception','Post has been deleted successfully');
        redirect("configcontroller/postList");
    }

     function changePassword(){
      if($_POST){
        $this->form_validation->set_rules('password','Old Password','required|min_length[4]|trim|xss_clean');
        $this->form_validation->set_rules('new_password','New Password','required|min_length[4]|trim|xss_clean');
        $this->form_validation->set_rules('con_password','Confirm Password','trim|min_length[4]|xss_clean');
        if ($this->form_validation->run()==TRUE) { 
            $nepass=md5($this->input->post('password'));
            if($nepass==$this->session->userdata('password')){
          if($this->input->post('new_password')==$this->input->post('con_password')){
          $session_data = array(
                  'password' => md5($this->input->post('con_password')),
                  'pw_change_date' => date('Y-m-d'),
                  'pre_password' => $this->session->userdata('password')
              );
          $id=$this->session->userdata('user_id');
          $this->db->WHERE('id',$id);
          $this->db->update('user',$session_data);
          $this->session->set_userdata($session_data);
          $this->session->set_userdata('exception', "Change Password is successfully"); 
        }else{
          $this->session->set_userdata('exceptionw', "New and Confirm Password does't match!"); 
        }}else{
          $this->session->set_userdata('exceptionw', "Old Password does't match!");  
        }
      }
      }
      $data['heading']='Change Password';
      $data['display']='admin/changepassword';
      $this->load->view('admin/master',$data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */