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
if(!empty($tariff_amount))
{
   @$amount=$tariff_amount;
}
else
{
   $amount=0; 
}
 ?>
<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1"> 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary "><i class="fab fa-wpforms"></i>&nbsp; Form 1 </button></div>
<div class="col-6 d-flex justify-content-end">
<button class="btn-sm btn-flat btn btn-outline-success " id="printform">&nbsp; Payment </button>
</div> <!-- end of button col -->
<div class="col-12" id="form1view-print"> </div>
</div> <!-- end of row -->
<div class="row h-100 justify-content-center mt-3">

<div class="col-12 " id="form1view">
<!-- ########################################################################################### -->
 <!-- inside content -->

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

?>

<!-- <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/pending_payment/'.$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1 ?>">
 -->
<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");


      echo form_open("Kiv_Ctrl/Survey/pending_payment/".$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1, $attributes);
      ?>
<!-- ____________________________ Payment Process ____________________________ -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Payment process 
  <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Port of registry
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <select class="form-control select2 " name="portofregistry_sl" id="portofregistry_sl"  title="" required="required" data-validation="required">
  <option value="">Select</option>
  <?php   foreach ($portofregistry as $res_portofregistry)
  {
  ?>
  <option value="<?php echo $res_portofregistry['int_portoffice_id'];?>"><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
  <?php    }    ?>
  </select>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Bank
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">

<select class="form-control select2 " name="bank_sl" id="bank_sl"  title="" data-validation="required">
  <option value="">Select</option> 
  <?php   foreach ($bank as $res_bank)
  {
  ?>
  <option value="<?php echo $res_bank['bank_sl'];?>" ><?php echo $res_bank['bank_name'];?>  </option>
  <?php    }    ?>
  </select>

</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->






<div class="row no-gutters oddrow border-bottom" id="survey1">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Amount
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <input type="text" class="form-control" name="dd_amount" value="<?php echo $amount; ?>" id="dd_amount" maxlength="4" autocomplete="off"  required readonly>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->


<div class="row no-gutters oddrow border-bottom" id="survey4">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">

</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<input type="submit" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Proceed">
    
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->




<!-- </form> -->  <?php echo form_close(); ?>


<!-- end of inside content -->
<!-- ########################################################################################### -->
</div> <!-- end of col-8 -->
</div> <!-- end of row -->
</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->

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