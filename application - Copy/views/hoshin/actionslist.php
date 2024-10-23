<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
        <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>hoshin/actions/add">
<i class="fa fa-plus"></i>
Add New 
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>hoshin/actions/addbulk">
<i class="fa fa-plus"></i>
Uplaod 
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>hoshin/actions/update">
<i class="fa fa-plus"></i>
Bulk Update  
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>hoshin/actions/lists" method="get" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-sm-2 control-label">Team</label>
             <div class="col-sm-2">
              <select class="form-control select2" name="team" id="team">
                <option value="">Select 选择</option>
                <option value="VSS" <?php  if(isset($info)) echo 'VSS'==$info->team? 'selected="selected"':0; else echo set_select('team','VSS');?>>VSS</option>
                <option value="MSS" <?php  if(isset($info)) echo 'MSS'==$info->team? 'selected="selected"':0; else echo set_select('team','MSS');?>>MSS</option>
                <option value="CSS" <?php  if(isset($info)) echo 'CSS'==$info->team? 'selected="selected"':0; else echo set_select('team','CSS');?>>CSS</option>
                <option value="ESS" <?php  if(isset($info)) echo 'ESS'==$info->team? 'selected="selected"':0; else echo set_select('team','ESS');?>>ESS</option>
                <option value="BSS" <?php  if(isset($info)) echo 'BSS'==$info->team? 'selected="selected"':0; else echo set_select('team','BSS');?>>BSS</option>
              </select>
             <span class="error-msg"><?php echo form_error("team");?></span>
           </div>
           <label class="col-sm-2 control-label">Department</label>
            <div class="col-sm-2">
            <select class="form-control select2" name="department_id" id="department_id">
              <option value="">Select 选择</option>
              <?php 
              foreach ($dlist as $value) {  ?>
                <option value="<?php echo $value->department_id; ?>"
                  <?php  if(isset($info)) echo $value->department_id==$info->department_id? 'selected="selected"':0; else echo set_select('department_id',$value->department_id);?>>
                  <?php echo $value->department_name; ?></option>
                <?php } ?>
            </select>
             <span class="error-msg"><?php echo form_error("department_id");?></span>
           </div>
            <label class="col-sm-2 control-label">Dept. Goal</label>
            <div class="col-sm-2">
              <input type="text" name="departmental_goal" class="form-control" placeholder="Dept. Goal" value="<?php  echo set_value('departmental_goal'); ?>" autofocus>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-1 control-label">Ind. Goal</label>
            <div class="col-sm-2">
              <input type="text" name="actions_name" class="form-control" placeholder="Action name" value="<?php  echo set_value('actions_name'); ?>" autofocus>
            </div>
            <label class="col-sm-2 control-label">Person</label>
            <div class="col-sm-2">
              <input type="text" name="person_name" class="form-control" placeholder="Person" value="<?php  echo set_value('person_name'); ?>" autofocus>
            </div>
            <label class="col-sm-1 control-label">Dateline</label>
            <div class="col-sm-2">
              <input type="text" name="end_date" class="form-control month" readonly placeholder="Dateline" value="<?php  echo set_value('end_date'); ?>" autofocus>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          </div>
          <div class="col-sm-1">
            <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>hoshin/actions/lists">All</a>
          </div>
          </div>
        </form>
        <div class="table-responsive table-bordered">
          <table id="" class="table table-bordered table-striped" style="width:120%;border:#000" >
            <thead>
          <tr>
            <th style="width:3%;">SN</th>
            <th style="width:6%;">Team</th>
            <th style="text-align:center;width:6%">Department</th>
            <th style="width:20%;">Departmental Goal</th>
            <th style="width:20%;">Individual Goal </th>
            <th style="width:10%;">Person</th>
            <th style="text-align:center;width:6%">Goal Category</th>
            <th style="text-align:center;width:6%">Dateline</th> 
            <th style="text-align:center;width:6%">Target</th> 
            <th style="text-align:center;width:6%">Achievement</th> 
            <th style="text-align:center;width:6%">Result</th>  
            <th  style="text-align:center;width:5%">Actions 行动</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)): $i=1;
            foreach($list as $row):
                ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->team;?></td>
                <td style="text-align:center">
                  <?php echo $row->department_name; ?></td>
                <td><?php echo $row->departmental_goal;?></td>
                <td><?php echo $row->actions_name;?></td>
                <td style="text-align:center"><?php echo $row->person_name; ?></td>
                <td><?php echo $row->category;?></td>
                <td style="text-align:center">
                  <?php echo findDate($row->end_date);  ?></td> 
                <td style="vertical-align: text-top;text-align:center">
                <?php  echo $row->target; if($row->target_type=='%') echo $row->target_type; ?></td>
                <td style="vertical-align: text-top;text-align:center">
                <?php  echo $row->achievment; ?></td>
                <td style="vertical-align: text-top;text-align:center">
                <?php 
                if($row->achievment==''){
                  echo "";
                }else{
                  if($row->category=='Positive'){
                    if($row->target<=$row->achievment) echo "Pass"; else echo "Fail";
                  }elseif($row->category=='Negative'){
                    if($row->target>=$row->achievment) echo "Pass"; else echo "Fail";
                  }elseif($row->category=='Medium'){
                    if($row->achievment<=$row->target&&$row->achievment>=(-1*$row->target)) echo "Pass"; else echo "Fail";
                  } 
                }
                ?></td>
                
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li>  <a href="<?php echo base_url()?>hoshin/actions/edit/<?php echo $row->actions_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                        <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="<?php echo base_url()?>hoshin/actions/delete/<?php echo $row->actions_id;?>" ><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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

 <script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
      $('.month').datepicker({
          "format": "yyyy-mm",
          "startView": "months", 
           "minViewMode": "months",
           "autoclose": true
      });
    });
</script>
