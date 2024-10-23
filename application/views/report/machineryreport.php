<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
    $(document).ready(function(){
       $('.date').datepicker({
            "format": "dd/mm/yyyy",
            "todayHighlight": true,
            "autoclose": true
        });
    });
</script>
<div class="row">
<div class="col-xs-12">
  <div class="box box-primary">
  <div class="box-header">
  <div class="widget-block">
<div class="widget-head">
<h5><i class="fa fa-file-excel-o" aria-hidden="true"></i>
 <?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<?php if(isset($resultdetail)){ ?>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/machineryreport/downloadExcel<?php echo "/$category_id/$product_id/$floor_id/$line_id/$detail_status/$tpm_status/$tpm_serial_code";  ?>">
<i class="fa fa-file-excel-o"></i>
Download
</a>
<?php } ?>
</div>
</div>
</div>
</div>
<div class="box box-info">
      <!-- form start -->
  <form class="form-horizontal" action="<?php echo base_url();?>me/machineryreport/reportResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-1 control-label">Category </label>
            <div class="col-sm-2">
              <select class="form-control select2" name="category_id" id="category_id">
              <option value="All">All</option>
              <?php foreach($clist as $rows){  ?>
              <option value="<?php echo $rows->category_id; ?>" 
                <?php if(isset($category_id))echo $rows->category_id==$category_id? 'selected="selected"':0; else
                 echo $rows->category_id==set_value('category_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->category_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("category_id");?></span>
            </div>
            <label class="col-sm-1 control-label">Model</label>
           <div class="col-sm-4">
              <select class="form-control select2" name="product_id" id="product_id">
              <option value="All">All</option>
              <?php foreach($plist as $rows){  ?>
              <option value="<?php echo $rows->product_id; ?>" 
                <?php if(isset($product_id))echo $rows->product_id==$product_id? 'selected="selected"':0; else
                 echo $rows->product_id==set_value('product_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->product_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("product_id");?></span>
            </div>
            <label class="col-sm-2 control-label">Active Status </label>
          <div class="col-sm-2">
            <select class="form-control select2"  name="detail_status" id="detail_status">
              <option value="All"
                <?php  if(isset($detail_status)) echo 'All'==$detail_status? 'selected="selected"':0; else echo set_select('detail_status','All');?>>
                  All</option>
              <option value="1"
                <?php  if(isset($detail_status)) echo 1==$detail_status? 'selected="selected"':0; else echo set_select('detail_status',1);?>>
                  ACTIVE</option>
                  <option value="2"
                <?php  if(isset($detail_status)) echo 2==$detail_status? 'selected="selected"':0; else echo set_select('detail_status',2);?>>
                  DEACTIVE</option>
            </select>
           <span class="error-msg"><?php echo form_error("detail_status");?></span>
          </div>
          </div>
           <div class="form-group">
            <label class="col-sm-2 control-label">Status 状态 <span style="color:red;">  *</span></label>
            <div class="col-sm-2">
              <select class="form-control select2" required name="tpm_status" id="tpm_status">
                <option value="All"
                <?php  if(isset($tpm_status)) echo 'All'==$tpm_status? 'selected="selected"':0; else echo set_select('tpm_status','All');?>>
                  All</option>
                <option value="1"
                  <?php  if(isset($info)) echo 1==$info->tpm_status? 'selected="selected"':0; else echo set_select('tpm_status',1);?>>
                    USED</option>
                    <option value="2"
                  <?php  if(isset($info)) echo 2==$info->tpm_status? 'selected="selected"':0; else echo set_select('tpm_status',2);?>>
                    IDLE</option>
                    <option value="3"
                  <?php  if(isset($info)) echo 3==$info->tpm_status? 'selected="selected"':0; else echo set_select('tpm_status',3);?>>
                    UNDER SERVICE</option>
              </select>
             <span class="error-msg"><?php echo form_error("tpm_status");?></span>
                  </div>
            <label class="col-sm-2 control-label">Location </label>
            <div class="col-sm-2">
              <select class="form-control select2"  name="floor_id" id="floor_id">
                <option value="All">All</option>
                <?php
                 foreach ($flist as $value) {  ?>
                <option value="<?php echo $value->floor_id; ?>"
                    <?php  if(isset($floor_id)) echo $value->floor_id==$floor_id? 'selected="selected"':0; else echo set_select('floor_id',$value->floor_id);?>>  <?php echo $value->floor_no; ?></option>
                  <?php } ?>
              </select>
            </div>
            <label class="col-sm-2 control-label">Line </label>
            <div class="col-sm-2">
              <select class="form-control select2"  name="line_id" id="line_id">
                <option value="All">All</option>
                <?php $llist=$this->db->query("SELECT * FROM floorline_info 
                    WHERE 1")->result();
                 foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->line_id; ?>"
                    <?php  if(isset($line_id)) echo $value->line_id==$line_id? 'selected="selected"':0; else echo set_select('line_id',$value->line_id);?>>  <?php echo $value->line_no; ?></option>
                  <?php } ?>
              </select>
            </div>
            </div>
           <div class="form-group">
            <label class="col-sm-3 control-label">TPM CODE (TPM代码)/Ventura CODE</label>
            <div class="col-sm-2">
              <input type="text" name="tpm_serial_code" class="form-control" placeholder="TPM CODE (TPM代码)/Ventura CODE" value="<?php  echo set_value('tpm_serial_code'); ?>" autofocus>
            </div>
            <div class="col-sm-1">
            <button type="submit" class="btn btn-success pull-left"> Result </button>
          </div>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
      <?php if(isset($resultdetail)){ ?>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered">
          <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" >
            <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="width:10%">Ventura Code</th>
                <th style="width:15%;">Machine Name</th>
                <?php if($category_id=='All'){ ?>
                <th style="width:10%">Category</th>
                <?php } ?>
                <?php if($product_id=='All'){ ?>
                <th style="width:10%;text-align:center">Model NO</th>
                <?php } ?>
                <th style="text-align:center;width:7%">C. Location</th>
                <th style="text-align:center;width:10%">Machine Type 机器的种类</th>
                <th style="text-align:center;width:7%">TPM CODE (TPM代码)</th>
                <th style="text-align:center;width:6%">Status 状态</th>
                <th style="text-align:center;width:6%">D. Status 状态</th>
                <th style="text-align:center;width:10%">Invoice No</th>
                <th style="text-align:center;width:8%">Price</th>
                <th style="text-align:center;width:8%">Assign Date</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if(isset($resultdetail)&&!empty($resultdetail)): 
                $i=1;
                foreach($resultdetail as $row):
                    ?>
                  <tr>
                    <td style="text-align:center;background-color:<?php if($row->machine_status==NULL) 
                          echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $i++; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->ventura_code; ; ?></td>
                    <td style="background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>"><?php echo $row->product_name;?></td>
                    <?php if($category_id=='All'){ ?>
                    <td style="text-align:center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->category_name; ; ?></td>
                      <?php } ?>
                    <?php if($product_id=='All'){ ?>
                    <td style="text-align:center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                      <?php echo $row->product_code;  ?></td> 
                      <?php } ?>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->line_no; ?></td>
                    <td style="text-align:center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php echo $row->machine_type_name;  ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->tpm_serial_code; ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo CheckStatus($row->machine_status); ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo CheckDeactiveStatus($row->deactive_status); ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->invoice_no; ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                    <?php  echo $row->machine_price; ?></td>
                    <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->machine_status==NULL)echo "#FFDF00"; else echo "#FFFFFF"; ?>">
                     <?php  echo findDate($row->assign_date); ?></td>
             
                  </tr>
                  <?php
                  endforeach;
              endif;
              ?>
              </tbody>
              </table>
              </div>
              <?php } ?>
    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
