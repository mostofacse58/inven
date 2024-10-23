<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spurchase extends My_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('egm/spurchase_model');
     }
    
    function lists(){
      $data=array();
        if($this->session->userdata('user_id')) {
        $data['heading']='Purchase Spares List';
        $data['list']=$this->spurchase_model->lists();
        $data['display']='egm/spurchaselist';
        $this->load->view('admin/master',$data);
        }else{
          redirect("logincontroller");
        }
       }
    function add(){
      if($this->session->userdata('user_id')) {
        $data['heading']='Add Purchase';
        $data['pilist']=$this->look_up_model->getPI();
        $data['slist']=$this->look_up_model->getSupplier();
        $data['display']='egm/addspurchase';
        $this->load->view('admin/master',$data);
      }else{
        redirect("logincontroller");
      }
    }
    function edit($purchase_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Purchase';
        $data['info']=$this->spurchase_model->get_info($purchase_id);
        $data['pilist']=$this->look_up_model->getPI();
        $data['slist']=$this->look_up_model->getSupplier();
        $data['detail']=$this->spurchase_model->getDetails($purchase_id);
        $data['display']='egm/addspurchase';
        $this->load->view('admin/master',$data);
        } else {
           redirect("logincontroller");
        }
    }
   function save($purchase_id=FALSE){
        $check=$this->spurchase_model->save($purchase_id);
        if($check && !$purchase_id){
         $this->session->set_userdata('exception','Saved successfully');
         }elseif($check&& $purchase_id){
             $this->session->set_userdata('exception','Update successfully');
         }else{
           $this->session->set_userdata('exception','Submission Failed');
         }
      redirect("egm/spurchase/lists");
    }
    function delete($purchase_id=FALSE){
      $check=$this->spurchase_model->delete($purchase_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("egm/spurchase/lists");
    }
////////////////////////
public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->look_up_model->getProductNames($term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              $stock=$this->look_up_model->get_sparesStock($row->product_id);
                $description="Material Type: $row->mtype_name";
                if($row->mdiameter!=''){
                  $description=$description.", Diameter:$row->mdiameter";
                }
                if($row->mthread_count!=''){
                  $description=$description.", Thread Count:$row->mthread_count";
                }
                if($row->mlength!=''){
                  $description=$description.", Length:$row->mlength";
                }
                $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 'label' => $row->product_name . " (" . $row->product_code . ")",'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'description' => $description, 'product_name' => $row->product_name,'product_code' => $row->product_code, 'unit_price' => $row->unit_price, 'stock' =>$stock);
                $r++;
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
    function view($purchase_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Invoice Spares ';
            $data['info']=$this->spurchase_model->get_info($purchase_id);
            $data['flist']=$this->look_up_model->getFloorLine();
            $data['detail']=$this->spurchase_model->getDetails($purchase_id);
            $pdfFilePath='sparesPurchaseInvoice'.date('Y-m-d H:i').'.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','15','15','15','18');
            $header = $this->load->view('header', $data, true);
            $html=$this->load->view('egm/viewSparesInvoice', $data, true);
            $mpdf->setHtmlHeader($header);
            $mpdf->pagenumPrefix = '  Page ';
            $mpdf->pagenumSuffix = ' - ';
            $mpdf->nbpgPrefix = ' out of ';
            $mpdf->nbpgSuffix = '';
            $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfFilePath,'D');
        } else {
           redirect("logincontroller");
        }
      }

   
 }