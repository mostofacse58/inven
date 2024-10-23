<script type="text/javascript">
    $(document).ready(function() {
    <?php if(isset($info)){ ?>
      var floor_ids = "<?php echo $info->floor_id; ?>";
      <?php  }else{ ?>
        var floor_ids = "<?php echo set_value('floor_id') ?>";
      <?php }?>
   
      ////////////////////////
       var floor_id=$('#floor_id').val();
            if(floor_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'floorline/getflat',
              data:{floor_id:floor_id},
              success:function(data){
                $("#floor_id").empty();
                $("#floor_id").append(data);
                if(floor_ids != ''){
                  $('#floor_id').val(floor_ids).change();
                }
              }
            });
          }

      ///////////////////////
      $('#floor_id').on('change',function(){
        var floor_id  = $(this).val();
         if(floor_id !=''){
            $.ajax({
              type:"post",
              url:"<?php echo base_url()?>"+'floorline/getflat',
              data:{floor_id:floor_id},
              success:function(data){
                $("#floor_id").empty();
                $("#floor_id").append(data);
                if(floor_ids != ''){
                  $('#floor_id').val(floor_ids).change();
                }
              }
            });
          }
          });

    });
var  baseURL = '<?php echo base_url();?>';
   </script>
<div class="row">
  <div class="col-xs-12">
   <div class="box box-primary">
  <div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">

</div>
</div>
</div>
</div>
<div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>floorline/save<?php if(isset($info)) echo "/$info->line_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Floor <span style="color:red;">  *</span></label>
                  <div class="col-sm-4">
                    <select class="form-control" name="floor_id" id="floor_id">
                    <option value="" selected="selected">===Select Floor===</option>
                    <?php foreach($flist as $rows){  ?>
                    <option value="<?php echo $rows->floor_id; ?>" 
                      <?php if(isset($info->floor_id))echo $rows->floor_id==$info->floor_id? 'selected="selected"':0; else
                       echo $rows->floor_id==set_value('floor_id')? 'selected="selected"':0; ?>><?php echo $rows->floor_no; ?></option>
                    <?php }  ?>
                  </select>                    
                  <span class="error-msg"><?php echo form_error("floor_id");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Line No<span style="color:red;">  *</span></label>
                  <div class="col-sm-2">
                    <input type="text" name="line_no" class="form-control" placeholder="Line No" value="<?php if(isset($info->line_no)) echo $info->line_no; else echo set_value('line_no'); ?>">
                   <span class="error-msg"><?php echo form_error("line_no");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">SAVE 保存</button>
                </div>
                </div>

              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
            <div class="box-body box">
              <div class="col-md-8">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th style="width:20%">Floor No</th>
                      <th style="width:10%">Line No</th>
                      <th  style="text-align:center;width:8%">Actions 行动</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                      foreach($list as $row):
                          ?>
                          <tr>
                              <td><?php echo $row->floor_no;?></td>
                              <td><?php echo $row->line_no;?></td>
                              <td style="text-align:center">
                                <a class="btn btn-success" href="<?php echo base_url()?>floorline/edit/<?php echo $row->line_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;                                        
                                <a href="#" data-pid="<?php echo $row->line_id;?>" class="btn btn-danger delete" ><i class="fa fa-trash-o tiny-icon"></i></a>
                              </td>
                          </tr>
                      <?php
                      endforeach;
                  endif;
                  ?>
                  </tbody>
              </table>
            </div>
          </div>
            <!-- /.box-body -->
          </div>
        </div>
 </div>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>floorline/checkDelete 删除/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
        $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>floorline/delete/"+rowId;
     }
},
error:function(){
  console.log("failed");
}
});
}
});
});//jquery ends here
</script>

