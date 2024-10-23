<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ipurchase extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('shipping/import_model');
        $this->load->model('common/ipurchase_model');
        
     }
    function lists(){
       $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'common/ipurchase/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->ipurchase_model->get_count();
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
        $data['list']=$this->ipurchase_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['llist']=$this->look_up_model->getlocation();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        ////////////////////////////
        $data['heading']='Received List';
        $data['display']='common/ipurchaselist';
        $this->load->view('admin/master',$data);
       }


    function add(){
      if($this->session->userdata('user_id')) {
        $data['heading']='Add Receive';
        $data['collapse']='YES';
        $data['dlist']=$this->look_up_model->departmentList();
        $data['slist']=$this->look_up_model->getSupplier();
        $data['clist']=$this->look_up_model->clist();
        $data['blist']=$this->look_up_model->get_box();
        $data['flist']=$this->import_model->getdata('shipping_file_style_info');
        $data['display']='common/addipurchase';
        $this->load->view('admin/master',$data);
      }else{
        redirect("logincontroller");
      }
    }
    
    function edit($purchase_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Receive';
        $data['info']=$this->ipurchase_model->get_info($purchase_id);
        $data['slist']=$this->look_up_model->getSupplier();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['clist']=$this->look_up_model->clist();
        $data['blist']=$this->look_up_model->get_box();
        $data['detail']=$this->ipurchase_model->getDetails($purchase_id);
        $data['flist']=$this->import_model->getdata('shipping_file_style_info');
        $data['display']='common/addipurchase';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }
    }
   function save($purchase_id=FALSE){
        $check=$this->ipurchase_model->save($purchase_id);
        if($check && !$purchase_id){
         $this->session->set_userdata('exception','Saved successfully');
         }elseif($check&& $purchase_id){
             $this->session->set_userdata('exception','Update successfully');
         }else{
           $this->session->set_userdata('exception','Submission Failed');
         }
      redirect("common/ipurchase/lists");
    }
    function delete($purchase_id=FALSE){
      $check=$this->ipurchase_model->delete($purchase_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("common/ipurchase/lists");
    }
////////////////////////
public function suggestions(){
      $term = $this->input->get('term', true);
      $department_id=$this->session->userdata('department_id');
      if (strlen($term) < 1 || !$term) {
          die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
      }
      $rows = $this->look_up_model->getdepartmentwiseItem($department_id,$term);
      if ($rows){
          $c = str_replace(".", "", microtime(true));
          $r = 0;
          foreach ($rows as $row) {
              $stock=$row->main_stock;
              $description="Category: $row->category_name";
              $pr[] = array('id' => ($c + $r), 'product_id' =>$row->product_id, 'label' => $row->product_name . " (" . $row->product_code . ")",'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'description' => $description, 'product_name' => $row->product_name,'product_code' => $row->product_code, 'unit_price' => $row->unit_price, 'stock' =>$stock);
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
      $data['show']=1;
      $data['controller']=$this->router->fetch_class();
      $data['heading']='Receive Form';
      $data['info']=$this->ipurchase_model->get_info($purchase_id);
      $data['detail']=$this->ipurchase_model->getDetails($purchase_id);
      $data['display']='common/receiveformhtml';
      $this->load->view('admin/master',$data);
    }
function viewpdf($purchase_id=FALSE){
  if ($this->session->userdata('user_id')) {
  $data['heading']='Receive Items ';
      $data['info']=$this->ipurchase_model->get_info($purchase_id);
      $data['detail']=$this->ipurchase_model->getDetails($purchase_id);
      $pdfFilePath='ItemReceiveInvoice'.date('Y-m-d H:i').'.pdf';
      $this->load->library('mpdf');
      $mpdf = new mPDF('bn','A4','','','5','5','10','18');
      $mpdf->useAdobeCJK = true;
      $mpdf->SetAutoFont(AUTOFONT_ALL);
      $mpdf->autoScriptToLang = true;
      $mpdf->autoLangToFont = true;
      $header = $this->load->view('header', $data, true);
      $html=$this->load->view('common/viewItemsInvoice', $data, true);
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
  $erpdb = $this->load->database('erpdb', TRUE);
  $department_id=$this->session->userdata('department_id');
  $po_number = $this->input->post('po_number');
  $po_number=str_replace(" ","",$po_number);
  $info=$erpdb->query("SELECT CURRENCY as currency, EXCH_RATE as  cnc_rate_in_hkd, COM_NAME
      FROM  BD_PO_SUMMARY  
      WHERE PO_NUMBER='$po_number' ")->row();

  if(!is_null($info)){
    if($info->currency=='CNY') $currency='RMB'; else $currency=$info->currency;
    $COM_NAME=$info->COM_NAME;
    $supplier_id=$this->db->query("SELECT supplier_id
      FROM supplier_info
      WHERE supplier_name='$COM_NAME' ")->row('supplier_id');
    ////////////////////////////////////////////////////////
    $data=array('check'=>'YES','currency'=>$currency,'cnc_rate_in_hkd'=>$info->cnc_rate_in_hkd,'supplier_id'=>$supplier_id,'po_id'=>'');
  }else{
    $data=array('check'=>'NO');
  }
  echo  json_encode($data);
}
public function getPOwiseitem(){
     $erpdb = $this->load->database('erpdb', TRUE);
    $blist=$this->look_up_model->get_box();
    $department_id=$this->session->userdata('department_id');
    $po_number = $this->input->post('po_number');
    $po_number=str_replace(" ","",$po_number);
    $detail=$erpdb->query("SELECT ITEM_CODE as product_code, DES as product_name,
      QTY as quantity,QTY as po_qty, UPRICE as unit_price,'' as specification, UNIT as unit_name
      FROM BD_PO_LN
      WHERE PO_NUMBER='$po_number' ")->result();
    $i=0;
    $id=0;
    $boxselect='';
     foreach ($blist as $rows){ 
      $boxselect.='<option value="'.$rows->box_name.'">'.$rows->box_name.'</option>';
    }
     ///////////////
    if(isset($detail)):
      foreach ($detail as  $value) {
        $product_code=$value->product_code;
        $product_id=$this->db->query("SELECT product_id
      FROM product_info
      WHERE product_code='$product_code' ")->row('product_id');
      if($product_id!=''){       
        $inquantity=$this->db->query("SELECT IFNULL(SUM(pud.quantity),0) as inquantity
       FROM purchase_detail pud,purchase_master pum 
       WHERE pum.purchase_id=pud.purchase_id AND pum.po_number='$po_number' 
       AND pud.product_id=$product_id  
       AND pud.status!=5 
       AND pum.department_id=$department_id")->row('inquantity');

       $quantity=$value->quantity-$inquantity;
        if($quantity>0){
        $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"> </td>';
        $str.='<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"> </td>';
        $str.='<td><input type="text" name="specification[]" class="form-control" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'.$id. '"> </td>';

        $str.='<td><input type="text" name="pi_no[]" class="form-control" value=""  style="margin-bottom:5px;width:98%" id="pi_no_'.$id. '"/> </td>';
        $str.='<td><input type="text" name="po_qty[]" readonly class="form-control" value="'.$value->po_qty.'"  style="margin-bottom:5px;width:98%" id="po_qty_'.$id. '"/> </td>';
        $str.='<td><input type="text" name="quantity[]" value="'.$quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
        $str.='<td> <input type="text" name="unit_price[]" readonly class="form-control" placeholder="Unit Price" value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"  style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"/> </td>';
        $str.='<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" value="'.$value->unit_price*$quantity.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"> </td>';
        $str.='<td> <select name="box_name[]" class="form-control select2"  style="width:100%;" id="box_name_' . $id . '" required><option value="" selected="selected">Select</option> '.$boxselect.' </select> </td> ';

        $str.='<td> <a class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></a></td></tr>';
           echo $str;
      $id++;
      }
     }
   }
    endif;
}
function submit($purchase_id=FALSE){
  $this->load->model('communication');
    $data['info']=$this->ipurchase_model->get_info($purchase_id); 
    $department_id=$data['info']->for_department_id;
    $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
      WHERE department_id=$department_id")->row('dept_head_email');
    $subject="GRN Received Notification";
    $message=$this->load->view('grn_received_email', $data,true); 
  //$this->communication->send($emailaddress,$subject,$message);
  ////////////////////////
  $check=$this->ipurchase_model->submit($purchase_id);
    if($check){ 
      $this->session->set_userdata('exception','Send successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("common/ipurchase/lists");
  }

  //////////////////AJAX FOR DELETIN PRODUCT/////////////
  function checkItemsUse($purchase_id){
    $chk=$this->db->query("SELECT pd.* FROM purchase_detail pd
         WHERE pd.purchase_id=$purchase_id 
         AND pd.FIFO_CODE IN(SELECT u.FIFO_CODE FROM spares_use_detail u 
         WHERE pd.product_id=u.product_id) ")->result();

    $chk2=$this->db->query("SELECT pd.* FROM purchase_detail pd
         WHERE  pd.purchase_id=$purchase_id 
         AND pd.FIFO_CODE IN(SELECT u.FIFO_CODE FROM item_issue_detail u 
         WHERE pd.product_id=u.product_id) ")->result();

    if((count($chk)+count($chk2))>0){
        echo "EXISTS";
    }else{
        echo "DELETABLE";
    }
  }

      
 }