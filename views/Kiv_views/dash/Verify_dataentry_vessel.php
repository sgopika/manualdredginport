<?php

$moduleid        = 2;
$modenc          = $this->encrypt->encode($moduleid); 
$modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

$sess_usr_id      = $this->session->userdata('int_userid');
$user_type_id     = $this->session->userdata('int_usertype');

$vessel_id1       = $this->uri->segment(4);
$data_id1         = $this->uri->segment(5);
$vessel_id        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id        = $this->encrypt->decode($vessel_id); 

$data_id          = str_replace(array('-', '_', '~'), array('+', '/', '='), $data_id1);
$data_id          = $this->encrypt->decode($data_id); 


if(!empty($data_vessel))
{
  $vessel_name                =$data_vessel[0]['vessel_name'];
  $vessel_type_id             =$data_vessel[0]['vessel_type_id'];
  $vessel_subtype_id          =$data_vessel[0]['vessel_subtype_id'];
  $vessel_length_overall      =$data_vessel[0]['vessel_length_overall'];
  $vessel_no_of_deck          =$data_vessel[0]['vessel_no_of_deck'];
  $vessel_length              =$data_vessel[0]['vessel_length'];
  $vessel_breadth             =$data_vessel[0]['vessel_breadth'];
  $vessel_depth               =$data_vessel[0]['vessel_depth'];
  $vessel_expected_tonnage    =$data_vessel[0]['vessel_expected_tonnage'];
  $vessel_total_tonnage       =$data_vessel[0]['vessel_total_tonnage'];
  $vessel_registry_port_id    =$data_vessel[0]['vessel_registry_port_id'];
  $vessel_registration_number =$data_vessel[0]['vessel_registration_number'];
  $build_place                =$data_vessel[0]['build_place'];
  $grt                        =$data_vessel[0]['grt'];
  $nrt                        =$data_vessel[0]['nrt'];
  $cargo_nature               =$data_vessel[0]['cargo_nature'];
  $stability_test_status_id   =$data_vessel[0]['stability_test_status_id']; 
  $passenger_capacity         =$data_vessel[0]['passenger_capacity'];
  $area_of_operation          =$data_vessel[0]['area_of_operation'];
  $lower_deck_passenger       =$data_vessel[0]['lower_deck_passenger'];
  $upper_deck_passenger       =$data_vessel[0]['upper_deck_passenger'];
  $four_cruise_passenger      =$data_vessel[0]['four_cruise_passenger'];
  $first_aid_box              =$data_vessel[0]['first_aid_box']; 
  $condition_of_equipment     =$data_vessel[0]['condition_of_equipment']; 
  $validity_of_certificate     =$data_vessel[0]['validity_of_certificate']; 
  $stern_id                   =$data_vessel[0]['stern_id'];
  $registering_authority      =$data_vessel[0]['registering_authority'];
  $upperdeck                  =$data_vessel[0]['upperdeck']; 
  $number_of_bedrooms         =$data_vessel[0]['number_of_bedrooms'];
  @$vessel_sl                 =$data_vessel[0]['vessel_sl'];

}

if(!empty($data_hull))
{
  $hull_name                  =$data_hull[0]['hull_name'];
  $hullmaterial_id            =$data_hull[0]['hullmaterial_id'];
  $bulk_heads                 =$data_hull[0]['bulk_heads'];
  $hull_condition_status_id   =$data_hull[0]['hull_condition_status_id'];
  $hull_year_of_built         =$data_hull[0]['hull_year_of_built'];
  @$hull_sl                   =$data_hull[0]['hull_sl'];
}
else
{
  @$hull_sl                   =0;
}

if(!empty($data_engine))
{
  $count  = count($data_engine);

  $engine_number            =$data_engine[0]['engine_number'];
  $engine_placement_id      =$data_engine[0]['engine_placement_id'];
  $manufacturer_name        =$data_engine[0]['manufacturer_name'];
  $make_year                =$data_engine[0]['make_year'];
  $engine_speed             =$data_engine[0]['engine_speed'];
  $propulsion_shaft_number  =$data_engine[0]['propulsion_shaft_number'];
  $bhp                      =$data_engine[0]['bhp'];
  $bhp_kw                   =$data_engine[0]['bhp_kw'];
  $fuel_used_id             =$data_engine[0]['fuel_used_id'];
  @$engine_sl               =$data_engine[0]['engine_sl'];
 }
 else
{
  @$engine_sl                   =0;
}

if(!empty($data_vessel_main)) 
{
  $vesselmain_reg_date        =$data_vessel_main[0]['vesselmain_reg_date'];
  $next_reg_renewal_date      =$data_vessel_main[0]['next_reg_renewal_date'];
  $next_drydock_date          =$data_vessel_main[0]['next_drydock_date'];
  @$vesselmain_sl             =$data_vessel_main[0]['vesselmain_sl'];
}
else
{
  @$vesselmain_sl                   =0;
}

if(!empty($data_survey_intimation)) 
{
  $placeofsurvey_id         =$data_survey_intimation[0]['placeofsurvey_id'];
  $date_of_survey           =$data_survey_intimation[0]['date_of_survey'];
  @$intimation_sl           =$data_survey_intimation[0]['intimation_sl'];
}
else
{
  @$intimation_sl                   =0;
}

if(!empty($data_registration_history))
{
  $registration_validity_period   =$data_registration_history[0]['registration_validity_period'];
  $user_sl                        =$data_registration_history[0]['registration_verify_id'];
  @$registration_sl               =$data_registration_history[0]['registration_sl'];
}
else
{
  @$registration_sl                   =0;
}

if(!empty($data_insurance_details))
{
  $insurance_expiry_date    =$data_insurance_details[0]['vessel_insurance_validity'];
  @$vessel_insurance_sl     =$data_insurance_details[0]['vessel_insurance_sl'];
}
else
{
  @$vessel_insurance_sl                   =0;
}

//Pollutoin control device
if(!empty($data_pollution))
{
  $pcb_expiry_date          =$data_pollution[0]['pcb_expiry_date'];
  $pcb_certificate_number   =$data_pollution[0]['pcb_number'];
  @$pollution_sl            =$data_pollution[0]['pollution_sl'];
}
else
{
  @$pollution_sl    =0;
}
//life bouys
if(!empty($data_equp_type18))
{
  $number_of_lifebouys   =$data_equp_type18[0]['number'];
  $equipment_details_sl18  =$data_equp_type18[0]['equipment_details_sl'];
}

else
{
  $number_of_lifebouys  =0;
  $equipment_details_sl18 =0;
}
//heaving line
if(!empty($data_equp_heaving))
{
  $heaving_line_count   =$data_equp_heaving[0]['number'];
  $equipment_details_sl155  =$data_equp_heaving[0]['equipment_details_sl'];
}
else
{
  $heaving_line_count  =0;
  $equipment_details_sl155 =0;
}

//bilge pump
if(!empty($data_equp_bilgepump))
{
  $number_of_bilgepump   =$data_equp_bilgepump[0]['number'];
  $equipment_details_sl453  =$data_equp_bilgepump[0]['equipment_details_sl'];
}
else
{
  $number_of_bilgepump  =0;
  $equipment_details_sl453 =0;
}

//fire pumps
if(!empty($data_equp_firepumps))
{
  $number_of_firepumps   =$data_equp_firepumps[0]['number'];
  $equipment_details_sl413  =$data_equp_firepumps[0]['equipment_details_sl'];
}
else
{
  $number_of_firepumps  =0;
  $equipment_details_sl413 =0;
}

// fire bucket
if(!empty($data_equp_firebucket))
{
  $number_of_firebucket   =$data_equp_firebucket[0]['number'];
  $equipment_details_sl411  =$data_equp_firebucket[0]['equipment_details_sl'];
}
else
{
  $number_of_firebucket  =0;
  $equipment_details_sl411 =0;
}

