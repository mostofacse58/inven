<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Requisitionstatus extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/requisitionstatus_model');
     }
    function reportResult($department_id=FALSE){
        $data['heading']='Requisition Report ';
        $data['department_id']=$department_id;
        $data['resultdetail']=$this->requisitionstatus_model->reportResult($department_id);
        $this->load->view('nologin/requisitionstatus',$data);
    }
    function stockholder(){
        $data['heading']='Safety Stock Holder Dept';
        $data['resultdetail']=$this->db->query("SELECT d.*,
        (SELECT count(r.requisition_id) as aaa FROM requisition_master r 
        WHERE r.responsible_department=d.department_id) as totalreq,
        (SELECT IFNULL(SUM(id.quantity),0) as dd FROM store_issue_master s,
        item_issue_detail id 
        WHERE s.department_id=d.department_id AND s.issue_id=id.issue_id 
        AND s.issue_date BETWEEN '2019-02-01' AND  '2019-02-31') as totalqty,
        (SELECT IFNULL(SUM(id1.sub_total),0) as dd FROM store_issue_master s1,item_issue_detail id1 
        WHERE s1.department_id=d.department_id 
        AND s1.issue_id=id1.issue_id AND s1.issue_date BETWEEN '2019-02-01' AND  '2019-02-31') as totalamount
        FROM department_info d 
        WHERE d.stock_holder=1 AND d.department_id!=12")->result();
        $this->load->view('nologin/holderdepartment',$data);
    }
  
}