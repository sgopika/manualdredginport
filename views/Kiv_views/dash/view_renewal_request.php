<?php  

/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$status_details_sl1         = $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl=$this->encrypt->decode($status_details_sl); 
/*_____________________Decoding End___________________*/

$survey_id=0;
$survey_type          = $this->Survey_model->get_survey_type($survey_id);
$data['survey_type']  =   $survey_type;
if(!empty($survey_type))
{
  $survey_name=$survey_type[0]['survey_name'];
}
else
{
  $survey_name="";
}

$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];

$usertype                 =   $this->Survey_model->get_user_id_cs(14);
$data['usertype']         =   $usertype;
if(!empty($usertype))
{
  $user_sl_ra=   $usertype[0]['user_master_id'];
  $user_type_id_ra=   $usertype[0]['user_master_id_user_type'];
}

//print_r($usertype);


 //----------- Vessel Details -----------//
if(!empty($vessel_details_viewpage)) {
foreach($vessel_details_viewpage as $res_vessel)
{
  $vessel_name            = $res_vessel['vessel_name'];
  $vessel_length          = $res_vessel['vessel_length'];
  $vessel_breadth         = $res_vessel['vessel_breadth'];
  $vessel_depth           = $res_vessel['vessel_depth'];
  $vessel_expected_tonnage= $res_vessel['vessel_expected_tonnage'];
  
  $vessel_category_id     = $res_vessel['vessel_category_id'];
  $vessel_subcategory_id  = $res_vessel['vessel_subcategory_id'];
  $vessel_type_id         = $res_vessel['vessel_type_id'];
  $vessel_subtype_id      = $res_vessel['vessel_subtype_id'];
  $sewage_treatment     = $res_vessel['sewage_treatment'];
   $vessel_registry_port_id     = $res_vessel['vessel_registry_port_id'];
    $vessel_registration_number     = $res_vessel['vessel_registration_number'];
     
    
    $vessel_id            = $res_vessel['vessel_sl'];
    $user_id              = $res_vessel['user_id'];

  $user_type_details          = $this->Survey_model->get_user_type_id($user_id);
  $data['user_type_details']  = $user_type_details;
  $user_type_id               = $user_type_details[0]['user_master_id_user_type'];
  $length_overall             = $res_vessel['vessel_length_overall'];
  $vessel_total_tonnage       = $res_vessel['vessel_total_tonnage'];
  
  if($vessel_category_id!=0)
  {
    $vessel_category_id       =   $this->Survey_model->get_vessel_category_id($vessel_category_id);
    $data['vessel_category_id']   = $vessel_category_id;
    $vessel_category_name     = $vessel_category_id[0]['vesselcategory_name'];
  }
  else
  {
    $vessel_category_name='-';
  }
  if($vessel_category_id!=0)
  {
    $vessel_subcategory_id      =   $this->Survey_model->get_vessel_subcategory_id($vessel_subcategory_id);
    $data['vessel_subcategory_id']  = $vessel_subcategory_id;
    @$vessel_subcategory_name   = $vessel_subcategory_id[0]['vessel_subcategory_name'];
  }
  else
  {
    $vessel_subcategory_name='-';
  }
  if($vessel_type_id!=0)
  {
    $vessel_type_id       =   $this->Survey_model->get_vessel_type_id($vessel_type_id);
    $data['vessel_type_id']   = $vessel_type_id;
    $vesseltype_name      = $vessel_type_id[0]['vesseltype_name'];
  }
  else
  {
    $vesseltype_name='-';
  }
    
  if($vessel_subtype_id!=0)
  {
    $vessel_subtype_id      =   $this->Survey_model->get_vessel_subtype_id($vessel_subtype_id);
    $data['vessel_subtype_id']  = $vessel_subtype_id;
    $vessel_subtype_name    = $vessel_subtype_id[0]['vessel_subtype_name'];
  }
  else
  {
    $vessel_subtype_name='-';
  }



}

}
if(!empty($customer_details)) 
{
  foreach($customer_details as $res_owner)
  {
    $owner_name         = $res_owner['user_name'];
    $owner_address      = $res_owner['user_address'];
    $user_mobile_number = $res_owner['user_mobile_number'];
    $user_email         = $res_owner['user_email'];
  }
}


