  <?php 
$name="SpareStockReport_".date('Y-m-dhi').".xls";
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
  border-spacing:0;width:200%}
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
   .tg td{background-color:#FFDF00; }
</style>
<body>
<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading))echo $heading; ?>  </b></h4>
  <table class="tg">
  <thead>
  <tr>
    <th style="text-align:center;width:5%;">SN</th>
    <th style="width:15%;">English Name</th>
    <th style="width:15%;">China Name 中国名</th>
    <th style="width:10%">Category Name 分类名称</th>
    <th style="text-align:center;width:10%">Materials Type</th>
    <th style="text-align:center;width:10%">Rack(Box) 架</th>
    <th style="text-align:center;width:10%">Item Code 项目代码</th>
    <th style="text-align:center;width:8%">Item Origin</th>

    <th style="text-align:center;width:6%">
    <?php $date = date('Y-m');
      $sixmonth = date('Y-m',strtotime($date." -6 month"));
       echo date("M-Y", strtotime("$sixmonth"));;
     ?></th>
     <th style="text-align:center;width:6%">
      <?php 
      $fivemonth = date('Y-m',strtotime($date." -5 month"));
       echo date("M-Y", strtotime("$fivemonth"));;
     ?></th>
      <th style="text-align:center;width:6%">
      <?php 
      $fourmonth = date('Y-m',strtotime($date." -4 month"));
       echo date("M-Y", strtotime("$fourmonth"));;
     ?></th>
      <th style="text-align:center;width:6%">
      <?php 
      $threemonth = date('Y-m',strtotime($date." -3 month"));
       echo date("M-Y", strtotime("$threemonth"));;
     ?></th>
      <th style="text-align:center;width:6%">
      <?php 
      $twomonth = date('Y-m',strtotime($date." -2 month"));
       echo date("M-Y", strtotime("$twomonth"));;
     ?></th>
      <th style="text-align:center;width:6%">
      <?php 
      $onemonth = date('Y-m',strtotime($date." -1 month"));
       echo date("M-Y", strtotime("$onemonth"));;
     ?></th>
    <th style="text-align:center;width:8%">Quantity Used for Last 6 Months<br>近6个月使用的数量</th>
    <th style="text-align:center;width:8%">Average Used Qty Per Month<br>平均每月使用量</th>
    <th style="text-align:center;width:8%">Lead Time 采购周期</th>
    <th style="text-align:center;width:8%">Lead Time Stock Qty <br>采购周期库存数量</th>
    <th style="text-align:center;width:8%">1 Months Stock Qty <br>1个月库存数量</th>
    <th style="text-align:center;width:8%">20% of Lead Time Stock <br>采购周期中剩余20%库存数量</th>
    <th style="text-align:center;width:8%">Reorder Level <br>库存预警数量</th>
    <th style="text-align:center;width:8%">Reorder Qty <br>再订购数量 </th>
    <th style="text-align:center;width:7%">Min. Stock <br>最低安全库存</th>                
    <th style="text-align:center;width:6%">Stock Qty <br>库存数量</th>
    <th style="text-align:center;width:7%">Unit Price<br>单价</th>
    <th style="text-align:center;width:6%">Safety stock value <br>安全库存总金额</th>
    <th style="text-align:center;width:7%">Amount in excess of safety stock value <br>超过安全库存值的金额</th>
    <th style="text-align:center;width:6%">PI Qty <br>PI购买数量</th>
    <th style="text-align:center;width:6%">Unit 单位</th>
    <th style="text-align:center;width:5%">Stock Value <br>库存金额</th>
    <th style="text-align:center;width:5%">Currency <br>货币</th>
     <th style="text-align:center;width:5%">First In Date <br>首次约会</th>
    <th style="text-align:center;width:6%">Last Received Date <br>上一次收货日期</th>
  </tr>
  </thead>
  <tbody>
