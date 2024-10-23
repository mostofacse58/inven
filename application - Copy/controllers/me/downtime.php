<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Downtime extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('excel'); //load PHPExcel library 
        $this->load->model('me/downtime_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'me/downtime/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->downtime_model->get_count();
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
        $data['list']=$this->downtime_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Machine Down Time Info';
        $data['display']='me/downtimelist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Machine Down Time';
        $data['mlist']=$this->downtime_model->getMachineLine();
        $data['display']='me/adddowntime';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function edit($machine_downtime_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Machine Down Time';
        $data['info']=$this->downtime_model->get_info($machine_downtime_id);
        $data['mlist']=$this->downtime_model->getMachineLine();
        $data['display']='me/adddowntime';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
    function getMachineLine(){
           $line_id=$this->input->post('line_id');
           $result=$this->db->query("SELECT ps.product_status_id,
            CONCAT(p.product_name,' (',pd.tpm_serial_code,') (',fl.line_no,')') as product_name
            FROM product_status_info ps
            INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
            INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
            INNER JOIN product_info p ON(p.product_id=pd.product_id)
            WHERE ps.machine_status=1 and ps.department_id=12 
            and ps.line_id=$line_id")->result();
      echo '<option value="">Select Machine Name(TMP CODE)</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->product_status_id.'" >'.$value->product_name.'</option>';
      }
    exit;
   }
   
    function save($machine_downtime_id=FALSE){
        $this->form_validation->set_rules('line_id','Line No','trim|required');
        $this->form_validation->set_rules('product_status_id','Product Name (Location)','trim|required');
        $this->form_validation->set_rules('down_date','Date','trim|required');
        $this->form_validation->set_rules('problem_start_time','Problem Start Time','trim|required');
        $this->form_validation->set_rules('me_response_time','ME Response Time','trim|required');
        $this->form_validation->set_rules('problem_end_time','Problem End Time','trim|required');
        $this->form_validation->set_rules('problem_description','Problem description','trim|required');
        $this->form_validation->set_rules('action_taken','Action Taken','trim|required');
        $this->form_validation->set_rules('supervisor_id','Supervisor','trim');
        $this->form_validation->set_rules('me_id','ME','trim|required');
        $this->form_validation->set_rules('total_minuts','Downtime Time','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->downtime_model->save($machine_downtime_id);
            if($check && !$machine_downtime_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $machine_downtime_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("me/downtime/lists");
         }else{
            $data['heading']='Add New Machine Down Time';
            if($machine_downtime_id){
              $data['heading']='Edit Machine Down Time';
              $data['info']=$this->downtime_model->get_info($machine_downtime_id);  
            }
            $data['mlist']=$this->downtime_model->getMachineLine();
            $data['display']='me/adddowntime';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($machine_downtime_id=FALSE){
      $check=$this->downtime_model->delete($machine_downtime_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("me/downtime/lists");
    }

   function addExcel(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Upload Machine Down Time';
        $data['display']='me/addDownTimeExcel';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
    function uploadExcel(){
       if ($_FILES['down_time_file']['name'] != "") {
                $configUpload['upload_path'] = FCPATH . 'asset/excel/';
                $configUpload['allowed_types'] = 'xls|xlsx|csv';
                $configUpload['max_size'] = '5000';
                $this->load->library('upload', $configUpload);
                if ($this->upload->do_upload('down_time_file')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name']; //uploded file name
                    $extension = $upload_data['file_ext'];    // uploded file extension
                    //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007     
                    //Set to read only
                    $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
                    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel        
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    //loop from first data untill last data
                if ($totalrows > 2) {
                  for ($i = 2; $i <= $totalrows; $i++) {
                    $downtimedata['action_taken']  = $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
                    if($downtimedata['action_taken']!=''){
                      $line_id='';
                      $product_status_id='';
                    $line_no = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
                    $downtimedata['down_date']  = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));

                    if($line_no!=''&&count($line_no)>0){
                       $downtimedata['line_id']=$line_no;
                       $tpm_serial_code = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                         $downtimedata['product_status_id']=$tpm_serial_code;
                    }else{
                      $downtimedata['line_id']='';
                      $downtimedata['product_status_id']='';
                    } 
                     $downtimedata['problem_start_time']  =date('h:i:s A', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(6, $i)->getValue()));
                      //$objWorksheet->getCellByColumnAndRow(6, $i)->getValue(); 
                     //echo date_default_timezone_get();
                    // $fff= date('h:i:s A', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(6, $i)->getValue())); 
                     //echo $fff ; 
                    // echo $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
                    // //echo  date("Y-m-d H:i:s", strtotime('+5 hours'));
                    //  exit();

                     $downtimedata['me_response_time'] = date('h:i:s A', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(7, $i)->getValue())); 
                     $downtimedata['problem_description']  = $objWorksheet->getCellByColumnAndRow(8, $i)->getValue(); 
                     $downtimedata['problem_end_time']  = date('h:i:s A', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(9, $i)->getValue())); 
                     $downtimedata['supervisor_id']  = $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
                     $me_id_no= $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();

                     if($me_id_no!=''&&count($me_id_no)>0){
                      $downtimedata['me_id']=$objWorksheet->getCellByColumnAndRow(12, $i)->getValue();
                     }
                     $downtimedata['total_minuts']  = $objWorksheet->getCellByColumnAndRow(13, $i)->getValue();
                     $downtimedata['working_time']  = $objWorksheet->getCellByColumnAndRow(14, $i)->getValue();
                     $downtimedata['time_status']  = $objWorksheet->getCellByColumnAndRow(15, $i)->getValue();
                     $this->downtime_model->saveExcel($downtimedata);
                   }
                  }
                   // unlink('./asset/excel/' . $file_name); //File Deleted After uploading in database .   
                    $this->session->set_userdata('exception', 'Upload successfully!');
                  } else {
                    $this->session->set_userdata('exception_err', "No data found.");
                }
                }else {
                  $error = $this->upload->display_errors();
                  $this->session->set_userdata('exception_err', "$error");
                }
        } else {
            $this->session->set_userdata('exception_err', 'File is required');
        }
        redirect("me/downtime/addExcel");
    }

   //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($machine_downtime_id){
        $chk=$this->db->query("SELECT * FROM machine_downtime_info 
          WHERE machine_downtime_id=$machine_downtime_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
 }