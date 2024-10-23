<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>payment/applications/save<?php if (isset($info)) echo "/$info->payment_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-1 control-label ">Pay To:<span style="color:red;">  *</span></label>
          <div class="col-sm-4">
          <select class="form-control" name="supplier_id" id="supplier_id" style="width: 100%">  
            <option value="" selected="selected">Select 选择</option>
            <?php foreach ($palist as $rows) { ?>
              <option value="<?php echo $rows->supplier_id; ?>" 
              <?php if (isset($info))
                  echo $rows->supplier_id==$info->supplier_id ? 'selected="selected"' : 0;
                  else
                  echo $rows->supplier_id==set_value('supplier_id') ? 'selected="selected"' : 0;
                  ?>>
                  <?php echo $rows->supplier_name; ?></option>
                  <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("supplier_id"); ?></span>
            </div>
            <div class="col-sm-1">
              <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#partyModal"><i class="fa fa-plus"></i></a>
            </div> 
         <label class="col-sm-1 control-label">Date<span style="color:red;">  *</span> </label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="applications_date" readonly id="applications_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->applications_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("applications_date");?></span>
          </div>
          <label class="col-sm-1 control-label">
            PA Type <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="pa_type" id="pa_type" style="width: 100%" required> 
            <option value="" selected="selected">Select 选择</option>
              <option value="Service" <?php if (isset($info))
                  echo 'Service'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Service'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Service</option>
              <option value="Safety Stock" <?php if (isset($info))
                  echo 'Safety Stock'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Safety Stock'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Safety Stock</option>
              <option value="Assets" <?php if (isset($info))
                  echo 'Assets'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Assets'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Assets</option>
              <option value="Miscellaneous Exp" <?php if (isset($info))
                  echo 'Miscellaneous Exp'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Miscellaneous Exp'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Miscellaneous Exp</option>
              <option value="Supplement" <?php if (isset($info))
                  echo 'Supplement'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Supplement'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Supplement</option>
              </select>
           <span class="error-msg"><?php echo form_error("pa_type");?></span>
         </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
          
          <label class="col-sm-2 control-label">
            Payment Term <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="pay_term" id="pay_term" style="width: 100%" required> 
            <option value="" selected="selected">Select 选择</option>
            <?php foreach ($plist as $rows) { ?>
              <option value="<?php echo $rows->pay_term; ?>" 
              <?php if (isset($info))
                  echo $rows->pay_term==$info->pay_term ? 'selected="selected"' : 0;
                  else
                  echo $rows->pay_term==set_value('pay_term') ? 'selected="selected"' : 0;
                  ?>>
                  <?php echo $rows->pay_term; ?></option>
                  <?php } ?>
              </select>
           <span class="error-msg"><?php echo form_error("pay_term");?></span>
         </div>
         <label class="col-sm-1 control-label">
            Currency<span style="color:red;">*</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="currency" id="currency" style="width: 100%" required> 
            <option value="" selected="selected">Select 选择</option>
              <option value="BDT" <?php if (isset($info))
                  echo 'BDT'==$info->currency ? 'selected="selected"' : 0;
                  else echo 'BDT'==set_value('currency') ? 'selected="selected"' : 0; ?>>BDT</option>
              <option value="RMB" <?php if (isset($info))
                  echo 'RMB'==$info->currency ? 'selected="selected"' : 0;
                  else echo 'RMB'==set_value('currency') ? 'selected="selected"' : 0; ?>>RMB</option>
              <option value="HKD" <?php if (isset($info))
                  echo 'HKD'==$info->currency ? 'selected="selected"' : 0;
                  else echo 'HKD'==set_value('currency') ? 'selected="selected"' : 0; ?>>HKD</option>
              <option value="USD" <?php if (isset($info))
                  echo 'USD'==$info->currency ? 'selected="selected"' : 0;
                  else echo 'USD'==set_value('currency') ? 'selected="selected"' : 0; ?>>USD</option>
              </select>
           <span class="error-msg"><?php echo form_error("currency");?></span>
         </div>
          <label class="col-sm-3 control-label ">
            Update Currency Rate in HKD<span style="color:red;"> * </span></label>
          <div class="col-sm-2">
            <input type="text" name="currency_rate_in_hkd" id="currency_rate_in_hkd" class="form-control" value="<?php if(isset($info)) echo $info->currency_rate_in_hkd; else echo set_value('currency_rate_in_hkd'); ?>" required>
              <span class="error-msg"><?php echo form_error("currency_rate_in_hkd"); ?></span>
          </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
          <label class="col-sm-2 control-label ">Approve By:<span style="color:red;">  *</span></label>
          <div class="col-sm-3">
          <select class="form-control select2" name="approved_by" id="approved_by" style="width: 100%">  
            <option value="" selected="selected">Select 选择</option>
            <?php foreach ($ulist as $rows) { ?>
              <option value="<?php echo $rows->id; ?>" 
              <?php if (isset($info))
                  echo $rows->id==$info->approved_by? 'selected="selected"' : 0;
                  else
                  echo $rows->id==set_value('approved_by') ? 'selected="selected"' : 0;
                  ?>>
                  <?php echo $rows->user_name; ?></option>
                  <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("approved_by"); ?></span>
            </div>
          <label class="col-sm-1 control-label ">
            Note:<span style="color:red;">  </span></label>
          <div class="col-sm-4">
            <input type="text" name="description" id="description" class="form-control" value="<?php if(isset($info)) echo $info->description; else echo set_value('description'); ?>">
              <span class="error-msg"><?php echo form_error("description"); ?></span>
          </div>
          
      </div><!-- ///////////////////// -->
      <div class="form-group">
        <div class="col-sm-8" style="text-align: right;margin-bottom:10px;">  
        <div class="table-responsive">
        <table class="table table-bordered" id="form-table">
        <thead>
        <tr>
          <th style="width:5%;text-align:center">SN</th>
          <th style="width:50%;text-align:center">Bill Description</th>
          <th style="width:20%;text-align:center;">Percentage</th>
          <th style="width:20%;text-align:center;">Amount</th>
          <th style="width:5%;text-align:center">
            <i class="fa fa-trash-o"></i></th></tr>
        </thead>
        <tbody>
         <?php
         $i=0;
         $id=0;
          if(isset($detail)):
            foreach ($detail as  $value){
               $optionTree1="";
                foreach ($hlist as $rowc):
                    $selected=($rowc->head_id==$value->head_id)? 'selected="selected"':'';
                    $optionTree1.='<option value="'.$rowc->head_id.'" '.$selected.'>'.$rowc->head_name.'</option>'; 
                endforeach;

             $str='<tr id="row_' . $id . '"><td style="text-align:center"><b>' . ($id +1).'</b></td>';
              $str.='<td style="text-align:left"><select name="head_id[]" class="form-control select2"  style="width:100%;" id="head_id_' . $id . '" required><option value="" selected="selected">Select</option> '.$optionTree1.'</select> </td> ';
              $str.= '<td></td>';
              $str.= '<td><input type="text" name="amount[]" class="form-control integerchk" placeholder="Amount"  onblur="return TcalSum();" onkeyup="return TcalSum();"  value="'.$value->amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"/> </td>';
              $str.= '<td style="text-align:center"><span class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td></tr>';
              echo $str;
              $id++;
              }
              endif;
          ?>
        </tbody>
        </table>
          <div class="col-sm-12" style="text-align: right;margin-bottom:10px;">
           <a id="AddManualItem" class="btn btn-info">
            <i class="fa fa-plus-square"></i> Add Row</a>
          </div>
         <table class="table table-bordered">
          <tbody>
          <tr>
            <td style="width:5%;text-align:center"></td>
            <td style="width:50%;text-align:center">Add: VAT</td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="vat_add_per" id="vat_add_per" onblur="return TcalSum();" onkeyup="return TcalSum();" class="form-control integerchk" style="text-align: right;float: left;width: 80%" value="<?php if(isset($info)) echo $info->vat_add_per; else echo 0; ?>">
               <label class="control-label" style="text-align: left;float: left;width: 20%">%</label>
            </td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="vat_add_amount" id="vat_add_amount" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $info->vat_add_amount; else echo 0; ?>">
            </td>
            <td style="width:5%;text-align:center"></td>
          </tr>
          <tr>
            <td style="width:5%;text-align:center"></td>
            <td style="width:50%;text-align:center">Add: AIT</td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="ait_add_per" id="ait_add_per" onblur="return TcalSum();" onkeyup="return TcalSum();" class="form-control integerchk" style="text-align: right;float: left;width: 80%" value="<?php if(isset($info)) echo $info->ait_add_per; else echo 0; ?>">
               <label class="control-label" style="text-align: left;float: left;width: 20%">%</label>
            </td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="ait_add_amount" id="ait_add_amount" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $info->ait_add_amount; else echo 0; ?>">
            </td>
            <td style="width:5%;text-align:center"></td>
          </tr>
          <tr>
            <td style="width:5%;text-align:center"></td>
            <th style="width:50%;text-align:center">Adjusted Bill Amount</th>
            <td style="width:20%;text-align:center;">
            </td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="sub_total" id="sub_total" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $info->sub_total; else echo 0; ?>">
            </td>
            <td style="width:5%;text-align:center"></td>
          </tr>
          <tr>
            <td style="width:5%;text-align:center"></td>
            <td style="width:50%;text-align:center">Less:  VAT</td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="vat_less_per" id="vat_less_per" onblur="return TcalSum();" onkeyup="return TcalSum();" class="form-control integerchk" style="text-align: right;float: left;width: 80%" value="<?php if(isset($info)) echo $info->vat_less_per; else echo 0; ?>">
               <label class="control-label" style="text-align: left;float: left;width: 20%">%</label>
            </td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="vat_less_amount" id="vat_less_amount" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $info->vat_less_amount; else echo 0; ?>">
            </td>
            <td style="width:5%;text-align:center"></td>
          </tr>
          <tr>
            <td style="width:5%;text-align:center"></td>
            <td style="width:50%;text-align:center">Less: AIT</td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="ait_less_per" id="ait_less_per" onblur="return TcalSum();" onkeyup="return TcalSum();" class="form-control integerchk" style="text-align: right;float: left;width: 80%" value="<?php if(isset($info)) echo $info->ait_less_per; else echo 0; ?>">
               <label class="control-label" style="text-align: left;float: left;width: 20%">%</label>
            </td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="ait_less_amount" id="ait_less_amount" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $info->ait_less_amount; else echo 0; ?>">
            </td>
            <td style="width:5%;text-align:center"></td>
          </tr>
           <tr>
            <td style="width:5%;text-align:center"></td>
            <td style="width:50%;text-align:center">
              <input type="text" name="other_note" placeholder="Other adjustment" id="other_note" class="form-control" style="text-align: center;float: left;" value="<?php if(isset($info)) echo $info->other_note;  ?>">
            </td>
            <td style="width:20%;text-align:center;">
              <select class="form-control" name="other_plus_minus" id="other_plus_minus" onchange="return TcalSum();"> 
                <option value="Plus" 
                <?php if (isset($info)) echo 'Plus' == $info->other_plus_minus ? 'selected="selected"' : 0;
                else echo 'Plus' == set_value('other_plus_minus') ? 'selected="selected"' : 0;
                ?>>Plus</option>
                <option value="Minus" 
                <?php if (isset($info)) echo 'Minus' == $info->other_plus_minus ? 'selected="selected"' : 0;
                else echo 'Minus' == set_value('other_plus_minus') ? 'selected="selected"' : 0;
                ?>>Minus</option>
                </select>
            </td>
            <td style="width:20%;text-align:center;">
              <input type="text" name="other_amount" id="other_amount" onblur="return TcalSum();" onkeyup="return TcalSum();" class="form-control integerchk" style="text-align: center;" value="<?php if(isset($info)) echo $info->other_amount; else echo 0; ?>">
            </td>
            <td style="width:5%;text-align:center"></td>
          </tr>
          <tr>
            <td style="width:5%;text-align:center"></td>
            <td style="width:50%;text-align:center"></td>
            <th style="width:20%;text-align:center;">Net Payment:
            </th>
            <td style="width:20%;text-align:center;">
              <input type="text" name="total_amount" id="total_amount" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $info->total_amount; else echo 0; ?>">
            </td>
            <td style="width:5%;text-align:center"></td>
          </tr>
        </tbody>
        </table>
        </div>
      </div>
      
      <div class="col-sm-4" style="text-align: right;margin-bottom:10px;">  
        <div class="table-responsive">
        <table class="table table-bordered" id="form-table1">
        <thead>
        <tr>
          <th style="width:10%;text-align:center">SN</th>
          <th style="width:50%;text-align:center">Department</th>
          <th style="width:30%;text-align:center;">Amount</th>
          <th style="width:10%;text-align:center">
            <i class="fa fa-trash-o"></i></th></tr>
        </thead>
        <tbody>
         <?php
         $i=0;
         $id=0;
          if(isset($detail1)):
            foreach ($detail1 as  $value){
              $optionTree="";
                foreach ($clist as $rowc):
                    $selected=($rowc->dcode==$value->dcode)? 'selected="selected"':'';
                    $optionTree.='<option value="'.$rowc->dcode.'" '.$selected.'>'.$rowc->department_name.'</option>'; 
                endforeach;
              $str='<tr id="row1_' . $id . '"><td style="text-align:center"><b>' . ($id +1).'</b></td>';
              $str.='<td style="text-align:left"><select name="dcode[]" class="form-control select2"  style="width:100%;" id="dcode_' . $id . '"> '.$optionTree.'</select> </td> ';
              $str.= '<td><input type="text" name="damount[]" class="form-control integerchk" placeholder="Amount"  onblur="return DcalSum(' . $id . ');" onkeyup="return DcalSum(' . $id . ');"  value="'.$value->damount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="damount_'.$id.'"/> </td>';
              $str.= '<td style="text-align:center"><span class="btn btn-danger btn-xs" onclick="return deleter1('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td></tr>';
              echo $str;
              $id++;
              }
              endif;
              ?>
        </tbody>
        </table>
        <table class="table table-bordered" >
        <tr>
            <td style="width:10%;text-align:center"></td>
            <th style="width:50%;text-align:center;">
              Total Amount:
            </th>
            <td style="width:30%;text-align:center;">
              <input type="text" name="dtotal_amount" id="dtotal_amount" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $info->dtotal_amount; else echo 0; ?>">
            </td>
            <td style="width:10%;text-align:center"></td>
          </tr>
      </table>
          <div class="col-sm-12" style="text-align: right;margin-bottom:10px;">
           <a id="AddManualItem1" class="btn btn-info">
            <i class="fa fa-plus-square"></i> Add Row</a>
          </div>

        </div>
      </div>
    </div>
      <div class="form-group">
          <label class="col-sm-2 control-label">Attachment 
            <span style="color:red;"> * </span></label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="attachemnt_file" class="form-control" >
            <?php if(isset($info) &&!empty($info->attachemnt_file)) { ?>
              <div style="margin-top:10px;">
                <input type="hidden" name="attachemnt_file_p" value="<?php echo $info->attachemnt_file; ?>">
              <a href="<?php echo base_url(); ?>dashboard/dpayment/<?php echo $info->attachemnt_file; ?>">Download</a>
              </div>
            <?php } ?>
            <span>Allows Type: jpg,png, pdf.</span>
            <p class="error-msg"><?php  
                if(isset($exception_err)) echo $exception_err; ?></p>
          </div>
        </div>
      </div>
          <!-- /.box-body -->
          <div class="box-footer">
          <div class="col-sm-4">
            <a href="<?php echo base_url(); ?>payment/applications/lists" class="btn btn-info">
            <i class="fa fa-arrow-circle-o-left" aria-hidden="true">
            </i> 
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

<div class="modal fade" id="partyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Pay To Info</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label">Vendor Name <span style="color:red;">  *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="supplier_name" placeholder="Name" value="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Address <span style="color:red;">  *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="company_address">
            </div>
          </div>
      
          <div class="form-group">
            <label class="col-sm-4 control-label">Telephone </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="phone_no">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Email </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="email_address">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addNew">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('asset/payto.js');?>"></script>

<script type="text/javascript">
var count = 1
$(function () {
  "use strict";

  $(document).on('click','input[type=number]', function(){
   this.select(); 
 });
  $('.date').datepicker({
      "format": "dd/mm/yyyy",
      "todayHighlight": true,
      "endDate": "FromEndDate", 
      "autoclose": true
  });

 
});
//////////////
var deletedRow=[];
var deletedRow1=[];
var payment_ids='';
<?php  
if(isset($info)){ 
   ?>
    var id=<?php echo count($detail); ?>;
    var payment_ids=<?php echo $info->payment_id; ?>;
  <?php }else{ ?>
    var id=0;
<?php  } ?>
<?php  
if(isset($info)){ 
   ?>
    var id1=<?php echo count($detail1); ?>;
  <?php }else{ ?>
    var id1=0;
<?php  } ?>
var deptselect='<?php if(isset($clist)){
     foreach ($clist as $rows) {?><option value="<?php echo $rows->dcode; ?>"><?php echo "$rows->department_name";?></option><?php }} ?> ';

var headselect='<?php if(isset($hlist)){
     foreach ($hlist as $rows) {?><option value="<?php echo $rows->head_id; ?>"><?php echo "$rows->head_name";?></option><?php }} ?> ';

