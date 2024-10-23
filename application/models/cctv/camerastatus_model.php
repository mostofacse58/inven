<?php
class Camerastatus_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('asset_encoding')!=''){
        $asset_encoding=$this->input->get('asset_encoding');
        $condition=$condition."  AND (pd.asset_encoding LIKE '%$asset_encoding%' OR pd.ventura_code LIKE '%$asset_encoding%' OR p.product_code LIKE '%$asset_encoding%') ";
      }

     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT ccs.* FROM cctv_maintain ccs
        INNER JOIN product_detail_info pd ON(ccs.product_detail_id=pd.product_detail_id)
        INNER JOIN product_info p ON(p.product_id=pd.product_id)
        WHERE ccs.cctv_status=1  $condition");
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
     
     
     }
     $result=$this->db->query("SELECT pd.*,pd.remarks as coveragearea,ccs.*,p.product_name,p.product_code,l.location_name
      FROM cctv_maintain ccs
      INNER JOIN product_detail_info pd ON(ccs.product_detail_id=pd.product_detail_id)
      INNER JOIN product_info p ON(p.product_id=pd.product_id)
      INNER JOIN location_info l ON(ccs.location_id=l.location_id)
      LEFT JOIN user u ON(u.id=ccs.create_id) 
      WHERE ccs.cctv_status=1  $condition
      ORDER BY ccs.cctv_main_id DESC LIMIT $start,$limit")->result();
    return $result;
  }
    function get_info($cctv_main_id){
        $result=$this->db->query("SELECT ccs.*
          FROM cctv_maintain ccs
          WHERE  ccs.cctv_main_id=$cctv_main_id")->row();
        return $result;
    }
   function getCCTVList($cctv_main_id=FALSE){
        if($cctv_main_id==FALSE){
           $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.asset_encoding,')') as product_name
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.it_status=1 AND pd.machine_other=2 
            AND p.category_id=83
            AND pd.product_detail_id NOT IN(SELECT ccs.product_detail_id 
            FROM cctv_maintain ccs 
            WHERE ccs.cctv_status=1)")->result();
        }else{
            $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(p.product_name,' (',pd.asset_encoding,')') as product_name
            FROM product_detail_info pd, product_info p
            WHERE pd.product_id=p.product_id AND pd.it_status=1  AND pd.machine_other=2
            AND p.category_id=83
            AND pd.product_detail_id NOT IN(SELECT ccs.product_detail_id 
            FROM cctv_maintain ccs 
            WHERE ccs.cctv_status=1 
            AND ccs.cctv_main_id!=$cctv_main_id) GROUP BY pd.product_detail_id")->result();
        }
      return $result;
   }

    function save($cctv_main_id) {
      $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['cctv_status']=$this->input->post('cctv_status');
        $data['product_detail_id']=$this->input->post('product_detail_id');
        $data['start_date']=alterDateFormat($this->input->post('start_date'));
        $data['start_time']=$this->input->post('start_time');
        $data['end_date']=alterDateFormat($this->input->post('end_date'));
        $data['end_time']=$this->input->post('end_time');
        $data['remarks']=$this->input->post('remarks');
        $data['location_id']=$this->input->post('location_id');
        if($data['cctv_status']==1){
          $data['create_id']=$this->session->userdata('user_id');
        }elseif($data['cctv_status']==2){
          $data['repair_note']=$this->input->post('repair_note');
          $data['repair_by_id']=$this->session->userdata('user_id');
        }
        $data['department_id']=$department_id;
        if($cctv_main_id==FALSE){
          $ref_no=$this->db->query("SELECT IFNULL(MAX(cctv_main_id),0) as ref_no
             FROM cctv_maintain WHERE 1")->row('ref_no');
          $ref_no =date('ihdmY').str_pad($ref_no + 1, 6, '0', STR_PAD_LEFT);
          $data['ref_no']=$ref_no;
          $query=$this->db->insert('cctv_maintain',$data);
          ///////////////////////
        }else{
          $this->db->WHERE('cctv_main_id',$cctv_main_id);
          $query=$this->db->update('cctv_maintain',$data);
        }
      return $query;
    }
   
    function underService(){
        $cctv_main_id=$this->input->post('cctv_main_id1');
        $data2['cctv_status']=3;
        $data2['return_date']=alterDateFormat($this->input->post('return_date1'));
        $data2['return_note']=$this->input->post('return_note1');
        $data2['take_over_status']=2;
        $this->db->where('cctv_main_id', $cctv_main_id);
        $this->db->update('cctv_maintain',$data2);
        //////////////////////////////////////////////
        $product_detail_id=$this->db->query("SELECT product_detail_id FROM cctv_maintain 
          WHERE cctv_main_id=$cctv_main_id")->row('product_detail_id');
        $data1['it_status']=3;
        $data1['return_date']=alterDateFormat($this->input->post('return_date'));
        $data1['remarks']=$this->input->post('return_note');
        $this->db->WHERE('product_detail_id',$product_detail_id);
        $this->db->update('product_detail_info',$data1);
      return $query;

    }
    function returndate(){
        $cctv_main_id=$this->input->post('cctv_main_id');
        $data2['cctv_status']=2;
        $data2['return_date']=alterDateFormat($this->input->post('return_date'));
        $data2['return_note']=$this->input->post('return_note');
        $data2['take_over_status']=2;
        $this->db->where('cctv_main_id', $cctv_main_id);
        $this->db->update('cctv_maintain',$data2);
        //////////////////////////////////////////////
        $product_detail_id=$this->db->query("SELECT product_detail_id FROM cctv_maintain 
          WHERE cctv_main_id=$cctv_main_id")->row('product_detail_id');
        $data1['it_status']=2;
        $data1['takeover_date']=alterDateFormat($this->input->post('return_date'));
        $data1['remarks']=$this->input->post('return_note');
          $this->db->WHERE('product_detail_id',$product_detail_id);
          $this->db->update('product_detail_info',$data1);
        /////////////////////////////////////////////
      return $query;

    }
  
    function delete($cctv_main_id) {
        $this->db->WHERE('cctv_main_id',$cctv_main_id);
        $query=$this->db->delete('cctv_maintain');
        return $query;
    }
   function getlocation($product_detail_id) {
       $result=$this->db->query("SELECT l.location_name
          FROM asset_issue_master sim,location_info l
          WHERE sim.location_id=l.location_id AND sim.issue_status=1 
          AND sim.product_detail_id=$product_detail_id ")->row('location_name');
       if(count($result)>0)
        return $result;
       else return "";
    }

  
}
