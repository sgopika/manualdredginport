<?php 

//print_r($vessel_details);
if(!empty($vessel_details))
{
  $official_number            =   $vessel_details[0]['official_number'];
  $reference_number           =   $vessel_details[0]['reference_number'];
  @$vessel_registry_port_id   =   $vessel_details[0]['vessel_registry_port_id'];
  $process_id                 =   $vessel_details[0]['process_id'];
  $vessel_id                  =   $vessel_details[0]['vessel_id'];
  $processflow_sl             =   $vessel_details[0]['processflow_sl'];
  $survey_id                  =   $vessel_details[0]['survey_id'];
}


$survey_id1     = 1;
$survey_id0=0;

$user_type_id1 = $this->session->userdata('int_usertype');

$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];




$registry_port_id            =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
$data['registry_port_id']    =   $registry_port_id;

if(!empty($registry_port_id))
{
  $registry_name=$registry_port_id[0]['vchr_portoffice_name'];
}
else
{
  $registry_name="";
}

$survey             =   $this->Survey_model->get_survey_type($survey_id);
$data['survey']     =   $survey;

if(!empty($survey))
{
  $survey_name=$survey[0]['survey_name'];
}


$yes="YES";
$no="NO";
$nil="nil";

//print_r($vessel_details_viewpage);
 //----------- Vessel Details -----------//
