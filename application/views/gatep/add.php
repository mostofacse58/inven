<style>
   table.table-bordered tbody tr td{
        border-bottom: 1px solid #e2e2e2;
    }
    table.table-bordered tbody tr td:last-child{
        border: 1px solid #e2e2e2;

    }
    table.table-bordered tbody tr td h3{margin:0px;}
    .employee-holder{
        position: absolute;
        top:30px;
        display: none;
        background-color: #ffffff;
        width:270px;
        border:1px solid #efefef;
        z-index: 1000;
        box-shadow: 0 0 4px 0px #ccc;
    }
    .employee-holder ul{
        list-style: none;
        margin: 0px;
        padding: 0px;
    }
    .employee-holder ul li{
        margin: 0px;
        list-style: none;
        width:100%;
        padding:5px 10px;
        color:#666;
        background-color: #fff;
        border-bottom: 1px solid #e2e2e2;
    }
    .employee-holder ul li:hover,.employee-holder ul li.active{
        background-color: #0C5889;
        color:#fff;
    }
    .error-msg{display:none;}
    .form-control{
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
    }
</style>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
  $(document).on('click','input[type=number]',
    function(){
   this.select(); 
 });
    $('.date').datepicker({
        "format": "dd/mm/yyyy",
        "todayHighlight": true,
        "startDate": '-0d',
        "autoclose": true
    });
    });
///////////////////////////////////////////

//called when key is pressed in textbox
  $("#employee_id").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $('input[name=employee_id]').css('border', '1px solid #f00');
      return false;
    }else{
      $('input[name=employee_id]').css('border', '1px solid #ccc');
    }
  });
//////////////
var deletedRow=[];
<?php  
if(isset($info)){ ?>
     var id=<?php echo  count($detail); ?>;
     <?php }else{ ?>
    var id=0;
  <?php } ?>

