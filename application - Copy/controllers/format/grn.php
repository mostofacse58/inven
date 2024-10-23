<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Grn extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('shipping/import_model');
        $this->load->model('format/grn_model');
     }
    function lists(){
       $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'format/grn/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->grn_model->get_count();
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
        $data['list']=$this->grn_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        ////////////////////////////
        $data['heading']='GRN List';
        $data['display']='format/grnlist';
        $this->load->view('admin/master',$data);
       }


    function add(){
      if($this->session->userdata('user_id')) {
        $data['heading']='Add Receive';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        $data['clist']=$this->look_up_model->clist();
        $data['display']='format/addgrn';
        $this->load->view('admin/master',$data);
      }else{
        redirect("logincontroller");
      }
    }
    
    function edit($purchase_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Receive';
        $data['info']=$this->grn_model->get_info($purchase_id);
        $data['slist']=$this->look_up_model->getSupplier();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['clist']=$this->look_up_model->clist();
        $data['detail']=$this->grn_model->getDetails($purchase_id);
        $data['display']='format/addgrn';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
   function save($purchase_id=FALSE){
        $check=$this->grn_model->save($purchase_id);
        if($check && !$purchase_id){
         $this->session->set_userdata('exception','Saved successfully');
         }elseif($check&& $purchase_id){
             $this->session->set_userdata('exception','Update successfully');
         }else{
           $this->session->set_userdata('exception','Submission Failed');
         }
      redirect("format/grn/lists");
    }
    function delete($purchase_id=FALSE){
      $check=$this->grn_model->delete($purchase_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("format/grn/lists");
    }

  function view($purchase_id=FALSE){
      $data['show']=1;
      $data['controller']=$this->router->fetch_class();
      $data['heading']='Receive Form';
      $data['info']=$this->grn_model->get_info($purchase_id);
      $data['detail']=$this->grn_model->getDetails($purchase_id);
      $data['display']='format/receiveformhtml';
      $this->load->view('admin/master',$data);
    }
function viewpdf($purchase_id=FALSE){
  if ($this->session->userdata('user_id')) {
  $data['heading']='Receive Items ';
      $data['info']=$this->grn_model->get_info($purchase_id);
      $data['detail']=$this->grn_model->getDetails($purchase_id);
      $pdfFilePath='ItemReceiveInvoice'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','A4','','','5','5','10','18');
      $mpdf->useAdobeCJK = true;
      $mpdf->SetAutoFont(AUTOFONT_ALL);
      $mpdf->autoScriptToLang = true;
      $mpdf->autoLangToFont = true;
      $header = $this->load->view('header', $data, true);
      $html=$this->load->view('format/viewItemsInvoice', $data, true);
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
public function getPOInfo(){
  $department_id=$this->session->userdata('department_id');
  $po_number = $this->input->post('po_number');
  $po_number=str_replace(" ","",$po_number);
  $info=$this->db->query("SELECT pm.*,s.*   
      FROM  po_master pm 
      INNER JOIN supplier_info s ON(s.supplier_id=pm.supplier_id)
      WHERE pm.po_number='$po_number' 
      AND pm.po_status!=5 AND pm.po_status=3 ")->row();

  $detail=$this->db->query("SELECT pm.* ,prd.*,
      (SELECT IFNULL(SUM(pud.quantity),0) 
      FROM purchase_detail_cn pud,purchase_master_cn pum 
       WHERE pum.purchase_id=pud.purchase_id AND pum.po_id=prd.po_id 
       AND pud.product_id=prd.product_id AND pud.status!=5  
       AND pum.department_id=$department_id) as inquantity
       
      FROM po_pline prd,po_master pm
      WHERE pm.po_id=prd.po_id AND pm.po_number='$po_number'
      AND pm.for_department_id=$department_id 
      AND prd.quantity>(SELECT IFNULL(SUM(pud2.quantity),0) 
      FROM purchase_detail_cn pud2,purchase_master_cn pum2 
       WHERE pum2.purchase_id=pud2.purchase_id 
       AND pum2.po_id=prd.po_id 
       AND pud2.product_id=prd.product_id 
       AND pud2.status!=5 )")->result();

  if(!is_null($info)){
    $data=array('check'=>'YES','currency'=>$info->currency,'cnc_rate_in_hkd'=>$info->cnc_rate_in_hkd,'supplier_id'=>$info->supplier_id,'for_department_id'=>$info->for_department_id,'po_id'=>$info->po_id,'ids'=>count($detail));
  }else{
    $data=array('check'=>'NO');
  }
  echo  json_encode($data);
}
public function getPOwiseitem(){
    $blist=$this->look_up_model->get_box();
    $department_id=$this->session->userdata('department_id');
    $po_number = $this->input->post('po_number');
    $po_number=str_replace(" ","",$po_number);
    $detail=$this->db->query("SELECT pm.* ,prd.*,prd.quantity as po_qty    
      FROM po_pline prd,po_master pm
      WHERE pm.po_id=prd.po_id 
      AND pm.po_number='$po_number'  ")->result();
   $i=0;
   $id=0;

     ///////////////
    if(isset($detail)):
      foreach ($detail as  $value) {
         $product_id=$value->product_id;
         $inquantity=$this->db->query("SELECT IFNULL(SUM(pud.quantity),0) as inquantity
         FROM purchase_detail_cn pud,purchase_master_cn pum 
         WHERE pum.purchase_id=pud.purchase_id AND pum.po_number='$po_number' 
         AND pud.product_id=$product_id  
         AND pud.status!=5 
         AND pum.department_id=$department_id")->row('inquantity');
         $quantity=$value->quantity-$inquantity;
        if($quantity>0){
        $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"> </td>';
        $str.='<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"> </td>';
        $str.='<td><input type="text" name="specification[]" class="form-control" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'.$id. '"> </td>';
        $str.='<td><input type="text" name="pi_no[]" readonly class="form-control" value="'.$value->pi_no.'"  style="margin-bottom:5px;width:98%" id="pi_no_'.$id. '"/> </td>';
        $str.='<td><input type="text" name="po_qty[]" readonly class="form-control" value="'.$value->po_qty.'"  style="margin-bottom:5px;width:98%" id="po_qty_'.$id. '"/> </td>';
        $str.='<td><input type="text" name="quantity[]" value="'.$quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
        $str.='<td> <input type="text" name="unit_price[]" readonly class="form-control" placeholder="Unit Price" value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"  style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"/> </td>';
        $str.='<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" value="'.$value->sub_total_amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"> </td>';

        $str.='<td> <a class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></a></td></tr>';
           echo $str;
         ?>
        <?php 

      $id++;
     }}
    endif;
}
 function send($purchase_id){
    $data['heading']='Ship to BD';
    $data['info']=$this->grn_model->get_info($purchase_id);
    $data['display']='format/addInvoice';
    $this->load->view('admin/master',$data);
     
  }
function submit($purchase_id=FALSE){
    $this->load->model('communication');
    $data['info']=$this->grn_model->get_info($purchase_id); 
    $department_id=$data['info']->for_department_id;
    $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
      WHERE department_id=$department_id")->row('dept_head_email');
    $subject="GRN GRN Notification";
    $message=$this->load->view('grn_received_email', $data,true); 
  //$this->communication->send($emailaddress,$subject,$message);
  ////////////////////////
  $check=$this->grn_model->submit($purchase_id);
    if($check){ 
      $this->session->set_userdata('exception','Send successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("format/grn/lists");
  }

  //////////////////AJAX FOR DELETIN PRODUCT/////////////
  function checkItemsUse($purchase_id){
    $chk=$this->db->query("SELECT pd.* FROM purchase_detail_cn pd
         WHERE pd.purchase_id=$purchase_id 
         AND pd.FIFO_CODE IN(SELECT u.FIFO_CODE FROM spares_use_detail u 
         WHERE pd.product_id=u.product_id) ")->result();

    $chk2=$this->db->query("SELECT pd.* FROM purchase_detail_cn pd
         WHERE  pd.purchase_id=$purchase_id AND pd.FIFO_CODE IN(SELECT u.FIFO_CODE FROM item_issue_detail u 
         WHERE pd.product_id=u.product_id) ")->result();

    if((count($chk)+count($chk2))>0){
        echo "EXISTS";
    }else{
        echo "DELETABLE";
    }
  }

      
 }