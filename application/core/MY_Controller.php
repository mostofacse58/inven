<?php
session_start();

/**
 * Description of MY_Controller
 *
 * @author Mostofa
 */
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('my_model');
        $this->load->model('config_model');
        $_SESSION['redirect_to'] = current_url();


    
        $uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);
        $uri3 = $this->uri->segment(3);
        if ($uri3) {
            $uri3 = '/' . $uri3;
        }
        $uriSegment = $uri1 . '/' . $uri2 . $uri3;
        //echo $uriSegment; exit();
        $menu_uri['menu_active_id'] = $this->my_model->select_menu_by_uri($uriSegment);
        $menu_uri['menu_active_id'] == false || $this->session->set_userdata($menu_uri);
        $this->my_model->checkurl();

        // Login check
        $exception_uris = array(
            'logincontroller',
            'logincontroller/index/1',
            'logincontroller/index/2',
            'logincontroller/logout'
        );        
        if (in_array(uri_string(), $exception_uris) == FALSE) {
            if ($this->config_model->loggedin() == FALSE) {
                redirect('logincontroller');
            }
        }
        $this->my_model->checkpermission();
        //////////////////
        $meth=$this->router->fetch_method();
        $user_id=$this->session->userdata('user_id');
		
        $info=$this->db->query("SELECT * FROM user WHERE id=$user_id ")->row();
       // print_r($info); exit();
        if($info->pw_change_date=='2021-12-06' && $meth!='changePassword'){
            redirect("configcontroller/changePassword");
        }
        


    }

       

      

}
