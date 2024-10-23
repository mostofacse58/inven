<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
$(document).on('click','input[type=number]',function(){ this.select(); });
  $('.date').datepicker({
      "format": "dd/mm/yyyy",
      "todayHighlight": true,
      "autoclose": true
  });
});
//////////////
var deletedRow=[];
<?php  if(isset($info)){ ?>
     var id='<?php echo count($detail); ?>';
     <?php }else{ ?>
    var id=0;
    <?php } ?>
  var check='YES';
$(document).ready(function(){
  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
          $.ajax({
              type: 'get',
              url: '<?= base_url('common/extragrn/suggestions'); ?>',
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
        minLength: 3,
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
           if(chkname==2){
            $("#alertMessageHTML").html("This Items already added!!");
            $("#alertMessagemodal").modal("show");
           }else{
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+
            '<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="CODE" value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +
            
            '<td><input type="text" name="pi_no[]" readonly class="form-control" value="" style="margin-bottom:5px;width:98%" id="pi_no_' + id + '"/> </td>' +
            '<td><input type="text" name="po_qty[]" readonly class="form-control" placeholder="Qty" value=""  style="margin-bottom:5px;width:98%" id="po_qty_' + id + '"/> </td>' +
            ' <td><input type="text" name="quantity[]" value="" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control" placeholder="Qty" style="width:60%;float:left;text-align:center"  id="quantity_' + id + '"/> <label  style="width:38%;float:left">'+ui.item.unit_name+'</label></td>' +
            '<td> <input type="text" name="unit_price[]" class="form-control" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow(' + id + ');" value="'+ui.item.unit_price+'"  id="unit_price_' + id + '"/> </td>' +
            '<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" style="margin-bottom:5px;width:98%;text-align:center" value="0.00"  id="amount_' + id + '"/> </td>' +
            ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
        $("#form-table tbody").append(nodeStr);
        updateRowNo();
        id++;
          //var row = add_invoice_item(ui.item);
          $("#add_item").val('');
        }
        } else {
          alert('Not Found');
        }
        }
    });
////////////// end Add Item///////////////////
    });
    function deleter(id){
        $("#row_"+id).remove();
        deletedRow.push(id);
        updateRowNo();
    }
    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
    function updateRowNo(){
    var numRows=$("#form-table tbody tr").length;
    for(var r=0;r<numRows;r++){
        $("#form-table tbody tr").eq(r).find("td:first b").text(r+1);
    }
    totalSum();
    }
  
 ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
       var quantity=$("#quantity_"+id).val();
       if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
          $("#quantity_"+id).val(0);
        }
      calculateRow(id);
    }
     ////// TOTAL SUM
    ////////////////////////////////////////////
    function totalSum(){
        var totalAmount=0;
        for(var i=0;i<id;i++){
        if(deletedRow.indexOf(i)<0) {
            totalAmount += parseFloat($.trim($("#amount_" + i).val()));
        }
        }
        $("#grand_total").val(totalAmount.toFixed(2));
      }
      //////////////////////////////////////////////
    /////////////CALCULATE ROW
    //////////////////////////////////////////////
    function calculateRow(id){
        var unit_price=$("#unit_price_"+id).val();
        var quantity=$("#quantity_"+id).val();
        if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
            quantity=1;
        }
        if($.trim(unit_price)==""|| $.isNumeric(unit_price)==false){
            unit_price=0;
        }
        var quantityAndPrice=parseFloat($.trim(unit_price))*parseFloat($.trim(quantity));
        ////////////// PUT VALUE ////////
        $("#amount_"+id).val(quantityAndPrice.toFixed(2));
        totalSum();
    }//calculateRow


