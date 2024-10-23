<?php
class assetissue_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }
      if($this->input->get('location_id')!=''){
        $location_id=$this->input->get('location_id');
        $condition=$condition." AND sim.location_id='$location_id' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT sim.* FROM asset_issue_master sim
        INNER JOIN product_detail_info pd ON(sim.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        WHERE  sim.department_id=$department_id 
        AND sim.take_over_status=1
        $condition");
      $data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }
      if($this->input->get('location_id')!=''){
        $location_id=$this->input->get('location_id');
        $condition=$condition."  AND sim.location_id='$location_id' ";
      }
     }
     $result=$this->db->query("SELECT sim.*,pd.*,p.product_name,p.product_code,
      c.category_name,l.location_name,sim.employee_id as employee_name,d.department_name
      FROM asset_issue_master sim
      INNER JOIN product_detail_info pd ON(sim.product_detail_id=pd.product_detail_id)
      INNER JOIN product_info p ON(p.product_id=pd.product_id)
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      LEFT JOIN user u ON(u.id=sim.user_id) 
      LEFT JOIN location_info l ON(sim.location_id=l.location_id)
      LEFT JOIN department_info d ON(sim.take_department_id=d.department_id)
      WHERE  sim.department_id=$department_id 
      AND sim.take_over_status=1
        $condition
      ORDER BY sim.asset_issue_id DESC LIMIT $start,$limit")->result();
    return $result;
  }
  function get_info($asset_issue_id){
        $result=$this->db->query("SELECT sim.*,pd.*,p.product_name,p.product_code,
          c.category_name,l.location_name,e.employee_name,d.department_name
          FROM asset_issue_master sim
          LEFT JOIN location_info l ON(sim.location_id=l.location_id)
          INNER JOIN product_detail_info pd ON(sim.product_detail_id=pd.product_detail_id)
          INNER JOIN product_info p ON(p.product_id=pd.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN user u ON(u.id=sim.user_id) 
          LEFT JOIN employee_idcard_info e ON(sim.employee_id=e.employee_cardno)
          LEFT JOIN department_info d ON(sim.department_id=d.department_id)
          WHERE 1 AND sim.asset_issue_id=$asset_issue_id")->row();
        return $result;
    }
   function getStockAsset($asset_issue_id=FALSE){
    $department_id=$this->session->userdata('department_id');
        if($asset_issue_id==FALSE){
           $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.asset_encoding,')') as product_name,pd.ventura_code
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.it_status=2 AND pd.machine_other=2 
            AND pd.department_id=$department_id
            AND pd.product_detail_id NOT IN(SELECT sim.product_detail_id 
            FROM asset_issue_master sim 
            WHERE sim.issue_status=1)")->result();
        }else{
            $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.asset_encoding,')') as product_name,pd.ventura_code
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.machine_other=2
            AND pd.department_id=$department_id
            AND pd.product_detail_id NOT IN(SELECT sim.product_detail_id 
            FROM asset_issue_master sim 
            WHERE sim.issue_status=1 
            AND sim.asset_issue_id!=$asset_issue_id) GROUP BY pd.product_detail_id")->result();
        }
      return $result;
   }
   function getUNUSEDMachineList($term){
    $data=date('Y-m-d');
     $result=$this->db->query("SELECT pd.product_detail_id,
            p.product_name,pd.asset_encoding,pd.ventura_code
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.detail_status=1 
            AND pd.product_detail_id NOT IN(SELECT sim.product_detail_id 
            FROM asset_issue_master sim 
            WHERE sim.take_over_status=1) 
            AND
             (pd.ventura_code LIKE '%$term%' or pd.asset_encoding LIKE '%$term%' or p.product_name LIKE '%$term%') ")->result();
        return $result;
    }
    function save($asset_issue_id) {
      $department_id=$this->session->userdata('department_id');
        $data=array();
        $product_detail_id=$this->input->post('product_detail_id');
        $data['issue_type']=$this->input->post('issue_type');
        $data['product_detail_id']=$this->input->post('product_detail_id');
        $data['location_id']=$this->input->post('location_id');
        $data['issue_date']=alterDateFormat($this->input->post('issue_date'));
        $data['issue_purpose']=$this->input->post('issue_purpose');
        $data['issue_status']=$this->input->post('issue_status');
        if($department_id==1){
          $data['real_ip_address']=$this->input->post('real_ip_address');
          $data['ups_status']=$this->input->post('ups_status');
        }

        if($data['issue_status']!=1){
          $data['take_over_status']=2;
        }
        if($data['issue_type']==1){
          $data['location_id']=$this->input->post('location_id');
          $data['employee_id']=NULL;
          $data['take_department_id']=$this->input->post('take_department_id');
        }elseif($data['issue_type']==2){
          $data['location_id']=$this->input->post('location_id');
          $data['take_department_id']=$this->input->post('take_department_id');
          $data['employee_id']=$this->input->post('employee_id');
        }else{
          $data['take_department_id']=NULL;
          $data['employee_id']=NULL;
          $data['location_id']=$this->input->post('location_id');
        }
        $data['requisition_no']=$this->input->post('requisition_no');
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$department_id;
        if($asset_issue_id==FALSE){
          $issue_ref_no=$this->db->query("SELECT IFNULL(MAX(issue_count),0) as issue_ref_no
             FROM store_issue_master WHERE department_id=$department_id")->row('issue_ref_no');
          $issue_ref_no =date('ihdmY').str_pad($issue_ref_no + 1, 6, '0', STR_PAD_LEFT);
          $data['issue_ref_no']=$issue_ref_no+1;
          $query=$this->db->insert('asset_issue_master',$data);
          //}
        ///////////////////////
        }else{
          $this->db->WHERE('asset_issue_id',$asset_issue_id);
          $query=$this->db->update('asset_issue_master',$data);
        }
      $arraydata['it_status']=$this->input->post('issue_status');
      $arraydata['remarks']=$this->input->post('issue_purpose');
      $arraydata['assign_date']=alterDateFormat($this->input->post('issue_date'));
      $this->db->WHERE('product_detail_id',$product_detail_id);
      $this->db->update('product_detail_info',$arraydata);
      return $query;
    }
   
    function underService(){
      $asset_issue_id=$this->input->post('asset_issue_id1');
      $data2['issue_status']=3;
      $data2['return_date']=alterDateFormat($this->input->post('return_date1'));
      $data2['return_note']=$this->input->post('return_note1');
      $data2['take_over_status']=2;
      $data2['entry_check']=2;
      $this->db->where('asset_issue_id', $asset_issue_id);
      $this->db->update('asset_issue_master',$data2);
      //////////////////////////////////////////////
      $product_detail_id=$this->db->query("SELECT product_detail_id 
        FROM asset_issue_master 
        WHERE asset_issue_id=$asset_issue_id")->row('product_detail_id');
      $data1['it_status']=3;
      $data1['takeover_date']=alterDateFormat($this->input->post('return_date'));
      $data1['remarks']=$this->input->post('return_note');
      $this->db->WHERE('product_detail_id',$product_detail_id);
      $this->db->update('product_detail_info',$data1);
      return true;

    }
    function returndate(){
        $asset_issue_id=$this->input->post('asset_issue_id');
        $data2['issue_status']=$this->input->post('it_status');
        $data2['return_date']=alterDateFormat($this->input->post('return_date'));
        $data2['return_note']=$this->input->post('return_note');
        $data2['take_over_status']=2;
        $data2['entry_check']=2;
        $this->db->where('asset_issue_id', $asset_issue_id);
        $this->db->update('asset_issue_master',$data2);
        //////////////////////////////////////////////
        $product_detail_id=$this->db->query("SELECT product_detail_id FROM asset_issue_master 
          WHERE asset_issue_id=$asset_issue_id")->row('product_detail_id');
        $data1['it_status']=$this->input->post('it_status');
        $data1['takeover_date']=alterDateFormat($this->input->post('return_date'));
        $data1['remarks']=$this->input->post('return_note');
        $this->db->WHERE('product_detail_id',$product_detail_id);
        $query=$this->db->update('product_detail_info',$data1);
        /////////////////////////////////////////////
      return $query;

    }
  
    function delete($asset_issue_id) {
        $product_detail_id=$this->db->query("SELECT product_detail_id FROM asset_issue_master 
          WHERE asset_issue_id=$asset_issue_id")->row('product_detail_id');
        $data1['it_status']=2;
        $data1['takeover_date']='';
        $data1['remarks']="";
        $this->db->WHERE('product_detail_id',$product_detail_id);
        $query=$this->db->update('product_detail_info',$data1);
        $this->db->WHERE('asset_issue_id',$asset_issue_id);
        $query=$this->db->delete('asset_issue_master');
        return $query;
    }
  

  
}
