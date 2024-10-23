<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>navigation/add">
<i class="fa fa-plus"></i>
Add New
</a>
</div>
</div></div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                      <tr>
                        <th width="5%">SL</th>
                        <th width="20%">Menu Label</th>
                        <th width="25%">Menu Link</th>
                        <th width="15%">Icon</th>
                        <th width="10%">Parent</th>
                        <th width="10%">Sort</th>
                        <th width="10%">Actions 行动</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $row):?>
                      <tr>
                      <td><?php echo $row->menu_id;?></td>
                        <td style="width:100px;word-wrap: break-word;"><?php echo $row->menu_label;?></td>
                        <td style="width:120px;word-wrap: break-word;"><?php echo $row->link;?></td>
                        <td><i class="<?php echo $row->icon;?>"></i></td>
                        <td><?php echo $row->parent;?></td>
                        <td><?php echo $row->sort;?></td>
                        <td>
                      <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>  <a href="<?php echo site_url('navigation/edit/'.$row->menu_id)?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                                <li><a href="<?php echo site_url('navigation/delete/'.$row->menu_id)?>"  ><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                             
                            </ul>
                        </div>
                        </td>
                      </tr>
                    <?php endforeach ?>
                    </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
 </div>
