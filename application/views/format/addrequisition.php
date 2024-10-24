<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>format/requisition/save<?php if (isset($info)) echo "/$info->requisition_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
        <label class="col-sm-2 control-label">To Department  <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="responsible_department" id="responsible_department">> 
              <?php foreach ($dlist as $rows) { ?>
                <option value="<?php echo $rows->department_id; ?>" 
                <?php if (isset($info))
                    echo $rows->department_id == $info->responsible_department? 'selected="selected"' : 0;
                else
                    echo $rows->department_id == set_value('responsible_department') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->department_name; ?></option>
                    <?php } ?>
                </select>
           <span class="error-msg"><?php echo form_error("responsible_department");?></span>
         </div>
         <label class="col-sm-2 control-label">Requisition Date <span style="color:red;">  *</span></label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="requisition_date" readonly id="requisition_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->requisition_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("requisition_date");?></span>
          </div>
         <label class="col-sm-2 control-label">Demand Date<span style="color:red;">  *</span> </label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="demand_date" readonly id="demand_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->demand_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("demand_date");?></span>
          </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
        <label class="col-sm-2 control-label ">Employee ID </label>
           <div class="col-sm-2 ">
             <input type="text" name="employee_id" maxlength="5" id="employee_id" class="form-control" value="<?php if(isset($info)) echo $info->employee_id; else echo set_value('employee_id'); ?>">
             <span class="error-msg"><?php echo form_error("employee_id");?></span>
             <span id="errmsg"></span>
           </div>
           <label class="col-sm-2 control-label ">Asset Code </label>
           <div class="col-sm-2 ">
             <input type="text" name="asset_encoding" id="asset_encoding" class="form-control" value="<?php if(isset($info)) echo $info->asset_encoding; else echo set_value('asset_encoding'); ?>">
             <span class="error-msg"><?php echo form_error("asset_encoding");?></span>
           </div>
           <label class="col-sm-1 control-label">Note<span style="color:red;">  </span></label>
           <div class="col-sm-3">
           <input type="text" name="other_note" id="other_note" class="form-control" placeholder="Note" value="<?php if(isset($info->other_note)) echo $info->other_note; else echo set_value('other_note'); ?>">
           <span class="error-msg"><?php echo form_error("other_note");?></span>
         </div>  
       </div><!-- ///////////////////// -->
      <div class="form-group">
         <label class="col-sm-2 control-label">File No<span style="color:red;">  </span></label>
          <div class="col-sm-3">
            <select class="form-control select2" name="file_no" id="file_no">
            <option value="" selected="selected">Select File No</option>
            <?php foreach ($flist as $rows) { ?>
            <option value="<?php echo $rows->file_no; ?>" 
            <?php if (isset($info))
                echo $rows->file_no == $info->file_no ? 'selected="selected"' : 0;
                else
                echo $rows->file_no == set_value('file_no')? 'selected="selected"' : 0;
            ?>><?php echo "$rows->file_no"; ?></option>
                <?php } ?>
            </select>
           </div>  
           <label class="col-sm-2 control-label">Location <span style="color:red;">  </span></label>
            <div class="col-sm-3">
               <select class="form-control select2" name="line_id" id="line_id">> 
              <option value="" selected="selected">===Select Location===</option>
              <?php foreach ($llist as $rows) { ?>
                <option value="<?php echo $rows->line_id; ?>" 
                <?php if (isset($info))
                    echo $rows->line_id == $info->line_id ? 'selected="selected"' : 0;
                else
                    echo $rows->line_id == set_value('line_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->line_no; ?></option>
                    <?php } ?>
                </select>
              <span class="error-msg"><?php echo form_error("line_id"); ?></span>
            </div>     
        
        </div><!-- ///////////////////// -->
    <div class="form-group">
      <label class="col-sm-2 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索Item<span style="color:red;">  </span></label>
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
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:4%;text-align:center">SN</th>
  <th style="width:12%;text-align:center">Item code</th>
  <th style="width:25%;text-align:center">Materials Description</th>
  <th style="width:10%;text-align:center">Spacification</th>
  <th style="width:8%;text-align:center;">Req. Qty</th>
  <th style="width:8%;text-align:center;">Stock Qty</th>
  <th style="width:5%;text-align:center;">Unit</th>
  <th style="width:12%;text-align:center;">Remarks</th>
  <th style="width:5%;text-align:center">
    <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value){
       $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td>';
       $str.='<td><input readonly type="text" name="product_code[]" class="form-control"  placeholder="Material Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';

        $str.='<td><input type="text" name="product_name[]" readonly class="form-control" placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
     $str.='<td><input type="text" name="specification[]" class="form-control" placeholder="'.$value->specification.'" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'  .$id. '"/> </td>';

      $str.= '<td><input type="text" name="required_qty[]" value="'.$value->required_qty.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="required_qty_' .$id. '"/></td>';
      $str.= '<td><input type="text" name="stock_qty[]" readonly class="form-control" placeholder="Stock" value="'.$value->stock_qty.'"   style="margin-bottom:5px;width:98%;text-align:center" id="stock_qty_'.$id.'"/> </td>';
      $str.= '<td><label  style="width:98%;float:left">'.$value->unit_name.'</label></td>';
      $str.= '<td><textarea  name="remarks[]" class="form-control"  placeholder="Remarks"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="remarks_'.$id.'">'.$value->remarks.'</textarea> </td>';
      $str.= '<td><a class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></a></td></tr>';
      echo $str;
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
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>format/requisition/lists" class="btn btn-info">
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
     var id=<?php echo  count($detail); ?>;
     <?php }else{ ?>
    var id=0;
    <?php } ?>
