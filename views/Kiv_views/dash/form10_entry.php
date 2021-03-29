<?php 
/*_____________________Decoding Start___________________*/
$vessel_id1         = $this->uri->segment(4);
$processflow_sl1    = $this->uri->segment(5);
$survey_id1         = $this->uri->segment(6);

$vessel_id        = str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
$vessel_id        = $this->encrypt->decode($vessel_id); 

$processflow_sl   = str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
$processflow_sl   = $this->encrypt->decode($processflow_sl); 

$survey_id        = str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
$survey_id        = $this->encrypt->decode($survey_id); 
/*_____________________Decoding End___________________*/


if(!empty($vessel_details))
{
  //print_r($vessel_details);
$vessel_survey_number       = $vessel_details[0]['vessel_survey_number'];
$vessel_registration_number = $vessel_details[0]['vessel_registration_number'];
//$owner_user_id              = $vessel_details[0]['vessel_user_id'];
$owner_user_id              = $vessel_details[0]['user_id'];

$vessel_length_overall      = $vessel_details[0]['vessel_length_overall'];
$vessel_length              = $vessel_details[0]['vessel_length'];
$vessel_breadth             = $vessel_details[0]['vessel_breadth'];
$vessel_depth               = $vessel_details[0]['vessel_depth'];
$vessel_upperdeck_length    = $vessel_details[0]['vessel_upperdeck_length'];
$vessel_upperdeck_breadth   = $vessel_details[0]['vessel_upperdeck_breadth'];
$vessel_upperdeck_depth     = $vessel_details[0]['vessel_upperdeck_depth'];
$vessel_total_tonnage       = $vessel_details[0]['vessel_total_tonnage'];


$user_master                =   $this->Survey_model->get_user_master($owner_user_id);
$data['user_master']        =   $user_master;
$owner_user_type_id         =   $user_master[0]['user_type_id'];

}

$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
//print_r($current_status1);
$status_details_sl        =   $current_status1[0]['status_details_sl'];

 if(!empty($vessDetails))
{

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

} 

?>

<script language="javascript">
    
