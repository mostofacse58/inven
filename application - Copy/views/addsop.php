<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>sop/save<?php if (isset($info)) echo "/$info->id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
    <div class="box-body">
      <div class="form-group local">
        <label class="col-sm-2 control-label">Menu Name<span style="color:red;">  *</span></label>
           <div class="col-sm-2">
           <input type="text" name="menu" id="menu" class="form-control" placeholder="Name" value="<?php if(isset($info)) echo $info->menu; else echo set_value('menu'); ?>">
           <span class="error-msg"><?php echo form_error("menu");?></span>
         </div>
          <label class="col-sm-2 control-label">Title <span style="color:red;">  *</span></label>
           <div class="col-sm-6"> 
            <input type="text" name="title" id="title" class="form-control" placeholder="title" value="<?php if(isset($info)) echo $info->title; else echo set_value('title'); ?>">
           <span class="error-msg"><?php echo form_error("title");?></span>
         </div>         
      </div><!-- ///////////////////// -->
    <div class="form-group">
      <label class="col-sm-2 control-label">SOP <span style="color:red;">  *</span></label>
      <div class="col-sm-10"> 
        <textarea type="text" name="description" id="description" class="form-control summernote" placeholder="Description"><?php if(isset($info)) echo $info->description; else echo ""; ?></textarea>
           <span class="error-msg"><?php echo form_error("description");?></span>
         </div>         
      </div><!-- ///////////////////// -->
      <div class="form-group">
        <label class="col-sm-2 control-label">Image 1 <span style="color:red;">  </span></label>
         <div class="col-sm-2">
             <div class="input-group">
              <input type="file" class="form-control"  name="file_1" class="file">
            </div>
          <?php if (isset($info->file_1) && !empty($info->file_1)) { ?>
            <div style="margin-top:20px;">
              <a href="<?php echo base_url();?>sop/fliedownload/<?php echo $info->file_1;?>" style="width:auto;text-decoration: none;">                 
               <button type="button"  class="btn btn-sm btn-primary">Download</button></a>
              </div>
          <?php } ?>
          <span>Allows jpg,png.</span>
       </div>
       <label class="col-sm-2 control-label">Image 2 <span style="color:red;">  </span></label>
         <div class="col-sm-2">
             <div class="input-group">
              <input type="file" class="form-control"  name="file_2" class="file">
            </div>
          <?php if (isset($info->file_2) && !empty($info->file_2)) { ?>
            <div style="margin-top:20px;">
              <a href="<?php echo base_url();?>sop/fliedownload/<?php echo $info->file_2;?>" style="width:auto;text-decoration: none;">                 
               <button type="button"  class="btn btn-sm btn-primary">Download</button></a>
              </div>
          <?php } ?>
          <span>Allows jpg,png.</span>
       </div>
       <label class="col-sm-2 control-label">Image 3 <span style="color:red;">  </span></label>
         <div class="col-sm-2">
             <div class="input-group">
              <input type="file" class="form-control"  name="file_3" class="file">
            </div>
          <?php if (isset($info->file_3) && !empty($info->file_3)) { ?>
            <div style="margin-top:20px;">
              <a href="<?php echo base_url();?>sop/fliedownload/<?php echo $info->file_3;?>" style="width:auto;text-decoration: none;">                 
               <button type="button"  class="btn btn-sm btn-primary">Download</button></a>
              </div>
          <?php } ?>
          <span>Allows jpg,png.</span>
       </div>
     </div>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>sop/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
  <div class="col-sm-4">
    <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> SAVE 保存</button>
  </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>
<!-- /////////////////////////////////////// -->

<script src="<?php echo base_url();?>asset/js/plugins/summernote/summernote.js"></script>
<link href="<?php echo base_url();?>asset/js/plugins/summernote/summernote.css" type="text/css" rel="stylesheet">

