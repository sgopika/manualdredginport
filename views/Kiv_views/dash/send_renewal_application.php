<?php 
//print_r($tariff_amount);
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$status_details_sl1    =   $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl=$this->encrypt->decode($status_details_sl); 

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
<script language="javascript">
    
$(document).ready(function()
{

//$("#showpayment").hide();
$("#insuranceValidity").mouseout(function()
{
  var next_reg_renewal_date=$("#next_reg_renewal_date").val();
  var insuranceValidity=$("#insuranceValidity").val();
 // alert(next_reg_renewal_date);
//16-08-2024


});


$("#btnsubmit").click(function()
{

  var insuranceCompanyId=$("#insuranceCompanyId").val();
  var insuranceNumber=$("#insuranceNumber").val();
  var vessel_insurance_type=$("#vessel_insurance_type").val();
  var vessel_insurance_premium=$("#vessel_insurance_premium").val();
  var insuranceDate=$("#insuranceDate").val();
  var insuranceValidity=$("#insuranceValidity").val();
  var thirdpartyInsuranceCopy=$("#thirdpartyInsuranceCopy").val();
  var statementofOwner=$("#statementofOwner").val();
var portofregistry_sl=$("#portofregistry_sl").val();
var bank_sl=$("#bank_sl").val();


    

  if(insuranceCompanyId=="")
  {
    alert("Select Insurance Company");
    $("#insuranceCompanyId").focus();
    return false;
  }
  

if(insuranceNumber=="")
  {
    alert("Enter Insurance Number");
    $("#insuranceNumber").focus();
    return false;
  }
 
if(vessel_insurance_type=="")
  {
    alert("Select Insurance type");
    $("#vessel_insurance_type").focus();
    return false;
  }
 

if(vessel_insurance_premium=="")
  {
    alert("Enter Insurance amount");
    $("#vessel_insurance_premium").focus();
    return false;
  }
  
if(insuranceDate=="")
  {
    alert("Enter Insurance Date");
    $("#insuranceDate").focus();
    return false;
  }
 
if(insuranceValidity=="")
  {
    alert("Enter Insurance Validity date");
    $("#insuranceValidity").focus();
    return false;
  }
 


if(thirdpartyInsuranceCopy=="")
  {
    alert("Upload third party insurance copy");
    $("#thirdpartyInsuranceCopy").focus();
    return false;
  }
  

if(statementofOwner=="")
  {
    alert("Upload statement of owner");
    $("#statementofOwner").focus();
    return false;
  }
 

if(portofregistry_sl=="")
  {
    alert("Select Port of registry");
    $("#portofregistry_sl").focus();
    return false;
  }
 
if(bank_sl=="")
  {
    alert("Select bank");
    $("#bank_sl").focus();
    return false;
  }
  


});


 


/*

insuranceCompanyId
insuranceNumber
vessel_insurance_type
vessel_insurance_premium
insuranceDate
insuranceValidity
thirdpartyInsuranceCopy
statementofOwner

*/

//-----Jquery End----//
});

</script>
<?php 

if(!empty($vessel_list))
{
 
 $vesselmain_sl                   =   $vessel_list[0]['vesselmain_sl'];
 $vesselmain_vessel_id            =   $vessel_list[0]['vesselmain_vessel_id'];
 $vesselmain_vessel_name          =   $vessel_list[0]['vesselmain_vessel_name'];
 $vesselmain_vessel_type          =   $vessel_list[0]['vesselmain_vessel_type'];
 $vesselmain_vessel_subtype       =   $vessel_list[0]['vesselmain_vessel_subtype'];
 $vesselmain_vessel_category      =   $vessel_list[0]['vesselmain_vessel_category'];
 $vesselmain_ref_number           =   $vessel_list[0]['vesselmain_ref_number'];
 $vesselmain_owner_id             =   $vessel_list[0]['vesselmain_owner_id'];
 $vesselmain_portofregistry_id    =   $vessel_list[0]['vesselmain_portofregistry_id'];
 $vesselmain_reg_number           =   $vessel_list[0]['vesselmain_reg_number'];
 $vesselmain_reg_date             =   $vessel_list[0]['vesselmain_reg_date'];
  $next_reg_renewal_date           =   $vessel_list[0]['next_reg_renewal_date'];


$user           =   $this->Bookofregistration_model->get_customer_details($vesselmain_owner_id);
$data['user']   =   $user;
if(!empty($user))
{
  $name=$user[0]['user_name'];
  $address=$user[0]['user_address'];
}
else
{
  $name="";
  $address="";
}

$portofregistry_details           =   $this->Bookofregistration_model->get_registry_port_id($vesselmain_portofregistry_id);
$data['portofregistry_details']   =   $portofregistry_details;
if(!empty($portofregistry_details))
{
  $portofregistry_name=$portofregistry_details[0]['vchr_portoffice_name'];
}
else
{
  $portofregistry_name="";
}

$user_type           =   $this->Bookofregistration_model->get_user_master($vesselmain_owner_id);
$data['user_type']   =   $user_type;
if(!empty($user_type))
{
  $owner_usertype_id=$user_type[0]['user_type_id'];
}
else
{
  $owner_usertype_id=0;
}





}

