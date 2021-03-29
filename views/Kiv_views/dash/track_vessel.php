<?php 

$moduleid        = 2;
$modenc          = $this->encrypt->encode($moduleid); 
$modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

$sess_usr_id     = $this->session->userdata('int_userid');
$user_type_id    = $this->session->userdata('int_usertype');

?>
<!-- Start of breadcrumb -->
<nav aria-label="breadcrumb " class="mb-0">
<ol class="breadcrumb justify-content-end mb-0">
<?php if($user_type_id==12) { ?>
<li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
<?php } ?>
<?php if($user_type_id==3) { ?>
<li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
<?php } ?>
<?php if($user_type_id==13) { ?>
<li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
<?php } ?>
<?php if($user_type_id==14) { ?>
<li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
<?php } ?>
<?php if($user_type_id==11) { ?>
<li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
<?php } ?>
</ol>
</nav> 
<!-- End of breadcrumb -->
<div class="ui-innerpage">

<!-- <form name="form1" method="post" action=""> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/track_vessel", $attributes);
?>

<div class="container mt-5 mb-5">
<div class="row ">
<div class="col-4 d-flex justify-content-end">Select vessel</div>
<div class="col-4 d-flex justify-content-start">

<select class="form-control btn-point js-example-basic-single select2" name="vessel_id" id="vessel_id"  required>
<option value="">Select</option>
<?php foreach($vessel_details as $res_vessel_details) { ?>
<option value="<?php echo $res_vessel_details['vessel_sl']?>"><?php echo $res_vessel_details['vessel_name'];?><?php if(!empty($res_vessel_details['vessel_registration_number'])) { echo "---".$res_vessel_details['vessel_registration_number']; } ?>  </option>
<?php } ?></select>

</div> 
<div class="col-4 d-flex justify-content-start"><input type="submit" value="Submit" class="btn bg-purple-active btn-flat  btn-point btn-md" name="btnsubmit" id="btnsubmit"  ></div> 
</div> 
</div> 
<!-- </form> --> <?php echo form_close(); ?>

