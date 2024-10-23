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
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}

</style>
<br>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 18px;">
<p style="line-height: 27px;padding: 3px 10px;" >
  <b><i>Purchase Invoice
  </i></b></p>
</div>
<table style="width: 100%">
  <tr>
    <th style="width:20%;text-align: left" >Supplier Name 供应商名称:</th>
    <th style="width:40%;text-align: left" ><?php if(isset($info))echo $info->company_name; ?></th>
    <th style="width:20%;text-align: left" >PI NO:</th>
    <th style="width:20%;text-align: left" ><?php if(isset($info))echo $info->pi_no; ?></th>
  </tr>
  <tr>
    <th style="text-align: left" >Purchase Date:</th>
    <th style="text-align: left" ><?php if(isset($info)) echo findDate($info->purchase_date); ?></th>
    <th style="text-align: left" >Reference No:</th>
    <th style="text-align: left" ><?php if(isset($info)) echo $info->reference_no; ?></th>
  </tr>
</table>
<br>
<table class="tg">
  <tr>
    <th style="width:5%;text-align:center">SL</th>
    <th style="width:12%;text-align:center">Item CODE</th>
    <th style="width:17%;text-align:center">Item Name 项目名</th>
    <th style="width:25%;text-align:center">Description</th>
    <th style="width:10%;text-align:center;">Quantity</th>
    <th style="width:10%;text-align:center;">Unit Price</th>
    <th style="width:10%;text-align:center;">Amount</th>
    
  </tr>
 
  <?php
  if(isset($detail)){
	   $i=1; $totakqty=0;
	  foreach($detail as $value){ 
      $description="Material Type: $value->mtype_name";
        if($value->mdiameter!=''){
          $description=$description.", Diameter:$value->mdiameter";
        }
        if($value->mthread_count!=''){
          $description=$description.", Thread Count:$value->mthread_count";
        }
        if($value->mlength!=''){
          $description=$description.", Length:$value->mlength";
        }
        $totakqty=$totakqty+$value->quantity;
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
     <td class=""><?php echo $value->product_name; ?></td>
    <td class="textcenter"><?php echo $description; ?></td>
    <td class="tg-s6z2"><?php echo "$value->quantity $value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_price"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->amount"; ?></td>
  </tr>
   <?php }} ?>
   <tr>
    <th sty colspan="4"></th>
    <th style="text-align: right;" colspan="2">Total Amount:</th>
    <th class="tg-s6z2"><?php echo $info->grand_total; ?></th>
  </tr>
</table>
<p>Note: <?php echo $info->note; ?></p>
<br><br>
<table style="width:100%">
  <tr>
  <td style="width:33%;text-align:left;"></td>
  <td style="width:33%;text-align:center"><?php if(isset($info)) echo "$info->user_name"; ?></td>
  <td style="width:33%;text-align:right"></td>
  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Head of Dept.</td>
  <td style="text-align:center">Received By</td>
  <td style="text-align:right">Approved</td>
  </tr>

</table>

<html>