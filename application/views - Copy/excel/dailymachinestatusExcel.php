  <?php 
$name="dailyMachineStatusReport_".date('Y-m-dhi').".xls";
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
  border-spacing:0;width:100%}
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
    <?php if($from_date!=''){  ?>
   <h3 align="center" style="margin:0;padding: 5px">
   <b>
Date: <?php echo date("jS M-Y", strtotime("$from_date")); ?>
</b></h3>
<?php } ?>
<table class="tg">
  <thead>
  <tr>
     <th style="text-align:center;width:5%">SL NO</th>
      <th style="text-align:center;width:20%;">LOCATION <br>位置</th>
      <th style="text-align:center;width:15%">WORKING MACHINES <br> 机器在使用中</th>
      <th style="text-align:center;width:15%">IDLE MACHINES<br>闲 机</th>
      <th style="text-align:center;width:15%">UNDER SERVICE<br>正在服务</th>
      <th style="text-align:center;width:15%">MISSING DATA <br> 缺失数据</th>
      <th style="text-align:center;width:15%">GRAND TOTAL <br>累计</th>
  </tr>
  </thead>
  <tbody>
  <?php
   $i=1; $totalworking=0;
   $totalidle=0;
   $totalservice=0;
   $totalmissing=0;
    foreach($flist as $row){
      $grandtotal=0;
      ?>
      <tr>
      <td style="text-align:center">
          <?php echo $i++; ; ?></td>
        <td style="text-align:center">
      <?php echo $row->floor_no; ?></td>
      <td style="text-align:center">
      <?php $total=$this->dailymachinestatus_model->reportrResult($row->floor_id,$from_date,1);
      $totalworking=$totalworking+$total;
      $grandtotal=$grandtotal+$total;
      echo $total; ?></td>
      <td style="text-align:center">
      <?php $total=$this->dailymachinestatus_model->reportrResult($row->floor_id,$from_date,2);
      $totalidle=$totalidle+$total;
      $grandtotal=$grandtotal+$total;
      echo $total; ?></td>
      <td style="text-align:center">
      <?php $total=$this->dailymachinestatus_model->reportrResult($row->floor_id,$from_date,3);
      $totalservice=$totalservice+$total;
      $grandtotal=$grandtotal+$total;
      echo $total; ?></td>
      <td style="text-align:center">
      <?php                 
      echo 0; ?></td>
      <td style="text-align:center">
      <?php echo $grandtotal; ?></td>

      </tr>
      <?php }
     ?>
     <tr>
       <th style="text-align:center;width:5%"><?php echo $i++; ; ?></th>
        <th style="text-align:center;width:20%;">MISSING DATA</th>
        <th style="text-align:center;width:15%">0</th>
        <th style="text-align:center;width:15%">0</th>
        <th style="text-align:center;width:15%">0</th>
        <td style="text-align:center">
        <?php 
        $totalmissing=$this->dailymachinestatus_model->NotfoundMachine(3);
        echo $totalmissing; ?></td>
        <td style="text-align:center">
        <?php echo $totalmissing; ?></td>
    </tr>
     <tr>
     <th style="text-align:center;width:5%"></th>
      <th style="text-align:center;width:20%;">TOTAL</th>
      <th style="text-align:center;width:15%"><?php echo $totalworking; ?></th>
      <th style="text-align:center;width:15%"><?php echo $totalidle; ?></th>
      <th style="text-align:center;width:15%"><?php echo $totalservice; ?></th>
      <th style="text-align:center;width:15%"><?php echo $totalmissing; ?></th>
      <th style="text-align:center;width:15%">
        <?php echo $totalidle+$totalworking+$totalservice+$totalmissing; ?></th>
  </tr>
</tbody>
</table>

<html>