$(document).ready(function(){
$("#AddManualItem").click(function(){
  var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><b></b></td>'+
    '<td style="text-align:left"><select name="head_id[]" required class="form-control select2" style="width:100%;text-align:left"  id="head_id_' + id + '"> <option value="" selected="selected">Select</option>'+headselect+'</select> </td>' +
    '<td> </td>'+
    '<td> <input type="text" name="amount[]" value="0" onblur="return TcalSum();" onkeyup="return TcalSum();" class="form-control integerchk"  placeholder="Amount" style="width:98%;float:left;text-align:center"  id="amount_' + id + '"> </td>' +
    ' <td style="text-align:center"> <span class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </span> </td> </tr>';
    $("#form-table tbody").append(nodeStr);
    updateRowNo();
    id++;
    $('.select2').select2();
    TcalSum();

});
//////////////////////////
$("#AddManualItem1").click(function(){
  var subTotal=0;
  //var serviceNum=$("#form-table1 tbody tr").length;
  for(var i=0;i<id1;i++){
    if(deletedRow1.indexOf(i)<0) {
     subTotal += parseFloat($.trim($("#damount_" + i).val()));
    }
  }
  var sub_total=parseFloat($("#sub_total").val());
  var rstofamount=sub_total-subTotal;
  var nodeStr = '<tr id="row1_' + id1 + '"><td  style="text-align:center"><b></b></td>'+
    '<td td style="text-align:left"><select name="dcode[]" onchange="return checkdepart(' + id1 + ');" required class="form-control select2" style="width:100%;"  id="dcode_' + id1 + '"> <option value="" selected="selected">Select</option>'+deptselect+'</select> </td>' +

    '<td><input type="text" onblur="return DcalSum(' + id1 + ');" onkeyup="return DcalSum(' + id1 + ');" name="damount[]" value="' + rstofamount + '" class="form-control integerchk"  placeholder="Amount" style="width:98%;float:left;text-align:center" id="damount_' + id1 + '"></td>' +
    ' <td style="text-align:center"> <span class="btn btn-danger btn-xs" onclick="return deleter1(' + id1 + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </span> </td> </tr>';
    $("#form-table1 tbody").append(nodeStr);
    updateRowNo1();
    
    id1++;
    $('.select2').select2();
    DcalSum(id1)
  });
 
});
function deleter(id2){
    $("#row_"+id2).remove();
    deletedRow.push(id2);
    updateRowNo();
}
    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
