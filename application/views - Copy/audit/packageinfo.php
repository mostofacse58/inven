<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
        <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>audit/package/addedit">
<i class="fa fa-plus"></i>
Add New 添新
</a>
</div>
</div>
</div>
</div>
      <!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" action="<?php echo base_url();?>audit/package/lists" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-3 control-label">Search By</label>
          <div class="col-sm-3">
            <input type="text" name="search_name" class="form-control" placeholder="SEARCH NAME" value="<?php  echo set_value('search_name'); ?>" autofocus>
          </div>
          <div class="col-sm-1">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
        </div>
        <div class="col-sm-1">
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>audit/packagelists">All</a>
        </div>
        </div>
      </form>
      <div class="table-responsive table-bordered">
        <table id="example1" class="table table-bordered table-striped" style="width:120%;border:#000" >
          <thead>
        <tr>
            <th style="width:10%;">Head</th>
            <th style="width:10%;">Sub Head</th>
            <th style="width:6%">Weight</th>
            <th style="text-align:center;width:15%">Criteria 5</th>
            <th style="text-align:center;width:15%">Criteria 3</th>
            <th style="text-align:center;width:15%">Criteria 1</th>
            <th style="text-align:center;width:7%">Year</th>
            <th style="text-align:center;width:7%">Department</th>
             <th style="width:10%">Category</th>
            <th  style="text-align:center;width:5%">Actions 行动</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)):
          foreach($list as $row):
              ?>
            <tr>
              <td><?php echo $row->head_name;?></td>
              <td style="text-align:center">
                <?php echo $row->sub_head_name; ?></td>
              <td style="text-align:center">
                <?php echo $row->weight; ?>%</td>
              <td style="text-align:left">
                <?php echo nl2br($row->criteria_1);  ?></td>
              <td style="text-align:left">
                <?php echo nl2br($row->criteria_2);  ?></td> 
              <td style="vertical-align: text-top;">
              <?php  echo nl2br($row->criteria_3); ?></td>
              <td style="vertical-align: text-top;">
              <?php  echo $row->year; ?></td>
              <td style="vertical-align: text-top;">
              <?php  echo $row->department_name; ?></td>
              <td class=""><?php echo $row->acategory;?></td>
             <td style="text-align:center">
                  <!-- Single button -->
              <div class="btn-group">
                  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="<?php echo base_url()?>audit/package/addedit/<?php echo $row->package_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                      <?php if($this->session->userdata('delete')=='YES'){ ?>
                    <li><a href="#" class="delete" data-pid="<?php echo $row->package_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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


<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>audit/packagecheckItemsUse/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
      $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>audit/packagedelete/"+rowId;
     }
},
error:function(){
  console.log("failed");
}
});
}
});
});//jquery ends here
</script>
