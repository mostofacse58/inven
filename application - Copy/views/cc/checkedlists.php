<style type="text/css">
  .error-msg{display: none;}
</style>
<script type="text/javascript">
var url1="<?php echo base_url(); ?>cc/checked/lists";


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
          <form class="form-horizontal" action="<?php echo base_url();?>cc/checked/lists" method="GET" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-sm-3 control-label">Requisition No</label>
            <div class="col-sm-3">
              <input type="text" name="requisition_no" class="form-control" placeholder="Requisition No" value="<?php  echo set_value('requisition_no'); ?>" autofocus>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Search </button>
          </div>
          <div class="col-sm-1">
            <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>cc/checked/lists">All</a>
          </div>
          </div>
        </form>
        <div class="table-responsive table-bordered">
          <table id="" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
          <tr>
              <th style="width:5%;text-align:center">SN</th>
              <th style="width:10%;text-align:center">Requisition No</th>
              <th style="width:8%;text-align:center">Issuer Name</th>
              <th style="width:10%;text-align:center">Date of Issue</th>
              <th style="width:8%;text-align:center">Shipper Name</th>
              <th style="text-align:center;width:10%">Ship to Name</th>
              <th style="width:10%;text-align:center">Demand ETA</th>
              <th style="width:10%;text-align:center">Shipping Mode</th>
              <th style="width:10%;text-align:center">Charge Back</th>
              <th style="text-align:center;width:6%">Status</th>
              <th style="text-align:center;width:5%">Action</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)): $i=1;
            foreach($list as $row):
                ?>
            <tr>
            <td style="text-align:center">
              <?php echo $i++; ; ?></td>
            <td><?php echo $row->requisition_no;?></td>
            <td style="text-align:center">
              <?php echo $row->issuer;  ?></td>
            <td style="text-align:center">
              <?php echo findDate($row->issue_date); ; ?></td>
            <td style="text-align:center">
              <?php echo $row->shipper_name;  ?></td>
            <td style="text-align:center">
              <?php echo $row->ship_name;  ?></td>
            <td style="text-align:center">
              <?php echo findDate($row->demand_eta); ; ?></td>
            <td style="text-align:center">
              <?php echo $row->shipping_mode;  ?></td>
            <td style="text-align:center">
              <?php echo $row->chargeback_name;  ?></td>
            <td style="text-align:center">
              <span class="btn btn-xs btn-<?php echo ($row->charges_status!='Done')?"danger":"success";?>">
                  <?php 
                  if($row->charges_status!='Done') echo "Pending";
                  else echo "Done";
                  ?>
              </span>
              </td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a href="<?php echo base_url()?>cc/checked/view/<?php echo $row->courier_id;?>"><i class="fa fa-eye tiny-icon"></i>View</a></li>
                      <li><a href="<?php echo base_url()?>dashboard/viewCCpdf/<?php echo $row->courier_id;?>"><i class="fa fa-file-pdf-o tiny-icon"></i>PDF</a></li>
                    <?php if($row->charges_status!='Done'){  ?>
                     <li><a href="<?php echo base_url()?>cc/checked/addinform/<?php echo $row->courier_id;?>">
                      <i class="fa fa-arrow-circle-right tiny-icon"></i>View & Payment</a>
                    </li>
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

