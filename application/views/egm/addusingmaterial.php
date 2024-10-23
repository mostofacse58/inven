<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
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
<?php  if(isset($info)){ ?>
     var id=<?php echo  count($detail); ?>
     <?php }else{ ?>
    var id=0;
    <?php } ?>
    


$(document).ready(function(){
  var use_type=$("#use_type").val(); 
      if(use_type==1){
         $("#machinediv").show();
         $("#otherdiv").hide();
      }else  {
         $("#otherdiv").show();
         $("#machinediv").hide();           
      }
  $("#use_type").change(function(){
    var use_type=$("#use_type").val(); 
      if(use_type==1){
         $("#machinediv").show();
         $("#otherdiv").hide();
      }else  {
         $("#otherdiv").show();
         $("#machinediv").hide();           
      }
    });
  ///////////////////////
  <?php if(isset($info)){ ?>
      var product_detail_ids = "<?php echo $info->product_detail_id; ?>";
      <?php  }else{ ?>
        var product_detail_ids = "<?php echo set_value('product_detail_id') ?>";
      <?php }?>
    ///////////////////
   
     
      ////////////////////////
       var line_id=$('#line_id').val();
            if(line_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'egm/materialusing/getMachineLine/'+product_detail_ids,
              data:{line_id:line_id},
              success:function(data){
                $("#product_detail_id").empty();
                $("#product_detail_id").append(data);
                if(product_detail_ids != ''){
                  $('#product_detail_id').val(product_detail_ids).change();
                }
              }
            });
          }

      ///////////////////////
      $('#line_id').on('change',function(){
        var line_id=$('#line_id').val();
            if(line_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'egm/materialusing/getMachineLine',
              data:{line_id:line_id},
              success:function(data){
                $("#product_detail_id").empty();
                $("#product_detail_id").append(data);
                if(product_detail_ids != ''){
                  $('#product_detail_id').val(product_detail_ids).change();
                }
              }
            });
          }
          });


  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
           
            $.ajax({
                type: 'get',
                url: '<?= base_url('egm/materialusing/suggestions'); ?>',
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
            var productId=ui.item.product_id;
            var chkname=1;
            if (ui.item.id !== 0) {
              for(var i=0;i<id;i++){
                var prid= parseInt($("#product_id_" + i).val());
                if(prid==productId){
                   chkname=2;
                }
               }
           if(chkname==2){
            $("#alertMessageHTML").html("This Spares already added!!");
            $("#alertMessagemodal").modal("show");
           }else{
           //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+

            '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="TPM CODE (TPM代码)" value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +

            '<td class="description"> <textarea  name="description[]" class="form-control" readonly placeholder="Description"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="description_' + id + '">'+ui.item.description+'</textarea> </td>' +

            ' <td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.stock+'"  id="stock_' + id + '"/> </td>' +

            ' <td> <input type="text" name="quantity[]" onfocus="this.select();"  value="" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' + id + '"/> <label  style="width:38%;float:left">'+ui.item.unit_name+'</label></td>' +
            ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
        $("#form-table tbody").append(nodeStr);
        updateRowNo();
        id++;
          //var row = add_invoice_item(ui.item);
          $("#add_item").val('');
        }
        } else {
          alert('Not Found');
        }
        }
    });
