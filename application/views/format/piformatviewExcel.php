<?php 
$name="PIExcelView_".date('Y-m-dhi').".xls";
header("Content-type: application/octet-stream");
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8" />
<!--This is what you should include-->
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<header>
<style type="text/css">
body {
  padding: 3px;
   font-size:14px;
   font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
    }

.tg  {border-collapse:collapse;border-spacing:0;width:150%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
hr{margin: 5px}

</style>
</header>
<body>
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:2px 0px;color: #538FD4">
<b> <?php echo  $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 3px 5px;font-size: 18px" >
  <b><?php if($info->product_type=='PRODUCT'){ ?>
    Purchase Indent(<?php if($info->pi_type==1) echo "Safety Stock"; else echo "Fixed Asset"; ?>) <br>物料申购单 
  <?php }else{ ?>
    Service Indent <br>服務縮排
  <?php } ?> </b></p>
</div>
<hr style="margin-top: 0px">
<table style="width: 100%">
  <tr>
    <th style="width:50%;text-align: left" colspan="4"> 
      Purchase Type 购买类型: <?php if(isset($info)) echo $info->p_type_name; ?> </th>
    <th style="width:25%;text-align: left"  colspan="3"> 
      NO.VLML采购单号: <?php if(isset($info)) echo $info->pi_no; ?> </th>
    <th style="width:25%;text-align: left"  colspan="2"> 
      Date日期: <?php if(isset($info)) echo findDate($info->pi_date); ?> </th>
  </tr>
   <tr>
    <th style="text-align: left"  colspan="4"> 
      Demand Dept. 需求部门 <?php if(isset($info)) echo $info->department_name; ?> </th>
    <th style="text-align: left"  colspan="3"> 
      Division部门: <?php if(isset($info)) echo $info->division; ?> </th>
    <th style="text-align: left"  colspan="2"> 
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
    <th style="text-align: left" > 
      Product Type 產品類型: <?php if(isset($info)) echo $info->product_type; ?> </th>
  </tr>
  
</table>
<br>
<table class="tg">
 <tr>
    <th style="width:3%;text-align:center">SN(序号)</th>
    <th style="width:8%;text-align:center">Material code<br>(物料编码)</th>
    <th style="width:25%;text-align:center">Material Name<br>(物料名称)</th>
    <th style="width:8%;text-align:center">Specification<br>(规格)</th>
    <th style="width:8%;text-align:center">Material Picture<br>(物料图片)</th>
    <?php if($info->product_type=='PRODUCT'){ ?>
    <th style="width:7%;text-align:center;">Additional Qty<br>(额外数量)</th>
    <th style="width:7%;text-align:center;">Safety Qty<br>(安全数量)</th>
    <th style="width:7%;text-align:center;">Required Qty<br>(需求数量)</th>
    <th style="width:7%;text-align:center;">Stock Qty<br>(仓存数量)</th>
    <?php } ?>
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
    <a href="<?php echo base_url();?>product/<?php echo $value->product_image; ?>" data-toggle="lightbox" data-title="<?php echo $value->product_name;  ?>" data-gallery="gallery">
    <img src="<?php echo base_url();?>product/<?php echo $value->product_image; ?>" class="img-thumbnail" style="width:70px;height:auto;">
  </a>
    <?php }else{ echo "No Picture";} ?></td>
    <?php if($info->product_type=='PRODUCT'){ ?>
    <td class="tg-s6z2"><?php echo "$value->additional_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->safety_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->required_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->stock_qty"; ?></td>
    <?php } ?>
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
    <?php if($info->product_type=='PRODUCT'){ ?>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"><?php echo $totalreq; ?></th>
    <th class="tg-s6z2"></th>
    <?php } ?>
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
<p style="text-align: right;">
  Promised date of using up:  
  <br>承诺用完日期： <?php if(isset($info)) echo findDate($info->promised_date); ?>
</p>
<br><br>
<table style="width:100%">
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
</body>
<html>