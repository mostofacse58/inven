<link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/datatables/dataTables.bootstrap.css'); ?>">
<div class="row">
  <div class="col-xs-12">
   <div class="box box-primary">
    <div class="box-header">
      <div class="widget-block">
<div class="widget-head">
<h5><?php echo "$heading"; ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>configcontroller/addPostForm">
<i class="fa fa-plus"></i>
Add New Designation
</a>
</div>
</div></div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                                <tr>
                                    <th style="text-align:center">Designation Name</th>
                                     <th  style="text-align:center">Actions 行动</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($postlist&&!empty($postlist)):
                                    foreach($postlist as $row):
                                        ?>
                                        <tr>
                                            <td style="text-align:center"><?php echo $row->post_name;?></td>
                                         
                                           
                                            <td style="text-align:center">
                                            <?php 
                                                if($this->session->userdata('user_type')==1):
                                            ?>
                                                <!-- Single button -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">

                                                        <li>  <a href="<?php echo base_url()?>configcontroller/editPostForm/<?php echo $row->post_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                                                      
                                                        <li><a href="<?php echo base_url()?>configcontroller/deletePost/<?php echo $row->post_id;?>" class="delete" data-cid="<?php echo $row->post_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>

                                                    </ul>
                                                </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
 </div>