$(document).ready(function(){
  
  $("#responsible_department").change(function() {
    $("#form-table tbody").empty();
    id=0;
  });
  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
        $.ajax({
            type: 'get',
            url: '<?= base_url('format/requisition/suggestions'); ?>',
            dataType: "json",
            data: {
              term: request.term,
              responsible_department: $('#responsible_department').val()
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
           if(chkname==2){
            $("#alertMessageHTML").html("This Material already added!!");
            $("#alertMessagemodal").modal("show");
           }else{
              //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td>'+
           '<td> <input type="text" readonly name="product_code[]" class="form-control" placeholder="Material Code" value="'+ui.item.product_code+'" style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +

            '<td> <input type="text" name="product_name[]" class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+
            '<td> <input type="text" name="specification[]" class="form-control" placeholder="Specification" value="" style="margin-bottom:5px;width:98%" id="specification_' + id + '"/> </td>'+          

            '<td> <input type="text" name="required_qty[]" value="" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Qty" style="width:98%;float:left;text-align:center"  id="required_qty_' + id + '"/> </td>' +
           
            '<td> <input type="text" name="stock_qty[]" readonly class="form-control" placeholder="Stock" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.stock+'"  id="stock_qty_' + id + '"/> </td>' +

            ' <td><label  style="width:98%;float:left">'+ui.item.unit_name+'</label></td>' +
            '<td class="remarks"><textarea  name="remarks[]" class="form-control" placeholder="Remarks"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="remarks_' + id + '"></textarea> </td>' +
            ' <td style="text-align:center"> <a class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </a> </td> </tr>';
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
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Item!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var requisition_date=$("#requisition_date").val();
  var demand_date=$("#demand_date").val();
  var requisition_no=$("#requisition_no").val();
  var responsible_department=$("#responsible_department").val();
  if(responsible_department==''){
    $("#alertMessageHTML").html("Please select From Department!!");
    $("#alertMessagemodal").modal("show");
  }
  if(requisition_no == ''){
      error_status=true;
      $('input[name=requisition_no]').css('border', '1px solid #f00');
    } else {
      $('input[name=requisition_no]').css('border', '1px solid #ccc');      
    }
  /////////////
  for(var i=0;i<serviceNum;i++){
    if($("#required_qty_"+i).val()==''){
      $("#required_qty_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    }
  
  if(requisition_date == '') {
    error_status=true;
    $("#requisition_date").css('border', '1px solid #f00');
  } else {
    $("#requisition_date").css('border', '1px solid #ccc');      
  }
  if(demand_date == '') {
    error_status=true;
    $("#demand_date").css('border', '1px solid #f00');
  } else {
    $("#demand_date").css('border', '1px solid #ccc');      
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
    function checkQuantity(ids){
       var required_qty=$("#required_qty_"+ids).val();
       if($.trim(required_qty)==""|| $.isNumeric(required_qty)==false){
        $("#required_qty_"+ids).val(0);
       }
      }
</script>