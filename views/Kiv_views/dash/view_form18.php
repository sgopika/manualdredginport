<?php 
/*$sess_usr_id        = $this->session->userdata('user_sl');
$user_type_id       = $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
       $user_type_id =   $this->session->userdata('int_usertype');


/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$status_details_sl1 = $this->uri->segment(6);

$vessel_id          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id          = $this->encrypt->decode($vessel_id); 

$processflow_sl     = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl     = $this->encrypt->decode($processflow_sl); 

$status_details_sl  = str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl  = $this->encrypt->decode($status_details_sl); 
/*_____________________Decoding End___________________*/
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

<?php 

if(!empty($registration_intimation))
{
  //print_r($registration_intimation);
  foreach ($registration_intimation as $key ) 
  {
    $date                           = date("d-m-Y", strtotime($key['registration_inspection_date']));
    $survey_number                  = $key['vessel_survey_number'];
    $vessel_registration_number     = $key['vessel_registration_number'];
    $vesselmain_reg_number          = $key['vesselmain_reg_number'];
    $remarks                        = $key['registration_intimation_remark'];
    $vessel_name                    = $key['vessel_name'];
    $category                       = $key['category'];
    $reference_number               = $key['reference_number'];
    $official_number                = $key['official_number'];
    $owner_name                     = $key['user_name'];
    $owner_address                  = $key['user_address'];
    $vessel_registry_port_id        = $key['registration_intimation_place_id'];
    $registration_intimation_sl     = $key['registration_intimation_sl'];
    $vessel_created_timestamp       = $key['vessel_created_timestamp'];
    $registry_port_id               = $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
    $data['registry_port_id']       = $registry_port_id;
   
    if(!empty($registry_port_id))
    {
      $registry_name=$registry_port_id[0]['vchr_portoffice_name'];
    }
    else
    {
      $registry_name="";
    }
  }
}
else
{
  //echo "No data";
  //exit;
  $this->load->model('Kiv_models/Vessel_change_model');
  $registration_intimation          = $this->Vessel_change_model->get_vesselownerchange_details_ra($vessel_id);
  $data['registration_intimation']  = $registration_intimation; //print_r($registration_intimation);
   
  foreach ($registration_intimation as $key ) 
  {
    if(!empty($key['registration_inspection_date'])){
      $date                         = date("d-m-Y", strtotime($key['registration_inspection_date']));
    }
    $survey_number                  = $key['vessel_survey_number'];
    $vessel_registration_number     = $key['vessel_registration_number'];
    $vesselmain_reg_number          = $key['vesselmain_reg_number'];  
    if(!empty($key['registration_intimation_remark'])){  
      $remarks                      = $key['registration_intimation_remark'];
    }
    $vessel_name                    = $key['vesselmain_vessel_name'];
    $category                       = $key['category'];
    $reference_number               = $key['reference_number'];
    $official_number                = $key['official_number'];
    $owner_name                     = $key['user_name'];
    if(!empty($key['user_address'])){  
      $owner_address                = $key['user_address'];
    }
      $vessel_created_timestamp     = $key['vessel_created_timestamp'];
    
  }

  $id                               = $registration_intimation[0]['vesselmain_owner_id'];

  $customer_details                 = $this->Vessel_change_model->get_customer_details($id);
  $data['customer_details']         = $customer_details;//print_r($customer_details);
  if(!empty($customer_details)) 
  {
    foreach($customer_details as $res_owner)
    {
      $owner_name                   = $res_owner['user_name'];
      $owner_address                = $res_owner['user_address'];
      $user_mobile_number           = $res_owner['user_mobile_number'];
      $user_email                   = $res_owner['user_email'];
    }
  }
  
}
if(!empty($initial_data))
{ //print_r($initial_data);
  $process_id                       = $initial_data[0]['process_id'];
  $survey_id                        = $initial_data[0]['survey_id'];
  $user_id                          = $initial_data[0]['user_id'];
  $process_id                       = $initial_data[0]['process_id'];
  $current_position                 = $initial_data[0]['current_position'];
  $user_sl_ra                       = $initial_data[0]['curruser'];
  $user_id_owner                    = $initial_data[0]['uid'];

  $user_type_details                = $this->Vessel_change_model->get_user_type_id($user_id_owner);
  $data['user_type_details']        = $user_type_details;
  $user_type_id_owner               = $user_type_details[0]['user_master_id_user_type'];
}


