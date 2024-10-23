  <?php 
$name="piStatusReport_".date('Y-m-dhi').".xls";
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
                  <th style="text-align:center;width:3%;">SN</th>
                  <th style="text-align:center;width:8%">PI NO</th>
                  <th style="text-align:center;width:8%">PI Date</th>
                  <th style="text-align:center;width:8%">Demand Date</th>
                   <th style="text-align:center;width:7%">Pur.Type</th>
                  <th style="width:15%;">Item/Materials Name</th>
                  <th style="text-align:center;width:8%">Item Code <br> 项目代码</th>
                  <th style="text-align:center;width:7%">Unit Price</th>
                  <th style="text-align:center;width:7%">Currency</th>
                  <th style="text-align:center;width:7%">PI Qty</th>
                  <th style="text-align:center;width:7%">PO Qty</th>
                  <th style="text-align:center;width:7%">IN Qty</th>
                  <th style="text-align:center;width:7%">DUE Qty</th>

              </tr>
              </thead>
              <tbody>
              <?php $grandtotal=0; $grandamount=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                    $bdcolor='';
                    if($row->pi_date>='2020-01-01'){
                     if(($row->purchased_qty-$row->in_qty)<0) $bdcolor="background-color: red";
                     if($row->purchased_qty>$row->in_qty) $bdcolor="background-color: yellow"; 
                    }
                  ?>
                  <tr>
                    <td style="text-align:center;">
                      <?php echo $i++; ?></td>
                     <td style="text-align:center;">
                      <?php echo $row->pi_no;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo findDate3($row->pi_date);  ?></td>
                    <td style="text-align:center;">
                      <?php echo findDate3($row->demand_date);  ?></td>
                    <td class="text-center"><?php 
                   if($row->purchase_type_id==1||$row->purchase_type_id==2) echo "Overseas"; else echo "Local"; ?></td>
                    <td style=""><?php echo $row->product_name;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo "$row->unit_price";  ?></td>
                    <td style="text-align:center;">
                      <?php echo "$row->currency";  ?></td>
                    <td style="text-align:center;">
                      <?php echo $row->purchased_qty;  ?></td> 
                    <td style="text-align:center;">
                      <?php echo $row->po_qty;  ?></td> 
                    <td style="text-align:center;">
                      <?php
                      if($row->pi_date>='2020-01-01'){
                      echo $row->in_qty; 
                      }else{
                        echo $row->purchased_qty;
                      }?></td> 
                    <td style="text-align:center; <?php echo $bdcolor; ?>">
                      <?php 
                      if($row->pi_date>='2020-01-01'){
                      echo $row->purchased_qty-$row->in_qty; 
                      }else{
                        echo "0.00";
                      } ?></td> 
                    </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              </tbody>
 
</table>

<html>