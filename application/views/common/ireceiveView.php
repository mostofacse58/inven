<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
hr{margin: 5px}
.tg1  {border-collapse:collapse;border-spacing:0;width:100%}
.tg1 td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;overflow:hidden;word-break:normal;line-height: 18px;overflow: hidden;}
  .error-msg{display: none;}
</style>
<div class="row">
  <div class="col-md-12">
   <div class="content-holder">
   <div class="box box-info" style="padding: 10px">
   <div class="table-responsive table-bordered">

<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:2px 0px;color: #538FD4">
<b><?php echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 12px;">
<p style="line-height: 27px;padding: 10px 10px;margin-bottom: 0px;padding-bottom: 0px" >
  <b><i> Material Issue Form (<?php if(isset($info))echo $info->from_department_name; ?>)
  </i></b></p>
</div>
<table style="width: 100%">
  <tr>
    <th style="width:15%;text-align: left">For:</th>
    <th style="width:40%;text-align: left">
      <?php if($info->issue_type==1) echo "Department"; else echo "Employee"; ?></th>
    <th style="width:15%;text-align: left">Department:</th>
    <th style="width:30%;text-align: left">
      <?php if(isset($info))echo $info->department_name; ?></th>
  </tr>
  <tr>
    <th style="text-align: left" >Employee:</th>
    <th style="text-align: left" >
      <?php if($info->issue_type==2) 
      echo "$info->employee_name($info->employee_id)";?></th>
    <th style="text-align: left" >Purpose:</th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->issue_purpose; ?></th>
  </tr>
   <tr>
    <th style="text-align: left" >Requisition No: </th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->requisition_no; ?></th>
    <th style="text-align: left" >Date: </th>
    <th style="text-align: left" ><?php if(isset($info)) echo findDate($info->issue_date); ?></th>
  </tr>
  <?php if($info->product_detail_id!=''){ ?>
  <tr>
    <th style="text-align: left">Asset Name: </th>
    <th style="text-align: left" colspan="3">
      <?php if(isset($info)) echo $this->look_up_model->get_ProductnameSerial($info->product_detail_id); ?></th>
  </tr>
<?php } ?>
</table>
<br>
<table class="tg">
  <tr>
    <th style="width:5%;text-align:center">SL</th>
    <th style="width:12%;text-align:center">Item Code</th>
    <th style="width:17%;text-align:center">Item Name 项目名</th>
    <th style="width:12%;text-align:center;">Issued Qty</th>
    <th style="width:10%;text-align:center;">Unit Price</th>
    <th style="width:10%;text-align:center;">Amount</th>
  </tr>
 
  <?php
  if(isset($detail)){
     $i=1; $totalqty=0;
     $totalamount=0;
    foreach($detail as $value){ 
      $description="Category: $value->category_name";
       $totalqty=$totalqty+$value->quantity;
       $totalamount=$totalamount+$value->sub_total;
    ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
     <td class=""><?php echo $value->product_name; ?></td>
    <td class="tg-s6z2"><?php echo "$value->quantity $value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_price"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->sub_total"; ?></td>

  </tr>
   <?php }} ?>
   <tr>
    <th style="text-align: right;" colspan="3">Total:</th>
    <th class="tg-s6z2"><?php echo "$totalqty"; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"><?php echo "$totalamount"; ?></th>
  </tr>
 
</table>
<br><br><br>
<table style="width:100%">
  <tr>
  <td style="width:25%;text-align:left"><?php if(isset($info)) echo "$info->user_name"; ?></td>
  <td style="width:25%;text-align:center"><?php if(isset($info)) echo "For $info->received_by_name"; ?></td>
  <td style="width:25%;text-align:center"><?php if(isset($info)) echo "$info->received_by_name"; ?></td>
  <td style="width:25%;text-align:right"></td>
  </tr>
  <tr>
  <td style="width:25%;text-align:left;font-size: 15px;line-height: 5px">-----------------</td>
  <td style="width:25%;text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="width:25%;text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="width:25%;text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left">Issued By</td>
  <td style="text-align:center">Head of Dept.</td>
  <td style="text-align:center">Received By</td>
  <td style="text-align:right">Approved</td>
  </tr>

</table>
  <div class="box-footer">
  <?php if($info->issue_status==1){ ?>
  <div class="col-sm-12" style="text-align: center;">
    <a class="btn btn-success canceled"  data-pid="<?php echo $info->issue_id; ?>">
    <i class="fa fa-check-circle-o  tiny-icon"> </i> Receive</a>
  </div>
<?php } ?>
  </div>
 </div>

</div>
</div>

</div>
<!-- content holder -->

</div>
</div>
<div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Add Comments</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>common/ireceived/receivedby">
          <div class="form-group">
            <label class="col-sm-3 control-label">Comments </label>
            <div class="col-sm-6">
              <textarea class="form-control" name="receive_comments" rows="2" id="receive_comments" placeholder="Comments"></textarea> 
              <span class="error-msg">Comments field is required</span>
            </div>
          </div>
       <input type="hidden" name="issue_id" id="issue_id" value="<?php echo $info->issue_id; ?>">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> OK</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready (function(){
  $("#addNewTeam").click(function(){
    var receive_comments = $("#receive_comments").val();
    var error = 0;
    if(receive_comments==""){
      $("#receive_comments").css({"border-color":"red"});
      $("#receive_comments").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#receive_comments").css({"border-color":"#ccc"});
      });
      error=1;
    }
    if(error == 0) {
      $("#formId").submit();
    }
  });
  ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".canceled").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
     $("#issue_id").val(rowId);
     $("#TeamModal").modal("show");
  });
});//jquery ends here
</script>