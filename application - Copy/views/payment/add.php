<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
$(function () {
  $(document).on('click','input[type=number]',function(){ this.select(); });
      $('.date').datepicker({
          "format": "dd/mm/yyyy",
          "todayHighlight": true,
          "endDate": '0d',
          "autoclose": true
      });
    });
  </script>
<div class="row">
    <div class="col-md-12">
<form class="form-horizontal" action="<?php echo base_url(); ?>payment/applications/save<?php if (isset($info)) echo "/$info->payment_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
        <div class="box box-info">
      <!-- /.box-header -->
    
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-1 control-label ">Pay To:<span style="color:red;">  *</span></label>
          <div class="col-sm-4">
          <select class="form-control select2" name="supplier_id" id="supplier_id" style="width: 100%">  
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
            <!-- <div class="col-sm-1"> -->
              <!-- <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#partyModal"><i class="fa fa-plus"></i></a> -->
            <!-- </div>  -->
            <label class="col-sm-1 control-label othername">
            Other:<span style="color:red;"> * </span></label>
          <div class="col-sm-3 othername">
            <input type="text" name="other_name" id="other_name" class="form-control" value="<?php if(isset($info)) echo $info->other_name; else echo set_value('other_name'); ?>" >
              <span class="error-msg"><?php echo form_error("other_name"); ?></span>
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
          
      </div><!-- ///////////////////// -->
      <div class="form-group">
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
               <!-- <option value="Miscellaneous Exp" <?php if (isset($info))
                  echo 'Miscellaneous Exp'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Miscellaneous Exp'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Miscellaneous Exp</option>
              <option value="Supplement" <?php if (isset($info))
                  echo 'Supplement'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Supplement'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Supplement</option> -->
              <option value="Material" <?php if (isset($info))
                  echo 'Material'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Material'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Material</option>
              <option value="Advance" <?php if (isset($info))
                  echo 'Advance'==$info->pa_type ? 'selected="selected"' : 0;
                  else echo 'Advance'==set_value('pa_type') ? 'selected="selected"' : 0;
                  ?>>Advance</option>
              </select>
           <span class="error-msg"><?php echo form_error("pa_type");?></span>
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
              <option value="GBP" <?php if (isset($info))
                  echo 'GBP'==$info->currency ? 'selected="selected"' : 0;
                  else echo 'GBP'==set_value('currency') ? 'selected="selected"' : 0; ?>>GBP</option>
              </select>
           <span class="error-msg"><?php echo form_error("currency");?></span>
         </div>
         <label class="col-sm-2 control-label ">Approve By:<span style="color:red;">  *</span></label>
          <div class="col-sm-3">
            <input type="hidden" name="pa_limit" id="pa_limit" value="<?php if(isset($info)) echo $info->pa_limit; else echo set_value('pa_limit'); ?>">
            
          <select class="form-control select2" name="approved_by" id="approved_by" style="width: 100%" required onchange="checkLimit();">  
            <option value="" selected="selected">Select 选择</option>
            <?php foreach ($ulist as $rows) { ?>
              <option value="<?php echo $rows->id; ?>"  data-paid="<?php echo $rows->pa_limit; ?>"
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
      </div><!-- ///////////////////// -->
      <div class="form-group">
          <label class="col-sm-2 control-label">
          Purchase Verification Need<span style="color:red;">*</span></label>
           <div class="col-sm-2">
            <select class="form-control select2" name="verification_need" id="verification_need" style="width: 100%" required> 
            <option value="" selected="selected">Select 选择</option>
              <option value="NO" <?php if (isset($info))
                  echo 'NO'==$info->verification_need ? 'selected="selected"' : 0;
                  else echo 'NO'==set_value('verification_need') ? 'selected="selected"' : 0; ?>>NO</option>
              <option value="YES" <?php if (isset($info))
                  echo 'YES'==$info->verification_need ? 'selected="selected"' : 0;
                  else echo 'YES'==set_value('verification_need') ? 'selected="selected"' : 0; ?>>YES</option>
              </select>
           <span class="error-msg"><?php echo form_error("verification_need");?></span>
          </div>
          <label class="col-sm-1 control-label ">
            To:<span style="color:red;">  </span></label>
          <div class="col-sm-3">
          <select class="form-control select2" name="company_id" id="company_id" style="width: 100%" required="">  
            <?php foreach ($blist as $rows) { ?>
              <option value="<?php echo $rows->id; ?>" 
              <?php if (isset($info))
                  echo $rows->id==$info->company_id? 'selected="selected"' : 0;
                  else
                  echo $rows->id==set_value('company_id') ? 'selected="selected"' : 0;
                  ?>>
                  <?php echo $rows->company_name; ?></option>
                  <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("company_id"); ?></span>
            </div>
          <label class="col-sm-1 control-label ">
            Note:<span style="color:red;">  </span></label>
          <div class="col-sm-3">
            <input type="text" name="description" id="description" class="form-control" value="<?php if(isset($info)) echo $info->description; else echo set_value('description'); ?>">
              <span class="error-msg"><?php echo form_error("description"); ?></span>
          </div>
          
      </div><!-- ///////////////////// -->
      <div class="form-group">
        <div class="col-sm-12" style="text-align: right;margin-bottom:10px;">  
        <div class="table-responsive">
        <table class="table table-bordered" id="formtable">
        <thead>
        <tr>
          <th style="width:5%;text-align:center">SN</th>
          <th style="width:25%;text-align:center">Bill Description</th>
          <th style="width:10%;text-align:center;">Amount</th>
          <th style="width:15%;text-align:center;">Remarks</th>
          <th style="width:35%;text-align:center;">Department</th>
          <th style="width:5%;text-align:center">
            <i class="fa fa-trash-o"></i></th></tr>
        </thead>
        <tbody class="dddd">
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
              $str='<tr class="hclass" id="row_' . $id . '"><td style="text-align:center"><input type="hidden" name="parameter[]" value="' . $id . '"  id="parameter_'. $id .  '"><b>' . ($id +1).'</b></td>';
              $str.='<td style="text-align:left"><select name="head_id[]" onchange="return checkHead(' . $id . ');" class="form-control select2"  style="width:100%;" id="head_id_' . $id . '" required><option value="" selected="selected">Select</option> '.$optionTree1.'</select> </td> ';
              $str.= '<td><input type="text" onfocus="this.select()"  name="amount[]" class="form-control integerchk" placeholder="Amount"  onblur="return TcalSum();" onkeyup="return TcalSum();"  value="'.$value->amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"/> </td>';
              $str.= '<td><input type="text" name="remarks[]" class="form-control" placeholder="Remarks"   style="margin-bottom:5px;width:98%;text-align:center" id="remarks_'.$id.'" value="'.$value->remarks.'"> </td>';
            echo $str;
          ?>
        <td>
        <table class="table table-bordered" id="formtable<?php echo $id; ?>">
        <tbody>
         <?php
         $detail1=$this->applications_model->getDetails1($payment_id,$value->head_id);
         $i=0;
          if(isset($detail1)):
            foreach ($detail1 as  $value2){
              $optionTree="";
              foreach ($clist as $rowc):
                $selected=($rowc->dcode==$value2->dcode)? 'selected="selected"':'';
                $optionTree.='<option value="'.$rowc->dcode.'" '.$selected.'>'.$rowc->department_name.'</option>'; 
              endforeach;
              $str='<tr  class="rowCount'.$id.'" data-id="'.$i.'" id="row1_' .$id.$i. '" id="row1_' . $i . '">';
              $str.='<td style="text-align:left;width:50%">
              <select name="dcode'.$id.'[]" onchange="return checkdepart(' . $id . ','.$i.');" class="form-control select2"  style="width:100%;" id="dcode'.$id.'_' . $i . '"> '.$optionTree.'</select> </td> ';
              $str.= '<td style="width:30%"><input type="text" onfocus="this.select()"  name="damount'.$id.'[]" class="form-control integerchk" placeholder="Amount"  onblur="return DcalSum(' . $id . ','.$i.');" onkeyup="return DcalSum(' . $id . ','.$i.');"  value="'.$value2->damount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="damount'.$id.'_'.$i.'"/> </td>';
              $str.= '<td style="text-align:center;width:10%"><span class="btn btn-danger btn-xs" onclick="return deleter1(' . $id . ','.$i.');" style="margin-top:5px;">
              <i class="fa fa-trash-o"></i></span></td></tr>';
              echo $str;
              $i++;
          }
          endif;
          ?>
        </tbody>
        </table>
          <table class="table table-bordered" >
            <tr>
                <th style="width:60%;text-align:center;">
                  Total:
                </th>
                <td style="width:30%;text-align:center;">
                  <input type="text" name="dtotal_amount<?php echo $id; ?>" id="dtotal_amount<?php echo $id; ?>" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $value->amount; else echo 0; ?>">
                </td>
                <td style="width:10%;text-align:center">
                  <a onclick="addDepartment(<?php echo $id; ?>)" class="btn btn-info">
                <i class="fa fa-plus-square"></i> Add Row</a>
                </td>
              </tr>
            </table>
            </td>
              <?php
               echo '<td style="text-align:center"><span class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td> </tr>';
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
             <input type="hidden" name="vat_add_per" id="vat_add_per" onblur="return TcalSum();" onkeyup="return TcalSum();" value="<?php if(isset($info)) echo $info->vat_add_per; else echo 0; ?>">
              <input type="hidden" name="vat_add_amount" id="vat_add_amount" value="<?php if(isset($info)) echo $info->vat_add_amount; else echo 0; ?>">
              <input type="hidden" name="ait_add_per" id="ait_add_per" onblur="return TcalSum();" onkeyup="return TcalSum();" value="<?php if(isset($info)) echo $info->ait_add_per; else echo 0; ?>">
              <input type="hidden" name="ait_add_amount" id="ait_add_amount"  value="<?php if(isset($info)) echo $info->ait_add_amount; else echo 0; ?>">
              <input type="hidden" name="sub_total" id="sub_total" value="<?php if(isset($info)) echo $info->sub_total; else echo 0; ?>">
              <input type="hidden" name="vat_less_per" id="vat_less_per" onblur="return TcalSum();" onkeyup="return TcalSum();"  value="<?php if(isset($info)) echo $info->vat_less_per; else echo 0; ?>">
              <input type="hidden" name="vat_less_amount" id="vat_less_amount"  value="<?php if(isset($info)) echo $info->vat_less_amount; else echo 0; ?>">
              <input type="hidden" name="ait_less_per" id="ait_less_per" onblur="return TcalSum();" onkeyup="return TcalSum();"  value="<?php if(isset($info)) echo $info->ait_less_per; else echo 0; ?>">
              <input type="hidden" name="ait_less_amount" id="ait_less_amount"  value="<?php if(isset($info)) echo $info->ait_less_amount; else echo 0; ?>">
             <input type="hidden" name="other_note"  id="other_note"  value="<?php if(isset($info)) echo $info->other_note;  ?>">
              <input type="hidden" name="other_plus_minus"  id="other_plus_minus"  value="<?php if(isset($info)) echo $info->other_plus_minus;  ?>">
              <input type="hidden" name="other_amount" id="other_amount" onblur="return TcalSum();" onkeyup="return TcalSum();" value="<?php if(isset($info)) echo $info->other_amount; else echo 0; ?>">
          <tr>
            <td style="width:5%;text-align:center"></td>
            <td style="width:25%;text-align:center">Net Payment:</td>
            <td style="width:10%;text-align:center;">
              <input type="text" name="total_amount" id="total_amount" readonly class="form-control" style="text-align: center;" value="<?php if(isset($info)) echo $info->total_amount; else echo 0; ?>">
            </td>
            <th style="width:35%;text-align:center;"></th>
            <th style="width:35%;text-align:center;"></th>
            <td style="width:5%;text-align:center"></td>
          </tr>
        </tbody>
        </table>
        </div>
      </div>
    </div>
    </div>
      <div class="form-group ">
        <div class="col-sm-12 poarea" style="text-align: right;margin-bottom:10px;">  
        <div class="table-responsive">
          <table class="table table-bordered" id="form-table3">
          <thead>
          <tr>
            <th style="width:5%;text-align:center">SN</th>
            <th style="width:20%;text-align:center">PO Number</th>
            <th style="width:15%;text-align:center;">Amount</th>
            <th style="width:15%;text-align:center;">PO Amount</th>
            <th style="width:10%;text-align:center;">Currency </th>
            <th style="width:15%;text-align:center;">PO Due Amount</th>
            <th style="width:15%;text-align:center;">GRN Amount(If Available)</th>
            <th style="width:10%;text-align:center">
              <i class="fa fa-trash-o"></i></th></tr>
          </thead>
          <tbody>
           <?php
           $i=0;
           $id=0;
            if(isset($detail3)):
              foreach ($detail3 as  $value){
                $optionTree3="";
                  foreach ($polist as $rowc):
                      $selected=($rowc->po_number==$value->po_number)? 'selected="selected"':'';
                      $optionTree3.='<option value="'.$rowc->po_number.'" '.$selected.'>'.$rowc->po_number.'</option>'; 
                  endforeach;
                $str='<tr id="row3_' . $id . '"><td style="text-align:center"><b>' . ($id +1).'</b></td>';
                $str.='<td style="text-align:left">
                <select name="po_number[]" class="form-control select2" style="width:100%;" id="po_number_' . $id . '" onchange="return checkpo(' . $id . ');" > '.$optionTree3.'</select> </td> ';
                $str.= '<td><input type="text" name="pamount[]" class="form-control integerchk" placeholder="Amount"  value="'.$value->pamount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="pamount_'.$id.'" onblur="return pocalculation(' . $id .');" onkeyup="return pocalculation(' . $id . ');"> </td>';
                $str.= '<td><input type="text" readonly name="actual_amount[]" class="form-control" placeholder="actual_amount"  value="'.$value->actual_amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="actual_amount_'.$id.'"/> </td>';
                $str.= '<td><input type="text" readonly name="pocurrency[]" class="form-control" placeholder="pocurrency"  value="'.$value->pocurrency.'"   style="margin-bottom:5px;width:98%;text-align:center" id="pocurrency_'.$id.'"/> </td>';
                $str.= '<td><input type="text" readonly name="due_amount[]" class="form-control" placeholder="due_amount"  value="'.$value->due_amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="due_amount_'.$id.'"/> </td>';
                $str.= '<td><input type="text" readonly name="grn_amount[]" class="form-control" placeholder="grn_amount"  value="'.$value->grn_amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="due_amount_'.$id.'"/> </td>';
                $str.= '<td style="text-align:center"><span class="btn btn-danger btn-xs" onclick="return deleter3('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td></tr>';
                echo $str;
                $id++;
                }
                endif;
                ?>
          </tbody>
          </table>
           <div class="col-sm-12" style="text-align: right;margin-bottom:10px;">
             <a id="AddManualItem3" class="btn btn-info">
              <i class="fa fa-plus-square"></i> Add Row</a>
            </div>

          </div>
        </div>
        <div class="col-sm-4" style="text-align: right;margin-bottom:10px;">  
        <div class="table-responsive">
          <table class="table table-bordered" id="form-table4">
          <thead>
          <tr>
            <th style="width:10%;text-align:center">SN</th>
            <th style="width:50%;text-align:center">Bill No</th>
            <th style="width:30%;text-align:center;">Amount</th>
            <th style="width:10%;text-align:center">
              <i class="fa fa-trash-o"></i></th></tr>
          </thead>
          <tbody>
           <?php
           $i=0;
           $id=0;
            if(isset($detail4)):
              foreach ($detail4 as  $value){
                $str='<tr id="row4_' . $id . '"><td style="text-align:center"><b>' . ($id +1).'</b></td>';
                $str.= '<td><input type="text" name="bill_no[]" class="form-control" placeholder="Bill No"   value="'.$value->bill_no.'"   style="margin-bottom:5px;width:98%;text-align:center" id="bill_no_'.$id.'"/> </td>';
                $str.= '<td><input type="text" name="bamount[]" class="form-control integerchk" placeholder="Amount"   value="'.$value->bamount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="bamount_'.$id.'"/> </td>';
                $str.= '<td style="text-align:center"><span class="btn btn-danger btn-xs" onclick="return deleter4('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td></tr>';
                echo $str;
                $id++;
                }
                endif;
                ?>
          </tbody>
          </table>
           <div class="col-sm-12" style="text-align: right;margin-bottom:10px;">
             <a id="AddManualItem4" class="btn btn-info">
              <i class="fa fa-plus-square"></i> Add Row</a>
            </div>

          </div>
        </div>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="attachemnt_file"  id="attachemnt_file"  class="form-control" >
            <?php if(isset($info) &&!empty($info->attachemnt_file)) { ?>
              <div style="margin-top:10px;">
                <input type="hidden" name="attachemnt_file_p" id="attachemnt_file_p" value="<?php echo $info->attachemnt_file; ?>">
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
            Back</a>
          </div>
          <div class="col-sm-8">
            <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> SAVE 保存</button>
          </div>
          </div>

          <!-- /.box-footer -->
        </form>
        </div>
        </div>

<script type="text/javascript" src="<?php echo base_url('asset/payto.js');?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
  "use strict";
  $(document).on('click','input[type=number]', 
    function(){
      this.select(); 
 });
});
function checkLimit() {
   var userid=$("#approved_by").val();
   if(userid!=''){
    $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'payment/applications/getLimit',
        data:{
            userid : userid,
        },
        success:function(response){
            var data = JSON.parse(response);
            $("#pa_limit").val(data.pa_limit);
        }
      });
    }
   
}
var pa_type=$("#pa_type").val(); 
    if(pa_type=='Advance'){
       $(".poarea").hide();
    }else{
      $(".poarea").show();
    }
  $("#pa_type").change(function(){
    var pa_type=$("#pa_type").val(); 
    if(pa_type=='Advance'){
       $(".poarea").hide();
    }else{
      $(".poarea").show();
    }

  });
