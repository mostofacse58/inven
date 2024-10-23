<?php 
$name="ModelwisereportExcels".date('Y-m-dhi').".xls";
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
  border-spacing:0;width:120%}
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
<table class="tg">
  <thead>
      <tr>
        <th style="text-align:center;width:5%;">SN</th>
        <th style="width:10%">Model</th>
        <th style="width:15%;">English<br> Name </th>
        <th style="width:12%;">China<br> Name </th>
        <th style="text-align:center;width:8%">Total</th>
        <th style="text-align:center;width:8%">USED</th>
        <th style="text-align:center;width:8%">IDLE</th>
        <th style="text-align:center;width:8%">U.S</th>
        <th style="text-align:center;width:8%">Missing</th>
        <th style="text-align:center;width:8%">Not Assign</th>
       <?php foreach ($flist as  $value) {
         ?>
       <th style="text-align:center;width:8%">
        <?php echo $value->floor_no; ?></th>
       <?php } ?>
      </tr>
      </thead>
      <tbody>
      <?php
      if(isset($resultdetail)&&!empty($resultdetail)): 
        $i=1;
        foreach($resultdetail as $row):
            ?>
          <tr>
            <td style="text-align:center;">
              <?php echo $i++; ?></td>
            <td style="text-align:center">
              <?php echo $row->product_model; ; ?></td>
            <td><?php echo $row->product_name;?></td>
            <td><?php echo $row->china_name;?></td>
            <td style="vertical-align:text-top;text-align:center;">
            <?php  echo $row->totalqty; ?></td>
            <td style="text-align:center">
            <?php $total1=$this->modelwisereport_model->getModelWiseStatus($row->product_id,1); 
            echo $total1; ?></td>
            <td style="text-align:center">
            <?php $total2=$this->modelwisereport_model->getModelWiseStatus($row->product_id,2); 
            echo $total2; ?></td>
            <td style="text-align:center">
            <?php $total3=$this->modelwisereport_model->getModelWiseStatus($row->product_id,3);  
            echo $total3; ?></td>
            <td style="text-align:center">
            <?php 
            $total4=$this->modelwisereport_model->NotfoundMachine($row->product_id,3);
            echo $total4; ?></td>
            <td style="text-align:center">
            <?php 
            echo $row->totalqty-($total1+$total2+$total3+$total4); ?></td>
            <?php foreach ($flist as  $value) {
           ?>
           <td style="text-align:center;width:8%">
            <?php 
            $total=$this->modelwisereport_model->getModelWiseFloor($row->product_id,$value->floor_id);
            echo $total; ?></td>
           <?php } ?>
          </tr>
          <?php
          endforeach;
      endif;
      ?>
      </tbody>
</table>
<html>