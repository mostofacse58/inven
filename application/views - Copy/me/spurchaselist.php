<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/spurchase/add">
<i class="fa fa-plus"></i>
Add Purchase
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
      <div class="box-body">
      <div class="table-responsive table-bordered">
      <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#00" >
          <thead>
          <tr>
            <th style="width:10%;">Date</th>
            <th style="width:10%;">Ref. No</th>
            <th style="width:20%;">Supplier</th>
            <th style="text-align:center;width:10%">PI NO</th>
            <th style="width:10%;">Total Qty</th>
            <th style="width:12%;">Total Amount</th>
            <th style="text-align:center;width:5%;">Actions 行动</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)):
          foreach($list as $row):
              ?>
          <tr>
            <td class="text-center"><?php echo findDate($row->purchase_date); ?></td>
            <td class="text-center"><?php echo $row->reference_no; ?></td>
            <td><?php echo "$row->company_name";?></td>
            <td style="text-align:center">
              <?php echo $row->pi_no; ; ?></td>
            <td class="text-center"><?php echo $row->totalquantity; ?></td>
            <td class="text-center"><?php echo $row->grand_total; ?></td>
            <td style="text-align:center">
                <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
              <li> <a href="<?php echo base_url()?>me/spurchase/view/<?php echo $row->purchase_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
              <li> <a href="<?php echo base_url()?>me/spurchase/edit/<?php echo $row->purchase_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                    <?php if($this->session->userdata('delete')=='YES'){ ?>
              <li><a href="#" class="delete" data-pid="<?php echo $row->purchase_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
  location.href="<?php echo base_url();?>me/spurchase/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>