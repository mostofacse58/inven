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
</script>
<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" 
href="<?php echo base_url(); ?>common/extragrn/add">
<i class="fa fa-plus"></i>
Add New
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
  <div class="box-body">
    <form class="form-horizontal" action="<?php echo base_url();?>common/extragrn/lists" method="GET" enctype="multipart/form-data">

    <div class="form-group">
    <label class="col-sm-1 control-label">Search By </label>
        <div class="col-sm-2">
          <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="ITEM CODE/Name">
        <span class="error-msg"><?php echo form_error("product_code");?></span>
        </div>
        <label class="col-sm-2 control-label">
          For Department</label>
          <div class="col-sm-2">
            <select class="form-control select2" name="for_department_id" id="for_department_id">
              <option value="All" selected="selected">All Dept.</option>
            <?php 
            foreach($dlist as $rows){  ?>
            <option value="<?php echo $rows->department_id; ?>" 
              <?php echo $rows->department_id==set_value('for_department_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->department_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("for_department_id");?></span>
        </div>
        <div class="col-sm-2">
            <select class="form-control select2" name="supplier_id" id="supplier_id">
            <option value="All" selected="selected">All Supplier</option>
            <?php 
            foreach($slist as $rows){  ?>
            <option value="<?php echo $rows->supplier_id; ?>" 
              <?php echo $rows->supplier_id==set_value('supplier_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->supplier_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("supplier_id");?></span>
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-1 control-label">Search By </label>
          <div class="col-sm-2">
           <input class="form-control" name="reference_no" id="reference_no" value="<?php echo set_value('reference_no'); ?>" placeholder="PI NO">
        <span class="error-msg"><?php echo form_error("reference_no");?></span>
        </div>
        <div class="col-sm-2">
           <input class="form-control" name="po_number" id="po_number" value="<?php echo set_value('po_number'); ?>" placeholder="PO NO">
        <span class="error-msg"><?php echo form_error("po_number");?></span>
        </div>
        <label class="col-sm-1 control-label">Date</label>
          <div class="col-sm-2">
          <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
        </div>
        <div class="col-sm-2">
          <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
        </div>
        <div class="col-sm-2">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>common/extragrn/lists">All</a>
      </div>
    </div>

  <!-- /.box-body -->
</form>

      <div class="table-responsive table-bordered">
      <table class="table table-bordered table-striped" style="width:100%;border:#00" >
        <thead>
          <tr>
            <th style="width:5%;">SN</th>
            <th style="width:10%;">For Department</th>
            <th style="width:10%;">Date</th>
            <th style="width:10%;">Ref. No</th>
            <th style="width:20%;">Supplier</th>
            <th style="text-align:center;width:10%">PO NO</th>
            <th style="width:12%;">Total Amount</th>
            <th style="width:8%;">Status 状态</th>
            <th style="text-align:center;width:5%;">Actions 行动</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)): $i=$page+1;
          foreach($list as $row):
              ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td class="text-center"><?php echo $row->for_department_name; ?></td>
            <td class="text-center"><?php echo findDate($row->purchase_date); ?></td>
            <td class="text-center"><?php echo $row->reference_no; ?></td>
            <td><?php echo "$row->company_name";?></td>
            <td style="text-align:center">
              <?php echo $row->po_number; ; ?></td>
            <td class="text-center"><?php echo $row->grand_total; ?></td>
            <td class="text-center">
            <span class="btn btn-xs btn-<?php echo ($row->status==2||$row->status==5)?"danger":"success";?>">
              <?php 
              if($row->status==1) echo "Draft";
              elseif($row->status==2) echo "Submit";
              elseif($row->status==3) echo "Received";
              elseif($row->status==4) echo "Certified";
              elseif($row->status==5) echo "Approved";
              elseif($row->status==6) echo "Received";
              elseif($row->status==8) echo "Cancel";
              ?>
            </span></td>
            <td style="text-align:center">
                <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
              <li> <a href="<?php echo base_url()?>common/extragrn/view/<?php echo $row->purchase_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
              <li> <a href="<?php echo base_url()?>common/extragrn/viewpdf/<?php echo $row->purchase_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>PDF</a></li>
              <?php if($row->status==1){ ?>
              <li><a href="<?php echo base_url()?>common/extragrn/submit/<?php echo $row->purchase_id;?>"><i class="fa fa-arrow-circle-o-right tiny-icon"></i>Submit</a></li>
              <?php } ?>
              <?php if($this->session->userdata('delete')=='YES'){ ?>
                <li><a href="#" class="delete" data-pid="<?php echo $row->purchase_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Return</a></li>
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
  job=confirm("Are you sure you want to return this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>common/extragrn/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>