$(document).ready(function()
{
var vessel_length_overall  =  parseInt($("#vessel_length_overall").val());
var vessel_breadth =  parseInt($("#vessel_breadth").val());
var vessel_depth   =  parseInt($("#vessel_depth").val());
var vessel_upperdeck_length   = parseInt($("#vessel_upperdeck_length").val());
var vessel_upperdeck_breadth  = parseInt($("#vessel_upperdeck_breadth").val());
var vessel_upperdeck_depth    = parseInt($("#vessel_upperdeck_depth").val());

var vessel_tonnage            = ((vessel_length_overall*vessel_breadth*vessel_depth)/2.83);
var vessel_upperdeck_tonnage  = ((vessel_upperdeck_length*vessel_upperdeck_breadth*vessel_upperdeck_depth
  )/2.83);
var vessel_total_tonnage      =   vessel_tonnage+vessel_upperdeck_tonnage;

var result=  vessel_total_tonnage.toFixed(2); 
$("#vessel_modified_tonnage").val(result);

  $("#tab1next").click(function() 
    {
     /* var vesselId                    = $("#hdn_vesselId").val();

      var hdn_equipment_id11          = $("#hdn_equipment_id11").val();
      var hdn_equipment_type_id4      = $("#hdn_equipment_type_id4").val();
      var number11                    = $("#number11").val();

      var hdn_equipment_id20          = $("#hdn_equipment_id20").val();
      var hdn_equipment_type_id10     = $("#hdn_equipment_type_id10").val();
      var number20                    = $("#number20").val();
      var location20                  = $("#location20").val();

      var hdn_equipment_id21          = $("#hdn_equipment_id21").val();
      var number21                    = $("#number21").val();
      var capacity21                  = $("#capacity21").val();
*/
    
    if($("#form1").isValid())
    {
/*      var form = $("#form1");
form.validate();
if(form.valid())
{
   */   $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform10_Tab1')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form1').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          alert("Fire fighting equipment Details Inserted.");
          $('.nav-item a[href="#tab2"]').tab('show');
           $("#lifesave_equipment").html(data).find(".select2").select2();  
        }
        if(data=="val_errors")
        {
          //echo $this->session->flashdata('msg');
          window.location.reload(true);
        }
      }

      });
    }
                
    });


 $("#tab2next").click(function() 
    {
      /*var vesselId            = $("#hdn_vesselId").val();


      var hdn_equipment_id17    = $("#hdn_equipment_id17").val();
      var number17_adult        = $("#number17_adult").val();
      var number17_children     = $("#number17_children").val();

      var hdn_equipment_id18    = $("#hdn_equipment_id18").val();
      var number18              = $("#number18").val();
      var capacity18            = $("#capacity18").val();

      var hdn_equipment_id19    = $("#hdn_equipment_id19").val();
      var number19                = $("#number19").val();
      var capacity19              = $("#capacity19").val();

      var hdn_equipment_type_id11 = $("#hdn_equipment_type_id11").val();

      var plastic_yellow          = $("#plastic_yellow").val();
      var food_grane_black        = $("#food_grane_black").val();
      var purple_blue             = $("#purple_blue").val();
      var glass_crockery          = $("#glass_crockery").val();
      var oily_water              = $("#oily_water").val();
      var first_aid_box           = $("#first_aid_box").val();
      var condition_of_equipment  = $("#condition_of_equipment").val();
      var repair_details          = $("#repair_details").val();*/

    
    if($("#form2").isValid())
    {
/*      var form = $("#form2");
form.validate();
if(form.valid())
{*/
      $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform10_Tab2')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form2').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          //alert(data);
          alert("Life saving equipment Details Inserted.");
          $('.nav-item a[href="#tab3"]').tab('show');
           $("#controlvalidity").html(data).find(".select2").select2();  
        }
        if(data=="val_errors")
        {
          //echo $this->session->flashdata('msg');
          window.location.reload(true);
        }
      }

      });
    }
                
    });


 $("#tab3next").click(function() 
    {
      /*var vesselId              = $("#hdn_vesselId").val();
      var upper_deck_passenger    = $("#upper_deck_passenger").val();
      var lower_deck_passenger    = $("#lower_deck_passenger").val();
      var four_cruise_passenger   = $("#four_cruise_passenger").val();

      var insurance_validity      = $("#insurance_validity").val();
      var extinguisher_validity   = $("#extinguisher_validity").val();
      var next_drydock_date       = $("#next_drydock_date").val();
      var certificate_validity_date = $("#certificate_validity_date").val();
      var form10_remarks          = $("#form10_remarks").val();
     */

var vessel_id          = $("#hdn_vesselId1").val();
var processflow_sl     = $("#processflow_sl").val();
var survey_id          = $("#hdn_surveyId1").val();


    
    if($("#form3").isValid())
    {
/*      var form = $("#form3");
form.validate();
if(form.valid())
{*/
      $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform10_Tab3')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form3').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          alert("Capacity and validity Details Inserted.");
        window.location.href = "<?php echo site_url('Kiv_Ctrl/Survey/form10_view'); ?>/"+vessel_id+"/"+survey_id;
        }
        if(data=="val_errors")
        {
          //echo $this->session->flashdata('msg');
          window.location.reload(true);
        }
      }

      });
    }
                
    });

$(".tonnage").change(function(){

var vessel_length_overall  =  parseInt($("#vessel_length_overall").val());
var vessel_breadth =  parseInt($("#vessel_breadth").val());
var vessel_depth   =  parseInt($("#vessel_depth").val());
var vessel_upperdeck_length   = parseInt($("#vessel_upperdeck_length").val());
var vessel_upperdeck_breadth  = parseInt($("#vessel_upperdeck_breadth").val());
var vessel_upperdeck_depth    = parseInt($("#vessel_upperdeck_depth").val());

var vessel_tonnage            = ((vessel_length_overall*vessel_breadth*vessel_depth)/2.83);
var vessel_upperdeck_tonnage  = ((vessel_upperdeck_length*vessel_upperdeck_breadth*vessel_upperdeck_depth
  )/2.83);
var vessel_total_tonnage      =   vessel_tonnage+vessel_upperdeck_tonnage;

var result=  vessel_total_tonnage.toFixed(2); 
$("#vessel_modified_tonnage").val(result);

});

//---Jquery End--------------//
});

</script>
<script language="javascript">

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



function alpbabetspace(e) {
     var k;
     document.all ? k = e.keyCode : k = e.which;
     return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k==32);
}

