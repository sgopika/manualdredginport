
 <?php
 /*$sess_usr_id  =   $this->session->userdata('user_sl');
  $user_type_id  =   $this->session->userdata('user_type_id');*/
   $sess_usr_id    = $this->session->userdata('int_userid');
    $user_type_id   = $this->session->userdata('int_usertype');


  $vessel_id1     = $this->uri->segment(4);
$processflow_sl1   = $this->uri->segment(5);
$survey_id1    = $this->uri->segment(6);

  $vessel_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $vessel_id1);
  $vessel_id=$this->encrypt->decode($vessel_id); 

  $processflow_sl=str_replace(array('-', '_', '~'), array('+', '/', '='), $processflow_sl1);
  $processflow_sl=$this->encrypt->decode($processflow_sl); 

  $survey_id=str_replace(array('-', '_', '~'), array('+', '/', '='), $survey_id1);
  $survey_id=$this->encrypt->decode($survey_id); 



$vessel_id_enc1 = $this->encrypt->encode($vessel_id); 
$vessel_id_enc=str_replace(array('+', '/', '='), array('-', '_', '~'), $vessel_id_enc1);

$survey_id_enc1 = $this->encrypt->encode($survey_id); 
$survey_id_enc=str_replace(array('+', '/', '='), array('-', '_', '~'), $survey_id_enc1);




  
 if(!empty($vessDetails))
{

        $vesselType     = $vessDetails[0]['vessel_type_id'];
        $vesselSubtype  = $vessDetails[0]['vessel_subtype_id'];
        $lengthOverDeck = $vessDetails[0]['vessel_length'];
        $engine_id      = $vessDetails[0]['engine_placement_id'];
        $hull_id        = $vessDetails[0]['hullmaterial_id'];

} 


$current_status1          =   $this->Survey_model->get_status_details($vessel_id,$survey_id);
$data['current_status1']  =   $current_status1;
$status_details_sl        =   $current_status1[0]['status_details_sl'];
 ?>

