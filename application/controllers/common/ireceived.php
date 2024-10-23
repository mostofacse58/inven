<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ireceived extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('common/ireceived_model');
        $this->load->model('common/issued_model');
     }
    
    function lists(){
       $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'common/ireceived/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->ireceived_model->get_count();
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
        $data['list']=$this->ireceived_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        ////////////////////////////
        $data['heading']='Issued to Received List';
        $data['display']='common/ireceivedlist';
        $this->load->view('admin/master',$data);
       }
       function viewreceived($issue_id=FALSE){
        $data['heading']='Invoice Spares ';
        $data['info']=$this->issued_model->get_info($issue_id);
        $data['detail']=$this->issued_model->getDetails($issue_id);
        $data['heading']='Material Received Form';
        $data['display']='common/ireceiveView';
        $this->load->view('admin/master',$data);

      }
    
    function view($issue_id=FALSE){
        $data['heading']='Invoice Spares ';
        $data['info']=$this->issued_model->get_info($issue_id);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['detail']=$this->issued_model->getDetails($issue_id);
        $pdfFilePath='sparesInvoice'.date('Y-m-d H:i').'.pdf';
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
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
      
      }
      function receivedby(){
        $check=$this->ireceived_model->receivedby();
        if($check){ 
           $this->session->set_userdata('exception','Received successfully');
         }else{
           $this->session->set_userdata('exception','Received Failed');
        }
      redirect("common/ireceived/lists");
    }
 
   
 }