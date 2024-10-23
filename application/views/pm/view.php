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

<hr style="margin-top: 0px">
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px;margin:3px 0px;" >
  <b>PM Deatils for Date <?php echo $info->pm_date ; ?></b>
</p>
</div>
<table style="width: 100%">
  <tr>
    <th style="text-align: left;width: 15%">Work Date:</th>
    <th style="text-align: left;width: 35%">
      <?php  echo "$info->work_date"; ?></th>
    <th style="text-align: left;width: 15%">Asset Code :</th>
    <th style="text-align: left;width: 35%">
      <?php if(isset($info)) echo $info->tpm_code; ?>
    </th>
  </tr>
   <tr>
    <th style="text-align: left">Model: </th>
    <th style="text-align: left">
      <?php if(isset($info)) echo $info->model_no; ?></th>
    <th style="text-align: left">Name: </th>
    <th style="text-align: left"><?php if(isset($info)) echo $info->product_name; ?></th>
  </tr>
  <tr>
    <th style="text-align: left" >Spare Ref. No : </th>
    <th style="text-align: left" >
      <?php if(isset($info)) echo $info->sref_no; ?></th>
    <th style="text-align: left" >Remarks: </th>
    <th style="text-align: left" ><?php if(isset($info)) echo $info->remarks; ?></th>
  </tr>
</table>

<br>
<table class="tg">
  <tr>
   <th style="width:4%;text-align:center">SN</th>
  <th style="width:50%;text-align:center">Name</th>
  <th style="width:10%;text-align:center">Status </th>
  <th style="width:12%;text-align:center;">Note</th>
    
  </tr>
 
  <?php
  if(isset($details)){
     $i=1; 
    foreach($details as $value){ 

    ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class=""><?php echo $value->check_name; ?></td>
    <td class="tg-s6z2"><i class="fa fa-check-circle-o" aria-hidden="true"></i></td>
    <td class="tg-s6z2"><?php echo "$value->notes"; ?></td>
  </tr>
   <?php }} ?>

 
</table>

<br>
<br>
<h4>Spares using Details</h4>
<table class="tg">
  <tr>
  <th style="width:4%;text-align:center">SN</th>
  <th style="width:10%;text-align:center">Item Code</th>
  <th style="width:35%;text-align:center">Name </th>
  <th style="width:12%;text-align:center;">Qty</th>
    
  </tr>
 
  <?php
  if(isset($sdetail)){
     $i=1; 
    foreach($sdetail as $value){ 

    ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class=""><?php echo $value->product_code; ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class="tg-s6z2"><?php echo "$value->quantity"; ?></td>
  </tr>
   <?php }} ?>
 
</table>
<br>
<table style="width: 100%">
  <tr>
    <th style="text-align: right;width: 15%;vertical-align: top">Before Picture:</th>
    <th style="text-align: left;width: 35%">
    <?php if (isset($info->before_image) &&!empty($info->before_image)) { ?>
      <img src="<?php echo base_url(); ?>pm/<?php echo $info->before_image; ?>" class="img-thumbnail" style="width:100%;height:auto;"/>
    <?php } ?>
    </th>
    <th style="text-align: right;width: 15%;vertical-align: top">After Picture :</th>
    <th style="text-align: left;width: 35%">
      <?php if (isset($info->after_image) &&!empty($info->after_image)) { ?>
      <img src="<?php echo base_url(); ?>pm/<?php echo $info->after_image; ?>" class="img-thumbnail" style="width:100%;height:auto;"/>
    <?php } ?>
    </th>
  </tr>
  <tr>
    <th style="text-align: right;width: 15%;vertical-align: top">Worl Picture 1:</th>
    <th style="text-align: left;width: 35%">
    <?php if (isset($info->image1) &&!empty($info->image1)) { ?>
      <img src="<?php echo base_url(); ?>pm/<?php echo $info->image1; ?>" class="img-thumbnail" style="width:100%;height:auto;"/>
    <?php } ?>
    </th>
    <th style="text-align: right;width: 15%;vertical-align: top">Work Picture 2:</th>
    <th style="text-align: left;width: 35%">
      <?php if (isset($info->image2) &&!empty($info->image2)) { ?>
      <img src="<?php echo base_url(); ?>pm/<?php echo $info->image2; ?>" class="img-thumbnail" style="width:100%;height:auto;"/>
    <?php } ?>
    </th>
  </tr>
</table>
<br>


  <div class="box-footer">
  
  <div class="col-sm-12" style="text-align: center;">
    <a class="btn btn-info" href="<?php echo base_url()?>pm/<?php echo $controller; ?>/lists">
      <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Back</a>
  </div>



  </div>
 </div>

</div>
</div>



</div>
</div>
