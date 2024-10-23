<?php
class Schedule_model extends CI_Model {

    function lists(){
        
        $result=$this->db->query("SELECT a.*,d.department_name
            FROM audit_master a 
            inner join department_info d ON(d.department_id=a.department_id)
            ORDER BY a.master_id DESC")->result();
        return $result;
    }

    
    function get_info($master_id){
        $result=$this->db->query("SELECT * FROM audit_master 
            WHERE master_id=$master_id ")->row();
        return $result;
    }
    function save($master_id=FALSE){
        $data=array();
        $data['quater']=$this->input->post('quater');
        $data['acategory']=$this->input->post('acategory');
        $data['atype']=$this->input->post('atype');
        $data['start_date']=alterDateFormat($this->input->post('start_date'));
        $data['end_date']=alterDateFormat($this->input->post('end_date'));
        $data['year']=$this->input->post('year');
        $data['department_id']=$this->input->post('department_id');
        $data['by_department']=$this->input->post('by_department');
        $data['note']=$this->input->post('note');
        $data['status']=1;
        $data['user_id']=$this->session->userdata('user_id');
        $data['create_date']=date('Y-m-d');
        if($master_id==FALSE){
        $query=$this->db->insert('audit_master',$data);
        }else{
          $this->db->WHERE('master_id',$master_id);
          $query=$this->db->update('audit_master',$data);
        }
       return $query;
     
    }
    function delete($master_id) {
        $this->db->WHERE('master_id',$master_id);
        $query=$this->db->delete('audit_master');
        return $query;
    }
    function send($master_id) {
     $data['status']=2;
      $this->db->WHERE('master_id',$master_id);
      $query=$this->db->update('audit_master',$data);
    return $query;
    }

  
}
