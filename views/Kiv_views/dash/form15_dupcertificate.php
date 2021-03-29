
<?php 
/*$sess_usr_id  =   $this->session->userdata('user_sl');
$user_type_id  =   $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');

$yes="Yes";
$no="No";
$nil="Nil";

$vessel_id    = $this->uri->segment(4);

$ra_details= $this->Bookofregistration_model->get_user_id_cs($user_type_id);
$data['ra_details']  =   $ra_details;
if(!empty($ra_details))
{
  $ra_name=$ra_details[0]['user_master_fullname'];
}
if(!empty($vessel_duplicate_details)){
  foreach ($vessel_duplicate_details as $res_dup) {
    $duplicate_cert_type        = $res_dup['duplicate_cert_type'];
  }
}
 //-----------Get basic vessel details--------------//

if(!empty($vessel_details_viewpage))
{
  foreach($vessel_details_viewpage as $res_vessel)
  {
    $vessel_name                =     $res_vessel['vessel_name'];
    $vessel_survey_number       =     $res_vessel['vessel_survey_number'];
    @$official_number           =     $res_vessel['official_number'];
    $reference_number           =     $res_vessel['reference_number'];
    @$vessel_registry_port_id   =     $res_vessel['vessel_registry_port_id'];     
    @$plying_limit              =     $res_vessel['plying_limit'];
    @$vessel_gross_tonnage      =     $res_vessel['grt'];
    @$vessel_net_tonnage        =     $res_vessel['nrt'];
    $vessel_registration_number =     $res_vessel['vessel_registration_number'];
    $vessel_length              =     $res_vessel['vessel_length'];
    $vessel_breadth             =     $res_vessel['vessel_breadth'];
    $vessel_depth               =     $res_vessel['vessel_depth']; 
    $vessel_length_overall      =     $res_vessel['vessel_length_overall'];
    $vessel_yearofbuilt         =     $res_vessel['vessel_expected_completion'];

    $stern                      =     $res_vessel['stern'];
    $stern_id                   =     $res_vessel['stern_id'];
    $vessel_no_of_deck          =     $res_vessel['vessel_no_of_deck'];
    $no_of_shaft                =     $res_vessel['no_of_shaft'];
    $yardName                   =     $res_vessel['yardName'];
    $area_of_operation          =     $res_vessel['area_of_operation'];
    $build_place                =     $res_vessel['build_place'];
    $passenger_capacity         =     $res_vessel['passenger_capacity'];
    $vessel_type_id             =     $res_vessel['vessel_type_id'];
    @$boats_aggregate_capacity  =   $res_vessel['boats_aggregate_capacity'];

    $lower_deck_passenger       =     $res_vessel['lower_deck_passenger'];
    $upper_deck_passenger       =     $res_vessel['upper_deck_passenger'];
    $four_cruise_passenger      =     $res_vessel['four_cruise_passenger'];
    $first_aid_box              =     $res_vessel['first_aid_box'];
    $condition_of_equipment     =     $res_vessel['condition_of_equipment'];
    $repair_details_nature      =     $res_vessel['repair_details_nature'];
    

 if(!empty($vessel_type_id))
 {
  $vessel_type          =   $this->Survey_model->get_vessel_type_id($vessel_type_id);
       $data['vessel_type']  =   $vessel_type; 
       $vesseltype_name=$vessel_type[0]['vesseltype_name'];
       $vesseltype_code=$vessel_type[0]['vesseltype_code'];
 }



    if(!empty($stern_id))
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
    }

   

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
    $user_mobile   =   $res_customer['user_mobile_number'];

     $state_id=$res_customer['user_state_id'];
     if($state_id!=0)
     {
      $state=  $this->Survey_model->get_state($state_id);
    $data['state']  =   $state;
    $state_name     =   $state[0]['state_name'];
     }
     else
     {
      $state_name="";
     }
    
  }
} 

//-----------engine details--------------//
if(!empty($engine_details))
{
  $no_of_engineset=count($engine_details);
   /*foreach($engine_details as $res_engine)
  {

  }*/
}