<?php 
if(!empty($slt_processflow))
{
  $vessel_id             = $slt_processflow[0]['vessel_id'];
  $vessel_details_viewpage           = $this->Survey_model->get_vessel_details_viewpage($vessel_id);
  $data['vessel_details_viewpage']  = $vessel_details_viewpage;
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
    $validity_fire_extinguisher1=     $res_vessel['validity_fire_extinguisher'];
    $validity_of_insurance1     =     $res_vessel['validity_of_insurance'];
    $validity_of_certificate1   =     $res_vessel['validity_of_certificate'];
    $form10_remarks             =     $res_vessel['form10_remarks'];
    $validity_fire_extinguisher =     date("d-m-Y", strtotime($validity_fire_extinguisher1));
    $validity_of_insurance      =     date("d-m-Y", strtotime($validity_of_insurance1));
    $validity_of_certificate    =     date("d-m-Y", strtotime($validity_of_certificate1));
    $vessel_category_id         =     $res_vessel['vessel_category_id'];
    $vessel_subcategory_id      =     $res_vessel['vessel_subcategory_id'];
    $vessel_type_id             =     $res_vessel['vessel_type_id'];
    $vessel_subtype_id          =     $res_vessel['vessel_subtype_id'];
    @$owner_id                  =     $res_vessel['user_id'];
    
   //_________________Get customer name and address_____________________//
    $customer_details=$this->Survey_model->get_customer_details($owner_id);
    $data['customer_details']=$customer_details;
    if(!empty($customer_details)) 
    {
      foreach($customer_details as $res_owner)
      {
        $owner_name     = $res_owner['user_name'];
        $owner_address  = $res_owner['user_address'];
        $owner_phone  = $res_owner['user_master_ph'];
        $owner_email  = $res_owner['user_master_email'];
      }
    }
    else
    {
      $owner_name   ="";
      $owner_address  ="";
    }

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
    //_________________Get port of registry name________________//
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
    //_________________Get vessel category name________________//
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
    //_________________Get vessel sub category name________________//
    if($vessel_subcategory_id!=0)
    {
      $vessel_subcategory_id      =   $this->Survey_model->get_vessel_subcategory_id($vessel_subcategory_id);
      $data['vessel_subcategory_id']  = $vessel_subcategory_id;
      @$vessel_subcategory_name   = $vessel_subcategory_id[0]['vessel_subcategory_name'];
    }
    else
    {
      $vessel_subcategory_name='-';
    }
    //_________________Get vessel type name________________//
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
    //_________________Get vessel sub type name________________//  
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
    //_____________________get initial survey date_____________________________//
    $process_id1=1;
    $initial_survey_id1=1;
    $initial_survey_done=$this->Survey_model->get_survey_done_vessel($process_id1,$initial_survey_id1,$vessel_id);
    $data['initial_survey_done']  = $initial_survey_done;
    if(!empty($initial_survey_done))
    {
      $actual_date=date("d-m-Y", strtotime($initial_survey_done[0]['actual_date']));
    }
    else
    {
      $actual_date="";
    }
    //_____________get vessel main______________________//
    $vessel_main=$this->Survey_model->get_vessel_main($vessel_id);
    $data['vessel_main']  = $vessel_main;
    if(!empty($vessel_main))
    {
      $vesselmain_reg_date=date("d-m-Y", strtotime($vessel_main[0]['vesselmain_reg_date']));
      $next_reg_renewal_date=date("d-m-Y", strtotime($vessel_main[0]['next_reg_renewal_date']));
      $vesselmain_annual_date=date("d-m-Y", strtotime($vessel_main[0]['vesselmain_annual_date']));
      $vesselmain_drydock_date=date("d-m-Y", strtotime($vessel_main[0]['vesselmain_drydock_date']));
    }
    //_____________________get next annual survey date_____________________________//
    $process_id1=1;
    $subprocess_id2=2;
    $next_annual_details=$this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$process_id1,$subprocess_id2);
    $data['next_annual_details']  = $next_annual_details;
    if(!empty($next_annual_details))
    {
      $next_annual_date=date("d-m-Y", strtotime($next_annual_details[0]['scheduled_date']));
    }
    else
    {
      $next_annual_date="";
    }
   //_____________________get next drydock survey date_____________________________//
    $process_id1=1;
    $subprocess_id3=3;
    $next_drydock_details=$this->Survey_model->get_vessel_timeline_nextdate($vessel_id,$process_id1,$subprocess_id3);
    $data['next_drydock_details']  = $next_drydock_details;
    if(!empty($next_drydock_details))
    {
      $next_drydock_date=date("d-m-Y", strtotime($next_drydock_details[0]['scheduled_date']));
    }
    else
    {
      $next_drydock_date="";
    }
    //_____________________get pcb date_____________________________//
    $pollution_details=$this->Survey_model->get_vessel_pollution($vessel_id);
    $data['pollution_details']  = $pollution_details;
    if(!empty($pollution_details))
    {
      $validity_of_pcb=date("d-m-Y", strtotime($pollution_details[0]['pcb_expiry_date']));
    }
    else
    {
      $validity_of_pcb="";
    }
        



  }
 //-----------------Get Namechange Log details----------------//    
  $namechg_dt           =   $this->Vessel_change_model->getnamechange_vessel($vessel_id);
  $data['namechg_dt']   =   $namechg_dt;

  //-----------------Get Ownerchange Log details----------------//    
  $ownerchg_dt          =   $this->Vessel_change_model->getownerchange_vessel($vessel_id);
  $data['ownerchg_dt']  =   $ownerchg_dt;

   //-----------------Get Ownerchange Log details----------------//    
  $transfrvsl_dt        =   $this->Vessel_change_model->gettransfer_vessel($vessel_id);
  $data['transfrvsl_dt']=   $transfrvsl_dt;
  
  //-----------------Get Ownerchange Log details----------------//    
  $dupcert_dt           =   $this->Vessel_change_model->get_dupcert_details($vessel_id);
  $data['dupcert_dt']   =   $dupcert_dt;

   //-----------------Get Renewal of registration Log details----------------//    
  $renewal_dt           =   $this->Vessel_change_model->get_renewal_details($vessel_id);
  $data['renewal_dt']   =   $renewal_dt;
 
  ?>

  <div class="row h-100 justify-content-center mt-3" id="form9view">
  <div class="col-12">

  <!-- <form name="form1" id="form1" method="post" action=""> -->
    <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/track_vessel", $attributes);