// sandbox
if(!empty($data_equp_sandbox))
{
  $number_of_sandbox   =$data_equp_sandbox[0]['number'];
  $equipment_details_sl412  =$data_equp_sandbox[0]['equipment_details_sl'];
}
else
{
  $number_of_sandbox  =0;
  $equipment_details_sl412 =0;
}
// oars
if(!empty($data_equp_oars))
{
  $oars   =$data_equp_oars[0]['number'];
  $equipment_details_sl456  =$data_equp_oars[0]['equipment_details_sl'];
}
else
{
  $oars  =0;
  $equipment_details_sl456 =0;
}
// foam
if(!empty($data_equp_foam))
{
  $number_of_foam   =$data_equp_foam[0]['number'];
  $equipment_details_sl1020  =$data_equp_foam[0]['equipment_details_sl'];
}
else
{
  $number_of_foam  =0;
  $equipment_details_sl1020=0;
}
// fixed sandbox
if(!empty($data_equp_fixed_sandbox))
{
  $number_of_fixed_sandbox   =$data_equp_fixed_sandbox[0]['number'];
  $equipment_details_sl1021  =$data_equp_fixed_sandbox[0]['equipment_details_sl'];
}
else
{
  $number_of_fixed_sandbox  =0;
  $equipment_details_sl1021=0;
}
// fire axe
if(!empty($data_equp_fireaxe))
{
  $fire_axe   =$data_equp_fireaxe[0]['number'];
  $equipment_details_sl1157  =$data_equp_fireaxe[0]['equipment_details_sl'];
}
else
{
  $fire_axe  =0;
  $equipment_details_sl1157=0;
}


/*
$number_of_bilgepump 4 53
$number_of_firepumps 4 13
$number_of_firebucket 4 11
$number_of_sandbox 4 12
$oars 4 56
$number_of_foam 10 20
$number_of_fixed_sandbox 10 21
$fire_axe 11 57
*/
/*

$vessel_sl 
$hull_sl
$engine_sl 
$vesselmain_sl
$intimation_sl  
$registration_sl 
$vessel_insurance_sl
$pollution_sl
$equipment_details_sl18
$equipment_details_sl155
$equipment_details_sl453
$equipment_details_sl413
$equipment_details_sl411
$equipment_details_sl412
$equipment_details_sl456
$equipment_details_sl1020
$equipment_details_sl1021
$equipment_details_sl1157

*/



?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id==11) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
   <?php if($user_type_id==3) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php } ?>
  </ol>
</nav> 

<!-- <form name="form1" id="form1" method="post" action=""> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/Verify_dataentry_vessel", $attributes);
?>
  <div id="showcontent">
<div class="row">
<div class="col-12"> 
<div class="alert alert-success" role="alert home_title">
  Form 14 (Registration Certificate) Details 
  <i class="fas fa-pencil-alt float-right"></i>
</div> <!-- end of alert -->
</div> <!-- end of col12 -->
</div> <!-- end of row -->

<div class="row listrow">
  <div class="col-12 home_content pt-0">

    <input type="hidden" name="vessel_sl" id="vessel_sl" value="<?php echo $vessel_id; ?>">
    <input type="hidden" name="hull_sl" id="hull_sl" value="<?php echo $hull_sl; ?>">
    <input type="hidden" name="engine_sl" id="engine_sl" value="<?php echo $engine_sl; ?>">
    <input type="hidden" name="vesselmain_sl" id="vesselmain_sl" value="<?php echo $vesselmain_sl; ?>">
    <input type="hidden" name="intimation_sl" id="intimation_sl" value="<?php echo $intimation_sl ; ?>">
    <input type="hidden" name="registration_sl" id="registration_sl" value="<?php echo $registration_sl; ?>">
    <input type="hidden" name="vessel_insurance_sl" id="vessel_insurance_sl" value="<?php echo $vessel_insurance_sl; ?>">
    <input type="hidden" name="pollution_sl" id="pollution_sl" value="<?php echo $pollution_sl; ?>">
    <input type="hidden" name="equipment_details_sl18" id="equipment_details_lifebouy" value="<?php echo $equipment_details_sl18; ?>">
    <input type="hidden" name="equipment_details_sl155" id="equipment_details_heaving" value="<?php echo $equipment_details_sl155; ?>">
    <input type="hidden" name="equipment_details_sl453" id="equipment_details_bilgepump" value="<?php echo $equipment_details_sl453; ?>">
    <input type="hidden" name="equipment_details_sl413" id="equipment_details_firepump" value="<?php echo $equipment_details_sl413; ?>">
    <input type="hidden" name="equipment_details_sl411" id="equipment_details_firebucket" value="<?php echo $equipment_details_sl411; ?>">
     <input type="hidden" name="equipment_details_sl412" id="equipment_details_sandbox" value="<?php echo $equipment_details_sl412; ?>">
    <input type="hidden" name="equipment_details_sl456" id="equipment_details_oars" value="<?php echo $equipment_details_sl456; ?>">
    <input type="hidden" name="equipment_details_sl1020" id="equipment_details_foam" value="<?php echo $equipment_details_sl1020; ?>">
     <input type="hidden" name="equipment_details_sl1021" id="equipment_details_fixedsandbox" value="<?php echo $equipment_details_sl1021; ?>">
    <input type="hidden" name="equipment_details_sl1157" id="equipment_details_fireaxe" value="<?php echo $equipment_details_sl1157; ?>">
    <input type="hidden" name="data_id" id="data_id" value="<?php echo $data_id; ?>">
    
  </div>
</div>


<div class="row listrow">
  <div class="col-2 home_content pt-0">
     Passenger Capacity
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point"  value="<?php echo $passenger_capacity; ?>" name="passenger_capacity"  id="passenger_capacity" aria-describedby="text" placeholder="Passenger Capacity" required maxlength="3">
  </div>
  </div> <!-- end of col2 -->
  <div class="col-2 home_content pt-0">
    KIV Number
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $vessel_registration_number; ?>" name="vessel_registration_number" id="vessel_registration_number" aria-describedby="text" placeholder="Vessel registration number" required maxlength="50">
  </div>
  </div> <!-- end of col2 -->
  <div class="col-2 home_content pt-0">
    Year of registry
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control dob" value="<?php echo $vesselmain_reg_date; ?>"  name="vesselmain_reg_date" id="vesselmain_reg_date" aria-describedby="text" placeholder="Vessel registration date" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

  <div class="row listrow">

   <div class="col-2 home_content pt-0">
    Place of Registry
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    <select class="form-control btn-point js-example-basic-single" name="registering_authority_sl" id="registering_authority_sl"  required>
    <option value="">Select</option>
      <?php foreach($registeringAuthority as $res_registeringAuthority) { ?>
      <option value="<?php echo $res_registeringAuthority['registering_authority_sl']?>" <?php if($res_registeringAuthority['registering_authority_sl']==$registering_authority) {echo "selected"; } ?>><?php echo $res_registeringAuthority['registering_authority_name']?></option>
    <?php } ?>

    </select>
  </div>
  </div> <!-- end of col2 -->
  <div class="col-2 home_content pt-0">
    Registering Authority 
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">

   <!--  <input type="text" class="form-control btn-point" id="text" aria-describedby="text" placeholder="" required maxlength="50"> -->

<select class="form-control btn-point js-example-basic-single" name="user_sl" id="user_sl"  required>
    <option value="">Select</option>
      <?php foreach($ra_list as $res_ra_list) { ?>
      <option value="<?php echo $res_ra_list['user_master_id']?>" <?php if($user_sl==$res_ra_list['user_master_id']) { echo "selected"; } ?> ><?php echo $res_ra_list['user_master_fullname']?></option>
    <?php } ?>
    </select>
 

  </div>
  </div> <!-- end of col2 -->
  <div class="col-2 home_content pt-0" >
    Type of Vessel 
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
   <select class="form-control btn-point js-example-basic-single" name="vessel_type_id" id="vessel_type_id" title="Select Vessel Type" data-validation="required">
         <option value="">Select</option>
    <?php foreach ($vesseltype as $res_vesseltype)
    {
    ?>
    <option value="<?php echo $res_vesseltype['vesseltype_sl']; ?>" <?php  if($vessel_type_id==$res_vesseltype['vesseltype_sl']){ echo "selected"; } ?> > <?php echo $res_vesseltype['vesseltype_name'];?>  </option>
    <?php
    } 
    ?>
          </select> 

   
  </div>
  </div> <!-- end of col2 -->
  </div> <!-- end of listrow -->



<div class="row listrow">
     <div class="col-2 home_content pt-0">
    Subtype of Vessel
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
   
<select class="form-control btn-point js-example-basic-single" name="vessel_subtype_id" id="vessel_subtype_id" title="Select Vessel Sub Type" > 
  <?php 
  if($vessel_subtype_id!=0) {
    foreach ($vessel_subtype as $key) {
     ?>
      <option value="<?php echo $key['vessel_subtype_sl']; ?>" <?php  if($vessel_subtype_id==$key['vessel_subtype_sl']){ echo "selected"; } ?> ><?php echo $key['vessel_subtype_name']; ?></option>
     <?php
  }
    
  } ?>
 