?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/surveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ui-innerpage">
<form name="form1" id="form1" method="POST" action="<?php echo $site_url.'/Kiv_Ctrl/Bookofregistration/renewalofregistration'?>">
<?php 
  foreach ($vesselDet as $vesselDetails) 
    {

      $vessel_sl=$vesselDetails['vessel_sl'];
      $vessel_survey_number=$vesselDetails['vessel_survey_number'];
      $vessel_name=$vesselDetails['vessel_name'];
      $reference_number=$vesselDetails['reference_number'];
      $build_date=$vesselDetails['build_date'];
      $vessel_registry_port_id=$vesselDetails['vessel_registry_port_id'];
      $vessel_total_tonnage=$vesselDetails['vessel_total_tonnage'];
      
      $vessel_expected_completion=$vesselDetails['vessel_expected_completion'];
      
  
      
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
    if(!empty($engine_type))
    {
      $engine_type_name1[] =   $engine_type[0]['enginetype_name'];
    }
    else
    {
      $engine_type_name1="";
    }
    

  }



  $bhp=implode(", ", $bhp1);
  $make_year=implode(", ", $make_year1);
  if($engine_type_name1)
  {
    $engine_type_name=implode(", ", $engine_type_name1);
  }
  else
  {
    $engine_type_name="";
  }
  
}
else
{
  $bhp="";
  $make_year="";
  $engine_type_name="";
}

//print_r($insurance_details);

if(!empty($insurance_details))
{

  $vessel_insurance_sl=$insurance_details[0]['vessel_insurance_sl'];
  $vessel_insurance_company=$insurance_details[0]['vessel_insurance_company'];
  $vessel_insurance_number=$insurance_details[0]['vessel_insurance_number'];
  $vessel_insurance_type=$insurance_details[0]['vessel_insurance_type'];
  $vessel_insurance_date=date('d-m-Y',strtotime($insurance_details[0]['vessel_insurance_date']));
  $vessel_insurance_premium=$insurance_details[0]['vessel_insurance_premium'];
  $vessel_insurance_validity=date('d-m-Y',strtotime($insurance_details[0]['vessel_insurance_validity']));
  $vessel_thirdpartyInsuranceCopy=$insurance_details[0]['vessel_thirdpartyInsuranceCopy'];
  $vessel_statementofOwner=$insurance_details[0]['vessel_statementofOwner'];
}
else
{
   $vessel_insurance_sl="";
  $vessel_insurance_company="";
  $vessel_insurance_number="";
  $vessel_insurance_type="";
  $vessel_insurance_date="";
  $vessel_insurance_premium="";
  $vessel_insurance_validity="";
  $vessel_thirdpartyInsuranceCopy="";
  $vessel_statementofOwner="";
}

?>


<div class="main-content">  
<div class="row no-gutters px-5" >
<div class="col-12">
<div class=" letterform mb-4">

<div class="row  evenrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
<u>Vessel details </u> </strong> </div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Name of vessel </div>
<div class="col-3 px-6 text-secondary"><?php echo $vesselmain_vessel_name; ?>  </div>
<div class="col-3 pl-6 text-primary"> Reference Number </div>
<div class="col-3 px-6 text-secondary"> <?php echo $reference_number; ?></div>
</div> <!-- end of row -->


<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary">Owner Name</div>
<div class="col-3 px-6 text-secondary"><?php echo $name; ?></div>
<div class="col-3 pl-6 text-primary"> Owner address </div>
<div class="col-3 px-6 text-secondary">  <?php echo $address; ?></div>
</div> <!-- end of row -->



