<?php  
//print_r($vessel_details_viewpage);
//print_r($customer_details);
//print_r($equipment_details);

//print_r($engine_details);
//print_r($hull_details);
$sess_usr_id     = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');

$yes="Yes";
$no="No";
$nil="Nil";


/*_____________________Decoding Start___________________*/
$vessel_id1     = $this->uri->segment(4);
  $processflow_sl1  = $this->uri->segment(5);
  $survey_id1     = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 
/*_____________________Decoding End___________________*/

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

    $lower_deck_passenger       =     $res_vessel['lower_deck_passenger'];
    $upper_deck_passenger       =     $res_vessel['upper_deck_passenger'];
    $four_cruise_passenger      =     $res_vessel['four_cruise_passenger'];
    $first_aid_box              =     $res_vessel['first_aid_box'];
    $condition_of_equipment     =     $res_vessel['condition_of_equipment'];
    $repair_details_nature      =     $res_vessel['repair_details_nature'];

    $validity_fire_extinguisher1 =     $res_vessel['validity_fire_extinguisher'];
    $validity_of_insurance1      =     $res_vessel['validity_of_insurance'];
    $validity_of_certificate1    =     $res_vessel['validity_of_certificate'];
    $form10_remarks              =     $res_vessel['form10_remarks'];
     $owner_user_id          =      $res_vessel['user_id'];
     $user_master                =   $this->Survey_model->get_user_master($owner_user_id);
    $data['user_master']        =   $user_master;
    $owner_user_type_id         =   $user_master[0]['user_type_id'];
    $current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
    $data['current_status1']  =   $current_status1;
    //print_r($current_status1);
    $status_details_sl        =   $current_status1[0]['status_details_sl'];
$process_id        =   $current_status1[0]['process_id'];



    $validity_fire_extinguisher = date("d-m-Y", strtotime($validity_fire_extinguisher1));
    $validity_of_insurance      = date("d-m-Y", strtotime($validity_of_insurance1));
    $validity_of_certificate    = date("d-m-Y", strtotime($validity_of_certificate1));

    if($validity_fire_extinguisher=='01-01-1970')
    {
      $validity_fire_extinguisher="-";
    }
    else
    {
      $validity_fire_extinguisher=$validity_fire_extinguisher;
    }

    if($validity_of_insurance=='01-01-1970')
    {
      $validity_of_insurance="-";
    }
    else
    {
      $validity_of_insurance=$validity_of_insurance;
    }

    if($validity_of_certificate=='01-01-1970')
    {
      $validity_of_certificate="-";
    }
    else
    {
      $validity_of_certificate=$validity_of_certificate;
    }



    if(!empty($vessel_registry_port_id))
    {
       $portofregistry          =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
       $data['portofregistry']  =   $portofregistry;
       $portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
    }
    else
{
  $portofregistry_name="";
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
  @$natureofoperation_name        =   $cargo_nature_name[0]['natureofoperation_name'];

} 




//-----------Get number of lifebouy : equipment_id=8 tbl_kiv_equipment_details--------------//
$equipment_id8=8;
$lifebouy             =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id8,$survey_id);
$data['lifebouy']     =   $lifebouy;
if(!empty($lifebouy)) 
{
  @$number_of_lifebouy  =   $lifebouy[0]['number'];
}
else
{
  @$number_of_lifebouy  =0;
}



//-----------Get Buoyant apparatus : equipment_id=9 tbl_kiv_equipment_details--------------//
$equipment_id9=9;
$buoyant_apparatus             =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id9,$survey_id);
$data['buoyant_apparatus']     =   $buoyant_apparatus;
if(!empty($buoyant_apparatus)) 
{
  @$number_of_buoyant_apparatus  =   $buoyant_apparatus[0]['number'];
}
else
{
  @$number_of_buoyant_apparatus  =0;
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
  @$count_bilgepump  =$nil;
}



//-----------Get firepumps : tbl_kiv_firepumps_details  --------------//

$firepumps             =    $this->Survey_model->get_firepumps($vessel_id,$survey_id);
$data['firepumps']     =    $firepumps;
 
