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
if(!empty($vessel_details))
{
  //print_r($vessel_details);
$vessel_survey_number       = $vessel_details[0]['vessel_survey_number'];
$vessel_registration_number = $vessel_details[0]['vessel_registration_number'];
$owner_user_id              = $vessel_details[0]['vessel_user_id'];

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
    
$(document).ready(function(){


  $("#tab1next").click(function() 
    {
      var vessel_id          = $("#hdn_vesselId1").val();
//var processflow_sl     = $("#processflow_sl").val();
var survey_id          = $("#hdn_surveyId1").val();
        
    if($("#form1").isValid())
    {
    /*  var form = $("#form1");
form.validate();
if(form.valid())
{*/
      $.ajax({
      url : "<?php echo site_url('Kiv_Ctrl/Survey/saveform9_Tab1')?>",
      type: "POST",
      //dataType: "JSON",
      data:$('#form1').serialize(),

      success: function(data)
      { 
         
        if(data!="val_errors")
        {
          alert("Details Inserted.");
         // $('.nav-item a[href="#tab2"]').tab('show');
            window.location.href = "<?php echo site_url('Kiv_Ctrl/Survey/form9_view'); ?>/"+vessel_id+"/"+survey_id;
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
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Kiv_Ctrl/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="ui-innerpage">
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row">
  <div class="col-12"> 
  	<div class="row">
  		<div class="col-2 mt-1 ml-5">
  			 <button type="button" class="btn btn-primary kivbutton btn-block"> Form 9</button> 
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
    <a class="nav-link active" id="details" data-toggle="tab" href="#tab1" role="tab" aria-controls="VesselDetails" aria-selected="true">Details</a>
  </li>
 

</ul>

<div class="tab-content " id="myTabContent">

<!-- ______________________ Fire Fighting Equipment  Start_________________________ -->

<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="details">
<!-- start of content in tab pane -->
<!-- <form name="form1" id="form1" method="post" class="form1" >  -->
  <?php
$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1", "enctype"=> "multipart/form-data");
echo form_open("Kiv_Ctrl/Survey/saveform9_Tab1", $attributes);
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


<input type="hidden" name="hdn_surveyId" id="hdn_surveyId1" value="<?php echo $survey_id1; ?>" >
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId1" value="<?php echo $vessel_id1; ?>" >

<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="details">
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
/*$value219 ='<div class="form-group mt-2 mb-2">
 <input type="text" name="capacity21" value="" id="capacity21"  class="form-control"  maxlength="2" autocomplete="off" title="Fire sandbox capacity" placeholder="Enter capacity of fire sandox" data-validation="required" onkeypress="return IsDecimal(event);"/></div>';
$value220 ='<div class="form-group mt-2 mb-2">
 <input type="text" name="boats_aggregate_capacity" value="" id="boats_aggregate_capacity"  class="form-control"  maxlength="2" autocomplete="off" title="Boats aggregate capacity" placeholder="Enter Boats aggregate capacity" data-validation="required" onkeypress="return IsDecimal(event);"/></div>';

 $value221 ='<div class="form-group mt-2 mb-2">
 <input type="text" name="lifebouys_plyingA" value="" id="lifebouys_plyingA"  class="form-control"  maxlength="2" autocomplete="off" title="" placeholder="" data-validation="required" onkeypress="return IsDecimal(event);"/></div>';
 $value222 ='<div class="form-group mt-2 mb-2">
 <input type="text" name="lifebouys_plyingB" value="" id="lifebouys_plyingB"  class="form-control"  maxlength="2" autocomplete="off" title="" placeholder="" data-validation="required" onkeypress="return IsDecimal(event);"/></div>';
 $value223 ='<div class="form-group mt-2 mb-2">
 <input type="text" name="lifebouys_plyingC" value="" id="lifebouys_plyingC"  class="form-control"  maxlength="2" autocomplete="off" title="" placeholder="" data-validation="required" onkeypress="return IsDecimal(event);"/></div>';
 */

 $value219= '<div class="row">
             <div class="col-6 d-flex justify-content-center">'.$label_name.' </div> <!-- end of col-6 -->
             <div class="col-6 d-flex justify-content-center">

                  <div class="form-group mt-2 mb-2">
                 <input type="text" name="capacity21" value="" id="capacity21"  class="form-control"  maxlength="2" autocomplete="off" title="Fire sandbox capacity" placeholder="Enter capacity of fire sandox" data-validation="required" onkeypress="return IsDecimal(event);"/>
                   <input type="hidden" name="hdn_equipment_id12" value="12"> 
  <input type="hidden" name="hdn_equipment_type_id4" value="4"> 
                  </div>

             </div> <!-- end of col-6 -->
             </div> <!-- end of row -->  ';
$value220= '<div class="row">
<div class="col-6 d-flex justify-content-center">'.$label_name.' </div> <!-- end of col-6 -->
<div class="col-6 d-flex justify-content-center">

<div class="form-group mt-2 mb-2">
<input type="text" name="boats_aggregate_capacity" value="" id="boats_aggregate_capacity"  class="form-control"  maxlength="2" autocomplete="off" title="Boats aggregate capacity" placeholder="Enter Boats aggregate capacity" data-validation="required" onkeypress="return IsDecimal(event);"/></div>

</div> <!-- end of col-6 -->
</div> <!-- end of row -->  ';


$value221='<div class="row">
                <div class="col-3"></div>
                <div class="col-3 d-flex justify-content-center">Number of life buoys</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center">Number of buoyancy apparatus</div> <!-- end of div col -->
                <div class="col-3 d-flex justify-content-center"></div> <!-- end of div col -->
                </div>

                <div class="row">
                <div class="col-3 d-flex justify-content-center">'.$label_name.'</div> <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center">

                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                       <input type="text" name="lifebuoys_plyingA" value="" id="lifebuoys_plyingA"  class="form-control"  maxlength="4" autocomplete="off" title="" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/>
                      
                      
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col -->


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                      <input type="text" name="buoyancy_apparatus_plyingA" value="" id="buoyancy_apparatus_plyingA"  class="form-control"  maxlength="4" autocomplete="off" title="" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/>
                    
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col --> 


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                                            </div> <!-- end of div form-group select -->
                      </div> <!-- end of col-3 -->

                </div> <!-- end of row --> ';
$value222='   <div class="row">
                <div class="col-3 d-flex justify-content-center">'.$label_name.'</div> <!-- end of div col -->

                <div class="col-3 d-flex justify-content-center">

                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                       <input type="text" name="lifebuoys_plyingB" value="" id="lifebuoys_plyingB"  class="form-control"  maxlength="4" autocomplete="off" title="" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/>
                      
                      
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col -->


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                      <div class="input-group">
                      <input type="text" name="buoyancy_apparatus_plyingB" value="" id="buoyancy_apparatus_plyingB"  class="form-control"  maxlength="4" autocomplete="off" title="" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/>
                    
                      </div> <!-- end of input-group -->
                      </div> <!-- end of form-group -->
                      </div> <!-- end of div col --> 


                      <div class="col-3 d-flex justify-content-center">
                      <div class="form-group mt-2 mb-2">
                                            </div> <!-- end of div form-group select -->
                      </div> <!-- end of col-3 -->

                </div> <!-- end of row --> ';

$value223='   <div class="row">
<div class="col-3 d-flex justify-content-center">'.$label_name.'</div> <!-- end of div col -->

<div class="col-3 d-flex justify-content-center">

<div class="form-group mt-2 mb-2">
<div class="input-group">
<input type="text" name="lifebuoys_plyingC" value="" id="lifebuoys_plyingC"  class="form-control"  maxlength="4" autocomplete="off" title="" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/>


</div> <!-- end of input-group -->
</div> <!-- end of form-group -->
</div> <!-- end of div col -->


<div class="col-3 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
<div class="input-group">
<input type="text" name="buoyancy_apparatus_plyingC" value="" id="buoyancy_apparatus_plyingC"  class="form-control"  maxlength="4" autocomplete="off" title="" data-validation="required" onkeypress="return IsNumeric(event);" onchange="return IsZero(this.id);"/>

</div> <!-- end of input-group -->
</div> <!-- end of form-group -->
</div> <!-- end of div col --> 


<div class="col-3 d-flex justify-content-center">
<div class="form-group mt-2 mb-2">
                  </div> <!-- end of div form-group select -->
</div> <!-- end of col-3 -->

</div> <!-- end of row --> ';




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
  }
     $value="value".$labelId;
  ?>
    <!-- Creating New Row -->
    <div class="row no-gutters  <?php echo $style; ?>">
    <div class="col-12">
    <?php echo ${$value}; ?>
    </div> <!-- end of col-12 -->
    </div> <!-- end of row -->
 
<?php
} //End of Foreach


} // end of main IF
?>



<div class="row mx-0 mb-3 no-gutters eventab">
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

<!-- ______________________ Fire Fighting Equipment  End_________________________ -->






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