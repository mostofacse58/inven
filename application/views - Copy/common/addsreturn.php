<style>
   table.table-bordered tbody tr td{
        border-bottom: 1px solid #e2e2e2;
    }
    table.table-bordered tbody tr td:last-child{
        border: 1px solid #e2e2e2;

    }
    table.table-bordered tbody tr td h3{margin:0px;}

    .employee-holder{
        position: absolute;
        top:30px;
        display: none;
        background-color: #ffffff;
        width:270px;
        border:1px solid #efefef;
        z-index: 1000;
        box-shadow: 0 0 4px 0px #ccc;
    }
    .employee-holder ul{
        list-style: none;
        margin: 0px;
        padding: 0px;
    }
    .employee-holder ul li{
        margin: 0px;
        list-style: none;
        width:100%;
        padding:5px 10px;
        color:#666;
        background-color: #fff;
        border-bottom: 1px solid #e2e2e2;
    }
    .employee-holder ul li:hover,.employee-holder ul li.active{
        background-color: #0C5889;
        color:#fff;
    }
    .error-msg{display:none;}
    .form-control{
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
    }
</style>
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
///////////////////////////////////////////
function getprwiseitem(){
  var requisition_no=$("#requisition_no").val();
  if(requisition_no !=''&&requisition_no.length==17){
  $.ajax({
    type:"post",
    url:"<?php echo base_url()?>"+'common/sreturn/getprinfo',
    data:{requisition_no:requisition_no},
    success:function(data1){
      data1=JSON.parse(data1);
      $('#take_department_id').val(data1.department_id).change();
      $("#employee_id").val(data1.employee_id);
      if(data1.employee_id==''){
        $('#issue_type').val("2").change();  
      }   
      $('#product_detail_id').val(data1.product_detail_id).change();        
    }
  });
  $.ajax({
    type:"post",
    url:"<?php echo base_url()?>"+'common/sreturn/getprwiseitem',
    data:{requisition_no:requisition_no},
    success:function(data){
      $("#form-table tbody").empty();
      $("#form-table tbody").append(data);
      }
  });
}
}

//////////////
var deletedRow=[];
<?php  
if(isset($info)){ ?>
     var id=<?php echo  count($detail); ?>;
     <?php }else{ ?>
    var id=0;
    <?php } ?>

