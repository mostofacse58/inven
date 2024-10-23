<style>
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
  .form-group.required .control-label:after { 
     content:"*";
     color:red;
  }
  .well-sm {
  border-radius: 3px;
  padding: 7px 25px;
}
table td{text-align: left;}
.textcenter{text-align: center;}
</style>
<script type="text/javascript">

  function formsubmit(){
  var error_status=false;
  var serviceNum=$("#form-table tbody tr").length;
  var chk=2;
  for(var i=1;i<=serviceNum;i++){
    if($("#return_qty_"+i).val()>0){
      chk=1;
    }
  }
  if(chk==2){
    $("#alertMessageHTML").html("Please fillup at least one returnable qty!!");
    $("#alertMessagemodal").modal("show");
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
    return true;
  }
}
  //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
       var return_qty=$("#return_qty_"+id).val();
       var stock=$("#stock_"+id).val();
     if(stock-return_qty<0){
         $("#alertMessageHTML").html("Return Qty does not exceed returnable quantity!!");
         $("#alertMessagemodal").modal("show");
         $("#return_qty_"+id).val(0);
      }else{
       if($.trim(return_qty)==""|| $.isNumeric(return_qty)==false){
            $("#return_qty_"+id).val(0);
        }
    } }
</script>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>

</div>
</div>

</div>
   <div class="box box-info">
    <!-- /.box-header -->
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>gatep/returnablein/searchIn" method="POST">
        <div class="box-body">
         <div class="form-group">
          <label class="col-sm-3 control-label" style="margin-top: 20px">SCAN CODE<span style="color:red;">  </span></label>
            <div class="col-sm-6">
              <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
                <div class="well well-sm">
                  <div class="form-group" style="margin-bottom:0;">
                    <div class="input-group wide-tip">
                    <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                      <input name="gatepass_no" value="" class="form-control input-lg" id="gatepass_no" autofocus="autofocus" placeholder="Please scan CODE" tabindex="1" type="text" autocomplete="off">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
      <div class="col-sm-3">
          <button type="submit" class="btn btn-info pull-right">Search</button>
      </div>
     </div><!-- ///////////////////// -->
      </div>
     <!-- /.box-body -->
  </form>
<?php if(isset($info)){ ?>
<div class="box box-primary">
<div class="box-body">
   <?php if(count($info)>0){  ?>
    <div class="alert alert-success alert-dismissable"  style="text-align:center;padding: 0px">
    <strong style="font-size:20px">This Gate Pass Valid and  Please fillup return qty product wise!!</strong>  
  </div>
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
  <b><span style="font-family: cursive;font-size: 22px;">
  e-</span>GATE PASS (<?php echo getGatepassType($info->gatepass_type); ?>)</b></p>
  <table style="width: 100%">
  <tr>
    <th class="tg-s6z2" style="width: 15%">Department </th>
    <td class="tg-baqh" style="width: 35%">: <?php echo $info->department_name; ?></td>
    <th class="tg-baqh" style="width: 15%">Barcode: </th>
    <th class="tg-baqh" style="width: 35%">
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
      <?php  echo "To"; ?>: 
    </th>
    <td>
    <?php 
      if($info->wh_whare!='OTHER'){
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
    <th class="tg-s6z2" >Container No/Lock No:</th>
    <td class="tg-s6z2" ><?php echo "$info->container_no" ?></th>
  <?php } ?>
  </tr>
  </table>
  <!-- ///////////////////// -->
<br>
 <?php
 if(count($detail)>0){ ?>
<form action="<?php echo base_url();?>gatep/returnablein/saveIn/<?php echo $info->gatepass_id; ?>" method="POST" onsubmit="return formsubmit();" class="form-horizontal">
  <table class="tg" style="width: 100%" id="form-table">
    <thead>
  <tr>
    <th style="width:5%;text-align:center">SN</th>
    <th style="width:10%;text-align:center">Material Code</th>
    <th style="width:35%;text-align:center">Material/Product Name</th>
    <th style="width:8%;text-align:center">Due Qty</th>
    <th style="width:10%;text-align:center">Return Qty</th>
    <th style="width:8%;text-align:center">Unit</th>
  </tr>
  </thead>
  <tbody>
  <?php
 if(isset($detail)){
$i=0; 
foreach($detail as $row){ 
?>
  <tr>
  <td class="tg-baqh" style="text-align:center">
    <?php echo ++$i;; ?></td>
  <td class="tg-baqh" ><?php echo $row->product_code; ?></td>
  <td class="tg-baqh" ><?php echo $row->product_name; ?></td>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $row->qty; ?></td>
    <td class="tg-baqh" style="text-align:center">
    <input type="hidden" name="detail_id[]" id="detail_id_<?php echo $i; ?>" value="<?php echo $row->detail_id; ?>">
    <input type="hidden" name="stock[]" id="stock_<?php echo $i; ?>" value="<?php echo $row->qty; ?>">
    <input type="text" name="return_qty[]" onblur="return checkQuantity(<?php echo $i; ?>);" onkeyup="return checkQuantity(<?php echo $i; ?>);" style="width: 90%;text-align: center;" id="return_qty_<?php echo $i; ?>"></td>
  <td class="tg-baqh" style="text-align:center">
    <?php echo $row->unit_name; ?></td>
  
  </tr>
 <?php }} ?>
 </tbody>
  </table>
  <br>
  <p style="text-align: left;width: 50%;float: left;overflow: hidden;">
  Note: 
  <br>
  <?php echo $this->look_up_model->getGatepassIN($info->gatepass_id); ?>
</p>
<br>
  <div  style="width: 100%;text-align: center;">
    <button type="submit" class="btn btn-primary">
      <i class="fa fa-save"></i> Save</button></div>
  </form>
  <?php }else{ ?>
  <strong style="font-size:20px">

  This Gate Pass has no due return product!!
</strong>
  <?php } ?>
  <script type="text/javascript">
  $(document).ready(function() {
    var urlList='<?php echo base_url('gatep/returnablein/lists');?>'; 
   setTimeout(function(){
    document.location=urlList;
    },40000 );
   });
</script>
  <br>
<br>
  <!-- ///////////////////// -->
</div>
  <?php }else{ ?>
  <div class="alert alert-danger alert-dismissable"  id="danger-alert" style="text-align:center">
    <strong style="font-size:25px">This Gate Pass Number Not Valid!</strong> 
  </div>
  <?php } ?>
  </div>
</div>
  <?php } ?>
   <div class="box-footer">
     <div class="col-sm-6"><a href="<?php echo base_url(); ?>gatep/returnablein/lists" class="btn btn-info"> <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
   </div>
    </div>
          </div>
        </div>
   </div>
 </div>
 