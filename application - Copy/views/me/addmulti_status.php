<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script> <style type="text/css">
  .error-msg{display:none;}
</style>
<script type="text/javascript">
var count = 1
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
var id=0;
$(document).ready(function(){
  ///////////////////////
  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
           
            $.ajax({
                type: 'get',
                url: '<?= base_url('me/machinestatus/suggestions'); ?>',
                dataType: "json",
                data: {
                    term: request.term
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
            var productId=ui.item.product_detail_id;
            var chkname=1;
            if (ui.item.id !== 0) {
              for(var i=0;i<id;i++){
                var prid= parseInt($("#product_detail_id_" + i).val());
                if(prid==productId){
                   chkname=2;
                }
               }
           if(chkname==2){
            $("#alertMessageHTML").html("This Machine already added!!");
            $("#alertMessagemodal").modal("show");
           }else{
              //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_detail_id+'" name="product_detail_id[]"  id="product_detail_id_' + id + '"><input type="hidden" value="'+ui.item.product_status_id+'" name="product_status_id[]"  id="product_status_id_' + id + '"><b></b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Machine Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+

            '<td> <input type="text" name="tpm_serial_code[]" readonly class="form-control" placeholder="TPM CODE (TPM代码)" value="'+ui.item.tpm_serial_code+'"  style="margin-bottom:5px;width:98%" id="tpm_serial_code_' + id + '"/> </td>' +
            '<td> <input type="text" name="ventura_code[]" readonly class="form-control" placeholder="VENTURA CODE" value="'+ui.item.ventura_code+'"  style="margin-bottom:5px;width:98%" id="ventura_code_' + id + '"/> </td>' +
            '<td> <input type="text" name="from_location_name[]" readonly class="form-control" placeholder="from_location_name" value="'+ui.item.from_location_name+'"  style="margin-bottom:5px;width:98%" id="from_location_name' + id + '"> </td>' +

             ' <td><select name="to_location_name[]" class="form-control select2" style="width:90%;margin-left:10px;" id="to_location_name_' + id + '" required> <option value="" selected="selected" data-taxid="0">Select Location</option>'+LineList+' </select><span class="error-msg" style="margin-left:10px;">Please Select Location</span></td> '+

            ' <td><select name="machine_status[]" class="form-control pull-left" style="width:90%;margin-left:10px;" id="machine_status_' + id + '">'+StatusList+' </select></td> '+
            ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
              $("#form-table tbody").append(nodeStr);
              updateRowNo();
              id++;
          //var row = add_invoice_item(ui.item);
          $("#add_item").val('');
          $(".select2").select2();
        }
        } else {
          alert('Not Found');
        }
        }
    });
////////////// end Add Item///////////////////
    });
  var LineList='<?php if($flist)
     {
     foreach ($flist as $row) {?><option value="<?php echo $row->line_no; ?>"><?php echo $row->line_no;?></option><?php }} ?> ';

     /////////////////
    var StatusList='<option value="1">USED</option><option value="2">IDLE</option><option value="3">UNDER SERVICE</option>';
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
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Machine!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  // for(var n=0;n<=id-1;n++){
  //    if(deletedRow.indexOf(n)<0){
  //     var line_id= $.trim($("#line_id_"+n).val());
  //     if(line_id==''||isNaN(line_id)){
  //     $("#line_id_"+n).css({"border-color":"red"});
  //     $("#line_id_"+n).next("span").show(200).delay(5000).hide(200,function(){
  //     $("#line_id_"+n).css({"border-color":"#ccc"});
  //     });
  //     error_status=true;
  //   }
  //   }
  // }
  var assign_date=$("#assign_date").val();
  var line_id=$("#line_id").val();
 if(line_id == '') {
    error_status=true;
    $("#line_id").css('border', '1px solid #f00');
  } else {
    $("#line_id").css('border', '1px solid #ccc');      
  }
  if(assign_date == '') {
    error_status=true;
    $("#assign_date").css('border', '1px solid #f00');
  } else {
    $("#assign_date").css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
}
////////////////////////////////////////////
</script>
<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
    <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>me/machinestatus/save2" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
     <div class="box-body">
      <div class="form-group">
         <label class="col-sm-3 control-label">Assign Date <span style="color:red;">  *</span> </label>
           <div class="col-sm-3">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="assign_date" readonly id="assign_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->assign_date); else echo date('d/m/Y'); ?>">
          </div>
       <span class="error-msg"><?php echo form_error("assign_date");?></span>
      </div>
      
    </div><!-- ///////////////////// -->
    <div class="form-group">
      <label class="col-sm-3 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
        <div class="col-sm-7">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please Scan or Write Code or Name" autocomplete="off" tabindex="1" type="text">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
     </div><!-- ///////////////////// -->
  <div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:5%;text-align:center">SL</th>
  <th style="width:15%;text-align:center">Machine Name</th>
  <th style="width:10%;text-align:center">Ventura Code</th>
  <th style="width:10%;text-align:center">TPM CODE (TPM代码)</th>
  <th style="width:10%;text-align:center">Current Location</th>
  <th style="width:10%;text-align:center;">Transfer Location</th>
  <th style="width:10%;text-align:center;">Status 状态</th>
  <th style="width:5%;text-align:center"><i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>me/machinestatus/lists" class="btn btn-info">
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

