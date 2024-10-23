  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>

<script>
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
            <!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" action="<?php echo base_url();?>hoshin/actions/update" method="POST" enctype="multipart/form-data">
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
              <option value="Medium" <?php  if(isset($category)) echo 'Medium'==$category? 'selected="selected"':0; else echo set_select('category','Medium');?>>Medium</option>
              <option value="Positive" <?php  if(isset($category)) echo 'Positive'==$category? 'selected="selected"':0; else echo set_select('category','Positive');?>>Positive</option>
              <option value="Negative" <?php  if(isset($category)) echo 'Negative'==$category? 'selected="selected"':0; else echo set_select('category','Negative');?>>Negative</option>
            </select>
          </div>
        </div>
          <div class="form-group">
          <label class="col-sm-2 control-label">Department</label>
            <div class="col-sm-3">
            <select class="form-control select2" name="department_id" id="department_id" required>
              <option value="">Select 选择</option>
              <?php 
              foreach ($dlist as $value) {  ?>
                <option value="<?php echo $value->department_id; ?>"
                  <?php  if(isset($department_id)) echo $value->department_id==$department_id? 'selected="selected"':0; else echo set_select('department_id',$value->department_id);?>>
                  <?php echo $value->department_name; ?></option>
                <?php } ?>
            </select>
             <span class="error-msg"><?php echo form_error("department_id");?></span>
           </div>
          <label class="col-sm-1 control-label">Month</label>
          <div class="col-sm-2">
            <input type="text" name="month" readonly class="form-control month" placeholder="Month " value="<?php  echo set_value('month'); ?>" required>
          </div>
          <div class="col-sm-1">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
        </div>
        </div>
      </form>
      <form class="form-horizontal" action="<?php echo base_url();?>hoshin/actions/saveupdate" method="POST" enctype="multipart/form-data">
      <div class="table-responsive table-bordered">
        <table id="" class="table table-bordered table-striped" style="width:120%;border:#000" >
          <thead>
        <tr>
          <th style="width:3%;">SN</th>
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
              <td style="text-align:center"> 
              <input type="text" name="departmental_goal[]"  class="form-control" placeholder="Individual" value="<?php if(isset($row->departmental_goal)) echo $row->departmental_goal; else echo set_value('departmental_goal'); ?>" required></td>
              <td style="text-align:center"> 
              <input type="text" name="actions_name[]"  class="form-control" placeholder="Individual" value="<?php if(isset($row->actions_name)) echo $row->actions_name; else echo set_value('actions_name'); ?>" required></td>
              
                <td>
                <select class="form-control select2" name="category[]" id="category" required style="width: 100%">
                <option value="">Select 选择</option>
                <option value="Medium" <?php  if(isset($row)) echo 'Medium'==$row->category? 'selected="selected"':0; else echo set_select('category','Medium');?>>Medium</option>
                <option value="Positive" <?php  if(isset($row)) echo 'Positive'==$row->category? 'selected="selected"':0; else echo set_select('category','Positive');?>>Positive</option>
                <option value="Negative" <?php  if(isset($row)) echo 'Negative'==$row->category? 'selected="selected"':0; else echo set_select('category','Negative');?>>Negative</option>
              </select>
                </td> 
              <td style="text-align:center">
                <input type="text" name="end_date[]" readonly id="end_date" class="form-control date" value="<?php if(isset($row)) echo findDate($row->end_date); else echo date('d/m/Y'); ?>">
              </td> 
              <td>
               <input type="text" name="target[]"  class="form-control" placeholder="Target" value="<?php if(isset($row->target)) echo $row->target; else echo set_value('target'); ?>" required>
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
           <div class="col-sm-4"><a href="<?php echo base_url(); ?>hoshin/actions/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
           <div class="col-sm-4">
          <?php if(isset($lists)){ ?>
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
        <?php } ?>
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


</script>


 