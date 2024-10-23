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
<div class="widget-control pull-right">
  <?php if(isset($info)){ ?>
<?php if(count($info)>0){  ?>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/checkmachinedetail/downloadExcel<?php echo "/$tpm_serial_code";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<?php } ?>
<?php } ?>

</div>
</div>
</div>

</div>
   <div class="box box-info">
    <!-- /.box-header -->
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>me/checkmachinedetail/search" method="POST">
        <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label" style="margin-top: 10px">SCAN CODE<span style="color:red;">  </span></label>
            <div class="col-sm-4">
              <input type=text name="tpm_serial_code" style="width: 80%;height: 30px;margin-top: 10px" placeholder="Please scan Code" class="qrcode-text">
              <label class="qrcode-text-btn" style="margin-bottom: -6px">
                <input type=file accept="image/*" capture=environment onclick="return showQRIntro();" onchange="openQRCamera(this);" tabindex=-1>
              </label> 
              <button style="width: 15%;" type="submit" class="btn btn-info">Go</button>

           <!--  <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                  <input name="tpm_serial_code" value="" class="form-control input-lg qrcode-text" id="tpm_serial_code" autofocus="autofocus" placeholder="Please scan CODE" type="text" tabindex=-1>
                  
           <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              <label class="qrcode-text-btn">
                <i class="fa fa-2x fa-barcode addIcon"></i>
         <input type="file" class="form-control"  accept="image/*" capture=environment onclick="return showQRIntro();" onchange="openQRCamera(this);" tabindex=-1>
           </label>
            </div>
            </div>
        </div>
      </div>
      </div> -->
    </div>
   </div><!-- ///////////////////// -->
</div>
 </div>
