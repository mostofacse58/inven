<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
        <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/spares/add">
<i class="fa fa-plus"></i>
Add Spares
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
            <div class="box-body">
              <form class="form-horizontal" action="<?php echo base_url();?>me/spares/lists" method="GET" enctype="multipart/form-data">
              <div class="form-group">
                <label class="col-sm-3 control-label">ITEM CODE (项目代码) </label>
                <div class="col-sm-3">
                  <input type="text" name="product_code" class="form-control" placeholder="ITEM CODE (项目代码)" value="<?php  echo set_value('product_code'); ?>" autofocus>
                </div>
                <div class="col-sm-1">
                <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              </div>
              <div class="col-sm-1">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/spares/lists">All</a>
              </div>
              </div>
            </form>
            <div class="table-responsive table-bordered">
              <table id="" class="table table-bordered table-striped" style="width:120%;border:#000" >
                <thead>
              <tr>
                  <td  style="width:4%;">SN</td>
                  <th style="width:15%;">Tools/Materials Name 工具/材料名称</th>
                  <th style="width:15%;">中文名称</th>
                  <th style="width:10%">Category 类别</th>
                  <th style="text-align:center;width:10%">ITEM CODE (项目代码) </th>
                  <th style="text-align:center;width:7%">Rack(Box)机架（盒）</th>
                  <th style="text-align:center;width:10%">Maximum Stock 最大库存数量</th>
                  <th style="text-align:center;width:10%">Safety Stock 安全库存数量</th>
                  <th style="text-align:center;width:6%">C.Stock 当前库存</th> 
                  <th  style="text-align:center;width:5%">Actions 行动</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)): $i=1;
                foreach($list as $row):
                    ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row->product_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->china_name; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->category_name; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center">
                    <?php  echo "$row->rack_name($row->box_name)"; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->minimum_stock;  ?></td>
                    <td style="text-align:center">
                      <?php echo $row->safety_stock_qty;  ?></td>
                    <td style="text-align:center">
                      <?php echo $row->main_stock;  ?></td>
                    <td style="text-align:center">
                        <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                          <li><a href="<?php echo base_url()?>me/spares/views/<?php echo $row->product_id;?>">
                            <i class="fa ffa fa-eye tiny-icon"></i>View</a></li>
                          <li>  <a href="<?php echo base_url()?>me/spares/edit/<?php echo $row->product_id;?>">
                            <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                            <?php if($this->session->userdata('delete')=='YES'){ ?>
                          <li><a href="#" class="delete" data-pid="<?php echo $row->product_id;?>">
                            <i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
   url:"<?php echo base_url();?>me/spares/checkSparesUse/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
        $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>me/spares/delete/"+rowId;
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