if(!empty($payment_det)){
  $dd_amount                        = $payment_det[0]['dd_amount'];
}
if(!empty($ownershipchange_det)){
  foreach($ownershipchange_det as $res_owner)
  {
    
    $transfer_buyer_id              = $res_owner['transfer_buyer_id'];
    if(!empty($transfer_buyer_id)){
      $cust_details                 = $this->Vessel_change_model->get_customer_details($transfer_buyer_id); //print_r($cust_details); 
      $transfer_verify_id           = $res_owner['transfer_verify_id'];
      $transfer_pc_verified_date    = date("d-m-Y", strtotime($res_owner['transfer_pc_verified_date']));
      $transfer_payment_date        = date("d-m-Y", strtotime($res_owner['transfer_payment_date']));
      foreach($cust_details as $res_cust)
      {
        $transfer_buyer_usertyp     = $res_cust['user_master_id_user_type'];
        $transfer_buyer_name        = $res_cust['user_name'];
        $transfer_buyer_address     = $res_cust['user_address'];
        $transfer_buyer_mobile      = $res_cust['user_mobile_number'];
        $transfer_buyer_email_id    = $res_cust['user_email'];
       
      }
    } else {
      $transfer_buyer_usertyp       = 0;
      $transfer_buyer_name          = $res_owner['transfer_buyer_name'];
      $transfer_buyer_address       = $res_owner['transfer_buyer_address'];
      $transfer_buyer_mobile        = $res_owner['transfer_buyer_mobile'];
      $transfer_buyer_email_id      = $res_owner['transfer_buyer_email_id'];
      $transfer_verify_id           = $res_owner['transfer_verify_id'];
      $transfer_pc_verified_date    = date("d-m-Y", strtotime($res_owner['transfer_pc_verified_date']));
      $transfer_payment_date        = date("d-m-Y", strtotime($res_owner['transfer_payment_date']));
    }
  }

  $verified_usertype                = $this->Vessel_change_model->get_user_master($transfer_verify_id);
  $data['verified_usertype']        = $verified_usertype; //print_r($verified_usertype);
  $verified_usertype                = $verified_usertype[0]['user_type_type_name'];
}
$survey=0;
$process=39;
$status=1;
$ownership_intimation               = $this->Vessel_change_model->get_ownerchange_intimation_det($vessel_id,$survey,$process,$status);
$data['ownership_intimation']       = $ownership_intimation; //print_r($ownership_intimation);
if(!empty($ownership_intimation)){
  foreach($ownership_intimation as $res_ownintim){
    $intimation_place               = $res_ownintim['registration_intimation_place_id'];
    $intimation_date                = $res_ownintim['registration_inspection_date'];
  }

}
?>

 


<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
  <?php if($user_type_id==14) /// After integration Registering Authority New user_type_id=14?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>

    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
  <div class="row ui-innerpage" >
    <div class="col-12">
      <div class="container letterform mb-4">
        <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/VesselChange/ownerchange_intimation_send/'.$vessel_id.'/'.$processflow_sl.'/'.$status_details_sl ?>" enctype="multipart/form-data">
