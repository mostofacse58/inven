<html>
<header>
<style type="text/css">
body {
   padding: 3px;
   font-size:13px;
   font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
    }
.tg  {border-collapse:collapse;border-spacing:0;width:100%;}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;text-align: center;
  overflow: hidden;word-wrap: break-word;overflow-wrap: break-word;
}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;font-weight: bold;
  overflow: hidden;word-wrap: break-word;overflow-wrap: break-word;
}
.tg .tg-s6z2{text-align:center}
.tg .tg-right{text-align:right;vertical-align:top;padding-right: 20px}
hr{margin: 5px}
.tg1  {border-collapse:collapse;border-spacing:0;width:100%}
.tg1 td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;overflow:hidden;word-break:normal;line-height: 18px;overflow: hidden;}
</style>
</header>
<body>

<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:0px 0px;color: #538FD4">
<b><?php echo $info->company_name; ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px" >
  <b>PAYMENT APPLICATION  </b></p>
</div>
<hr style="margin-top: 0px">
<table style="width: 100%">
  <tr>
    <th style="text-align: left" > 
     To Dept:  </th>
    <th style="text-align: left" > 
      <?php if(isset($info)) echo $info->acc_department_name; ?>
     </th>
     <th style="text-align: left" > 
     PA NO:  </th>
    <th style="text-align: left"> 
      <?php if(isset($info)) echo $info->applications_no; ?>
     </th>
   </tr>
  <tr>
    <th style="width:20%;text-align: left" > 
     To:  </th>
    <th style="width:50%;text-align: left"> 
      <?php echo $info->company_name; ?>
     </th>
    <th style="width:15%;text-align: left" > 
    Date: </th>
    <th style="width:15%">
      <?php if(isset($info)) echo  date("j-M-Y", strtotime("$info->applications_date")); ?>
    </th>
  </tr>
  <tr>
    <th style="width:20%;text-align: left" > 
     Pay To:</th>
    <th style="width:50%;text-align: left"> 
      <?php if($info->supplier_id==353) echo $info->other_name; 
      else echo $info->supplier_name; ?>
     </th>
    <th style="width:15%;text-align: left" > 
    PA Type: </th>
    <th style="width:15%;text-align: left;">
      <?php if(isset($info)) echo  $info->pa_type; ?>
    </th>
   </tr>
   <tr>
    <th style="width:20%;text-align: left" > 
     Currency:</th>
    <th style="width:50%;text-align: left"> 
      <?php if(isset($info)) echo $info->currency; ?>
     </th>
    <th style="width:15%;text-align: left" > 
    Rate in HKD: </th>
    <th style="width:15%;text-align: left;">
      <?php if(isset($info)) echo  $info->currency_rate_in_hkd; ?>
    </th>
   </tr>
</table>
<br>

<table class="tg"  style="overflow: hidden;">
  <thead>
  <tr>
    <th style="width:25%;text-align:center">Description</th>
    <th style="width:10%;text-align:center">Percentage</th>
    <th class="tg-right" style="width:10%;">Amount</th>
    <th style="width:15%;text-align:center">Remarks</th>
    <th style="width:20%;text-align:center">Department</th>
  </tr>
</thead>
<tbody>
  <?php
  if(isset($detail)){
     $i=1;
    foreach($detail as $value){ 

    ?>
  <tr>
    <td class="tg-s6z2" style="word-wrap: break-word;overflow-wrap: break-word;"><?php echo $value->head_name;  ?></td>
    <td class="" style="word-wrap: break-word;overflow-wrap: break-word;"></td>
    <td class="tg-right" style="word-wrap: break-word;overflow-wrap: break-word;"><?php echo number_format($value->amount,2); ?></td>
    <td class="tg-s6z2" style="word-wrap: break-word;overflow-wrap: break-word;word-break: break-all;overflow-wrap: break-word;"><?php echo $value->remarks;  ?></td>
    <td class="tg-s6z2"  style="word-wrap: break-word;overflow-wrap: break-word;"> 
      <?php
      $detail1=$this->applications_model->getDetails1($info->payment_id,$value->head_id);
      if(isset($detail1)){
         $i=1;
        foreach($detail1 as $value1){ 
        ?>
      <p style="padding: 3px;margin:0px;float: left">
         <?php echo "$value1->department_name: $value1->percentage%="; 
         echo number_format($value1->damount,2); echo ""; ?>
        </p>
      <?php } } ?></td>

  </tr>
   <?php }
 } ?>
 <?php if($info->vat_add_per!=0){ ?>
   <tr>
    <td class="tg-s6z2">Add. VAT</td>
    <td><?php if(isset($info)) echo $info->vat_add_per; ?>%</td>
    <td class="tg-right"><?php if(isset($info)) echo $info->vat_add_amount; ?></td>
    <td></td>
  </tr>
<?php } ?>
<?php if($info->ait_add_per!=0){ ?>
   <tr>
    <td class="tg-s6z2">Add. AIT</td>
    <td><?php if(isset($info)) echo $info->ait_add_per; ?>%</td>
    <td class="tg-right"><?php if(isset($info)) echo $info->ait_add_amount; ?></td>
    <td></td>
    <td></td>
  </tr>
<?php } ?>

<?php if($info->vat_add_per!=0||$info->ait_add_per!=0){ ?>
   <tr>
    <th class="tg-s6z2">Adjusted Bill Amount</th>
    <td></td>
    <th class="tg-right"><?php if(isset($info)) 
    echo number_format($info->sub_total,2); ?></th>
    <td></td>
    <td></td>
  </tr>
<?php } ?>

