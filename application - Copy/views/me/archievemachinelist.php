<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">

</div>
</div></div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive table-bordered">
              <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#00" >
                <thead>
                <tr>
                  <th style="width:5%;">SN</th>
                  <th style="width:20%;">Asset Name</th>
                  <th style="width:8%">Spec. Model</th>
                  <th style="width:8%">Ventura Code</th>
                  <th style="text-align:center;width:8%">TPM CODE (TPM代码)</th>
                  <th style="width:6%;text-align:center">Location</th>
                  <th style="text-align:center;width:6%">Status 状态</th>
                  <th style="text-align:center;width:10%">Assign Date</th>
                  <th style="text-align:center;width:10%">Take Over Date</th>
                
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)): $i=1;
                foreach($list as $row):
                    ?>
                  <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo $row->product_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->product_code; ; ?></td>
                      <td style="text-align:center">
                      <?php echo $row->ventura_code; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->tpm_serial_code; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->line_no; ?></td>
                       <td style="text-align:center">
                    <span class="btn btn-xs btn-success">
                      <?php 
                      echo CheckStatus($row->machine_status);
                      ?>
                    </span>
                    </td> 
                      <td style="text-align:center">
                    <?php echo findDate($row->assign_date);  ?></td>
                    <td style="text-align:center">
                    <?php echo findDate($row->takeover_date);  ?></td>
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

 <style>
.table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
  border: 1px solid #000;
}
.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
  border: 1px solid #000;
}
br{
  padding: 1px solid #000;
}
</style>
