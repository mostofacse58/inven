<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
$(function () {
  $(document).on('click','input[type=number]',function(){ this.select(); });
        $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
    });
//////////////
var deletedRow=[];
<?php  if(isset($info1)){ ?>
     var id=<?php echo  count($info1); ?>
     <?php }else{ ?>
    var id=0;
    <?php } ?>

var departmentselect='';
var departmentselect='<?php if(isset($dlist))
     {
     foreach ($dlist as $rows){  ?><option value="<?php echo $rows->department_id; ?>"><?php echo "$rows->department_name";?></option><?php }} ?> ';
$(document).ready(function(){
  $("#add_req").click(function(){
         var nodeStr = '<tr id="row_' + id + '"><td><input type="text" name="asset_encoding[]"  class="form-control" required  placeholder="Serial No" style="margin-bottom:5px;width:98%" id="asset_encoding_' + id + '"/></td>'+
         '<td><select name="forpurchase_department_id[]" required class="form-control pull-left select2" style="width:100%;"  id="forpurchase_department_id_' + id + '" ><option value="" selected="selected">Please Select</option>'+departmentselect+'</select> </td>' +
          '<td> <input type="text" name="other_description[]" class="form-control" placeholder="Description" style="width:98%;"  id="other_description_' + id + '"/></td>' +
           ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
        $("#form-table tbody").append(nodeStr);
        updateRowNo();
        id++;
        totalSum();
    });//addField

    var it_status=$("#it_status").val(); 
      if(it_status==5){
         $(".dispose").show();
      }else{
        $(".dispose").hide();
      }
    $("#it_status").change(function(){
      var it_status=$("#it_status").val(); 
      if(it_status==5){
         $(".dispose").show();
      }else{
        $(".dispose").hide();
      }
      });
    });

    function deleter(id){
        $("#row_"+id).remove();
        deletedRow.push(id);
        updateRowNo();
    }

    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
    function updateRowNo(){
        var numRows=$("#form-table tbody tr").length;
        for(var r=0;r<numRows;r++){
            $("#form-table tbody tr").eq(r).find("td:first b").text(r+1);
        }
    }



  function formsubmit(){
  var error_status=false;
  var product_id=$("#product_id").val();
  var pi_no=$("#pi_no").val();
  var purchase_date=$("#purchase_date").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
      error_status=true;
  }
  for(var i=0;i<serviceNum;i++){
      if($("#asset_encoding_"+i).val()==''){
        $("#asset_encoding_"+i).css('border', '1px solid #f00');
         error_status=true;
      }
  }
  if(product_id == ''){
    error_status=true;
    $('input[name=product_id]').css('border', '1px solid #f00');
  } else {
    $('input[name=product_id]').css('border', '1px solid #ccc');      
  }
  if(pi_no == ''){
    error_status=true;
    $('input[name=pi_no]').css('border', '1px solid #f00');
  } else {
    $('input[name=pi_no]').css('border', '1px solid #ccc');      
  }
  if(purchase_date == '') {
    error_status=true;
    $('input[name=purchase_date]').css('border', '1px solid #f00');
  } else {
    $('input[name=purchase_date]').css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
}

 
</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>it/pregistraion/save<?php if (isset($info)) echo "/$info->product_detail_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
          <div class="box-body">
              <div class="form-group">
                  <label class="col-sm-3 control-label">Asset Name (Model No) <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                   <select class="form-control select2" name="product_id">
                  <option value="" selected="selected">===Select Asset Name===</option>
                  <?php foreach ($mainlist as $rows) { ?>
                    <option value="<?php echo $rows->product_id; ?>" 
                    <?php if (isset($info))
                        echo $rows->product_id == $info->product_id ? 'selected="selected"' : 0;
                    else
                        echo $rows->product_id == set_value('product_id') ? 'selected="selected"' : 0;
                    ?>><?php echo $rows->product_name; ?></option>
                        <?php } ?>
                    </select>
                  <span class="error-msg"><?php echo form_error("product_id"); ?></span>
                </div>
                <?php if($this->session->userdata('department_id')==1){ ?>
                <label class="col-md-1 control-label">Processor</label>
                  <div class="col-md-2">
                  <select class="form-control select2" name="proccessor_id">
                  <option value="" selected="selected">None</option>
                  <?php $prlist=$this->db->query("SELECT * FROM proccessor_info")->result();
                  foreach ($prlist as $rows) { ?>
                    <option value="<?php echo $rows->proccessor_id; ?>" 
                    <?php if (isset($info))
                        echo $rows->proccessor_id == $info->proccessor_id ? 'selected="selected"' : 0;
                    else
                        echo $rows->proccessor_id == set_value('proccessor_id') ? 'selected="selected"' : 0;
                    ?>><?php echo $rows->proccessor_type; ?></option>
                        <?php } ?>
                    </select>
                  <span class="error-msg"><?php echo form_error("proccessor_id"); ?></span>
                </div>
              <?php } ?>
              </div><!-- ///////////////////// -->
              <div class="form-group">
                  <label class="col-sm-3 control-label">Supplier Name 供应商名称</label>
                  <div class="col-sm-5">
                   <select class="form-control select2" name="supplier_id">
                  <option value="" selected="selected">Select Supplier Name 供应商名称</option>
                  <?php foreach ($slist as $rows) { ?>
                    <option value="<?php echo $rows->supplier_id; ?>" 
                    <?php if (isset($info))
                        echo $rows->supplier_id == $info->supplier_id ? 'selected="selected"' : 0;
                    else
                        echo $rows->supplier_id == set_value('supplier_id') ? 'selected="selected"' : 0;
                    ?>><?php echo $rows->supplier_name; ?></option>
                        <?php } ?>
                    </select>
                  <span class="error-msg"><?php echo form_error("supplier_id"); ?></span>
                </div>
                <?php if($this->session->userdata('department_id')==1){ ?>
                <label class="col-md-1 control-label">RAM</label>
                  <div class="col-md-2">
                  <select class="form-control select2" name="ram_id">
                  <option value="" selected="selected">None</option>
                  <?php $prlist=$this->db->query("SELECT * FROM ram_info")->result();
                  foreach ($prlist as $rows) { ?>
                    <option value="<?php echo $rows->ram_id; ?>" 
                    <?php if (isset($info))
                        echo $rows->ram_id == $info->ram_id ? 'selected="selected"' : 0;
                    else
                        echo $rows->ram_id == set_value('ram_id') ? 'selected="selected"' : 0;
                    ?>><?php echo $rows->ram_type; ?></option>
                        <?php } ?>
                    </select>
                  <span class="error-msg"><?php echo form_error("ram_id"); ?></span>
                </div>
              <?php } ?>

              </div><!-- ///////////////////// -->
              <div class="form-group">
                <label class="col-sm-2 control-label">INVOICE NO <span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                       <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="<?php if(isset($info)) echo $info->invoice_no; else echo set_value('invoice_no'); ?>">
                   <span class="error-msg"><?php echo form_error("invoice_no");?></span>
                  </div>
                 <label class="col-sm-2 control-label">Purchase Date <span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                    <div class="input-group date">
                    <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                       </div>
                       <input type="text" name="purchase_date" readonly id="purchase_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->purchase_date); else echo set_value('purchase_date'); ?>" required>
                     </div>
               <span class="error-msg"><?php echo form_error("purchase_date");?></span>
              </div>
              <label class="col-sm-1 control-label">Price <span style="color:red;">  *</span></label>
                   <div class="col-sm-2">
                       <input type="text" name="machine_price" id="machine_price" class="form-control" value="<?php if(isset($info)) echo $info->machine_price; else echo set_value('machine_price'); ?>" required>
               <span class="error-msg"><?php echo form_error("machine_price");?></span>
              </div>
              <label class="col-sm-1 control-label" style="text-align: left;">IN BDT</label>
          </div><!-- ///////////////////// -->
          <div class="form-group">
            <div class="form-group">
            <label class="col-sm-2 control-label">PI NO <span style="color:red;">  *</span></label>
               <div class="col-sm-2">
                   <input type="text" name="pi_no" id="pi_no" class="form-control" value="<?php if(isset($info)) echo $info->pi_no; else echo set_value('pi_no'); ?>" required>
               <span class="error-msg"><?php echo form_error("pi_no");?></span>
              </div>
          <label class="col-sm-2 control-label">Status </label>
          <div class="col-sm-2">
            <select class="form-control select2" name="it_status" id="it_status" style="width: 100%;">
              <option value="2"
                <?php  if(isset($info)) echo '2'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',2);?>>IDLE/Stock</option>
              <option value="1"
                <?php if(isset($info)) echo '1'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',1);?>>USED</option>
              <option value="3"
                <?php if(isset($info)) echo '3'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',3);?>>Under Service</option>
              <option value="4"
                <?php if(isset($info)) echo '4'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',4);?>>Damage</option>
              <option value="5"
                <?php if(isset($info)) echo '5'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',5);?>>Dispose</option>
              <option value="6"
                <?php if(isset($info)) echo '6'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',6);?>>Sold</option>
              <option value="7"
                <?php if(isset($info)) echo '7'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',7);?>>CSR</option>
              <option value="8"
                <?php if(isset($info)) echo '8'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',8);?>>Lost</option>
              <option value="9"
                <?php if(isset($info)) echo '9'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',9);?>>Dormant</option>
              <option value="10"
                <?php if(isset($info)) echo '10'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',10);?>>Transfer</option>
              <option value="11"
                <?php if(isset($info)) echo '11'==$info->it_status? 'selected="selected"':0; else echo set_select('it_status',11);?>>Paper Free</option>

            </select>
           <span class="error-msg"><?php echo form_error("it_status");?></span>
          </div>
          <label class="col-sm-2 control-label dispose">Dispose Date <span style="color:red;">  *</span></label>
             <div class="col-sm-2 dispose">
              <div class="input-group date">
              <div class="input-group-addon">
                   <i class="fa fa-calendar"></i>
                 </div>
                 <input type="text" name="despose_date" readonly id="despose_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->despose_date); else echo set_value('despose_date'); ?>" required>
          </div>
         <span class="error-msg"><?php echo form_error("despose_date");?></span>
        </div>
           <label class="col-sm-1 control-label dispose">Note </label>
            <div class="col-sm-3 dispose">
              <textarea class="form-control" name="despose_note" rows="1" id="despose_note" placeholder="Note"></textarea> 
            </div>
        </div>
    <br>
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:15%;text-align:center">Serial No</th>
  <th style="width:15%;text-align:center">Department when new purchase</th>
  <th style="width:20%;text-align:center">Description</th>
  <th style="width:10%;text-align:center">
    Actions 行动s <i class="fa fa-trash-o"></i></th>
  </tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($info)):
    $optionTree="";
     if(isset($info)){
      foreach ($dlist as $rowc):
        $selected=($rowc->department_id==$info->forpurchase_department_id)? 'selected="selected"':'';
        $optionTree.='<option value="'.$rowc->department_id.'" '.$selected.'>'.$rowc->department_name.'</option>';
        endforeach;
      }
$str= '<tr  id="row_'.$i. '"><td><input type="text" name="asset_encoding[]" required class="form-control"  placeholder="Serial No"  value="'.$info->asset_encoding.'" style="margin-bottom:5px;width:98%" id="asset_encoding_'.$i. '"/></td>';
$str.='<td> <select name="forpurchase_department_id[]" class="form-control select2"  style="width:100%;" id="forpurchase_department_id_' . $id . '" required><option value="" selected="selected">Please Select</option> '.$optionTree.' </select> </td> ';
$str.= '<td> <input type="text" name="other_description[]" value="'.$info->other_description.'"  class="form-control" placeholder="Description" style="width:98%;"  id="other_description_'.$i.'"/></td>';
$str.= '<td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter('. $i .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
   echo $str;

    ?>
   <?php
endif;
?>
</tbody>
</table>
</div>
</div>
<div class="form-group">
   <div class="col-sm-7 col-sm-offset-3">
   <button id="add_req"  class="btn btn-info">Add Serial No</button>
  </div>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>it/pregistraion/lists" class="btn btn-info">
        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
        Back</a></div>
      <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
      </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>