<!-- <form name="form1" action="<?php //echo site_url('VesselChange/namechange_intimation_send/')?>" method="POST" enctype="multipart/form-data" id="form1"> -->

          <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
          <input type="hidden" name="vessel_name" id="vessel_name" value="<?php echo $vessel_name; ?>">
          <input type="hidden" name="transfer_buyer_name" id="transfer_buyer_name" value="<?php echo $transfer_buyer_name; ?>">
          <input type="hidden" name="transfer_buyer_address" id="transfer_buyer_address" value="<?php echo $transfer_buyer_address; ?>">
          <input type="hidden" name="transfer_buyer_mobile" id="transfer_buyer_mobile" value="<?php echo $transfer_buyer_mobile; ?>">
          <input type="hidden" name="transfer_buyer_email_id" id="transfer_buyer_email_id" value="<?php echo $transfer_buyer_email_id; ?>">
          <input type="hidden" name="transfer_buyer_id" id="transfer_buyer_id" value="<?php echo $transfer_buyer_id; ?>">
          <input type="hidden" name="transfer_buyer_usertyp" id="transfer_buyer_usertyp" value="<?php echo $transfer_buyer_usertyp; ?>">
          <input type="hidden" name="registered_date" id="registered_date" value="<?php echo $vessel_created_timestamp; ?>">
          <input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
          <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
          <input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
          <input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
          <input type="hidden" name="current_position" id="current_position" value="<?php echo $current_position; ?>">
          <input type="hidden" name="user_sl_ra" id="user_sl_ra" value="<?php echo $user_sl_ra; ?>">
          <input type="hidden" name="registration_intimation_sl" id="registration_intimation_sl" value="<?php //echo $registration_intimation_sl; ?>">
          <input type="hidden" name="user_id_owner" id="user_id_owner" value="<?php echo $user_id_owner; ?>">
          <input type="hidden" name="user_type_id_owner" id="user_type_id_owner" value="<?php echo $user_type_id_owner; ?>"> 
          <input type="hidden" name="current_status_id" id="current_status_id" value="7"> 

          <div class="row no-gutters">
            <div class="col-12 d-flex justify-content-center text-primary">&nbsp; Form --</div>
            <div class="col-12 d-flex justify-content-center text-primary"> <u> APPLICATION FOR CHANGE OF OWNERSHIP OF THE VESSEL </u></div>
          </div>

          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary"> Survey number</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $survey_number; ?></div>
            <div class="col-3 pl-2 text-primary"> Registration Number</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $vesselmain_reg_number;?></div>
          </div> <!-- end of row -->
          <div class="row evenrow py-2">
            <div class="col-3 pl-2 text-primary"> Owner Name</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $owner_name ; ?></div>
            <div class="col-3 pl-2 text-primary"> Vessel Name </div>
            <div class="col-3 px-2 text-secondary"> <?php echo $vessel_name ; ?></div>
          </div> <!-- end of row -->
          <div class="row oddrow py-2">
            <div class="col-6 pl-2 text-primary"> Address</div>
            <div class="col-6 px-2 text-secondary"> <?php echo $owner_address; ?></div>
          </div>
          <div class="row evenrow py-2">
            <div class="col-3 pl-2 text-primary"> Buyer Name</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $transfer_buyer_name; ?></div>
            <div class="col-3 pl-2 text-primary"> Buyer Address </div>
            <div class="col-3 px-2 text-secondary"> <?php echo $transfer_buyer_address ; ?></div>
          </div>
          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary"> Tariff Amount</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $dd_amount; ?></div>
            <div class="col-3 pl-2 text-primary"> Payment Date </div>
            <div class="col-3 px-2 text-secondary"> <?php echo $transfer_payment_date ; ?></div>
          </div>
          <div class="row evenrow py-2">
            <div class="col-3 pl-2 text-primary"> Verified by</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $verified_usertype; ?></div>
            <div class="col-3 pl-2 text-primary"> Verified Date </div>
            <div class="col-3 px-2 text-secondary"> <?php echo $transfer_pc_verified_date ; ?></div>
          </div>
          <div class="row py-2 px-2">
            <div class="col-12 d-flex justify-content-center">
              <?php if($category==1){?>
              <a class="btn btn-flat btn-sm btn-info" href="<?php echo site_url(); ?>/Kiv_Ctrl/Survey/form9_certificate/<?php echo $vessel_id; ?>" target="_blank" width="30" height="30">Certificate of Survey<i class="fas fa-file-pdf h4"></i> </a> &nbsp;
              <?php }?>
               <?php if($category==2){?>
              <a class="btn btn-flat btn-sm btn-info" href="<?php echo site_url(); ?>/Kiv_Ctrl/Survey/form10_certificate/<?php echo $vessel_id; ?>" target="_blank" width="30" height="30">Certificate of Survey<i class="fas fa-file-pdf h4"></i> </a> &nbsp;
              <?php }?>
              <input class="btn btn-flat btn-sm btn-success" type="button" name="approve" id="approve" value="Approve and generate certificate"> &nbsp;
              <input class="btn btn-flat btn-sm btn-primary" type="button" name="revert" id= "revert" value="Resend registration intimation to owner">  &nbsp;
              <input class="btn btn-flat btn-sm btn-secondary" type="button" name="reset" id= "reset" value="Reset"> &nbsp;
              <a class="btn btn-flat btn-sm btn-info" href="<?php echo site_url(); ?>/Kiv_Ctrl/VesselChange/form18_certificate/<?php echo $vessel_id1; ?>" target="_blank" width="30" height="30">Form --<i class="fas fa-file-pdf h4"></i> </a> 
            </div> 
          </div>

          <div id="new_intimation" style="display: none;">

            <div class="row no-gutters oddrow border-bottom">
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
              Date of inspection
              </div> 

              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
                <input type="date" class="form-control dob" id="change_inspection_date" name="change_inspection_date" placeholder="Inspection Date" data-validation="required" value="<?php if(isset($intimation_date)){ echo $intimation_date;}?>">
              </div> 
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
              Place of inspection <?php //print_r($plyingPort);?>
              </div> 
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
              <select class="form-control select2" name="portofregistry_sl" id="portofregistry_sl" title="Select  Plying Port of Registry" data-validation="required">
                    <option value="">Select</option>
                    <?php foreach ($plyingPort as $plyPort) { ?>
                      <option value="<?php echo $plyPort['int_portoffice_id']; ?>" <?php if(isset($intimation_place)){if($intimation_place==$plyPort['int_portoffice_id'] ){ echo "selected";}}?>><?php echo $plyPort['vchr_portoffice_name']; ?></option>
                    <?php } ?>
              </select>
            </div> 
            </div> 

            <div class="row no-gutters oddrow border-bottom">
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
              Remarks
              </div> 
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
                <textarea name="change_intimation_remark" id="change_intimation_remark" cols="50" rows="3" data-validation="required">Verified</textarea>
              </div> 
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
              Upload documents
              </div> 
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
                <input type="file" name="change_inspection_report_upload" id="change_inspection_report_upload" />
              </div> 
            </div> 

            <div class="col-3 d-flex justify-content-center mt-1 mb-1 text-primary formfont">
              <input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Submit">
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
              </div>
              <div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
              </div> 
            </div>

          </div>
          <div id="form14" style="display: none;">

            <div class="row evenrow py-2">
              <div class="col-3 pl-2 text-primary"> Status</div>
              <div class="col-3 px-2 text-secondary">  
                <select class="form-control select2"  name="approve_status" id="approve_status">
                <option value="5">Approve</option>
                <option value="3">Reject</option>
                </select>
              </div>
              <div class="col-3 pl-2 text-primary"> &nbsp;</div>
              <div class="col-3 px-2 text-secondary"> &nbsp;</div>
            </div> 

            <div class="row py-2 px-2">
              <div class="col-12 d-flex justify-content-center">
              <!-- <input class="btn btn-flat btn-sm btn-success" type="submit" name="btnsubmit" value="Generate certificate">  -->
                <input class="btn btn-flat btn-sm btn-success" type="button" name="generatecertificate" id="generatecertificate" value="Generate certificate and book of registration">
              &nbsp;
                <input class="btn btn-flat btn-sm btn-secondary" type="reset" name="btnreset" value="Reset"> 
              </div> 
            </div>
          </div>
        </form>

      </div> 
    </div> 
  </div> 
