<?php
class Psubmit_model extends CI_Model {

    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*,d.* 
            FROM project_management p
            LEFT JOIN department_info d ON(p.department_id=d.department_id)
            WHERE p.department_id=$department_id
            ORDER BY p.project_id DESC")->result();
        return $result;
    }

    
    function get_info($project_id){
        $result=$this->db->query("SELECT p.*,d.* 
            FROM project_management p
            LEFT JOIN department_info d ON(p.department_id=d.department_id)
            WHERE project_id=$project_id")->row();
        return $result;
    }
    function save($project_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['project_name']=$this->input->post('project_name');
        $data['department_id']=$department_id;
        $data['p_type']=$this->input->post('p_type');
        if($data['p_type']=='MODIFY')
            $data['parent_id']=$this->input->post('parent_id');
        $data['project_coordinator']=$this->input->post('project_coordinator');
        $data['project_coordinator2']=$this->input->post('project_coordinator2');
        $data['project_requirement']=$this->input->post('project_requirement');
        $data['create_date']=date('Y-m-d');
        $data['priority']=$this->input->post('priority');
        $data['project_status']=1;
        $data['user_id']=$this->session->userdata('user_id');
        if($this->input->post('manpower')=='YES'){
            $data['manpower']=$this->input->post('manpower');
        }else{
           $data['manpower']='NO'; 
        }
        if($this->input->post('money')=='YES'){
            $data['money']=$this->input->post('money');
        }else{
           $data['money']='NO'; 
        }
        if($this->input->post('quality')=='YES'){
            $data['quality']=$this->input->post('quality');
        }else{
           $data['quality']='NO'; 
        }
        if($this->input->post('times')=='YES'){
            $data['times']=$this->input->post('times');
        }else{
           $data['times']='NO'; 
        }
        // if($_FILES['attachemnt_file']['name']!=""){
        // $config['upload_path'] = './project/';
        // $config['allowed_types'] = 'pdf|PDF|xlsx|xls|jpg|jpeg|png';
        // $config['max_size'] = '300000';
        // $config['encrypt_name'] = TRUE;
        // $config['detect_mime'] = TRUE;
        // $this->load->library('upload', $config);
        // if ($this->upload->do_upload("attachemnt_file")){
        //   $upload_info = $this->upload->data();
        //   $data['attachemnt_file']=$upload_info['file_name'];
        // }}
        
        if($project_id==FALSE){
        $query=$this->db->insert('project_management',$data);
        $project_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('project_id',$project_id);
          $query=$this->db->update('project_management',$data);
          
        }
        $count = count($_FILES['attachemnt_file']['name']);
        if($count>0){
            $this->db->WHERE('project_id',$project_id);
            $query=$this->db->delete('project_attachment');
        }
        for($i=0;$i<$count;$i++){
        if(!empty($_FILES['attachemnt_file']['name'][$i])){
          $_FILES['file']['name'] = $_FILES['attachemnt_file']['name'][$i];
          $_FILES['file']['type'] = $_FILES['attachemnt_file']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['attachemnt_file']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['attachemnt_file']['error'][$i];
          $_FILES['file']['size'] = $_FILES['attachemnt_file']['size'][$i];

          $config['upload_path'] = 'project/'; 
          $config['allowed_types'] = 'pdf|PDF|xlsx|xls|jpg|jpeg|png';
          $config['max_size'] = '5000';
          $config['file_name'] = $_FILES['attachemnt_file']['name'][$i];
          $this->load->library('upload',$config); 
          if($this->upload->do_upload('file')){
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];
            $data3['project_id'] = $project_id;
            $data3['attachemnt_file'] = $filename;
            $data3['department_id'] = $department_id;
            $this->db->insert('project_attachment',$data3);
          }
        }
        }
       return $query;
     
    }
    function delete($project_id) {
        $this->db->WHERE('project_id',$project_id);
        $query=$this->db->delete('project_management');
        $this->db->WHERE('project_id',$project_id);
        $query=$this->db->delete('project_attachment');
        return $query;
  }

  
}
