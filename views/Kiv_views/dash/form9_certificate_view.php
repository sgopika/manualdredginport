<?php
$vessel_id1=$this->uri->segment(4); 

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 
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

	    @$boats_aggregate_capacity      =   $res_vessel['boats_aggregate_capacity'];

	     @$id=$res_vessel['user_id'];
		@$category=$res_vessel['category'];

		

    	if(!empty($vessel_registry_port_id))
    	{
       		$portofregistry          =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
       		$data['portofregistry']  =   $portofregistry;
       		$portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
    	}
  	}
}

$customer_details=$this->Survey_model->get_customer_details($id);
$data['customer_details']=$customer_details;

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

//master
$crew_type_sl=1;
$crew_details_master             =   $this->Survey_model->get_crew_details_master_serang($vessel_id, $survey_id,$crew_type_sl);
$data['crew_details_master']     =   $crew_details_master;
if(!empty($crew_details_master))
{
  $license_number_of_type=$crew_details_master[0]['license_number_of_type'];
   $crew_type_name=$crew_details_master[0]['crew_type_name'];
}

 //-----------Get Passenger--------------//
$passenger_details=$this->Survey_model->get_passenger_details($vessel_id,$survey_id);
$data['passenger_details']=$passenger_details;
if(!empty($passenger_details))
{
	$plying_night_upperdeck 	=	$passenger_details[0]['plying_night_upperdeck'];
	$plying_daynight_upperdeck	=	$passenger_details[0]['plying_daynight_upperdeck'];
	$plying_halfday_upperdeck 	=	$passenger_details[0]['plying_halfday_upperdeck'];

	$plying_night_inbwdeck 		=	$passenger_details[0]['plying_night_inbwdeck'];
	$plying_daynight_inbwdeck 	=	$passenger_details[0]['plying_daynight_inbwdeck'];
	$plying_halfday_inbwdeck 	=	$passenger_details[0]['plying_halfday_inbwdeck'];

	$plying_night_maindeck 		=	$passenger_details[0]['plying_night_maindeck'];
	$plying_daynight_maindeck 	=	$passenger_details[0]['plying_daynight_maindeck'];
	$plying_halfday_maindeck 	=	$passenger_details[0]['plying_halfday_maindeck'];

	$plying_night_secondcabin 	=	$passenger_details[0]['plying_night_secondcabin'];
	$plying_daynight_secondcabin=	$passenger_details[0]['plying_daynight_secondcabin'];
	$plying_halfday_secondcabin =	$passenger_details[0]['plying_halfday_secondcabin'];

	$plying_night_saloon 		=	$passenger_details[0]['plying_night_saloon'];
	$plying_daynight_saloon 	=	$passenger_details[0]['plying_daynight_saloon'];
	$plying_halfday_saloon 		=	$passenger_details[0]['plying_halfday_saloon'];


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
<strong> FORM No.9  </strong>
</div> <!-- end of col12 -->
<div align="center" class="col-12 py-2 px-3 d-flex justify-content-center"> 
[See  Rule 12] 
</div> <!-- end of col12 -->
<div align="center" class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong>Certificate of Survey  </strong>
</div> <!-- end of col12 -->
</div>
<div>&nbsp;</div>

<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To remain in force until the --------- day of ------------20---only; unless previously cancelled or suspended</div>

<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The vessel &nbsp; <?php echo $vessel_name; ?></div>




<table width="100%" cellspacing="0" cellpadding="0" >
<tr>
	<td>1.</td>
	<td>OWNER, MANAGING OWNER OR AGENT </td>
	<td>:</td>
	<td><?php echo $user_name; ?></td>
</tr>

<tr>
	<td>2.</td>
	<td>PLACE OF REGISTRY AND OFFICIAL NUMBER</td>
	<td>:</td>
	<td><?php echo $portofregistry_name; ?>&nbsp;&nbsp;<?php echo $official_number; ?></td>
</tr>	

<tr>
	<td>3.</td>
	<td>TONNAGE, Gross Registered tonnage, Net Registered tonnage</td>
	<td>:</td>
	<td><?php echo $vessel_gross_tonnage; ?>Ton,&nbsp;&nbsp;<?php echo $vessel_net_tonnage; ?>Ton</td>
</tr>

<tr>
	<td>4.</td>
	<td>Name of Master, and No. of his certificate or license</td>
	<td>:</td>
	<td><?php echo $crew_type_name; ?>,&nbsp;&nbsp;<?php echo $license_number_of_type; ?></td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td valign="top">Declaration:- </td>
		<td align="justify">This is to certify that the provisions of the Inland Vessels Act 1917 (Central Act 1 of 1917) and the Rules made there under regarding survey and the transmission of declarations in respect of this vessel have been complied with.</td>
	</tr>

	<tr>
		<td valign="top">Plying limits:- </td>
		<td align="justify">This vessel is not to ply other than -------------------</td>
	</tr>

	<tr>
		<td valign="top">Passengers:- </td>
		<td align="justify">This is vessel, according to the declaration of the Surveyor is fit to carry passengers in accordance with the following scale:-</td>
	</tr>
</table>
<br>
<table width="100%" cellspacing="0" cellpadding="0" border="1">
	<tr>
	<td valign="top">Number of Deck<br> passengers on each deck</td>
	<td valign="top">When plying by<br> night on <br>smooth <br>and<br> partially <br>smooth water</td>
	<td valign="top">When plying by <br>day on smooth <br> and partially <br>smooth water<br> or in canals by<br>night and day  </td>
	<td valign="top">When plying by<br> day on voyages<br> which do not <br>last more than <br>six hours on <br>smooth water only </td>
	<!-- <td valign="top">Second cabin passengers </td>
	<td valign="top">Saloon passengers </td> -->
	</tr>
<tr>
<td>On between deck, if any</td>
<td><?php echo $plying_night_inbwdeck; ?></td>
<td><?php echo $plying_daynight_inbwdeck; ?></td>
<td><?php echo $plying_halfday_inbwdeck; ?></td>
</tr>

<tr>
<td>On main deck</td>
<td><?php echo $plying_night_maindeck; ?></td>
<td><?php echo $plying_daynight_maindeck; ?></td>
<td><?php echo $plying_halfday_maindeck; ?></td>
</tr>

<tr>
<td>on the upper deck/bridge</td>
<td><?php echo $plying_night_upperdeck; ?></td>
<td><?php echo $plying_daynight_upperdeck; ?></td>
<td><?php echo $plying_halfday_upperdeck; ?></td>
</tr>

<tr>
<td>Total deck passenger</td>
<td><b><?php echo ($plying_night_inbwdeck+$plying_night_maindeck+$plying_night_upperdeck);?></b></td>
<td><b><?php echo ($plying_daynight_inbwdeck+$plying_daynight_maindeck+$plying_daynight_upperdeck);?></b></td>
<td><b><?php echo ($plying_halfday_inbwdeck+$plying_halfday_maindeck+$plying_halfday_upperdeck);?></b></td>
</tr>

<tr>
<td>Second cabin passengers</td>
<td><?php echo $plying_night_secondcabin; ?></td>
<td><?php echo $plying_daynight_secondcabin; ?></td>
<td><?php echo $plying_halfday_secondcabin; ?></td>
</tr>

<tr>
<td>Saloon passengers </td>
<td><?php echo $plying_night_saloon; ?></td>
<td><?php echo $plying_daynight_saloon; ?></td>
<td><?php echo $plying_halfday_saloon; ?></td>
</tr>
</table>

<div>Two children above 5 years and under 12 years of age to be reckoned as one passenger</div>


<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td valign="top">Encumbrance:- </td>
		<td align="justify"><i>If the space measured by the Surveyor for passenger accomodation is encumbered by cattle, cargo or other articles then ONE PASSENGER is to be deducted from the foregoing table for each</i></td>
	</tr>
	<tr>
		<td valign="top"> </td>
		<td align="justify">65 dm<sup>2</sup> passenger area encumbered when plying at A above</td>
	</tr>
	<tr>
		<td valign="top"> </td>
		<td align="justify">50 dm<sup>2</sup> passenger area encumbered when plying at B above</td>
	</tr>
	<tr>
		<td valign="top"> </td>
		<td align="justify">40 dm<sup>2</sup> passenger area encumbered when plying at C above</td>
	</tr>
	
	</table>
<br>
	<div>Towing by this vessel while plying with passengers is prohibited/permitted as follows(only)</div>
	<br>
	<div><i>Equipments:-</i> Required by law to be carried and maintained in proper condition and in the positions approved by the Surveyor on this vessel while this certificate remains in force include the following:-</div>


<table width="100%" cellspacing="0" cellpadding="0">
<tr>
	<td>Bilge and hold pumps</td>
	<td><?php if($count_bilgepump!=0 ) { echo $count_bilgepump; } else{ echo "No"; } ?></td>
	<td>Fire Buckets</td>
	<td valign="top"><?php if(@$fire_bucket_number!=0 ) { echo $fire_bucket_number; } else{ echo "No"; } ?></td>
	<td>Boats of<br>aggregate capacity</td>
	<td><?php echo $boats_aggregate_capacity; ?></td>
</tr>

<tr>
	<td>Fire Pumps</td>
	<td><?php if($count_firepumps!=0 ) { echo $count_firepumps; } else{ echo "No"; } ?></td>
	<td>Fire Sand Boxes</td>
	<td><?php if($fire_sandbox_number!=0) { echo $fire_sandbox_number; } else  { echo $nil; } ?></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<td>Fire Hose</td>
	<td><?php if($number_of_hose!=0) { echo $number_of_hose; } else  { echo "No"; } ?></td>
	<td>Fire Extinguishers</td>
	<td><?php if($count_portablefire_extinguisher!=0 ) { echo $count_portablefire_extinguisher; } else{ echo "nil"; } ?></td>
	<td></td>
	<td></td>
</tr>
</table>
<br>
<div>Life bouys and Buoyancy apparatus As below</div>

<div>When plying as at A; life buoys and buoyancy apparatus &nbsp; <?php echo $lifebuoys_plyingA; ?></div>
<div>When plying as at B; life buoys and buoyancy apparatus &nbsp; <?php echo $lifebuoys_plyingB; ?></div>
<div>When plying as at C; life buoys and buoyancy apparatus &nbsp; <?php echo $lifebuoys_plyingC; ?></div>
<br>


<table width="100%" cellspacing="0" cellpadding="0" >
	<tr>
		<td valign="top"><i>Exhibition of certificate:-</i> </td>
		<td align="justify">This certificate (or a duplicate signed by the Certifying Officer) must be exhibited in a legible conditoin, protected by glass where it may be easily read by all persons on board.</td>
	</tr>

	<tr>
		<td valign="top"><i>Expiry of certificate:-</i>  </td>
		<td align="justify">The vessel must cease to ply on the date given above for the expiry of this certificate (except in so far as may be neccessary for her to reach a place of survey if she is not at such a place at that date) until she is again surveyed and granted a fresh certificate</td>
	</tr>

	<tr>
		<td valign="top"><i>Name of vessel:-</i> </td>
		<td align="justify">While this certificate is in force the vessel's name, as printed or otherwise marked in positions approved by the Surveyor, is not to be removed or defaced; and if a change of name is desired, 14 clear days notice is to be given to the Certifying Officer before the change is made.</td>
	</tr>
		<tr>
		<td valign="top"><i>Accidents:-</i> </td>
		<td align="justify">After any accident, howsoever caused, occasioning loss of life or any material damage affecting the safetyof the vessel either in her hull, machinery or equipments, the master or serang is to report the particulars at the nearest police station; and as soon as possible the owner or master is to report the matter fully in writting signed by him to the surveyor at the nearest declared place of survey</td>
	</tr>
</table>
<br>
<div align="right">Signature</div>

</div>