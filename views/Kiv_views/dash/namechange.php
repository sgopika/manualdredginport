
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
      var regex     = new RegExp("^[a-zA-Z][a-zA-Z0-9]+$");
      var regexname = new RegExp("^[a-zA-Z\ \-]+$");
      var regexnum  = new RegExp("^[0-9]+$");

      var newvesselname  = $('#newvesselname').val();
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
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/VesselChange/nameChange_list">List Page</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row">
  <div class="col-12"> 
    <div class="row">
      <div class="col-2 mt-1 ml-5">
         <button type="button" class="btn btn-primary kivbutton btn-block"> Form 11</button> 
      </div> <!-- end of col-2 -->
      <div class="col mt-2 text-primary">
        Name Change for Registered Vessels 
      </div>
    </div> <!-- inner row -->
  </div> <!-- end of col-12 add-button header --> 
  <div class="col-12 mt-2 ml-2 newfont">
<!--__________________________________________________________________________-->


<div id="form12show">
<div class="row no-gutters">
  <div class="col-12 ">
    <div class="table-responsive">
      <table class="table table-hover ">
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
<form name="form12" id="form12" method="post"  enctype="multipart/form-data" action="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/payment_details_form11/'.$vessel_sl2.'/'.$processflow_sl2.'/'.$status_details_sl2 ?>">
  
<div id="msg"></div>

<div class="row no-gutters eventab">
  <div class="col-3 px-2 py-2"> New Name of the Vessel </div>
  <div class="col-3 px-2 py-2"> 
    <input type="text" class="form-control" id="newvesselname" name="newvesselname" placeholder="New Name of Vessel" data-validation="required">
  </div>
</div> <!-- end of row -->


<!-- ________________________________________________________ -->


<div id="declarationDiv" class="row no-gutters oddtab" style="display: none;">
    <div class="col-12 px-3 py-3 d-flex justify-content-start">
      <input type="checkbox" checked name="decl" id="decl"> &nbsp; &nbsp; 
     <p> I <b><?php echo $user_name; ?></b> subject of Kerala state of <b><?php echo $user_address; ?></b> residing permanently at/having principal place of business at <b><label id="placeOfBussiness_decl"></label> </b> do hereby declare that <b><?php echo $vessel_name; ?></b>(name) was built at <b><label id="yardName_decl"></label></b> in the year <b><?php echo $vessel_expected_completion; ?></b> and was puchased by me on <b><label id="vesselPurchaseDate_decl"></label></b> for rupees <b><label id="vesselPurchaseAmount_decl"></label></b> and wish to have registered it in my name at the port of <b><label id="vesselRegistry_decl"></label></b> and that I am the sole owner of the same. I further declare that the vessel is intended to ply in the port of <b><label id="plying_portofregistry_decl"></label></b></p><br><br>

      <!--&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;Owner<br><br>-->

    </div> <!-- end of col-12 -->
   Declaration of Ownership<input type="file" class="form-control-file" id="declarationOfOwnership" name="declarationOfOwnership">
  </div> <!-- end of row -->

</div> <!-- end of formshowdiv -->

<div id="form12pay">
  <div class="row no-gutters  mx-0 mt-5 mb-5">
<div class="col-6 d-flex justify-content-end pr-5">

 <input type="submit" class="btn btn-success btn-flat btn-point btn-lg" name="btnsubmit" value="Submit" id="btnsubmit"><!-- <i class="fas fa-rupee-sign"></i> -->&nbsp;&nbsp;&nbsp;  
 
 <input type="hidden" value="<?php echo $vessel_sl; ?>" id="vessel_sl" name="vessel_sl">
 <input type="hidden" value="<?php echo $processflow_sl; ?>" id="processflow_sl" name="processflow_sl">
 <input type="hidden" value="<?php echo $status_details_sl; ?>" id="status_details_sl" name="status_details_sl">
 <input type="hidden" value="<?php echo $vessel_registry_port_id; ?>" id="vessel_registry_port_id" name="vessel_registry_port_id">
 <input type="hidden" value="<?php echo $tariff_amount; ?>" id="dd_amount" name="dd_amount">

<!-- <input type="submit" name="pay_now" id="pay_now" value="Submit" class="btn btn-success btn-flat btn-point btn-lg" style="display: none;"> -->
   <!--<input type="submit" name="pay_later" id="pay_later" value="Pay Later" class="btn btn-secondary  btn-flat  btn-point btn-lg" style="display: none;"> -->

</div>
<!-- <div class="col-6 d-flex justify-content-start pl-5">
<button type="button" class="btn btn-secondary  btn-flat  btn-point btn-lg" name="pay_later_btn" id="pay_later_btn" ><i class="fas fa-business-time"></i>&nbsp;&nbsp;&nbsp;Pay Later</button>
</div> -->
</div>
</div> <!-- end of form12pay -->
<?php  //echo form_close(); ?>
</form>
<!--__________________________________________________________________________-->
</div>
</div> <!-- end of main row -->
</div> <!-- end of container div -->
<script src="<?php echo base_url(); ?>plugins/js/jquery.validate.js"></script> 
<script src="<?php echo base_url(); ?>plugins/jquery.form-validator.js"></script>
 <script src="<?php echo base_url(); ?>plugins/js/inputmask.js"></script> 