?>

  <!-- ____________________________ Vessel Details ____________________________ -->
  <div class="col-12 py-2 d-flex justify-content-center text-primary"> <strong>Track vessel</strong> </div>
  <div class="col-12 py-2 d-flex justify-content-center "></div> 

  <div class="row no-gutters headrow border-bottom">
  <div class="col-12 mt-1 mb-1 text-white pl-2 formfont">Owner details</div> 
  </div> 

  <div class="row no-gutters oddrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Owner name</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $owner_name; ?></div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Owner address</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $owner_address;?> </div> 
  </div> 
  <div class="row no-gutters evenrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Owner mobile number</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $owner_phone; ?></div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Owner email</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $owner_email;?> </div> 
  </div> 

  <div class="row no-gutters headrow border-bottom">
  <div class="col-12 mt-1 mb-1 text-white pl-2 formfont">Vessel details</div> 
  </div> 
 
  <div class="row no-gutters oddrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Vessel name</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $vessel_name; ?></div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Reference number</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php  echo $reference_number; ?> </div> 
  </div> 

  <div class="row no-gutters evenrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Vessel category</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $vessel_category_name; ?></div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Vessel sub category</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $vessel_subcategory_name;  ?> </div> 
  </div>

  <div class="row no-gutters oddrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Vessel type</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $vesseltype_name; ?></div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Vessel sub type</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $vessel_subtype_name;  ?> </div> 
  </div> 

  <div class="row no-gutters evenrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Area of operation</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $operation_area; ?></div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Nature of operation</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php if(!empty($cargo_nature)) { echo $cargo_nature; } else { echo ""; }  ?> </div> 
  </div> 

  <div class="row no-gutters oddrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">Port of registry</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $portofregistry_name; ?></div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Year of built</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
  <?php echo $vessel_yearofbuilt;  ?> </div> 
  </div> 

  <div class="row no-gutters evenrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  Survey certificate number</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
  <?php echo $vessel_survey_number; ?>  </div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Survey certificate date </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
  <?php echo $actual_date; ?> </div> 
  </div>

  <div class="row no-gutters oddrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  Registration number</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
  <?php if(!empty($vessel_registration_number)) { echo $vessel_registration_number; } else { echo "To be registered"; }  ?>  </div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Registration date </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
  <?php echo $vesselmain_reg_date; ?> </div> 
  </div>

  <div class="row no-gutters headrow text-white border-bottom">
  <div class="col-12 d-flex justify-content-left mt-1 mb-1 text-white formfont">
  Extreme inner dimension of the vessel</div> 
  </div>
  <div class="row no-gutters evenrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  </div><div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">Length</div>
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Breadth</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Depth</div> 
  </div> 
  <div class="row no-gutters oddrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">

  </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"><?php echo $vessel_length; ?> m</div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont"> <?php echo $vessel_breadth; ?> m </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary border-left border-primary pl-1 formfont" > <?php echo $vessel_depth; ?> m</div> 
  </div> 

  <div class="row no-gutters evenrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  Gross registered tonnage </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
  <?php echo $vessel_gross_tonnage; ?> Ton </div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Net registered tonnage </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
  <?php echo $vessel_net_tonnage; ?> Ton</div> 
  </div>

  <div class="row no-gutters headrow border-bottom">
  <div class="col-12 mt-1 mb-1 text-white pl-2 formfont">Date specification</div> 
  </div> 

  <div class="row no-gutters oddrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  Last annual survey date</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
  <?php echo $vesselmain_annual_date; ?>  </div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Next annual survey date </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
  <?php echo $next_annual_date; ?> </div> 
  </div>

  <div class="row no-gutters evenrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  Last drydock survey date</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
  <?php echo $vesselmain_drydock_date; ?>  </div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  Next drydock survey date </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
  <?php echo $next_drydock_date; ?> </div> 
  </div>

  <div class="row no-gutters oddrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  Next renewal date</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
  <?php echo $next_reg_renewal_date; ?>  </div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  PCB expiry date </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
  <?php echo $validity_of_pcb; ?> </div> 
  </div>

  <div class="row no-gutters evenrow border-bottom">
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
  Insurance expiry date</div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary formfont"> 
  <?php echo $validity_of_insurance; ?>  </div> 
  <div class="col-2 d-flex justify-content-left mt-1 mb-1 text-dark border-left border-primary pl-1 formfont">
  &nbsp; </div> 
  <div class="col-4 d-flex justify-content-left mt-1 mb-1 text-primary  formfont" >
  <?php //echo $actual_date; ?> </div> 
  </div>
