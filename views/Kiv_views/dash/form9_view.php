<?php  
//$user_type_id     = $this->session->userdata('user_type_id');
$user_type_id   = $this->session->userdata('int_usertype');


/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$survey_id1         = $this->uri->segment(5);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id=$this->encrypt->decode($survey_id); 
/*_____________________Decoding End___________________*/



$owner_user_id            =   $initial_data[0]['vessel_user_id'];
$process_id               =   $initial_data[0]['process_id'];

$user_type_id1= $this->Survey_model->get_user_master($owner_user_id);
$data['user_type_id1']  =   $user_type_id1;
if(!empty($user_type_id1))
{
  $owner_user_type_id        =   $user_type_id1[0]['user_type_id'];
}


/*$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];
  */

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
    @$vessel_gross_tonnage    =   $res_vessel['grt'];
    @$vessel_net_tonnage      =   $res_vessel['nrt'];
    @$boats_aggregate_capacity      =   $res_vessel['boats_aggregate_capacity'];

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
//print_r($lifebouy);
if(!empty($lifebouy)) 
{
  @$number_of_lifebouy  =   $lifebouy[0]['number'];
}
else
{
   @$number_of_lifebouy  =0;
}

//-----------Get bilgepump : tbl_kiv_bilgepump_details  --------------//

$bilgepump             =    $this->Survey_model->get_bilgepump($vessel_id,$survey_id);
$data['bilgepump']     =    $bilgepump;
if(!empty($bilgepump)) 
{
  @$count_bilgepump      =    count($bilgepump);
  
}
else
{
  @$count_bilgepump  =0;
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
$portable_fire_ext             =   $this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
$data['portable_fire_ext']     =   $portable_fire_ext;
//print_r($portable_fire_ext);
if(!empty($portable_fire_ext)) 
{
   @$count_portablefire_extinguisher    =    count($portable_fire_ext);
   foreach ($portable_fire_ext as $key ) 
  {
    @$type_of_portablefire_typeid           =   $key['fire_extinguisher_type_id'];
        //------Get portable fire exstinguisher type name :  kiv_portable_fire_extinguisher_master -----------//
    $portablefire_extinguisher_type         =   $this->Survey_model->get_portablefire_extinguisher_type($type_of_portablefire_typeid);
    $data['portablefire_extinguisher_type'] =   $portablefire_extinguisher_type;
//print_r($portablefire_extinguisher_type);
     $portable_fire_extinguisher_typename1[] =$portablefire_extinguisher_type[0]['portable_fire_extinguisher_name'];
  }

  $portable_fire_extinguisher_typename    = implode(", ",$portable_fire_extinguisher_typename1);
}

else
{
    $count_portablefire_extinguisher=0;

  $portable_fire_extinguisher_typename=$nil;
}

//echo $portable_fire_extinguisher_typename;

//master
$crew_type_sl=1;
$crew_details_master             =   $this->Survey_model->get_crew_details_master_serang($vessel_id, $survey_id,$crew_type_sl);
$data['crew_details_master']     =   $crew_details_master;
if(!empty($crew_details_master))
{
  $license_number_of_type=$crew_details_master[0]['license_number_of_type'];
   $crew_type_name=$crew_details_master[0]['crew_type_name'];
}

//____________Plying State_____________________//
$buoyancy_apparatus              =   $this->Survey_model->get_buoyancy_apparatus($vessel_id, $survey_id);
$data['buoyancy_apparatus']     =   $buoyancy_apparatus;
if(!empty($buoyancy_apparatus))
{
  $lifebuoys_plyingA=$buoyancy_apparatus[0]['lifebuoys_plyingA'];
   $lifebuoys_plyingB=$buoyancy_apparatus[0]['lifebuoys_plyingB'];
   $lifebuoys_plyingC=$buoyancy_apparatus[0]['lifebuoys_plyingC'];

}
else
{
  $lifebuoys_plyingA=0;
   $lifebuoys_plyingB=0;
   $lifebuoys_plyingC=0;
}


$passenger_details=$this->Survey_model->get_passenger_details($vessel_id,$survey_id);
$data['passenger_details']=$passenger_details;
if(!empty($passenger_details))
{
  $plying_night_upperdeck   = $passenger_details[0]['plying_night_upperdeck'];
  $plying_daynight_upperdeck  = $passenger_details[0]['plying_daynight_upperdeck'];
  $plying_halfday_upperdeck   = $passenger_details[0]['plying_halfday_upperdeck'];
  $plying_night_inbwdeck    = $passenger_details[0]['plying_night_inbwdeck'];
  $plying_daynight_inbwdeck   = $passenger_details[0]['plying_daynight_inbwdeck'];
  $plying_halfday_inbwdeck  = $passenger_details[0]['plying_halfday_inbwdeck'];
  $plying_night_maindeck    = $passenger_details[0]['plying_night_maindeck'];
  $plying_daynight_maindeck   = $passenger_details[0]['plying_daynight_maindeck'];
  $plying_halfday_maindeck  = $passenger_details[0]['plying_halfday_maindeck'];
  $plying_night_secondcabin   = $passenger_details[0]['plying_night_secondcabin'];
  $plying_daynight_secondcabin= $passenger_details[0]['plying_daynight_secondcabin'];
  $plying_halfday_secondcabin = $passenger_details[0]['plying_halfday_secondcabin'];
  $plying_night_saloon    = $passenger_details[0]['plying_night_saloon'];
  $plying_daynight_saloon   = $passenger_details[0]['plying_daynight_saloon'];
  $plying_halfday_saloon    = $passenger_details[0]['plying_halfday_saloon'];


}

//-----------Get fire buckets  : equipment_id=11 tbl_kiv_equipment_details--------------//
$equipment_id11=11;
$fire_bucket              =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id11,$survey_id);
$data['fire_bucket']      =   $fire_bucket;
if(!empty($fire_bucket)) 
{
    @$fire_bucket_number    =   $fire_bucket[0]['number'];
}
else
{
   $fire_bucket_number  =   0;
}

