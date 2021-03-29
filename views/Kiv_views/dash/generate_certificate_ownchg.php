
<?php 
/*$sess_usr_id      = $this->session->userdata('user_sl');
$user_type_id     = $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');


$vessel_id        = $this->uri->segment(4);

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
<?php 
//_______________________Process flow _____________________________//
/*if(!empty($registration_intimation))
{
  foreach ($registration_intimation as $key ) 
  {
    $registration_intimation_sl=   $key['registration_intimation_sl'];
  }

}*/

/*if(!empty($initial_data))
{
  $process_id       = $initial_data[0]['process_id'];
  $survey_id        = $initial_data[0]['survey_id'];
  $user_id          = $initial_data[0]['user_id'];
  $process_id       = $initial_data[0]['process_id'];
  $current_position = $initial_data[0]['current_position'];
  $user_sl_ra       = $initial_data[0]['user_id'];
  $user_id_owner    = $initial_data[0]['uid'];

  $user_type_details          = $this->Survey_model->get_user_type_id($user_id_owner);
  $data['user_type_details']  = $user_type_details;
  $user_type_id_owner               = $user_type_details[0]['user_type_id'];
}*/

//_______________________Process flow end_____________________________//

//-----------Get basic vessel details--------------//

if(!empty($vessel_details_viewpage))
{
  foreach($vessel_details_viewpage as $res_vessel)
  {
    $vessel_name                =     $res_vessel['vessel_name'];
    $vessel_survey_number       =     $res_vessel['vessel_survey_number'];
    $official_number            =     $res_vessel['official_number'];
    $reference_number           =     $res_vessel['reference_number'];
    @$vessel_registry_port_id   =     $res_vessel['vessel_registry_port_id'];
    @$plying_limit              =     $res_vessel['plying_limit'];
    @$vessel_gross_tonnage      =     $res_vessel['grt'];
    @$vessel_net_tonnage        =     $res_vessel['nrt'];
    $vessel_registration_number =     $res_vessel['vessel_registration_number'];
    $vesselmain_reg_number      =     $res_vessel['vesselmain_reg_number'];
    $vessel_length              =     $res_vessel['vessel_length'];
    $vessel_breadth             =     $res_vessel['vessel_breadth'];
    $vessel_depth               =     $res_vessel['vessel_depth']; 
    $vessel_length_overall      =     $res_vessel['vessel_length_overall'];
    $vessel_yearofbuilt         =     $res_vessel['vessel_expected_completion'];

    $stern                      =     $res_vessel['stern'];
    $stern_id                   =     $res_vessel['stern_id'];
    $vessel_no_of_deck          =     $res_vessel['vessel_no_of_deck'];
    $no_of_shaft                =     $res_vessel['no_of_shaft'];






   /* if(!empty($stern_id))
    {
      $stern_materialname          =   $this->Bookofregistration_model->get_stern_materialname($stern_id);
       $data['stern_materialname']  =   $stern_materialname; 
       if(!empty($stern_materialname))
       {
        $materialname=$stern_materialname[0]['stern_material_name'];
       }
       else
       {
        $materialname="";
       }
    }
    else
    {
      $materialname="";
    }*/

   

    /*if(!empty($vessel_registry_port_id))
    {
       $portofregistry          =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
       $data['portofregistry']  =   $portofregistry;
       $portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
       $portofregistry_code     =   $portofregistry[0]['vchr_officecode'];

    }*/
  }
}




//-----------Get customer name and address--------------//
if(!empty($customer_details))
{
  foreach($customer_details as $res_customer)
  {
    $user_name      =   $res_customer['user_name'];
    $user_address   =   $res_customer['user_address'];
  }
} 

//-----------engine details--------------//
/*if(!empty($engine_details))
{
  $no_of_engineset=count($engine_details);
   
}*/

//-----------hull details--------------//
/*if(!empty($hull_details))
{
   foreach($hull_details as $res_hull)
  {
    $bulk_heads=$res_hull['bulk_heads'];
    $hull_year_of_built=$res_hull['hull_year_of_built'];
  }
}*/
?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">

    <?php if($user_type_id==14) {/// After integration Registering Authority New user_type_id=14?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php } else if($user_type_id==11) {/// After integration Vessel Owner New user_type_id=11?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php } ?>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage " >
<div class="col-12">
<div class="container letterform mb-4">
<div class="row no-gutters">
<div class="col-12 d-flex justify-content-center text-primary"></div>
<div class="col-12 d-flex justify-content-center text-primary"> <strong>VESSEL CERTIFICATE</strong></div>
</div>

<form name="form14" id="form14" method="POST" action="">
 <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<!--<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="current_position" id="current_position" value="<?php echo $current_position; ?>">
<input type="hidden" name="user_sl_ra" id="user_sl_ra" value="<?php echo $user_sl_ra; ?>">
<input type="hidden" name="registration_intimation_sl" id="registration_intimation_sl" value="<?php echo $registration_intimation_sl; ?>">
<input type="hidden" name="user_id_owner" id="user_id_owner" value="<?php echo $user_id_owner; ?>">
<input type="hidden" name="user_type_id_owner" id="user_type_id_owner" value="<?php echo $user_type_id_owner; ?>"> 

<input type="hidden" name="vessel_registration_number" id="user_type_id_owner" value="<?php echo $user_type_id_owner; ?>"> 
<input type="hidden" name="user_type_id_owner" id="user_type_id_owner" value="<?php echo $user_type_id_owner; ?>">  -->
<!-- <input type="hidden" name="current_status_id" id="current_status_id" value="2"> --> 




<div class="row py-2">
<div class="col-3 pl-6 text-primary"> Registration Number</div>
<div class="col-3 px-6 text-secondary"> <?php echo $vesselmain_reg_number;  ?></div>
</div> 

<div class="row py-2">
<div class="col-3 pl-6 text-primary">Name of Inland Vessel</div>
<div class="col-3 px-6 text-secondary"> <?php  echo $vessel_name; ?></div>
</div> 

<div class="row py-2">
<div class="col-3 pl-6 text-primary">Name of Owner</div>
<div class="col-3 px-6 text-secondary"> <?php echo $user_name;  ?></div>
</div> 

<div class="row py-2">
<div class="col-3 pl-6 text-primary">Address of owner</div>
<div class="col-3 px-6 text-secondary"> <?php  echo $user_address; ?></div>
</div> 


  
<div class="row py-2 px-2">
<div class="col-12 d-flex justify-content-center">
<!-- <input class="btn btn-flat btn-sm btn-success" type="submit" name="btnsubmit" value="Generate certificate">  -->
<input class="btn btn-flat btn-sm btn-success" type="button" name="generate_certificate" id="generate_certificate" value="Certificate of Registration">
&nbsp;
<input class="btn btn-flat btn-sm btn-success" type="button" name="generate_bookofregn" id="generate_bookofregn" value="Book of Registration">
</div> 
</div>



</form>





</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->


<script language="javascript">
$(document).ready(function(){

$("#generate_certificate").click(function()
{
   var vessel_id1          =  $("#vessel_id").val();
  //alert("Registration completed successfully");

      location.replace('<?php echo site_url('Kiv_Ctrl/Bookofregistration/form14_certificate')?>/'+vessel_id1);

 });
$("#generate_bookofregn").click(function()
{
   var vessel_id1          =  $("#vessel_id").val();
  //alert("Registration completed successfully");

      location.replace('<?php echo site_url('Kiv_Ctrl/Bookofregistration/form15_certificate')?>/'+vessel_id1);

 });


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