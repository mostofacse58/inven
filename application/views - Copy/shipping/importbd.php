<style type="text/css">
  .error-msg{display: none;}
</style>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
  $(document).on('click','input[type=number]',function(){ this.select(); });
    $('.date').datepicker({
        "format": "yyyy-mm-dd",
        "todayHighlight": true,
        "autoclose": true
    });
    });
var url1="<?php echo base_url(); ?>shipping/import/lists";
</script>
<div class="row">
<div class="col-xs-12">
<div class="box box-primary">
<div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
  <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>shipping/bdimport/addExcel">
  <i class="fa fa-plus"></i>
  Upload Excel
  </a>
  <a class="btn btn-sm btn-primary pull-right" style="margin-right:5px;" href="<?php echo base_url(); ?>shipping/bdimport/loadExcel<?php echo $condition; ?> ">
<i class="fa fa-plus"></i>
Export Excel
</a>

</div>
</div>
</div>
</div>
        <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>shipping/bdimport/lists" method="GET" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('ex_fty_date'); ?></label>
            <div class="col-sm-2">
              <input type="text" name="ex_fty_date" readonly id="ex_fty_date" class="form-control date" value="<?php  echo set_value('ex_fty_date');  ?>"  placeholder="<?php echo lang('ex_fty_date'); ?>" >
            </div>
           <label class="col-sm-2 control-label"><?php echo lang('port_of_loading'); ?>
           </label>
           <div class="col-sm-2">
              <select class="form-control select2" name="port_of_loading" id="port_of_loading" required="">
                <option value="All"><?php echo lang('select'); ?></option>
                <?php foreach ($plist as $value) {  ?>
                <option value="<?php echo $value->port_of_loading; ?>"
                <?php  echo set_select('port_of_loading',$value->port_of_loading);?> >
                <?php echo "$value->port_of_loading"; ?></option>
                <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label"><?php echo lang('port_of_discharge'); ?>
             </label>
             <div class="col-sm-2">
              <select class="form-control select2" name="port_of_discharge" id="port_of_discharge" style="width: 100%" required>
                <option value="All"><?php echo lang('select'); ?></option>
                <option value="CHATTOGRAM"
                  <?php  echo set_select('port_of_discharge','CHATTOGRAM');?>>
                    CHATTOGRAM</option>
                <option value="DAC"
                  <?php   echo set_select('port_of_discharge','DAC');?>>
                    DAC</option>
                </select>
               <span class="error-msg"><?php echo form_error("port_of_discharge");?></span>
              </div>
          </div>
          <div class="form-group">
            
           <label class="col-sm-2 control-label"><?php echo lang('customer_name'); ?></label>
         <div class="col-sm-2">
           <select class="form-control select2" name="customer_name" id="customer_name" >
              <option value="All"><?php echo lang('select'); ?></option>
              <?php 
              foreach ($clist as $value) {  ?>
              <option value="<?php echo $value->customer_name; ?>" <?php  echo set_select('customer_name',$value->customer_name);?>><?php echo $value->customer_name; ?></option>
              <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("customer_name");?></span>
         </div>
          <label class="col-sm-2 control-label"><?php echo lang('supplier'); ?> 1    </label>
         <div class="col-sm-2">
           <select class="form-control select2" name="supplier_name" id="supplier_name" required="">
              <option value="All"><?php echo lang('select'); ?></option>
              <?php foreach ($slist as $value) {  ?>
              <option value="<?php echo $value->supplier_name; ?>"
              <?php   echo set_select('supplier_name',$value->supplier_name);?>>
              <?php echo "$value->supplier_name"; ?></option>
              <?php } ?>
            </select>
         </div>
          <label class="col-sm-2 control-label"><?php echo lang('shipping_terms'); ?></label>
         <div class="col-sm-2">
            <select class="form-control select2" name="shipping_terms" id="shipping_terms" required="">
              <option value="All"><?php echo lang('select'); ?></option>
              <?php foreach ($tlist as $value) {  ?>
              <option value="<?php echo $value->shipping_terms; ?>"
              <?php  echo set_select('shipping_terms',$value->shipping_terms);?>>
              <?php echo "$value->shipping_terms"; ?></option>
              <?php } ?>
            </select>
         </div>
         </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('file_no'); ?></label>
           <div class="col-sm-4">
             <select class="form-control select2" name="file_no[]" id="file_no"  multiple="multiple" data-placeholder="Select multiple file">
              <?php 
                foreach ($flist as $value) {  ?>
                <option value="<?php echo $value->file_no; ?>" <?php 
                     if(isset($_POST['file_no'])) if(in_array($value->file_no, $_POST['file_no'])) echo 'selected="selected"';
                       ?>><?php echo $value->file_no; ?></option>
                <?php } ?>
              </select>
           </div>
            <label class="col-sm-2 control-label">Import/Invoice No</label>
            <div class="col-sm-2">
              <input type="text" name="import_number" class="form-control" placeholder="Import/Invoice No" value="<?php  echo set_value('import_number'); ?>" autofocus>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Season</label>
            <div class="col-sm-2">
              <input type="text" name="season" class="form-control" placeholder="season" value="<?php  echo set_value('season'); ?>" autofocus>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Search </button>
          </div>
          <div class="col-sm-1">
            <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>shipping/import/lists">All</a>
          </div>
          </div>
        </form>
        <!-- <div class="table-responsive table-bordered"> -->
          <table id="" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
          <tr>
              <th style="width:5%;text-align:center">SN</th>
              <th style="width:10%;text-align:center">Import No</th>
              <th style="width:8%;text-align:center"><?php echo lang('invoice_no'); ?> </th>
              <th style="width:8%;text-align:center"><?php echo lang('ex_fty_date'); ?></th>
              <th style="width:8%;text-align:center"><?php echo lang('port_of_loading'); ?></th>
              <th style="width:8%;text-align:center"><?php echo lang('port_of_discharge'); ?></th>
              <th style="width:8%;text-align:center"><?php echo lang('shipped_qty'); ?></th>
              <th style="width:8%;text-align:center"><?php echo lang('file_no'); ?></th>
              <th style="width:8%;text-align:center"><?php echo lang('customer_name'); ?></th>
              <th style="width:8%;text-align:center"><?php echo lang('supplier'); ?> 1</th>
              <th style="text-align:center;width:6%">Status</th>
              <th style="text-align:center;width:5%">Action</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)): $i=1;
            foreach($list as $row):
                ?>
            <tr>
            <td style="text-align:center">
              <?php echo $i++; ; ?></td>
            <td><?php echo $row->import_number;?></td>
            <td style="text-align:center">
              <?php echo $row->invoice_no;  ?></td>
            <td style="text-align:center">
              <?php echo $row->ex_fty_date;  ?></td>
            <td style="text-align:center">
              <?php echo $row->port_of_loading;  ?></td>
            <td style="text-align:center">
              <?php echo $row->port_of_discharge;  ?></td>
            <td style="text-align:center">
              <?php echo $row->shipped_qty;  ?></td>
            <td style="text-align:center">
              <?php echo $row->file_no; ; ?></td>
            <td style="text-align:center">
              <?php echo $row->customer_name;  ?></td>
            <td style="text-align:center">
              <?php echo $row->supplier_name;  ?></td>
            <td style="text-align:center">
              <span class="btn btn-xs btn-<?php echo ($row->import_status==2||$row->import_status==1)?"danger":"success";?>">
                  <?php 
                  if($row->import_status==1) echo "Draft";
                  elseif($row->import_status==2) echo "Submit";
                  elseif($row->import_status==3) echo "Done";
                  else echo "Sent";
                  ?>
              </span>
              </td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a href="<?php echo base_url()?>shipping/bdimport/view/<?php echo $row->import_id;?>"><i class="fa ffa fa-eye tiny-icon"></i>View</a></li>
                   <!--    <li><a href="<?php echo base_url()?>dashboard/viewCCpdf/<?php echo $row->import_id;?>"><i class="fa fa-file-pdf-o tiny-icon"></i>PDF</a></li> -->
                       <?php if($row->import_status==2){  ?>
                     <li><a href="<?php echo base_url()?>shipping/bdimport/submit/<?php echo $row->import_id;?>">
                      <i class="fa fa-arrow-circle-right tiny-icon"></i>Complete</a>
                    </li>
                    <?php } ?>
                      <?php if($row->import_status<=2){  ?>
                      <?php if($this->session->userdata('update')=='YES'){ ?>
                      <li>  <a href="<?php echo base_url()?>shipping/bdimport/edit/<?php echo $row->import_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit</a>
                      </li>
                      <?php }  } ?>
        
                    </ul>
                </div>
                </td>
              </tr>
              <?php
              endforeach;
          endif;
          ?>
          </tbody>
          </table>
          
          <div class="box-tools">
              <?php if(isset($pagination))echo $pagination; ?>
          </div>


          <!-- </div> -->
        </div>
        <!-- /.box-body -->
      </div>
    </div>
 </div>
 <style>
.table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
  border: 1px solid #000;
}
.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
  border: 1px solid #000;
}
br{
  padding: 1px solid #000;
}
</style>
<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>shipping/bdimport/delete/"+rowId;
}
});
});//jquery ends here
</script>