function formsubmit(){
  var error_status=false;
  var reference_no=$("#reference_no").val();
  var for_department_id=$("#for_department_id").val();
  var supplier_id=$("#supplier_id").val();
  var currency=$("#currency").val();
  var cnc_rate_in_hkd=$("#cnc_rate_in_hkd").val();
  var purchase_date=$("#purchase_date").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Items!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  
  for(var i=0;i<serviceNum;i++){
    if($("#unit_price_"+i).val()==''){
      $("#unit_price_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
      $("#quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
  }
  if(reference_no == '') {
    error_status=true;
    $("#reference_no").css('border', '1px solid #f00');
  } else {
    $("#reference_no").css('border', '1px solid #ccc');      
  }
  if(for_department_id == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select department!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#for_department_id").css('border', '1px solid #ccc');      
  }
  if(supplier_id == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select supplier!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#supplier_id").css('border', '1px solid #ccc');      
  }  
  if(purchase_date == '') {
    error_status=true;
    $("#purchase_date").css('border', '1px solid #f00');
  } else {
    $("#purchase_date").css('border', '1px solid #ccc');      
  }
  if(currency == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select currency!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#currency").css('border', '1px solid #ccc');      
  }
  if(cnc_rate_in_hkd == '') {
    error_status=true;
    $("#cnc_rate_in_hkd").css('border', '1px solid #f00');
  } else {
    $("#cnc_rate_in_hkd").css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
     return true;
  }
  $(".error-flash").delay(5000).hide(200);
}
////////////////////////////

</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>common/extragrn/save<?php if (isset($info)) echo "/$info->purchase_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
          <input type="hidden" name="po_id" id="po_id" value="<?php if(isset($info)) echo $info->po_id; else echo set_value('po_id'); ?>">
         <div class="form-group">
          <label class="col-sm-2 control-label">PO/WO<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input type="text" name="po_number" id="po_number" class="form-control" value="<?php if(isset($info)) echo $info->po_number; else echo set_value('po_number'); ?>"  >
           </div>
          <label class="col-sm-2 control-label">Supplier Name 供应商名称 <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control select2" name="supplier_id" id="supplier_id">> 
              <option value="" selected="selected">===Select Supplier===</option>
              <?php foreach ($slist as $rows) { ?>
                <option value="<?php echo $rows->supplier_id; ?>" 
                <?php if (isset($info))
                    echo $rows->supplier_id == $info->supplier_id ? 'selected="selected"' : 0;
                else
                    echo $rows->supplier_id == set_value('supplier_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->company_name; ?></option>
                    <?php } ?>
                </select>
           <span class="error-msg"><?php echo form_error("use_type");?></span>
         </div>
         <div class="col-sm-1">
              <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#partyModal"><i class="fa fa-plus"></i></a>
        </div>
          <div class="col-sm-2">
            <input type="text" name="tolerance_perc" id="tolerance_perc" class="form-control" value="<?php if(isset($info)) echo $info->tolerance_perc; else echo 0; ?>" placeholder="Tolerance Percentage" >
           </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
       <label class="col-sm-2 control-label"> Date  <span style="color:red;">  *</span></label>
       <div class="col-sm-2">
             <div class="input-group date">
           <div class="input-group-addon">
             <i class="fa fa-calendar"></i>
           </div>
           <input type="text" name="purchase_date" readonly id="purchase_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->purchase_date); else echo date('d/m/Y'); ?>">
         </div>
         <span class="error-msg"><?php echo form_error("purchase_date");?></span>
        </div>
       <label class="col-sm-2 control-label">Ref/Invoice No<span style="color:red;">  *</span> </label>
       <div class="col-sm-2">
         <input type="text" name="reference_no" id="reference_no" class="form-control pull-right" value="<?php if(isset($info)) echo $info->reference_no; else echo set_value('reference_no'); ?>">
         <span class="error-msg"><?php echo form_error("reference_no");?></span>
        </div>
        <label class="col-sm-2 control-label ">For Department <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
          <select class="form-control select2" name="for_department_id" id="for_department_id"> 
          <option value="" selected="selected">Select </option>
          <?php foreach ($dlist as $rows) { ?>
            <option value="<?php echo $rows->department_id; ?>" 
            <?php if (isset($info))
                echo $rows->department_id == $info->for_department_id ? 'selected="selected"' : 0;
                else echo $rows->department_id == $this->session->userdata('department_id') ? 'selected="selected"' : 0;
          
            ?>><?php echo $rows->department_name; ?></option>
                <?php } ?>
            </select>
            <span class="error-msg"><?php echo form_error("for_department_id"); ?></span>
          </div>
      </div><!-- ///////////////////// -->
     
    <div class="form-group Searchclass">
      <label class="col-sm-2 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
        <div class="col-sm-8">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm"  style="overflow: hidden;">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                 
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Items to order list" autocomplete="off" tabindex="1" type="text">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
     </div><!-- ///////////////////// -->
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:5%;text-align:center;">SL</th>
  <th style="width:25%;text-align:center;">Item Name 项目名</th>
  <th style="width:12%;text-align:center;">Item Code 项目代码</th>
  <th style="width:10%;text-align:center;">PI NO</th>
  <th style="width:10%;text-align:center;">PO Qty</th>
  <th style="width:10%;text-align:center;">Quantity</th>
  <th style="width:10%;text-align:center;">Unit Price</th>
  <th style="width:10%;text-align:center;">Amount</th>
  <th style="width:5%;text-align:center">
     <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
       $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
      $str.= '<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="pi_no[]" readonly class="form-control" value="'.$value->pi_no.'"  style="margin-bottom:5px;width:98%" id="pi_no_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="po_qty[]" readonly class="form-control" value="'.$value->po_qty.'"  style="margin-bottom:5px;width:98%" id="po_qty_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"/> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
      $str.= '<td> <input type="text" name="unit_price[]" class="form-control" placeholder="Unit Price" value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"  style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"/> </td>';
      $str.= '<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" value="'.$value->amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"/> </td>';
      $str.= '<td> <a class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></a></td></tr>';
         echo $str;
       ?>
      <?php 
      $id++; 
      $i++;
       }
      endif;
      ?>
</tbody>
</table>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label ">Currency<span style="color:red;">  *</span></label>
    <div class="col-sm-2">
    <select class="form-control select2" name="currency" id="currency" style="width: 100%"> 
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
   <div class="col-sm-1">
       <input type="text" name="cnc_rate_in_hkd"  id="cnc_rate_in_hkd" class="form-control" value="<?php if(isset($info)) echo $info->cnc_rate_in_hkd; else echo '0.92'; ?>">
     <span class="error-msg"><?php echo form_error("cnc_rate_in_hkd");?></span>
    </div>
  <label class="col-sm-2 control-label">Total Amount<span style="color:red;">  *</span></label>
    <div class="col-sm-2">
      <input type="text" name="grand_total" id="grand_total" readonly class="form-control" value="<?php if(isset($info)) echo $info->grand_total; else echo set_value('grand_total'); ?>">
      <span class="error-msg"><?php echo form_error("grand_total"); ?></span>
    </div>
  </div><!-- ///////////////////// -->

</div>
   <div class="form-group">
          <label class="col-sm-2 control-label">Reason<span style="color:red;">  </span></label>
           <div class="col-sm-8">
           <input type="text" name="note" id="note" class="form-control" placeholder="Reason" value="<?php if(isset($info->note)) echo $info->note; else echo set_value('note'); ?>">
           <span class="error-msg"><?php echo form_error("note");?></span>
         </div>
      </div><!-- ///////////////////// -->
  <!-- /.box-body -->
  <div class="box-footer">
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>common/extragrn/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
  <div class="col-sm-4">
      <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
  </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>

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
            <label class="col-sm-4 control-label">Company Name <span style="color:red;">  *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="">
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