$(document).ready(function(){
 
////////////////////////////////////
$("#AddManualItem").click(function(){
    var gatepass_type=$("#gatepass_type").val(); 
    if(gatepass_type==3){
      var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><b>' + (id+1) + '</b></td><td><input type="text" name="product_code[]"  class="form-control"   placeholder="Material Code" style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/></td>'+
      '<td><input type="text" name="product_name[]"  class="form-control"   placeholder="Material/Product Name" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/></td>'+
      '<td><input type="text" name="po_no[]"  class="form-control"   placeholder="PO NO" style="margin-bottom:5px;width:98%" id="po_no_' + id + '" required></td>'+
      '<td><input type="text" name="carton_no[]"  class="form-control" placeholder="Carton No" style="margin-bottom:5px;width:98%" id="carton_no_' + id + '" required></td>'+
      '<td><input type="text" name="product_quantity[]" onfocus="this.select();" value="1"  class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="product_quantity_' + id + '"/></td>' +
      '<td><input type="text" name="unit_name[]" onfocus="this.select();" value=""  class="form-control"  placeholder="Unit" style="width:98%;float:left;text-align:center"  id="unit_name_' + id + '"/></td> '+
      '<td><input type="text" name="bag_qty[]"  class="form-control" placeholder="Bag Qty" style="margin-bottom:5px;width:98%" id="bag_qty_' + id + '" ></td>'+
      '<td><input type="text" name="invoice_no[]"  class="form-control" placeholder="Invoice No" style="margin-bottom:5px;width:98%" id="invoice_no_' + id + '" required></td>'+
      '<td><input type="text" name="remarks[]" class="form-control" placeholder="Purpose" style="width:98%;"  id="remarks_' + id + '"/></td>' +
      '<td style="text-align:center"><button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
    }else{
      var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><b>' + (id+1) + '</b></td><td><input type="text" name="product_code[]"  class="form-control"   placeholder="Material Code" style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/></td>'+
      '<td><input type="text" name="product_name[]"  class="form-control"   placeholder="Material/Product Name" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/></td>'+
      ' <td><input type="text" name="product_quantity[]" onfocus="this.select();" value="1"  class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="product_quantity_' + id + '"/></td>' +
      ' <td><input type="text" name="unit_name[]" onfocus="this.select();" value=""  class="form-control"  placeholder="Unit" style="width:98%;float:left;text-align:center"  id="unit_name_' + id + '"/></td> '+
      '<td> <input type="text" name="remarks[]" class="form-control" placeholder="Purpose" style="width:98%;"  id="remarks_' + id + '"/></td>'+
      '<input type="hidden" name="po_no[]"><input type="hidden" name="carton_no[]"><input type="hidden" name="bag_qty[]"><input type="hidden" name="invoice_no[]">' +
      '<td style="text-align:center"><button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
    }
     
    $("#form-table tbody").append(nodeStr);
    updateRowNo();
    id++;
    
  });//addField

  ///////////////////////
  ///////  Search 搜索 Material Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
        $.ajax({
            type: 'get',
            url: '<?= base_url('gatep/gatepass/suggestions'); ?>',
            dataType: "json",
            data: {
                term: request.term,
                data_from: $('#data_from').val()
            },
            success: function (data) {
                $(this).removeClass('ui-autocomplete-loading');
                response(data);
            }
        });
        },
        minLength: 1,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {
            if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                bootbox.alert('Not Found', function () {
                  $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
            else if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
            else if (ui.content.length == 1 && ui.content[0].id == 0) {
                bootbox.alert('Not Found', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
        },
        select: function (event, ui) {
            event.preventDefault();
            var unit_price=ui.item.unit_price;
            var productId=ui.item.product_id;
            var PPCODE=ui.item.product_code;
            var sub_total=(parseFloat(unit_price)*1).toFixed(2);
            var chkname=1;
            if (ui.item.id !== 0) {
              for(var i=0;i<id;i++){
                var PCODE= $("#product_code_"+i).val();
                if(PCODE==PPCODE){
                   chkname=2;
                }
               }
            if(chkname==2){
              $("#alertMessageHTML").html("This Material already added!!");
              $("#alertMessagemodal").modal("show");
            }else{
           //////////////////////////////
           var gatepass_type=$("#gatepass_type").val(); 
           if(gatepass_type==3){
            var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td>'+ 
           '<td><input type="text" name="product_code[]" class="form-control" placeholder="Material Code 项目代码" value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +
           '<td> <input type="text" name="product_name[]"  class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+
            '<td><input type="text" name="po_no[]"  class="form-control"   placeholder="PO NO" style="margin-bottom:5px;width:98%" id="po_no_' + id + '" required></td>'+
            '<td><input type="text" name="carton_no[]"  class="form-control" placeholder="Carton No" style="margin-bottom:5px;width:98%" id="carton_no_' + id + '" required></td>'+
            ' <td> <input type="text" name="product_quantity[]" onfocus="this.select();"  value="1"  class="form-control"  placeholder="Quantity" style="width:100%;float:left;text-align:center"  id="product_quantity_' + id + '"/></td>'+ 
            '<td><input type="text" name="bag_qty[]"  class="form-control" placeholder="Bag Qty" style="margin-bottom:5px;width:100%" id="bag_qty_' + id + '" required></td>'+
            '<td><input type="text" name="invoice_no[]"  class="form-control" placeholder="Invoice No" style="margin-bottom:5px;width:98%" id="invoice_no_' + id + '" required></td>'+
            '<td><input  style="width:100%;float:left" readonly class="form-control" name="unit_name[]" value="'+ui.item.unit_name+'" ></td>' +
            '<td> <input type="text" name="remarks[]" class="form-control" placeholder="Purpose" style="width:98%;"  id="remarks_' + id + '"/></td>' + 

            ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
          }else{
            var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td>'+ 
           '<td> <input type="text"  name="product_code[]" class="form-control" placeholder="Material Code 项目代码" value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +
           '<td> <input type="text" name="product_name[]"  class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+
            ' <td> <input type="text" name="product_quantity[]" onfocus="this.select();"  value="1"  class="form-control"  placeholder="Quantity" style="width:100%;float:left;text-align:center"  id="product_quantity_' + id + '"/></td>'+ 

            '<td><input  style="width:100%;float:left" readonly class="form-control" name="unit_name[]" value="'+ui.item.unit_name+'" ></td>' +
            '<td> <input type="text" name="remarks[]" class="form-control" placeholder="Purpose" style="width:98%;"  id="remarks_' + id + '"/></td>' + 
            '<input type="hidden" name="po_no[]"><input type="hidden" name="carton_no[]"><input type="hidden" name="invoice_no[]">' +      
            ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
          }
        $("#form-table tbody").append(nodeStr);
        updateRowNo();
        id++;
        $("#add_item").val('');
        }
        } else {
          alert('Not Found');
        }
        }
    });
////////////// end Add Material///////////////////
    });

//////////////////////////////
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
  var wh_whare=$("#wh_whare").val();
  var issue_to=$("#issue_to").val();
  var return_date=$("#return_date").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Material!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var create_date=$("#create_date").val();
  var gatepass_type=$("#gatepass_type").val();
  var employee_id=$("#employee_id").val();
  if(employee_id == ''){
    error_status=true;
    $('input[name=employee_id]').css('border', '1px solid #f00');
  } else {
    $('input[name=employee_id]').css('border', '1px solid #ccc');      
  }
  if(employee_id.length!=5&&employee_id != ''){
    error_status=true;
    $("#alertMessageHTML").html("Please Enter ID NO exactly 5 digit!!");
    $("#alertMessagemodal").modal("show");
  }
 if(wh_whare=='OTHER'){
  if(issue_to==''){
    error_status=true;
    $('select[name=issue_to]').css('border', '1px solid #f00');
    $("#alertMessageHTML").html("Please select issue to!!");
    $("#alertMessagemodal").modal("show");
  }
 }
  for(var i=0;i<serviceNum;i++){
    if($("#product_code_"+i).val()==''){
      $("#product_code_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#product_name_"+i).val()==''){
      $("#product_name_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#product_quantity_"+i).val()==''||$("#product_quantity_"+i).val()==0){
      $("#product_quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#product_code_"+i).val()==''){
      $("#product_code_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
  }
  if(create_date == '') {
    error_status=true;
    $("#create_date").css('border', '1px solid #f00');
  } else {
    $("#create_date").css('border', '1px solid #ccc');      
  }
  if(gatepass_type==1){
    if(return_date == '') {
      error_status=true;
      $("#return_date").css('border', '1px solid #f00');
    } else {
      $("#return_date").css('border', '1px solid #ccc');      
    }
  }
  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
    return true;
  }
}
</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>gatep/gatepass/save<?php if (isset($info)) echo "/$info->gatepass_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Gatepass Type  <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control select2" required name="gatepass_type" id="gatepass_type">
                <option value="1"
                  <?php  if(isset($info)) echo 1==$info->gatepass_type? 'selected="selected"':0; else echo set_select('gatepass_type',1);?>>
                    Returnable Material</option>
                <option value="2"
                  <?php  if(isset($info)) echo 2==$info->gatepass_type? 'selected="selected"':0; else echo set_select('gatepass_type',2);?>>
                    Non-Returnable Material</option>
                <option value="3"
                  <?php  if(isset($info)) echo 3==$info->gatepass_type? 'selected="selected"':0; else echo set_select('gatepass_type',3);?>>
                    Finished Goods</option>
                <option value="4"
                  <?php  if(isset($info)) echo 4==$info->gatepass_type? 'selected="selected"':0; else echo set_select('gatepass_type',4);?>>
                    Stock Transfer</option>
              </select>
           <span class="error-msg"><?php echo form_error("gatepass_type");?></span>
         </div>
         <label class="col-sm-2 control-label">Data From  <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control select2" name="data_from" id="data_from">
              <option value="3"
                  <?php  if(isset($info)) echo 3==$info->data_from? 'selected="selected"':0; else echo set_select('data_from',3);?>>
                    Manual</option>
                <option value="1"
                  <?php  if(isset($info)) echo 1==$info->data_from? 'selected="selected"':0; else echo set_select('data_from',1);?>>
                    VLMBD</option>
                <option value="2"
                  <?php  if(isset($info)) echo 2==$info->data_from? 'selected="selected"':0; else echo set_select('data_from',2);?>>
                    ERP</option>
                
              </select>
           <span class="error-msg"><?php echo form_error("data_from");?></span>
         </div>
       </div>
       <div class="form-group">
        <label class="col-sm-2 control-label">From  <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control select2" required name="issue_from" id="issue_from">
                <option value="Ventura"
                  <?php  if(isset($info)) echo 'Ventura'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','Ventura');?>>
                    Ventura</option>
                <option value="SFB-01"
                  <?php  if(isset($info)) echo 'SFB-01'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','SFB-01');?>>
                    SFB-01</option>
                <option value="MSSFB-3"
                  <?php  if(isset($info)) echo 'MSSFB-3'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','MSSFB-3');?>>
                    MSSFB-3</option>
                <option value="CDF"
                  <?php  if(isset($info)) echo 'CDF'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','CDF');?>>
                    CDF</option>
                <option value="CGN"
                  <?php  if(isset($info)) echo 'CGN'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','CGN');?>>
                    CGN</option>
                <option value="VD"
                  <?php  if(isset($info)) echo 'VD'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','VD');?>>
                    VD</option>
                <option value="F4"
                  <?php  if(isset($info)) echo 'F4'==$info->issue_from? 'selected="selected"':0; else echo set_select('issue_from','F4');?>>
                    F4</option>
              </select>
           <span class="error-msg"><?php echo form_error("issue_from");?></span>
         </div>
         
          <label class="col-sm-2 control-label">Issue To  <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
              <select class="form-control select2" name="wh_whare" id="wh_whare" style="width: 100%">
                <option value="OTHER"
                  <?php  if(isset($info)) echo 'OTHER'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','OTHER');?>>
                    OTHER</option>
                <option value="MSSFB-3"
                  <?php  if(isset($info)) echo 'MSSFB-3'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','MSSFB-3');?>>
                    MSSFB-3</option>
                <option value="SFB-01"
                  <?php  if(isset($info)) echo 'SFB-01'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','SFB-01');?>>
                    SFB-01</option>
                <option value="CDF"
                  <?php  if(isset($info)) echo 'CDF'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','CDF');?>>
                    CDF</option>
                <option value="VD"
                  <?php  if(isset($info)) echo 'VD'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','VD');?>>
                    VD</option>
                <option value="CGN"
                  <?php  if(isset($info)) echo 'CGN'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','CGN');?>>
                    CGN</option>
                <option value="Ventura"
                  <?php  if(isset($info)) echo 'Ventura'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','Ventura');?>>
                    Ventura</option>
                <option value="F4"
                  <?php  if(isset($info)) echo 'F4'==$info->wh_whare? 'selected="selected"':0; else echo set_select('wh_whare','F4');?>>
                    F4</option>
                </select>
             <span class="error-msg"><?php echo form_error("wh_whare");?></span>
            </div>
            <div class="col-sm-3 issuetoDiv">
            <select class="form-control select2" name="issue_to" id="issue_to">
              <option value="">Select Any One</option>
              <?php foreach ($ilist as $value) {  ?>
              <option value="<?php echo $value->issue_to; ?>"
              <?php  if(isset($info)) echo $value->issue_to==$info->issue_to? 'selected="selected"':0; else echo set_select('issue_to',$value->issue_to);?>>
              <?php echo $value->issue_to_name; ?></option>
              <?php } ?>
            </select>
            <span class="error-msg"><?php echo form_error("issue_to"); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Carried Name <span style="color:red;">  *</span></label>
             <div class="col-sm-3">
               <input type="text" name="carried_by" id="carried_by" class="form-control" value="<?php if(isset($info)) echo $info->carried_by; else echo set_value('carried_by'); ?>">
               <span class="error-msg"><?php echo form_error("carried_by");?></span>
             </div>
            <label class="col-sm-2 control-label">Carried ID <span style="color:red;">  *</span></label>
             <div class="col-sm-3">
               <input type="text" name="employee_id" maxlength="5" id="employee_id" class="form-control pull-right" value="<?php if(isset($info)) echo $info->employee_id; else echo set_value('employee_id'); ?>">
               <span class="error-msg"><?php echo form_error("employee_id");?></span>
               <span id="errmsg"></span>
             </div>
         </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Date <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="create_date" readonly id="create_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->create_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("create_date");?></span>
          </div>
          <label class="col-sm-2 control-label returnableDiv">Approx. Return Date <span style="color:red;">  *</span></label>
           <div class="col-sm-3 returnableDiv">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="return_date" readonly id="return_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->return_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("return_date");?></span>
          </div>
          <label class="col-sm-2 control-label Finished">Vehicle No </label>
           <div class="col-sm-3 Finished">
               <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" value="<?php if(isset($info)) echo $info->vehicle_no; else  echo set_value('vehicle_no'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("vehicle_no");?></span>
          </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Attachment</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="attachment" class="form-control" >
            <?php if(isset($info) &&!empty($info->attachment)) { ?>
              <div style="margin-top:10px;">
              <a href="<?php echo base_url(); ?>dashboard/gatepassExcel/<?php echo $info->attachment; ?>">Download</a>
              </div>
            <?php } ?>
            <span>Allow only: pdf,xls,jpg</span>
          </div>
          <label class="col-sm-2 control-label Finished">Container No/Lock No </label>
           <div class="col-sm-3 Finished">
               <input type="text" name="container_no" id="container_no" class="form-control" value="<?php if(isset($info)) echo $info->container_no; else  echo set_value('container_no'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("container_no");?></span>
          </div>
        </div><!-- ///////////////////// -->

    <div class="form-group SearchDiv">
    <label class="col-sm-2 control-label" style="margin-top: 14px">
      SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
        <div class="col-sm-8">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm"  style="overflow: hidden;">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Material to order list" autocomplete="off" tabindex="1" type="text">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
    </div><!-- ///////////////////// -->
    <div class="form-group manualAddDiv">
      <div class="col-sm-12" style="">
       <a id="AddManualItem" class="btn btn-info">
        <i class="fa fa-plus-square"></i> Add Item</a>
      </div>
     </div><!-- ///////////////////// -->
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:3%;text-align:center">SN</th>
  <th style="width:10%;text-align:center">Material Code 项目代码</th>
  <th style="width:20%;text-align:center">Material Name 项目名</th>
  <th style="width:10%;text-align:center;" class="Finished">PO NO</th>
  <th style="width:10%;text-align:center;" class="Finished">Carton No</th>
  <th style="width:5%;text-align:center;">Qty</th>
  <th style="width:5%;text-align:center;">Unit </th>
  <th style="width:10%;text-align:center;" class="Finished">Bag Qty</th>
  <th style="width:10%;text-align:center;" class="Finished">Invoice No</th>
  <th style="width:15%;text-align:center;">Purpose/Remarks</th>
  <th style="width:5%;text-align:center">
     <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $str='<tr id="row_' . $id . '"><td style="text-align:center"><b>' . ($id +1).'</b></td>';
      $str.= '<td><input type="text" name="product_code[]" class="form-control" placeholder="Material Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
      $str.='<td><input type="text" name="product_name[]" class="form-control" placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
      if($info->gatepass_type==3){ 
      $str.= '<td><input type="text" name="po_no[]" value="'.$value->po_no.'"  class="form-control"  placeholder="PO No" style="width:100%;float:left;text-align:center"  id="po_no_' .$id. '">'; 
       
      $str.= '<td><input type="text" name="carton_no[]" value="'.$value->carton_no.'"  class="form-control"  placeholder="Carton No" style="width:100%;float:left;text-align:center"  id="carton_no_' .$id. '">'; 
      }

      $str.= '<td><input type="text" name="product_quantity[]" value="'.$value->product_quantity.'"  class="form-control"  placeholder="Quantity" style="width:100%;float:left;text-align:center"  id="product_quantity_' .$id. '"></td>'; 

      $str.= '<td><input style="width:100%;float:left" class="form-control" name="unit_name[]" value="'.$value->unit_name.'" ></td>';
      if($info->gatepass_type==3){ 
      $str.= '<td><input type="text" name="bag_qty[]" value="'.$value->bag_qty.'"  class="form-control"  placeholder="Bag Qty" style="width:100%;float:left;text-align:center"  id="bag_qty_' .$id. '">'; 
      $str.= '<td><input type="text" name="invoice_no[]" value="'.$value->invoice_no.'"  class="form-control"  placeholder="Invoice No" style="width:100%;float:left;text-align:center"  id="invoice_no_' .$id. '">';

      }
      $str.= '<td> <input type="text" name="remarks[]" value="'.$value->remarks.'"  class="form-control" placeholder="Purpose" style="width:98%;"  id="remarks_' .$id. '"/></td>';
      $str.= '<td style"text-align:center"> <button class="btn btn-danger btn-xs" style"text-align:center" onclick="return deleter('. $i .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
      echo $str;
       ?>
      <?php 
      $id++;
      $i++;
       }
      endif;
      ?>
</tbody>
</table>
</div>


  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>gatep/gatepass/lists" class="btn btn-info">
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

<div class="modal fade" id="partyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-4 control-label">Name <span style="color:red;">  *</span></label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="issue_to_name" placeholder="Name" value="<?php echo set_value('issue_to_name'); ?>">
              <span class="error-msg text-danger"><?php echo form_error("issue_to_name");?></span>
            </div>
          </div>
 
          <div class="form-group">
            <label class="col-sm-4 control-label">Mobile Number </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="mobile_no" placeholder="Mobile Number" value="<?php echo set_value('mobile_no'); ?>" >
              <span class="error-msg text-danger"><?php echo form_error("mobile_no");?></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Address </label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="address" placeholder="Address" value="" >
              <span class="error-msg text-danger"><?php echo form_error("address");?></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addNewGuest">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('asset/customer.js');?>"></script>
<script>
  $(document).ready(function(){
 var gatepass_type=$("#gatepass_type").val(); 
    if(gatepass_type==1){
       $(".returnableDiv").show();
       $(".issuetoDiv").show();
       $(".LocationDiv").hide();
       $(".Finished").hide();
    }else if(gatepass_type==3)  {
      $(".returnableDiv").hide();
      $(".issuetoDiv").show();
      $(".LocationDiv").hide();
      $(".Finished").show();
      $('#data_from').val("3").change();         
    }else if(gatepass_type==4)  {
       $(".returnableDiv").hide();
       $(".issuetoDiv").hide();
       $(".LocationDiv").show();  
       $(".Finished").hide();       
    }else{
      $(".returnableDiv").hide();
      $(".issuetoDiv").show();
      $(".LocationDiv").hide();
      $(".Finished").hide(); 
    }

  $("#gatepass_type").change(function(){
    var gatepass_type=$("#gatepass_type").val(); 
    if(gatepass_type==1){
       $(".returnableDiv").show();
       $(".issuetoDiv").show();
       $(".LocationDiv").hide();
       $(".Finished").hide();
    }else if(gatepass_type==3)  {
      $(".returnableDiv").hide();
      $(".issuetoDiv").show();
      $(".LocationDiv").hide();
      $(".Finished").show();
      $('#data_from').val("3").change();        
    }else if(gatepass_type==4)  {
       $(".returnableDiv").hide();
       $(".issuetoDiv").hide();
       $(".LocationDiv").show();  
       $(".Finished").hide();       
    }else{
      $(".returnableDiv").hide();
      $(".issuetoDiv").show();
      $(".LocationDiv").hide();
      $(".Finished").hide(); 
    }
    });
   var data_from=$("#data_from").val(); 
    if(data_from==3){
       $(".manualAddDiv").show();
       $(".SearchDiv").hide();
    }else{
      $(".manualAddDiv").hide(); 
      $(".SearchDiv").show();
    }
  $("#data_from").change(function(){
    var data_from=$("#data_from").val(); 
    if(data_from==3){
       $(".manualAddDiv").show();
       $(".SearchDiv").hide();
    }else{
      $(".manualAddDiv").hide(); 
      $(".SearchDiv").show();
    }
  });
  var wh_whare=$("#wh_whare").val(); 
    if(wh_whare=='OTHER'||wh_whare=='F4'){
       $(".issuetoDiv").show();
    }else{
      $(".issuetoDiv").hide(); 
    }
    ////////////////
    
  $("#wh_whare").change(function(){
    var wh_whare=$("#wh_whare").val(); 
    if(wh_whare=='OTHER'||wh_whare=='F4'){
       $(".issuetoDiv").show();
    }else{
      $(".issuetoDiv").hide(); 
    }
  });

  });

</script>