<script type="text/javascript">
  function divcall(val){
       
    $("#print_options").show();
    if(val==216){
      $("#print_result_div").show(); 
      $("#report_result_div").hide();
      $("#result_ajax_div").hide();
    } else if(val==217) {
      $("#report_result_div").show(); 
      $("#print_result_div").hide(); 
      $("#result_ajax_div").hide(); 
    }
    $("#hid_sub_id").val(val);

  }

  function tablediv(val,id){
    
    $.ajax({
      url : "<?php echo site_url('Print_Ctrl/Print_Ctl/show_print_xl_table/')?>",
      type: "POST",
      data:{ val:val,id:id},
      //dataType: "JSON",

      success: function(data)
      {
        //alert(data);exit;
        if(id==1){
          $("#click_btn_all").show();
          $("#default_btns").hide();
          $("#click_btn_rep").hide();
        }
        if(id==2){
          $("#click_btn_all").hide();
          $("#default_btns").show();
          $("#click_btn_rep").hide();

        }
        if(id==3){
          $("#click_btn_all").hide();
          $("#default_btns").hide();
          $("#click_btn_rep").show();

        }
        $("#print_result_div").hide();
        $("#report_result_div").hide();
        $("#result_ajax_div").show();
        $("#result_ajax_div").html(data);
      }
    });
  }
$(document).ready(function()
{

  $("#checkAll").click(function () { 
       $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
   });

  $("#Vw_print_report").click(function(){ 
    
    var start = $("#from_date").val();  
    var end   = $("#to_date").val(); 
    var id=2;
    var val=217;

    $.ajax({
      url : "<?php echo site_url('Print_Ctrl/Print_Ctl/show_rpt_dt_xl_table/')?>",
      type: "POST",
      data:{ start:start, end:end, id:id, val:val},
      success: function(data)
      {
        $("#print_result_div").hide();
        $("#report_result_div").hide();
        $("#result_ajax_div").show();
        $("#result_ajax_div").html(data);
      } 

    });

  });

  $("#Vw_print_reportt").click(function(){ 
    
    var start = $("#from_date").val(); 
    var end   = $("#to_date").val(); 
    var id=$("#hid_id").val();;
    var val=$("#hid_val").val();;

    $.ajax({
      url : "<?php echo site_url('Print_Ctrl/Print_Ctl/show_rpt_dt_xl_table/')?>",
      type: "POST",
      data:{ start:start, end:end, id:id, val:val},
      success: function(data)
      {
        $("#print_result_div").hide();
        $("#report_result_div").hide();
        $("#result_ajax_div").show();
        $("#result_ajax_div").html(data);
      } 

    });

  });

   $("#excel_btn").click(function(){ 
     var from_dt = $("#from").val();
     var to_dt   = $("#to").val();
     var id      = $("#id").val();
     var val     = $("#val").val();

     $.ajax({
      url : "<?php echo site_url('Print_Ctrl/Print_Ctl/generate_excel/')?>",
      type: "POST",
      data:{ from_dt:from_dt, to_dt:to_dt, id:id, val:val},
      success: function(data)
      {
         //alert(data);
      window.open('<?php echo site_url('Print_Ctrl/Print_Ctl/generate_excel/'); ?>','_blank');
      } 

    });


  });

}); 

function print_all(){
  
  var items=document.getElementsByName('check_id[]');
  var selectedItems="";
  for(var i=0; i<items.length; i++){
    if(items[i].type=='checkbox' && items[i].checked==true)
      selectedItems+=items[i].value+"/";
  }
  //alert(selectedItems);
  $.ajax({ 
      url : "<?php echo site_url('Print_Ctrl/Print_Ctl/print_all/')?>",
      type: "POST",
      data:{ selectedItems:selectedItems},
      //dataType: "JSON",
      success: function(data)
      {
        alert(data);
        //$('#shw_list').html(data); location.reload();
        //window.location.reload();
      }
    });
}