</div> 


<script language="javascript">
$(document).ready(function()
{
    $("#revert") .click(function()
    {
      $("#new_intimation").show();
      $("#form14").hide();
    });

    $("#reset") .click(function()
    {
      $("#new_intimation").hide();
      $("#form14").hide();
    });

    $("#approve") .click(function()
    {
      $("#new_intimation").hide();
      $("#form14").show();
    });


    $("#generatecertificate").click(function()
    { 
      var vessel_id1          = $("#vessel_id").val();
      var processflow_sl1     = $("#processflow_sl").val();
      var status_details_sl1  = $("#status_details_sl").val();
      var buyer_id            = $("#transfer_buyer_id").val(); 
      var vessel_id           = btoa(vessel_id1);
      var processflow_sl      = btoa(processflow_sl1);
      var status_details_sl   = btoa(status_details_sl1);
      
      if(buyer_id==0){ alert("Buyer is not a Registered User!!!");
      } else {

        $.ajax({ 
          url : "<?php echo site_url('Kiv_Ctrl/VesselChange/form_ownership_insertion')?>",
          type: "POST",
          data:$('#form1').serialize(),
          //dataType: "JSON",
          success: function(data)
          {//alert(data);exit;
            if(data==1)
            {
              alert("Successfully inserted");
              location.replace('<?php echo site_url('Kiv_Ctrl/VesselChange/generate_certificate_own')?>/'+vessel_id1+'/'+processflow_sl1+'/'+status_details_sl1);
            }
            if(data==0)
            {
                 alert("Failed");

            }
          }

        });

      }

    });




});


</script>
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

  function IsNumeric(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
        {
                return true;
        }
        else 
        {
                window.alert("This field accepts only Numbers");
                return false;
        }
        }


function IsDecimal(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58) || (unicode == 46 )) 
  {
      return true;
  }
  else 
  {
      window.alert("This field accepts only Numbers");
      return false;
  }
} 
function IsZero(id)
{
  var strvalue=document.getElementById(id).value; 
  if((strvalue==0))
  {
    alert("Invalid Number");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
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
 </script>