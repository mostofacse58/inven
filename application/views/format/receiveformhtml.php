<style type="text/css">
  table td{
  padding: 5px 3px;
}
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
<p style="margin:0px 0px;color: #538FD4">
<b><?php  echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 12px;">
<p style="line-height: 27px;padding:5px;margin-bottom: 0px;padding-bottom: 0px;font-size: 15px" >
  <b><i> Material Receive Form <?php if($info->grn_type==1) echo "GRN"; else echo "Extra GRN"; ?>
  </i></b></p>
</div>
<table style="width: 100%">
   <tr>
    <th style="text-align: left;width: 15%" >Supplier:</th>
    <th style="text-align: left;width: 50%" >
      <?php  
      echo "$info->supplier_name";?></th>
    <th style="text-align: left;width: 15%" >PO NO:</th>
    <th style="text-align: left;width: 20%" >
      <?php if(isset($info)) echo $info->po_number; ?>
    </th>
  </tr>
   <tr>
    <th style="text-align: left" >Ref. No: </th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->reference_no; ?></th>
    <th style="text-align: left" >Receive Date: </th>
    <th style="text-align: left" ><?php if(isset($info)) echo findDate($info->purchase_date); ?></th>
  </tr>
  <tr>
    <th style="text-align: left" >Currency: </th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->currency; ?></th>
    <th style="text-align: left" >Currency Rate HKD: </th>
    <th style="text-align: left" ><?php if(isset($info)) echo $info->cnc_rate_in_hkd; ?></th>
  </tr>
<tr>
    <th style="text-align: left;"  >Invoice No 发票号码:</th>
    <th style="text-align: left;" >
      <?php if(isset($info)) echo $info->invoice_no; ?>
    </th>
  </tr>
</table>
<br>
<table class="tg">
  <tr>
    <th style="width:3%;text-align:center">SL</th>
    <th style="width:10%;text-align:center">Item Code</th>
    <th style="width:20%;text-align:center">Item Name 项目名</th>
    <th style="width:15%;text-align:center">Description</th>
    <th style="width:10%;text-align:center;">PI NO</th>
    <th style="width:10%;text-align:center;">FIFO CODE</th>
    <th style="width:6%;text-align:center;">Qty</th>
    <th style="width:8%;text-align:center;">Unit</th>
    <th style="width:10%;text-align:center;">Unit Price</th>
    <th style="width:10%;text-align:center;">Sub-Total</th>
    
  </tr>
 
  <?php
  if(isset($detail)){
     $i=1; $totakqty=0;$tamount=0;
    foreach($detail as $value){ 
      $description="Category: $value->category_name";
       $totakqty=$totakqty+$value->quantity;
       $tamount=$tamount+$value->amount_hkd;
    ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class="textcenter"><?php echo $description; ?></td>
    <td class="tg-s6z2"><?php echo "$value->pi_no"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->FIFO_CODE"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->quantity"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->currency $value->unit_price"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->amount"; ?></td>
  </tr>
   <?php }} ?>
   <tr>
    <th style="text-align: right;" colspan="6">Total Quantity:</th>
    <th class="tg-s6z2"><?php echo "$totakqty"; ?></th>
    <th></th>
    <th></th>
    <th class="tg-s6z2"><?php if(isset($info)) echo $tamount; ?> HKD</th>
  </tr>
 
</table>
<br><br><br>
<table style="width:100%">
  <tr>
  <td style="width:50%;text-align:left"><?php if(isset($info)) {echo "$info->user_name<br>";
  echo findDate($info->purchase_date);} ?></td>
  <td style="width:50%;text-align:right">
    <?php if(isset($info)) {
    echo "$info->received_by_name<br>";
    echo findDate($info->received_date);
  } 
    ?>
  </td>
  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">
  -----------------
  </td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">
  ----------------
  </td>
  </tr>
  <tr>
  <td style="text-align:left">Prepared By</td>
  <td style="text-align:right">Received By</td>
  </tr>

</table>
  <div class="box-footer">
  
  <div class="col-sm-12" style="text-align: center;">
    <?php if($show==2){ ?>
    <a class="btn btn-info" href="<?php echo base_url()?>format/<?php echo $controller; ?>/lists">
      <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Back</a>
    <?php } ?>
    <?php if($show==1){ ?>
    <a class="btn btn-info" href="<?php echo base_url()?>format/<?php echo $controller; ?>/lists">
      <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Back</a>
    <?php } ?>
    <?php if($info->status==2&&$show==2){ ?>
    <a class="btn btn-info received" data-pid="<?php echo $info->purchase_id;?>" href="#">
    <i class="fa fa-check-circle-o  tiny-icon"> </i> Received </a>
    <a class="btn btn-danger" href="<?php echo base_url()?>common/<?php echo $controller; ?>/returns/<?php echo $info->purchase_id;?>">
      <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Return</a>
    <?php  ?>
  </div>
<?php } ?>

  </div>
 </div>

</div>
</div>
</div>
</div>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".received").click(function(e){
  job=confirm("Are you sure you want to received this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>common/<?php echo $controller; ?>/received/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>