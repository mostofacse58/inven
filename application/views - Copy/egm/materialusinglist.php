<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>egm/materialusing/add">
<i class="fa fa-plus"></i>
Add Using
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
        <div class="table-responsive table-bordered">
          <table id="" class="table table-bordered table-striped" style="width:100%;border:#00" >
            <thead>
            <tr>
              <th style="width:8%;">Date</th>
              <th style="width:8%;">Location</th>
              <th style="width:20%;">Purpose of Use</th>
              <th style="text-align:center;width:10%">TPM CODE (TPM代码)</th>
              <th style="width:8%;">Total Qty</th>
              <th style="width:12%;">EGM Name</th>
              <th style="width:12%;">Issued By</th>
              <th style="text-align:center;width:5%;">Actions 行动</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)):
            foreach($list as $row):
                ?>
              <tr>
                <td class="text-center"><?php echo findDate($row->use_date); ?></td>
                <td class="text-center"><?php echo $row->line_no; ?></td>
                <td><?php echo "$row->product_name $row->use_purpose";?></td>
                <td style="text-align:center">
                  <?php echo $row->tpm_serial_code; ; ?></td>
                <td class="text-center"><?php echo $row->totalquantity; ?></td>
                <td class="text-center"><?php echo $row->me_name; ?></td>
                <td class="text-center"><?php echo $row->user_name; ?></td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                    <li> <a href="<?php echo base_url()?>egm/materialusing/view/<?php echo $row->spares_use_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
                      <li> <a href="<?php echo base_url()?>egm/materialusing/edit/<?php echo $row->spares_use_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                        <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->spares_use_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>egm/materialusing/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>