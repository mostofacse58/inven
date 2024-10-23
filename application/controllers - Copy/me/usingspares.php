<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usingspares extends My_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('me/usingspares_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'me/usingspares/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->usingspares_model->get_count();
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
        ////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        //echo $data["page"]; exit();///////////
        $data['list']=$this->usingspares_model->lists($config["per_page"],$data['page'] );
        $data['flist']=$this->look_up_model->getFloorLine();
        ////////////////////////////////////////
        $data['heading']='Using Spares List';
        $data['display']='me/usingspareslist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("logincontroller");
        }

       }
    function add(){
        $data['heading']='Add Using';
        $data['collapse']='YES';
        $data['clist']=$this->look_up_model->clist();
        $data['flist']=$this->look_up_model->getFloorLine();
        $data['display']='me/addusingspares';
        $data['dlist']=$this->look_up_model->departmentList();
        $this->load->view('admin/master',$data);
    }
    function edit($spares_use_id){
        $data['heading']='Edit Using';
        $data['collapse']='YES';
        $data['clist']=$this->look_up_model->clist();
        $data['info']=$this->usingspares_model->get_info($spares_use_id);
        $data['flist']=$this->look_up_model->getFloorLine();
        $data['dlist']=$this->look_up_model->departmentList();
        $data['detail']=$this->usingspares_model->getDetails($spares_use_id);
        $data['display']='me/addusingspares';
        $this->load->view('admin/master',$data);
    }
    function getMachineLine(){
          $line_id=$this->input->post('line_id');
           $result=$this->db->query("SELECT pd.product_detail_id,
            CONCAT(pd.tpm_serial_code,' (',p.product_name,')') as product_name
            FROM product_status_info ps
            INNER JOIN product_detail_info pd ON(ps.product_detail_id=pd.product_detail_id)
            INNER JOIN floorline_info fl ON(ps.line_id=fl.line_id)
            INNER JOIN product_info p ON(p.product_id=pd.product_id)
            WHERE ps.department_id=12 
            and ps.line_id=$line_id GROUP BY pd.product_detail_id")->result();
          
      echo '<option value="">Select Machine Name(TMP CODE)</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->product_detail_id.'" >'.$value->product_name.'</option>';
      }
    exit;
   }
   
  function save($spares_use_id=FALSE){
        $this->form_validation->set_rules('use_purpose','Purpose','trim');
        $this->form_validation->set_rules('line_id','Location','trim|required');
        $this->form_validation->set_rules('other_id','Other ID','trim');
        $this->form_validation->set_rules('use_date','Date','trim|required');
        $this->form_validation->set_rules('me_id','ME','trim');
         if ($this->form_validation->run() == TRUE) {
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
              WHERE sm.department_id=12 AND sm.product_id=$value 
              AND sm.FIFO_CODE='$fifo' ")->row('fifoStock');

            $main_stock=$this->db->query("SELECT p.main_stock
              FROM product_info p
              WHERE p.department_id=12 
              AND p.product_id=$value")->row('main_stock');
            $preIssueQty=0;
            if($spares_use_id!=FALSE){
              $preIssueQty=$this->db->query("SELECT IFNULL(SUM(quantity),0) as quantity
              FROM spares_use_detail
              WHERE spares_use_id=$spares_use_id 
              AND product_id=$value ")->row('quantity');
            }

            if($quantity[$i]>($fifoStock+$preIssueQty)||$quantity[$i]>($main_stock+$preIssueQty)) {
              $this->session->set_userdata('exception',"This $product_code1 stock not available");
              if($spares_use_id==FALSE)
                redirect("me/usingspares/add");  
              else 
                redirect("me/usingspares/edit/$spares_use_id"); 
            }
            $i++;
          }
          $check=$this->usingspares_model->save($spares_use_id);
          if($check && !$spares_use_id){
             $this->session->set_userdata('exception','Saved successfully');
             }elseif($check&& $spares_use_id){
                 $this->session->set_userdata('exception','Update successfully');
             }else{
               $this->session->set_userdata('exception','Submission Failed');
             }
          redirect("me/usingspares/lists");
         }else{
            $data['heading']='Add Using';
            if($spares_use_id){
              $data['heading']='Edit Using';
              $data['info']=$this->usingspares_model->get_info($spares_use_id);  
              $data['detail']=$this->usingspares_model->getDetails($spares_use_id);
            }
            $data['flist']=$this->look_up_model->getFloorLine();
            $data['clist']=$this->look_up_model->clist();
            $data['dlist']=$this->look_up_model->departmentList();
            $data['display']='me/addusingspares';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($spares_use_id=FALSE){
      $check=$this->usingspares_model->delete($spares_use_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("me/usingspares/lists");
    }
////////////////////////
public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->look_up_model->getItemFifoWise($term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              if($row->main_stock>0){
              $stock=$row->main_stock;
              $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 
                'label' => $row->product_name . " (" . $row->product_code . ")". "-(FIFO=" . $row->FIFO_CODE . ")-(Stock=" . $row->main_stock . ")-(Box=". $row->box_name . ")-(Spec=". $row->specification . ")",
                'currency' => $row->currency ,'unit_name' => $row->unit_name,
                'FIFO_CODE' => $row->FIFO_CODE, 'product_name' => $row->product_name,
                'product_code' => $row->product_code,'unit_price' => $row->unit_price, 
                'stock' =>$stock, 'cnc_rate_in_hkd' =>$row->cnc_rate_in_hkd, 
                'specification' =>$row->specification);
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
    function view($spares_use_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Invoice Spares ';
            $data['info']=$this->usingspares_model->get_info($spares_use_id);
            $data['flist']=$this->look_up_model->getFloorLine();
            $data['detail']=$this->usingspares_model->getDetails($spares_use_id);
            $pdfFilePath='sparesInvoice'.date('Y-m-d H:i').'.pdf';
            $this->load->library('mpdf');
            $mpdf = new mPDF('bn','A4','','','5','5','10','18');
            $mpdf->useAdobeCJK = true;
            $mpdf->SetAutoFont(AUTOFONT_ALL);
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $header = $this->load->view('header', $data, true);
            $html=$this->load->view('me/viewSparesUsing', $data, true);
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
    public function getprinfo(){
      $requisition_no = $this->input->post('requisition_no');
      $checkin=$this->db->query("SELECT * 
        FROM spares_use_master 
        WHERE requisition_no='$requisition_no'")->result();
      if(count($checkin)<=0){
      $info=$this->db->query("SELECT pm.* ,pd.product_detail_id, m.me_id  
          FROM  requisition_master pm 
          LEFT JOIN product_detail_info pd ON(pd.asset_encoding=pm.asset_encoding OR pd.tpm_serial_code=pm.asset_encoding OR pd.tpm_serial_code=pm.asset_encoding)
          LEFT JOIN me_info m ON(m.id_no=pm.employee_id)
          WHERE pm.requisition_no='$requisition_no' AND pm.general_or_tpm=2 ")->row();
      //////////////////////////////
      $data=array('department_id'=>$info->department_id,'employee_id'=>$info->employee_id,'asset_encoding'=>$info->asset_encoding,'product_detail_id'=>$info->product_detail_id,'line_id'=>$info->line_id,'me_id'=>$info->me_id,'status'=>'NO');
    }else{
      $data=array('status'=>'DONE');
      }
      echo  json_encode($data);
    
    }
    public function getprwiseitem(){
      $requisition_no = $this->input->post('requisition_no');
      $requisition_id=$this->db->query("SELECT requisition_id 
        FROM requisition_master 
        WHERE requisition_no='$requisition_no'")->row('requisition_id');
        //////////////////////////////
      $department_id=$this->session->userdata('department_id');
      $medical_yes=$this->session->userdata('medical_yes');
      $data=date('Y-m-d');
      $checkin=$this->db->query("SELECT * 
        FROM spares_use_master 
        WHERE requisition_no='$requisition_no'")->result();
       if(count($checkin)<=0){

      $detail=$this->db->query("SELECT IFNULL(SUM(sm.QUANTITY),0) as main_stock,
        sm.CRRNCY as currency,sm.EXCH_RATE as cnc_rate_in_hkd,sm.FIFO_CODE,
        sm.UPRICE as unit_price,p.product_id,
        p.product_name,p.product_code,u.unit_name,
        prd.required_qty,sm.specification
        FROM stock_master_detail sm
        INNER JOIN product_info p ON(p.product_id=sm.product_id)
        INNER JOIN requisition_item_details prd ON(p.product_id=prd.product_id)        
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.product_type=2 AND p.department_id=12  
        AND sm.department_id=12 
        AND  prd.requisition_id=$requisition_id
        GROUP BY sm.product_id,sm.FIFO_CODE 
        ORDER BY sm.FIFO_CODE DESC")->result();
      /////////////////////////////////////////
      $clist=$this->look_up_model->clist();
       $i=0;
       $id=0;
        if(isset($detail)):
          foreach ($detail as  $value) {
            if($value->main_stock>0){
            $stock=$value->main_stock;
            $sub_total=$value->required_qty*$value->unit_price;
            $optionTree="";
            foreach ($clist as $rowc):
                $selected=($rowc->currency==$value->currency)? 'selected="selected"':'';
                $optionTree.='<option value="'.$rowc->currency.'" '.$selected.'>'.$rowc->currency.'</option>'; 
            endforeach;
             $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
            
            $str.= '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
            $str.= '<td> <input type="text" name="specification[]" readonly class="form-control" placeholder="Specification" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'.$id. '"/> </td>';
            $str.= '<td><input type="text" name="FIFO_CODE[]" readonly class="form-control" placeholder="FIFO_CODE" value="'.$value->FIFO_CODE.'"  style="margin-bottom:5px;width:98%" id="FIFO_CODE_'.$id. '"/> </td>';
        
            $str.= '<td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" 
            value="'.$stock.'" style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"> </td>';

            $str.= '<td> <input type="text" name="quantity[]" value="'.$value->required_qty.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
            $str.= '<td><input type="text" name="unit_price[]"  class="form-control" placeholder="Unit Price" 
            value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"> </td>';
       
            $str.='<td> <select name="currency[]" class="form-control select2"  style="width:100%;" id="currency_' . $id . '"> '.$optionTree.'</select> </td> ';
            $str.= '<td> <input type="text" name="cnc_rate_in_hkd[]" readonly class="form-control" placeholder="Rate" 
                value="'.$value->cnc_rate_in_hkd.'" style="margin-bottom:5px;width:98%;text-align:center" id="cnc_rate_in_hkd_'.$id.'"> </td>';
            $str.= '<td style"text-align:center"><button class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
            echo $str;
             ?>
            <?php 

          $id++;
         }
       }
        endif;
      }
    }
   
 }