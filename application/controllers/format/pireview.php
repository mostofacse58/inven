<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pireview extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/pireview_model');
        $this->load->model('format/deptrequisnapp_model');
        $this->load->model('format/deptrequisn_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=30;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/pireview/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->pireview_model->get_count();
      $total_rows=$config['total_rows'];
      $config['per_page'] = $perpage;
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = 2;
      $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = 'First';
      $config['last_link'] = 'Last';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '<span aria-hidden="true">&laquo Prev</span>';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '<span aria-hidden="true">Next »</span>';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = "</a></li>";
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      ////////////////////////////////////////
      $this->pagination->initialize($config); 
      $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';      
      $data['list']=$this->pireview_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['dlist']=$this->look_up_model->departmentList();
      $data['ptlist']=$this->look_up_model->getPIType();
      $data['heading']='PI Lists';
      $data['display']='format/pireview_list';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
    }
    function modify($pi_id){
      $data['collapse']='YES';
      $data['clist']=$this->look_up_model->clist();
      $data['heading']='Modify Name & Specification';
      $data['info']=$this->deptrequisn_model->get_info($pi_id);
      $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
      $data['display']='format/pimodify';
      $this->load->view('admin/master',$data);
    }

  function save($pi_id=FALSE){
    $check=$this->pireview_model->save($pi_id);
    if($check){
        $this->load->model('communication');
        $data['info']=$this->deptrequisn_model->get_info($pi_id); 
        $department_id=$data['info']->department_id;
        if($department_id==8||$department_id==15||$department_id==22||$department_id==6){
          $emailaddress="robert.luo@bdventura.com";
        }elseif($department_id==9){
          $emailaddress="sarwar.hossen@bdventura.com";
        }elseif($department_id==4){
          $emailaddress="jwel.ahmmed@bdventura.com";
        }elseif($department_id==28){
          $emailaddress="jack.tang@bdventura.com;steven.xu@bdventura.com";
        }elseif($department_id==29){
          $emailaddress="devin@bdventura.com;steven.xu@bdventura.com";
        }elseif($department_id==5||$department_id==12||$department_id==17||$department_id==18||$department_id==28){
          $emailaddress="steven.xu@bdventura.com";
        }else{
          $emailaddress="thomas.zou@bdventura.com";
        }
        $subject="PI Certify Notification";
        $message=$this->load->view('for_certify_email', $data,true); 
        $this->communication->send($emailaddress,$subject,$message);
        $this->session->set_userdata('exception','Update successfully');
     }else{
       $this->session->set_userdata('exception','Submission Failed');
     }
    redirect("format/pireview/lists");
  }
 
    function directreview($pi_id=FALSE){
      $check=$this->pireview_model->directreview($pi_id);
        if($check){ 
          $this->load->model('communication');
          $data['info']=$this->deptrequisn_model->get_info($pi_id); 
          $department_id=$data['info']->department_id;
          if($department_id==8||$department_id==15||$department_id==22||$department_id==6){
            $emailaddress="robert.luo@bdventura.com";
          }elseif($department_id==9){
            $emailaddress="sarwar.hossen@bdventura.com";
          }elseif($department_id==4){
            $emailaddress="jwel.ahmmed@bdventura.com";
          }elseif($department_id==28){
            $emailaddress="jack.tang@bdventura.com;steven.xu@bdventura.com";
          }elseif($department_id==29){
            $emailaddress="devin@bdventura.com;steven.xu@bdventura.com";
          }elseif($department_id==5||$department_id==12||$department_id==17||$department_id==18||$department_id==28){
            $emailaddress="steven.xu@bdventura.com";
          }else{
            $emailaddress="thomas.zou@bdventura.com";
          }
          $subject="PI Certify Notification";
          $message=$this->load->view('for_certify_email', $data,true); 
          $this->communication->send($emailaddress,$subject,$message);
           $this->session->set_userdata('exception','Receive successfully');
         }else{
           $this->session->set_userdata('exception','Failed');
        }
      redirect("format/pireview/lists");
    }
   
  function viewpihtmlonly($pi_id=FALSE){
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Purchase Indent';
    $data['info']=$this->deptrequisn_model->get_info($pi_id);
    $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
    $data['display']='format/viewpihtmlonly';
    $this->load->view('admin/master',$data);     
  }
 
  
 }