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
     var id=<?php echo  count($detail); ?>
     <?php }else{ ?>
    var id=0;
    <?php } ?>
$(document).ready(function(){
  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
           
            $.ajax({
                type: 'get',
                url: '<?= base_url('me/spurchase/suggestions'); ?>',
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
            $("#alertMessageHTML").html("This Spares already added!!");
            $("#alertMessagemodal").modal("show");
           }else{
              //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+

            '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="TPM CODE (TPM代码)" value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +

            '<td class="description"><textarea  name="description[]" class="form-control" readonly placeholder="Description"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="description_' + id + '">'+ui.item.description+'</textarea> </td>' +

            ' <td> <input type="text" name="quantity[]" value="" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Qty" style="width:60%;float:left;text-align:center"  id="quantity_' + id + '"/> <label  style="width:38%;float:left">'+ui.item.unit_name+'</label></td>' +

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
    }

  function formsubmit(){
  var error_status=false;
  var me_id=$("#me_id").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Spares!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  
  var purchase_date=$("#purchase_date").val();
    var pi_id=$("#pi_id").val();
    if(pi_id == ''){
      error_status=true;
      $('select[name=pi_id]').css('border', '1px solid #f00');
    } else {
      $('select[name=pi_id]').css('border', '1px solid #ccc');      
    }
  /////////////
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
  
  if(purchase_date == '') {
    error_status=true;
    $("#purchase_date").css('border', '1px solid #f00');
  } else {
    $("#purchase_date").css('border', '1px solid #ccc');      
  }

  if(error_status==true){
    return false;
  }else{
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
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

</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>me/spurchase/save<?php if (isset($info)) echo "/$info->purchase_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Supplier Name 供应商名称 <span style="color:red;">  *</span></label>
           <div class="col-sm-4">
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
         <label class="col-sm-1 control-label">PI No <span style="color:red;">  *</span></label>
              <div class="col-sm-3">
               <select class="form-control select2" name="pi_id" id="pi_id">> 
              <option value="" selected="selected">===Select PI===</option>
              <?php foreach ($pilist as $rows) { ?>
                <option value="<?php echo $rows->pi_id; ?>" 
                <?php if (isset($info))
                    echo $rows->pi_id == $info->pi_id ? 'selected="selected"' : 0;
                else
                    echo $rows->pi_id == set_value('pi_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->pi_no; ?></option>
                    <?php } ?>
                </select>
              <span class="error-msg"><?php echo form_error("pi_id"); ?></span>
            </div>
      </div><!-- ///////////////////// -->
      
      <div class="form-group">
         <label class="col-sm-2 control-label">Purchase Date <span style="color:red;">  *</span></label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="purchase_date" readonly id="purchase_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->purchase_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("purchase_date");?></span>
          </div>
         <label class="col-sm-2 control-label">Reference No<span style="color:red;">  *</span> </label>
         <div class="col-sm-2">
           <input type="text" name="reference_no" id="reference_no" class="form-control pull-right" value="<?php if(isset($info)) echo $info->reference_no; else echo set_value('reference_no'); ?>">
           <span class="error-msg"><?php echo form_error("reference_no");?></span>
          </div>
        </div><!-- ///////////////////// -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Note<span style="color:red;">  </span></label>
           <div class="col-sm-8">
           <input type="text" name="note" id="note" class="form-control" placeholder="Note" value="<?php if(isset($info->note)) echo $info->note; else echo set_value('note'); ?>">
           <span class="error-msg"><?php echo form_error("note");?></span>
         </div>
      </div><!-- ///////////////////// -->
    <div class="form-group">
      <label class="col-sm-2 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
        <div class="col-sm-8">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm"  style="overflow: hidden;">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                 
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Spares to order list" autocomplete="off" tabindex="1" type="text">
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
  <th style="width:17%;text-align:center">Spares Name</th>
  <th style="width:12%;text-align:center">Item Code 项目代码</th>
  <th style="width:25%;text-align:center">Description</th>
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
      $stock=$this->look_up_model->get_sparesStock($value->product_id);
      $stock=$stock+$value->quantity;
      $description="Material Type: $value->mtype_name";
        if($value->mdiameter!=''){
          $description=$description.", Diameter:$value->mdiameter";
        }
        if($value->mthread_count!=''){
          $description=$description.", Thread Count:$value->mthread_count";
        }
        if($value->mlength!=''){
          $description=$description.", Length:$value->mlength";
        }
      
       $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';

      $str.= '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="TPM CODE (TPM代码)" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';

      $str.= '<td class="description"> <textarea  name="description[]" class="form-control" readonly placeholder="Description"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="description_'.$id.'">'.$description.'</textarea> </td>';


      $str.= '<td> <input type="text" name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"/> <label  style="width:38%;float:left">'.$value->unit_price.'</label></td>';
      $str.= '<td> <input type="text" name="unit_price[]" class="form-control" placeholder="Unit Price" value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"  style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"/> </td>';
      $str.= '<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" value="'.$value->amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"/> </td>';
      $str.= '<td> <button class="btn btn-danger btn-xs" onclick="return deleter('. $i .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
         echo $str;
       ?>
         <?php
       }
      endif;
      ?>
</tbody>
</table>
</div>
<div class="form-group">
    <label class="col-sm-2 col-sm-offset-7 control-label">Total Amount<span style="color:red;">  *</span></label>
        <div class="col-sm-2">
          <input type="text" name="grand_total" id="grand_total" readonly class="form-control pull-right" value="<?php if(isset($info)) echo $info->grand_total; else echo set_value('grand_total'); ?>">
          <span class="error-msg"><?php echo form_error("grand_total"); ?></span>
        </div>
      </div><!-- ///////////////////// -->
</div>
  <!-- /.box-body -->
  <div class="box-footer">
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>me/spurchase/lists" class="btn btn-info">
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