//-----------Get fire sand boxes  : equipment_id=12 tbl_kiv_equipment_details--------------//
$equipment_id12=12;
$fire_sandbox              =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id12,$survey_id);
$data['fire_sandbox']      =   $fire_sandbox;
//print_r($fire_sandbox);
if(!empty($fire_sandbox)) 
{
    @$fire_sandbox_number    =   $fire_sandbox[0]['number'];
}
else
{
   $fire_sandbox_number  =   0;
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
echo form_open("Kiv_Ctrl/Survey/form9_view", $attributes);
?>
<!-- <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id ; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php //echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $owner_user_id; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $owner_user_type_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">  -->
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
<?php echo $crew_type_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
License number 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php echo $license_number_of_type; ?>

</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of life buoy
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($number_of_lifebouy!=0) { echo $number_of_lifebouy; } else  { echo 'nil'; } ?>
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

<!-- $plying_night_upperdeck   = $passenger_details[0]['plying_night_upperdeck'];
  $plying_daynight_upperdeck  = $passenger_details[0]['plying_daynight_upperdeck'];
  $plying_halfday_upperdeck   = $passenger_details[0]['plying_halfday_upperdeck'];

  $plying_night_inbwdeck    = $passenger_details[0]['plying_night_inbwdeck'];
  $plying_daynight_inbwdeck   = $passenger_details[0]['plying_daynight_inbwdeck'];
  $plying_halfday_inbwdeck  = $passenger_details[0]['plying_halfday_inbwdeck'];

  $plying_night_maindeck    = $passenger_details[0]['plying_night_maindeck'];
  $plying_daynight_maindeck   = $passenger_details[0]['plying_daynight_maindeck'];
  $plying_halfday_maindeck  = $passenger_details[0]['plying_halfday_maindeck'];

  $plying_night_secondcabin   = $passenger_details[0]['plying_night_secondcabin'];
  $plying_daynight_secondcabin= $passenger_details[0]['plying_daynight_secondcabin'];
  $plying_halfday_secondcabin = $passenger_details[0]['plying_halfday_secondcabin'];

  $plying_night_saloon    = $passenger_details[0]['plying_night_saloon'];
  $plying_daynight_saloon   = $passenger_details[0]['plying_daynight_saloon'];
  $plying_halfday_saloon    = $passenger_details[0]['plying_halfday_saloon']; -->

<?php //for($i=1; $i<=3; $i++)  { ?>


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
On between deck, if any
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
<?php echo $plying_night_inbwdeck;  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $plying_daynight_inbwdeck;  ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
<?php echo $plying_halfday_inbwdeck;  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
On main deck
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
<?php echo $plying_night_maindeck;  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $plying_daynight_maindeck;  ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
<?php echo $plying_halfday_maindeck;  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
On the upper deck/bridge
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
<?php echo $plying_night_upperdeck;  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $plying_daynight_upperdeck;  ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
<?php echo $plying_halfday_upperdeck;  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->





<?php //} ?>


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<strong>Total (deck) </strong>
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> <b>
<?php echo $t1= ($plying_night_inbwdeck+$plying_night_maindeck+$plying_night_upperdeck);?></b>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"><b>
<?php echo $t2= ($plying_daynight_inbwdeck+$plying_daynight_maindeck+$plying_daynight_upperdeck);?></b>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" ><b>
<?php echo $t3=($plying_halfday_inbwdeck+$plying_halfday_maindeck+$plying_halfday_upperdeck);?></b>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
Second cabin passengers
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
<?php echo $plying_night_secondcabin;  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $plying_daynight_secondcabin;  ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
<?php echo $plying_halfday_secondcabin;  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
Saloon passengers
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> 
<?php echo $plying_night_saloon;  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $plying_daynight_saloon;  ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" >
<?php echo $plying_halfday_saloon;  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<strong>Total</strong>
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1"> <b>
<?php echo ($t1+$plying_night_secondcabin+$plying_night_saloon); ?></b>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"><b>
<?php echo ($t2+$plying_daynight_secondcabin+$plying_daynight_saloon); ?></b>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1" ><b>
<?php echo ($t2+$plying_halfday_secondcabin+$plying_halfday_saloon); ?></b>
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
<?php if(@$fire_bucket_number!=0 ) { echo $fire_bucket_number; } else{ echo "No"; } ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Boats of aggregate capacity 
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 

</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $boats_aggregate_capacity; ?>
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
<?php if($fire_sandbox_number!=0) { echo $fire_sandbox_number; } else  { echo $nil; } ?>
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

  echo $portable_fire_extinguisher_typename;
  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
When plying as at A; life buoys and buoyancy apparatus
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo $lifebuoys_plyingA; ?> 
</div> <!-- end of col-3 2nd-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
When plying as at B; life buoys and buoyancy apparatus
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo $lifebuoys_plyingB; ?>  
</div> <!-- end of col-3 2nd-->
</div> <!-- end of row -->
<div class="row no-gutters evenrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
When plying as at C; life buoys and buoyancy apparatus
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo $lifebuoys_plyingC; ?>  
</div> <!-- end of col-3 2nd-->
</div> <!-- end of row -->




<!-- <div class="row no-gutters oddrow border-bottom" id="survey4">
<div class="col-12 d-flex justify-content-center mt-1 mb-1 text-primary formfont">
<button type="submit" class="btn btn-flat btn-sm btn-success btn-point" id="btnsubmit">Send &nbsp; <i class="fas fa-arrow-right"></i> </button>    
</div> 
</div> 

 -->


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