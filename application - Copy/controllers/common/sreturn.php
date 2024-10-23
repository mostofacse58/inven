<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sreturn extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('common/sreturn_model');
        $this->load->model('shipping/import_model');
     }
    
    function lists(){
      $data=array();
          $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'common/sreturn/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->sreturn_model->get_count();
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
        $total_rows=$config['total_rows'];
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->sreturn_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $data['slist']=$this->look_up_model->getSupplier();
        ////////////////////////////
        $data['heading']='Supplier Return List';
        $data['display']='common/sreturnlist';
        $this->load->view('admin/master',$data);
       }
    function add(){
      $data['collapse']='YES';
      $data['heading']='Add Return';
      $data['clist']=$this->look_up_model->clist();
      $department_id=$this->session->userdata('department_id');
      $data['slist']=$this->look_up_model->getSupplier();
      $data['display']='common/addsreturn';
      $this->load->view('admin/master',$data);
    }

    function edit($sreturn_id){
      $data['collapse']='YES';
      $data['heading']='Edit Return';
      $data['clist']=$this->look_up_model->clist();
      $department_id=$this->session->userdata('department_id');
      $data['info']=$this->sreturn_model->get_info($sreturn_id);
      $data['slist']=$this->look_up_model->getSupplier();
      $data['display']='common/addsreturn';
      $this->load->view('admin/master',$data);
     }

    function save($sreturn_id=FALSE){
        $department_id=$this->session->userdata('department_id');
        $this->form_validation->set_rules('sreturn_type','Return type','trim|required');
        $this->form_validation->set_rules('sreturn_date','Date','trim|required');
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
            $preReturnQty=0;
            if($sreturn_id!=FALSE){
              $preReturnQty=$this->db->query("SELECT IFNULL(SUM(quantity),0) as quantity 
              FROM item_sreturn_detail
              WHERE sreturn_id=$sreturn_id 
              AND product_id=$value ")->row('quantity');
            }
           // echo "$fifoStock  $preReturnQty $main_stock"; exit();
            if($quantity[$i]>($fifoStock+$preReturnQty)&&$quantity[$i]>($main_stock+$preReturnQty)) {
              $this->session->set_userdata('exception',"This $product_code1 stock not available");
              if($sreturn_id==FALSE)
                redirect("common/sreturn/add");  
              else 
                redirect("common/sreturn/edit/$sreturn_id"); 
            }
            $i++;
          }
        /////////////////////////////////
        $check=$this->sreturn_model->save($sreturn_id);
        if($check && !$sreturn_id){
           $this->session->set_userdata('exception','Saved successfully');
           }elseif($check&& $sreturn_id){
               $this->session->set_userdata('exception','Update successfully');
           }else{
             $this->session->set_userdata('exception','Submission Failed');
           }
        redirect("common/sreturn/add");
       }else{
          $data['heading']='Add Return';
          if($sreturn_id){
            $data['heading']='Edit Return';
            $data['info']=$this->sreturn_model->get_info($sreturn_id);  
          }
          $data['slist']=$this->look_up_model->getSupplier();
          $data['display']='common/addsreturn';
          $this->load->view('admin/master',$data);
       }
    }

    function delete($sreturn_id=FALSE){
      $check=$this->sreturn_model->delete($sreturn_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("common/sreturn/lists");
    }
  ////////////////////////
  public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows=$this->look_up_model->getItemFifoWise($term);
        if($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              if($row->main_stock>0){
              $stock=$row->main_stock;
              $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 
                'label' => $row->product_name . " (" . $row->product_code . ")". "-(FIFO=" . $row->FIFO_CODE . ")-(Stock=" . $row->main_stock . ")-(Box=". $row->box_name . ")",
                'currency' => $row->currency ,'unit_name' => $row->unit_name,'FIFO_CODE' => $row->FIFO_CODE, 'product_name' => $row->product_name,'product_code' => $row->product_code,'unit_price' => $row->unit_price, 'stock' =>$stock, 'cnc_rate_in_hkd' =>$row->cnc_rate_in_hkd);
              $r++;}
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

  
    function view($sreturn_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Invoice Spares ';
            $data['info']=$this->sreturn_model->get_info($sreturn_id);
            $data['dlist']=$this->look_up_model->departmentList();
            $data['detail']=$this->sreturn_model->getDetails($sreturn_id);
            $pdfFilePath='sparesInvoice'.date('Y-m-d H:i').'.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','5','5','10','18');
            $mpdf->useAdobeCJK = true;
            $mpdf->SetAutoFont(AUTOFONT_ALL);
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $header = $this->load->view('header', $data, true);
            $html=$this->load->view('common/viewMaterialUsing', $data, true);
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
      function returnback($sreturn_id=FALSE){
      $check=$this->sreturn_model->returnback($sreturn_id);
        if($check){ 
           $this->session->set_userdata('exception','Return successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("common/sreturn/lists");
    }
 
   
 }