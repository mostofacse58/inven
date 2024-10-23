  <?php 
$name="Supplier_Wise_Report_".date('Y-m-dhi').".xls";
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
   <?php if($department_id!='All'){  ?>
       <h3 align="center" style="margin:0;padding: 5px">
       <b>Department: 
    <?php 
     $department_name=$this->db->query("SELECT * FROM department_info 
      WHERE department_id=$department_id")->row('department_name'); 
     echo "$department_name";
      ?>
    </b></h3>
  <?php } 
   ?>
   <?php if($supplier_id!='All'){  ?>
       <h3 align="center" style="margin:0;padding: 5px">
       <b>Supplier: 
    <?php 
     $supplier_name=$this->db->query("SELECT * FROM supplier_info 
      WHERE supplier_id=$supplier_id")->row('supplier_name'); 
     echo "$supplier_name";
      ?>
    </b></h3>
  <?php } 
   ?>
   <?php if($from_date!=''){  ?>
     <h4 align="center" style="margin:0;padding: 5px">
     <b>
  From Date: <?php echo date("jS M-Y", strtotime("$from_date")); ?>
    &nbsp;&nbsp;&nbsp;&nbsp; To Date: <?php echo date("jS M-Y", strtotime("$to_date"));  ?>
  </b></h4>
  <?php } ?>
<table class="tg">
                <thead>
              <tr>
              <th style="text-align:center;width:5%;">SN</th>
              <th style="width:8%">From Department</th>
              <th style="text-align:center;width:8%">Date</th>
              <th style="text-align:center;width:8%">PA No</th>
              <th style="text-align:center;width:15%">Supplier</th>
              <th style="text-align:center;width:8%">Description</th>
              <th style="width:8%;">Amount</th>
              <th style="text-align:center;width:15%">Department</th>
              <th style="width:8%;">Payment Term</th>
              <th style="text-align:center;width:10%">Remarks</th>
              </tr>
              </thead>
              <tbody>
              <?php 
              $grandtotal=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  $grandtotal=$grandtotal+$row->amount;
                  ?>
                  <tr>
                    <td style="text-align:center;"><?php echo $i++; ?></td>
                    <td style="text-align:center;"><?php echo $row->department_name; ?></td>
                    <td style="text-align:center;">
                    <?php echo findDate($row->applications_date); ?></td>
                    <td style="text-align:center;"><?php echo $row->applications_no;?></td>
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo $row->supplier_name;  ?></td> 
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo $row->head_name;  ?></td> 
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo number_format($row->amount,2);  ?></td>  
                    <td style="text-align:center;word-break: break-all;">
                    <?php echo $row->dcode_group;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->pay_term;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->remarks;  ?></td>
                  </tr>
                  <?php
                  endforeach;
                endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="6">Total</th>
                  <th style="text-align:center;">
                    <?php echo number_format($grandtotal,2); ?></th>
                  <th></th>
                  <th></th>
                  <th></th>
              </tr>
              </tbody>
              </table>

<html>