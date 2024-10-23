  <?php 
$name="MachineryReport_".date('Y-m-dhi').".xls";
 header("Pragma: public");
    header("Expires: 0");
// header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: text/html; charset=utf-8");
header('Content-Disposition: attachement; filename="' .$name. '"');
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");
?>
<style>
  body {
  padding: 3px;
   font-size:14px;
   font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
    }
  .form-group.required .control-label:after { 
     content:"*";
     color:red;
  }
table  {border-collapse:collapse;
  border-spacing:0;width:120%}
table td{
  font-size:12px;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
  overflow:hidden;
  word-break:normal;
}
table th{
 font-size:12px;
  font-weight:bold;
  padding:10px 5px;
  border-style:solid;
  border-width:1px;
  overflow:hidden;
  word-break:normal;}
table td{text-align: left;}

</style>
<script type="text/javascript">

</script>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">

   <div class="box box-info">
<div class="box box-primary">
            <!-- /.box-header -->
    <div class="box-body">
   <?php if(count($info)>0){  ?>
    <div class="alert alert-success alert-dismissable" style="text-align:center">
    <strong style="font-size:25px"> Machine Details Information! </strong><br>
    <div class="table-responsive">
        <table class="table">

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
                </tr>
            </thead>
            <tbody>
              <?php if(isset($details)): $totaldowntime=0;
                foreach ($details as  $value) {
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
                </tr>
                <?php }
                endif; ?>
                <tr>
                    <th style="text-align:right" colspan="9">TOTAL DOWNTIME(IN MINUTES)</th>
                    <th class="textcenter"><?php echo $totaldowntime; ?></th>
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
                     <td class=""><?php echo "$value->product_name ($value->china_name)"; ?></td>
                    <td class="textcenter"><?php echo $value->product_code; ?></td>
                    <td class="textcenter"><?php echo "$value->quantity $value->unit_name"; ?></td>
                </tr>
                <?php }
                endif; ?>
                <tr>
                    <th style="text-align:right" colspan="5">TOTAL QUANTITY</th>
                    <th class="textcenter"><?php echo $totalqty; ?></th>
                  
                </tr>
            </tbody>
        </table>
    </div>
  </div>


  </div>
            <!-- /.box-body -->
</div>
  <?php } ?>
 
          </div>
        </div>
   
   </div>
 </div>
 