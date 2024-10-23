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
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{font-size:12px;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-size:12px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
</style>
</head>
<h4 align="center" style="margin:0;"><b> 
   <?php if(isset($heading))echo $heading; ?>  </b></h4>
<table class="tg">
  <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="width:10%">Ventura Code</th>
                <th style="text-align:center;width:7%">Serial No</th>
                <th style="width:15%;">Asset Name</th>
                <?php if($category_id=='All'){ ?>
                <th style="width:10%">Category</th>
                <?php } ?>
                <?php if($product_id=='All'){ ?>
                <th style="width:10%;text-align:center">Model NO</th>
                <?php } ?>
                <th style="text-align:center;width:7%">Location</th>
                <th style="text-align:center;width:10%">Department</th>
                <th style="text-align:center;width:10%">Employee</th>
                <th style="text-align:center;width:10%">Purchase Date</th>
                <th style="text-align:center;width:10%">Issue Date</th>
                <th style="text-align:center;width:10%">Price</th>
                <th style="text-align:center;width:6%">Status </th>
                <th style="text-align:center;width:10%">Note</th>
              </tr>
              </thead>
              <tbody>
              <?php  $totalprice=0;
              if(isset($resultdetail)&&!empty($resultdetail)): 
                $i=1;
                foreach($resultdetail as $row):
                  $totalprice=$totalprice+$row->machine_price;
                  if($row->issue_type==1){
                    $head_id=$row->head_id;
                    $empinfo=$this->db->query("SELECT * FROM employee_idcard_info e 
                      WHERE employee_cardno='$head_id' ")->row();
                    $row->employee_name=$empinfo->employee_name;
                    $row->employee_id=$head_id;
                  } ?>
                  <tr>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                      <?php echo $i++; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->ventura_code; ; ?></td>
                      <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->asset_encoding; ?></td>
                    <td style="background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>"><?php echo $row->product_name; 
                    if($row->ram_type!='') echo "<span color='red'> ($row->ram_type) <span>"; ?></td>
                    <?php if($category_id=='All'){ ?>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->category_name; ; ?></td>
                      <?php } ?>
                    <?php if($product_id=='All'){ ?>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->product_code;  ?></td> 
                      <?php } ?>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo "$row->mlocation_name($row->location_name)"; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php echo $row->department_name;  ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                     <?php if($row->employee_id!='') echo "$row->employee_name($row->employee_id)"; ?></td>
                     <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php  echo findDate($row->purchase_date); ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                    <?php  echo findDate($row->issue_date); ?></td>
                     <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                      <?php  echo "$row->machine_price $row->currency"; ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo CheckStatuspro($row->it_status); ?></td>
                    <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
                     <?php if($row->it_status==5) echo $row->despose_note; elseif($row->remarks!='') echo "$row->remarks"; else echo "$row->other_description";  ?></td>
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              <tr>
                <td colspan="10"> Total</td>
                <td style="text-align: right;"> <?php  echo number_format($totalprice,2); ?></td>
                <td></td>
                <td></td>
              </tr>
      </tbody>
 
</table>

<html>