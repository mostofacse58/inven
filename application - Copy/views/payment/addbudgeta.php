 <style type="text/css">
  .error-msg{display:none;}
</style>
<script type="text/javascript">
function formsubmit(){
  var error_status=false;
}
var baseURL = '<?php echo base_url();?>';
 
</script>
<div class="row">
<div class="col-md-12">
  <div class="box box-info">


 <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5>Budget  Adjustment</h5>

<div class="widget-control pull-right">

</div>
</div>
</div>
</div>
  <!-- form start -->
<form class="form-horizontal" action="<?php echo base_url(); ?>payment/budgeta/save<?php if (isset($info)) echo "/$master_id"; ?>" method="POST" id="formid">
<div class="box-body">
  
 <br>
 <div class="form-group">
  <label class="col-sm-2 control-label">Month</label>
  <div class="col-sm-4">
    <input type="text" class="form-control month" readonly name="for_month" value="<?php if(isset($info))  echo $info->for_month; ?>">
  </div>
   <label class="col-sm-2 control-label">Budget. NO</label>
  <div class="col-sm-4">
    <input type="text" class="form-control" readonly name="budget_no" value="<?php if(isset($info))  echo $info->budget_no; ?>">
  </div>
</div>
<div class="form-group">
    <div class="col-sm-12" style="text-align: right;margin-bottom:10px;">  
    <div class="table-responsive">
    <table class="table table-bordered" id="formtable" style="width: 100%">
  <thead>
   <tr>
    <th style="text-align:center;font-size: 16px;width: 5%;">SN</th>
    <th style="text-align:center;font-size: 16px;width: 20%;">Account Head </th>
    <th style="text-align:center;width: 10%;" valign="top">Budget</th>
      <th style="text-align:center;font-size: 16px;width: 10%;">Remarks</th>
  </tr>

  </thead>
  <?php 
    if(isset($hlist)){
    $i=1;
    foreach ($hlist as  $rows){ 
   ?>
   <tr>
    <td style="text-align: center;"><?php echo $i; ?> </td>
    <td style="text-align: center;">
      <?php echo $rows->head_name; ?>
      <input type="hidden" name="head_id[]" value="<?php echo $rows->head_id; ?>"> 
    </td>
    <td style="text-align:center;">
      <input type="text" name="amount[]" class="form-control" onfocus="this.select();" value="<?php if($rows->amount==0) echo 0; else echo $rows->amount; ?>" id="amount_<?php echo $i; ?>">
    </td>
     
    <td style="text-align:center;">
      <input type="text" name="remarks[]" class="form-control" value="<?php echo $rows->remarks; ?>" id="remarks_<?php echo $i; ?>">
    </td>

   </tr>
  <?php $i++;}

   }

  ?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
<!-- /.box-body -->
<div class="box-footer">
  <div class="col-sm-6"><a href="<?php echo base_url(); ?>payment/budgeta/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
  <div class="col-sm-">
    <button type="submit" name="save" class="btn btn-info">
        <i class="fa fa-save"></i> SAVE</button>
       &nbsp;&nbsp;&nbsp;
 </div>
</div>

</form>

  
</div>
  <!-- /.box-footer -->

</div>
</div>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
      $('.month').datepicker({
          "format": "yyyy-mm",
          "startView": "months", 
           "minViewMode": "months",
           "autoclose": true
      });
    });
</script>