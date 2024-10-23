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
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 12px;">
<p style="line-height: 27px;padding: 10px 10px;margin-bottom: 0px;padding-bottom: 0px" >
  <b><i> Material Using Form 
  </i></b></p>
</div>
<table style="width: 100%">
  <tr>
    <?php if($info->use_type==1){ ?>
    <th style="width:15%;text-align: left" >Machine Name:</th>
    <th style="width:40%;text-align: left" ><?php if(isset($info))echo $info->product_name; ?></th>
    <th style="width:20%;text-align: left" >TPM CODE (TPM代码):</th>
    <th style="width:25%;text-align: left" ><?php if(isset($info))echo $info->tpm_serial_code; ?></th>
    <?php }else{  ?>
    <th style="text-align: left" valign="top">Purpose:</th>
    <th style="text-align: left" colspan="3"><?php if(isset($info))echo $info->use_purpose; ?></th>
    <?php } ?>
  </tr>
  <tr>
    <th style="text-align: left" >Line No:</th>
    <th style="text-align: left" ><?php if(isset($info)) echo $info->line_no; ?></th>
    <th style="text-align: left" >Specification:</th>
    <th style="text-align: left" ><?php if(isset($info)) echo $info->product_code; ?></th>
  </tr>
   <tr>
    <th style="text-align: left" >Requisition No: </th>
    <th style="text-align: left" ><?php if(isset($info)) echo $info->requsition_no; ?></th>
    <th style="text-align: left" >Date: </th>
    <th style="text-align: left" ><?php if(isset($info)) echo findDate($info->use_date); ?></th>
  </tr>
</table>
<br>
<table class="tg">
  <tr>
    <th style="width:5%;text-align:center">SL</th>
    <th style="width:10%;text-align:center">Item Code 项目代码</th>
    <th style="width:15%;text-align:center">Item Name</th>
    <th style="width:12%;text-align:center">Specification</th>
    <th style="width:10%;text-align:center">FIFO CODE</th>
    <th style="width:8%;text-align:center;">Issued Qty</th>
    <th style="width:8%;text-align:center;">Unit</th>
    <th style="width:8%;text-align:center;">Unit Price</th>
    <th style="width:8%;text-align:center;">Amount</th>
    <th style="width:8%;text-align:center;">Currency</th>
    <th style="width:8%;text-align:center;">Rate HKD</th>
  </tr>
 
  <?php
  if(isset($detail)){
	   $i=1; $totakqty=0; $totakamount=0;
	  foreach($detail as $value){ 
      // $description="Material Type: $value->mtype_name";
      //   if($value->mdiameter!=''){
      //     $description=$description.", Diameter:$value->mdiameter";
      //   }
      //   if($value->mthread_count!=''){
      //     $description=$description.", Thread Count:$value->mthread_count";
      //   }
      //   if($value->mlength!=''){
      //     $description=$description.", Length:$value->mlength";
      //   }
        $totakamount=$totakamount+$value->amount;
        $totakqty=$totakqty+$value->quantity;
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class=""><?php echo $value->specification; ?></td>
    <td class="textcenter"><?php echo $value->FIFO_CODE; ?></td>
    <td class="tg-s6z2"><?php echo "$value->quantity"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_price"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->amount"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->currency"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->cnc_rate_in_hkd"; ?></td>
  </tr>
   <?php }} ?>
   <tr>
    <th style="text-align: right;" colspan="5">Total Quantity:</th>
    <th class="tg-s6z2"><?php echo "$totakqty"; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"><?php echo "$totakamount"; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
  </tr>
 
</table>
<br><br><br>
<table style="width:100%">
  <tr>
  <td style="width:25%;text-align:left"><?php if(isset($info)) echo "$info->user_name"; ?></td>
  <td style="width:25%;text-align:center"></td>
  <td style="width:25%;text-align:center">
    <?php if(isset($info)) echo "$info->me_name $info->other_id"; ?></td>
  <td style="width:25%;text-align:right"></td>
  </tr>
  <tr>
  <td style="width:25%;text-align:left;font-size: 15px;line-height: 5px">-----------------</td>
  <td style="width:25%;text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="width:25%;text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="width:25%;text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left">Prepared By</td>
  <td style="text-align:center">Head of Dept.</td>
  <td style="text-align:center">Received By</td>
  <td style="text-align:right">Approved</td>
  </tr>

</table>

<html>