function validateEmail(email) {
 
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( email ) ) {
      alert("Invalid Email");
      document.getElementById('user_email').value='';
        return false;
    } else {
        return true;
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
 function IsAlphanumeric(e) 
        {
        var unicode = e.charCode ? e.charCode : e.keyCode;
       if ( (unicode >64 && unicode<91) || (unicode > 47 && unicode < 58) || (unicode==47) || (unicode == 45) || (unicode == 8))  
        {
                return true;
        }
        else 
        {
                window.alert("This field accepts Alphanumeric with hyphen(-) and slash (/) ");
                return false;
        }
        }

function checklength(id)
{
  var strvalue=document.getElementById(id).value;  
  //alert(strvalue);
    var len=strvalue.length;
  if(len<4)
  {
    alert("Minimum 4 character");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}

function IsZero(id)
{
  var strvalue=document.getElementById(id).value; 
  if((strvalue==0) || (strvalue=='.'))
  {
    alert("Invalid Number");
   document.getElementById(id).value='';
    document.getElementById(id).focus();
    return false;
  }
}

        
</script>

<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">
    <li class="breadcrumb-item"><a  class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="ui-innerpage">
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row">
  <div class="col-12"> 
  	<div class="row">
  		<div class="col-2 mt-1 ml-5">
  			 <button type="button" class="btn btn-primary kivbutton btn-block"> Form 10</button> 
  		</div> <!-- end of col-2 -->
    <!-- <div class="col mt-2 text-primary">
       <a href="" class="btn btn-sm btn-flat btn-outline-primary" role="button">[See  Rule 12]  </a>
      </div> -->
  	</div> <!-- inner row -->
  </div> <!-- end of col-12 add-button header -->

  <div class="col-12 mt-2 ml-2 newfont">  
  	<?php //include ('tab.php'); ?>



<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="firefight" data-toggle="tab" href="#tab1" role="tab" aria-controls="VesselDetails" aria-selected="true">Fire Fighting Equipment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="lifesave" data-toggle="tab" href="#tab2" role="tab" aria-controls="Hull" aria-selected="false">Life Saving &amp; Pollution control Equipment</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="capacityvalidity" data-toggle="tab" href="#tab3" role="tab" aria-controls="Engine" aria-selected="false">Capacity &amp; validity</a>
  </li>



</ul>

<div class="tab-content " id="myTabContent">

<!-- ______________________ Fire Fighting Equipment  Start_________________________ -->

<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="firefight">
<!-- start of content in tab pane -->
<!-- <form name="form1" id="form1" method="post" class="form1" >  -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/saveform10_Tab1", $attributes);
?>

<input type="hidden" id="hdn_vesselId" name="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
<input type="hidden" id="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vesselType; ?>" >
<input type="hidden" id="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vesselSubtype; ?>" >
<input type="hidden" id="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $lengthOverDeck; ?>" >
<input type="hidden" id="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_id; ?>" >
<input type="hidden" id="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hull_id; ?>" > 
<input type="hidden" name="owner_user_id" id="owner_user_id" value="<?php echo $owner_user_id; ?>">
<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="firefightequipment">
<?php
if (count($fieldstoShow)!=0) 
{
$row_count=0;
$row_color=0;

$var_row=0;
$var_color=0;// 0-odd, 1-even
  foreach ($fieldstoShow as $listFields) 
  {
    //print_r($listFields) ;
    $labelId=$listFields['label_id'];
    
    if($labelId!='')
    {
      $value='';
        $label_name=$listFields['label_name'];
    }
 ?>
 <?php
 $value193='<div class="form-group mt-2 mb-2">
 <input type="text" name="number11" value="" id="number11"  class="form-control"  maxlength="25" autocomplete="off" title="Enter number of fire bucket" placeholder="Enter number of fire bucket" data-validation="required" onchange="return IsZero(this.id);"/> 
 </div>
  <input type="hidden" name="hdn_equipment_id11" value="11">
  <input type="hidden" name="hdn_equipment_type_id4" value="4">';

     $value194='<div class="form-group mt-2 mb-2">
      <input type="text" name="number20" value="" id="number20"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of fixed foam" placeholder="Enter number of fixed foam" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/>
      </div>
  <input type="hidden" name="hdn_equipment_id20" value="20">
  <input type="hidden" name="hdn_equipment_type_id10" value="10">
     ';

     $value195='<div class="form-group mt-2 mb-2">
        <select class="form-control select2" name="location20" id="location20" title="Select location of foam" data-validation="required" required="">
           <option value="">Select</option>';
    foreach ($formtype_location as $res_formtype_location)
    {
  $value195 .='<option value="'.$res_formtype_location['formtype_location_sl'].'">'.$res_formtype_location['formtype_location_name'].'</option>';
    } 
     
          $value195.='  </select></div>';

      

     $value196 ='<div class="form-group mt-2 mb-2">
      <input type="text" name="number21" value="" id="number21"  class="form-control"  maxlength="2" autocomplete="off" title="Enter number of fixed CO2" placeholder="Enter number of fixed CO2" data-validation="required" onkeypress="return IsDecimal(event);"/></div>
  <input type="hidden" name="hdn_equipment_id21" value="21">       
     '; 


 $value197 ='<div class="form-group mt-2 mb-2">


 <input type="text" name="capacity21" value="" id="capacity21"  class="form-control"  maxlength="2" autocomplete="off" title="Enter capacity of  sandox" placeholder="Enter capacity of fire sandox" data-validation="required" onkeypress="return IsDecimal(event);"/>

 </div>
      '; 



  // Placing Div Elements from here
  if($var_row==0)
  { 
    $var_row=1;
    if($var_color==0){
      $style='oddtab';
      $var_color=1;
    }
    else {
       $style="eventab";
       $var_color=0;
    }
     $value="value".$labelId;
  ?>

  <!-- Creating New Row -->
  <div class="row no-gutters  <?php echo $style; ?>">
    <div class="col-3 border-top border-bottom ">
      <p class="mt-3 mb-3"> <?php echo $label_name; ?> </p>
      </div>

      <div class="col-3 border-top border-bottom ">
      <?php   echo ${$value}; ?>
      </div>

  <?php
  }
  else
  {
    $var_row=0;
     $value="value".$labelId;
    ?>
    <div class="col-3 border-top border-bottom border-left pl-2">
      <p class="mt-3 mb-3"> <?php echo $label_name; ?> </p>
      </div> <!-- end of col-3 -->

      <div class="col-3 border-top border-bottom">
      <?php   echo ${$value}; ?>
      </div> <!-- end of col-3 -->
      </div> <!-- end of row -->
    <?php
  } //End of var_row condition
} //End of Foreach

if($var_row==1)
{
  ?>
  <div class="col-6"></div>
  </div> <!-- end of unclosed row -->
  <?php
}


} // end of main IF
?>

<div class="row no-gutters oddtab">
<div class="col-3 border-top border-bottom ">
<p class="mt-3 mb-3"> Oars </p></div>
<div class="col-3 border-top border-bottom ">
<div class="form-group mt-2 mb-2"><input type="text" class="form-control btn-point" name="oars" id="oars" aria-describedby="text" placeholder="No. of oars" maxlength="3">
</div></div>
<div class="col-3 border-top border-bottom border-left pl-2">
<p class="mt-3 mb-3"> Fire axe </p></div> 
<div class="col-3 border-top border-bottom">
<div class="form-group mt-2 mb-2"><input type="text" class="form-control btn-point" name="fire_axe" id="fire_axe" aria-describedby="text" placeholder="No. of fire axe" maxlength="3"></div>
</div> 
</div>


<div class="row no-gutters eventab">
<div class="col-3 border-top border-bottom ">
<p class="mt-3 mb-3"> Heaving line </p></div>
<div class="col-3 border-top border-bottom ">
<div class="form-group mt-2 mb-2"><input type="text" class="form-control btn-point" name="heaving_line_count" id="heaving_line_count" aria-describedby="text" placeholder="No. of heaving line" maxlength="3">
</div></div>
<div class="col-3 border-top border-bottom border-left pl-2">
<p class="mt-3 mb-3"> Number of life bouys with MOB light </p></div> 
<div class="col-3 border-top border-bottom">
<div class="form-group mt-2 mb-2"><input type="text" class="form-control btn-point" name="lifebouys_moblight" id="lifebouys_moblight" aria-describedby="text" placeholder="Number of life bouys with MOB light" maxlength="3"></div>
</div> 
</div>
   
<div class="row no-gutters oddtab">
<div class="col-3 border-top border-bottom ">
<p class="mt-3 mb-3"> Vessel length over all </p></div>
<div class="col-3 border-top border-bottom ">
<div class="form-group mt-2 mb-2"> <input type="text" class="form-control btn-point tonnage" name="vessel_length_overall" value="<?php echo $vessel_length_overall; ?>" id="vessel_length_overall" maxlength="5" autocomplete="off" title="Enter Vessel Length" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);">
</div></div>
<div class="col-3 border-top border-bottom border-left pl-2">
<p class="mt-3 mb-3"> Breadth over the deck </p></div> 
<div class="col-3 border-top border-bottom">
<div class="form-group mt-2 mb-2"><input type="text" name="vessel_breadth" value="<?php echo $vessel_breadth; ?>" id="vessel_breadth"  class="form-control btn-point tonnage"  maxlength="5" autocomplete="off" title="Enter Vessel Breadth" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/></div>
</div> 
</div>


<div class="row no-gutters eventab">
<div class="col-3 border-top border-bottom ">
<p class="mt-3 mb-3"> Depth over the deck </p></div>
<div class="col-3 border-top border-bottom ">
<div class="form-group mt-2 mb-2"> <input type="text" name="vessel_depth" value="<?php echo $vessel_depth; ?>" id="vessel_depth"  class="form-control btn-point tonnage"  maxlength="5" autocomplete="off" title="Enter Vessel Depth" data-validation="required" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
</div></div>
<div class="col-3 border-top border-bottom border-left pl-2">
<p class="mt-3 mb-3"> Length upper the deck </p></div> 
<div class="col-3 border-top border-bottom">
<div class="form-group mt-2 mb-2">  <input type="text" class="form-control btn-point tonnage" name="vessel_upperdeck_length" value="<?php echo $vessel_upperdeck_length; ?>" id="vessel_upperdeck_length" maxlength="4" autocomplete="off" title="Enter Vessel Length Upper the Deck" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/></div>
</div> 
</div>

<div class="row no-gutters oddtab">
<div class="col-3 border-top border-bottom ">
<p class="mt-3 mb-3"> Breadth upper the deck </p></div>
<div class="col-3 border-top border-bottom ">
<div class="form-group mt-2 mb-2">  <input type="text" name="vessel_upperdeck_breadth" value="<?php echo $vessel_upperdeck_breadth; ?>" id="vessel_upperdeck_breadth"  class="form-control btn-point tonnage"  maxlength="4" autocomplete="off" title="Enter Vessel Breadth Upper the Deck" onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
</div></div>
<div class="col-3 border-top border-bottom border-left pl-2">
<p class="mt-3 mb-3"> Depth upper the deck </p></div> 
<div class="col-3 border-top border-bottom">
<div class="form-group mt-2 mb-2">   <input type="text" name="vessel_upperdeck_depth" value="<?php echo $vessel_upperdeck_depth; ?>" id="vessel_upperdeck_depth"  class="form-control btn-point tonnage"  maxlength="4" autocomplete="off"  title="Enter Vessel Depth Upper the Deck"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/></div>
</div> 
</div>

<div class="row no-gutters eventab">
<div class="col-3 border-top border-bottom ">
<p class="mt-3 mb-3"> Old tonnage</p></div>
<div class="col-3 border-top border-bottom ">
<div class="form-group mt-2 mb-2">  <input type="text" name="vessel_total_tonnage" value="<?php echo $vessel_total_tonnage ; ?>" id="vessel_total_tonnage"  class="form-control" readonly /> 
</div></div>
<div class="col-3 border-top border-bottom border-left pl-2">
<p class="mt-3 mb-3"> Modified tonnage </p></div> 
<div class="col-3 border-top border-bottom">
<div class="form-group mt-2 mb-2">   <input type="text" name="vessel_modified_tonnage" value="" id="vessel_modified_tonnage"  class="form-control" readonly="readonly" > </div>
</div> 
</div>




<div class="row no-gutters oddtab">
<div class="col-3 border-top border-bottom ">
<p class="mt-3 mb-3"> Additional amount </p></div>
<div class="col-3 border-top border-bottom ">
<div class="form-group mt-2 mb-2"> <input type="text" name="additional_amount" value="" id="additional_amount"  class="form-control"  maxlength="4" autocomplete="off" title="Enter additional amount"  onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);"/>
</div></div>
<div class="col-3 border-top border-bottom border-left pl-2">
<p class="mt-3 mb-3"> Remarks </p></div> 
<div class="col-3 border-top border-bottom">
<div class="form-group mt-2 mb-2">   <textarea class="form-control" rows="4" cols="50" name="remarks" id="remarks"  title="Remarks"  onkeypress="return IsAddress(event);" onchange="return checklength(this.id)" maxlength="250" onpaste="return false;"></textarea></div>
</div> 
</div>

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
</div> 
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab1next" id="tab1next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>

