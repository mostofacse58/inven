<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actions extends My_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('hoshin/actions_model');
     }
    
    function lists(){
     //echo $controll=$this->router->fetch_directory().$this->router->fetch_class();
      //echo  $method_name=$this->router->fetch_method();
      // exit();
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      //////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'hoshin/actions/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->actions_model->get_count();
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
        $data['list']=$this->actions_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////
        $data['dlist']=$this->look_up_model->departmentList();
        $data['heading']='Dept. & Individual Goals';
        $data['display']='hoshin/actionslist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        $data['heading']='Add Actions Info';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['display']='hoshin/Addaction';
        $this->load->view('admin/master',$data);
    }
    function edit($actions_id){
      $data['heading']='Edit Actions Info';
      $data['info']=$this->actions_model->get_info($actions_id);
      $data['dlist']=$this->look_up_model->departmentList();
      $data['display']='hoshin/Addaction';
      $this->load->view('admin/master',$data);
    }
    function save($actions_id=FALSE){
        $this->form_validation->set_rules('actions_name','Name','trim|required');
        $this->form_validation->set_rules('person_name','Person','trim|');
        $this->form_validation->set_rules('end_date','Edn Date','trim|required');
        $this->form_validation->set_rules('department_id','department','trim|required');
         if ($this->form_validation->run() == TRUE) {
          $check=$this->actions_model->save($actions_id);
          if($check &&!$actions_id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&&$actions_id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
        redirect("hoshin/actions/lists");
       }else{
          $data['heading']='Add New Actions Info';
          if($actions_id){
            $data['heading']='Edit Actions Info';
            $data['info']=$this->actions_model->get_info($actions_id);  
          }
          $data['dlist']=$this->look_up_model->departmentList();
          $data['display']='hoshin/Addaction';
          $this->load->view('admin/master',$data);
       }
    }
    ////////////////////////////
    function delete($actions_id=FALSE){
      $check=$this->actions_model->delete($actions_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("hoshin/actions/lists");
    }
    function addbulk(){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Bulk Upload';
    $data['dlist']=$this->look_up_model->departmentList();
    $data['display']='hoshin/bulkupload';
    $this->load->view('admin/master',$data);
    } else {
       redirect("logincontroller");
    }
}
function savebulk(){

   if ($_FILES['data_file']['name'] != "") {
    $configUpload['upload_path'] = FCPATH . 'asset/excel/';
    $configUpload['allowed_types'] = 'xls|xlsx|csv';
    $configUpload['max_size'] = '50000';
    $this->load->library('upload', $configUpload);
    if($this->upload->do_upload('data_file')) {
    $upload_data = $this->upload->data(); 
    $file_name = $upload_data['file_name'];
    $extension = $upload_data['file_ext']; 
    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); 
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();       
    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    $department_id=$this->input->post('department_id');
    if($totalrows>2){
    for($i = 2; $i <= $totalrows; $i++) {
        /////////////////product////////////
        $pdata=array();
        $pdata['team']=$objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
        $pdata['department_id']=$department_id;
        $pdata['departmental_goal']=$objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
        $pdata['actions_name']=$objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
        $pdata['category']=$objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
        $pdata['person_name']=$objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
        $pdata['end_date']=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(7, $i)->getValue()));
        $pdata['target_type']=$objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
        $pdata['target']=$objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
        $pdata['achievment']=$objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
        $pdata['remarks']=$objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
        $pdata['department_id']=$department_id;
        $pdata['year']=date('Y');
        $this->db->insert('actions_table',$pdata);
      }
      unlink('./asset/excel/' . $file_name); 
      $this->session->set_userdata('exception', 'Upload successfully!');
      redirect("hoshin/actions/addbulk");
    }else{
    $this->session->set_userdata('exception_err', "No data found.");
    }
    }else{
     $this->session->set_userdata('exception_err', 'File is required');
    }
    }
    redirect("hoshin/actions/addbulk");
  }
  function update(){
      $data['heading']='Update Goal';
      if($_POST){
        $data['departmental_goal']=$this->input->post('departmental_goal');
        $data['person_name']=$this->input->post('person_name');
        $data['category']=$this->input->post('category');
        $data['department_id']=$this->input->post('department_id');
        $data['lists']=$this->actions_model->getLists();
      }
      $data['dlist']=$this->look_up_model->departmentList();
      $data['display']='hoshin/update';
      $this->load->view('admin/master',$data);

    }
    function saveupdate(){
      $check=$this->actions_model->saveupdate();
      $this->session->set_userdata('exception','Update successfully');
      redirect("hoshin/actions/lists");
    }



    
 }