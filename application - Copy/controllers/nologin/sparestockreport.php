<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sparestockreport extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/sparestockreport_model');
     }
    function reportResult($department_id=FALSE){
        $data['heading']='Spares Stock Report ';
        $data['department_id']=$department_id;
        $data['resultdetail']=$this->sparestockreport_model->reportResult($department_id);
        //print_r($data['resultdetail']);
        //exit();
        $this->load->view('nologin/sparestockreport',$data);
    }
   function stock(){
        $data['heading']='Stock Report ';
        $data['resultdetail']=$this->db->query("SELECT d.*,
        (SELECT IFNULL(SUM(p1.main_stock),0) as dd FROM product_info p1
        WHERE p1.department_id=d.department_id AND p1.product_type=2) as totalqty,
        (SELECT IFNULL(SUM(p2.main_stock*p2.unit_price),0) as aaa 
        FROM product_info p2
        WHERE p2.department_id=d.department_id AND p2.product_type=2) as totalamount
        FROM department_info d 
        WHERE d.stock_holder=1 ")->result();
        $this->load->view('nologin/stockqtyandvalue',$data);
    }
}