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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>format/po/add">
<i class="fa fa-plus"></i>
Add New PO
</a>
</div>
</div>
</div>
</div>
<!-- /.box-header -->
<div class="box-body">
  <form class="form-horizontal" action="<?php echo base_url();?>format/po/lists" method="GET" enctype="multipart/form-data">
  <div class="box-body">
    <div class="form-group">
    <label class="col-sm-1 control-label">PO. NO </label>
      <div class="col-sm-2">
        <input class="form-control" name="po_number" id="po_number" value="<?php echo set_value('po_number'); ?>" placeholder="NO">
      <span class="error-msg"><?php echo form_error("po_number");?></span>
      </div>
      <label class="col-sm-1 control-label">
        CODE <span style="color:red;">  </span></label>
        <div class="col-sm-2">
          <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="ITEM CODE">
        <span class="error-msg"><?php echo form_error("product_code");?></span>
        </div>
        <div class="col-sm-2">
          <input class="form-control" name="pi_no" id="pi_no" value="<?php echo set_value('pi_no'); ?>" placeholder="PI NO">
        <span class="error-msg"><?php echo form_error("pi_no");?></span>
        </div>
        <label class="col-sm-2 control-label">
          For Department</label>
          <div class="col-sm-2">
            <select class="form-control select2" name="for_department_id" id="for_department_id">
              <option value="All" selected="selected">All</option>
            <?php 
            foreach($dlist as $rows){  ?>
            <option value="<?php echo $rows->department_id; ?>" 
              <?php echo $rows->department_id==set_value('for_department_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->department_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("for_department_id");?></span>
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
        <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>format/po/lists">All</a>
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
      <th style="text-align:center;width:6%;">Type</th>
      <th style="width:10%;">For Department</th>
      <th style="width:7%;">PO/WO NO</th>      
      <th style="width:8%;">PO Date</th>
      <th style="text-align:center;width:8%">
        Delivery Date</th>
      <th style="width:15%;">Supplier Name</th>
      <th style="width:8%;">Status 状态</th>
      <th style="width:10%;">Prep.By</th>
      <th style="text-align:center;width:7%;">
      Actions 行动</th>
      <th style="width:8%;">Acknowledgement </th>
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
      <td class="text-center"><?php echo $row->po_number; ?></td>
      <td class="text-center"><?php echo findDate($row->po_date); ?></td>
      <td class="text-center"><?php echo findDate($row->delivery_date); ?></td>
      <td class="text-center"><?php echo $row->supplier_name; ?></td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->po_status==2||$row->po_status==5)?"danger":"success";?>">
        <?php 
        if($row->po_status==1) echo "Draft";
        elseif($row->po_status==2) echo "Submit";
        elseif($row->po_status==3) echo "Approved";
        elseif($row->po_status==4) echo "Certified";
        elseif($row->po_status==5) echo "Approved";
        elseif($row->po_status==6) echo "Received";
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
          <li><a href="<?php echo base_url()?>format/po/viewforapproved/<?php echo $row->po_id;?>">
          <i class="fa fa-eye tiny-icon"></i>View  </a></li>
        <li> <a href="<?php echo base_url()?>dashboard/viewpopdf/<?php echo $row->po_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View PDF</a></li>
        <li> <a href="<?php echo base_url()?>dashboard/excelpo/<?php echo $row->po_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>Excel</a></li>
        <?php if($row->po_status==1){ ?>
        <li> <a href="<?php echo base_url()?>format/po/submit/<?php echo $row->po_id;?>">
          <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Submit</a></li>
        <?php } ?>
        <?php if($row->po_status<=2){ ?>
        <li> <a href="<?php echo base_url()?>format/po/edit/<?php echo $row->po_id;?>">
          <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
        <?php } ?>
        <?php if($row->po_status==3){ ?>
        <li> <a href="<?php echo base_url()?>format/po/adddiscount/<?php echo $row->po_id;?>">
          <i class="fa fa-edit tiny-icon"></i>Add Dicount</a></li>
        <?php } ?>
        <?php if($row->po_status==1){ ?>
        <?php if($this->session->userdata('delete')=='YES'){ ?>
        <li><a href="#" class="delete" data-pod="<?php echo $row->po_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
        <?php } ?>
        <?php }else{ ?>
          <li> <a href="<?php echo base_url()?>format/po/aknoledgement/<?php echo $row->po_id;?>">
          <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Receive Aknow</a></li>
        <?php } ?>
        <li><a href="#" data-pid="<?php echo $row->po_id; ?>" class="changeDate">
          <i class="fa fa-check-square-o tiny-icon"></i>Change Delivery Date</a></li>
        <!-- <li><a href="#" data-pid2="<?php echo $row->po_id; ?>" class="giveRating">
          <i class="fa fa-check-square-o tiny-icon"></i>Give Rating</a></li> -->
        </ul>
      </div>
      </td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->acknow_status=='NO')?"danger":"success";?>">
        <?php  echo $row->acknow_status;    ?> </span></td>
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
<!-- ////////////////////////////// -->
<div class="modal fade " id="DateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Form</h4>
      </div>
      <form class="form-horizontal" method="POST" action="<?php echo base_url()?>format/po/changeDate">
      <div class="modal-body">
        
          <div class="form-group">
            <label class="col-sm-4 control-label">2nd Delivery Date </label>
            <div class="col-sm-7">
              <input  class="form-control date" name="delivery_date2"  id="delivery_date2" placeholder="Date">
            </div>
          </div>
          <div class="form-group under_service">
            <label class="col-sm-4 control-label">3rd Delivery Date </label>
            <div class="col-sm-7">
              <input  class="form-control date" name="delivery_date3" id="delivery_date3" placeholder="Date">
            </div>
          </div>
       <input type="hidden" name="po_id"  id="po_id">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade " id="RatingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Form</h4>
      </div>
      <form class="form-horizontal" method="POST" action="<?php echo base_url()?>format/po/giveRating">
      <div class="modal-body">
         
          <div class="form-group">
            <label class="col-sm-4 control-label">Responsive Rate </label>
            <div class="col-sm-7">
              <select class="form-control select2" name="resposive_rate" id="resposive_rate" style="width: 100%;" required="">
              <option value="">Select Rating</option> 
              <option value="5"
                  <?php  echo set_select('resposive_rate',5);?>>5</option>
              <option value="1"
                  <?php  echo set_select('resposive_rate',1);?>>1</option>
                <option value="2"
                  <?php  echo set_select('resposive_rate',2);?>>2</option>
                <option value="3"
                  <?php  echo set_select('resposive_rate',3);?>>3</option>
                <option value="4"
                  <?php  echo set_select('resposive_rate',4);?>>4</option>
                
              </select>
             <span class="error-msg"><?php echo form_error("resposive_rate");?></span>
            </div>
          </div>
       <input type="hidden" name="po_id2"  id="po_id2">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
   ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".changeDate").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
     $("#po_id").val(rowId);
     $("#DateModal").modal("show");
  });
  $(".giveRating").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid2');
     $("#po_id2").val(rowId);
     $("#RatingModal").modal("show");
  });
////////////////////////////////
});

</script>


<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pod');
  location.href="<?php echo base_url();?>format/po/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>