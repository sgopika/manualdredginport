<?php 
/*$sess_usr_id        = $this->session->userdata('user_sl');
$user_type_id       = $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
       $user_type_id =   $this->session->userdata('int_usertype');


/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);

$vessel_id          = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id          = $this->encrypt->decode($vessel_id); 


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

if(!empty($initimat_data))
{
  
  foreach ($initimat_data as $key ) 
  {
    $date                                 = date("d-m-Y", strtotime($key['registration_inspection_date']));
    $survey_number                        = $key['vessel_survey_number'];
    $vessel_registration_number           = $key['vessel_registration_number'];
    $registration_inspection_report_upload= $key['registration_inspection_report_upload'];
    $remarks                              = $key['registration_intimation_remark'];
    $vessel_name                          = $key['vessel_name'];
    $vessel_user_id                       = $key['vessel_user_id'];
    $category                             = $key['category'];
    $reference_number                     = $key['reference_number'];
    $official_number                      = $key['official_number'];
    @$owner_name                          = $key['user_name'];
    @$owner_address                       = $key['user_address'];
    $vessel_registry_port_id              = $key['registration_intimation_place_id'];
    $registration_intimation_sl           = $key['registration_intimation_sl'];


    $user_det                             = $this->Vessel_change_model->get_owner($vessel_user_id);
    $data['user_det']                     = $user_det;
    foreach ($user_det as $res) {
      $username                           = $res['user_name'];
    }

    $registry_port_id                     = $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
    $data['registry_port_id']             = $registry_port_id;
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
  echo "No data";
  exit;
  
}

if(!empty($vessel_change_det)){
  foreach($vessel_change_det as $res_owner)
  {
    $transfer_based_changetype          = $res_owner['transfer_based_changetype'];
    if($transfer_based_changetype==1){
      $transfer_portofregistry_from     = $res_owner['transfer_portofregistry_from'];
      $transfer_portofregistry_fm       = $this->Vessel_change_model->get_registry_port_id($transfer_portofregistry_from);
      if(!empty($transfer_portofregistry_fm)){
        foreach($transfer_portofregistry_fm as $port_fm){
          $port_fm                      = $port_fm['vchr_portoffice_name'];
        }
      }
      $transfer_portofregistry_to       = $res_owner['transfer_portofregistry_to'];
      $transfer_portofregistry_tto      = $this->Vessel_change_model->get_registry_port_id($transfer_portofregistry_to);
      if(!empty($transfer_portofregistry_tto)){
        foreach($transfer_portofregistry_tto as $port_to){
          $port_to                      = $port_to['vchr_portoffice_name'];
        }
      }
      $transfer_pc_verified_date        = date("d-m-Y", strtotime($res_owner['transfer_pc_verified_date']));
      $transfer_payment_date            = date("d-m-Y", strtotime($res_owner['transfer_payment_date']));
      $transfer_verify_id               = $res_owner['transfer_verify_id'];
      $transfer_buyer_name              = '';
      $transfer_buyer_address           = '';
      $transfer_buyer_mobile            = '';
      $transfer_buyer_email_id          = '';
      $transfer_buyer_id                = 0;
      $transfer_buyer_usertyp           = 0;
      $state_nm                         = 0;
    } elseif ($transfer_based_changetype==3) {
      $transfer_portofregistry_from     = $res_owner['transfer_portofregistry_from'];
      $state_nm                         = 0;
      $transfer_portofregistry_fm       = $this->Vessel_change_model->get_registry_port_id($transfer_portofregistry_from);
      if(!empty($transfer_portofregistry_fm)){
        foreach($transfer_portofregistry_fm as $port_fm){
          $port_fm                      = $port_fm['vchr_portoffice_name'];
        }
      }
      $transfer_portofregistry_to       = $res_owner['transfer_portofregistry_to'];
      $transfer_portofregistry_tto      = $this->Vessel_change_model->get_registry_port_id($transfer_portofregistry_to);
      if(!empty($transfer_portofregistry_tto)){
        foreach($transfer_portofregistry_tto as $port_to){
          $port_to                      = $port_to['vchr_portoffice_name'];
        }
      }
      $transfer_buyer_id                = $res_owner['transfer_buyer_id'];
      if(!empty($transfer_buyer_id)){
        $cust_details                   = $this->Vessel_change_model->get_customer_details($transfer_buyer_id); //print_r($cust_details);
        //$data['cust_details']   = $cust_details;
        foreach($cust_details as $res_cust)
        {
          $transfer_buyer_usertyp       = $res_cust['user_master_id_user_type'];
          $transfer_buyer_name          = $res_cust['user_name'];
          $transfer_buyer_address       = $res_cust['user_address'];
          $transfer_buyer_mobile        = $res_cust['user_mobile_number'];
          $transfer_buyer_email_id      = $res_cust['user_email'];
          $transfer_verify_id           = $res_owner['transfer_verify_id'];
          $transfer_pc_verified_date    = date("d-m-Y", strtotime($res_owner['transfer_pc_verified_date']));
          $transfer_payment_date        = date("d-m-Y", strtotime($res_owner['transfer_payment_date']));
        }
      } else {
        $transfer_buyer_usertyp         = 0;
        $transfer_buyer_name            = $res_owner['transfer_buyer_name'];
        $transfer_buyer_address         = $res_owner['transfer_buyer_address'];
        $transfer_buyer_mobile          = $res_owner['transfer_buyer_mobile'];
        $transfer_buyer_email_id        = $res_owner['transfer_buyer_email_id'];
        $transfer_verify_id             = $res_owner['transfer_verify_id'];
        $transfer_pc_verified_date      = date("d-m-Y", strtotime($res_owner['transfer_pc_verified_date']));
        $transfer_payment_date          = date("d-m-Y", strtotime($res_owner['transfer_payment_date']));
        $transfer_buyer_id              = 0;
      }
    } elseif ($transfer_based_changetype==0) {
      $transfer_portofregistry_from     = 0;
      $transfer_portofregistry_to       = 0;
      $transfer_statetype               = $res_owner['transfer_state_id'];
      $transfer_state                   = $this->Vessel_change_model->get_state($transfer_statetype);
      if(!empty($transfer_state)){
        foreach($transfer_state as $res_state){
          $state_nm                     = $res_state['state_name'];
        }
      }
      $transfer_buyer_id                = 0;
      $transfer_buyer_usertyp           = 0;
      $transfer_buyer_name              = $res_owner['transfer_buyer_name'];
      $transfer_buyer_address           = $res_owner['transfer_buyer_address'];
      $transfer_buyer_mobile            = $res_owner['transfer_buyer_mobile'];
      $transfer_buyer_email_id          = $res_owner['transfer_buyer_email_id'];
      $transfer_verify_id               = $res_owner['transfer_verify_id'];
      $transfer_pc_verified_date        = date("d-m-Y", strtotime($res_owner['transfer_pc_verified_date']));
      $transfer_payment_date            = date("d-m-Y", strtotime($res_owner['transfer_payment_date']));
    }
  }
}//print_r($vessel_change_det);
$verified_usertype                      = $this->Vessel_change_model->get_user_master($transfer_verify_id);
$data['verified_usertype']              = $verified_usertype; //print_r($verified_usertype);
$verified_usertype                      = $verified_usertype[0]['user_type_type_name'];
if(!empty($payment_det)){
  $dd_amount                            = $payment_det[0]['dd_amount'];
}
?>

 


<!-- Start of breadcrumb -->
<nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
  <?php if($user_type_id==14) /// After integration Registering Authority New user_type_id=14?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>

    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/VesselChange/transfervessel_req_list">List Page</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
  <div class="row ui-innerpage" >
    <div class="col-12">
      <div class="container letterform mb-4">
        <form name="form1" id="form1">
<!-- <form name="form1" action="<?php //echo site_url('VesselChange/namechange_intimation_send/')?>" method="POST" enctype="multipart/form-data" id="form1"> -->

          <div class="row no-gutters">
            <div class="col-12 d-flex justify-content-center text-primary">&nbsp; Form --</div>
            <div class="col-12 d-flex justify-content-center text-primary"> <u> INTIMATION FOR TRANSFER OF THE VESSEL </u></div>
          </div>

          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary"> Survey number</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $survey_number; ?></div>
            <div class="col-3 pl-2 text-primary"> Registration Number</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $vessel_registration_number;?></div>
          </div> <!-- end of row -->
          <div class="row evenrow py-2">
            <div class="col-6 pl-2 text-primary"> Vessel Owner </div>
            <div class="col-6 px-2 text-secondary"> <?php echo $username ; ?></div>
            <!-- <div class="col-3 pl-2 text-primary"> Buyer</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $transfer_buyer_name; ?></div> -->
          </div> <!-- end of row -->
          <?php if($transfer_based_changetype==1){
          ?>
          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary">
            Present Port of Registry
            </div> <!-- end of col-3 1st-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $port_fm; ?>
            </div> <!-- end of col-3 2nd-->
            <div class="col-3 pl-2 text-primary">
            New Port of Registry
            </div> <!-- end of col-3 3rd-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $port_to; ?>
            </div> <!-- end of col-3 4th-->
          </div> <!-- end of row -->

          <?php
          } elseif ($transfer_based_changetype==3) {
          ?>
          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary">
            Present Port of Registry
            </div> <!-- end of col-3 1st-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $port_fm; ?>
            </div> <!-- end of col-3 2nd-->
            <div class="col-3 pl-2 text-primary">
            New Port of Registry
            </div> <!-- end of col-3 3rd-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $port_to; ?>
            </div> <!-- end of col-3 4th-->
          </div> <!-- end of row -->

          <div class="row evenrow py-2">
            <div class="col-3 pl-2 text-primary">
            Buyer name
            </div> <!-- end of col-3 1st-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $transfer_buyer_name; ?>
            </div> <!-- end of col-3 2nd-->
            <div class="col-3 pl-2 text-primary">
            Address
            </div> <!-- end of col-3 3rd-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $transfer_buyer_address; ?>
            </div> <!-- end of col-3 4th-->
          </div> <!-- end of row -->
          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary">
            Phone number
            </div> <!-- end of col-3 1st-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $transfer_buyer_mobile; ?>
            </div> <!-- end of col-3 2nd-->
            <div class="col-3 pl-2 text-primary">
            Email
            </div> <!-- end of col-3 3rd-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $transfer_buyer_email_id; ?>
            </div> <!-- end of col-3 4th-->
          </div> <!-- end of row -->
          <?php
          } elseif ($transfer_based_changetype==0) {
          ?>
          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary">
            State
            </div> <!-- end of col-3 1st-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $state_nm; ?>
            </div> <!-- end of col-3 2nd-->
          </div> <!-- end of row -->
          <div class="row evenrow py-2">
            <div class="col-3 pl-2 text-primary">
            Buyer name
            </div> <!-- end of col-3 1st-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $transfer_buyer_name; ?>
            </div> <!-- end of col-3 2nd-->
            <div class="col-3 pl-2 text-primary">
            Address
            </div> <!-- end of col-3 3rd-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $transfer_buyer_address; ?>
            </div> <!-- end of col-3 4th-->
          </div> <!-- end of row -->
          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary">
            Phone number
            </div> <!-- end of col-3 1st-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $transfer_buyer_mobile; ?>
            </div> <!-- end of col-3 2nd-->
            <div class="col-3 pl-2 text-primary">
            Email
            </div> <!-- end of col-3 3rd-->
            <div class="col-3 px-2 text-secondary">
            <?php echo $transfer_buyer_email_id; ?>
            </div> <!-- end of col-3 4th-->
          </div> <!-- end of row -->
          <?php
          }
          ?>
          <div class="row evenrow py-2">
            <div class="col-3 pl-2 text-primary"> Date of inspection</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $date; ?></div>
            <div class="col-3 pl-2 text-primary"> Place of inspection </div>
            <div class="col-3 px-2 text-secondary"> <?php echo $registry_name; ?></div>
          </div>
          <div class="row evenrow py-2">
            <div class="col-3 pl-2 text-primary"> Remarks</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $remarks; ?></div>
            <div class="col-3 pl-2 text-primary"> Uploaded Document </div>
            <div class="col-3 px-2 text-secondary"><a class="btn btn-flat btn-sm btn-info" href="<?php echo base_url(); ?>uploads/OwnershipChange_Intimation/<?php echo $registration_inspection_report_upload; ?>"  target="_blank" width="30" height="30">Intimation Report<i class="fas fa-file-pdf h4"></i> </a></div>
          </div>
        </form>
      </div> 
    </div> 
  </div> 
</div> 


