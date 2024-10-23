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
            <form class="form-horizontal" action="<?php echo base_url();?>currency/save<?php if(isset($info)) echo "/$info->id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">
                    Currency <span style="color:red;">  *</span></label>
                  <div class="col-sm-2">
                    <select class="form-control select2" name="currency" id="currency" style="width: 100%"> 
                      <?php foreach ($clist as $rows) { ?>
                        <option value="<?php echo $rows->currency; ?>" 
                        <?php if (isset($info))
                            echo $rows->currency == $info->currency ? 'selected="selected"' : 0;
                            else
                            echo $rows->currency ==set_value('currency') ? 'selected="selected"' : 0;
                        ?>><?php echo $rows->currency; ?></option>
                            <?php } ?>
                      </select>
                   <span class="error-msg"><?php echo form_error("currency");?></span>
                  </div>
                  <label for="inputEmail3" class="col-sm-1 control-label">
                    To</label>
                  <div class="col-sm-2">
                    <select class="form-control select2" name="in_currency" id="in_currency" style="width: 100%"> 
                      <?php foreach ($clist as $rows) { ?>
                        <option value="<?php echo $rows->currency; ?>" 
                        <?php if (isset($info))
                            echo $rows->currency == $info->in_currency ? 'selected="selected"' : 0;
                            else
                            echo $rows->currency ==set_value('in_currency') ? 'selected="selected"' : 0;
                        ?>><?php echo $rows->currency; ?></option>
                            <?php } ?>
                      </select>
                   <span class="error-msg"><?php echo form_error("in_currency");?></span>
                  </div>
                  <label for="inputEmail3" class="col-sm-1 control-label">
                    Rate</label>
                  <div class="col-sm-1">
                    <input type="text" name="convert_rate" class="form-control"  placeholder="Rate" value="<?php if(isset($info)) echo $info->convert_rate; else echo set_value('convert_rate'); ?>">
                   <span class="error-msg"><?php echo form_error("convert_rate");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">SAVE 保存</button>
                </div>
                  
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
                <th style="width:15%">Currency Name</th>
                <th style="width:15%">Rate</th>
                <th  style="text-align:center;width:5%">Actions 行动</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($list&&!empty($list)):
                foreach($list as $row):
                    ?>
                  <tr>
                      <td><?php echo "$row->currency-$row->in_currency";?></td>
                      <td><?php echo $row->convert_rate;?></td>
                      <td style="text-align:center">
                        <a class="btn btn-success" href="<?php echo base_url()?>currency/edit/<?php echo $row->id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;                                        
                        <!-- <a href="<?php echo base_url()?>currency/delete/<?php echo $row->id;?>" class="delete btn btn-success" onClick="return doconfirm();" ><i class="fa fa-trash-o tiny-icon"></i></a> -->
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
