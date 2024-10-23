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
            <form class="form-horizontal" action="<?php echo base_url();?>department/save<?php if(isset($info)) echo "/$info->department_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">
                    Department Name <span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="department_name" class="form-control" autofocus placeholder="Department Name" value="<?php if(isset($info)) echo $info->department_name; else echo set_value('department_name'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("department_name");?></span>
                  </div>
                  <label for="inputEmail3" class="col-sm-2 control-label">
                    Email Address</label>
                  <div class="col-sm-3">
                    <input type="text" name="dept_head_email" class="form-control"  placeholder="Email Address" value="<?php if(isset($info)) echo $info->dept_head_email; else echo set_value('dept_head_email'); ?>">
                   <span class="error-msg"><?php echo form_error("dept_head_email");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">SAVE 保存</button>
                </div>
                  
                </div>

                </div>
              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
      <div class="box-body box">
        <div class="col-md-8">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th style="width:15%">Department Name</th>
                <th style="width:15%">Head Email Address</th>
                <th  style="text-align:center;width:5%">Actions 行动</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($list&&!empty($list)):
                foreach($list as $row):
                    ?>
                  <tr>
                      <td><?php echo $row->department_name;?></td>
                      <td><?php echo $row->dept_head_email;?></td>
                      <td style="text-align:center">
                        <a class="btn btn-success" href="<?php echo base_url()?>department/edit/<?php echo $row->department_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;                                        
                        <!-- <a href="<?php echo base_url()?>department/delete/<?php echo $row->department_id;?>" class="delete btn btn-success" onClick="return doconfirm();" ><i class="fa fa-trash-o tiny-icon"></i></a> -->
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
