<style type="text/css">
  .error-msg{display: none;}
</style>
<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
    <div class="box-body">
      <form class="form-horizontal" action="<?php echo base_url();?>format/overseapi/lists" method="GET" enctype="multipart/form-data">
      <div class="box-body">
        <label class="col-sm-1 control-label">
         PI. NO <span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control" name="pi_no" id="pi_no" value="<?php echo set_value('pi_no'); ?>" placeholder="NO">
          <span class="error-msg"><?php echo form_error("pi_no");?></span>
          </div>
          <label class="col-sm-1 control-label">
         ITEM CODE/NAME <span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="ITEM CODE/NAME">
          <span class="error-msg"><?php echo form_error("product_code");?></span>
          </div>
          <div class="col-sm-2">
          <select class="form-control select2" required name="pi_status" id="pi_status" onchange='this.form.submit()'>
            <option value="All">All Status</option>
              <option value="4"
              <?php  if(isset($info)) echo 4==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',4);?>>
                Certified</option>
              <option value="5"
              <?php  if(isset($info)) echo 5==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',5);?>>
                Pending</option>
              <option value="6"
              <?php  if(isset($info)) echo 6==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',6);?>>
                Receved</option>
              <option value="7"
              <?php  if(isset($info)) echo 7==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',7);?>>
                Approved</option>
          </select>
         <span class="error-msg"><?php echo form_error("pi_status");?></span>
        </div>
          <div class="col-sm-2">
            <select class="form-control select2" name="department_id" id="department_id" onchange='this.form.submit()'>
            <option value="All" <?php echo 'All'==set_value('department_id')? 'selected="selected"':0; ?>>All Department</option>
            <?php 
            foreach($dlist as $rows){  ?>
            <option value="<?php echo $rows->department_id; ?>" 
              <?php echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->department_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("department_id");?></span>
          </div>
          <div class="col-sm-2">
            <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
            <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>format/overseapi/lists">All</a>
        </div>
      </div>
        <!-- /.box-body -->
      </form>
      <div class="table-responsive table-bordered">
      <table id="" class="table table-bordered table-striped" style="width:100%;border:#000">
         <thead>
          <tr>
            <th style="text-align:center;width:4%;">SN</th>
            <th style="text-align:center;width:10%;">Department</th>
            <th style="text-align:center;width:8%;">For</th>
            <th style="text-align:center;width:8%;">Type</th>
            <th style="text-align:center;width:8%">PI NO</th>
            <th style="text-align:center;width:8%;">PI Date</th>
            <th style="text-align:center;width:8%">Demand Date</th>
            <th style="text-align:center;width:8%;">New Demand Date</th>
            <th style="text-align:center;width:8%;">Approved Date</th>
            <th style="text-align:center;width:10%;">Status 状态</th>
            <th style="text-align:center;width:10%;">Requested by</th>
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
      <td class="text-center"><?php echo $row->department_name; ?></td>
      <td class="text-center"><?php 
      if($row->pi_type==1) echo "Safety Item"; 
            else echo "Fixed Asset"; ?></td>
      <td class="text-center"><?php 
      if($row->purchase_type_id==1||$row->purchase_type_id==2) echo "Overseas"; 
            else echo "Local"; ?></td>
      <td class="text-center"><?php echo $row->pi_no; ?></td>
      <td class="text-center"><?php echo findDate($row->pi_date); ?></td>
      <td class="text-center"><?php echo findDate($row->demand_date); ?></td>
      <td class="text-center"><?php echo findDate($row->new_demand_date); ?></td>
      <td class="text-center"><?php echo findDate($row->approved_date); ?></td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->pi_status==5||$row->pi_status==8)?"danger":"success";?>">
        <?php 
          if($row->pi_status==1) echo "Draft";
          elseif($row->pi_status==4) echo "Certified";
          elseif($row->pi_status==5) echo "Pending";
          elseif($row->pi_status==6) echo "Received";
          elseif($row->pi_status==7) echo "Approved";
          elseif($row->pi_status==8) echo "Rejected";
          ?>
      </span></td>
      <td class="text-center"><?php echo $row->user_name; ?></td>
            <td style="text-align:center">
            <div class="btn-group">
            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
              <?php if($row->pi_status==5){ ?>
              <li> <a href="<?php echo base_url()?>format/overseapi/received/<?php echo $row->pi_id;?>">
                <i class="fa fa-check tiny-icon"></i>Receive 接收</a></li>
              <li> <a href="<?php echo base_url()?>format/overseapi/returns/<?php echo $row->pi_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Return 返回</a></li>
            <li> <a  data-pid="<?php echo $row->pi_id; ?>" data-pistatus="8" class="canceled" href="#">
                <i class="fa fa-times tiny-icon"></i>Reject 拒绝</a></li>
            <?php } ?>
              <li><a href="<?php echo base_url()?>dashboard/viewpipdf/<?php echo $row->pi_id;?>" target="_blank">
                <i class="fa fa-eye tiny-icon"></i>View PDF</a></li>
               <li> <a href="<?php echo base_url()?>dashboard/downloadpiExcel/<?php echo $row->pi_id;?>" target="_blank">
                <i class="fa fa-eye tiny-icon"></i>View Excel</a></li>
                <li> <a href="<?php echo base_url()?>format/overseapi/viewpihtmlonly/<?php echo $row->pi_id;?>">
              <i class="fa fa-eye tiny-icon"></i>View </a></li>
              <?php if($row->pi_status!=8){ ?>
              <li> <a href="<?php echo base_url()?>format/purhrequisn/addprice/<?php echo $row->pi_id;?>">
                <i class="fa fa-check tiny-icon"></i>Edit Price 加价</a></li>
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
 <div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Add Note</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>format/overseapi/rejected">
          <div class="form-group">
            <label class="col-sm-3 control-label">Note </label>
            <div class="col-sm-6">
              <textarea class="form-control" name="reject_note" rows="2" id="reject_note" placeholder="Note"></textarea> 
              <span class="error-msg">Note field is required</span>
            </div>
          </div>
       <input type="hidden" name="pi_id"  id="pi_id">
       <input type="hidden" name="pi_status"  id="pi_status">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> OK</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////

   ////////////////////////////////
    $("#addNewTeam").click(function(){
    var reject_note = $("#reject_note").val();
    var return_date = $("#return_date").val();
    var error = 0;
   
    if(reject_note==""){
      $("#reject_note").css({"border-color":"red"});
      $("#reject_note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#reject_note").css({"border-color":"#ccc"});
      });
      error=1;
    }
 
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }
  });
  ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".canceled").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
    var pistatus=$(this).data('pistatus');
     $("#pi_id").val(rowId);
     $("#pi_status").val(pistatus);
     $("#TeamModal").modal("show");
  });


});//jquery ends here
</script>