<?php
$sess_usr_id    = $this->session->userdata('int_userid');
$user_type_id   = $this->session->userdata('int_usertype');

  $vessel_id1     = $this->uri->segment(4);
  $processflow_sl1   = $this->uri->segment(5);
  $survey_id1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id);
  $current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
  $data['current_status1']  =   $current_status1;
  $status_details_sl        =   $current_status1[0]['status_details_sl'];
  $process_id        =   $current_status1[0]['process_id'];

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

if(!empty($survey_intimation))
{
    $date                   =   date("d-m-Y", strtotime($survey_intimation[0]['intimation_created_timestamp']));
    $survey_number          =   $survey_intimation[0]['survey_number'];
    $remarks                =   $survey_intimation[0]['remarks'];
    $vessel_name            =   $survey_intimation[0]['vessel_name'];
    $reference_number       =   $survey_intimation[0]['reference_number'];
    $official_number        =   $survey_intimation[0]['official_number'];
    $date_of_survey         =   date("d-m-Y", strtotime($survey_intimation[0]['date_of_survey']));
    $time_of_survey         =   $survey_intimation[0]['time_of_survey'];
    $placeofsurvey_name     =   $survey_intimation[0]['placeofsurvey_name'];
    $owner_name             =   $survey_intimation[0]['user_name'];
    $owner_address          =   $survey_intimation[0]['user_address'];

    $vessel_registry_port_id=   $survey_intimation[0]['vessel_registry_port_id'];
    $user_id_cs =$survey_intimation[0]['intimation_created_user_id'];
    $user_details=$this->Survey_model->get_user_type_id($user_id_cs);
          $data['user_details']=$user_details;
          if(!empty($user_details))
          {
            $user_type_id_cs=$user_details[0]['user_master_id_user_type'];
          }



    $registry_port_id       =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
    $data['registry_port_id']   =   $registry_port_id;

if(!empty($registry_port_id))
{
  $registry_name=$registry_port_id[0]['vchr_portoffice_name'];
}
else
{
  $registry_name="";
}
}
else
{
  echo "No data";
  exit;
}

?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/surveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container letterform mb-4">
<div class="row no-gutters">
<div class="col-12 d-flex justify-content-center text-primary"> Form 4 </div>
<div class="col-12 d-flex justify-content-center text-primary"> <u> Intimation of date and time of survey of vessel </u></div>
</div>
<div class="row oddrow py-2">
<div class="col-3 pl-2 text-primary"> Survey number</div>
<div class="col-3 px-2 text-secondary"> <?php echo $survey_number; ?></div>
<div class="col-3 pl-2 text-primary"> Place of survey</div>
<div class="col-3 px-2 text-secondary"> <?php echo $placeofsurvey_name;?></div>
</div> <!-- end of row -->
<div class="row evenrow py-2">
<div class="col-3 pl-2 text-primary"> Date of survey</div>
<div class="col-3 px-2 text-secondary"> <?php echo $date_of_survey ; ?></div>
<div class="col-3 pl-2 text-primary"> Time of survey</div>
<div class="col-3 px-2 text-secondary"> <?php echo $time_of_survey ; ?></div>
</div> <!-- end of row -->
<div class="row oddrow py-2">
<div class="col-6 pl-2 text-primary"> Remarks</div>
<div class="col-6 px-2 text-secondary"> <?php echo $remarks; ?></div>
</div> <!-- end of row -->
<div class="row no-gutters py-2"> 
<div class="col-6 d-flex justify-content-start">
<button class="btn btn-sm btn-flat btn-point btn-warning text-primary"> <i class="fas fa-file-invoice"></i> &nbsp; View Prerequisites</button>

</div>
<div class="col-6 d-flex justify-content-end">
 <button class="btn btn-sm btn-flat btn-point btn-success" id="print_form4"> <i class="fas fa-envelope-open"></i> &nbsp; Show intimation letter</button>

 <button class="btn btn-sm btn-flat btn-point btn-secondary" id="print_form4_hide"> <i class="fas fa-envelope-close"></i> &nbsp; Close intimation letter</button>

</div>
</div> <hr>
<!-- <form name="form1" id="form1" method="post"> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/surveyIntimation", $attributes);
?>

<div class="row no-gutters postcard mb-4" id="form4_card" style="display: none">
<div class="col-12">

<div class="row no-gutter mb-4">
<div class="col-12 py-2 d-flex justify-content-center"> <strong>FORM NO. 4</strong> </div>
<div class="col-12 py-2 px-3 d-flex justify-content-center"> 
<strong><a href="" class="btn btn-sm btn-flat btn-outline-primary" role="button">[See  Rule 7 (1)]  </a>
 </strong>
</div> <!-- end of col12 -->
<div class="col-12 py-2 d-flex justify-content-center"> <u> <?php echo strtoupper('Intimation of date and time of survey of vessel');?> </u> </div>
<div class="col-12 py-2 d-flex justify-content-end pr-4"> Place: <?php echo $registry_name; ?> </div>
<div class="col-12 py-2 d-flex justify-content-end pr-4"> Date: <?php echo $date; ?> </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4"> From</div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> 
The Chief Surveyor, <br> Department of Ports, <br> Kerala
</div>
<div class="col-12 py-2 d-flex justify-content-start pl-4"> To</div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> 
&nbsp;<?php echo $owner_name;?> owner of &nbsp;<?php echo $vessel_name;?>
<br>&nbsp;<?php echo $owner_address;?>
</div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> Sub: Intimation of date and time of survey of vessel </div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> Ref: <?php echo $reference_number;?></div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> Place of survey: <?php echo $placeofsurvey_name;?> </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4">
I have to acknowledge receipt of your application for survey of the vessel name above under the Inland Vessels Act 1917, (Central Act 1 of 1917) and state that a Surveyor will procees on board the vessel at &nbsp;<?php echo $time_of_survey ; ?>  on <?php echo $date_of_survey ; ?>. <br>
I enclosed a list of the requisite preparations for the survey, which shall be made before the day and hour above mentioned.<br> </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4"> Survey number: <?php echo $survey_number; ?> </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4"> Remarks: <?php echo $remarks; ?> </div>
</div>

<div class="row py-2 px-2">
<div class="col-12 d-flex justify-content-end">
<!--  <button class="btn btn-sm btn-flat btn-point btn-secondary" id="print_form4"> <i class="fas fa-print"></i> &nbsp; Print intimation letter</button>  -->
<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id_cs" id="user_id_cs" value="<?php echo $user_id_cs; ?>">
<input type="hidden" name="user_type_id_cs" id="user_type_id_cs" value="<?php echo $user_type_id_cs; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl;?>">

<button class="btn btn-sm btn-flat btn-point btn-secondary" type="button" name="btnconfirm" id="btnconfirm" > <i class="fas fa-print"></i> &nbsp; Send confirmation</button> 
 

</div> 
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
    $("#print_form4_hide").hide(); 

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
    $("#print_form4_hide").show(); 
     $("#print_form4").hide(); 

});

$("#print_form4_hide").click(function () {
    $("#form4_card").hide();
    $("#print_form4_hide").hide(); 
     $("#print_form4").show(); 

});

});
$("#btnconfirm").click(function()
{
 
    $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/form4_confirmation')?>",
      type: "POST",
      data:$('#form1').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
       //  alert(data);
       // exit;

        alert("Confirmation send");
        window.location.href = "<?php echo site_url('Kiv_Ctrl/Survey/Owner_Inbox'); ?>";
        
       
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


 </script>