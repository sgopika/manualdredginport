<?php 
/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$survey_id1         = $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id=$this->encrypt->decode($survey_id); 
/*_____________________Decoding End___________________*/



$current_status         =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status'] =   $current_status;
if(!empty($current_status))
{
  @$status_details_sl     =   $current_status[0]['status_details_sl'];
  $process_id             =   $current_status[0]['process_id']; 
}

if(!empty($vessel_details))
{
  $user_id=$vessel_details[0]['user_id'];
  $vessel_survey_number       = $vessel_details[0]['vessel_survey_number'];
$vessel_registration_number = $vessel_details[0]['vessel_registration_number'];
}
$user_type         =   $this->Survey_model->get_user_master($user_id);
$data['user_type'] =   $user_type;
if(!empty($user_type))
{
   $user_type_id= $user_type[0]['user_type_id'];

}
  if(!empty($drydock_survey))
     {
      $timeline_sl=$drydock_survey[0]['timeline_sl'];

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

<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/surveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   
  </ol>
</nav> 
<!-- End of breadcrumb -->
<!-- <form name="form1" method="post" action=""> -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/drydock_approval_sr", $attributes);
?>




<div class="main-content">  
<div class="row ui-innerpage " >
<div class="col-12">
<div class="container letterform mb-4">

<div class="row no-gutters">
<div class="col-12 d-flex justify-content-center text-primary"> Drydock Certificate </div>
</div>



<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"></div>
<div class="col-3 px-6 text-secondary"> 
<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="current_position" id="current_position" value="<?php echo $user_type_id; ?>">
<input type="hidden" name="timeline_sl" id="timeline_sl" value="<?php echo $timeline_sl; ?>">
<input type="hidden" name="vessel_registration_number" id="vessel_registration_number" value="<?php echo $vessel_registration_number; ?>">
<input type="hidden" name="vessel_survey_number" id="vessel_survey_number" value="<?php echo $vessel_survey_number; ?>">
</div>
</div> <!-- end of row -->

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary">Recommendation</div>
<div class="col-3 px-6 text-secondary"><textarea name="drydock_recommendation" data-validation="required" id="drydock_recommendation" rows="5" cols="50"></textarea></div>
</div>

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"></div>
<div class="col-3 px-6 text-secondary"><input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Issue drydock certificate"></div>
</div> <!-- end of row -->


</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->
<!-- </form> --> <?php echo form_close(); ?>

<script language="javascript">
$(document).ready(function(){

$("#printform").click(function () {
  
    //Copy the element you want to print to the print-me div.
    $("#form4view").clone().appendTo("#form4view-print");
    //Apply some styles to hide everything else while printing.
    $("body").addClass("printing");
    //Print the window.
    window.print();
    //Restore the styles.
    $("body").removeClass("printing");
    //Clear up the div.
    $("#form4view-print").empty();
});

$("#print_form4").click(function () {
    $("#form4_card").show();
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