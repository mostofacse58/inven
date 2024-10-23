 <style type="text/css">
  .error-msg{display:none;}
  .tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:600;padding:5px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-031e{text-align:left;}
</style>
<script type="text/javascript">
$(function () {
  $(document).on('click','input[type=text]',function(){ 
    this.select(); 
  });
});
//////////////////////////
$(document).ready(function(){  

});

function formsubmit(){
  var error_status=false;
  var names = {};
  $(':radio').each(function() {
        names[$(this).attr('name')] = true;
    });
    var count = 0;
    $.each(names, function() { 
        count++;
    });
    $(':radio').each(function() {
       var opp=$(this).attr('name');
       var valchk = $('input:radio[name='+opp+']:checked').val();
       if(valchk>0){
        $('.'+opp+'').css({color:'#000'});
       }else{
        $('.'+opp+'').css({color:'#FF2B00'});
       }
    });
      if ($(':radio:checked').length === count) {
          return true;
      }else{
        alert('Need to answer all question');
        return false;
      }
  }
var  baseURL = '<?php echo base_url();?>';
</script>
<div class="row">
<div class="col-md-12">
  <div class="box box-info">
 <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5>Self Audit <?php if($info->quater==1) echo "1st";
                              elseif($info->quater==2) echo "2nd";
                              elseif($info->quater==3) echo "3rd";
                              elseif($info->quater==4) echo "4th"; ?> Quater <?php echo $info->year; ?></h5>
<div class="widget-control pull-right">

</div>
</div>
</div>
</div>
  <!-- form start -->
<form class="form-horizontal" action="<?php echo base_url(); ?>audit/selfa/save<?php if (isset($info)) echo "/$master_id"; ?>" method="POST" id="formid">
<div class="box-body">
 <br>
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<tbody>
 <?php
 $i=1;
 $id=0;
  
  ?>
  <tr>
  <th style="width:8%;text-align:center;color: #2B579A;font-size: 16px" rowspan="2">Head </th>
  <th style="text-align:center;color: #2B579A;width: 8%" valign="top" rowspan="2">
   Sub-Head
 </th>
  <th style="text-align:center;color: #2B579A;width: 6%" valign="top" rowspan="2">
   Weight  
 </th>
 <th style="width:66%;text-align:center;color: #2B579A;font-size: 16px" colspan="3">Assessment Criteria</th>
 <th style="width:10%;text-align:center;color: #2B579A;font-size: 16px">Result</th>
</tr>
<tr>
  <th style="width:22%;text-align:center;color: #2B579A;font-size: 16px">5</th>
  <th style="width:22%;text-align:center;color: #2B579A;font-size: 16px">3</th>
  <th style="width:22%;text-align:center;color: #2B579A;font-size: 16px">1</th>
  <th style="width:10%;text-align:center;color: #2B579A;font-size: 16px">Score</th>
</tr>
<tr>
<?php if(isset($info)){

foreach ($plists as  $rows) { 
 ?>
 <tr>
  <td style="text-align: center;"><?php echo $rows->head_name; ?> </td>
  <td style="text-align: center;"><?php echo $rows->sub_head_name; ?> </td>
  <td style="text-align: center;"><?php echo $rows->weight; ?>% </td>
  <td style="vertical-align: top;">
    <?php  echo nl2br($rows->criteria_1); ?> </td>
  <td style="vertical-align: top;"><?php echo nl2br($rows->criteria_2); ?> </td>
  <td style="vertical-align: top;"><?php  echo nl2br($rows->criteria_3); ?> </td>
    <input type="hidden" name="package_id[]" value="<?php echo $rows->package_id; ?>">
  <td style="text-align:center;">
    <select class="form-control callaverage" name="score[]" onchange="return calculateRow();" id="score_<?php echo $id++; ?>">
    <option value="0">Select</option>
    <?php 
    for($n=5;$n>=0;$n--){ ?>
     <option value="<?php echo $n; ?>" 
      <?php echo $rows->score==$n? 'selected="selected"':0; ?>>
          <?php echo  $n; ?></option>
      <?php } ?>
    </select>
  </td>

 </tr>
<?php $id++;}
$i++;
 }

?>
</tbody>
</table>
<input type="hidden" name="year" value="<?php echo $info->year; ?>">
<input type="hidden" name="quater" value="<?php echo $info->quater; ?>">
</div>
</div>
  <!-- /.box-body -->
<div class="box-footer">
  <div class="col-sm-6"><a href="<?php echo base_url(); ?>audit/selfa/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
  <div class="col-sm-">
    <button type="submit" name="save" class="btn btn-info">
        <i class="fa fa-save"></i> SAVE</button> &nbsp;&nbsp;&nbsp;

    
 </div>
</div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>