<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Registration number of vessel</div>
<div class="col-3 px-6 text-secondary"> <?php echo $vesselmain_reg_number; ?></div>
<div class="col-3 pl-6 text-primary"> Port under which the vessel is registered</div>
<div class="col-3 px-6 text-secondary"> <?php echo $portofregistry_name; ?></div>
</div> <!-- end of row -->

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"> Type of vessel</div>
<div class="col-3 px-6 text-secondary"> <?php echo $vesselmain_vessel_type; ?></div>
<div class="col-3 pl-6 text-primary"> Survey number  </div>
<div class="col-3 px-6 text-secondary"><?php echo $vessel_survey_number; ?> </div>
</div> <!-- end of row -->


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Engine make</div>
<div class="col-3 px-6 text-secondary"> <?php echo $engine_type_name; ?></div>
<div class="col-3 pl-6 text-primary"> BHP</div>
<div class="col-3 px-6 text-secondary"> <?php echo $bhp; ?></div>
</div> <!-- end of row -->

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"> Tariff for Registration</div>
<div class="col-3 px-6 text-secondary"> <?php echo $tariff_amount; ?></div>
<div class="col-3 pl-6 text-primary"> Year of Make</div>
<div class="col-3 px-6 text-secondary"> <?php echo $make_year; ?></div>
</div> <!-- end of row -->


<?php $cnt=count($vesselMasterDetails); if($cnt>0){ ?>
<div class="row  oddrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
<u>Master/Serang Details </u> </strong> </div>
</div>


<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary">#</div>
<div class="col-3 px-6 text-primary">Type</div>
<div class="col-3 pl-6 text-primary">Name</div>
<div class="col-3 px-6 text-primary">License Number</div>
</div> <!-- end of row -->

 <?php $i=1; foreach ($vesselMasterDetails as $value) { ?>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-secondary"><?php echo $i; ?></div>
<div class="col-3 px-6 text-secondary"><?php echo $value['crew_type_name']; ?></div>
<div class="col-3 pl-6 text-secondary"><?php echo $value['name_of_type']; ?></div>
<div class="col-3 px-6 text-secondary"><?php echo $value['license_number_of_type']; ?></div>
</div> <!-- end of row -->

  <?php $i++;} } ?>



<div class="row  evenrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
 <u>Insurance details </u> </strong> </div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Insurance Company</div>
<div class="col-3 px-6 text-secondary"> 
  <select class="form-control select2" name="insuranceCompanyId" id="insuranceCompanyId" title="Select Insurance Company" data-validation="required">
        <option value="">Select</option>
        <?php foreach ($insuranceCompany as $insComp) { ?>
          <option value="<?php echo $insComp['insurance_company_sl']; ?>" <?php //if($vessel_insurance_company==$insComp['insurance_company_sl']) { echo "selected";  }?>><?php echo $insComp['insurance_company_name']; ?></option>
        <?php } ?>
    </select>
  </div>
<div class="col-3 pl-6 text-primary"> Insurance Number</div>
<div class="col-3 px-6 text-secondary">  <input type="text" class="form-control " maxlength="9" id="insuranceNumber" name="insuranceNumber" placeholder="Insurance Number" data-validation="required" value="<?php //echo $vessel_insurance_number ?>"> </div>
</div> <!-- end of row -->


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Insurance Type</div>
<div class="col-3 px-6 text-secondary"> 
  <select class="form-control select2" name="vessel_insurance_type" id="vessel_insurance_type" title="Select Insurance Type" data-validation="required">
        <option value="">Select</option>
        <?php foreach ($insurance_type as $res_insurance_type) { ?>
          <option value="<?php echo $res_insurance_type['insurance_type_sl']; ?>" <?php //if($vessel_insurance_type==$res_insurance_type['insurance_type_sl']) {echo "selected"; } ?>><?php echo $res_insurance_type['insurance_type_name']; ?></option>
        <?php } ?>
    </select>
  </div>
<div class="col-3 pl-6 text-primary"> Insurance Amount</div>
<div class="col-3 px-6 text-secondary">  <input type="text" class="form-control " maxlength="9" id="vessel_insurance_premium" name="vessel_insurance_premium" placeholder="Insurance Amount" data-validation="required" value="<?php //echo $vessel_insurance_premium ?>"> </div>
</div> <!-- end of row -->



<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"> Insurance Date</div> <!--  -->
<div class="col-3 px-6 text-secondary">  <input type="date"  class="form-control dob" id="insuranceDate" name="insuranceDate" placeholder="Insurance Date" data-validation="required" value="<?php //echo $vessel_insurance_date; ?>">
  <span></span>
