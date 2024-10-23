<style type="text/css">
  .error-msg{display: none;}
</style>
<script type="text/javascript">
var url1="<?php echo base_url(); ?>it/pregistraion/lists";
  $(document).ready(function() {
    ////////////////////////////////
    $("#addNewTeam").click(function(){
    var it_status = $("#it_status").val();
    var despose_note = $("#despose_note").val();
    var issue_to_name = $("#issue_to_name").val();
    var error = 0;
   
    if(despose_note==""){
      $("#despose_note").css({"border-color":"red"});
      $("#despose_note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#despose_note").css({"border-color":"#ccc"});
      });
      error=1;
    }
    if(it_status==3){
      if(issue_to_name==""){
      $("#issue_to_name").css({"border-color":"red"});
      $("#issue_to_name").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#issue_to_name").css({"border-color":"#ccc"});
      });
      error=1;
    }
    }
   
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }

  });
    ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".despose").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
     $("#product_detail_id").val(rowId);
     $("#TeamModal").modal("show");
  });

////////////////////////////////
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
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/pregistraion/add">
          <i class="fa fa-plus"></i>
          Add Asset Register
          </a>
          </div>
          </div>
          </div>
    </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form class="form-horizontal" action="<?php echo base_url();?>it/pregistraion/lists" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label class="col-sm-3 control-label">Serial No/Ventura CODE</label>
                <div class="col-sm-3">
                  <input type="text" name="asset_encoding" class="form-control" placeholder="Serial No/Ventura CODE" value="<?php  echo set_value('asset_encoding'); ?>" autofocus>
                </div>
                <div class="col-sm-1">
                <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              </div>
              <div class="col-sm-1">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/pregistraion/lists">All</a>
              </div>
              </div>
            </form>
            <div class="table-responsive table-bordered">
              <table id="" class="table table-bordered table-striped" style="width:100%;border:#000" >
                <thead>
              <tr>
                  <th style="width:8%;text-align:center">Ventura Code</th>
                  <th style="width:15%;;text-align:center">Asset Name</th>
                  <th style="width:10%;text-align:center">Category</th>
                  <th style="width:10%;text-align:center">Model No</th>
                  <th style="text-align:center;width:7%">Serial No</th>
                  <th style="text-align:center;width:6%">Price</th>
                  <th style="text-align:center;width:10%">Invoice No</th>
                  <th style="text-align:center;width:6%">Status 状态</th>
                  <th  style="text-align:center;width:5%">Actions 行动</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)):
                foreach($list as $row):
                    ?>
                  <tr>
                    <td style="text-align:center">
                      <?php echo $row->ventura_code; ; ?></td>
                    <td><?php echo $row->product_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->category_name; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="text-align:center">
                    <?php  echo $row->asset_encoding; ?></td>
                    <td style="vertical-align: text-top">
                    <?php  echo $row->machine_price; ?> BDT</td>
                    <td style=";text-align:center">
                    <?php  echo $row->invoice_no; ?></td>
                    <td style="text-align:center">
                      <span class="btn btn-xs btn-<?php echo ($row->it_status>=3)?"danger":"success";?>">
                      <?php 
                        echo CheckStatuspro($row->it_status);
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
                          <li><a href="<?php echo base_url()?>it/pregistraion/views/<?php echo $row->product_detail_id;?>">
                            <i class="fa ffa fa-arrow-circle-right tiny-icon"></i>View Detail</a></li>
                          <?php if($row->it_status!=1){  ?>
                          <?php if($row->detail_status==1){  ?>
                          <li><a href="<?php echo base_url()?>it/pregistraion/damages/<?php echo $row->product_detail_id;?>">
                            <i class="fa fa-window-close tiny-icon"></i>Damage</a></li>
                          <li>  <a href="<?php echo base_url()?>it/pregistraion/edit/<?php echo $row->product_detail_id;?>">
                            <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a>
                          </li>
                          <?php if($this->session->userdata('delete')=='YES'){ ?>
                          <li><a href="#" class="delete" data-pid="<?php echo $row->product_detail_id;?>">
                            <i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                        <?php } ?>
                        <?php } ?>

                        <?php if($row->it_status==4){  ?>
                         <li><a href="<?php echo base_url()?>it/pregistraion/activated/<?php echo $row->product_detail_id;?>">
                          <i class="fa fa-check-square tiny-icon"></i>Active</a></li>
                        <?php } ?>
                        <?php if($row->it_status==9){  ?>
                         <li><a href="<?php echo base_url()?>it/pregistraion/activated/<?php echo $row->product_detail_id;?>">
                          <i class="fa fa-check-square tiny-icon"></i>Active</a></li>
                        <?php } ?>
                        <?php 
                           //if($row->it_status<=4){  ?>
                         <li>
                          <a href="#" data-pid="<?php echo $row->product_detail_id; ?>" class="despose">
                          <i class="fa fa-check-square-o tiny-icon"></i>Change Status</a></li>
                          <li><a href="<?php echo base_url()?>it/pregistraion/notfound/<?php echo $row->product_detail_id;?>"><i class="fa fa-check-square tiny-icon"></i>Not Found</a></li>
                         <?php } ?>
                        <?php //} ?>
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
        <h4 class="modal-title text-primary" id="myModalLabel"> Form</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>it/pregistraion/changestatus">
         <div class="form-group">
          <label class="col-sm-4 control-label">Status </label>
          <div class="col-sm-7">
            <select class="form-control select2" name="it_status" id="it_status" style="width: 100%;">
            <option value="">Select Status</option> 
              <option value="2"
                <?php  echo set_select('it_status',2);?>>IDLE/Stock</option>
              <option value="3"
                <?php  echo set_select('it_status',3);?>>Under Service</option>
              <option value="4"
                <?php  echo set_select('it_status',4);?>>Damage</option>
              <option value="5"
                <?php  echo set_select('it_status',5);?>>Dispose</option>
              <option value="6"
                <?php  echo set_select('it_status',6);?>>Sold</option>
              <option value="7"
                <?php  echo set_select('it_status',7);?>>CSR</option>
              <option value="8"
                <?php  echo set_select('it_status',8);?>>Lost</option>
              <option value="9"
                <?php  echo set_select('it_status',9);?>>Dormant</option>
              <option value="10"
                <?php  echo set_select('it_status',10);?>>Transfer</option>
              <option value="11"
                <?php  echo set_select('it_status',11);?>>Paper Free</option>
            </select>
           <span class="error-msg"><?php echo form_error("it_status");?></span>
          </div>
        </div>

          <div class="form-group">
            <label class="col-sm-4 control-label">Note </label>
            <div class="col-sm-7">
              <textarea class="form-control" name="despose_note" rows="4" id="despose_note" placeholder="Note">Mega Dispose-2 15 ,Feb 2021</textarea> 
              <span class="error-msg">Note field is required</span>
            </div>
          </div>
          <div class="form-group under_service">
            <label class="col-sm-4 control-label">Issue To Name </label>
            <div class="col-sm-7">
              <textarea class="form-control" name="issue_to_name" rows="4" id="issue_to_name" placeholder="Issue To"></textarea> 
              <span class="error-msg">Issue field is required</span>
            </div>
          </div>
       <input type="hidden" name="product_detail_id"  id="product_detail_id">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> Save</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready (function(){
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
    e.preventDefault();
    var rowId=$(this).data('pid');
      $.ajax({
       type:"GET",
       url:"<?php echo base_url();?>it/pregistraion/checkUse/"+rowId,
         success:function(data){
           if(data=="EXISTS"){
             $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
            $("#alertMessagemodal").modal("show");
           }else{
          location.href="<?php echo base_url();?>it/pregistraion/delete/"+rowId;
         }
    },
    error:function(){
      console.log("failed");
    }
    });
    }
  });
///////////////////////////
var it_status=$("#it_status").val(); 
   if(it_status==3){
         $(".under_service").show();
      }else{
         $(".under_service").hide();
      }
  $("#it_status").change(function(){
    var it_status=$("#it_status").val(); 
      if(it_status==3){
         $(".under_service").show();
      }else{
        $(".under_service").hide();
      }
    });

});
</script>
