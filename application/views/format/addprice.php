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
    <div class="box box-info" style="padding: 10px">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:2px 0px;color: #538FD4">
<b><?php echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px" >
  <b>Purchase Indent(Safety Stock) <br>物料申购单 </b></p>
</div>
<hr style="margin-top: 0px">
<table style="width: 100%">
  <tr>
    <th style="width:50%;text-align: left" > 
      Purchase Category购买类别: <?php if(isset($info)) echo $info->p_type_name; ?> </th>
    <th style="width:25%;text-align: left" > 
      NO.VLML采购单号: <?php if(isset($info)) echo $info->pi_no; ?> </th>
    <th style="width:25%;text-align: left" > 
      Date日期: <?php if(isset($info)) echo findDate($info->pi_date); ?> </th>
  </tr>
  <tr>
    <th style="text-align: left" > 
      Demand Dept. 需求部门 <?php if(isset($info)) echo $info->demand_department_name; ?> </th>
    <th style="text-align: left" > 
      Division部门: <?php if(isset($info)) echo $info->division; ?></th>
    <th style="text-align: left" > 
    Demand Date 需求日期: <?php if(isset($info)) echo findDate($info->demand_date); ?></th>
  </tr>
  <tr>
    <th style="text-align: left;width:25%;"> 
      Making Dept. 制作部 <?php if(isset($info)) echo $info->department_name; ?> </th>
      <th style="width:50%;text-align: left" colspan="2"> 
      Note: <?php if(isset($info)) echo $info->other_note; ?> </th>
    </tr>
</table>
<?php $updates=$this->db->query("SELECT * FROM pi_update_info WHERE pi_id=$info->pi_id")->result();
  if(count($updates)>0){
 ?>
    <p style="width: 100%"> <strong>Update Info:</strong> <?php 
    foreach ($updates as $value){
      echo "<strong>$value->update_date</strong>  $value->update_text";
    }
 ?>
</p>
<?php } ?>
<br>
<form class="form-horizontal" action="<?php echo base_url(); ?>format/purhrequisn/save<?php if (isset($info)) echo "/$info->pi_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
<table class="tg"  style="overflow: hidden;">
  <tr>
    <th style="width:3%;text-align:center;">SN(序号)</th>
    <th style="width:8%;text-align:center;">Material code<br>(物料编码)</th>
    <th style="width:10%;text-align:center;">Material Name<br>(物料名称)</th>
    <th style="width:8%;text-align:center;">Specification<br>(规格)</th>
    <th style="width:6%;text-align:center;">Material Picture<br>(物料图片)</th>
    <th style="width:6%;text-align:center;">Purchased Qty<br>(购买数量)</th>
    <th style="width:8%;text-align:center;">Unit price<br> 单价</th>
    <th style="width:8%;text-align:center;">Amount <br>总金额</th>
    <th style="width:4%;text-align:center;">Currency <br>货币</th>
    <th style="width:6%;text-align:center;">Currency Rate in HKD <br>货币</th>
    <th style="width:10%;text-align:center;">Supplier</th>
    <th style="width:8%;text-align:center;">PO NO </th>
    <th style="width:10%;text-align:center;">ERP ITEM CODE</th>
    <th style="width:8%;text-align:center;">FILE NO</th>
  </tr>
  <?php
  if(isset($detail)){
	   $i=1; $totalpur=0; $m=0;
     $totalreq=0;
     $optionTree2="";
        foreach ($slist as $rowc):
            $selected='';
            $optionTree2.='<option value="'.$rowc->supplier_id.'" '.$selected.'>'.$rowc->supplier_name.'</option>';
        endforeach;
  	  foreach($detail as $value){ 
       $totalreq=$totalreq+$value->required_qty;
       $totalpur=$totalpur+$value->purchased_qty;
       $optionTree="";
        foreach ($clist as $rowc):
          if($info->purchase_type_id<=2&&$rowc->currency!='BDT'){
            $selected=($rowc->currency==$value->currency)? 'selected="selected"':'';
            $optionTree.='<option value="'.$rowc->currency.'" '.$selected.'>'.$rowc->currency.'</option>';
          }elseif($info->purchase_type_id>=3&&($rowc->currency=='BDT'||$rowc->currency=='USD')){
            $selected=($rowc->currency==$value->currency)? 'selected="selected"':'';
            $optionTree.='<option value="'.$rowc->currency.'" '.$selected.'>'.$rowc->currency.'</option>';
          }
      endforeach;
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class="">
      <?php echo $value->product_name; if($value->china_name!='') echo "($value->china_name)"; ?></td>
    <td class=""><?php echo $value->specification; ?></td>
    <td class="textcenter">
    <?php if (isset($value->product_image)&&!empty($value->product_image)) { ?>
    <img src="<?php echo base_url(); ?>product/<?php echo $value->product_image; ?>" class="img-thumbnail" style="width:100px;height:auto;"/><?php }else{ echo "No Picture";} ?></td>
    <td class="tg-s6z2"><?php echo "$value->purchased_qty"; ?>
    <input type="hidden" value="<?php echo "$value->purchased_qty"; ?>" id="purchased_qty_<?php echo $m; ?>" name="purchased_qty[]" ></td>
    <td class="tg-s6z2">
      <input type="hidden" value="<?php echo "$value->pi_detail_id"; ?>" name="pi_detail_id[]">
      <input type="hidden" value="<?php echo "$value->product_id"; ?>" name="product_id[]">
      <input type="text" class="form-control" value="<?php echo "$value->unit_price"; ?>" name="unit_price[]" id="unit_price_<?php echo $m; ?>"   onblur="return checkQuantity(<?php echo $m; ?>);" onkeyup="return checkQuantity(<?php echo $m; ?>);" ></td>
    <td class="tg-s6z2">
      <input type="text" class="form-control" readonly value="<?php echo "$value->amount"; ?>" name="amount[]" id="amount_<?php echo $m; ?>"></td>
    <td class="tg-s6z2">
      <select name="currency[]" class="form-control"  style="width:100%;" id="currency_<?php echo $m; ?>"> <?php echo $optionTree; ?></select>
    </td> 
    <td class="tg-s6z2">
      <input type="text" class="form-control" value="<?php echo "$value->cnc_rate_in_hkd"; ?>" name="cnc_rate_in_hkd[]" id="cnc_rate_in_hkd_<?php echo $m; ?>"></td>
    <td class="tg-s6z2">
      <select name="supplier_id[]" class="form-control select2"  style="width:100%;" id="supplier_id_<?php echo $m; ?>"  >
      <option value="" selected="selected">Select 选择</option>
      <?php if($value->supplier_id>0){  ?>
      <option value="<?php echo $value->supplier_id; ?>" selected="selected"><?php echo getSupplier($value->supplier_id); ?></option>
      <?php } ?>
      <?php echo $optionTree2; ?>
    </select>
    </td> 
    <td class="tg-s6z2">
      <input type="text" class="form-control"  value="<?php echo "$value->po_no"; ?>" name="po_no[]" id="po_no_<?php echo $m; ?>"></td>
    <td class="tg-s6z2">
      <input type="text" class="form-control"  value="<?php echo "$value->erp_item_code"; ?>" name="erp_item_code[]" id="erp_item_code_<?php echo $m; ?>"></td>
    <td class="tg-s6z2">
      <input type="text" class="form-control"  value="<?php echo "$value->file_no"; ?>" name="file_no[]" id="file_no_<?php echo $m; ?>"></td>

  </tr>
   <?php 
   $m++; 
    }
 } ?>
   <tr>
    <th sty colspan="5" style="text-align: right;" >Total</th>
    <th class="tg-s6z2"><?php echo $totalpur; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
  </tr>
