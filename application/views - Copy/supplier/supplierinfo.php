<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>supplier/add">
<i class="fa fa-plus"></i>
Add Supplier
</a>
</div>
</div></div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive table-bordered">
              <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#00" >
                <thead>
                <tr>
                  <th style="width:15%;">Supplier Name 供应商名称</th>
                  <th style="text-align:center;width:15%">Address</th>
                  <th style="width:10%;text-align:center">Phone No</th>
                  <th style="text-align:center;width:10%">Mobile No. 手机号码。</th>
                  <th style="text-align:center;width:10%">Email Address</th>
                  <th style="text-align:center;width:10%">Payment Term </th>
                  <th style="text-align:center;width:10%">VAT Number</th>
                  <th  style="text-align:center;width:5%">Actions 行动</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if($list&&!empty($list)):
                foreach($list as $row):
                    ?>
                  <tr>
                    <td><?php echo $row->supplier_name;?></td>
                    <td style="text-align:center">
                      <?php echo $row->company_address; ; ?></td>
                    <td style="text-align:center">
                      <?php echo $row->phone_no; ?></td> 
                    <td style="text-align:center">
                    <?php echo $row->mobile_no;  ?></td>
                    <td style="text-align:center">
                    <?php echo $row->email_address;  ?></td>
                    <td style="text-align:center">
                    <?php echo $row->payment_terms;  ?>
                     <?php if($row->payment_term_file!='') {       ?>
                      <a href="<?php echo base_url(); ?>supplier/Download/<?php echo $row->payment_term_file; ?>">Download</a>
                    <?php } ?>
                    </td>
                    <td style="text-align:center">
                    <?php echo $row->vat_number;  ?>
                    <?php if($row->vat_number_file!='') {       ?>
                      <a href="<?php echo base_url(); ?>supplier/Download/<?php echo $row->vat_number_file; ?>">Download</a>
                    <?php } ?>                      
                    </td>
                    <td style="text-align:center">
                        <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                          <li> <a href="<?php echo base_url()?>supplier/edit/<?php echo $row->supplier_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                            <?php if($this->session->userdata('delete')=='YES'){ ?>
                          <li><a href="#"  class="delete" data-pid="<?php echo $row->supplier_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
  job=confirm("Are you sure you want to delete this Supplier?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  $.ajax({
   type:"GET",
   url:"<?php echo base_url();?>supplier/checkSupplier/"+rowId,
     success:function(data){
      if(data=="EXISTS"){
        $("#alertMessageHTML").html("Sorry, this information can't be deleted.!!");
        $("#alertMessagemodal").modal("show");
      }else{
        location.href="<?php echo base_url();?>supplier/delete/"+rowId;
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
