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
     var id=<?php echo  count($detail); ?>
     <?php }else{ ?>
    var id=0;
    <?php } ?>
    
$(document).ready(function(){
  var use_type=$("#use_type").val(); 
      if(use_type==1){
         $("#machinediv").show();
         $("#otherdiv").hide();
      }else  {
         $("#otherdiv").show();
         $("#machinediv").hide();           
      }
  $("#use_type").change(function(){
    var use_type=$("#use_type").val(); 
      if(use_type==1){
         $("#machinediv").show();
         $("#otherdiv").hide();
      }else  {
         $("#otherdiv").show();
         $("#machinediv").hide();           
      }
    });
  ///////////////////////
  <?php if(isset($info)){ ?>
var product_detail_ids = "<?php echo $info->product_detail_id; ?>";
<?php  }else{ ?>
  var product_detail_ids = "<?php echo set_value('product_detail_id') ?>";
<?php }?>
///////////////////
var currencyselect='<?php if(isset($clist)){
foreach ($clist as $rows) {?>
  <option value="<?php echo $rows->currency; ?>"><?php echo "$rows->currency";?>
  </option><?php }} ?> ';
////////////////////////
 // var line_id=$('#line_id').val();
 //      if(line_id !=''){
 //      $.ajax({
 //        type:"post",
 //        url:"<?php //echo base_url()?>"+'me/usingspares/getMachineLine/'+product_detail_ids,
 //        data:{line_id:line_id},
 //        success:function(data){
 //          $("#product_detail_id").empty();
 //          $("#product_detail_id").append(data);
 //          if(product_detail_ids != ''){
 //            $('#product_detail_id').val(product_detail_ids).change();
 //          }
 //        }
 //      });
 //    }

///////////////////////
// $('#line_id').on('change',function(){
//   var line_id=$('#line_id').val();
//       if(line_id !=''){
//       $.ajax({
//         type:"post",
//         url:"<?php //echo base_url()?>"+'me/usingspares/getMachineLine',
//         data:{line_id:line_id},
//         success:function(data){
//           $("#product_detail_id").empty();
//           $("#product_detail_id").append(data);
//           if(product_detail_ids != ''){
//             $('#product_detail_id').val(product_detail_ids).change();
//           }
//         }
//       });
//     }
//     });


  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
           
            $.ajax({
                type: 'get',
                url: '<?= base_url('me/usingspares/suggestions'); ?>',
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
            }else if (ui.content.length == 1 && ui.content[0].id != 0) {
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
            var PFCODE=ui.item.FIFO_CODE;
            var chkname=1;
            if (ui.item.id !== 0) {
            for(var i=0;i<id;i++){
              var FCODE= parseInt($("#FIFO_CODE_" + i).val());
              if(FCODE==PFCODE){
                 chkname=2;
              }
             }
           if(chkname==2){
            $("#alertMessageHTML").html("This FIFO CODE already added!!");
            $("#alertMessagemodal").modal("show");
           }else{
           //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+

            '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="TPM CODE (TPM代码)" value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +
            '<td> <input type="text" name="specification[]" readonly class="form-control" placeholder="specification" value="'+ui.item.specification+'"  style="margin-bottom:5px;width:98%" id="specification_' + id + '"/> </td>' +

            '<td> <input type="text" name="FIFO_CODE[]" readonly class="form-control" placeholder="FIFO_CODE" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.FIFO_CODE+'"  id="FIFO_CODE_' + id + '"> </td>' +

            ' <td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.stock+'"  id="stock_' + id + '"/> </td>' +
            ' <td> <input type="text" name="quantity[]" onfocus="this.select();"  value="0" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' + id + '"/> <label  style="width:38%;float:left">'+ui.item.unit_name+'</label></td>' +
            ' <td> <input type="text" name="unit_price[]" readonly class="form-control" placeholder="Unit Price" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.unit_price+'"  id="unit_price_' + id + '"  onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow(' + id + ');"> </td>' +

            '<td><input type="text" name="currency[]" readonly class="form-control" placeholder="CNC" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.currency+'"  id="currency_' + id + '"/></td>' +
            
            ' <td><input type="text" name="cnc_rate_in_hkd[]" readonly class="form-control" placeholder="Rate" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.cnc_rate_in_hkd+'"  id="cnc_rate_in_hkd_' + id + '"/> </td>' +
            ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
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
  
  var use_date=$("#use_date").val();
  var use_type=$("#use_type").val();
  for(var i=0;i<serviceNum;i++){
    var qtyy= parseFloat($.trim($("#quantity_"+i).val()));
    var stockqty= parseFloat($.trim($("#stock_"+i).val()));
    
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
  
  if(use_date == '') {
    error_status=true;
    $("#use_date").css('border', '1px solid #f00');
  } else {
    $("#use_date").css('border', '1px solid #ccc');      
  }

  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
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
    }
///////////////////////////////////////////
function getprwiseitem(){
  var requisition_no=$("#requisition_no").val();
  var status='';
  if(requisition_no !=''&&requisition_no.length==17){

  $.ajax({
    type:"post",
    url:"<?php echo base_url()?>"+'me/usingspares/getprinfo',
    data:{requisition_no:requisition_no},
    success:function(data1){
      data1=JSON.parse(data1)
      status=data1.status;
      if(data1.status=='NO'){
        $('#take_department_id').val(data1.department_id).change();
        $('#line_id').val(data1.line_id).change();
        $('#me_id').val(data1.me_id).change();
        $("#asset_encoding").val(data1.asset_encoding);
        $("#other_id").val(data1.employee_id);
        if(data1.asset_encoding!=''){
          $('#use_type').val("1").change();            
        } 
      }else{
        $("#alertMessageHTML").html("Sorry, Already issue this requisition.!!");
        $("#alertMessagemodal").modal("show");
      }

    }
  });

  $.ajax({
    type:"post",
    url:"<?php echo base_url()?>"+'me/usingspares/getprwiseitem',
    data:{requisition_no:requisition_no},
    success:function(data){
      $("#form-table tbody").empty();
      $("#form-table tbody").append(data);
      }
  });
}
}
</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>me/usingspares/save<?php if (isset($info)) echo "/$info->spares_use_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Use Type <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control" name="use_type" id="use_type">
              <option value="1"
                <?php if(isset($info)) echo '1'==$info->use_type? 'selected="selected"':0; else echo set_select('use_type','1');?>>Machine</option>
                  <option value="2"
                <?php if(isset($info)) echo '2'==$info->use_type? 'selected="selected"':0; else echo set_select('use_type','2');?>>Others</option>
            </select>
           <span class="error-msg"><?php echo form_error("use_type");?></span>
         </div>
         <label class="col-sm-2 control-label">Location <span style="color:red;">  *</span></label>
            <div class="col-sm-2">
               <select class="form-control select2" name="line_id" id="line_id">> 
              <option value="" selected="selected">===Select Location===</option>
              <?php foreach ($flist as $rows) { ?>
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
            <label class="col-sm-2 control-label">Requisition No <span style="color:red;"> * </span> </label>
         <div class="col-sm-2">
           <input type="text" name="requisition_no" id="requisition_no" class="form-control pull-right" value="<?php if(isset($info)) echo $info->requisition_no; else echo set_value('requisition_no'); ?>" <?php if (!isset($info)){ ?> onkeyup="return getprwiseitem();" <?php } ?>>
           <span class="error-msg"><?php echo form_error("requisition_no");?></span>
          </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
     
          <label class="col-sm-2 control-label">Purpose<span style="color:red;">  </span></label>
           <div class="col-sm-4">
           <input type="text" name="use_purpose" id="use_purpose" class="form-control" placeholder="Use Purpose" value="<?php if(isset($info->use_purpose)) echo $info->use_purpose; else echo set_value('use_purpose'); ?>">
           <span class="error-msg"><?php echo form_error("use_purpose");?></span>
         </div>
         <label class="col-sm-1 control-label">Code<span style="color:red;">  *</span></label>
           <div class="col-sm-2">
           <input type="text" name="asset_encoding" id="asset_encoding" class="form-control" placeholder="TPM/Asset CODE" value="<?php if(isset($info->asset_encoding)) echo $info->asset_encoding; else echo set_value('asset_encoding'); ?>">
           <span class="error-msg"><?php echo form_error("asset_encoding");?></span>
         </div>
         <label class="col-sm-1 control-label ">Department <span style="color:red;">  *</span></label>
          <div class="col-sm-2">
          <select class="form-control select2" name="take_department_id" id="take_department_id" style="width: 100%"> 
            <option value="" selected="selected">Select Department</option>
            <?php foreach ($dlist as $rows) { ?>
              <option value="<?php echo $rows->department_id; ?>" 
              <?php if (isset($info))
                  echo $rows->department_id == $info->take_department_id ? 'selected="selected"' : 0;
              else
                  echo $rows->department_id ==5 ? 'selected="selected"' : 0;
              ?>><?php echo $rows->department_name; ?></option>
                  <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("take_department_id"); ?></span>
            </div>
    
          
      </div><!-- ///////////////////// -->
      <div class="form-group">
         <label class="col-sm-2 control-label">Date </label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="use_date" readonly id="use_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->use_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("use_date");?></span>
          </div>
          <label class="col-sm-1 control-label">ME  <span style="color:red;">*  </span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="me_id" id="me_id">
              <option value="">Select ME</option>
              <?php $melist=$this->db->query("SELECT * FROM me_info")->result();
              foreach ($melist as $value) {  ?>
                <option value="<?php echo $value->me_id; ?>"
                  <?php  if(isset($info)) echo $value->me_id==$info->me_id? 'selected="selected"':0; else echo set_select('me_id',$value->me_id);?>>
                  <?php echo $value->me_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("me_id");?></span>
         </div>
           <div class="col-sm-2">
            <select class="form-control select2" name="TRX_TYPE" id="TRX_TYPE">
              <option value="TPMISSUE"
                <?php if(isset($info)) echo 'TPMISSUE'==$info->TRX_TYPE? 'selected="selected"':0; else echo set_select('TRX_TYPE','TPMISSUE');?>>TPMISSUE</option>
              <option value="GOUTLD"
                <?php if(isset($info)) echo 'GOUTLD'==$info->TRX_TYPE? 'selected="selected"':0; else echo set_select('TRX_TYPE','GOUTLD');?>>GOUTLD</option>
              <option value="GOUTDD"
                <?php if(isset($info)) echo 'GOUTDD'==$info->TRX_TYPE? 'selected="selected"':0; else echo set_select('TRX_TYPE','GOUTDD');?>>GOUTDD</option>
              <option value="GOUTGT"
                <?php if(isset($info)) echo 'GOUTGT'==$info->TRX_TYPE? 'selected="selected"':0; else echo set_select('TRX_TYPE','GOUTGT');?>>GOUTGT</option>
              <option value="GOUTOD"
                <?php if(isset($info)) echo 'GOUTOD'==$info->TRX_TYPE? 'selected="selected"':0; else echo set_select('TRX_TYPE','GOUTOD');?>>GOUTOD</option>
            </select>
           <span class="error-msg"><?php echo form_error("use_type");?></span>
         </div>
         <label class="col-sm-1 control-label">Other ID </label>
         <div class="col-sm-2">
           <input type="text" name="other_id" id="other_id" class="form-control pull-right" value="<?php if(isset($info)) echo $info->other_id; else echo set_value('other_id'); ?>">
           <span class="error-msg"><?php echo form_error("other_id");?></span>
          </div>
        </div><!-- ///////////////////// -->
    <div class="form-group">
      <label class="col-sm-2 control-label" style="margin-top: 14px">
        SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
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
  <th style="width:20%;text-align:center">Spares Name</th>
  <th style="width:12%;text-align:center">Item Code 项目代码</th>
  <th style="width:12%;text-align:center">Specification</th>
  <th style="width:10%;text-align:center;">FIFO CODE</th>
  <th style="width:6%;text-align:center">Stock Qty</th>
  <th style="width:10%;text-align:center;">Quantity</th>
  <th style="width:8%;text-align:center;">Unit Price</th>
  <th style="width:4%;text-align:center;">Currency</th>
  <th style="width:8%;text-align:center;">Rate HKD</th>
  <th style="width:5%;text-align:center">
     <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $stock=$value->main_stock+$value->quantity;
      $optionTree="";
        foreach ($clist as $rowc):
          $selected=($rowc->currency==$value->currency)? 'selected="selected"':'';
          $optionTree.='<option value="'.$rowc->currency.'" '.$selected.'>'.$rowc->currency.'</option>'; 
        endforeach;
       $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
       $str.= '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="TPM CODE (TPM代码)" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
       $str.= '<td> <input type="text" name="specification[]" readonly class="form-control" placeholder="specification" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'.$id. '"/> </td>';
       $str.= '<td><input type="text" readonly name="FIFO_CODE[]"  class="form-control" placeholder="FIFO_CODE" value="'.$value->FIFO_CODE.'"  style="margin-bottom:5px;width:98%" id="FIFO_CODE_'.$id. '"/> </td>';
      $str.= '<td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" value="'.$stock.'"   style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"/> </td>';
      $str.= '<td> <input type="text" name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"/> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';
       $str.= '<td><input type="text" readonly name="unit_price[]"  class="form-control" placeholder="Unit Price" 
      value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"> </td>';
      $str.='<td> <input type="text" name="currency[]" readonly class="form-control" placeholder="CNC" 
      value="'.$value->currency.'" style="margin-bottom:5px;width:98%;text-align:center" id="currency_'.$id.'"></td> ';

      $str.= '<td> <input type="text" name="cnc_rate_in_hkd[]" readonly class="form-control" placeholder="Rate" 
      value="'.$value->cnc_rate_in_hkd.'" style="margin-bottom:5px;width:98%;text-align:center" id="cnc_rate_in_hkd_'.$id.'"> </td>';
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
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>me/usingspares/lists" class="btn btn-info">
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

