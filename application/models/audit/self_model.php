<?php
class Self_model extends CI_Model {
    function lists() {
        $department_id=$this->session->userdata('department_id');
         $result=$this->db->query("SELECT a.*,d.department_name,
            (SELECT COUNT(p.package_id) as fff FROM audit_package p 
             WHERE p.year=a.year AND a.department_id=p.department_id) as pqty,
             (SELECT COUNT(r.package_id) as dd FROM audit_result r 
             WHERE r.master_id=a.master_id AND r.score!=0) as rqty
            FROM audit_master a 
            INNER JOIN department_info d ON(d.department_id=a.department_id)
            WHERE a.by_department=$department_id AND a.status>=2
            ORDER BY a.master_id DESC")->result();
        return $result;
    }
    function get_info($master_id){
       $result=$this->db->query("SELECT a.*,d.department_name
            FROM audit_master a 
            inner join department_info d ON(d.department_id=a.department_id)
            WHERE master_id=$master_id ")->row();
        return $result;
    }

    function getallPackage($info){
      $condition='';
      $master_id=$info->master_id;
      $year=$info->year;
      $department_id=$info->department_id;
      $acategory=$info->acategory;
      if($acategory=='Departmental'){
        $condition.=" AND  s.department_id=$department_id ";
      }
  		$result=$this->db->query("SELECT s.*,h.head_name,a.score
        FROM audit_package s
        INNER JOIN audit_head h ON(h.head_id=s.head_id)
        LEFT JOIN audit_result a ON(s.package_id=a.package_id AND a.master_id=$master_id AND a.year=$year)
        WHERE  s.year=$year  AND s.acategory='$acategory' $condition 
        ORDER BY h.head_id ASC")->result();
      //print_r($result); exit();
      return $result;
    }
    function getHeadList($info){
      $condition='';
      $year=$info->year;
      $department_id=$info->department_id;
      $acategory=$info->acategory;
       if($acategory=='Departmental'){
        $condition.=" AND  s.department_id=$department_id ";
      }
      $result=$this->db->query("SELECT COUNT(s.head_id) as rowspan,h.head_name,s.head_id       
        FROM audit_package s
        INNER JOIN audit_head h ON(h.head_id=s.head_id)
        WHERE  s.year=$year  AND s.acategory='$acategory' $condition
        GROUP BY h.head_id
        ORDER BY h.head_id ASC")->result();
      //print_r($result); exit();
      return $result;
    }
    function getPakage($head_id,$year,$acategory,$department_id){
      $condition='';
      if($acategory=='Departmental'){
        $condition.=" AND  s.department_id=$department_id";
      }
      $result=$this->db->query("SELECT s.*,a.score as score1,
        b.score as score2,c.score as score3,
        d.score as score4,e.score as score5
        FROM audit_package s
        LEFT JOIN audit_result a ON(a.package_id=s.package_id AND a.department_id=$department_id 
        AND a.year=s.year AND a.quater=1)
        LEFT JOIN audit_result b ON(b.package_id=s.package_id AND b.department_id=$department_id 
        AND b.year=s.year AND b.quater=2)
        LEFT JOIN audit_result c ON(c.package_id=s.package_id AND c.department_id=$department_id 
        AND c.year=s.year AND c.quater=3)
        LEFT JOIN audit_result d ON(d.package_id=s.package_id AND d.department_id=$department_id 
        AND d.year=s.year AND d.quater=4)
        LEFT JOIN audit_result e ON(e.package_id=s.package_id AND e.department_id=$department_id 
        AND e.year=s.year AND e.quater=5)
        WHERE  s.year=$year 
        AND s.acategory='$acategory'
        AND s.head_id=$head_id $condition
        ORDER BY s.package_id ASC")->result();

      return $result;
    }

    function save($master_id) {
      $department_id=$this->db->query("SELECT a.*
            FROM audit_master a 
            WHERE master_id=$master_id")->row('department_id');

        $data=array();
        $data['completed_date']=date('Y-m-d');
        if(isset($_POST['submit'])){
          $data['status']=3;
        }
        $data['completed_by']=$this->session->userdata('user_id');
        if($master_id!=FALSE){
            $this->db->WHERE('master_id',$master_id);
            $this->db->WHERE('by_department',$department_id);
            $this->db->UPDATE('audit_master',$data);
        }
        ////////////////////////////////////////
        $this->db->WHERE('master_id',$master_id);
        $this->db->delete('audit_result');
        $i=0;
        /////////////////////////////////////////
        $year=$this->input->post('year');
        $package_id=$this->input->post('package_id');
        $score=$this->input->post('score');
        $i=0;
        $data2['department_id']=$department_id;
        $data2['year']=$year;
        $data2['quater']=$this->input->post('quater');
        foreach ($package_id as $value) {
          $data2['package_id']=$value;
          $data2['score']=$score[$i];
          $data2['master_id']=$master_id;
          $query=$this->db->insert('audit_result',$data2);
        $i++;
        }
      return $master_id;
    }
   function delete($master_id) {
     $employee_id=$this->session->userdata('employee_id');
      $this->db->WHERE('master_id',$master_id);
      $query=$this->db->delete('audit_result');
      $this->db->WHERE('employee_id',$employee_id);
      $this->db->WHERE('master_id',$master_id);
      $this->db->WHERE('period',3);
      $query=$this->db->delete('audit_master');
      return $query;
    }
    function lists2() {
        $employee_id=$this->session->userdata('employee_id');
        $result=$this->db->query("SELECT s.*,d.*,e.*
          FROM   audit_master s 
          LEFT JOIN department_info d ON(s.department_id=d.department_id)
          LEFT JOIN employee_info e ON(s.employee_id=e.employee_id)
          WHERE  s.department_id=2 AND s.period=3
          ORDER BY s.master_id DESC")->result();
        return $result;
    }
     function getdetailsChk($master_id=FALSE){
        $counts=$this->db->query("SELECT COUNT(master_id) as counts
          FROM   audit_result s 
          WHERE s.marks>0 AND  s.master_id=$master_id")->row('counts');
        return $counts;
    }
    ////////////////////////
    function get_reportresult() {
      $condition='';
      $department_id=$this->input->post('department_id');
      $designation_id=$this->input->post('designation_id');
      $service_id=$this->input->post('service_id');
        if($department_id!='All'){
          $condition.=" AND s.department_id=$department_id";
        }
        if($designation_id!='All'){
          $condition.=" AND s.designation_id='$designation_id'";
        }
        if($service_id!='All'){
          $condition.=" AND s.service_id='$service_id'";
        }
        
        $result=$this->db->query("SELECT s.*,d.department_name,dg.designation_name,sl.service_length
          FROM audit_master s 
          LEFT JOIN department_info d ON(s.department_id=d.department_id)
          LEFT JOIN designation_table dg ON(s.designation_id=dg.designation_id)
          LEFT JOIN service_table sl ON(s.service_id=sl.service_id)
          WHERE s.status=2 AND s.period=3  $condition")->result();
        return $result;
    }
    function get_Ans_Queswise($employee_id,$master_id){
      $result=$this->db->query("SELECT e.marks
          FROM   audit_result e 
          WHERE e.employee_id=$employee_id 
          AND e.master_id=$master_id")->result();
      return $result;
    }
    function getallName() {
      $result=$this->db->query("SELECT s.*,
        dg.designation_name,sl.service_length,e.*,d.department_name
        FROM   audit_master s 
        LEFT JOIN employee_info e ON(s.employee_id=e.employee_id)
        LEFT JOIN department_info d ON(s.department_id=d.department_id)
        LEFT JOIN designation_table dg ON(s.designation_id=dg.designation_id)
        LEFT JOIN service_table sl ON(s.service_id=sl.service_id)
        WHERE  s.period=3")->result();
      return $result;
    }
}
