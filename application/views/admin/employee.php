  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>

<script>
  $(document).ready(function(){
    $(".select2").select2();
   
    
  });
    $(document).ready(function(){
 
      //////////////////date picker//////////////////////
      $('.date').datepicker({
        "format":"dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose":true
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
<div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>employee/save<?php if(isset($info)) echo "/$info->employee_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Employee Name <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="employee_name" class="form-control" placeholder="Employee Name" value="<?php if(isset($info->employee_name)) echo $info->employee_name; else echo set_value('employee_name'); ?>">
                   <span class="error-msg"><?php echo form_error("employee_name");?></span>
                  </div>
                 <label class="col-sm-2 control-label">Designation <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="designation" class="form-control" placeholder="ID NO" value="<?php if(isset($info->designation)) echo $info->designation; else echo set_value('designation'); ?>">
                    <span class="error-msg"><?php echo form_error("designation"); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">ID NO <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="employee_cardno" class="form-control" placeholder="ID NO" value="<?php if(isset($info->employee_cardno)) echo $info->employee_cardno; else echo set_value('employee_cardno'); ?>">
                   <span class="error-msg"><?php echo form_error("employee_cardno");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Joining Date <span style="color:red;">  *</span> </label>
                  <div class="col-sm-3">
                    <input type="text" name="join_date" class="form-control date" readonly placeholder="Joining Date" value="<?php if(isset($info->join_date)) echo $info->join_date; else echo set_value('join_date'); ?>">
                   <span class="error-msg"><?php echo form_error("join_date");?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Department <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <input type="text" name="department_name" class="form-control" placeholder="" value="<?php if(isset($info->department_name)) echo $info->department_name; else echo set_value('mobile_no'); ?>">
                    <span class="error-msg"><?php echo form_error("department_name"); ?></span>
                  </div>
                  <label class="col-sm-2 control-label">Division </label>
                  <div class="col-sm-3">
                    <input type="text" name="division" class="form-control" placeholder="division" value="<?php if(isset($info->division)) echo $info->division; else echo set_value('division'); ?>">
                   <span class="error-msg"><?php echo form_error("division");?></span>
                  </div>
                </div>
            
                </div>
                <div class="box-footer">
                 <div class="col-sm-6"></div>
                 <div class="col-sm-4">
                <button type="submit" class="btn btn-success pull-left">SAVE 保存</button>
                </div>
              </div>
              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
            <div class="box-body box">
              <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:20%">Employee Name</th>
                      <th style="width:10%">Designation</th>
                      <th style="width:8%">ID NO</th>
                      <th style="width:10%">Department</th>
                      <th style="width:10%">Joining Date</th>
                      <th  style="text-align:center;width:10%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td><?php echo $row->employee_name;?></td>
                              <td><?php echo $row->designation;?></td>
                              <td><?php echo $row->employee_cardno;?></td>
                              <td><?php echo $row->department_name;?></td>
                              <td><?php echo $row->join_date;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>employee/edit/<?php echo $row->employee_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                                <a href="<?php echo base_url()?>employee/delete/<?php echo $row->employee_id;?>" class="delete btn btn-success" onClick="return doconfirm();" ><i class="fa fa-trash-o tiny-icon"></i></a>
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
