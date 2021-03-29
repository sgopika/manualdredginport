<?php

$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');
/*_____________________Decoding Start___________________*/
 $vessel_id1         = $this->uri->segment(4);


$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

/*_____________________Decoding End___________________*/
$survey_id=1;
$yes="Yes";
$no="No";
$nil="Nil";

//----------Hull Details--------//

$hull_details 				= 	$this->Survey_model->get_hull_details($vessel_id,$survey_id);
$data['hull_details']		=	$hull_details;

//----------Engine Details--------//

$engine_details 			= 	$this->Survey_model->get_engine_details($vessel_id,$survey_id);
$data['engine_details']	=	$engine_details;

//----------Equipment Details--------//

$equipment_details 		= 	$this->Survey_model->get_equipment_details_view($vessel_id,$survey_id);
$data['equipment_details']	=	$equipment_details;

//----------Get portable fire extinguisher---------------//

$portable_fire_ext	          = 	$this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
$data['portable_fire_ext']	  =	  $portable_fire_ext;
                         
//--------------Documents-----------------//

$list_document_vessel				= 	$this->Survey_model->get_list_document_vessel();
$data['list_document_vessel']		=	$list_document_vessel;



$vessel_details				= 	$this->Survey_model->get_vessel_details_viewpage($vessel_id);
$data['vessel_details']		=	$vessel_details;

