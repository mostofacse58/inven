<html>
<style type="text/css">
  @media print{
    .print{ display:none;}
    .approval_panel{ display:none;}
     .margin_top{ display:none;}
    .rowcolor{ background-color:#CCCCCC !important;}
    body {padding: 3px; font-size:14px}
}
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}

</style>
<br>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 12px;">
<p style="line-height: 27px;padding:5px;margin-bottom: 0px;padding-bottom: 0px;font-size: 15px" >
  <b><i> Material Receive Form <?php if($info->grn_type==1) echo "GRN"; else echo "Extra GRN"; ?>
  </i></b></p>
</div>
<table style="width: 100%">
   <tr>
    <th style="text-align: left;width: 15%">Supplier:</th>
    <th style="text-align: left;width: 50%">
      <?php  echo "$info->supplier_name"; ?></th>
    <th style="text-align: left;width: 15%">PO NO:</th>
    <th style="text-align: left;width: 20%">
      <?php if(isset($info)) echo $info->po_number; ?>
    </th>
  </tr>
   <tr>
    <th style="text-align: left">Ref. No: </th>
    <th style="text-align: left">
      <?php if(isset($info)) echo $info->reference_no; ?></th>
    <th style="text-align: left">Receive Date: </th>
    <th style="text-align: left"><?php if(isset($info)) echo findDate($info->purchase_date); ?></th>
  </tr>
  <tr>
    <th style="text-align: left" >Currency: </th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->currency; ?></th>
    <th style="text-align: left" >Currency Rate HKD: </th>
    <th style="text-align: left" ><?php if(isset($info)) echo $info->cnc_rate_in_hkd; ?></th>
  </tr>
   <tr>
    <th style="text-align: left" >FILE: </th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->file_no; ?></th>
    <th style="text-align: left" >Invoice No: </th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->invoice_no; ?></th>
  </tr>

</table>
<br>
<table class="tg">
  <tr>
    <th style="width:3%;text-align:center">SL</th>
    <th style="width:10%;text-align:center">Item Code</th>
    <th style="width:15%;text-align:center">Item Name 项目名</th>
    <th style="width:10%;text-align:center">Specification</th>
    <th style="width:10%;text-align:center;">PI NO</th>
    <th style="width:10%;text-align:center;">FIFO CODE</th>
    <th style="width:6%;text-align:center;">Q. Qty</th>
    <th style="width:6%;text-align:center;">Unq. Qty</th>
    <th style="width:8%;text-align:center;">Unit</th>
    <th style="width:10%;text-align:center;">Unit Price</th>
    <th style="width:10%;text-align:center;">Sub-Total</th>
  </tr>
  <?php
  if(isset($detail)){
	   $i=1; $totakqty=0; $unqualifiedqty=0;
	  foreach($detail as $value){ 
       $totakqty=$totakqty+$value->quantity;
       $unqualifiedqty=$unqualifiedqty+$value->unqualified_qty;
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class="textcenter"><?php echo $value->specification; ?></td>
    <td class="tg-s6z2"><?php echo "$value->pi_no"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->FIFO_CODE"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->quantity"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unqualified_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->currency $value->unit_price"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->amount"; ?></td>
  </tr>
   <?php }} ?>
   <tr>
    <th style="text-align: right;" colspan="6">Total Quantity:</th>
    <th class="tg-s6z2"><?php echo "$totakqty"; ?></th>
    <th class="tg-s6z2"><?php echo "$unqualifiedqty"; ?></th>
    <th></th>
    <th></th>
    <th class="tg-s6z2"><?php if(isset($info)) echo $info->grand_total; ?></th>
  </tr>
 
</table>
<br><br>
<p>Note:<?php if(isset($info)) echo $info->note; ?></p>
<br>
<table style="width:100%">
  <tr>
  <td style="width:33%;text-align:left"><?php if(isset($info)) echo "$info->user_name"; ?></td>
  <td style="width:33%;text-align:center">
    <?php if(isset($info)) {
    echo "$info->received_by_name<br>";
    echo findDate($info->received_date);
  } 
    ?>
  </td>
  <td style="width:33%;text-align:center"></td>
  <?php if(isset($info)) {
    echo "$info->received_by_name<br>";
    echo findDate($info->received_date);
  } 
    ?>
  <td style="width:33%;text-align:right"></td>
  </tr>
  <tr>
  <td style="width:33%;text-align:left;font-size: 15px;line-height: 5px">-----------------</td>
  <td style="width:33%;text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="width:33%;text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left">Received By</td>
  <td style="text-align:center">Received By</td>
  <td style="text-align:right">Approved</td>
  </tr>

</table>

<html>