<?php 
  $grandtotal=0; 
  $totalvalue=0;
  $grandpi=0;
  if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
    foreach($resultdetail as $row):
      $piqty=$this->look_up_model->get_PIStock($row->product_id);
      if($piqty>0||$row->main_stock>0||$row->minimum_stock>0){
      /////////////////////////////////////////////
      if($color_code!=3){
      $stock=$row->main_stock;
      $grandtotal=$grandtotal+$stock;
      $grandpi=$grandpi+$piqty;
      $totalvalue=$totalvalue+$stock*$row->unit_price;
      $color="background-color: white;color: #000;";
        if($stock<$row->minimum_stock){
          $color="background-color: #CE3130;color: #FFF;";
        } 
       ?>
      <tr>
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $i++; ?></td>
        <td style="<?php echo $color; ?>"><?php echo $row->product_name;?></td>
        <td style="<?php echo $color; ?>"><?php echo $row->china_name;?></td>
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->category_name; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->mtype_name;  ?></td>  
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->rack_name;  ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->product_code;  ?></td> 
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->bd_or_cn; ?></td>

        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->sixqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->fiveqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->fourqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->threeqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->twoqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->oneqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->last_six_month_qty; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->avg_use_per_month; ?></td> 
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo "$row->lead_time days"; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->lead_time_stock_qty; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->one_month_stock; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->twenty_per_stock; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->reorder_level; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->re_order_qty; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->minimum_stock; ?></td>
        
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $stock; ?></td>
        <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
        <?php  echo "$row->unit_price";  ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo number_format($row->minimum_stock*$row->unit_price,2); ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo number_format(($stock*$row->unit_price)-($row->minimum_stock*$row->unit_price),2); ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php if($piqty>0)echo "background-color: #FFDF00";else echo $color; ?>">
        <?php  echo $piqty; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->unit_name; ?></td>
        <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
        <?php  echo number_format($stock*$row->unit_price,2);  ?></td>
        <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
        <?php  echo "$row->currency"; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo findDate($row->create_date); ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo findDate($row->last_receive_date); ?></td>
      </tr> 
      <?php
    }else{
    ?>
    <?php $stock=$row->main_stock;
      if($piqty>0){
      $stock=$row->main_stock;
      $grandtotal=$grandtotal+$stock;
      $grandpi=$grandpi+$piqty;
      $totalvalue=$totalvalue+$stock*$row->unit_price;
        $color="background-color: white;color: #000;";
        if($stock<$row->minimum_stock){
          $color="background-color: #CE3130;color: #FFF;";
        } 
       ?>
      <tr>
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $i++; ?></td>
        <td style="<?php echo $color; ?>"><?php echo $row->product_name;?></td>
        <td style="<?php echo $color; ?>"><?php echo $row->china_name;?></td>
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->category_name; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->mtype_name;  ?></td>  
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->rack_name;  ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->product_code;  ?></td> 
        <td style="text-align:center;<?php echo $color; ?>">
          <?php echo $row->bd_or_cn; ?></td>

        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->sixqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->fiveqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->fourqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->threeqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->twoqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->oneqty; ?></td>
        <td style="text-align:center;<?php echo $color; ?>">
        <?php echo $row->last_six_month_qty; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->avg_use_per_month; ?></td> 
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo "$row->lead_time days"; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->lead_time_stock_qty; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->one_month_stock; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->twenty_per_stock; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->reorder_level; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->re_order_qty; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->minimum_stock; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $stock; ?></td>
        <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
        <?php  echo "$row->unit_price";  ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo number_format($row->minimum_stock*$row->unit_price,2); ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo number_format(($stock*$row->unit_price)-($row->minimum_stock*$row->unit_price),2); ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php if($piqty>0)echo "background-color: #FFDF00";else echo $color; ?>">
        <?php  echo $piqty; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo $row->unit_name; ?></td>
        <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
        <?php  echo number_format($stock*$row->unit_price,2);  ?></td>
        <td style="vertical-align: text-top;text-align:right;<?php echo $color; ?>">
        <?php  echo "$row->currency"; ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                    <?php  echo findDate($row->create_date); ?></td>
        <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
        <?php  echo findDate($row->last_receive_date); ?></td>
      </tr>
  <?php  
     }
   }
 }
      endforeach;
  endif;
  ?>
  <tr>
      <th style="text-align:right;" colspan="23">Grand Total</th>
      <th style="text-align:center;"><?php echo number_format($grandtotal,2); ?></th>
      <th style="text-align:center;"><?php echo number_format($grandpi,2); ?></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th style="text-align:right;"><?php echo number_format($totalvalue,2); ?></th>
      <th></th>
      <th></th>
      <th></th>
  </tr>
  </tbody>
  </table>

  
</body>

<html>