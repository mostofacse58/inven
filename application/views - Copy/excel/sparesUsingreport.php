  <?php 
$name="SparesUsingReport_".date('Y-m-dhi').".xls";
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
<?php if(count($info)>0){ ?>
<h4 align="center" style="margin:0;"><b>Machine Information! </b></h4>
    <table class="table">
        <tr>
           <td></td>
           <td></td>
            <th style="width:15%">English Name:</th>
            <td style="width:35%"><?php echo $info->product_name; ?></td>
            <th style="width:15%"></th>
            <td style="width:35%"></td>
        </tr>
        <tr>
        <td></td>
           <td></td>
            <th style="width:15%">Asset Encoding:</th>
            <td style="width:35%"><?php echo $info->asset_encoding; ?></td>
            <th style="width:15%">TPM CODE (TPM代码):</th>
            <td style="width:35%"><?php echo $info->tpm_serial_code; ?></td>
        </tr>
        <tr>
        <td></td>
           <td></td>
            <th style="width:15%">Product Category:</th>
            <td style="width:35%"><?php echo $info->category_name; ?></td>
            <th style="width:15%">Specifications Model:</th>
            <td style="width:35%"><?php echo $info->product_code; ?></td>
        </tr>
       
    </table>
<br>
<?php } ?>
<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading)) echo $heading; ?>  </b></h4>
<table class="tg">
  <tr>
    <th class="tg-s6z2" style="width: 4">SL NO</th>
    <?php if($product_detail_id=='All'){ ?>
    <th class="textcenter" style="width: 10%;">TPM CODE (TPM代码)</th>
    <th style="text-align:center;width:10%">M.Model</th>
    <?php } ?>
    <th class="textcenter" style="width: 10%;">Location</th>
    <th class="textcenter" style="width: 15%;">Date</th>
    <th class="textcenter" style="width: 10%;">Ref. No</th>
    <th class="textcenter" style="width: 30%;">Spares Name</th>
    <th class="textcenter" style="width: 15%;">ITEM <br> CODE</th>
    <th style="text-align:center;width:8%">FIFO CODE</th>
    <th class="textcenter" style="width: 10%;">Quantity</th>
    <th class="textcenter" style="width: 10%;">Unit Price(Currency)</th>
    <th class="textcenter" style="width: 10%;">Cost(HKD)</th>
    <th class="textcenter" style="width: 8%;">ME/ID</th>
    <th class="textcenter" style="width: 8%;">Requisition No</th>
  </tr>
<?php if(isset($resultdetail)):
 $totalqty=0; 
 $i=1;
 $totalcost=0;
    foreach ($resultdetail as  $value) {
       $totalqty=$totalqty+$value->qty;
       $totalcost=$totalcost+$value->amount_hkd;
     ?>
    <tr>
        <td class="textcenter"><?php echo   $i++; ?></td>
        <?php if($product_detail_id=='All'){ ?>
        <td class="textcenter"><?php echo   $value->tpm_serial_code; ?></td>
        <td class="text-center"><?php echo $value->product_model; ?></td>
        <?php } ?>
        <td class="textcenter"><?php echo   $value->line_no; ?></td>
        <td class="textcenter"><?php echo findDate($value->use_date); ?></td>
        <td class="textcenter"><?php echo $value->using_ref_no;  ?></td>
         <td class=""><?php echo $value->product_name;echo "($value->china_name)"; ?></td>
        <td class="textcenter"><?php echo $value->product_code; ?></td>
        <td style="text-align:center;"><?php echo "'$value->FIFO_CODE";  ?></td> 
        <td class="textcenter"><?php echo "$value->qty $value->unit_name"; ?></td>
        <td class="textcenter"><?php echo "$value->unit_price $value->currency";; ?></td>
        <td class="textcenter"><?php echo $value->amount_hkd; ?></td>
        <td class="textcenter"><?php echo "$value->me_name $value->other_id"; ?></td>
        <td class="textcenter"><?php echo $value->requisition_no; ?></td>
    </tr>
    <?php }
    endif; ?>
</table>
<p align="center"><b>Total Quantity: <?php echo $totalqty; ?> 
Total Cost: <?php echo number_format($totalcost,2); ?> HKD</b></p>
<p align="center"><b>In Word: <?php echo number_to_word($totalcost); ?> HKD only.</b></p>

<html>