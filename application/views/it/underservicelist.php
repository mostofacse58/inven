<style type="text/css">
  .error-msg{display: none;}
</style>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
var url1="<?php echo base_url(); ?>it/underservice/lists";
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
     $("#asset_issue_id").val(rowId);
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
     $("#asset_issue_id1").val(pid1);
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
</div>
</div>
</div>
</div>
      <!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" action="<?php echo base_url();?>it/underservice/lists" method="GET" enctype="multipart/form-data">
   
        <div class="form-group">
          <label class="col-sm-1 control-label">Location </label>
          <div class="col-sm-3">
            <select class="form-control select2"  name="location_id" id="location_id">
              <option value="">All Location</option>
              <?php
               foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_id; ?>"
                  <?php  if(isset($info)) echo $value->location_id==$info->location_id? 'selected="selected"':0; else echo set_select('location_id',$value->location_id);?>>  <?php echo $value->location_name; ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="col-sm-6">
            <input type="text" name="asset_encoding" class="form-control" placeholder="Search 搜索 like SN/ventura code/Name/Model" autofocus>
          </div>
          <div class="col-sm-2">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/underservice/lists">All</a>
        </div>
        </div>

        <!-- /.box-body -->
      </form>
      <div class="table-responsive table-bordered">
        <table id="" class="table table-bordered table-striped" style="width:100%;border:#00" >
          <thead>
          <tr>
            <th style="width:4%;">SN</th>
            <th style="text-align:center;width:6%">Category</th>
            <th style="width:20%;">Asset Name</th>
            <th style="width:8%">Ventura CODE</th>
            <th style="text-align:center;width:8%">Serial No</th>
            <th style="width:10%;text-align:center">Department</th>
            <th style="width:10%;text-align:center">Employee</th>
            <th style="width:6%;text-align:center">Location</th>
            <th style="text-align:center;width:10%;">Issue Date</th>
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
                <?php echo $row->category_name; ?></td>
              <td><?php echo $row->product_name;?></td>
              <td style="text-align:center">
                <?php echo $row->ventura_code; ; ?></td>
              <td style="text-align:center">
                <?php echo $row->asset_encoding; ; ?></td>
              <td style="text-align:center">
                <?php echo "$row->department_name"; ?></td> 
                <td style="text-align:center">
                <?php echo "$row->employee_name"; ?></td> 
              <td style="text-align:center">
                <?php echo $row->location_name; ?></td> 
              <td style="text-align:center">
              <?php echo findDate($row->issue_date);  ?></td>
              <td style="text-align:center">
              <span class="btn btn-xs btn-success">
                <?php 
                echo CheckStatus($row->it_status);
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
                  <?php if($row->issue_status==3){ ?>
                  <li><a  data-pid="<?php echo $row->product_detail_id; ?>" class="returnstore"><i class="fa fa-arrow-circle-o-right tiny-icon"></i>Done Return</a></li>
                  <li><a href="#" data-pid1="<?php echo $row->product_detail_id; ?>" class="underService"><i class="fa fa fa-arrow-circle-o-right tiny-icon"></i>Done at Same Place</a></li>
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
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>it/underservice/returndate">
          
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
       <input type="hidden" name="asset_issue_id"  id="asset_issue_id">
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
        <form class="form-horizontal" id="formId1" method="POST" action="<?php echo base_url()?>it/underservice/underService">
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
       <input type="hidden" name="asset_issue_id1"  id="asset_issue_id1">
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
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>it/underservice/checkDelete 删除/"+rowId,
   success:function(data){
    if(data=="EXISTS"){
      $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
      $("#alertMessagemodal").modal("show");
    }else{
      location.href="<?php echo base_url();?>it/underservice/delete/"+rowId;
   }
},
error:function(){
  console.log("failed");
}
});
}
});

});//jquery ends here
</script>