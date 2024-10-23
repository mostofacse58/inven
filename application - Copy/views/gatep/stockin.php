<style type="text/css">
  .error-msg{display: none;}
</style>
<script type="text/javascript">
var url1="<?php echo base_url(); ?>gatep/stockin/lists";
</script>
<div class="row">
<div class="col-xs-12">
<div class="box box-primary">
<div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>gatep/stockin/add">
<i class="fa fa-plus"></i>
Add New
</a>
</div>
</div>
</div>
</div>
        <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>gatep/stockin/lists" method="GET" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-sm-3 control-label">Gate Pass No</label>
            <div class="col-sm-3">
              <input type="text" name="gatepass_no" class="form-control" placeholder="Gate Pass No" value="<?php  echo set_value('gatepass_no'); ?>" autofocus>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Search </button>
          </div>
          <div class="col-sm-1">
            <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>gatep/stockin/lists">All</a>
          </div>
          </div>
        </form>
        <!-- <div class="table-responsive table-bordered"> -->
          <table id="" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
          <tr>
              <th style="width:5%;text-align:center">SN</th>
              <th style="width:8%;text-align:center">Date</th>
              <th style="width:10%;text-align:center">Gatepass No</th>
              <th style="width:10%;text-align:center">Carried Name(ID)</th>
              <th style="text-align:center;width:10%">From</th>
              <th style="text-align:center;width:10%">To</th>
              <th style="text-align:center;width:6%">Status</th>
              <th  style="text-align:center;width:5%">Action</th>
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
              <td style="text-align:center">
              <?php echo findDate($row->create_date); ; ?></td>
            <td style="text-align:center"><?php echo $row->gatepass_no;?></td>
            <td style="text-align:center">
              <?php echo "$row->carried_by ($row->employee_id)";  ?></td>
            <td style="text-align:center">
            <?php echo $row->wh_whare;  ?></td>
            <td style="text-align:center">
            <?php echo $row->issue_from;  ?></td>
            <td style="text-align:center">
              <span class="btn btn-xs btn-<?php echo ($row->gatepass_status==2||$row->gatepass_status==1)?"danger":"success";?>">
                  <?php 
                  if($row->gatepass_status==1) echo "Draft";
                  elseif($row->gatepass_status==2) echo "Submit";
                  elseif($row->gatepass_status==3) echo "Confirmed";
                  elseif($row->gatepass_status==4) echo "Approved";
                  elseif($row->gatepass_status==5) echo "Checkout";
                  elseif($row->gatepass_status==6) echo "Checkin";
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
                      <li><a href="<?php echo base_url()?>gatep/stockin/view/<?php echo $row->gatepass_id;?>"><i class="fa ffa fa-eye tiny-icon"></i>View</a></li>
                       <?php if($row->gatepass_status==1){  ?>
                     <li><a href="<?php echo base_url()?>gatep/stockin/submit/<?php echo $row->gatepass_id;?>">
                      <i class="fa fa-arrow-circle-right tiny-icon"></i>Send</a>
                    </li>
                    <?php } ?>
                      <?php if($row->gatepass_status==1){  ?>
                      <?php if($this->session->userdata('update')=='YES'){ ?>
                      <li>  <a href="<?php echo base_url()?>gatep/stockin/edit/<?php echo $row->gatepass_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit</a>
                      </li>
                      <?php } ?>
                        <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->gatepass_id;?>">
                        <i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
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
    location.href="<?php echo base_url();?>gatep/stockin/delete/"+rowId;
  }
});
});//jquery ends here
</script>

