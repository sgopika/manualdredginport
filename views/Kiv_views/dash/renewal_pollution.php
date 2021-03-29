<?php 

$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$status_details_sl1 = $this->uri->segment(6);

$vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id=$this->encrypt->decode($vessel_id); 

$processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl=$this->encrypt->decode($processflow_sl); 

$status_details_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $status_details_sl1);
$status_details_sl=$this->encrypt->decode($status_details_sl); 
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

$("#btnsubmit").click(function()
{

  var pcb_reg_date=$("#pcb_reg_date").val();
  var pcb_expiry_date=$("#pcb_expiry_date").val();
  var pcb_number=$("#pcb_number").val();
  var pcb_certificate=$("#pcb_certificate").val();
     

  if(pcb_reg_date=="")
  {
    alert("PCB registration date");
    $("#pcb_reg_date").focus();
    return false;
  }
  

if(pcb_expiry_date=="")
  {
    alert("PCB expiry date");
    $("#pcb_expiry_date").focus();
    return false;
  }
 
if(pcb_number=="")
  {
    alert("Enter pcb number");
    $("#pcb_number").focus();
    return false;
  }
 

if(pcb_certificate=="")
  {
    alert("upload pcb certificate");
    $("#pcb_certificate").focus();
    return false;
  }
  
 

});




//-----Jquery End----//
});

</script>
<?php 