</script>
<div class="main-content ui-innerpage">
  <div class="row no-gutters p-1">
    <?php 
    foreach($menu as $menu_res){ ?>
    <div class="col-6 p-5">
      <!-- ---------------- start of card --- ------------------------ -->
              <div class="card ">
                <div class="row no-gutters">
                  <div class="col-4 d-flex justify-content-center py-4 rightbordercard">
                    <i class="<?php echo $menu_res['icon_name']; ?>"></i>
                  </div>
                  <div class="col-8 leftbordercard">
                    <div class="card-body " style="cursor: pointer;"  onclick="divcall(<?php echo $menu_res['sub_modue_id']; ?>);">
                      <h5 class="card-title" >
                        <?php echo $menu_res['sub_modue_name']; ?>
                      </h5>
                      <p class="card-text"><small class="text-muted">  NEW </small></p>
                    </div> <!-- end of card-body -->
                   
                  </div> <!-- end of col8 -->
                </div> <!-- end of row -->
              </div>  <!-- end of card -->
              <!-- ---------------- end of card --- ------------------------ -->
    </div> <!-- end of col6 -->
  <?php } ?>
    
  </div> <!-- end of row -->
 
  <div class="row no-gutters px-3">
    <div class="col-6 p-1" id="print_options" style="display: none;">
      <div class="card">
        <div class="card-body">
          <div class="row no-gutters p-1" id="default_btns">
            <div class="col-4 p-1">
              <input type="hidden" name="hid_sub_id" id="hid_sub_id" value="">
              <button type="button" class="btn btn-block btn-flat btn-point bg-mediumorchid"  onclick="tablediv(hid_sub_id.value,1);"><i class="fas fa-file-archive"></i>&nbsp; ALL </button>
              <input type="hidden" name="all">
              
            </div> <!-- end of col4 --> 
            <div class="col-4 p-1">
              <button type="button" class="btn btn-block btn-flat btn-point bg-blue" onclick="tablediv(hid_sub_id.value,2);"><i class="fas fa-folder-open"></i>&nbsp; NEW </button>
              
            </div> <!-- end of col4 --> 
            <div class="col-4 p-1">
              <button type="button" class="btn btn-block btn-flat btn-point bg-mediumorchid"  onclick="tablediv(hid_sub_id.value,3);"><i class="fas fa-folder-minus"></i>&nbsp; REPRINT </button>
              
            </div> <!-- end of col4 -->
          </div> <!-- end of inner row -->


          <div class="row no-gutters p-1" id="click_btn_all" style="display: none;">
            <div class="col-4 p-1">
              <input type="hidden" name="hid_sub_id" id="hid_sub_id" value="">
              <button type="button" class="btn btn-block btn-flat btn-point bg-blue" onclick="tablediv(hid_sub_id.value,1);"><i class="fas fa-file-archive"></i>&nbsp; ALL </button>
            </div> <!-- end of col4 --> 
            <div class="col-4 p-1">
             
              <button type="button" class="btn btn-block btn-flat btn-point bg-mediumorchid"  onclick="tablediv(hid_sub_id.value,2);" ><i class="fas fa-folder-open"></i>&nbsp; NEW </button>
            </div> <!-- end of col4 --> 
            <div class="col-4 p-1">
              <button type="button" class="btn btn-block btn-flat btn-point bg-mediumorchid" onclick="tablediv(hid_sub_id.value,3);"><i class="fas fa-folder-minus"></i>&nbsp; REPRINT </button>
              
            </div> <!-- end of col4 -->
          </div> <!-- end of inner row -->

          <div class="row no-gutters p-1" id="click_btn_rep" style="display: none;">
            <div class="col-4 p-1">
              <input type="hidden" name="hid_sub_id" id="hid_sub_id" value="">
              <button type="button" class="btn btn-block btn-flat btn-point bg-mediumorchid" onclick="tablediv(hid_sub_id.value,1);"><i class="fas fa-file-archive"></i>&nbsp; ALL </button>
                          </div> <!-- end of col4 --> 
            <div class="col-4 p-1">
             <button type="button" class="btn btn-block btn-flat btn-point bg-mediumorchid" onclick="tablediv(hid_sub_id.value,2);" ><i class="fas fa-folder-open"></i>&nbsp; NEW </button>
            </div> <!-- end of col4 --> 
            <div class="col-4 p-1">
              
              <button type="button" class="btn btn-block btn-flat btn-point bg-blue" onclick="tablediv(hid_sub_id.value,3);"><i class="fas fa-folder-minus"></i>&nbsp; REPRINT </button>
            </div> <!-- end of col4 -->
          </div> <!-- end of inner row -->

        </div> <!-- end of cardbody -->
      </div> <!-- end of card -->
    </div>  <!-- end of col12 -->
  </div> <!-- end of second row -->
  <div class="row no-gutters p-1" id="print_result_div" style="display: none;">
    <div class="col-12 p-1 d-flex justify-content-end" >
        <button type="button" class="btn btn-sm btn-flat btn-point bg-firebrick" onclick="print_all();"><i class="fas fa-file-archive"></i>&nbsp; PRINT ALL</button> &nbsp; 
     </div> <!-- end of col12 -->
    <div class="col-12 p-1">
      <div class="alert bg-darkslateblue" role="alert">
        Print Number Plate - New Requests
      </div>
    </div> <!-- end of col12 -->
    <div class="col-12 table-responsive">  
      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
          <th><input type="checkbox" id="checkAll" name="checkAll"/> All</th>
          <th>Sl No</th>
          <th>KIV Number</th>
          <th>Request time</th>
          <th>Port of Registry</th>
          <th>Vessel Name</th>
          <th>Owner Name</th>
          <th>Print</th>
        </thead>
        <tbody>
          <?php //print_r($vessel_reg);
          $k=1;
          foreach ($vessel_reg as $vessel_reg_res) {
            $vessel_id = $vessel_reg_res['vesselmain_vessel_id'];
            $kiv_no    = $vessel_reg_res['vesselmain_reg_number'];
            $port      = $vessel_reg_res['vchr_portoffice_name'];
            $name      = $vessel_reg_res['vesselmain_vessel_name'];
            $owner     = $vessel_reg_res['user_master_fullname'];
            $idenc     = $this->encrypt->encode($vessel_id); 
            $vslidenc  = str_replace(array('+', '/', '='), array('-', '_', '~'), $idenc);
          ?>
          <tr>
            <td ><input type="checkbox" name="check_id[]" id="check_id" value="<?php echo $vessel_id;?>"></td>
            <td><?php echo $k;?></td>
            <td><?php echo $kiv_no;?></td>
            <td></td>
            <td><?php echo $port;?></td>
            <td><?php echo $name;?></td>
            <td><?php echo $owner;?></td>
            <td><a href="<?php echo site_url("Print_Ctrl/Print_Ctl/print_number/$vslidenc");?>"><i class="fas fa-print"></i></a></td>
          </tr>
          <?php 
          $k++;
          }?>
        </tbody>
      </table> 
    </div> <!-- end of col12 -->
  </div>  <!-- end of row -->
  <?php 
  //$attributes = array("class" => "form-horizontal", "id" => "print_report_list", "name" => "print_report_list" , "novalidate");
    //echo form_open("Print_Ctrl/Print_Ctl/Vw_print_report", $attributes);?>
  <div class="row no-gutters p-1" id="report_result_div" style="display: none;">
    
  <div class="col-12 text-center">
      <div class="alert bg-darkslateblue" role="alert">
        Print Report Details
      </div> <!-- end of alert -->
  </div> <!-- end of col10 -->
  <div class="col-12 text-center py-1">
    <div class="row no-gutters px-1 pt-1 pb-1 justify-content-center bg-gray">
    <div class="col-2 pt-3 text-darkmagenta">
    From Date
    </div> <!-- end of col-3 -->
    <div class="col-3 py-2">
    <div class="input-group port-content-noborder">
    <input type="date" class="form-control dob" placeholder="" name="from_date" id="from_date" aria-label="Fromdate" aria-describedby="basic-addon2" required="required" value="<?php if(isset($_POST['start'])){echo $_POST['start'];}else{echo date('Y-m-d', strtotime('-30 days'));}?>">
    <div class="input-group-append">
                  </div>
    </div> <!-- end of input group -->
    </div> <!-- end of col-3 -->
    <div class="col-2 pt-3 text-darkmagenta">
    To Date
    </div> <!-- end of col-3 -->
    <div class="col-3 py-2">
    <div class="input-group port-content-noborder">
    <input type="date" class="form-control dob" placeholder="" name="to_date" id="to_date" aria-label="Todate" aria-describedby="basic-addon2" required="required" value="<?php if(isset($_POST['end'])){echo $_POST['end'];}else{echo date('Y-m-d');}?>">
    <div class="input-group-append">

    </div>
    </div> <!-- end of input group -->
    </div> <!-- end of col-3 -->
    <div class="col-2 text-center py-2"><input type="hidden" name="portofregistry_id" id="portofregistry_id" value="<?php //echo $user_master_port_id ?>">
    <button type="button" name="Vw_print_report" id="Vw_print_report" class="btn btn-point btn-flat bg-darkmagenta"> <i class="fas fa-money-check"></i> &nbsp; View</button>
    </div>  <!-- end of col12 -->
    </div> <!-- end of inner row 1-->
  