if(!empty($firepumps)) 
{
  @$count_firepumps       =    count($firepumps);
 foreach($firepumps as $key_firepump)
 {
    $firepumptype_id = $key_firepump['firepumptype_id'];


    $firepumptype_details         =   $this->Survey_model->get_firepumptype_name($firepumptype_id);
    $data['firepumptype_details'] =   $firepumptype_details;

     $firepumptype_name1[] =$firepumptype_details[0]['firepumptype_name'];
 }
   
   $firepumptype_name    = implode(", ",$firepumptype_name1);
 
}
else
{
  @$firepumptype_name  =$nil;
  @$count_firepumps=0;
}



//-----------Get number of hose : equipment_id=16 tbl_kiv_equipment_details--------------//
$equipment_id16=16;
$hose             =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id16,$survey_id);
$data['hose']     =   $hose;
if(!empty($hose)) 
{
  @$number_of_hose  =   $hose[0]['number'];
  
}
else
{
  @$number_of_hose  =0;
  }




//-----------Get portable fire exstinguisher : tbl_kiv_fire_extinguisher_details--------------//
$portablefire_extinguisher             =   $this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
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

     $portable_fire_extinguisher_name[] =$portablefire_extinguisher_type[0]['portable_fire_extinguisher_name'];
  }
}
else
{
  $portable_fire_extinguisher_name=$nil;
}



