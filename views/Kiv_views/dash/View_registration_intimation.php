
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

if(!empty($registration_intimation))
{
  foreach ($registration_intimation as $key ) 
  {
    $date                       =   date("d-m-Y", strtotime($key['registration_inspection_date']));
    $survey_number              =   $key['vessel_survey_number'];
    $remarks                    =   $key['registration_intimation_remark'];
    $vessel_name                =   $key['vessel_name'];
    $reference_number           =   $key['reference_number'];
    $official_number            =   $key['official_number'];
    $owner_name                 =   $key['user_name'];
    $owner_address              =   $key['user_address'];
    $vessel_registry_port_id    =   $key['registration_intimation_place_id'];
    $registry_port_id           =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
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
}
else
{
  echo "No data";
  exit;
}


$year=date('Y', strtotime($date));
$month= date('F', strtotime($date));
$day= date('d', strtotime($date));
$sup=date("S", strtotime($date)); 
$registration_inspection_date=$day. ''.$sup.''.' day of ' .$month.' '.$year;



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
<div class="col-12 d-flex justify-content-center text-primary"> Form 13</div>
<div class="col-12 d-flex justify-content-center text-primary"> <u> Appointment of date and time of inspection of the inland vessel by the registering authority</u></div>
</div>


<div class="row oddrow py-2">
<div class="col-3 pl-2 text-primary"> Survey number</div>
<div class="col-3 px-2 text-secondary"> <?php echo $survey_number; ?></div>
<div class="col-3 pl-2 text-primary"> Place of inspection</div>
<div class="col-3 px-2 text-secondary"> <?php echo $registry_name;?></div>
</div> <!-- end of row -->
<div class="row evenrow py-2">
<div class="col-3 pl-2 text-primary"> Date of inspection</div>
<div class="col-3 px-2 text-secondary"> <?php echo $date ; ?></div>
<div class="col-3 pl-2 text-primary"> Time of inspection</div>
<div class="col-3 px-2 text-secondary"> <?php echo "10.00 AM" ; ?></div>
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
 <button class="btn btn-sm btn-flat btn-point btn-success" id="print_form4"> <i class="fas fa-envelope-open"></i> &nbsp; Show registration intimation letter</button>

 <button class="btn btn-sm btn-flat btn-point btn-secondary" id="print_form4_hide"> <i class="fas fa-envelope-close"></i> &nbsp; Close registration intimation letter</button>

</div>
</div> <hr>


<div class="row no-gutters postcard mb-4" id="form4_card" style="display: none">
<div class="col-12">

<div class="row no-gutter mb-4">
<div class="col-12 py-2 d-flex justify-content-center"> <strong>FORM NO. 13</strong> </div>
<div class="col-12 py-2 d-flex justify-content-center"> <u> <?php echo strtoupper('Appointment of date and time of inspection of the inland vessel by the registering authority');?> </u> </div>
<div class="col-12 py-2 d-flex justify-content-end pr-4"> Place: <?php echo $registry_name; ?> </div>
<div class="col-12 py-2 d-flex justify-content-end pr-4"> Date: <?php echo $date; ?> </div>
<!-- <div class="col-12 py-2 d-flex justify-content-start pl-4"> From</div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> 
The Chief Surveyor, <br> Department of Ports, <br> Kerala
</div> -->
<div class="col-12 py-2 d-flex justify-content-start pl-4"> To</div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> 
&nbsp;<?php echo $owner_name;?> owner of &nbsp;<?php echo $vessel_name;?>
<br>&nbsp;<?php echo $owner_address;?>
</div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> Sub: Appointment of date and time of inspection of the inland vessel by the registering authority </div>
<div class="col-12 py-2 d-flex justify-content-start pl-5"> Ref: <?php echo $reference_number;?></div>
<div class="col-12 py-2 d-flex justify-content-start pl-4">1. &nbsp;
I have to acknowledge receipt of your application for Registration of the vessel named above under the Inland Vessel Act 1917 and to state that I shall proceed onboard the vessel at &nbsp;<?php echo "10.00 AM" ; ?>  on <?php echo $registration_inspection_date; ?>.
<br>
2. &nbsp;You are requested to afford to the Registering Authority all reasonable facilities for the registration of the vessel and all such information respecting the vessel and her machinery or any part thereof and all equipments and articles onboard as he may require for the purpose of the registration. </div>

<!-- <div class="col-12 py-2 d-flex justify-content-start pl-4"> Survey number: <?php echo $survey_number; ?> </div> -->
<div class="col-12 py-2 d-flex justify-content-start pl-4"> Remarks: <?php echo $remarks; ?> </div>
<div class="col-12 py-2 d-flex justify-content-end pl-4"> Your's faithfully</div>
<div class="col-12 py-2 d-flex justify-content-end pl-4"> Registering Authority</div>


</div>

<div class="row py-2 px-2">
<div class="col-12 d-flex justify-content-end">
 <button class="btn btn-sm btn-flat btn-point btn-secondary" id="print_form4"> <i class="fas fa-print"></i> &nbsp; Print registration intimation letter</button> </div> 
</div> 

</div> 
</div>  <hr>

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