//////////////
var deletedRow=[];
var deletedRow1=[];
var deletedRow3=[];
var deletedRow4=[];
var payment_par1='';
<?php  
if(isset($info)){ 
   ?>
    var id=<?php echo count($detail); ?>;
    var payment_par1=<?php echo $info->payment_id; ?>;
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
<?php  if(isset($info)){ 
  ?>
    var id3=<?php echo count($detail3); ?>;
  <?php }else{ ?>
    var id3=0;
<?php  }  ?>
<?php  if(isset($info)){ 
  ?>
    var id4=<?php echo count($detail4); ?>;
  <?php }else{ ?>
    var id4=0;
<?php  }  ?>

var poselect='<?php if(isset($polist)){
     foreach ($polist as $rows) {?><option value="<?php echo $rows->po_number; ?>"><?php echo "$rows->po_number";?></option><?php }} ?> ';

var deptselect='<?php if(isset($clist)){
     foreach ($clist as $rows) {?><option value="<?php echo $rows->dcode; ?>"><?php echo "$rows->department_name";?></option><?php }} ?> ';

var headselect='<?php if(isset($hlist)){
     foreach ($hlist as $rows) {?><option value="<?php echo $rows->head_id; ?>"><?php echo "$rows->head_name";?></option><?php }} ?> ';

