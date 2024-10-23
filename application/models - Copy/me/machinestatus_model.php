<?php
class Machinestatus_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('tpm_serial_code')!=''){
        $tpm_serial_code=$this->input->get('tpm_serial_code');
        $condition=$condition."  AND (pd.tpm_serial_code LIKE '%$tpm_serial_code%' OR pd.ventura_code LIKE '%$tpm_serial_code%' OR p.product_code LIKE '%$tpm_serial_code%' OR mt.machine_type_name LIKE '%$tpm_serial_code%') ";
      }
      if($this->input->get('line_id')!=''){
        $line_id=$this->input->get('line_id');
        $condition=$condition." AND ps.line_id='$line_id' ";
      }
     }
   $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT ps.* FROM product_status_info ps
        INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
        WHERE ps.take_over_status=1 AND ps.department_id=12 $condition");
      $data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_GET){
      if($this->input->get('tpm_serial_code')!=''){
        $tpm_serial_code=$this->input->get('tpm_serial_code');
        $condition=$condition."  AND (pd.tpm_serial_code LIKE '%$tpm_serial_code%' OR pd.ventura_code LIKE '%$tpm_serial_code%' OR p.product_code LIKE '%$tpm_serial_code%' OR mt.machine_type_name LIKE '%$tpm_serial_code%') ";
      }
      if($this->input->get('line_id')!=''){
        $line_id=$this->input->get('line_id');
        $condition=$condition."  AND ps.line_id='$line_id' ";
      }
     }
    $result=$this->db->query("SELECT ps.*,pd.*,ps.takeover_date,ps.assign_date,ps.machine_status,
      p.product_name,p.product_code,
        c.category_name,mt.machine_type_name
        FROM product_status_info ps
        INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        LEFT JOIN machine_type mt ON(p.machine_type_id=mt.machine_type_id)
        LEFT JOIN user u ON(u.id=ps.user_id) 
        WHERE ps.take_over_status=1 $condition
        ORDER BY ps.machine_status DESC
        LIMIT $start,$limit")->result();
      return $result;
    }
    function get_info($product_status_id){
        $result=$this->db->query("SELECT ps.*,pd.*,
          p.product_name,p.product_code,
          c.category_name,mt.machine_type_name
          FROM product_status_info ps
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
            AND pd.department_id=12 AND pd.machine_other=1
            AND pd.product_detail_id NOT IN(SELECT ps.product_detail_id 
            FROM product_status_info ps 
            WHERE ps.take_over_status=1)")->result();
        }else{
            $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.tpm_serial_code,')') as product_name
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.detail_status=1 
            AND pd.department_id=12 AND pd.machine_other=1
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
        p.product_name,pd.tpm_serial_code,pd.ventura_code,
        ps.assign_date_time,ps.product_status_id,
        ps.from_location_name,ps.to_location_name,ps.machine_status,
        p.product_name,p.product_code

        FROM product_status_info ps
        INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(pd.product_id=p.product_id)
        WHERE pd.department_id=12  AND ps.take_over_status=1
        AND (pd.ventura_code LIKE '%$term%' or pd.tpm_serial_code LIKE '%$term%' or p.product_name LIKE '%$term%') ")->result();
        ///////////////////////////////////////////
        if(count($result)<1){
          $result=$this->db->query("SELECT pd.product_detail_id,
            p.product_name,pd.tpm_serial_code,pd.ventura_code,
            0 as product_status_id,
            'CENTRAL GODOWN' as to_location_name,
            pd.takeover_date as assign_date_time,
            pd.tpm_status as machine_status,
            p.product_name,p.product_code
            FROM product_detail_info pd
            INNER JOIN product_info p ON(pd.product_id=p.product_id)
            WHERE pd.department_id=12  
            AND (pd.ventura_code LIKE '%$term%' or pd.tpm_serial_code LIKE '%$term%' or p.product_name LIKE '%$term%') ")->result();
        }
      return $result;
    }
  function getAssignMachineList($term) {
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT ps.product_status_id,fl.line_no,
            p.product_name,pd.tpm_serial_code,pd.ventura_code 
            FROM product_status_info ps,product_detail_info pd, 
            product_info p,floorline_info fl
            WHERE pd.product_id=p.product_id 
            AND ps.product_detail_id=pd.product_detail_id
            AND ps.take_over_status=1 AND ps.line_id=fl.line_id
            AND (pd.ventura_code LIKE '%$term%' or pd.tpm_serial_code LIKE '%$term%' or p.product_name LIKE '%$term%')")->result();
        return $result;
    }
    function save($product_status_id) {
        $data=array();
        $data['product_detail_id']=$this->input->post('product_detail_id');
        $data['line_id']=$this->input->post('line_id');
        $data['assign_date']=alterDateFormat($this->input->post('assign_date'));
        $data['note']=$this->input->post('note');
        $data['machine_status']=$this->input->post('machine_status');
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=12;
        ////////////////////////
        $product_detail_id=$this->input->post('product_detail_id');
        $line_id=$this->input->post('line_id');
        $assign_date=alterDateFormat($this->input->post('assign_date'));
        $info=$this->db->query("SELECT * FROM product_status_info 
          WHERE product_detail_id=$product_detail_id AND line_id=$line_id 
          AND assign_date='$assign_date'")->result();
        ////////////
        if($product_status_id==FALSE){
          if(count($info)<1){
            $query=$this->db->insert('product_status_info',$data);
          }          
        }else{
          $this->db->WHERE('product_status_id',$product_status_id);
          $query=$this->db->update('product_status_info',$data);
        }
        $product_detail_id=$this->input->post('product_detail_id');
        $data2['tpm_status']=$this->input->post('machine_status');
        $data2['line_id']=$this->input->post('line_id');
        $data2['assign_date']=alterDateFormat($this->input->post('assign_date'));
        $data2['takeover_date']=NULL;
        $this->db->WHERE('product_detail_id',$product_detail_id);
        $query=$this->db->update('product_detail_info',$data2);

      return $query;
    }
    function save2() {
        $data=array();
        //////////////
        $data2['assign_date']=alterDateFormat($this->input->post('assign_date'));
        //////////////////////
        $product_detail_id=$this->input->post('product_detail_id');
        $machine_status=$this->input->post('machine_status');
        $product_status_id=$this->input->post('product_status_id');
        $from_location_name=$this->input->post('from_location_name');
        $to_location_name=$this->input->post('to_location_name');
        $ventura_code=$this->input->post('ventura_code');
        $tpm_serial_code=$this->input->post('tpm_serial_code');
        $ventura_code=$this->input->post('ventura_code');
        $i=0;
        foreach ($product_detail_id as $value) {
          $data['product_detail_id']=$value;
          $data['user_id']=$this->session->userdata('user_id');
          $data['department_id']=12;
          $data['assign_date']=alterDateFormat($this->input->post('assign_date'));
          $data['assign_date_time']=$data['assign_date'].date(" H:i:s");
          $data['machine_status']=$machine_status[$i];
          $data['from_location_name']=$from_location_name[$i];
          $data['to_location_name']=$to_location_name[$i];
          $data['line_id']=getLineId($data['to_location_name']);
          $data['ventura_code']=$ventura_code[$i];
          $query=$this->db->insert('product_status_info',$data);
          //////////////////////////
          $productstatusid=$product_status_id[$i];
          if($productstatusid!=0){
            $tdata['takeover_date']=date('Y-m-d');
            $tdata['takeover_date_time']=date('Y-m-d H:i:s');
            $tdata['take_over_status']=2;
            $this->db->WHERE('product_status_id',$productstatusid);
            $this->db->update('product_status_info',$tdata);
          }
          //////////////////////////
          $data3['tpm_status']=$data['machine_status'];
          $data3['line_id']=$data['line_id'];
          $data3['assign_date']=date('Y-m-d');
          $data3['takeover_date']=alterDateFormat($this->input->post('assign_date'));
          $this->db->WHERE('product_detail_id',$value);
          $query=$this->db->update('product_detail_info',$data3);
          $i++;
        }
        return $query;
    }
    function savemultipletake() {
        $data=array();
        $data['take_over_status']=2;
        $data['takeover_date']=alterDateFormat($this->input->post('takeover_date'));
        $data['takeover_man']=$this->session->userdata('user_id');
        //////////////
        $data3['tpm_status']=2;
        $data3['line_id']=NULL;
        $data3['assign_date']=NULL;
        $data3['takeover_date']=alterDateFormat($this->input->post('takeover_date'));
        //////////////////////
        $product_status_id=$this->input->post('product_status_id');
        $i=0;
        foreach ($product_status_id as $value) {
          $query=$this->db->insert('product_status_info',$data);
          $this->db->where('product_status_id', $value);
          $this->db->update('product_status_info',$data);
          $info=$this->db->query("SELECT * FROM  product_status_info 
          WHERE product_status_id=$value")->row();
          //////////////////////////
          $product_detail_id=$info->product_detail_id;
          $this->db->WHERE('product_detail_id',$product_detail_id);
          $query=$this->db->update('product_detail_info',$data3);
          //////////////////////
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
        $data['department_id']=12;
        $query=$this->db->insert('product_status_info',$data);
        ////////////////
        $product_detail_id=$info->product_detail_id;
        $data3['tpm_status']=2;
        $data3['line_id']=$info->line_id;
        $data3['assign_date']=date('Y-m-d');
        $this->db->WHERE('product_detail_id',$product_detail_id);
        $query=$this->db->update('product_detail_info',$data3);
      return $query;

    }
    function underservice(){
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
        $data['department_id']=12;
        $query=$this->db->insert('product_status_info',$data);
        ////////////////
        $product_detail_id=$info->product_detail_id;
        $data3['tpm_status']=3;
        $data3['assign_date']=alterDateFormat($this->input->post('takeover_date'));;
        $this->db->WHERE('product_detail_id',$product_detail_id);
        $query=$this->db->update('product_detail_info',$data3);
      return $query;

    }
  
    function delete($product_status_id) {
        $this->db->WHERE('product_status_id',$product_status_id);
        $query=$this->db->delete('product_status_info');
        return $query;
  }
  

  
}
