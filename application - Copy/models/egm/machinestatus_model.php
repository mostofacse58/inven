<?php
class Machinestatus_model extends CI_Model {
  public function get_count(){
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_POST){
      if($this->input->post('tpm_serial_code')!=''){
        $tpm_serial_code=$this->input->post('tpm_serial_code');
        $condition=$condition."  AND (pd.tpm_serial_code LIKE '%$tpm_serial_code%' OR pd.ventura_code LIKE '%$tpm_serial_code%' OR p.product_code LIKE '%$tpm_serial_code%' OR mt.machine_type_name LIKE '%$tpm_serial_code%') ";
      }
      if($this->input->post('line_id')!=''){
        $line_id=$this->input->post('line_id');
        $condition=$condition." AND ps.line_id='$line_id' ";
      }
      $this->session->set_userdata('machinestatus',$condition);
     }
      if($this->session->userdata('machinestatus')!=' '){
        $condition=$this->session->userdata('machinestatus');
      }
   $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT ps.* FROM product_status_info ps
        INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
        WHERE ps.take_over_status=1 AND ps.department_id=$department_id $condition");
      $data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_POST){
      if($this->input->post('tpm_serial_code')!=''){
        $tpm_serial_code=$this->input->post('tpm_serial_code');
        $condition=$condition."  AND (pd.tpm_serial_code LIKE '%$tpm_serial_code%' OR pd.ventura_code LIKE '%$tpm_serial_code%' OR p.product_code LIKE '%$tpm_serial_code%' OR mt.machine_type_name LIKE '%$tpm_serial_code%') ";
      }
      if($this->input->post('line_id')!=''){
        $line_id=$this->input->post('line_id');
        $condition=$condition."  AND ps.line_id='$line_id' ";
      }
      $this->session->set_userdata('machinestatus',$condition);
     }
     if($this->session->userdata('machinestatus')!=' '){
      $condition=$this->session->userdata('machinestatus');
     }
    $result=$this->db->query("SELECT ps.*,pd.*,p.product_name,p.product_code,
      c.category_name,mt.machine_type_name,fl.line_no
      FROM product_status_info ps
      INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
      INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
      INNER JOIN product_info p ON(p.product_id=pd.product_id)
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
      LEFT JOIN user u ON(u.id=ps.user_id) 
      WHERE ps.take_over_status=1 $condition
      ORDER BY ps.product_status_id DESC LIMIT $start,$limit")->result();
    return $result;
  }
    function get_info($product_status_id){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT ps.*,pd.*,p.product_name,p.product_code,
          c.category_name,mt.machine_type_name,fl.line_no
          FROM product_status_info ps
          INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
          INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
          LEFT JOIN user u ON(u.id=ps.user_id) 
          WHERE 1 AND 
           ps.product_status_id=$product_status_id")->row();
        return $result;
    }
   function getUNUSEDMachine($product_status_id=FALSE){
    $department_id=$this->session->userdata('department_id');
        if($product_status_id==FALSE){
           $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.tpm_serial_code,')') as product_name
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.detail_status=1
            AND pd.product_detail_id NOT IN(SELECT ps.product_detail_id 
            FROM product_status_info ps 
            WHERE ps.take_over_status=1)")->result();
        }else{
            $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.tpm_serial_code,')') as product_name
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.detail_status=1
            AND pd.product_detail_id NOT IN(SELECT ps.product_detail_id 
            FROM product_status_info ps 
            WHERE ps.take_over_status=1 
            AND ps.product_status_id!=$product_status_id)")->result();
        }
        return $result;
   }
   function getUNUSEDMachineList($term) {
    $department_id=$this->session->userdata('department_id');
    $data=date('Y-m-d');
     $result=$this->db->query("SELECT pd.product_detail_id,
            p.product_name,pd.tpm_serial_code,pd.ventura_code
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.detail_status=1
            AND pd.product_detail_id NOT IN(SELECT ps.product_detail_id 
            FROM product_status_info ps 
            WHERE ps.take_over_status=1) AND (pd.ventura_code LIKE '%$term%' or pd.tpm_serial_code LIKE '%$term%' or p.product_name LIKE '%$term%') ")->result();
        return $result;
    }
    function save($product_status_id) {
      $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['product_detail_id']=$this->input->post('product_detail_id');
        $data['line_id']=$this->input->post('line_id');
        $data['assign_date']=alterDateFormat($this->input->post('assign_date'));
        $data['note']=$this->input->post('note');
        $data['machine_status']=$this->input->post('machine_status');
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        if($product_status_id==FALSE){
          $query=$this->db->insert('product_status_info',$data);
        }else{
          $this->db->WHERE('product_status_id',$product_status_id);
          $query=$this->db->update('product_status_info',$data);
        }
      return $query;
    }
    function save2() {
      $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['assign_date']=alterDateFormat($this->input->post('assign_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['line_id']=$this->input->post('line_id');
        $data['department_id']=$department_id;
        $product_detail_id=$this->input->post('product_detail_id');
        $machine_status=$this->input->post('machine_status');
        $i=0;
        foreach ($product_detail_id as $value) {
           $data['product_detail_id']=$value;
           $data['machine_status']=$machine_status[$i];
           //$data['line_id']=$line_id[$i];
           $query=$this->db->insert('product_status_info',$data);
           $i++;
        }
        return $query;
    }

    function getFloorLine(){
      $result=$this->db->query("SELECT * FROM floorline_info 
        WHERE line_no!='EGM' ORDER BY line_no ASC")->result();
      return $result;
    }
    function idle($product_status_id){
      $department_id=$this->session->userdata('department_id');
        $data2['take_over_status']=2;
        $data2['takeover_date']=date('Y-m-d');
        $this->db->where('product_status_id', $product_status_id);
        $this->db->update('product_status_info',$data2);
        $info=$this->db->query("SELECT * FROM  product_status_info 
          WHERE product_status_id=$product_status_id")->row();

        $data=array();
        $data['product_detail_id']=$info->product_detail_id;
        $data['line_id']=$info->line_id;
        $data['assign_date']=date('Y-m-d');
        $data['machine_status']=2;
        $data['note']=$info->note;
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        $query=$this->db->insert('product_status_info',$data);
      return $query;

    }
    function underservice(){
      $department_id=$this->session->userdata('department_id');
        $product_status_id=$this->input->post('product_status_id');
        $data2['take_over_status']=2;
        $data2['takeover_date']=alterDateFormat($this->input->post('takeover_date'));
        $data2['note']=$this->input->post('note');
        $this->db->where('product_status_id', $product_status_id);
        $this->db->update('product_status_info',$data2);
        $info=$this->db->query("SELECT * FROM  product_status_info 
          WHERE product_status_id=$product_status_id")->row();

        $data=array();
        $data['product_detail_id']=$info->product_detail_id;
        $data['line_id']=$info->line_id;
        $data['assign_date']=alterDateFormat($this->input->post('takeover_date'));
        $data['machine_status']=3;
        $data['note']=$info->note;
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        $query=$this->db->insert('product_status_info',$data);
      return $query;

    }
  
    function delete($product_status_id) {
      $department_id=$this->session->userdata('department_id');
        $this->db->WHERE('product_status_id',$product_status_id);
        $query=$this->db->delete('product_status_info');
        return $query;
  }
  

  
}