<script type="text/javascript">
var count = 1
$(document).ready(function(){
  $('.summernote').summernote({
    onChange: function(contents, $editable) {
      //var latestword = $('div.note-editable').html().split(/(\s|&nbsp;)/).pop();
      //var tmp = $('div.note-editable').html().replace();
      var latestword = $('div.note-editable').html().split(/[ .,:;?!]/).pop();
      latestword=latestword.replace(/<br>/gi, " ");
      latestword=latestword.replace(/<p>/gi, " ");
      latestword=latestword.replace(/<\/p>/gi, " ");

      console.log( "FULL : " , latestword.trim() );
    },
    height: 600,
    codemirror: {                 // code mirror options
      mode: 'text/html',
      htmlMode: true,
      lineNumbers: true,
      theme: 'monokai'
    }
      /////////////
  });

 
});
$(function () {
  $(document).on('click','input[type=number]',function(){ 
    this.select(); 
    });
    $('.date').datepicker({
      "format": "dd/mm/yyyy",
      "todayHighlight": true,
      "autoclose": true
    });
  
  });


    //////////////////////////////////////////////////////
    /////// DELETE FIELD
    ////////////////////////////////////////////////////////
   function deleter(id){
        $("#row_"+id).remove();
        deletedRow.push(id);
        totalSum();
        updateRowNo();
    }
    ////////////////////////////////
    //////////UPDATE ROW NUmber
    ////////////////////////////////
    function updateRowNo(){
      var numRows=$("#form-table tbody tr").length;
      for(var r=0;r<numRows;r++){
          $("#form-table tbody tr").eq(r).find("td:first b").text(r+1);
      }
    }
    ////// TOTAL SUM
    ////////////////////////////////////////////
    function totalSum(){
      var totalAmount=0;
      var totalqty=0;
      for(var i=0;i<id;i++){
        if(deletedRow.indexOf(i)<0) {
           var price=parseFloat($.trim($("#unit_price_"+i).val()));
           var quantity=parseFloat($.trim($("#quantity_"+i).val()));
           var priceAndQuantity=price*quantity;
           totalqty+=quantity;
           totalAmount += parseFloat($.trim($("#sub_total_amount_" + i).val()));
        }
      }
      $("#total_amount").val(totalAmount.toFixed(2));
    }
    //////////////////////////////////////////////
    /////////////CALCULATE ROW
    //////////////////////////////////////////////
    function calculateRow(id){
      var unitPrice=$("#unit_price_"+id).val();
      var quantity=$("#quantity_"+id).val();

      if($.trim(unitPrice)==""|| typeof unitPrice === "undefined"){
        unitPrice=0
        $("#unit_price_"+id).val(0);
      }
      if($.trim(quantity)==""|| typeof quantity === "undefined"){
        quantity=0
        $("#quantity_"+id).val(0);
      }
      var quantityAndPrice=parseFloat($.trim(unitPrice))*parseFloat($.trim(quantity));
      $("#sub_total_amount_"+id).val(quantityAndPrice.toFixed(2));
      //alert(id);
      totalSum();
    }//calculateRow

    ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
       var quantity=$("#quantity_"+id).val();
       if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
        $("#quantity_"+id).val(1);
      }   
      calculateRow(id);
    }
    ////////////////////////////////////////////
    //////////CHECK UNIT PRICE
    ///////////////////////////////////////////
    function checkUnitPrice(id){
      var unitPrice=$("#unit_price_"+id).val();
      if($.trim(unitPrice)==""){
      $("#unit_price_"+id).val(0);
      }
      calculateRow(id);
    }
///////////////////////////////////////////
  function formsubmit(){  return true;
    var error_status=false;
    var po_type=$("#po_type").val(); 
    var po_date=$("#po_date").val();
    var delivery_date=$("#delivery_date").val();
    var pay_term=$("#pay_term").val();
    var currency=$("#currency").val();
    var cnc_rate_in_hkd=$("#cnc_rate_in_hkd").val();
    var serviceNum=$("#form-table tbody tr").length;
    var chk;
    if(serviceNum<1){
      $("#alertMessageHTML").html("Please Adding at least one Item!!");
      $("#alertMessagemodal").modal("show");
      error_status=true;
    }
  
  if(po_type=='BD WO'){
    var title=$("#title").val();
    var subject=$("#subject").val();
    var menu=$("#menu").val();
    if(title ==''){
      error_status=true;
      $('textarea[name=title]').css('border', '1px solid #f00');
    } else {
      $('textarea[name=title]').css('border', '1px solid #ccc');      
    }
    if(subject ==''){
      error_status=true;
      $('input[name=subject]').css('border', '1px solid #f00');
    } else {
      $('input[name=subject]').css('border', '1px solid #ccc');      
    }
    if(menu ==''){
      error_status=true;
      $('input[name=menu]').css('border', '1px solid #f00');
    } else {
      $('input[name=menu]').css('border', '1px solid #ccc');      
    }
  }else{
    var mode_of_shipment=$("#mode_of_shipment").val();
    if(mode_of_shipment ==''){
      error_status=true;
      $('input[name=mode_of_shipment]').css('border', '1px solid #f00');
    } else {
      $('input[name=mode_of_shipment]').css('border', '1px solid #ccc');      
    }
  }
  if(pay_term ==''){
    error_status=true;
    $('select[name=pay_term]').css('border', '1px solid #f00');
  } else {
    $('select[name=pay_term]').css('border', '1px solid #ccc');      
  }
  if(currency ==''){
    error_status=true;
    $('select[name=currency]').css('border', '1px solid #f00');
  } else {
    $('select[name=currency]').css('border', '1px solid #ccc');      
  }
  if(cnc_rate_in_hkd ==''){
    error_status=true;
    $('cnc_rate_in_hkd[name=po_number]').css('border', '1px solid #f00');
  } else {
    $('cnc_rate_in_hkd[name=po_number]').css('border', '1px solid #ccc');      
  }

  if(total_amount ==''){
    error_status=true;
    $('input[name=total_amount]').css('border', '1px solid #f00');
  } else {
    $('input[name=total_amount]').css('border', '1px solid #ccc');      
  }
  if(po_date == '') {
    error_status=true;
    $("#po_date").css('border', '1px solid #f00');
  } else {
    $("#po_date").css('border', '1px solid #ccc');      
  }
  if(delivery_date == '') {
    error_status=true;
    $("#delivery_date").css('border', '1px solid #f00');
  } else {
    $("#delivery_date").css('border', '1px solid #ccc');      
  }
  /////////////
  for(var i=0;i<serviceNum;i++){
    if($("#unit_price_"+i).val()==''||$("#unit_price_"+i).val()==0){
      $("#unit_price_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
      $("#quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#pi_no_"+i).val()==''){
      $("#pi_no_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#sub_total_amount_"+i).val()==''){
      $("#sub_total_amount_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    }
  
  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
}
 ////////////////////////////////////////////
//////////CHECK QUANTITY
///////////////////////////////////////////

</script>