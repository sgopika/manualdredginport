<script language="javascript">

function IsNumeric(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
  {
    return true;
  }
  else 
  {
    window.alert("This field accepts only Numbers");
    return false;
  }
}
function validateEmail(email) {
 
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test( email ) ) {
    alert("Invalid Email");
    document.getElementById('newowner_mail').value='';
      return false;
  } else {
      return true;
  }
}
</script>
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
<script language="javascript">
    
$(document).ready(function(){

  $("#btnsubmit").click(function()
  { 
      var regex           = new RegExp("^[a-zA-Z][a-zA-Z0-9]+$");
      var regexname       = new RegExp("^[a-zA-Z\ \-]+$");
      var regexnum        = new RegExp("^[0-9]+$");

      var newvesselname   = $('#newvesselname').val();
      if(newvesselname=="")
      {
        alert("New Vessel Name Required");
        $("#newvesselname").focus();
        return false;
      }
      else if (regexname.exec(newvesselname) == null) 
      {
        alert("Only alphabets,space and - allowed in New Vessel Name.");
        $("#newvesselname").val(''); 
        $("#newvesselname").focus();
        return false;
      }
  }); 

});
  </script>

<!-- <div class="alert alert-primary" role="alert"> -->
<!-- Start of breadcrumb -->
<nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/VesselChange/ownershipChange_list">List Page</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row">
    <div class="col-12"> 
      <div class="row">
        <div class="col-2 mt-1 ml-5">
          <button type="button" class="btn btn-primary kivbutton btn-block"> Form --</button> 
        </div> <!-- end of col-2 -->
        <div class="col mt-2 text-primary">
          Ownership Change for Registered Vessels 
        </div>
      </div> <!-- inner row -->
    </div> <!-- end of col-12 add-button header --> 
    <div class="col-12 mt-2 ml-2 newfont">
    <!--__________________________________________________________________________-->
      <div id="form12show">
        <div class="row no-gutters">
          <div class="col-12 ">
            <div class="table-responsive">
              <table class="table table-hover">
              <tbody>
    <?php 
    //print_r($vesselDet); 
    foreach ($vesselDet as $vesselDetails) 
    {

      $vessel_sl					       =  $vesselDetails['vessel_sl'];
      $vessel_survey_number			 =  $vesselDetails['vessel_survey_number'];
      $vessel_name					     =  $vesselDetails['vessel_name'];
      $reference_number				   =  $vesselDetails['reference_number'];
      $build_date					       =  $vesselDetails['build_date'];
      $vessel_registry_port_id	 =  $vesselDetails['vessel_registry_port_id'];
      $vessel_total_tonnage			 =  $vesselDetails['vessel_total_tonnage'];
      $vessel_registration_number=  $vesselDetails['vessel_registration_number'];
      $vessel_expected_completion=  $vesselDetails['vessel_expected_completion'];
      
    }

    $user_details=$this->Bookofregistration_model->get_user_id($vessel_sl);
    $data['user_details']=$user_details;
    if(!empty($user_details))
    {
      	$id=$user_details[0]['user_id'];
      	$customer_details=$this->Bookofregistration_model->get_customer_details($id);
    	  $data['customer_details']=$customer_details;

        if(!empty($customer_details))
        {
          foreach($customer_details as $res_customer)
          {
            $user_name      =   $res_customer['user_name'];
            $user_address   =   $res_customer['user_address'];
          }
        } 

    }
    else

    {
      $user_name      =   "";
      $user_address   =   "";
    }

    $survey_id=1;
    $engine_details=  $this->Survey_model->get_engine_details($vessel_sl,$survey_id);
    $data['engine_details']  = $engine_details;


if(!empty($engine_details)) 
{
  foreach($engine_details as $key_engine)
  {
    $engine_type_id = $key_engine['engine_type_id'];
    $bhp1[]         = $key_engine['bhp'];
    $make_year1[]   = $key_engine['make_year'];

    $engine_type         =   $this->Survey_model->get_enginetype_name($engine_type_id);
    $data['engine_type'] =   $engine_type;
    $engine_type_name1[] =   $engine_type[0]['enginetype_name'];

  }
  $bhp=implode(", ", $bhp1);
  $make_year=implode(", ", $make_year1);
  $engine_type_name=implode(", ", $engine_type_name1);
}


$vessel_sl1 = $this->encrypt->encode($vessel_sl); 
$vessel_sl2=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_sl1);

$status_details_sl1 = $this->encrypt->encode($status_details_sl); 
$status_details_sl2=str_replace(array('+', '/', '='), array('-', '_', '~'), $status_details_sl1);

$processflow_sl1 = $this->encrypt->encode($processflow_sl); 
$processflow_sl2=str_replace(array('+', '/', '='), array('-', '_', '~'), $processflow_sl1);

    ?>

    <tr>
      <td>Survey number</td>
      <td><?php echo $vessel_survey_number; ?></td>
      <td>Engine Make</td>
      <td><?php echo $engine_type_name?></td>
    </tr>
    <tr>
      <td>Vessel Name</td>
      <td><?php echo $vessel_name; ?></td>
      <td>BHP</td>
      <td><?php echo $bhp; ?></td>
    </tr>
    <tr>
      <td>Reference Number</td>
      <td><?php echo $reference_number; ?></td>
      <td>Tariff for Registration</td>
      <td>Rs. <?php echo $tariff_amount; ?></td>
    </tr>
    <tr>
      <td>Year of Make</td>
      <td><?php echo $make_year; ?></td>
      <td>Registration Number</td>
      <td><?php echo $vessel_registration_number; ?></td>
    </tr>
