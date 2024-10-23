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

  var url1="<?php echo base_url(); ?>gatep/merapproval/lists";
  $(document).ready(function() {
    ////////////////////////////////
    $("#addNewTeam").click(function(){
    var reject_note = $("#reject_note").val();
    var error = 0;
   
    if(reject_note==""){
      $("#reject_note").css({"border-color":"red"});
      $("#reject_note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#reject_note").css({"border-color":"#ccc"});
      });
      error=1;
    }
   
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }

  });
    ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".reject").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
     $("#gatepass_id").val(rowId);
     $("#TeamModal").modal("show");
  });
});
    </script>
  <style>
        
    @media print{
    .print{ display:none;}
    .merapproval_panel{ display:none;}
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
<div class="primary_area1">
<?php //$this->load->view('header',$info); ?>

<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 15px;">
<p style="margin:2px 0px;color: #538FD4">
<b> Ventura Leatherware Mfy (BD) Ltd.</b></p>
</div>
<div style="width:100%;overflow:hidden;font-size: 18px;color: #000;text-align:center">
 <p style="margin:0;text-align:center">
  <b>Uttara EPZ, Nilphamari.</b></p>
 </div>


 <p style="margin:0;text-align:center;font-size: 16px;">
  <b><span style="font-family: cursive;font-size: 22px;">e-</span>GATE PASS (<?php echo getGatepassType($info->gatepass_type) ; ?>)</b></p>
  <table style="width: 100%">
  <tr>
    <th class="tg-s6z2" style="width: 10%">Department </th>
    <td class="tg-baqh" style="width: 40%">: <?php echo $info->department_name; ?></td>
    <th class="tg-baqh" style="width: 10%">Barcode: </th>
    <th class="tg-baqh" style="width: 40%">
      <?php if($info->gatepass_no != '' || $info->gatepass_no != NULL) 
    { echo '<img src="'.base_url('dashboard/barcode/'.$info->gatepass_no).'" alt="" >'; } ?>
    </th>
  </tr>
  <tr>
    <th class="tg-s6z2" >Date & Time</th>
    <td class="tg-baqh" >: <?php echo findDate($info->create_date); echo " $info->create_time"; ?></td>
    <th class="tg-s6z2" >Gatepass NO: </th>
    <th class="tg-s6z2">
      <?php echo "$info->gatepass_no" ?> 
    </th>
  </tr>
  <tr>
    <th class="tg-s6z2"  valign="top">
    From
    </th>
    <td class="tg-baqh" style="" valign="top">: 
     <?php echo "$info->issue_from" ?>
    </td>
    <th class="tg-s6z2" style="">
      <?php if($info->gatepass_type==4) echo "Location"; else echo "To"; ?>: 
    </th>
    <td>
    <?php 
      if($info->gatepass_type==4){
        echo $info->wh_whare; 
      }else{
        echo $info->issue_to_name; 
      if($info->mobile_no!='') echo " ($info->mobile_no)";
      if($info->address!='') echo " $info->address";
      }
     ?></td>
  </tr>
  <tr>
    <th class="tg-s6z2" style="" valign="top">
    Carried By:
    </th>
    <td class="tg-baqh" style="" valign="top">: 
      <?php echo "$info->carried_by ($info->employee_id)" ?>
    </td>
    <?php if($info->gatepass_type==3){ ?>
    <th class="tg-s6z2" >Vehicle No:</th>
    <td class="tg-s6z2" ><?php echo "$info->vehicle_no" ?></th>
  <?php } ?>
  </tr>
  <tr>
    <?php if($info->attachment!=''){ ?>
    <th class="tg-s6z2" style="" valign="top">
    Attachment:
    </th>
    <td class="tg-baqh" style="" valign="top">: 
      <a href="<?php echo base_url(); ?>dashboard/gatepassExcel/<?php echo $info->attachment; ?>">Download</a>
    </td>
    <?php } ?>
    <?php if($info->gatepass_type==3){ ?>
    <th class="tg-s6z2" >Container No:</th>
    <td class="tg-s6z2" ><?php echo "$info->container_no" ?></th>
  <?php } ?>
  </tr>
  </table>
  <!-- ///////////////////// -->
<br>
  <table class="tg" style="width: 100%">
  <tr>
    <th style="width:5%;text-align:center">SN</th>
    <th style="width:10%;text-align:center">Material Code</th>
    <th style="width:35%;text-align:center">MaterialName/Description</th>
    <?php if($info->gatepass_type==3){ ?>
     <th style="width:10%;text-align:center">PO NO</th>
     <th style="width:10%;text-align:center">Carton No</th>
    <?php } ?>
    <th style="width:8%;text-align:center">Quantity</th>
    <th style="width:8%;text-align:center">Unit</th>
    <?php if($info->gatepass_type==3){ ?>
     <th style="width:10%;text-align:center">Invoice No</th>
    <?php } ?>
    <th style="width:20%;text-align:center">Purpose</th>
  </tr>
  <?php
   if(isset($detail)){
  $i=1; $totalqty=0;
  foreach($detail as $row){
  $totalqty=$totalqty+ $row->product_quantity; 
  ?>
  <tr>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $i++;; ?></td>
    <td class="tg-baqh" ><?php echo $row->product_code; ?></td>
    <td class="tg-baqh" ><?php echo $row->product_name; ?></td>
    <?php if($info->gatepass_type==3){ ?>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->po_no; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->carton_no; ?></td>
    <?php } ?>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->product_quantity; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->unit_name; ?></td>
    <?php if($info->gatepass_type==3){ ?>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->invoice_no; ?></td>
    <?php } ?>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->remarks; ?></td>
    </tr>
    <?php }
  } ?>
   <?php if($info->gatepass_type==3){ ?>
    <tr>
     <td style="text-align: center;" colspan="5">Total</td>
     <td style="text-align: center;"><?php echo $totalqty; ?></td>
     <td></td>
     <td></td>
     <td></td>
    </tr>
    <?php }else{ ?>
      <tr>
     <td style="text-align: center;" colspan="3">Total</td>
     <td style="text-align: center;"><?php echo $totalqty; ?></td>
     <td></td>
     <td></td>
    </tr>
  <?php } ?>
  </table>
  <br><br>

  <?php if($info->gatepass_type==3){ ?> 
<table style="width:100%">
  <tr>
    <td style="text-align:left">
      <?php if($info->gatepass_status>=2){ echo $info->user_name; 
        echo "<br>"; echo findDate($info->create_date); echo " $info->create_time";}
      ?></td>
     <td style="text-align:center;">
      <?php if($info->gatepass_status>=5){ echo $info->checked_by_name; 
        echo "<br>"; echo findDate($info->checked_date); echo " $info->checked_time";}
      ?></td>
      <?php if($info->gatepass_status>=4) { ?>
          <td style="text-align: center;"><?php echo $info->approved_by_name; 
          echo "<br>"; 
          echo findDate($info->approved_date); 
          echo "<br>"; echo $info->department_name;
          ?></td>
          <td style="text-align: center;"><?php echo getUserName($info->approved_by3); 
          echo "<br>"; 
          echo findDate($info->approved_date2); 
          echo "<br> LOGISTICS"; 
          ?></td>
          <td style="text-align: center;"><?php echo getUserName($info->approved_by3); 
          echo "<br>"; 
          echo findDate($info->approved_date3); 
          echo "<br> PC"; 
          ?></td>
          <td style="text-align: right;">
          <?php echo getUserName($info->approved_by4); 
          echo "<br>"; 
          echo findDate($info->approved_date4); 
          echo "<br> MERCHANDISING"; 
          ?></td>
        <?php } ?>
  </tr>
  <tr>
     <td style="text-align:left;font-size:15px;line-height:5px">
     ---------------------------------</td>
     <td style="text-align:center;font-size:15px;line-height:5px">
     --------------------------------</td>
     <td style="text-align:center;font-size:15px;line-height:5px">
     --------------------------------</td>
     <td style="text-align:center;font-size:15px;line-height:5px">
     --------------------------------</td>
     <td style="text-align:center;font-size:15px;line-height:5px">
     --------------------------------</td>
     <td style="text-align:right;font-size:15px;line-height:5px">
     --------------------------------</td>
  </tr>
  <tr>
  <td style="text-align:left">PREPARED BY</td>
  <td style="text-align:center;">CHECKED BY</td>
  <td style="text-align:center">APPROVED BY</td>
  <td style="text-align:center;">APPROVED BY</td>
  <td style="text-align:center;">APPROVED BY</td>
  <td style="text-align:right">APPROVED BY</td>
  </tr>
</table>
<?php }else{ ?>
  <table style="width:100%">
  <tr>
    <td style="text-align:left">
      <?php if($info->gatepass_status>=2){ echo $info->user_name; 
        echo "<br>"; echo findDate($info->create_date); echo " $info->create_time";}
      ?></td>
     <td style="text-align:center;">
      <?php if($info->gatepass_status>=5){ echo $info->checked_by_name; 
        echo "<br>"; echo findDate($info->checked_date); echo " $info->checked_time";}
      ?></td>
     <td style="text-align:right;width: 45%">
      <?php if($info->gatepass_status>=4) {
        echo $info->approved_by_name; 
          echo "<br>";
          echo findDate($info->approved_date);
        }
        ?>
      </td>
  </tr>
  <tr>
     <td style="text-align:left;font-size:15px;line-height:5px">
     ---------------------------------</td>
     <td style="text-align:center;font-size:15px;line-height:5px">
     --------------------------------</td>
     <td style="text-align:right;font-size:15px;line-height:5px">
     --------------------------------</td>
  </tr>
  <tr>
  <td style="text-align:left">PREPARED BY</td>
  <td style="text-align:center;">CHECKED BY</td>
  <td style="text-align:right">APPROVED BY</td>
  </tr>
</table>
<?php } ?>
<p style="margin:0;text-align:center">
<?php echo $this->session->userdata('caddress'); ?>                   
</p>
  <!-- ///////////////////// -->
</div>
</div>
</div>
        <!-- /.box-body -->
<div class="box-footer">
   <div class="col-sm-6">
    <a href="<?php echo base_url(); ?>gatep/pcapproval/lists" class="btn btn-info"> <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
   <button class="btn btn-info prints"><i class="fa fa-print" ></i> Print</button>
 </div>
 <?php if($info->approved_by3==NULL){  ?>
 <div class="col-sm-6">
  <a href="<?php echo base_url(); ?>gatep/pcapproval/approved/<?php echo $info->gatepass_id; ?>" class="btn btn-info"> 
      <i class="fa fa-check" aria-hidden="true"></i> Approve</a>
 </div>
 <?php } ?>
  </div>
     
  </div>
</div>
<!-- /.box-footer -->
</div>
<style type="text/css">
  .error-msg{display: none;}
</style>