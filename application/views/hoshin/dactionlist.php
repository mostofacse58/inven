<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
        <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
  <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>hoshin/daction/edit">
<i class="fa fa-plus"></i>
Update All 
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>hoshin/daction/lists" method="get" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-sm-2 control-label">Dept. Goal</label>
            <div class="col-sm-2">
              <input type="text" name="departmental_goal" class="form-control" placeholder="Dept. Goal" value="<?php  echo set_value('departmental_goal'); ?>" autofocus>
            </div>
            <label class="col-sm-2 control-label">Ind. Goal</label>
            <div class="col-sm-2">
              <input type="text" name="actions_name" class="form-control" placeholder="Action name" value="<?php  echo set_value('actions_name'); ?>" autofocus>
            </div>
            <label class="col-sm-2 control-label">Person</label>
            <div class="col-sm-2">
              <input type="text" name="person_name" class="form-control" placeholder="Person" value="<?php  echo set_value('person_name'); ?>" autofocus>
            </div>
            <label class="col-sm-2 control-label">Dateline</label>
            <div class="col-sm-2">
              <input type="text" name="end_date" class="form-control month" readonly placeholder="Dateline" value="<?php  echo set_value('end_date'); ?>" autofocus>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          </div>
          <div class="col-sm-1">
            <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>hoshin/daction/lists">All</a>
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
