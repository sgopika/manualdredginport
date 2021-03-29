
<?php 
/*$sess_usr_id  =   $this->session->userdata('user_sl');
$user_type_id = $this->session->userdata('user_type_id');*/
$sess_usr_id  =   $this->session->userdata('int_userid');
$user_type_id =   $this->session->userdata('int_usertype');


 $vessel_id    = $this->uri->segment(4);
  $processflow_sl   = $this->uri->segment(5);
  $status_details_sl   = $this->uri->segment(6);

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
//_______________________Process flow _____________________________//
if(!empty($registration_intimation))
{
  foreach ($registration_intimation as $key ) 
  {
    $registration_intimation_sl=   $key['registration_intimation_sl'];
  }

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
  $user_type_id_owner               = $user_type_details[0]['user_master_id_user_type'];
}

//_______________________Process flow end_____________________________//

//-----------Get basic vessel details--------------//

if(!empty($vessel_details_viewpage))
{
  foreach($vessel_details_viewpage as $res_vessel)
  {
    $vessel_name                =     $res_vessel['vessel_name'];
    $vessel_survey_number       =     $res_vessel['vessel_survey_number'];
    $official_number            =     $res_vessel['official_number'];
    $reference_number           =     $res_vessel['reference_number'];
    @$vessel_registry_port_id   =     $res_vessel['vessel_registry_port_id'];
    @$plying_limit              =     $res_vessel['plying_limit'];
    @$vessel_gross_tonnage      =     $res_vessel['grt'];
    @$vessel_net_tonnage        =     $res_vessel['nrt'];
    $vessel_registration_number =     $res_vessel['vessel_registration_number'];
    $vessel_length              =     $res_vessel['vessel_length'];
    $vessel_breadth             =     $res_vessel['vessel_breadth'];
    $vessel_depth               =     $res_vessel['vessel_depth']; 
    $vessel_length_overall      =     $res_vessel['vessel_length_overall'];
    $vessel_yearofbuilt         =     $res_vessel['vessel_expected_completion'];

    $stern                      =     $res_vessel['stern'];
    $stern_id                   =     $res_vessel['stern_id'];
    $vessel_no_of_deck          =     $res_vessel['vessel_no_of_deck'];
    $no_of_shaft                =     $res_vessel['no_of_shaft'];






    if(!empty($stern_id))
    {
      $stern_materialname          =   $this->Bookofregistration_model->get_stern_materialname($stern_id);
       $data['stern_materialname']  =   $stern_materialname; 
       if(!empty($stern_materialname))
       {
        $materialname=$stern_materialname[0]['stern_material_name'];
       }
       else
       {
        $materialname="";
       }
    }
    else
    {
      $materialname="";
    }

   

    if(!empty($vessel_registry_port_id))
    {
       $portofregistry          =   $this->Survey_model->get_registry_port_id($vessel_registry_port_id);
       $data['portofregistry']  =   $portofregistry;
       $portofregistry_name     =   $portofregistry[0]['vchr_portoffice_name'];
       $portofregistry_code     =   $portofregistry[0]['vchr_officecode'];

    }
  }
}




//-----------Get customer name and address--------------//
if(!empty($customer_details))
{
  foreach($customer_details as $res_customer)
  {
    $user_name      =   $res_customer['user_name'];
    $user_address   =   $res_customer['user_address'];
  }
} 

//-----------engine details--------------//
if(!empty($engine_details))
{
  $no_of_engineset=count($engine_details);
   /*foreach($engine_details as $res_engine)
  {

  }*/
}

