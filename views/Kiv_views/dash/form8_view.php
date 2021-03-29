<?php  
//$user_type_id     = $this->session->userdata('user_type_id');
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
<?php 

if(!empty($initial_data))
{
   //print_r($initial_data);

    $vessel_id      =   $initial_data[0]['vessel_id'];
    $process_id     =   $initial_data[0]['process_id'];
    $survey_id      =   $initial_data[0]['survey_id'];
    $processflow_sl =   $initial_data[0]['processflow_sl'];
    $owner_user_id  =   $initial_data[0]['vessel_user_id'];


    $reference_number  =    $initial_data[0]['reference_number'];
    $survey_number  =    $initial_data[0]['vessel_survey_number'];
    $vessel_name       =    $initial_data[0]['vessel_name'];
   

}
if(!empty($customer_details))
{
 $owner_name=$customer_details[0]['user_name'];
}
$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];

 $survey_intimation          = $this->Survey_model->get_survey_intimation_cs($vessel_id,$survey_id);
$data['survey_intimation']  = $survey_intimation;
//print_r($survey_intimation);
if(!empty($survey_intimation))
{
    //print_r($survey_intimation);
    $intimation_sl=$survey_intimation[0]['intimation_sl'];
    $status=$survey_intimation[0]['status'];
    $defect_status=$survey_intimation[0]['defect_status'];
    @$survey_defects_id=$survey_intimation[0]['survey_defects_id'];

     $date_of_survey= date("d-m-Y", strtotime($survey_intimation[0]['date_of_survey']));
    if($status==2 && $defect_status==0)
    {
        $survey_date=$date_of_survey;
    }
     if($status==2 && $defect_status==2)
    {
         $intimation_defects          = $this->Survey_model->get_survey_intimation_defects($survey_defects_id);
        $data['intimation_defects']  = $intimation_defects;
        //print_r($intimation_defects);
        $date_of_survey1= date("d-m-Y", strtotime($intimation_defects[0]['date_of_survey']));
         $survey_date=$date_of_survey1;
    }
}


?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <?php if($user_type_id ==11){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>
   <?php if($user_type_id ==12){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>

  <?php if($user_type_id ==13){ ?>
      <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  <?php  } ?>
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container postcard mb-4">
<!-- <form name="form1" id="form1" method="post" action="" enctype="multipart/form-data"> -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/form8_view", $attributes);
?>




<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id ; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $owner_user_id; ?>">
<!--<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $owner_user_type_id; ?>"> -->
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>"> 


<div class="row no-gutters  mb-4" id="form7_card">
<div class="col-12">

<div class="row no-gutter mb-4">
<div class="col-12 py-2 d-flex justify-content-center text-primary"> <strong>FORM NO. 8</strong> </div>
<div class="col-12 py-2 d-flex justify-content-center "> <a href="" class="btn btn-sm btn-flat btn-outline-primary" role="button">[ See Rule 11 ]  </a> </div> 
<div class="col-12 py-2 d-flex justify-content-center text-primary"> <u> <strong>
APPLICATION FOR CERTIFICATE OF SURVEY  </strong>
 </u> </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4 text-primary"> From </div>
<div class="col-12 py-2 d-flex justify-content-start pl-5 text-primary"> The owner of <?php echo $vessel_name; ?> </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4 text-primary"> To </div>
<div class="col-12 py-2 d-flex justify-content-start pl-5 text-primary"> The Chief Surveyor, <br> Department of Ports, <br> Kerala </div>
<div class="col-12 py-2 d-flex justify-content-start pl-5 text-primary"> 
Sub:-      Application for certificate of Survey.
</div>
<div class="col-12 py-2 d-flex justify-content-start pl-5 text-primary">       
            Ref:- Declaration of Survey <?php echo $survey_number; ?> dated <?php echo $survey_date; ?>
</div>
<div class="col-12 py-2 d-flex justify-content-start pl-4 text-primary">
          My vessel named <?php echo $vessel_name; ?> has been surveyed on DATE and Declaration of Survey as above has been issued  on <?php echo $survey_date; ?>. <br>I  request  that  the  Certificate  of  Survey  may be issued <br> </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4 text-primary"> Remarks: </div>
<div class="col-12 py-2 d-flex justify-content-end pr-5 text-primary">Yours faithfully,  </div>
<div class="col-12 py-2 d-flex justify-content-end pr-5 text-primary"> <?php echo $owner_name; ?> </div>
</div>

<div class="row py-2 px-2">
<div class="col-12 d-flex justify-content-end"><button type="submit" class="btn btn-flat btn-sm btn-success btn-point" id="btnsubmit">Approve &nbsp; <i class="fas fa-arrow-right"></i> </button></div> 
</div> <!-- end of row -->
<!-- inside content for printing letter -->
</div> <!-- end of col-12 -->
</div> <!-- end of print form 4 --> <hr>
<!-- </form> --> <?php echo form_close(); ?>
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