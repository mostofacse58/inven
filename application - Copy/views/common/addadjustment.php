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
      ///////////////
function getitemAllFifo(){
  var ITEM_CODE=$("#ITEM_CODE").val();
  var department_id=$("#department_id").val();
  if(ITEM_CODE !=''&&department_id !=''){
  $.ajax({
    type:"post",
    url:"<?php echo base_url()?>"+'common/adjustment/getproductinfo',
    data:{ITEM_CODE:ITEM_CODE,department_id:department_id},
    success:function(data1){
      data1=JSON.parse(data1);
      $('#product_name').val(data1.product_name);
      $('#product_id').val(data1.product_id);
      $('#unit_name').val(data1.unit_name);
    }
  });
  $.ajax({
    type:"post",
    url:"<?php echo base_url()?>"+'common/adjustment/getitemAllFifo',
    data:{ITEM_CODE:ITEM_CODE,department_id:department_id},
    success:function(data){
      $("#form-table tbody").empty();
      $("#form-table tbody").append(data);
      }
  });
  }else{
    $("#alertMessageHTML").html("Please select department & input code!!");
    $("#alertMessagemodal").modal("show");
  }
}
//////

  
  
 function formsubmit(){
    var error_status=false;
    var INDATE=$("#INDATE").val();
    var department_id=$("#department_id").val();
    if(department_id == ''){
      error_status=true;
      $("#alertMessageHTML").html("Please select department!!");
      $("#alertMessagemodal").modal("show");
    }
    if(INDATE == '') {
      error_status=true;
      $("#INDATE").css('border', '1px solid #f00');
    } else {
      $("#INDATE").css('border', '1px solid #ccc');      
    }
    if(error_status==true){
      return false;
    }else{
      $('button[type=submit]').attr('disabled','disabled');
      return true;
    }
}
 $(document).ready(function(){
  $("#department_id").change(function(){
       getitemAllFifo();
  });
  //////////////////date picker//////////////////////
      $('.date').datepicker({
        "format":"dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose":true
      });
    ///////////////////////////////////
  });
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
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>common/adjustment/save<?php if(isset($info)) echo "/$info->adjustment_id"; ?>" method="POST" enctype="multipart/form-data"  onsubmit="formsubmit();">
        <div class="box-body">
      <!-- ///////////////////// -->
      <div class="form-group">    
          <label class="col-sm-2 control-label">
              For Department <span style="color:red;">  </span></label>
              <div class="col-sm-3">
              <select class="form-control select2" name="department_id" id="department_id" style="width: 100%"> 
              <option value="" selected="selected">Select Department</option>
              <?php foreach ($dlist as $rows) { ?>
                <option value="<?php echo $rows->department_id; ?>" 
                <?php if (isset($info))
                  echo $rows->department_id == $info->department_id ? 'selected="selected"' : 0;
                else
                  echo $rows->department_id == set_value('department_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->department_name; ?></option>
                    <?php } ?>
                </select>
            <span class="error-msg"><?php echo form_error("department_id"); ?></span>
          </div>       
          <label class="col-sm-2 control-label">Item Code <span style="color:red;">  *</span></label>
          <div class="col-sm-3">
            <input type="text" name="ITEM_CODE"  id="ITEM_CODE" class="form-control" value="<?php if(isset($info)) echo $info->ITEM_CODE; else echo set_value('ITEM_CODE'); ?>" <?php if (!isset($info)){ ?> onkeyup="return getitemAllFifo();" <?php } ?>>
           <span class="error-msg"><?php echo form_error("ITEM_CODE");?></span>
          </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Product Name <span style="color:red;">  </span></label>
          <div class="col-sm-3">
            <input type="hidden" name="product_id" readonly id="product_id" value="<?php if(isset($info)) echo $info->product_id; else echo set_value('product_id'); ?>">
           <input type="text" name="product_name" readonly id="product_name" class="form-control" value="<?php if(isset($info)) echo $info->product_name; else echo set_value('product_name'); ?>">
          <span class="error-msg"><?php echo form_error("product_name"); ?></span>
        </div>
        <div class="col-sm-1">
           <input type="text" name="unit_name" readonly id="unit_name" class="form-control" value="<?php if(isset($info)) echo $info->unit_name; else echo set_value('unit_name'); ?>">
          <span class="error-msg"><?php echo form_error("unit_name"); ?></span>
        </div>
           <label class="col-sm-2 control-label">Adjustment Date <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
              <div class="input-group date">
               <div class="input-group-addon">
                 <i class="fa fa-calendar"></i>
               </div>
               <input type="text" name="INDATE" id="INDATE" readonly class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->INDATE); else echo date('d/m/Y'); ?>" required>
             </div>
           <span class="error-msg"><?php echo form_error("INDATE");?></span>
         </div>
        </div>
        <div class="form-group">
        <label class="col-sm-2 control-label">Note</label>
        <div class="col-sm-7">
          <textarea  name="reason_note" class="form-control" rows="3"><?php if(isset($info)) echo $info->reason_note; else echo set_value('reason_note'); ?> </textarea>
           <span class="error-msg"><?php echo form_error("reason_note");?></span>
        </div>
      </div><!-- ///////////////////// -->
        <div class="table-responsive">
          <table class="table table-bordered" id="form-table">
          <thead>
          <tr>
            <th style="width:3%;text-align:center">SL</th>
            <th style="width:10%;text-align:center;">FIFO CODE</th>
            <th style="width:8%;text-align:center">Stock Qty</th>
            <th style="width:8%;text-align:center;">Adjust Quantity</th>
            <th style="width:8%;text-align:center;">Unit Price</th>
            <th style="width:4%;text-align:center;">Currency</th>
          </thead>
          <tbody>
           <?php
           $i=0;
           $id=0;
            if(isset($detail)):
              foreach ($detail as  $value) {
                $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->FIFO_CODE.'" name="FIFO_CODE[]"  id="FIFO_CODE_' . $id . '"/><b>' . ($id +1).'</b></td><td><input type="text" name="FIFO_CODE[]" class="form-control" readonly placeholder="'.$value->FIFO_CODE.'" value="'.$value->FIFO_CODE.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
                
                $str.= '<td><input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" 
                value="'.$stock.'" style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"> </td>';
                $str.= '<td><input type="text" name="QUANTITY[]" value="'.$value->QUANTITY.'"  class="form-control" placeholder="QUANTITY" style="width:98%;float:left;text-align:center"  id="QUANTITY_' .$id. '"></td>';
                $str.= '<td><input type="text" name="UPRICE[]" readonly class="form-control" placeholder="Price" value="'.$value->UPRICE.'"  style="margin-bottom:5px;width:98%" id="UPRICE_'.$id. '"/> </td>';
                $str.= '<td> <input type="text" name="CRRNCY[]" readonly class="form-control" placeholder="CNC" value="'.$value->CRRNCY.'" style="margin-bottom:5px;width:98%;text-align:center" id="CRRNCY_'.$id.'"> </td>';
                $str.= '</tr>';
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
           <div class="col-sm-4">
            <a href="<?php echo base_url(); ?>common/adjustment/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
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
 <script>
 $(document).ready(function(){
  //////////////////date picker//////////////////////
    $('#product_id').on('change',function(){
    var product_id = $('#product_id').val();  
       $.ajax({
            url: '<?php echo base_url("common/adjustment/getproductinfo") ?>',
            method:"POST",
            data:{
                product_id : product_id
            },
            success:function(response) {
                var data = JSON.parse(response);
                $("#unit_price").val(data.unit_price);
                $("#product_code").val(data.product_code);
                $("#product_name").val(data.product_name);
                $("#CRRNCY").val(data.CRRNCY);
            },
            error:function(){
                alert("error");
            }
        });
    });
  });
</script>
