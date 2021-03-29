

<?php 
//print_r($vessel_details);
//select * from tbl_kiv_processflow a join tbl_kiv_vessel_details b on a.vessel_id=b.vessel_sl where a.processflow_sl=45
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
  
  $("#survey0").hide();
  $("#survey1").hide();
  $("#survey2").hide();
  $("#survey3").hide();
  $("#survey4").hide();

  


  $("#current_status_id").change(function()
  {
    var current_status_id=$("#current_status_id").val();

    var process_id=$("#process_id").val();  //4

   // alert(current_status_id);
    //alert(process_id);

    //Reject and Revert
    if(current_status_id==3 || current_status_id==4)
    {
        $("#surveyactivity_id").val('');
        //$("#surveyactivity_id option").prop("selected", false);
        $("#datepicker3").val('');
        $("#forward_to").val('');
        $("#remarks").val('');

      $("#survey0").show();
      $("#survey1").hide();
      $("#survey2").hide();
      $("#survey3").show();
      $("#survey4").show();
    }
    //Approve and Forward
    if(current_status_id==6)
    {
        //$("#surveyactivity_id option").prop("selected", false);
        $("#datepicker3").val('');
        $("#forward_to").val('');
        $("#remarks").val('');

      $("#survey0").hide();
      $("#survey1").show();
      $("#survey2").show();
      $("#survey3").show();
      $("#survey4").show();
    }
    //Approve
    if(current_status_id==5)
    {
        //$("#surveyactivity_id option").prop("selected", false);
        $("#datepicker3").val('');
        $("#forward_to").val('');
        $("#remarks").val('');

      $("#survey0").show();
      $("#survey1").show();
      $("#survey2").hide();
      $("#survey3").show();
      $("#survey4").show();
    }

    if(current_status_id==5 && process_id==4 )
    {
        //$("#surveyactivity_id option").prop("selected", false);
        $("#datepicker3").val('');
        $("#forward_to").val('');
        $("#remarks").val('');

      $("#survey0").hide();
      $("#survey1").hide();
      $("#survey2").hide();
      $("#survey3").show();
      $("#survey4").show();
    }

  });

        

//-----Jquery End----//
});
</script>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1"> 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary "><i class="fab fa-wpforms"></i>&nbsp; Form 1 </button></div>
<div class="col-6 d-flex justify-content-end">
<button class="btn-sm btn-flat btn btn-outline-success " id="printform"><i class="fas fa-print"></i>&nbsp; Print </button>
</div> <!-- end of button col -->
<div class="col-12" id="form1view-print"> </div>
</div> <!-- end of row -->
<div class="row h-100 justify-content-center mt-3">

<div class="col-12 " id="form1view">
<!-- ########################################################################################### -->
 <!-- inside content -->
<?php  



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

   
  $user_type_id   = $this->session->userdata('int_usertype');

