<?php  
//$user_type_id     = $this->session->userdata('user_type_id');
$user_type_id   = $this->session->userdata('int_usertype');

$yes="YES";
$no="NO";
$nil="nil";


/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$survey_id1         = $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id=$this->encrypt->decode($survey_id); 
/*_____________________Decoding End___________________*/

$survey_id1        = 1;

$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
if(!empty($current_status1)) 
{
  $status_details_sl        =   $current_status1[0]['status_details_sl'];

}

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
    @$vessel_total_tonnage      =     $res_vessel['vessel_total_tonnage'];
    @$vessel_gross_tonnage      =     $res_vessel['grt'];
    @$vessel_net_tonnage        =     $res_vessel['nrt'];
    $vessel_registration_number =     $res_vessel['vessel_registration_number'];
    $vessel_length              =     $res_vessel['vessel_length'];
    $vessel_breadth             =     $res_vessel['vessel_breadth'];
    $vessel_depth               =     $res_vessel['vessel_depth'];
    $vessel_yearofbuilt         =     $res_vessel['vessel_expected_completion'];
    $operation_area             =     $res_vessel['area_of_operation'];
    @$cargo_nature              =     $res_vessel['cargo_nature'];

    $sewage_treatment           =     $res_vessel['sewage_treatment'];
    $solid_waste                =     $res_vessel['solid_waste'];
    $sound_pollution            =     $res_vessel['sound_pollution'];
    $stability_test_status_id   =     $res_vessel['stability_test_status_id'];

    $stability_test_time        =     $res_vessel['stability_test_time'];
    $stability_test_duration    =     $res_vessel['stability_test_duration'];
    $clear_area_status          =     $res_vessel['clear_area_status'];
    $passenger_capacity         =     $res_vessel['passenger_capacity'];
    $capacity_visible           =     $res_vessel['capacity_visible'];
    $railing_status_id          =     $res_vessel['railing_status_id'];
    $log_book_status_id         =     $res_vessel['log_book_status_id'];

    $light_status_id            =     $res_vessel['light_status_id'];
    $engine_room_overheat_id    =     $res_vessel['engine_room_overheat_id'];
    $freeboard_height           =     $res_vessel['freeboard_height'];
    $repair_details             =     $res_vessel['repair_details'];
    $form6_remarks              =     $res_vessel['form6_remarks'];
    $declaration_issue_date1    =     $res_vessel['declaration_issue_date'];

    $declaration_issue_date     =     date("d-m-Y", strtotime($declaration_issue_date1));
    @$vessel_registry_port_id   =     $res_vessel['vessel_registry_port_id'];

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

//-----------Get Nature of operation name :  kiv_natureofoperation_master--------------//

if(!empty($cargo_nature))
{
  $cargo_nature_name             =   $this->Survey_model->get_cargo_nature_name($cargo_nature);
  $data['cargo_nature_name']     =   $cargo_nature_name;

  @$natureofoperation_name       =   $cargo_nature_name[0]['natureofoperation_name'];
} 




//-----------Get number of lifebouy : equipment_id=8 tbl_kiv_equipment_details--------------//
$equipment_id8=8;
$lifebouy               =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id8,$survey_id1);
$data['lifebouy']       =   $lifebouy;
if(!empty($lifebouy)) 
{
  @$number_of_lifebouy  =   $lifebouy[0]['number'];
}
else
{
  @$number_of_lifebouy  =   "";
}



//-----------Get Buoyant apparatus : equipment_id=9 tbl_kiv_equipment_details--------------//
$equipment_id9=9;
$buoyant_apparatus             =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id9,$survey_id1);
$data['buoyant_apparatus']     =   $buoyant_apparatus;
if(!empty($buoyant_apparatus)) 
{
  @$number_of_buoyant_apparatus  =   $buoyant_apparatus[0]['number'];
}
else
{
  @$number_of_buoyant_apparatus  = "";
}




//-----------Get bilgepump : tbl_kiv_bilgepump_details  --------------//

$bilgepump             =    $this->Survey_model->get_bilgepump($vessel_id,$survey_id1);
$data['bilgepump']     =    $bilgepump;
if(!empty($bilgepump)) 
{
  @$count_bilgepump      =    count($bilgepump);
}


