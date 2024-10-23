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


$(document).ready(function(){
  $("#add_req").click(function(){
         var nodeStr = '<tr id="row_' + id + '"><td><input type="text" name="pm_date[]" readonly class="form-control date" required  placeholder="Date" style="margin-bottom:5px;width:98%" id="pm_date_' + id + '"/></td>'+
          '<td> <input type="text" name="tpm_code[]" class="form-control" placeholder="Code" required style="width:98%;"  id="tpm_code_' + id + '"/></td>' +
          '<td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
        $("#form-table tbody").append(nodeStr);
        updateRowNo();
        id++;
        $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
    });//addField

 
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
  var model_no=$("#model_no").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
      error_status=true;
  }
  for(var i=0;i<serviceNum;i++){
      if($("#check_name_"+i).val()==''){
        $("#check_name_"+i).css('border', '1px solid #f00');
         error_status=true;
      }
  }
  if(model_no == ''){
    error_status=true;
    $('input[name=model_no]').css('border', '1px solid #f00');
  } else {
    $('input[name=model_no]').css('border', '1px solid #ccc');      
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
          <div class="panel panel-success">
      <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">

</div>
</div>
</div>
</div></div>
        <div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url(); ?>pm/maintenance/save<?php if (isset($info)) echo "/$info->pm_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
          <div class="box-body">
         
          <br>
            <div class="table-responsive">
            <table class="table table-bordered" id="form-table">
            <thead>
            <tr>
              <th style="width:15%;text-align:center">Date</th>
              <th style="width:15%;text-align:center">Asset Code</th>
              <th style="width:10%;text-align:center">
                Actions 行动s <i class="fa fa-trash-o"></i></th>
              </tr>
            </thead>
            <tbody>
             <?php
             $i=0;
             $id=0;
              if(isset($info)):
                  $str= '<tr  id="row_'.$i. '"><td><input type="text" name="pm_date[]" required class="form-control date" readonly placeholder="Date" value="'.findDate($info->pm_date).'" style="margin-bottom:5px;width:98%" id="pm_date_'.$i. '"/></td>';
                    $str.= '<td><input type="text" name="tpm_code[]" value="'.$info->tpm_code.'" required class="form-control" placeholder="Code" style="width:98%;"  id="tpm_code_'.$i.'"/></td>';
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
<?php if(!isset($info)){  ?>
<div class="form-group">
   <div class="col-sm-7 col-sm-offset-3">
   <button id="add_req"  class="btn btn-info">Add</button>
  </div>
</div>
<?php } ?>  
<!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>pm/maintenance/lists" class="btn btn-info">
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