$(document).ready(function(){
//////////////////////////////////////
$("#AddManualItem").click(function(){
  var nodeStr = '<tr class="hclass" id="row_' + id + '"><td  style="text-align:center"><input type="hidden" name="parameter[]" value="' + id + '"  id="parameter_' + id + '"><b></b></td>'+
    '<td style="text-align:left"><select name="head_id[]" onchange="return checkHead(' + id + ');" required class="form-control select2" style="width:100%;text-align:left"  id="head_id_' + id + '"> <option value="" selected="selected">Select</option>'+headselect+'</select> </td>' +
    '<td> <input type="text" onfocus="this.select()"  name="amount[]" value="0" onblur="return TcalSum();" onkeyup="return TcalSum();" class="form-control integerchk"  placeholder="Amount" style="width:98%;float:left;text-align:center"  id="amount_' + id + '"> </td>' +
    '<td> <input type="text" name="remarks[]"  class="form-control"  placeholder="Remarks" style="width:98%;float:left;text-align:center"  id="remarks_' + id + '"> </td>' +

    '<td><table class="table table-bordered" id="formtable' + id + '"><tbody></tbody> </table>' +
    '<table class="table table-bordered" ><tr><th style="width:60%;text-align:center;">     Total:</th>' +
    '<td style="width:30%;text-align:center;"><input type="text" name="dtotal_amount'+id+'" id="dtotal_amount'+id+'" readonly class="form-control" style="text-align: center;" value="0"></td>' +

    '<td style="width:10%;text-align:center"><a onclick="addDepartment('+id+')" class="btn btn-info"><i class="fa fa-plus-square"></i> Add Row</a></td></tr></table> </td>' +

    ' <td style="text-align:center"> <span class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </span> </td> </tr>';
    $("#formtable .dddd").append(nodeStr);
    updateRowNo();
    id++;
    $('.select2').select2();
    TcalSum();

});
//////////////////////////
//////////////////////////
$("#AddManualItem3").click(function(){
  var subTotal=0;
  for(var i=0;i<id3;i++){
    if(deletedRow3.indexOf(i)<0) {
     subTotal += parseFloat($.trim($("#pamount_" + i).val()));
    }
  }
  var sub_total=parseFloat($("#sub_total").val());
  var rstofamount=(sub_total-subTotal).toFixed(3);
  var nodeStr = '<tr id="row3_' + id3 + '"><td  style="text-align:center"><b></b></td>'+
    '<td td style="text-align:left"><select name="po_number[]" onchange="return checkpo(' + id3 + ');" required class="form-control select2" style="width:100%;"  id="po_number_' + id3 + '"> <option value="" selected="selected">Select</option>'+poselect+'</select> </td>' +
    '<td><input type="text" name="pamount[]" value="' + rstofamount + '" class="form-control integerchk"  placeholder="Amount" style="width:98%;float:left;text-align:center" id="pamount_' + id3 + '"></td>' +
    '<td><input type="text" readonly name="actual_amount[]" value="0" class="form-control"  placeholder="actual_amount" style="width:98%;float:left;text-align:center" id="actual_amount_' + id3 + '"></td>' +
    '<td><input type="text" readonly name="pocurrency[]" value="" class="form-control"  placeholder="pocurrency" style="width:98%;float:left;text-align:center" id="pocurrency_' + id3 + '"></td>' +
    '<td><input type="text" readonly name="due_amount[]" value="0" class="form-control"  placeholder="due_amount" style="width:98%;float:left;text-align:center" id="due_amount_' + id3 + '"></td>' +
    '<td><input type="text" readonly name="grn_amount[]" value="0" class="form-control"  placeholder="grn_amount" style="width:98%;float:left;text-align:center" id="grn_amount_' + id3 + '"></td>' +
    ' <td style="text-align:center"> <span class="btn btn-danger btn-xs" onclick="return deleter3(' + id3 + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </span> </td> </tr>';
    $("#form-table3 tbody").append(nodeStr);
    updateRowNo3();
    id3++;
    $('.select2').select2();
  });
//////////////////////////
$("#AddManualItem4").click(function(){
  var subTotal=0;
  for(var i=0;i<id4;i++){
    if(deletedRow4.indexOf(i)<0) {
     subTotal += parseFloat($.trim($("#bamount_" + i).val()));
    }
  }
  var sub_total=parseFloat($("#sub_total").val());
  var rstofamount=sub_total-subTotal;
  var nodeStr = '<tr id="row4_' + id4 + '"><td  style="text-align:center"><b></b></td>'+
    '<td><input type="text" name="bill_no[]" class="form-control"  placeholder="Bill No" style="width:98%;float:left;text-align:center" id="bill_no_' + id4 + '"></td>' +
    '<td><input type="text" name="bamount[]" value="' + rstofamount + '" class="form-control integerchk"  placeholder="Amount" style="width:98%;float:left;text-align:center" id="bamount_' + id4 + '"></td>' +
    ' <td style="text-align:center"> <span class="btn btn-danger btn-xs" onclick="return deleter4(' + id4 + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </span> </td> </tr>';
    $("#form-table4 tbody").append(nodeStr);
    updateRowNo4();
    id4++;
  });
  ///////////////////
  var supplier_id=$("#supplier_id").val(); 
    if(supplier_id==353){
       $(".othername").show();
    }else{
      $(".othername").hide();
    }
  $("#supplier_id").change(function(){
    var supplier_id=$("#supplier_id").val(); 
    if(supplier_id==353){
       $(".othername").show();
    }else{
      $(".othername").hide();
    }

  });
   
});