$(document).ready(function(){
  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
        $.ajax({
            type: 'get',
            url: '<?= base_url('common/sreturn/suggestions'); ?>',
            dataType: "json",
            data: {
                term: request.term
            },
            success: function (data) {
                $(this).removeClass('ui-autocomplete-loading');
                response(data);
            }
        });
        },
        minLength: 1,
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
            var unit_price=ui.item.unit_price;
            var productId=ui.item.product_id;
            var PFCODE=ui.item.FIFO_CODE;
            var sub_total=(parseFloat(unit_price)*1).toFixed(3);
            var chkname=1;
            if (ui.item.id !== 0) {
              for(var i=0;i<id;i++){
                var FCODE= $("#FIFO_CODE_"+i).val();
                if(FCODE==PFCODE){
                   chkname=2;
                }
               }
            if(chkname==2){
              $("#alertMessageHTML").html("This FIFO already added!!");
              $("#alertMessagemodal").modal("show");
            }else{
           //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+
            '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code " value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +
            '<td> <input type="text" name="FIFO_CODE[]" readonly class="form-control" placeholder="FIFO_CODE" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.FIFO_CODE+'"  id="FIFO_CODE_' + id + '" readonly> </td>' +
            '<td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.stock+'"  id="stock_' + id + '"/> </td>' +
            '<td> <input type="text" name="quantity[]" onfocus="this.select();"  value="1" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control integerchk"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' + id + '"/> <label  style="width:38%;float:left">'+ui.item.unit_name+'</label></td>' +
            '<td> <input type="text" readonly name="unit_price[]" class="form-control" placeholder="Unit Price" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.unit_price+'"  id="unit_price_' + id + '"  onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow(' + id + ');"> </td>' +
            '<td> <input type="text" name="sub_total[]" readonly class="form-control" placeholder="Amount" style="margin-bottom:5px;width:98%;text-align:center" value="'+sub_total+'"  id="sub_total_' + id + '"/> </td>' +
            '<td><input type="text" name="currency[]" readonly class="form-control" placeholder="CUR" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.currency+'"  id="currency_' + id + '"/> </td>' +
            '<td><input type="text" name="cnc_rate_in_hkd[]" readonly class="form-control" placeholder="Rate" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.cnc_rate_in_hkd+'"  id="cnc_rate_in_hkd_' + id + '"/> </td>' +
            '<td style="text-align:center"><a class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </a> </td> </tr>';
        $("#form-table tbody").append(nodeStr);
        $("#currency_"+id).val(ui.item.currency).change();
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

  });

//////////////////////////////
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
    }
  function formsubmit(){
  var error_status=false;
  // var me_id=$("#me_id").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Item!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var sreturn_date=$("#sreturn_date").val();
  var issue_type=$("#issue_type").val();
  if(issue_type==1){
    var take_department_id=$("#take_department_id").val();
    if(take_department_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select department!!");
      $("#alertMessagemodal").modal("show");
    }
   }else if(issue_type==2){
    var employee_id=$("#employee_id").val();
    if(employee_id == ''){
      error_status=true;
      $('input[name=employee_id]').css('border', '1px solid #f00');
    } else {
      $('input[name=employee_id]').css('border', '1px solid #ccc');      
    }
    if(employee_id.length!=5&&employee_id != ''){
      error_status=true;
      $("#alertMessageHTML").html("Please Enter ID NO exactly 5 digit!!");
      $("#alertMessagemodal").modal("show");
    }
   }else if(issue_type==3){
    var supplier_id=$("#supplier_id").val();
    if(supplier_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select Location!!");
      $("#alertMessagemodal").modal("show");
    } else {
      $('select[name=supplier_id]').css('border', '1px solid #ccc');      
    }
   }
  for(var i=0;i<serviceNum;i++){
   var qtyy= parseFloat($.trim($("#quantity_"+i).val()));
   var stockqty= parseFloat($.trim($("#stock_"+i).val()));
    if($("#product_code_"+i).val()==''){
      $("#product_code_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
      $("#quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#FIFO_CODE_"+i).val()==''){
      $("#FIFO_CODE_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if(qtyy>stockqty){
      error_status=true;
      $("#quantity_"+id).val(0);
      $("#alertMessageHTML").html("Not enough Stock!!");
      $("#alertMessagemodal").modal("show");

    }
  }
  if(sreturn_date == '') {
    error_status=true;
    $("#sreturn_date").css('border', '1px solid #f00');
  } else {
    $("#sreturn_date").css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
    return true;
  }
}
 ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
  function checkQuantity(id){
      var quantity=$("#quantity_"+id).val();
       var stock=$("#stock_"+id).val();
     if(stock-quantity<0){
         $("#alertMessageHTML").html("Not enough Stock!!");
         $("#alertMessagemodal").modal("show");
         $("#quantity_"+id).val(0);
      }else{
       if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
            $("#quantity_"+id).val(0);

        }
  }
  calculateRow(id);
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
      $("#sub_total_"+id).val(quantityAndPrice.toFixed(3));
     
  }//calculateRow


</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>common/sreturn/save<?php if (isset($info)) echo "/$info->issue_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
         <label class="col-sm-2 control-label ">Rerurn No <span style="color:red;"> </span></label>
          <div class="col-sm-2">
           <input type="text" name="requisition_no" id="requisition_no" class="form-control pull-right" value="<?php if(isset($info)) echo $info->requisition_no; else echo set_value('requisition_no'); ?>" <?php if (!isset($info)){ ?> onkeyup="return getprwiseitem();" <?php } ?> >
           <span class="error-msg"><?php echo form_error("requisition_no");?></span>
         </div>
         
         <label class="col-sm-2 control-label">Supplier <span style="color:red;">  *</span></label>
          <div class="col-sm-4">
            <select class="form-control select2" name="supplier_id" id="supplier_id" style="width: 100%">
              <option value="">Select Supplier</option>
              <?php foreach ($slist as $value) {  ?>
                <option value="<?php echo $value->supplier_id; ?>"
                  <?php  if(isset($info)) echo $value->supplier_id==$info->supplier_id? 'selected="selected"':0; else echo set_select('supplier_id',$value->supplier_id);?>>
                  <?php echo $value->supplier_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("supplier_id");?></span>
          </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
        <label class="col-sm-2 control-label">Return Date </label>
         <div class="col-sm-2">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="sreturn_date" readonly id="sreturn_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->sreturn_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("sreturn_date");?></span>
          </div>
          <label class="col-sm-2 control-label">PO NO<span style="color:red;">  </span></label>
           <div class="col-sm-2">
           <input type="text" name="po_number" id="po_number" class="form-control" placeholder="PO NO" value="<?php if(isset($info->po_number)) echo $info->po_number; else echo set_value('po_number'); ?>">
           <span class="error-msg"><?php echo form_error("po_number");?></span>
         </div>
        <label class="col-sm-1 control-label">Note<span style="color:red;">  </span></label>
           <div class="col-sm-3">
           <input type="text" name="sreturn_note" id="sreturn_note" class="form-control" placeholder="Note" value="<?php if(isset($info->sreturn_note)) echo $info->sreturn_note; else echo set_value('sreturn_note'); ?>">
           <span class="error-msg"><?php echo form_error("sreturn_note");?></span>
         </div>
      </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
        <div class="col-sm-10">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm"  style="overflow: hidden;">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Item to order list" autocomplete="off" tabindex="1" type="text">
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
    <th style="width:5%;text-align:center">SL</th>
    <th style="width:17%;text-align:center">Item Name 项目名</th>
    <th style="width:10%;text-align:center">Item Code </th>
    <th style="width:10%;text-align:center;">FIFO CODE</th>
    <th style="width:8%;text-align:center">Stock Qty</th>
    <th style="width:8%;text-align:center;">Quantity</th>
    <th style="width:8%;text-align:center;">Unit Price</th>
    <th style="width:8%;text-align:center;">Amount</th>
    <th style="width:4%;text-align:center;">Currency</th>
    <th style="width:8%;text-align:center;">Reason</th>
    <th style="width:5%;text-align:center">
       <i class="fa fa-trash-o"></i></th>
  </tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $stock=$value->main_stock+$value->quantity;
      $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td><td><input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
      $str.= '<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="FIFO_CODE[]"  class="form-control" placeholder="FIFO_CODE" value="'.$value->FIFO_CODE.'"  style="margin-bottom:5px;width:98%" id="FIFO_CODE_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" 
      value="'.$stock.'" style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"> </td>';
      $str.= '<td><input type="text" name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
      $str.= '<td><input type="text" name="unit_price[]"  class="form-control" placeholder="Unit Price" 
      value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"> </td>';
      $str.= '<td> <input type="text" name="sub_total[]" readonly class="form-control" placeholder="Amount" 
      value="'.$value->sub_total.'" style="margin-bottom:5px;width:98%;text-align:center" id="sub_total_'.$id.'"> </td>';
      $str.= '<td> <input type="text" name="currency[]" readonly class="form-control" placeholder="CNC" 
      value="'.$value->currency.'" style="margin-bottom:5px;width:98%;text-align:center" id="currency_'.$id.'"> </td>';
      $str.= '<td> <input type="text" name="reason[]" class="form-control" placeholder="reason" 
      value="'.$value->reason.'" style="margin-bottom:5px;width:98%;text-align:center" id="reason_'.$id.'"> </td>';
      $str.= '<td style"text-align:center"><a class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></a></td></tr>';
      echo $str;
       ?>
      <?php 
      $id++;
       }
      endif;
      ?>
</tbody>
</table>
</div>

</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>common/sreturn/lists" class="btn btn-info">
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

