  <?php 
$name="DowntimeReport_".date('Y-m-dhi').".xls";
header("Content-type: application/octet-stream");
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
  <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  </head>
<style type="text/css">
body{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
}
.tg  {border-collapse:collapse;
  border-spacing:0;width:150%}
.tg td{
  font-size:12px;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
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
  word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;
  vertical-align:top}
</style>
<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading))echo $heading; ?>  </b></h4>
   <p align="center" style="margin:0;"><b>
From Date: <?php echo $from_date; ?>
  &nbsp;&nbsp;&nbsp;&nbsp; To Date: <?php echo $to_date;  ?>
</b></p>
<table class="tg">
  <tr>
    <th class="tg-s6z2">SL NO</th>
    <th class="tg-s6z2">LINE NAME</th>
    <th class="tg-s6z2">DATE,日期</th>
    <th class="tg-s6z2">TPM CODE (TPM代码) NO,<br>TPM编码</th>
    <th class="tg-s6z2">MACHINE NAME,<br>机器名称</th>
    <th class="tg-s6z2">MODEL NUMBER,<br>型号</th>
    <th class="tg-s6z2">PROBLEM START TIME,<br>问题开始时间</th>
    <th class="tg-s6z2">RESPONSE TIME,<br>响应时间</th>
    <th class="tg-s6z2">PROBLEM,问题</th>
    <th class="tg-s6z2">PROBLEM END TIME,<br>问题结束时间</th>
    <th class="tg-s6z2">ACTION TAKEN, <br>所采取的行动</th>
    <th class="tg-s6z2">VISOR NAME, <br>主管名称</th>
    <th class="tg-s6z2">ME Name,<br>ME 名称</th>
    <th class="tg-s6z2">TOTAL DOWNTIME(IN MINUTES),<br> 总停机时间(分钟)</th>
  </tr>
<?php
  if(isset($resultdetail)){
     $i=1;
     $sum=0;
    foreach($resultdetail as $row){ 
   $sum=$sum+$row->total_minuts;
    ?>
  <tr>
     <td><?php echo $i++;?></td>
     <td class="tg-s6z2"><?php echo   $row->line_no; ?></td>
    <td class="tg-s6z2"><?php echo findDate($row->down_date); ?></td>
    <td style="text-align:center">
      <?php echo $row->tpm_serial_code; ; ?></td>
    <td><?php echo $row->product_name;?></td>
    <td style="text-align:center">
      <?php echo $row->product_code; ; ?></td>    
    <td class="tg-s6z2">
      <?php echo date("H:i:s A", strtotime($row->problem_start_time));  ?>
    </td>
    <td class="tg-s6z2">
      <?php echo date("H:i:s A", strtotime($row->me_response_time));  ?></td>
    <td><?php echo $row->problem_description; ?></td>
    <td class="tg-s6z2">
      <?php echo date("H:i:s A", strtotime($row->problem_end_time));  ?>
      </td>
    <td class="tg-s6z2"><?php echo $row->action_taken; ?></td>
    <td class="tg-s6z2"><?php echo $row->supervisor_name; ?></td>
    <td class="tg-s6z2"><?php echo $row->me_name; ?></td>
    <td class="tg-s6z2"><?php echo $row->total_minuts; ?></td>
  </tr>
  <?php  }} ?>
 
</table>
<p align="center"><b>Grnad Total Downtime: <?php echo $sum; ?> Minutes</b></p>

<html>