if(!empty($payment_details))
{


$payment_sl      = $payment_details[0]['payment_sl'];
$paymenttype_id   = $payment_details[0]['paymenttype_id'];
$dd_amount        = $payment_details[0]['dd_amount'];
$dd_date          = date('d-m-Y',strtotime($payment_details[0]['dd_date']));
$bank_id          = $payment_details[0]['bank_id'];
$branch_name      = $payment_details[0]['branch_name'];


if(!empty($bank_id ))
{

 $bankname      =   $this->Survey_model->get_bankname($bank_id);
  $data['bankname']  = $bankname;
  if(!empty($bankname))
  {
    $bank_name=$bankname[0]['bank_name'];
  }
  else
  {
     $bank_name="";
  }
}
else
{
  $bank_name="";
}


$payment_mode=$payment_details[0]['payment_mode'];
$transaction_id=$payment_details[0]['transaction_id'];


}


$portofregistry_details           =   $this->Bookofregistration_model->get_registry_port_id($vessel_registry_port_id);
$data['portofregistry_details']   =   $portofregistry_details;
if(!empty($portofregistry_details))
{
  $portofregistry_name=$portofregistry_details[0]['vchr_portoffice_name'];
}
else
{
  $portofregistry_name="";
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
<script language="javascript">
    
$(document).ready(function()
{
  
 

//-----Jquery End----//
});

</script>
<script type="text/javascript">
  function IsAddress(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if ((unicode == 32) || (unicode == 44) || (unicode == 47) || (unicode == 40) || (unicode == 41) || (unicode == 45) || (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode > 96 && unicode < 123) || (unicode==8) || (unicode==46) ) 
        {
                return true;
        }
        else 
        {
              window.alert("Not Allowed");
                return false;  
        }
        }  
</script>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1"> 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary "><i class="fab fa-wpforms"></i>  </button></div>
<div class="col-6 d-flex justify-content-end">
<button class="btn-sm btn-flat btn btn-outline-success " id="printform">&nbsp; Renewal of Registration </button>
</div> <!-- end of button col -->
<div class="col-12" id="form1view-print"> </div>
</div> <!-- end of row -->
<div class="row h-100 justify-content-center mt-3">
<div class="col-12 d-flex justify-content-center text-primary mt-4"><u><strong><!-- Appointment of Date and time of Inspection of the Inland Vessel by the Registering Authority --> </strong></u> </div>
<div class="col-12 " id="form1view">
<!-- ########################################################################################### -->
 <!-- inside content -->

<form name="form1" id="form1" method="post" action="" enctype="multipart/form-data" >


<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Owner details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Owner name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $owner_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Address
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $owner_address; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Phone number
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $user_mobile_number; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Email
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $user_email; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Registration number
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vessel_registration_number; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Port under which the vessel is registeed
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $portofregistry_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Vessel details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <?php echo $vessel_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Survey Type
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $survey_name;  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel category
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $vessel_category_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Vessel sub category
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $vessel_subcategory_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel type
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <?php echo $vesseltype_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Vessel sub type
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $vessel_subtype_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel Tonnage
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <?php echo $vessel_total_tonnage; ?> Ton
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">

</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">

</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Payment details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Transaction mode
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $payment_mode; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Transaction Id
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $transaction_id; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Amount remitted
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $dd_amount; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Payment date
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $dd_date; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Bank name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $bank_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Branch
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $branch_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->






<!-- id="registration_inspection_report_upload" data-validation="required" -->

<div class="row no-gutters oddrow border-bottom" >

<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $user_type_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">



</div> <!-- end of col-3 1st-->

<div class="col-3 d-flex justify-content-center mt-1 mb-1 text-primary formfont">
<input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Approve">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="col-3 d-flex justify-content-center mt-1 mb-1 text-primary formfont">
&nbsp;
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



</form>
<!-- end of inside content -->
<!-- ########################################################################################### -->
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->

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