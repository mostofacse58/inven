<html>
<style type="text/css">
  @media print{
            .print{ display:none;}
            .approval_panel{ display:none;}
             .margin_top{ display:none;}
            .rowcolor{ background-color:#CCCCCC !important;}
            body {padding: 3px; font-size:14px}
        }
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:bold;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
</style>
<div style="width:100%;float:left;overflow:hidden">
<h4 align="center" style="margin:0;"><b> Project Name: <?php if(isset($info))echo $info->project_name; ?>  </b></h4>
<p align="center" style="margin:0;"><b>Address: <?php if(isset($info))echo $info->project_address; ?></b></p>
 </div>
 <div style="width:100%;float:left;overflow:hidden;margin:10px 0">
<h4 align="center" style="margin:0;"><b> Project Wise Broker</b></h4>
 </div>


<br>
<table class="tg">
  <tr>
    <th class="tg-s6z2">SL</th>
    <th class="tg-s6z2">Broker Name</th>
    <th class="tg-s6z2">Type</th>
    <th class="tg-s6z2">Mobile</th>
    <th class="tg-s6z2">Total Amount</th>
    <th class="tg-s6z2">Paid Amount</th>
    <th class="tg-s6z2">Due Amount</th>
  </tr>
   <?php
  if(isset($detail)){
	   $i=1;
	   $sum=0;
     $sum2=0;
	  foreach($detail as $row){ 
	 $sum=$sum+$row->pay_amount;
   $sum2=$sum2+$row->paid_amount;
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i; ?></td>
    <td class="tg-s6z2"><?php echo $row->broker_name; ?></td>
    <td class="tg-s6z2"><?php echo $row->broker_type; ?></td>
    <td class="tg-s6z2"><?php echo $row->mobile_no; ?></td>
    <td class="tg-baqh"><?php echo $row->pay_amount; ?></td>
    <td class="tg-baqh"><?php echo $row->paid_amount; ?></td>
    <td class="tg-baqh"><?php echo $row->pay_amount-$row->paid_amount; ?></td>
  
   
  </tr>
   <?php $i++; }} ?>
    <tr>
    <td class="tg-baqh"></td>
    <td class="tg-baqh"></td>
    <td class="tg-baqh"></td>
    <td class="tg-baqh">Total</td>
    <td class="tg-baqh"><?php echo $sum; ?></td>
    <td class="tg-baqh"><?php echo $sum2; ?></td>
    <td class="tg-baqh"><?php echo $sum-$sum2; ?></td>
  </tr>
</table>

<html>