function addDepartment(par1){
  //////////////////////////////////////
  var sub_total=parseFloat($.trim($("#amount_" + par1).val()));
  /////////////////////////
  if($.trim(sub_total)==""|| typeof sub_total === "undefined"){
    sub_total=0;
  }
  var subTotal=$("#dtotal_amount"+par1).val();
  var rstofamount=sub_total-subTotal;
  var nodeStr = '<tr class="rowCount'+par1+'" data-id="'+id1 +'" id="row1_' +par1+id1 + '">'+
    '<td td style="text-align:left;width:60%"><select name="dcode'+par1+'[]" onchange="return checkdepart(' + par1 + ',' + id1 + ');" required class="form-control select2" style="width:100%;"  id="dcode'+par1+'_' + id1 + '"> <option value="" selected="selected">Select</option>'+deptselect+'</select> </td>' +
    '<td style="width:30%"><input type="text" onblur="return DcalSum('+par1+',' + id1 + ');" onkeyup="return DcalSum(' + par1 + ',' + id1 + ');" onfocus="this.select()"  name="damount' + par1 + '[]" value="' + rstofamount + '" class="form-control integerchk"  placeholder="Amount" style="width:98%;float:left;text-align:center" id="damount' + par1 + '_' + id1 + '"></td>' +
    '<td style="text-align:center;width:10%"> <span class="btn btn-danger btn-xs" onclick="return deleter1(' + par1 + ',' + id1 + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td></tr>';
  $("#formtable"+par1+" tbody").append(nodeStr);
  id1++;
  $('.select2').select2();
  departmentSum(par1)
} 

