<script language="javascript" type="text/javascript">
$(document).ready(function() {
  $('.popup').click(function(event) {
     var urls=$(this).attr("href");
     event.preventDefault();
     window.open(urls, "popupWindow", "width=1050,height=700,scrollbars=yes");
  });
});
</script>
<div class="row">
<div class="col-xs-12">
<div class="box box-primary">
<div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>finishedgoods/finishedgoods/add">
<i class="fa fa-plus"></i>
Add New
</a>
<a class="btn btn-sm btn-primary pull-right popup" style="margin-right:0px;" target="_blank" href="<?php echo base_url(); ?>finishedgoods/finishedgoods/printsticker">
<i class="fa fa-barcode"></i>
Print Sticker
</a>
</div>
</div>
</div>
</div>
        <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>finishedgoods/finishedgoods/lists" finishedgoodsthod="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-sm-3 control-label">File/Style No</label>
            <div class="col-sm-3">
              <input type="text" nafinishedgoods="file_no" class="form-control" placeholder="TPM CODE (TPM代码)/Ventura CODE" value="<?php  echo set_value('file_no'); ?>" autofocus>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          </div>
          <div class="col-sm-1">
            <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>finishedgoods/finishedgoods/lists">All</a>
          </div>
          </div>
        </form>
        <div class="table-responsive table-bordered">
          <table id="" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
          <tr>
            <th style="width:5%">SN</th>
              <th style="width:10%">File No</th>
              <th style="width:15%;">Style No(款号)</th>
              <th style="width:10%">Color(颜色)</th>
              <th style="width:10%;text-align:center">Quantity(数量)</th>
              <th style="text-align:center;width:10%">Workshop(生产车间)</th>
              <th style="text-align:center;width:10%">Line No(组别)</th>
              <th style="text-align:center;width:6%">Create Date</th>
              <th  style="text-align:center;width:5%">Actions 行动</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)): $i=1;
            foreach($list as $row):
                ?>
              <tr>
                 <td style="text-align:center">
                  <?php echo $i++;  ?></td>
                <td style="text-align:center">
                  <?php echo $row->file_no; ; ?></td>
                <td><?php echo $row->style_no;?></td>
                <td style="text-align:center">
                  <?php echo $row->color_name; ; ?></td>
                  <td style="text-align:center">
                  <?php echo $row->quantity; ; ?></td>
                <td style="text-align:center">
                  <?php echo $row->floor_no;  ?></td> 
                <td style="text-align:center">
                <?php echo $row->line_no;  ?></td>
                <td style="vertical-align: text-top">
                <?php  echo $row->create_date; ?></td>
                 </td>
                 <td>
               <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                          <li>  <a href="<?php echo base_url()?>finishedgoods/finishedgoods/edit/<?php echo $row->goods_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                            <?php if($this->session->userdata('delete')=='YES'){ ?>
                          <li><a href="#" class="delete" data-pid="<?php echo $row->goods_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                        <?php } ?>
                        
                        </ul>
                    </div>
                  </td>
              </tr>
              <?php
              endforeach;
          endif;
          ?>
          </tbody>
          </table>
          <div class="box-tools">
              <?php if(isset($pagination))echo $pagination; ?>
          </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
</div>

<div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="docufinishedgoodsnt">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&tifinishedgoodss;</span></button>
    <h4 class="modal-title text-primary" id="myModalLabel"> Despose Note</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="formId" finishedgoodsthod="POST" action="<?php echo base_url()?>finishedgoods/finishedgoods/despose">
      <div class="form-group">
        <label class="col-sm-4 control-label">Despose Note </label>
        <div class="col-sm-7">
          <textarea class="form-control" nafinishedgoods="despose_note" rows="4" id="despose_note" placeholder="Despose Note"></textarea> 
          <span class="error-msg">Despose Note field is required</span>
        </div>
      </div>
   <input type="hidden" nafinishedgoods="goods_id"  id="goods_id">
   </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
    <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> Save</button>
  </div>
</div>
</div>
</div>

<script>
$(docufinishedgoodsnt).ready (function(){
///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
job=confirm("Are you sure you want to delete this Information?");
if(job==true){
e.preventDefault();
var rowId=$(this).data('pid');
$.ajax({
type:"GET",
url:"<?php echo base_url();?>finishedgoods/finishedgoods/checkMachineUse/"+rowId,
 success:function(data){
   if(data=="EXISTS"){
     $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
    $("#alertMessagemodal").modal("show");
   }else{
    location.href="<?php echo base_url();?>finishedgoods/finishedgoods/delete/"+rowId;
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
