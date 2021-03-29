
<?php 
/*$sess_usr_id  =   $this->session->userdata('user_sl');
$user_type_id  =   $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');

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
    $area_of_operation         =     $res_vessel['area_of_operation'];

    $build_place                 =     $res_vessel['build_place'];

$passenger_capacity                 =     $res_vessel['passenger_capacity'];


 $vessel_type_id         =     $res_vessel['vessel_type_id'];
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
?>

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container letterform mb-4">
<div class="row no-gutters">
<div align="center"><img src="assets/img/govtemblem.jpg" width="100" height="60" alt=""> </div>
<div align="center"> <strong>Government of Kerala</strong></div>
<div align="center"> <strong>FORM NO: 14</strong></div>
<div align="center"> <strong><i>(See Rule 17)</i></strong></div>
<div align="center"> <strong>Certificate of Registration</strong></div><?php if(isset($duplicate_cert_type)){ if($duplicate_cert_type==1){?><div align="right"><font color="red"><strong>DUPLICATE</strong></font></div><?php }} ?>
</div>
<br>
<table width="100%">
<tr><td colspan="2" align="right">PASSENGER CAPACITY: <?php echo $passenger_capacity; ?> Nos (Excluding crew)</td></tr>

<tr><td>Official Number:&nbsp;<strong><?php echo $vessel_registration_number;?></strong></td><td align="right">Year and Place of Registry: <?php echo $year; ?>, <?php  $lower= strtolower($portofregistry_name); echo ucfirst($lower);  ?> </td></tr></table>
<br>
<div align="justify" class="tbline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that <strong><?php echo $ra_name; ?></strong>, Registering Authority of Kerala, has declared that <strong><?php echo $user_name; ?>, <?php echo $user_address; ?> MOB: <?php echo $user_mobile; ?> </strong>
 subject of the state of <strong><?php $lstate=strtolower($state_name); echo ucfirst($lstate); ?></strong> and the sole proprietors of the <strong><?php echo $vesseltype_name; ?></strong> called  <strong><?php echo $vessel_name; ?></strong> and that the said Vessel was built at <strong><?php echo $build_place; ?></strong> by <strong><?php echo $yardName; ?></strong> in the year <strong><?php echo $hull_year_of_built; ?>.</strong> The said <strong><?php echo $vesseltype_code; ?></strong> had been duly registered at <strong><?php echo $portofregistry_name; ?> PORT</strong> under the Inland Vessels Act, 1917. Certified under my hand this day of <strong><?php echo $day ?><sup><?php echo $sup;?></sup> day of 
 <?php echo $month.' '. $year;  ?></strong>. </div>
<br>
<form name="form14" id="form14" method="POST" action="">

<table width="100%" cellpadding="0" cellspacing="0" border="1" class="tabletbox">

<!--   <tr>
    <td width="40%">Registration Number</td>
    
    <td width="55%"><?php echo $vessel_registration_number;  ?></td>
  </tr>

  <tr>
    <td width="40%">Name of Inland Vessel</td>
    
    <td width="55%"><?php  echo $vessel_name; ?></td>
  </tr>

  <tr>
    <td width="40%">Name of Owner</td>
    
    <td width="55%"><?php echo $user_name;  ?></td>
  </tr> 

   <tr>
    <td width="40%">Address of owner</td>
    
    <td width="55%"><?php echo $user_address;  ?></td>
  </tr> -->

 <tr>
    <td width="40%">No. of sets of Engines</td>
    
    <td width="55%"><?php echo $no_of_engineset;  ?></td>
  </tr>

<tr>
    <td width="40%">No. of shafts</td>
    
    <td width="55%"><?php echo $no_of_shaft;  ?></td>
  </tr>
<?php 


if(!empty($engine_details))
{
  $i=1;
   foreach($engine_details as $res_engine)
  {

    $engine_description=$res_engine['engine_description'];
    $engine_number=$res_engine['engine_number'];
$engine_placement_id=$res_engine['engine_placement_id'];

    $engine_speed=$res_engine['engine_speed'];

    @$fuel_used_id=$res_engine['fuel_used_id'];
    $bhp=$res_engine['bhp'];
    $rpm=$res_engine['rpm'];
$manufacturer_name=$res_engine['manufacturer_name'];
$manufacturer_brand=$res_engine['manufacturer_brand'];

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


<tr>
    <td width="40%" colspan="2" align="left">Engine <?php echo $i; ?></td>
    
  </tr>
<tr>
    <td width="40%"> Description of engine / Engine number</td>
    
    <td width="55%"><?php echo $inboard_outboard_name .' / '. $engine_number;  ?></td>
  </tr>
<tr>
    <td width="40%"> Name and address of maker</td>
    
    <td width="55%"><?php echo $manufacturer_name;  ?>,<?php echo $manufacturer_brand;  ?></td>
  </tr>


<tr>
    <td width="40%">Nature of fuel used</td>
    
    <td width="55%"><?php echo $fuel_name;  ?></td>
  </tr>

<tr>
    <td width="40%">Estimated speed of inland vessel</td>
    
    <td width="55%"><?php echo $engine_speed;  ?></td>
  </tr>

<tr>
    <td width="40%">Total brake horse power </td>
    
    <td width="55%"><?php echo $bhp;  ?></td>
  </tr>

<tr>
    <td width="40%"> R.P.M</td>
    
    <td width="55%"><?php echo $rpm;  ?></td>
  </tr>
<tr>
    <td width="40%"> Surface, jet of any other </td>
    
    <td width="55%"><?php   ?></td>
  </tr>

<?php $i++; }

}
?>



<tr>
    <td width="40%">Extreme length </td>
    <td width="55%"><?php  echo $vessel_length_overall; ?>&nbsp;m</td>
  </tr>
  
<tr>
    <td width="40%"> Length </td>
    <td width="55%"><?php  echo $vessel_length; ?>&nbsp;m</td>
  </tr>

  <tr>
    <td width="40%"> Breadth </td>
    
    <td width="55%"><?php  echo $vessel_breadth; ?>&nbsp;m</td>
  </tr>
   <tr>
    <td width="40%"> Depth </td>
    
    <td width="55%"><?php  echo $vessel_depth; ?>&nbsp;m</td>
  </tr>
  
 <tr>
    <td width="40%"> Gross Registered Tonnage </td>
    
    <td width="55%"><?php if($vessel_gross_tonnage!=0) {  echo $vessel_gross_tonnage; ?>&nbsp;Ton <?php } else { echo "---";} ?></td>
  </tr>

    <tr>
    <td width="40%"> Net Registered Tonnage </td>
    
    <td width="55%"><?php if($vessel_net_tonnage!=0) {  echo $vessel_net_tonnage; ?>&nbsp;Ton  <?php } else
    { echo "---"; } ?></td>
  </tr>
     <tr>
    <td width="40%"> No. of Decks </td>
    
    <td width="55%"><?php  if($vessel_no_of_deck!=0) { echo $vessel_no_of_deck; } else { echo "---"; } ?></td>
  </tr>

   <tr>
    <td width="40%"> No. of Bulkheads </td>
    
    <td width="55%"><?php if($bulk_heads!=0) { echo $bulk_heads; } else { echo "---";} ?></td>
  </tr>

  
   <tr>
    <td width="40%"> Year of Build </td>
    
    <td width="55%"><?php  echo $hull_year_of_built; ?></td>
  </tr>


   <tr>
    <td width="40%"> Stern </td>
    
    <td width="55%"><?php if($stern) { echo $stern; } else { echo "---"; } ?></td>
  </tr>


   <tr>
    <td width="40%"> Material </td>
    
    <td width="55%"><?php  if($materialname) {  echo $materialname; } else { echo "---"; } ?></td>
  </tr>


</table>
<br>
<div align="justify"><i>Note:-</i>This Certificate of Registration shall be produced for inspection on demand by any authority authorized by the State Government.<br>

<table width="100%">
<tr>
  <td>1. </td>
  <td align="justify">This Certificate shall be surrendered to the Registering Authority if so required by him.</td>
  </tr>
<tr>  
<td valign="top">2. </td>
<td align="justify">While this Certificate is in force the Vessels's name and Registration mark as painted or otherwise marked in the position approved by the Government of Kerala shall not be removed or defaced.</td>
</tr>
<tr>
<td valign="top">3. </td>
<td align="justify">In case of any accident occasioning loss of life or any material damage affecting the river worthiness or efficiency of the Vessel, either in the Hull or in any part of the Machinery, a Report by letter, signed by the Owner or Master of the Vessel shall be forwarded to the Registering Authority, Kerala within 24 Hrs after the happening of the accident, or as soon thereafter as possible.</td>
</tr>
</table>
<br>
<div>Date of Registration&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; <strong><?php echo $vesselmain_reg_date; ?></strong> <br>Date of Validity up to&nbsp; :<strong>&nbsp;&nbsp;<?php echo $validity_up_to_date; ?></strong> </div>
<br>

<table width="100%"><tr><td>Subject to validity &amp; Compllance of <br>Conditons on the survey certificate</td>
<td align="right">Registering Authority<br>Port of <?php $lower= strtolower($portofregistry_name); echo ucfirst($lower); ?></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2">Area of operation:&nbsp;<?php echo $area_of_operation; ?></td></tr></table>
</form>





</div> 
</div> 
</div> 
</div>   
<style type="text/css">
  div,table {
  font-size: 11px;
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
  line-height: 21px;
}

</style>