</select>
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-0">
    Vessel Name
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" name="vessel_name" value="<?php echo $vessel_name; ?>" id="vessel_name" aria-describedby="text" placeholder="Enter Vessel Name" required maxlength="50" onkeypress="return alphaNumeric(event);" onchange="return checklength(this.id)">
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-0">
    Built at
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $build_place; ?>" name="build_place" id="build_place" aria-describedby="text" placeholder="Built at" required maxlength="20">
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
  <div class="row listrow">
      <div class="col-2 home_content pt-0">
    Hull builder name
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $hull_name; ?>" name="hull_name" id="hull_name" aria-describedby="text" placeholder="Hull name"  onkeypress="return alpbabetspace(event);" onchange="return checklength(this.id)" onpaste="return false;">
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-0">
    Year of built
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $hull_year_of_built; ?>" name="hull_year_of_built" id="hull_year_of_built" aria-describedby="text" placeholder="Year of built" required maxlength="4">
  </div>
  </div> <!-- end of col2 -->
    
       <div class="col-2 home_content pt-0">
    Port of Registry
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    
      <select class="form-control btn-point js-example-basic-single" name="portofregistry_sl" id="portofregistry_sl"  title="" required data-validation="required">
  <option value="">Select</option>
  <?php   foreach ($portofregistry as $res_portofregistry)
  {
  ?>
  <option value="<?php echo $res_portofregistry['int_portoffice_id']; ?>" <?php if($res_portofregistry['int_portoffice_id']==$vessel_registry_port_id) { echo "selected"; } ?>><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
  <?php    }    ?>
  </select>
  </div>
  </div> <!-- end of col2 -->
   
  </div> <!-- end of listrow -->
  <div class="row listrow">
     <div class="col-2 home_content pt-0">
    Registration Date
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" id="text" aria-describedby="text" placeholder=""  maxlength="10">
  </div>
  </div> <!-- end of col2 -->
      <div class="col-2 home_content pt-0">
    Description of Engine
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    
      <select class="form-control btn-point js-example-basic-single" name="engine_placement_id" id="engine_placement_id" title="Select Engine inboard/outboard" data-validation="required">
                <option value="">Select</option>
              
                    <?php
                    foreach ($inboard_outboard as $res_inboard_outboard)
                   {
                        ?>
                     <option value="<?php echo $res_inboard_outboard['inboard_outboard_sl']; ?>" <?php if($engine_placement_id==$res_inboard_outboard['inboard_outboard_sl']) { echo "selected"; } ?> > <?php echo $res_inboard_outboard['inboard_outboard_name']; ?>  </option>
                    <?php
                   }
                    ?>

                  </select>



  </div>
  </div> <!-- end of col2 -->
     <div class="col-2 home_content pt-0">
    Name &amp; Address of Engine Maker
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $manufacturer_name; ?>" name="manufacturer_name" id="manufacturer_name" aria-describedby="text" placeholder="Manufacturer name" onkeypress="return alpbabetspace(event);" onchange="checklength()" onpaste="return false;">
  </div>
  </div> <!-- end of col2 -->
 
  </div> <!-- end of listrow -->
  <div class="row listrow">
       <div class="col-2 home_content pt-0">
    Engine make year
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $make_year; ?>" name="make_year" id="make_year" aria-describedby="text" placeholder="Engine make year" required maxlength="50">
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-0">
    Number of engine set 
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $count; ?>" name="no_of_engineset" id="no_of_engineset" aria-describedby="text" placeholder="No. of engine set"  maxlength="1">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Number of shaft
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $propulsion_shaft_number; ?>" name="propulsion_shaft_number" id="propulsion_shaft_number" aria-describedby="text" placeholder="number of shaft"  maxlength="1">
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
    <div class="row listrow">
         <div class="col-2 home_content pt-1">
    Total BHP
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $bhp; ?>" name="bhp" id="bhp" aria-describedby="text" placeholder="BHP" required maxlength="3" min="1" max="999">
  </div>
  </div> <!-- end of col2 -->
        <div class="col-2 home_content pt-2">
    Speed of vessel
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point" value="<?php echo $engine_speed; ?>" name="engine_speed" id="engine_speed" placeholder="Speed of vessel" aria-label="text" aria-describedby="basic-addon2" maxlength="3" required>
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">Kmph</span>
  </div>
</div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-2">
    Extreme Length
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point" value="<?php echo $vessel_length_overall; ?>" name="vessel_length_overall" id="vessel_length_overall" placeholder="Length over all" aria-label="text" aria-describedby="basic-addon2"  maxlength="2">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">m</span>
  </div>
</div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
    <div class="row listrow">
         <div class="col-2 home_content pt-2">
    Length
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point" value="<?php echo $vessel_length; ?>" name="vessel_length" id="vessel_length" placeholder="Vessel length " aria-label="text" aria-describedby="basic-addon2" required maxlength="2"> 
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">m</span>
  </div>
</div>
  </div> <!-- end of col2 -->
         <div class="col-2 home_content pt-2">
    Breadth
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point" value="<?php echo $vessel_breadth; ?>"   name="vessel_breadth" id="vessel_breadth" placeholder="Vessel breadth" aria-label="text" aria-describedby="basic-addon2" required maxlength="2"> 
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">m</span>
  </div>


</div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-2">
    Depth
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point" value="<?php echo $vessel_depth; ?>" name="vessel_depth" id="vessel_depth" placeholder="Vessel depth" aria-label="text" aria-describedby="basic-addon2" required max="2">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">m</span>
  </div>
</div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
    <div class="row listrow">
         <div class="col-2 home_content pt-2">
    GRT
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point" value="<?php echo $grt; ?>" name="grt" id="grt" placeholder="Gross registered tonnage" aria-label="text" aria-describedby="basic-addon2" required maxlength="3">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">ton</span>
  </div>
</div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-2">
    NRT
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="input-group mb-3">
  <input type="text" class="form-control btn-point" value="<?php echo $nrt; ?>"  name="nrt" id="nrt" placeholder="Net registered tonnage" aria-label="text" aria-describedby="basic-addon2"  maxlength="3">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">ton</span>
  </div>
</div>
  </div> <!-- end of col2 -->
     <div class="col-2 home_content pt-2">
    Number of Deck
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $vessel_no_of_deck; ?>" name="vessel_no_of_deck" id="vessel_no_of_deck" aria-describedby="text" placeholder="Number of deck" required maxlength="1">
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of listrow -->
    <div class="row listrow">
    <div class="col-2 home_content">

    Number of bulkhead
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point"  value="<?php echo $bulk_heads; ?>" name="bulk_heads" id="bulk_heads" aria-describedby="text" placeholder="Number of bulkhead"  maxlength="1">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Hull material
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">

<select class="form-control btn-point js-example-basic-single" name="hullmaterial_id" id="hullmaterial_id" title="Select Materil of Hull" data-validation="required">
<option value="">Select</option>

<?php
foreach ($hullmaterial as $res_hullmaterial)
{
  ?>
<option value="<?php echo $res_hullmaterial['hullmaterial_sl']; ?>" <?php if($hullmaterial_id==$res_hullmaterial['hullmaterial_sl']) { echo "selected"; } ?> > <?php echo $res_hullmaterial['hullmaterial_name']; ?>  </option>
<?php
}
?>

</select>
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-0">
    Stern
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
   <select class="form-control btn-point js-example-basic-single" name="stern_material_sl" id="stern_material_sl" title="Select Materil of Hull" >
<option value="">Select</option>

<?php 
foreach ($stern_material as $res_stern_material) { ?>
<option value="<?php echo $res_stern_material['stern_material_sl']; ?>" <?php if($res_stern_material['stern_material_sl']==$stern_id) { echo "selected"; } ?> ><?php echo $res_stern_material['stern_material_name']; ?></option>
<?php 
}
?>

</select>
  </div>
  </div> <!-- end of col2 -->
    </div> <!-- end of row -->