//-----------Get firepumps : tbl_kiv_firepumps_details  --------------//

$firepumps             =    $this->Survey_model->get_firepumps($vessel_id,$survey_id1);
$data['firepumps']     =    $firepumps;
 
if(!empty($firepumps)) 
{
  @$count_firepumps       =    count($firepumps);
 foreach($firepumps as $key_firepump)
 {
    $firepumptype_id              =   $key_firepump['firepumptype_id'];
    $firepumptype_details         =   $this->Survey_model->get_firepumptype_name($firepumptype_id);
    $data['firepumptype_details'] =   $firepumptype_details;
     $firepumptype_name1[]        =   $firepumptype_details[0]['firepumptype_name'];
 }
   $firepumptype_name             =   implode(", ",$firepumptype_name1);
 
}


//-----------Get number of hose : equipment_id=16 tbl_kiv_equipment_details--------------//
$equipment_id16=16;
$hose             =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id16,$survey_id1);
$data['hose']     =   $hose;
if(!empty($hose)) 
{
  @$number_of_hose  =   $hose[0]['number'];
  
}


//-----------Get portable fire exstinguisher : tbl_kiv_fire_extinguisher_details--------------//
$portablefire_extinguisher             =   $this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id1,$survey_id);
$data['portablefire_extinguisher']     =   $portablefire_extinguisher;
@$count_portablefire_extinguisher    =    count($portablefire_extinguisher);
if(!empty($portablefire_extinguisher)) 
{
   foreach ($portablefire_extinguisher as $key ) 
  {
    @$type_of_portablefire_typeid           =   $key['fire_extinguisher_type_id'];
        //------Get portable fire exstinguisher type name :  kiv_portable_fire_extinguisher_master -----------//
    $portablefire_extinguisher_type         =   $this->Survey_model->get_portablefire_extinguisher_type($type_of_portablefire_typeid);
    $data['portablefire_extinguisher_type'] =   $portablefire_extinguisher_type;

     @$portable_fire_extinguisher_name[] =$portablefire_extinguisher_type[0]['portable_fire_extinguisher_name'];
  }
}

if(!empty($hull_details))
{
  foreach ($hull_details as $key_hull)
  {
    @$hull_condition_status_id=$key_hull['hull_condition_status_id'];
    @$hullmaterial_id=$key_hull['hullmaterial_id'];

    $condition_status           =  $this->Survey_model->get_condition_status($hull_condition_status_id);
    $data['condition_status']   =   $condition_status;
    @$conditionstatus_name=$condition_status[0]['conditionstatus_name'];


    if(($hullmaterial_id!='9999') || ($hullmaterial_id!='0'))
    {
       $hullmaterial           =  $this->Survey_model->get_hullmaterial();
       $data['hullmaterial']   =   $hullmaterial;
       foreach ($hullmaterial as $key) 
       {
         $hullmaterial_name[] = $key['hullmaterial_name'];
       }
        $hullmaterial_name    = implode(", ",$hullmaterial_name);
    }
    else
    {
      $hullmaterial           =  $this->Survey_model->get_hullmaterial_name($hullmaterial_id);
      $data['hullmaterial']   =   $hullmaterial; 
      $hullmaterial_name      =   $hullmaterial[0]['hullmaterial_name'];
    }  

  }
}


//-----------Get number of Anchors : equipment_id=1,2,3 tbl_kiv_equipment_details--------------//

$anchors             =   $this->Survey_model->get_equipment_details_anchors($vessel_id,$survey_id1);
$data['anchors']     =   $anchors;
if(!empty($anchors)) 
{
 $number_of_anchors= count($anchors);
  
}

//-----------Get number of Powerdriven :  tbl_kiv_firepumps_details --------------//
$firepumptype_id=1;
$powerdriven             =   $this->Survey_model->get_firepumps_typenumber($vessel_id,$firepumptype_id,$survey_id1);
$data['powerdriven']     =   $powerdriven;
if(!empty($powerdriven)) 
{
 $number_of_powerdriven= $powerdriven[0]['number'];
}

