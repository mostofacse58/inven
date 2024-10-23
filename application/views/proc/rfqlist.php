<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>proc/rfq/add">
<i class="fa fa-plus"></i>
Add RFI
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
      <div class="box-body">
         <form class="form-horizontal" action="<?php echo base_url();?>proc/rfq/lists" method="GET" enctype="multipart/form-data">
          <div class="box-body">

           <div class="form-group">
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
          <div class="col-sm-3">
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

          <label class="col-sm-2 control-label">
           RFI. No <span style="color:red;">  </span></label>
            <div class="col-sm-2">
              <input class="form-control" name="rfq_no" id="rfq_no" value="<?php echo set_value('rfq_no'); ?>" placeholder="NO">
            <span class="error-msg"><?php echo form_error("rfq_no");?></span>
            </div>
          </div>

    <div class="form-group">

            <label class="col-sm-2 control-label">
           RFI. No <span style="color:red;">  </span></label>
            <div class="col-sm-2">
              <input class="form-control" name="rfi_no" id="rfi_no" value="<?php echo set_value('rfi_no'); ?>" placeholder="NO">
            <span class="error-msg"><?php echo form_error("rfi_no");?></span>
            </div>
            <label class="col-sm-1 control-label">Date</label>
        <div class="col-sm-2">
        <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
      </div>
      <div class="col-sm-2">
        <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
      </div>
              <div class="col-sm-1">
                <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
            </div>
            <div class="col-sm-1">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>proc/rfq/lists">All</a>
            </div>
          </div>
          </div>
          <!-- /.box-body -->
        </form>
      <div class="table-responsive table-bordered">
      <table id="" class="table table-bordered table-striped" style="width:100%;border:#000">
          <thead>
          <tr>
            <th style="width:4%;">SN</th>
            <th style="width:10%;">Type</th>
            <th style="text-align:center;width:10%">RFQ NO</th>
            <th style="width:10%;">RFQ Date</th>
            <th style="text-align:center;width:10%">RFI NO</th>
            <th style="width:10%;">FOR Dept</th>
            <th style="text-align:center;width:10%">Quotation Date</th>
            <th style="width:10%;">Prepared by</th>
            <th style="text-align:center;width:5%;">Actions 行动</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)): $i=1;
          foreach($list as $row):
              ?>
          <tr>
            <td class="text-center"><?php echo $i++; ?></td>
            <td class="text-center">
            <?php 
                if($row->pr_type==2) echo "Asset";
                elseif($row->pr_type==1) echo "Safety Stock";
                ?></td>
            <td class="text-center"><?php echo $row->rfq_no; ?></td>
            <td class="text-center"><?php echo findDate($row->rfq_date); ?></td>
            <td class="text-center"><?php echo $row->rfq_no; ?></td>
            
            <td class="text-center"><?php echo $row->for_department_name; ?></td>
            <td class="text-center"><?php echo $row->quotation_date; ?></td>
      
            <td class="text-center"><?php echo $row->user_name; ?></td>
            <td style="text-align:center">
                <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
              <li> <a href="<?php echo base_url()?>proc/rfq/view/<?php echo $row->rfq_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
              <li> <a href="<?php echo base_url()?>proc/rfq/pdf/<?php echo $row->rfq_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>pdf</a></li>
              <li> <a href="<?php echo base_url()?>proc/rfq/excelload/<?php echo $row->rfq_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>Excel</a></li>
              <?php if($row->rfq_status==1){ ?>
              <li> <a href="<?php echo base_url()?>proc/rfq/submit/<?php echo $row->rfq_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Submit</a></li>
              <li> <a href="<?php echo base_url()?>proc/rfq/edit/<?php echo $row->rfq_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
              <?php if($this->session->userdata('delete')=='YES'){ ?>
              <li><a href="#" class="delete" data-rfqd="<?php echo $row->rfq_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
              <?php } ?>
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
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('rfqd');
  location.href="<?php echo base_url();?>proc/rfq/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>