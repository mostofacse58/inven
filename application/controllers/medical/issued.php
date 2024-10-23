<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Issued extends My_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('medical/issued_model');
     }
    function lists(){
      $data=array();
        if($this->session->userdata('user_id')) {
          $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'medical/issued/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->issued_model->get_count();
        $total_rows=$config['total_rows'];
        $config['per_page'] = $perpage;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = 2;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo Prev</span>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">Next »</span>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = "</a></li>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
      //////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->issued_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        ////////////////////////////
        $data['heading']='Medical Issued List';
        $data['display']='medical/issuedlist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
       }
    function add(){
        $data['heading']='Add Issue';
        $data['collapse']='YES';
        $data['clist']=$this->look_up_model->clist();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['llist']=$this->look_up_model->getlocation();
        $data['slist']=$this->look_up_model->getSymptom();
        $data['ilist']=$this->look_up_model->getInjury();
        $data['display']='medical/addissued';
        $this->load->view('admin/master',$data);
    }
    function edit($issue_id){
        $data['heading']='Edit Issue';
        $data['collapse']='YES';
        $data['clist']=$this->look_up_model->clist();
        $data['info']=$this->issued_model->get_info($issue_id);
        $data['dlist']=$this->look_up_model->departmentList();
        $data['detail']=$this->issued_model->getDetails($issue_id);
        $data['llist']=$this->look_up_model->getlocation();
        $data['slist']=$this->look_up_model->getSymptom();
        $data['sdetail'] = $this->issued_model->getSymptom($issue_id);
        $data['display']='medical/addissued';
        $this->load->view('admin/master',$data);
        
    }
    function searchemployee(){
       $item=$this->input->post('item');
       $department_id=$this->input->post('department_id');
        $data=$this->db->query("SELECT * FROM employee_info 
          WHERE department_id=$department_id 
          AND (employee_name LIKE '%$item%' OR  emp_card_id='$item') ")->result();
       foreach($data as $service):
            echo "<li class='employee_class'  data-ids='".$service->employee_id."' onclick='addFieldEmployee(this);'>".$service->emp_card_id."</li>";
        endforeach;
    }
    function save($issue_id=FALSE){
      $department_id=$this->session->userdata('department_id');
        $this->form_validation->set_rules('issue_type','Issue type','trim|required');
        $this->form_validation->set_rules('issue_date','Date','trim|required');
         if ($this->form_validation->run() == TRUE) {

            /////////////////////////////////
          $product_id=$this->input->post('product_id');
          $product_code=$this->input->post('product_code');
          $FIFO_CODE=$this->input->post('FIFO_CODE');
          $quantity=$this->input->post('quantity');
          $i=0;
          foreach ($product_id as $value) {
            $fifo=$FIFO_CODE[$i];
            $product_code1=$product_code[$i];
            $fifoStock=$this->db->query("SELECT IFNULL(SUM(sm.QUANTITY),0) as fifoStock
              FROM stock_master_detail sm
              WHERE sm.department_id=$department_id AND sm.product_id=$value 
              AND sm.FIFO_CODE='$fifo' ")->row('fifoStock');
            $main_stock=$this->db->query("SELECT p.main_stock
              FROM product_info p
              WHERE p.department_id=$department_id 
              AND p.product_id=$value")->row('main_stock');
            $preIssueQty=0;
            if($issue_id!=FALSE){
              $preIssueQty=$this->db->query("SELECT IFNULL(SUM(quantity),0) as quantity 
              FROM item_issue_detail
              WHERE issue_id=$issue_id 
              AND product_id=$value ")->row('quantity');
            }
            if($quantity[$i]>($fifoStock+$preIssueQty)||$quantity[$i]>($main_stock+$preIssueQty)) {
              $this->session->set_userdata('exception',"This $product_code1 stock not available");
              if($issue_id==FALSE)
                redirect("medical/issued/add");  
              else 
                redirect("medical/issued/edit/$issue_id"); 
            }
            $i++;
          }
          ///////////////////
            $check=$this->issued_model->save($issue_id);
            if($check && !$issue_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $issue_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("medical/issued/add");
         }else{
            $data['heading']='Add Issue';
            if($issue_id){
              $data['heading']='Edit Issue';
              $data['info']=$this->issued_model->get_info($issue_id);  
            }
            $data['sdetail'] = $this->issued_model->getSymptom($issue_id);
            $data['dlist']=$this->look_up_model->departmentList();
            $data['display']='medical/addissued';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($issue_id=FALSE){
      $check=$this->issued_model->delete($issue_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("medical/issued/lists");
    }
////////////////////////
public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows=$this->look_up_model->getItemFifoWiseMedical($term);
        if($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
            if($row->main_stock>0){
              $stock=$row->main_stock;
              $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 
                'label' => $row->product_name . " (" . $row->product_code . ")". "-(FIFO=" . $row->FIFO_CODE . ")-(Stock=" . $row->main_stock . ")-(Box=". $row->box_name . ")",
                'currency' => $row->currency ,'unit_name' => $row->unit_name,'FIFO_CODE' => $row->FIFO_CODE, 'product_name' => $row->product_name,'product_code' => $row->product_code,'unit_price' => $row->unit_price, 'stock' =>$stock, 'cnc_rate_in_hkd' =>$row->cnc_rate_in_hkd);
              $r++;
            }
            }
            header('Content-Type: application/json');
            die(json_encode($pr));
            exit;
        }else{
            $dsad='';
            header('Content-Type: application/json');
            die(json_encode($dsad));
            exit;
        }
    }
    function view($issue_id=FALSE){
    if ($this->session->userdata('user_id')) {
          $data['heading']='Invoice Spares ';
          $data['info']=$this->issued_model->get_info($issue_id);
          $data['dlist']=$this->look_up_model->departmentList();
          $data['detail']=$this->issued_model->getDetails($issue_id);
          $pdfFilePath='Medcineissue'.date('Y-m-d H:i').'.pdf';
          $this->load->library('mpdf');
          $mpdf = new mPDF('bn','A4','','','5','5','10','18');
          $mpdf->useAdobeCJK = true;
          $mpdf->SetAutoFont(AUTOFONT_ALL);
          $mpdf->autoScriptToLang = true;
          $mpdf->autoLangToFont = true;
          $header = $this->load->view('header', $data, true);
          $html=$this->load->view('medical/viewmedicineIssue', $data, true);
          $mpdf->setHtmlHeader($header);
          $mpdf->pagenumPrefix = '  Page ';
          $mpdf->pagenumSuffix = ' - ';
          $mpdf->nbpgPrefix = ' out of ';
          $mpdf->nbpgSuffix = '';
          $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
          $mpdf->WriteHTML($html);
          $mpdf->Output();
        } else {
           redirect("logincontroller");
        }
      }
 
   
 }