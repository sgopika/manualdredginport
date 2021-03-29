
<?php
$vessel_sl1                 = $this->uri->segment(4);
$processflow_sl1            = $this->uri->segment(5);
$status_details_sl1         = $this->uri->segment(6);

$vessel_sl                  = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_sl1);
$vessel_sl                  = $this->encrypt->decode($vessel_sl); 

$processflow_sl             = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl             = $this->encrypt->decode($processflow_sl); 

$status_details_sl          = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl          = $this->encrypt->decode($status_details_sl); 

foreach ($vesselDet as $vesselDetails) 
{
   $vessel_registry_port_id = $vesselDetails['vessel_registry_port_id'];
}

$vessel_details             = $this->Vessel_change_model->get_process_flow($processflow_sl); //print_r($vessel_details);
$data['vessel_details']     = $vessel_details;
if(!empty($vessel_details))
{
  $process_id               = 39;//$vessel_details[0]['process_id'];
  $current_status_id        = $vessel_details[0]['current_status_id'];
  $current_position         = $vessel_details[0]['current_position'];
  $user_id                  = $vessel_details[0]['user_id'];
}

?>
<script>
$(function($) {
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    }); 
});
</script>


<!-- <div class="alert alert-primary" role="alert"> -->
<!-- Start of breadcrumb -->
<nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/form12List">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row ui-innerpage">
    <div class="col-12"> 
      <div class="row">
        <div class="col-2 mt-1 ml-5">
          <button type="button" class="btn btn-primary kivbutton btn-block"> Form --</button> 
        </div> <!-- end of col-2 -->
        <div class="col mt-2 text-primary">
          Request for Ownership Change of Registered Vessel 
        </div>
      </div> <!-- inner row -->
    </div> <!-- end of col-12 add-button header --> 
    <div class="col-12 mt-2 ml-2 newfont">
<!--__________________________________________________________________________-->
      <div id="form12show">
        <div class="row no-gutters">
          <div class="col-12 ">
            <div class="table-responsive">
            </div> <!-- end of table div -->
          </div> <!--end of col12 -->
        </div> <!--end of row -->

        <form name="form11" id="form11" method="post"  enctype="multipart/form-data" action="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/pay_now_form18/'.$vessel_sl1.'/'.$processflow_sl1.'/'.$status_details_sl1 ?>">

          <div class="row no-gutters headrow text-white border-bottom">
            <div class="col-12 mt-1 mb-1 pl-2 formfont">
            Payment process 
              
            </div> <!-- end of col-12 heading -->
          </div> <!-- end of row -->
          <div class="row no-gutters evenrow border-bottom">
            <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
            Port of registry
            </div> <!-- end of col-3 1st-->
            <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
              <select class="form-control select2 " name="portofregistry_sl" id="portofregistry_sl"  title="" data-validation="required">
                <option value="">Select</option>
                <?php   foreach ($portofregistry as $res_portofregistry)
                {
                ?>
                <option value="<?php echo $res_portofregistry['int_portoffice_id']; ?>"><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
                <?php    }    ?>
              </select>
            </div> <!-- end of col-3 2nd-->
            <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
            </div> <!-- end of col-3 3rd-->
            <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
            </div> <!-- end of col-3 4th-->
          </div> <!-- end of row -->

          <div class="row no-gutters evenrow border-bottom">
            <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
            Bank
            </div> <!-- end of col-3 1st-->
            <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
              <select class="form-control select2 " name="bank_sl" id="bank_sl"  title="" data-validation="required">
                <option value="">Select</option> 
                <?php   foreach ($bank as $res_bank)
                {
                ?>
                <option value="<?php echo $res_bank['bank_sl'];?>" ><?php echo $res_bank['bank_name'];?>  </option>
                <?php    }    ?>
              </select>
            </div> <!-- end of col-3 2nd-->
            <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
            </div> <!-- end of col-3 3rd-->
            <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
            </div> <!-- end of col-3 4th-->
          </div> <!-- end of row -->
      </div> <!-- end of formshowdiv -->

      <div id="form12pay">
        <div class="row no-gutters  mx-0 mt-5 mb-5">
          <div class="col-6 d-flex justify-content-end pr-5">
            <button type="button" class="btn btn-success btn-flat btn-point btn-lg" name="pay_now" id="pay_now"> <i class="fas fa-rupee-sign"></i> &nbsp;&nbsp;&nbsp;Pay now</button> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-primary btn-flat btn-point btn-lg" name="pay_later" id="pay_later"> <i class="fas fa-rupee-sign"></i> &nbsp;&nbsp;&nbsp;Pay Later</button>     
       
            <input type="hidden" value="<?php echo $vessel_sl; ?>" id="vessel_sl" name="vessel_sl">
            <input type="hidden" value="<?php echo $processflow_sl; ?>" id="processflow_sl" name="processflow_sl">
            <input type="hidden" value="<?php echo $status_details_sl; ?>" id="status_details_sl" name="status_details_sl">
            <input type="hidden" value="<?php echo $process_id; ?>" id="process_id" name="process_id">
            <input type="hidden" value="<?php echo $current_status_id; ?>" id="current_status_id" name="current_status_id">
            <input type="hidden" value="<?php echo $current_position; ?>" id="current_position" name="current_position">
            <input type="hidden" value="<?php echo $user_id; ?>" id="user_id" name="user_id">
          </div>
        </div>
      </div> <!-- end of form12pay -->
      <?php  //echo form_close(); ?>
      <div class="row no-gutters mx-0 mt-2" id="payment">
      </div>
      <div class="row mx-0 mb-3 no-gutters eventab" id="submitbtn">
        <div class="col-10"></div>
        <div class="col-1 d-flex justify-content-end">
        </div> 
        <!-- <div class="col-1 d-flex justify-content-end"> -->
        <div>
          <button type="submit" class="btn btn-primary btn-flat  btn-point btn-md" name="tab8next" id="tab8next" ><i class="far fa-save"></i>&nbsp;&nbsp;Save &amp; Proceed</button>
          <button type="button" class="btn btn-success btn-flat  btn-point btn-md" name="btnsubmit" id="btnsubmit" ><i class="far fa-save"></i>&nbsp;Submit</button>
        </div>
      </div>
      </form>
