  <?php 
$name="POReport_".date('Y-m-dhi').".xls";
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
      <th style="text-align:center;width:3%;">SN 序號</th>
      <th style="text-align:center;width:8%">Supplier Name 供應商名稱</th>
      <th style="text-align:center;width:7%">PO NO 采购订单号</th> 
      <th style="text-align:center;width:8%">PO Date 訂購時間</th>
      <th style="text-align:center;width:8%">Item Code <br> 訂購物料編碼</th>
      <th style="width:15%;">Material Name <br>訂購物料名稱 </th>
      <th style="text-align:center;width:8%">Specification規格</th>
      <th style="text-align:center;width:7%">PO QTY訂購物料數量</th>                  
      <th style="text-align:center;width:7%">Unit Price訂購物料單價</th>
      <th style="text-align:center;width:7%">Currency幣別</th>
      <th style="text-align:center;width:7%">Total Amount總額 </th>
  </tr>
  </thead>
  <tbody>
    <?php $grandtotal=0; $grandamount=0;
    if(isset($resultdetail)&&!empty($resultdetail)): 
      $i=1;
      foreach($resultdetail as $row):
      ?>
      <tr>
        <td style="text-align:center;"><?php echo $i++; ?></td>
        <td style=""><?php echo getSupplier($row->supplier_id);?></td>
         <td style="text-align:center;"><?php echo $row->po_number;  ?></td> 
        <td style="text-align:center;"><?php echo findDate($row->po_date);  ?></td>
        <td style="text-align:center;"><?php echo $row->product_code;  ?></td>
        <td style=""><?php echo $row->product_name;?></td>
        <td style="text-align:center;"><?php echo $row->specification;  ?></td> 
        <td style="text-align:center;"> <?php echo $row->quantity;  ?></td> 
        <td style="text-align:center;"><?php echo $row->unit_price;  ?></td>
        <td style="text-align:center;"><?php echo $row->currency;  ?></td> 
        <td style="text-align:center;"><?php echo $row->total_amount;  ?></td>  
        </tr>
      <?php
      endforeach;
  endif;
  ?>
  </tbody>
 
</table>

<html>