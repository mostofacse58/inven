<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
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
     var id=<?php echo  count($info); ?>
     <?php }else{ ?>
    var id=0;
    <?php } ?>


$(document).ready(function(){
  $("#add_req").click(function(){
         var nodeStr = '<tr id="row_' + id + '"><td><input type="text" name="tpm_serial_code[]"  class="form-control" required  placeholder="TPM CODE (TPM代码)" style="margin-bottom:5px;width:98%" id="tpm_serial_code_' + id + '"/></td>'+
          '<td> <input type="text" name="other_description[]" class="form-control" placeholder="Description" style="width:98%;"  id="other_description_' + id + '"/></td>' +
           ' <td> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
        $("#form-table tbody").append(nodeStr);
        updateRowNo();
        id++;
        totalSum();
    });//addField
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
  var product_id=$("#product_id").val();
  var purchase_date=$("#purchase_date").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
      error_status=true;
  }
  for(var i=0;i<serviceNum;i++){
      if($("#tpm_serial_code_"+i).val()==''){
        $("#tpm_serial_code_"+i).css('border', '1px solid #f00');
         error_status=true;
      }
  }
  if(product_id == ''){
    error_status=true;
    $('input[name=product_id]').css('border', '1px solid #f00');
  } else {
    $('input[name=product_id]').css('border', '1px solid #ccc');      
  }
  if(purchase_date == '') {
    error_status=true;
    $('input[name=purchase_date]').css('border', '1px solid #f00');
  } else {
    $('input[name=purchase_date]').css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
}
</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>egm/machineregister/save<?php if (isset($info)) echo "/$info->product_detail_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
          <div class="box-body">
              <div class="form-group">
                  <label class="col-sm-3 control-label">Product Name (Model No) <span style="color:red;">  *</span></label>
                  <div class="col-sm-7">
                   <select class="form-control select2" name="product_id">
                  <option value="" selected="selected">===Select Product Name===</option>
                  <?php foreach ($machinelist as $rows) { ?>
                    <option value="<?php echo $rows->product_id; ?>" 
                    <?php if (isset($info))
                        echo $rows->product_id == $info->product_id ? 'selected="selected"' : 0;
                    else
                        echo $rows->product_id == set_value('product_id') ? 'selected="selected"' : 0;
                    ?>><?php echo $rows->product_name; ?></option>
                        <?php } ?>
                    </select>
                  <span class="error-msg"><?php echo form_error("product_id"); ?></span>
                </div>
              </div><!-- ///////////////////// -->
              <div class="form-group">
                  <label class="col-sm-3 control-label">Supplier Name 供应商名称</label>
                  <div class="col-sm-7">
                   <select class="form-control select2" name="supplier_id">
                  <option value="" selected="selected">===Select Supplier Name 供应商名称===</option>
                  <?php foreach ($slist as $rows) { ?>
                    <option value="<?php echo $rows->supplier_id; ?>" 
                    <?php if (isset($info))
                        echo $rows->supplier_id == $info->supplier_id ? 'selected="selected"' : 0;
                    else
                        echo $rows->supplier_id == set_value('supplier_id') ? 'selected="selected"' : 0;
                    ?>><?php echo $rows->supplier_name; ?></option>
                        <?php } ?>
                    </select>
                  <span class="error-msg"><?php echo form_error("supplier_id"); ?></span>
                </div>
              </div><!-- ///////////////////// -->
              <div class="form-group">
                <label class="col-sm-2 control-label">INVOICE NO <span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                       <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="<?php if(isset($info)) echo $info->invoice_no; else echo set_value('invoice_no'); ?>">
               <span class="error-msg"><?php echo form_error("invoice_no");?></span>
              </div>

                 <label class="col-sm-2 control-label">Purchase Date <span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                    <div class="input-group date">
                    <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <input type="text" name="purchase_date" readonly id="purchase_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->purchase_date); else echo set_value('purchase_date'); ?>">
                     </div>
               <span class="error-msg"><?php echo form_error("purchase_date");?></span>
              </div>
              <label class="col-sm-1 control-label">Value</label>
                   <div class="col-sm-2">
                       <input type="text" name="machine_price" id="machine_price" class="form-control" value="<?php if(isset($info)) echo $info->machine_price; else echo set_value('machine_price'); ?>">
               <span class="error-msg"><?php echo form_error("machine_price");?></span>
              </div>
               </div><!-- ///////////////////// -->
                 <div class="form-group">
                   <div class="col-sm-7 col-sm-offset-3">
                   <button id="add_req"  class="btn btn-info">Add TPM CODE (TPM代码)</button>
                  </div>
                </div>
                <br>
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:20%;text-align:center">TPM CODE (TPM代码)</th>
  <th style="width:20%;text-align:center">Description</th>
  <th style="width:10%;text-align:center">Actions 行动 <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($info)):
$str= '<tr  id="row_'.$i. '"><td><input type="text" name="tpm_serial_code[]" required class="form-control"  placeholder="TPM CODE (TPM代码)"  value="'.$info->tpm_serial_code.'" style="margin-bottom:5px;width:98%" id="tpm_serial_code_'.$i. '"/></td>';
$str.= '<td> <input type="text" name="other_description[]" value="'.$info->other_description.'"  class="form-control" placeholder="Description" style="width:98%;"  id="other_description_'.$i.'"/></td>';
$str.= '<td> <button class="btn btn-danger btn-xs" onclick="return deleter('. $i .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
   echo $str;

    ?>
   <?php
endif;
?>
</tbody>
</table>
</div>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>egm/machineregister/lists" class="btn btn-info">
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