<div class="row listrow">
     <div class="col-2 home_content pt-0">
    Initial registration
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" id="text" aria-describedby="text" placeholder=""  maxlength="10">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Renewal date
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" value="<?php echo $next_reg_renewal_date; ?>" name="next_reg_renewal_date" id="next_reg_renewal_date" aria-describedby="text" placeholder="Registration renewal date" maxlength="10">
  </div>
  </div> <!-- end of col2 -->
    <div class="col-2 home_content pt-0"> 
    Registration validity
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" value="<?php echo $registration_validity_period; ?>" name="registration_validity_period" id="registration_validity_period" aria-describedby="text" placeholder="Regeration validity" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
  </div> <!-- end of listrow -->

  <div class="row listrow">
       <div class="col-2 home_content pt-0">
    Area of operation
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
 <input type="text" class="form-control btn-point" value="<?php echo $area_of_operation; ?>" name="area_of_operation" id="area_of_operation" aria-describedby="text" placeholder="Area of operation" required maxlength="50">

  </div>
  </div> <!-- end of col2 -->
     <div class="col-2 home_content pt-0">
     Nature of operation
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
   <select class="form-control btn-point js-example-basic-single" id="cargo_nature" name="cargo_nature" required>
      <option value="">Select</option>
      <?php foreach($cargo_nature_list as $condtn) 
      { ?>
      <option value="<?php echo $condtn['natureofoperation_sl']; ?>" <?php if($condtn['natureofoperation_sl']==$cargo_nature) { echo "selected"; } ?>><?php echo $condtn['natureofoperation_name']?></option>
    <?php } ?>
    </select>
  </div>
  </div> <!-- end of col2 -->
 
  <div class="col-2 home_content pt-0">
      Upper deck
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
 Yes&nbsp;<input type="radio" value="Y" name="upperdeck" <?php echo ($upperdeck== 'Y') ?  "checked" : "" ;  ?>>&nbsp;&nbsp;&nbsp;
    No&nbsp; <input type="radio" value="N" name="upperdeck" <?php echo ($upperdeck== 'N') ?  "checked" : "" ;  ?>>

  </div>
  </div> <!-- end of col2 -->
 </div> <!-- end of listrow -->
<!-- end of certificate of registration -->



<div class="row pt-3">
  <div class="col-12">
    <div class="alert alert-secondary" role="alert">
    Certificate of Survey Details 
    <i class="fas fa-pencil-alt float-right"></i>
</div>
  </div> <!-- end of col12 -->
</div> <!-- end of row -->

<div class="row listrow">
  <div class="col-2 home_content pt-0">
    Details of Master
  </div> <!-- end of col2 -->
   <div class="col-10 home_subtitle">

<!-- -------------------------------------- Inside Master details --------------------------------- -->
<?php 
$i=1;
if(!empty($data_crew_master))
{
  foreach ($data_crew_master as $key_master)
  {
    $crew_sl_master=$key_master['crew_sl'];
    $master_name=$key_master['name_of_type'];
    $master_license=$key_master['license_number_of_type'];

    
?>
<span id="optionBox_mr">
<div class="row listrow" id="addrow_mr<?php echo $i; ?>">
<div class="col-3">
<div class="form-group">
<input type="hidden" name="crew_sl_master[]" id="crew_sl_master" value="<?php echo $crew_sl_master ?>">
<input type="text" class="form-control btn-point" value="<?php echo $master_name; ?>" name="name_of_type_mr[]" id="name_of_type_mr" aria-describedby="text" placeholder="Name of master" required maxlength="50">
</div>
</div> 

<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point txtcapital" value="<?php echo $master_license; ?>"  name="license_number_of_type_mr[]"  id="license_number_of_type_mr" aria-describedby="text" placeholder="License number" maxlength="20">
</div>
</div> 
 <div class="col-3 ">
<button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove(<?php echo $i; ?>)"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button>
</div>  
</div> 

<input type="hidden" value="<?php echo $i; ?>" name="cnt" id="cnt">
<input type="hidden" value="<?php echo $i; ?>" name="master_cnt" id="master_cnt">
</span>
<?php 
$i++;
}
}
?>


<div class="col-3 pb-3">
  <button class="btn btn-primary btn-flat btn-point btn-sm btn_content_w" type="button" id="add"><i class="fas fa-plus"></i>&nbsp; Add New Master</button>
</div>
<!-- ---------------------------- End of Inside Master details ------------------------------------ -->
</div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-2 home_content pt-0">
    Details of Serang
  </div> <!-- end of col2 -->
   <div class="col-10 home_subtitle">
<!-- ------------------------------ Inside Serang details ------------------------------------------ -->
<?php 
$j=1;
if(!empty($data_crew_serang))
{
  foreach ($data_crew_serang as $key_serang)
  {
    $serang_name=$key_serang['name_of_type'];
    $serang_license=$key_serang['license_number_of_type'];
     $crew_sl_serang=$key_serang['crew_sl'];
    
?>
<span id="optionBox_sg">
<div class="row listrow" id="addrow_sg<?php echo $j;?>">
<div class="col-3">
<div class="form-group">
  <input type="hidden" name="crew_sl_serang[]" id="crew_sl_serang" value="<?php echo $crew_sl_serang ?>">
<input type="text" class="form-control btn-point" value="<?php echo $serang_name; ?>" name="name_of_type_sg[]" id="name_of_type_sg" aria-describedby="text" placeholder="Name of master" required maxlength="50">
</div>
</div> 

<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point txtcapital" value="<?php echo $serang_license; ?>" name="license_number_of_type_sg[]"  id="license_number_of_type_sg" aria-describedby="text" placeholder="License number" maxlength="20">
</div>
</div> 

 <div class="col-3 pt-0">
<button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_sg(<?php echo $j; ?>)"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button>
</div>  
</div> 
<input type="hidden" value="<?php echo $j; ?>" name="cnt_sg" id="cnt_sg">
<input type="hidden" value="<?php echo $j; ?>" name="serang_cnt" id="serang_cnt">
</span>
<?php 
$j++;
}
}
?>

 <div class="col-3 pb-3">
  <button class="btn btn-primary btn-flat btn-point btn-sm btn_content_w" type="button" id="add_sg"><i class="fas fa-plus"></i>&nbsp; Add New Serang</button>
</div>
<!-- -------------------------- End of Inside Serang details --------------------------------------- -->
</div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-2 home_content pt-0">
    Details of Lascar
  </div> <!-- end of col2 -->
   <div class="col-10 home_subtitle">
<!-- ----------------------------------- Inside Lascar details ------------------------------------- -->
<?php 
$k=1;
if(!empty($data_crew_lascar))
{
  foreach ($data_crew_lascar as $key_lascar)
  {
    $lascar_name=$key_lascar['name_of_type'];
    $lascar_license=$key_lascar['license_number_of_type'];
      $crew_sl_lascar=$key_lascar['crew_sl'];
       
?>

<span id="optionBox_lr">
<div class="row listrow" id="addrow_lr<?php echo $k; ?>">
<div class="col-3">
<div class="form-group">
  <input type="hidden" name="crew_sl_lascar[]" id="crew_sl_lascar" value="<?php echo $crew_sl_lascar ?>">
<input type="text" class="form-control btn-point" value="<?php echo $lascar_name; ?>" name="name_of_type_lr[]" id="name_of_type_lr" aria-describedby="text" placeholder="Name of master" required maxlength="50">
</div>
</div> 

<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point txtcapital" value="<?php echo $lascar_license; ?>" name="license_number_of_type_lr[]"  id="license_number_of_type_lr" aria-describedby="text" placeholder="License number" maxlength="20">
</div>
</div> 

<div class="col-3 pt-0">
<button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_lr(<?php echo $k; ?>)"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button>
</div> 

</div> 

<input type="hidden" value="<?php echo $k; ?>" name="cnt_lr" id="cnt_lr">
<input type="hidden" value="<?php echo $k; ?>" name="lascar_cnt" id="lascar_cnt">
</span>
<?php 
$k++;
}
}
?>
 <div class="col-3 pb-3">
  <button class="btn btn-primary btn-flat btn-point btn-sm btn_content_w" type="button" id="add_lr"><i class="fas fa-plus"></i>&nbsp; Add New Lascar</button>
</div>
  <!-- ------------------------------------ End of Inside Lascar details --------------------------- -->
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->



<div class="row listrow">
  <div class="col-2 home_content pt-0">
    Details of Driver
  </div> <!-- end of col2 -->
   <div class="col-10 home_subtitle">
     <!-- ------------------------- Inside Driver details ------------------------------- -->
