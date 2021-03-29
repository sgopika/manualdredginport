<?php 

$user_type_id              = $this->session->userdata('int_usertype');
$usertype_master           =   $this->Survey_model->get_usertype_master($user_type_id);
$data['usertype_master']   =   $usertype_master;
if(!empty($usertype_master))
{
   $usertype_name= $usertype_master[0]['user_type_type_name'];
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
   
});

//-----Jquery End----//

</script>
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

if(!empty($initial_data))
{
    
    $reference_number       =   $initial_data[0]['reference_number'];
   $process_id=$initial_data[0]['process_id'];
    
}  

$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];

?>
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
<div class="row ui-innerpage" >
<div class="col-12">
<!-- inside content in container -->
<div class="container letterform">
<!-- inside container -->

<!-- <form name="form1" id="form1" method="post" action="<?php //echo $site_url.'/Survey/form4defect_detection/'.$vessel_id.'/'.$processflow_sl.'/'.$survey_id ?>" enctype="multipart/form-data"> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/form7_entry", $attributes);
?>



 <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
 <input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id ; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<!-- <input type="hidden" name="user_id" id="user_id" value="<?php echo $owner_user_id; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $owner_user_type_id; ?>"> -->
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>"> 
<!-- hidden fields end -->
<div class="row no-gutters">
<div class="col-6 d-flex justify-content-start mt-2">
<button class="btn btn-sm btn-point btn-flat btn-outline-primary">Form 7</button>
</div>
<div class="col-6 d-flex justify-content-end mt-2">
<button class="btn btn-sm btn-point btn-flat btn-outline-success"> <i class="fas fa-print"></i> &nbsp; Print</button>
</div>
<div class="col-12 d-flex justify-content-center text-primary mt-4"> <u> <strong> Sent intimation </strong> </u> </div>
</div> <!-- end of row -->



<div class="row no-gutters oddrow py-2 text-primary">
<div class="col-6 pl-2"> Subject</div> 
<div class="col-6 text-secondary"> <?php echo 'Notice to owner that a Certificate of Survey granted under the  Inland Vessels Act is ready for delivery' ; ?> </div>
</div> <!-- end of row -->
<div class="row no-gutters evenrow py-2 text-primary">
<div class="col-6 pl-2"> Reference Number</div> 
<div class="col-6 text-secondary"> <?php echo $reference_number;?></div>
</div> <!-- end of row -->



<div class="row no-gutters py-2 mb-3" id="survey4">
<div class="col-12 d-flex justify-content-center"> 
<!-- <input type="submit" class="btn btn-info btn-space" name="btnsubmit"  value="Submit "> -->
<button type="submit" class="btn btn-flat btn-sm btn-success btn-point" id="btnsubmit">Send &nbsp; <i class="fas fa-arrow-right"></i> </button>
</div>
</div>  <!-- end of survey4 row -->
<!-- </form> --> <?php echo form_close(); ?>

<!-- end of inside container -->
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->


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