<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
$(document).on('click','input[type=number]',function(){ this.select(); });
  $('.date').datepicker({
      "format": "dd/mm/yyyy",
      "todayHighlight": true,
      "endDate": '0d',
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
      source: function (request, resrfinse) {
        $.ajax({
            type: 'get',
            url: '<?= base_url('proc/rfq/suggestions'); ?>',
            dataType: "json",
            data: {
              term: request.term
            },
            success: function (data) {
              $(this).removeClass('ui-autocomplete-loading');
              resrfinse(data);
            }
        });
      },
      minLength: 3,
      autoFocus: false,
      delay: 250,
      resrfinse: function (event, ui) {
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
          '<td><input type="text" name="specification[]" class="form-control" value="" style="margin-bottom:5px;width:98%" id="specification_' + id + '"/></td>' +

          '<td><input type="text" name="pi_no[]" class="form-control" value="" style="margin-bottom:5px;width:98%" id="pi_no_' + id + '"/> </td>' +
          '<td><input type="text" name="rfi_qty[]" readonly class="form-control" placeholder="Qty" value=""  style="margin-bottom:5px;width:98%" id="rfi_qty_' + id + '"/> </td>' +
          ' <td><input type="text" name="quantity[]" value="" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control integerchk" placeholder="Qty" style="width:100%;float:left;text-align:center"  id="quantity_' + id + '"/> </td>' +
           '<td> <input type="text" name="unit_price[]" class="form-control integerchk" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow(' + id + ');" value="'+ui.item.unit_price+'"  id="unit_price_' + id + '"/> </td>' +
          '<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" style="margin-bottom:5px;width:98%;text-align:center" value="0.00"  id="amount_' + id + '"/> </td>' +
          '<td><select name="box_name[]" required class="form-control pull-left select2" style="width:100%;"  id="box_name_' + id + '" required><option value="" selected="selected">Select</option>'+boxselect+'</select> </td>' +
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
  var rfq_date=$("#rfq_date").val();
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
  if(rfq_date == '') {
    error_status=true;
    $("#rfq_date").css('border', '1px solid #f00');
  } else {
    $("#rfq_date").css('border', '1px solid #ccc');      
  }
  if(currency == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select currency!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#currency").css('border', '1px solid #ccc');      
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
function getRFIwiseitem(){
      var rfi_no=$("#rfi_no").val();
      if(rfi_no !=''&&rfi_no.length==17){
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'proc/rfq/getRFIInfo',
        data:{rfi_no:rfi_no},
        success:function(data1){
          data1=JSON.parse(data1);
          check=data1.check
          if(check=='YES'){
            $('#for_department_id').val(data1.for_department_id);
            $('#currency').val(data1.currency).change();
            $("#rfi_id").val(data1.rfi_id);
            totalSum();
          }else{
            $("#alertMessageHTML").html("This RFI not found or not approved!!");
            $("#alertMessagemodal").modal("show");
          }
        }
      });
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'proc/rfq/getRFIwiseitem',
        data:{rfi_no:rfi_no},
        success:function(data){
          $("#form-table tbody").empty();
          $("#form-table tbody").append(data);
          var serviceNum=$("#form-table tbody tr").length;
          id=serviceNum;
          totalSum();
          }
      });
    }else{
      $("#form-table tbody").empty();
      $(".Searchclass").show();
      id=0;
    }
  }
</script>
<div class="row">
    <div class="col-md-12">
    	    <div class="panel panel-success">
      <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">

