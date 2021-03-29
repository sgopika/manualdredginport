<?php

/*$sess_usr_id   =   $this->session->userdata('user_sl');
$user_type_id  =   $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');
/*_____________________Decoding Start___________________*/
$vessel_id1    = $this->uri->segment(4);


$vessel_id     = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id     = $this->encrypt->decode($vessel_id); 


/*_____________________Decoding End___________________*/
$survey_id=0;
$yes="Yes";
$no="No";
$nil="Nil";

$vessel_details       =   $this->Vessel_change_model->get_vessel_details_viewpage($vessel_id);
  $data['vessel_details']   = $vessel_details;

  $vesselnamechg_details       =   $this->Vessel_change_model->get_vesselnamechange_details_ra($vessel_id);
  $data['vesselnamechg_details']   = $vesselnamechg_details;

//print_r($vessel_details);exit;

if(!empty($vessel_details))
{
	foreach($vessel_details as $res_vessel)
  	{
	    $vessel_name                =     $res_vessel['vessel_name'];
	    $vessel_survey_number       =     $res_vessel['vessel_survey_number'];
	    $vessel_registry_port_id    =     $res_vessel['vessel_registry_port_id'];
      $created_user_id            =     $res_vessel['created_user_id'];

	   

	    /*$validity_fire_extinguisher = date("d-m-Y", strtotime($validity_fire_extinguisher1));
	    $validity_of_insurance      = date("d-m-Y", strtotime($validity_of_insurance1));
	    $validity_of_certificate    = date("d-m-Y", strtotime($validity_of_certificate1));*/

    	if(!empty($vessel_registry_port_id))
    	{
       		$portofregistry          =   $this->Vessel_change_model->get_registry_port_id($vessel_registry_port_id);
       		$data['portofregistry']  =   $portofregistry;
       		$portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
    	}
      else
    {
      $portofregistry_name="";
    }
      if(!empty($created_user_id))
      {
          $owner                   =   $this->Vessel_change_model->get_owner($created_user_id);
          $data['owner']           =   $owner;
          $owner_name              =   $owner[0]['user_name'];
          $owner_address           =   $owner[0]['user_address'];
      }

  	}
}
if(!empty($vesselnamechg_details)){
  foreach($vesselnamechg_details as $res_name)
    {
      $newvessel_name              =   $res_name['change_name'];
      $change_req_date             =   date("d-m-Y", strtotime($res_name['change_req_date']));
    }

}



?>
<!-- <style type="text/css">
  div,table {
  font-size: 14px;
}
table.tabletbox
  {
  border:solid 1px black;
  border-collapse:collapse;
  padding:0px;
  font-size:14px;
  margin-right: 0px;
  margin-left: 0px;
 
}
.tbline
{
  line-height: 35px;
}

</style> -->

<div class="ui-innerpage">
<div class="row no-gutter text-primary">
<div align="center"  class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong> FORM No: 11  </strong>
</div> <!-- end of col12 -->
<div align="center" class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong>APPLICATION FOR CHANGE OF NAME OF THE VESSEL  </strong>
</div> <!-- end of col12 -->
</div>
<div></div>
<div></div>
<div></div>
<div></div>
<table width="100%">
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td align="margin-right">Place : <?php echo $portofregistry_name;?></td>
</tr>	

<tr>
	<td></td>
	<td></td>
	<td></td>
	<td align="margin-right">Date : <?php echo $change_req_date;?></td>
</tr>

<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<td>From</td>
	<td></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>


<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr><br/>

<tr>
	<td></td>
	<td colspan="3">Certificate of Survey No : <?php echo $vessel_survey_number;?></td>
</tr>

<tr>
	<td></td>
	<td>Name : <?php echo $owner_name;?></td>
	<td></td>
	<td></td>
</tr>

<tr>
	<td></td>
	<td>Vessel Name : <?php echo $vessel_name;?></td>
	<td></td>
	<td>&nbsp;&nbsp;<?php echo $operation_area; ?> </td>
</tr>

<tr>
	<td>To</td>
	<td></td>
	<td></td>
	<td></td>
</tr>

<tr>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr><br/>

<tr>
  <td></td>
  <td>The Registering Authority</td>
  <td></td>
  <td></td>
</tr>

<tr>
  <td></td>
  <td>TVM</td>
  <td></td>
  <td></td>
</tr>

<tr>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>

<tr>
  <td></td>
  <td>Sub :- </td>
  <td colspan="2">Change the Name of the Vessel</td>
</tr>

<tr>
  <td></td>
  <td>Ref :- </td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr><br/>
 
<tr>
	<td></td>
	<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;I <strong><?php echo $owner_name;?></strong> of being the owner / master of Inland Vessel <strong><?php echo $vessel_name;?></strong> bearing No. hereby request that the name of the vessel may be changed as <strong><?php echo $newvessel_name;?></strong>. The certificate of survey No. <strong><?php echo $vessel_survey_number;?></strong> dated in original is enclosed herewith for making the change of name.</td>
</tr>



</table>
</div>