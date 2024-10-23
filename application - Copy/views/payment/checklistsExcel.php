  <?php 
$name="PA_LIST_".date('Y-m-dhi').".xls";
header('Content-Type: text/html; charset=utf-8');
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
  <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
<style type="text/css">
body{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
}
  @media print{
            .print{ display:none;}
            .approval_panel{ display:none;}
             .margin_top{ display:none;}
            .rowcolor{ background-color:#CCCCCC !important;}
            body {padding: 3px; font-size:12px}
        }
}
.tg  {border-collapse:collapse;
  border-spacing:0;width:120%}
.tg td{
  font-size:12px;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
  border-color: #000;
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
  border-color: #000;
  word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;
  vertical-align:top}
</style>
</head>
<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading))echo $heading; ?>  </b></h4>
       <h3 align="center" style="margin:0;padding: 5px">
       <b>Department: 
    <?php 
     echo $this->session->userdata('department_name'); 
      ?>
    </b></h3>

              <table class="tg">
                <thead>
    <tr>
      <th style="width:4%;">SN</th>
      <th style="width:7%;">Application NO</th>      
      <th style="width:8%;">Application Date</th>
      <th style="width:7%;">PA Type</th>
      <th style="width:15%;">Pay To Name</th>
      <th style="text-align:center;width:8%">
        Department</th>
      <th style="text-align:center;width:8%">
        Approved By</th>
      <th style="text-align:center;width:12%">
        Total Amount</th>
      <th style="width:8%;">Status 状态</th>
      <th style="width:10%;">Prep.By</th>
   
  </tr>
  </thead>
  <tbody>
  <?php
  if($lists&&!empty($lists)): $i=1;
    foreach($lists as $row):
    ?>
    <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td class="text-center"><?php echo $row->applications_no;?></td>
      <td class="text-center"><?php echo findDate($row->applications_date); ?></td>
      <td class="text-center"><?php echo $row->pa_type;?></td>
      <td class="text-center"><?php if($row->supplier_id==353) echo $row->other_name; 
      else echo $row->supplier_name; ?></td>
      <td class="text-center"><?php echo $row->department_name; ?></td>
      <td class="text-center"><?php echo $row->approved_by_name; ?></td>
      <td class="text-center"><?php echo $row->currency.' '.number_format($row->total_amount,2); ?></td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->status==1||$row->status==2||$row->status==8)?"danger":"success";?>">
        <?php 
        if($row->status==1) echo "Draft";
        elseif($row->status==2) echo "Pending";
        elseif($row->status==3) echo "Confirmed";
        elseif($row->status==4) echo "Verified";
        elseif($row->status==5) echo "Checked";
        elseif($row->status==6) echo "Approved";
        elseif($row->status==7) echo "Paid";
        elseif($row->status==8) echo "Rejected";
        ?>
      </span></td>
      <td class="text-center"><?php echo $row->user_name; ?></td>
    </tr>
    <?php
    endforeach;
  endif;
  ?>
              </tbody>
              </table>

<html>