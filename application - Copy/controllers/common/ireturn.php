<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ireturn extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('common/ireturn_model');
     }
    
    function lists(){
      $data=array();
          $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'common/ireturn/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->ireturn_model->get_count();
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
      //////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->ireturn_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        ////////////////////////////
        $data['heading']='Item Return List';
        $data['display']='common/ireturnlist';
        $this->load->view('admin/master',$data);
       }
    function add(){
      $data['heading']='Add Return';
      $data['ilist']=$this->look_up_model->getItemList();
      $data['dlist']=$this->look_up_model->departmentList();
      $data['mlist']=$this->look_up_model->getMainProductSerial();
      $data['display']='common/addireturn';
      $this->load->view('admin/master',$data);
      
    }
    function edit($ireturn_id){
      $data['heading']='Edit Return';
      $data['ilist']=$this->look_up_model->getItemList();
      $data['info']=$this->ireturn_model->get_info($ireturn_id);
      $data['dlist']=$this->look_up_model->departmentList();
      $data['mlist']=$this->look_up_model->getMainProductSerial();
      $data['llist']=$this->look_up_model->getlocation();
      $data['display']='common/addireturn';
      $this->load->view('admin/master',$data);
     }

    function save($ireturn_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $this->form_validation->set_rules('product_id','Item','trim|required');
        $this->form_validation->set_rules('return_qty','Qty','trim|required');
        $this->form_validation->set_rules('return_date','Date','trim|required');
        if ($this->form_validation->run() == TRUE) {
        $check=$this->ireturn_model->save($ireturn_id);
        if($check && !$ireturn_id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&& $ireturn_id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
        redirect("common/ireturn/lists");
       }else{
          $data['heading']='Add Issue';
          if($ireturn_id){
            $data['heading']='Edit Issue';
            $data['info']=$this->ireturn_model->get_info($ireturn_id);  
          }
          $data['dlist']=$this->look_up_model->departmentList();
          $data['mlist']=$this->look_up_model->getMainProductSerial();
          $data['display']='common/addireturn';
          $this->load->view('admin/master',$data);
       }
    }

    function delete($ireturn_id=FALSE){
      $info=$this->db->query("SELECT *
        FROM issue_return_info  
        WHERE ireturn_id=$ireturn_id")->row();
      $FIFO=$info->FIFO_CODE;
      $result=$this->db->query("SELECT *
        FROM stock_master_detail  
        WHERE FIFO_CODE='$FIFO' AND TRX_TYPE!='RETURN' ")->result();
      if(count($result)>0){
        $this->session->set_userdata('exception','Can not delete this FIFO!');
        redirect("common/ireturn/lists");
      }else{
        $check=$this->ireturn_model->delete($ireturn_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
        redirect("common/ireturn/lists");
      }
    }
  ////////////////////////
 
    function view($ireturn_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Invoice Spares ';
            $data['info']=$this->ireturn_model->get_info($ireturn_id);
            $data['dlist']=$this->look_up_model->departmentList();
            $data['detail']=$this->ireturn_model->getDetails($ireturn_id);
            $pdfFilePath='sparesInvoice'.date('Y-m-d H:i').'.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','5','5','10','18');
            $mpdf->useAdobeCJK = true;
            $mpdf->SetAutoFont(AUTOFONT_ALL);
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $header = $this->load->view('header', $data, true);
            $html=$this->load->view('common/viewMaterialUsing', $data, true);
            $mpdf->setHtmlHeader($header);
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
           redirect("logincontroller");
        }
      }
      function returnback($ireturn_id=FALSE){
      $check=$this->ireturn_model->returnback($ireturn_id);
        if($check){ 
           $this->session->set_userdata('exception','Return successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("common/ireturn/lists");
    }
    public function getproductinfo() {
        $product_id = $this->input->post('product_id');
        $info = $this->db->query("SELECT * FROM product_info 
          WHERE product_id='$product_id'")->row(); 
       echo json_encode($info);
    }
 
   
 }