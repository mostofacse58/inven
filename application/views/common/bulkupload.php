<div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>common/bulkupload/save" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
      <div class="box-body">
          <div class="form-group">
          <label class="col-sm-1 control-label">Department </label>
            <div class="col-sm-2">
             <select class="form-control select2" name="department_id">
            <?php foreach ($dlist as $rows) { ?>
              <option value="<?php echo $rows->department_id; ?>" 
              <?php if (isset($info))
                  echo $rows->department_id == $info->department_id ? 'selected="selected"' : 0;
              else
                  echo $rows->department_id == set_value('department_id') ? 'selected="selected"' : 0;
              ?>><?php echo $rows->department_name; ?></option>
                  <?php } ?>
              </select>
            <span class="error-msg"><?php echo form_error("department_id"); ?></span>
        </div>
              <label class="col-sm-1 control-label">Supplier </label>
              <div class="col-sm-2">
               <select class="form-control select2" name="supplier_id">
              <option value="" selected="selected">Select Supplier Name 供应商名称</option>
              <?php foreach ($slist as $rows) { ?>
                <option value="<?php echo $rows->supplier_id; ?>" 
                <?php if (isset($info))
                    echo $rows->supplier_id == $info->supplier_id ? 'selected="selected"' : 0;
                else
                    echo $rows->supplier_id == set_value('supplier_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->supplier_name; ?></option>
                    <?php } ?>
                </select>
              <span class="error-msg"><?php echo form_error("supplier_id"); ?></span>
        </div>
        <label class="col-sm-2 control-label">
        Select Excel File</label>
          <div class="col-sm-3">
              <input type="file" class="form-control"  name="data_file">
              <?php
                $exception_err = $this->session->userdata('exception_err');
                if ($exception_err) {
                  ?>
                  <span class="error-msg"><?php echo $exception_err; ?>
                  </span>
                  <?php
                  $this->session->unset_userdata('exception_err');
                }
                ?>
         </div>
      </div><!-- ///////////////////// -->
        <br>

</div>

  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>common/items/lists" class="btn btn-info">
        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
        Back</a></div>
      <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right">
          Upload</button>
      </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>

