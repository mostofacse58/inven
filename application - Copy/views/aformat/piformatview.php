<html>
<header>
<style type="text/css">
body {
   padding: 3px;
   font-size:14px;
   font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
    }
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
</style>
</header>
<body>
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:2px 0px;color: #538FD4">
<b><?php echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 3px 5px;font-size: 18px" >
  <b>Purchase Indent(Fixed Asset) <br>物料申购单 </b></p>
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
    <th style="width:25%;text-align: left" > 
      Making Dept. 制作部 <?php if(isset($info)) echo $info->department_name; ?> </th>
      <th style="width:50%;text-align: left" colspan="2"> 
      Note: <?php if(isset($info)) echo $info->other_note; ?> </th>
    </tr>
  
</table>
<?php $updates=$this->db->query("SELECT * FROM pi_update_info WHERE pi_id=$info->pi_id")->result();
  if(count($updates)>0){
 ?>

<p style="width: 100%"> <strong>Update Info:</strong> <?php 
foreach ($updates as $value) {
  echo "<strong>$value->update_date</strong>  $value->update_text";
}
 ?>
</p>
<?php } ?>
<br>
<table class="tg"  style="overflow: hidden;">
  <thead>
  <tr>
    <th style="width:3%;text-align:center">SN(序号)</th>
    <th style="width:8%;text-align:center">Material code<br>(物料编码)</th>
    <th style="width:25%;text-align:center">Material Name<br>(物料名称)</th>
    <th style="width:8%;text-align:center">Specification<br>(规格)</th>
    <th style="width:8%;text-align:center">Material Picture<br>(物料图片)</th>
    <th style="width:7%;text-align:center;">Required Qty<br>(需求数量)</th>
    <th style="width:7%;text-align:center;">Stock Qty<br>(仓存数量)</th>
    <th style="width:7%;text-align:center;">Purchased Qty<br>(购买数量)</th>
    <th style="width:5%;text-align:center;">Unit(单位)</th>
    <th style="width:7%;text-align:center;">Unit price<br> 单价</th>
    <th style="width:7%;text-align:center;">Amount <br>总金额</th>
    <th style="width:4%;text-align:center;">Currency <br>货币</th>
    <th style="width:12%;text-align:center;">Remarks<br>(备注)</th>
  </tr>
  </thead>
  <tbody>
  <?php
  if(isset($detail)){
     $i=1; $totalpur=0;
     $cnc='';
     $cncCheck=1;
     $totalreq=0;$totalamount=0;
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
    <img src="<?php echo base_url(); ?>product/<?php echo $value->product_image; ?>" class="img-thumbnail" style="width:100px;height:auto;"/><?php }else{ echo "No Picture";} ?></td>
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
  </tbody>
</table>
<p style="text-align: left;width: 50%;float: left;overflow: hidden;margin-top: 5px;margin-bottom:0px">
<?php if($info->reject_note!=''){?>

  Note: <?php if(isset($info)) echo $info->reject_note; ?>

<?php } ?>
</p>
<p style="text-align: right;width: 50%;float: right;overflow: hidden;margin-top: 5px;margin-bottom:0px">
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
</body>
<html>