//-----------Get number of handpump :  tbl_kiv_firepumps_details --------------//
$firepumptype_id=2;
$handpump             =   $this->Survey_model->get_firepumps_typenumber($vessel_id,$firepumptype_id,$survey_id1);
$data['handpump']     =   $handpump;
if(!empty($handpump)) 
{
 $number_of_handpump= $handpump[0]['number'];
}

//-----------Get crew details :  tbl_kiv_crew_details --------------//

$crew_details             =   $this->Survey_model->get_crew_details($vessel_id,$survey_id1);
$data['crew_details']     =   $crew_details;

//-----------Get survey intimation :  tbl_kiv_survey_intimation --------------//

$survey_intimation          = $this->Survey_model->get_survey_intimation_details($vessel_id,$survey_id1);
$data['survey_intimation']  = $survey_intimation;
//print_r($survey_intimation);
if(!empty($survey_intimation))
{
  foreach ($survey_intimation as $key ) 
  {
    $defect_status=$key['defect_status'];
    $survey_defects_id=$key['survey_defects_id'];
     @$intimation_created_user_id  =   $survey_intimation[0]['intimation_created_user_id'];
      if($intimation_created_user_id!=0)
      {  
        $user_master            =   $this->Survey_model->get_user_master($intimation_created_user_id);
        $data['user_master']    =   $user_master;
        $name                   =   $user_master[0]['user_master_fullname'];
        $user_type_name         =   $user_master[0]['user_type_type_name'];
      }
    
    if($defect_status==0)
    {
      $date_of_survey        =   date("d-m-Y", strtotime($survey_intimation[0]['date_of_survey']));
      $time_of_survey        =   $survey_intimation[0]['time_of_survey'];
      @$placeofsurvey_id     =   $survey_intimation[0]['placeofsurvey_id'];

     
      if($placeofsurvey_id !=0)
      {
        $placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($placeofsurvey_id);
        $data['placeofsurvey']  =   $placeofsurvey;
        $placeofsurvey_name     =   $placeofsurvey[0]['placeofsurvey_name'];
      }
    }
      else
      {
        $survey_intimation_defects =   $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
        $data['survey_intimation_defects'] =   $survey_intimation_defects;

      $date_of_survey        =   date("d-m-Y", strtotime($survey_intimation_defects[0]['date_of_survey']));
      $time_of_survey        =   $survey_intimation_defects[0]['time_of_survey'];
      @$placeofsurvey_id     =   $survey_intimation_defects[0]['placeofsurvey_id'];
      if($placeofsurvey_id !=0)
      {
        $placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($placeofsurvey_id);
        $data['placeofsurvey']  =   $placeofsurvey;
        $placeofsurvey_name     =   $placeofsurvey[0]['placeofsurvey_name'];
      }

      }
  }
}

//-----------Get Sandbox :  tbl_kiv_equipment_details --------------//
 $equipment_id12=12;
 $equipment_type_id4=4;

 $equipment_details_sandbox         =   $this->Survey_model->get_type_equipment_details_view($vessel_id, $equipment_id12, $equipment_type_id4,$survey_id1);
  $data['equipment_details_sandbox']  =   $equipment_details_sandbox;
 // print_r($equipment_details_sandbox);
  if(!empty( $equipment_details_sandbox))
  {
    $msg="YES";
  }
  else
  {
    $msg="NO";
  }

  //-----------Get Life Jacket :  tbl_kiv_equipment_details --------------//
 $equipment_id17=17;
 $equipment_type_id11=11;
 
 $equipment_details_lifejkt         =   $this->Survey_model->get_type_equipment_details_view($vessel_id, $equipment_id17, $equipment_type_id11,$survey_id1);
  $data['equipment_details_lifejkt']  =   $equipment_details_lifejkt;
    if(!empty( $equipment_details_lifejkt))
  {
    $msg1="YES";
  }
  else
  {
    $msg1="NO";
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
  <?php  }?>
   <?php if($user_type_id ==12){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  }?>

  <?php if($user_type_id ==13){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  }?>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1" > 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary" id="form3"><i class="fab fa-wpforms"></i>&nbsp; Form 6 </button>&nbsp;
