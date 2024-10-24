<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
        <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>common/items/add">
<i class="fa fa-plus"></i>
Add New 添新
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
            <div class="box-body">
              <form class="form-horizontal" action="<?php echo base_url();?>common/items/lists" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label class="col-sm-2 control-label">Category Name分类名称<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <select class="form-control select2" required name="category_id" id="category_id">
                      <option value="All">All</option>
                      <?php foreach ($clist as $value) {  ?>
                        <option value="<?php echo $value->category_id; ?>"
                          <?php  if(isset($info)) echo $value->category_id==$info->category_id? 'selected="selected"':0; else echo set_select('category_id',$value->category_id);?>>
                          <?php echo $value->category_name; ?></option>
                        <?php } ?>
                    </select>
                   <span class="error-msg"><?php echo form_error("category_id");?></span>
                  </div>
                <label class="col-sm-3 control-label">Iteam Code物料编码/Name 名称</label>
                <div class="col-sm-2">
                  <input type="text" name="product_code" class="form-control" placeholder="Item Code 项目代码/NAME" value="<?php  echo set_value('product_code'); ?>" autofocus>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Type<span style="color:red;">  *</span></label>
               <div class="col-sm-3">
                <select class="form-control" name="type" id="type" required="">
                  <option value="All">All</option>
                  <option value="PRODUCT"
                    <?php if(isset($info)) echo 'PRODUCT'==$info->type? 'selected="selected"':0; else echo set_select('type','PRODUCT');?>>PRODUCT</option>
                    <option value="SERVICE"
                    <?php if(isset($info)) echo 'SERVICE'==$info->type? 'selected="selected"':0; else echo set_select('type','SERVICE');?>>SERVICE</option>
                </select>
               <span class="error-msg"><?php echo form_error("type");?></span>
             </div>
                <div class="col-sm-1">
                <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              </div>
              <div class="col-sm-1">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>common/items/lists">All</a>
              </div>
              </div>
            </form>
            <div class="table-responsive table-bordered">
              <table id="" class="table table-bordered table-striped" style="width:120%;border:#000" >
                <thead>
              <tr>
                  <th style="width:5%;">Type</th>
                  <th style="width:15%;">English Name英文名称</th>
                  <th style="width:15%;">Chinese name中文名称</th>
                  <th style="width:10%">Category 类别</th>
                  <th style="text-align:center;width:10%">Model型号</th>
                  <th style="text-align:center;width:10%">Iteam Code物料编码</th>
                  <th style="text-align:center;width:7%">Safety Stock Qty安全库存</th>
                  <th style="text-align:center;width:7%">Reorder Qty</th>
                  <th style="text-align:center;width:7%">Stock Qty 库存数量</th>
                  <th style="text-align:center;width:8%">Unit Price</th>
                  <th style="text-align:center;width:6%">Status 状态</th> 
                  <th  style="text-align:center;width:5%">Actions 行动</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)):
                foreach($list as $row):
                    ?>
                  <tr>
                    <td><?php echo $row->type;?></td>
                    <td><?php echo $row->product_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->china_name; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->category_name; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->product_model;  ?></td>
                      <td style="text-align:center">
                      <?php echo $row->product_code;  ?></td> 
                    <td style="vertical-align: text-top;text-align:center">
                    <?php  echo $row->minimum_stock; ?></td>
                    <td style="vertical-align: text-top;text-align:center">
                    <?php  echo $row->re_order_qty; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->main_stock;  ?></td>
                    <td style="text-align:center">
                      <?php echo $row->unit_price;  ?></td>

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
                          <li><a href="<?php echo base_url()?>common/items/views/<?php echo $row->product_id;?>"><i class="fa ffa fa-eye tiny-icon"></i>View</a></li>
                          <?php if($row->product_status==1){  ?>
                          <li><a href="<?php echo base_url()?>common/items/deactivated/<?php echo $row->product_id;?>"><i class="fa ffa fa-trash tiny-icon"></i>Deactive</a></li>
                          <?php } ?>
                          <?php if($row->product_status==2){ ?>
                          <li><a href="<?php echo base_url()?>common/items/activated/<?php echo $row->product_id;?>"><i class="fa ffa fa-ok tiny-icon"></i>Active</a></li>
                          <?php } ?>
                          <li>  <a href="<?php echo base_url()?>common/items/edit/<?php echo $row->product_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
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
   url:"<?php echo base_url();?>common/items/checkItemsUse/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
      $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>common/items/delete/"+rowId;
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