<?php if($info->vat_less_per!=0){ ?>
   <tr>
    <td class="tg-s6z2">Less. VAT</td>
    <td><?php if(isset($info)) echo $info->vat_less_per; ?>%</td>
    <td class="tg-right"><?php if(isset($info)) echo $info->vat_less_amount; ?></td>
    <td></td>
    <td></td>
  </tr>
<?php } ?>
<?php if($info->ait_less_per!=0){ ?>
   <tr>
    <td class="tg-s6z2">Less. AIT</td>
    <td><?php if(isset($info)) echo $info->ait_less_per; ?>%</td>
    <td class="tg-right"><?php if(isset($info)) echo $info->ait_less_amount; ?></td>
    <td></td>
    <td></td>
  </tr>
<?php } ?>
<?php if($info->other_amount!=0){ ?>
   <tr>
    <td class="tg-s6z2"><?php if(isset($info)) echo $info->other_note; ?></td>
    <td><?php if(isset($info)) echo $info->other_plus_minus; ?></td>
    <td class="tg-right">
      <?php if(isset($info)) echo number_format($info->other_amount,2); ?></td>
      <td></td>
      <td></td>
  </tr>
<?php } ?>

   <tr>
    <th class="tg-s6z2"></th>
    <th>Net Payment:</th>
    <th class="tg-right">
      <?php if(isset($info)) echo number_format($info->total_amount,2); ?></th>
      <td></td>
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
<br>
<div style="width: 100%">
  <div style="width: 45%;float: left;">
<table class="tg"  style="">
  <thead>
    <tr>
    <th style="width:30%;text-align:center">Sub-Total</th>
    <th class="tg-right" style="width:15%;">
      <?php 
      $sum = 0;
      foreach ($detail3 as $item) {
          $sum += $item->pamount;
      } 
      echo number_format($sum,2);
      ?></th>
  </tr>
  <tr>
    <th style="width:30%;text-align:center">PO Number</th>
    <th class="tg-right" style="width:15%;">Amount</th>
  </tr>
</thead>
<tbody>
  <?php
  if(isset($detail3)){
     $i=1;
    foreach($detail3 as $value){ 
    ?>
  <tr>
    <td class="tg-s6z2" ><?php echo $value->po_number;  ?></td>
    <td class="tg-right"><?php echo number_format($value->pamount,2); ?></td>
  </tr>
<?php }} ?>
  </tbody>
</table>
</div>
<div style="float: left;margin-left: 8%">
<table class="tg">
  <thead>
    <tr>
    <th style="width:30%;text-align:center">Sub-Total</th>
    <th class="tg-right" style="width:15%;">
    <?php 
      $sum = 0;
      foreach ($detail4 as $item) {
          $sum += $item->bamount;
      } 
      echo number_format($sum,2);
      ?></th>
  </tr>
  <tr>
    <th style="width:30%;text-align:center">Bill No</th>
    <th class="tg-right" style="width:15%;">Amount</th>
  </tr>
</thead>
<tbody>
  <?php
  if(isset($detail4)){
     $i=1;
    foreach($detail4 as $value){ 
    ?>
  <tr>
    <td class="tg-s6z2" ><?php echo $value->bill_no;  ?></td>
    <td class="tg-right"><?php echo number_format($value->bamount,2); ?></td>
  </tr>
<?php }} ?>
  </tbody>
</table>
</div>
</div>
<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 1px;">
 Remarks : <?php if(isset($info)) echo $info->description; ?>
</p> 
<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 1px;font-weight: bold;">
 Payment: <?php if($info->pay_term!='') echo $info->pay_term; ?>
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
  <td style="width:20%;text-align:left;">
    <?php if($info->status>=1) echo "$info->user_name"; ?></td>
  <td style="width:20%;text-align:center;">
    <?php if($info->status>=3&&$info->status!=8) echo "$info->checked_by"; ?></td>
  <td style="width:20%;text-align:center;">
  <?php if($info->status>=4&&$info->status!=8) echo "$info->verified_by"; ?></td>
  <td style="width:20%;text-align:center;">
  <?php if($info->status>=5&&$info->status!=8) echo "$info->received_by"; ?></td>
  <td style="width:20%;text-align:right;">
  <?php if($info->status>=6&&$info->status!=8) echo "$info->approved_by_name"; ?></td>
  </tr>
  <tr>
  <td style="text-align:left;">
    <?php if($info->status>=1) echo findDate($info->prepared_date); ?></td>
  <td style="text-align:center;">
    <?php if($info->status>=3&&$info->status!=8) 
   echo findDate($info->checked_date); ?></td>
  <td style="text-align:center;">
  <?php if($info->status>=4&&$info->status!=8) 
   echo findDate($info->verified_date); ?></td>
  <td style="text-align:center;">
  <?php if($info->status>=5&&$info->status!=8) 
   echo findDate($info->received_date); ?></td>
  <td style="text-align:right;">
    <?php if($info->status>=6&&$info->status!=8)
   echo findDate($info->approved_date); ?></td>
  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">----------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">----------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">----------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">----------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">----------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Prepared By:</td>
  <td style="text-align:center;">Confirmed By: </td>
  <td style="text-align:center;">Verified By</td>
  <td style="text-align:center;">Checked By</td>
  <td style="text-align:right;">Approved By</td>
  </tr>
</table>
</body>
<html>