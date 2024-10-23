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
<script language="javascript" type="text/javascript">
$(document).ready(function() {
  $('.popup').click(function(event) {
     var urls=$(this).attr("href");
     event.preventDefault();
     window.open(urls, "popupWindow", "width=180,height=700,scrollbars=yes");
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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>it/fixedassetreport/downloadExcel<?php echo "/$category_id/$product_id/$location_id/$issue_status/$department_id/$ram_id/$mlocation_id/$from_date/$to_date/$asset_encoding";  ?>" >
<i style="background-color: green" class="fa fa-file-excel-o"></i>
Download Excel
</a> 
<button class="btn btn-sm btn-primary pull-right" id="btnExport" onclick="fnExcelReport();"> 
<i style="background-color: green" class="fa fa-file-excel-o"></i>EXPORT EXCEL</button>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" target="_blank" href="<?php echo base_url(); ?>it/fixedassetreport/downloadPdf<?php echo "/$category_id/$product_id/$location_id/$issue_status/$department_id/$ram_id/$mlocation_id/$from_date/$to_date/$asset_encoding";  ?>">
<i style="background-color: red" class="fa fa-file-pdf-o"></i>
Download pdf
</a>
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" target="_blank" href="<?php echo base_url(); ?>it/fixedassetreport/downloadPdf1<?php echo "/$category_id/$product_id/$location_id/$issue_status/$department_id/$ram_id/$mlocation_id/$asset_encoding/$from_date/$to_date";  ?>">
<i style="background-color: red" class="fa fa-file-pdf-o"></i>
Download pdf 2
</a>
<a class="btn btn-sm btn-primary pull-right popup" style="margin-right:0px;" target="_blank" href="<?php echo base_url(); ?>it/fixedassetreport/printsticker<?php echo "/$category_id/$issue_status/$department_id/$from_date/$to_date/$asset_encoding";  ?>">
<i class="fa fa-barcode"></i>
Print Barcode
</a>

<?php } ?>
</div>
</div>
</div>

</div>
<div class="box box-info">
      <!-- form start -->
      <form class="form-horizontal" action="<?php echo base_url();?>it/fixedassetreport/reportResult" method="POST" enctype="multipart/form-data">
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
            <label class="col-sm-2 control-label">Asset Model</label>
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
            <label class="col-sm-1 control-label">Dept.</label>
            <div class="col-sm-2">
              <select class="form-control select2" name="department_id" id="department_id">
              <option value="All">All</option>
              <?php 
              foreach($dlist as $rows){  ?>
              <option value="<?php echo $rows->department_id; ?>" 
                <?php echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>>
                 <?php echo $rows->department_name; ?></option>
              <?php }  ?>
            </select>                    
            <span class="error-msg"><?php echo form_error("department_id");?></span>
            </div>
          </div>
           <div class="form-group">
            <label class="col-sm-1 control-label">Location </label>
            <div class="col-sm-2">
              <select class="form-control select2"  name="location_id" id="location_id">
                <option value="All">All</option>
                <?php
                 foreach ($llist as $value) {  ?>
                <option value="<?php echo $value->location_id; ?>"
                    <?php  if(isset($location_id)) echo $value->location_id==$location_id? 'selected="selected"':0; else echo set_select('location_id',$value->location_id);?>>  <?php echo $value->location_name; ?></option>
                  <?php } ?>
              </select>
            </div>
            <label class="col-sm-1 control-label">Main Area </label>
            <div class="col-md-2">
            <select class="form-control select2" name="mlocation_id">
            <option value="All" selected="selected">All</option>
            <?php $mllist=$this->db->query("SELECT * FROM main_location")->result();
            foreach ($mllist as $rows) { ?>
              <option value="<?php echo $rows->mlocation_id; ?>" 
              <?php if (isset($info))
                  echo $rows->mlocation_id == $mlocation_id ? 'selected="selected"' : 0;
              else
                  echo $rows->mlocation_id == set_value('mlocation_id') ? 'selected="selected"' : 0;
              ?>><?php echo $rows->mlocation_name; ?></option>
                  <?php } ?>
              </select>
            <span class="error-msg"><?php echo form_error("mlocation_id"); ?></span>
          </div>
            
        <label class="col-sm-1 control-label">Status 状态 </label>
          <div class="col-sm-2">
            <select class="form-control select2"  name="issue_status" id="issue_status">
              <option value="All"
                <?php  if(isset($issue_status)) echo 'All'==$issue_status? 'selected="selected"':0; else echo set_select('issue_status','All');?>>
                  All</option>
              <option value="1"
                <?php  if(isset($issue_status)) echo 1==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',1);?>>
                  USED</option>
                  <option value="2"
                <?php  if(isset($issue_status)) echo 2==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',2);?>>
                  IDLE/Stock</option>
                  <option value="3"
                <?php  if(isset($issue_status)) echo 3==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',3);?>>
                  UNDER SERVICE</option>
                  <option value="4"
                <?php  if(isset($issue_status)) echo 4==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',4);?>>
                  DAMAGE</option>
                  <option value="5"
                <?php  if(isset($issue_status)) echo 5==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',5);?>>
                  DISPOSE</option>
                  <option value="6"
                <?php  if(isset($issue_status)) echo 6==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',6);?>>
                  SOLD</option>
                <option value="7"
                <?php  if(isset($issue_status)) echo 7==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',7);?>>
                  CSR</option>
                <option value="8"
                <?php  if(isset($issue_status)) echo 8==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',8);?>>
                  LOST</option>
                <option value="9"
                <?php  if(isset($issue_status)) echo 9==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',9);?>>
                  Dormant</option>
                <option value="10"
                <?php  if(isset($issue_status)) echo 10==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',10);?>>
                  Transfer</option>
                  <option value="11"
                <?php  if(isset($issue_status)) echo 11==$issue_status? 'selected="selected"':0; else echo set_select('issue_status',11);?>>
                  Paper Free</option>
            </select>
           <span class="error-msg"><?php echo form_error("issue_status");?></span>
          </div>
            <div class="col-md-1">
            <select class="form-control select2" name="ram_id">
            <option value="All" selected="selected">All</option>
            <?php $prlist=$this->db->query("SELECT * FROM ram_info")->result();
            foreach ($prlist as $rows) { ?>
              <option value="<?php echo $rows->ram_id; ?>" 
              <?php if (isset($info))
                  echo $rows->ram_id == $ram_id ? 'selected="selected"' : 0;
              else echo $rows->ram_id == set_value('ram_id') ? 'selected="selected"' : 0;
              ?>><?php echo $rows->ram_type; ?></option>
                  <?php } ?>
              </select>
            <span class="error-msg"><?php echo form_error("ram_id"); ?></span>
          </div>
            <div class="col-sm-2">
              <input type="text" name="asset_encoding" class="form-control" placeholder="SN/CODE" value="<?php  echo set_value('asset_encoding'); ?>" autofocus>
            </div>
          </div>
            <div class="form-group">
            
          <label class="col-sm-1 control-label">Purchase Date </label>
              <div class="col-sm-2">
                  <input type="text" name="from_date" readonly  class="form-control date" placeholder="From Date" value="<?php if (isset($info))
                          echo $info->from_date;
                      else
                          echo set_value('from_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("from_date"); ?></span>
              </div>
              <div class="col-sm-2">
                  <input type="text" name="to_date" readonly class="form-control date" placeholder="To Date" value="<?php if(isset($info))
                          echo $info->to_date;
                      else echo set_value('to_date');
                      ?>">
                  <span class="error-msg"><?php echo form_error("to_date"); ?></span>
              </div>
              <label class="col-sm-1 control-label">Issue Date </label>
              <div class="col-sm-2">
                  <input type="text" name="from_idate" readonly  class="form-control date" placeholder="From Date" value="<?php if (isset($info))
                          echo $info->from_idate;
                      else
                          echo set_value('from_idate');
                      ?>">
                  <span class="error-msg"><?php echo form_error("from_idate"); ?></span>
              </div>
              <div class="col-sm-2">
                  <input type="text" name="to_idate" readonly class="form-control date" placeholder="To Date" value="<?php if(isset($info))
                          echo $info->to_idate;
                      else echo set_value('to_idate');
                      ?>">
                  <span class="error-msg"><?php echo form_error("to_idate"); ?></span>
              </div>
            <div class="col-sm-2">
            <button type="submit" class="btn btn-success pull-left"> Search搜索 </button>
          </div>
          </div>
        </div>
        <!-- /.box-body -->
      </form>
      <?php if(isset($resultdetail)){ ?>
      <!-- /////////////////////////////////// -->
      <div class="table-responsive table-bordered" id="customers">
          <table class="table table-bordered table-striped colortd" style="width:99%;border:#000" id="headerTable">
            <thead>
              <tr>
                <th style="text-align:center;width:5%;">SN</th>
                <th style="width:10%">Ventura Code</th>
                <th style="text-align:center;width:7%">Serial No</th>
                <th style="width:15%;">Asset Name</th>
                <?php if($category_id=='All'){ ?>
                <th style="width:10%">Category</th>
                <?php } ?>
                <?php if($product_id=='All'){ ?>
                <th style="width:10%;text-align:center">Model NO</th>
                <?php } ?>
                <th style="text-align:center;width:7%">Location</th>
                <th style="text-align:center;width:10%">Department</th>
                <th style="text-align:center;width:10%">Employee</th>
                <th style="text-align:center;width:8%">Status 状态</th>
                <th style="text-align:center;width:7%">Purchase Price</th>
                <th style="text-align:center;width:7%">Purchase Date</th>
                <th style="text-align:center;width:7%">Issue Date</th>
                <th style="text-align:center;width:10%">Note</th>
              </tr>
              </thead>
              <tbody>
              <?php
              if(isset($resultdetail)&&!empty($resultdetail)): 
                $i=1;
                foreach($resultdetail as $row):
                  if($row->issue_type==1){
                    $head_id=$row->head_id;
                    $empinfo=$this->db->query("SELECT * FROM employee_idcard_info e 
                      WHERE employee_cardno='$head_id' ")->row();
                    if(count($empinfo)>0){
                      $row->employee_name=$empinfo->employee_name;
                      $row->employee_id=$head_id;
                    }
                    
                  }
                  ?>
          <tr>
            <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
              <?php echo $i++; ?></td>
            <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
              <?php echo $row->ventura_code; ; ?></td>
              <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php  echo $row->asset_encoding; ?></td>
            <td style="background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>"><?php echo $row->product_name;?></td>
            <?php if($category_id=='All'){ ?>
            <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
              <?php echo $row->category_name; ; ?></td>
              <?php } ?>
            <?php if($product_id=='All'){ ?>
            <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
              <?php echo $row->product_code;  ?></td> 
              <?php } ?>
            <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php  echo "$row->mlocation_name($row->location_name)"; ?></td>
            <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php echo $row->department_name;  ?></td>
            <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php if($row->employee_id!='') echo "$row->employee_name($row->employee_id)"; ?></td>
            <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php  echo CheckStatuspro($row->it_status); ?></td>
            <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php  echo "$row->machine_price $row->currency"; ?></td>
            <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php  echo findDate($row->purchase_date); ?></td>
            <td style="vertical-align: text-top;text-align: center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php  echo findDate($row->issue_date); ?></td>
            <td style="text-align:center;background-color:<?php if($row->it_status==2)echo "#FFDF00"; elseif($row->it_status==4) echo "#FF0000";  else echo "#FFFFFF"; ?>">
            <?php if($row->it_status==5) echo $row->despose_note; elseif($row->remarks!='') echo "$row->remarks"; else echo "$row->other_description";  ?></td>
          </tr>
          <?php
          endforeach;
      endif;
      ?>
      </tbody>
      </table>
      
      </div>
      <!-- <object id="output" type="application/pdf"></object> -->
      <?php } ?>
    </div>

      <!-- /.box-header -->
    </div>
  </div>
 </div>
<!-- <iframe id="txtArea1" style="display:none"></iframe>
<script src="<?php echo base_url(); ?>/jspdf/jspdf.debug.js"></script>
<script src="<?php echo base_url(); ?>/jspdf/jspdf.plugin.autotable.js"></script>
<script>
  const doc = new jsPDF('p', 'mm');
  doc.autoTable({
    html: '#headerTable',
    theme: 'grid',
    // tableWidth: 180,
    // head: [['ID', 'Name', 'Email', 'Country', 'IP-address']],
    // body: [
    //   ['1', 'Donna', 'dmoore0@furl.net', 'China', '211.56.242.221'],
    //   ['2', 'Janice', 'jhenry1@theatlantic.com', 'Ukraine', '38.36.7.199'],
    //   [
    //     '3',
    //     'Ruth',
    //     'rwells2@constantcontact.com',
    //     'Trinidad and Tobago',
    //     '19.162.133.184',
    //   ],
    //   ['4', 'Jason', 'jray3@psu.edu', 'Brazil', '10.68.11.42'],
    //   ['5', 'Jane', 'jstephens4@go.com', 'United States', '47.32.129.71'],
    //   ['6', 'Adam', 'anichols5@com.com', 'Canada', '18.186.38.37'],
    // ],
  });

  document.getElementById("output").data = doc.output('datauristring');
</script>
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
<style>
   #output {
      width: 100%;
      height: 100vh;
      margin-top: 20px;
    }
</style> -->