function deleter(par1){
    $("#row_"+par1).remove();
    deletedRow.push(par1);
    updateRowNo();
}
    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
function updateRowNo(){
  var numRows=$("#formtable .dddd .hclass").length;
  for(var r=0;r<numRows;r++){
    $("#formtable .dddd .hclass").eq(r).find("td:first b").text(r+1);
  }
  TcalSum();
}
  ///////////////
  function deleter1(par1,par2){
    $("#row1_"+par1+par2).remove();
    deletedRow1.push(par2);
    departmentSum(par1);
  }
 ///////////////
function deleter3(id3){
    $("#row3_"+id3).remove();
    deletedRow3.push(id3);
    updateRowNo3();
  }
function deleter4(id4){
    $("#row4_"+id4).remove();
    deletedRow4.push(id4);
    updateRowNo4();
  }
    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
function updateRowNo3(){
  var numRows=$("#form-table3 tbody tr").length;
  for(var r=0;r<numRows;r++){
    $("#form-table3 tbody tr").eq(r).find("td:first b").text(r+1);
  }
}
function updateRowNo4(){
  var numRows=$("#form-table4 tbody tr").length;
  for(var r=0;r<numRows;r++){
    $("#form-table4 tbody tr").eq(r).find("td:first b").text(r+1);
  }
}