<script language="javascript">
$(document).ready(function(){

$("#tab1next").click(function() 
{

   /* var hull_condition_status_id    = $("#hull_condition_status_id").val();

    var stability_test_time         = $("#stability_test_time").val();
    var stability_test_duration     = $("#stability_test_duration").val();
    var stability_test_particulars  = $("#stability_test_particulars").val();
    var clear_area_status           = $("#clear_area_status").val();
    var vesselId                    = $("#hdn_vesselId").val();*/

/*var form = $("#form1");
  form.validate();
  if(form.valid())
  {*/

   if($("#form1").isValid())
    {
      $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform6_Tab1')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form1').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          alert("Vessel Details Inserted.");
          $('.nav-item a[href="#tab2"]').tab('show');
          $("#enginedetails").html(data).find(".select2").select2();  
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
    /*var fuel_used_id    = $("#fuel_used_id").val();

    var fuel_tank_material_condition_id = $("#fuel_tank_material_condition_id").val();
    var engine_room_overheat_id     = $("#engine_room_overheat_id").val();
    var vesselId                    = $("#hdn_vesselId").val();*/
/*var form = $("#form2");
  form.validate();
  if(form.valid())
  {
*/

    if($("#form2").isValid())
    {
      $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform6_Tab2')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form2').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          alert("Engine Details Inserted.");
          $('.nav-item a[href="#tab3"]').tab('show');
          $("#machinecondition").html(data).find(".select2").select2();  
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
   /* var passenger_capacity = $("#passenger_capacity").val();
    var capacity_visible = $("#capacity_visible").val();
    var railing_status_id = $("#railing_status_id").val();
    var sand_box          = $("#sand_box").val();
    var life_jacket       = $("#life_jacket").val();
    var cabin_height      = $("#cabin_height").val();
    var freeboard_height  = $("#freeboard_height").val();
    var light_status_id   = $("#light_status_id").val();
    var boat_accomodation_condition_status_id     = $("#boat_accomodation_condition_status_id").val();
    var vesselId         = $("#hdn_vesselId").val();*/
/*var form = $("#form3");
  form.validate();
  if(form.valid())
  {*/


    if($("#form3").isValid())
    {
      $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform6_Tab3')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form3').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          alert("Machine Details Inserted.");
          $('.nav-item a[href="#tab4"]').tab('show');
          $("#crewdetails").html(data).find(".select2").select2();  
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


      
$("#tab4next").click(function() {
         
 /*        var form = $("#form4");
  form.validate();
  if(form.valid())
  { */    
        
    if($("#form4").isValid())
    {
      $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform6_Tab4')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form4').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          alert("Crew Details Inserted.");
          $('.nav-item a[href="#tab5"]').tab('show');
          $("#declaration").html(data).find(".select2").select2();  
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
    
  
$("#tab5next").click(function() 
    {
    /*var passenger_capacity = $("#passenger_capacity").val();
    var vesselId         = $("#hdn_vesselId").val();*/

var vessel_id        = $("#hdn_vesselId1").val();
var processflow_sl     = $("#processflow_sl").val();
var survey_id         = $("#hdn_surveyId1").val();

/*var form = $("#form5");
  form.validate();
  if(form.valid())
  {*/
    if($("#form5").isValid())
    {


      $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform6_Tab5')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form5').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          alert("Declaration Details Inserted.");
        
                window.location.href = "<?php echo site_url('Kiv_Ctrl/Survey/form6_view'); ?>/"+vessel_id+"/"+survey_id;

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
      window.alert("This field accepts only Numbers ");
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
      window.alert("This field accepts only Numbers and Decimal Point(.)");
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
    var lastChar = strvalue[strvalue.length -1];

        if((strvalue==0) || (strvalue=='.'))
        {
          alert("Invalid Number");
          document.getElementById(id).value='';
          document.getElementById(id).focus();
          return false;
        } 
        
        if(lastChar=='.')
        { 
          alert("Cannot end with decimal point");
          document.getElementById(id).value='';
          document.getElementById(id).focus();
          return false;
        }
                  
}

function prevDate(id) 
  {  
        var dateString = document.getElementById(id).value; 
        dateString = dateString.split("/").reverse().join("-");
        
        var myDate = new Date(dateString);
        var today = new Date();
        
        if ( myDate > today ) 
        { 
                       
            alert("Date Should be Smaller than Current Date");
            document.getElementById(id).value='';
            document.getElementById(id).focus();
            return false;
        }
                        
  }

function nextDate(id) 
  {  
        var dateString = document.getElementById(id).value; 
        dateString = dateString.split("/").reverse().join("-");
        
        var myDate = new Date(dateString);
        var today = new Date();
        
        if ( myDate < today ) 
        { 
                       
            alert("You Cannot Enter Previous Date");
            document.getElementById(id).value='';
            document.getElementById(id).focus();
            return false;
        }
                        
  }    
</script>


<!-- Start of breadcrumb -->
 <nav aria-label="breadcrumb " class="mb-0">
  <ol class="breadcrumb justify-content-end mb-0">

   
    <?php if($user_type_id==12) { ?> 
  <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li> 
<?php } if($user_type_id==13) { ?><li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/SurveyorHome"><i class="fas fa-home"></i>&nbsp;Home</a></li> <?php } ?>
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/form56_view">&nbsp;Back</a></li>
    
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="ui-innerpage">
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row">
  <div class="col-12"> 
    <div class="row">
      <div class="col-2 mt-1 ml-5">
         <button type="button" class="btn btn-primary kivbutton btn-block"> Form 6</button> 
      </div> <!-- end of col-2 -->
      <div class="col mt-2 text-primary">
        See Rule 9 (1) - <!-- Form for expressing the intention to build a new vessel -->Declaration by surveyor
      </div>
    </div> <!-- inner row -->
  </div> <!-- end of col-12 add-button header -->

  <div class="col-12 mt-2 ml-2 newfont">  
    <?php //include ('tab.php'); ?>
<input type="hidden" name="hdn_user_type_id" id="hdn_user_type_id" value="<?php echo $user_type_id; ?>" >

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="vesseltab" data-toggle="tab" href="#tab1" role="tab" aria-controls="VesselDetails" aria-selected="true">Vessel and Hull</a>
  </li>
 
  <li class="nav-item">
    <a class="nav-link" id="enginetab" data-toggle="tab" href="#tab2" role="tab" aria-controls="Engine" aria-selected="false">Particulars of Engine</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="conditiontab" data-toggle="tab" href="#tab3" role="tab" aria-controls="Equipment" aria-selected="false">Condition of vessel</a>
  </li>

   <li class="nav-item">
    <a class="nav-link" id="crewdetailstab" data-toggle="tab" href="#tab4" role="tab" aria-controls="FireAppliance" aria-selected="false">Crew Details</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="declarationtab" data-toggle="tab" href="#tab5" role="tab" aria-controls="Payment" aria-selected="false">Declaration</a>
  </li>

</ul>

<div class="tab-content " id="myTabContent">
<!-- ______________________ Vessel Details  Start_________________________ -->

<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="firefight">
<!-- start of content in tab pane -->

<!-- <form name="form1" id="form1" method="post" class="form1" >  -->



<?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
echo form_open("Kiv_Ctrl/Survey/saveform6_Tab1", $attributes);
?>


<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id;?>">
<input type="hidden" id="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vesselType; ?>" >
<input type="hidden" id="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vesselSubtype; ?>" >
<input type="hidden" id="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $lengthOverDeck; ?>" >
<input type="hidden" id="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_id; ?>" >
<input type="hidden" id="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hull_id; ?>" > 
<!-- <input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
 -->
<input type="hidden" name="hdn_surveyId" id="hdn_surveyId" value="<?php echo $survey_id; ?>" >




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
 $value169=' <select class="form-control select2" name="hull_condition_status_id" id="hull_condition_status_id" data-validation="required" required >
           <option value="">Select</option>';
            foreach ($conditionofItem as $condtn)
            {
            
            $value169 .='<option value="'.$condtn['conditionstatus_sl'].'">'.$condtn['conditionstatus_name'].'</option>';
            
            } 
             
            $value169 .='</select>';

     $value170='<input type="text" name="stability_test_time" value="" id="stability_test_time"  class="form-control"  maxlength="10" autocomplete="off" placeholder="Enter Stability Test Time" data-validation="required" required onkeypress="return IsDecimal(event);" onchange="return IsZero(this.id);" /> ';

     $value171='<input type="text" name="stability_test_duration" value="" id="stability_test_duration"  class="form-control"  maxlength="10" autocomplete="off" placeholder="Enter Stability Test duration" data-validation="required"  required onkeypress="return IsAddress(event);"/>';

      

     $value172 =' <textarea name="stability_test_particulars" id="stability_test_particulars" data-validation="required"   onkeypress="return IsAddress(event);"> </textarea> '; 


/*$value173 ='<div class="form-group mt-2 mb-2">

      <input type="radio" name="clear_area_status" id="clear_area_status_y" value="1"> &nbsp;Yes
    &nbsp; &nbsp;
  
      <input type="radio" name="clear_area_status"  id="clear_area_status_n"  value="0" checked> &nbsp;No
    
</div>';*/

$value173 ='
<select class="form-control select2" name="clear_area_status" id="clear_area_status" data-validation="required" required >
           <option value="">Select</option>
           <option value="1">YES</option>
            <option value="0">NO</option>
           </select>';


  /*   $value226 ='<select class="form-control select2" name="cargo_nature" id="cargo_nature" data-validation="required" required >
        <option value="">Select</option>';
            foreach ($cargo_nature as $condtn)
            {
            $value226 .='<option value="'.$condtn['natureofoperation_sl'].'">'.$condtn['natureofoperation_name'].'</option>';
             } 
             $value226 .='</select>'; */  

     $value226='
<input type="text" name="cargo_nature" value="" id="cargo_nature"  class="form-control"  maxlength="100" autocomplete="off" placeholder="Enter nature of operation" data-validation="required"  onkeypress="return IsAddress(event);"/>';             

        $value230='
<input type="text" name="area_of_operation" value="" id="area_of_operation"  class="form-control"  maxlength="100" autocomplete="off" placeholder="Enter Area of operation" data-validation="required"  onkeypress="return IsAddress(event);"/>';          

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




<div class="row mx-0 mb-3 no-gutters oddtab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">

</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab1next" id="tab1next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>

</div> <!-- end of row -->
</div>  <!-- end of col-12 -->

<!-- </form> --> <?php echo form_close(); ?>

  </div><!-- end of tab-pane 1 -->


<!-- ______________________ Vessel Details  End_________________________ -->









<!-- ______________________Particulars of Engine  Start_________________________ -->
<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="enginetab">

<!-- start of content in tab pane -->
<!-- <form name="form2" id="form2" method="post" > -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form2", "name" => "form2");
echo form_open("Kiv_Ctrl/Survey/saveform6_Tab2", $attributes);
?>

<input type="hidden" id="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vesselType; ?>" >
<input type="hidden" id="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vesselSubtype; ?>" >
<input type="hidden" id="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $lengthOverDeck; ?>" >
<input type="hidden" id="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_id; ?>" >
<input type="hidden" id="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hull_id; ?>" > 
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
<input type="hidden" name="hdn_surveyId" id="hdn_surveyId" value="<?php echo $survey_id; ?>" >


<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="enginedetails">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters oddtab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">

</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab2next" id="tab2next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>

<!-- </form> --> <?php echo form_close(); ?>

</div> <!-- end of tab-pane -->

<!-- ______________________ Particulars of Engine  End_________________________ -->







<!-- ______________________ Condition Details Start_________________________ -->

<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="conditiontab">
<!-- start of content in tab pane -->
<!-- <form name="form3" id="form3" method="post" > -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form3", "name" => "form3");
echo form_open("Kiv_Ctrl/Survey/saveform6_Tab3", $attributes);
?>

<input type="hidden" id="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vesselType; ?>" >
<input type="hidden" id="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vesselSubtype; ?>" >
<input type="hidden" id="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $lengthOverDeck; ?>" >
<input type="hidden" id="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_id; ?>" >
<input type="hidden" id="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hull_id; ?>" > 
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
<input type="hidden" name="hdn_surveyId" id="hdn_surveyId" value="<?php echo $survey_id; ?>" >


<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="machinecondition">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">

</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab3next" id="tab3next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>

<!-- </form> --> <?php echo form_close(); ?>

</div> <!-- end of tab-pane -->
<!-- ______________________ condition Details End_________________________ -->



<!-- ______________________ Crew Details Start_________________________ -->

<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="crewdetailstab">
<!-- start of content in tab pane -->
<!-- <form name="form4" id="form4" method="post" > -->

<?php
$attributes = array("class" => "form-horizontal", "id" => "form4", "name" => "form4");
echo form_open("Kiv_Ctrl/Survey/saveform6_Tab4", $attributes);
?>

<input type="hidden" id="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vesselType; ?>" >
<input type="hidden" id="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vesselSubtype; ?>" >
<input type="hidden" id="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $lengthOverDeck; ?>" >
<input type="hidden" id="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_id; ?>" >
<input type="hidden" id="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hull_id; ?>" > 
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
<input type="hidden" name="hdn_surveyId" id="hdn_surveyId" value="<?php echo $survey_id; ?>" >




<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="crewdetails">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters oddtab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">

</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab4next" id="tab4next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>

<!-- </form> --> <?php echo form_close(); ?>

</div>
<!-- ______________________ Crew Details End_________________________ -->





<!--________________________ Declaration Start_____________________________ -->

<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="declarationtab">
<!-- <form name="form5" id="form5" method="post">   -->


<?php
$attributes = array("class" => "form-horizontal", "id" => "form5", "name" => "form5");
echo form_open("Kiv_Ctrl/Survey/saveform6_Tab5", $attributes);
?>
<input type="hidden" id="hdn_vessel_type" name="hdn_vessel_type" value="<?php echo $vesselType; ?>" >
<input type="hidden" id="hdn_vessel_subtype" name="hdn_vessel_subtype" value="<?php echo $vesselSubtype; ?>" >
<input type="hidden" id="hdn_vessel_length" name="hdn_vessel_length" value="<?php echo $lengthOverDeck; ?>" >
<input type="hidden" id="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="<?php echo $engine_id; ?>" >
<input type="hidden" id="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="<?php echo $hull_id; ?>" > 
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vessel_id; ?>" >
<input type="hidden" name="hdn_surveyId" id="hdn_surveyId" value="<?php echo $survey_id; ?>" >


<input type="hidden" name="process_id" id="process_id" value="<?php echo $vessel_details[0]['process_id']; ?>">
<!-- <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $vessel_details[0]['survey_id']; ?>"> -->
<input type="hidden" name="processflow_sl" id="processflow_sl" value="<?php echo $processflow_sl; ?>"> 
<input type="hidden" name="user_id" id="user_id" value="<?php echo $vessel_details[0]['user_id']; ?>">
<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $vessel_details[0]['current_position']; ?>">
<input type="hidden" name="status_details_sl" id="status_details_sl" value="<?php echo $status_details_sl; ?>">

<input type="hidden" name="hdn_vesselId1" id="hdn_vesselId1" value="<?php echo $vessel_id1; ?>" >
<input type="hidden" name="hdn_surveyId1" id="hdn_surveyId1" value="<?php echo $survey_id1; ?>" >




<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="declaration">
<!--replace declaration details here-->
</div>  <!-- end of col-12 -->
</div>

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<div class="col-1 d-flex justify-content-end">
 
</div> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab5next" id="tab5next" ><i class="far fa-save"></i>&nbsp;Submit</button>
</div>
</div>
<!-- </form> --> <?php echo form_close(); ?>
</div>
<!--________________________ Declaration End_____________________________ -->


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