$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];

 //----------- Vessel Details -----------//
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
  $sewage_treatment       = $res_vessel['sewage_treatment'];
     
  $solid_waste            = $res_vessel['solid_waste'];
  $sound_pollution        = $res_vessel['sound_pollution'];
  $water_consumption      = $res_vessel['water_consumption'];
  $source_of_water        = $res_vessel['source_of_water'];
  $vessel_id              = $res_vessel['vessel_sl'];
  $user_id                = $res_vessel['vessel_created_user_id'];

  $user_type_details          = $this->Survey_model->get_user_type_id($user_id);
  $data['user_type_details']    = $user_type_details;
  $user_type_id                 = $user_type_details[0]['user_master_id_user_type'];


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
  $hull_name      = $res_hull['hull_name'];
  $hull_address     = $res_hull['hull_address'];
  $hullmaterial_id  = $res_hull['hullmaterial_id'];

  if($hullmaterial_id!=0)
  {
    $get_hullmaterial_id      =   $this->Survey_model->get_hullmaterial_name($hullmaterial_id);
    $data['get_hullmaterial_id']  = $get_hullmaterial_id;
  //  $hullmaterial_name        = $get_hullmaterial_id[0]['hullmaterial_name'];
      if(!empty($get_hullmaterial_id))
    {
      $hullmaterial_name        = $get_hullmaterial_id[0]['hullmaterial_name'];
    }
    else
    {
       $hullmaterial_name='-';
    }
  }
  else
  {
    $hullmaterial_name='-';
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

  $bulk_heads       = $res_hull['bulk_heads'];
  $bulk_head_placement  = $res_hull['bulk_head_placement'];

  if($bulk_head_placement!=0)
  {
    $bulk_head_placement_name     =   $this->Survey_model->get_bulk_head_placement_name($bulk_head_placement);
    $data['bulk_head_placement_name'] = $bulk_head_placement_name;
    $location_name            = $bulk_head_placement_name[0]['location_name'];
  }
  else
  {
    $location_name='-';
  }
    $bulk_head_thickness      = $res_hull['bulk_head_thickness'];
    $hullplating_material_id    = $res_hull['hullplating_material_id'];

  if($hullplating_material_id!=0)
  {
    $hullplating_material_id    =   $this->Survey_model->get_hullplating_material_name($hullplating_material_id);
    $data['hullplating_material_id']= $hullplating_material_id;
    $hullplating_material_name    = $hullplating_material_id[0]['hullplating_material_name'];
  }
  else
  {
    $hullplating_material_name='-';
  }

  $hull_plating_material_thickness= $res_hull['hull_plating_material_thickness'];
  $hull_bulkhead_details      =   $this->Function_model->get_hull_bulkhead_details($vessel_id,$survey_id);
  $data['hull_bulkhead_details']  = $hull_bulkhead_details;
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
$get_anchor_spare     =   $this->Function_model->get_anchor_spare($vessel_id,3,$survey_id);
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
$get_chain_port     =   $this->Function_model->get_chain_port($vessel_id,4,$survey_id);
$data['get_chain_port'] = $get_chain_port;

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
$get_chain_startboard     =   $this->Function_model->get_chain_startboard($vessel_id,5,$survey_id);
$data['chain_startboard'] = $get_chain_startboard;

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
$get_chain_Rope   =   $this->Function_model->get_chain_Rope($vessel_id,6,$survey_id);
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
$get_searchlight    =   $this->Function_model->get_searchlight($vessel_id,7,$survey_id);
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
$get_lifebuoys      =   $this->Function_model->get_lifebuoys($vessel_id,8,$survey_id);
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
$get_buoyant_apparatus      =   $this->Function_model->get_buoyant_apparatus($vessel_id,9,$survey_id);
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
$navigation_light       =   $this->Function_model->get_navigation_light_view($vessel_id,$survey_id);
$data['navigation_light'] = $navigation_light;


//-----Sound Signals--------//
$sound_signal         =   $this->Function_model->get_sound_signal_view($vessel_id,$survey_id);
$data['sound_signal']   = $sound_signal;

//-----Fire Pumps---//  

$get_fire_pumps       =   $this->Function_model->get_fire_pumps($vessel_id,13,$survey_id);
$data['get_fire_pumps']   = $get_fire_pumps;



//-----Fire Mains---//  
$get_fire_mains       =   $this->Function_model->get_fire_mains($vessel_id,14,$survey_id);
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
$get_hydrants       =   $this->Function_model->get_hydrants($vessel_id,15,$survey_id);
$data['get_hydrants'] = $get_hydrants;  
@$hydrant_number    = $get_hydrants[0]['number'];

//-----Hose---//  
$get_hose         =   $this->Function_model->get_hose($vessel_id,16,$survey_id);
$data['get_hose']   = $get_hose;  
@$hose_number       = $get_hose[0]['number'];


//-------------- portable fire extinguisher-----------------//tbl_kiv_fire_extinguisher_details
$get_portable_fire      =   $this->Function_model->get_fire_extinguisher_details($vessel_id,$survey_id);
$data['get_portable_fire']  = $get_portable_fire;  

//----------------Communication Equipment---------------//
$get_communication_equipment      =   $this->Function_model->get_communication_equipment($vessel_id,5,$survey_id);
$data['get_communication_equipment']  = $get_communication_equipment;

//----------------Navigation Equipment---------------//
$get_navigation_equipment         =   $this->Function_model->get_navigation_equipment($vessel_id,6,$survey_id);
$data['get_navigation_equipment']   = $get_navigation_equipment;

//----------------Pollution Control Devices---------------//
$get_pollution_control          =   $this->Function_model->get_pollution_control($vessel_id,7,$survey_id);
$data['get_pollution_control']      = $get_pollution_control;
//----------------Nozzle Type---------------//
$get_nozzle_type            =   $this->Function_model->get_nozzle_type($vessel_id,8,$survey_id);
$data['get_nozzle_type']        = $get_nozzle_type;
?>
<!-- <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/srTask/'.$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1 ?>>"> -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/srTask/".$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1, $attributes);
  ?>

<!-- ____________________________ Vessel Details ____________________________ -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
1. Vessel Details 
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel Name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
    <?php echo @$vessel_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Ref: Number 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
1234/2018 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row 1-->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Owner Name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
<?php echo @$owner_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Owner Address 
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont" >
<?php echo @$owner_address; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row 2-->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Length
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$vessel_length; ?>&nbsp;m 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Breadth
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$vessel_breadth; ?>&nbsp;m 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row 3-->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Depth
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$vessel_depth; ?>&nbsp;m
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Tonnage
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$vessel_expected_tonnage; ?>&nbsp;Ton
</div> <!-- end of col-3 4th-->
</div> <!-- end of row 4-->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Type
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$vesseltype_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Sub type
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$vessel_subtype_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row 5-->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Category
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$vessel_category_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Sub category
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$vessel_subcategory_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row 6-->

<?php
if($length_overall>0)
{
?>
<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Length Overall
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> <?php echo @$length_overall; ?>&nbsp; m
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row 7-->
<?php
}
?> 

  <!-- ____________________________ Hull Details ____________________________ -->
 <div class="row no-gutters headrow border-bottom">
<div class="col-12 mt-1 mb-1 text-white pl-2 formfont">
2. Hull Details 
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Builder Name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$hull_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Builders Address
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$hull_address; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Material of Hull
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$hullmaterial_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Whether with a deck above freeboard deck
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$deck_msg; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
  <?php
   $i=1;
  foreach($hull_bulkhead_details as $res_hull_bulkhead)
  {
      $placement_id             = $res_hull_bulkhead['bulk_head_placement'];
      $thickness_bulkhead_placement     = $res_hull_bulkhead['bulk_head_thickness'];
      if($placement_id!=0)
      {
           $bulk_head_placement       =   $this->Function_model->get_bulk_head_placement_name($placement_id);
           $data['bulk_head_placement'] = $bulk_head_placement;
           $bulk_head_placement_name    = $bulk_head_placement[0]['bulkhead_placement_name'];
    } 
  ?>

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Bulk head placement&nbsp;<?php echo $i; ?>
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$bulk_head_placement_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Bulk head Thickness&nbsp;<?php echo $i; ?>
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$thickness_bulkhead_placement; ?>&nbsp;mm
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
 <?php
  $i++;
  }
  ?>

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Hull plating material
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$hullplating_material_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Thickness
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$hull_plating_material_thickness; ?>&nbsp;mm
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<!-- ____________________________ Engine Details ____________________________ -->

 <div class="row no-gutters headrow border-bottom">
<div class="col-12 mt-1 mb-1 text-white pl-2 formfont">
3. Particulars of propulsion of engines
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 
 <?php 
  $i=1;
  foreach($engine_details as $res_engine)
  {
    $bhp          = $res_engine['bhp'];
    $manufacturer_name  = $res_engine['manufacturer_name'];
    $manufacturer_brand   = $res_engine['manufacturer_brand'];
    $propulsion_diameter  =   $res_engine['propulsion_diameter'];
    $gear_number      = $res_engine['gear_number'];
    $engine_model_id    = $res_engine['engine_model_id'];
    if($engine_model_id!=0)
    {
      $get_modelnumber_name     =   $this->Function_model->get_modelnumber_name($engine_model_id);
        $data['get_modelnumber_name'] = $get_modelnumber_name;
        $modelnumber_name       = $get_modelnumber_name[0]['modelnumber_name'];
    }
    else
    {
      $modelnumber_name='-';
    }
    $engine_type_id   =   $res_engine['engine_type_id'];

    if($engine_type_id!=0)
    {
      $get_enginetype_name      =   $this->Function_model->get_enginetype_name($engine_type_id);
        $data['get_enginetype_name']  = $get_enginetype_name;
        $enginetype_name        = $get_enginetype_name[0]['enginetype_name'];
    }
    else
    {
        $enginetype_name='-';
    }
    $gear_type_id=$res_engine['gear_type_id'];
    if($gear_type_id!=0)
    {
    $get_geartype_name      =   $this->Function_model->get_geartype_name($gear_type_id);
      $data['get_geartype_name']  = $get_geartype_name;
      $geartype_name        = $get_geartype_name[0]['geartype_name'];
    }
    else
    {
      $geartype_name='-';
    }
    $propulsion_material_id=$res_engine['propulsion_material_id'];
    if($propulsion_material_id!=0)
    {
              
      $get_propulsionshaft_material_name    =   $this->Function_model->get_propulsionshaft_material_name($propulsion_material_id);
      $data['get_propulsionshaft_material_name']  = $get_propulsionshaft_material_name;
      $propulsionshaft_material_name        = $get_propulsionshaft_material_name[0]['propulsionshaft_material_name'];
    }
    else
    {
        $propulsionshaft_material_name='-';
    }





?>


 <div class="row no-gutters oddrow border-bottom">
<div class="col-12 mt-1 mb-1 text-dark pl-2 formfont">
Set number <?php echo $i; ?>
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
BHP
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$bhp;  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Manufacturers Name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$manufacturer_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Brand
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$manufacturer_brand; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
 Model number
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $modelnumber_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Type of engine
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <?php echo $enginetype_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Diameter of propulsion shaft
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $propulsion_diameter; ?>&nbsp;mm
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Material of propulsion shaft
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $propulsionshaft_material_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Type of gear
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $geartype_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number of gear
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $gear_number; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
 <?php
  $i++;
  } 
  ?>
<!-- ____________________________ Equipment Details ____________________________ -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
4. Particulars of Equipments 
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-12 mt-1 mb-1 text-dark pl-2 formfont">
a. Anchor
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Port weight
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$weight_anchor_port; ?>&nbsp;Kg
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Port material
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$equipment_material_name;?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Starboard weight
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$weight_star_board; ?>&nbsp;Kg
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Starboard material
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$equipment_material_starboard_name;?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
b. Anchor spare weight
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$weight_anchor_spare; ?>&nbsp;Kg
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Anchor spare material
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$equipment_material_spare_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-12 mt-1 mb-1 text-dark pl-2 formfont">c.Chain Port
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 

<div class="row no-gutters evenrow border-bottom">
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Size
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$size_chain_port; ?>&nbsp;mm 
</div> <!-- end of col-3 2nd-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Type
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$equipment_material_spare_name; ?>
</div> <!-- end of col-3 4th-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Length
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $length_chain_port; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-12 mt-1 mb-1 text-dark pl-2 formfont">c.Chain Starboard
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 

<div class="row no-gutters evenrow border-bottom">
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Size
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $size_chain_startboard; ?>&nbsp;m
</div> <!-- end of col-3 2nd-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Type
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$type_name_chain_startboard; ?>
</div> <!-- end of col-3 4th-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Length
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $length_chain_startboard; ?>&nbsp;m
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
e. Rope Size
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $size_chain_Rope; ?> &nbsp;mm&nbsp;m
</div> <!-- end of col-3 2nd-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Material
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$equipment_material_rope_name; ?>
</div> <!-- end of col-3 4th-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $number_chain_Rope; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
f. Search Light Size
</div> <!-- end of col-3 1st-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $searchlight_size_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Power
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$power_searchlight; ?>&nbsp;nm 
</div> <!-- end of col-3 4th-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $number_searchlight; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
g. Number of life buoys
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $number_lifebuoys; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Buoyant apparatus with self ignited light with buoyant
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo @$number_buoyant_apparatus; ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->




<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Navigation lights giving particulars</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont formtext"><?php 
  foreach ($navigation_light as $result_nav)
  {
    $list1=$result_nav['equipment_id']; 
    if($list1>9)
    {
      $nav_light_euipment     =   $this->Function_model->get_nav_light_euipment($list1);
      $data['nav_light_euipment'] = $nav_light_euipment;  
      echo  @$nav_equip_name    =   $nav_light_euipment[0]['equipment_name'].', ';
    }
  } 
  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Sound signals : Mechanical or Electrical
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php  foreach ($sound_signal as $result_sound)
         {
             $list2=$result_sound['equipment_id']; 
             if($list2>9)
             {
                $get_sound_signal=  $this->Function_model->get_nav_light_euipment($list2);
              $data['get_sound_signal'] = $get_sound_signal;   
              echo @$sound_equip_name=$get_sound_signal[0]['equipment_name'].', ';
             }
        } 
         ?> 
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<!-- ____________________________ Fire Appliance Details ____________________________ -->
<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
5. Particulars of Fire Appliances
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-12 mt-1 mb-1 text-dark pl-2 formfont">
a. Fire pumps
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont">Number
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Capacity
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont">Size
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<?php
  foreach($get_fire_pumps as $res_fire_pumps) 
  {
    $firepumptype_id    = $res_fire_pumps['firepumptype_id'];
    $size_fire_pumps    = $res_fire_pumps['firepumpsize_id'];
    @$number_fire_pumps   = $res_fire_pumps['number'];
    @$capacity_fire_pumps   = $res_fire_pumps['capacity'];

    if($size_fire_pumps!=0)
    {
      $firepump_size      =   $this->Function_model->get_firepump_size($size_fire_pumps);
      $data['firepump_size']  = $firepump_size;
      @$sizename_fire_pumps   =   $firepump_size[0]['firepumpsize_name'];
    }
    else 
    {
      $sizename_fire_pumps='-'  ;
    }
    if($firepumptype_id!=0)
    {
      $firepump_type      = $this->Function_model->get_firepump_type_name($firepumptype_id);
      $data['firepump_type']  = $firepump_type;
      @$firepump_type_name  = $firepump_type[0]['firepumptype_name'];
    }
  ?>

<div class="row no-gutters evenrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1"><?php echo $firepump_type_name; ?>
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $number_fire_pumps; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $capacity_fire_pumps; ?>&nbsp;&nbsp;m<sup>3</sup>/h
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $sizename_fire_pumps;?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
  <?php
  } 
?>

<div class="row no-gutters oddrow border-bottom">
<div class="col-12 mt-1 mb-1 text-dark pl-2 formfont">
b. Fire Mains
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 

<div class="row no-gutters evenrow border-bottom">
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Diameter
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$diameter_fire_mains; ?>&nbsp;mm
</div> <!-- end of col-3 2nd-->
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Material
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$equipment_material_firemains;?>
</div> <!-- end of col-3 4th-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Number of hydrants
</div> <!-- end of col-3 3rd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $hydrant_number; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Number of hose
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo @$hose_number; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Nozzles
</div> <!-- end of col-3 3rd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">         
  <?php
  foreach($get_nozzle_type as $res_nozzle_type)
  {
    $list8= $res_nozzle_type['equipment_id'];
    if($list8>9)
    {
      $get_nozzle_equipment     =   $this->Function_model->get_nav_light_euipment($list8);
      $data['get_nozzle_equipment'] = $get_nozzle_equipment;   
      echo @$nozzle_equip_name    =   $get_nozzle_equipment[0]['equipment_name'].', ';
    }
  }
  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

   <!-- ____________________________ Other Equipments Details ____________________________ -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
6. Particulars of Other Equipments
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters evenrow border-bottom">
<div class="col-12 mt-1 mb-1 text-dark pl-2 formfont">
a. Fire Extinguishers
</div> <!-- end of col-12 heading -->
</div> <!-- end of row --> 

<div class="row no-gutters oddrow border-bottom">
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Name
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont border-left border-primary pl-1 formfont">Number
</div> <!-- end of col-3 2nd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Capacity
</div> <!-- end of col-3 3rd-->
</div>

 <?php 
  $i=1;
  foreach ($get_portable_fire as $result_portable) 
  {
    $ext_id               =   $result_portable['fire_extinguisher_type_id'];
    $get_ext_type           =   $this->Function_model->get_portable_fire_extinguisher_name($ext_id);
    $data['get_ext_type']       = $get_ext_type;
    @$portable_fire_extinguisher_name = $get_ext_type[0]['portable_fire_extinguisher_name'];
  ?>

<div class="row no-gutters evenrow border-bottom">
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1"><?php echo $i; ?>&nbsp; <?php echo $portable_fire_extinguisher_name;  ?>
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont border-left border-primary pl-1 formfont"><?php echo $result_portable['fire_extinguisher_number']; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont">
<?php echo $result_portable['fire_extinguisher_capacity']; ?>
</div> <!-- end of col-3 3rd-->
</div>

 <?php 
 $i++; 
 }
 ?>

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Particulars of communication equipments
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <?php
  foreach($get_communication_equipment as $res_commn_equipment)
  {
    $list3= $res_commn_equipment['equipment_id'];
    if($list3>9)
    {
      $get_commn_equipment      =   $this->Function_model->get_nav_light_euipment($list3);
      $data['get_commn_equipment']  = $get_commn_equipment;   
      echo @$commn_equip_name     =   $get_commn_equipment[0]['equipment_name'].', ';
    }
  }
  ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Particulars of navigation equipments
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> <?php
  foreach($get_navigation_equipment as $res_navigation_equipment)
  {
    $list4  = $res_navigation_equipment['equipment_id'];
    if($list4>9)
    {
      $get_nav_equipment      =   $this->Function_model->get_nav_light_euipment($list4);
      $data['get_nav_equipment']  = $get_nav_equipment;   
      echo @$nav_equip_name     = $get_nav_equipment[0]['equipment_name'].', ';
      }
  }
  ?>
</div> <!-- end of col-3 4th-->

</div>





<div class="row no-gutters evenrow border-bottom">
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Particulars of pollution control device
</div> <!-- end of col-3 1st-->
<div class="col-8 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php
  foreach($get_pollution_control as $res_pollution_control)
  {
    $list5= $res_pollution_control['equipment_id'];

    if($list5>9)
    {
      $get_pollncntrl_equipment       =   $this->Function_model->get_nav_light_euipment($list5);
      $data['get_pollncntrl_equipment'] = $get_pollncntrl_equipment;   
      echo @$polln_equip_name       = $get_pollncntrl_equipment[0]['equipment_name'].', ';
    }
  }
  ?>
</div> <!-- end of col-3 2nd-->

</div>

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Sewage treatment and disposal
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> <?php echo $res_sewage_treatment;?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Solid waste processing and disposal
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $res_solid_waste; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Sound pollution control
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> <?php echo $res_sound_pollution; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
Water consumption per day
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"><?php echo $res_solid_waste; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Source of Water
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
<?php echo @$source_of_water_name; ?>
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<!-- ____________________________ Documents Details ____________________________ -->
<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
7. Documents
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<?php
  $i=1; 
  foreach($list_document_vessel as $res_list_document)
  {
    $document_sl  = $res_list_document['document_sl'];
    $doc_file     =   $this->Function_model->get_doc_file($vessel_id, $document_sl,$survey_id);
    $document_id  =   @$doc_file->document_id;
    $filename     =   @$doc_file->document_name;
    /*  
    $document_id=$doc_file[0]['document_id'];
    $filename=$doc_file[0]['document_name'];
    */ 
    if($filename==NULL)
    {
      $msg_disp='<font color="#7a29c6">  <b> No </b>  </font>';
    }
    else 
    {
      $msg_disp='<font color="#7a29c6"> <a href="'.base_url().'uploads/survey/'.$document_id.'/'.$filename.'" download> <b> Yes </b> </a> </font>';
    }
  ?>
<div class="row no-gutters evenrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
<?php  echo $res_list_document['document_name']; ?>
</div> <!-- end of col-3 1st-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
<?php
    echo $msg_disp; 
  ?>
</div> <!-- end of col-3 3rd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<?php
}
?>

<div class="row no-gutters oddrow border-bottom">
<div class="col-6 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Preferred Inspection Date
</div> <!-- end of col-3 1st-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
<?php echo $vessel_pref_inspection_date; ?>
</div> <!-- end of col-3 3rd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary formfont">

  <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
  <input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
  <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
  <input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
  <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
  <input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $user_type_id; ?>">
  <input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">

</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<!-- ____________________________ Survey Process ____________________________ -->
<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Survey Process
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<!-- ____________________________ Survey Process ____________________________ -->
<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Survey Process
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom">
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Slno
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark formfont">
Activity Name</div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
Assign Date
</div> <!-- end of col-3 3rd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
Approved Date
</div> <!-- end of col-3 3rd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Remarks
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<?php 
$i=1;
foreach($processactivity_date as $res_date) { ?>
<div class="row no-gutters oddrow border-bottom">
<div class="col-1 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $i;  ?>
</div> <!-- end of col-3 1st-->
<div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php if($res_date['process_id']==2) {echo 'Keel Laying'; }   if($res_date['process_id']==3) {echo 'Hull Inspection'; } if($res_date['process_id']==4) {echo 'Final Inspection '; } ?></div> <!-- end of col-3 2nd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary  border-primary ">
<?php if($res_date['activity_date']==NULL) { echo "";  } else { echo date('d-m-Y', strtotime($res_date['activity_date'])); }  ?>
</div> <!-- end of col-3 3rd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary  border-primary ">
<?php if($res_date['approved_date']==NULL) { echo ""; } else { echo date('d-m-Y', strtotime($res_date['approved_date'])); }  ?>
</div> <!-- end of col-3 3rd-->
<div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $res_date['remarks'];  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<?php
$i++;
 } ?>



<div class="row no-gutters evenrow border-bottom" >
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Survey Process
</div> <!-- end of col-3 1st-->

<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont " >
<select name="current_status_id" id="current_status_id" class="form-control select2" data-validation="required">
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


<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->




<div class="row no-gutters oddrow border-bottom" id="survey1">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Survey Activity
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<select name="surveyactivity_id" id="surveyactivity_id" class="form-control select2" data-validation="required">
  <option value="">Select</option>  
  <?php foreach($survey_activity as $res_survey_activity)
  {
  ?>
  <option value="<?php echo $res_survey_activity['surveyactivity_sl']; ?>"> <?php echo $res_survey_activity['surveyactivity_name']; ?> </option>
  <?php
  }
  ?>
  </select>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->





<div class="row no-gutters oddrow border-bottom" id="survey0">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont ">
Survey Activity Date
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">

    <div class="form-group">
     <input type="date" class="form-control" name="inspection_date" maxlength="10" id="inspection_date"  value=""  placeholder="Enter Date"  data-validation="required" autocomplete="off" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
    </div>

</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary pl-1">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom" id="survey2">
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




<div class="row no-gutters oddrow border-bottom" id="survey3">
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



<div class="row no-gutters evenrow border-bottom" id="survey4">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">

</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Submit">
    
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->





<!-- </form> --> <?php echo form_close(); ?>
<!-- end of inside content -->
<!-- ########################################################################################### -->
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->


<script language="javascript">
$(document).ready(function(){

$("#printform").click(function () {
  
    //Copy the element you want to print to the print-me div.
    $("#form1view").clone().appendTo("#form1view-print");
    //Apply some styles to hide everything else while printing.
    $("body").addClass("printing");
    //Print the window.
    window.print();
    //Restore the styles.
    $("body").removeClass("printing");
    //Clear up the div.
    $("#form1view-print").empty();
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