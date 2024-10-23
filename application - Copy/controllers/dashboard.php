<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends My_Controller {
  function __construct(){
        parent::__construct();
        $this->load->model('format/deptrequisn_model');
        $this->load->model('payment/applications_model');
        $this->load->model('cc/courier_model');
        $this->load->model('format/po_model');
     }
	public function index(){
    $department_id=$this->session->userdata('department_id');
    // $sss=$this->db->query("SELECT * 
    //   FROM machinery_report_view
    //   ")->result();
    // print_r($sss); exit();
		$data['totalspares']=$this->db->query("SELECT COUNT(*) as ccc 
      FROM product_info WHERE product_type=2 AND department_id=12 AND machine_other=1")->row('ccc');
		$data['totalmachine']=$this->db->query("SELECT COUNT(*) as ccc 
      FROM product_detail_info 
			WHERE department_id=12 AND machine_other=1")->row('ccc');
		$data['totalmachineactive']=$this->db->query("SELECT COUNT(*) as ccc 
      FROM product_detail_info
			WHERE department_id=12 AND detail_status=1 AND machine_other=1")->row('ccc');
		$data['totalmachinedeactive']=$this->db->query("SELECT COUNT(*) as ccc 
      FROM product_detail_info
			WHERE department_id=12 AND detail_status=2 AND machine_other=1")->row('ccc');
    $data['totalasset']=$this->db->query("SELECT COUNT(*) as ccc 
      FROM product_detail_info
      WHERE department_id=$department_id AND machine_other=2")->row('ccc');
    $data['totalitems']=$this->db->query("SELECT COUNT(*) as ccc 
      FROM product_info WHERE product_type=2 AND department_id=$department_id AND machine_other=2")->row('ccc');
    
    
		$data['heading']='Dashboard';
		$data['display']='admin/dashboard';
		$this->load->view('admin/master',$data);
	}
  public function profile(){
        if ($this->session->userdata('user_id')){
        $id=$this->session->userdata('user_id');
        $data['postlist']=$this->config_model->postList();
        $data['heading'] = "Update Profile";
        $data['user_id'] = $id;
        $data['user_info'] = $this->config_model->get_user_info( $id);
        ////////////////////
        $data['display']='admin/editprofile';
        $this->load->view('admin/master',$data);
        } else {
            redirect("admin/index");
        }
    }
function viewpipdf($pi_id=FALSE){
  if ($this->session->userdata('user_id')) {
      $data['heading']='Purchase Indent';
        $data['info']=$this->deptrequisn_model->get_info($pi_id);
        $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
        $pdfFilePath='PI'.date('Y-m-d H:i').'.pdf';
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','L','','','10','10','5','18');
        $mpdf->useAdobeCJK = true;
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->AddPage('L');
        $header = $this->load->view('header', $data, true);
        $footer = $this->load->view('footer', $data, true);
        if($data['info']->pi_type==1)
        $html=$this->load->view('format/piformatview', $data, true);
        elseif($data['info']->pi_type==2)
        $html=$this->load->view('aformat/piformatview', $data, true);
        $mpdf->SetHTMLFooter($footer); 
        $mpdf->WriteHTML($html);
        $mpdf->Output();
      } else {
         redirect("logincontroller");
      }
    }
  function viewapplicationspdf($payment_id=FALSE){
      $data['heading']='Payment Application';
      $data['info']=$this->applications_model->get_info($payment_id);
      $data['detail']=$this->applications_model->getDetails($payment_id);
      $data['detail3']=$this->applications_model->getDetails3($payment_id);
      $data['detail4']=$this->applications_model->getDetails4($payment_id);
      $pdfFilePath='PA-'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','P','','','15','15','10','15');
      $mpdf->useAdobeCJK = true;
      $mpdf->SetAutoFont(AUTOFONT_ALL);
      $mpdf->autoScriptToLang = true;
      $mpdf->autoLangToFont = true;
      $mpdf->AddPage('P');
      $header = $this->load->view('payment/header', $data, true);
      $footer = $this->load->view('payment/footer', $data, true);
      $html=$this->load->view('payment/viwepdf', $data, true);
      $mpdf->SetHTMLFooter($footer); 
      $mpdf->WriteHTML($html);
      $mpdf->Output();
    }
    function viewCCpdf($courier_id=FALSE){
      $data['heading']='Courier Control Details Information';
      $data['info']=$this->courier_model->get_info($courier_id);
      $data['detail']=$this->courier_model->get_detail($courier_id);
      $pdfFilePath='PA-'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','P','','','15','15','10','15');
      $mpdf->useAdobeCJK = true;
      $mpdf->SetAutoFont(AUTOFONT_ALL);
      $mpdf->autoScriptToLang = true;
      $mpdf->autoLangToFont = true;
      $mpdf->AddPage('P');
      $header = $this->load->view('header', $data, true);
      $footer = $this->load->view('footer', $data, true);
      $html=$this->load->view('cc/courierPdf', $data, true);
      $mpdf->SetHTMLFooter($footer); 
      $mpdf->WriteHTML($html);
      $mpdf->Output();
    }
    function downloadpiExcel($pi_id=FALSE){
      $data['heading']='Purchase Indent';
      $data['info']=$this->deptrequisn_model->get_info($pi_id);
      $data['detail']=$this->deptrequisn_model->getDetails($pi_id);
      if($data['info']->pi_type==1)
      $this->load->view('format/piformatviewExcel', $data);
      else
      $this->load->view('aformat/piformatviewExcel', $data);
    }
    

  function viewpopdf($po_id=FALSE){
      $data['heading']='PO';
      $data['info']=$this->po_model->get_info($po_id);
      $data['detail']=$this->po_model->getDetails($po_id);
      $pdfFilePath='PO'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','P','','','15','15','5','18');
      $mpdf->useAdobeCJK = true;
      $mpdf->SetAutoFont(AUTOFONT_ALL);
      $mpdf->autoScriptToLang = true;
      $mpdf->autoLangToFont = true;
      $mpdf->AddPage('P');
      $header = $this->load->view('header', $data, true);
      $footer = $this->load->view('footer', $data, true);
      $html=$this->load->view('format/woviewpdf', $data, true);
      $mpdf->SetHTMLFooter($footer); 
      $mpdf->WriteHTML($html);
      $mpdf->Output();
  }
  function excelpo($po_id=FALSE){
      $data['heading']='PO';
      $data['info']=$this->po_model->get_info($po_id);
      $data['detail']=$this->po_model->getDetails($po_id);
      $this->load->view('format/poexcel', $data);
    }
  function downloadPO($po_number=FALSE){
      $data['heading']='PO';
      $data['info']=$this->po_model->get_info2($po_number);
      $data['detail']=$this->po_model->getDetails($data['info']->po_id);
      $pdfFilePath='PO'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','P','','','15','15','5','18');
      $mpdf->useAdobeCJK = true;
      $mpdf->SetAutoFont(AUTOFONT_ALL);
      $mpdf->autoScriptToLang = true;
      $mpdf->autoLangToFont = true;
      $mpdf->AddPage('P');
      $header = $this->load->view('header', $data, true);
      $footer = $this->load->view('footer', $data, true);
      $html=$this->load->view('format/woviewpdf', $data, true);
      $mpdf->SetHTMLFooter($footer); 
      $mpdf->WriteHTML($html);
      $mpdf->Output();
   
  }
    ////////////////////////////////////////////////
    ////////// SAVE USER
    ////////////////////////////////////////////////
    public function  saveP(){
      if($this->session->userdata('user_id')){
    $id=$this->session->userdata('user_id');
    $data=array();
    if($_FILES['photo']['name']!=""){
      $config['upload_path'] = './asset/photo/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG';
      $config['max_size'] = '30000';
      $this->load->library('upload', $config);
      if($this->upload->do_upload("photo")){
        $upload_info = $this->upload->data();
        $config['image_library'] = 'gd2';
        $config['source_image'] = './asset/photo/' . $upload_info['file_name'];
        $config['maintain_ratio'] = FALSE;
        $config['width'] = '200';
        $config['height'] = '200';
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $data['photo']=$upload_info['file_name'];
        $this->session->set_userdata("photo", $data['photo']);
        }}
      $data['user_name']=$this->input->post('user_name');
      $data['email_address']=$this->input->post('email_address');
      $data['mobile']=$this->input->post('mobile');
      $data['post_id']=$this->input->post('post_id');
      $this->session->set_userdata("user_name", $this->input->post('user_name'));
      $this->session->set_userdata("email_address", $this->input->post('email_address'));

      $this->db->where('id', $id);
      $this->db->update('user',$data);
      $this->session->set_userdata('exception','User information has been updated successfully');
      redirect("dashboard/profile");
      }else{
      redirect("logincontroller");
      }
    }

	// function barcode($string = ''){
 //    $this->load->library('zend');
 //    $this->zend->load('Zend/Barcode');
 //    Zend_Barcode::render('code128', 'image', array('text' => $string, 'barHeight' => 66), array('imageType' => 'png')); 
 //  }
  function barcode($string = '',$get_be = false){
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');
    Zend_Barcode::render('code128', 'image', array('text' =>  $string,
      'drawText' => false, 
      'barWidth' => 295,
      'barHeight' => 50,
      'factor' => ($get_be ? 2 : 1)), 
    array('imageType' => 'png',
      'horizontalPosition' => 'center', 
      'verticalPosition' => 'middle')); 
  }
 function addNewSupplierByAjax(){
    $department_id=$this->session->userdata('department_id');
    $data['supplier_name'] = $this->input->post('supplier_name');
    $data['phone_no'] = $this->input->post('phone_no');
    $data['company_address'] = $this->input->post('company_address');
    $data['department_id']=$this->session->userdata('department_id');
    $data['create_date']=date('Y-m-d');
    $this->db->insert('supplier_info', $data);
    $data1=$this->db->query("SELECT * FROM supplier_info 
              WHERE department_id=$department_id 
              ORDER BY supplier_id DESC")->result();
    foreach ($data1 as $value) {
     echo '<option value="'.$value->supplier_id.'" >'.$value->supplier_name.'</option>';
     }
    exit;
  }
  function addNewShipToByAjax(){
    $data['ship_name'] = $this->input->post('ship_name1');
    $data['ship_address'] = $this->input->post('ship_address1');
    $data['ship_attention'] = $this->input->post('ship_attention1');
    $data['ship_telephone'] = $this->input->post('ship_telephone1');
    $data['ship_email'] = $this->input->post('ship_email1');
    $this->db->insert('ship_to_info', $data);
    $ship_id=$this->db->insert_id();
    $data1=$this->db->query("SELECT * FROM ship_to_info 
              WHERE 1 
              ORDER BY ship_id DESC")->result();
    foreach ($data1 as $value) {
      if($ship_id==$value->ship_id)
     echo '<option value="'.$value->ship_id.'" selected>'.$value->ship_name.'</option>';
     else echo '<option value="'.$value->ship_id.'" >'.$value->ship_name.'</option>';
    }
    exit;
  }
  function addNewPayToByAjax(){
    $data['supplier_name'] = $this->input->post('supplier_name');
    $data['company_address'] = $this->input->post('company_address');
    $data['phone_no'] = $this->input->post('phone_no');
    $data['email_address'] = $this->input->post('email_address');
    $this->db->insert('supplier_info', $data);
    $supplier_id=$this->db->insert_id();
    $data1=$this->db->query("SELECT * FROM supplier_info 
              WHERE 1 
              ORDER BY supplier_id DESC")->result();
    foreach ($data1 as $value) {
      if($supplier_id==$value->supplier_id)
     echo '<option value="'.$value->supplier_id.'" selected>'.$value->supplier_name.'</option>';
     else echo '<option value="'.$value->supplier_id.'" >'.$value->supplier_name.'</option>';
    }
    exit;
  }
  
  function addNewCourToByAjax(){
    $data['courier_company'] = $this->input->post('courier_company1');
    $data['courier_address'] = $this->input->post('courier_address1');
    $this->db->insert('courier_name_info', $data);
    $data1=$this->db->query("SELECT * FROM courier_name_info 
              WHERE 1 
              ORDER BY courier_company DESC")->result();
    foreach ($data1 as $value) {
      if($data['courier_company']==$value->courier_company)
     echo '<option value="'.$value->courier_company.'" selected>'.$value->courier_company.'</option>';
     else echo '<option value="'.$value->courier_company.'" >'.$value->courier_company.'</option>';
    }
    exit;
  }
  function addNewLocationByAjax(){
    $department_id=$this->session->userdata('department_id');
    $data['location_name'] = $this->input->post('location_name');
    $data['department_id']=$this->session->userdata('department_id');
    $this->db->insert('location_info', $data);
    $data1=$this->db->query("SELECT * FROM location_info 
              WHERE department_id=$department_id ORDER BY location_id DESC")->result();
    foreach ($data1 as $value) {
     echo '<option value="'.$value->location_id.'" >'.$value->location_name.'</option>';
     }
    exit;
  }
  function gatepassExcel($file = "") {
    // load ci download helder
    $this->load->helper('download');
    $data = file_get_contents("gatepass/".$file); // Read the file's 
    $name = $file;
    force_download($name, $data);
  }
  function dpayment($file = "") {
    // load ci download helder
    $this->load->helper('download');
    $data = file_get_contents("payment/".$file); // Read the file's 
    $name = $file;
    force_download($name, $data);
  }
  function dproject($file = "") {
    // load ci download helder
    $this->load->helper('download');
    $data = file_get_contents("project/".$file); // Read the file's 
    $name = $file;
    force_download($name, $data);
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */