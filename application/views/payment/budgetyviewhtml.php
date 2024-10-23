
<style type="text/css">

.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;text-align: center;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;font-weight: bold}
.tg .tg-s6z2{text-align:center}
.tg .tg-right{text-align:right;vertical-align:top;padding-right: 20px}
hr{margin: 5px}
.tg1  {border-collapse:collapse;border-spacing:0;width:100%}
.tg1 td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;overflow:hidden;word-break:normal;line-height: 18px;overflow: hidden;}
  .primary_area1{
  background-color: #fff;
  border-top: 5px dotted #000;
  border-bottom: 5px dotted #000;
  box-shadow: inset 0 -2px 0 0 #000, inset 0 2px 0 0 #000, 0 2px 0 0 #000, 0 -2px 0 0 #000;
  margin-bottom: 1px;
  padding: 10px;
  border-left: 5px;
  border-right: 5px;
  border-left-style:double ;
  border-right-style:double;
  padding-top:0px;
}
.error-msg{display: none;}
.bs-wizard {margin-top: 40px;}

/*Form Wizard*/
.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #09ff8e; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;} 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #00a65a ; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #09ff8e;}
.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #aeaeae;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
.progress { background-color: #aeaeae;}
</style>

 <div class="row bs-wizard" style="border-bottom:0;">
    <div class="col-xs-4 bs-wizard-step <?php if($info->status==1&&$info->status!=8) echo "active"; else if($info->status>=2&&$info->status!=8) echo "complete"; else echo "disabled"; ?>">
      <div class="text-center bs-wizard-stepnum">Prepared By</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    <div class="col-xs-4 bs-wizard-step <?php  if($info->status>=3&&$info->status!=8) echo "complete"; else echo "disabled"; ?>"><!-- complete -->
      <div class="text-center bs-wizard-stepnum">Confirmed By</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
 
    <div class="col-xs-4 bs-wizard-step <?php if($info->status>=4&&$info->status!=8) echo "complete"; else echo "disabled"; ?>"><!-- active -->
      <div class="text-center bs-wizard-stepnum">Received By</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
   <div class="content-holder">
   <div class="box box-info" style="padding: 10px">
    <div class="primary_area1">
   <div class="table-responsive table-bordered">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:0px 0px;color: #538FD4">
<b><?php echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px" >
  <b>Budget for <?php 
if(isset($info)) { echo $info->for_month;  }?>  </b></p>
</div>
<hr style="margin-top: 0px">
<table style="width: 100%">
  <tr>
    <th style="text-align: left" > 
     From Dept.:  </th>
    <th style="text-align: left" > 
      <?php if(isset($info)) echo $info->department_name; ?>
     </th>
     <th style="text-align: left" > 
     Budget No:  </th>
    <th style="text-align: left"> 
      <?php if(isset($info)) echo $info->budget_no; ?>
     </th>
   </tr>
  <tr>
    <th style="width:20%;text-align: left" > 
     To Dept:  </th>
    <th style="width:50%;text-align: left"> 
      <?php if(isset($info)) echo $info->to_department_name; ?>
     </th>
    <th style="width:15%;text-align: left" > 
    Date: </th>
    <th style="width:15%">
      <?php if(isset($info)) echo  date("j-M-Y", strtotime("$info->create_date")); ?>
    </th>
  </tr>
 
  
</table>
<br>

<table class="tg"  style="overflow: hidden;">
  <thead>
  <tr>
  <th style="text-align:center;font-size: 16px;width: 5%;" rowspan="2">SN</th>
  <th style="text-align:center;font-size: 16px;width: 20%;" rowspan="2">Account Head </th>
  <th style="text-align:center;width: 10%;" valign="top">Budget</th>
    <th style="text-align:center;font-size: 16px;width: 10%;" rowspan="2">Remarks</th>
</tr>
<tr>
  <th style="text-align:center;"><?php echo $info->for_month; ; ?></th>
   
</tr>
</thead>
<tbody>
  <?php
  if(isset($hlist)){
	  $i=1;
	  foreach($hlist as $rows){ 
     if($rows->amount>0){ 
	  ?>
   <tr>
  <td style="text-align: center;"><?php echo $i; ?> </td>
  <td style="text-align: center;">
    <?php echo $rows->head_name; ?>
  </td>
  <td style="text-align:right;">
    <?php echo $rows->amount; ?>
  </td>
  
  <td style="text-align:center;">
    <?php echo $rows->remarks; ?>
  </td>

 </tr>
   <?php $i++; 
 }
 }
 } ?>


   <tr>
    <th class="tg-s6z2"></th>
    <th>Net Payment:</th>
    <th class="tg-right">
      <?php if(isset($info)) echo number_format($info->total_amount,2); ?></th>
    <td></td>

  </tr>
</tbody>
</table>

<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 4px;font-weight: bold;">
 Amount In Word: <?php 
 $tmount=explode(".",$info->total_amount);

 if(isset($info)) echo number_to_word($tmount[0]); ?> <?php if($info->currency=='BDT') echo "Taka"; else echo $info->currency; ?>
 <?php if($tmount[1]>0){ echo " and "; echo number_to_word($tmount[1]); if($info->currency=='BDT') echo " Poysha"; elseif($info->currency=='RMB') echo " Jiao"; else echo " Cent";  } ?> Only
</p> 


<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 1px;">
 Note : <?php if(isset($info)) echo $info->comment_note; ?>
</p> 
<br><br>
<table class="tg1" style="overflow: hidden;">
  <tr>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
  <tr>
  <td style="width:33%;text-align:left;">
    <?php if($info->status>=1) echo getUserName($info->user_id); ?></td>
  <td style="width:33%;text-align:center;">
    <?php if($info->status>=3&&$info->status!=8) echo getUserName($info->confirm_by);  ?></td>
  <td style="width:33%;text-align:right;">
  <?php if($info->status>=4&&$info->status!=8) echo getUserName($info->received_by); ?></td>

  </tr>
  <tr>
  <td style="text-align:left;">
    <?php if($info->status>=1) echo findDate($info->create_date); ?></td>
  <td style="text-align:center;">
    <?php if($info->status>=3&&$info->status!=8) 
   echo findDate($info->confirm_date); ?></td>

  <td style="text-align:right;">
  <?php if($info->status>=4&&$info->status!=8) 
   echo findDate($info->received_date); ?></td>

  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Prepared By:</td>
  <td style="text-align:center;">Confirmed By: </td>
  <td style="text-align:right;">Received By</td>
  </tr>
</table>
</div>
</div>
</div>
<div class="box-footer">
  <div class="col-sm-12" style="text-align: center;">
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/lists">
    <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Back</a>
    <?php if($info->status==1&&$controller=='budgety'){ ?>
      <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/submit/<?php echo $info->master_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Submit</a>
   <?php } ?>
    <?php if($info->status==2&&$controller=='cbudgety'){ ?>
    <a class="btn btn-warning decisions"  data-pastatus="1" href="#">
    <i class="fa fa-arrow-circle-o-left  tiny-icon"> </i> Return </a>
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/approved/<?php echo $info->master_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Confirm</a>
  <?php } ?>

  <?php if($info->status==3&&$controller=='rbudgety'){ ?>
    <a class="btn btn-warning decisions"  data-pastatus="1" href="#">
    <i class="fa fa-arrow-circle-o-left  tiny-icon"> </i> Return </a>
    <a class="btn btn-danger decisions"  data-pastatus="8" href="#">
    <i class="fa fa-times  tiny-icon"> </i> Reject </a>
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/approved/<?php echo $info->master_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Receive</a>
  <?php } ?>
 
  </div>
</div>
</div>
</div>
</div>
<div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel">  Comments</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>payment/<?php echo $controller; ?>/decisions/<?php echo $info->master_id;?>">
          <div class="form-group">
            <label class="col-sm-3 control-label">Comments </label>
            <div class="col-sm-6">
              <textarea class="form-control" name="comment_note" rows="2" id="comment_note" placeholder="Comments"></textarea> 
              <span class="error-msg">Comments field is required</span>
            </div>
          </div>
       <input type="hidden" name="status"  id="status">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> OK</button>
      </div>
    </div>
  </div>
</div>
<script>
  
$(document).ready (function(){
 ///////////////////////////
  $("#addNewTeam").click(function(){
    var comment_note = $("#comment_note").val();
    var error = 0;
    if(comment_note==""){
      $("#comment_note").css({"border-color":"red"});
      $("#comment_note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#comment_note").css({"border-color":"#ccc"});
      });
      error=1;
    }
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }
  });
  ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".decisions").click(function(e){
    e.preventDefault();
    var pastatus=$(this).data('pastatus');
    if(pastatus==8){
      $(".control-label").html("<span style='color: red;'>Comment</span>");
      $("#myModalLabel").html("<span style='color: red;'>Reject Comment</span>");
    }else if(pastatus==1){
      $(".control-label").html("<span style='color: #9F6000;'>Comment</span>");
      $("#myModalLabel").html("<span style='color: #9F6000;'>Return Comment</span>");
    }
     $("#status").val(pastatus);
     $("#TeamModal").modal("show");
  });
});//jquery ends here
</script>
