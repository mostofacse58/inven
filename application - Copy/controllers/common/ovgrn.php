<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ovgrn extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/grn_model');
        $this->load->model('shipping/import_model');
        $this->load->model('common/ovgrn_model');
     }
    function lists(){
       $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'common/ovgrn/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->ovgrn_model->get_count();
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
        $data['list']=$this->ovgrn_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        ////////////////////////////
        $data['heading']='GRN List';
        $data['display']='common/ovgrnlist';
        $this->load->view('admin/master',$data);
       }


   
  function view($purchase_id=FALSE){
      $data['show']=2;
      $data['controller']=$this->router->fetch_class();
      $data['heading']='Receive Form';
      $data['info']=$this->grn_model->get_info($purchase_id);
      $data['detail']=$this->grn_model->getDetails($purchase_id);
      $data['display']='format/receiveformhtml';
      $this->load->view('admin/master',$data);
    }
function viewpdf($purchase_id=FALSE){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Receive Items ';
        $data['info']=$this->grn_model->get_info($purchase_id);
        $data['detail']=$this->grn_model->getDetails($purchase_id);
        $pdfFilePath='ItemReceiveInvoice'.date('Y-m-d H:i').'.pdf';
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','5','5','10','18');
        $mpdf->useAdobeCJK = true;
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('format/viewItemsInvoice', $data, true);
        $mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'D');
    } else {
       redirect("logincontroller");
    }
  }
  function returns($purchase_id=FALSE){
      $check=$this->ovgrn_model->returns($purchase_id);
      if($check){ 
         $this->session->set_userdata('exception','Return successfully');
       }else{
         $this->session->set_userdata('exception','Return Failed');
      }
      redirect("common/ovgrn/lists");
    }
   function received($purchase_id=FALSE){
      $data['show']=2;
      $this->ovgrn_model->received($purchase_id);
      $data['heading']='Receive Form';
      $data['info']=$this->grn_model->get_info($purchase_id);
      $data['detail']=$this->grn_model->getDetails($purchase_id);
      $data['slist']=$this->look_up_model->getSupplier();
      $data['clist']=$this->look_up_model->clist();
      $data['blist']=$this->look_up_model->get_box();
      $data['flist']=$this->import_model->getdata('shipping_file_style_info');
      $data['display']='common/addipurchase';
      $this->load->view('admin/master',$data);
    }

      
 }