<style type="text/css">
  .error-msg{display: none;}
</style>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
var url1="<?php echo base_url(); ?>cctv/camerastatuslists";
  $(document).ready(function() {
    $('.date').datepicker({
        "format":"dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose":true
      });
    ////////////////////////////////
    $("#addNewTeam").click(function(){
    var return_note = $("#return_note").val();
    var return_date = $("#return_date").val();
    var error = 0;
   
    if(return_note==""){
      $("#return_note").css({"border-color":"red"});
      $("#return_note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#return_note").css({"border-color":"#ccc"});
      });
      error=1;
    }
    if(return_date==""){
      $("#return_date").css({"border-color":"red"});
      $("#return_date").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#return_date").css({"border-color":"#ccc"});
      });
      error=1;
    }
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }
  });
  ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".returnstore").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
     $("#cctv_main_id").val(rowId);
     $("#TeamModal").modal("show");
  });
  ////////////////////////////////
    $("#AddUnderService").click(function(){
    var return_note1 = $("#return_note1").val();
    var return_date1 = $("#return_date1").val();
    var error = 0;
   
    if(return_note==""){
      $("#return_note1").css({"border-color":"red"});
      $("#return_note1").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#return_note1").css({"border-color":"#ccc"});
      });
      error=1;
    }
    if(return_date1==""){
      $("#return_date1").css({"border-color":"red"});
      $("#return_date1").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#return_date1").css({"border-color":"#ccc"});
      });
      error=1;
    }
    if(error == 0) {
      $("#formId1").submit();
      //document.location=url1;
    }
  });
    ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".underService").click(function(e){
    e.preventDefault();
    var pid1=$(this).data('pid1');
     $("#cctv_main_id1").val(pid1);
     $("#TeamModal1").modal("show");
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

<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>cctv/camerastatus/add">
<i class="fa fa-plus"></i>
Add Status
</a>
</div>
</div>
</div>
</div>
      <!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" action="<?php echo base_url();?>cctv/camerastatus/lists" method="GET" enctype="multipart/form-data">
        <div class="form-group">
            <div class="col-sm-4">
            <input type="text" name="asset_encoding" class="form-control" placeholder="Search 搜索 like SN/ventura code/Name/Model" autofocus>
          </div>
          <div class="col-sm-2">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>cctv/camerastatus/lists">All</a>
        </div>
        </div>
       <!-- /.box-body -->
      </form>
      <div class="table-responsive table-bordered">
        <table id="" class="table table-bordered table-striped" style="width:100%;border:#00" >
          <thead>
          <tr>
            <th style="width:4%;">SN</th>
            <th style="width:8%">Ventura CODE</th>
            <th style="text-align:center;width:8%">Asset Code</th>
            <th style="width:8%;text-align:center">Location</th>
            <th style="width:10%;text-align:center">Start Time</th>
            <th style="width:10%;text-align:center">End time</th>
            <th style="text-align:center;width:10%;">Problem</th>
            <th style="text-align:center;width:6%;">Downtime</th>
            <th style="text-align:center;width:6%;">Status 状态</th>
            <th  style="text-align:center;width:5%;">Actions 行动</th>
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
                <?php echo $row->ventura_code; ; ?></td>
              <td style="text-align:center">
                <?php echo $row->asset_encoding; ; ?></td>
              <td style="text-align:center">
                <?php echo "$row->location_name($row->coveragearea)";
                ///$this->camerastatus_model->getlocation($row->product_detail_id); ?></td> 
              <td style="text-align:center">
                <?php echo "$row->start_date $row->start_time"; ?></td> 
              <td style="text-align:center">
                <?php echo "$row->end_date $row->end_time"; ?></td>
              <td style="text-align:center">
                <?php echo $row->remarks; ?></td> 
              <td style="text-align:center">
              <?php if($row->end_date!=''&&$row->end_time!=''){
                $datetime1 = new DateTime("$row->start_date $row->start_time");
                $datetime2 = new DateTime("$row->end_date $row->end_time");
                $interval = $datetime1->diff($datetime2);
                $elapsed = $interval->format('%a days %h hours %i minutes');
                echo $elapsed;
              }  ?></td>
              <td style="text-align:center">
              <span class="btn btn-xs btn-<?php if($row->cctv_status==1) echo "danger"; else echo "success";?>">
               <?php 
                if($row->cctv_status==1) echo "Offline";
                else if($row->cctv_status==2) echo "Online";
                else if($row->cctv_status==3) echo "Damage";
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
                 <!--    <li> <a href="#" data-pid="<?php echo $row->cctv_main_id; ?>" class="returnstore"><i class="fa fa-arrow-circle-o-right tiny-icon"></i>Online</a></li> -->
               
                    <li><a href="<?php echo base_url()?>cctv/camerastatus/edit/<?php echo $row->cctv_main_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                      <?php if($this->session->userdata('delete')=='YES'){ ?>
                    <li><a href="#" class="delete" data-pid="<?php echo $row->cctv_main_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Return</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>cctv/camerastatusreturndate">
          
          <div class="form-group">
            <label class="col-sm-3 control-label">Date </label>
            <div class="col-sm-6">
              <input class="form-control date" name="return_date" readonly=""   id="return_date" placeholder="Date">
              <span class="error-msg">Date field is required</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Return Note </label>
            <div class="col-sm-6">
              <textarea class="form-control" name="return_note" rows="2" id="return_note" placeholder="Return Note"></textarea> 
              <span class="error-msg">Note field is required</span>
            </div>
          </div>
       <input type="hidden" name="cctv_main_id"  id="cctv_main_id">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> OK</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade " id="TeamModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Under Service</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId1" method="POST" action="<?php echo base_url()?>cctv/camerastatusunderService">
          <div class="form-group">
            <label class="col-sm-3 control-label">Date </label>
            <div class="col-sm-6">
              <input class="form-control date" name="return_date1" readonly=""   id="return_date1" placeholder="Date">
              <span class="error-msg">Date field is required</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Note </label>
            <div class="col-sm-6">
              <textarea class="form-control" name="return_note1" rows="2" id="return_note1" placeholder="Note"></textarea> 
              <span class="error-msg">Note field is required</span>
            </div>
          </div>
       <input type="hidden" name="cctv_main_id1"  id="cctv_main_id1">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="AddUnderService"><i class="fa fa-save"></i> OK</button>
      </div>
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
  var url=$(this).attr("href");
  location.href="<?php echo base_url();?>cctv/camerastatus/delete/"+rowId;

}
});

});//jquery ends here
</script>