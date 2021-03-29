<?php  

$moduleid        = 2;
$modenc          = $this->encrypt->encode($moduleid); 
$modidenc        = str_replace(array('+', '/', '='), array('-', '_', '~'), $modenc);

/*_____________________Decoding Start___________________*/
$vessel_id1                         = $this->uri->segment(4);
$processflow_sl1                    = $this->uri->segment(5);
$survey_id1                         = $this->uri->segment(6);

$vessel_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id                          = $this->encrypt->decode($vessel_id); 

$processflow_sl                     = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl                     = $this->encrypt->decode($processflow_sl); 

$survey_id                          = str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id                          = $this->encrypt->decode($survey_id); 
/*_____________________Decoding End___________________*/

$survey_type                        = $this->Survey_model->get_survey_type($survey_id);
$data['survey_type']                =   $survey_type;
if(!empty($survey_type))
{
  $survey_name                      = $survey_type[0]['survey_name'];
}
else
{
  $survey_name="";
}
$current_status1                    = $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']            = $current_status1;
if(!empty($current_status1))
{
  $status_details_sl                = $current_status1[0]['status_details_sl'];
}

 //----------- Vessel Details -----------//
if(!empty($vessel_details_viewpage)) {
  foreach($vessel_details_viewpage as $res_vessel)
  {
    $vessel_name                    = $res_vessel['vessel_name'];
    $vessel_length                  = $res_vessel['vessel_length'];
    $vessel_breadth                 = $res_vessel['vessel_breadth'];
    $vessel_depth                   = $res_vessel['vessel_depth'];
    $vessel_expected_tonnage        = $res_vessel['vessel_expected_tonnage'];
    
    $vessel_category_id             = $res_vessel['vessel_category_id'];
    $vessel_subcategory_id          = $res_vessel['vessel_subcategory_id'];
    $vessel_type_id                 = $res_vessel['vessel_type_id'];
    $vessel_subtype_id              = $res_vessel['vessel_subtype_id'];
    $sewage_treatment               = $res_vessel['sewage_treatment'];
    $vessel_registration_number     = $res_vessel['vessel_registration_number'];   
      
    $vessel_id                      = $res_vessel['vessel_sl'];
    $user_id                        = $res_vessel['user_id'];

    $user_type_details              = $this->Survey_model->get_user_type_id($user_id);
    $data['user_type_details']      = $user_type_details;
    $user_type_id                   = $user_type_details[0]['user_master_id_user_type'];
    $length_overall                 = $res_vessel['vessel_length_overall'];
    $vessel_total_tonnage           = $res_vessel['vessel_total_tonnage'];
    
    if($vessel_category_id!=0)
    {
      $vessel_category_id           = $this->Survey_model->get_vessel_category_id($vessel_category_id);
      $data['vessel_category_id']   = $vessel_category_id;
      $vessel_category_name         = $vessel_category_id[0]['vesselcategory_name'];
    }
    else
    {
      $vessel_category_name         = '-';
    }
    if($vessel_category_id!=0)
    {
      $vessel_subcategory_id        =   $this->Survey_model->get_vessel_subcategory_id($vessel_subcategory_id);
      $data['vessel_subcategory_id']= $vessel_subcategory_id;
      @$vessel_subcategory_name     = $vessel_subcategory_id[0]['vessel_subcategory_name'];
    }
    else
    {
      $vessel_subcategory_name      = '-';
    }
    if($vessel_type_id!=0)
    {
      $vessel_type_id               =   $this->Survey_model->get_vessel_type_id($vessel_type_id);
      $data['vessel_type_id']       = $vessel_type_id;
      $vesseltype_name              = $vessel_type_id[0]['vesseltype_name'];
    }
    else
    {
      $vesseltype_name              = '-';
    }
      
    if($vessel_subtype_id!=0)
    {
      $vessel_subtype_id            = $this->Survey_model->get_vessel_subtype_id($vessel_subtype_id);
      $data['vessel_subtype_id']    = $vessel_subtype_id;
      $vessel_subtype_name          = $vessel_subtype_id[0]['vessel_subtype_name'];
    }
    else
    {
      $vessel_subtype_name          = '-';
    }



  }

}
if(!empty($customer_details)) 
{
  foreach($customer_details as $res_owner)
  {
    $owner_name                     = $res_owner['user_name'];
    $owner_address                  = $res_owner['user_address'];
    $user_mobile_number             = $res_owner['user_mobile_number'];
    $user_email                     = $res_owner['user_email'];
  }
}

