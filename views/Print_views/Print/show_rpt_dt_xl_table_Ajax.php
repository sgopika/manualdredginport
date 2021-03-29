<?php 
if($val!=''){
  if($val==216){
?>
 <div class="col-12 p-1 d-flex justify-content-end" >
        <button type="button" class="btn btn-sm btn-flat btn-point bg-firebrick" onclick="print_all();"><i class="fas fa-file-archive"></i>&nbsp; PRINT ALL</button> &nbsp; 
     </div> <!-- end of col12 -->
    <div class="col-12 p-1"  >
      <table id="example3" class="table table-bordered table-striped table-hover">
       <div class="alert bg-darkslateblue" role="alert"><?php if($id==1){?>All<?php } else if($id==2){?>New <?php } else if($id==3){?>Reprint<?php } ?> Requests</div>
        <thead>

          <th>#</th>
          <th>KIV Number</th>
          <th>Request time</th>
          <th>Port of Registry</th>
          <th>Vessel Name</th>
          <th>Owner Name</th>
          <th>Print</th>
        </thead>
        <tbody>
          <?php //print_r($vessel_reg);
          $l=1;
          foreach ($vessel_det as $vessel_det_res) {
            $vessel_id = $vessel_det_res['vesselmain_vessel_id'];
            $kiv_no   = $vessel_det_res['vesselmain_reg_number'];
            $port     = $vessel_det_res['vchr_portoffice_name'];
            @$reqtime     = $vessel_det_res['reprint_reqtimestamp'];
            $name     = $vessel_det_res['vesselmain_vessel_name'];
            $owner    = $vessel_det_res['user_master_fullname'];
            $idenc     = $this->encrypt->encode($vessel_id); 
            $vslidenc  = str_replace(array('+', '/', '='), array('-', '_', '~'), $idenc);
          ?>
          <tr>
            <td><?php echo $l;?>
              <input type="checkbox"  name="check_id[]" id="check_id" value="<?php echo $vessel_id;?>">
            </td>
            <td><?php echo $kiv_no;?></td>
            <td><?php if($id==3) {echo $reqtime;}?></td>
            <td><?php echo $port;?></td>
            <td><?php echo $name;?></td>
            <td><?php echo $owner;?></td>
            <td><a href="<?php echo site_url("Print_Ctrl/Print_Ctl/print_number/$vslidenc");?>"><i class="fas fa-print"></i></a></td>
          </tr>
          <?php 
          $l++;
          }?>
        </tbody>

      </table> 
    </div> <!-- end of col12 -->

<?php } else if($val==217){?>
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
    <input type="date" class="form-control dob" placeholder="" name="from_date2" id="from_date2" aria-label="Fromdate" aria-describedby="basic-addon2" required="required" value="<?php if(isset($_POST['start'])){echo $_POST['start'];}else{echo date('Y-m-d', strtotime('-30 days'));}?>">
    <div class="input-group-append">
                  </div>
    </div> <!-- end of input group -->
    </div> <!-- end of col-3 -->
    <div class="col-2 pt-3 text-darkmagenta">
    To Date
    </div> <!-- end of col-3 -->
    <div class="col-3 py-2">
    <div class="input-group port-content-noborder">
    <input type="date" class="form-control dob" placeholder="" name="to_date2" id="to_date2" aria-label="Todate" aria-describedby="basic-addon2" required="required" value="<?php if(isset($_POST['end'])){echo $_POST['end'];}else{echo date('Y-m-d');}?>">
    <div class="input-group-append">

    </div>
    </div> <!-- end of input group -->
    </div> <!-- end of col-3 -->
    <div class="col-2 text-center py-2"><input type="hidden" name="portofregistry_id" id="portofregistry_id" value="<?php //echo $user_master_port_id ?>">
      <input type="hidden" name="hid_id" id="hid_id" value="<?php echo $id;?>">
      <input type="hidden" name="hid_val" id="hid_val" value="<?php echo $val;?>">
    <button type="button" name="Vw_print_report2" id="Vw_print_report2" class="btn btn-point btn-flat bg-darkmagenta"> <i class="fas fa-money-check"></i> &nbsp; View</button>
    </div>  <!-- end of col12 -->
    </div> <!-- end of inner row 1-->
  
</div>
  <div class="col-12 p-1 d-flex justify-content-end" >
  <input type="hidden" name="from1" id="from1" value="<?php if(isset($_POST['start'])){echo $_POST['start'];}?>">
  <input type="hidden" name="to1" id="to1" value="<?php if(isset($_POST['end'])){echo $_POST['end'];}?>">
  <input type="hidden" name="id1" id="id1" value="<?php echo $_POST['id'];?>">
  <input type="hidden" name="val1" id="val1" value="<?php echo $_POST['val'];?>">
        <!-- <button type="button" name="excel_btn2" id="excel_btn2" class="btn btn-sm btn-flat btn-point bg-mediumorchid"><i class="fas fa-file-archive"></i>&nbsp; EXCEL</button> --> &nbsp;

        <?php 
        $fromdtenc = $this->encrypt->encode($_POST['start']); 
        $fromdtencd= str_replace(array('+', '/', '='), array('-', '_', '~'), $fromdtenc);
        $todtenc   = $this->encrypt->encode($_POST['end']); 
        $todtencd  = str_replace(array('+', '/', '='), array('-', '_', '~'), $todtenc);
        $idenc     = $this->encrypt->encode($_POST['id']); 
        $idencd    = str_replace(array('+', '/', '='), array('-', '_', '~'), $idenc);
        $valenc    = $this->encrypt->encode($_POST['val']); 
        $valencd   = str_replace(array('+', '/', '='), array('-', '_', '~'), $valenc);

    ?>
        <a href="<?php echo base_url();?>index.php/Print_Ctrl/Print_Ctl/generate_excel/<?php echo $fromdtencd;?>/<?php echo $todtencd;?>/<?php echo $idencd;?>/<?php echo $valencd;?>" name="excel_btn2" id="excel_btn2" class="btn btn-sm btn-flat btn-point bg-firebrick"><i class="fas fa-file-archive"></i>&nbsp; EXCEL</a>&nbsp;  
     </div> <!-- end of col12 -->
    <div class="col-12 p-1"  >
      <table id="example4" class="table table-bordered table-striped table-hover">
        <div class="alert bg-darkslateblue" role="alert">Report Details - <?php if($id==1){?>All<?php } else if($id==2){?>New <?php } else if($id==3){?>Reprint<?php } ?> Requests</div>
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
          $m=1;
          foreach ($vessel_reg_rep as $vessel_det_res) {
            $vessel_id = $vessel_det_res['vesselmain_vessel_id'];
            $kiv_no   = $vessel_det_res['vesselmain_reg_number'];
            @$reqtime     = $vessel_det_res['reprint_reqtimestamp'];
            $port     = $vessel_det_res['vchr_portoffice_name'];
            $name     = $vessel_det_res['vesselmain_vessel_name'];
            $owner    = $vessel_det_res['user_master_fullname'];
          
          ?>
          <tr>
            <td><?php echo $m;?></td>
            <td><?php echo $kiv_no;?></td>
            <td><?php if($id==3) {echo $reqtime;}?></td>
            <td><?php echo $port;?></td>
            <td><?php echo $name;?></td>
            <td><?php echo $owner;?></td>
            
          </tr>
          <?php 
          $m++;
          }?>
        </tbody>

      </table> 
    </div> <!-- end of col12 -->

<?php } } else {?>
<div class="col-12 p-1" >No Datas Found</div>
 <?php }?> 
 <script type="text/javascript">
  $(document).ready(function() {
    $('#example3').DataTable({
      "oLanguage": { "sSearch": "" } 
    });
    $('#example4').DataTable({
      "oLanguage": { "sSearch": "" } 
    });
   }); 
  $("#Vw_print_report2").click(function(){ 
    
    var start = $("#from_date2").val();  
    var end   = $("#to_date2").val(); 
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

  $("#excel_btn2").click(function(){ 
  	var from_dt = $("#from1").val();
     var to_dt   = $("#to1").val();
     var id      = $("#id1").val();
     var val     = $("#val1").val();

     $.ajax({
      url : "<?php echo site_url('Print_Ctrl/Print_Ctl/generate_excel/')?>",
      type: "POST",
      data:{ from_dt:from_dt, to_dt:to_dt, id:id, val:val},
      success: function(data)
      {
        //alert(data);exit;
       // window.open('<?php echo site_url('Print_Ctrl/Print_Ctl/generate_excel/'); ?>','_blank');
      } 

    });

  });
 </script>