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
<style type="text/css">
</style>
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>medical/monthlystatement/downloadExcel<?php echo "/$department_id/$from_date/$to_date";  ?>">
<i class="fa fa-file-excel-o"></i>
Download Excel
</a>
<button class="btn btn-sm btn-primary pull-right" id="btnExport" onclick="fnExcelReport();"> 
<i style="background-color: green" class="fa fa-file-excel-o"></i>EXPORT EXCEL</button>

<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>medical/monthlystatement/reportrResult" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-1 control-label">Department</label>
            <div class="col-sm-2">
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
            <label class="col-sm-1 control-label">Symptom <span style="color:red;">  </span></label>
            <div class="col-sm-2">
            <select class="form-control select2" name="symptoms_id" style="width: 100%">
              <option value="All" <?php echo 'All'==set_value('symptoms_id')? 'selected="selected"':0; ?>>All</option>
                <?php foreach($slist as $value){ ?>
                <option value="<?php echo $value->symptoms_id; ?>" <?php echo $value->symptoms_id==set_value('symptoms_id')? 'selected="selected"':0; ?>>
                  <?php echo $value->symptoms_name; ?></option>
                  <?php } ?>
            </select>
            </div>
            <label class="col-sm-1 control-label">From Date</label>
              <div class="col-sm-2">
                  <input type="text" name="from_date" readonly  class="form-control date" id="inputEmail3" placeholder="From Date" value="<?php if (isset($info))
                          echo $info->from_date;
                      else
                          echo set_value('from_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
              <div class="col-sm-2">
                  <input type="text" name="to_date"  readonly class="form-control date" id="inputEmail3" placeholder="To Date" value="<?php if (isset($info))
                          echo $info->to_date;
                      else
                          echo set_value('to_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("to_date"); ?></span>
              </div>
            <div class="col-sm-1">
          <button type="submit" class="btn btn-info pull-left">Result</button>
          </div>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered">
        <table class="table table-bordered table-striped colortd" style="width:99%;border:#000;" id="headerTable">
          <thead>
        <tr>
            <th style="text-align:center;width:5%;">SN</th>
            <th style="text-align:center;width:10%">Date</th>
            <th style="width:10%">ID NO</th>
            <th style="width:15%;">Name</th>
            <th style="text-align:center;width:5%">Male</th>
            <th style="text-align:center;width:7%">Section</th>
            <th style="text-align:center;width:8%">Description of sickness</th>
            <th style="text-align:center;width:8%">Treatment</th>
            <th style="text-align:center;width:8%">Cost</th>
        </tr>
        </thead>
        <tbody>
        <?php $grandtotal=0; 
        if(isset($resultdetail)&&!empty($resultdetail)): $i=1;
          foreach($resultdetail as $row):
            $grandtotal=$grandtotal+$row->cost;
            ?>
            <tr>
              <td style="text-align:center;">
                <?php echo $i++; ?></td>
              <td style="text-align:center;">
                <?php echo findDate($row->issue_date);  ?></td>
              <td style="text-align:center;">
                <?php echo $row->employee_id; ?></td>
              <td><?php echo $row->employee_name;?></td>
              <td style="text-align:center;">
                <?php echo $row->sex;  ?></td> 
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo "$row->location_name"; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->symptoms_group; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo $row->item_group; ?></td>
              <td style="vertical-align: text-top;text-align:center;">
              <?php  echo number_format($row->cost,2); ?></td>
            </tr>
            <?php
            endforeach;
        endif;
        ?>
        <tr>
            <th style="text-align:right;" colspan="8">Grand Total</th>
            <th style="text-align:center;"><?php echo $grandtotal; ?></th>
        </tr>
        </tbody>
        </table>
        </div>
    </div>
      <!-- /.box-header -->

      <!-- /.box-body -->
    </div>
  </div>
 </div>
<script>
  
  function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('headerTable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
</script>
<iframe id="txtArea1" style="display:none"></iframe>