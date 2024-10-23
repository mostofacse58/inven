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
.qrcode-text {padding-right:20px; margin-right:0}
.qrcode-text-btn {
  display:inline-block; 
  background:url(//dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg) 50% 50% no-repeat; 
  height:20px; 
  width:28px; 
  margin-left:-30px; 
  cursor:pointer}
.qrcode-text-btn > input[type="file"] {
  position:absolute; 
  overflow:hidden; 
  width:1px; 
  height:1px; 
  opacity:0}
</style>
<script type="text/javascript">
  function openQRCamera(node) {
  var reader = new FileReader();
  reader.onload = function() {
    node.value = "";
    qrcode.callback = function(res) {
      if(res instanceof Error) {
        alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
      } else {
        node.parentNode.previousElementSibling.value = res;
      }
    };
    qrcode.decode(reader.result);
  };
  reader.readAsDataURL(node.files[0]);
}

function showQRIntro() {
  return confirm("Use your camera to take a picture of a QR code.");
}
</script>
<script src="<?php echo base_url('asset/qr_packed.js'); ?>"></script>
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
      <form class="form-horizontal" action="<?php echo base_url();?>it/assetdetail/search" method="POST">
        <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label" style="margin-top: 10px">SCAN CODE<span style="color:red;">  </span></label>
            <div class="col-sm-4">
              <input type=text name="ventura_code" style="width: 80%;height: 30px;margin-top: 10px" placeholder="Please scan Code" class="qrcode-text">
              <label class="qrcode-text-btn" style="margin-bottom: -6px">
                <input type=file accept="image/*" capture=environment onclick="return showQRIntro();" onchange="openQRCamera(this);" tabindex=-1>
              </label> 
              <button style="width: 15%;" type="submit" class="btn btn-info">Go</button>

    </div>
   </div><!-- ///////////////////// -->
</div>
</form>
 </div>
<!-- /.box-body -->

  <?php if(isset($info)){ ?>
<div class="box box-primary">
            <!-- /.box-header -->
    <div class="box-body">
   <?php if(count($info)>0){  ?>
    <div class="alert alert-success alert-dismissable" style="text-align:center">
    <strong style="font-size:25px"> Asset Details Information! </strong><br>
    <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:15%">QCODE:</th>
            <th style="width:35%"><?php if($info->ventura_code!=''){ ?>
                <img src="<?php echo $this->look_up_model->qcode_function($info->ventura_code,'L',6); ?>" alt="Photo">
                <?php } ?></th>
            <th style="width:15%">BARCODE:</th>
            <th style="width:35%">
                  <?php if($info->ventura_code != '' || $info->ventura_code != NULL) 
             { echo '<img src="'.base_url('dashboard/barcode/'.$info->ventura_code).'" alt="" />'; } ?></th>
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
                <th style="width:35%"><?php echo "$info->employee_name($info->employee_id)"; ?></th>
                
            </tr>

           
        </table>
    </div>

<h3 style="text-align: center;font-weight: bold;font-size: 18px"> MOVEMENT HISTORY</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                  <th style="width:4%;">SN</th>
                  <th style="width:10%;text-align:center">Department</th>
                  <th style="width:10%;text-align:center">Employee</th>
                  <th style="width:6%;text-align:center">Location</th>
                  <th style="text-align:center;width:10%;">Issue Date</th>
                  <th style="text-align:center;width:10%;">Return Date</th>
                  <th style="text-align:center;width:6%;">Status 状态</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($details)):$i=1;
              foreach ($details as $row){
              ?>
                <tr>
                <td style="text-align:center">
                  <?php echo $i++; ; ?></td>
                <td style="text-align:center">
                  <?php echo "$row->department_name"; ?></td> 
                  <td style="text-align:center">
                  <?php echo "$row->employee_name"; ?></td> 
                <td style="text-align:center">
                  <?php echo $row->location_name; ?></td> 
                <td style="text-align:center">
                <?php echo findDate($row->issue_date);  ?></td>
                <td style="text-align:center">
                <?php echo findDate($row->return_date);  ?></td>
                <td style="text-align:center">
                  <?php 
                  echo CheckStatus1($row->issue_status);
                ?>
                </td>
                </tr>
                <?php }
                endif; ?>
            </tbody>
        </table>
    </div>
  
    <h3 style="text-align: center;font-weight: bold;font-size: 18px">  Spares Using List</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                  <th class="textcenter" style="width: 10%;">Date</th>
                  <th class="textcenter" style="width: 10%;">Ref. No</th>
                  <th class="textcenter" style="width: 25%;">Item/Material Name</th>
                  <th class="textcenter" style="width: 15%;">Item Code 项目代码</th>
                  <th class="textcenter" style="width: 8%;">Quantity</th>
                  <th class="textcenter" style="width: 8%;">Amount HKD</th>
                </tr>
            </thead>
            <tbody>
              <?php if(isset($spareslist)): $totalqty=0; $totalamount=0;
                foreach ($spareslist as  $value) {
                   $totalqty=$totalqty+$value->quantity;
                   $totalamount=$totalamount+$value->amount_hkd;
                 ?>
                <tr>
                  <td class="textcenter"><?php echo findDate($value->issue_date); ?></td>
                  <td class="textcenter"><?php echo $value->requisition_no;  ?></td>
                   <td class=""><?php echo $value->product_name; ?></td>
                  <td class="textcenter"><?php echo $value->product_code; ?></td>
                  <td class="textcenter"><?php echo "$value->quantity $value->unit_name"; ?></td>
                  <td class="textcenter"><?php echo "$value->amount_hkd"; ?></td>
                </tr>
                <?php }
                endif; ?>
                <tr>
                    <th style="text-align:right" colspan="4">TOTAL QUANTITY</th>
                    <th class="textcenter"><?php echo $totalqty; ?></th>
                    <th class="textcenter"><?php echo $totalamount; ?> HKD</th>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <h3 style="text-align: center;font-weight: bold;font-size: 18px">  
    Servicing Costing List</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                  <th class="textcenter" style="width: 3%;">SN</th>
                  <th class="textcenter" style="width: 5%;">S. Type</th>
                  <th class="textcenter" style="width: 10%;">Servicing Date</th>
                  <th class="textcenter" style="width: 10%;">Reference No</th>
                  <th class="textcenter" style="width: 12%;">Vendor</th>
                  <th class="textcenter" style="width: 12%;">Location</th>
                  <th class="textcenter" style="width: 12%;">Problem</th>
                  <th class="textcenter" style="width: 12%;">Actions</th>
                  <th class="textcenter" style="width: 8%;">Amount(BDT)</th>
                </tr>
            </thead>
            <tbody>
              <?php if(isset($servlist)):  $totalamount=0; $i=1;
                foreach ($servlist as  $value) {
                   $totalamount=$totalamount+$value->servicing_cost;
                 ?>
                <tr>
                  <td class="textcenter"><?php echo $i++;  ?></td>
                  <td class="textcenter"><?php echo $value->servicing_type; ?></td>
                  <td class="textcenter"><?php echo findDate($value->servicing_date); ?></td>
                  <td class="textcenter"><?php echo $value->reference_no;  ?></td>
                   <td class=""><?php echo $value->issuer_to_name; ?></td>
                  <td class="textcenter"><?php echo $value->location_name; ?></td>
                  <td class="textcenter"><?php echo $value->problem_details; ?></td>
                  <td class="textcenter"><?php echo $value->service_details; ?></td>
                  <td class="textcenter"><?php echo "$value->servicing_cost"; ?></td>
                </tr>
                <?php }
                endif; ?>
                <tr>
                    <th style="text-align:right" colspan="8">TOTAL QUANTITY</th>
                    <th class="textcenter"><?php echo $totalamount; ?> BDT</th>
                </tr>
            </tbody>
        </table>
    </div>
    <h3 style="text-align: center;font-weight: bold;font-size: 18px">  
    Gatepass Lists</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                  <th class="textcenter" style="width: 3%;">SN</th>
                  <th class="textcenter" style="width: 10%;">Gatepass Date</th>
                  <th class="textcenter" style="width: 10%;">Gatepass No</th>
                  <th class="textcenter" style="width: 12%;">Vendor</th>
                  <th class="textcenter" style="width: 12%;">Carrying By</th>
                  <th class="textcenter" style="width: 12%;">Problem</th>
                </tr>
            </thead>
            <tbody>
              <?php if(isset($glist)):  
                $totalamount=0; $i=1;
                foreach ($glist as  $value) {
                 ?>
                <tr>
                  <td class="textcenter"><?php echo $i++;  ?></td>
                  <td class="textcenter"><?php echo findDate($value->create_date); ?></td>
                  <td class="textcenter"><?php echo $value->gatepass_no;  ?></td>
                   <td class=""><?php echo $value->issue_to_name; ?></td>
                  <td class="textcenter"><?php echo "$value->carried_by $value->employee_id"; ?></td>
                  <td class="textcenter"><?php echo $value->remarks; ?></td>
                </tr>
                <?php }
                endif; ?>
            </tbody>
        </table>
    </div>
  </div>
  <?php }else{ ?>
  <div class="alert alert-danger alert-dismissable" style="text-align:center">
    <strong style="font-size:25px">This CODE Not Valid!</strong> 
  </div>
  <?php } ?>

  </div>
            <!-- /.box-body -->
</div>
  <?php } ?>
      </div>
      </div>
 </div>
 