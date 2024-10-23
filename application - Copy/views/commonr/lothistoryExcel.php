  <?php 
$name="LotHistoryReport_".date('Y-m-dhi').".xls";
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
                <th style="text-align:center;width:7%">Lot No</th>
                <th style="text-align:center;width:7%">TRX TYPE</th>
                <th style="text-align:center;width:10%">Date</th>
                <th style="text-align:center;width:7%">REF. No</th>
                <th style="text-align:center;width:10%">Supplier</th>
                <th style="text-align:center;width:8%">Quantity</th>
                <th style="text-align:center;width:5%">Unit</th>
                <th style="text-align:center;width:8%">U Cost</th>
                <th style="text-align:center;width:8%">Total Amt</th>
                <th style="text-align:center;width:8%">Currency</th>
                <th style="text-align:center;width:10%">Item Code 项目代码</th>
                <th style="width:15%;">Item/Materials Name</th>
                <th style="text-align:center;width:8%">Location</th>
            </tr>
            </thead>
            <tbody>
            <?php $totalbalance=0; $totalvalue=0;$grandpi=0;
            if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
              foreach($resultdetail as $row):
                if($i==1) $FIFO_CODE=$row->FIFO_CODE;

                if($row->FIFO_CODE==$FIFO_CODE){
                $stock=$row->QUANTITY;
                $totalbalance=$totalbalance+$stock;
                ?>
                <tr>
                  <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->FIFO_CODE; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->TRX_TYPE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->INDATE; ?></td> 
                  <td style="text-align:center;">
                    <?php echo $row->REF_CODE; ?></td> 
                  <td></td>
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
                  <td style="text-align:center;">
                    <?php echo $row->product_code; ?></td>
                  <td style=""><?php echo $row->product_name;?></td>                  
                  <td style="text-align:center;">
                    <?php echo $row->LOCATION;  ?></td>
                </tr>
                <?php
                  }else{  
                ?>
                <tr>
                  <td style="text-align:right;background-color: #CCD1D1" colspan="6">
                    Balance</td>
                  <td style="vertical-align: text-top;text-align:center;background-color: #CCD1D1">
                  <?php  echo number_format($totalbalance,2);  ?></td>
                  <td style="vertical-align: text-top;text-align:center;background-color: #CCD1D1"  colspan="7"></td>
                </tr>
                <?php 
                 $totalbalance=0; 
                 $stock=$row->QUANTITY;
                 $totalbalance=$totalbalance+$stock;
                 $FIFO_CODE=$row->FIFO_CODE
                 ?>
                 <tr>
                  <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                  <td style="text-align:center;">
                    <?php echo "'$row->FIFO_CODE"; ?></td>
                  <td style="text-align:center;">
                    <?php echo $row->TRX_TYPE; ?></td>
                  <td style="vertical-align: text-top;text-align:center;">
                  <?php  echo $row->INDATE; ?></td> 
                  <td style="text-align:center;">
                    <?php echo $row->REF_CODE; ?></td> 
                  <td></td>
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
                  <td style="text-align:center;">
                    <?php echo $row->product_code; ?></td>
                  <td style=""><?php echo $row->product_name;?></td>                  
                  <td style="text-align:center;">
                    <?php echo $row->LOCATION;  ?></td>
                </tr>
            <?php 
             }
              endforeach;
            endif;
            ?>
            <tr>
            <td style="text-align:right;background-color: #CCD1D1" colspan="6">
              Balance</td>
            <td style="vertical-align: text-top;text-align:center;background-color:  #CCD1D1">
            <?php  echo  number_format($totalbalance,2);  ?></td>
            <td style="vertical-align: text-top;text-align:center;background-color: #CCD1D1"  colspan="7"></td>
          </tr>
    </tbody>
 
</table>

<html>