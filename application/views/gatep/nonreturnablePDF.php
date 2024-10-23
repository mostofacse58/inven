  <?php 
$name="GatepassReport_".date('Y-m-dhi').".xls";
header("Content-type: application/octet-stream");
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<style type="text/css">
   @media print{
    .print{ display:none;}
    .approval_panel{ display:none;}
     .margin_top{ display:none;}
    .rowcolor{ background-color:#CCCCCC !important;}
    body {
      font-size:14px;
      padding: 3px;
     }
    }
  .tg  {border-collapse:collapse;border-spacing:0;width: 100%}
.tg td{font-size:14px;font-weight: normal;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg th{text-align: left;font-size:14px;font-weight:bold;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:left}
.tg-s6z25{text-align:right;}
tbody{margin: 0;
  padding: 0}
.primary_area1{
  background-color: #fff;
  border-top: 5px dotted #000;
  border-bottom: 5px dotted #000;
  box-shadow: inset 0 -2px 0 0 #000, inset 0 2px 0 0 #000, 0 2px 0 0 #000, 0 -2px 0 0 #000;
  margin-bottom: 1px;
  padding: 10px;
  border-left: 5px;
  border-right: 5px;
  border-left-style:double ;
  border-right-style:double;
  padding-top:0px;

}
</style>
<body>
  <br>
<?php if($department_id!='All'){  ?>
     <h3 align="center" style="margin:0;padding: 5px">
     <b>Department: 
  <?php 
   $department_name=$this->db->query("SELECT * FROM department_info 
    WHERE department_id=$department_id")->row('department_name'); echo "$department_name";
    ?>
  </b></h3>
  <?php } ?>
   <?php if($from_date!=''){  ?>
     <h4 align="center" style="margin:0;padding: 5px">
     <b>
  From Date: <?php echo date("jS M-Y", strtotime("$from_date")); ?>
    &nbsp;&nbsp;&nbsp;&nbsp; To Date: <?php echo date("jS M-Y", strtotime("$to_date"));  ?>
  </b></h4>
  <?php } ?>
  <!-- ///////////////////// -->
<br>
  <table class="tg" style="width: 100%">
    <thead>
              <tr>
              <th style="text-align:center;width:5%;">SN</th>
              <th style="width:8%">Department</th>
              <th style="text-align:center;width:8%">Date</th>
              <th style="text-align:center;width:8%">Gate Pass No</th>
              <th style="text-align:center;width:8%">From</th>
              <th style="text-align:center;width:8%">Issue To</th>

              <th style="text-align:center;width:8%">
                <?php if($gatepass_type==3) echo "File No"; else echo "Matrial Code"; ?></th>
              <th style="width:15%;">Item/Materials Name</th>
              <th style="text-align:center;width:8%">Out Qty</th>
              <th style="text-align:center;width:5%">Unit</th>
               <?php if($gatepass_type==3){ ?>
               <th style="width:10%;text-align:center">PO No</th>
               <th style="width:10%;text-align:center">Carton No</th>
               <th style="width:10%;text-align:center">Bag Qty</th>
               <th style="width:10%;text-align:center">Invoice No</th>
              <?php } ?>
              <th style="text-align:center;width:10%">Carried Name(ID)</th>
              </tr>
              </thead>
              <tbody>
              <?php 
              $grandtotal=0;
              $bagtotal=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  $bagtotal=$bagtotal+$row->bag_qty;
                  $grandtotal=$grandtotal+$row->product_quantity;

                    ?>
                  <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->department_name; ?></td>
                    <td style="text-align:center;">
                    <?php echo findDate($row->create_date);
                     echo " $row->create_time"; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->issue_from;  ?></td> 
                      <td style="text-align:center;">
                      <?php if($row->wh_whare=='OTHER') 
                      echo $row->issue_to_name; 
                      else echo $row->wh_whare;  ?></td> 
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="text-align:center;word-break: break-all;">
                      <?php echo $row->product_name;  ?></td>  
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->unit_name;  ?></td>
                    <?php if($gatepass_type==3){ ?>
                    <td class="tg-baqh" style="text-align:center">
                        <?php echo $row->po_no; ?></td>
                    <td class="tg-baqh" style="text-align:center">
                        <?php echo $row->carton_no; ?></td>
                    <td class="tg-baqh" style="text-align:center">
                      <?php echo $row->bag_qty; ?></td>
                    <td class="tg-baqh" style="text-align:center">
                      <?php echo $row->invoice_no; ?></td>
                    <?php } ?>
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td>
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              <tr>
                  <th style="text-align:right;" colspan="7">Total</th>
                  <th style="text-align:center;width:10%"><?php echo $grandtotal; ?></th>
                  <?php if($gatepass_type==3){ ?>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><?php echo $bagtotal; ?></th>
                  <?php } ?>
                  <th></th>
                  <th></th>
                  
              </tr>
              </tbody>
              </table>
              </table>
<br>
<p style="margin:0;text-align:center">
  Office: Road #6 House # 17 Floor #7 Sector#4,Uttara Dhaka  Factory: Uttara EPZ, Nilphamari Bangladesh                    
</p>
</table>

</body>
</html>