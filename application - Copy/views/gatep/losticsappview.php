  <script src="<?php echo base_url(); ?>asset/js/print.js"></script>

   <script type="text/javascript">
      // When the document is ready, initialize the link so
      // that when it is clicked, the printable area of the
      // page will print.
      $(function(){
        // Hook up the print link.
        $(".prints").attr( "href", "javascript:void(0)");

        $(".prints").click(function(){
            // Print the DIV.
            $(".primary_area" ).print();
            // Cancel click event.
            return( false );
          });
      });

  var url1="<?php echo base_url(); ?>gatep/losticsapp/lists";
  $(document).ready(function() {
    ////////////////////////////////
    $("#addNewTeam").click(function(){
    var reject_note = $("#reject_note").val();
    var error = 0;
   
    if(reject_note==""){
      $("#reject_note").css({"border-color":"red"});
      $("#reject_note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#reject_note").css({"border-color":"#ccc"});
      });
      error=1;
    }
   
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }

  });
    ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".reject").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
     $("#gatepass_id").val(rowId);
     $("#TeamModal").modal("show");
  });
});
    </script>
  <style>
        
    @media print{
    .print{ display:none;}
    .losticsapp_panel{ display:none;}
     .margin_top{ display:none;}
    .rowcolor{ background-color:#CCCCCC !important;}
    body {
      font-size:14px;
      padding: 3px;
     }
    }
  .tg  {border-collapse:collapse;border-spacing:0;width: 100%}
.tg td{font-size:14px;font-weight: normal;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg th{text-align: left;font-size:14px;font-weight:bold;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:left}
.tg-s6z25{text-align:right;}
tbody{margin: 0;
  padding: 0}
.primary_area1{
  background-color: #fff;
  border-top: 5px dotted #000;
  border-bottom: 5px dotted #000;
  box-shadow: inset 0 -2px 0 0 #000, inset 0 2px 0 0 #000, 0 2px 0 0 #000, 0 -2px 0 0 #000;
  margin-bottom: 1px;
  padding: 10px;
  border-left: 5px;
  border-right: 5px;
  border-left-style:double ;
  border-right-style:double;
  padding-top:0px;
}
</style>
<div class="row">
  <div class="col-md-12">
   <div class="box box-info">
         <div class="box-header">
  <div class="widget-block">
    <div class="widget-head">
    <h5><i class="fa fa-eye"></i> 
      <?php echo ucwords($heading); ?>
    </h5>
    <div class="widget-control pull-right">

    </div>
    </div>
    </div>
</div>  
<div class="box-body">
  <div class="primary_area">
<div class="primary_area1">
<?php echo  $this->load->view($view); ?>
</div>
</div>
</div>
        <!-- /.box-body -->
<div class="box-footer">
   <div class="col-sm-6">
    <a href="<?php echo base_url(); ?>gatep/losticsapp/lists" class="btn btn-info"> <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
   <button class="btn btn-info prints"><i class="fa fa-print" ></i> Print</button>
 </div>
 <?php if($info->sub_contract_status==1){  ?>
 <div class="col-sm-6">
  <a href="#" class="btn btn-danger reject" data-pid="<?php echo $info->gatepass_id; ?>" ><i class="fa fa-ban tiny-icon"></i> Decline</a>
  <a href="<?php echo base_url(); ?>gatep/losticsapp/approved/<?php echo $info->gatepass_id; ?>" class="btn btn-info"> 
      <i class="fa fa-check" aria-hidden="true"></i>Approve</a>
 </div>
 <?php } ?>
  </div>
     
  </div>
</div>
<!-- /.box-footer -->
</div>
<div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Add Decline Note</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>gatep/losticsapp/decline">
          <div class="form-group">
            <label class="col-sm-4 control-label">Decline Note </label>
            <div class="col-sm-7">
              <textarea class="form-control" name="reject_note" rows="3" id="reject_note" placeholder="Decline Note"></textarea> 
              <span class="error-msg">Decline Note field is required</span>
            </div>
          </div>
       <input type="hidden" name="gatepass_id"  id="gatepass_id" value="<?php echo $info->gatepass_id; ?>">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> Save</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .error-msg{display: none;}
</style>