//-----------hull details--------------//
if(!empty($hull_details))
{
   foreach($hull_details as $res_hull)
  {
    $bulk_heads=$res_hull['bulk_heads'];
    $hull_year_of_built=$res_hull['hull_year_of_built'];
  }
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

<div class="main-content  ui-innerpage">  
<div class="row no-gutters " >
<div class="col-12">
<div class="letterform mb-4">
<div class="row no-gutters">
<div class="col-12 d-flex justify-content-center text-primary"> FORM NO: 14</div>
<div class="col-12 d-flex justify-content-center text-primary"> <strong>CERTIFICATE OF INSPECTION</strong></div>
</div>

<!-- <form name="form14" id="form14" method="POST" action=""> -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form14", "name" => "form14");
echo form_open("Kiv_Ctrl/Bookofregistration/generate_certificate", $attributes);
?>

<!-- </form> --> <?php echo form_close(); ?>
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

<input type="hidden" name="vessel_registration_number" id="user_type_id_owner" value="<?php echo $user_type_id_owner; ?>"> 
<input type="hidden" name="user_type_id_owner" id="user_type_id_owner" value="<?php echo $user_type_id_owner; ?>"> 
<!-- <input type="hidden" name="current_status_id" id="current_status_id" value="2"> --> 




<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Registration Number</div>
<div class="col-3 px-6 text-secondary"> <?php echo $vessel_registration_number;  ?></div>
</div> 

<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary">Name of Inland Vessel</div>
<div class="col-3 px-6 text-secondary"> <?php  echo $vessel_name; ?></div>
</div> 

<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary">Name of Owner</div>
<div class="col-3 px-6 text-secondary"> <?php echo $user_name;  ?></div>
</div> 

<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary">Address of owner</div>
<div class="col-3 px-6 text-secondary"> <?php  echo $user_address; ?></div>
</div> 

<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary">No. of sets of Engines</div>
<div class="col-3 px-6 text-secondary"> <?php echo $no_of_engineset;  ?></div>
</div> 

<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> No. of shafts </div>
<div class="col-3 px-6 text-secondary"> <?php echo $no_of_shaft;  ?></div>
</div> 
  
<?php 


if(!empty($engine_details))
{
  $i=1;
   foreach($engine_details as $res_engine)
  {

    $engine_description=$res_engine['engine_description'];
     $engine_number=$res_engine['engine_number'];


    $engine_speed=$res_engine['engine_speed'];

    @$fuel_used_id=$res_engine['fuel_used_id'];
    $bhp=$res_engine['bhp'];
    $rpm=$res_engine['rpm'];
$manufacturer_name=$res_engine['manufacturer_name'];
$manufacturer_brand=$res_engine['manufacturer_brand'];

      if($fuel_used_id!=0) 
    {
      $fuel_details         =   $this->Survey_model->get_fuel($fuel_used_id);
      $data['fuel_details'] =   $fuel_details;
      if(!empty($fuel_details)){
              @$fuel_name            =   $fuel_details[0]['fuel_name'];

      }

    }
    else
    {
       @$fuel_name            = $nil;
    }



  ?>

<div class="row py-2  no-gutters evenrow" >
<div class="col-6pl-6 text-primary">Engine <?php echo $i; ?> </div>
</div> 


<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Description of engine / Engine number </div>
<div class="col-3 px-6 text-secondary"> <?php echo $engine_description .' / '. $engine_number;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Name of maker </div>
<div class="col-3 px-6 text-secondary"> <?php echo $manufacturer_name;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Address of maker </div>
<div class="col-3 px-6 text-secondary"> <?php echo $manufacturer_brand; ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Nature of fuel used </div>
<div class="col-3 px-6 text-secondary"> <?php echo $fuel_name;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Estimated speed of inland vessel </div>
<div class="col-3 px-6 text-secondary"> <?php echo $engine_speed;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Total brake horse power </div>
<div class="col-3 px-6 text-secondary"> <?php echo $bhp;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> R.P.M </div>
<div class="col-3 px-6 text-secondary"> <?php echo $rpm;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Surface, jet of any other </div>
<div class="col-3 px-6 text-secondary"> <?php   ?></div>
</div> 

<?php $i++; }

}
?>
<div class="row py-2 no-gutters evenrow" >
<div class="col-6pl-6 text-primary"></div>
</div>
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Extreme length </div>
<div class="col-3 px-6 text-secondary"> <?php echo $vessel_length_overall;  ?>&nbsp;m</div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Length </div>
<div class="col-3 px-6 text-secondary"> <?php echo $vessel_length;  ?>&nbsp;m</div>
</div> 
  <!-- vessel_sl IN (2,75,91,267,271,319,353,365,367) ORDER BY vessel_sl ASC -->
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Breadth </div>
<div class="col-3 px-6 text-secondary"> <?php  echo $vessel_breadth; ?>&nbsp;m</div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Depth </div>
<div class="col-3 px-6 text-secondary"> <?php echo $vessel_depth;  ?>&nbsp;m</div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Gross Registered Tonnage </div>
<div class="col-3 px-6 text-secondary"> <?php echo $vessel_gross_tonnage;  ?>&nbsp;m</div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Net Registered Tonnage </div>
<div class="col-3 px-6 text-secondary"> <?php echo $vessel_net_tonnage;  ?>&nbsp;m</div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> No. of Decks </div>
<div class="col-3 px-6 text-secondary"> <?php echo $vessel_no_of_deck; ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> No. of Bulkheads </div>
<div class="col-3 px-6 text-secondary"> <?php echo $bulk_heads;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Year of Build </div>
<div class="col-3 px-6 text-secondary"> <?php  echo $hull_year_of_built;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Stern </div>
<div class="col-3 px-6 text-secondary"> <?php echo $stern; ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Material </div>
<div class="col-3 px-6 text-secondary"> <?php echo $materialname;  ?></div>
</div> 
  
<div class="row py-2 no-gutters">
<div class="col-3 pl-6 text-primary"> Remarks </div>
<div class="col-3 px-6 text-secondary"> <textarea name="remarks" id="remarks" cols="50" rows="3">Verified</textarea>
</div>
</div> 
  
<div class="row no-gutters py-2 px-2">
<div class="col-12 d-flex justify-content-center">
<!-- <input class="btn btn-flat btn-sm btn-success" type="submit" name="btnsubmit" value="Generate certificate">  -->
<input class="btn btn-flat btn-sm btn-success" type="button" name="generate_certificate" id="generate_certificate" value="Generate Certificate">
&nbsp;
<input class="btn btn-flat btn-sm btn-secondary" type="reset" name="btnreset" value="Reset"> 
</div> 
</div>



<!-- </form> --> <?php echo form_close(); ?>





</div> <!-- end of container -->
</div> <!-- end of col-12 -->
</div> <!-- end of row ui-innerpage -->
</div>  <!-- end of main-content -->


<script language="javascript">
$(document).ready(function(){

$("#generate_certificate").click(function()
{
   var vessel_id1          =  $("#vessel_id").val();
   $.ajax({
    url : "<?php echo site_url('Kiv_Ctrl/Bookofregistration/registration_certificate')?>",
    type: "POST",
    //dataType: "JSON",
    data:$('#form14').serialize(),
    success: function(data)
    {
      alert("Registration completed successfully");
      location.replace('<?php echo site_url('Kiv_Ctrl/Bookofregistration/reg_certificate_list')?>');

  
      
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


 </script>