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
   <?php if(!is_null($info)>0){  ?>
    <strong style="font-size:25px"> Asset Details Information! </strong><br>
    <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:15%">QCODE:</th>
            <th style="width:35%"><?php if($info->asset_encoding!=''){ ?>
                <img src="<?php echo $this->look_up_model->qcode_function($info->asset_encoding,'L',6); ?>" alt="Photo">
                <?php } ?></th>
            <th style="width:15%">BARCODE:</th>
            <th style="width:35%">
                  <?php if($info->asset_encoding != '' || $info->asset_encoding != NULL) 
             { echo '<img src="'.base_url('dashboard/barcode/'.$info->asset_encoding).'" alt="" />'; } ?></th>
            </tr>
             <tr>
                <th style="width:15%">Serial No:</th>
                <th style="width:35%"><?php echo $info->asset_encoding; ?></th>
                <th style="width:15%">Price:</th>
                <th style="width:35%"><?php echo $info->machine_price; ?></th>
            </tr>
            <tr>
                <th style="width:15%">English Name:</th>
                <th style="width:35%"><?php echo $info->product_name; ?></th>
                <th style="width:15%">China Name:</th>
                <th style="width:35%"><?php echo $info->china_name; ?></th>
            </tr>
            <tr>
                <th style="width:15%">Invoice No:</th>
                <th style="width:35%"><?php echo $info->invoice_no; ?></th>
                <th style="width:15%">Purchase Date:</th>
                <th style="width:35%"><?php echo findDate($info->purchase_date); ?></th>
            </tr>
            <tr>
                <th style="width:15%">Product Category:</th>
                <th style="width:35%"><?php echo $info->category_name; ?></th>
                <th style="width:15%">Model No:</th>
                <th style="width:35%"><?php echo $info->product_code; ?></th>
            </tr>
            <tr>
                <th style="width:15%">Brand Name:</th>
                <th style="width:35%"><?php echo $info->brand_name; ?></th>
                <th style="width:15%">Supplier Name 供应商名称:</th>
                <th style="width:35%"><?php echo $info->supplier_name; ?></th>
            </tr>
            <tr>
                <th style="width:15%">Asset Picture:</th>
                <th style="width:35%">
                	<?php if (isset($info->product_image) &&!empty($info->product_image)) { ?>
                	<img src="<?php echo base_url(); ?>product/<?php echo $info->product_image; ?>" class="img-thumbnail" style="width:100px;height:auto;"/>
                	<?php }else{ echo "No Picture this Machine";} ?></th>
                  <th style="width:15%">User/Location :</th>
                <th style="width:35%"><?php echo "$info->employee_name $info->employee_id $info->other_description"; ?></th>
            </tr>
        </table>
    </div>
<br>
<?php } ?>
</div>
<!-- /.box-body -->
</div>
  <?php } ?>
 
          </div>
        </div>
   
   </div>
 </div>
 