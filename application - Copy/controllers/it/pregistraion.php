<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pregistraion extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('it/pregistraion_model');
     }
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'it/pregistraion/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->pregistraion_model->get_count();
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
        //echo $data["page"]; exit();///////////
        $data['list']=$this->pregistraion_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Asset Register Info';
        //$data['list']=$this->pregistraion_model->lists();
        $data['display']='it/pregistrationlist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }

    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Asset Register Info';
        $data['mainlist']=$this->look_up_model->getMainProduct($this->session->userdata('department_id'));
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        $data['display']='it/addregister';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($product_detail_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Asset Info';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['info']=$this->pregistraion_model->get_info($product_detail_id);
        $data['mainlist']=$this->look_up_model->getMainProduct($this->session->userdata('department_id'));
        $data['slist']=$this->look_up_model->getSupplier();
        $data['display']='it/addregister';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function save($product_detail_id=FALSE){
        $this->form_validation->set_rules('product_id','Asset Name','trim|required');
        $this->form_validation->set_rules('invoice_no','Invoice No','trim');
        $this->form_validation->set_rules('purchase_date','Purchase Date','trim|required');
        $this->form_validation->set_rules('supplier_id','Supplier Name','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->pregistraion_model->save($product_detail_id);
            if($check && !$product_detail_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $product_detail_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("it/pregistraion/lists");
         }else{
            $data['heading']='Add New Asset Register Info';
            if($product_detail_id){
              $data['heading']='Edit Asset Register Info';
              $data['info']=$this->pregistraion_model->get_info($product_detail_id);  
            }
            $data['mainlist']=$this->look_up_model->getMainProduct($this->session->userdata('department_id'));
            $data['slist']=$this->look_up_model->getSupplier();
            $data['display']='it/addregister';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($product_detail_id=FALSE){
      $check=$this->pregistraion_model->delete($product_detail_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("it/pregistraion/lists");
    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkUse($product_detail_id){
        $chk=$this->db->query("SELECT * FROM product_status_info 
          WHERE product_detail_id=$product_detail_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function damages($product_detail_id){
      $data['detail_status']=2;
      $data['it_status']=4;
      $data['deactivated_date']=date('Y-m-d');
      $this->db->where('product_detail_id', $product_detail_id);
      $this->db->update('product_detail_info',$data);
      $this->session->set_userdata('exception','Deactivated successfully');
      redirect("it/pregistraion/lists");
    }
  function changestatus(){
      $product_detail_id=$this->input->post('product_detail_id');
      if($this->input->post('it_status')>3){
        $data['detail_status']=4;
      }else{
        $data['detail_status']=1;
      }      
      $data['despose_date']=date('Y-m-d');
      $data['it_status']=$this->input->post('it_status');
      $data['despose_note']=$this->input->post('despose_note');
      $data['remarks']=$this->input->post('despose_note');
      $this->db->where('product_detail_id', $product_detail_id);
      $this->db->update('product_detail_info',$data);
      $this->session->set_userdata('exception','Change status successfully');
      redirect("it/pregistraion/lists");
  }
  function activated($product_detail_id){
      $data['detail_status']=1;
      $data['it_status']=2;
      $this->db->where('product_detail_id', $product_detail_id);
      $this->db->update('product_detail_info',$data);
      $this->session->set_userdata('exception','Activated successfully');
      redirect("it/pregistraion/lists");
  }
 
  function notfound($product_detail_id){
      $data['detail_status']=3;
      $data['it_status']=9;
      $data['remarks']='Dormant Stock';
      $this->db->where('product_detail_id', $product_detail_id);
      $this->db->update('product_detail_info',$data);
      $this->session->set_userdata('exception','Not found successfully');
      redirect("it/pregistraion/lists");
    }
  function duplicate($product_detail_id){
      $data['duplicate_status']=2;
      $this->db->where('product_detail_id', $product_detail_id);
      $this->db->update('product_detail_info',$data);
      $this->session->set_userdata('exception','Information change successfully');
      redirect("it/pregistraion/lists");
    }
    function serviceDone($product_detail_id){
      $data['it_status']=2;
      $data['detail_status']=1;
      $this->db->where('product_detail_id', $product_detail_id);
      $this->db->update('product_detail_info',$data);
      $this->session->set_userdata('exception','Service Done Successfully');
      redirect("it/pregistraion/lists");
    }
    function views($product_detail_id){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Asset Details Information';
        $data['info']=$this->pregistraion_model->get_info($product_detail_id); 
        $data['display']='it/viewSingleRegister';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }

 
   
 }