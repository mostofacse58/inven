  <?php 
$name="Budget_view_".date('Y-m-dhi').".xls";
header('Content-Type: text/html; charset=utf-8');
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
  <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style type="text/css">
body{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
}
  @media print{
            .print{ display:none;}
            .approval_panel{ display:none;}
             .margin_top{ display:none;}
            .rowcolor{ background-color:#CCCCCC !important;}
            body {padding: 3px; font-size:12px}
        }
}
.tg  {border-collapse:collapse;
  border-spacing:0;width:120%}
.tg td{
  font-size:12px;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
  border-color: #000;
  overflow:hidden;
  word-break:normal;
}
.tg th{
  font-size:12px;
  font-weight:bold;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
  overflow:hidden;
  border-color: #000;
  word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;
  vertical-align:top}
</style>
</head>
<body>
  
  <div class="table-responsive table-bordered">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:0px 0px;color: #538FD4">
<b><?php echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px" >
  <b>Budget for <?php 
if(isset($info)) {$date = date('Y-m',strtotime($info->for_month." +-1 month")); }else {$date = date('Y-m');}
                 $onemonth = date('Y-m',strtotime($date." +1 month"));
                 $twomonth = date('Y-m',strtotime($date." +2 month"));
                 $threemonth = date('Y-m',strtotime($date." +3 month"));
                 $fourmonth = date('Y-m',strtotime($date." +4 month"));
                 $fivemonth = date('Y-m',strtotime($date." +5 month"));
                 $sixmonth = date('Y-m',strtotime($date." +6 month"));
                 echo date("M-Y", strtotime("$onemonth"));
           ?>  </b></p>
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
  <th style="text-align:center;font-size: 16px;width: 24%;" colspan="3">All Cost Forecast </th>
  <th style="text-align:center;font-size: ;width: 16%;" colspan="2">Vital Cost Forecast </th>
  <th style="text-align:center;font-size: 16px;width: 10%;" rowspan="2">Remarks</th>
</tr>
<tr>
  <th style="text-align:center;"><?php echo date("M-Y", strtotime("$onemonth")); ?></th>
  <th style="text-align:center;font-size: 16px">
    <?php echo date("M-Y", strtotime("$twomonth")); ?></th>
  <th style="text-align:center;font-size: 16px">
    <?php echo date("M-Y", strtotime("$threemonth")); ?></th>
  <th style="text-align:center;font-size: 16px">
    <?php echo date("M-Y", strtotime("$fourmonth")); ?></th>
  <th style="text-align:center;font-size: 16px">
    <?php echo date("M-Y", strtotime("$fivemonth")); ?></th>
  <th style="text-align:center;font-size: 16px">
    <?php echo date("M-Y", strtotime("$sixmonth")); ?></th>
</tr>
</thead>
<tbody>
  <?php
  if(isset($hlist)){
     $i=1;
     $amount2=0;
     $amount3=0;
     $amount4=0;
     $amount5=0;
     $amount6=0;
    foreach($hlist as $rows){ 
     $amount2=$amount2+$rows->amount2;
     $amount3=$amount3+$rows->amount3;
     $amount4=$amount4+$rows->amount4;
     $amount5=$amount5+$rows->amount5;
     $amount6=$amount6+$rows->amount6;
     if($rows->amount>0){ 
    ?>
   <tr>
  <td style="text-align: center;"><?php echo $i; ?> </td>
  <td style="text-align: center;">
    <?php echo $rows->head_name; ?>
  </td>
  <td style="text-align:center;">
    <?php echo $rows->amount; ?>
  </td>
  <td style="text-align:center;">
    <?php echo $rows->amount2; ?>
  </td>
  <td style="text-align:center;">
    <?php echo $rows->amount3; ?>
  </td>
  <td style="text-align:center;">
    <?php echo $rows->amount4; ?>
  </td>
  <td style="text-align:center;">
    <?php echo $rows->amount5; ?>
  </td>
  <td style="text-align:center;">
    <?php echo $rows->amount6; ?>
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
    <th class="tg-right"><?php if(isset($info)) echo number_format($amount2,2); ?></th>
    <th class="tg-right"><?php if(isset($info)) echo number_format($amount3,2); ?></th>
    <th class="tg-right"><?php if(isset($info)) echo number_format($amount4,2); ?></th>
    <th class="tg-right"><?php if(isset($info)) echo number_format($amount5,2); ?></th>
    <th class="tg-right"><?php if(isset($info)) echo number_format($amount6,2); ?></th>
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
</body>

<html>