if(!empty($vessel_details))
{
	foreach($vessel_details as $res_vessel)
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
	    $operation_area             =     $res_vessel['area_of_operation']; //Area of operation
	    @$cargo_nature              =     $res_vessel['cargo_nature']; //Nature of operation

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

	    $validity_fire_extinguisher = date("d-m-Y", strtotime($validity_fire_extinguisher1));
	    $validity_of_insurance      = date("d-m-Y", strtotime($validity_of_insurance1));
	    $validity_of_certificate    = date("d-m-Y", strtotime($validity_of_certificate1));

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

$process_id=1;
$initial_survey_id=1;
$initial_survey_done=$this->Survey_model->get_survey_done($process_id,$initial_survey_id);
$data['initial_survey_done']  = $initial_survey_done;
if(!empty($initial_survey_done))
{
	$registration_number=$initial_survey_done[0]['registration_number'];
}

//-----------Get customer name and address--------------//

@$id=$vessel_details[0]['user_id'];


//-----------Get customer name and address--------------//
$customer_details=$this->Survey_model->get_customer_details($id);
$data['customer_details']=$customer_details;

if(!empty($customer_details))
{
  foreach($customer_details as $res_customer)
  {
    $user_name      =   $res_customer['user_name'];
    $user_address   =   $res_customer['user_address'];
  }
} 
//-----------Get crew details :  tbl_kiv_crew_details --------------//

$crew_details             =   $this->Survey_model->get_crew_details($vessel_id,$survey_id);
$data['crew_details']     =   $crew_details;

//master
$crew_type_sl=1;
$crew_details_master             =   $this->Survey_model->get_crew_details_master_serang($vessel_id,$survey_id,$crew_type_sl);
$data['crew_details_master']     =   $crew_details_master;
$crew_type_sl2=2;
$crew_details_serang             =   $this->Survey_model->get_crew_details_master_serang($vessel_id,$survey_id,$crew_type_sl2);
$data['crew_details_serang']     =   $crew_details_serang;



//-----------Get Nature of operation name :  kiv_natureofoperation_master--------------//
if(!empty($cargo_nature))
{
  $cargo_nature_name             =   $this->Survey_model->get_cargo_nature_name($cargo_nature);
  $data['cargo_nature_name']     =   $cargo_nature_name;
  @$natureofoperation_name        =   $cargo_nature_name[0]['natureofoperation_name'];

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
     /* else
      {
        $conditionstatus_name=$nil;
      }*/
    


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
//print_r($lifejacket);

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

//----------Get fixed fire extinguisher: tbl_kiv_equipment_details---------------//
$equipment_type_id10=10;
      $fixed_fire_ext            =   $this->Survey_model->get_type_equipment_details_edit($vessel_id,$equipment_type_id10,$survey_id);
      $data['fixed_fire_ext']    =   $fixed_fire_ext;


//-----------Get portable fire exstinguisher : tbl_kiv_fire_extinguisher_details--------------//
$portablefire_extinguisher             =   $this->Survey_model->get_portablefire_extinguisher($vessel_id,$survey_id);
$data['portablefire_extinguisher']     =   $portablefire_extinguisher;
   @$count_portablefire_extinguisher    =    count($portablefire_extinguisher);

  
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

                         
 //----------Get initial survey  date : tbl_kiv_vessel_timeline ---------------//
      $subprocess_id=1;
      $vessel_timeline11            =   $this->Survey_model->get_vessel_timeline_initialsurvey($vessel_id, $survey_id,$subprocess_id);
      $data['vessel_timeline11']    =   $vessel_timeline11;
     
      if(!empty($vessel_timeline11))
      {
          $date_initialsurvey=$vessel_timeline11[0]['actual_date'];
        
           $initialsurvey_donedate = date("d-m-Y", strtotime($date_initialsurvey));

      }
      else
      {
        $initialsurvey_donedate =$nil;
      }

$validity_up_to_date= date('d-m-Y', strtotime($date_initialsurvey . "1 year") );



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


?>
<style type="text/css">
  div,table {
  font-size: 12px;
}
table.tabletbox
  {
  border:solid 1px black;
  border-collapse:collapse;
  padding:0px;
  font-size:11px;
  margin-right: 0px;
  margin-left: 0px;
 
}
.tbline
{
  line-height: 25px;
}

</style>
<div class="ui-innerpage">
  <div align="center"><img src="plugins/img/govtemblem.jpg" width="100" height="60" alt=""> </div>
<div class="row no-gutter text-primary">
<div align="center"  class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong> FORM No.10  </strong>
</div> <!-- end of col12 -->
<div align="center" class="col-12 py-2 px-3 d-flex justify-content-center"> 
[See  Rule 12] 
</div> <!-- end of col12 -->
<div align="center" class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong>Certificate of Survey  </strong>
</div> <!-- end of col12 -->
</div>
<div></div>

<table width="100%" cellspacing="0" cellpadding="0" >
<tr>
	<td>1.</td>
	<td>Name of Vessel</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $vessel_name; ?></td>
</tr>	

<tr>
	<td>2.</td>
	<td>Registration Number</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $registration_number; ?></td>
</tr>

<tr>
	<td>3.</td>
	<td>Owner's name and Address</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $user_name; ?></td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;&nbsp;<?php echo $user_address; ?></td>
</tr>

<tr>
	<td>4.</td>
	<td>Master', Serang's Name and Address</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>


<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Master's Name and address</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(!empty($crew_details_master)){ echo $crew_details_master[0]['name_of_type']; }?>&nbsp;</td>
</tr>

<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Serang's Name and address</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(!empty($crew_details_serang)){ echo $crew_details_serang[0]['name_of_type']; }?>&nbsp;</td>
</tr>

<tr>
	<td>5.</td>
	<td>Year of built</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $vessel_yearofbuilt; ?> </td>
</tr>

<tr>
	<td>6.</td>
	<td>Area of Operation</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $operation_area; ?> </td>
</tr>

<tr>
	<td>7.</td>
	<td>Nature of operation</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(!empty($natureofoperation_name)) { echo $natureofoperation_name; } else { echo $nil; } ?> 
 </td>
</tr>

<tr>
	<td>8.</td>
	<td>Extreme inner dimension of the vessel</td>
	<td>&nbsp;</td>
	<td>&nbsp;&nbsp;Length&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $vessel_length; ?> m </td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;&nbsp;Breadth&nbsp;:&nbsp;&nbsp;<?php echo $vessel_breadth; ?> m </td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;&nbsp;Depth&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $vessel_depth; ?> m </td>
</tr>

<tr>
	<td>9.</td>
	<td>Net registered tonnage</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $vessel_net_tonnage; ?> Ton</td>
</tr>



<tr>
	<td>10.</td>
	<td>Description of engine</td>
	<td>:</td>
	<td>
		<?php
$i=1;
if(!empty($engine_details))
{
  foreach ($engine_details as $key_engine1) 
  {
    $engine_description   =   $key_engine1['engine_description'];
?>
	&nbsp;&nbsp;<?php echo $engine_description; ?> <?php } }   ?></td>
</tr>

<tr>
	<td>11.</td>
	<td>Engine Number and Brake Horse Power</td>
	<td>:</td>
	<td><?php
$i=1;
if(!empty($engine_details))
{
  
  foreach ($engine_details as $key_engine2) 
  {
    
    $engine_number        =   $key_engine2['engine_number'];
    $horsepowerofEngine   =   $key_engine2['horsepowerofEngine'];
?>
	&nbsp;&nbsp;<?php echo $engine_number; ?>,<?php echo $horsepowerofEngine;?><br> <?php } }   ?></td>
</tr>

<tr>
	<td>12.</td>
	<td>Nature of fuel used</td>
	<td>:</td>
	<td><?php
$i=1;
if(!empty($engine_details))
{
  
  foreach ($engine_details as $key_engine3) 
  {
    
    
    $engine_description   =   $key_engine3['engine_description'];
   @$fuel_used_id         =   $key_engine3['fuel_used_id'];
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
    

?>&nbsp;&nbsp;<?php echo $fuel_name; ?><?php } }   ?></td>
</tr>




<tr>
	<td>13.</td>
	<td>Details of crew required for the vessel</td>
	<td>:</td>
	<td>&nbsp;&nbsp;
	<table>
	<tr>
		<td>Type</td><td>Name</td><td>Address</td>
	</tr>
	<?php if(!empty($crew_details)) {
	$i=1;
	foreach($crew_details as $res) { ?>
	<tr>
		<td><?php echo $res['crew_type_name'];?></td><td><?php echo $res['name_of_type'];?></td><td></td>
	</tr>

	<?php  $i++; } } ?>
	</table>




</td>
</tr>

<tr>
	<td valign="top">14.</td>
	<td>Is the hull of the vessel in good condition <br>and fit for service</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $conditionstatus_name; ?></td>
</tr>

<tr>
	<td valign="top">15.</td>
	<td valign="top">Material used for hull</td>
	<td valign="top">:</td>
	<td valign="top">&nbsp;&nbsp;<?php echo $hullmaterial_name; ?></td>
</tr>

<tr>
	<td valign="top">16.</td>
	<td>Has the vessel been tested for <br>stability and found safe for <br>passenger service</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if($stability_test_status_id!=0) { echo $yes; } else { echo $no; } ?></td>
</tr>


<tr>
	<td>17.</td>
	<td>Details of life saving equipments</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>

<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Whether there is life jacket</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(!empty($lifejacket)) { echo $yes; } else { echo $no; } ?></td>
</tr>

<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adult</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(!empty($number_adult)) { echo $number_adult; } else { echo $nil; } ?></td>
</tr>

<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Children</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(!empty($number_children)) { echo $number_children; } else { echo $nil; } ?></td>
</tr>

<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buoyant apparatus</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if($number_of_buoyant_apparatus!=0) { echo $yes; } else  { echo $no; } ?> </td>
</tr>


<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of life bouys</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if($number_of_lifebouy!=0) { echo $number_of_lifebouy; } else  { echo $nil; } ?> 
 </td>
</tr>


<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of life boat</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(@$life_boat_number!=0) { echo @$life_boat_number; } else  { echo $nil; } ?>
 </td>
</tr>

<!-- <tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total capacity of life raft</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(@$life_boat_capacity) { echo @$life_boat_capacity; } else  { echo $nil; } ?> 
</td>
</tr> -->
 <tr>
  <td></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;First aid box</td>
  <td>:</td>
  <td>&nbsp;&nbsp;<?php if($first_aid_box!=0) { echo $yes;} else {echo $no;}?> 
</td>
</tr> 



<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of life raft</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(@$life_raft_number) { echo @$life_raft_number; } else  { echo $nil; } ?></td>
</tr>

<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total capacity of life raft</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(@$life_raft_capacity) { echo $life_raft_capacity; } else  { echo $nil; } ?></td>
</tr>

<tr>
	<td>18.</td>
	<td>Details of fire fighting equipments</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>


<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of fire extinguishers</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if($count_portablefire_extinguisher!=0 ) { echo $count_portablefire_extinguisher; } else{ echo $nil; } ?></td>
</tr>
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of fire pumps</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if($count_firepumps!=0 ) { echo $count_firepumps; } else{ echo $no; } ?></td>
</tr>
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of fire buckets</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(@$fire_bucket_number!=0 ) { echo $fire_bucket_number; } else{ echo $no; } ?></td>
</tr>
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fire pump type</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $firepumptype_name; ?></td>
</tr>
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of fire hose with dual nozzle</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if(@$number_of_hose!=0 ) { echo $number_of_hose; } else{ echo $no; } ?></td>
</tr>



<tr>
	<td>19.</td>
	<td>Details of pollution control equipments</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sewage treatment and disposal</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if ($lower_deck_passenger!=0) { echo $lower_deck_passenger; } else {echo $nil; } ?></td>
</tr>
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Solid waste processing and disposal</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if ($solid_waste==1) { echo $yes; } else {echo $no; } ?></td>
</tr>


<tr>
  <td></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pollution control cerfificate number</td>
  <td>:</td>
  <td>&nbsp;&nbsp;<?php ?></td>
</tr>


<tr>
	<td valign="top">20.</td>
	<td>Are all the equipment and facility prescribed<br> under the rules provided on board </td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if($condition_of_equipment!=0) { echo $yes;} else {echo $no;}?></td>
</tr>

<tr>
	<td valign="top">21.</td>
	<td>Nature of repairs, renewals neded at the <br>time of inspection</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if($repair_details_nature!=0) { echo $repair_details_nature;} else {echo $nil;}?></td>
</tr>
 

<tr>
	<td valign="top">22.</td>
	<td>Number of passengers which the <br>vessel is licensed to carry</td>
	<td></td>
	<td></td>
</tr>

 
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lower Deck</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if ($lower_deck_passenger!=0) { echo $lower_deck_passenger; } else {echo $nil; } ?></td>
</tr>
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upper Deck</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if ($upper_deck_passenger!=0) { echo $upper_deck_passenger; } else {echo $nil; } ?></td>
</tr>
<tr>
	<td></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;For Day Cruise</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php if ($four_cruise_passenger!=0) { echo $four_cruise_passenger; } else {echo $nil; } ?></td>
</tr>

 

<tr>
	<td valign="top">23.</td>
	<td>Period for which the certificate shall hold</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $validity_up_to_date; ?></td>
</tr>

<tr>
  <td valign="top">&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>

<tr>
  <td valign="top">Date&nbsp;:</td>
  <td>&nbsp;<?php echo $initialsurvey_donedate; ?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td valign="top">Place:</td>
  <td>&nbsp;<?php echo $portofregistry_name?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td valign="top" colspan="4" align="right">Name and signature of the authority</td>
  
</tr>

</table>
</div>