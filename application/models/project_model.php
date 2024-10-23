<?php
class Project_model extends CI_Model {
    function lists(){
        $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*,d.* 
            FROM project_management p
            LEFT JOIN department_info d ON(p.department_id=d.department_id)
            WHERE 1
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
    function getDetails($project_id){
        $result=$this->db->query("SELECT *
            FROM project_attachment p
            WHERE project_id=$project_id")->result();
        return $result;
    }
    function save($project_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['developed_by']=$this->input->post('developed_by');
        $data['start_date']=alterDateFormat($this->input->post('start_date'));
        $data['end_date']=alterDateFormat($this->input->post('end_date'));
        $data['priority']=$this->input->post('priority');
        $data['project_status']=$this->input->post('project_status');
        $data['development_note']=$this->input->post('development_note');
        $data['special_note']=$this->input->post('special_note');
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
        if($project_id==FALSE){
        $query=$this->db->insert('project_management',$data);
        }else{
          $this->db->WHERE('project_id',$project_id);
          $query=$this->db->update('project_management',$data);
        }
       return $query;
     
    }
  
}