<?php 
$m=1;
if(!empty($data_crew_driver))
{
  foreach ($data_crew_driver as $key_driver)
  {
    $driver_name=$key_driver['name_of_type'];
    $driver_license=$key_driver['license_number_of_type'];
    $crew_sl_driver=$key_driver['crew_sl'];
       
?>
<span id="optionBox_dr">
<div class="row listrow" id="addrow_dr<?php echo $m; ?>">
<div class="col-3">
<div class="form-group">
<input type="hidden" name="crew_sl_driver[]" id="crew_sl_driver" value="<?php echo $crew_sl_driver ?>">
<input type="text" class="form-control btn-point" value="<?php echo $driver_name; ?>" name="name_of_type_dr[]" id="name_of_type_dr" aria-describedby="text" placeholder="Name of Driver" required maxlength="50">
</div>
</div> 

<div class="col-3">
<div class="form-group">
<input type="text" class="form-control btn-point txtcapital" value="<?php echo $driver_license; ?>" name="license_number_of_type_dr[]"  id="license_number_of_type_dr" aria-describedby="text" placeholder="License number" maxlength="20">
</div>
</div> 

<div class="col-3 pt-0">
<button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_dr(<?php echo $m; ?>)"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button>
</div> 

</div> 

<input type="hidden" value="<?php echo $m; ?>" name="cnt_dr" id="cnt_dr">
<input type="hidden" value="<?php echo $m; ?>" name="driver_cnt" id="driver_cnt">
</span>
<?php 
$m++;
}
}
?>

 <div class="col-3 pb-3">
  <button class="btn btn-primary btn-flat btn-point btn-sm btn_content_w" type="button" id="add_dr"><i class="fas fa-plus"></i>&nbsp; Add New Driver</button>
</div>
 
    <!-- -------------------------------------------- End of Inside Driver details -------------------------------------------------------- -->
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->




<div class="row pt-3">
<div class="col-12">
<div class="alert alert-secondary" role="alert">
<i class="fas fa-pencil-alt float-right"></i>
</div>
</div> <!-- end of col12 -->
</div> <!-- end of row -->





<div class="row listrow">
  <div class="col-2 home_content pt-0">
     Number of bed rooms 
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
   <input type="text" class="form-control btn-point" value="<?php echo $number_of_bedrooms; ?>" name="number_of_bedrooms" id="number_of_bedrooms" aria-describedby="text" placeholder="No. of bed" maxlength="3">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Engine Number
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $engine_number; ?>" name="engine_number" id="engine_number" aria-describedby="text" placeholder="Engine number" required maxlength="20">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Nature of fuel
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
    <select class="form-control btn-point js-example-basic-single" name="fuel_sl" id="fuel_sl" required>
      <option value="">Select</option>
      <?php foreach($fuel as $res_fuel) { ?>
      <option value="<?php echo $res_fuel['fuel_sl']?>" <?php if($fuel_used_id==$res_fuel['fuel_sl']) { echo "selected"; } ?> ><?php echo $res_fuel['fuel_name']?></option>
    <?php } ?>

    </select>
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->



<div class="row listrow">
  <div class="col-3 home_content pt-0">
    Is hull in good condition
  </div> <!-- end of col2 -->
   <div class="col-1 home_subtitle pt-0">
    <input tabindex="10" type="checkbox"  name="hull_condition_status_id" id="icheckbox_square-green" <?php echo ($hull_condition_status_id== 1) ?  "checked" : "" ;  ?>>
  </div> <!-- end of col2 -->
   <div class="col-3 home_content pt-0">
    Has vessel tested for stability
  </div> <!-- end of col2 -->
   <div class="col-1 home_subtitle pt-0">
    <input tabindex="10" type="checkbox" name="stability_test_status_id" id="icheckbox_square-green"  <?php echo ($stability_test_status_id== 1) ?  "checked" : "" ;  ?>>
  </div> <!-- end of col2 -->
   <div class="col-3 home_content pt-0">
    Are all equipments under rule
  </div> <!-- end of col2 -->
   <div class="col-1 home_subtitle pt-0">
    <input tabindex="10" type="checkbox" name="condition_of_equipment" id="icheckbox_square-green" <?php echo ($condition_of_equipment== 1) ?  "checked" : "" ;  ?>>
 
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-3 home_content pt-0">
    Life Saving equipment details 
  </div> <!-- end of col2 -->
   <div class="col-9 home_subtitle">
    <!-- ----------------------------- Inside life saving equipments --------------------------------------------------- -->
<?php
$i=1;
if(!empty($life_save_equipment)) 
{
 foreach ($life_save_equipment as $key1) {

 $equipment_sl=$key1['equipment_sl'];
 $equipment_type_id=$key1['equipment_type_id'];


$life_save_dtls =   $this->DataEntry_model->get_equipment_dtls($vessel_id,$equipment_type_id,$equipment_sl);
$data['life_save_dtls'] =  $life_save_dtls;
//print_r($life_save_dtls);

if(!empty($life_save_dtls))
{
$equipment_details_sl     =$life_save_dtls[0]['equipment_details_sl'];
$number_adult             =$life_save_dtls[0]['number_adult'];
$number_children          =$life_save_dtls[0]['number_children'];
}
else
{
  $equipment_details_sl=0;
$number_adult="";
$number_children="";
}
 



   ?>


<div class="row listrow">
<div class="col-4">
<div class="form-group">

<input type="hidden"  value="<?php echo $equipment_details_sl; ?>"  name="equipment_details_sl<?php echo $i; ?>" id="equipment_sl<?php echo $i; ?>" value="<?php echo $key1['equipment_sl'];?>">

<input type="hidden"  value="<?php echo $equipment_sl; ?>"  name="equipment_sl<?php echo $i; ?>" id="equipment_sl<?php echo $i; ?>" value="<?php echo $key1['equipment_sl'];?>">

<?php echo $key1['equipment_name'];?>

</div>
</div> <!-- end of col6 -->

<div class="col-4">
  <div class="form-group">
    <input type="text" class="form-control btn-point"   value="<?php echo $number_adult; ?>" name="number_adult<?php echo $i; ?>" id="number_adult<?php echo $i; ?>" aria-describedby="text" placeholder="No. of  <?php echo $key1['equipment_name'];?> in adult" maxlength="3" >
  </div>
  </div> <!-- end of col6 -->

   <div class="col-4">
     <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $number_children; ?>"  name="number_children<?php echo $i; ?>" id="number_children<?php echo $i; ?>" aria-describedby="text" placeholder="No. of  <?php echo $key1['equipment_name'];?> in children" maxlength="3" >
  </div>
  </div> <!-- end of col4 -->
</div> <!-- end of row -->

<?php 
$i++; 
}
}
?>

<!-- -------------------------------------------------------- end of life saving equipments --------------------------------------- -->
  </div> <!-- end of col10 -->



</div> <!-- end of listrow -->
<div class="row listrow">
  <div class="col-3 home_content pt-0">
    Fire fighting equipment details 
  </div> <!-- end of col2 -->
   <div class="col-9 home_subtitle">
    <!-- ---------------  ------------------ Inside fire fighting equipments    ----------------------------------------------------->
    <?php 
    $j=1;
    if(!empty($fire_fighting_details))
    {
      //print_r($fire_fighting_details);
    foreach($fire_fighting_details as $key2) { ?>
    <div class="row listrow">
      <div class="col-4">
      <div class="form-group">
        <input type="hidden" name="fire_extinguisher_sl[]" id="fire_extinguisher_sl<?php echo $j; ?>" value="<?php echo $key2['fire_extinguisher_sl'];?>">


    <input type="hidden" name="fire_extinguisher_type_id[]" id="portable_fire_extinguisher_sl<?php echo $j; ?>" value="<?php echo $key2['portable_fire_extinguisher_sl'];?>">
   <?php echo $key2['portable_fire_extinguisher_name'];?>

  </div>
</div> <!-- end of col6 -->
<div class="col-4">
  <div class="form-group">
    <input type="text" class="form-control btn-point" name="firenumber[]" id="firenumber<?php echo $j; ?>" aria-describedby="text" placeholder="No. of  <?php echo $key2['portable_fire_extinguisher_name'];?>" required maxlength="3" value="<?php echo $key2['fire_extinguisher_number'] ?>">
  </div>
  </div> <!-- end of col6 -->

  <div class="col-4">
  <div class="form-group">
    <input type="text" class="form-control btn-point" name="capacity[]" id="capacity<?php echo $j; ?>" aria-describedby="text" placeholder="Capacity of  <?php echo $key2['portable_fire_extinguisher_name'];?>" required maxlength="3"  value="<?php echo $key2['fire_extinguisher_capacity'] ?>">
  </div>
  </div> <!-- end of col6 -->


  <div class="col-4">
    
  </div> <!-- end of col4 -->
</div> <!-- end of row -->


<?php 
$j++;
}  } ?>
<input type="hidden" name="fireext_count" value="<?php echo ($j-1);?>">