//-----------hull details--------------//
if(!empty($hull_details))
{
   foreach($hull_details as $res_hull)
  {
    $bulk_heads=$res_hull['bulk_heads'];
    $hull_year_of_built=$res_hull['hull_year_of_built'];
    @$hullmaterial_id=$res_hull['hullmaterial_id'];
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
$date=date('d-m-Y');
$year=date('Y');
$month= date('M');
$day= date('d');
$sup=date('S');

$tb_main=    $this->Survey_model->get_vessel_main($vessel_id);
$data['tb_main']  =   $tb_main;
//print_r($tb_main);
//exit;
if(!empty($tb_main))
{
  $vesselmain_reg_date1=$tb_main[0]['vesselmain_reg_date'];
  if($vesselmain_reg_date1) {
     $vesselmain_reg_date=date("d-m-Y", strtotime($vesselmain_reg_date1));
  $validity_up_to_date= date('d-m-Y', strtotime($vesselmain_reg_date1 . "5 year") );
  }
  else
{
  $vesselmain_reg_date="";
  $validity_up_to_date="";
}
 
}
else
{
  $vesselmain_reg_date="";
  $validity_up_to_date="";
}


$survey_id=1;

//__________________Passenger details________________________________//

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
else
{
  $plying_night_upperdeck   = 0;
  $plying_daynight_upperdeck  = 0;
  $plying_halfday_upperdeck   = 0;
  $plying_night_inbwdeck    = 0;
  $plying_daynight_inbwdeck   = 0;
  $plying_halfday_inbwdeck  = 0;
  $plying_night_maindeck    = 0;
  $plying_daynight_maindeck   = 0;
  $plying_halfday_maindeck  = 0;
  $plying_night_secondcabin   = 0;
  $plying_daynight_secondcabin= 0;
  $plying_halfday_secondcabin = 0;
  $plying_night_saloon    = 0;
  $plying_daynight_saloon   = 0;
  $plying_halfday_saloon    = 0;
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

//____________Boat details_____________________//

$boat_details              =   $this->Bookofregistration_model->get_boat_details($vessel_id);
$data['boat_details']     =   $boat_details;
//print_r($boat_details);
if(!empty($boat_details))
{
   $boat_count=count($boat_details);
}
else
{
  $boat_count=0;
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

//-----------Get firepumps : tbl_kiv_firepumps_details  --------------//

$firepumps             =    $this->Survey_model->get_firepumps($vessel_id,$survey_id);
$data['firepumps']     =    $firepumps;
 
if(!empty($firepumps)) 
{
  @$count_firepumps       =    count($firepumps);
 foreach($firepumps as $key_firepump)
 {
    $firepumptype_id = $key_firepump['firepumptype_id'];
    $capacity_firepump1[] = $key_firepump['capacity'];


    $firepumptype_details         =   $this->Survey_model->get_firepumptype_name($firepumptype_id);
    $data['firepumptype_details'] =   $firepumptype_details;
    if(!empty($firepumptype_details))
    {
       $firepumptype_name1[] =$firepumptype_details[0]['firepumptype_name'];
 }
    }

    
   
   $firepumptype_name    = implode(", ",$firepumptype_name1);
 $capacity_firepump    = implode(", ",$capacity_firepump1);
 
}
else
{
  @$firepumptype_name  =$nil;
  @$count_firepumps=0;
  @$capacity_firepump=$nil;
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

//----------Get nozzles: tbl_kiv_equipment_details---------------//
$equipment_type_id8=8;

      $nozzle   =   $this->Survey_model->get_type_equipment_details_edit($vessel_id,$equipment_type_id8,$survey_id);
      $data['nozzle'] =   $nozzle;
      if(!empty($nozzle))
      {
        $nozzle_equipment_id=   $nozzle[0]['equipment_id'];
         $nozzle_equipment   =   $this->Survey_model->get_nozzletype_view($nozzle_equipment_id);
          $data['nozzle_equipment'] =   $nozzle_equipment;
          if(!empty($nozzle_equipment))
          {
            $nozzle_equipment_name=$nozzle_equipment[0]['equipment_name'];
          }

      }
  //-----------------Get Namechange Log details----------------//    
  $namechg_dt           =   $this->Vessel_change_model->getnamechange_vessel($vessel_id);
  $data['namechg_dt']   =   $namechg_dt;
  //print_r( $namechg_dt);
  //-----------------Get Ownerchange Log details----------------//    
  $ownerchg_dt          =   $this->Vessel_change_model->getownerchange_vessel($vessel_id);
  $data['ownerchg_dt']  =   $ownerchg_dt;
  //print_r( $ownerchg_dt);
  //-----------------Get Ownerchange Log details----------------//    
  $transfrvsl_dt        =   $this->Vessel_change_model->gettransfer_vessel($vessel_id);
  $data['transfrvsl_dt']=   $transfrvsl_dt;
  //print_r( $transfrvsl_dt);
 //-----------------Get Ownerchange Log details----------------//    
  $dupcert_dt           =   $this->Vessel_change_model->get_dupcert_details($vessel_id);
  $data['dupcert_dt']   =   $dupcert_dt;
  //print_r( $transfrvsl_dt);

?>

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container letterform mb-4">
<div class="row no-gutters">
<div align="center"><img src="assets/img/govtemblem.jpg" width="100" height="60" alt=""> </div>
<div align="center"> <strong>Government of Kerala</strong></div>
<div align="center"> <strong>FORM NO: 15</strong></div>
<div align="center"> <strong><i>(See Rule 17)</i></strong></div>
<div align="center"> <strong>BOOK OF REGISTRATION</strong></div><?php if(isset($duplicate_cert_type)){ if($duplicate_cert_type==2){?><div align="right"><font color="red"><strong>DUPLICATE</strong></font></div><?php }} ?>
</div>
<br>

<form name="form14" id="form14" method="POST" action="">

<!-- <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tabletbox"> -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0">

  <tr>
    <td width="40%">Name of the Owner</td>
    <td width="55%"><?php echo $user_name;  ?></td>
  </tr> 

 <tr>
    <td width="40%">Address of owner</td>
    <td width="55%"><?php echo $user_address; ?></td>
  </tr> 
  <tr>
    <td width="40%">Name of Inland Vessel</td>
    <td width="55%"><?php  echo $vessel_name; ?></td>
  </tr>

  <tr>
    <td width="40%">Registration Number</td>
    <td width="55%"><?php echo $vessel_registration_number;  ?></td>
  </tr>

<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Description of inland vessel</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>

 <tr>
    <td width="40%"> Gross Registered Tonnage </td>
    <td width="55%"><?php if($vessel_gross_tonnage!=0) {  echo $vessel_gross_tonnage; ?>&nbsp;Ton <?php } else { echo "---";} ?></td></tr>

    <tr>
    <td width="40%"> Net Registered Tonnage </td>
    <td width="55%"><?php if($vessel_net_tonnage!=0) {  echo $vessel_net_tonnage; ?>&nbsp;Ton  <?php } else
    { echo "---"; } ?></td></tr>

<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Particulars of vessels</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr>
    <td width="40%">Length overall</td>
    <td width="55%"><?php  echo $vessel_length_overall; ?>&nbsp;m</td></tr>
<tr>
    <td width="40%"> Length </td>
    <td width="55%"><?php  echo $vessel_length; ?>&nbsp;m</td></tr>
<tr>
    <td width="40%"> Breadth </td>
    <td width="55%"><?php  echo $vessel_breadth; ?>&nbsp;m</td></tr>
<tr>
    <td width="40%"> Depth </td>
    <td width="55%"><?php  echo $vessel_depth; ?>&nbsp;m</td></tr>
<tr>
    <td width="40%"> Year of make </td>
    <td width="55%"><?php  echo $hull_year_of_built; ?></td></tr>
<tr>
    <td width="40%"> Make </td>
    <td width="55%"><?php echo "---"; ?></td></tr>
<tr>
    <td width="40%"> Hull material </td>
    <td width="55%"><?php  echo $hullmaterial_name; ?></td></tr>

<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Engine</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>

 <tr>
    <td width="40%">No. of sets of Engines</td>
    <td width="55%"><?php echo $no_of_engineset;  ?></td></tr>
 <!-- <tr><td colspan="2" align="center">&nbsp;</td></tr>   --> 
<?php 
if(!empty($engine_details))
{
  $i=1;
  foreach($engine_details as $res_engine)
  {
    $engine_description   = $res_engine['engine_description'];
    $engine_number        = $res_engine['engine_number'];
    $engine_placement_id  = $res_engine['engine_placement_id'];
    $engine_speed         = $res_engine['engine_speed'];
    @$fuel_used_id        = $res_engine['fuel_used_id'];
    $bhp                  = $res_engine['bhp'];
    $rpm                  = $res_engine['rpm'];
    $manufacturer_name    = $res_engine['manufacturer_name'];
    $manufacturer_brand   = $res_engine['manufacturer_brand'];
    $make_year            = $res_engine['make_year'];
    $cylinder_number      = $res_engine['cylinder_number'];
    $propulsion_material_id      = $res_engine['propulsion_material_id'];

    $propulsion_means_id        =     $res_vessel['propulsion_means_id'];

    if(!(empty($propulsion_means_id)))
    {
      $meansofpropulsionShaft          =   $this->Survey_model->get_meansofpropulsionShaft_name($propulsion_means_id);
       $data['meansofpropulsionShaft']  =   $meansofpropulsionShaft; 
       $meansofpropulsionShaft_name =   $meansofpropulsionShaft[0]['meansofpropulsion_name']; 
    }
    else
    {
      $meansofpropulsionShaft_name ='nil';
    }

    
      
    if($fuel_used_id!=0) 
    {
      $fuel_details         =   $this->Survey_model->get_fuel($fuel_used_id);
      $data['fuel_details'] =   $fuel_details;
      if(!empty($fuel_details)){ @$fuel_name =   $fuel_details[0]['fuel_name']; }
    }
    else { @$fuel_name      = $nil;  }
    if(!empty($engine_placement_id))
    {
      $inboard_outboard=$this->Survey_model->get_inboard_outboard_name($engine_placement_id);
      $data['inboard_outboard']=$inboard_outboard;
      if(!empty($inboard_outboard))
      {
        $inboard_outboard_name=$inboard_outboard[0]['inboard_outboard_name'];
      }
      else
      {
        $inboard_outboard_name="";
      }
    }
?>
<tr><td width="40%" colspan="2" align="left" bgcolor="#c6cbd3">Engine <?php echo $i; ?></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr>
    <td width="40%"> Description of engine </td>
    <td width="55%"><?php echo $inboard_outboard_name; ?></td></tr>
<tr>
    <td width="40%"> Name and address of maker</td>
    <td width="55%"><?php echo $manufacturer_name;  ?>,<?php echo $manufacturer_brand;  ?></td></tr>
<tr>
    <td width="40%"> Year of make</td>
    <td width="55%"><?php echo $make_year ;?></td></tr>
<tr>
    <td width="40%"> Nozzle<!-- Surface, jet of any other  --></td>
    <td width="55%"><?php echo $nozzle_equipment_name;  ?></td></tr>
<tr>
    <td width="40%"> No. of cylinder per set </td>
    <td width="55%"><?php echo $cylinder_number;  ?></td></tr>
<tr>
    <td width="40%"> Engine number</td>
    <td width="55%"><?php echo $engine_number; ?></td></tr>
<tr>
    <td width="40%"> R.P.M</td>
    <td width="55%"><?php echo $rpm;  ?></td></tr>
<tr>
    <td width="40%">Total brake horse power </td>
    <td width="55%"><?php echo $bhp;  ?></td></tr>   
<tr>
    <td width="40%">Nature of fuel used</td>
    <td width="55%"><?php echo $fuel_name;  ?></td></tr>
<tr>
    <td width="40%">Estimated speed of inland vessel</td>
    <td width="55%"><?php echo $engine_speed;  ?></td></tr> 

<tr>
    <td width="40%"> Means of propulsion shaft </td>
    <td width="55%"><?php  echo $meansofpropulsionShaft_name;  ?></td></tr>

<tr><td colspan="2" align="center">&nbsp;</td></tr>

<?php $i++; 
  }
}
?>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Propulsion</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>

 

<tr> 
  <td width="40%"> Propeller </td>
  <td width="55%"><?php  echo "---"; ?></td></tr>


<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Equipments</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>

<tr>
  <td width="40%"> Boats </td>
  <td width="55%"><?php  echo $boat_count;  ?></td></tr>

  <tr>
  <td width="40%"> Capacity </td>
  <td width="55%"><?php  echo "---";  ?></td></tr>

  <tr>
  <td width="40%"> Description of life buoys </td>
  <td width="55%"><?php  echo "---";  ?></td></tr>

  <tr>
  <td width="40%"> Number of life buoys </td>
  <td width="55%"><?php  echo $number_of_lifebouy;  ?></td></tr>

  <tr>
  <td width="40%"> Description of buoyancy apparatus </td>
  <td width="55%"><?php  echo "---";  ?></td></tr>

  <tr>
  <td width="40%"> Number of buoyancy apparatus </td>
  <td width="55%"><?php  echo $number_of_buoyant_apparatus;  ?></td></tr>

  <tr>
  <td width="40%"> Bow anchor number </td>
  <td width="55%"><?php  echo "---";  ?></td></tr>

<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Fire Apparatus</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>

<tr>
  <td width="40%"> Boats of aggregate capacity </td>
  <td width="55%"><?php  echo $boats_aggregate_capacity;  ?></td></tr>

<tr>
  <td width="40%"> Fire pumps </td>
  <td width="55%"><?php  echo $count_firepumps;  ?></td></tr>  
<tr>
  <td width="40%"> Fire Buckets </td>
  <td width="55%"><?php  echo $fire_bucket_number;  ?></td></tr>

<tr>
  <td width="40%"> Capacity of fire pumps </td>
  <td width="55%"><?php  echo $capacity_firepump;  ?></td></tr>

<tr>
  <td width="40%"> Fire sand boxes </td>
  <td width="55%"><?php  echo $fire_sandbox_number;  ?></td></tr>

 <tr>
  <td width="40%"> Number of portable fire extinguisher </td>
  <td width="55%"><?php  echo $count_portablefire_extinguisher;  ?></td></tr> 

<tr>
  <td width="40%"> Type of portable fire extinguisher </td>
  <td width="55%"><?php  echo $portable_fire_extinguisher_typename;  ?></td></tr> 

<tr>
  <td width="40%"> Number of chemical extinguisher </td>
  <td width="55%"><?php  echo "---";  ?></td></tr> 

<tr>
  <td width="40%"> Capacity of chemical extinguisher </td>
  <td width="55%"><?php  echo "---";  ?></td></tr> 

<tr>
  <td width="40%"> Passenger capacity in lower deck</td>
  <td width="55%"><?php if ($lower_deck_passenger!=0) { echo $lower_deck_passenger; } else {echo $nil; } ?></td></tr> 

<tr>
  <td width="40%"> Passenger capacity in upper deck</td>
  <td width="55%"><?php if ($upper_deck_passenger!=0) { echo $upper_deck_passenger; } else {echo $nil; } ?></td></tr> 

<tr>
  <td width="40%"> When plying as at A life buoys; and Buoyancy Apparatus</td>
  <td width="55%" valign="top"><?php  echo $lifebuoys_plyingA;  ?></td></tr> 

<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Passengers</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>  

<tr><td colspan="2">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabletbox">
    <tr>
       <td>Number of passengers on</td>
       <td>When plying by night (smooth &amp; partially smooth water)</td>
       <td>When plying by day or in canals by night and day (smooth &amp; partially smooth water)</td>
       <td>When plying by day on voyages which do not last more than 6 hours (smooth water only)</td>
    </tr>

    <tr>
      <td>On between deck, if any</td>
      <td><?php echo $plying_night_inbwdeck; ?></td>
      <td><?php echo $plying_daynight_inbwdeck; ?></td>
      <td><?php echo $plying_halfday_inbwdeck; ?></td>
    </tr>

     <tr>
      <td>On main deck</td>
      <td><?php echo $plying_night_maindeck;  ?></td>
      <td><?php echo $plying_daynight_maindeck;  ?></td>
      <td><?php echo $plying_halfday_maindeck;  ?></td>
    </tr>

     <tr>
      <td>On the upper deck/bridge</td>
      <td><?php echo $plying_night_upperdeck;  ?></td>
      <td><?php echo $plying_daynight_upperdeck;  ?></td>
      <td><?php echo $plying_halfday_upperdeck;  ?></td>
    </tr>

     <tr>
      <td><strong>Total (deck) </strong></td>
      <td><b><?php echo $t1= ($plying_night_inbwdeck+$plying_night_maindeck+$plying_night_upperdeck);?></b></td>
      <td><b><?php echo $t2= ($plying_daynight_inbwdeck+$plying_daynight_maindeck+$plying_daynight_upperdeck);?></b></td>
      <td><b><?php echo $t3=($plying_halfday_inbwdeck+$plying_halfday_maindeck+$plying_halfday_upperdeck);?></b></td>
    </tr>

     <tr>
      <td>Second cabin passengers</td>
      <td><?php echo $plying_night_secondcabin;  ?></td>
      <td><?php echo $plying_daynight_secondcabin;  ?></td>
      <td><?php echo $plying_halfday_secondcabin;  ?></td>
    </tr>

     <tr>
      <td>Saloon passengers</td>
      <td><?php echo $plying_night_saloon;  ?></td>
      <td><?php echo $plying_daynight_saloon;  ?></td>
      <td><?php echo $plying_halfday_saloon;  ?></td>
    </tr> 

     <tr>
      <td><strong>Total</strong></td>
      <td><b><?php echo ($t1+$plying_night_secondcabin+$plying_night_saloon); ?></b></td>
      <td><b><?php echo ($t2+$plying_daynight_secondcabin+$plying_daynight_saloon); ?></b></td>
      <td><b><?php echo ($t2+$plying_halfday_secondcabin+$plying_halfday_saloon); ?></b></td>
    </tr>
  </table>
</td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>  
<tr><td colspan="2">Two children above 5 years and under 12 years of age will be reckoned as one passenger.</td></tr>  

<tr><td colspan="2">Encumbrance:- If space measured for passenger is encumbered by cattle, cargo or other article, then one passenger is to be deducted from the foregoing table for each.</td></tr>  

<tr><td colspan="2" align="center">&nbsp;</td></tr> 
<tr><td colspan="2">65 m^2 of passenger area encumber when plying as A above</td></tr> 
<tr><td colspan="2" align="center">&nbsp;</td></tr> 
<tr><td colspan="2">50 m^2 of passenger area encumber when plying as B above</td></tr> 
<tr><td colspan="2" align="center">&nbsp;</td></tr> 
<tr><td colspan="2">40 m^2 of passenger area encumber when plying as C above</td></tr> 
<?php 
if(!empty($namechg_dt))
{ ?>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Name Change of vessel</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabletbox">
  <tr>
    <td align="center"><strong>Old Name of Vessel</strong></td>
    <td align="center"><strong>Reg Date</strong></td>
    <td align="center"><strong>New Name of Vessel</strong></td>
    <td align="center"><strong>Approved Date</strong></td>
  </tr>
<?php 
  //if(!empty($namechg_dt))
  //{  
    foreach($namechg_dt as $nmdet ){
      $old_vessel_name  =   $nmdet['old_vessel_name'];
      $new_vessel_name  =   $nmdet['new_vessel_name'];
      $registered_date  =   date("d/m/Y", strtotime($nmdet['registered_date']));
      $approved_date    =   date("d/m/Y", strtotime($nmdet['approved_date']));
?>
  <tr>
    <td align="center"><?php echo $old_vessel_name;?></td>
    <td align="center"><?php echo $registered_date;?></td>
    <td align="center"><?php echo $new_vessel_name;?></td>
    <td align="center"><?php echo $approved_date;?></td>
  </tr>
<?php 
    } 
    
  //} 
?>
 </table>
</td>
</tr>
<?php } ?>
<?php 
if(!empty($ownerchg_dt))
{ 
?>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Ownership Change of vessel</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabletbox">
  <tr>
    <td align="center"><strong>Old Owner of Vessel</strong></td>
    <td align="center"><strong>New Owner of Vessel</strong></td>
    <td align="center"><strong>Reg Date</strong></td>
    <td align="center"><strong>Approved Date</strong></td>
  </tr>
<?php 
  //if(!empty($ownerchg_dt))
  //{  
    foreach($ownerchg_dt as $owndet ){
      $transfer_seller_id  =   $owndet['transfer_seller_id'];
      $trans_seller        =   $this->Vessel_change_model->get_owner($transfer_seller_id);
      foreach($trans_seller as $sell_res){
        $seller            =   $sell_res['user_name'];
      }
      $transfer_buyer_id   =   $owndet['transfer_buyer_id'];
      $trans_buyer         =   $this->Vessel_change_model->get_owner($transfer_buyer_id);
      foreach($trans_buyer as $buy_res){
        $buyer             =   $buy_res['user_name'];
      }
      $registered_date     =   date("d/m/Y", strtotime($owndet['registered_date']));
      $approved_date       =   date("d/m/Y", strtotime($owndet['approved_date']));
?>
  <tr>
    <td align="center"><?php echo $seller;?></td>
    <td align="center"><?php echo $buyer;?></td>
    <td align="center"><?php echo $registered_date;?></td>
    <td align="center"><?php echo $approved_date;?></td>
  </tr>
<?php 
    } 
    
  //} 
?>
 </table>
</td>
</tr>
<?php } ?>
<?php 
if(!empty($transfrvsl_dt))
{
?>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Transfer of vessel</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabletbox">
  <tr>
    <td align="center"><strong>Transfer Type</strong></td>
    <td align="center"><strong>State</strong></td>
    <td align="center"><strong>Port of Registry From</strong></td>
    <td align="center"><strong>Port of Registry To</strong></td>
    <td align="center"><strong>Seller</strong></td>
    <td align="center"><strong>Buyer</strong></td>
    <td align="center"><strong>Reg Date</strong></td>
    <td align="center"><strong>Approve Date</strong></td>
  </tr>
<?php 
  //if(!empty($transfrvsl_dt))
  //{  
    foreach($transfrvsl_dt as $trandet ){
      $transfer_type                 =   $trandet['transfer_based_changetype'];
      if($transfer_type==0){
        $transfer_typ                =   "Transfer Outside Kerala";
      } elseif ($transfer_type==1) {
        $transfer_typ                =   "Transfer Within Kerala (Only Port Changes)";
      } elseif ($transfer_type==3) {
        $transfer_typ                =   "Transfer Within Kerala (Both Port and Ownership Changes)";
      }
      $transfer_seller_id            =   $trandet['transfer_seller_id'];
      if($transfer_seller_id!=0){
        $trans_seller                =   $this->Vessel_change_model->get_owner($transfer_seller_id);
        foreach($trans_seller as $sell_res){
          $seller                    =   $sell_res['user_name'];
        }
      } else {
        $seller                      =   '';
      }
      $transfer_buyer_id             =   $trandet['transfer_buyer_id'];
      if($transfer_buyer_id!=0){
        $trans_buyer                 =   $this->Vessel_change_model->get_owner($transfer_buyer_id);
        foreach($trans_buyer as $buy_res){
          $buyer                     =   $buy_res['user_name'];
        }
      } else {
        $buyer                      =   '';
      }
      $transfer_portofregistry_from  =   $trandet['transfer_portofregistry_from'];
      if($transfer_portofregistry_from!=0){
        $portofregistryfm            =   $this->Survey_model->get_registry_port_id($transfer_portofregistry_from);
        foreach($portofregistryfm as $portofregistryfm_res){
          $portofregistryfm_name     =   $portofregistryfm_res['vchr_portoffice_name'];
        }
      } else {
        $portofregistryfm_name       =   '';
      }
      $transfer_portofregistry_to    =   $trandet['transfer_portofregistry_to'];
      if($transfer_portofregistry_to!=0){
        $portofregistryto            =   $this->Survey_model->get_registry_port_id($transfer_portofregistry_to);
        foreach($portofregistryto as $portofregistryto_res){
          $portofregistryto_name     =   $portofregistryto_res['vchr_portoffice_name'];
        }
      } else {
        $portofregistryto_name       =   '';
      }
      $transfer_state                =   $trandet['transfer_state_id'];
      if($transfer_state!=0){
        $transferstate               =   $this->Vessel_change_model->get_state($transfer_state);
        foreach($transferstate as $state_res){
          $state_name                =   $state_res['state_name'];
        }
      } else {
        $state_name                  =   '';
      }
      $registered_date               =   date("d/m/Y", strtotime($trandet['registered_date']));
      $approved_date                 =   date("d/m/Y", strtotime($trandet['approved_date']));
?>
  <tr>
    <td align="center"><?php echo $transfer_typ;?></td>
    <td align="center"><?php echo $state_name;?></td>
    <td align="center"><?php echo $portofregistryfm_name;?></td>
    <td align="center"><?php echo $portofregistryto_name;?></td>
    <td align="center"><?php if($transfer_type!=1){ echo $seller; }?></td>
    <td align="center"><?php echo $buyer;?></td>
    <td align="center"><?php echo $registered_date;?></td>
    <td align="center"><?php echo $approved_date;?></td>
  </tr>
<?php 
    } 
    
  //} 
?>
 </table>
</td>
</tr>
<?php } ?>
<?php 
if(!empty($dupcert_dt))
{ ?>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Duplicate Certificate</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabletbox">
  <tr>
    <td align="center"><strong>Duplicate Certificate Type</strong></td>
    <td align="center"><strong>Issue Date</strong></td>
  </tr>
<?php 
  //if(!empty($namechg_dt))
  //{  
    foreach($dupcert_dt as $dupdet ){
      $duplicate_cert_type        =   $dupdet['duplicate_cert_type'];
      $duplicate_cert_issue_date  =   date("d/m/Y", strtotime($dupdet['duplicate_cert_issue_date']));
      
?>
  <tr>
    <td align="center"><?php if($duplicate_cert_type==1){echo "Certificate of Registration";} else {echo "Book of Registration";}?></td>
    <td align="center"><?php echo $duplicate_cert_issue_date;?></td>
  </tr>
<?php 
    } 
    
  //} 
?>
 </table>
</td>
</tr>

<?php } ?>
<tr><td colspan="2" align="center">&nbsp;</td></tr>
<tr><td colspan="2" align="center" bgcolor="#c5d2cc"><strong>Alteration</strong></td></tr>
<tr><td colspan="2" align="center">&nbsp;</td></tr>


</table>



</form>
</div> 
</div> 
</div> 
</div>   
<style type="text/css">
  div,table {
  font-size: 12px;
}
table.tabletbox
  {
  border:solid 1px black;
  border-collapse:collapse;
  padding:0px;
  font-size:12px;
  margin-right: 0px;
  margin-left: 0px;
 
}
.tbline
{
  line-height: 25px;
}

</style>