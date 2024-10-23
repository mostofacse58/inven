<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>it/bulk/save" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
          <div class="box-body">
            <div class="form-group">
              <br>
              <br>
            <label class="col-sm-2 control-label">
            Select Asset Excel</label>
              <div class="col-sm-4">
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
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>it/pregistraion/lists" class="btn btn-info">
        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
        Back</a></div>
      <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
      </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>

