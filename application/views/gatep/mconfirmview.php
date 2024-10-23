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

  var url1="<?php echo base_url(); ?>gatep/mconfirm/lists";
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
    .mconfirm_panel{ display:none;}
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
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 15px;">
<p style="margin:2px 0px;color: #538FD4">
<b> Ventura Leatherware Mfy (BD) Ltd.</b></p>
</div>
<div style="width:100%;overflow:hidden;font-size: 18px;color: #000;text-align:center">
 <p style="margin:0;text-align:center">
  <b>Uttara EPZ, Nilphamari.</b></p>
 </div>
 <p style="margin:0;text-align:center;font-size: 16px;">
  <b><span style="font-family: cursive;font-size: 22px;">e-</span>GATE PASS (Stock In)</b></p>
  <table style="width: 100%">
  <tr>
    <th class="tg-s6z2" style="width: 10%" valign="top">
    From
    </th>
    <td class="tg-baqh" style="width: 60%" valign="top">: 
      <?php 
        echo $info->wh_whare; 
       ?>
      </td>
    <th class="tg-s6z2" style="width: 30%;font-weight: 500; ">
      <?php if($info->gatepass_no != '' || $info->gatepass_no != NULL) 
    { echo '<img src="'.base_url('dashboard/barcode/'.$info->gatepass_no).'" alt="" >'; } ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2" >Date </th>
    <td class="tg-baqh" >: <?php echo findDate($info->create_date); echo " $info->create_time"; ?></td>
    <th class="tg-s6z2" >Gatepass NO: <?php echo "$info->gatepass_no" ?></th>
  </tr>
  <tr>
    <th class="tg-s6z2">Department </th>
    <td class="tg-baqh" >: <?php echo $info->department_name; ?></td>
    <th class="tg-s6z2" >Carried By: <?php echo "$info->carried_by ($info->employee_id)" ?></th>
  </tr>
  </table>
  <!-- ///////////////////// -->
<br>
  <table class="tg" style="width: 100%">
  <tr>
    <th style="width:5%;text-align:center">SN</th>
    <th style="width:10%;text-align:center">Material Code</th>
    <th style="width:35%;text-align:center">Material/Product Name</th>
    <th style="width:8%;text-align:center">Quantity</th>
    <th style="width:8%;text-align:center">Unit</th>
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
     <td class="tg-baqh" ><?php echo $row->product_code; ?></td>
  <td class="tg-baqh" ><?php echo $row->product_name; ?></td>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $row->product_quantity; ?></td>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $row->unit_name; ?></td>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $row->remarks; ?></td>
  </tr>
 <?php }} ?>
  </table>
  <br><br><br>
<table style="width:100%">
  <tr>
     <td style="width:50%;text-align:left">
      <?php if($info->gatepass_status>=4){ echo $info->checked_by_name; 
        echo "<br>"; echo findDate($info->checked_date); echo " $info->checked_time";}
      ?></td>
     <td style="width:50%;text-align:right">
      <?php if($info->gatepass_status>=3) {
        echo $info->approved_by_name; echo "<br>";
        echo findDate($info->approved_date); echo " $info->approved_time";
      } ?></td>
  </tr>
  <tr>
     <td style="text-align:left;font-size:15px;line-height:5px">
     ---------------------------------</td>
     <td style="text-align:right;font-size:15px;line-height:5px">
     --------------------------------</td>
  </tr>
  <tr>
  <td style="text-align:left">CHECKED BY</td>
  <td style="text-align:right">APPROVED BY</td>
  </tr>
</table>
<br>
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
    <a href="<?php echo base_url(); ?>gatep/mconfirm/lists" class="btn btn-info"> <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
   <button class="btn btn-info prints"><i class="fa fa-print" ></i> Print</button>
 </div>
 <?php if($info->gatepass_status==2){  ?>
 <div class="col-sm-6">
  <a href="#" class="btn btn-danger reject" data-pid="<?php echo $info->gatepass_id; ?>" ><i class="fa fa-ban tiny-icon"></i> Decline</a>
  <a href="<?php echo base_url(); ?>gatep/mconfirm/approved/<?php echo $info->gatepass_id; ?>" class="btn btn-info"> 
      <i class="fa fa-check" aria-hidden="true"></i> Confirm</a>
 </div>
 <?php } ?>
  </div>
     
  </div>
</div>
<!-- /.box-footer -->
</div>
<div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Add Decline Note</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>gatep/mconfirm/decline">
          <div class="form-group">
            <label class="col-sm-4 control-label">Decline Note </label>
            <div class="col-sm-7">
              <textarea class="form-control" name="reject_note" rows="3" id="reject_note" placeholder="Decline Note"></textarea> 
              <span class="error-msg">Decline Note field is required</span>
            </div>
          </div>
       <input type="hidden" name="gatepass_id"  id="gatepass_id">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> Save</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .error-msg{display: none;}
</style>