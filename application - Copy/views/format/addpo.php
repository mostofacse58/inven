<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>format/po/save<?php if (isset($info)) echo "/$info->po_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
    <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">PO/WO Type <span style="color:red;">  *</span></label>
           <div class="col-sm-1">
            <select class="form-control select2" name="po_type" id="po_type">
            <?php foreach ($ptlist as $rows) { ?>
              <option value="<?php echo $rows->po_type; ?>" 
              <?php if (isset($info))
                  echo $rows->po_type == $info->po_type ? 'selected="selected"' : 0;
                  else echo $rows->po_type == set_value('po_type') ? 'selected="selected"' : 0;
              ?>><?php echo $rows->po_type; ?></option>
                  <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("use_type");?></span>
         </div>
         <?php if(isset($info)){ ?>
         <label class="col-sm-1 control-label">PO/WO NO<span style="color:red;">  *</span></label>
          <div class="col-sm-2">
             <input type="text" name="po_number" id="po_number" class="form-control" placeholder="PO/WO NO" value="<?php if(isset($info)) echo $info->po_number; else echo set_value('po_number'); ?>">
              <span class="error-msg"><?php echo form_error("po_number"); ?></span>
          </div>
        <?php } ?>
          <label class="col-sm-1 control-label">PO/WO Date <span style="color:red;">  *</span></label>
         <div class="col-sm-2">
            <div class="input-group date">
             <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="po_date" readonly id="po_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->po_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("po_date");?></span>
          </div>
          <label class="col-sm-2 control-label ">For Department对于部门 <span style="color:red;">  </span></label>
          <div class="col-sm-2">
          <select class="form-control select2" name="for_department_id" id="for_department_id" style="width: 100%"> 
            <option value="" selected="selected">Select 选择</option>
            <?php foreach ($dlist as $rows) { ?>
              <option value="<?php echo $rows->department_id; ?>" 
              <?php if (isset($for_department_id))
                  echo $rows->department_id==$for_department_id ? 'selected="selected"' : 0;
                  else
                  echo $rows->department_id==$for_department_id ? 'selected="selected"' : 0;
              ?>>
               <?php echo $rows->department_name; ?></option>
              <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("for_department_id"); ?></span>
            </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label"> Delivery Date<span style="color:red;">  *</span> </label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="delivery_date" readonly id="delivery_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->delivery_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("delivery_date");?></span>
          </div>
          <label class="col-sm-2 control-label">2nd Delivery Date 2<span style="color:red;">  </span> </label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="delivery_date2" readonly id="delivery_date2" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->delivery_date2);  ?>">
           </div>
           <span class="error-msg"><?php echo form_error("delivery_date2");?></span>
          </div>
          <label class="col-sm-2 control-label">3rd Delivery Date <span style="color:red;">  </span> </label>
         <div class="col-sm-2">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="delivery_date3" readonly id="delivery_date3" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->delivery_date3); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("delivery_date3");?></span>
          </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label ">Supplier 供应商名称<span style="color:red;">  *</span></label>
          <div class="col-sm-4">
          <select class="form-control select2" name="supplier_id" id="supplier_id" style="width: 100%" required  onchange="return getSuppItem();"> 
            <option value="" selected="selected">Select 选择</option>
            <?php foreach ($slist as $rows) { ?>
              <option value="<?php echo $rows->supplier_id; ?>" 
              <?php if (isset($info))
                  echo $rows->supplier_id==$info->supplier_id ? 'selected="selected"' : 0;
                  else
                  echo $rows->supplier_id==set_value('supplier_id') ? 'selected="selected"' : 0;
                  ?>>
                  <?php echo "$rows->supplier_name"; ?></option>
                  <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("supplier_id"); ?></span>
            </div>
            <div class="col-sm-1">
              <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#partyModal"><i class="fa fa-plus"></i></a>
        </div>  
        <label class="col-sm-2 control-label overseas">Shipment Mode <span style="color:red;">  *</span></label>
         <div class="col-sm-2 overseas">
            <select name="mode_of_shipment" class="form-control select2" id="mode_of_shipment">
              <option value="By Ship" <?php if(isset($info))
              if('By Ship'==$info->mode_of_shipment) echo 'selected="selected"';
               else echo 'By Ship'==set_value('mode_of_shipment')? 'selected="selected"':0; ?> >By Ship</option>
               <option value="By Air" <?php if(isset($info))
              if('By Air'==$info->mode_of_shipment) echo 'selected="selected"';
               else echo 'By Air'==set_value('mode_of_shipment')? 'selected="selected"':0; ?> >By Air</option>
               <option value="By Road" <?php if(isset($info))
              if('By Road'==$info->mode_of_shipment) echo 'selected="selected"';
               else echo 'By Road'==set_value('mode_of_shipment')? 'selected="selected"':0; ?> >By Road</option>
               <option value="By Rail" <?php if(isset($info))
              if('By Rail'==$info->mode_of_shipment) echo 'selected="selected"';
               else echo 'By Rail'==set_value('mode_of_shipment')? 'selected="selected"':0; ?> >By Rail</option>
               <option value="By Mail" <?php if(isset($info))
              if('By Mail'==$info->mode_of_shipment) echo 'selected="selected"';
               else echo 'By Mail'==set_value('mode_of_shipment')? 'selected="selected"':0; ?> >By Mail</option>
               <option value="Service" <?php if(isset($info))
              if('Service'==$info->mode_of_shipment) echo 'selected="selected"';
               else echo 'Service'==set_value('mode_of_shipment')? 'selected="selected"':0; ?> >Service</option>
          </select>
         <span class="error-msg"><?php echo form_error("mode_of_shipment");?></span>
       </div>                                                    
      </div><!-- ///////////////////// -->
      <div class="form-group">
          <label class="col-sm-1 control-label local">Subject<span style="color:red;">  *</span></label>
           <div class="col-sm-6 local">
           <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" value="<?php if(isset($info)) echo $info->subject; else echo set_value('subject'); ?>"> 
           <span class="error-msg"><?php echo form_error("subject");?></span>
         </div> 
         <label class="col-sm-1 control-label ">
            To:<span style="color:red;">  </span></label>
          <div class="col-sm-4">
          <select class="form-control select2" name="company_id" id="company_id" style="width: 100%" required="">  
            <?php foreach ($blist as $rows) { ?>
              <option value="<?php echo $rows->id; ?>" 
              <?php if (isset($info))
                  echo $rows->id==$info->company_id? 'selected="selected"' : 0;
                  else
                  echo $rows->id==set_value('company_id') ? 'selected="selected"' : 0;
                  ?>>
                  <?php echo $rows->company_name; ?></option>
                  <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("company_id"); ?></span>
            </div>        
      </div><!-- ///////////////////// -->
      <div class="form-group local">
        <label class="col-sm-1 control-label">Dear<span style="color:red;">  *</span></label>
           <div class="col-sm-2">
           <input type="text" name="dear_name" id="dear_name" class="form-control" placeholder="Name" value="<?php if(isset($info)) echo $info->dear_name; else echo set_value('dear_name'); ?>">
           <span class="error-msg"><?php echo form_error("dear_name");?></span>
         </div>
          <label class="col-sm-1 control-label">Body <span style="color:red;">  *</span></label>
           <div class="col-sm-6"> 
           <textarea type="text" name="body_content" id="body_content" rows="1" class="form-control" placeholder="Body"><?php if(isset($info->body_content)) echo $info->body_content; else echo set_value('body_content'); ?></textarea>
           <span class="error-msg"><?php echo form_error("body_content");?></span>
         </div>         
      </div><!-- ///////////////////// -->
    <div class="form-group">
      <label class="col-sm-2 control-label" style="margin-top: 10px">SCAN CODE or Search 搜索Item<span style="color:red;">  </span></label>
        <div class="col-sm-8">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm"  style="overflow: hidden;">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Asset/Item to order list" autocomplete="off" tabindex="1" type="text">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
     
     </div><!-- ///////////////////// -->
<div class="form-group">
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:3%;text-align:center">SN</th>
  <th style="width:10%;text-align:center">Item code</th>
  <th style="width:20%;text-align:center">Item Name</th>
  <th style="width:15%;text-align:center"> Specification</th>
  <th style="width:6%;text-align:center;">Qty</th>
  <th style="width:4%;text-align:center;">Unit</th>
  <th style="width:6%;text-align:center;">Unit Price</th>
  <th style="width:6%;text-align:center;">Sub Total</th>
  <th style="width:8%;text-align:center;">PI Ref.</th>
  <th style="width:10%;text-align:center;">Remarks</th>
  <th style="width:5%;text-align:center">
    <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value){
      $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td>';
      $str.='<td><textarea type="text" name="product_code[]" readonly class="form-control"  placeholder="Material Code"   style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '">'.$value->product_code.'</textarea> </td>';

      $str.='<td><textarea type="text" name="product_name[]" readonly class="form-control" placeholder="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '">'.$value->product_name.'</textarea></td>';
      $str.='<td><textarea type="text" name="specification[]"  class="form-control"  style="margin-bottom:5px;width:98%" id="specification_'  .$id. '">'.$value->specification.'</textarea></td>';

      $str.='<td> <input type="text" name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity('.$id. ');" onClick="this.select();" onkeyup="return checkQuantity('.$id. ');" class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="quantity_'.$id. '"> </td>';

      $str.='<td><input type="text" name="unit_name[]" readonly class="form-control" style="margin-bottom:5px;width:98%;text-align:center" value="'.$value->unit_name.'"  id="unit_name_' .$id.'"></td>' ;
      $str.='<td> <input type="text" name="unit_price[]" class="form-control" onClick="this.select();" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" value="'.$value->unit_price.'" id="unit_price_'.$id. '" onblur="return checkUnitPrice('.$id.');"   onkeyup="return checkUnitPrice('.$id. ');"> </td>';

      $str.='<td> <input type="text" name="sub_total_amount[]" readonly class="form-control" placeholder="Sub Total" style="margin-bottom:5px;width:98%;text-align:center" value="'.$value->sub_total_amount.'" id="sub_total_amount_'.$id.'"/> </td>';
      $str.='<td><input type="text" name="pi_no[]" class="form-control" placeholder="PI NO" style="margin-bottom:5px;width:98%;text-align:center" id="pi_no_' .$id. '" value="'.$value->pi_no.'"></td>';
      $str.='<td><textarea name="remarks[]" class="form-control" placeholder="Remarks"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="remarks_'.$id.'">'.$value->remarks.'</textarea> </td>';
      $str.='<td style="text-align:center"><span class="btn btn-danger btn-xs" onclick="return deleter('.$id.');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td></tr>';
      echo $str;
      $id++;
      }
      endif;
      ?>
</tbody>
</table>
</div>
</div>
<div class="form-group">
   
   <label class="col-sm-1 control-label ">Currency <span style="color:red;">  </span></label>
    <div class="col-sm-2">
    <select class="form-control select2" name="currency" id="currency" style="width: 100%" required=""> 
      <option value="" selected="selected">选择</option>
      <?php foreach ($clist as $rows) { ?>
        <option value="<?php echo $rows->currency; ?>" 
        <?php if (isset($info))
            echo $rows->currency == $info->currency ? 'selected="selected"' : 0;
            else
            echo $rows->currency ==set_value('currency') ? 'selected="selected"' : 0;
        ?>><?php echo $rows->currency; ?></option>
            <?php } ?>
        </select>
        <span class="error-msg"><?php echo form_error("currency"); ?></span>
      </div>
    <label class="col-sm-2 control-label">Currency Rate in HKD <span style="color:red;">  *</span></label>
   <div class="col-sm-2">
       <input type="text" required name="cnc_rate_in_hkd"  id="cnc_rate_in_hkd" class="form-control" value="<?php if(isset($info)) echo $info->cnc_rate_in_hkd; else echo '0.10'; ?>">
     <span class="error-msg"><?php echo form_error("cnc_rate_in_hkd");?></span>
    </div>
    <label class="col-sm-2 control-label">Sub-Total Amount <span style="color:red;">  *</span></label>
    <div class="col-sm-2">
       <input type="text" name="subtotal" readonly required id="subtotal" class="form-control" value="<?php if(isset($info)) echo $info->subtotal; else echo set_value('subtotal'); ?>">
     <span class="error-msg"><?php echo form_error("subtotal");?></span>
    </div>
  </div>
  <div class="form-group">
     <label class="col-sm-1 control-label">Payment Term <span style="color:red;">  *</span></label>
     <div class="col-sm-2">
      <select class="form-control select2" name="pay_term" id="pay_term" style="width: 100%"> 
      <option value="" selected="selected">Select 选择</option>
      <?php foreach ($plist as $rows) { ?>
        <option value="<?php echo $rows->pay_term; ?>" 
        <?php if (isset($info))
            echo $rows->pay_term==$info->pay_term ? 'selected="selected"' : 0;
            else
            echo $rows->pay_term==set_value('pay_term') ? 'selected="selected"' : 0;
            ?>>
            <?php echo $rows->pay_term; ?></option>
            <?php } ?>
        </select>
     <span class="error-msg"><?php echo form_error("pay_term");?></span>
   </div>
   <label class="col-sm-2 control-label">Payment Disburse<span style="color:red;">  *</span></label>
   <div class="col-sm-1">
       <input type="text" required name="credit_days"  id="credit_days" class="form-control integerchk" value="<?php if(isset($info)) echo $info->credit_days; ?>">
     <span class="error-msg"><?php echo form_error("credit_days");?></span>
    </div>
    <label class="col-sm-1 control-label">days credit<span style="color:red;">  </span></label>
    <label class="col-sm-2 control-label">Discount Amount <span style="color:red;">  *</span></label>
    <div class="col-sm-2">
       <input type="text" name="discount_amount"  required id="discount_amount" class="form-control" value="<?php if(isset($info)) echo $info->discount_amount; else echo 0; ?>" onblur="return totalSum();" onClick="this.select();" onkeyup="return totalSum();">
     <span class="error-msg"><?php echo form_error("discount_amount");?></span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Term & Condition <span style="color:red;">  *</span></label>
     <div class="col-sm-5"> 
     <textarea type="text" name="term_condition" id="term_condition" class="form-control summernote" placeholder="Body"><?php if(isset($info)) echo $info->term_condition; else echo "Delivery: Delivery will be made within 07 working days at Ventura Leatherware Mfy (BD) Ltd.
        Factory: Uttara EPZ, Nilphamary"; ?></textarea>
     <span class="error-msg"><?php echo form_error("term_condition");?></span>
   </div>  
   <label class="col-sm-2 control-label">Total Amount <span style="color:red;">  *</span></label>
    <div class="col-sm-2">
       <input type="text" name="total_amount" readonly required id="total_amount" class="form-control" value="<?php if(isset($info)) echo $info->total_amount; else echo set_value('total_amount'); ?>">
     <span class="error-msg"><?php echo form_error("total_amount");?></span>
    </div>

</div><!-- ///////////////////// -->
</div>
  <!-- /.box-body -->
  <div class="box-footer">
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>format/po/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
  <div class="col-sm-4">
    <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> SAVE 保存</button>
  </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>
<!-- /////////////////////////////////////// -->
<div class="modal fade" id="partyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Supplier</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label">Supplier Name 供应商名称 <span style="color:red;">  *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="supplier_name" placeholder="Supplier Name 供应商名称" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Phone No  </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="phone_no" placeholder="Phone No" value="" >
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Address </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="company_address" placeholder="Address" value="" >
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addNewGuest">Save</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url('asset/supplier.js');?>"></script>
<script src="<?php echo base_url();?>asset/js/plugins/summernote/summernote.js"></script>
<link href="<?php echo base_url();?>asset/js/plugins/summernote/summernote.css" type="text/css" rel="stylesheet">

<script type="text/javascript">
var count = 1
//////////////
var deletedRow=[];
var po_ids='';
<?php  
if(isset($info)){ 
   ?>
    var po_ids=<?php echo $info->po_id; ?>;
    var prid=12000+<?php echo count($detail); ?>;
  <?php }else{ ?>
    var prid=12000;
<?php  } ?>
<?php if(isset($detail)){ 
   ?>
    var id=<?php echo count($detail); ?>;
  <?php }else{ ?>
    var id=0;
<?php  } ?>

<?php  if(!isset($suppcheck)){  ?>
function getSuppItem(){
      var supplier_id=$("#supplier_id").val();
      var for_department_id=$("#for_department_id").val();
      if(supplier_id !=''&&for_department_id!=''){
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'format/po/getSuppItem',
        data:{supplier_id:supplier_id,for_department_id:for_department_id},
        success:function(data){
          $("#form-table tbody").empty();
          $("#form-table tbody").append(data);

        }
      });
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'format/po/getcount',
        data:{supplier_id:supplier_id,for_department_id:for_department_id},
        success:function(data){
           id=data;
           totalSum();
        }
      });
    }else{
      $("#form-table tbody").empty();
      id=0;
    }
  }
