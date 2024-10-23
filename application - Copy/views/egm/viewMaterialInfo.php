<style>
  .form-group.required .control-label:after { 
     content:"*";
     color:red;
  }
  .well-sm {
  border-radius: 3px;
  padding: 7px 25px;
}
table td{text-align: left;}
.textcenter{text-align: center;}
</style>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
      <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>

</div>
</div>

</div>
   <div class="box box-info">
    <!-- /.box-header -->
      <!-- form start -->
      
   <?php if(isset($info)){ ?>
<div class="box box-primary">
            <!-- /.box-header -->
    <div class="box-body">
   <?php if(count($info)>0){  ?>
    <div class="alert alert-success alert-dismissable" style="text-align:center">
    <strong style="font-size:25px"> Spares Details Information! </strong><br>
    <div class="table-responsive">
        <table class="table">
          <tr>
                <th style="width:20%">ITEM QCODE:</th>
                <th style="width:30%"><?php if($info->product_code!=''){ ?>
                  <!--   <img src="<?php //echo $this->look_up_model->qcode_function($info->product_code,'L',6); ?>" alt="Photo"> -->
                    <?php } ?></td>
                <th style="width:20%">ITEM BARCODE:</th>
                <th style="width:30%">
                  <?php if($info->product_code != '' || $info->product_code != NULL) 
             { echo '<img src="'.base_url('dashboard/barcode/'.$info->product_code).'" alt="" >'; } ?></td>
            </tr>
            <tr>
                <th style="width:20%">Tools/Materials Code 工具/材料代码:</th>
                <th style="width:30%"><?php echo $info->product_model; ?></td>
                <th style="width:20%">TPM CODE (TPM代码):</th>
                <th style="width:30%"><?php echo $info->product_code; ?></td>
            </tr>
            <tr>
                <th style="width:20%">English Name:</th>
                <th style="width:30%"><?php echo $info->product_name; ?></td>
                <th style="width:20%">China Name:</th>
                <th style="width:30%"><?php echo $info->china_name; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Category Name 分类名称:</th>
                <th style="width:30%"><?php echo $info->category_name; ?></td>
                <th style="width:20%">Diameter:</th>
                <th style="width:30%"><?php echo $info->mdiameter; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Thread Count:</th>
                <th style="width:30%"><?php echo $info->mthread_count; ?></td>
                <th style="width:20%">Length:</th>
                <th style="width:30%"><?php echo $info->mlength; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Stock Quantity:</th>
                <th style="width:30%"><?php echo $this->look_up_model->get_sparesStock($info->product_id);
                 ?></td>
                <th style="width:20%">Safety Stock:</th>
                <th style="width:30%"><?php echo $info->minimum_stock; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Unit Price:</th>
                <th style="width:30%"><?php echo $info->unit_price; ?></td>
                <th style="width:20%"></th>
                <th style="width:30%"></td>
            </tr>
            <tr>
                <th style="width:20%">Box Name:</th>
                <th style="width:30%"><?php echo $info->box_name; ?></td>
                <th style="width:20%">Description  :</th>
                <th style="width:30%"><?php echo $info->product_description; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Tools/Material Type:</th>
                <th style="width:30%"><?php echo $info->mtype_name; ?></td>
                <th style="width:20%">Tools/Material Picture:</th>
                <th style="width:30%">
                	<?php if (isset($info->product_image) &&!empty($info->product_image)) { ?>
                	<img src="<?php echo base_url(); ?>product/<?php echo $info->product_image; ?>" class="img-thumbnail" style="width:100px;height:auto;"/>
                	<?php }else{ echo "No Picture this Machine";} ?></td>
            </tr>
           
        </table>
    </div>
   

  
  </div>
  <?php } ?>

  </div>
  
            <!-- /.box-body -->
</div>
  <?php } ?>
 
          </div>
        </div><a href="<?php echo base_url(); ?>egm/spares/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
   
   </div>
 </div>
 