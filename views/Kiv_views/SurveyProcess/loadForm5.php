
<script type="text/javascript">
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

<script language="javascript">

$(document).ready(function(){	
	
  $("#bulk_heads_show").show(); //hide when Particulars of Hull Tab Load
  $("#num_bulk").show();

  $("#show_headplacement").hide();

  $("#show_vessel_length_overall").hide();
  $("#Ton").hide();
  $("#Ton_upperdeck").hide();
  $("#over_deck_id").hide();
  $("#over_deck_id_value").hide();
  $("#upper_deck_id").hide();
  $("#upper_deck_id_value").hide();



   
$("#vessel_length_overall").change(function() 
{
  var iszero=($("#vessel_length_overall").val());
  
  if( (iszero==0)  || (iszero=='.'))
  {
    alert("Invalid Number");
    $("#vessel_length_overall").val('');
    $("#vessel_length_overall").focus();
    return false;
  }
});

      
$("#month_id").change(function()
{
  var month_id=$("#month_id").val();
  var vessel_expected_completion=$("#vessel_expected_completion").val();

  var mm    =   new Date().getMonth();
  var newmm   =   mm+1;
  var year  =   new Date().getFullYear();

  if((month_id<newmm && vessel_expected_completion<year) || (month_id<newmm && vessel_expected_completion==year))
  {
    alert("Invalid Month");
    $("#month_id").val('');
  }

});
      
$("#datepicker2").change(function()
{
  var yard_accreditation_expiry_date=$("#datepicker2").val(); 
  var today   = new Date();
  var dd      = today.getDate();
  var mm      = today.getMonth()+1; //January is 0!
  var yyyy    = today.getFullYear();

  if(dd<10)
  {
    dd='0'+dd;
  } 
  if(mm<10)
  {
    mm='0'+mm;
  } 

  var today1 = dd+'/'+mm+'/'+yyyy;
  if(yard_accreditation_expiry_date<today1)
  {
    alert("Invalid Date");
    $("#datepicker2").val('');
  }
});
      
      
$("#datepicker3").change(function()
{

  var vessel_pref_inspection_date=$("#datepicker3").val(); 
  var today   = new Date();
  var dd      = today.getDate();
  var mm      = today.getMonth()+1; //January is 0!
  var yyyy    = today.getFullYear();
  if(dd<10)
  {
    dd='0'+dd;
  } 
  if(mm<10)
  {
    mm='0'+mm;
  } 
  var today1 = dd+'/'+mm+'/'+yyyy;

  if(vessel_pref_inspection_date<today1)
  {
    alert("Invalid Date");
    $("#datepicker3").val('');
  }
});

  
           
  
/*----------------------------------------------------------------------*/
/*                             Vessel Details                           */
/*----------------------------------------------------------------------*/
/*tab1 click start*/ 
$("#tab1next").click(function() 
{
	  var grt    		    = $("#grt").val();
    var nrt 		      = $("#nrt").val();
    var placeofBuild  = $("#placeofBuild").val();
    var dateofBuild   = $("#dateofBuild").val();
    var vesselId   	  = $("#hdn_vesselId").val();
    //alert(grt);alert(nrt);alert(placeofBuild);alert(dateofBuild);alert(vesselId);

 	  if($("#form1").isValid())
  	{
	  	$.ajax({
	  	url : "<?php echo site_url('Surveyprocess/saveTab1/')?>",
	  	type: "POST",
	  	//dataType: "JSON",
	  	data:$('#form1').serialize(),

	  	success: function(data)
	  	{ 
         //alert(data);
        if(data!="val_errors")
        {
          alert("Vessel Details Inserted.");
  	      $('.nav-item a[href="#tab2"]').tab('show');
  	      $("#hulldetails").html(data).find(".select2").select2();  
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
/*--------------------------tab1 click End-----------------------------*/  
  
/*----------------------------------------------------------------------*/
/*                             Hull Details                             */
/*----------------------------------------------------------------------*/
/*tab2 click start*/ 

$("#tab2next").click(function()
{ 
  if($("#form2").isValid())
  {
    $.ajax({
    //url : "<?php //echo site_url('Survey/add_hull_details/')?>",
    url : "<?php echo site_url('Surveyprocess/saveTab2/')?>",
    type: "POST",
    //dataType: "JSON",
    data:$('#form2').serialize(),
    success: function(data)
    { //alert(data);alert(data);
      if(data!="val_errors")
      {
        //$(".hdn_hullmaterial_id").val(hullmaterial_id); 
        alert("Hull Details Inserted.");
        $('.nav-item a[href="#tab3"]').tab('show');
        $("#engine1").prepend(data).find(".select2").select2();
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
/*--------------------------tab2 click End-----------------------------*/  

$("#hullmaterial_id").change(function()
{
  var id=$("#hullmaterial_id").val();
  if(id==2)
  {
    $('#hullplating_material_id').attr("disabled", 'true'); 
  }
  else
  {
    $('#hullplating_material_id').removeAttr("disabled");
  }
});
//---tab2 click End---//
      
      //------------------- Particulars of Engine ---------------//     
$("#chg_engine").click(function()
{
  var no_of_engineset=$("#no_of_engineset").val();
  if(no_of_engineset!='')
  { 
    $.ajax({
    type: "POST",
    url:"<?php echo site_url('/Kiv_Ctrl/Survey/no_of_engineset/')?>"+no_of_engineset,
    success: function(data)
    { 
      $("#show_engine_set").html(data).find(".select2").select2();
    }
    });
  }
});
       

 
/*----------------------------------------------------------------------*/
/*                    Particulars of Engine                             */
/*----------------------------------------------------------------------*/
/*tab3 click start*/
$("#tab3next").click(function() 
{ 
  if($("#form3").isValid())
  {
    $.ajax({
    url : "<?php echo site_url('Surveyprocess/saveTab3/')?>",
    type: "POST",
    data:$('#form3').serialize(),
    //dataType: "JSON",
    success: function(data)
    { //alert(data);
      if(data!="val_errors")
      { 
  	      alert("Particulars of Engine Inserted.");
  	      $('.nav-item a[href="#tab4"]').tab('show');
  	      $("#machine").html(data).find(".select2").select2(); 
  	      //Datemask dd/mm/yyyy
  	      $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
  	      $("[data-mask]").inputmask();
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
/*--------------------------tab3 click End-----------------------------*/  
 
/*----------------------------------------------------------------------*/
/*                         Machine Details                              */
/*----------------------------------------------------------------------*/
/*tab4 click start*/

$("#tab4next").click(function()
{
   if($("#form4").isValid())
   {
      $.ajax({
        //url : "<?php //echo site_url('Survey/add_equipment_details/')?>",
        url : "<?php echo site_url('Surveyprocess/saveTab4/')?>",
        type: "POST",
        data:$('#form4').serialize(),
        //dataType: "JSON",
        success: function(data)
        { 	//alert(data); 
	        if(data!="val_errors")
	      	{ 		      	    
		        alert("Machine Details Inserted.");
		        $('.nav-item a[href="#tab5"]').tab('show');
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


/*--------------------------tab4 click End-----------------------------*/  
   

 
/*----------------------------------------------------------------------*/
/*                            Crew Details                              */
/*----------------------------------------------------------------------*/
/*tab5 click start*/   
$("#tab5next").click(function()
{
 if($("#form5").isValid())
  { 
    $.ajax({
      //url : "<?php //echo site_url('Survey/add_fire_appliance/')?>",
      url : "<?php echo site_url('Surveyprocess/saveTab5/')?>",
      type: "POST",
      data:$('#form5').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
        alert("Crew Details Inserted.");
        $('.nav-item a[href="#tab6"]').tab('show');
        $("#passengerdetails").html(data).find(".select2").select2(); 
      }
    }); 
  }
});  
/*--------------------------tab5 click End-----------------------------*/  
   
  

/*----------------------------------------------------------------------*/
/*                       Passenger Details                              */
/*----------------------------------------------------------------------*/
/*tab6 click start*/  

$("#tab6next").click(function() 
{
  
  if($("#form6").isValid())
  { 
    $.ajax({      
      url : "<?php echo site_url('Surveyprocess/saveTab6/')?>",
      type: "POST",
      data:$('#form6').serialize(),
      //dataType: "JSON",
      success: function(data)
      {
     alert(data);
        alert("Passenger Details Inserted.");
        $('.nav-item a[href="#tab7"]').tab('show');
        $("#conditionOfservice").html(data).find(".select2").select2(); 
      }
    }); 
  }
}); 
/*--------------------------tab6 click End---------------------------*/   


 
/*----------------------------------------------------------------------*/
/*                       Condition of Service                           */
/*----------------------------------------------------------------------*/
/*tab7 click start*/  
$("#tab7next").click(function() 
{
  
  if($("#form7").isValid()) 
  {   
    $.ajax({
      url : "<?php echo site_url('Surveyprocess/saveTab7/')?>",
      type: "POST",
      data:$('#form7').serialize(),
      
      success: function(data)
      {
        
        alert("Condition of Service Inserted.");

        $('.nav-item a[href="#tab8"]').tab('show');
        $("#declaration").html(data).find(".select2").select2();

      }
    }); 
 }     
}); 
/*--------------------------tab7 click End---------------------------*/  
  
  
  
/*---------------------------------------------------------------------*/
/*                              Declaration                            */  
/*---------------------------------------------------------------------*/
/*tab8 click start*/
$("#tab8next").click(function()
{
  if($("#form8").isValid())
  { 
    $.ajax({
      //url : "<?php //echo site_url('Survey/add_payment_details/')?>",
      url : "<?php echo site_url('Surveyprocess/saveTab8/')?>",
      type: "POST",
      data:$('#form8').serialize(),
      //dataType: "JSON",
      success: function(data)
      { alert(data);
        if(data!="val_errors")
        {
          alert("Declaration Inserted.");
          //window.location.href = "<?php echo site_url('Survey/SurveyHome'); ?>";
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
/*--------------------------------------tab8 click Ends----------------*/
  



    $("#tab2back").click(function() {
                $('.nav-item a[href="#tab1"]').tab('show');
    });
    
    $("#tab3back").click(function() {
                $('.nav-item a[href="#tab2"]').tab('show');
    });
    
    $("#tab4back").click(function() {
                $('.nav-item a[href="#tab3"]').tab('show');
    });
      
    $("#tab5back").click(function() {
                $('.nav-item a[href="#tab4"]').tab('show');
    });
    
    $("#tab6back").click(function() {
                $('.nav-item a[href="#tab5"]').tab('show');
    });
  
    $("#tab7back").click(function() {
                $('.nav-item a[href="#tab6"]').tab('show');
    });

     $("#tab8back").click(function() {
                $('.nav-item a[href="#tab7"]').tab('show');
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
              window.alert("Characters other than Alphabets,Numbers and ,./()- are not allowed. ");
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

function onPaste(id)
	{ alert("fsd");
	 $('id').bind("cut copy paste", function(e) {alert("fsd");
        e.preventDefault();
         alert("You cannot paste into this text field.");
        $('id').bind("contextmenu", function(e) {
            e.preventDefault();
        });
    });
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
    <li class="breadcrumb-item"><a class="no-link" href="<?php echo base_url(); ?>index.php/Survey/csHome"><i class="fas fa-home"></i>&nbsp;Home</a></li>
    <li class="breadcrumb-item"><a href="#">List Page</a></li>
  </ol>
</nav> 
<!-- End of breadcrumb -->
<div class="main-content ">  <!-- Container Class overridden for edge free design -->
  <div class="row">
  <div class="col-12"> 
  	<div class="row">
  		<div class="col-2 mt-1 ml-5">
  			 <button type="button" class="btn btn-primary kivbutton btn-block"> Form 5</button> 
  		</div> <!-- end of col-2 -->
      <div class="col mt-2 text-primary">
        See Rule 5 (1) - Form for expressing the intention to build a new vessel
      </div>
  	</div> <!-- inner row -->
  </div> <!-- end of col-12 add-button header -->
  <div class="col-12 mt-2 ml-2 newfont">  
  	<?php //include ('tab.php'); ?>





<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="vesseltab" data-toggle="tab" href="#tab1" role="tab" aria-controls="VesselDetails" aria-selected="true">Vessel Details</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="hulltab" data-toggle="tab" href="#tab2" role="tab" aria-controls="Hull" aria-selected="false">Hull Details</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="enginetab" data-toggle="tab" href="#tab3" role="tab" aria-controls="Engine" aria-selected="false">Particulars of Engine</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="machinetab" data-toggle="tab" href="#tab4" role="tab" aria-controls="Equipment" aria-selected="false">Machine</a>
  </li>

   <li class="nav-item">
    <a class="nav-link" id="crewdetailstab" data-toggle="tab" href="#tab5" role="tab" aria-controls="FireAppliance" aria-selected="false">Crew Details</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="passengerdetailstab" data-toggle="tab" href="#tab6" role="tab" aria-controls="PassengerDetails" aria-selected="false">Passenger Details</a>
  </li>

   <li class="nav-item">
    <a class="nav-link" id="conditionOfservicetab" data-toggle="tab" href="#tab7" role="tab" aria-controls="Document" aria-selected="false">Condition of Services</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" id="declarationtab" data-toggle="tab" href="#tab8" role="tab" aria-controls="Payment" aria-selected="false">Declaration</a>
  </li>

</ul>

<div class="tab-content " id="myTabContent">

<?php

/*$form_id=5;
$heading=10;
$vesselType=2;
$vesselSubtype=10;
$lengthOverDeck=15;
$hull_id=9999;
$engine_id=9999;
$startDate='2012-12-12';
$endDate='0000-00-00';*/
 ?>
 
<!-- ______________________ Vessel Details  Start_________________________ -->
<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="vesseltab">
<!-- start of content in tab pane -->
<form name="form1" id="form1" method="post" class="form1" > 
 
<?php 
if($this->session->flashdata('msg'))
{
  echo $this->session->flashdata('msg');
}
?>
<input type="hidden" name="hdn_vesselId" id="hdn_vesselId" value="<?php echo $vesselId; ?>" >
<div class="row no-gutters mx-3 mb-3 mt-2">
<div class="col-12">
<?php
//echo $a=count($fieldstoShow);
//print_r($fieldstoShow);
//print_r($vesselId);
if (count($fieldstoShow)!=0) 
{
$row_count=0;
$row_color=0;
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
	
    <?php $value89='<div class="col-3 border-bottom ">
    <p class="mt-3 mb-3">'.$label_name.'</p>
    </div><!-- end of col-2 ves_div1 -->

    <div class="col-3 border-bottom  ">
      <div class="form-group mt-2 mb-2">
          <input type="text" name="grt" value="" id="grt"  class="form-control"  maxlength="10" autocomplete="off" placeholder="Enter Gross Registered Tonnage" data-validation="required" required onkeypress="return IsDecimal(event);" onpaste="return false;" onchange="return IsZero(this.id);" /> 
      </div> <!-- end of form group -->
    </div> <!-- end of col-2 ves_div1 -->';?>
   
    <?php $value90='<div class="col-3 border-bottom border-left ">
      <p class="mt-3 mb-3 ">'.$label_name .' </p>
    </div>
    <div class="col-3 border-bottom  ">    
      <div class="form-group mt-2 mb-2">
          <input type="text" name="nrt" value="" id="nrt"  class="form-control"  maxlength="10" autocomplete="off" placeholder="Enter Net Registered Tonnage" data-validation="required" required onkeypress="return IsDecimal(event);" onpaste="return false;" onchange="return IsZero(this.id);" /> 
      </div> <!-- end of form group -->
    </div>';?>



    <?php $value95='<div class="col-3 border-bottom">
      <p class="mt-3 mb-3">'.$label_name .'</p>
    </div> <!-- end of col-2 -->

    <div class="col-3 border-bottom">
      <div class="form-group mt-2 mb-2">
        <input type="text" name="placeofBuild" value="" id="placeofBuild"  class="form-control"  maxlength="50" autocomplete="off" placeholder="Enter Place of Build" data-validation="required" required onpaste="return false;" onkeypress="return alpbabetspace(event);" onchange="return IsZero(this.id);" />
      </div> <!-- end of form group -->
    </div> <!-- end of col -->';?>

    <?php $value96='<div class="col-3 border-bottom border-left ">
      <p class="mt-2 mb-3">'.$label_name .'</p>
    </div>

    <div class="col-3 border-bottom ">
      <div class="form-group mt-2 mb-2">
        <input type="text" name="dateofBuild" value="" id="dateofBuild"  class="form-control dob" onpaste="return false;"  maxlength="10" autocomplete="off" placeholder="dd/mm/yyyy" data-validation="required" required />
      </div> <!-- end of form group -->
    </div><!-- end of col -->';?>



<?php 
  // Placing Div Elements from here
	if($row_count==0)
	{	
		$row_count=1;
		if($row_color==0)
		{
			$style='oddtab';
			$row_color=1;
		}
		else 
		{
		   $style="eventab";
		   $row_color=0;
		}
?>

 <!--Place the data div inside the row div-->
	<div class="row no-gutters  <?php echo $style; ?>"><!--placing row .opened-->
	<?php
	$value="value".$labelId;
  	echo ${$value};
  	}
  	else // Already a row has been opened.
	{
		$row_count=0;
	
		$value="value".$labelId;
  		echo ${$value};
  		?>
  	</div> <!-- end of opened placing row -->

  	<?php
	} //End of var_row condition	
  
  }/*End of foreach*/
  }/*End of Main if*/ 

  /*style for the save button*/
  if($row_color==0)
		$style='oddtab';
  else 
		$style="eventab";
  /*style for the save button*/
	
?>
  
   <div class="row no-gutters d-flex justify-content-end <?php echo $style; ?>">
    <div class="col-1"> 
     <button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab1next" id="tab1next" ><i class="far fa-save"></i>&nbsp;Save</button>
    </div> <!-- end of col-2 save col -->
   </div> <!-- end of eventab -->
    </div> <!-- end of col-12 inside row in the tab pane -->
    </div> <!-- end of main inside row in the tab pane -->
</form>
  </div><!-- end of tab-pane 1 -->


<!-- ______________________ Vessel Details  End_________________________ -->


<!-- ______________________ Hull Details Start_________________________ -->

<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="hulltab">
<form name="form2" id="form2" method="post" >

<div class="row no-gutters mx-0 mt-2">
<div class="col-12"  id="hulldetails"> 
<!-- container for hull details -->

<!-- end of inside content -->
</div> <!-- End of content col -->
</div><!-- End of content row -->
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab2next" id="tab2next" ><i class="far fa-save"></i>&nbsp;Savepage</button>
</form>
<!-- end of content in tab pane -->
</div><!-- end of tab-pane 2 -->
<!-- ______________________ Hull Details End_________________________ -->



<!-- ______________________Particulars of Engine  Start_________________________ -->

<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="enginetab">
<!-- start of content in tab pane -->
<form name="form3" id="form3" method="post" >

<div class="row no-gutters mx-0 mt-2">
<div class="col-12"  id="engine1"> 
<!--Form3 content will be load here-->

<!--Form3 content will be load here-->
</div> <!-- End of content col -->
</div><!-- End of content row -->
<div class="col-1 d-flex justify-content-end">

<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab3next" id="tab3next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</form>
<!-- end of content in tab pane -->
</div><!-- end of tab-pane 3 -->

<!-- ______________________ Particulars of Engine  End_________________________ -->

<!-- ______________________ Machine Details Start_________________________ -->

<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="machinetab">
<!-- start of content in tab pane -->
<form name="form4" id="form4" method="post" >


<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="machine">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div> <!-- end of col-10 -->
<!--<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab4back" id="tab4back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  
</div> --><!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab4next" id="tab4next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div> <!-- end of button col -->
</div> <!-- end of row -->
</form>
</div> <!-- end of tab-pane -->
<!-- ______________________ Machine Details End_________________________ -->


<!-- ______________________ Crew Details Start_________________________ -->

<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="crewdetailstab">
<!-- start of content in tab pane -->
<form name="form5" id="form5" method="post" >

<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="crewdetails">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters oddtab">
<div class="col-10"></div>
<!--<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab5back" id="tab5back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  
</div> --><!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab5next" id="tab5next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>

</form>
</div>
<!-- ______________________ Crew Details End_________________________ -->

              
<!--________________________ Passenger Details Start_____________________________ -->

<div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="passengerdetailstab">
<form name="form6" id="form6" method="post">  

<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="passengerdetails">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<!--<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab6back" id="tab6back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  
</div> --><!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab6next" id="tab6next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>
</form>
</div>
<!--________________________ Passenger Details End_____________________________ -->



<!--________________________ Condition of Service Start_____________________________ -->

<div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="conditionOfservicetab">
<form name="form7" id="form7" method="post" >  

<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="conditionOfservice">
</div>  <!-- end of col-12 -->
</div> <!-- end of row -->

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<!--<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab7back" id="tab7back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  
</div>--> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab7next" id="tab7next" ><i class="far fa-save"></i>&nbsp;Save</button>
</div>
</div>
</form>
</div>
<!--________________________ Condition of Service End_____________________________ -->


<!--________________________ Declaration Start_____________________________ -->

<div class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="declarationtab">
<form name="form8" id="form8" method="post">  

<div class="row no-gutters mx-0 mt-2">
<div class="col-12" id="declaration">
<!--replace declaration details here-->
</div>  <!-- end of col-12 -->
</div>

<div class="row mx-0 mb-3 no-gutters eventab">
<div class="col-10"></div>
<!--<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-warning btn-flat btn-point btn-sm" name="tab8back" id="tab8back"><i class="fas fa-step-backward"></i>&nbsp;Back</button>  
</div>--> <!-- End of button col -->
<div class="col-1 d-flex justify-content-end">
<button type="button" class="btn btn-success btn-flat  btn-point btn-sm" name="tab8next" id="tab8next" ><i class="far fa-save"></i>&nbsp;Submit</button>
</div>
</div>
</form>
</div>
<!--________________________ Declaration End_____________________________ -->




</div> <!-- end of tab -content -->
  </div> <!-- end of col-12 main col -->
</div> <!-- end of main row -->
</div> <!-- end of container div -->
