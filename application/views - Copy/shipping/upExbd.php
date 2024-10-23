<div class="row">
    <div class="col-md-12">
          <div class="panel panel-success">
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
      <form class="form-horizontal" action="<?php echo base_url(); ?>shipping/bdimport/uplaoddata" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
      <div class="box-body">
        <br>
        <div class="form-group">
        <label class="col-sm-2 control-label">Excel File</label>
          <div class="col-sm-3">
              <input type="file" class="form-control"  name="data_file">
              <?php
                $exception_err = $this->session->userdata('exception_err');
                if ($exception_err) {
                  ?>
                  <span class="error-msg"><?php echo $exception_err; ?>
                  </span>
                  <?php
                  $this->session->unset_userdata('exception_err'); }
                ?>
         </div>
         <div class="col-sm-4"><a href="<?php echo base_url(); ?>shipping/bdimport/sample" class="btn btn-info">
        <i class="fa fa-download" aria-hidden="true"></i>Sample Download</a></div>
      </div><!-- ///////////////////// -->
        <br>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>shipping/bdimport/lists" class="btn btn-info">
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

