
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

/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
 $processflow_sl1    = $this->uri->segment(5);
  $surveyId1         = $this->uri->segment(6);


$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
 $vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
 $processflow_sl=$this->encrypt->decode($processflow_sl); 

$surveyId=str_replace(array('-', '_', '~'), array('+', '/', '='), $surveyId1);
  $surveyId=$this->encrypt->decode($surveyId); 
/*_____________________Decoding End___________________*/

$current_status         =   $this->Survey_model->get_status_details($vessel_id,$surveyId);
$data['current_status'] =   $current_status;
//print_r($current_status);
if(!empty($current_status))
{
      @$status_details_sl     =   $current_status[0]['status_details_sl'];
      @$survey_id     =   $current_status[0]['survey_id'];
}


            $process_id=$vessel_details[0]['process_id']; 
            $current_status_id=$vessel_details[0]['current_status_id'];

            if($process_id==1)
            {
              $msg='Form 1 Verification';
            }
            if($process_id==2)
            {
              $msg='Keel Laying';
            }
            if($process_id==3)
            {
              $msg='Hull Inspection';
            }
            if($process_id==4)
            {
              $msg='Final Inspection';
            }
             if($process_id==15)
            {
              $msg='Form2';
            }
            $previous_module_id           =   $vessel_details[0]['previous_module_id'];
            $user_type_user_id            =   $this->Survey_model->get_user_type_user_id($previous_module_id);
            $data['user_type_user_id']    =   $user_type_user_id;
            @$user_type_id1               =   $user_type_user_id[0]['current_position'];
            @$user_id1                    =   $user_type_user_id[0]['user_id'];

            if(@$user_type_id1=='')
            {
              $user_type_id=4;
            }
            else
            {
              $user_type_id=$user_type_id1;
            }
            if(@$user_id1=='')
            {
              $user_id=4;
            }
            else
            {
              $user_id=$user_id1;
            }

$processactivity_date_remarks= $this->Survey_model->get_processactivity_date_remarks($vessel_id,$survey_id,$process_id);
$data['processactivity_date_remarks']= $processactivity_date_remarks;
if(!empty($processactivity_date_remarks))
{
  $activity_date1=$processactivity_date_remarks[0]['activity_date'];
  $remarks=$processactivity_date_remarks[0]['remarks'];
  $activity_date    =   date("d-m-Y", strtotime($activity_date1));
}

//print_r($processactivity_date_remarks);
   

            ?> 

 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/surveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
   
  </ol>
</nav> 


<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container letterform mb-4">



<div class="row no-gutters">
<div class="col-12 d-flex justify-content-center text-primary"> Intimation </div>
<div class="col-12 d-flex justify-content-center text-primary"> <u> Date of inspection of vessel </u></div>
</div>
<div class="row oddrow py-2">
<div class="col-3 pl-2 text-primary"> Vessel name</div>
<div class="col-3 px-2 text-secondary"> <?php echo $vessel_details[0]['vessel_name']; ?></div>
<div class="col-3 pl-2 text-primary"> Reference number</div>
<div class="col-3 px-2 text-secondary"><?php echo $vessel_details[0]['reference_number']; ?></div>
</div> <!-- end of row -->
<div class="row evenrow py-2">
<div class="col-3 pl-2 text-primary">Process name </div>
<div class="col-3 px-2 text-secondary"> <?php echo $msg; ?></div>
<div class="col-3 pl-2 text-primary">Date of inspection</div>
<div class="col-3 px-2 text-secondary"> <?php echo $activity_date ; ?></div>
</div> <!-- end of row -->
<div class="row oddrow py-2">
<div class="col-6 pl-2 text-primary"> Remarks</div>
<div class="col-6 px-2 text-secondary"> <?php echo $remarks; ?></div>
</div> <!-- end of row -->
 <hr>
<!-- <form id="form1" name='form1' method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/Forward_Vessel'?>"> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/Forward_Vessel", $attributes);
?>



<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="current_status_id" id="current_status_id" value="<?php echo "2"; ?>">

<div class="row evenrow py-2">
<div class="col-12 pl-2 text-primary"> Completed the process of&nbsp;<?php echo $msg; ?>&nbsp;of vessel&nbsp;
<em> <strong> <?php echo $vessel_details[0]['vessel_name']; ?> </strong> </div>
</div> <!-- end of row -->

<div class="row oddrow py-2">
<div class="col-6 pl-2 text-primary"> Forward To</div>
<div class="col-6 px-2 text-secondary"><select name="current_position" id="current_position" class="form-control select2" data-validation="required">
<option value="">Select</option>
<option value="<?php echo $user_type_id; ?>"><?php if($user_type_id==12 || $user_type_id=='') { echo 'Chief Surveyor'; } if($user_type_id==13) { echo 'Surveyor'; }?></option>
</select></div>
</div> <!-- end of row -->


<div class="row evenrow py-2">
<div class="col-12 pl-2 text-primary" align="right"> <input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Confirm"> </div>
</div> <!-- end of row -->

<!-- </form> --> <?php echo form_close(); ?>

</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->




 <script type="text/javascript">
  $(document).ready(function() {
          $('.select2').select2({ width:'resolve' });
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