</div> <!-- end of row -->
</div>  <!-- end of col-12 -->

<!-- </form> --> <?php echo form_close(); ?>
  </div><!-- end of tab-pane 1 -->

<!-- ______________________ Fire Fighting Equipment  End_________________________ -->



<!-- ______________________ Life Saving and Pollution control Equipments Start_________________________ -->

<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="lifesave">
<!-- <form name="form2" id="form2" method="post" > -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form2", "name" => "form2");
echo form_open("Kiv_Ctrl/Survey/saveform10_Tab2", $attributes);
?>
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
<input type="hidden" id="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vesselType; ?>" >
<input type="hidden" id="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vesselSubtype; ?>" >
<input type="hidden" id="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $lengthOverDeck; ?>" >
<input type="hidden" id="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_id; ?>" >
<input type="hidden" id="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hull_id; ?>" > 
<input type="hidden" name="hdn_surveyId" id="hdn_surveyId" value="<?php echo $survey_id; ?>" >


<div class="row no-gutters mx-3 mb-3 mt-2">
<div class="col-12" id="lifesave_equipment"></div> <!-- End of content col -->
</div><!-- End of content row -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab2next" id="tab2next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>


<!-- </form> --> <?php echo form_close(); ?>
<!-- end of content in tab pane -->
</div><!-- end of tab-pane 2 -->
<!-- ______________________ Life Saving and Pollution control Equipments End_________________________ -->



