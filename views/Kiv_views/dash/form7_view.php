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
$("#form7_card").hide();
$("#print_form4").hide();
$("#hide_form4").hide();

$("#show_form4").click(function()
{
    $("#form7_card").show();
    $("#print_form4").show(); 
    $("#hide_form4").show();
    $("#show_form4").hide();
});

$("#hide_form4").click(function()
{
    $("#form7_card").hide();
    $("#print_form4").hide(); 
    $("#hide_form4").hide();
    $("#show_form4").show();
});
 
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
    $owner_user_id =   $initial_data[0]['vessel_user_id'];


    $reference_number  =    $initial_data[0]['reference_number'];
    $vessel_name       =    $initial_data[0]['vessel_name'];
    $date              =    date("jS-F-Y", strtotime($initial_data[0]['status_change_date']));

    $today_date1       =    date('Y-m-d');
    $checking_date1    =    date("Y-m-d", strtotime($initial_data[0]['status_change_date']));

    $today_date     = strtotime($today_date1);
    $checking_date  = strtotime($checking_date1);
    $diff           = $today_date - $checking_date;
    $numdays        = round($diff / 86400);

}
if(!empty($customer_details))
{
 $owner_name=$customer_details[0]['user_name'];
}
$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];

if(!empty($tariff_details))
{

   $tariff_amount=$tariff_details[0]['tariff_amount'];
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

<div class="row py-2 px-2">
<div class="col-6 d-flex justify-content-end">
 <button class="btn btn-sm btn-flat btn-point btn-secondary" id="show_form4"> <i class="far fa-eye"></i> &nbsp; Show Notice</button>
  <button class="btn btn-sm btn-flat btn-point btn-secondary" id="hide_form4"> <i class="far fa-eye-slash"></i> &nbsp; Hide Notice</button>

  </div> 
<div class="col-6 d-flex justify-content-end">
 <button class="btn btn-sm btn-flat btn-point btn-success" id="print_form4"> <i class="fas fa-print"></i> &nbsp; Print Notice</button> </div> 
</div> <!-- end of row -->
<!-- <form name="form1" id="form1" method="post" action="" enctype="multipart/form-data"> -->



<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
 echo form_open("Kiv_Ctrl/Survey/form7_view", $attributes);
?>
<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id ; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $owner_user_id; ?>">
<!--<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $owner_user_type_id; ?>"> -->
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>"> 

<div class="row no-gutters  mb-4"  id="form7_card">
<div class="col-12">

<div class="row no-gutter mb-4">
<div class="col-12 py-2 d-flex justify-content-center text-primary"> <strong>FORM NO. 7</strong> </div>
<div class="col-12 py-2 d-flex justify-content-center "> <a href="" class="btn btn-sm btn-flat btn-outline-primary" role="button">[ See Rule 10 ]  </a> </div> 
<div class="col-12 py-2 d-flex justify-content-center text-primary"> <u> <strong>
Notice to owner that a Certificate of Survey granted under the Inland Vessels Act is ready for delivery </strong>
 </u> </div>
<div class="col-12 py-2 d-flex justify-content-end pr-4 text-primary"> <?php echo $date; ?><!-- The SECOND day of NOVEMBER 2018 -->  </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4 text-primary"> To <br>The <?php echo $owner_name; ?> <br>  Owner of <?php echo $vessel_name; ?> </div>
<div class="col-12 py-2 d-flex justify-content-start pl-4 text-primary"> Sir, </div>
<div class="col-12 py-2 d-flex justify-content-start pl-5 text-primary"> 
Sub:-      Notice to owner that a Certificate of Survey granted under the Inland Vessels Act is ready for delivery 
</div>
<div class="col-12 py-2 d-flex justify-content-start pl-5 text-primary">       
            Ref:- <?php echo  $reference_number; ?>
</div>


<div class="col-12 py-2 d-flex justify-content-start pl-4 text-primary">
I hereby give you notice that the certificate of survey of the above inland vessel applied for by <?php echo $owner_name; ?> is ready for delivery, and will be forwarded to you by registered post on payment by you to the local treasury or sub-treasury as the case may be and on production of the treasury chalan of the following sum, viz.:-  <br>
<?php if($numdays>14) { ?>
Forfeiture under section 8(2) of the Inland Vessels Act, 1917,for delay in excess of fourteen days in sending in the    declaration being at the rate of Rs. <?php echo $tariff_amount; ?>  per day for <?php echo $numdays; ?> days. <br><?php } ?> </div>
<?php if($numdays>14) { ?>
<div class="col-12 py-2 d-flex justify-content-start text-primary pl-4"> Total : <?php echo $tariff_amount*$numdays; ?></div><?php } ?> 


<div class="col-12 py-2 d-flex justify-content-end pl-4 text-primary">Yours faithfully,  </div>
<div class="col-12 py-2 d-flex justify-content-end pl-4 text-primary">Certifying  officer  </div>
</div>
<?php if($numdays>14) { ?>
<div class="col-12 py-2 d-flex justify-content-center pl-4 text-success"> <button class="btn btn-sm btn-flat btn-point btn-success" type="button"> <i class="fas fa-credit-card-blank"></i> &nbsp; Proceed to pay</button>  </div>
<?php }  else { ?>

<div class="col-12 py-2 d-flex justify-content-center pl-4 text-success">  <button class="btn btn-sm btn-flat btn-point btn-success"  type="submit"> <i class="fas fa-share-square"></i> &nbsp; Send application</button>  </div>
<?php } ?>

<!-- inside content for printing letter -->
</div> <!-- end of col-12 -->
</div> <!-- end of print form 4 --> 
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

$("#print_form4").click(function () 
{
    $("#form4_card").show();
});

});


</script>
