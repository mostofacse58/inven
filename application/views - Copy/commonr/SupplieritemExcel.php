  <?php 
$name="SupplierItemReport_".date('Y-m-dhi').".xls";
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
<table class="tg">
  <thead>
    <tr>
        <th style="text-align:center;width:5%;">SN</th>
        <th style="text-align:center;width:7%">Supplier Name</th>
        <th style="text-align:center;width:10%">Receive Date</th>
        <th style="text-align:center;width:10%">Ref/Invoice</th>
        <th style="width:15%;">Item/Materials </th>
        <th style="text-align:center;width:10%">Item Code <br> 项目代码</th>
        <th style="text-align:center;width:7%">FIFO NO</th>
        <th style="text-align:center;width:7%">Receive Qty</th>
        <th style="text-align:center;width:7%">Unit Price(Currency)</th>
        <th style="text-align:center;width:7%">Amount(HKD)</th>
        <th style="text-align:center;width:7%">PI NO</th>
        <th style="text-align:center;width:7%">Specification</th>
    </tr>
    </thead>
    <tbody>
    <?php $grandtotal=0; $grandamount=0;
    if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
      foreach($resultdetail as $row):
        $grandtotal=$grandtotal+$row->quantity;
        $grandamount=$grandamount+$row->amount_hkd;
        ?>
        <tr>
          <td style="text-align:center;">
            <?php echo $i++; ?></td>
           <td style="text-align:center;">
            <?php echo $row->supplier_name;  ?></td>
          <td style="text-align:center;">
            <?php echo findDate($row->purchase_date);  ?></td>
          <td style="text-align:center;">
            <?php echo $row->reference_no;  ?></td> 
          <td style=""><?php echo $row->product_name;?></td>
          <td style="text-align:center;">
            <?php echo $row->product_code;  ?></td> 
          <td style="text-align:center;">
            <?php echo "'$row->FIFO_CODE";  ?></td> 
          <td style="vertical-align: text-top;text-align:center;">
          <?php  echo "$row->quantity $row->unit_name"; ?></td>
          <td style="text-align:center;">
            <?php echo "$row->unit_price $row->currency";  ?></td> 
          <td style="text-align:center;">
            <?php echo $row->amount_hkd;  ?></td> 
          <td style="text-align:center;">
            <?php echo $row->pi_no;  ?></td> 
          <td style="text-align:center;">
            <?php echo $row->specification;  ?></td>
           
          </tr>
        <?php
        endforeach;
    endif;
    ?>
    <tr>
        <th style="text-align:right;" colspan="7">Grand Total</th>
        <th style="text-align:center;"><?php echo $grandtotal; ?> </th>
        <th style="text-align:center;"></th>
        <th style="text-align:center;">
          <?php echo number_format($grandamount,2); ?> HKD</th>
        <th style="text-align:center;"></th>
        <th style="text-align:center;"></th>
    </tr>
    </tbody>
 
</table>

<html>