<script type="text/javascript">

//_________________________________________________________________________________________________//
//To submit page, on button click of pay now
$("#btnsubmit").click(function()
{ 


  var regex     = new RegExp("^[a-zA-Z][a-zA-Z0-9]+$");
  var regexname = new RegExp("^[a-zA-Z\ \-]+$");
  var regexnum  = new RegExp("^[0-9]+$");

  var insuranceNumber=$('#insuranceNumber').val();
  var registeringAuthorityId1=$('#registeringAuthorityId').val();
  var registeringAuthorityId=$('#registeringAuthorityId option:selected').text();

  var insuranceCompanyId=$('#insuranceCompanyId').val();
  var insuranceDate=$('#insuranceDate').val();
  var insuranceValidity=$('#insuranceValidity').val();
  var thirdpartyInsuranceCopy=$('#thirdpartyInsuranceCopy').val();
  var statementofOwner=$('#statementofOwner').val();
  var yardName=$('#yardName').val();
  var plying_portofregistry1=$('#plying_portofregistry').val();

  var plying_portofregistry=$('#plying_portofregistry option:selected').text();
  var vesselPurchaseDate1=$('#vesselPurchaseDate').val();
  var vesselPurchaseAmount=$('#vesselPurchaseAmount').val();
  var placeOfBussiness=$('#placeOfBussiness').val();
  var vesselPurchaseDate = vesselPurchaseDate1.split("-").reverse().join("-");


  $('#placeOfBussiness_decl').text(placeOfBussiness);
  $('#yardName_decl').text(yardName);
  $('#vesselPurchaseDate_decl').text(vesselPurchaseDate);
  $('#vesselPurchaseAmount_decl').text(vesselPurchaseAmount);
  $('#plying_portofregistry_decl').text(plying_portofregistry);
  $('#vesselRegistry_decl').text(registeringAuthorityId);


  

  if(registeringAuthorityId1=="")
  {
      alert("Registering Authority Required");
      $("#registeringAuthorityId").focus();
      return false;
  }

  if(insuranceCompanyId=="")
  {
      alert("Insurance Company Required");
      $("#insuranceCompanyId").focus();
      return false;
  }

  if(insuranceNumber=="")
  {
      alert("Insurance Number Required");
      $("#insuranceNumber").focus();
      return false;
  }
  
  else if (regex.exec(insuranceNumber) == null) 
  {
      alert("Insurance Number should start with an alphabets and followed by digits.");
      $("#insuranceNumber").val(''); 
      $("#insuranceNumber").focus();
      return false;
  } 

  if(insuranceDate=="")
  {
      alert("Insurance Date Required");
      $("#insuranceDate").focus();
      return false;
  }

  if(insuranceValidity=="")
  {
      alert("Insurance Validity Required");
      $("#insuranceValidity").focus();
      return false;
  }

  if(thirdpartyInsuranceCopy=="")
  {
      alert("Thirdparty insurance copy Required");
      $("#thirdpartyInsuranceCopy").focus();
      return false;
  }

  if(statementofOwner=="")
  {
      alert("Statement of owner Required");
      $("#statementofOwner").focus();
      return false;
  }

  if(yardName=="")
  {
      alert("Yard Name Required");
      $("#yardName").focus();
      return false;
  }

  else if (regexname.exec(yardName) == null) 
  {
      alert("Only alphabets,space and - allowed in Yard Name.");
      $("#yardName").val(''); 
      $("#yardName").focus();
      return false;
  } 

  if(plying_portofregistry1=="")
  {
      alert("Plying port of registry Required");
      $("#plying_portofregistry").focus();
      return false;
  }

  if(vesselPurchaseAmount=="")
  {
      alert("Vessel Purchase Amount Required");
      $("#vesselPurchaseAmount").focus();
      return false;
  }

  else if (regexnum.exec(vesselPurchaseAmount) == null) 
  {
      alert("Purchase Amount should contain only numbers.");
      $("#vesselPurchaseAmount").val(''); 
      $("#vesselPurchaseAmount").focus();
      return false;
  } 

  if(vesselPurchaseDate=="")
  {
      alert("Vessel Purchase Date Required");
      $("#vesselPurchaseDate").focus();
      return false;
  }

  if(placeOfBussiness=="")
  {
      alert("Place of Bussiness Required");
      $("#placeOfBussiness").focus();
      return false;
  }

  else if (regexname.exec(placeOfBussiness) == null) 
  {
      alert("Only alphabets,space and - allowed in Place of Bussiness.");
      $("#placeOfBussiness").val(''); 
      $("#placeOfBussiness").focus();
      return false;
  } 

  else
  {
      $('#pay_now').show();
      $('#declarationDiv').show();
      $('#btnsubmit').hide();

  }

/* if($("#form12").isValid())
  { 
    $.ajax({
      url : "<?php echo site_url('Survey/payment_later_form12')?>",
      type: "POST",
      data:$('#form12').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
        
        alert("Details inserted Successfully");
        window.location.href = "<?php echo site_url('Survey/SurveyHome'); ?>";
      }
    }); 
  }

*/
  
});
/*

$("#pay_later_btn").click(function()
{ 


  var regex     = new RegExp("^[a-zA-Z][a-zA-Z0-9]+$");
  var regexname = new RegExp("^[a-zA-Z\ \-]+$");
  var regexnum  = new RegExp("^[0-9]+$");

  var insuranceNumber=$('#insuranceNumber').val();
  var registeringAuthorityId1=$('#registeringAuthorityId').val();
  var registeringAuthorityId=$('#registeringAuthorityId option:selected').text();

  var insuranceCompanyId=$('#insuranceCompanyId').val();
  var insuranceDate=$('#insuranceDate').val();
  var insuranceValidity=$('#insuranceValidity').val();
  var thirdpartyInsuranceCopy=$('#thirdpartyInsuranceCopy').val();
  var statementofOwner=$('#statementofOwner').val();
  var yardName=$('#yardName').val();
  var plying_portofregistry1=$('#plying_portofregistry').val();

  var plying_portofregistry=$('#plying_portofregistry option:selected').text();
  var vesselPurchaseDate1=$('#vesselPurchaseDate').val();
  var vesselPurchaseAmount=$('#vesselPurchaseAmount').val();
  var placeOfBussiness=$('#placeOfBussiness').val();
  var vesselPurchaseDate = vesselPurchaseDate1.split("-").reverse().join("-");


  $('#placeOfBussiness_decl').text(placeOfBussiness);
  $('#yardName_decl').text(yardName);
  $('#vesselPurchaseDate_decl').text(vesselPurchaseDate);
  $('#vesselPurchaseAmount_decl').text(vesselPurchaseAmount);
  $('#plying_portofregistry_decl').text(plying_portofregistry);
  $('#vesselRegistry_decl').text(registeringAuthorityId);


  

  if(registeringAuthorityId1=="")
  {
      alert("Registering Authority Required");
      $("#registeringAuthorityId").focus();
      return false;
  }

  if(insuranceCompanyId=="")
  {
      alert("Insurance Company Required");
      $("#insuranceCompanyId").focus();
      return false;
  }

  if(insuranceNumber=="")
  {
      alert("Insurance Number Required");
      $("#insuranceNumber").focus();
      return false;
  }
  
  else if (regex.exec(insuranceNumber) == null) 
  {
      alert("Insurance Number should start with an alphabets and followed by digits.");
      $("#insuranceNumber").val(''); 
      $("#insuranceNumber").focus();
      return false;
  } 

  if(insuranceDate=="")
  {
      alert("Insurance Date Required");
      $("#insuranceDate").focus();
      return false;
  }

  if(insuranceValidity=="")
  {
      alert("Insurance Validity Required");
      $("#insuranceValidity").focus();
      return false;
  }

  if(thirdpartyInsuranceCopy=="")
  {
      alert("Thirdparty insurance copy Required");
      $("#thirdpartyInsuranceCopy").focus();
      return false;
  }

  if(statementofOwner=="")
  {
      alert("Statement of owner Required");
      $("#statementofOwner").focus();
      return false;
  }

  if(yardName=="")
  {
      alert("Yard Name Required");
      $("#yardName").focus();
      return false;
  }

  else if (regexname.exec(yardName) == null) 
  {
      alert("Only alphabets,space and - allowed in Yard Name.");
      $("#yardName").val(''); 
      $("#yardName").focus();
      return false;
  } 

  if(plying_portofregistry1=="")
  {
      alert("Plying port of registry Required");
      $("#plying_portofregistry").focus();
      return false;
  }

  if(vesselPurchaseAmount=="")
  {
      alert("Vessel Purchase Amount Required");
      $("#vesselPurchaseAmount").focus();
      return false;
  }

  else if (regexnum.exec(vesselPurchaseAmount) == null) 
  {
      alert("Purchase Amount should contain only numbers.");
      $("#vesselPurchaseAmount").val(''); 
      $("#vesselPurchaseAmount").focus();
      return false;
  } 

  if(vesselPurchaseDate=="")
  {
      alert("Vessel Purchase Date Required");
      $("#vesselPurchaseDate").focus();
      return false;
  }

  if(placeOfBussiness=="")
  {
      alert("Place of Bussiness Required");
      $("#placeOfBussiness").focus();
      return false;
  }

  else if (regexname.exec(placeOfBussiness) == null) 
  {
      alert("Only alphabets,space and - allowed in Place of Bussiness.");
      $("#placeOfBussiness").val(''); 
      $("#placeOfBussiness").focus();
      return false;
  } 

  else
  {
     // $('#pay_now').show();
      $('#declarationDiv').show();
      $('#pay_now_btn').hide();
  }

    if($("#form12").isValid())
  { 
    $.ajax({
      url : "<?php echo site_url('Survey/payment_later_form12')?>",
      type: "POST",
      data:$('#form12').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
        
        alert("Details inserted Successfully");
        window.location.href = "<?php echo site_url('Survey/SurveyHome'); ?>";
      }
    }); 
  }
  
});
*/

//_________________________________________________________________________________________________//


</script>