</div>
    <div class="col-12 p-1 d-flex justify-content-end" >
      <input type="hidden" name="from" id="from" value="<?php if(isset($_POST['start'])){echo $_POST['start'];}?>">
  <input type="hidden" name="to" id="to" value="<?php if(isset($_POST['start'])){echo $_POST['end'];}?>">
  <input type="hidden" name="id" id="id" value="<?php if(isset($_POST['id'])){echo $_POST['id'];}?>">
  <input type="hidden" name="val" id="val" value="<?php if(isset($_POST['val'])){ echo $_POST['val'];}?>">
        <!-- <button type="button" name="excel_btn" id="excel_btn" class="btn btn-sm btn-flat btn-point bg-mediumorchid"><i class="fas fa-file-archive"></i>&nbsp; EXCEL</button> --> 
    <?php 
        $fromdtenc = $this->encrypt->encode(date('Y-m-d', strtotime('-30 days'))); 
        $fromdtencd= str_replace(array('+', '/', '='), array('-', '_', '~'), $fromdtenc);
        $todtenc   = $this->encrypt->encode(date('Y-m-d')); 
        $todtencd  = str_replace(array('+', '/', '='), array('-', '_', '~'), $todtenc);
        $idenc     = $this->encrypt->encode(2); 
        $idencd    = str_replace(array('+', '/', '='), array('-', '_', '~'), $idenc);
        $valenc    = $this->encrypt->encode(217); 
        $valencd   = str_replace(array('+', '/', '='), array('-', '_', '~'), $valenc);

    ?>
        <a href="<?php echo base_url();?>index.php/Print_Ctrl/Print_Ctl/generate_excel/<?php echo $fromdtencd;?>/<?php echo $todtencd;?>/<?php echo $idencd;?>/<?php echo $valencd;?>" name="excel_btn" id="excel_btn" class="btn btn-sm btn-flat btn-point bg-firebrick"><i class="fas fa-file-archive"></i>&nbsp; EXCEL</a>&nbsp; 
     </div> <!-- end of col12 -->
    <div class="col-12 p-1"  >
      <div class="alert bg-darkslategray" role="alert">
        Report Details - New Requests
      </div>
     </div> <!-- end of col12 -->
     <div class="col-12 table-responsive">
       <table id="example2" class="table table-bordered table-striped table-hover">
        <thead>
          <th>#</th>
          <th>KIV Number</th>
          <th>Request time</th>
          <th>Port of Registry</th>
          <th>Vessel Name</th>
          <th>Owner Name</th>
        </thead>
        <tbody>
          <?php //print_r($vessel_reg);
          $j=1;
          foreach ($vessel_reg_rep as $vessel_reg_res) {
            $vessel_id = $vessel_reg_res['vesselmain_vessel_id'];
            $kiv_no   = $vessel_reg_res['vesselmain_reg_number'];
            $port     = $vessel_reg_res['vchr_portoffice_name'];
            $name     = $vessel_reg_res['vesselmain_vessel_name'];
            $owner    = $vessel_reg_res['user_master_fullname'];
          ?>
          <tr>
            <td><?php echo $j;?></td>
            <td><?php echo $kiv_no;?></td>
            <td></td>
            <td><?php echo $port;?></td>
            <td><?php echo $name;?></td>
            <td><?php echo $owner;?></td>
          </tr>
          <?php 
          $j++;
          }?>
        </tbody>
      </table> 
    </div> <!-- end of col12 -->
  </div>  <!-- end of row -->
  <?php //echo form_close();?>
  <div class="row no-gutters p-1" id="result_ajax_div" style="display: none;">
  </div>
</div> <!-- end of main-content -->