<?php } ?>
$(document).ready(function(){
  var po_type=$("#po_type").val(); 
      if(po_type=='BD WO')
      {
        $(".overseas").hide();
        $(".local").show();
      }else  {
        $(".local").hide();
        $(".overseas").show();
      }
  $("#po_type").change(function(){
    var po_type=$("#po_type").val(); 
      if(po_type=='BD WO')
      {
        $(".overseas").hide();
        $(".local").show();
      }else  {
        $(".local").hide();
        $(".overseas").show();
      }
    });
 $('.summernote').summernote({
    onChange: function(contents, $editable) {
      //var latestword = $('div.note-editable').html().split(/(\s|&nbsp;)/).pop();
      //var tmp = $('div.note-editable').html().replace();
      var latestword = $('div.note-editable').html().split(/[ .,:;?!]/).pop();
      latestword=latestword.replace(/<br>/gi, " ");
      latestword=latestword.replace(/<p>/gi, " ");
      latestword=latestword.replace(/<\/p>/gi, " ");

      console.log( "FULL : " , latestword.trim() );
    },
    height: 100,
    codemirror: {                 // code mirror options
      mode: 'text/html',
      htmlMode: true,
      lineNumbers: true,
      theme: 'monokai'
    },
    toolbar: [
      ['style', ['style']],
      ['style', ['bold', 'italic', 'underline','clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['view', ['codeview']],
    ]
      /////////////
  });

  $(window).load(function(){
    $('.note-toolbar .note-fontsize,.note-fontname,.note-font [data-event="removeFormat"],.note-insert,.note-height,.note-view, .note-toolbar .note-color, .note-toolbar .note-para .dropdown-menu li:first, .note-toolbar .note-line-height').remove();

  });
});
$(function () {
  $(document).on('click','input[type=number]',function(){ 
    this.select(); 
    });
    $('.date').datepicker({
      "format": "dd/mm/yyyy",
      "todayHighlight": true,
      "autoclose": true
    });
  
  });
/////////////////
$(document).ready(function(){
  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
        $.ajax({
            type: 'get',
            url: '<?= base_url('format/po/suggestions'); ?>',
            dataType: "json",
            data: {
                term: request.term,
                for_department_id: $('#for_department_id').val()
            },
            success: function (data) {
                $(this).removeClass('ui-autocomplete-loading');
                response(data);
            }
        });
        },
        minLength: 2,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {
            if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                bootbox.alert('Not Found', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
            else if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
            else if (ui.content.length == 1 && ui.content[0].id == 0) {
                bootbox.alert('Not Found', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
        },
        select: function (event, ui) {
            event.preventDefault();
            var productId=ui.item.product_id;
            var chkname=1;
            if (ui.item.id !== 0) {
              for(var i=0;i<id;i++){
              var prid= parseInt($("#product_id_" + i).val());
              if(prid==productId){
                 chkname=2;
              }
             }
          /// if(chkname==2){
           // $("#alertMessageHTML").html("This Material already added!!");
           /// $("#alertMessagemodal").modal("show");
          // }else{

            if(ui.item.image_link==null){
             var links='Please add image in item lists';
            }else{
             var links='';
            }
          //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td>'+
            '<td> <textarea type="text" readonly name="product_code[]" class="form-control" placeholder="Material Code" style="margin-bottom:5px;width:98%" id="product_code_' + id + '">'+ui.item.product_code+'</textarea></td>' +
            '<td> <textarea type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" style="margin-bottom:5px;width:98%" id="product_name_' + id + '">'+ui.item.product_name+'</textarea></td>'+
            '<td> <textarea type="text" name="specification[]" class="form-control" placeholder="specification" value="" style="margin-bottom:5px;width:98%" id="specification_' + id + '"></textarea></td>'+
            '<td> <input type="text" name="quantity[]" value="0" onblur="return checkQuantity(' + id + ');" onClick="this.select();" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="quantity_' + id + '"/> </td>' +
            '<td><input type="text" name="unit_name[]" readonly class="form-control" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.unit_name+'"  id="unit_name_' + id + '"/></td>' +
            '<td> <input type="text" name="unit_price[]" class="form-control" onClick="this.select();" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.unit_price+'" id="unit_price_' + id + '" onblur="return checkUnitPrice(' + id + ');" onClick="this.select();" onkeyup="return checkUnitPrice(' + id + ');"> </td>'+

            '<td> <input type="text" name="sub_total_amount[]" readonly class="form-control" placeholder="Sub Total" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.unit_price+'" id="sub_total_amount_' + id + '"/> </td>' +
            '<td> <input type="text" name="pi_no[]" class="form-control" placeholder="PI NO" style="margin-bottom:5px;width:98%;text-align:center" id="pi_no_' + id + '"/> </td>'+
            '<td class="remarks"><textarea  name="remarks[]" class="form-control" placeholder="Remarks"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="1" id="remarks_' + id + '"></textarea> </td>' +
            ' <td style="text-align:center"> <span class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </span> </td> </tr>';
          $("#form-table tbody").append(nodeStr);

          updateRowNo();
          id++;
        $("#add_item").val('');
       // }
        } else {
        alert('Not Found');
        }
      }
    });
    ////////////// end Add Item///////////////////
    });
    //////////////////////////////////////////////////////
    /////// DELETE FIELD
    ////////////////////////////////////////////////////////
   function deleter(id){
        $("#row_"+id).remove();
        deletedRow.push(id);
        totalSum();
        updateRowNo();
    }
    ////////////////////////////////
    //////////UPDATE ROW NUmber
    ////////////////////////////////
    function updateRowNo(){
      var numRows=$("#form-table tbody tr").length;
      for(var r=0;r<numRows;r++){
          $("#form-table tbody tr").eq(r).find("td:first b").text(r+1);
      }
    }
    ////// TOTAL SUM
    ////////////////////////////////////////////
    function totalSum(){
      var subtotal=0;
      var totalqty=0;
      for(var i=0;i<id;i++){
        if(deletedRow.indexOf(i)<0) {
           var price=parseFloat($.trim($("#unit_price_"+i).val()));
           var quantity=parseFloat($.trim($("#quantity_"+i).val()));
           var priceAndQuantity=price*quantity;
           totalqty+=quantity;
           subtotal += parseFloat($.trim($("#sub_total_amount_" + i).val()));
        }
      }
      $("#subtotal").val(subtotal.toFixed(2));
      var discountamount=parseFloat($.trim($("#discount_amount").val()));
      if(isNaN(discountamount)){
        $("#discount_amount").val(0)
        discountamount=0;

      }
      var totalAmount=subtotal-discountamount;
      $("#total_amount").val(totalAmount.toFixed(2));
    }
    //////////////////////////////////////////////
    /////////////CALCULATE ROW
    //////////////////////////////////////////////
    function calculateRow(id){
      var unitPrice=$("#unit_price_"+id).val();
      var quantity=$("#quantity_"+id).val();

      if($.trim(unitPrice)==""|| typeof unitPrice === "undefined"){
        unitPrice=0
        $("#unit_price_"+id).val(0);
      }
      if($.trim(quantity)==""|| typeof quantity === "undefined"){
        quantity=0
        $("#quantity_"+id).val(0);
      }
      var quantityAndPrice=parseFloat($.trim(unitPrice))*parseFloat($.trim(quantity));
      $("#sub_total_amount_"+id).val(quantityAndPrice.toFixed(2));
      //alert(id);
      totalSum();
    }//calculateRow

    ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
       var quantity=$("#quantity_"+id).val();
       if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
        $("#quantity_"+id).val(1);
      }   
      calculateRow(id);
    }
    ////////////////////////////////////////////
    //////////CHECK UNIT PRICE
    ///////////////////////////////////////////
    function checkUnitPrice(id){
      var unitPrice=$("#unit_price_"+id).val();
      if($.trim(unitPrice)==""){
      $("#unit_price_"+id).val(0);
      }
      calculateRow(id);
    }
