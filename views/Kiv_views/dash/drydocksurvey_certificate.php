<?php 
  $sess_usr_id     = $this->session->userdata('int_userid');
  $user_type_id   = $this->session->userdata('int_usertype');
/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$timeline_sl1         = $this->uri->segment(5);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$timeline_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $timeline_sl1);
$timeline_sl=$this->encrypt->decode($timeline_sl); 
/*_____________________Decoding End___________________*/

  $vessel_details_viewpage       =   $this->Survey_model->get_vessel_details_viewpage($vessel_id);
   $data['vessel_details_viewpage'] = $vessel_details_viewpage;

if(!empty($vessel_details_viewpage))
{
	foreach ($vessel_details_viewpage as $res_vessel)  
	{
		$vessel_name                =     $res_vessel['vessel_name'];
		$vessel_survey_number       =     $res_vessel['vessel_survey_number'];
		$official_number            =     $res_vessel['official_number'];
		$reference_number           =     $res_vessel['reference_number'];
		@$vessel_registry_port_id   =     $res_vessel['vessel_registry_port_id'];
		$vessel_registration_number =     $res_vessel['vessel_registration_number'];
		$vessel_yearofbuilt         =     $res_vessel['vessel_expected_completion'];
		$vessel_registry_port_id    =     $res_vessel['vessel_registry_port_id'];
		$yardname    				=     $res_vessel['yardName'];
		$drydock_recommendation    	=     $res_vessel['drydock_recommendation'];
	}
}


    @$id=$vessel_details_viewpage[0]['user_id'];



    
   
	$survey_id=1;
     //----------Hull Details--------//
   $nil="nil";
   $hull_details        =   $this->Survey_model->get_hull_details($vessel_id,$survey_id);
   $data['hull_details']    = $hull_details;

if(!empty($hull_details))
{
   foreach($hull_details as $res_hull)
  {
   
    $hullmaterial_id  = $res_hull['hullmaterial_id'];
     $yard_accreditation_number  = $res_hull['yard_accreditation_number'];
     $hull_condition_status_id  = $res_hull['hull_condition_status_id'];
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


     

     if($hullmaterial_id!=0)
  {
    $get_hullmaterial_id          =   $this->Survey_model->get_hullmaterial_name($hullmaterial_id);
    $data['get_hullmaterial_id']  =   $get_hullmaterial_id;
    @$hullmaterial_name            =   $get_hullmaterial_id[0]['hullmaterial_name'];
  }
  else
  {
    $hullmaterial_name='-';
  }
  }
}


   
   //----------Engine Details--------//
   
   $engine_details      =   $this->Survey_model->get_engine_details($vessel_id,$survey_id);
   $data['engine_details']  = $engine_details;


//-----------Get customer name and address--------------//
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
 if(!empty($vessel_registry_port_id))
    {
       $portofregistry          =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
       $data['portofregistry']  =   $portofregistry;
       $portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
    }
$survey_id1=1;
$subprocess_id=3;

$timeline_nextdrydock     =   $this->Survey_model->get_vessel_timeline_nextdrydock($vessel_id,$survey_id1,$subprocess_id);
/*print_r($timeline_nextdrydock);
exit;*/

//$timeline_nextdrydock     =   $this->Survey_model->get_vessel_timeline_nextdrydock_timesl($timeline_sl);

$data['timeline_nextdrydock']  =   $timeline_nextdrydock;
if(!empty($timeline_nextdrydock))
{
	$link_id=$timeline_nextdrydock[0]['link_id'];

	$next_drydock_date 	=	date("d-m-Y", strtotime($timeline_nextdrydock[0]['scheduled_date']));

}

//$timeline_lastdrydock     =   $this->Survey_model->get_vessel_timeline_lastdrydock($vessel_id,$survey_id1,$subprocess_id);
$timeline_lastdrydock     =   $this->Survey_model->get_vessel_timeline_lastdrydock_timesl($link_id);

$data['timeline_lastdrydock']  =   $timeline_lastdrydock;

if(!empty($timeline_lastdrydock))
{
	$last_drydock_date 	=	date("d-m-Y", strtotime($timeline_lastdrydock[0]['actual_date']));
}

//print_r($timeline_nextdrydock);


?>

<div class="main-content">  
<div class="row ui-innerpage " >
<div class="col-12">
<div class="container letterform mb-4">
<div class="row no-gutters">
<div align="center"><img src="plugins/img/govtemblem.jpg" width="100" height="60" alt=""> </div>
<div align="center"> <strong>Government of Kerala</strong></div>
<!-- <div align="center"> <strong>FORM NO: 14</strong></div>
<div align="center"> <strong><i>(See Rule 17)</i></strong></div> -->
<div align="center"> <strong>Drydock Certificate</strong></div>
</div>

<table width="100%" cellspacing="0" cellpadding="0" align="center" >

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
	<td>&nbsp;&nbsp;<?php echo $vessel_registration_number; ?></td>
</tr>	
<tr>
	<td>3.</td>
	<td>Name of Owner</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $user_name; ?></td>
</tr>	
<tr>
	<td>4.</td>
	<td>Year of built</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $vessel_yearofbuilt; ?></td>
</tr>	

<tr>
	<td>5.</td>
	<td>Port of registry</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $portofregistry_name; ?></td>
</tr>	

<tr>
	<td>6.</td>
	<td>Hull material</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $hullmaterial_name; ?></td>
</tr>	

<tr><td colspan="4">&nbsp;</td></tr>

<tr>
	<td colspan="4">Engine details</td>
</tr>
<tr><td colspan="4">&nbsp;</td></tr>

<tr>
	<td>7.</td>
	<td>Name of the yard</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $yardname; ?></td>
</tr>	
<tr>
	<td>8.</td>
	<td>Yard accrediation number</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $yard_accreditation_number; ?></td>
</tr>	
<tr>
	<td>9.</td>
	<td>Last drydock date</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $last_drydock_date; ?></td>
</tr>	
<tr>
	<td>10.</td>
	<td>Next drydock date</td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $next_drydock_date; ?></td>
</tr>

<tr>
	<td>11.</td>
	<td>Condition of the hull/Machinary propulsion </td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $conditionstatus_name; ?></td>
</tr>	

<tr>
	<td>12.</td>
	<td>Recommendation </td>
	<td>:</td>
	<td>&nbsp;&nbsp;<?php echo $drydock_recommendation; ?></td>
</tr>	
</table>
<br>
<br>
<table width="100%">
	<tr>
		<td align="left">Date&nbsp;&nbsp;: <?php echo $portofregistry_name; ?></td>
		<td align="right">Name and signature</td>
		</tr>

		<tr><td align="left">Place:&nbsp;: <?php echo date('d-m-Y'); ?></td>
		<td></td>
	</tr>
</table>

</div>
</div>
</div>
</div>