if(!empty($vessel_list))
{
 
 $vesselmain_sl                   =   $vessel_list[0]['vesselmain_sl'];
 $vesselmain_vessel_id            =   $vessel_list[0]['vesselmain_vessel_id'];
 $vesselmain_vessel_name          =   $vessel_list[0]['vesselmain_vessel_name'];
 $vesselmain_vessel_type          =   $vessel_list[0]['vesselmain_vessel_type'];
 $vesselmain_vessel_subtype       =   $vessel_list[0]['vesselmain_vessel_subtype'];
 $vesselmain_vessel_category      =   $vessel_list[0]['vesselmain_vessel_category'];
 $vesselmain_ref_number           =   $vessel_list[0]['vesselmain_ref_number'];
 $vesselmain_owner_id             =   $vessel_list[0]['vesselmain_owner_id'];
 $vesselmain_portofregistry_id    =   $vessel_list[0]['vesselmain_portofregistry_id'];
 $vesselmain_reg_number           =   $vessel_list[0]['vesselmain_reg_number'];
 $vesselmain_reg_date             =   $vessel_list[0]['vesselmain_reg_date'];
 $next_reg_renewal_date           =   $vessel_list[0]['next_reg_renewal_date'];


$user           =   $this->Bookofregistration_model->get_customer_details($vesselmain_owner_id);
$data['user']   =   $user;
if(!empty($user))
{
  $name=$user[0]['user_name'];
  $address=$user[0]['user_address'];
}
else
{
  $name="";
  $address="";
}

$portofregistry_details           =   $this->Bookofregistration_model->get_registry_port_id($vesselmain_portofregistry_id);
$data['portofregistry_details']   =   $portofregistry_details;
if(!empty($portofregistry_details))
{
  $portofregistry_name=$portofregistry_details[0]['vchr_portoffice_name'];
}
else
{
  $portofregistry_name="";
}

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
<div class="main-content ui-innerpage">
<form name="form1" id="form1"  method="POST" action="<?php echo site_url().'/Kiv_Ctrl/Bookofregistration/renewalofpollution'?>" enctype="multipart/form-data">
<?php 
foreach ($vesselDet as $vesselDetails) 
{
  $vessel_sl=$vesselDetails['vessel_sl'];
  $vessel_survey_number=$vesselDetails['vessel_survey_number'];
  $vessel_name=$vesselDetails['vessel_name'];
  $reference_number=$vesselDetails['reference_number'];
  $build_date=$vesselDetails['build_date'];
  $vessel_registry_port_id=$vesselDetails['vessel_registry_port_id'];
  $vessel_total_tonnage=$vesselDetails['vessel_total_tonnage'];
  $vessel_expected_completion=$vesselDetails['vessel_expected_completion'];
}

$user_details=$this->Bookofregistration_model->get_user_id($vessel_sl);
$data['user_details']=$user_details;
if(!empty($user_details))
{
  $id=$user_details[0]['user_id'];
  $customer_details=$this->Bookofregistration_model->get_customer_details($id);
  $data['customer_details']=$customer_details;
  if(!empty($customer_details))
  {
    foreach($customer_details as $res_customer)
    {
      $user_name      =   $res_customer['user_name'];
      $user_address   =   $res_customer['user_address'];
    }
  } 
}
else
{
  $user_name      =   "";
  $user_address   =   "";
}

$survey_id=1;
$engine_details=  $this->Survey_model->get_engine_details($vessel_sl,$survey_id);
$data['engine_details']  = $engine_details;

if(!empty($engine_details)) 
{
  foreach($engine_details as $key_engine)
  {
    $engine_type_id = $key_engine['engine_type_id'];
    $bhp1[]         = $key_engine['bhp'];
    $make_year1[]   = $key_engine['make_year'];
    $engine_type         =   $this->Survey_model->get_enginetype_name($engine_type_id);
    $data['engine_type'] =   $engine_type;
    if(!empty($engine_type))
    {
      $engine_type_name1[] =   $engine_type[0]['enginetype_name'];
    }
    else
    {
      $engine_type_name1="";
    }
  }
  $bhp=implode(", ", $bhp1);
  $make_year=implode(", ", $make_year1);
  if($engine_type_name1)
  {
    $engine_type_name=implode(", ", $engine_type_name1);
  }
  else
  {
    $engine_type_name="";
  }
}
else
{
  $bhp="";
  $make_year="";
  $engine_type_name="";
}

//print_r($insurance_details);

if(!empty($pollution_details))
{
  $pollution_sl=$pollution_details[0]['pollution_sl'];
  $pcb_reg_date=date("d-m-Y", strtotime($pollution_details[0]['pcb_reg_date']));
  $validity_of_pcb=date("d-m-Y", strtotime($pollution_details[0]['pcb_expiry_date']));
  $pcb_number=$pollution_details[0]['pcb_number'];
}
else
{
  $pollution_sl="";
  $pcb_reg_date="";
  $validity_of_pcb="";
  $pcb_number="";
}

?>


<div class="main-content">  
<div class="row no-gutters px-5" >
<div class="col-12">
<div class=" letterform mb-4">

<div class="row  evenrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
<u>Vessel details </u> </strong> </div>
</div>

<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Name of vessel </div>
<div class="col-3 px-6 text-secondary"><?php echo $vesselmain_vessel_name; ?>  </div>
<div class="col-3 pl-6 text-primary"> Reference Number </div>
<div class="col-3 px-6 text-secondary"> <?php echo $reference_number; ?></div>
</div> <!-- end of row -->


<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary">Owner Name</div>
<div class="col-3 px-6 text-secondary"><?php echo $name; ?></div>
<div class="col-3 pl-6 text-primary"> Owner address </div>
<div class="col-3 px-6 text-secondary">  <?php echo $address; ?></div>
</div> <!-- end of row -->



<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Registration number of vessel</div>
<div class="col-3 px-6 text-secondary"> <?php echo $vesselmain_reg_number; ?></div>
<div class="col-3 pl-6 text-primary"> Port under which the vessel is registered</div>
<div class="col-3 px-6 text-secondary"> <?php echo $portofregistry_name; ?></div>
</div> <!-- end of row -->

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"> Type of vessel</div>
<div class="col-3 px-6 text-secondary"> <?php echo $vesselmain_vessel_type; ?></div>
<div class="col-3 pl-6 text-primary"> Survey number  </div>
<div class="col-3 px-6 text-secondary"><?php echo $vessel_survey_number; ?> </div>
</div> <!-- end of row -->
<div class="row  oddrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
 <u>Previous Pollution Certificate details </u> </strong> </div>
</div>
<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary"> Pollution Certificate Date</div>
<div class="col-3 px-6 text-secondary"> <?php echo $pcb_reg_date; ?></div>
<div class="col-3 pl-6 text-primary"> Pollution Certificate Expiry Date  </div>
<div class="col-3 px-6 text-secondary"><?php echo $validity_of_pcb; ?> </div>
</div> <!-- end of row -->
<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Pollution Certificate Number</div>
<div class="col-3 px-6 text-secondary"> <?php echo $pcb_number; ?></div>
<div class="col-3 pl-6 text-primary">  </div>
<div class="col-3 px-6 text-secondary"><?php  ?> </div>
</div> <!-- end of row -->


<div class="row  oddrow"> 
<div class="col-12 d-flex justify-content-center text-success py-2"> <strong> 
 <u>New Pollution Certificate details </u> </strong> </div>
</div>

<div class="row evenrow py-2">
<div class="col-3 pl-6 text-primary">Pollution Certificate Date</div> 
<div class="col-3 px-6 text-secondary"> 
   <input type="date" class="form-control dob" id="pcb_reg_date" name="pcb_reg_date" placeholder="PCB registration date"> 
  </div>
<div class="col-3 pl-6 text-primary"> Pollution Certificate Expiry Date</div>
<div class="col-3 px-6 text-secondary">   <input type="date" class="form-control dob" id="pcb_expiry_date" name="pcb_expiry_date" placeholder="PCB expiry date">  </div>
</div> <!-- end of row -->


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary"> Pollution Certificate Number</div>
<div class="col-3 px-6 text-secondary"> 
 <input type="text" class="form-control " maxlength="9" id="pcb_number" name="pcb_number" placeholder="PCB number" > 
  </div>
<div class="col-3 pl-6 text-primary"> Pollution Certificate </div>
<div class="col-3 px-6 text-secondary">  <input type="file" class="form-control-file" id="pcb_certificate" name="pcb_certificate"  accept=".jpg,.jpeg,.JPG,.png"></div>
</div> <!-- end of row -->



<span id="showpayment">


<div class="row oddrow py-2">
<div class="col-3 pl-6 text-primary">
  <input type="hidden" name="vessel_id" id="vessel_id" value="<?php echo $vessel_id; ?>">
 <input type="hidden" name="pollution_sl" id="pollution_sl" value="<?php echo $pollution_sl; ?>">


</div>
<div class="col-3 px-6 text-secondary"><input class="btn btn-flat btn-sm btn-success" type="submit" name="btnsubmit" value="Renew" id="btnsubmit"></div>
</div> <!-- end of row -->

</span>


</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->
</form>
</div>

<script language="javascript">
$(document).ready(function(){


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