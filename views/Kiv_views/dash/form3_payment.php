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

/*$user_id     = $this->session->userdata('user_sl');
  $user_type_id    = $this->session->userdata('user_type_id');*/
   $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');


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

    $portofregistry             =   $this->Survey_model->get_portofregistry();
    $data['portofregistry']     = $portofregistry;

$vessel=$this->Survey_model->get_vessel($vessel_id);
$data['vessel']=$vessel;

//print_r($vessel);


if(!empty($vessel))
{

  $vessel_registry_port_id=$vessel[0]['vessel_registry_port_id'];

}

/*if(!empty($tariff_form3))
{
   $tariff_amount=$tariff_form3[0]['tariff_amount'];
}
else
{
  $tariff_amount=1;
}*/

if(!empty($tariff_amount))
  {
    $tariff_amount=$tariff_amount;
  }
  else
  {
    $tariff_amount=1;
  }

?>
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
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container h-100">
<div class="row no-gutter mb-1"> 
<div class="col-6 formfont "> <button class="btn-sm btn-flat btn btn-outline-primary "><i class="fab fa-wpforms"></i>&nbsp; Form 3 </button></div>
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


$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];

$process_id       = $vessel_details[0]['process_id']; 
$current_status_id    = $vessel_details[0]['current_status_id'];

$process_id4=4;
$current_status_id5=5;

$approved_date_finalins=$this->Survey_model->get_form3_appdate($vessel_id,$process_id4,$survey_id,$current_status_id5);
$data['approved_date_finalins']  =   $approved_date_finalins;
if(!empty($approved_date_finalins))
{
  $user_type_id_cssr=$approved_date_finalins[0]['current_position'];
  $user_id_cssr=$approved_date_finalins[0]['user_id'];
}
?>
<!-- <form name="form1" id="form1" method="post" action="<?php echo $site_url.'/Kiv_Ctrl/Survey/pending_payment_form3/'.$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1 ?>"> -->

  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
  echo form_open("Kiv_Ctrl/Survey/pending_payment_form3/".$vessel_id1.'/'.$processflow_sl1.'/'.$survey_id1, $attributes);
  ?>

<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id_cssr; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="current_position" id="current_position" value="<?php echo $user_type_id_cssr; ?>">
<input type="hidden" name="current_status_id" id="current_status_id" value="<?php echo $current_status_id 
; ?>">


<!-- ____________________________ Payment Process ____________________________ -->

<div class="row no-gutters headrow text-white border-bottom">
<div class="col-12 mt-1 mb-1 pl-2 formfont">
Form 3 payment process
</div> <!-- end of col-12 heading -->
</div> <!-- end of row -->


<div class="row no-gutters eventab">
<div class="col-3 border-top border-bottom"> <p class="mt-3 mb-3">Port of Registry</p></div>
<div class="col-3 border-top border-bottom"><p class="mt-3 mb-3">
   <select class="form-control select2 " name="portofregistry_sl" id="portofregistry_sl"  title="" data-validation="required">
  <option value="">Select</option>
  <?php   foreach ($portofregistry as $res_portofregistry)
  {
  ?>
  <option value="<?php echo $res_portofregistry['int_portoffice_id']; ?>"<?php //if($vessel_registry_port_id==$res_portofregistry['portofregistry_sl']) { echo "selected"; } ?>><?php echo $res_portofregistry['vchr_portoffice_name'];?>  </option>
  <?php    }    ?>
  </select></p>
</div>

<div class="col-3 border-top border-bottom border-left pl-2"><p class="mt-3 mb-3">Bank</p></div>
<div class="col-3 border-top border-bottom"><p class="mt-3 mb-3"><div class="input-group">

  <select class="form-control select2 " name="bank_sl" id="bank_sl"  title="" data-validation="required">
  <option value="">Select</option> 
  <?php   foreach ($bank as $res_bank)
  {
  ?>
  <option value="<?php echo $res_bank['bank_sl'];?>" ><?php echo $res_bank['bank_name'];?>  </option>
  <?php    }    ?>
  </select>
    </div></p> </div>

</div>


<div class="row no-gutters eventab">
<div class="col-3 border-top border-bottom"> <p class="mt-3 mb-3">Fee</p></div>
<div class="col-3 border-top border-bottom"><p class="mt-3 mb-3">
   
    <input type="text" class="form-control" name="dd_amount" value="<?php echo $tariff_amount; ?>" id="dd_amount" maxlength="8" autocomplete="off"  required readonly>
     
 </p>
</div>

<div class="col-3 border-top border-bottom border-left pl-2"><p class="mt-3 mb-3"></p></div>
<div class="col-3 border-top border-bottom"><p class="mt-3 mb-3"><div class="input-group">
    </div></p> </div>

</div>




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