<!-- ______________________ Capacity and validity Start_________________________ -->

<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="capacityvalidity">
<!-- start of content in tab pane -->
<!-- <form name="form3" id="form3" method="post" > -->
<?php
$attributes = array("class" => "form-horizontal", "id" => "form3", "name" => "form3");
echo form_open("Kiv_Ctrl/Survey/saveform10_Tab3", $attributes);
?>

<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>">
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>"> 
<input type="hidden" name="user_id" id="user_id" value="<?php echo $vessel_details[0]['user_id']; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $vessel_details[0]['current_position']; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">
<input type="hidden" name="owner_user_id" id="owner_user_id" value="<?php echo $owner_user_id; ?>">
<input type="hidden" name="owner_user_type_id" id="owner_user_type_id" value="<?php echo $owner_user_type_id; ?>">

<input type="hidden" id="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vesselType; ?>" >
<input type="hidden" id="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vesselSubtype; ?>" >
<input type="hidden" id="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $lengthOverDeck; ?>" >
<input type="hidden" id="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_id; ?>" >
<input type="hidden" id="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hull_id; ?>" > 

<input type="hidden" name="hdn_surveyId" id="hdn_surveyId" value="<?php echo $survey_id; ?>" >
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
<input type="hidden" name="vessel_survey_number" id="vessel_survey_number" value="<?php echo $vessel_survey_number; ?>" >
<input type="hidden" id="vessel_registration_number" name="vessel_registration_number" value="<?php echo $vessel_registration_number; ?>" >


<input type="hidden" name="hdn_surveyId1" id="hdn_surveyId1" value="<?php echo $survey_id1; ?>" >
<input type="hidden" name="hdn_vesselId1" id="hdn_vesselId1" value="<?php echo $vessel_id1; ?>" >


<div class="row no-gutters mx-3 mb-3 mt-2">
<div class="col-12" id="controlvalidity"></div> <!-- End of content col -->
</div><!-- End of content row -->

<div class="row mx-0 mb-3 no-gutters oddtab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab3next" id="tab3next" ><i class="far fa-save"></i>&nbsp;Submit</button>

</div>
</div>

<!-- </form> --> <?php echo form_close(); ?>
<!-- end of content in tab pane -->
</div><!-- end of tab-pane 3 -->

<!-- ______________________ Capacity and validity  End_________________________ -->




</div> <!-- end of tab -content -->
</div> <!-- end of col-12 main col -->
</div> <!-- end of main row -->
</div> <!-- end of container div -->

</div>

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