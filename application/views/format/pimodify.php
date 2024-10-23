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
</style>
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
      Purchase Category购买类别: <?php if(isset($info)) echo $info->p_type_name; ?> </th>
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
      <th style="width:50%;text-align: left" colspan="2"> 
      Note: <?php if(isset($info)) echo $info->other_note; ?> </th>
    </tr>
</table>
 
 
<br>
<form class="form-horizontal" action="<?php echo base_url(); ?>format/pireview/save<?php if (isset($info)) echo "/$info->pi_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
<table class="tg"  style="overflow: hidden;">
  <tr>
    <th style="width:3%;text-align:center;">SN(序号)</th>
    <th style="width:8%;text-align:center;">Material code<br>(物料编码)</th>
    <th style="width:8%;text-align:center;">Material Name<br>(物料名称)</th>
    <th style="width:10%;text-align:center;">Chinese Name</th>
    <th style="width:15%;text-align:center;">Specification<br>(规格)</th>
    <th style="width:5%;text-align:center;">Purchased Qty<br>(购买数量)</th>
    <th style="width:5%;text-align:center;">Unit price<br> 单价</th>
    <th style="width:5%;text-align:center;">Amount <br>总金额</th>
    <th style="width:10%;text-align:center;">Remarks </th>
   </tr>
  <?php
  if(isset($detail)){
	   $i=1; $totalpur=0; $m=0;
     $totalreq=0;
  	  foreach($detail as $value){ 
       $totalreq=$totalreq+$value->required_qty;
       $totalpur=$totalpur+$value->purchased_qty;
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class="">
      <?php echo $value->product_name; if($value->china_name!='') echo "($value->china_name)"; ?></td>
     <td class="tg-s6z2">
      <input type="hidden" value="<?php echo "$value->pi_detail_id"; ?>" name="pi_detail_id[]">
      <input type="hidden" value="<?php echo "$value->product_id"; ?>" name="product_id[]">
      <input type="text" class="form-control"  value="<?php echo "$value->china_name"; ?>" name="china_name[]" id="china_name_<?php echo $m; ?>"></td>
      <td class="tg-s6z2">
      <textarea type="text" rows="3" name="specification[]"  class="form-control"  style="margin-bottom:5px;width:98%" id="specification_<?php echo $m; ?>"><?php echo "$value->specification"; ?></textarea></td>

    <td class="tg-s6z2"><?php echo "$value->purchased_qty $value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_price "; ?></td>
    <td class="tg-s6z2"><?php echo "$value->amount $value->currency"; ?></td>
    <td class="tg-s6z2"><textarea type="text" rows="3" name="remarks[]"  class="form-control"  style="margin-bottom:5px;width:98%" id="remarks_<?php echo $m; ?>"><?php echo "$value->remarks"; ?></textarea></td>

  </tr>
   <?php 
   $m++; 
    }
 } ?>
    
</table>
<p style="text-align: left;width: 50%;float: left;overflow: hidden;">
<?php if($info->reject_note!=''){?>

  Note: <?php if(isset($info)) echo $info->reject_note; ?>

<?php } ?>
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
  <?php if($info->pi_status>=4&&$info->pi_status!=8) echo findDate($info->certified_date); ?></td>
  <td style="text-align:center;">
    <?php if($info->pi_status>=5&&$info->pi_status!=8) echo findDate($info->verified_date); ?></td>
  <td style="text-align:center;">
    <?php if($info->pi_status>=6&&$info->pi_status!=8) echo findDate($info->received_date); ?></td>
  <td style="text-align:right;">
    <?php if($info->pi_status>=7&&$info->pi_status!=8) echo findDate($info->approved_date); ?></td>
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
    <a href="<?php echo base_url(); ?>format/pireview/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
    <div class="col-sm-4">
    <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> SAVE 保存</button>
  </div>

  </div>
  </form>
</div>
</div>
</div>
<script>
  function checkQuantity(ids){
   var unit_price=parseFloat($.trim($("#unit_price_"+ids).val()));
   var purchased_qty=parseFloat($.trim($("#purchased_qty_"+ids).val()));
   if($.trim(unit_price)==""|| $.isNumeric(unit_price)==false){
     $("#unit_price_"+ids).val(0);
        unit_price=0;
   }
   $("#amount_"+ids).val(purchased_qty*unit_price);
  }

</script>

