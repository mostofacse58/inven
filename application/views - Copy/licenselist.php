<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
<div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>license/add">
<i class="fa fa-plus"></i>
Add License
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
      <div class="box-body">
      <div class="table-responsive table-bordered">
        <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#00" >
          <thead>
        <tr>
            <th style="width:5%;">SN</th>
            <th style="width:15%;">Title Name</th>
            <th style="width:35%;">Description </th>
            <th style="text-align:center;width:8%">Purchase Date</th>
            <th style="text-align:center;width:8%">Expire Date</th>
            <th style="text-align:center;width:8%">Download</th>
            <th style="text-align:center;width:8%">Create Date</th> 
            <th  style="text-align:center;width:5%">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)):$i=1;
          foreach($list as $row):
              ?>
            <tr>
              <td style="text-align:center">
                <?php echo $i++; ; ?></td>
              <td><?php echo $row->title_name;?></td>
              <td>
                <?php echo $row->description; ?></td>
              <td><?php echo $row->purchase_date;?></td>
              <td><?php echo $row->expire_date;?></td>
              <td><?php if (isset($row->file_name) && !empty($row->file_name)) { ?>
              <a class="btn btn-sm btn-primary" href="<?php echo base_url();?>license/fliedownload/<?php echo $row->file_name;?>" style="width:auto;text-decoration: none;"> 
              Download</a>
              <?php }else{ echo "None";} ?></td>
              <td style="text-align:center">
                <?php echo $row->create_date; ?></td>
              <td style="text-align:center">
                  <!-- Single button -->
              <div class="btn-group">
              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
              <li>  <a href="<?php echo base_url()?>license/edit/<?php echo $row->document_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
                      <?php if($this->session->userdata('delete')=='YES'){ ?>
              <li><a href="<?php echo base_url()?>license/delete/<?php echo $row->document_id;?>" class="delete"  onClick="return doconfirm();">
              <i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
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
