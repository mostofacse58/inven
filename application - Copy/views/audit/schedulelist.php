<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
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
<div class="box box-info">
            <!-- /.box-scheduleer -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>audit/schedule/save<?php if(isset($info)) echo "/$info->master_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Quarter<span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                    <select class="form-control select2" name="quater" id="quater">
                      <option value="1"
                          <?php  if(isset($info)) echo 1==$info->quater? 'selected="selected"':0; else echo set_select('quater',1);?>>
                            1st</option>
                        <option value="2"
                          <?php  if(isset($info)) echo 2==$info->quater? 'selected="selected"':0; else echo set_select('quater',2);?>>
                            2nd</option>
                      <option value="3"
                          <?php  if(isset($info)) echo 3==$info->quater? 'selected="selected"':0; else echo set_select('quater',3);?>>
                            3rd</option>
                      <option value="4"
                          <?php  if(isset($info)) echo 4==$info->quater? 'selected="selected"':0; else echo set_select('quater',4);?>>
                            4th</option>
                      <option value="5"
                          <?php  if(isset($info)) echo 5==$info->quater? 'selected="selected"':0; else echo set_select('quater',5);?>>
                            Yearly</option>
                    </select>
                   <span class="error-msg"><?php echo form_error("quater");?></span>
                 </div>
                  <label class="col-sm-2 control-label">Type<span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                    <select class="form-control select2" name="atype" id="atype">
                        <option value="IA"
                          <?php  if(isset($info)) echo 'IA'==$info->atype? 'selected="selected"':0; else echo set_select('atype','IA');?>>
                            IA</option>
                        <option value="Self"
                          <?php  if(isset($info)) echo 'Self'==$info->atype? 'selected="selected"':0; else echo set_select('atype','Self');?>>
                            Self</option>
                      </select>
                   <span class="error-msg"><?php echo form_error("atype");?></span>
                 </div>
                 <label class="col-sm-2 control-label">Category<span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                    <select class="form-control select2" name="acategory" id="acategory">
                      <option value="Departmental"
                          <?php  if(isset($info)) echo 'Departmental'==$info->acategory? 'selected="selected"':0; else echo set_select('acategory','Departmental');?>>
                            Departmental</option>
                      <option value="Inventory"
                          <?php  if(isset($info)) echo 'Inventory'==$info->acategory? 'selected="selected"':0; else echo set_select('acategory','Inventory');?>>
                            Inventory</option>
                      <option value="Asset"
                          <?php  if(isset($info)) echo 'Asset'==$info->acategory? 'selected="selected"':0; else echo set_select('acategory','Asset');?>>
                            Asset</option>
                    </select>
                   <span class="error-msg"><?php echo form_error("quater");?></span>
                 </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Start Date<span style="color:red;">  *</span> </label>
                 <div class="col-sm-2">
                       <div class="input-group date">
                     <div class="input-group-addon">
                       <i class="fa fa-calendar"></i>
                     </div>
                     <input type="text" name="start_date" readonly id="start_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->start_date); else echo date('d/m/Y'); ?>">
                   </div>
                   <span class="error-msg"><?php echo form_error("start_date");?></span>
                  </div>
                  <label class="col-sm-2 control-label">End Date<span style="color:red;">  *</span> </label>
                   <div class="col-sm-2">
                      <div class="input-group date">
                       <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <input type="text" name="end_date" readonly id="end_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->end_date); else echo date('d/m/Y'); ?>">
                     </div>
                     <span class="error-msg"><?php echo form_error("end_date");?></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">For Year<span style="color:red;">  *</span></label>
                  <div class="col-sm-2">
                  <input type="text" name="year" <?php if(isset($info)) echo ""; ?>  class="form-control integerchk" value="<?php if(isset($info)) echo $info->year; else echo set_value('year');  ?>"> 
                    <span class="error-msg"><?php echo form_error("year"); ?></span>
                  </div>
                  <label class="col-sm-2 control-label">For Department<span style="color:red;">  *</span></label>
                    <div class="col-sm-2">
                      <select class="form-control select2" required name="department_id" id="department_id">
                        <option value="">Select Department</option>
                        <?php foreach ($dlist as $value) {  ?>
                          <option value="<?php echo $value->department_id; ?>"
                            <?php  if(isset($info)) echo $value->department_id==$info->department_id? 'selected="selected"':0; else echo set_select('department_id',$value->department_id);?>>
                            <?php echo $value->department_name; ?></option>
                          <?php } ?>
                      </select>
                     <span class="error-msg"><?php echo form_error("department_id");?></span>
                    </div>
                    <label class="col-sm-2 control-label">By Department<span style="color:red;">  *</span></label>
                    <div class="col-sm-2">
                      <select class="form-control select2" required name="by_department" id="by_department">
                        <option value="">Select Department</option>
                        <?php foreach ($dlist as $value) {  ?>
                          <option value="<?php echo $value->department_id; ?>"
                            <?php  if(isset($info)) echo $value->department_id==$info->by_department? 'selected="selected"':0; else echo set_select('by_department',$value->department_id);?>>
                            <?php echo $value->department_name; ?></option>
                          <?php } ?>
                      </select>
                     <span class="error-msg"><?php echo form_error("by_department");?></span>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Note<span style="color:red;">  *</span></label>
                  <div class="col-sm-6">
                    <input type="text" name="note" class="form-control" placeholder="note" value="<?php if(isset($info)) echo $info->note; else echo set_value('note'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("note");?></span>
                </div>
                <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">SAVE 保存</button>
                </div>
                </div>

              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-scheduleer -->
            <div class="box-body box">
              <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:10%">Quarter</th>
                      <th style="width:10%">Type</th>
                      <th style="width:10%">Category</th>
                      <th style="width:20%">For Department</th>
                      <th style="width:10%">Start Date</th>
                      <th style="width:10%">End Date</th>
                      <th style="width:20%">Note</th>
                      <th style="width:10%">Status</th>
                      <th  style="text-align:center;width:15%">Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td class=""><?php if($row->quater==1) echo "1st";
                              elseif($row->quater==2) echo "2nd";
                              elseif($row->quater==3) echo "3rd";
                              elseif($row->quater==4) echo "4th";
                              elseif($row->quater==5) echo "Yearly"; ?></td>
                              <td class=""><?php echo $row->atype;?></td>
                              <td class=""><?php echo $row->acategory;?></td>
                              <td class=""><?php echo $row->department_name;?></td>
                              <td class=""><?php echo $row->start_date;?></td>
                              <td class=""><?php echo $row->end_date;?></td>
                              <td class=""><?php echo $row->note;?></td>
                              <td style="text-align: center;">
                                <?php if($row->status==1) echo "Draft";
                              elseif($row->status==2) echo "Pending";
                              elseif($row->status==3) echo "Completed";
                              ?></td>
                              <td style="text-align:center">
                                <!-- Single button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                    <li> <a href="<?php echo base_url()?>audit/selfa/loadExcel/<?php echo $row->master_id;?>" target="_blank">
                                      <i class="fa fa-eye tiny-icon"></i>View</a></li>
                                      <?php if($row->status==1){ ?>
                                      <li> <a href="<?php echo base_url()?>audit/schedule/edit/<?php echo $row->master_id;?>">
                                        <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                                      <li><a href="#" class="delete" data-pid="<?php echo $row->master_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                                      <li> <a href="<?php echo base_url()?>audit/schedule/send/<?php echo $row->master_id;?>">
                                        <i class="fa fa-send tiny-icon"></i>Send</a></li>
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
<div class="modal modal-danger fade bs-example-modal-sm " tabindex="-1" role="dialog" id="deleteMessage" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-bell-o"></i> System Alert</h4>
        </div>
        <div class="modal-body">
        Sorry, this Head can't be deleted!!
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>

<script>
$(document).ready (function(){
var count = 1

    $('.date').datepicker({
        "format": "dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose": true
    });


//////////////
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this schedule?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>audit/schedule/checkDelete/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#deleteMessage").modal("show");
      }else{
        location.href="<?php echo base_url();?>audit/schedule/delete/"+rowId;
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