////////////// end Add Item///////////////////
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
  var me_id=$("#me_id").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Spares!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  
  var use_date=$("#use_date").val();
  var use_type=$("#use_type").val();
  if(use_type==1){
    var product_detail_id=$("#product_detail_id").val();
    var line_id=$("#line_id").val();
    if(product_detail_id == '') {
      $("#alertMessageHTML").html("Please Select machine!!");
      $("#alertMessagemodal").modal("show");
      error_status=true;
      $("#product_detail_id").css('border', '1px solid #f00');
    } else {
      $("#product_detail_id").css('border', '1px solid #ccc');      
    }
    if(line_id == ''){
      error_status=true;
      $('input[name=line_id]').css('border', '1px solid #f00');
    } else {
      $('input[name=line_id]').css('border', '1px solid #ccc');      
    }
  /////////////
  }else{
    var use_purpose=$("#use_purpose").val();
    if(use_purpose == '') {
      $("#alertMessageHTML").html("Please write purpose of use!!");
      $("#alertMessagemodal").modal("show");
      error_status=true;
      $("#use_purpose").css('border', '1px solid #f00');
    } else {
      $("#use_purpose").css('border', '1px solid #ccc');      
    }
  }
  

  
  

  for(var i=0;i<serviceNum;i++){
    if($("#tpm_serial_code_"+i).val()==''){
      $("#tpm_serial_code_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
      $("#quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
  }
  
  if(use_date == '') {
    error_status=true;
    $("#use_date").css('border', '1px solid #f00');
  } else {
    $("#use_date").css('border', '1px solid #ccc');      
  }

  if(error_status==true){
    return false;
  }else{
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
}
 ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
       var quantity=$("#quantity_"+id).val();
       var stock=$("#stock_"+id).val();
     if(stock-quantity<0){
         $("#alertMessageHTML").html("Not enough Stock!!");
         $("#alertMessagemodal").modal("show");
         $("#quantity_"+id).val(0);
      }else{
       if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
            $("#quantity_"+id).val(0);

        }
    }
    }

</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>egm/materialusing/save<?php if (isset($info)) echo "/$info->spares_use_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Use Type <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control" name="use_type" id="use_type">
              <option value="1"
                <?php if(isset($info)) echo '1'==$info->use_type? 'selected="selected"':0; else echo set_select('use_type','1');?>>Machine</option>
                  <option value="2"
                <?php if(isset($info)) echo '2'==$info->use_type? 'selected="selected"':0; else echo set_select('use_type','2');?>>Others</option>
            </select>
           <span class="error-msg"><?php echo form_error("use_type");?></span>
         </div>
         <label class="col-sm-2 control-label">Location <span style="color:red;">  *</span></label>
              <div class="col-sm-3">
               <select class="form-control select2" name="line_id" id="line_id">> 
              <option value="" selected="selected">===Select Location===</option>
              <?php foreach ($flist as $rows) { ?>
                <option value="<?php echo $rows->line_id; ?>" 
                <?php if (isset($info))
                    echo $rows->line_id == $info->line_id ? 'selected="selected"' : 0;
                else
                    echo $rows->line_id == set_value('line_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->line_no; ?></option>
                    <?php } ?>
                </select>
              <span class="error-msg"><?php echo form_error("line_id"); ?></span>
            </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
      <div  id="otherdiv">
          <label class="col-sm-2 control-label">Purpose<span style="color:red;">  *</span></label>
           <div class="col-sm-8">
           <input type="text" name="use_purpose" id="use_purpose" class="form-control" placeholder="Use Purpose" value="<?php if(isset($info->use_purpose)) echo $info->use_purpose; else echo set_value('use_purpose'); ?>">
           <span class="error-msg"><?php echo form_error("use_purpose");?></span>
         </div>
     
      </div>
      <div id="machinediv">
        <label class="col-sm-2 control-label">
          TMP CODE (Machine Name)<span style="color:red;">  *</span></label>
          <div class="col-sm-6">
            <select class="form-control select2" name="product_detail_id" id="product_detail_id">
              <option value="" selected="selected">===Select TMP CODE (Machine Name)===</option>
              </select>
              <span class="error-msg"><?php echo form_error("product_detail_id"); ?></span>
            </div>
      </div>
          <label class="col-sm-2 control-label">Requisition No<span style="color:red;">  </span> </label>
         <div class="col-sm-2">
           <input type="text" name="requisition_no" id="requisition_no" class="form-control pull-right" value="<?php if(isset($info)) echo $info->requisition_no; else echo set_value('requisition_no'); ?>">
           <span class="error-msg"><?php echo form_error("requisition_no");?></span>
          </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
         <label class="col-sm-2 control-label">Date </label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="use_date" readonly id="use_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->use_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("use_date");?></span>
          </div>
          <label class="col-sm-1 control-label">ME  <span style="color:red;">  </span></label>
           <div class="col-sm-3">
            <select class="form-control select2" name="me_id" id="me_id">
              <option value="">Select ME</option>
              <?php $melist=$this->db->query("SELECT * FROM me_info")->result();
              foreach ($melist as $value) {  ?>
                <option value="<?php echo $value->me_id; ?>"
                  <?php  if(isset($info)) echo $value->me_id==$info->me_id? 'selected="selected"':0; else echo set_select('me_id',$value->me_id);?>>
                  <?php echo $value->me_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("me_id");?></span>
         </div>
         <label class="col-sm-2 control-label">Other ID </label>
         <div class="col-sm-2">
           <input type="text" name="other_id" id="other_id" class="form-control pull-right" value="<?php if(isset($info)) echo $info->other_id; else echo set_value('other_id'); ?>">
           <span class="error-msg"><?php echo form_error("other_id");?></span>
          </div>
        </div><!-- ///////////////////// -->
    <div class="form-group">
      <label class="col-sm-2 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
        <div class="col-sm-8">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm"  style="overflow: hidden;">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                 
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Spares to order list" autocomplete="off" tabindex="1" type="text">
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
  <th style="width:17%;text-align:center">Spares Name</th>
  <th style="width:12%;text-align:center">Item Code 项目代码</th>
  <th style="width:25%;text-align:center">Description</th>
  <th style="width:6%;text-align:center">Stock Qty</th>
  <th style="width:10%;text-align:center;">Quantity</th>
  <th style="width:5%;text-align:center">
     <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $stock=$this->look_up_model->get_sparesStock($value->product_id);
      $stock=$stock+$value->quantity;
      $description="Material Type: $value->mtype_name";
        if($value->mdiameter!=''){
          $description=$description.", Diameter:$value->mdiameter";
        }
        if($value->mthread_count!=''){
          $description=$description.", Thread Count:$value->mthread_count";
        }
        if($value->mlength!=''){
          $description=$description.", Length:$value->mlength";
        }
      
       $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';

      $str.= '<td> <input type="text" name="product_code[]" readonly class="form-control" placeholder="TPM CODE (TPM代码)" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';

      $str.= '<td class="description"> <textarea  name="description[]" class="form-control" readonly placeholder="Description"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="description_'.$id.'">'.$description.'</textarea> </td>';

      $str.= '<td> <input type="text" name="stock[]" readonly class="form-control" placeholder="Stock" value="'.$stock+$value->quantity.'"   style="margin-bottom:5px;width:98%;text-align:center" id="stock_'.$id.'"/> </td>';

      $str.= '<td> <input type="text" name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"/> <label  style="width:38%;float:left">'.$value->unit_name.'</label></td>';

      $str.= '<td> <button class="btn btn-danger btn-xs" onclick="return deleter('. $i .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
         echo $str;
       ?>
         <?php
       }
      endif;
      ?>
</tbody>
</table>
</div>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>egm/materialusing/lists" class="btn btn-info">
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