</div>
<div class="col-3 pl-6 text-primary">  Validity of Insurance</div>
<div class="col-3 px-6 text-secondary">  <input type="date" class="form-control dob" id="insuranceValidity" name="insuranceValidity" placeholder="Validity of Insurance" data-validation="required" value="<?php //echo $vessel_insurance_validity; ?>"> </div>
</div> <!-- end of row -->
<input type="hidden" name="next_reg_renewal_date" id="next_reg_renewal_date" value="<?php echo $next_reg_renewal_date; ?>">


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">Thirdparty insurance copy</div>
<div class="col-3 px-6 text-secondary">   <input type="file" class="form-control-file" id="thirdpartyInsuranceCopy" name="thirdpartyInsuranceCopy" data-validation="required"  accept=".jpg,.jpeg,.JPG,.png">

 <!-- <?php if(!empty($vessel_thirdpartyInsuranceCopy)) { ?>
   <a href="<?php echo base_url(); ?>uploads/thirdPartyInsurance/<?php echo $vessel_thirdpartyInsuranceCopy; ?>" target="_blank"><img src="<?php echo base_url(); ?>plugins/img/pdf_icon.png" width="30" height="30"> </a><?php } ?>
   <input type="hidden" name="thirdparty_InsuranceCopy" value="<?php echo $vessel_thirdpartyInsuranceCopy; ?>"> -->

</div>
<div class="col-3 pl-6 text-primary">  Statement of owner</div>
<div class="col-3 px-6 text-secondary">   <input type="file" class="form-control-file" id="statementofOwner" name="statementofOwner" data-validation="required"  accept=".jpg,.jpeg,.JPG,.png">

 <!-- <?php if(!empty($vessel_statementofOwner)) { ?>
   <a href="<?php echo base_url(); ?>uploads/statementofOwner/<?php echo $vessel_statementofOwner; ?>" target="_blank"><img src="<?php echo base_url(); ?>plugins/img/pdf_icon.png" width="30" height="30"> </a><?php } ?>
<input type="hidden" name="statementof_Owner" value="<?php echo $vessel_statementofOwner; ?>"> -->


 </div>
</div> <!-- end of row -->


<span id="showpayment">

<div class="row  evenrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
 <u>  Payment details </u> </strong> </div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">Port of registry</div>
<div class="col-3 px-6 text-secondary"> <select class="form-control select2 " name="portofregistry_sl" id="portofregistry_sl"  title="" data-validation="required" >
  <option value="">Select</option>
  <?php   foreach ($portofregistry as $res_portofregistry)
  {
  ?>
  <option value="<?php echo $res_portofregistry['int_portoffice_id']; ?>"<?php //if($vesselmain_portofregistry_id==$res_portofregistry['portofregistry_sl']) { echo "selected"; } ?>><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
  <?php    }    ?>
  </select></div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">Bank</div>
<div class="col-3 px-6 text-secondary">  
  <select class="form-control select2 " name="bank_sl" id="bank_sl"  title="" data-validation="required">
  <option value="">Select</option> 
  <?php   foreach ($bank as $res_bank)
  {
  ?>
  <option value="<?php echo $res_bank['bank_sl'];?>" ><?php echo $res_bank['bank_name'];?>  </option>
  <?php    }    ?>
  </select>
</div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">Fee</div>
<div class="col-3 px-6 text-secondary"><?php echo $tariff_amount; ?></div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">
  
<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="owner_user_id" id="owner_user_id" value="<?php echo $vesselmain_owner_id; ?>">
<input type="hidden" name="owner_usertype_id" id="owner_usertype_id" value="<?php echo $owner_usertype_id; ?>">
<input type="hidden" name="vessel_insurance_sl" id="vessel_insurance_sl" value="<?php echo $vessel_insurance_sl; ?>">


</div>
<div class="col-3 px-6 text-secondary"><input class="btn btn-flat btn-sm btn-success" type="submit" name="btnsubmit" value="Send application" id="btnsubmit"></div>
</div> <!-- end of row -->

</span>


</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->
</form>
</div>

<script language="javascript">
$(document).ready(function(){


});

 



</script>
 <script type="text/javascript">
  $(document).ready(function() {
          $('.select2').select2({ width:'100%' });
      });

  (function($){ 
  $('.dob').inputmask("date",{
    mask: "1/2/y", 
    placeholder: "dd-mm-yyyy", 
    leapday: "-02-29", 
    separator: "/", 
    alias: "dd/mm/yyyy"
  });
  
})(jQuery);


 </script>