<!-------------------------------------------- end of firefighting equipments ------------------------------------------- -->
  </div> <!-- end of col10 -->
</div> <!-- end of listrow -->
<div class="row listrow">
  <div class="col-3 home_content pt-0">
    Pollution control devices details 
  </div> <!-- end of col2 -->
   <div class="col-9 home_subtitle">
    <div class="form-group">

    <select class="js-example-basic-multiple" name="list3[]" multiple="multiple">
    <option value="">Select list</option>
    <?php 
    foreach ($pollution_control as $key3)
    {
      if(!empty($get_pollncntrl_equipment))
      {
         $equipment_id_polln = $get_pollncntrl_equipment[0]['equipment_id']; 
      }
      else
      {
        $equipment_id_polln = 0;
      }
    ?>
    <option value="<?php echo $key3['equipment_sl']; ?>" <?php if($equipment_id_polln==$key3['equipment_sl']) { echo  "selected"; }?>><?php echo $key3['equipment_name']; ?></option>
    <?php }     ?>
    </select>
    </div>


  </div> <!-- end of col10 -->
</div> <!-- end of listrow -->

<div class="row pt-3">
<div class="col-12">
<div class="alert alert-secondary" role="alert">
<i class="fas fa-pencil-alt float-right"></i>
</div>
</div> <!-- end of col12 -->
</div> <!-- end of row -->


<div class="row listrow">
  <div class="col-12 home_content "> Number of passengers in </div>
  <div class="col-2 home_content pt-0">
    Lower Deck
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point"  value="<?php echo $lower_deck_passenger; ?>" name="lower_deck_passenger" id="lower_deck_passenger" aria-describedby="text" placeholder="No. of lower deck passenger" maxlength="3">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Upper Deck
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $upper_deck_passenger; ?>" name="upper_deck_passenger" id="upper_deck_passenger" aria-describedby="text" placeholder="No. of upper deck passenger" maxlength="3">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Four Day Cruise
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="text" class="form-control btn-point" value="<?php echo $four_cruise_passenger; ?>" name="four_cruise_passenger" id="four_cruise_passenger" aria-describedby="text" placeholder="No. of four day cruise" maxlength="3">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->

<div class="row listrow">
  <div class="col-2 home_content pt-0">
    Number of life bouys
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <!-- <textarea class="form-control btn-point btn-block" id="textarea" name="repair_details_nature" rows="5"></textarea> -->

    <input type="text" class="form-control btn-point" value="<?php echo $number_of_lifebouys; ?>" name="number_of_lifebouys" id="number_of_lifebouys" aria-describedby="text" placeholder="No. of life bouys" maxlength="3">

  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Next drydock date
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" value="<?php echo $next_drydock_date; ?>" name="next_drydock_date" id="next_drydock_date" aria-describedby="text" placeholder="" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
    Validity of Certificate
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
    <input type="date" class="form-control btn-point dob" name="validity_of_certificate" id="validity_of_certificate" value="<?php echo $validity_of_certificate; ?>" aria-describedby="text" placeholder="Validity of certificate" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->



<div class="row listrow">
  <div class="col-1 home_content pt-0">
   <!--  Remarks of Surveyor -->Place of survey
  </div> <!-- end of col2 -->
   <div class="col-3 home_subtitle">
     <div class="form-group">
   <!--  <textarea class="form-control btn-point btn-block" id="remarks" name="remarks" rows="5"></textarea> -->
     <select class="form-control btn-point js-example-basic-single" name="placeofsurvey_sl" id="placeofsurvey_sl" required>
      <option value="">Select</option>
            <?php foreach ($placeof_survey as $res_placeofsurvey) {
             ?>
              <option value="<?php echo $res_placeofsurvey['placeofsurvey_sl']; ?>" <?php if($placeofsurvey_id==$res_placeofsurvey['placeofsurvey_sl']) { echo "selected";  } ?> ><?php echo $res_placeofsurvey['placeofsurvey_name']; ?></option>
           <?php } ?> 
    </select>
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
     Date of survey
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
      <div class="form-group">
   <input type="date" class="form-control btn-point dob" value="<?php echo $date_of_survey; ?>" name="date_of_survey" id="date_of_survey" aria-describedby="text" placeholder="Date of survey" required maxlength="10">
  </div>
  </div> <!-- end of col2 -->
   <div class="col-2 home_content pt-0">
  Bilge pump
  </div> <!-- end of col2 -->
   <div class="col-2 home_subtitle">
    <div class="form-group">
   <input type="hidden" name="equipment_type_id4" id="equipment_type_id4" value="4">
   <input type="text" class="form-control btn-point" value="<?php echo $number_of_bilgepump; ?>" name="number_of_bilgepump" id="number_of_bilgepump" aria-describedby="text" placeholder="No. of bilge pump" maxlength="3">
    <input type="hidden" name="equipment_id53" id="equipment_id53" value="53">
  </div>
  </div> <!-- end of col2 -->
</div> <!-- end of listrow -->



<div class="row listrow">
  <div class="col-1 home_content pt-0">
  Fire pump
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
    <input type="hidden" name="equipment_type_id4" id="equipment_type_id4" value="4">
   <input type="text" class="form-control btn-point" value="<?php echo $number_of_firepumps; ?>" name="number_of_firepumps" id="number_of_firepumps" aria-describedby="text" placeholder="No. of fire pumps" maxlength="3">
    <input type="hidden" name="equipment_id13" id="equipment_id13" value="13">
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
  Fire bucket
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
 <input type="text" class="form-control btn-point" value="<?php echo $number_of_firebucket; ?>" name="number_of_firebucket" id="number_of_firebucket" aria-describedby="text" placeholder="No. of fire bucket" maxlength="3">
    <input type="hidden" name="equipment_id11" id="equipment_id11" value="11">
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
  Sandbox
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
   <input type="text" class="form-control btn-point" value="<?php echo $number_of_sandbox; ?>" name="number_of_sandbox" id="number_of_sandbox" aria-describedby="text" placeholder="No. of sandbox" maxlength="3">
    <input type="hidden" name="equipment_id12" id="equipment_id12" value="12">
  </div>
  </div> 
</div> 



<div class="row listrow">
  <div class="col-1 home_content pt-0">
  First aid box
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
  Yes&nbsp;<input type="radio" value="Y" name="first_aid_box" <?php echo ($first_aid_box== 1) ?  "checked" : "" ;  ?>>&nbsp;&nbsp;&nbsp;No&nbsp;<input type="radio" value="N" name="first_aid_box" <?php echo ($first_aid_box== 0) ?  "checked" : "" ;  ?>>
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
   Foam 

  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
   <input type="hidden" name="equipment_type_id10" id="equipment_type_id10" value="10">
   <input type="text" class="form-control btn-point" value="<?php echo $number_of_foam; ?>" name="number_of_foam" id="number_of_foam" aria-describedby="text" placeholder="No. of foam" maxlength="3">
    <input type="hidden" name="equipment_id20" id="equipment_id20" value="20"> 
   
  </div>
  </div> 

  <div class="col-2 home_content pt-0">
  Sandbox
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
   <input type="text" class="form-control btn-point" value="<?php echo $number_of_fixed_sandbox; ?>" name="number_of_fixed_sandbox" id="number_of_fixed_sandbox" aria-describedby="text" placeholder="No. of fixed sandbox" maxlength="3">
    <input type="hidden" name="equipment_id21" id="equipment_id21" value="21">
  </div>
  </div> 
</div> 


<div class="row listrow">
  <div class="col-1 home_content pt-0">
  Heaving line
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
  <input type="text" class="form-control btn-point" value="<?php echo $heaving_line_count;  ?>" name="heaving_line_count" id="heaving_line_count" aria-describedby="text" placeholder="No. of heaving line" maxlength="3">
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
  Oars
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
 <input type="text" class="form-control btn-point" value="<?php echo $oars; ?>" name="oars" id="oars" aria-describedby="text" placeholder="No. of oarsline" maxlength="3">
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
  Fire axe
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
   <input type="text" class="form-control btn-point" value="<?php echo $fire_axe; ?>" name="fire_axe" id="fire_axe" aria-describedby="text" placeholder="No. of fire axe" maxlength="3">
  </div>
  </div> 
