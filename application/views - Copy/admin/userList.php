
   <link rel="stylesheet" href="<?php echo base_url('asset/js/plugins/datatables/dataTables.bootstrap.css'); ?>">


<div class="row">
  <div class="col-xs-12">
   <div class="box box-primary">
   <div class="box-header">
     <div class="widget-block">
<div class="widget-head">
<h5><?php echo "$heading"; ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>configcontroller/addUserForm">
<i class="fa fa-plus"></i>
Add New User
</a>
</div>
</div></div>

</div>
<!-- /.box-header -->
<div class="box-body">
    <div class="table-responsive table-bordered">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th style="text-align:center;width:5%">SL</th>
<th style="text-align:center;width:25%">Name</th>
<th style="text-align:center;width:8%">ID NO</th>
<th style="text-align:center;width:15%">Email</th>
<th style="text-align:center;width:12%">Designation</th>
<th style="text-align:center;width:12%">Department</th>
<th style="text-align:center;width:10%">Status 状态</th>
<th  style="text-align:center;width:5%">Actions 行动</th>
<th  style="text-align:center;width:5%">Limit</th>
</tr>
</thead>
<tbody>
<?php
if($userlist&&!empty($userlist)): $i=1;
foreach($userlist as $user):
?>
<tr>
    <td><?php echo $i++;?></td>
    <td><?php echo $user->user_name;?></td>
    <td style="text-align:center">
        <?php echo $user->employee_id_no;?></td>
    <td style="text-align:center">
        <?php echo $user->email_address;?></td>
    <td><?php echo $user->post_name;?></td>
    <td><?php echo $user->department_name;?></td>
    <td>
        <span class="btn btn-xs btn-<?php echo ($user->status=='ACTIVE')?"success":"danger";?>">
        <?php echo $user->status;?>
            </span>
    </td>
   
    <td style="text-align:center">
    <?php 
        if($user->super_user!="TRUE"):
    ?>
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>  <a href="<?php echo base_url()?>configcontroller/addUserForm/<?php echo $user->id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                <?php if($user->status!='ACTIVE'){?>
                <li> <a href="<?php echo base_url()?>configcontroller/activateUser/<?php echo $user->id;?>"><i class="fa fa-check-circle tiny-icon"></i>Activate</a></li>
                <?php }else{?>
                <li>  <a href="<?php echo base_url()?>configcontroller/deactivateUser/<?php echo $user->id;?>"><i class="fa fa-times-circle tiny-icon"></i>Deactivate</a></li>
                <?php }
                ?>
                <li> <a href="<?php echo base_url()?>configcontroller/resetpassworduser/<?php echo $user->id;?>"><i class="fa fa-check-circle tiny-icon"></i>Pass Reset</a></li>
                <li><a href="<?php echo base_url()?>configcontroller/deleteUser/<?php echo $user->id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
            </ul>
        </div>
        <?php endif; ?>
    </td>
    <td style="text-align:center"><?php echo $user->pa_limit;?></td>   
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