foreach($vessel_details_viewpage as $res_vessel)
{
  $vessel_name            = $res_vessel['vessel_name'];
  $vessel_length          = $res_vessel['vessel_length'];
  $vessel_breadth         = $res_vessel['vessel_breadth'];
  $vessel_depth           = $res_vessel['vessel_depth'];
  $vessel_expected_tonnage= $res_vessel['vessel_expected_tonnage'];
  $vessel_total_tonnage   = $res_vessel['vessel_total_tonnage'];
  
  $vessel_category_id     = $res_vessel['vessel_category_id'];
  $vessel_subcategory_id  = $res_vessel['vessel_subcategory_id'];
  $vessel_type_id         = $res_vessel['vessel_type_id'];
  $vessel_subtype_id      = $res_vessel['vessel_subtype_id'];
    $sewage_treatment     = $res_vessel['sewage_treatment'];
     
    $solid_waste          = $res_vessel['solid_waste'];
    $sound_pollution      = $res_vessel['sound_pollution'];
    $water_consumption    = $res_vessel['water_consumption'];
    $source_of_water      = $res_vessel['source_of_water'];
    $vessel_id            = $res_vessel['vessel_sl'];
    //$user_id              = $res_vessel['vessel_created_user_id'];
    $user_id              = $res_vessel['user_id'];
    $reference_number= $res_vessel['reference_number'];

    $user_type_details          = $this->Survey_model->get_user_type_id($user_id);
  $data['user_type_details']    = $user_type_details;
  $user_type_id                 = $user_type_details[0]['user_master_id_user_type'];
//echo $res_vessel['vessel_pref_inspection_date'];

    $vessel_pref_inspection_date=date("d-m-Y", strtotime($res_vessel['vessel_pref_inspection_date']));

                
                
    if(($vessel_type_id==1) || ($vessel_type_id==7 && $vessel_subtype_id==3) )
    {
        $length_overall=$res_vessel['vessel_length_overall'];
    }
    else
    {
         $length_overall=0;
    }
                 
                
    if($sewage_treatment!=0)
    { $res_sewage_treatment='YES'; }
    else { $res_sewage_treatment='NO'; }
                    
    if($solid_waste!=0)
        { $res_solid_waste='YES'; }
    else { $res_solid_waste='NO'; }  
                    
    if($sound_pollution!=0)
    { $res_sound_pollution='YES'; }
    else { $res_sound_pollution='NO'; } 

    if( $source_of_water!=0)  
    {
      $get_sourceof_water       =   $this->Function_model->get_sourceof_water($source_of_water);
    $data['get_sourceof_water']   = $get_sourceof_water;
    $source_of_water_name     = $get_sourceof_water[0]['sourceofwater_name'];
    }
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
  /*else
  {
    $vessel_subcategory_name='-';
  }*/
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


foreach($customer_details as $res_owner)
{
  $owner_name   = $res_owner['user_name'];
  $owner_address  = $res_owner['user_address'];
}
         
 //----------- Hull Details -----------//
foreach($hull_details as $res_hull)
{
  $hull_name        = $res_hull['hull_name'];
  $hull_address     = $res_hull['hull_address'];
  $hullmaterial_id  = $res_hull['hullmaterial_id'];

  $hull_year_of_built1              =   $res_hull['hull_year_of_built'];
    $hull_year_of_built=date("d-m-Y", strtotime($hull_year_of_built1));

    $builder_certificate_document    =   $res_hull['builder_certificate_document'];

     if($builder_certificate_document==NULL)
    {
      $builder_certificate='<font color="#7a29c6">  <b> No </b>  </font>';
    }
    else 
    {
      $builder_certificate='<font color="#7a29c6"> <a href="'.base_url().'uploads/BuilderCertificate/'.$builder_certificate_document.'" download> <b> Yes </b> </a> </font>';
    }



/*  if($hullmaterial_id!=0)
  {
    $get_hullmaterial_id          =   $this->Survey_model->get_hullmaterial_name($hullmaterial_id);
    $data['get_hullmaterial_id']  =   $get_hullmaterial_id;
    @$hullmaterial_name            =   $get_hullmaterial_id[0]['hullmaterial_name'];
  }
  else
  {
    $hullmaterial_name='-';
  }*/


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



    

  $deck_status_id=$res_hull['deck_status_id'];

  if($deck_status_id=='1')
  {
    $deck_msg='YES';
  }
  else
  {
    $deck_msg='No';
  }

  $bulk_heads           = $res_hull['bulk_heads'];
  $bulk_head_placement  = $res_hull['bulk_head_placement'];

  if($bulk_head_placement!=0)
  {
    $bulk_head_placement_name         =   $this->Survey_model->get_bulk_head_placement_name($bulk_head_placement);
    $data['bulk_head_placement_name'] =   $bulk_head_placement_name;
    $location_name                    =   $bulk_head_placement_name[0]['location_name'];
  }
  else
  {
    $location_name='-';
  }
    $bulk_head_thickness        = $res_hull['bulk_head_thickness'];
    $hullplating_material_id    = $res_hull['hullplating_material_id'];

  if($hullplating_material_id!=0)
  {
    $hullplating_material_id        =   $this->Survey_model->get_hullplating_material_name($hullplating_material_id);
    $data['hullplating_material_id']=   $hullplating_material_id;
    $hullplating_material_name      =   $hullplating_material_id[0]['hullplating_material_name'];
  }
  else
  {
    $hullplating_material_name='-';
  }

  $hull_plating_material_thickness  =   $res_hull['hull_plating_material_thickness'];
  $hull_bulkhead_details            =   $this->Function_model->get_hull_bulkhead_details($vessel_id,$survey_id);
  $data['hull_bulkhead_details']    =   $hull_bulkhead_details;
} 
         
  //----------- Engine Details -----------//  
   
    //----------- Equipment Details -----------// 
foreach($equipment_details as $res_equipment)
{
   $equipment_id  = $res_equipment['equipment_id'];
   $vessel_id     = $res_equipment['vessel_id'];
}

//----anchor port-----//
$get_anchor_port      =   $this->Function_model->get_anchor_port($vessel_id,1,$survey_id);
$data['get_anchor_port']  = $get_anchor_port;
       
foreach($get_anchor_port as $res_anchor_port) 
{
    $weight_anchor_port     = $res_anchor_port['weight'];
    $material_id_anchor_port  = $res_anchor_port['material_id'];

    if($material_id_anchor_port!=0)
    {
      $equipment_material     =   $this->Function_model->get_equipment_material_name($material_id_anchor_port);
    $data['equipment_material'] = $equipment_material;
      $equipment_material_name  = $equipment_material[0]['equipment_material_name'];
    }
}
                          
//-------Anchor Startboard---------//
$anchor_startboard      =   $this->Function_model->get_anchor_startboard($vessel_id,2,$survey_id);
$data['anchor_startboard']  = $anchor_startboard;

foreach($anchor_startboard as $res_star_board) 
{
  $weight_star_board      = $res_star_board['weight'];
  $material_id_star_board   = $res_star_board['material_id'];
  if($material_id_star_board!=0)
  {
    $equipment_material         =   $this->Function_model->get_equipment_material_name($material_id_star_board);
    $data['equipment_material']     = $equipment_material;
    $equipment_material_starboard_name  = $equipment_material[0]['equipment_material_name'];
  }
} 
//-------Anchor Spare---------//
$get_anchor_spare     =   $this->Function_model->get_anchor_spare($vessel_id,3,$survey_id1);
$data['anchor_spare'] = $get_anchor_spare;

foreach($get_anchor_spare as $res_anchor_spare) 
{
  $weight_anchor_spare    = $res_anchor_spare['weight'];
  $material_id_anchor_spare   = $res_anchor_spare['material_id'];
  if($material_id_anchor_spare!=0)
  {
    $equipment_material       =   $this->Function_model->get_equipment_material_name($material_id_anchor_spare);
    $data['equipment_material']   = $equipment_material;
    $equipment_material_spare_name  = $equipment_material[0]['equipment_material_name'];
  }
}
                          
                          
//-------Chain Port---------//
$get_chain_port     =   $this->Function_model->get_chain_port($vessel_id,4,$survey_id1);
$data['get_chain_port'] = $get_chain_port;

$chainport_test_certificate    =   $get_chain_port[0]['chainport_test_certificate'];

     if($chainport_test_certificate==NULL)
    {
      $chainport_test_certificatename='<font color="#7a29c6">  <b> No </b>  </font>';
    }
    else 
    {
      $chainport_test_certificatename='<font color="#7a29c6"> <a href="'.base_url().'uploads/Chain_Port_Certificate/'.$chainport_test_certificate.'" download> <b> Yes </b> </a> </font>';
    }



foreach($get_chain_port as $res_chain_port) 
{
  $size_chain_port  = $res_chain_port['size'];
  $length_chain_port  = $res_chain_port['length'];
  //$equipment_type_id_chain_port=$res_chain_port['equipment_type_id'];
  $equipment_type_id_chain_port=$res_chain_port['chainport_type_id'];


  if($equipment_type_id_chain_port!=0)
  {
    $equipment_type_chainport     =   $this->Function_model->get_chainporttype_name($equipment_type_id_chain_port);
    $data['equipment_type_chain_port']  = $equipment_type_chainport;
    $type_name_chain_port         = $equipment_type_chainport[0]['chainporttype_name'];
  }
  else
  { 
    $type_name_chain_port='-';
  }
}  

//-------Chain startboard---------//
$get_chain_startboard     =   $this->Function_model->get_chain_startboard($vessel_id,5,$survey_id1);
$data['chain_startboard'] = $get_chain_startboard;


$chainstarboard_test_certificate    =   $get_chain_startboard[0]['chainstarboard_test_certificate'];

     if($chainstarboard_test_certificate==NULL)
    {
      $chainstarboard_test_certificatename='<font color="#7a29c6">  <b> No </b>  </font>';
    }
    else 
    {
      $chainstarboard_test_certificatename='<font color="#7a29c6"> <a href="'.base_url().'uploads/Chain_Port_Certificate/'.$chainstarboard_test_certificate.'" download> <b> Yes </b> </a> </font>';
    }


foreach($get_chain_startboard as $res_chain_startboard) 
{
  $size_chain_startboard    = $res_chain_startboard['size'];
  $length_chain_startboard  = $res_chain_startboard['length'];
  //$equipment_type_id_chain_startboard=$res_chain_startboard['equipment_type_id'];
  $equipment_type_id_chain_startboard=$res_chain_startboard['chainport_type_id'];


  if($equipment_type_id_chain_startboard!=0)
  {
    $equipment_type_chainstartboard     =   $this->Function_model->get_chainporttype_name($equipment_type_id_chain_startboard);
    $data['equipment_type_chain_startboard']= $equipment_type_chainstartboard;
    @$type_name_chain_startboard      = $equipment_type_chainstartboard[0]['chainporttype_name'];
  }
    else
    { 
      $type_name_chain_startboard ='-';
    } 
}
                         
                          
//------- Rope---------//
$get_chain_Rope   =   $this->Function_model->get_chain_Rope($vessel_id,6,$survey_id1);
$data['chain_Rope'] = $get_chain_Rope;

foreach($get_chain_Rope as $res_chain_Rope) 
{
  $size_chain_Rope  = $res_chain_Rope['size'];
  $number_chain_Rope  = $res_chain_Rope['number'];
  $material_id_Rope   = $res_chain_Rope['material_id'];
  if($material_id_Rope!=0)
  {
    $equipment_material_rope      =   $this->Function_model->get_rope_material_name($material_id_Rope);
    $data['equipment_material_rope']  = $equipment_material_rope;
    $equipment_material_rope_name     = $equipment_material_rope[0]['ropematerial_name'];
  }
}  
//------- Search Light---------//
$get_searchlight    =   $this->Function_model->get_searchlight($vessel_id,7,$survey_id1);
$data['searchlight']  = $get_searchlight;

foreach($get_searchlight as $res_searchlight) 
{
  $size_searchlight     = $res_searchlight['size'];
  $power_searchlight    = $res_searchlight['power'];
  $number_searchlight   = $res_searchlight['number'];
  if($size_searchlight!=0)
  {
    $searchlight_size     =   $this->Function_model->get_searchlight_size($size_searchlight);
    $data['searchlight_size'] = $searchlight_size;
    $searchlight_size_name    = $searchlight_size[0]['searchlight_size_name'];
  }
  else
  { 
    $searchlight_size_name='-';
  }
}

//------------- Life Buoys----------//
$get_lifebuoys      =   $this->Function_model->get_lifebuoys($vessel_id,8,$survey_id1);
$data['get_lifebuoys']  = $get_lifebuoys;
$number1        = $get_lifebuoys[0]['number'];

if($number1!=0)
{
  $number_lifebuoys =$number1;
}
else
 {
   $number_lifebuoys='-'; 
}           
      
                                
     

//---------- Buoyant apparatus ---------//
$get_buoyant_apparatus      =   $this->Function_model->get_buoyant_apparatus($vessel_id,9,$survey_id1);
$data['get_buoyant_apparatus']  = $get_buoyant_apparatus;
$number2            = $get_buoyant_apparatus[0]['number'];

if($number1!=0)
{
  $number_buoyant_apparatus=$number2;
}
else
 {
   $number_buoyant_apparatus='-'; 
}   
                          
//-----Navigation Light Particulars--------//
$navigation_light       =   $this->Function_model->get_navigation_light_view($vessel_id,$survey_id1);
$data['navigation_light'] = $navigation_light;


//-----Sound Signals--------//
$sound_signal         =   $this->Function_model->get_sound_signal_view($vessel_id,$survey_id1);
$data['sound_signal']   = $sound_signal;

//-----Fire Pumps---//  

$get_fire_pumps       =   $this->Function_model->get_fire_pumps($vessel_id,13,$survey_id1);
$data['get_fire_pumps']   = $get_fire_pumps;



//-----Fire Mains---//  
$get_fire_mains       =   $this->Function_model->get_fire_mains($vessel_id,14,$survey_id1);
$data['get_fire_mains']   = $get_fire_mains;

                          
foreach($get_fire_mains as $res_fire_mains) 
{
  $diameter_fire_mains  = $res_fire_mains['diameter'];
  $material_id_fire_mains = $res_fire_mains['material_id'];

  if($material_id_fire_mains!=0)
  {
    $equipment_material_firemain      =   $this->Function_model->get_equipment_material_name($material_id_fire_mains);
    $data['equipment_material_firemain']  = $equipment_material_firemain;
    $equipment_material_firemains       = $equipment_material_firemain[0]['equipment_material_name'];
  }
}  
//-----Hydrants---//  
$get_hydrants       =   $this->Function_model->get_hydrants($vessel_id,15,$survey_id1);
$data['get_hydrants'] = $get_hydrants;  
@$hydrant_number    = $get_hydrants[0]['number'];

//-----Hose---//  
$get_hose         =   $this->Function_model->get_hose($vessel_id,16,$survey_id1);
$data['get_hose']   = $get_hose;  
@$hose_number       = $get_hose[0]['number'];


//-------------- portable fire extinguisher-----------------//tbl_kiv_fire_extinguisher_details
$get_portable_fire      =   $this->Function_model->get_fire_extinguisher_details($vessel_id,$survey_id1);
$data['get_portable_fire']  = $get_portable_fire;  

//----------------Communication Equipment---------------//
$get_communication_equipment      =   $this->Function_model->get_communication_equipment($vessel_id,5,$survey_id1);
$data['get_communication_equipment']  = $get_communication_equipment;

//----------------Navigation Equipment---------------//
$get_navigation_equipment         =   $this->Function_model->get_navigation_equipment($vessel_id,6,$survey_id1);
$data['get_navigation_equipment']   = $get_navigation_equipment;

//----------------Pollution Control Devices---------------//
$get_pollution_control          =   $this->Function_model->get_pollution_control($vessel_id,7,$survey_id1);
$data['get_pollution_control']      = $get_pollution_control;
//----------------Nozzle Type---------------//
$get_nozzle_type            =   $this->Function_model->get_nozzle_type($vessel_id,8,$survey_id1);
$data['get_nozzle_type']        = $get_nozzle_type;


$survey_intimation          = $this->Survey_model->get_survey_intimation_details($vessel_id,$survey_id1);
$data['survey_intimation']  = $survey_intimation;
//print_r($survey_intimation);

if(!empty($survey_intimation))
{
  foreach ($survey_intimation as $key ) 
  {
    $defect_status=$key['defect_status'];
    $survey_defects_id=$key['survey_defects_id'];
    $placeofsurvey_id=$key['placeofsurvey_id'];
 
    
    
    if($defect_status==0)
    {
      $date_of_survey      = date('d-m-Y', strtotime($survey_intimation[0]['date_of_survey']));
       if($placeofsurvey_id !=0)
      {
        $placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($placeofsurvey_id);
        $data['placeofsurvey']  =   $placeofsurvey;
        $placeofsurvey_name     =   $placeofsurvey[0]['placeofsurvey_name'];
      }
    }
    else
    {
      $survey_intimation_defects      =   $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
      $data['survey_intimation_defects']  =   $survey_intimation_defects;
      $placeofsurvey_id=$survey_intimation_defects[0]['placeofsurvey_id'];
      if($placeofsurvey_id !=0)
      {
        $placeofsurvey          =   $this->Survey_model->get_placeofsurvey_code($placeofsurvey_id);
        $data['placeofsurvey']  =   $placeofsurvey;
        $placeofsurvey_name     =   $placeofsurvey[0]['placeofsurvey_name'];
      }

       $date_of_survey      = date('d-m-Y', strtotime($survey_intimation_defects[0]['date_of_survey']));
    }
  }

}


$user_id_details          =   $this->Survey_model->get_user_id($vessel_id);
$data['user_id_details']  =   $user_id_details;
if(!empty($user_id_details))
{
  $user_id_owner= $user_id_details[0]['user_id'];
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
  $("#form2view").show();
  $("#printform1").show();

  $("#survey2").hide();
  $("#btnsubmit").hide();
  $("#btnapprove").hide();
  $("#btnforward").hide();





  $("#current_status_id").change(function()
  {
    var current_status_id=$("#current_status_id").val();
   // alert(current_status_id);
    if(current_status_id==6)
    {
      $("#forward_to").val('');
      $("#remarks").val('');
      $("#survey2").show();
      $("#btnforward").show();
      $("#btnsubmit").hide();
      $("#btnapprove").hide();
    }


    if(current_status_id==4)
    {
      $("#forward_to").val('');
      $("#remarks").val('');
      $("#survey2").hide();
      $("#btnforward").hide();
      $("#btnsubmit").show();
      $("#btnapprove").hide();
    }
     if(current_status_id==5)
    {
      $("#forward_to").val('');
      $("#remarks").val('');
      $("#survey2").hide();
      $("#btnforward").hide();
      $("#btnsubmit").hide();
      $("#btnapprove").show();
    }


    else
    {
      
    }
  });



 
//-----Jquery End----//
});