<!-- /.box-body -->
</form>
   <?php if(isset($info)){ ?>
<div class="box box-primary">
            <!-- /.box-header -->
    <div class="box-body">
   <?php if(count($info)>0){  ?>
    <div class="alert alert-success alert-dismissable" style="text-align:center">
    <strong style="font-size:25px"> Machine Details Information! </strong><br>
    <div class="table-responsive">
        <table class="table">
          <tr>
                <th style="width:15%">QCODE:</th>
                <th style="width:35%"><?php if($info->tpm_serial_code!=''){ ?>
                    <img src="<?php echo $this->look_up_model->qcode_function($info->tpm_serial_code,'L',10); ?>" alt="Photo">
                    <?php } ?>
                  </th>
                <th style="width:15%">BARCODE:</th>
                <th style="width:35%">
                  <?php if($info->tpm_serial_code != '' || $info->tpm_serial_code != NULL) 
             { echo '<img src="'.base_url('dashboard/barcode/'.$info->tpm_serial_code).'" alt="" />'; } ?></th>
            </tr>
            <tr>
                <th style="width:15%">English Name:</th>
                <th style="width:35%"><?php echo $info->product_name; ?></th>
                <th style="width:15%">China Name:</th>
                <th style="width:35%"><?php echo $info->china_name; ?></th>
            </tr>
            <tr>
                <th style="width:15%">Asset Encoding:</th>
                <th style="width:35%"><?php echo $info->asset_encoding; ?></th>
                <th style="width:15%">TPM CODE (TPM代码):</th>
                <th style="width:35%"><?php echo $info->tpm_serial_code; ?></th>
            </tr>
            <tr>
                <th style="width:15%">Ventura CODE:</th>
                <th style="width:35%"><?php echo $info->ventura_code; ?></th>
                <th style="width:15%">Supplier Name 供应商名称:</th>
                <th style="width:35%"><?php echo $info->supplier_name; ?></th>
            </tr>
            <tr>
                <th style="width:15%">Invoice Number:</th>
                <th style="width:35%"><?php echo $info->invoice_no; ?></th>
                <th style="width:15%">Purchase Date:</th>
                <th style="width:35%"><?php echo findDate($info->purchase_date); ?></td>
            </tr>
            <tr>
                <th style="width:15%">Product Category:</th>
                <th style="width:35%"><?php echo $info->category_name; ?></th>
                <th style="width:15%">Specifications Model:</th>
                <th style="width:35%"><?php echo $info->product_code; ?></th>
            </tr>
            <tr>
                <th style="width:15%">Machine Type 机器的种类:</th>
                <th style="width:35%"><?php echo $info->machine_type_name; ?></th>
                <th style="width:15%">Brand Name:</th>
                <th style="width:35%"><?php echo $info->brand_name; ?></th>
            </tr>
            
            <tr>
                <th style="width:15%">Current Location:</th>
                <th style="width:35%">
                <?php if($info->line_no!=NULL) echo $info->line_no;
                      else echo "Store House"; ?>
                </th>
                <th style="width:15%"></th>
                <th style="width:35%"></td>
            </tr>
        </table>
    </div>
    <br>
<h3 style="text-align: center;font-weight: bold;font-size: 18px"> MOVEMENT HISTORY</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr><th class="textcenter">SN</th>
                    <th class="textcenter">Location</th>
                    <th class="textcenter">Line Name</th>
                    <th class="textcenter">Assign Date</th>
                    <th class="textcenter">TakeOver Date</th>
                    <th class="textcenter">Status</th>
                </tr>
            </thead>
            <tbody>
              <?php if(isset($movelist)): 
                $mm=1;
                foreach ($movelist as  $value) {
                ?>
                <tr>
                    <td class="textcenter"><?php echo   $mm++; ?></td>
                    <td class="textcenter"><?php echo   $value->floor_no; ?></td>
                    <td class="textcenter"><?php echo   $value->line_no; ?></td>
                    <td class="textcenter"><?php echo findDate($value->assign_date); ?></td>
                    <td class="textcenter"><?php echo findDate($value->takeover_date); ?></td>
                    <td class="textcenter"><?php echo CheckStatus($value->machine_status); ?></td>
                </tr>
                <?php }
                endif; ?>
            </tbody>
        </table>
    </div>
    
<br>
<h3 style="text-align: center;font-weight: bold;font-size: 18px"> DOWNTIME HISTORY</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="textcenter">Line Name</th>
                    <th class="textcenter">Date</th>
                    <th class="textcenter">Problem <br>Start Time</th>
                    <th class="textcenter">ME Response Time</th>
                    <th class="textcenter">Problem</th>
                    <th class="textcenter">Problem <br>End Time</th>
                    <th class="textcenter">Actions 行动 Taken</th>
                    <th class="textcenter">Supervisor <br> Name</th>
                    <th class="textcenter">ME Name</th>
                    <th class="textcenter">Downtime <br> (In Minutes)</th>
                    <th class="textcenter">Detail QCODE</th>
                </tr>
            </thead>
            <tbody>
              <?php if(isset($details)): $totaldowntime=0;
                foreach ($details as  $value) {
                   $code='Name:'.$info->product_name.', 名称:'.$info->china_name.', TPM CODE (TPM代码):'.$info->tpm_serial_code.', Location: '.$value->line_no; 
                   $totaldowntime=$totaldowntime+$value->total_minuts;
                 ?>
                <tr>
                    <td class="textcenter"><?php echo   $value->line_no; ?></td>
                    <td class="textcenter"><?php echo findDate($value->down_date); ?></td>
                    <td class="textcenter">
                      <?php echo date("H:i:s A", strtotime($value->problem_start_time));  ?>
                  </td>
                    <td class="textcenter">
                      <?php echo date("H:i:s A", strtotime($value->me_response_time));  ?></td>
                    <td class="textcenter"><?php echo $value->problem_description; ?></td>
                    <td class="textcenter">
                      <?php echo date("H:i:s A", strtotime($value->problem_end_time));  ?>
                      </td>
                    <td class="textcenter"><?php echo $value->action_taken; ?></td>
                    <td class="textcenter"><?php echo $value->supervisor_name; ?></td>
                    <td class="textcenter"><?php echo $value->me_name; ?></td>
                    <td class="textcenter"><?php echo $value->total_minuts; ?></td>
                    <td class="textcenter">
                    <img src="<?php 
                    echo $this->look_up_model->qcode_functionline($code,'L',4); ?>" alt="QCODE"/>
                    </td>
                </tr>
                <?php }
                endif; ?>
                <tr>
                    <th style="text-align:right" colspan="9">TOTAL DOWNTIME(IN MINUTES)</th>
                    <th class="textcenter"><?php echo $totaldowntime; ?></th>
                    <td>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <h3 style="text-align: center;font-weight: bold;font-size: 18px"> Using Spares List</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="textcenter" style="width: 10%;">Line Name</th>
                    <th class="textcenter" style="width: 15%;">Date</th>
                    <th class="textcenter" style="width: 10%;">Ref. No</th>
                    <th class="textcenter" style="width: 10%;">ME Name</th>
                    <th class="textcenter" style="width: 30%;">Spares Name</th>
                    <th class="textcenter" style="width: 15%;">Item Code 项目代码</th>
                    <th class="textcenter" style="width: 10%;">Quantity</th>
                </tr>
            </thead>
            <tbody>
              <?php if(isset($spareslist)): $totalqty=0;
                foreach ($spareslist as  $value) {
                   $totalqty=$totalqty+$value->quantity;
                 ?>
                <tr>
                    <td class="textcenter"><?php echo   $value->line_no; ?></td>
                    <td class="textcenter"><?php echo findDate($value->use_date); ?></td>
                    <td class="textcenter"><?php echo $value->using_ref_no;  ?></td>
                    <td class="textcenter"><?php echo $value->me_name;  ?></td>
                     <td class=""><?php echo "$value->product_name ($value->china_name)"; ?></td>
                    <td class="textcenter"><?php echo $value->product_code; ?></td>
                    <td class="textcenter"><?php echo "$value->quantity $value->unit_name"; ?></td>
                </tr>
                <?php }
                endif; ?>
                <tr>
                    <th style="text-align:right" colspan="6">TOTAL QUANTITY</th>
                    <th class="textcenter"><?php echo $totalqty; ?></th>
                  
                </tr>
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
 </div>
 