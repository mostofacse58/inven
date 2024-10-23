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
  <tr>
      <th style="text-align:center;width:5%;">SN</th>
       <?php if($department_id=='All'){  ?>
      <th style="width:10%">Department</th>
      <?php } ?>
      <th style="text-align:center;width:10%">Date</th>
      <th style="text-align:center;width:10%">Gate Pass No</th>
      <th style="width:15%;">Item/Materials Name</th>
      <th style="text-align:center;width:8%">Out Qty</th>
      <th style="text-align:center;width:8%">In Qty</th>
      <th style="text-align:center;width:8%">Due Qty</th>
      <th style="text-align:center;width:15%">Issue To</th>
      <th style="text-align:center;width:10%">Carried Name(ID)</th>
      </tr>
     
      <?php $grandtotal=0;
              if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
                foreach($resultdetail as $row):
                  if($pendingstatus=='All'){
                    ?>
                  
                  <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <?php if($department_id=='All'){  ?>
                    <td style="text-align:center;">
                    <?php echo $row->department_name; ?></td>
                    <?php } ?>
                    <td style="text-align:center;">
                    <?php echo findDate($row->create_date); echo " $row->create_time"; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_name;  ?></td>  
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity-$row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->issue_to_name;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td>
                  </tr>
                <?php }elseif($pendingstatus=='Pending'&&$row->product_quantity>$row->qty){ ?>
                  <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <?php if($department_id=='All'){  ?>
                    <td style="text-align:center;">
                    <?php echo $row->department_name; ?></td>
                    <?php } ?>
                    <td style="text-align:center;">
                    <?php echo findDate($row->create_date); echo " $row->create_time"; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_name;  ?></td>  
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity-$row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->issue_to_name;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td>
                  </tr>
                  <?php }elseif($pendingstatus=='Done'&&$row->product_quantity==$row->qty){ ?>
                    <tr>
                    <td style="text-align:center;">
                    <?php echo $i++; ?></td>
                    <?php if($department_id=='All'){  ?>
                    <td style="text-align:center;">
                    <?php echo $row->department_name; ?></td>
                    <?php } ?>
                    <td style="text-align:center;">
                    <?php echo findDate($row->create_date); echo " $row->create_time"; ?></td>
                    <td ><?php echo $row->gatepass_no;?></td>
                    <td style="text-align:center;">
                      <?php echo $row->product_name;  ?></td>  
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->product_quantity-$row->qty;  ?></td>
                    <td style="text-align:center;">
                    <?php echo $row->issue_to_name;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center;">
                    <?php  echo "$row->carried_by ($row->employee_id)"; ?></td>
                  </tr>
                  <?php }
                  endforeach;
              endif;
              ?>
</table>
<br>
<p style="margin:0;text-align:center">
  Office: Road #6 House # 17 Floor #7 Sector#4,Uttara Dhaka  Factory: Uttara EPZ, Nilphamari Bangladesh                    
</p>
</table>

</body>
</html>