</script>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">

    <?php if($user_type_id1 ==11){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>
   <?php if($user_type_id1 ==12){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>

  <?php if($user_type_id1 ==13){ ?>
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
 <button class="btn-sm btn-flat btn btn-outline-primary" id="form2"><i class="fab fa-wpforms"></i>&nbsp; Form 2 </button></div>
<div class="col-6 d-flex justify-content-end">
<button class="btn-sm btn-flat btn btn-outline-success " id="printform1"><i class="fas fa-print"></i>&nbsp; Print </button>
</div> <!-- end of button col -->


<!-- <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/form2_action' ?>"> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/form2_action", $attributes);
?>




<input type="hidden" name="owner_user_id" id="owner_user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="owner_user_type_id" id="owner_user_type_id" value="11">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="hdn_vessel_id" id="hdn_vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="hdn_processflow_id" id="processflow_id" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="hdn_survey_id" id="hdn_survey_id" value="<?php echo $survey_id; ?>">
<input type="hidden" name="next_process_id" id="next_process_id" value="17">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">


<!-- starting of form two view -->
<div id="form2view1" class="postcard mb-5">
<div class="row no-gutter text-primary">
<div class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong> FORM No - 2  </strong>
</div> <!-- end of col12 -->
<div class="col-12 py-2 px-3 d-flex justify-content-center"> 
<a href="" class="btn btn-sm btn-flat btn-outline-primary" role="button">[See  Rule 6 (2)]  </a>
</div> <!-- end of col12 -->
<div class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong> <u> Application for Survey of Inland Vessel To Date: The Surveying  </u> </strong>
</div> <!-- end of col12 -->
<div class="col-12 py-2 px-3 pl-5 d-flex justify-content-start"> 
Authority Place: At Port <?php echo $registry_name; ?>
</div>
<?php 
if(!empty($payment_details))
{
  //$amount   = $payment_details[0]['dd_amount'];
  $date     = date("d-m-Y", strtotime($payment_details[0]['dd_date']));
}
else 
{
  //$amount   ="____";
  $date     ="_";
}

if(!empty($tariff_form2))
{
  $amount   = $tariff_form2[0]['tariff_amount'];
}
else
{
   $amount   = "0";
}


?>

<div class="col-12 py-2  pl-5 pr-5 d-flex justify-content-start text-justify"> 
&nbsp; I  <?php echo @$owner_name; ?> &nbsp;being owner/Agent/incase of Minor, Legal/Natural Guardian (Legal documents of guardianship attached ) of the Inland Vessel duly authorized by the owner (copy of authorization attached ).Vessel Name &nbsp;<?php echo @$vessel_name; ?> &nbsp;Official No&nbsp; <?php echo $official_number; ?>&nbsp; hereby apply for the survey of the said vessel at the port /place of &nbsp; <?php echo $registry_name; ?>. I /we have remitted Rs &nbsp;<?php echo  $amount; ?>&nbsp;vide chalan no/reference number <?php echo $reference_number; ?> dated &nbsp;<?php  echo $date;?>&nbsp; in respect of the survey. I/we agree to pay on demand such extra fees as may be leviable under the rules.
</div> 
<div class="col-12 py-2 px-3 pl-5 d-flex justify-content-start"> 
The particulars of the vessel are as under ;
</div>
</div> <!-- end of row -->

<div class="row no-gutter postodd mx-0">
<div class="col-4 py-2 text-primary px-5 " >
1. Name of vessel :
</div>
<div class="col-8 py-2 text-secondary px-3">
<?php echo @$vessel_name; ?>
</div>
</div> <!-- end of postodd -->

<div class="row no-gutter posteven mx-0">
<div class="col-4 py-2 text-primary px-5">
2. Official No of the vessel :
</div>
<div class="col-8 py-2 text-secondary px-3">
<?php echo $official_number; ?>
</div>
</div> <!-- end of posteven -->
<div class="row no-gutter postodd mx-0">
<div class="col-4 py-2 text-primary px-5">
3. Port of registry of vessel :
</div>
<div class="col-8 py-2 text-secondary px-3">
<?php echo $registry_name; ?>
</div>
</div> <!-- end of postodd -->

<div class="row no-gutter posteven mx-0">
<div class="col-4 py-2 text-primary px-5">
4. Gross tonnage of vessel :
</div>
<div class="col-8 py-2 text-secondary px-3">
<?php echo $vessel_total_tonnage; ?>&nbsp;Ton
</div>
</div> <!-- end of posteven -->

<div class="row no-gutter postodd mx-0">
<div class="col-4 py-2 text-primary px-5">
5. Place and date of last survey :
</div>
<div class="col-8 py-2 text-secondary px-3"><?php echo $placeofsurvey_name; ?>,&nbsp;<?php echo $date_of_survey; ?>
</div>
</div> <!-- end of postodd -->

<div class="row no-gutter posteven mx-0">
<div class="col-4 py-2 text-primary px-5">
6. Nature of survey (state if survey in dry dock is required) :
</div>
<div class="col-8 py-2 text-secondary px-3"><?php echo $survey_name; ?>
</div>
</div> <!-- end of posteven -->

<div class="row no-gutter postodd mx-0">
<div class="col-4 py-2 text-primary px-5">
7. Length, Breadth ,Depth :
</div>
<div class="col-8 py-2 text-secondary px-3"><?php echo $vessel_length; ?>&nbsp;m, &nbsp;<?php echo $vessel_breadth; ?>&nbsp;m,&nbsp;<?php echo $vessel_depth; ?>&nbsp;m
</div>
</div> <!-- end of postodd -->


<div class="row no-gutter posteven mx-0">
<div class="col-4 py-2 text-primary px-5">
8. Type of main propulsion engines and total H.P. :
</div>
<div class="col-8 py-2 text-secondary px-3">
<?php //echo rtrim($enginetype_name1,','); ?>
<?php foreach($engine_details as $res_engine1)
  {
    @$engine_type_id1   =   $res_engine1['engine_type_id'];
     if($engine_type_id1!=0)
    {

        $get_enginetype_name1      =   $this->Function_model->get_enginetype_name($engine_type_id1);
        $data['get_enginetype_name1']  = $get_enginetype_name1;
        @$enginetype_name1       = $get_enginetype_name1[0]['enginetype_name'].' ,';
    }
    else
    {
        @$enginetype_name1='-';
    }
  } 



  ?>


</div>
</div> <!-- end of posteven -->

<div class="row no-gutter postodd mx-0">
<div class="col-4 py-2 text-primary px-5">
9. Details of other machineries :
</div>
<div class="col-8 py-2 text-secondary px-3">

</div>
</div> <!-- end of postodd -->


<div class="row no-gutter posteven mx-0">
<div class="col-4 py-2 text-primary px-5">
10. Type of the vessel passenger cum cargo/ Cargo/Chemical Carrier, Liquid Carrier etc. :
</div>
<div class="col-8 py-2 text-secondary px-3">
<?php echo @$vesseltype_name; ?>/<?php echo @$vessel_subtype_name; ?>
</div>
</div> <!-- end of posteven -->

<div class="row no-gutter postodd mx-0">
<div class="col-4 py-2 text-primary px-5">
11. Owner’s name and address :
</div>
<div class="col-8 py-2 text-secondary px-3">
<?php echo $owner_name;?><br><?php echo $owner_address;?>
</div>
</div> <!-- end of postodd -->

<div class="row no-gutter posteven mx-0">
<div class="col-4 py-2 text-primary px-5">
12.Agents name and address :
</div>
<div class="col-8 py-2 text-secondary px-3">
<?php if(!empty($agent_details))
{
  echo  $agent_details[0]['user_name'].'<br>'.$agent_details[0]['user_address'];
   $agent_phonenumber=$agent_details[0]['user_mobile_number'];
}
else
{
  echo '-';
  $agent_phonenumber="";
}
?></div>
</div> <!-- end of posteven -->

<div class="row no-gutter postodd mx-0">
<div class="col-4 py-2 text-primary px-5">
13. Telephone No:
</div>
<div class="col-8 py-2 text-secondary px-3">
 <?php echo $agent_phonenumber; ?></div>
</div> <!-- end of postodd -->

<div class="row no-gutter  mx-0">
<div class="col-12 py-2 text-primary px-5 d-flex justify-content-end">
<strong>Owner/master/serang</strong>
</div>
</div> <!-- end of row -->

<div class="row no-gutter  mx-0 postodd">
<div class="col-12 py-2 text-primary px-5">
<strong>Enclosures:-</strong>
</div>
</div> <!-- end of row -->


<div class="row no-gutter  mx-0 posteven">
<div class="col-12 py-2 text-primary px-5">
1. Documents as per rules-6 (3) [ (a) to ( f) ]
</div>
</div> <!-- end of row -->

<?php if(!empty($document_vessel)) { 
  //print_r($document_vessel);
foreach ($document_vessel as $key) {
   $pdfname=$key['pdfname'];
   $listname=$key['listname'];
   $Id=$key['Id'];
 ?>
<div class="row no-gutter  mx-0 postodd">
<div class="col-12 py-2 text-primary px-5">
<?php echo $listname; ?> &nbsp; <a href="<?php echo base_url(); ?>uploads/annualsurvey/<?php echo $Id; ?>/<?php echo $pdfname; ?>"><i class="fas fa-file-pdf h4"></i> </a>

</div>
</div> 
<?php } }  ?>
</div>

<!-- <div class="row no-gutters oddtab">    
<div class="col-12 d-flex justify-content-end">
<button type="button" class="btn btn-primary btn-flat  btn-point btn-md" name="tab2next" id="tab2next" ><i class="far fa-save"></i>&nbsp;Approve &amp; proceed</button>
</div> 
</div>  -->


<div class="row no-gutters border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Survey Process
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<select name="current_status_id" id="current_status_id" class="form-control select2" data-validation="required" required="">
    <option value="">Select</option>
    <?php foreach($current_status as $res_current_status)
  {
  ?>
  <option value="<?php echo $res_current_status['status_id']; ?>"> <?php echo $res_current_status['status_name']; ?> </option>
  <?php
  }
  ?>
  </select>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters border-bottom" id="survey2">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Forward To Surveyor
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">

<select name="forward_to" id="forward_to" class="form-control select2" data-validation="required">
  <option value="">Select</option>
  <?php foreach($surveyor_details as $res_surveyor_details) 
  {
  ?>
  <option value="<?php echo $res_surveyor_details['user_sl']; ?>"> <?php echo $res_surveyor_details['user_master_fullname']; ?> </option>
  <?php 
  }
  ?>
  </select>
    
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



<div class="row no-gutters border-bottom" id="survey3">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Remarks
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<textarea name="remarks" data-validation="required" id="remarks" rows="5" cols="50"></textarea>
    
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary pl-1">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



<div class="row no-gutters border-bottom" id="survey4">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">

</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">

<input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Revert to owner">
<input type="submit" class="btn btn-info pull-right btn-space" name="btnapprove" id="btnapprove" value="Approve & send intimation">
<input type="submit" class="btn btn-info pull-right btn-space" name="btnforward" id="btnforward" value="Approve & forward">

</div> <!-- end of col-3 2nd-->

<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<!-- </form> --> <?php echo form_close(); ?>

</div> <!-- end of row -->
<!-- end of form two view -->
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->


<script language="javascript">
$(document).ready(function(){



$("#printform1").click(function () {
  
    //Copy the element you want to print to the print-me div.
    $("#form2view").clone().appendTo("#form2view-print");
    //Apply some styles to hide everything else while printing.
    $("body").addClass("printing");
    //Print the window.
    window.print();
    //Restore the styles.
    $("body").removeClass("printing");
    //Clear up the div.
    $("#form2view-print").empty();
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
