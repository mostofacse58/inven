<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
  $(function () {
  $(document).on('click','input[type=number]',function(){ 
    this.select(); 
    });
    $('.date').datepicker({
      "format": "dd/mm/yyyy",
      "todayHighlight": true,
      "autoclose": true
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
  <form class="form-horizontal" action="<?php echo base_url();?>format/apo/lists" method="GET" enctype="multipart/form-data">
  <div class="box-body">
    <div class="form-group">
    <label class="col-sm-1 control-label">PO. NO </label>
      <div class="col-sm-2">
        <input class="form-control" name="po_number" id="po_number" value="<?php echo set_value('po_number'); ?>" placeholder="NO">
      <span class="error-msg"><?php echo form_error("po_number");?></span>
      </div>
      <label class="col-sm-1 control-label">
       ITEM CODE <span style="color:red;">  </span></label>
        <div class="col-sm-2">
          <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="CODE">
        <span class="error-msg"><?php echo form_error("product_code");?></span>
        </div>
        <label class="col-sm-2 control-label">
          For Department</label>
          <div class="col-sm-2">
            <select class="form-control select2" name="for_department_id" id="for_department_id">
              <option value="All" selected="selected">All</option>
            <?php 
            foreach($dlist as $rows){  ?>
            <option value="<?php echo $rows->department_id; ?>" 
              <?php echo $rows->department_id==set_value('for_department_name')? 'selected="selected"':0; ?>>
               <?php echo $rows->department_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("for_department_name");?></span>
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-1 control-label">Supplier</label>
          <div class="col-sm-2">
            <select class="form-control select2" name="supplier_id" id="supplier_id">
            <option value="All" selected="selected">All</option>
            <?php 
            foreach($slist as $rows){  ?>
            <option value="<?php echo $rows->supplier_id; ?>" 
              <?php echo $rows->supplier_id==set_value('supplier_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->supplier_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("supplier_id");?></span>
        </div>
      <label class="col-sm-1 control-label">Date</label>
        <div class="col-sm-2">
        <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
      </div>
      <div class="col-sm-2">
        <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
      </div>
      <div class="col-sm-3">
        <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
        <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>format/apo/lists">All</a>
    </div>
  </div>
  </div>
  <!-- /.box-body -->
</form>
<div class="table-responsive table-bordered">
<table id="examplse1" class="table table-bordered table-striped" style="width:100%;border:#000" >
    <thead>
    <tr>
      <th style="width:4%;">SN</th>
      <th style="text-align:center;width:8%;">Type</th>
      <th style="width:10%;">For Department</th>
      <th style="text-align:center;width:8%;">Prodcut Type</th>
      <th style="width:8%;">PO/WO NO</th>      
      <th style="width:8%;">PO Date</th>
      <th style="text-align:center;width:8%">
        Delivery Date</th>
      <th style="width:10%;">Supplier Name</th>
      <th style="width:10%;">Status 状态</th>
      <th style="width:10%;">Prep.By</th>
      <th style="text-align:center;width:7%;">
      Actions 行动</th>
  </tr>
  </thead>
  <tbody>
  <?php
  if($lists&&!empty($lists)): $i=1;
    foreach($lists as $row):
    ?>
    <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td class="text-center"><?php echo $row->po_type;?></td>
      <td class="text-center"><?php echo $row->for_department_name; ?></td>
      <td class="text-center"><?php echo $row->product_type;?></td>
      <td class="text-center"><?php echo $row->po_number; ?></td>
      <td class="text-center"><?php echo findDate($row->po_date); ?></td>
      <td class="text-center"><?php echo findDate($row->delivery_date); ?></td>
      <td class="text-center"><?php echo $row->supplier_name; ?></td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->po_status==2||$row->po_status==8)?"danger":"success";?>">
        <?php 
        if($row->po_status==1) echo "Draft";
        elseif($row->po_status==2) echo "Pending";
        elseif($row->po_status==3) echo "Approved";
        elseif($row->po_status==8) echo "Cancel";
        ?>
      </span></td>
      <td class="text-center"><?php echo $row->user_name; ?></td>
      <td style="text-align:center">
      <!-- Single button -->
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">
          <li><a href="<?php echo base_url()?>format/apo/viewforapproved/<?php echo $row->po_id;?>">
            <i class="fa fa-eye tiny-icon"></i>View <?php if($row->po_status==2) echo "& Approved"; ?> </a></li>
          <li> <a href="<?php echo base_url()?>dashboard/viewpopdf/<?php echo $row->po_id;?>" target="_blank">
            <i class="fa fa-eye tiny-icon"></i>PDF</a></li>
          <?php if($this->session->userdata('user_type')==1){ ?>
           <li> <a href="<?php echo base_url()?>format/apo/returns/<?php echo $row->po_id;?>">
                <i class="fa fa-undo  tiny-icon"> </i> Return </a></li>
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

