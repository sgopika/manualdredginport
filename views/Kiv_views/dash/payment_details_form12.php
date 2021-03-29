
<?php
$vessel_sl1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$status_details_sl1 = $this->uri->segment(6);

$vessel_sl          =   str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_sl1);
$vessel_sl     =   $this->encrypt->decode($vessel_sl); 

$processflow_sl     =   str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl     =   $this->encrypt->decode($processflow_sl); 

$status_details_sl  =   str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl  =   $this->encrypt->decode($status_details_sl); 

 foreach ($vesselDet as $vesselDetails) 
{
   $vessel_registry_port_id=$vesselDetails['vessel_registry_port_id'];
}

$vessel_details       =   $this->Survey_model->get_process_flow($processflow_sl);
  $data['vessel_details']   = $vessel_details;
  if(!empty($vessel_details))
  {
    $process_id         = $vessel_details[0]['process_id'];
    $current_status_id  = $vessel_details[0]['current_status_id'];
    $current_position   = $vessel_details[0]['current_position'];
    $user_id            = $vessel_details[0]['user_id'];
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
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/form12List">List Page</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row ui-innerpage">
  <div class="col-12"> 
    <div class="row">
      <div class="col-2 mt-1 ml-5">
         <button type="button" class="btn btn-primary kivbutton btn-block"> Form 12</button> 
      </div> <!-- end of col-2 -->
      <div class="col mt-2 text-primary">
        Application for registration 
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



<!-- <form name="form12" id="form12" method="post"  enctype="multipart/form-data" action="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/pay_now_form12/'.$vessel_sl1.'/'.$processflow_sl1.'/'.$status_details_sl1 ?>"> -->
 

<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Bookofregistration/pay_now_form12/".$vessel_sl1.'/'.$processflow_sl1.'/'.$status_details_sl1, $attributes);
  ?>


<div class="row no-gutters eventab">
<div class="col-3 px-2 py-2">Port of Registry</div>

<div class="col-3 px-2 py-2"> 
   <select class="form-control select2" name="portofregistry_sl" id="portofregistry_sl" title="Select  Plying Port of Registry" data-validation="required">
        <option value="">Select</option>
        <?php foreach ($plyingPort as $plyPort) { ?>
          <option value="<?php echo $plyPort['int_portoffice_id']; ?>" <?php //if($vessel_registry_port_id==$plyPort['portofregistry_sl'] ){ echo "selected";}?>><?php echo $plyPort['vchr_portoffice_name']; ?></option>
        <?php } ?>
    </select>
 </div>

<div class="col-3 px-2 py-2"> Bank</div>
<div class="col-3 px-2 py-2">  <select class="form-control select2 " name="bank_sl" id="bank_sl"  title="" data-validation="required">
  <option value="">Select</option> 
  <?php   foreach ($bank as $res_bank)
  {
  ?>
  <option value="<?php echo $res_bank['bank_sl'];?>" ><?php echo $res_bank['bank_name'];?>  </option>
  <?php    }    ?>
  </select>  </div> 



</div> <!-- end of row -->

<div class="row no-gutters eventab">
<div class="col-3 px-2 py-2">Tariff amount </div>

<div class="col-3 px-2 py-2"> <input type="text" class="form-control" value="<?php echo $tariff_amount; ?>" id="dd_amount" name="dd_amount" readonly>
  
 </div>

<div class="col-3 px-2 py-2">  </div>
<div class="col-3 px-2 py-2">  </div> 
</div> <!-- end of row -->






</div> <!-- end of formshowdiv -->

<div id="form12pay">
  <div class="row no-gutters  mx-0 mt-5 mb-5">
<div class="col-6 d-flex justify-content-end pr-5">

 <button type="submit" class="btn btn-success btn-flat btn-point btn-lg" name="pay_now" id="pay_now"> <i class="fas fa-rupee-sign"></i> &nbsp;&nbsp;&nbsp;Pay now</button> 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <!--  <button type="button" class="btn btn-primary btn-flat btn-point btn-lg" name="pay_later" id="pay_later"> <i class="fas fa-rupee-sign"></i> &nbsp;&nbsp;&nbsp;Pay Later</button>    -->
 
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
 <!-- </form> --> <?php echo form_close(); ?>

<!--__________________________________________________________________________-->
</div>
</div> <!-- end of main row -->
</div> <!-- end of container div -->

<!--<script src="http://192.168.2.158/kiv_port/assets/js/jquery.validate.js"></script> 
<script src="http://192.168.2.158/kiv_port/assets/J_Validation/jquery.form-validator.js"></script>
 <script src="http://192.168.2.158/kiv_port/assets/plugins/js/inputmask.js"></script>  -->

<script language="javascript">
    
$(document).ready(function(){

/*$("#pay_now").click(function()
{

  if($("#form12").isValid())
  {
    $.ajax({
    url : "<?php echo site_url('Bookofregistration/pay_now_form12')?>",
    type: "POST",
    //dataType: "JSON",
    data:$('#form12').serialize(),
    success: function(data)
    {
      alert("Payment Details inserted Successfully");
        window.location.href = "<?php echo site_url('Survey/SurveyHome'); ?>";
      }
    });
  }
}); */
});
</script>