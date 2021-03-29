<?php 
/*$sess_usr_id  =   $this->session->userdata('user_sl');
$user_type_id = $this->session->userdata('user_type_id');*/
$sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');


/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$status_details_sl1 = $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl=$this->encrypt->decode($status_details_sl); 
/*_____________________Decoding End___________________*/
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
if(!empty($registration_intimation))
{
  //print_r($registration_intimation);
  foreach ($registration_intimation as $key ) 
  {
    $date                   =   date("d-m-Y", strtotime($key['registration_inspection_date']));
    $survey_number          =   $key['vessel_survey_number'];
    $remarks                =   $key['registration_intimation_remark'];
    $vessel_name            =   $key['vessel_name'];
    $reference_number       =   $key['reference_number'];
    $official_number        =   $key['official_number'];
    $owner_name             =   $key['user_name'];
    $owner_address          =   $key['user_address'];
    $vessel_registry_port_id=   $key['registration_intimation_place_id'];
    $registration_intimation_sl=   $key['registration_intimation_sl'];

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
}
else
{
  echo "No data";
  exit;
}
if(!empty($initial_data))
{
$process_id       = $initial_data[0]['process_id'];
$survey_id        = $initial_data[0]['survey_id'];
$user_id          = $initial_data[0]['user_id'];
$process_id       = $initial_data[0]['process_id'];
$current_position = $initial_data[0]['current_position'];
$user_sl_ra       = $initial_data[0]['user_id'];
$user_id_owner    = $initial_data[0]['uid'];

  $user_type_details          = $this->Survey_model->get_user_type_id($user_id_owner);
  $data['user_type_details']  = $user_type_details;
  $user_type_id_owner         = $user_type_details[0]['user_master_id_user_type'];
}

?>

 


<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
  <?php if($user_type_id==14) ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Bookofregistration/raHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>

    <!-- <li class="breadcrumb-item"><a href="#">List Page</a></li> -->
  </ol>
</nav> 
<!-- End of breadcrumb -->

<div class="main-content">  
<div class="row ui-innerpage" >
<div class="col-12">
<div class="container letterform mb-4">

<!-- <form name="form1" method="POST" enctype="multipart/form-data" id="form1"> -->
  
<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Bookofregistration/view_form13", $attributes);
?>




<input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
<input type="hidden" name="process_id" id="process_id" value="<?php echo $process_id; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $survey_id; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="current_position" id="current_position" value="<?php echo $current_position; ?>">
<input type="hidden" name="user_sl_ra" id="user_sl_ra" value="<?php echo $user_sl_ra; ?>">
<input type="hidden" name="registration_intimation_sl" id="registration_intimation_sl" value="<?php echo $registration_intimation_sl; ?>">
<input type="hidden" name="user_id_owner" id="user_id_owner" value="<?php echo $user_id_owner; ?>">
<input type="hidden" name="user_type_id_owner" id="user_type_id_owner" value="<?php echo $user_type_id_owner; ?>"> 
<input type="hidden" name="current_status_id" id="current_status_id" value="4"> 


<div class="row no-gutters">
<div class="col-12 d-flex justify-content-center text-primary">&nbsp; Form 13</div>
<div class="col-12 d-flex justify-content-center text-primary"> <u> Previous appointment of date and time of inspection of the inland vessel by the registering authority  </u></div>
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
</div>

<div class="row py-2 px-2">
<div class="col-12 d-flex justify-content-center">
<input class="btn btn-flat btn-sm btn-success" type="button" name="approve" id="approve" value="Approve and generate certificate"> &nbsp;
<input class="btn btn-flat btn-sm btn-primary" type="button" name="revert" id= "revert" value="Resend registration intimation to owner">  &nbsp;
<input class="btn btn-flat btn-sm btn-secondary" type="button" name="reset" id= "reset" value="Reset"> 
</div> 
</div>


<div id="new_intimation" style="display: none;">

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Date of inspection
</div> 


<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<input type="date" class="form-control dob" id="registration_inspection_date" name="registration_inspection_date" placeholder="Inspection Date" data-validation="required">
</div> 
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Place of inspection
</div> 
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
 <select class="form-control select2" name="portofregistry_sl" id="portofregistry_sl" title="Select  Plying Port of Registry" data-validation="required">
        <option value="">Select</option>
        <?php foreach ($plyingPort as $plyPort) { ?>
          <option value="<?php echo $plyPort['int_portoffice_id']; ?>" <?php if($vessel_registry_port_id==$plyPort['int_portoffice_id'] ){ echo "selected";}?>><?php echo $plyPort['vchr_portoffice_name']; ?></option>
        <?php } ?>
    </select>
</div> 
</div> 

<div class="row no-gutters oddrow border-bottom">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark formfont pl-1">
Remarks
</div> 
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
<textarea name="registration_intimation_remark" id="registration_intimation_remark" cols="50" rows="3" data-validation="required">Verified</textarea>
</div> 
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark border-primary formfont pl-1">
Upload documents
</div> 
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont pl-1">
<input type="file" name="registration_inspection_report_upload" />
</div> 
</div> 

<div class="col-3 d-flex justify-content-center mt-1 mb-1 text-primary formfont">
<input type="button" class="btn btn-info pull-right btn-space" name="btnsubmit" id="btnsubmit" value="Submit">
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-dark  border-primary ">
</div>
<div class="col-3 d-flex justify-content-left mt-1 mb-1 text-primary formfont">
</div> 
</div>

</div>






<div id="form14" style="display: none;">

<div class="row oddrow py-2">
<div class="col-12 pl-2 text-primary"> <strong> Form 14 datas</strong></div>
</div>

<div class="row evenrow py-2">
<div class="col-3 pl-2 text-primary"> Number of shafts</div>
<div class="col-3 px-2 text-secondary">  <input type="text" name="propulsion_shaft_number" value="" id="propulsion_shaft_number"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of shaft" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/></div>
<div class="col-3 pl-2 text-primary"> Stern</div>
<div class="col-3 px-2 text-secondary">  <input type="text" name="stern" value="" id="stern"  class="form-control"  maxlength="50" autocomplete="off" title="Enter stern" onkeypress="return IsAddress(event);"></div>
</div> 

<div class="row evenrow py-2">
<div class="col-3 pl-2 text-primary"> Stern material</div>
<div class="col-3 px-2 text-secondary">  <select class="form-control select2"  name="stern_material_sl" id="stern_material_sl">
<option value="">select</option>
<?php 
foreach ($stern_material as $res_stern_material) { ?>
<option value="<?php echo $res_stern_material['stern_material_sl']; ?>"><?php echo $res_stern_material['stern_material_name']; ?></option>
<?php 
}
?>
</select>
</div>
<div class="col-3 pl-2 text-primary"> &nbsp;</div>
<div class="col-3 px-2 text-secondary"> &nbsp;</div>
</div> 



<div class="row oddrow py-2">
<div class="col-12 pl-2 text-primary"><strong> Form 15 datas</strong></div>
</div>


<div class="row evenrow py-2">
<div class="col-3 pl-2 text-primary"> Number of cylinder per set </div>
<div class="col-3 px-2 text-secondary">  <input type="text" name="cylinder_number" value="" id="cylinder_number"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of cylinder per set" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/></div>
<div class="col-3 pl-2 text-primary"> RPM</div>
<div class="col-3 px-2 text-secondary">  <input type="text" name="rpm" value="" id="rpm"  class="form-control"  maxlength="2" autocomplete="off" title="Enter rpm" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/></div>
</div>
<div class="row evenrow py-2">
<div class="col-3 pl-2 text-primary"> Boat </div>
<div class="col-3 px-2 text-secondary">  <input type="text" name="boat" value="" id="boat"  class="form-control"  maxlength="2" autocomplete="off" title="Enter boat" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/></div>
<div class="col-3 pl-2 text-primary"> Capacity</div>
<div class="col-3 px-2 text-secondary">  <input type="text" name="Capacity" value="" id="Capacity"  class="form-control"  maxlength="2" autocomplete="off" title="Enter Capacity" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/></div>
</div>

<div class="row py-2 px-2">
<div class="col-12 d-flex justify-content-center">
<!-- <input class="btn btn-flat btn-sm btn-success" type="submit" name="btnsubmit" value="Generate certificate">  -->
<input class="btn btn-flat btn-sm btn-success" type="button" name="generatecertificate" id="generatecertificate" value="Generate certificate and book of registration">
&nbsp;
<input class="btn btn-flat btn-sm btn-secondary" type="reset" name="btnreset" value="Reset"> 
</div> 
</div>
</div>
<!-- </form> --> <?php echo form_close(); ?>

</div> 
</div> 
</div> 
</div> 


<script language="javascript">
$(document).ready(function()
{
    $("#revert") .click(function()
    {
      $("#new_intimation").show();
      $("#form14").hide();
    });

    $("#reset") .click(function()
    {
      $("#new_intimation").hide();
      $("#form14").hide();
    });

    $("#approve") .click(function()
    {
      $("#new_intimation").hide();
      $("#form14").show();
    });

$("#btnsubmit") .click(function()
{
  // if($("#form1").isValid())
  //{
  $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Bookofregistration/registration_intimation_resend')?>",
    type: "POST",
    data:$('#form1').serialize(),
    //dataType: "JSON",
    success: function(data)
    {
      alert("Registration intimation re-send successfully");
      window.location.href = "<?php echo site_url('Kiv_Ctrl/Bookofregistration/raHome'); ?>";


    }
  });   
  //}
});


$("#generatecertificate").click(function()
   {
    var vessel_id1          =  $("#vessel_id").val();
    var processflow_sl1     =  $("#processflow_sl").val();
    var status_details_sl1  =  $("#status_details_sl").val();
   
   var vessel_id = btoa(vessel_id1);
   var processflow_sl = btoa(processflow_sl1);
   var status_details_sl = btoa(status_details_sl1);
   

     $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Bookofregistration/form14_form15_insertion')?>",
    type: "POST",
    data:$('#form1').serialize(),
    //dataType: "JSON",
    success: function(data)
    {
      //alert(data);
     if(data==1)
     {
      alert("Successfully inserted");
      location.replace('<?php echo site_url('Kiv_Ctrl/Bookofregistration/generate_certificate')?>/'+vessel_id1+'/'+processflow_sl1+'/'+status_details_sl1);
     }
      if(data==0)
      {
         alert("Failed");

      }
    }
  });



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

  function IsNumeric(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)) 
        {
                return true;
        }
        else 
        {
                window.alert("This field accepts only Numbers");
                return false;
        }
        }


function IsDecimal(e) 
{
  var unicode = e.charCode ? e.charCode : e.keyCode;
  if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58) || (unicode == 46 )) 
  {
      return true;
  }
  else 
  {
      window.alert("This field accepts only Numbers");
      return false;
  }
} 
function IsZero(id)
{
  var strvalue=document.getElementById(id).value; 
  if((strvalue==0))
  {
    alert("Invalid Number");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}
function IsAddress(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if ((unicode == 32) || (unicode == 44) || (unicode == 47) || (unicode == 40) || (unicode == 41) || (unicode == 45) || (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode > 96 && unicode < 123) || (unicode==8) || (unicode==46) ) 
        {
                return true;
        }
        else 
        {
              window.alert("Not Allowed");
                return false;  
        }
        }
 </script>