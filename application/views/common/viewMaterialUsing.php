<html>
<meta charset="UTF-8">

<style type="text/css">
  @media print{
            .print{ display:none;}
            .approval_panel{ display:none;}
             .margin_top{ display:none;}
            .rowcolor{ background-color:#CCCCCC !important;}
            body {padding: 3px; font-size:12px}
        }
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}

</style>
<br>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 12px;">
<p style="line-height: 27px;padding: 10px 10px;margin-bottom: 0px;padding-bottom: 0px" >
  <b><i> Material Issue Form (<?php if(isset($info))echo $info->from_department_name; ?>)
  </i></b></p>
</div>
<table style="width: 100%">
  <tr>
    <th style="width:15%;text-align: left" >For:</th>
    <th style="width:40%;text-align: left" >
      <?php if($info->issue_type==1) echo "Department"; else echo "Employee"; ?></th>
    <th style="width:15%;text-align: left" >Department:</th>
    <th style="width:30%;text-align: left" >
      <?php if(isset($info))echo $info->department_name; ?></th>
  </tr>
  <tr>
    <th style="text-align: left" >Employee:</th>
    <th style="text-align: left" >
      <?php if($info->issue_type==2) 
      echo "$info->employee_name($info->employee_id)";?></th>
    <th style="text-align: left" >Purpose:</th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->issue_purpose; ?></th>
  </tr>
   <tr>
    <th style="text-align: left" >Requisition No: </th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->requisition_no; ?></th>
    <th style="text-align: left" >Date: </th>
    <th style="text-align: left" ><?php if(isset($info)) echo findDate($info->issue_date); ?></th>
  </tr>
  <?php if($info->product_detail_id!=''){ ?>
  <tr>
    <th style="text-align: left">Asset Name: </th>
    <th style="text-align: left" colspan="3">
      <?php if(isset($info)) echo $this->look_up_model->get_ProductnameSerial($info->product_detail_id); ?></th>
  </tr>
<?php } ?>
</table>
<br>
<table class="tg">
  <tr>
    <th style="width:5%;text-align:center">SL</th>
    <th style="width:12%;text-align:center">Item Code</th>
    <th style="width:15%;text-align:center">Item Name 项目名</th>
    <th style="width:10%;text-align:center">Specification</th>
    <th style="width:10%;text-align:center;">FIFO CODE</th>
    <th style="width:8%;text-align:center;">Issued Qty</th>
    <th style="width:8%;text-align:center;">Unit Price</th>
    <th style="width:10%;text-align:center;">Amount</th>
    <th style="width:6%;text-align:center;">Currency</th>
    <th style="width:8%;text-align:center;">Rate HKD</th>
  </tr>
 
  <?php
  if(isset($detail)){
	   $i=1; $totalqty=0;
     $totalamount=0;
	  foreach($detail as $value){ 
      $description="Category: $value->category_name";
       $totalqty=$totalqty+$value->quantity;
       $totalamount=$totalamount+$value->sub_total;
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class=""><?php echo $value->specification; ?></td>
    <td class="tg-s6z2"><?php echo "$value->FIFO_CODE"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->quantity $value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_price"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->sub_total"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->currency"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->cnc_rate_in_hkd"; ?></td>

  </tr>
   <?php }} ?>
   <tr>
    <th style="text-align: right;" colspan="4">Total:</th>
    <th class="tg-s6z2"><?php echo "$totalqty"; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"><?php echo "$totalamount"; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
  </tr>
 
</table>
<br><br><br>
<table style="width:100%">
  <tr>
  <td style="width:25%;text-align:left">
  <?php if(isset($info)) {
    echo "$info->user_name<br>";
    echo findDate($info->issue_date);
  } 
    ?></td>
  <td style="width:25%;text-align:center">
    <?php if(isset($info)) {
    echo "$info->received_by_name<br>";
    echo findDate($info->received_date);
  } 
    ?></td>
  <td style="width:25%;text-align:center">
    <?php if(isset($info)) {
    echo "$info->received_by_name<br>";
    echo findDate($info->received_date);
  } 
    ?></td>
  <td style="width:25%;text-align:right"></td>
  </tr>
  <tr>
  <td style="width:25%;text-align:left;font-size: 15px;line-height: 5px">-----------------</td>
  <td style="width:25%;text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="width:25%;text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="width:25%;text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left">Issued By</td>
  <td style="text-align:center">Head of Dept.</td>
  <td style="text-align:center">Received By</td>
  <td style="text-align:right">Approved</td>
  </tr>

</table>

<html>