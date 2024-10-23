  <?php 
$name="AuditReport_all _".date('Y-m-dhi').".xls";
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">

body{
  font-family: Arial, Helvetica, 宋体, SimSun, 华文细黑, STXihei, sans-serif;
}
.tg  {border-collapse:collapse;border-spacing:0;width:200%;
font-family: Arial, Helvetica, 宋体, SimSun, 华文细黑, STXihei, sans-serif;}
.tg td{font-size:14px;padding:5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
  font-family: Arial, Helvetica, 宋体, SimSun, 华文细黑, STXihei, sans-serif;
.tg th{font-size:14px;font-weight:normal;padding:5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;font-family: Arial, Helvetica, 宋体, SimSun, 华文细黑, STXihei, sans-serif;}
.tg .tg-jgvo{font-weight:bold;font-size:18px;background-color:#F7CAAC;text-align:center}
.tg .tg-s6z2{text-align:center;background-color: #FFF;vertical-align:top;}
.tg .tg-s6z2h{text-align:center;background-color: #000;color: #FFF}
.tg .tg-baqh{text-align:center;vertical-align:top;background-color: #FFE8D1}
.tg .tg-031e{text-align:left;background-color: #FFF;vertical-align:top;}
.tg .tg-wm6t{font-weight:bold;font-size:16px;background-color: #FFE8D1}
.tg .tg-ges6{font-weight:bold;font-size:15px;background-color: #FFE8D1}
</style>
</head>
<body>
<div  style="width:100%;float:left;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
	<p style="margin:0px;font-size: 30px;color: #4472C4;"><b> Ventura BD</b></p>
<p style="margin:0px;font-size: 30px">
<?php echo $info->department_name; ?> Audit Package <?php echo $info->year; ?>
</p>
</div>

<br>
<table class="tg" id="">
<thead>
  <tr>
  <th style="width:8%;text-align:center;color: #2B579A;font-size: 16px" rowspan="2">Head </th>
  <th style="text-align:center;color: #2B579A;width: 8%" valign="top" rowspan="2">
   Sub-Head
 </th>
  <th style="text-align:center;color: #2B579A;width: 6%" valign="top" rowspan="2">
   Weight  
 </th>
 <th style="width:66%;text-align:center;color: #2B579A;font-size: 16px" colspan="5">Assessment Criteria</th>
 <th style="width:10%;text-align:center;color: #2B579A;font-size: 16px" colspan="2" >1st Quater Result</th>
 <th style="width:10%;text-align:center;color: #2B579A;font-size: 16px" colspan="2" >2nd Quater Result</th>
 <th style="width:10%;text-align:center;color: #2B579A;font-size: 16px" colspan="2" >3rd Quater Result</th>
 <th style="width:10%;text-align:center;color: #2B579A;font-size: 16px" colspan="2" >4th Quater Result</th>
 <th style="width:10%;text-align:center;color: #2B579A;font-size: 16px" colspan="2" >Yearly Audit  Result</th>
</tr>
<tr>
  <th style="width:22%;text-align:center;color: #2B579A;font-size: 16px">5</th>
  <th style="width:22%;text-align:center;color: #2B579A;font-size: 16px">4</th>
  <th style="width:22%;text-align:center;color: #2B579A;font-size: 16px">3</th>
  <th style="width:22%;text-align:center;color: #2B579A;font-size: 16px">2</th>
  <th style="width:22%;text-align:center;color: #2B579A;font-size: 16px">1</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">Score</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">%</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">Score</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">%</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">Score</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">%</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">Score</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">%</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">Score</th>
  <th style="width:5%;text-align:center;color: #2B579A;font-size: 16px">%</th>
</tr>
<tr>
</thead>
<tbody>
  <?php if(isset($info)){
    foreach ($hlist as  $value) { 
      $rowcheck=1;
  $plist=$this->self_model->getPakage($value->head_id,$info->year,$info->acategory,$info->department_id);
  foreach ($plist as  $rows) { 
 ?>
 <tr>
  <?php if($rowcheck==1){ ?>
  <td rowspan="<?php echo $value->rowspan; ?>" style="text-align:center;vertical-align: middle;">
    <?php   echo $value->head_name; ?> </td>
  <?php } ?>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->sub_head_name;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->weight;  ?> %
  </td>
<td style="vertical-align: top;"><?php  echo nl2br($rows->criteria_1); ?> </td>
  <td></td>
  <td style="vertical-align: top;"><?php echo nl2br($rows->criteria_2); ?> </td>
  <td></td>
  <td style="vertical-align: top;"><?php  echo nl2br($rows->criteria_3); ?> </td>
  <td style="text-align:center;vertical-align: top;">
    <?php echo $rows->score1;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->weight/5*$rows->score1;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->score2;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->weight/5*$rows->score2;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->score3;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->weight/5*$rows->score3;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->score4;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->weight/5*$rows->score4;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->score5;  ?>
  </td>
  <td style="text-align:center;vertical-align: middle;">
    <?php echo $rows->weight/5*$rows->score5;  ?>
  </td>

  
</tr>
<?php 
$rowcheck++;
} }  }
?>

</tbody>
</table>

</body>
</html>