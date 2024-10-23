  <?php 
$name="monthlystatement_".date('Y-m-dhi').".xls";
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
          <th style="text-align:center;width:5%;">SN</th>
          <th style="text-align:center;width:10%">Date</th>
          <th style="width:10%">ID NO</th>
          <th style="width:15%;">Name</th>
          <th style="text-align:center;width:5%">Male</th>
          <th style="text-align:center;width:7%">Section</th>
          <th style="text-align:center;width:8%">Description of <br> sickness</th>
          <th style="text-align:center;width:8%">Treatment</th>
          <th style="text-align:center;width:8%">Cost</th>
      </tr>
      </thead>
      <tbody>
      <?php $grandtotal=0; 
        if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
          foreach($resultdetail as $row):
            $grandtotal=$grandtotal+$row->cost;
            ?>
            <tr>
              <td style="text-align:center;">
                <?php echo $i++; ?></td>
              <td style="text-align:center;">
                <?php echo findDate($row->issue_date);  ?></td>
              <td style="text-align:center;">
                <?php echo "'$row->employee_id"; ?></td>
              <td><?php echo $row->employee_name;?></td>
              <td style="text-align:center;">
                <?php echo $row->sex;  ?></td> 
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "$row->location_name"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->symptoms_group; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->item_group; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo number_format($row->cost,2); ?></td>
            </tr>
            <?php
            endforeach;
        endif;
        ?>
        <tr>
            <th style="text-align:right;" colspan="8">Grand Total</th>
            <th style="text-align:center;"><?php echo $grandtotal; ?></th>
        </tr>
      </tbody>
 
</table>

<html>