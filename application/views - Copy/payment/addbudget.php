 <style type="text/css">
  .error-msg{display:none;}
</style>
<script type="text/javascript">
function formsubmit(){
  var error_status=false;
}
var baseURL = '<?php echo base_url();?>';
$(function() {
  $('.checkboxfun').click(function() {
    var id =$(this).val();
    if ($('.checkboxfun').is(':checked')) {
      var values=$("#amount_"+id).val();
      $("#amount2_"+id).val(values);
      $("#amount3_"+id).val(values);
      $("#amount4_"+id).val(values);
      $("#amount5_"+id).val(values);
      $("#amount6_"+id).val(values);
    } else {
      $("#amount2_"+id).val(0);
      $("#amount3_"+id).val(0);
      $("#amount4_"+id).val(0);
      $("#amount5_"+id).val(0);
      $("#amount6_"+id).val(0);
    }
  });
});
</script>
<div class="row">
<div class="col-md-12">
  <div class="box box-info">


 <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5>Budget for <?php 
      if(isset($info)) 
        {$date = date('Y-m',strtotime($info->for_month." +-1 month")); 
      } else {
        $date = date('Y-m');
      }
       $onemonth = date('Y-m',strtotime($date." +1 month"));
       $twomonth = date('Y-m',strtotime($date." +2 month"));
       $threemonth = date('Y-m',strtotime($date." +3 month"));
       $fourmonth = date('Y-m',strtotime($date." +4 month"));
       $fivemonth = date('Y-m',strtotime($date." +5 month"));
       $sixmonth = date('Y-m',strtotime($date." +6 month"));
       echo date("M-Y", strtotime("$onemonth"));
 ?></h5>

<div class="widget-control pull-right">

</div>
</div>
</div>
</div>
  <!-- form start -->
<form class="form-horizontal" action="<?php echo base_url(); ?>payment/budget/save<?php if (isset($info)) echo "/$master_id"; ?>" method="POST" id="formid">
<div class="box-body">
  <input type="hidden" class="hidden" name="for_month" value="<?php echo $onemonth; ?>">
 <br>
<div class="form-group">
        <div class="col-sm-12" style="text-align: right;margin-bottom:10px;">  
        <div class="table-responsive">
        <table class="table table-bordered" id="formtable" style="width: 100%">
<thead>
 <tr>
  <th style="text-align:center;font-size: 16px;width: 5%;" rowspan="2">SN</th>
  <th style="text-align:center;font-size: 16px;width: 20%;" rowspan="2">Account Head </th>
  <th style="text-align:center;width: 10%;" valign="top">Budget</th>
  <th style="text-align:center;width: 10%;" valign="top" rowspan="2">Other same as Budget</th>
  <th style="text-align:center;font-size: 16px;width: 24%;" colspan="3">All Cost Forecast </th>
  <th style="text-align:center;font-size: ;width: 16%;" colspan="2">Vital Cost Forecast </th>
  <th style="text-align:center;font-size: 16px;width: 10%;" rowspan="2">Remarks</th>
</tr>
<tr>
  <th style="text-align:center;"><?php echo date("M-Y", strtotime("$onemonth")); ?></th>
  <th style="text-align:center;font-size: 16px"><?php echo date("M-Y", strtotime("$twomonth")); ?></th>
  <th style="text-align:center;font-size: 16px"><?php echo date("M-Y", strtotime("$threemonth")); ?></th>
  <th style="text-align:center;font-size: 16px"><?php echo date("M-Y", strtotime("$fourmonth")); ?></th>
  <th style="text-align:center;font-size: 16px"><?php echo date("M-Y", strtotime("$fivemonth")); ?></th>
  <th style="text-align:center;font-size: 16px"><?php echo date("M-Y", strtotime("$sixmonth")); ?></th>
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
    <input type="text" name="amount[]" class="form-control integerchk" onfocus="this.select();" value="<?php if($rows->amount==0) echo $this->budget_model->getLastMonth($rows->head_id,$date); else echo $rows->amount; ?>" id="amount_<?php echo $i; ?>">
  </td>
  <td style="text-align: center;"><input type="checkbox" class="checkboxfun"  value="<?php echo $i; ?>"></td>
  <td style="text-align:center;">
    <input type="text" name="amount2[]" class="form-control integerchk" onfocus="this.select();" value="<?php echo $rows->amount2; ?>" id="amount2_<?php echo $i; ?>">
  </td>
  <td style="text-align:center;">
    <input type="text" name="amount3[]" class="form-control integerchk" onfocus="this.select();" value="<?php echo $rows->amount3; ?>" id="amount3_<?php echo $i; ?>">
  </td>
  <td style="text-align:center;">
    <input type="text" name="amount4[]" class="form-control integerchk" onfocus="this.select();" value="<?php echo $rows->amount4; ?>" id="amount4_<?php echo $i; ?>">
  </td>
  <td style="text-align:center;">
    <input type="text" name="amount5[]" class="form-control integerchk" onfocus="this.select();" value="<?php echo $rows->amount5; ?>" id="amount5_<?php echo $i; ?>">
  </td>
  <td style="text-align:center;">
    <input type="text" name="amount6[]" class="form-control integerchk" onfocus="this.select();" value="<?php echo $rows->amount6; ?>" id="amount6_<?php echo $i; ?>">
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
  <div class="col-sm-6"><a href="<?php echo base_url(); ?>payment/budget/lists" class="btn btn-info">
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
