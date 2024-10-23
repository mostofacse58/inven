  <?php 
$name="DieselReport_".date('Y-m-dhi').".xls";
header('Content-Type: text/html; charset=utf-8');
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
  padding:10px;
  border-style:solid;
  border-width:1px;
  overflow:hidden;
  word-break:normal;
  border-color: #000;
}
.tg th{
  font-size:12px;
  font-weight:bold;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
  overflow:hidden;
  word-break:normal;
  border-color: #000;
}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;
  vertical-align:top}
</style>
   <?php if($from_date!=''){  ?>
   <p align="center" style="margin:0;"><b>
From Date: <?php echo $from_date; ?>
  &nbsp;&nbsp;&nbsp;&nbsp; To Date: <?php echo $to_date;  ?>
</b></p>
<?php } ?>

<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading)) echo $heading; ?>  </b></h4>
<table class="tg" style="width:99%;border:#000" >
          <thead>
      <tr>
      <th style="width:4%;">SN</th>
      <th style="width:8%;">Date</th>
      <th style="width:8%;">Department</th>
      <th style="width:15%">Vehicle Name</th>
      <th style="width:10%;text-align:center">Fuel Reading <br> at Start Point</th>
      <th style="width:10%;text-align:center">Fuel Reading <br> at Stop Point</th>
      <th style="text-align:center;width:10%">Run(KM)(Liter)</th>
      <th style="text-align:center;width:10%">Start Run Hr</th>
      <th style="text-align:center;width:10%">Stop Run Hr</th>
      <th style="text-align:center;width:10%">Run Hr</th>
      <th style="text-align:center;width:8%">Diesel Qty</th>
      <th style="text-align:center;width:8%">Taken By</th>
      <th style="text-align:center;width:7%">Req No</th>
      <th style="text-align:center;width:6%">Non Official KM</th>
      <th style="text-align:center;width:6%">Amount</th>
      </tr>
      </thead>
      <tbody>
      <?php $grandtotal=0; $totalcost=0;
      if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
        foreach($resultdetail as $row):
          $grandtotal=$grandtotal+$row->issue_qty;
          $totalcost=$totalcost+$row->amount;
          ?>
      <tr>
      <td style="text-align:center">
        <?php echo $i++; ; ?></td>
      <td class="text-center">
        <?php echo findDate($row->issue_date); ?></td>
      <td><?php echo $row->fuel_using_dept_name;?></td>
      <td style="text-align:center">
        <?php echo $row->motor_name; ; ?></td>
      <td style="text-align:center">
        <?php echo $row->fuel_r_start_point_km_liter;  ?></td>  
      <td style="text-align:center">
        <?php echo $row->fuel_r_end_point_km_liter;  ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->run_km_liter; ?></td> 
      <td style="vertical-align: text-top">
      <?php echo $row->start_hour;  ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->stop_hour; ?></td> 
      <td style="vertical-align: text-top">
      <?php  echo $row->run_hour; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->issue_qty; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->driver_name; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->req_no; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->on_officicer_km; ?></td>
      <td style="vertical-align: text-top">
      <?php  echo $row->amount; ?></td>
      </tr>
      <?php
      endforeach;
  endif;
  ?>
  <tr>
      <th style="text-align:right;" colspan="10">Grand Total</th>
      <th style="text-align:center;"><?php echo $grandtotal; ?></th>
      <th style="text-align:right;" colspan="3"></th>
      <th style="text-align:center;"><?php echo $totalcost; ?></th>
  </tr>
  </tbody>
  </table>
  <h4 style="text-align: right;">Available Stock Balance: <?php echo  $this->db->query("SELECT main_stock FROM product_info 
      WHERE product_id=3614")->row('main_stock'); ?>
      </h4>

<html>