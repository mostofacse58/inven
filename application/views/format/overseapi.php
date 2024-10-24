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
            <!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" action="<?php echo base_url();?>format/overseapi/lists" method="GET" enctype="multipart/form-data">
        <div class="box-body">
          <label class="col-sm-2 control-label">
           PI. NO <span style="color:red;">  </span></label>
            <div class="col-sm-2">
              <input class="form-control" name="pi_no" id="pi_no" value="<?php echo set_value('pi_no'); ?>" placeholder="NO">
            <span class="error-msg"><?php echo form_error("pi_no");?></span>
            </div>
            <label class="col-sm-2 control-label">From Department</label>
            <div class="col-sm-3">
              <select class="form-control select2" name="department_id" id="department_id">
              <option value="All" <?php echo 'All'==set_value('department_id')? 'selected="selected"':0; ?>>All</option>
              <?php 
              foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("department_id");?></span>
            </div>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>format/overseapi/lists">All</a>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
      <div class="table-responsive table-bordered">
      <table id="" class="table table-bordered table-striped" style="width:100%;border:#000">
         <thead>
          <tr>
            <th style="text-align:center;width:4%;">SN</th>
            <th style="text-align:center;width:10%;">Department</th>
            <th style="text-align:center;width:8%;">Product Type</th>
            <th style="text-align:center;width:8%;">For</th>
            <th style="text-align:center;width:8%;">Type</th>
            <th style="text-align:center;width:8%">PI NO</th>
            <th style="text-align:center;width:8%;">PI Date</th>
            <th style="text-align:center;width:8%">Demand Date</th>
            <th style="width:8%;">New Demand Date</th>
            <th style="text-align:center;width:8%;">Approved Date</th>
            <th style="text-align:center;width:10%;">Status 状态</th>
            <th style="text-align:center;width:10%;">Requested by</th>
            <th style="text-align:center;width:5%;">Actions 行动</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)): $i=1;
          foreach($list as $row):
              ?>
          <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td class="text-center"><?php echo $row->department_name; ?></td>
      <td class="text-center"><?php echo $row->product_type; ?></td>
      <td class="text-center"><?php 
      if($row->pi_type==1) echo "Safety Item"; 
            else echo "Fixed Asset"; ?></td>
      <td class="text-center"><?php 
      if($row->purchase_type_id==1||$row->purchase_type_id==2) echo "Overseas"; 
            else echo "Local"; ?></td>
      <td class="text-center"><?php echo $row->pi_no; ?></td>
      <td class="text-center"><?php echo findDate($row->pi_date); ?></td>
      <td class="text-center"><?php echo findDate($row->demand_date); ?></td>
      <td class="text-center"><?php echo findDate($row->new_demand_date); ?></td>
      <td class="text-center"><?php echo findDate($row->approved_date); ?></td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->pi_status==5||$row->pi_status==8)?"danger":"success";?>">
        <?php 
          if($row->pi_status==1) echo "Draft";
          elseif($row->pi_status==2) echo "Submitted";
          elseif($row->pi_status==3) echo "Confirmed";
          elseif($row->pi_status==4) echo "Pending";
          elseif($row->pi_status==5) echo "Received";
          elseif($row->pi_status==6) echo "Verified";
          elseif($row->pi_status==7) echo "Approved";
          elseif($row->pi_status==8) echo "Rejected";
          ?>
      </span></td>
      <td class="text-center"><?php echo $row->user_name; ?></td>
            <td style="text-align:center">
            <div class="btn-group">
            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
              <li><a href="<?php echo base_url()?>dashboard/viewpipdf/<?php echo $row->pi_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View PDF</a></li>
               <li> <a href="<?php echo base_url()?>dashboard/downloadpiExcel/<?php echo $row->pi_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View Excel</a></li>
               <li> <a href="<?php echo base_url()?>format/verified/viewpihtmlonly/<?php echo $row->pi_id;?>">
              <i class="fa fa-eye tiny-icon"></i>View </a></li>
            <?php if($row->pi_status==5){ ?>
              <li> <a href="<?php echo base_url()?>format/overseapi/received/<?php echo $row->pi_id;?>">
                <i class="fa fa-check tiny-icon"></i>Receive 接收</a></li>
              <li> <a href="<?php echo base_url()?>format/overseapi/returns/<?php echo $row->pi_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Return 返回</a></li>
            <li> <a href="<?php echo base_url()?>format/overseapi/rejected/<?php echo $row->pi_id;?>">
                <i class="fa fa-times tiny-icon"></i>Reject 拒绝</a></li>
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
