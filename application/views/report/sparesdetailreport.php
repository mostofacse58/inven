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
      <form class="form-horizontal" action="<?php echo base_url();?>me/sparesdetailreport/reportrResult" method="POST">
        <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label" style="margin-top: 20px">SCAN Item Code 项目代码 扫描项目代码<span style="color:red;">  </span></label>
            <div class="col-sm-6">
              <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
                <div class="well well-sm">
                  <div class="form-group" style="margin-bottom:0;">
                  <div class="input-group wide-tip">
                    <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                      <i class="fa fa-2x fa-barcode addIcon"></i>
                    </div>
                    <input name="product_code" value="" class="form-control input-lg" id="product_code" autofocus="autofocus" placeholder="PLEASE SCAN Item Code 项目代码" tabindex="1" type="text">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
        </div>
      </div>
      </div>
      <div class="col-sm-2" style="margin-top: 15px">
        <button type="submit" class="btn btn-info">
        <i class="fa fa-search" aria-hidden="true"></i>
        Search 搜索</button>
      </div>
     </div><!-- ///////////////////// -->
  </div>
  <!-- /.box-body -->
  </form>
<?php if(isset($info)){ ?>
<div class="box box-primary">
    <div class="box-body">
   <?php if(count($info)>0){  ?>
    <div class="alert alert-success alert-dismissable" style="text-align:center">
    <strong style="font-size:25px"> Spare Details Information! </strong><br>
    <div class="table-responsive">
        <table class="table">
          
            <tr>
                <th style="width:20%">Tools/Materials Code 工具/材料代码:</th>
                <td style="width:30%"><?php echo $info->product_model; ?></td>
                <th style="width:20%">TPM CODE (TPM代码):</th>
                <td style="width:30%"><?php echo $info->product_code; ?></td>
            </tr>
            <tr>
                <th style="width:20%">English Name:</th>
                <td style="width:30%"><?php echo $info->product_name; ?></td>
                <th style="width:20%">China Name:</th>
                <td style="width:30%"><?php echo $info->china_name; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Category:</th>
                <td style="width:30%"><?php echo $info->category_name; ?></td>
                <th style="width:20%">Diameter:</th>
                <td style="width:30%"><?php echo $info->mdiameter; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Thread Count:</th>
                <td style="width:30%"><?php echo $info->mthread_count; ?></td>
                <th style="width:20%">Length:</th>
                <td style="width:30%"><?php echo $info->mlength; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Current Stock:</th>
                <td style="width:30%"><?php echo $info->main_stock; echo " $info->unit_name"; ?></td>
                <th style="width:20%">Safety Stock:</th>
                <td style="width:30%"><?php echo $info->minimum_stock; echo " $info->unit_name";?></td>
            </tr>
            <tr>
                <th style="width:20%">Unit Price:</th>
                <td style="width:30%"><?php echo $info->unit_price; ?></td>
                <th style="width:20%"></th>
                <td style="width:30%"></td>
            </tr>
            <tr>
                <th style="width:20%">Box Name:</th>
                <td style="width:30%"><?php echo $info->box_name; ?></td>
                <th style="width:20%">Description  :</th>
                <td style="width:30%"><?php echo $info->product_description; ?></td>
            </tr>
            <tr>
                <th style="width:20%">Tools/Material Type:</th>
                <td style="width:30%"><?php echo $info->mtype_name; ?></td>
                <th style="width:20%">Tools/Material Picture:</th>
                <td style="width:30%">
                  <?php if (isset($info->product_image) &&!empty($info->product_image)) { ?>
                  <img src="<?php echo base_url(); ?>product/<?php echo $info->product_image; ?>" class="img-thumbnail" style="width:100px;height:auto;"/>
                  <?php }else{ echo "No Picture this Spare";} ?></td>
            </tr>
           
        </table>
    </div>
<br>
</div>
<h3 style="text-align: center;font-weight: bold;font-size: 18px"> Using Details List</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="textcenter" style="width: 10%;">Date</th>
                    <th class="textcenter" style="width: 10%;">Ref. No</th>
                    <th class="textcenter" style="width: 10%;">Location</th>
                    <th class="textcenter" style="width: 20%;">Machine Name</th>
                    <th class="textcenter" style="width: 20%;">Description/Purpose</th>
                    <th class="textcenter" style="width: 10%;">ME Name</th>
                    <th class="textcenter" style="width: 10%;">Quantity</th>
                </tr>
            </thead>
            <tbody>
              <?php if(isset($resultdetail)): $totalqty=0;
                foreach ($resultdetail as  $value) {
                   $totalqty=$totalqty+$value->quantity;
                 ?>
                <tr>
                    <td class="textcenter"><?php echo findDate($value->use_date); ?></td>
                    <td class="textcenter"><?php echo $value->using_ref_no;  ?></td>
                    <td class="textcenter"><?php echo $value->line_no; ?></td>
                    <td class=""><?php if($value->machine_name!='') echo "$value->machine_name ($value->ventura_code)($value->tpm_serial_code)"; ?></td>
                    <td class=""><?php echo $value->use_purpose; ?></td>
                    <td class="textcenter"><?php echo $value->me_name; ?></td>
                    <td class="textcenter"><?php echo "$value->quantity $value->unit_name"; ?></td>
                </tr>
                <?php }
                endif; ?>
                <tr>
                    <th style="text-align:right" colspan="6">TOTAL QUANTITY</th>
                    <th class="textcenter"><?php echo $totalqty; echo " $info->unit_name";?></th>
                  
                </tr>
            </tbody>
        </table>
    </div>
  
  <?php }else{ ?>
  <div class="alert alert-danger alert-dismissable" style="text-align:center">
    <strong style="font-size:25px">This Item Code 项目代码 Not Valid!</strong> 
  </div>
  <?php } ?>

  </div>
            <!-- /.box-body -->
</div>
  <?php } ?>
 
          </div>
        </div>
   
   </div>
 </div>
 