<?php $cnt=count($vesselDet);  ?>
    
  </tbody>
</table>
    </div> <!-- end of table div -->
  </div> <!--end of col12 -->
</div> <!--end of row -->
<?php 
  //  $attributes = array("class" => "form-horizontal", "id" => "form12", "name" => "form12" , "novalidate");    
    //echo form_open_multipart("Bookofregistration/form12", $attributes);
?>
<form name="form12" id="form12" method="post"  enctype="multipart/form-data" action="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/payment_details_form18/'.$vessel_sl2.'/'.$processflow_sl2.'/'.$status_details_sl2 ?>">
  


<div class="row no-gutters eventab">
  <div class="col-3 px-2 py-2"> Mobile Number of New Owner</div>
  <div class="col-3 px-2 py-2"> 
    <input type="text" class="form-control" id="newowner_mob" name="newowner_mob" placeholder="Mobile number of New Owner" data-validation="required number" onkeypress="return IsNumeric(event);" required="required" maxlength="11">
  </div>
</div> <!-- end of row -->
<div class="row no-gutters eventab">
  <div class="col-3 px-2 py-2">Email ID of New Owner</div>
  <div class="col-3 px-2 py-2"> 
    <input type="text" class="form-control" id="newowner_mail" name="newowner_mail" placeholder="Email ID of New Owner" data-validation="required" onchange="return validateEmail(this.value);" required="required" >
  </div><!-- <input type="button" class="btn btn-success btn-flat btn-point btn-sm" name="btnverify" value="Verify" id="btnverify"> --><div class="col-3 px-2 py-2">
    <button type="button" class="btn btn-primary btn-flat btn-sm" name="btnverify" id="btnverify"> <i class="fas fa-check"></i><small> Verify </small></button></div>
</div> <!-- end of row -->
<div id="existowner_div" style="display: none;">
  
</div>  

</div> <!-- end of formshowdiv -->


<div id="form12pay" style="display: none;">
  <div class="row no-gutters  mx-0 mt-5 mb-5">
    <div class="col-6 d-flex justify-content-end pr-5" >
      <input type="submit" class="btn btn-success btn-flat btn-point btn-lg" name="btnsubmit" value="Submit" id="btnsubmit">&nbsp;&nbsp;&nbsp;  
 
     <input type="hidden" value="<?php echo $vessel_sl; ?>" id="vessel_sl" name="vessel_sl">
     <input type="hidden" value="<?php echo $processflow_sl; ?>" id="processflow_sl" name="processflow_sl">
     <input type="hidden" value="<?php echo $status_details_sl; ?>" id="status_details_sl" name="status_details_sl">
     <input type="hidden" value="<?php echo $vessel_registry_port_id; ?>" id="vessel_registry_port_id" name="vessel_registry_port_id">
     <input type="hidden" value="<?php echo $tariff_amount; ?>" id="dd_amount" name="dd_amount">

    </div>
  </div>
</div> <!-- end of form12pay -->

</form>
<!--__________________________________________________________________________-->
</div>
</div> <!-- end of main row -->
</div> <!-- end of container div -->
<script src="<?php echo base_url(); ?>plugins/js/jquery.validate.js"></script> 
<script src="<?php echo base_url(); ?>plugins/jquery.form-validator.js"></script>
 <script src="<?php echo base_url(); ?>plugins/plugins/js/inputmask.js"></script> 

<script type="text/javascript">

//_________________________________________________________________________________________________//
//To submit page, on button click of pay now
$("#btnverify").click(function()
{ 


  var regex     = new RegExp("^[a-zA-Z][a-zA-Z0-9]+$");
  var regexname = new RegExp("^[a-zA-Z\ \-]+$");
  var regexnum  = new RegExp("^[0-9]+$");
  

  var newowner_mob=$('#newowner_mob').val();
  var newowner_mail=$('#newowner_mail').val();
  

  

  if(newowner_mob=="")
  {
      alert("Mobile Number Required");
      $("#newowner_mob").focus();
      return false;
  }
  else if (regexnum.exec(newowner_mob) == null) 
  {
      alert("Mobile Number should be in digits!!!");
      $("#newowner_mob").val(''); 
      $("#newowner_mob").focus();
      return false;
  }

  if(newowner_mail=="")
  {
      alert("Email ID Required!!!");
      $("#newowner_mail").focus();
      return false;
  }
  
  else {
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/VesselChange/Vessel_owner_check')?>",
      type: "POST",
      data:$('#form12').serialize(),
      //dataType: "JSON",
      success: function(data)
      { //alert(data);exit;
        //alert(data);
         
            $("#existowner_div").show();
            $("#existowner_div").html(data);
            $("#form12pay").show();
         
         
      }
    });

  }

});


//_________________________________________________________________________________________________//


</script>