///////////////////////////////////////////
  function formsubmit(){ 
    var error_status=false;
    var po_type=$("#po_type").val(); 
    var po_date=$("#po_date").val();
    var delivery_date=$("#delivery_date").val();
    var pay_term=$("#pay_term").val();
    var currency=$("#currency").val();
    var cnc_rate_in_hkd=$("#cnc_rate_in_hkd").val();
    var serviceNum=$("#form-table tbody tr").length;
    var chk;
    if(serviceNum<1){
      $("#alertMessageHTML").html("Please Adding at least one Item!!");
      $("#alertMessagemodal").modal("show");
      error_status=true;
    }
  
  if(po_type=='BD WO'){
    var body_content=$("#body_content").val();
    var subject=$("#subject").val();
    var dear_name=$("#dear_name").val();
    if(body_content ==''){
      error_status=true;
      $('textarea[name=body_content]').css('border', '1px solid #f00');
    } else {
      $('textarea[name=body_content]').css('border', '1px solid #ccc');      
    }
    if(subject ==''){
      error_status=true;
      $('input[name=subject]').css('border', '1px solid #f00');
    } else {
      $('input[name=subject]').css('border', '1px solid #ccc');      
    }
    if(dear_name ==''){
      error_status=true;
      $('input[name=dear_name]').css('border', '1px solid #f00');
    } else {
      $('input[name=dear_name]').css('border', '1px solid #ccc');      
    }
  }else{
    var mode_of_shipment=$("#mode_of_shipment").val();
    if(mode_of_shipment ==''){
      error_status=true;
      $('input[name=mode_of_shipment]').css('border', '1px solid #f00');
    } else {
      $('input[name=mode_of_shipment]').css('border', '1px solid #ccc');      
    }
  }
  if(pay_term ==''){
    error_status=true;
    $('select[name=pay_term]').css('border', '1px solid #f00');
  } else {
    $('select[name=pay_term]').css('border', '1px solid #ccc');      
  }
  if(currency ==''){
    error_status=true;
    $('select[name=currency]').css('border', '1px solid #f00');
  } else {
    $('select[name=currency]').css('border', '1px solid #ccc');      
  }
  if(cnc_rate_in_hkd ==''){
    error_status=true;
    $('cnc_rate_in_hkd[name=po_number]').css('border', '1px solid #f00');
  } else {
    $('cnc_rate_in_hkd[name=po_number]').css('border', '1px solid #ccc');      
  }

  if(total_amount ==''){
    error_status=true;
    $('input[name=total_amount]').css('border', '1px solid #f00');
  } else {
    $('input[name=total_amount]').css('border', '1px solid #ccc');      
  }
  if(po_date == '') {
    error_status=true;
    $("#po_date").css('border', '1px solid #f00');
  } else {
    $("#po_date").css('border', '1px solid #ccc');      
  }
  if(delivery_date == '') {
    error_status=true;
    $("#delivery_date").css('border', '1px solid #f00');
  } else {
    $("#delivery_date").css('border', '1px solid #ccc');      
  }
  /////////////
  for(var i=0;i<serviceNum;i++){
    if($("#unit_price_"+i).val()==''||$("#unit_price_"+i).val()==0){
      $("#unit_price_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
      $("#quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#pi_no_"+i).val()==''){
      $("#pi_no_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#sub_total_amount_"+i).val()==''){
      $("#sub_total_amount_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
  }
  
  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
}
</script>