</div> 



<div class="row listrow">
  <div class="col-1 home_content pt-0">
 Insurance expiry date
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
<input type="date" class="form-control btn-point dob" value="<?php echo $insurance_expiry_date; ?>" name="insurance_expiry_date" id="insurance_expiry_date" aria-describedby="text" value="<?php echo date('Y-m-d'); ?>" maxlength="10">
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
  PCB certificate number
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
  <input type="text" class="form-control btn-point" value="<?php echo $pcb_certificate_number; ?>" name="pcb_certificate_number" id="pcb_certificate_number" aria-describedby="text" placeholder=" PCB certificate number" maxlength="50">
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
  PCB expiry date
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
 <input type="date" class="form-control btn-point dob"  value="<?php echo $pcb_expiry_date; ?>" name="pcb_expiry_date" id="pcb_expiry_date" aria-describedby="text" value="<?php echo date('Y-m-d'); ?>" maxlength="10">
  </div>
  </div> 
</div> 

<div class="row pt-3">
<div class="col-12">
<div class="alert alert-secondary" role="alert">
Owner details
<i class="fas fa-pencil-alt float-right"></i>
</div>
</div> <!-- end of col12 -->
</div> <!-- end of row -->


<div class="row listrow">
<div class="col-1 home_content pt-0" required>
Email Id
</div> 
<div class="col-3 home_subtitle">
<div class="form-group">
 <input type="text" class="form-control btn-point" value="" data-validation="required" name="user_email" id="user_email" aria-describedby="text" placeholder="Email Id" maxlength="50" required>
</div>
</div> 
<div class="col-2 home_content pt-0">
</div> 
<div class="col-2 home_subtitle">
<div class="form-group">
</div>
</div> 
<div class="col-2 home_content pt-0">
</div> 
<div class="col-2 home_subtitle">
<div class="form-group">
 </div>
</div> 
</div> 

<div id="owner_dt_yid"></div>
<!-- if email id not exists -->
<div class="row listrow" id="owner_dt_id">
<div class="col-1 home_content pt-0">
Owner Name 
</div> 
<div class="col-3 home_subtitle">
<div class="form-group">
  <input type="text" class="form-control btn-point" value="" name="user_name" id="user_name" aria-describedby="text" placeholder="Vessel owners name" maxlength="50" data-validation="required" onkeypress="return alpbabetspace(event);" required>
</div>
</div> 
<div class="col-2 home_content pt-0">
Mobile Number
</div> 
<div class="col-2 home_subtitle">
<div class="form-group">
<input type="tel" class="form-control btn-point" value="" name="user_mobile_number" id="user_mobile_number" aria-describedby="text" data-validation="required" placeholder="Owner mobile number" minlength="10" maxlength="10"  onkeypress="return IsNumeric(event);" required>
</div>
</div> 
<div class="col-2 home_content pt-0">
Address
</div> 
<div class="col-2 home_subtitle">
<div class="form-group">
<textarea class="form-control btn-point btn-block" id="textarea" rows="5" name="user_address" id="user_address" onkeypress="return IsAddress(event);" data-validation="required" maxlength="100" placeholder="Address of owner" required></textarea>
</div>
</div> 
</div>



<!--
<div class="row listrow">
<div class="col-1 home_content pt-0">
Owner Name 
</div> 
<div class="col-3 home_subtitle">
<div class="form-group">
  <input type="text" class="form-control btn-point" value="" name="user_name" id="user_name" aria-describedby="text" placeholder="Vessel owners name" maxlength="50" data-validation="required" onkeypress="return alpbabetspace(event);" required>
</div>
</div> 
<div class="col-2 home_content pt-0">
Mobile Number
</div> 
<div class="col-2 home_subtitle">
<div class="form-group">
<input type="tel" class="form-control btn-point" value="" name="user_mobile_number" id="user_mobile_number" aria-describedby="text" data-validation="required" placeholder="Owner mobile number" minlength="10" maxlength="10"  onkeypress="return IsNumeric(event);" required>
</div>
</div> 
<div class="col-2 home_content pt-0">
Email Id
</div> 
<div class="col-2 home_subtitle">
<div class="form-group">
 <input type="text" class="form-control btn-point" value="" data-validation="required" name="user_email" id="user_email" aria-describedby="text" placeholder="Email Id" maxlength="50" required>
</div>
</div> 
</div> -->
<!--<div class="row listrow">
  <div class="col-1 home_content pt-0">
Address 
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
<textarea class="form-control btn-point btn-block" id="textarea" rows="5" name="user_address" id="user_address" onkeypress="return IsAddress(event);" data-validation="required" maxlength="100" placeholder="Address of owner" required></textarea>
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
&nbsp;
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
  &nbsp;
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
  &nbsp;
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
  &nbsp;
  </div>
  </div> 
</div> -->


<!-- 
<div class="row listrow">
  <div class="col-1 home_content pt-0">
 &nbsp;
  </div> 
  <div class="col-3 home_subtitle">
  <div class="form-group">
&nbsp;
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
&nbsp;
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
  &nbsp;
  </div>
  </div> 
  <div class="col-2 home_content pt-0">
  &nbsp;
  </div> 
  <div class="col-2 home_subtitle">
  <div class="form-group">
  &nbsp;
  </div>
  </div> 
</div>  -->


<!-- end of listrow2 -- Survey row -->
<div class="row listrow">
  <div class="col-12 d-flex justify-content-center">
    <input type="submit" class="btn btn-success btn-point btn-flat" name="btnsubmit" id="btnsubmit" value="Edit and verification">
  </div> <!-- end of col12 -->
<!-- end of listrow2 -- Survey row -->
</div> <!-- end of container fluid -->


</div> <!-- end of showcontent div -->

<!-- </form> --> <?php echo form_close(); ?>
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
<script>
$(document).ready(function() 
{
  $('.js-example-basic-multiple').select2({ width: '100%' });
  $('.js-example-basic-single').select2({ width: '100%' });
});

$(document).ready(function() {
  $('input').iCheck({
  checkboxClass: 'icheckbox_square-green',
  radioClass: 'iradio_square-green',
  increaseArea: '20%' // optional
  });
}); // end of ready function 

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