if(!empty($payment_details))
{
  //print_r($payment_details);

  $payment_sl                       = $payment_details[0]['payment_sl'];
  $paymenttype_id                   = $payment_details[0]['paymenttype_id'];
  $dd_amount                        = $payment_details[0]['dd_amount'];
  $dd_date                          = date('d-m-Y',strtotime($payment_details[0]['dd_date']));
  $bank_id                          = $payment_details[0]['bank_id'];
  $branch_name                      = $payment_details[0]['branch_name'];

  $payment_mode     = $payment_details[0]['payment_mode'];
  $transaction_id   = $payment_details[0]['transaction_id'];
  $get_bank_name    = $this->Vessel_change_model->get_bank_generated_last_number($bank_id);
  foreach ($get_bank_name as $bank_res) {
    $bank_name      = $bank_res['bank_name'];
  }

}
if(!empty($transfervsl_details))
{ //print_r($transfervsl_details);
  foreach($transfervsl_details as $res_tsfrvsl)
  {
    $transfer_based_changetype      = $res_tsfrvsl['transfer_based_changetype'];
    $transfer_statetype             = $res_tsfrvsl['transfer_state_id'];
    $transfer_state                 = $this->Vessel_change_model->get_state($transfer_statetype);
    if(!empty($transfer_state)){
      foreach($transfer_state as $res_state){
        $state_nm                   = $res_state['state_name'];
      }
    }
    $transfer_portofregistry_from   = $res_tsfrvsl['transfer_portofregistry_from'];
    $transfer_portofregistry_fm     = $this->Vessel_change_model->get_registry_port_id($transfer_portofregistry_from);
    if(!empty($transfer_portofregistry_fm)){
      foreach($transfer_portofregistry_fm as $port_fm){
        $port_fm                    = $port_fm['vchr_portoffice_name'];
      }
    }
    $transfer_portofregistry_to     = $res_tsfrvsl['transfer_portofregistry_to'];
    $transfer_portofregistry_tto    = $this->Vessel_change_model->get_registry_port_id($transfer_portofregistry_to);
    if(!empty($transfer_portofregistry_tto)){
      foreach($transfer_portofregistry_tto as $port_to){
        $port_to                    = $port_to['vchr_portoffice_name'];
      }
    }
    $transfer_buyer_id              = $res_tsfrvsl['transfer_buyer_id'];
    if(!empty($transfer_buyer_id)){ //echo $transfer_buyer_id;
      $cust_details                 = $this->Vessel_change_model->get_customer_details($transfer_buyer_id); //print_r($cust_details);
      //$data['cust_details']   = $cust_details;
      foreach($cust_details as $res_cust)
      {
        $transfer_buyer_name        = $res_cust['user_name'];
        $transfer_buyer_address     = $res_cust['user_address'];
        $transfer_buyer_mobile      = $res_cust['user_mobile_number'];
        $transfer_buyer_email_id    = $res_cust['user_email'];
      }
    } else {
      $transfer_buyer_name          = $res_tsfrvsl['transfer_buyer_name'];
      $transfer_buyer_address       = $res_tsfrvsl['transfer_buyer_address'];
      $transfer_buyer_mobile        = $res_tsfrvsl['transfer_buyer_mobile'];
      $transfer_buyer_email_id      = $res_tsfrvsl['transfer_buyer_email_id'];
    }
  }
}
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
  
 

//-----Jquery End----//
});

</script>
<script type="text/javascript">
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
</script>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/pcHome/<?php echo $modidenc;?>"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1"> 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary "><i class="fab fa-wpforms"></i>&nbsp;  </button></div>
<div class="col-6 d-flex justify-content-end">
<button class="btn-sm btn-flat btn btn-outline-success " id="printform">&nbsp; Payment </button>
</div> <!-- end of button col -->
<div class="col-12" id="form1view-print"> </div>
</div> <!-- end of row -->
<div class="row h-100 justify-content-center mt-3">

<div class="col-12 " id="form1view">
<!-- ########################################################################################### -->
 <!-- inside content -->


<form name="form18_payment" id="form18_payment" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/Verify_payment_pc_form18_trans/'.$vessel_id.'/'.$processflow_sl.'/'.$survey_id ?>">

<!-- ____________________________ Payment Process ____________________________ -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Owner details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



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
Transfer details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->
<?php if($transfer_based_changetype==1){
?>
<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Present Port of Registry
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $port_fm; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
New Port of Registry
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $port_to; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<?php
} elseif ($transfer_based_changetype==3) {
?>
<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Present Port of Registry
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $port_fm; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
New Port of Registry
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $port_to; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Buyer name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $transfer_buyer_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Address
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $transfer_buyer_address; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Phone number
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $transfer_buyer_mobile; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Email
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $transfer_buyer_email_id; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<?php
} elseif ($transfer_based_changetype==0) {
?>
<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
State
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $state_nm; ?>
</div> <!-- end of col-3 2nd-->
</div> <!-- end of row -->
<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Buyer name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $transfer_buyer_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Address
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $transfer_buyer_address; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Phone number
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $transfer_buyer_mobile; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Email
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $transfer_buyer_email_id; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->
<?php
}
?>





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
Survey Type
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php if(isset($survey_name)){echo $survey_name;  }?>
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
Vessel Registration Number
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $vessel_registration_number; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Payment details
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Transaction mode
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $payment_mode; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Transaction Id
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $transaction_id; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Amount remitted
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $dd_amount; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Payment date
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $dd_date; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Bank name
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<?php echo $bank_name; ?>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Branch
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<?php echo $branch_name; ?>
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Remarks
</div> <!-- end of col-3 1st-->
<div class="col-9 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <textarea name="remarks" id="remarks" cols="50" rows="3" onkeypress="return IsAddress(event);">Verified</textarea>
</div> <!-- end of col-3 2nd-->

</div> <!-- end of row -->



<div class="row no-gutters oddrow border-bottom" >

<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $user_type_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">

<input type="hidden" name="payment_sl" id="payment_sl" value="<?php echo $payment_sl; ?>">
<!-- <input type="hidden" name="current_position" id="current_position" value="<?php echo $user_type_id_cs_sr; ?>"> -->
<!-- <input type="hidden" name="user_sl_cs" id="user_sl_cs" value="<?php echo $user_sl_cs_sr; ?>"> -->
 <input type="hidden" name="current_status_id" id="current_status_id" value="2">

<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">

</div> <!-- end of col-3 1st-->

<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Approve">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->





</form>
<!-- end of inside content -->
<!-- ########################################################################################### -->
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->

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