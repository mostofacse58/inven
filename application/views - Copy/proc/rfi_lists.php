<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>proc/rfi/add">
<i class="fa fa-plus"></i>
Add RFI
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
      <div class="box-body">
         <form class="form-horizontal" action="<?php echo base_url();?>proc/rfi/lists" method="GET" enctype="multipart/form-data">
          <div class="box-body">
            <label class="col-sm-2 control-label">
             Req. No <span style="color:red;">  </span></label>
              <div class="col-sm-2">
                <input class="form-control" name="rfi_no" id="rfi_no" value="<?php echo set_value('rfi_no'); ?>" placeholder="NO">
              <span class="error-msg"><?php echo form_error("rfi_no");?></span>
              </div>
              <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>proc/rfi/lists">All</a>
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
            <th style="text-align:center;width:10%">RFI NO</th>
            <th style="width:10%;">RFI Date</th>
            <th style="text-align:center;width:10%">Demand Date</th>
            <th style="width:8%;">Status</th>
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
                if($row->pr_type==1) echo "Asset";
                elseif($row->pr_type==2) echo "Safety Stock";
                ?></td>
            <td class="text-center"><?php echo $row->rfi_no; ?></td>
            <td class="text-center"><?php echo findDate($row->rfi_date); ?></td>
            <td class="text-center"><?php echo findDate($row->demand_date); ?></td>
            <td class="text-center">
          <span class="btn btn-xs btn-<?php echo ($row->rfi_status==1)?"danger":"success";?>">
                <?php 
                if($row->rfi_status==1) echo "Draft";
                elseif($row->rfi_status==0) echo "Reject";
                elseif($row->rfi_status==2) echo "Submitted";
                elseif($row->rfi_status==3) echo "Approved";
                else echo "Received";
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
              <li> <a href="<?php echo base_url()?>proc/rfi/view/<?php echo $row->rfi_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
              <li> <a href="<?php echo base_url()?>proc/rfi/pdf/<?php echo $row->rfi_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>pdf</a></li>
              <li> <a href="<?php echo base_url()?>proc/rfi/excelload/<?php echo $row->rfi_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>Excel</a></li>
              <?php if($row->rfi_status==1){ ?>
              <li> <a href="<?php echo base_url()?>proc/rfi/submit/<?php echo $row->rfi_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Submit</a></li>
              <li> <a href="<?php echo base_url()?>proc/rfi/edit/<?php echo $row->rfi_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
              <?php if($this->session->userdata('delete')=='YES'){ ?>
              <li><a href="#" class="delete" data-rfid="<?php echo $row->rfi_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
  var rowId=$(this).data('rfid');
  location.href="<?php echo base_url();?>proc/rfi/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>