<?php 
if(!empty($namechg_dt))
{ 
?>
  <div class="row no-gutters headrow border-bottom">
  <div class="col-12 mt-1 mb-1 text-white pl-2 formfont">Name Change of vessel</div> 
  </div> 
 <div class="row no-gutters oddrow border-bottom">
   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabletbox">
  <tr>
    <td align="center"><strong>Old Name of Vessel</strong></td>
    <td align="center"><strong>Reg Date</strong></td>
    <td align="center"><strong>New Name of Vessel</strong></td>
    <td align="center"><strong>Approved Date</strong></td>
  </tr>
<?php 
 
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

?>
 </table>
 </div>
<?php
}
?>

<?php 
if(!empty($ownerchg_dt))
{ 
?>
  <div class="row no-gutters headrow border-bottom">
  <div class="col-12 mt-1 mb-1 text-white pl-2 formfont">Ownership Change of vessel</div> 
  </div> 
 <div class="row no-gutters oddrow border-bottom">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabletbox">
  <tr>
    <td align="center"><strong>Old Owner of Vessel</strong></td>
    <td align="center"><strong>New Owner of Vessel</strong></td>
    <td align="center"><strong>Reg Date</strong></td>
    <td align="center"><strong>Approved Date</strong></td>
  </tr>
<?php 
// print_r($ownerchg_dt);
//exit;
foreach($ownerchg_dt as $owndet)
{
  $transfer_seller_id  =   $owndet['transfer_seller_id'];
  $trans_seller        =   $this->Vessel_change_model->get_owner($transfer_seller_id);
  if(!empty($trans_seller))
  {
    foreach($trans_seller as $sell_res)
    {
      $seller            =   $sell_res['user_name'];
    }
  }
  else
  {
    $seller            ="";
  }
 
  $transfer_buyer_id   =   $owndet['transfer_buyer_id'];
  $trans_buyer         =   $this->Vessel_change_model->get_owner($transfer_buyer_id);
  
  if(!empty($trans_buyer))
  {
    foreach($trans_buyer as $buy_res)
    {
      $buyer             =   $buy_res['user_name'];
    }
  }
  else
  {
     $buyer             ="";
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
?>
 </table>
 </div>
<?php 
}
?>
 
<?php 
if(!empty($transfrvsl_dt))
{ 
?>
  <div class="row no-gutters headrow border-bottom">
  <div class="col-12 mt-1 mb-1 text-white pl-2 formfont">Transfer of vessel</div> 
  </div> 
 <div class="row no-gutters oddrow border-bottom">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabletbox">
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
?>
 </table>
 </div>
<?php 
}
?>

<?php 
if(!empty($dupcert_dt))
{ 
?>
  <div class="row no-gutters headrow border-bottom">
  <div class="col-12 mt-1 mb-1 text-white pl-2 formfont">Duplicate Certificate</div> 
  </div> 
 <div class="row no-gutters oddrow border-bottom">
   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabletbox">
   <tr>
    <td align="center"><strong>Duplicate Certificate Type</strong></td>
    <td align="center"><strong>Issue Date</strong></td>
  </tr>
  <?php 
  
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
?>
 </table>
 </div>
<?php
}
?>
<?php 
if(!empty($renewal_dt))
{ 
?>
  <div class="row no-gutters headrow border-bottom">
  <div class="col-12 mt-1 mb-1 text-white pl-2 formfont">Renewal of registration</div> 
  </div> 
 <div class="row no-gutters oddrow border-bottom">
   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabletbox">
  <tr>
    <td align="center"><strong>Reference number</strong></td>
     <td align="center"><strong>Renewal request date</strong></td>
    <td align="center"><strong>Approved date</strong></td>
  </tr>
<?php 
foreach($renewal_dt as $renewal)
{
  $ref_number = $renewal['ref_number'];
  $registration_renewal_req_date  =date("d/m/Y", strtotime($renewal['registration_renewal_req_date']));
  $registration_renewal_approve_date =date("d/m/Y", strtotime($renewal['registration_renewal_approve_date']));
?>
 <tr>
    <td align="center"><?php echo $ref_number;?></td>
    <td align="center"><?php echo $registration_renewal_req_date;?></td>
    <td align="center"><?php echo $registration_renewal_approve_date;?></td>
  </tr>
<?php 
} 
?>
 </table>
 </div>
<?php
}
?>
  <!-- </form> --> <?php echo form_close(); ?>
  </div>
  </div>
  <?php 
} 
?>
</div> <!-- end of innerpage div -->