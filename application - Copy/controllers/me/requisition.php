<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Requisition extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('me/requisition_model');
        
     }

    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'me/requisition/lists/';
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->requisition_model->get_count();
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
      $total_rows=$config['total_rows'];
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
      $data['list']=$this->requisition_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['heading']='Requisition Lists';
      $data['display']='me/requisition_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("logincontroller");
      }
  }
  function add(){
    if($this->session->userdata('user_id')) {
      $data['heading']='Add Requisition';
      $data['dlist']=$this->look_up_model->departmentList();
      $data['flist']=$this->look_up_model->getFloorLine();
      $data['display']='me/addrequisition';
      $this->load->view('admin/master',$data);
    }else{
      redirect("logincontroller");
    }
  }
  function edit($requisition_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Edit Requisition';
    $data['dlist']=$this->look_up_model->departmentList();
    $data['flist']=$this->look_up_model->getFloorLine();
    $data['info']=$this->requisition_model->get_info($requisition_id);
    $data['detail']=$this->requisition_model->getDetails($requisition_id);
    $data['display']='me/addrequisition';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
    }
   function save($requisition_id=FALSE){
    $this->form_validation->set_rules('asset_encoding', 'CODE', 'trim');
      $check=$this->requisition_model->save($requisition_id);
      if($check && !$requisition_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $requisition_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("me/requisition/lists");
    }
    function delete($requisition_id=FALSE){
      $check=$this->requisition_model->delete($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("me/requisition/lists");
    }
    function getspares(){
    $spares_name=$this->input->post('spares_name');
    $spares_code=$this->input->post('spares_code');
    $asset_encoding=$this->input->post('asset_encoding');

    $str='';
    $result=$this->db->query("SELECT a.*, c.category_name,u.unit_name
         FROM product_info a
         INNER JOIN category_info c ON(a.category_id=c.category_id)
         INNER JOIN product_unit u ON(a.unit_id=u.unit_id)   
         WHERE a.product_code LIKE '%$spares_code%'
         AND a.product_name LIKE '%$spares_name%' AND a.department_id=12
         ORDER BY a.product_name ASC LIMIT 0,300")->result();
        if(count($result)>0){
        foreach ($result as $value) {
          $str.='<tr><td><a href="#" data-product_id="'.$value->product_id.'" data-product_name="'.$value->product_name.'" data-product_code="'.$value->product_code.'" data-category_name="'.$value->category_name.'"  data-unit_name="'.$value->unit_name.'"onclick="return addField(this);"> 
          '.$value->product_code.'</a></td>';
         $str.='<td><a href="#" data-product_id="'.$value->product_id.'" data-product_name="'.$value->product_name.'" data-product_code="'.$value->product_code.'" data-category_name="'.$value->category_name.'"  data-unit_name="'.$value->unit_name.'"onclick="return addField(this);"> 
          <button type="button" class="btn btn-primary pull-right addNewSpares" id="addNewSpares">
          <i class="fa fa-plus"></i> 
        Add</button></a></td>';
        $str.='<td>'.$value->product_name.'</td>';
        $str.='<td>'.$value->category_name.'</td>';
        $str.='<td>'.$value->product_model.'</td>';
        $str.='</tr>';
        }
      }else{
        $str.='<tr>Noy Found</tr>';
      }
      echo $str;
  }
////////////////////////
public function suggestions(){
        $term = $this->input->get('term', true);
        $asset_encoding = $this->input->get('asset_encoding', true);
        if (strlen($term) < 1 || !$term) {
          die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->requisition_model->getRequisitionProduct($term,$asset_encoding);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              $product_name="$row->product_name($row->product_code)";
                $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 'label' => $row->product_name . " (" . $row->product_code . ")". " (Stock=" . $row->main_stock . ")", 'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'product_name' =>$product_name ,'product_code' => $row->product_code, 'unit_price' => $row->unit_price,
                 'stock' =>$row->main_stock);
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
    function view($requisition_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Requisition Form';
            $data['info']=$this->requisition_model->get_info($requisition_id);
            $data['detail']=$this->requisition_model->getDetails($requisition_id);
            $pdfFilePath='Requisition'.date('Y-m-d H:i').'.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','L','','','15','15','10','18');
            $mpdf->useAdobeCJK = true;
            $mpdf->SetAutoFont(AUTOFONT_ALL);
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('L');
            $header = $this->load->view('header', $data, true);
            $footer = $this->load->view('footer', $data, true);
            $html=$this->load->view('me/requisitionView', $data, true);
            //$mpdf->setHtmlHeader($header);
            // $mpdf->pagenumPrefix = '  Page ';
            // $mpdf->pagenumSuffix = ' - ';
            // $mpdf->nbpgPrefix = ' out of ';
            // $mpdf->nbpgSuffix = '';
            $mpdf->setHtmlFooter($footer);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
           redirect("logincontroller");
        }
      }
    function viewhtml($requisition_id=FALSE){
        $data['heading']='Requisition Form';
        $data['info']=$this->requisition_model->get_info($requisition_id);
        $data['detail']=$this->requisition_model->getDetails($requisition_id);
        $data['display']='me/htmlrequisitionView';
        $this->load->view('admin/master',$data);
    }
    function submit($requisition_id=FALSE){
      //$this->load->model('communication');
      // $data['info']=$this->requisition_model->get_info($requisition_id); 
      // $department_id=$data['info']->department_id;
      // $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
      //   WHERE department_id=$department_id")->row('dept_head_email');
      // $subject="Requisition Approval Notification";
      // $message=$this->load->view('req_email_format', $data,true); 
      // $this->communication->send($emailaddress,$subject,$message);
      $check=$this->requisition_model->submit($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Send successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("me/requisition/lists");
    }

   
 }