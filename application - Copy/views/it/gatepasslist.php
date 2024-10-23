<style type="text/css">
  .error-msg{display: none;}
</style>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
var url1="<?php echo base_url(); ?>it/gatepass/lists";
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
     $("#gatepass_id").val(rowId);
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
     $("#gatepass_id1").val(pid1);
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

<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/gatepass/add">
<i class="fa fa-plus"></i>
Add 
</a>
</div>
</div>
</div>
</div>
      <!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" action="<?php echo base_url();?>it/gatepass/lists" method="GET" enctype="multipart/form-data">
   
        <div class="form-group">
          <label class="col-sm-1 control-label">Location </label>
          <div class="col-sm-3">
            <select class="form-control select2"  name="location_name" id="location_name">
              <option value="">All Location</option>
              <?php
               foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_name; ?>"
                  <?php  if(isset($info)) echo $value->location_name==$info->location_name? 'selected="selected"':0; else echo set_select('location_name',$value->location_name);?>>  
                  <?php echo $value->location_name; ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="col-sm-6">
            <input type="text" name="asset_encoding" class="form-control" placeholder="Search 搜索 like SN/ventura code/Gate Pass No" autofocus>
          </div>
          <div class="col-sm-2">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/gatepass/lists">All</a>
        </div>
        </div>

        <!-- /.box-body -->
      </form>
      <div class="table-responsive table-bordered">
        <table id="" class="table table-bordered table-striped" style="width:100%;border:#00" >
          <thead>
          <tr>
            <th style="width:4%;">SN</th>
            
            <th style="text-align:center;width:8%;">Servicing Date</th>
            <th style="width:8%">Type</th>
            <th style="width:8%">Ref. No</th>
            <th style="width:15%;">Asset Name</th>
            <th style="text-align:center;width:8%">Serial No</th>
            <th style="width:6%;text-align:center">Location</th>
            <th style="text-align:center;width:6%;">Service Qty</th>
            <th style="text-align:center;width:6%;">Cost</th>
            <th style="text-align:center;width:12%;">Issue To</th>
            <th style="text-align:center;width:6%;">Status </th>
            <th  style="text-align:center;width:5%;">Actions </th>
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
              <?php echo findDate($row->servicing_date);  ?></td>
             <td style="text-align:center">
                <?php echo $row->servicing_type;  ?></td>
              <td style="text-align:center">
                <?php echo $row->reference_no; ?></td>
              <td><?php echo $row->product_name; ?></td>
              <td style="text-align:center">
                <?php echo $row->asset_encoding;  ?></td>
              <td style="text-align:center">
                <?php echo $row->location_name; ?></td>
                 <td style="text-align:center">
                <?php echo $row->out_quantity;  ?></td>
                <td style="text-align:center">
                <?php echo $row->servicing_cost;  ?></td>
                <td style="text-align:center">
                <?php echo $row->issuer_to_name;  ?></td>
              <td style="text-align:center">
              <span class="btn btn-xs btn-success">
                <?php 
                echo "Done"; 
                ?>
              </span>
              </td>
              <td style="text-align:center">
              <div class="btn-group">
                  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li> <a href="<?php echo base_url()?>it/gatepass/gatein/<?php echo $row->gatepass_id;?>"><i class="fa fa-edit tiny-icon"></i>Gate In</a></li>
                    <li> <a href="<?php echo base_url()?>it/gatepass/edit/<?php echo $row->gatepass_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                      <?php if($this->session->userdata('delete')=='YES'){ ?>
                    <li><a href="#" class="delete" data-pid="<?php echo $row->gatepass_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>it/gatepass/returndate">
          
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
       <input type="hidden" name="gatepass_id"  id="gatepass_id">
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
        <form class="form-horizontal" id="formId1" method="POST" action="<?php echo base_url()?>it/gatepass/underService">
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
       <input type="hidden" name="gatepass_id1"  id="gatepass_id1">
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
   url:"<?php echo base_url();?>it/gatepass/checkDelete 删除/"+rowId,
   success:function(data){
    if(data=="EXISTS"){
      $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
      $("#alertMessagemodal").modal("show");
    }else{
      location.href="<?php echo base_url();?>it/gatepass/delete/"+rowId;
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