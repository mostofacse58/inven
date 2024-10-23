  <script src="<?php echo base_url(); ?>asset/js/print.js"></script>

   <script type="text/javascript">
      // When the document is ready, initialize the link so
      // that when it is clicked, the printable area of the
      // page will print.
      $(function(){
        // Hook up the print link.
        $(".prints").attr( "href", "javascript:void(0)");

        $(".prints").click(function(){
            // Print the DIV.
            $(".primary_area" ).print();
            // Cancel click event.
            return( false );
          });
      });
    </script>
  <style>
        
    @media print{
        .print{ display:none;}
        .approval_panel{ display:none;}
         .margin_top{ display:none;}
        .rowcolor{ background-color:#CCCCCC !important;}
        body {
          padding: 3px; 
          font-size:14px;
          
        }
    }
        .tg  {border-collapse:collapse;border-spacing:0;width: 100%}
.tg td{font-size:14px;font-weight: normal;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg th{text-align: left;font-size:14px;font-weight:bold;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:left}
.tg-s6z25{text-align:right;}
tbody{margin: 0;padding: 0}
.primary_area{
  background-color:#C4C4C4;
  background-image: radial-gradient(#fff 10%, transparent 10%),
  radial-gradient(#fff 10%, transparent 10%);
  background-size: 30px 30px;
  background-position: 0 0, 15px 15px;
  padding: 10px;

}

</style>
<div class="row">
  <div class="col-md-12">
   <div class="box box-info">
         <div class="box-header">
  <div class="widget-block">
    <div class="widget-head">
    <h5><i class="fa fa-eye"></i> 
      <?php echo ucwords($heading); ?>
    </h5>
    <div class="widget-control pull-right">

    </div>
    </div>
    </div>
</div>  
<div class="box-body">
  <div class="primary_area">

<?php $this->load->view('header',$info); ?>
 <p style="margin:0;text-align:center;font-size: 16px;">
  <b>GATE PASS (<?php if($info->gatepass_type==1) 
  echo "Material"; else echo "Finished Goods"; ?>)</b></p>
  <table style="width: 100%">
  <tr>
    <th class="tg-s6z2" style="width: 10%" valign="top">Issue to </th>
    <td class="tg-baqh" style="width: 60%" valign="top">: 
      <?php echo $info->issue_to_name; 
      if($info->address!='') echo "<br> $info->address";
       ?>
        
      </td>
    <th class="tg-s6z2" style="width: 30%;font-weight: 500; ">
      <?php if($info->gatepass_no != '' || $info->gatepass_no != NULL) 
    { echo '<img src="'.base_url('dashboard/barcode/'.$info->gatepass_no).'" alt="" />'; } ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2" >Date </th>
    <td class="tg-baqh" >: <?php echo findDate($info->create_date); echo " $info->create_time"; ?></td>
    <th class="tg-s6z2" >Carried Name(ID): <?php echo "$info->carried_by $info->employee_id" ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2">Department: </th>
    <td class="tg-baqh" ><?php echo $info->department_name; ?></td>
    <th class="tg-s6z2" >Note:<?php echo $info->gatepass_note; ?></th>
  </tr>
  </table>
  <!-- ///////////////////// -->
<br>
  <table class="tg" style="width: 100%">
  <tr>
    <th style="width:5%;text-align:center">SN</th>
    <th style="width:35%;text-align:center">Material/Product Name</th>
    <th style="width:8%;text-align:center">Quantity</th>
    <th style="width:8%;text-align:center">Unit</th>
    <th style="width:10%;text-align:center">Returnable</th>
    <th style="width:20%;text-align:center">Purpose</th>
  </tr>
  <?php
 if(isset($detail)){
$i=1; 
foreach($detail as $row){ 
?>
  <tr>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $i++;; ?></td>
  <td class="tg-baqh" ><?php echo $row->product_name; ?></td>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $row->product_quantity; ?></td>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $row->unit_name; ?></td>
  <td class="tg-baqh" style="text-align:center">
    <?php if($row->returnable==1) echo "NO"; else echo "YES"; ?></td>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $row->remarks; ?></td>
  </tr>
 <?php }} ?>
  </table>
  <br><br><br>
<table style="width:100%">
  <tr>
     <td style="width:50%;text-align:left">
      <?php if(isset($info)) echo $info->created_by; ?></td>
     <td style="width:50%;text-align:right">
      <?php if(isset($info)) echo $info->approved_by; echo findDate($info->approved_date); echo " $info->approved_time"; ?></td>
  </tr>
  <tr>
     <td style="text-align:left;font-size:15px;line-height:5px">
     ---------------------------------</td>
     <td style="text-align:right;font-size:15px;line-height:5px">
     --------------------------------</td>
  </tr>
  <tr>
  <td style="text-align:left">PREPARED BY</td>
  <td style="text-align:right">APPROVED BY</td>
  </tr>
</table>
<br>
<p style="margin:0;text-align:center">
  Office: Road #6 House # 17 Floor #7 Sector#4,Uttara Dhaka  Factory: Uttara EPZ, Nilphamari Bangladesh                    
</p>
  <!-- ///////////////////// -->

    </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-6"><a href="<?php echo base_url(); ?>gatep/gatepass/lists" class="btn btn-info"> <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
           <button class="btn btn-info prints"><i class="fa fa-print" ></i> Print</button>
         </div>
          </div>
             
          </div>
        </div>
        <!-- /.box-footer -->
    </div>