</div>
<div class="col-6 d-flex justify-content-end">

<button class="btn-sm btn-flat btn btn-outline-success " id="printform"><i class="fas fa-print"></i>&nbsp; Print </button>
</div> <!-- end of button col -->
</div> <!-- end of row -->


<!-- starting of form 3 view -->
<div class="row h-100 justify-content-center mt-3" id="form9view">
<div class="col-12">

<!-- <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/form6_entry_annaul/'.$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1 ?>"> -->
  
<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/form6_entry_annaul/".$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1, $attributes);
  ?>

<!-- ____________________________ Vessel Details ____________________________ -->
<div class="col-12 py-2 d-flex justify-content-center text-primary"> <strong>FORM NO. 6</strong> </div>
<div class="col-12 py-2 d-flex justify-content-center "> <a href="" class="btn btn-sm btn-flat btn-outline-primary" role="button">[ See Rule 9(1) ] </a> </div> 

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-center mt-1 mb-1 text-white formfont">
Declaration by Surveyor 
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
Registration number
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vessel_registration_number; ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $vessel_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Reference number
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php echo $reference_number; ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  Name of owner
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $user_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Address of owner
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $user_address; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">

<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left  formfont">
Length :</div> <!-- end of col-3 2nd-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
 <?php echo $vessel_length; ?> m
</div>
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark  formfont">
Breadth: </div> <!-- end of col-3 3rd--><div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
 <?php echo $vessel_breadth; ?> m
</div>

<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Depth: </div> <!-- end of col-3 4th--><div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo $vessel_depth; ?> m
</div>

<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark  pl-1 formfont">
Tonnage: 
</div> <!-- end of col-3 4th-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo $vessel_total_tonnage; ?> Ton
</div>
</div> <!-- end of row -->





<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Particulars of hull 
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Material of the hull 
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if(!empty($hullmaterial_name)) { echo $hullmaterial_name; } else { echo ""; }?> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
 Is the hull of the vessel in good condition and fit for service
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if(!empty($conditionstatus_name)) { echo $conditionstatus_name; } else { echo ""; }  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->




<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Particulars of stability test
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Time taken for stability test during trial run
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($stability_test_time!=0) { echo $stability_test_time. 'days'; } else { echo "nil"; } ?> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Duration for stability test during trial run
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if($stability_test_duration!=0) { echo $stability_test_duration. 'hours'; } else { echo "nil"; } ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Clear area
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($clear_area_status!=0) { echo $yes; } else { echo $no; } ?> 

</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Passenger capacity
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $passenger_capacity; ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Is the passenger capacity painted on boat visible for passenger
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($capacity_visible!=0) { echo $yes; } else { echo $no; } ?> 


</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Are protective railings provided wherever necessary 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >

<?php if($railing_status_id!=0) { echo $yes; } else { echo $no; } ?> 

</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Safety precautions taken
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Sandbox
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $msg; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Life jacket
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $msg1; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Life buoys
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($number_of_lifebouy) { echo $yes; } else  { echo $no; } ?> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Fire extinguishers 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if($count_portablefire_extinguisher!=0 ) { echo $yes; } else{ echo $no; } ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Buoyant apparatus
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php if($number_of_buoyant_apparatus!=0) { echo $yes; } else  { echo $no; } ?> 
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->



<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Arrangements for pollution control
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Sewage treatment and disposal 
</div> <!-- end of col-3 1st-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php if ($sewage_treatment==1) { echo $yes; } else {echo $no; } ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont"> 
Solid waste processing and disposal
</div> <!-- end of col-3 2nd-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary  formfont">
<?php if ($solid_waste==1) { echo $yes; } else {echo $no; } ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark text-primary border-left border-primary pl-1  formfont" >
Sound pollution control devices
</div> <!-- end of col-3 4th-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary  formfont">
<?php if ($sound_pollution==1) { echo $yes; } else {echo $no; } ?>
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->




<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Crew details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


 <div class="row no-gutters oddrow border-bottom">
 <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont">
#
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont pl-1">
Type
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont"> 
 Name
