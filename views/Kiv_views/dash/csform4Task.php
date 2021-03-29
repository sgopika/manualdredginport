<?php 
 $user_type_id   = $this->session->userdata('int_usertype');
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
  <?php if($user_type_id==12) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php }?>
    <?php if($user_type_id==13) { ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   <?php }?>
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage " >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1"> 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary "><i class="fab fa-wpforms"></i>&nbsp; Form 4 </button></div>

</div> 
<div class="row h-100 justify-content-center mt-3">

<div class="col-12 " id="form1view">
<!-- ########################################################################################### -->
 <!-- inside content -->
<?php 


 $vessel_id1     = $this->uri->segment(4);
   $processflow_sl1   = $this->uri->segment(5);
   $survey_id1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
   $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 

/*
 $user_type_id1             =   $this->session->userdata('user_type_id');

 $user_type_id             =   $this->session->userdata('user_type_id');*/

  $user_type_id   = $this->session->userdata('int_usertype');
$user_type_id1   = $this->session->userdata('int_usertype');



$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];

$reference_number              =   $vessel_details[0]['reference_number'];
 @$vessel_registry_port_id         =   $vessel_details[0]['vessel_registry_port_id'];

$registry_port_id       =$this->Survey_model->get_registry_port_id($vessel_registry_port_id);
$data['registry_port_id']    = $registry_port_id;
//print_r($registry_port_id);
if(!empty($registry_port_id))
{
  $registry_code=$registry_port_id[0]['vchr_officecode'];
   $survey_number=$registry_code.'/'.'SRV'.'/'.$reference_number;
}

foreach($vessel_details_viewpage as $res_vessel)
{
   $user_id                = $res_vessel['vessel_created_user_id'];

  $user_type_details          = $this->Survey_model->get_user_type_id($user_id);
  $data['user_type_details']    = $user_type_details;
  $user_type_id1                 = $user_type_details[0]['user_master_id_user_type'];
  }

?>

<!-- <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/form4Task/'.$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1 ?>"> -->
<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/form4Task/".$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1, $attributes);
  ?>

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
<input type="hidden" class="form-control dob" id="reference_number" name="reference_number" value="<?php //echo $reference_number; ?>">
<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $user_type_id1; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
Intimation of Time and Date of Survey of Vessel
</div> <!-- end of col-12 heading -->
</div> 
<div class="row no-gutters oddrow py-3 text-primary">
<div class="col-3 pl-2"> Place of Survey</div> 
<div class="col-3 text-secondary px-3"> 
      <select name="placeofsurvey_sl" id="placeofsurvey_sl" class="form-control select2" data-validation="required">
          <option value="">Select</option>
          <?php foreach($placeof_survey as $res_placeof_survey)
          { 
              ?>
         <option value="<?php echo $res_placeof_survey['placeofsurvey_sl']; ?>" ><?php echo $res_placeof_survey['placeofsurvey_name']; ?></option>
      <?php
          } 
          ?>
         </select>
</div>
<div class="col-3 pl-4"> Survey Number</div>
<div class="col-3 text-secondary px-3">  <input type="text" name="survey_number" value="<?php echo $survey_number; ?>" id="survey_number"  class="form-control" autocomplete="off"   data-validation="required " readonly/>
</div>
</div> <!-- end of row -->

<div class="row no-gutters evenrow py-2 text-primary">
<div class="col-3 pl-2"> Date of Survey</div> 
<div class="col-3 text-secondary px-2"> <input type="date" class="form-control dob" id="date_of_survey" name="date_of_survey" data-validation="required"></div>
<div class="col-3 pl-4"> Time of Survey</div>
<div class="col-3 text-secondary px-3">  <input type="text" class="form-control" name="time_of_survey" id="time_of_survey" value="10:00 AM" /></div>
</div> <!-- end of row -->
<div class="row no-gutters oddrow py-2">
<div class="col-2 pl-2 text-primary"> Remarks</div>
<div class="col-6 px-2"> <textarea name="remarks" data-validation="required" id="remarks" rows="3" cols="90"></textarea></div>
</div> <!-- end of row -->
<div class="row no-gutters evenrow  border-bottom" id="survey4">
<div class="col-12 d-flex justify-content-center py-2">
<button type="submit" class="btn btn-sm btn-flat btn-point btn-success" name="btnsubmit" id="btnsubmit">Forward &nbsp; <i class="fas fa-arrow-circle-right"></i></button>
</div>
</div> 

<!-- </form> --> <?php echo form_close(); ?>

<!-- end of inside content -->
<!-- ########################################################################################### -->
</div> <!-- end of col-8 -->
</div> 
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->


<script language="javascript">
$(document).ready(function(){

$("#printform").click(function () {
  
    //Copy the element you want to print to the print-me div.
    $("#form1view").clone().appendTo("#form1view-print");
    //Apply some styles to hide everything else while printing.
    $("body").addClass("printing");
    //Print the window.
    window.print();
    //Restore the styles.
    $("body").removeClass("printing");
    //Clear up the div.
    $("#form1view-print").empty();
});


/*$("#placeofsurvey_sl").change(function () {
  var placeofsurvey_sl=$("#placeofsurvey_sl").val();
  var reference_number=$("#reference_number").val();
  if(placeofsurvey_sl != '')
  { 
    $.ajax
    ({
    type: "POST",
    url:"<?php echo site_url('/Kiv_Ctrl/Survey/placeofsurvey_code/')?>"+placeofsurvey_sl,
    success: function(data)
    {    
   var surveyno=data+'/SRV'+'/'+reference_number;
      $("#survey_number").val(surveyno);
    }
    });
  }


});*/

$('#datetimepicker3').datetimepicker({
                    format: 'LT'
                });


//Jquery End
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