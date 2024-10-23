  <?php 
$name="FixedAssetReport_".date('Y-m-dhi').".xls";
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
<table class="tg">
  <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="width:10%">Ventura Code</th>
                <th style="text-align:center;width:6%">Serial No</th>
                <th style="width:15%;">Asset Name</th>
                <?php if($category_id=='All'){ ?>
                <th style="width:10%">Category</th>
                <?php } ?>
                <?php if($product_id=='All'){ ?>
                <th style="width:10%;text-align:center">Model NO</th>
                <?php } ?>
                <th style="text-align:center;width:10%">Purchase Date</th>
                <th style="text-align:center;width:7%">Location</th>
                <th style="text-align:center;width:10%">Department</th>
                <th style="text-align:center;width:10%">Employee</th>
                <th style="text-align:center;width:10%">Status 状态</th>
                <th style="text-align:center;width:10%">Note</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if(isset($resultdetail)&&!empty($resultdetail)): 
                $i=1;
                foreach($resultdetail as $row):
                    ?>
                  <tr>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2) 
                          echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $i++; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->ventura_code; ; ?></td>
                      <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->asset_encoding; ?></td>
                    <td style="background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>"><?php echo $row->product_name;
                    if($row->ram_type!='') echo "($row->ram_type)"; ?></td>
                    <?php if($category_id=='All'){ ?>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->category_name; ; ?></td>
                      <?php } ?>
                    <?php if($product_id=='All'){ ?>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->product_code;  ?></td> 
                      <?php } ?>
                       <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php echo findDate3($row->purchase_date);  ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->location_name; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php echo $row->department_name;  ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                     <?php if($row->employee_id!='') echo "$row->employee_name($row->employee_id)"; ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo CheckStatus($row->it_status); ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php echo "$row->other_description, $row->remarks";  ?></td>                   
             
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
      </tbody>
 
</table>

<html>