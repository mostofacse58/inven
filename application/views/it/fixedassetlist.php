<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
        <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/fixedasset/add">
<i class="fa fa-plus"></i>
Add New </a>
</div>
</div>
</div>
</div>
      <!-- /.box-header -->
      <div class="box-body">
      <div class="table-responsive table-bordered">
        <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#000" >
          <thead>
        <tr>
            <th style="text-align:center;width:5%">SN</th>
            <th style="width:15%;">Asset Name</th>
            <th style="width:15%;">Chinese Name</th>
            <th style="width:10%">Category</th>
            <th style="width:10%;text-align:center">Brand Name</th>
            <th style="text-align:center;width:10%">Model No</th>
            <th style="text-align:center;width:7%">Min. Stock</th>
            <th style="text-align:center;width:6%">Status 状态</th> 
            <th  style="text-align:center;width:5%">Actions 行动</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)): $i=1;
          foreach($list as $row):
              ?>
            <tr>
              <td style="vertical-align: text-top">
              <?php echo $i++;  ?></td>
              <td><?php echo $row->product_name;?></td>
              <td style="text-align:center">
                <?php echo $row->china_name; ; ?></td>
              <td style="text-align:center">
                <?php echo $row->category_name; ; ?></td>
              <td style="text-align:center">
                <?php echo $row->brand_name;  ?></td>  
              <td style="text-align:center">
                <?php echo $row->product_model;  ?></td> 
              <td style="vertical-align: text-top">
              <?php  echo $row->minimum_stock; ?></td>
              <td style="text-align:center">
              <span class="btn btn-xs btn-<?php echo ($row->product_status==2)?"danger":"success";?>">
                <?php 
                if($row->product_status==1) echo "ACTIVE";
                elseif($row->product_status==2) echo "DEACTIVE";
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
                    <li><a href="<?php echo base_url()?>it/fixedasset/views/<?php echo $row->product_id;?>"><i class="fa ffa fa-eye tiny-icon"></i>View</a></li>
                    <li>  <a href="<?php echo base_url()?>it/fixedasset/edit/<?php echo $row->product_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                      <?php if($this->session->userdata('delete')=='YES'){ ?>
                    <li><a href="#" class="delete" data-pid="<?php echo $row->product_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
   url:"<?php echo base_url();?>it/fixedasset/checkMachineUse/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
        $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>it/fixedasset/delete/"+rowId;
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
