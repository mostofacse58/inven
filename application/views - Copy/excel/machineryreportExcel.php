  <?php 
$name="MachineryReport_".date('Y-m-dhi').".xls";
 header("Pragma: public");
    header("Expires: 0");
// header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: text/html; charset=utf-8");
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Content-Transfer-Encoding: binary");
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
  border-spacing:0;width:120%}
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
        <th style="width:10%">Ventura Code</th>
        <th style="width:15%;">Machine Name</th>
        <th style="width:10%;">China <br> Name</th>
        <?php if($category_id=='All'){ ?>
        <th style="width:10%">Category</th>
        <?php } ?>
        <?php if($product_id=='All'){ ?>
        <th style="width:10%;text-align:center">Model NO</th>
        <?php } ?>
        <th style="text-align:center;width:7%">C. Location</th>
        <th style="text-align:center;width:10%">Machine <br> Type</th>
        <th style="text-align:center;width:7%">TPM CODE (TPM代码)</th>
        <th style="text-align:center;width:10%">Status 状态</th>
        <th style="text-align:center;width:6%">D. Status 状态</th>
        <th style="text-align:center;width:10%">Invoice No</th>
        <th style="text-align:center;width:8%">Price</th>
        <th style="text-align:center;width:8%">Purchase Date</th>
        <th style="text-align:center;width:8%">Assign Date</th>
      </tr>
      </thead>
      <tbody>
      <?php
      if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
        foreach($resultdetail as $row):
            ?>
          <tr>
            <td style="text-align:center">
              <?php echo $i++; ?></td>
            <td style="text-align:center">
              <?php echo $row->ventura_code; ; ?></td>
            <td><?php echo $row->product_name;?></td>
            <td><?php echo $row->china_name;?></td>
            <?php if($category_id=='All'){ ?>
            <td style="text-align:center;text-align: center;">
              <?php echo $row->category_name; ; ?></td>
              <?php } ?>
            <?php if($product_id=='All'){ ?>
            <td style="text-align:center;text-align: center;">
              <?php echo $row->product_code;  ?></td> 
              <?php } ?>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->line_no; ?></td>
            <td style="text-align:center">
            <?php echo $row->machine_type_name;  ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->tpm_serial_code; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
              <?php  echo CheckStatus($row->machine_status); ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo CheckDeactiveStatus($row->deactive_status); ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->invoice_no; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo $row->machine_price; ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo findDate($row->purchase_date); ?></td>
            <td style="vertical-align: text-top;text-align: center;">
            <?php  echo findDate($row->assign_date); ?></td>
            
          </tr>
          <?php
          endforeach;
      endif;
      ?>
      </tbody>
 
</table>

<html>