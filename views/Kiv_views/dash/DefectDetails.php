<?php 
$vessel_id1         = $this->uri->segment(4);
$survey_defects_sl1 = $this->uri->segment(5);
$survey_id1         = $this->uri->segment(6);
$processflow_sl1    = $this->uri->segment(7);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id=$this->encrypt->decode($survey_id); 

$survey_defects_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_defects_sl1);
$survey_defects_sl=$this->encrypt->decode($survey_defects_sl); 


/*
$current_status         =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status'] =   $current_status;
@$status_details_sl     =   $current_status[0]['status_details_sl'];
$process_id             =   $vessel_details[0]['process_id']; 
$current_status_id      =   $vessel_details[0]['current_status_id'];
$portofregistry_sl      =   $vessel_details[0]['vessel_registry_port_id'];

$port_registry_user_id            =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
$data['port_registry_user_id']    =   $port_registry_user_id;

   if(!empty($port_registry_user_id))
   {
     $pc_user_id      =   $port_registry_user_id[0]['user_sl'];
     $pc_usertype_id  =   $port_registry_user_id[0]['user_type_id'];
   }
*/


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

if(!empty($survey_defect_details))
{
    $date_of_survey         =   date("d-m-Y", strtotime($survey_defect_details[0]['date_of_survey']));
    $time_of_survey         =   $survey_defect_details[0]['time_of_survey'];
    $defects_noticed_by     =   $survey_defect_details[0]['defects_noticed_by'];
    $time_period            =   $survey_defect_details[0]['time_period'];
    $direction_to_rectify   =   $survey_defect_details[0]['direction_to_rectify'];
    $defect_details         =   $survey_defect_details[0]['defect_details'];
    $defect_intimation      =   $survey_defect_details[0]['defect_intimation'];
    $remarks                =   $survey_defect_details[0]['remarks'];
    $placeofsurvey_name     =   $survey_defect_details[0]['placeofsurvey_name'];
    $reference_number       =   $survey_defect_details[0]['reference_number'];
   

$usertype_master           =   $this->Survey_model->get_usertype_master($defects_noticed_by);
$data['usertype_master']   =   $usertype_master;
if(!empty($usertype_master))
{
   $usertype_name= $usertype_master[0]['user_type_type_name'];
}

if($defect_intimation==NULL)
    {
      $msg_disp='<font color="#7a29c6">  <b> No </b>  </font>';
    }
    else 
    {
      $msg_display='<font color="#7a29c6"> <a href="'.base_url().'uploads/defects/'.$defect_intimation.'" download> <b> Yes </b> </a> </font>';
    }

}
$formnumber=3;
$defect_count           =   $this->Survey_model->get_defect_count($vessel_id,$survey_id);
$data['defect_count']   =   $defect_count;
//print_r($defect_count);
if(!empty($defect_count))
{
   
  $dcount = count($defect_count);
  $data['count']=$dcount;

$tariff           =   $this->Survey_model->get_form3_tariff($vessel_id,$survey_id,$formnumber);
$data['tariff']   =   $tariff;
//print_r($tariff);
if(!empty($tariff))
{
  $amount_tobe_pay=$tariff[0]['dd_amount']*2;
}
else
{
  $amount_tobe_pay=0;
}

}
else
{
  $count=0;
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
<!-- <form name="form1" method="POST" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/defect_payment/'.$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1?>"> -->



<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/defect_payment/".$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1, $attributes);
  ?>

<div class="main-content">  
<div class="row ui-innerpage " >
<div class="col-12">
<div class="container letterform mb-4">

<div class="row no-gutters">
<div class="col-12 d-flex justify-content-center text-primary"> Defect Details</div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Date of Entry</div>
<div class="col-3 px-6 text-secondary"> <?php echo date('d-m-Y'); ?></div>
</div> <!-- end of row -->

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"> Reference number</div>
<div class="col-3 px-6 text-secondary"> <?php echo $reference_number ; ?></div>
</div> <!-- end of row -->


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Details of defects</div>
<div class="col-3 px-6 text-secondary"> <?php echo $defect_details; ?></div>
</div> <!-- end of row -->

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"> Defect noticed by</div>
<div class="col-3 px-6 text-secondary"> <?php echo $usertype_name; ?></div>
</div> <!-- end of row -->


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Period allotted for clearing the defect</div>
<div class="col-3 px-6 text-secondary"> <?php echo $time_period; ?> days</div>
</div> <!-- end of row -->

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"> Direction to rectify</div>
<div class="col-3 px-6 text-secondary"> <?php echo $direction_to_rectify ; ?></div>
</div> <!-- end of row -->

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Uploaded Document</div>
<div class="col-3 px-6 text-secondary"> <?php echo $msg_display ; ?></div>
</div> <!-- end of row -->

<div class="row  evenrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
<i class="far fa-calendar-alt"></i> &nbsp; <u>  Survey Schedule </u> </strong> </div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">Place of survey</div>
<div class="col-3 px-6 text-secondary"> <?php echo $placeofsurvey_name ; ?></div>
</div> <!-- end of row -->

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary">Date of survey</div>
<div class="col-3 px-6 text-secondary"> <?php echo $date_of_survey ; ?></div>
</div> <!-- end of row -->

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">Time of survey</div>
<div class="col-3 px-6 text-secondary"> <?php echo $time_of_survey ; ?></div>
</div> <!-- end of row -->
<?php if($dcount>0)
{ ?>


<div class="row  evenrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
 <u>  Payment details </u> </strong> </div>
</div>


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">Amount to be pay</div>
<div class="col-3 px-6 text-secondary"><input type="text" name="dd_amount" value="<?php echo $amount_tobe_pay; ?>" readonly></div>
</div> <!-- end of row -->


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"></div>
<div class="col-3 px-6 text-secondary"><input class="btn btn-flat btn-sm btn-success" type="submit" name="btnsubmit" value="Pay now"></div>
</div> <!-- end of row -->
<?php  } ?>



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