</div> <!-- end of col-3 2nd-->

<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont" >
License Number 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<?php 
if(!empty($crew_details)) {
 // print_r($crew_details);

$i=1;
foreach($crew_details as $res) { ?>

 <div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $i;?>
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo $res['crew_type_name'];?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $res['name_of_type'];?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont" >
<?php echo $res['license_number_of_type'];?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<?php  $i++; } } ?>


<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Is the log book properly maintained
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php if($log_book_status_id!=0) { echo $yes; } else  { echo $no; } ?> 
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->


<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Particulars of Engine 
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<?php

if(!empty($engine_details))
{
  @$count_engine       =    count($engine_details);
  foreach ($engine_details as $key_engine) 
  {

    @$fuel_used_id         =   $key_engine['fuel_used_id'];
    if($fuel_used_id!=0) 
    {
      $fuel_details           =   $this->Survey_model->get_fuel($fuel_used_id);
      $data['fuel_details']   =   $fuel_details;
      if(!empty($fuel_details))
      {
        $fuel_name1[]           =   $fuel_details[0]['fuel_name'];
      }
    }
    $manufacturer_name1[]   =   $key_engine['manufacturer_name'];
    $fuel_tank_material_condition_id[]   =   $key_engine['fuel_tank_material_condition_id'];


    }

   @$fuel_name             = implode(", ",$fuel_name1);
   @$manufacturer_name     = implode(", ",$manufacturer_name1);
   @$fuel_tank_material_condition_id     = implode(", ",$fuel_tank_material_condition_id1);


   } 

  
?>



<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Manufacturer name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if(!empty($manufacturer_name)) { echo $manufacturer_name; } else { echo ""; } ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number of engine
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php  if(!empty($count_engine)) { echo $count_engine ; } else { echo "0"; }   ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Fuel used
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if(!empty($fuel_name)) { echo $fuel_name ; } else { echo " "; }  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Are the fuel tank and fuel lines made of good material and properly leak proof 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php  if(!empty($fuel_tank_material_condition_id)) {echo $fuel_tank_material_condition_id; } else { echo " "; }  ?>  
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Is the engine room getting overheated 
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php if($engine_room_overheat_id!=0) { echo $yes; } else  { echo $no; } ?> 

</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Lights provided
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($light_status_id!=0) { echo $yes; } else  { echo $no; } ?> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Height of free board
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php  echo $freeboard_height; ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Any repair, renewals or alteration needed at the time of inspection
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $repair_details; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Remarks 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php  echo $form6_remarks; ?>  
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Declaration
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Certified that I have inspected the <?php echo $vessel_name; ?> on <?php if(!empty($date_of_survey)) { echo $date_of_survey;  } else {  echo ""; } ?> <?php if(!empty($time_of_survey)) { echo $time_of_survey;  } else { echo ""; }  ?> at <?php if(!empty($placeofsurvey_name)) { echo $placeofsurvey_name; } else { echo ""; }     ?> and found in good condition for issuing fitness certificate
</div> <!-- end of col-3 1st-->

</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom">
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Date :
</div> <!-- end of col-3 1st-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $declaration_issue_date; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-8 d-flex justify-content-end mt-1 mb-1 text-primary  formfont" >
Name of Officer :  <?php if(!empty($name)) { echo $name; } else { echo "";} ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Place :
</div> <!-- end of col-3 1st-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo @$portofregistry_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-8 d-flex justify-content-end mt-1 mb-1 text-primary  formfont" >
Designation of officer: <?php if(!empty($user_type_name)) { echo $user_type_name; } else { echo "";}  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">

<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
<input type="hidden" name="hdn_surveyId" id="hdn_surveyId" value="<?php echo $survey_id; ?>" >
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>"> 
<input type="hidden" name="user_id" id="user_id" value="<?php echo $vessel_details[0]['user_id']; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $vessel_details[0]['current_position']; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">

</div> 
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 

<input class="btn btn-flat btn-sm btn-success" type="submit" name="btnsubmit" value="Submit">
</div> 
<div class="col-4 d-flex justify-content-end mt-1 mb-1 text-primary  formfont" >

</div> 
</div> 

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