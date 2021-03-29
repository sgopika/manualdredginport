
<?php 
 $vessel_id1        = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$survey_id1         = $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id=$this->encrypt->decode($survey_id); 


$current_status         =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status'] =   $current_status;
//print_r($current_status);
@$status_details_sl     =   $current_status[0]['status_details_sl'];
$process_id             =   $vessel_details[0]['process_id']; 
$current_status_id      =   $vessel_details[0]['current_status_id'];
 $portofregistry_sl=$vessel_details[0]['vessel_registry_port_id'];

 $port_registry_user_id           =   $this->Survey_model->get_port_registry_user_id($portofregistry_sl);
   $data['port_registry_user_id']  =   $port_registry_user_id;
   if(!empty($port_registry_user_id))
   {
    $pc_user_id=$port_registry_user_id[0]['user_master_id'];
    $pc_usertype_id=$port_registry_user_id[0]['user_master_id_user_type'];
   }


$formnumber=3;
$defect_count           =   $this->Survey_model->get_defect_count($vessel_id,$survey_id);
$data['defect_count']   =   $defect_count;
if(!empty($defect_count))
{
   
  $count = count($defect_count);
  $data['count']=$count;

$survey_id1=1;

$tariff           =   $this->Survey_model->get_form3_tariff($vessel_id,$survey_id,$formnumber);
$data['tariff']   =   $tariff;

if(!empty($tariff))
{
  $amount_tobe_pay=$tariff[0]['dd_amount']*2;
  //$amount_tobe_pay=1;
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
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage " >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1"> 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary "><i class="fab fa-wpforms"></i>&nbsp; Form 4 </button></div>
<div class="col-6 d-flex justify-content-end">
<button class="btn-sm btn-flat btn btn-outline-success " id="printform">&nbsp; Payment </button>
</div> <!-- end of button col -->
<div class="col-12" id="form1view-print"> </div>
</div> <!-- end of row -->
<div class="row h-100 justify-content-center mt-3">

<div class="col-12 " id="form1view">
<!-- ########################################################################################### -->
 <!-- inside content -->


<!-- <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/form4_defect_payment/'.$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1 ?>"> -->


<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/form4_defect_payment/".$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1, $attributes);
  ?>

<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $pc_user_id; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="current_position" id="current_position" value="<?php echo $pc_usertype_id; ?>">
<input type="hidden" name="current_status_id" id="current_status_id" value="<?php echo $current_status_id 
; ?>">
<!-- ____________________________ Payment Process ____________________________ -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Payment process
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->



<div class="row no-gutters evenrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Port of registry
</div> <!-- end of col-3 1st-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
 <select class="form-control select2 " name="portofregistry_sl" id="portofregistry_sl"  title="" data-validation="required" >
  <option value="">Select</option>
  <?php   foreach ($portofregistry as $res_portofregistry)
  {
  ?>
  <option value="<?php echo $res_portofregistry['int_portoffice_id'];?>"<?php if($portofregistry_sl==$res_portofregistry['int_portoffice_id']) { echo "selected"; }?> ><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
  <?php    }    ?>
  </select>
</div> <!-- end of col-3 2nd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Select bank
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
 <input type="text" class="form-control" name="dd_amount" value="<?php echo $amount_tobe_pay; ?>" id="dd_amount" maxlength="4" autocomplete="off"  required readonly>
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
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary">
</div> <!-- end of col-3 3rd-->
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> <!-- end of col-3 4th-->
</div> <!-- end of row -->

  <!-- </form> --> <?php echo form_close(); ?>
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

 $("#btnsubmit").click(function()
 {
  var portofregistry_sl =$("#portofregistry_sl").val();
  var bank_sl=$("#bank_sl").val();
  var dd_amount=$("#dd_amount").val();
  if(portofregistry_sl=="")
  {
    alert("Select port of registry");
    return false;
  }
  if(bank_sl=="")
  {
    alert("Select bank");
    return false;
  }
  if(dd_amount==0)
  {
    alert("No amount to be set");
    return false;
  }

 });



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