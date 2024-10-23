<?php
class Downtime_model extends CI_Model{
   public function get_count(){
    $condition=' ';
    if(isset($_POST)){
      if($this->input->post('tpm_serial_code')!=''){
      $tpm_serial_code=$this->input->post('tpm_serial_code');
      $condition=$condition."  AND (md.product_status_id='$tpm_serial_code') ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT  md.*
          FROM machine_downtime_info md 
          WHERE md.department_id=12  AND md.time_status=1 $condition");
      $data = count($query->result());
      return $data;
    }

  public  function lists($limit,$start){
     $condition=' ';
      if(isset($_POST)){
        if($this->input->post('tpm_serial_code')!=''){
        $tpm_serial_code=$this->input->post('tpm_serial_code');
        $condition=$condition."  AND (pd.tpm_serial_code='$tpm_serial_code' OR pd.ventura_code='$tpm_serial_code') ";
        }
       }
      $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT md.*,fl.line_no,p.product_name,pd.tpm_serial_code
          FROM machine_downtime_info md 
          INNER JOIN product_detail_info pd ON(md.product_status_id=pd.tpm_serial_code)
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN floorline_info fl ON(md.line_id=fl.line_no)
          WHERE md.department_id=12  AND md.time_status=1 $condition
          ORDER BY md.machine_downtime_id DESC LIMIT $start,$limit ")->result();
      return $result;
    }
 
    function get_info($machine_downtime_id){
        $result=$this->db->query("SELECT  md.*,ps.takeover_date,ps.takeover_date,
          fl.line_no,s.supervisor_name,m.me_name,p.product_name,pd.tpm_serial_code
          FROM machine_downtime_info md 
          INNER JOIN product_status_info ps ON(md.product_status_id=ps.product_status_id)
          INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
          INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          LEFT JOIN supervisor_info s ON(md.supervisor_id=s.supervisor_id)
          LEFT JOIN me_info m ON(md.me_id=m.me_id) 
          WHERE md.machine_downtime_id=$machine_downtime_id")->row();
        return $result;
    }
   function getMachineLine(){
           $result=$this->db->query("SELECT ps.product_status_id,
            CONCAT(p.product_name,' (',pd.tpm_serial_code,') (',fl.line_no,')') as product_name
            FROM product_status_info ps
            INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
            INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
            INNER JOIN product_info p ON(p.product_id=pd.product_id)
            WHERE ps.machine_status='USED' and ps.department_id=12")->result();
          return $result;
   }
   
    function save($machine_downtime_id) {
        $data=array();
        $data['line_id']=$this->input->post('line_id');
        $data['product_status_id']=$this->input->post('product_status_id');
        $data['down_date']=alterDateFormat($this->input->post('down_date'));
        $data['problem_start_time']=$this->input->post('problem_start_time');
        $data['me_response_time']=$this->input->post('me_response_time');
        $data['problem_end_time']=$this->input->post('problem_end_time');
        $data['problem_description']=$this->input->post('problem_description');
        $data['action_taken']=$this->input->post('action_taken');
        $data['supervisor_id']=$this->input->post('supervisor_id');
        $data['me_id']=$this->input->post('me_id');
        $data['total_minuts']=$this->input->post('total_minuts');
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=12;
        $data['create_date']=date('Y-m-d');
        if($machine_downtime_id==FALSE){
          $query=$this->db->insert('machine_downtime_info',$data);
        }else{
          $this->db->WHERE('machine_downtime_id',$machine_downtime_id);
          $query=$this->db->update('machine_downtime_info',$data);
        }
      return $query;
    }
    ////////////// save Excel ///////////
    function saveExcel($downtimedata) {
      //print_r($downtimedata); exit();
        $downtimedata['user_id']=$this->session->userdata('user_id');
        $downtimedata['department_id']=12;
        $dadowntimedatata['create_date']=date('Y-m-d');
        $query=$this->db->insert('machine_downtime_info',$downtimedata);
      return $query;
    }
    function getProductStatusId($line_id,$tpm_serial_code){
     $product_status_id=$this->db->query("SELECT ps.product_status_id
      FROM product_status_info ps
      INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
      INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
      INNER JOIN product_info p ON(p.product_id=pd.product_id)
      WHERE ps.machine_status=1 AND ps.department_id=12 
      AND ps.line_id=$line_id AND 
      pd.tpm_serial_code='$tpm_serial_code' ")->row('product_status_id');
     return $product_status_id;
   }
    function getFloorLine(){
      $result=$this->db->query("SELECT * FROM floorline_info WHERE line_no!='EGM'
        ORDER BY line_no ASC")->result();
      return $result;
    }
  
    function delete($machine_downtime_id) {
        $this->db->WHERE('machine_downtime_id',$machine_downtime_id);
        $query=$this->db->delete('machine_downtime_info');
        return $query;
  }
  

  
}