function updateRowNo(){
    var numRows=$("#form-table tbody tr").length;
    for(var r=0;r<numRows;r++){
        $("#form-table tbody tr").eq(r).find("td:first b").text(r+1);
    }
    TcalSum();

}
///////////////
function deleter1(id2){
        $("#row1_"+id2).remove();
        deletedRow1.push(id2);
        updateRowNo1();
    }
    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
function updateRowNo1(){
    var numRows=$("#form-table1 tbody tr").length;
    for(var r=0;r<numRows;r++){
        $("#form-table1 tbody tr").eq(r).find("td:first b").text(r+1);
    }
    DcalSum(0);
}
 

function formsubmit(){
  var error_status=false;
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Item!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var supplier_id=$("#supplier_id").val();
  var applications_date=$("#applications_date").val();
  if(supplier_id == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select Pay To!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#supplier_id").css('border', '1px solid #ccc');      
  } 
  for(var i=0;i<serviceNum;i++){
    if($("#amount_"+i).val()==''){
      $("#amount_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    }

  if(applications_date == '') {
    error_status=true;
    $("#applications_date").css('border', '1px solid #f00');
  } else {
    $("#applications_date").css('border', '1px solid #ccc');      
  }
  var sub_total=parseFloat($.trim($("#sub_total").val()));
  var dtotal_amount=parseFloat($.trim($("#dtotal_amount").val()));
  if(sub_total!=dtotal_amount){
     $("#alertMessageHTML").html("Adjusted Bill Amount & departmental amount must be equal!!");
      $("#alertMessagemodal").modal("show");
      error_status=true;
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
function TcalSum(){
  var subTotal=0;
  var serviceNum=$("#form-table tbody tr").length;
  for(var i=0;i<id;i++){
    if(deletedRow.indexOf(i)<0) {
     subTotal += parseFloat($.trim($("#amount_" + i).val()));
    }
  }
  
  var vat_add_per=parseFloat($("#vat_add_per").val());
  if($.trim(vat_add_per)==""|| typeof vat_add_per === "undefined"){
    vat_add_per=0;
  }
  var vataddamount=subTotal*vat_add_per/100;
  $("#vat_add_amount").val(vataddamount.toFixed(2));
  ///////////////////////////////
  var ait_add_per=parseFloat($("#ait_add_per").val());
  var aitaddamount=subTotal*ait_add_per/100;
   ///////////////////////////
  $("#ait_add_amount").val(aitaddamount.toFixed(2));
  $("#sub_total").val((subTotal+vataddamount+aitaddamount).toFixed(2));
  /////////////////////////////
  var sub_total=parseFloat($("#sub_total").val());
  /////////////////////////////////////
  var vat_less_per=parseFloat($("#vat_less_per").val());
  var vatlessamount=subTotal*vat_less_per/100;
  $("#vat_less_amount").val(vatlessamount.toFixed(2));
  //////////////////////////
  var ait_less_per=parseFloat($("#ait_less_per").val());
  var aitlessamount=subTotal*ait_less_per/100;
  $("#ait_less_amount").val(aitlessamount.toFixed(2));
  
  ////////////////
  ///$("#total_amount").val((subTotal+vataddamount+aitaddamount-vatlessamount-aitlessamount).toFixed(2));
  ////////////////
  var other_amount=parseFloat($("#other_amount").val());
  if($.trim(other_amount)==""|| typeof other_amount === "undefined"){
    other_amount=0;
  }
  if(other_plus_minus=='Plus'){
    $("#total_amount").val((subTotal+vataddamount+aitaddamount+other_amount-vatlessamount-aitlessamount).toFixed(2));
  }else{
    $("#total_amount").val((subTotal+vataddamount+aitaddamount-other_amount-vatlessamount-aitlessamount).toFixed(2));
  }
  
 
  }

  ///////////////////////////////
  function departmentSum(){
  var subTotal=0;
  var serviceNum=$("#form-table1 tbody tr").length;
  for(var i=0;i<id1;i++){
    if(deletedRow1.indexOf(i)<0) {
     subTotal += parseFloat($.trim($("#damount_" + i).val()));
    }
  }
  var sub_total=parseFloat($("#sub_total").val());

  $("#dtotal_amount").val(subTotal.toFixed(2));
  ////////////////
}
function DcalSum(id2){
  var subTotal=0;
  var serviceNum=$("#form-table1 tbody tr").length;
  for(var i=0;i<id1;i++){
    if(deletedRow1.indexOf(i)<0) {
     subTotal += parseFloat($.trim($("#damount_" + i).val()));
    }
  }
  var sub_total=parseFloat($("#sub_total").val());
  if($.trim(sub_total)==""|| typeof sub_total === "undefined"){
    sub_total=0;
  }
  if(subTotal>sub_total){
     $("#alertMessageHTML").html("Departmental amount can not exceed adjusted bill amount !!");
      $("#alertMessagemodal").modal("show");
      $("#damount_"+id2).val(0);
  }
  $("#dtotal_amount").val(subTotal.toFixed(2));
  ////////////////
}
  function checkdepart(id2){
    var newdid=$("#dcode_"+id2).val();
    var chkname=1;
    var serviceNum=$("#form-table1 tbody tr").length;

    for(var i=0;i<id1;i++){
      if(deletedRow1.indexOf(i)<0) {
      var oldid =$("#dcode_" + i).val();
        if(oldid==newdid && i!=id2){
           chkname=2;
        }
      }
      }
      if(chkname==2){
       $("#alertMessageHTML").html("Can not select same department twice!!");
        $("#alertMessagemodal").modal("show");
        $("#dcode_"+id2).val('').change();
    }

  }
</script>