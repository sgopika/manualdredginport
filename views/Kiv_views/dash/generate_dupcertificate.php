
<?php 
/*$sess_usr_id      = $this->session->userdata('user_sl');
$user_type_id     = $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
 $user_type_id =   $this->session->userdata('int_usertype');


$vessel_id        = $this->uri->segment(4);
/*$processflow_sl   = $this->uri->segment(4);
$status_details_sl= $this->uri->segment(5);*/


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

if(!empty($vessel_details_viewpage))
{
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
    $vesselmain_reg_number      =     $res_vessel['vesselmain_reg_number'];
    $vessel_length              =     $res_vessel['vessel_length'];
    $vessel_breadth             =     $res_vessel['vessel_breadth'];
    $vessel_depth               =     $res_vessel['vessel_depth']; 
    $vessel_length_overall      =     $res_vessel['vessel_length_overall'];
    $vessel_yearofbuilt         =     $res_vessel['vessel_expected_completion'];

    $stern                      =     $res_vessel['stern'];
    $stern_id                   =     $res_vessel['stern_id'];
    $vessel_no_of_deck          =     $res_vessel['vessel_no_of_deck'];
    $no_of_shaft                =     $res_vessel['no_of_shaft'];

  }
}

//-----------Get customer name and address--------------//
if(!empty($customer_details))
{
  foreach($customer_details as $res_customer)
  {
    $user_name      =   $res_customer['user_name'];
    $user_address   =   $res_customer['user_address'];
  }
} 

?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">

    <?php if($user_type_id==14) {/// After integration Registering Authority New user_type_id=14?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php } else if($user_type_id==11) {/// After integration Vessel Owner New user_type_id=11?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php } ?>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->
<!-- -------------------------------------- Start of Main Container --------------------------------------------- -->
<div class="main-content ui-innerpage">
  <div class="row p-2 justify-content-center">
    <div class="col-6">
      <div class="alert bg-blue-active text-center" role="alert">
        Vessel Details
      </div> <!-- end of alert -->
      <ul class="list-group list-group-flush">
  <li class="list-group-item">
    Registration Number :  <?php echo $vesselmain_reg_number; ?>
  </li>
  <li class="list-group-item">
    Name of Inland Vessel :  <?php  echo $vessel_name; ?> 
  </li>
  <li class="list-group-item">
    Name of Owner :  <?php echo $user_name;  ?>
  </li>
  <li class="list-group-item">
    Address of owner :  <?php  echo $user_address; ?>
  </li>
  <li class="list-group-item d-flex justify-content-center">
    <button class="btn btn-flat btn-sm bg-darkmagenta" type="button" name="generate_certificate" id="generate_certificate"> <i class="fas fa-download"></i> &nbsp; Certificate of Registration </button> &nbsp;&nbsp;
    <button class="btn btn-flat btn-sm bg-darkslategray" type="button" name="generate_bookofregn" id="generate_bookofregn">Book of Registration&nbsp; <i class="fas fa-download"></i> </button>
  </li>
</ul>
    </div> <!-- end of col6 -->
  </div> <!-- end of row -->
</div> <!-- end of main content container div -->
<!-- -------------------------------------- End of Main Container --------------------------------------------- -->


<script language="javascript">
$(document).ready(function(){

$("#generate_certificate").click(function()
{
   var vessel_id1          =  $("#vessel_id").val();
  //alert("Registration completed successfully");

      location.replace('<?php echo site_url('Kiv_Ctrl/VesselChange/form14_dupcertificate')?>/'+vessel_id1);

 });
$("#generate_bookofregn").click(function()
{
   var vessel_id1          =  $("#vessel_id").val();
  //alert("Registration completed successfully");

      location.replace('<?php echo site_url('Kiv_Ctrl/VesselChange/form15_dupcertificate')?>/'+vessel_id1);

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


 </script>