<!--__________________________________________________________________________-->
    </div>
  </div> <!-- end of main row -->
</div> <!-- end of container div -->

<!--<script src="http://192.168.2.158/kiv_port/assets/js/jquery.validate.js"></script> 
<script src="http://192.168.2.158/kiv_port/assets/J_Validation/jquery.form-validator.js"></script>
 <script src="http://192.168.2.158/kiv_port/assets/plugins/js/inputmask.js"></script>  -->

<script language="javascript">
    
$(document).ready(function(){
$("#portshow").hide();
$("#bankshow").hide();

$("#payment").hide();
$("#tab8next").hide(); //proceed
$("#btnsubmit").hide(); //submit
$("#pay_now").click(function()
{

  var vessel_id=$("#vessel_sl").val(); //alert(vessel_id);
 //if($("#form8").isValid())
 // { 
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/VesselChange/showpayment18/')?>"+vessel_id,
      type: "POST",
      data:$('#form11').serialize(),
      //dataType: "JSON",
      success: function(data)
      { //alert(data);exit;
       $("#portshow").show();
       $("#bankshow").show();
       
        $("#payment").show();
       $("#tab8next").show(); //proceed
        $("#btnsubmit").hide(); //submit

//alert(data);
        $("#payment").html(data).find(".select2").select2();
        
      }
    }); 
}); 
$("#pay_later").click(function()
{

 //if($("#form8").isValid())
 // { 
$("#portshow").hide();  
$("#bankshow").hide(); 
$("#payment").hide();
$("#tab8next").hide(); //proceed
$("#btnsubmit").show(); //submit
//}

}); 
$("#btnsubmit").click(function()
{
  var vessel_id=$("#vessel_sl").val(); //alert(vessel_id);
  // if($("#form11").isValid())
  // { 
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/VesselChange/not_payment_details_form18')?>",
      type: "POST",
      data:$('#form11').serialize(),
      //dataType: "JSON",
      success: function(data)
      {//alert(data);exit;
        
        alert("Please pay fees later");
        window.location.href = "<?php echo site_url('Kiv_Ctrl/Survey/SurveyHome'); ?>";
      }
    }); 
  //}
});
});
</script>