</table>
<p style="text-align: left;width: 50%;float: left;overflow: hidden;">
<?php if($info->reject_note!=''){?>

  Note: <?php if(isset($info)) echo $info->reject_note; ?>

<?php } ?>
</p>
<p style="text-align: right;width: 40%;float: left;overflow: hidden;">
  Promised date of using up:  
  <br>承诺用完日期： <?php if(isset($info)) echo findDate($info->promised_date); ?>
</p>
<br><br>
<table class="tg1" style="overflow: hidden;">
 <tr>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
</tr>
  <tr>
  <td style="width:25%;text-align:left;">
    <?php if($info->pi_status>=4&&$info->pi_status!=8) echo "$info->certified_name"; ?></td>
  <td style="width:25%;text-align:center;">
    <?php if($info->pi_status>=5&&$info->pi_status!=8) echo "$info->verified_name"; ?></td>
  <td style="width:25%;text-align:center;">
  <?php if($info->pi_status>=6&&$info->pi_status!=8) echo "$info->receive_by"; ?></td>
  <td style="width:25%;text-align:right;">
  <?php if($info->pi_status>=7&&$info->pi_status!=8) echo "$info->approve_by"; ?></td>
  </tr>
  <tr>

  <td style="text-align:left;">
  <?php if($info->pi_status>=4&&$info->pi_status!=8) echo findDate($info->certified_date); ?></td>
  <td style="text-align:center;">
    <?php if($info->pi_status>=5&&$info->pi_status!=8) echo findDate($info->verified_date); ?></td>
  <td style="text-align:center;">
    <?php if($info->pi_status>=6&&$info->pi_status!=8) echo findDate($info->received_date); ?></td>
  <td style="text-align:right;">
    <?php if($info->pi_status>=7&&$info->pi_status!=8) echo findDate($info->approved_date); ?></td>
  </tr>
  <tr>
    <td style="text-align:left;font-size: 15px;line-height: 5px">---------------</td>
    <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
    <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
    <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Certified by DIV.H
   <br> 板块负责人确认</td>
    <td style="text-align:center;">Verified by IA
   <br> IA查实</td>  
  <td style="text-align:center;">Received by Pur.
  <br> 采购部接收</td>
  <td style="text-align:right;">Approved by Malik Ma
  <br> Mailk 批准</td>
  </tr>
</table>

  <div class="box-footer">
  <div class="col-sm-4">
    <a href="<?php echo base_url(); ?>format/purhrequisn/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
    <div class="col-sm-4">
    <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> SAVE 保存</button>
  </div>

  </div>
  </form>
</div>
</div>
</div>
<script>
  function checkQuantity(ids){
   var unit_price=parseFloat($.trim($("#unit_price_"+ids).val()));
   var purchased_qty=parseFloat($.trim($("#purchased_qty_"+ids).val()));
   if($.trim(unit_price)==""|| $.isNumeric(unit_price)==false){
     $("#unit_price_"+ids).val(0);
        unit_price=0;
   }
   $("#amount_"+ids).val(purchased_qty*unit_price);
  }

</script>

