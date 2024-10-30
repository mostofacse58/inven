<html>
<header>
<style type="text/css">
body {
  padding: 3px;
   font-size:12px;
   font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
    }
.tg  {border-collapse:collapse;border-spacing:0;width:150%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:4px 2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;text-transform: uppercase;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
hr{margin: 5px}

</style>
</header>
<body>
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:2px 0px;color: #538FD4">
<b> <?php echo  $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 3px 5px;font-size: 18px" >
  <b><u> MATERIAL REQUISITION SLIP</u></b></p>
</div>
<hr style="margin-top: 0px;">
<table style="width: 100%">
  <tr>
    <th style="width:50%;text-align: left" > 
      Name : <?php if(isset($info)) echo "$info->employee_name $info->employee_id"; ?></th>
    <th style="width:25%;text-align: left" > 
      SL. No: <?php if(isset($info)) echo $info->requisition_no; ?> </th>
    </tr>
    <tr>
    <th style="text-align: left" > 
      Department: <?php if(isset($info)) echo $info->department_name; ?> </th>
    <th style="text-align: left" > 
     Date日期 : <?php if(isset($info)) echo findDate($info->requisition_date); ?></th>
    </tr>
    <tr>
    <th style="text-align: left" > 
      Demand Date: <?php if(isset($info)) echo  findDate($info->demand_date); ?> 
    </th>
    <th style="text-align: left" > 
     Note : <?php if(isset($info)) echo $info->other_note; ?></th>
  </tr>
  <tr>
    <th style="text-align: left" > 
      Location : <?php if(isset($info)) echo  $info->location_name; ?> 
    </th>
    <th style="text-align: left" > 
      File No: <?php if(isset($info)) echo  $info->file_no; ?> 
    </th>
  </tr>
</table>
<br>
<table class="tg">
  <tr>
    <th style="width:3%;text-align:center">SN</th>
    <th style="width:8%;text-align:center">Item code</th>
    <th style="width:15%;text-align:center">Materials Description</th>
    <th style="width:8%;text-align:center">Spacification</th>
    <th style="width:7%;text-align:center;">Unit</th>
    <th style="width:7%;text-align:center;">Colour</th>
    <th style="width:7%;text-align:center;">Req. Qty</th>
    <th style="width:7%;text-align:center;">Issued Qty</th>
    <th style="width:12%;text-align:center;">Remarks</th>
  </tr>
  <?php
  if(isset($detail)){
	   $i=1; 
	  foreach($detail as $value){ 
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class="tg-s6z2"><?php echo "$value->specification"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
    <td class="tg-s6z2"></td>
    <td class="tg-s6z2"><?php echo "$value->required_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->issued_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->remarks"; ?></td>
  </tr>
   <?php }
 } ?>
</table>
<br><br>
<table style="width:100%">
  <tr>
  <td style="width:25%;text-align:left;">
    <?php if(isset($info)) echo "$info->requested_by"; ?></td>
  <td style="width:25%;text-align:center">
    <?php if($info->requisition_status>2) echo "$info->dept_head"; ?></td>
  <td style="width:25%;text-align:center"><?php if($info->requisition_status>3) echo "$info->approved_by"; ?></td>
  <td style="width:25%;text-align:right">
    <?php if($info->requisition_status>3) echo "$info->approved_by"; ?></td>
  </tr>
  <tr>
  <td style="width:25%;text-align:left;">
    <?php if(isset($info)) echo $info->submited_date_time; ?></td>
  <td style="width:25%;text-align:center">
    <?php if($info->requisition_status>2) echo "$info->aproved_date_time"; ?></td>
  <td style="width:25%;text-align:center"><?php if($info->requisition_status>3) echo $info->delivery_date; ?></td>
  <td style="width:25%;text-align:right">
    <?php if($info->requisition_status>3) echo $info->delivery_date; ?></td>
  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">-------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">-------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">--------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">--------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">PREPARED BY</td>
  <td style="text-align:center">HEAD OF DEPARTMENT</td>
  <td style="text-align:center">RECEIVED BY</td>
  <td style="text-align:right">DELIVERED BY</td>
  </tr>

</table>
</body>
<html>