function formsubmit(){
  var error_status=false;
  var serviceNum=$("#formtable .dddd .hclass").length;
  var pocount=$("#form-table3 tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Item!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var supplier_id=$("#supplier_id").val();
  var currency=$("#currency").val();
  var attachemnt_file=$("#attachemnt_file").val();
  var approved_by=$("#approved_by").val();
  var pa_limit=parseFloat($("#pa_limit").val());
  var attachemnt_file_p=$("#attachemnt_file_p").val();
  var applications_date=$("#applications_date").val();
  var pa_type=$("#pa_type").val();
  if(supplier_id == '') {
    error_status=true;
    $("#alertMessageHTML").html("Please select Pay To!!");
    $("#alertMessagemodal").modal("show");
  } else {
    $("#supplier_id").css('border', '1px solid #ccc');      
  } 
  if(supplier_id==353){
    var other_name=$("#other_name").val();
    if(other_name==''){
      error_status=true;
      $("#alertMessageHTML").html("Please write other name!!");
      $("#alertMessagemodal").modal("show");
    }
  }

  if(pa_type=='Safety Stock'||pa_type=='Assets'||pa_type=='Material'){
    if(pocount<1){
      $("#alertMessageHTML").html("Please Adding at least one PO!!");
      $("#alertMessagemodal").modal("show");
      error_status=true;
    }
  }
  

  if(attachemnt_file == ''&&attachemnt_file_p=='') {
    error_status=true;
    $("#alertMessageHTML").html("Please select attachemnt file!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  } else {
    $("#attachemnt_file").css('border', '1px solid #ccc');      
  }
  var htotalamount=0;
  var dtotalamount=0;
  var checkDamount=0;
  for(var i=0;i<id;i++){
    if(deletedRow.indexOf(i)<0) {
      if($("#amount_"+i).val()==''||$("#amount_"+i).val()==0){
        $("#amount_"+i).css('border', '1px solid #f00');
        error_status=true;
      }
      var amount= parseFloat($("#amount_" + i).val());
      var deptcount=$("#formtable"+i).length;
      var checkDamount=parseFloat($("#dtotal_amount" + i).val());
      dtotalamount+= parseFloat($("#dtotal_amount" + i).val());
      if(checkDamount!=amount){
        $("#alertMessageHTML").html("Net Payment & departmental amount must be equal!!");
        $("#alertMessagemodal").modal("show");
        $("#dtotal_amount"+i).css('border', '1px solid #f00');
        error_status=true;

      }
      if(deptcount<1){
        $("#alertMessageHTML").html("Please Adding at least one department!!!");
        $("#alertMessagemodal").modal("show");
        error_status=true;
      }
    }
  }


  if(applications_date == '') {
    error_status=true;
    $("#applications_date").css('border', '1px solid #f00');
  } else {
    $("#applications_date").css('border', '1px solid #ccc');      
  }
  dtotalamount=parseFloat(dtotalamount).toFixed(2);
  var sub_total=parseFloat($("#sub_total").val()).toFixed(2);
  if(sub_total!=dtotalamount){
      $("#alertMessageHTML").html("Net Payment & departmental amount must be equal!!");
      $("#alertMessagemodal").modal("show");
      error_status=true;
  }
  if(approved_by!=90&&sub_total>pa_limit&&currency=='BDT') {
    error_status=true;
    $("#alertMessageHTML").html("Can not be exceeded application limit!!!");
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
  var serviceNum=$("#formtable .dddd .hclass").length;
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
  function departmentSum(par1){
    var dsubTotal=0;
    $(".rowCount"+par1).each(function () {
      var dataid = $(this).attr("data-id");
      dsubTotal+= parseFloat($.trim($("#damount"+par1+"_" + dataid).val()));
    });
    $("#dtotal_amount"+par1).val(dsubTotal.toFixed(2));
  ////////////////
  }
  function DcalSum(par1,par2){
    var sub_total=parseFloat($.trim($("#amount_" + par1).val()));
    if($.trim(sub_total)==""|| typeof sub_total === "undefined"){
      sub_total=0;
    }
    var dsubTotal=0;
    var deptcount=$(".rowCount"+par1).length;
    $(".rowCount"+par1).each(function () {
      var dataid = $(this).attr("data-id");
      dsubTotal+= parseFloat($.trim($("#damount"+par1+"_" + dataid).val()));
    });
    
    if(dsubTotal>sub_total){
        $("#alertMessageHTML").html("Departmental amount can not exceed Net Payment.!!");
        $("#alertMessagemodal").modal("show");
        $("#damount"+par1+"_"+par2).val(0);
        dsubTotal=0;
    }
    ////////////////////
    $("#dtotal_amount"+par1).val(dsubTotal.toFixed(2));
    departmentSum(par1);
  }
 

  function checkdepart(par1,par2){
    var newdid=$("#dcode"+par1+"_" + par2).val();
    var chkname=1;

    $(".rowCount"+par1).each(function () {
      var dataid = $(this).attr("data-id");
      oldid= $("#dcode"+par1+"_" + dataid).val();
       if(oldid==newdid && dataid!=par2){
           chkname=2;
        }
    })
    if(chkname==2){
      $("#alertMessageHTML").html("Can not select same department twice!!");
      $("#alertMessagemodal").modal("show");
      $("#dcode"+par1+"_" + par2).val('').change();
      //$("#dcode_"+par2).val('').change();
    }
    // var serviceNum=$("#formtable1 tbody tr").length;
    // for(var i=0;i<id1;i++){
    //   if(deletedRow1.indexOf(i)<0) {
    //   var oldid =$("#dcode_" + i).val();
    //     if(oldid==newdid && i!=id2){
    //        chkname=2;
    //     }
    //   }
    //   }
    

  }
  function checkHead(id2){
    var newdid=$("#head_id_"+id2).val();
    var chkname=1;
    var serviceNum=$("#formtable tbody tr").length;
    for(var i=0;i<id;i++){
      if(deletedRow.indexOf(i)<0) {
      var oldid =$("#head_id_" + i).val();
        if(oldid==newdid && i!=id2){
           chkname=2;
        }
      }
      }
      if(chkname==2){
       $("#alertMessageHTML").html("Can not select same department twice!!");
        $("#alertMessagemodal").modal("show");
        $("#head_id_"+id2).val('').change();
    }

  }
  function checkpo(ids3){
    var newdid=$("#po_number_"+ids3).val();
    var chkname=1;
    var serviceNum=$("#form-table3 tbody tr").length;
    for(var i=0;i<id3;i++){
      if(deletedRow1.indexOf(i)<0) {
      var oldid =$("#po_number_" + i).val();
        if(oldid==newdid && i!=ids3){
           chkname=2;
        }
      }
      }
      if(chkname==2){
        $("#alertMessageHTML").html("Can not select same po twice!!");
        $("#alertMessagemodal").modal("show");
        $("#po_number_"+ids3).val('').change();
    }else{
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'payment/applications/getPOAmount',
        data:{
            po_number : newdid,
        },
        success:function(response){
            var data = JSON.parse(response);
            var amountp=parseFloat(data.amount);
            var due_amountp=parseFloat(data.due_amount);
            var grn_amountp=parseFloat(data.grn_amount);
            amountp=amountp.toFixed(3);
            due_amountp=due_amountp.toFixed(3);
            grn_amountp=grn_amountp.toFixed(3);

            $("#actual_amount_"+ids3).val(amountp);
            $("#due_amount_"+ids3).val(due_amountp);
            $("#pocurrency_"+ids3).val(data.pocurrency);
            $("#grn_amount_"+ids3).val(grn_amountp);
        }
      });
    }
  }
</script>