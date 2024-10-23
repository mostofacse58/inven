<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
hr{margin: 5px}
.tg1  {border-collapse:collapse;border-spacing:0;width:100%}
.tg1 td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;overflow:hidden;word-break:normal;line-height: 18px;overflow: hidden;}
  .error-msg{display: none;}
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
    <div class="col-xs-3 bs-wizard-step <?php if($info->pi_status==3&&$info->pi_status!=8) echo "active"; else if($info->pi_status>=4&&$info->pi_status!=8) echo "complete"; else echo "disabled"; ?>">
      <div class="text-center bs-wizard-stepnum">Certified by DIV.H
    板块负责人确认<</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    <div class="col-xs-3 bs-wizard-step <?php  if($info->pi_status>=5&&$info->pi_status!=8) echo "complete"; else echo "disabled"; ?>"><!-- complete -->
      <div class="text-center bs-wizard-stepnum">Verified by IA
    (IA查实)</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    
    <div class="col-xs-3 bs-wizard-step <?php if($info->pi_status>=6&&$info->pi_status!=8) echo "complete";  else echo "disabled"; ?>"><!-- complete -->
      <div class="text-center bs-wizard-stepnum">Received by Pur.
  采购部接收</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    
    <div class="col-xs-3 bs-wizard-step <?php if($info->pi_status>=7&&$info->pi_status!=8) echo "complete"; else echo "disabled"; ?>"><!-- active -->
      <div class="text-center bs-wizard-stepnum">Approved by Malik Ma
  (Mailk 批准)</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
  <div class="box box-info" style="padding: 10px">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:2px 0px;color: #538FD4">
<b><?php echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px" >
  <b>Purchase Indent(Safety Stock) <br>物料申购单 </b></p>
</div>
<hr style="margin-top: 0px">
<table style="width: 100%">
  <tr>
    <th style="width:50%;text-align: left" > 
      Purchase Type 购买类型: <?php if(isset($info)) echo $info->p_type_name; ?> </th>
    <th style="width:25%;text-align: left" > 
      NO.VLML采购单号: <?php if(isset($info)) echo $info->pi_no; ?> </th>
    <th style="width:25%;text-align: left" > 
      Date日期: <?php if(isset($info)) echo findDate($info->pi_date); ?> </th>
  </tr>
  <tr>
    <th style="text-align: left" > 
      Demand Dept. 需求部门 <?php if(isset($info)) echo $info->demand_department_name; ?> </th>
    <th style="text-align: left" > 
      Division部门: <?php if(isset($info)) echo $info->division; ?></th>
    <th style="text-align: left" > 
    Demand Date 需求日期: <?php if(isset($info)) echo findDate($info->demand_date); ?></th>
  </tr>
  <tr>
    <th style="text-align: left;width:25%;"> 
      Making Dept. 制作部 <?php if(isset($info)) echo $info->department_name; ?> </th>
      <th style="text-align: left" > 
      Note: <?php if(isset($info)) echo $info->other_note; ?> </th>
      <th style="text-align: left" > 
    Standard Demand Date 标准需求日期: <?php if(isset($info)) echo findDate($info->new_demand_date); ?></th>
  </tr>
   <tr>
    <th style="text-align: left" > 
      Purchase Category购买类别: <?php if(isset($info)) echo $info->purchase_category; ?> </th>
  </tr>