</div>
</div>
</div>
</div>
   <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>proc/rfq/save" method="post" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
          <input type="hidden" name="rfi_id" id="rfi_id" value="<?php if(isset($info)) echo $info->rfi_id; else echo set_value('rfi_id'); ?>">
          <input type="hidden" name="for_department_id" id="for_department_id" value="<?php if(isset($info)) echo $info->for_department_id; else echo set_value('for_department_id'); ?>">
         <div class="form-group">
          <label class="col-sm-2 control-label">RFI NO<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input type="text" name="rfi_no" id="rfi_no" class="form-control pull-right" value="<?php if(isset($info)) echo $info->rfi_no; else echo set_value('rfi_no'); ?>"  onkeyup="return getRFIwiseitem();">
          </div>
          <label class="col-sm-2 control-label">Supplier Name <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control select2" name="supplier_id" id="supplier_id" required=""> 
              <option value="" selected="selected">Select Supplier</option>
              <?php foreach ($slist as $rows) { ?>
                <option value="<?php echo $rows->supplier_id; ?>" 
                <?php if (isset($info))
                    echo $rows->supplier_id == $info->supplier_id ? 'selected="selected"' : 0;
                else
                    echo $rows->supplier_id == set_value('supplier_id') ? 'selected="selected"' : 0;
                ?>><?php echo "$rows->supplier_name"; ?></option>
                    <?php } ?>
                </select>
           <span class="error-msg"><?php echo form_error("supplier_id");?></span>
         </div>
         <label class="col-sm-1 control-label"> Quotation No  <span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input type="text" name="quotation_no" id="quotation_no" class="form-control" value="<?php if(isset($info)) echo $info->quotation_no; else echo set_value('quotation_no');; ?>" placeholder="Quotation No" >
           </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
       <label class="col-sm-2 control-label"> Date  <span style="color:red;">  *</span></label>
       <div class="col-sm-2">
             <div class="input-group date">
           <div class="input-group-addon">
             <i class="fa fa-calendar"></i>
           </div>
           <input type="text" name="rfq_date" readonly id="rfq_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->rfq_date); else echo date('d/m/Y'); ?>">
         </div>
         <span class="error-msg"><?php echo form_error("rfq_date");?></span>
        </div>
        <label class="col-sm-2 control-label"> Quotation Date  <span style="color:red;">  *</span></label>
       <div class="col-sm-2">
             <div class="input-group date">
           <div class="input-group-addon">
             <i class="fa fa-calendar"></i>
           </div>
           <input type="text" name="quotation_date" readonly id="quotation_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->quotation_date); else echo date('d/m/Y'); ?>">
         </div>
         <span class="error-msg"><?php echo form_error("quotation_date");?></span>
        </div>
      </div><!-- ///////////////////// -->
     
   <input type="hidden" name="ovgrn_id" value="<?php if(isset($info)) echo $info->rfq_id; else echo 0; ?>">
<div class="table-resrfinsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:5%;text-align:center;">SL</th>
  <th style="width:12%;text-align:center;">Material Name</th>
  <th style="width:12%;text-align:center;">Material Code</th>
  <th style="width:15%;text-align:center;">Specification</th>
  <th style="width:8%;text-align:center;"> Qty</th>
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

      $str.= '<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'" style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="specification[]" class="form-control" value="'.$value->specification.'" style="margin-bottom:5px;width:98%" id="specification_'.$id. '"/> </td>';
       $str.= '<td><input type="text" readonly name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:100%;float:left;text-align:center"  id="quantity_' .$id. '"/> </td>';

      $str.= '<td> <input type="text" name="unit_price[]" class="form-control" placeholder="Unit Price" value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"  style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"/> </td>';
      $str.= '<td><input type="text" readonly name="amount[]" readonly class="form-control" placeholder="Amount" value="'.$value->amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"/> </td>';
 
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
  <label class="col-sm-2 control-label">Total Amount<span style="color:red;">  *</span></label>
    <div class="col-sm-2">
      <input type="text" name="grand_total" id="grand_total" readonly class="form-control pull-right" value="<?php if(isset($info)) echo $info->grand_total; else echo set_value('grand_total'); ?>">
      <span class="error-msg"><?php echo form_error("grand_total"); ?></span>
    </div>
  </div><!-- ///////////////////// -->

</div>
   <div class="form-group">
      <label class="col-sm-2 control-label">Remarks<span style="color:red;">  </span></label>
       <div class="col-sm-6">
       <input type="text" name="note" id="note" class="form-control" placeholder="Remarks" value="<?php if(isset($info->note)) echo $info->note; else echo set_value('note'); ?>">
       <span class="error-msg"><?php echo form_error("note");?></span>
     </div>
     <div class="col-sm-3">
          <input type="file" class="form-control"  name="attachment"  id="attachment"  class="form-control" >
          <?php if(isset($info) &&!empty($info->attachment)) { ?>
            <div style="margin-top:10px;">
              <input type="hidden" name="attachment_p" id="attachment_p" value="<?php echo $info->attachment; ?>">
            <a href="<?php echo base_url(); ?>dashboard/drfqatt/<?php echo $info->attachment; ?>">Download</a>
            </div>
          <?php } ?>
          <span>Allows Type: jpg,png, pdf.</span>
          <p class="error-msg"><?php  
              if(isset($exception_err)) echo $exception_err; ?></p>
        </div>
  </div><!-- ///////////////////// -->
  <!-- /.box-body -->
  <div class="box-footer">
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>proc/rfq/lists" class="btn btn-info">
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
</div>
 