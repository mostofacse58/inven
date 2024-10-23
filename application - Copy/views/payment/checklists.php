<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
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
</script>
<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
   <div class="box-header">
   <div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>payment/checked/downloadExcel">
<i class="fa fa-download"></i>
Download Excel
</a>
</div>
</div>
</div>
</div>
<!-- /.box-header -->
<div class="box-body">
  <form class="form-horizontal" action="<?php echo base_url();?>payment/checked/lists" method="GET" enctype="multipart/form-data">
  <div class="box-body">
    <div class="form-group">
    <label class="col-sm-2 control-label">Application. NO </label>
      <div class="col-sm-2">
        <input class="form-control" name="applications_no" id="applications_no" value="<?php echo set_value('applications_no'); ?>" placeholder="NO">
      <span class="error-msg"><?php echo form_error("applications_no");?></span>
      </div>
       <label class="col-sm-1 control-label">Pay To</label>
          <div class="col-sm-3">
            <select class="form-control select2" name="supplier_id" id="supplier_id">
            <option value="All" selected="selected">All</option>
            <?php 
            foreach($palist as $rows){  ?>
            <option value="<?php echo $rows->supplier_id; ?>" 
              <?php echo $rows->supplier_id==set_value('supplier_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->supplier_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("supplier_id");?></span>
        </div>
      </div>
      <div class="form-group">
      <label class="col-sm-2 control-label">Date</label>
        <div class="col-sm-2">
        <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
      </div>
      <div class="col-sm-2">
        <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
      </div>
      <div class="col-sm-3">
        <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
        <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>payment/checked/lists">All</a>
    </div>
  </div>
  </div>
  <!-- /.box-body -->
</form>
<div class="table-responsive table-bordered">
<table id="examplse1" class="table table-bordered table-striped" style="width:100%;border:#000" >
    <thead>
    <tr>
      <th style="width:4%;">SN</th>
      <th style="width:7%;">Application NO</th>      
      <th style="width:8%;">Application Date</th>
      <th style="width:7%;">PA Type</th>
      <th style="width:15%;">Pay To Name</th>
      <th style="text-align:center;width:8%">
        Department</th>
      <th style="text-align:center;width:8%">
        Approved By</th>
      <th style="text-align:center;width:12%">
        Total Amount</th>
      <th style="text-align:center;width:8%">
        Attachment</th>
      <th style="width:8%;">Status 状态</th>
      <th style="width:10%;">Prep.By</th>
      <th style="text-align:center;width:7%;">
      Actions 行动</th>
  </tr>
  </thead>
  <tbody>
  <?php
  if($lists&&!empty($lists)): $i=$page+1;
    foreach($lists as $row):
    ?>
    <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td class="text-center"><?php echo $row->applications_no;?></td>
      <td class="text-center"><?php echo findDate($row->applications_date); ?></td>
      <td class="text-center"><?php echo $row->pa_type;?></td>
      <td class="text-center"><?php if($row->supplier_id==353) echo $row->other_name; 
      else echo $row->supplier_name; ?></td>
      <td class="text-center"><?php echo $row->department_name; ?></td>
      <td class="text-center"><?php echo $row->approved_by_name; ?></td>
      <td class="text-center"><?php echo $row->currency.' '.number_format($row->total_amount,2); ?></td>
      <td class="text-center">
        <?php if(isset($row) &&!empty($row->attachemnt_file)) { ?>
        <a href="<?php echo base_url(); ?>dashboard/dpayment/<?php echo $row->attachemnt_file; ?>">Download</a>
      <?php } ?>
      </td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->status==1||$row->status==2||$row->status==8)?"danger":"success";?>">
        <?php 
        if($row->status==1) echo "Draft";
        elseif($row->status==2) echo "Pending";
        elseif($row->status==3) echo "Confirmed";
        elseif($row->status==4) echo "Verified";
        elseif($row->status==5) echo "Checked";
        elseif($row->status==6) echo "Approved";
        elseif($row->status==7) echo "Paid";
        elseif($row->status==8) echo "Rejected";
        ?>
      </span></td>
      <td class="text-center"><?php echo $row->user_name; ?></td>
      <td style="text-align:center">
      <!-- Single button -->
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">
          <li><a href="<?php echo base_url()?>payment/checked/view/<?php echo $row->payment_id;?>">
          <i class="fa fa-eye tiny-icon"></i>View  </a></li>
        <li> <a href="<?php echo base_url()?>dashboard/viewapplicationspdf/<?php echo $row->payment_id;?>" target="_blank">
          <i class="fa fa-pdf-o tiny-icon"></i>PDF</a></li>
        <?php if($row->status==2){ ?>
          <li><a href="<?php echo base_url()?>payment/checked/view/<?php echo $row->payment_id;?>">
          <i class="fa fa-eye tiny-icon"></i>View & Confirm </a></li>
          <?php } ?>
    
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
  </div>
</div>
    <!-- /.box-body -->
  </div>
</div>
</div>


<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Inpaymention?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('applicationsd');
  location.href="<?php echo base_url();?>payment/applications/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>