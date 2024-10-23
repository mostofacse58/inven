<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gatepass extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/gatepass_model');

        if($this->session->userdata('language')=='chinese'){
        $this->lang->load('chinese', "chinese");
        }else{
          $this->lang->load('english', "english");
        }
     }
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'gatep/gatepass/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->gatepass_model->get_count();
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
        $data['pagination'] = $this->pagination->create_links();
        //echo $data["page"]; exit();///////////
        $data['list']=$this->gatepass_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Gate Pass Lists';
        $data['display']='gatep/lists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }

    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Gate Pass';
        $data['ilist']=$this->gatepass_model->getIssueTo();
        $data['display']='gatep/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($gatepass_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Gate Pass';
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->gatepass_model->get_detail($gatepass_id);
        $data['ilist']=$this->gatepass_model->getIssueTo();
        $data['display']='gatep/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    public function suggestions(){
        $term = $this->input->get('term', true);
        $data_from = $this->input->get('data_from', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows=$this->gatepass_model->getData($data_from,$term);
        if($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            //$pr=array();
            foreach ($rows as $row) {
              if($row->product_type==1) $product_code=$row->ventura_code; else $product_code=$row->product_code;
              $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 
                'label' => $row->product_name . " (" . $row->product_code . $row->ventura_code . ")",
                'unit_name' => $row->unit_name, 'product_name' => $row->product_name,
                'product_code' => $product_code);
              $r++;
            }
            header('Content-Type: application/json');
            die(json_encode($pr));
            exit;
        }else{
            $dsad='';
            header('Content-Type: application/json');
            die(json_encode($dsad));
            exit;
        }
    }
    function save($gatepass_id=FALSE){
        $this->form_validation->set_rules('wh_whare','Location','trim|required');
        $this->form_validation->set_rules('issue_to','Issue To','trim');
        $this->form_validation->set_rules('employee_id','ID','trim|required');
        $this->form_validation->set_rules('carried_by','Employee','trim|required');
        $this->form_validation->set_rules('gatepass_type','Type','trim|required');
        $this->form_validation->set_rules('create_date','Date','trim|required');
        $this->form_validation->set_rules('data_from','Data From','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->gatepass_model->save($gatepass_id);
            if($check && !$gatepass_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $gatepass_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                   $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("gatep/gatepass/lists");
         }else{
            $data['heading']='Add Gate Pass';
            if($gatepass_id){
              $data['heading']='Edit Gate Pass';
              $data['info']=$this->gatepass_model->get_info($gatepass_id); 
              $data['detail']=$this->gatepass_model->get_detail($gatepass_id); 
            }
            $data['ilist']=$this->gatepass_model->getIssueTo();
            $data['ulist']=$this->gatepass_model->getProductUnit();
            $data['display']='gatep/add';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($gatepass_id){
      $this->gatepass_model->delete($gatepass_id); 
      $this->session->set_userdata('exception','Delete successfully');
      redirect("gatep/gatepass/lists");
    }
    function view($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->gatepass_model->get_detail($gatepass_id);
        $data['display']='gatep/viewpass';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function loadpdf($gatepass_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='GATEPASS';
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->gatepass_model->get_detail($gatepass_id);
        $data['gatepass_id']=$gatepass_id;
        $file_name='GATEPASS'.date('Ymdhi')."-$gatepass_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/Pdf/".$file_name.".pdf";
        
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('gatep/gatepassPdf', $data, true);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'F');
        } else {
        redirect("logincontroller");
        }
      }
      public function submit($gatepass_id=FALSE){
        $this->load->model('communication');
        $department_id=$this->session->userdata('department_id');
        $dept_head_email=$this->db->query("SELECT * FROM department_info
          WHERE department_id=$department_id")->row('dept_head_email');
        ////////////////////////////////////////
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->gatepass_model->get_detail($gatepass_id);
        $data['gatepass_id']=$gatepass_id;
        $data2['gatepass_status']=2;
        $this->db->where('gatepass_id', $gatepass_id);
        $this->db->update('gatepass_master',$data2);
        $message=$this->load->view('gatep/email_body', $data,true);
        $subject="Gate Pass Approval Notification";
        //$this->communication->send('golam.mostofa@bdventura.com',$subject,$message);
        $this->session->set_userdata('exception','Send successfully');
      redirect("gatep/gatepass/lists");
    }
     function addNewByAjax(){
        $department_id=$this->session->userdata('department_id');
        $data['issue_to_name'] = $this->input->post('issue_to_name');
        $data['mobile_no'] = $this->input->post('mobile_no');
        $data['address'] = $this->input->post('address');
        $data['department_id']=$this->session->userdata('department_id');
        $this->db->insert('issue_to_master', $data);
        $data1=$this->db->query("SELECT *
                  FROM issue_to_master WHERE department_id=$department_id")->result();
         echo '<option value="">Select any one</option>';
        foreach ($data1 as $value) {
         echo '<option value="'.$value->issue_to.'" >'.$value->issue_to_name.'</option>';
         }
        exit;
    }
    function fedit($gatepass_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Gate Pass';
        $data['info']=$this->gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->gatepass_model->get_detail($gatepass_id);
        $data['ilist']=$this->gatepass_model->getIssueTo();
        $data['display']='gatep/fedit';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function fsave($gatepass_id=FALSE){
        $this->load->model('communication');
        $data=array();
        if($_FILES['attachment']['name']!=""){
        $config['upload_path'] = './gatepass/';
        $config['allowed_types'] = 'pdf|PDF|xlsx|xls|jpg|jpeg';
        $config['max_size'] = '300000';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("attachment")){
          $upload_info = $this->upload->data();
          $data['attachment']=$upload_info['file_name'];
        }}
        $data['vehicle_no']=$this->input->post('vehicle_no');
        $data['container_no']=$this->input->post('container_no');
        $data['edit_date']=date('h:i A');
        $data['edit_status']=$this->input->post('edit_status')+1;
        $data['edit_by']=$this->session->userdata('user_id');
        ////////////////////
        $this->db->WHERE('gatepass_id',$gatepass_id);
        $query=$this->db->update('gatepass_master',$data);
        /////////////////////////////////////
        $product_code=$this->input->post('product_code');
        $pre_carton_no=$this->input->post('pre_carton_no');
        $pre_product_quantity=$this->input->post('pre_product_quantity');
        $pre_carton_no=$this->input->post('pre_carton_no');
        $pre_bag_qty=$this->input->post('pre_bag_qty');
        $product_quantity=$this->input->post('product_quantity');
        $carton_no=$this->input->post('carton_no');
        $bag_qty=$this->input->post('bag_qty');

        $detail_id=$this->input->post('detail_id');

        $gatepass_no=$this->input->post('gatepass_no');
        $i=0;
        $message='<html lang="en"><head><meta charset="UTF-8">
                </head>
                <body>
                <p style="font-size:15px;margin:0px;">
                Dear sir, 
                <br><br>
                Good day. 
                <br>
                Finished Goods gatepass no: '.$gatepass_no.' already modify by WH. 
                <br>Please check below details... 
                <br>';
        foreach ($detail_id as $value) {
          $data2['pre_product_quantity']=$pre_product_quantity[$i];
          $data2['product_quantity']=$product_quantity[$i];
          $data2['pre_carton_no']=$pre_carton_no[$i];
          $data2['carton_no']=$carton_no[$i];
          $data2['pre_bag_qty']=$pre_bag_qty[$i];
          $data2['bag_qty']=$bag_qty[$i];
          $this->db->WHERE('gatepass_id',$gatepass_id);
          $this->db->WHERE('detail_id',$value);
          $query=$this->db->update('gatepass_details',$data2);
          if($pre_product_quantity[$i]!=$product_quantity[$i]){
            $message.='This Material Code :'.$product_code[$i].' already change carton no '.$carton_no[$i].', quantity '.$product_quantity[$i].' and bag qty :'.$bag_qty[$i].'<br>';
          }
        $i++;
        }
      $message.='<br><br>
                Thanks by <br>
                Gatepass System<br><br>
                <span style="color: red">
                This is auto generated email from Gatepass Software. No Need to Reply.</span>
                </body>
                </html>';
      $emailaddress="azad.kalam@bdventura.com";
      $subject="Finished Goods Gatepass Update Notification";
      $this->communication->send($emailaddress,$subject,$message);
      $emailaddress="shakhawat.hossen@bdventura.com";
      $this->communication->send($emailaddress,$subject,$message);
      $emailaddress="melody.xie@bdventura.com";
      $this->communication->send($emailaddress,$subject,$message);
        $this->session->set_userdata('exception','Update successfully');
        redirect("gatep/gatepass/lists");
    }
   
 }