<script type="text/javascript">
$(document).ready(function() 
{
  $("#owner_dt_id").hide();
  $("#owner_dt_yid").hide();
  $("#vessel_type_id").change(function()
  {
    var vessel_type_id=$("#vessel_type_id").val();
    if(vessel_type_id != '')
    { 
      $.ajax
      ({
        type: "POST",
        url:"<?php echo site_url('Kiv_Ctrl/DataEntry/vessel_subtype/')?>"+vessel_type_id,
        success: function(data)
        {         
          $("#vessel_subtype_id").html(data);
        }
      });
    }
  });

  $("#user_name").change(function()
  {
    var user_name=$("#user_name").val();
    //alert(user_name.length);
    if(user_name.length<4)
    {
      alert("Name should contain atleast 4 characters");
      $("#user_name").val('');
      $("#user_name").focus();
    }
  });

  $("#user_address").change(function()
  {
    var user_address=$("#user_address").val();
    if(user_address.length<10)
    {
      alert("Address should contain atleast 10 characters");
      $("#user_address").val('');
      $("#user_address").focus();
    }
  });


  $("#user_mobile_number").change(function()
  {
    var mob=$("#user_mobile_number").val();
    var mob_length = mob.length; 
    if(mob_length<10)
    {
      alert('Please enter 10 digit mobile number');
      $("#user_mobile_number").val('');
      // $("#user_mobile_number").focus();
      return false;
    }
    if(mob!='')
    {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({type: "POST",
      url:"<?php echo site_url('/Kiv_Ctrl/Registration/mobileverify')?>",
      data: { mob: mob,'csrf_test_name': csrf_token},
      success: function(data)
      { 
        if(data == "1")
        {
          alert("This mobile number already exists");
          $("#user_mobile_number").val('');
          $("#user_mobile_number").focus();
        }
      }
      });  
    }
  });
  $("#user_email").change(function()
  {
    var email_id=$("#user_email").val();
    //alert(email_id);
    if(email_id!='')
    {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({type: "POST",
      url:"<?php echo site_url('/Kiv_Ctrl/Registration/email_id_check')?>",
      data: { email_id: email_id,'csrf_test_name': csrf_token},
      success: function(data)
      { 
        //alert(data);

        if(data!=0)
        {
          //alert(data);
          $("#owner_dt_yid").html(data);
          $("#owner_dt_yid").show(); 
          $("#owner_dt_id").hide(); 
        }
        else
        {
          //alert(data);
         $("#owner_dt_id").show();
         $("#owner_dt_yid").hide(); 
        }
      }

      });  
    }
  });

 /* $("#user_email").change(function()
  {
    var email_id=$("#user_email").val();
    if(email_id!='')
    {
      var csrf_token = '<?php echo $this->security->get_csrf_hash(); ?>';
      $.ajax({type: "POST",
      url:"<?php echo site_url('/Kiv_Ctrl/Registration/email_id_verify')?>",
      data: { email_id: email_id,'csrf_test_name': csrf_token},
      success: function(data)
      { 
        if(data == "1")
        {
          alert("This Email Id  already exists");
          $("#user_email").val('');
          $("#user_email").focus();
        }
      }
      });  
    }
  }); */ 

  $('#add').click(function() 
  {
    var cou=parseInt(document.getElementById('cnt').value);
    var incr=cou+1;
    var d="addrow_mr"+incr;
    document.getElementById('cnt').value=incr;
    var master_cnt=parseInt(document.getElementById('master_cnt').value);
    document.getElementById('master_cnt').value=master_cnt+1;
    $('#optionBox_mr').append('<div class="row listrow" id="addrow_mr'+incr+'"><div class="col-3"><div class="form-group"><input type="hidden" name="crew_sl_master[]" id="crew_sl_master" value="0"><input type="text" class="form-control btn-point" name="name_of_type_mr[]" id="name_of_type_mr" aria-describedby="text" placeholder="Name of master" required maxlength="50"></div></div><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point txtcapital" name="license_number_of_type_mr[]"  id="license_number_of_type_mr" aria-describedby="text" placeholder="License number" maxlength="20"></div></div><div class="col-3 "><button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove('+incr+')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button></div></div>');
  });

  $('#add_sg').click(function() 
  {
    var cou=parseInt(document.getElementById('cnt_sg').value);
    var incr_sg=cou+1;
    var d="addrow_sg"+incr_sg;
    document.getElementById('cnt_sg').value=incr_sg;
    var serang_cnt=parseInt(document.getElementById('serang_cnt').value);
    document.getElementById('serang_cnt').value=serang_cnt+1;
    $('#optionBox_sg').append('<div class="row listrow" id="addrow_sg'+incr_sg+'"><div class="col-3"><div class="form-group"><input type="hidden" name="crew_sl_serang[]" id="crew_sl_serang" value="0"><input type="text" class="form-control btn-point" name="name_of_type_sg[]" id="name_of_type_sg" aria-describedby="text" placeholder="Name of master" required maxlength="50"></div></div><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point txtcapital" name="license_number_of_type_sg[]"  id="license_number_of_type_sg" aria-describedby="text" placeholder="License number" maxlength="20"></div></div><div class="col-3 "><button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_sg('+incr_sg+')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button></div></div>');
  });

  $('#add_lr').click(function() 
  {
    var cou=parseInt(document.getElementById('cnt_lr').value);
    var incr_lr=cou+1;
    var d="addrow_lr"+incr_lr;
    document.getElementById('cnt_lr').value=incr_lr;
    var lascar_cnt=parseInt(document.getElementById('lascar_cnt').value);
    document.getElementById('lascar_cnt').value=lascar_cnt+1;
    $('#optionBox_lr').append('<div class="row listrow" id="addrow_lr'+incr_lr+'"><div class="col-3"><div class="form-group"><input type="hidden" name="crew_sl_lascar[]" id="crew_sl_lascar" value="0"><input type="text" class="form-control btn-point" name="name_of_type_lr[]" id="name_of_type_lr" aria-describedby="text" placeholder="Name of master" required maxlength="50"></div></div><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point txtcapital" name="license_number_of_type_lr[]"  id="license_number_of_type_lr" aria-describedby="text" placeholder="License number" maxlength="20"></div></div><div class="col-3 "><button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_lr('+incr_lr+')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button></div></div>');
  });

  $('#add_dr').click(function() 
  {
    var cou=parseInt(document.getElementById('cnt_dr').value);
    var incr_dr=cou+1;
    var d="addrow_dr"+incr_dr;
    document.getElementById('cnt_dr').value=incr_dr;
    var driver_cnt=parseInt(document.getElementById('driver_cnt').value);
    document.getElementById('driver_cnt').value=driver_cnt+1;
    $('#optionBox_dr').append('<div class="row listrow" id="addrow_dr'+incr_dr+'"><div class="col-3"><div class="form-group"><input type="hidden" name="crew_sl_driver[]" id="crew_sl_driver" value="0"><input type="text" class="form-control btn-point" name="name_of_type_dr[]" id="name_of_type_dr" aria-describedby="text" placeholder="Name of master" required maxlength="50"></div></div><div class="col-3"><div class="form-group"><input type="text" class="form-control btn-point txtcapital" name="license_number_of_type_dr[]"  id="license_number_of_type_dr" aria-describedby="text" placeholder="License number" maxlength="20"></div></div><div class="col-3 "><button class="btn btn-danger btn-flat btn-point btn-sm btn_content_w" type="button" id="remove" onclick="remove_dr('+incr_dr+')"> <i class="far fa-trash-alt"></i>&nbsp; Delete </button></div></div>');
  });
  $('.txtcapital').keyup(function() 
  {
    this.value = this.value.toUpperCase();
  });
 //_______________Jquery ending_______________________//  
});

function remove(txt)
{
  var crew_sl_master=document.getElementById('crew_sl_master').value;
  $.ajax
  ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/delete_crew_details/')?>"+crew_sl_master,
    success: function(data)
    {         
    }
  });
  $('#addrow_mr'+txt).remove();
  var  master_cnt=document.getElementById('master_cnt').value;
  document.getElementById('master_cnt').value=master_cnt-1;
}

function remove_sg(txt)
{
  var crew_sl_serang=document.getElementById('crew_sl_serang').value;
  $.ajax
  ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/delete_crew_details/')?>"+crew_sl_serang,
    success: function(data)
    {         
    }
  });
  $('#addrow_sg'+txt).remove();
  var  serang_cnt=document.getElementById('serang_cnt').value;
  document.getElementById('serang_cnt').value=serang_cnt-1;
}

function remove_lr(txt)
{
  var crew_sl_lascar=document.getElementById('crew_sl_lascar').value;
  $.ajax
  ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/delete_crew_details/')?>"+crew_sl_lascar,
    success: function(data)
    {         
    }
  });
  $('#addrow_lr'+txt).remove();
  var  lascar_cnt=document.getElementById('lascar_cnt').value;
  document.getElementById('lascar_cnt').value=lascar_cnt-1;
}

function remove_dr(txt)
{
  var crew_sl_driver=document.getElementById('crew_sl_driver').value;
  $.ajax
  ({
    type: "POST",
    url:"<?php echo site_url('Kiv_Ctrl/Survey/delete_crew_details/')?>"+crew_sl_driver,
    success: function(data)
    {         
    }
  });
  $('#addrow_dr'+txt).remove();
  var  driver_cnt=document.getElementById('driver_cnt').value;
  document.getElementById('driver_cnt').value=driver_cnt-1;
}

function IsNumeric(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
  {
    return true;
  }
  else 
  {
    window.alert("This field accepts only numbers");
    return false;
  }
}

function alpbabetspace(e) 
{
  var k;
  document.all ? k = e.keyCode : k = e.which;
  return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==32);
}

function validateEmail(email) 
{
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if(!emailReg.test(email)) 
  {
    alert("Invalid Email");
    document.getElementById('user_email').value='';
    return false;
  } 
  else 
  {
    return true;
  }
}

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

function IsAlphanumeric(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ( (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode==47) || (unicode == 45) || (unicode == 8))  
  {
    return true;
  }
  else 
  {
    window.alert("This field accepts Capital letters(A-Z), numbers with hyphen(-) and slash (/) ");
    return false;
  }
}


function alphaNumeric(e) 
{
  var k;
  document.all ? k = e.keyCode : k = e.which;
  return ((k > 64 && k < 91) || (k > 96 && k < 123) || (k > 47 && k < 58) || k == 45 || k==32);
} 

function checklength(id)
{
  var strvalue=document.getElementById(id).value;  
  //alert(strvalue);
  var len=strvalue.length;
  if(len<4)
  {
    alert("Minimum 4 character");
    document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}
</script>