if(!empty($hull_details))
{
  foreach ($hull_details as $key_hull)
  {
     $hull_condition_status_id=$key_hull['hull_condition_status_id'];
    @$hullmaterial_id=$key_hull['hullmaterial_id'];

    if($hull_condition_status_id!=0)
     {
      $condition_status           =  $this->Survey_model->get_condition_status($hull_condition_status_id);
      $data['condition_status']   =   $condition_status;
      if(!empty($condition_status))
      {
              $conditionstatus_name=$condition_status[0]['conditionstatus_name'];

      }
      else
      {
        $conditionstatus_name=$nil;
      }
     }
     else
     {
       $conditionstatus_name=$nil;
     }
    

    if($hullmaterial_id=='9999')
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
else
{
  $conditionstatus_name=$nil;
  $hullmaterial_name    =$nil;
}


//-----------Get number of Anchors : equipment_id=1,2,3 tbl_kiv_equipment_details--------------//

$anchors             =   $this->Survey_model->get_equipment_details_anchors($vessel_id,$survey_id);
$data['anchors']     =   $anchors;
if(!empty($anchors)) 
{
 $number_of_anchors= count($anchors);
  
}
else
{
  $number_of_anchors=0;
}

//-----------Get number of Powerdriven :  tbl_kiv_firepumps_details --------------//
$firepumptype_id1=1;
$powerdriven             =   $this->Survey_model->get_firepumps_typenumber($vessel_id,$firepumptype_id1,$survey_id);
$data['powerdriven']     =   $powerdriven;
if(!empty($powerdriven)) 
{
 $number_of_powerdriven= $powerdriven[0]['number'];
}
else
{
  $number_of_powerdriven=0;
}

//-----------Get number of handpump :  tbl_kiv_firepumps_details --------------//
$firepumptype_id2=2;
$handpump             =   $this->Survey_model->get_firepumps_typenumber($vessel_id,$firepumptype_id2,$survey_id);
$data['handpump']     =   $handpump;
if(!empty($handpump)) 
{
 $number_of_handpump= $handpump[0]['number'];
}
else
{
  $number_of_handpump=0;
}

//-----------Get crew details :  tbl_kiv_crew_details --------------//

$crew_details             =   $this->Survey_model->get_crew_details($vessel_id,$survey_id);
$data['crew_details']     =   $crew_details;

//-----------Get Life Jacket : equipment_id=17 tbl_kiv_equipment_details--------------//
$equipment_id17=17;
$lifejacket             =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id17,$survey_id);
$data['lifejacket']     =   $lifejacket;
if(!empty($lifejacket)) 
{
  @$number_adult  =   $lifejacket[0]['number_adult'];
   @$number_children  =   $lifejacket[0]['number_children'];
}
else
{
   $number_adult  =   0;
   $number_children  =  0;
}

//-----------Get Life boat : equipment_id=18 tbl_kiv_equipment_details--------------//
$equipment_id18=18;
$life_boat             =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id18,$survey_id);
$data['life_boat']     =   $life_boat;
//print_r($life_boat);
if(!empty($life_boat)) 
{
  @$life_boat_number      =   $life_boat[0]['number'];
   @$life_boat_capacity   =   $life_boat[0]['capacity'];
}
else
{
   $life_boat_number  =   0;
   $life_boat_capacity  =  0;
}
//-----------Get Life boat : equipment_id=18 tbl_kiv_equipment_details--------------//
$equipment_id19=19;
$life_raft              =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id19,$survey_id);
$data['life_raft']      =   $life_raft;
if(!empty($life_raft)) 
{
    @$life_raft_number    =   $life_raft[0]['number'];
    @$life_raft_capacity  =   $life_raft[0]['capacity'];
}
else
{
   $life_raft_number  =   0;
   $life_raft_capacity  =  0;
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
//-----------Get oars  : equipment_id=56 tbl_kiv_equipment_details--------------//
$equipment_id56=11;
$oars              =   $this->Survey_model->get_equipment_details_edit($vessel_id,$equipment_id56,$survey_id);
$data['oars']      =   $oars;
if(!empty($oars)) 
{
    @$oars_number    =   $oars[0]['number'];
}
else
{
   $oars_number  =   0;
}

//----------Get fixed fire extinguisher: tbl_kiv_equipment_details---------------//
$equipment_type_id10=10;
      $fixed_fire_ext            =   $this->Survey_model->get_type_equipment_details_edit($vessel_id,$equipment_type_id10,$survey_id);
      $data['fixed_fire_ext']    =   $fixed_fire_ext;

  
//----------Get Garbage : tbl_kiv_garbage_bucket_provider_details---------------//

      $garbage_bucket            =   $this->Survey_model->get_garbage_bucket_provider($vessel_id,$survey_id);
      $data['garbage_bucket']    =   $garbage_bucket;

 //----------Get last drydock details : tbl_kiv_vessel_timeline ---------------//
      $subprocess_id=3;
      $vessel_timeline            =   $this->Survey_model->get_vessel_timeline_lastdrydock($vessel_id, $survey_id,$subprocess_id);
      $data['vessel_timeline']    =   $vessel_timeline;
     
      if(!empty($vessel_timeline))
      {
          $date_drydock=$vessel_timeline[0]['actual_date'];
        
           $last_drydock = date("d-m-Y", strtotime($date_drydock));

      }
      else
      {
        $last_drydock =$nil;
      }
                          
 //----------Get next drydock details : tbl_kiv_vessel_timeline ---------------//
      $subprocess_id=3;
      $vessel_timeline1            =   $this->Survey_model->get_vessel_timeline_nextdrydock($vessel_id, $survey_id,$subprocess_id);
      $data['vessel_timeline1']    =   $vessel_timeline1;
     
      if(!empty($vessel_timeline1))
      {
          $date_nextdock=$vessel_timeline1[0]['scheduled_date'];
        
           $next_drydock = date("d-m-Y", strtotime($date_nextdock));

      }
      else
      {
        $next_drydock =$nil;
      }


$additional_payment_details=$this->Survey_model->get_additional_payment_approved($vessel_id);
      $data['additional_payment_details'] =  $additional_payment_details;
      if(!empty($additional_payment_details))
      {
        $additional_payment=$additional_payment_details[0]['additional_payment_amount'];
        $additional_remarks=$additional_payment_details[0]['additional_payment_remarks'];
      }
      else
      {
        $additional_payment="";
        $additional_remarks="";
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

  <?php if($user_type_id ==14){ ?>
      <li class="breadcrumb-item"><a  class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1" > 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary" id="form3"><i class="fab fa-wpforms"></i>&nbsp; Form 10 </button>&nbsp;
</div>
<div class="col-6 d-flex justify-content-end">

<button class="btn-sm btn-flat btn btn-outline-success " id="printform"><i class="fas fa-print"></i>&nbsp; Print </button>
</div> <!-- end of button col -->
</div> <!-- end of row -->

<!-- get_survey_intimation_cs  -->
<!-- starting of form 3 view -->
<div class="row h-100 justify-content-center mt-3" id="form9view">
<div class="col-12">

<!-- <form name="form1" id="form1" method="post" action=""> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/form10_approve", $attributes);
?>





<!-- ____________________________ Vessel Details ____________________________ -->
<div class="col-12 py-2 d-flex justify-content-center text-primary"> <strong>FORM NO. 10</strong> </div>
<div class="col-12 py-2 d-flex justify-content-center "> <a href="" class="btn btn-sm btn-flat btn-outline-primary" role="button">[ See Rule 12 ] </a> </div> 

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-center mt-1 mb-1 text-white formfont">
CERTIFICATE OF SURVEY
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vessel_name; ?> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Registration number
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php if(!empty($vessel_registration_number)) { echo $vessel_registration_number; } else { echo "To be registered"; }  ?> 
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
Year of built
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php echo $vessel_yearofbuilt; ?> 
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
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Area of operation 
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $operation_area; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Nature of operation
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php if(!empty($cargo_nature)) { echo $cargo_nature; } else { echo $nil; } ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Extreme inner dimension of the vessel
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Length 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Breadth
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Depth
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">

</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo $vessel_length; ?> m
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $vessel_breadth; ?> m
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont" >
<?php echo $vessel_depth; ?> m
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Gross registered tonnage
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $vessel_gross_tonnage; ?> Ton
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Net registered tonnage 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $vessel_net_tonnage; ?> Ton
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Description of engine
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->
<?php
$i=1;
if(!empty($engine_details))
{
  
  foreach ($engine_details as $key_engine) 
  {
    
    $model_number         =   $key_engine['model_number'];
    $bhp                  =   $key_engine['bhp'];
    $engine_description   =   $key_engine['engine_description'];
   @$fuel_used_id         =   $key_engine['fuel_used_id'];
   if($fuel_used_id!=0) 
    {
      $fuel_details         =   $this->Survey_model->get_fuel($fuel_used_id);
      $data['fuel_details'] =   $fuel_details;
      if(!empty($fuel_details)){
              @$fuel_name            =   $fuel_details[0]['fuel_name'];

      }

    }
    else
    {
       @$fuel_name            = $nil;
    }
    

?>
<div class="row no-gutters text-dark border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-dark formfont">
Engine Number&nbsp;<?php echo $i; ?>
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Model number of engine
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php  echo $model_number; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
BHP 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php  echo $bhp; ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Fuel used
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $fuel_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Description of engine 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php  echo $engine_description; ?>  
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<?php 
 $i++;
  }
 
}
?>



<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Details of hull
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Is the hull of the vessel in good condition and fit for service
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $conditionstatus_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Material of the hull 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $hullmaterial_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Has the vessel been tested for stability and found safe for passenger service 
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php if($stability_test_status_id!=0) { echo $yes; } else { echo $no; } ?>
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->


<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Details of crew
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


 <div class="row no-gutters evenrow border-bottom">
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Type
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont"> 
 Name
</div> <!-- end of col-3 2nd-->
<!-- <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Address
</div>  -->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont" >
License Number 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<?php if(!empty($crew_details)) {

$i=1;
foreach($crew_details as $res) { ?>

 <div class="row no-gutters oddrow border-bottom">
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $res['crew_type_name'];?>
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
 <?php echo $res['name_of_type'];?>
</div> <!-- end of col-3 2nd-->
<!-- <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
Address
</div>  -->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont" >
<?php echo $res['license_number_of_type'];?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<?php  $i++; } } ?>








<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Details of life saving equipments 
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Whether there is life jacket
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php if(!empty($lifejacket)) { echo $yes; } else { echo $no; } ?>
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Adult
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if(!empty($number_adult)) { echo $number_adult; } else { echo $nil; } ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Children 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if(!empty($number_children)) { echo $number_children; } else { echo $nil; } ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Buoyant apparatus
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($number_of_buoyant_apparatus!=0) { echo $yes; } else  { echo $no; } ?> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number of life bouys 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if($number_of_lifebouy!=0) { echo $number_of_lifebouy; } else  { echo $nil; } ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of life boat
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if(@$life_boat_number!=0) { echo @$life_boat_number; } else  { echo $nil; } ?> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Total capacity of life boat 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if(@$life_boat_capacity) { echo @$life_boat_capacity; } else  { echo $nil; } ?> 
 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of life raft
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if(@$life_raft_number) { echo @$life_raft_number; } else  { echo $nil; } ?> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Total capacity of life raft
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if(@$life_raft_capacity) { echo $life_raft_capacity; } else  { echo $nil; } ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Details of fire fighting equipments 
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of fire extinguishers
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($count_portablefire_extinguisher!=0 ) { echo $count_portablefire_extinguisher; } else{ echo $nil; } ?>

</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number of fire pumps
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if($count_firepumps!=0 ) { echo $count_firepumps; } else{ echo $no; } ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of fire buckets
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if(@$fire_bucket_number!=0 ) { echo $fire_bucket_number; } else{ echo $no; } ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Fire pump type
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $firepumptype_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of fire hose with dual nozzle
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php if(@$number_of_hose!=0 ) { echo $number_of_hose; } else{ echo $no; } ?>
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->



<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Portable fire extinguishers
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont"> 
Number
</div> <!-- end of col-3 2nd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Capacity
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->

<?php if(!empty($portable_fire_ext))
{
  foreach ($portable_fire_ext as $key_port) 
  {
    $fire_extinguisher_type_id=$key_port['fire_extinguisher_type_id'];
       $portable_fire_ext_name_details     =   $this->Survey_model->get_portablefire_extinguisher_type($fire_extinguisher_type_id);
   $data['portable_fire_ext_name_details'] = $portable_fire_ext_name_details;
   $portable_fire_extinguisher_name=$portable_fire_ext_name_details[0]['portable_fire_extinguisher_name'];
    

?>
<div class="row no-gutters oddrow border-bottom">
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $portable_fire_extinguisher_name;  ?>
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo $key_port['fire_extinguisher_number']; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $key_port['fire_extinguisher_capacity']; ?>
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->
<?php 
  }
}
?>



<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Fixed fire extinguishers
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont"> 
Number
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Location
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Capacity
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->

<?php 
if(!empty($fixed_fire_ext))
{
    foreach ($fixed_fire_ext as $key ) {
    $equipment_id_fixed       =   $key['equipment_id'];

    $fixed_fire_name          =   $this->Survey_model->get_equipment_details_id($equipment_id_fixed);
    $data['fixed_fire_name']  =   $fixed_fire_name;
    if(!empty($fixed_fire_name)) {

  ?>
  <div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $fixed_fire_name[0]['equipment_name']; ?>
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> 
<?php echo @$key['number']; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo @$key['location']; ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo @$key['capacity']; ?>
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->
  <?php
}
}
}
?>



<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Other equipments
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of oars
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($oars_number!=0) { echo  $oars_number; } else { echo $nil; }?>

</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number of anchors
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if($number_of_anchors!=0) { echo  $number_of_anchors; } else { echo $nil; }?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Number of power driven
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
 <?php if($number_of_powerdriven!=0) { echo  $number_of_powerdriven; } else { echo $nil; } ?>

</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number of hand pump
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if($number_of_handpump!=0) { echo  $number_of_handpump; } else { echo $nil; } ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


 <div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Details of pollution control device
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
Details of garbage bucket provider 
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<?php 
if(!empty($garbage_bucket))
{
  @$garbage_id=$garbage_bucket[0]['garbage_id'];
  if($garbage_id!=0) {
 $garbage_details          =   $this->Survey_model->get_garbage_details_view($garbage_id);
    $data['garbage_details']  =   $garbage_details;
  }
    if(!empty($garbage_details)) {
    $garbage_name=$garbage_details[0]['garbage_name'];
    if($garbage_name)
    {
      $name=$garbage_name;
      $disp=$yes;
    }

  ?>
  <div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
<?php echo $name; ?>
</div> 
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $disp; ?>
</div> 
</div>
  <?php 
}
}
?>
<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Medical first aid box provider
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if($first_aid_box!=0) { echo $yes;} else {echo $no;}?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Are all equipments under rule
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if($condition_of_equipment!=0) { echo $yes;} else {echo $no;}?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Nature of repairs at the time of inspection
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php if($repair_details_nature!=0) { echo $repair_details_nature;} else {echo $nil;}?>
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
Passenger details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->




<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Lower deck
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php if ($lower_deck_passenger!=0) { echo $lower_deck_passenger; } else {echo $nil; } ?>

</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Upper deck
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php if ($upper_deck_passenger!=0) { echo $upper_deck_passenger; } else {echo $nil; } ?>

</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Four day cruise
</div> <!-- end of col-3 1st-->
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php if ($four_cruise_passenger!=0) { echo $four_cruise_passenger; } else {echo $nil; } ?>
</div> <!-- end of col-3 3rd-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Validity of insurance
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
 <?php echo $validity_of_insurance; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Validity of fire fighting extinguishers
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $validity_fire_extinguisher; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Date of last dry docking
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo $last_drydock; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Date of next dry docking
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $next_drydock; ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Period for which the certificate shall hold
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
 <?php echo $validity_of_certificate; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Remarks
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $form10_remarks; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Additional amount
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
 <?php echo $additional_payment; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Remarks for additional amount
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<?php echo $additional_remarks; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Validity of fire extinguisher
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
 <input type="date" name="validity_fire_extinguisher" value="" id="validity_fire_extinguisher"  class="form-control dob"  maxlength="10" autocomplete="off" title="Enter validity of fire extinguisher" placeholder="dd/mm/yyyy" data-validation="required" onpaste="return false;" required="required"/>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Validity of insurance
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
 <input type="date" name="validity_of_insurance" value="" id="validity_of_insurance"  class="form-control dob"  maxlength="10" autocomplete="off" title="Enter validity of insurance" placeholder="Enter validity of insurance" data-validation="required" onpaste="return false;" required="required"/>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Validity of certificate
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<input type="date" name="validity_of_certificate" value="" id="validity_of_certificate"  class="form-control dob"  maxlength="10" autocomplete="off" title="Enter validity of the certificate" placeholder="dd/mm/yyyy" data-validation="required" required="required" />
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Remarks
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
<textarea name="form10_remarks" id="form10_remarks" rows="5" cols="30" data-validation="required" onpaste="return false;" onkeypress="return IsAddress(event);" required="required"></textarea>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



 <div class="row no-gutters evenrow border-bottom" id="survey4">
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>"> 
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="owner_user_id" id="owner_user_id" value="<?php echo $owner_user_id; ?>">
<input type="hidden" name="owner_user_type_id" id="owner_user_type_id" value="<?php echo $owner_user_type_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="vessel_survey_number" id="vessel_survey_number" value="<?php echo $vessel_survey_number; ?>" >
<input type="hidden" id="vessel_registration_number" name="vessel_registration_number" value="<?php echo $vessel_registration_number; ?>" >
<div class="col-12 d-flex justify-content-center mt-1 mb-1 text-primary formfont">
<button type="submit" class="btn btn-flat btn-sm btn-success btn-point" id="btnsubmit">Approve &nbsp; </button>    
</div> 
</div> 
 
<!--  'validity_fire_extinguisher'=>$validity_fire_extinguisher,
      'validity_of_insurance'   =>$validity_of_insurance,
      'validity_of_certificate' =>$validity_of_certificate,
      'form10_remarks'      =>$form10_remarks, -->


<!-- </form> --> <?php echo form_close(); ?>
</div>
</div>



<!-- end of form two view -->
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->


<script language="javascript">
$(document).ready(function(){


});

</script>