</table>
<?php $updates=$this->db->query("SELECT * FROM pi_update_info WHERE pi_id=$info->pi_id")->result();
  if(count($updates)>0){
 ?>
<p style="width: 100%"> <strong>Update Info:</strong> <?php 
foreach ($updates as $value){
  echo "<strong>$value->update_date</strong>  $value->update_text";
}
 ?>
</p>
<?php } ?>
<br>
<table class="tg"  style="overflow: hidden;">
  <tr>
    <th style="width:3%;text-align:center">SN(序号)</th>
    <th style="width:8%;text-align:center">Material code<br>(物料编码)</th>
    <th style="width:25%;text-align:center">Material Name<br>(物料名称)</th>
    <th style="width:8%;text-align:center">Specification<br>(规格)</th>
    <th style="width:8%;text-align:center">Material Picture<br>(物料图片)</th>
    <th style="width:7%;text-align:center;">Additional Qty<br>(额外数量)</th>
    <th style="width:7%;text-align:center;">Safety Qty<br>(安全数量)</th>
    <th style="width:7%;text-align:center;">Required Qty<br>(需求数量)</th>
    <th style="width:7%;text-align:center;">Stock Qty<br>(仓存数量)</th>
    <th style="width:7%;text-align:center;">Purchased Qty<br>(购买数量)</th>
    <th style="width:5%;text-align:center;">Unit(单位)</th>
    <th style="width:7%;text-align:center;">Unit price<br> 单价</th>
    <th style="width:7%;text-align:center;">Amount <br>总金额</th>
    <th style="width:4%;text-align:center;">Currency <br>货币</th>
    <th style="width:12%;text-align:center;">Remarks<br>(备注)</th>
  </tr>
  <?php
  if(isset($detail)){
     $i=1; 
     $totalpur=0;
     $totalreq=0;
     $totalamount=0;
     $totalamount2=0;
     $cnc='';
     $cncCheck=1;
    foreach($detail as $value){ 
     $totalreq=$totalreq+$value->required_qty;
     $totalpur=$totalpur+$value->purchased_qty;
     $totalamount=$totalamount+$value->amount_hkd;
     $totalamount2=$totalamount2+$value->amount;
     if($i==1){
      $cnc=$value->currency;
     }else{
      if($cnc!=$value->currency) $cncCheck=2;
     }
    ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; if($value->china_name!='') echo "($value->china_name)"; ?></td>
    <td class=""><?php echo $value->specification; ?></td>
    <td class="textcenter">
    <?php if (isset($value->product_image)&&!empty($value->product_image)) { ?>
    <img src="<?php echo base_url(); ?>product/<?php echo $value->product_image; ?>" class="img-thumbnail" style="width:70px;height:auto;"/><?php }else{ echo "No Picture";} ?></td>
    <td class="tg-s6z2"><?php echo "$value->additional_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->safety_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->required_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->stock_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->purchased_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_price"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->amount"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->currency"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->remarks"; ?></td>
  </tr>
   <?php }
 } ?>
   <tr>
    <th sty colspan="5" style="text-align: right;" >Total</th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"><?php echo $totalreq; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"><?php echo $totalpur; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"><?php 
    if($cncCheck==2) echo number_format($totalamount,2).' HKD'; 
    else  echo number_format($totalamount2,2).' '.$cnc; ?> </th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
  </tr>
</table>
<p style="text-align: left;width: 50%;float: left;overflow: hidden;">
  Note: 
  <br>
  <?php echo $this->look_up_model->getPINote($info->pi_id); ?>
</p>
<p style="text-align: right;width: 40%;float: left;overflow: hidden;">
  Promised date of using up:  
  <br>承诺用完日期： <?php if(isset($info)) echo findDate($info->promised_date); ?>
</p>
<br><br>
<table class="tg1" style="overflow: hidden;">
 <tr>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
</tr>
  <tr>
  <td style="width:25%;text-align:left;">
    <?php if($info->pi_status>=4&&$info->pi_status!=8) echo "$info->certified_name"; ?></td>
  <td style="width:25%;text-align:center;">
    <?php if($info->pi_status>=5&&$info->pi_status!=8) echo "$info->verified_name"; ?></td>
  <td style="width:25%;text-align:center;">
  
  <?php if($info->pi_status>=6&&$info->pi_status!=8) echo "$info->receive_by"; ?></td>
  <td style="width:25%;text-align:right;">
  <?php if($info->pi_status>=7&&$info->pi_status!=8) echo "$info->approve_by"; ?></td>
  </tr>
  <tr>

  <td style="text-align:left;">
  <?php if($info->pi_status>=4&&$info->pi_status!=8) echo $info->certified_date; ?></td>
  <td style="text-align:center;">
    <?php if($info->pi_status>=5&&$info->pi_status!=8) echo $info->verified_date; ?></td>
  
  <td style="text-align:center;">
    <?php if($info->pi_status>=6&&$info->pi_status!=8) echo $info->received_date; ?></td>
  <td style="text-align:right;">
    <?php if($info->pi_status>=7&&$info->pi_status!=8) echo $info->approved_date; ?></td>
  </tr>
  <tr>
    <td style="text-align:left;font-size: 15px;line-height: 5px">---------------</td>
    <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
    <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
    <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Certified by DIV.H
   <br> 板块负责人确认</td>
    <td style="text-align:center;">Verified by IA
   <br> IA查实</td>  
  
  <td style="text-align:center;">Received by Pur.
  <br> 采购部接收</td>
  
  <td style="text-align:right;">Approved by Malik Ma
  <br> Mailk 批准</td>
  </tr>
</table>
  <div class="box-footer">
  <div class="col-sm-4">
    <a href="<?php echo base_url(); ?>format/deptrequisn/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>

  </div>
</div>
</div>
</div>


