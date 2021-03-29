<?php  
//$user_type_id     = $this->session->userdata('user_type_id');
$user_type_id   = $this->session->userdata('int_usertype');


/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$survey_id12         = $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$survey_id1=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id12);
$survey_id1=$this->encrypt->decode($survey_id1); 
/*_____________________Decoding End___________________*/


$survey_id        = 1;

$owner_user_id            =   $initial_data[0]['vessel_user_id'];
$process_id               =   $initial_data[0]['process_id'];

$user_type_id1= $this->Survey_model->get_user_master($owner_user_id);
$data['user_type_id1']  =   $user_type_id1;
if(!empty($user_type_id1))
{
  $owner_user_type_id        =   $user_type_id1[0]['user_type_id'];
}


$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];
   

//-----------Get basic vessel details--------------//

if(!empty($vessel_details_viewpage))
{
  foreach($vessel_details_viewpage as $res_vessel)
  {
    $vessel_name              =   $res_vessel['vessel_name'];
    $vessel_survey_number     =   $res_vessel['vessel_survey_number'];
    $official_number          =   $res_vessel['official_number'];
    $reference_number         =   $res_vessel['reference_number'];
    @$vessel_registry_port_id =   $res_vessel['vessel_registry_port_id'];
    @$plying_limit            =   $res_vessel['plying_limit'];
    @$vessel_gross_tonnage    =   $res_vessel['vessel_total_tonnage'];
    @$vessel_net_tonnage      =   $res_vessel['vessel_expected_tonnage'];

    if(!empty($vessel_registry_port_id))
    {
       $portofregistry          =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
       $data['portofregistry']  =   $portofregistry;
       $portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
    }
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

//-----------Get number of lifebouy : equipment_id=8 tbl_kiv_equipment_details--------------//
$lifebouy             =   $this->Survey_model->get_equipment_details_edit($vessel_id,8,$survey_id);
$data['lifebouy']     =   $lifebouy;
if(!empty($lifebouy)) 
{
  @$number_of_lifebouy  =   $lifebouy[0]['number'];
}


//-----------Get bilgepump : tbl_kiv_bilgepump_details  --------------//

$bilgepump             =    $this->Survey_model->get_bilgepump($vessel_id,$survey_id);
$data['bilgepump']     =    $bilgepump;
if(!empty($bilgepump)) 
{
  @$count_bilgepump      =    count($bilgepump);
  
}


//-----------Get firepumps : tbl_kiv_firepumps_details  --------------//

$firepumps             =    $this->Survey_model->get_firepumps($vessel_id,$survey_id);
$data['firepumps']     =    $firepumps;
if(!empty($firepumps)) 
{
  @$count_firepumps      =    count($firepumps);
  @$capacity_of_firepump  =   $firepumps[0]['capacity'];

}


//-----------Get number of hose : equipment_id=16 tbl_kiv_equipment_details--------------//
$hose             =   $this->Survey_model->get_equipment_details_edit($vessel_id,16,$survey_id);
$data['hose']     =   $hose;
if(!empty($hose)) 
{
  @$number_of_hose  =   $hose[0]['number'];
 
}


//-----------Get portable fire exstinguisher : tbl_kiv_fire_extinguisher_details--------------//
$portablefire_extinguisher             =   $this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
$data['portablefire_extinguisher']     =   $portablefire_extinguisher;
if(!empty($portablefire_extinguisher)) 
{
   @$count_portablefire_extinguisher    =    count($portablefire_extinguisher);
   foreach ($portablefire_extinguisher as $key ) 
  {
    @$type_of_portablefire_typeid           =   $key['fire_extinguisher_type_id'];
        //------Get portable fire exstinguisher type name :  kiv_portable_fire_extinguisher_master -----------//
    $portablefire_extinguisher_type         =   $this->Survey_model->get_portablefire_extinguisher_type($type_of_portablefire_typeid);
    $data['portablefire_extinguisher_type'] =   $portablefire_extinguisher_type;

     $portable_fire_extinguisher_name[] =$portablefire_extinguisher_type[0]['portable_fire_extinguisher_name'];
  }
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
<script language="javascript">
    
$(document).ready(function()
{
  


 
//-----Jquery End----//
});

</script>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id ==11){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>
   <?php if($user_type_id ==12){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>

  <?php if($user_type_id ==13){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1" > 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary" id="form3"><i class="fab fa-wpforms"></i>&nbsp; Form 9 </button>&nbsp;
</div>
<div class="col-6 d-flex justify-content-end">

<button class="btn-sm btn-flat btn btn-outline-success " id="printform"><i class="fas fa-print"></i>&nbsp; Print </button>
</div> <!-- end of button col -->
</div> <!-- end of row -->


<!-- starting of form 3 view -->
<div class="row h-100 justify-content-center mt-3" id="form9view">
<div class="col-12">

<!-- <form name="form1" id="form1" method="post" action=""> -->

  

<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/form9_view_annual", $attributes);
?>

<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id ; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php //echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $owner_user_id; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $owner_user_type_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>"> 
<!-- ____________________________ Vessel Details ____________________________ -->

<div class="col-12 py-2 d-flex justify-content-center text-primary"> <strong>FORM NO. 9</strong> </div>
<div class="col-12 py-2 d-flex justify-content-center "> <a href="" class="btn btn-sm btn-flat btn-outline-primary" role="button">[ See Rule 12 ] </a> </div> 

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-center mt-1 mb-1 text-white formfont">
CERTIFICATE OF SURVEY



</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Survey number
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vessel_survey_number; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Official number
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $official_number; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Reference number
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $reference_number; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Name of vessel 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php echo $vessel_name; ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Gross registered tonnage
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vessel_gross_tonnage ; ?> Ton
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Net registered tonnage
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vessel_net_tonnage ; ?> Ton
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Port of registry
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $portofregistry_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Plying limit 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php if($plying_limit!=0){ echo $plying_limit; } else { echo "nil"; } ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Name of owner
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo  $user_name  ; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Address of owner
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo  $user_address  ; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Details of master
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
--------------- 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
License number 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
--------------- 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of life buoy
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($number_of_lifebouy) { echo $number_of_lifebouy; } else  { echo 'nil'; } ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Description of life buoy
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
--------------- 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Particulars of passenger
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of passengers on
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont border-left border-primary pl-1"> 
When plying by night (smooth &amp; partially smooth water)
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
When plying by day or in canals by night and day (smooth &amp; partially smooth water)
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont border-left border-primary pl-1" >
When plying by day on voyages which do not last more than 6 hours (smooth water only)
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<?php for($i=1; $i<=3; $i++)  { ?>
<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
----
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
----
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
----
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
----
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<?php } ?>
<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<strong>Total (deck) </strong>
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
----
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
----
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
----
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
Second cabin passengers
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
----
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
----
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
----
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
Saloon passengers
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
----
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
----
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
----
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<strong>Total</strong>
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
----
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
----
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
----
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Equipment
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Bilge and hold pump
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($count_bilgepump!=0 ) { echo "YES"; } else{ echo "NO"; } ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Fire bucket
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
--------------- 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Boats of aggregate capacity 
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 

</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
--------------- 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >

</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Fire pumps
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($count_firepumps!=0 ) { echo "YES"; } else{ echo "NO"; } ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Capacity of fire pumps
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php if($capacity_of_firepump!=0 ) { echo $capacity_of_firepump ; } else{ echo "nil"; } ?>  
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Fire hose
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($number_of_hose!=0) { echo "YES"; } else  { echo "NO"; } ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Fire sandbox
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
--------------- 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of portable fire extinguishers
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($count_portablefire_extinguisher!=0 ) { echo $count_portablefire_extinguisher; } else{ echo "nil"; } ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Type of portable fire extinguishers
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php 

  echo implode(", ",$portable_fire_extinguisher_name);
  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
When plying as at A; life buoys and buoyancy apparatus
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
--------------- 
</div> <!-- end of col-3 2nd-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
When plying as at B; life buoys and buoyancy apparatus
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
--------------- 
</div> <!-- end of col-3 2nd-->
</div> <!-- end of row -->
<div class="row no-gutters evenrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
When plying as at C; life buoys and buoyancy apparatus
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
--------------- 
</div> <!-- end of col-3 2nd-->
</div> <!-- end of row -->




<div class="row no-gutters oddrow border-bottom" id="survey4">
<div class="col-12 d-flex justify-content-center mt-1 mb-1 text-primary formfont">
<button type="submit" class="btn btn-flat btn-sm btn-success btn-point" id="btnsubmit">Send &nbsp; <i class="fas fa-arrow-right"></i> </button>    
</div> <!-- end of col-3 2nd-->
</div> <!-- end of row -->




<!-- </form> --> <?php echo form_close(); ?>
</div>
</div>



<!-- end of form two view -->
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