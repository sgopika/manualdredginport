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
  //print_r($initimat_data);
  foreach ($initimat_data as $key ) 
  {
    $date                                   = date("d-m-Y", strtotime($key['registration_inspection_date']));
    $survey_number                          = $key['vessel_survey_number'];
    $vessel_registration_number             = $key['vessel_registration_number'];
    $registration_inspection_report_upload  = $key['registration_inspection_report_upload'];
    $remarks                                = $key['registration_intimation_remark'];
    $vessel_name                            = $key['vessel_name'];
    $category                               = $key['category'];
    $reference_number                       = $key['reference_number'];
    $official_number                        = $key['official_number'];
    @$owner_name                            = $key['user_name'];
    @$owner_address                         = $key['user_address'];
    $vessel_registry_port_id                = $key['registration_intimation_place_id'];
    $registration_intimation_sl             = $key['registration_intimation_sl'];

    $registry_port_id                       = $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
    $data['registry_port_id']               = $registry_port_id;
   
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
  //$change_name              = $vessel_change_det[0]['change_name'];
  $change_req_date                            = date('d-m-Y',strtotime($vessel_change_det[0]['duplicate_cert_req_date']));
  $change_payment_date                        = date('d-m-Y',strtotime($vessel_change_det[0]['duplicate_cert_payment_date']));
  $change_verify_id                           = $vessel_change_det[0]['duplicate_cert_verify_id'];
  
  $change_pc_verified_date                    = date('d-m-Y',strtotime($vessel_change_det[0]['duplicate_cert_pc_verified_date']));
}//print_r($vessel_change_det);
$verified_usertype                            = $this->Vessel_change_model->get_user_master($change_verify_id);
$data['verified_usertype']                    = $verified_usertype; //print_r($verified_usertype);
$verified_usertype                            = $verified_usertype[0]['user_type_type_name'];
if(!empty($payment_det)){
  $dd_amount                                  = $payment_det[0]['dd_amount'];
}
?>

<!-- Start of breadcrumb -->
<nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
  <?php if($user_type_id==14) /// After integration Registering Authority New user_type_id=14?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>

    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/VesselChange/dupcertificate_req_list">List Page</a></li>
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
            <div class="col-12 d-flex justify-content-center text-primary"> <u> INTIMATION FOR DUPLICATE CERTIFICATE OF THE VESSEL </u></div>
          </div>

          <div class="row oddrow py-2">
            <div class="col-3 pl-2 text-primary"> Survey number</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $survey_number; ?></div>
            <div class="col-3 pl-2 text-primary"> Registration Number</div>
            <div class="col-3 px-2 text-secondary"> <?php echo $vessel_registration_number;?></div>
          </div> <!-- end of row -->
          <div class="row evenrow py-2">
            <div class="col-3 pl-2 text-primary"> Vessel Name </div>
            <div class="col-3 px-2 text-secondary"> <?php echo $vessel_name ; ?></div>
          </div> <!-- end of row -->
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
            <div class="col-3 px-2 text-secondary"><a class="btn btn-flat btn-sm btn-info" href="<?php echo base_url(); ?>uploads/DuplicateCert_Intimation/<?php echo $registration_inspection_report_upload; ?>"  target="_blank" width="30" height="30">Intimation Report<i class="fas fa-file-pdf h4"></i> </a></div>
          </div>
        </form>
      </div> 
    </div> 
  </div> 
</div> 


