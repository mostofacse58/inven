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
            <form class="form-horizontal" action="<?php echo base_url();?>me/material/save<?php if(isset($info)) echo "/$info->mtype_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                
                  <label class="col-sm-2 control-label">Material Type<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="mtype_name" class="form-control" placeholder="Material Type" value="<?php if(isset($info)) echo $info->mtype_name; else echo set_value('mtype_name'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("mtype_name");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">
                <?php if(isset($info)) echo "Update"; else echo "SAVE 保存"; ?> </button>
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
                      <th style="width:5%">SL No</th>
                      <th style="width:20%">Material Type</th>
                      <th  style="text-align:center;width:10%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)): $i=1;
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td><?php echo $i++;?></td>
                              <td><?php echo $row->mtype_name;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>me/material/edit/<?php echo $row->mtype_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                                <a href="<?php echo base_url()?>me/material/delete/<?php echo $row->mtype_id;?>" class="btn btn-danger delete" onClick="return doconfirm();" ><i class="fa fa-trash-o tiny-icon"></i></a>
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
