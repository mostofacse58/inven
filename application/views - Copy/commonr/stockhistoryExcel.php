  <?php 
$name="StockHistoryReport_".date('Y-m-dhi').".xls";
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
   .tg td{ }
</style>
<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading))echo $heading; ?>  </b></h4>
<table class="tg">
  <thead>
            <tr>
                <th style="text-align:center;width:4%;">SN</th>
                <th style="text-align:center;width:10%">Item Code <br> 项目代码</th>
                <th style="width:15%;">Item/Materials Name</th>
                <th style="text-align:center;width:8%">Location</th>
                <th style="text-align:center;width:7%">Lot No</th>
                <th style="text-align:center;width:7%">PO/WO No</th>
                <th style="text-align:center;width:8%">Quantity</th>
                <th style="text-align:center;width:5%">Unit</th>
                <th style="text-align:center;width:8%">U Cost</th>
                <th style="text-align:center;width:8%">Total Amt</th>
                <th style="text-align:center;width:8%">Currency</th>
                <th style="text-align:center;width:10%">Date</th>
                <th style="text-align:center;width:15%">Reason</th>
            </tr>
            </thead>
            <tbody>
            <?php $grandtotal=0; $totalvalue=0;$grandpi=0;
            if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
              foreach($resultdetail as $row):
                if($row->main_stock>0){
                $stock=$row->main_stock;
                $grandtotal=$grandtotal+$stock;
                $totalvalue=$totalvalue+$stock*$row->UPRICE;
                ?>
                <tr>
                  <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                  <td style=""><?php echo $row->product_name;?></td>
                  <td style="text-align:center;">
                    <?php echo $row->product_code; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->LOCATION;  ?></td>
                  <td style="text-align:center;">
                     <?php echo "'$row->FIFO_CODE"; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->REF_CODE;  ?></td> 
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo "$stock"; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo "$row->unit_name"; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->UPRICE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $stock*$row->UPRICE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->CRRNCY; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->INDATE; ?></td>            
                  <td style="vertical-align: text-top;text-align:right;"></td>
                </tr>
                <?php
              }
              endforeach;
            endif;
            ?>
            <tr>
                <th style="text-align:right;" colspan="6">Grand Total</th>
                <th style="text-align:center;"><?php echo $grandtotal; ?></th>
                <th style="text-align:center;"></th>
                <th style="text-align:center;"></th>
                <th style="text-align:right;"><?php echo number_format($totalvalue,2); ?></th>
                <th style="text-align:center;"></th>
                <th style="text-align:center;"></th>
                <th style="text-align:center;"></th>
            </tr>
            </tbody>
 
</table>

<html>