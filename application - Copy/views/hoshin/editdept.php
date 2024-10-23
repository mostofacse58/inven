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
            <!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" action="<?php echo base_url();?>hoshin/daction/edit" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-2 control-label">Dept. Goal</label>
            <div class="col-sm-3">
              <input type="text" name="departmental_goal" class="form-control" placeholder="Dept. Goal" value="<?php  echo set_value('departmental_goal'); ?>" autofocus>
          </div>
          <label class="col-sm-1 control-label">Person</label>
          <div class="col-sm-2">
            <input type="text" name="person_name" class="form-control" placeholder="Person name" value="<?php  echo set_value('person_name'); ?>" autofocus>
          </div>
          <label class="col-sm-1 control-label">Category</label>
          <div class="col-sm-2">
            <select class="form-control select2" name="category" id="category">
              <option value="">Select 选择</option>
              <option value="Medium" <?php  if(isset($info)) echo 'Medium'==$info->category? 'selected="selected"':0; else echo set_select('category','Medium');?>>Medium</option>
              <option value="Positive" <?php  if(isset($info)) echo 'Positive'==$info->category? 'selected="selected"':0; else echo set_select('category','Positive');?>>Positive</option>
              <option value="Negative" <?php  if(isset($info)) echo 'Negative'==$info->category? 'selected="selected"':0; else echo set_select('category','Negative');?>>Negative</option>
            </select>
          </div>
        </div>
          <div class="form-group">
          <label class="col-sm-2 control-label">Month</label>
          <div class="col-sm-2">
            <input type="text" name="month" readonly class="form-control month" placeholder="Month " value="<?php  echo set_value('month'); ?>" required>
          </div>
          <div class="col-sm-1">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
        </div>
        </div>
      </form>
      <form class="form-horizontal" action="<?php echo base_url();?>hoshin/daction/save" method="POST" enctype="multipart/form-data">
      <div class="table-responsive table-bordered">
        <table id="" class="table table-bordered table-striped" style="width:120%;border:#000" >
          <thead>
        <tr>
          <th style="width:3%;">SN</th>
          <th style="width:6%;">Team</th>
          <th style="text-align:center;width:6%">Department</th>
          <th style="width:20%;">Departmental Goal</th>
          <th style="width:20%;">Individual Goal </th>
          
          <th style="text-align:center;width:6%">Goal Category</th>
          <th style="text-align:center;width:6%">Dateline</th> 
          <th style="text-align:center;width:6%">Target</th>
          <th style="width:10%;">Person</th>
          <th style="text-align:center;width:6%">Achievement</th> 
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($lists)): $i=1;
          foreach($lists as $row):
              ?>
            <tr>
              <td><?php echo $i++;?></td>
              <td><?php echo $row->team;?></td>
              <td style="text-align:center">
                <?php echo $row->department_name; ?></td>
              <td><?php echo $row->departmental_goal;?></td>
              <td style="text-align:center"> 
              <input type="text" name="actions_name[]"  class="form-control" placeholder="Individual" value="<?php if(isset($row->actions_name)) echo $row->actions_name; else echo set_value('actions_name'); ?>" required></td>
              <td><?php echo $row->category;?></td>
              <td style="text-align:center">
                <?php echo findDate($row->end_date);  ?></td> 
              <td>
              <?php  echo $row->target; if($row->target_type=='%') echo $row->target_type; ?>
              </td>
             <td style="text-align:center"> 
              <input type="text" name="person_name[]"  class="form-control" placeholder="Person " value="<?php if(isset($row->person_name)) echo $row->person_name; else echo set_value('person_name'); ?>" required></td>
              <td style="vertical-align: text-top;text-align:center">
                <input type="hidden" value="<?php echo $row->actions_id; ?>" name="actions_id[]">
               <input type="text" name="achievment[]"  class="form-control checkint" placeholder="achievment" value="<?php if($row->achievment!='') echo $row->achievment; else echo ""; ?>">
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
         <div class="box-footer">
           <div class="col-sm-4"><a href="<?php echo base_url(); ?>hoshin/daction/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
           <div class="col-sm-4">
            <?php if(isset($lists)): ?>
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
        <?php endif; ?>
          </div>
        </div>
      </form>
      </div>
    </div>
 </div>
 <script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
function isValidFloat(input) {
    var regex = /^-?\d*(\.\d+)?$/;
    return regex.test(input);
}
$(function () {
      $('.month').datepicker({
          "format": "yyyy-mm",
          "startView": "months", 
           "minViewMode": "months",
           "autoclose": true
      });
      /////////////////////
      $('body').on('keyup','.checkint',function(e){


        var inputValue = $(this).val();
        var regex = /^(\+|-)?(\d*\.?\d*)$/;
        if (!regex.test(inputValue)) {
          $(this).val('');
        } 
       

      });

    });
// $('input[type="number"]').on('keydown', function(e){
//     // Allow: backspace, delete, tab, escape, enter, and minus
//     if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 109]) !== -1 ||
//          // Allow: Ctrl+A, Command+A
//         (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
//          // Allow: Ctrl+C, Command+C
//         (e.keyCode === 67 && (e.ctrlKey === true || e.metaKey === true)) ||
//          // Allow: Ctrl+V, Command+V
//         (e.keyCode === 86 && (e.ctrlKey === true || e.metaKey === true)) ||
//          // Allow: Ctrl+X, Command+X
//         (e.keyCode === 88 && (e.ctrlKey === true || e.metaKey === true)) ||
//          // Allow: home, end, left, right, down, up
//         (e.keyCode >= 35 && e.keyCode <= 40)) {
//              // let it happen, don't do anything
//              return;
//     }
//     // Ensure that it is a float number or minus sign
//     if ((e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode !== 190 && e.keyCode !== 189 && e.keyCode !== 109) {
//         e.preventDefault();
//     }
// });

</script>


 