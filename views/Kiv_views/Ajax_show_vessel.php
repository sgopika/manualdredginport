<?php
 //----------- Vessel Details -----------//

if(!empty($vessel_details)) {
  $vessel_sl=$vessel_details[0]['vessel_sl'];
}



$vessel_details_viewpage          =   $this->Survey_model->get_vessel_details_viewpage($vessel_sl);
$data['vessel_details_viewpage']  =  $vessel_details_viewpage;

if(!empty($vessel_details_viewpage)) {
  //print_r($vessel_details_viewpage);
foreach($vessel_details_viewpage as $res_vessel)
{
  $vessel_name            = $res_vessel['vessel_name'];
  $vessel_length          = $res_vessel['vessel_length'];
  $vessel_breadth         = $res_vessel['vessel_breadth'];
  $vessel_depth           = $res_vessel['vessel_depth'];
  $vessel_expected_tonnage= $res_vessel['vessel_expected_tonnage'];
  $vessel_registration_number= $res_vessel['vessel_registration_number'];
  
  $vessel_category_id     = $res_vessel['vessel_category_id'];
  $vessel_subcategory_id  = $res_vessel['vessel_subcategory_id'];
  $vessel_type_id         = $res_vessel['vessel_type_id'];
  $vessel_subtype_id      = $res_vessel['vessel_subtype_id'];
  $sewage_treatment       = $res_vessel['sewage_treatment'];
     
    
    $vessel_id            = $res_vessel['vessel_sl'];
   // $user_id              = $res_vessel['vessel_created_user_id'];
    $user_id              = $res_vessel['user_id'];

  $user_type_details          = $this->Survey_model->get_user_type_id($user_id);
  $data['user_type_details']  = $user_type_details;
  $user_type_id               = $user_type_details[0]['user_type_id'];
  $length_overall             = $res_vessel['vessel_length_overall'];
  $vessel_total_tonnage       = $res_vessel['vessel_total_tonnage'];
  
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
  else
  {
    $vessel_subcategory_name='-';
  }
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

}

 $customer_details       = $this->Survey_model->get_customer_details($user_id);
    $data['customer_details'] = $customer_details;
    if(!empty($customer_details)) 
{
  foreach($customer_details as $res_owner)
  {
    $owner_name         = $res_owner['user_name'];
    $owner_address      = $res_owner['user_address'];
    $user_mobile_number = $res_owner['user_mobile_number'];
    $user_email         = $res_owner['user_email'];
  }
}

$status_details=$this->Survey_model->get_status_details_vessel_sl($vessel_sl);
$data['status_details']=$status_details;
if(!empty($status_details))
{
  $status_details_sl=$status_details[0]['status_details_sl'];
  $receiving_user_id=$status_details[0]['receiving_user_id'];

  $processflow=$this->Survey_model->get_processflow_vessel_sl($vessel_sl,$receiving_user_id);
  $data['processflow']=$processflow;
 if(!empty($processflow))
{
  $processflow_sl=$processflow[0]['processflow_sl'];
  $current_position=$processflow[0]['current_position'];
}


}



 ?>

<div class="row h-100 justify-content-center mt-3">

<div class="col-12 " id="form1view">
<!-- ########################################################################################### -->
 <!-- inside content -->


<form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/initiate_specialsurvey/'?>">
<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Owner details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="28">
<input type="hidden" name="survey_id" id="survey_id" value="4">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $user_type_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl;?>">

<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Owner name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $owner_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Address
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $owner_address; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Phone number
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $user_mobile_number; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Email
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $user_email; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Vessel details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <?php echo $vessel_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Registration number
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $vessel_registration_number;  ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel category
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vessel_category_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Vessel sub category
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $vessel_subcategory_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel type
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vesseltype_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Vessel sub type
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $vessel_subtype_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Vessel Tonnage
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $vessel_total_tonnage; ?> Ton
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
&nbsp;
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
&nbsp;
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Remarks
</div> <!-- end of col-3 1st-->
<div class="col-9 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <textarea name="remarks" id="remarks" cols="70" rows="4" required=""></textarea>
</div> <!-- end of col-3 2nd-->

</div> <!-- end of row -->


<div class="col-12 d-flex justify-content-center mt-1 mb-1 text-primary formfont">
<input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Initiate Special Survey">
</div> <!-- end of row -->

</form>
</div>
</div>
