
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
    
$(document).ready(function(){
  
	$("#bulk_heads_show").show(); //hide when Particulars of Hull Tab Load
	$("#num_bulk").show();

	//$("#show_headplacement").hide();
	$("#show_vessel_length_overall").hide();
	$("#Ton").hide();
	$("#Ton_upperdeck").hide();
	$("#over_deck_id").hide();
	$("#over_deck_id_value").hide();
	$("#upper_deck_id").hide();
	$("#upper_deck_id_value").hide();
   /*     
      $("#id_ap1").hide();
      $("#id_ap2").hide();
      $("#id_ap3").hide();
      
     $("#id_cp1").hide(); 
     $("#id_cp2").hide(); 
     $("#no_of_anchor").change(function(){
         var no_of_anchor=$("#no_of_anchor").val();
         if(no_of_anchor>3)
         {
             alert("Invalid Number");
             $("#no_of_anchor").val('');
         }
        
        else
        {
         if(no_of_anchor==1)
         {
                $("#id_ap1").show();
                $("#id_ap2").hide();
                $("#id_ap3").hide();
                $("#id_cp1").show(); 
                $("#id_cp2").hide();
         }
         else
         {
                $("#id_ap1").show();
                $("#id_ap2").show();
                $("#id_ap3").show();
                $("#id_cp1").show(); 
                $("#id_cp2").show();
         }
     }
         
     });
       */
$("#vessel_no_of_deck").change(function() 
{
	var no_deck=parseInt($("#vessel_no_of_deck").val());
	if(no_deck==1)
	{
		$("#over_deck_id").show();
		$("#over_deck_id_value").show();
		$("#upper_deck_id").hide();
		$("#upper_deck_id_value").hide();
	}
	else
	{
		$("#over_deck_id").show();
		$("#over_deck_id_value").show();
		$("#upper_deck_id").show();
		$("#upper_deck_id_value").show();
	}
});
      
$("#month_id").change(function()
{
	var month_id=$("#month_id").val();
	var vessel_expected_completion=$("#vessel_expected_completion").val();

	var mm 		= 	new Date().getMonth();
	var newmm 	= 	mm+1;
	var year 	= 	new Date().getFullYear();

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

      
    /*  
    $('#step_2').fadeTo("fast", .5);
    $('.step_2').removeAttr("href");
    
    $('#step_3').fadeTo("fast", .5);
    $('.step_3').removeAttr("href");
    $("#tab_2").hide();
    */

           
  //-------------------Vessel Details---------------//  
  //----tab1 Click Start----//    


$("#tab1next").click(function() 
{
	if($("#form1").isValid())
	{
		var vessel_type_id 		=	$("#vessel_type_id").val();
		var vessel_subtype_id 	=	$("#vessel_subtype_id").val();
		var vessel_length 		=	$("#vessel_length").val();

		var hullmaterial_id 	=	$("#hullmaterial_id").val();
		var engine_placement_id =	$("#engine_placement_id").val();



		$.ajax({
		url : "<?php echo site_url('Survey/add_vessel_details/')?>",
		type: "POST",
		//dataType: "JSON",
		data:$('#form1').serialize(),
		success: function(data)
		{
			$(".hdn_vessel_type").val(vessel_type_id);
			$(".hdn_vessel_subtype").val(vessel_subtype_id);
			$(".hdn_vessel_length").val(vessel_length);
			$(".hdn_engine_inboard_outboard").val(engine_placement_id);
			$(".hdn_hullmaterial_id").val(hullmaterial_id);

			 

			alert("Vessel Details inserted Successfully");
			$('.nav-tabs a[href="#tab_2"]').tab('show');  
			//$("#hulldetails").html(data).find(".div200").select2(); 
			$("#hulldetails").html(data).find(".div200").select2(); 

			/*     
			if(data['val_errors']!="")
			{
			$("#msgDiv").show();
			alert(data['val_errors']);
			document.getElementById('msgDiv').innerHTML="<font color='#fff'>"+data['val_errors']+"</font>";
			}	
			else
			{
			$("#msgDiv").hide();
			}

			*/             
		}
		});
	}

});  //----tab1 Click End----//  

$("#vessel_category_id").change(function()
{
	var vessel_category_id=$("#vessel_category_id").val();
	if(vessel_category_id != '')
	{ 
		$.ajax
		({
		type: "POST",
		url:"<?php echo site_url('/Survey/vessel_subcategory/')?>"+vessel_category_id,
		success: function(data)
		{					
			$("#vessel_subcategory_id").html(data);
		}
		});
	}
});
        
        
        
        
	
	
$("#vessel_type_id").change(function()
{
	var vessel_type_id=$("#vessel_type_id").val();


	if(vessel_type_id==1)
	{
		$("#show_vessel_length_overall").show();
	}
	else
	{
		$("#vessel_length_overall").val('');
		$("#show_vessel_length_overall").hide();
	}

	if(vessel_type_id != '')
	{ 
		$.ajax
		({
		type: "POST",
		url:"<?php echo site_url('/Survey/vessel_subtype/')?>"+vessel_type_id,
		success: function(data)
		{					
			$("#vessel_subtype_id").html(data);
		}
		});


		$.ajax
		({
		type: "POST",
		url:"<?php echo site_url('/Survey/vessel_type_id/')?>"+vessel_type_id,
		success: function(data)
		{					
			if(data==1)			
			{

				$("#show_vessel_length_overall").show();
			}
			else
			{
				$("#vessel_length_overall").val('');
		 		$("#show_vessel_length_overall").hide();
			}
		}
		});



	}
});


        
$("#vessel_subtype_id").change(function()
{
	
	var vessel_subtype_id=$("#vessel_subtype_id").val();

	$.ajax
		({
		type: "POST",
		url:"<?php echo site_url('/Survey/vessel_subtype_id/')?>"+vessel_subtype_id,
		success: function(data)
		{		
			if(data==1)			
			{

				$("#show_vessel_length_overall").show();
			}
			else
			{
				$("#vessel_length_overall").val('');
		 		$("#show_vessel_length_overall").hide();
			}
		}
		});




});
	
$("#check_tonnage").click(function()
{
	var vessel_length 		=	$("#vessel_length").val();
	var vessel_breadth 		=	$("#vessel_breadth").val();
	var vessel_depth 		=	$("#vessel_depth").val();
	var tonnage 			= 	(((vessel_length)*(vessel_breadth)*(vessel_depth))/2.83);
	var result 				= 	Math.round(tonnage);
	$("#Ton").show();
	$("#show_tonnage").html(result).append(' Ton');
});
        
       
$("#check_tonnage_upperdeck").click(function()
{
	var vessel_upperdeck_length=$("#vessel_upperdeck_length").val();
	var vessel_upperdeck_breadth=$("#vessel_upperdeck_breadth").val();
	var vessel_upperdeck_depth=$("#vessel_upperdeck_depth").val();
	var tonnage_upperdeck=(((vessel_upperdeck_length)*(vessel_upperdeck_breadth)*(vessel_upperdeck_depth))/2.83);
	var result= Math.round(tonnage_upperdeck);
	$("#Ton_upperdeck").show();
	$("#show_upperdeck_tonnage").html(result).append(' Ton');
});  
       
       
    //-------------------Particulars of Hull---------------//    
     
$("input[type='radio'][name='freeboard_status_id']").click(function() 
{
  if ($("input[type='radio'][name='freeboard_status_id']:checked").val()=='0')
  {
           var num=$("#num_bulk").val();
           //var num=$("#bulk_heads").val();
           //alert(num);
           for(i=1; i<=num;$i++)
           {
              	$('#bulk_head_placement'+i).val($(this).data('val')).trigger('change');
            	$("#bulk_head_thickness"+i).val('');
           }
          
		        $("#bulk_heads_show").hide();  
		        $("#num_bulk").hide();
			$("#show_headplacement").hide();
       }
       else
       {
			$("#bulk_heads").val('');
			$("#bulk_heads_show").show();  
			$("#num_bulk").show();
    	}
});  
  
$("#bulk_heads").change(function()
{
    var num=$("#bulk_heads").val();
    if(num!='')
	{ 
	$.ajax
		({
			type: "POST",
			url:"<?php echo site_url('/Survey/no_of_bulkhead/')?>"+num,
			success: function(data)
			{	
	        //alert(data);
			$("#show_headplacement").show();
			$("#show_headplacement").html(data).find(".div200").select2();
			}
		});
	}
    //alert(num);
});
	
	
//--tab2 click start---//	
$("#tab2next").click(function()
{
	//var hullmaterial_id=$("#hullmaterial_id").val();
	if($("#form2").isValid())
	{
		$.ajax({
		url : "<?php echo site_url('Survey/add_hull_details/')?>",
		type: "POST",
		//dataType: "JSON",
		data:$('#form2').serialize(),
		success: function(data)
		{
			//$(".hdn_hullmaterial_id").val(hullmaterial_id); 
			alert("Hull Details inserted Successfully");
			$('.nav-tabs a[href="#tab_3"]').tab('show');
			$("#engine1").prepend(data).find(".div200").select2();
		}
		});
	}
     
}); 

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
		url:"<?php echo site_url('/Survey/no_of_engineset/')?>"+no_of_engineset,
		success: function(data)
		{	
			$("#show_engine_set").html(data).find(".div200").select2();
		}
		});
	}
});
         
         
      
$("#number_hydrant").change(function()
{
	var hydrant= $("#number_hydrant").val();
	$("#number_hose").val(hydrant);
});
      
       
//-----tab3 click start------//
$("#tab3next").click(function() 
{
	//var engine_placement_id=$("#engine_placement_id").val();
	if($("#form3").isValid())
	{
		$.ajax({
		url : "<?php echo site_url('Survey/add_engine_details/')?>",
		type: "POST",
		data:$('#form3').serialize(),
		//dataType: "JSON",
		success: function(data)
		{
			//$(".hdn_engine_inboard_outboard").val(engine_placement_id); 
			alert("Engine Details inserted Successfully");
			$('.nav-tabs a[href="#tab_4"]').tab('show');
			$("#equipment1").html(data).find(".div200").select2(); 
		}
		});
	} 
}); //---tab3 click End---//
  
	
  
    
   
 
   //------------------- Particulars of Equipment ---------------// 
  //-----tab4 click start------//
 $("#tab4next").click(function()
 {
  
/*
    weight1 
    material_id1
    weight2

    material_id2
    weight3
    material_id3
    size4
    length4
    equipment_type_id4 
    
    size5
    length5
    equipment_type_id5
    
    size6
    number6
    material_id6
    number7
    power7
    size7 
    number8 
    number9 
    nav_equipment_id
    sound_equipment_id
    
*/
	if($("#form4").isValid())
	{
		$.ajax({
			url : "<?php echo site_url('Survey/add_equipment_details/')?>",
			type: "POST",
			data:$('#form4').serialize(),
			//dataType: "JSON",
			success: function(data)
			{
				alert("Equipment Details inserted Successfully");
				$('.nav-tabs a[href="#tab_5"]').tab('show');
				$("#fireappliance1").html(data).find(".div200").select2(); 
			}
		});   
	}

});  //---tab4 click End---//
	
	//------------------- Particulars of Fire Appliance ---------------// 
  //-----tab5 click start------//
	
$("#tab5next").click(function()
{
	/* 
	number1
	capacity1
	size1
	material_id1 
	diameter1
	number2
	number3
	nozzle_type
	fire_extinguisher_number[]
	*/
	if($("#form5").isValid())
	{	
		$.ajax({
			url : "<?php echo site_url('Survey/add_fire_appliance/')?>",
			type: "POST",
			data:$('#form5').serialize(),
			//dataType: "JSON",
			success: function(data)
			{
				alert("Fire Appliance Details inserted Successfully");
				$('.nav-tabs a[href="#tab_6"]').tab('show');
				$("#otherequipment1").html(data).find(".div200").select2(); 
			}
		}); 
	}
});
	
//------tab5 click End---//
    
	
	
	
	//------------------- Particulars of Other Equipments ---------------// 
  //-----tab6 click start------//
	
$("#tab6next").click(function() 
{
    /* 
    list1 
    list2 
    list3 
    sewage_treatment
    solid_waste
    sound_pollution
    water_consumption 
    source_of_water
    */
	if($("#form6").isValid())
	{	
		$.ajax({
			url : "<?php echo site_url('Survey/add_other_equipments/')?>",
			type: "POST",
			data:$('#form6').serialize(),
			//dataType: "JSON",
			success: function(data)
			{
			//alert(data);
				alert("Other Equipments Details inserted Successfully");
				$('.nav-tabs a[href="#tab_7"]').tab('show');

				$("#documents1").html(data).find(".div200").select2(); 
			}
		}); 
	}
});
	
//------tab6 click End---//
	


	//------------------- Particulars of Documents ---------------// 
  //-----tab7 click start------//
	
$("#tab7next").click(function(e) {
	var data = new FormData();
	var form_data = $('#form7').serializeArray();
	$.each(form_data, function (key, input)
	{
		data.append(input.name, input.value);
	});
	for(var j=1; j<=7; j++)
	{
		var file_data = $('input[name="myFile'+j+'"]')[0].files;
		for (var i = 0; i < file_data.length; i++) 
		{
			data.append("myFile"+j+"[]", file_data[i]); 
		}
	}
	data.append('key', 'value');
	if($("#form7").isValid())
	{	  
		$.ajax({
			url : "<?php echo site_url('Survey/add_vessel_documents/')?>",
			type: "POST",
			//data:$('#form7').serialize(),
			data: data,
			contentType: false,       
			cache: false,             
			processData:false, 

			success: function(data)
			{
				//alert(data);
				alert("Vessel Documents Details inserted Successfully");
				$('.nav-tabs a[href="#tab_8"]').tab('show');
			}
		}); 
	}			
});

 
     
     
     
        
        
//------tab7 click End------//
	
	
	
  
	//------------------- Payment Details ---------------// 
  //-----tab8 click start------//

$("#tab8next").click(function()
{
	if($("#form8").isValid())
	{	
		$.ajax({
			url : "<?php echo site_url('Survey/add_payment_details/')?>",
			type: "POST",
			data:$('#form8').serialize(),
			//dataType: "JSON",
			success: function(data)
			{
				//alert(data);
				alert("Payment Details inserted Successfully");
				window.location.href = "<?php echo site_url('Survey/InitialSurvey'); ?>";
			}
		}); 
	}
});
	
//------tab8 click End---//
  



    $("#tab2back").click(function() {
                $('.nav-tabs a[href="#tab_1"]').tab('show');
    });
  	
    $("#tab3back").click(function() {
                $('.nav-tabs a[href="#tab_2"]').tab('show');
    });
    
    $("#tab4back").click(function() {
                $('.nav-tabs a[href="#tab_3"]').tab('show');
    });
      
    $("#tab5back").click(function() {
                $('.nav-tabs a[href="#tab_4"]').tab('show');
    });
    
    $("#tab6back").click(function() {
                $('.nav-tabs a[href="#tab_5"]').tab('show');
    });
	
    $("#tab8back").click(function() {
                $('.nav-tabs a[href="#tab_7"]').tab('show');
    });
    $("#tab7back").click(function() {
                $('.nav-tabs a[href="#tab_6"]').tab('show');
    });
	
	

	
	
	
//------------JQUERY END--------------------//	

});

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
        
</script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
<button type="button" class="btn bg-primary btn-flat margin"> Form 1 </button>
      <!-- Important; the following two ol class has to be kept, its not mistake -->
      <ol class="breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?php echo $site_url."/Survey/SurveyHome"?>"><i class="fa fa-dashboard"></i>  <span class="badge bg-blue"> Home </span> </a></li>
<li><a href="<?php echo $site_url."/Survey/InitialSurvey"?>"></i>  <span class="badge bg-blue"> Initial Survey DashBoard </span> </a></li>       
 <li><a href="#"></i>  <span class="badge bg-blue"> Form 1 </span> </a></li>
        <!--<li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li> -->
      </ol> </ol> 
      <!-- End of two ol -->
    </section>
    <!-- Bread Crumb Section Ends Here .... -->
    <!-- Header Section ends here -->
    <!-- Main content -->
    <section class="content">
   <!-- Main Content starts here -->

     <div class="row custom-inner">
      <!-- start inner custom row -->

        <div class="col-md-12">
          <div class="box box-solid">
          <div class="box-header with-border">
              <h3 class="box-title" style="color: #00f">Form 1 </h3>
              <?php
 
              ?>
	<p>  See Rule 5 (1) - Form for expressing the intention to build a new vessel <input type="hidden" name="stage_count" id="stage_count" value="<?php //echo $stage_count; ?>"> </p>
	</div> 

	<div class="box-body">
	<!-- Custom Tabs -->
	<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#tab_1" data-toggle="tab">Vessel Details</a></li>
	<li id="step_2"><a href="#tab_2" data-toggle="tab" class="step_2">Particulars of Hull</a></li>
	<li id="step_3"><a href="#tab_3" data-toggle="tab" class="step_3">Particulars of Engine</a></li>
	<li><a href="#tab_4" data-toggle="tab">Particulars of Equipment</a></li>
	<li><a href="#tab_5" data-toggle="tab">Particulars of Fire Appliance</a></li>
	<li><a href="#tab_6" data-toggle="tab">Other Equipments</a></li>
	<li><a href="#tab_7" data-toggle="tab">Documents</a></li>
	<li><a href="#tab_8" data-toggle="tab">Payment</a></li>
	<!-- <li><a href="#tab_9" data-toggle="tab">Owner Details</a></li> -->
	</ul>
              

	<div id="msgDiv" class="alert alert-info alert-dismissible" style="display:none"></div>
	<div class="tab-content">
                
              
               
  <!-- ____________________________Vessel Details ___________________________________________ -->


<div class="tab-pane active" id="tab_1">
	<form name="form1" id="form1" method="post" class="form1" > 


	<table id="vacbtable" class="table table-bordered table-striped">

	<tr>
	<td colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ തരം / </small>  <h5> Type of vessel</h5> </font></td>
		<td> <div class="div200">
		<div class="form-group">
		<select class="form-control select2" name="vessel_type_id" id="vessel_type_id" title="Select Vessel Type" data-validation="required">

		<option value="">Select</option>
		<?php foreach ($vesseltype as $res_vesseltype)
		{
		?>
		<option value="<?php echo $res_vesseltype['vesseltype_sl']; ?>"> <?php echo $res_vesseltype['vesseltype_name'];?>  </option>
		<?php
		}	
		?>
		</select> 
		</div>
		<!-- /.form-group -->
		</div></td>
		<td><font color="#282626"> <small> യാനത്തിന്റെ സബ്ടൈപ്പ് / </small>  <h5>  Sub-type of vessel</h5> </font></td>
		<td> <div class="div200">
		<div class="form-group">
		<select class="form-control select2" name="vessel_subtype_id" id="vessel_subtype_id" title="Select Vessel Sub Type" >
		</select>
		</div>
		<!-- /.form-group -->
		</div></td>	
	</tr>
	<tr id="show_vessel_length_overall"> 
		<td  colspan="2"> <font color="#282626"> <small>  </small>  <h5>Length Overall  </h5> </font> </td>
		<td > <div class="div100"> <div class="input-group">
		<input type="text" name="vessel_length_overall" value="" id="vessel_length_overall"  class="form-control"  maxlength="2" autocomplete="off" title="Length Over All" data-validation="number"/>
		<span class="input-group-addon">m</span>
		</div> </div> </td> 
		<td >  </td>
		<td > </td>
	</tr>

	<tr>
	<td colspan="2"><h5> Material of hull</h5></td>   
		<td> 
		<div class="form-group">
		<select class="form-control select2 div200" name="hullmaterial_id" id="hullmaterial_id" title="Enter Materil of Hull" data-validation="required">
		<option value="">Select</option>
		<?php foreach ($hullmaterial as $res_hullmaterial)
		{
		?>
		<option value="<?php echo $res_hullmaterial['hullmaterial_sl']; ?>"> <?php echo $res_hullmaterial['hullmaterial_name'];?>  </option>
		<?php
		}	
		?>

		</select>
		</div>
		</td>
		<td ><h5> Whether Engine inboard/outboard</h5></td>
              <td> 
                 <div class="form-group">
                     <select class="form-control select2 div200" name="engine_placement_id" id="engine_placement_id" title="Select Engine inboard/outboard" data-validation="required">
                         <option value="">Select</option>
                    <?php
                    foreach ($inboard_outboard as $res_inboard_outboard)
                   {
                        ?>
                     <option value="<?php echo $res_inboard_outboard['inboard_outboard_sl']; ?>" <?php //if($res_inboard_outboard['inboard_outboard_sl']==$sltid1) { echo "selected"; }?>> <?php echo $res_inboard_outboard['inboard_outboard_name']; ?>  </option>
                    <?php
                   }
                    ?>
                
                </select>
              </div>
             </td>
	</tr>
	<tr >
		<td colspan="5" height="1"><hr ></td>
		
	</tr>
	

	<tr> 
		<td  colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ പേര്  / </small>  <h5>Vessel name  </h5> </font> 
		</td>
		<td > 
		<div class="div350"> <div class="form-group">
		<input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" title="Enter Vessel Name" data-validation="required"/>
		</div> </div>
		</td> 

		<td > 
		<font color="#282626"> <small> നിർമ്മാണം പൂർത്തീകരിക്കാവുന്ന വർഷം / </small>  <h5>Proposed year and month of completion  </h5> </font>
		</td>
		<td > 
		<div class="div100"><div class="form-group">
		<input type="text" name="vessel_expected_completion" value="2018" id="vessel_expected_completion"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Proposed Year of Completion"  data-validation="number"/> 
		</div></div>

		<div class="div200">
		<div class="form-group">
		<select class="form-control select2" name="month_id" id="month_id" title="Select Month" data-validation="required">
		<option value="">Select</option>
		<?php foreach ($month as $res_month)
		{
		?>
		<option value="<?php echo $res_month['month_sl']; ?>"> <?php echo $res_month['month_name'];?>  </option>
		<?php
		}	
		?>
		</select>
		</div>
		</div>
		</td>
    </tr>

	<tr> 
		<td colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ വിഭാഗം / </small>  <h5> Category of vessel </h5> </font> 
		</td>

		<td> <div class="div200">
		<div class="form-group">
		<select class="form-control select2" name="vessel_category_id" id="vessel_category_id" title="Select Vessel Category" data-validation="required">
		<option value="">Select</option>
		<?php foreach ($vesselcategory as $res_vesselcategory)
		{
		?>
		<option value="<?php echo $res_vesselcategory['vesselcategory_sl']; ?>"> <?php echo $res_vesselcategory['vesselcategory_name'];?> </option>
		<?php
		}	
		?>
		</select>
		</div>
		<!-- /.form-group -->
		</div>
		</td>

		<td><font color="#282626"> <small> യാനത്തിന്റെ ഉപവിഭാഗം / </small>  <h5> Sub category of vessel</h5> </font></td>
		<td> <div class="div200">
		<div class="form-group">
		<select class="form-control select2" name="vessel_subcategory_id" id="vessel_subcategory_id" title="Select Vessel SubCategory">
		</select>
		</div>
		<!-- /.form-group -->
		</div></td>
	</tr>

          
	<tr> 
		<td  colspan="2"> <font color="#282626"> <small>  </small>  <h5>Number of Deck</h5> </font> </td>
		<td > <div class="div100"> <div class="input-group">
		<input type="text" name="vessel_no_of_deck" value="" id="vessel_no_of_deck"  class="form-control"  maxlength="1" autocomplete="off" title="Enter Number of Deck"  data-validation="required" onkeypress="return IsNumeric(event);"/>
		<!-- data-validation="length number" data-validation-length="min1"-->
		</div> </div> </td> 
		<td>  </td>
		<td> </td>
	</tr>
             
	<tr id="over_deck_id" >
		<td colspan="5">
		<div class="col-md-3"><font color="#282626"> <small> നീളം / </small>  <h5> Length Over the Deck</h5> </font> </div>
		<div class="col-md-3"><font color="#282626"> <small> വീതി / </small>  <h5>Breadth </h5> </font></div>
		<div class="col-md-3"><font color="#282626"> <small> ആഴം / </small>  <h5>Depth </h5> </font></div>
		<div class="col-md-3"><font color="#282626"> <small> ഭാരം / </small>  <h5> Tonnage </h5> </font></div>
		</td>
	</tr>
            
         
            
             
	<tr id="over_deck_id_value">  
		<td colspan="5">
		<div class="col-md-3">
		<div class="input-group">
		<input type="text" class="form-control" name="vessel_length" value="" id="vessel_length" maxlength="5" autocomplete="off" title="Enter Vessel Length" data-validation="required" onkeypress="return IsDecimal(event);">
		<span class="input-group-addon">m</span>
		</div>
		</div>
		<div class="col-md-3"><div class="input-group">
		<input type="text" name="vessel_breadth" value="" id="vessel_breadth"  class="form-control"  maxlength="5" autocomplete="off" title="Enter Vessel Breadth" data-validation="required" onkeypress="return IsDecimal(event);"/>
		<span class="input-group-addon">m</span>
		</div></div>
		<div class="col-md-3"><div class="input-group">
		<input type="text" name="vessel_depth" value="" id="vessel_depth"  class="form-control"  maxlength="5" autocomplete="off" title="Enter Vessel Depth" data-validation="required" onkeypress="return IsDecimal(event);"/>
		<span class="input-group-addon">m</span>
		</div></div>

		<div class="col-md-3"><div class="form-group">
		<button type="button" class="btn bg-olive btn-flat" id="check_tonnage"> Check </button></div>  <div class="col-md-6" id="Ton">
		<font color="#00f" id="show_tonnage">  </font>  </div>
		</div> 
		</td>
	</tr>
            
	<tr id="upper_deck_id" >
		<td colspan="5">
		<div class="col-md-3"><font color="#282626"> <small> നീളം / </small>  <h5> Length Upper the Deck</h5> </font> </div>
		<div class="col-md-3"><font color="#282626"> <small> വീതി / </small>  <h5>Breadth </h5> </font></div>
		<div class="col-md-3"><font color="#282626"> <small> ആഴം / </small>  <h5>Depth </h5> </font></div>
		<div class="col-md-3"><font color="#282626"> <small> ഭാരം / </small>  <h5> Tonnage </h5> </font></div>
		</td>
	</tr>

             
             
	<tr id="upper_deck_id_value">  

		<td colspan="5">
		<div class="col-md-3">
		<div class="input-group">
		<input type="text" class="form-control" name="vessel_upperdeck_length" value="" id="vessel_upperdeck_length" maxlength="4" autocomplete="off" title="Enter Vessel Length Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);" />
		<span class="input-group-addon">m</span>
		</div>
		</div>

		<div class="col-md-3"><div class="input-group">
		<input type="text" name="vessel_upperdeck_breadth" value="" id="vessel_upperdeck_breadth"  class="form-control"  maxlength="4" autocomplete="off" title="Enter Vessel Breadth Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);"/>
		<span class="input-group-addon">m</span>
		</div></div>

		<div class="col-md-3"><div class="input-group">
		<input type="text" name="vessel_upperdeck_depth" value="" id="vessel_upperdeck_depth"  class="form-control"  maxlength="4" autocomplete="off"  title="Enter Vessel Depth Upper the Deck" data-validation="required" onkeypress="return IsDecimal(event);"/>
		<span class="input-group-addon">m</span>
		</div></div>

		<div class="col-md-3"><div class="form-group">
		<button type="button" class="btn bg-olive btn-flat" id="check_tonnage_upperdeck"> Check </button></div>  <div class="col-md-6" id="Ton_upperdeck">
		<font color="#00f" id="show_upperdeck_tonnage">  </font>  </div>
		</div>
		       
		</td>
	</tr>
             

            
            
	<tr> 
		<td colspan="5">  
		<button type="button" class="btn btn-info pull-right" name="tab1next" id="tab1next" >Save</button> 
		<!-- <input type="submit" class="btn btn-info pull-right" name="tab1next" id="tab1next" value="Next"> -->
		</td>
	</tr>
	</table>


	</form>  
<?php
?>
</div>
 <!-- /. end of tab-pane 1-->


              
<!-- ______________________ Particulars of Hull _________________________ -->

<div class="tab-pane" id="tab_2">
<form name="form2" id="form2" method="post" >

<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" > 
<div id="hulldetails"> </div>



<table id="show_headplacement" class="table table-bordered table-striped">
<tr>
<td colspan="2">
	<td><span id="num_bulk" >Number of Bulk Head</span>  </td>
		<td> <div class="div100"> <div class="form-group" id="bulk_heads_show" >
		<input type="text" name="bulk_heads" value="" id="bulk_heads"  class="form-control"  maxlength="3" autocomplete="off" onkeypress="return IsNumeric(event);" title="Enter Number of Bulk Head" data-validation="number"/>
		</div> </div>
		</td>
	</tr>
	<tr>
		<td colspan="4">
		<table id="show_headplacement" class="table table-bordered table-striped"></table>
		</td>
	</tr>
	

</table>

<button type="button" class="btn btn-info pull-right btn-space " name="tab2next" id="tab2next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab2back" id="tab2back">Back</button>  

</form>
</div>

<!-- /. end of tab-pane 2 -->
              
<!-- __________________________ Particulars of Engine __________________________-->


<div class="tab-pane" id="tab_3">
<form name="form3" id="form3" method="post">
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >
<span id="show_field"></span>
<table id="vacbtable" class="table table-bordered table-striped">
	<tr> 
		<td colspan="3">  Number of engine sets  </td>
		<td colspan="2">  <div class="div100" >
		<div class="input-group input-group-sm" id="engine1">
		<span class="input-group-btn"> 
		<button type="button" class="btn btn-primary btn-flat" id="chg_engine" name="chg_engine"> Go </button>
		</span> 

		</div>
		<!-- /input-group -->
		</div> 
		</td>
	</tr>
	<tr>
		<td colspan="5" align="center" >
		<div id="show_engine_set">
		</div>
		</td>
	</tr>
	<tr> 
		<td colspan="5"> 
		<button type="button" class="btn btn-info pull-right btn-space" name="tab3next" id="tab3next">Save</button>
		<button type="button" class="btn btn-warning pull-right btn-space" name="tab3back" id="tab3back">Back</button>  
		</td> 
	</tr>

</table>
</form>
</div>
<!-- /. end of tab-pane 3 -->
              
<!-- _________________________ Particulars of Equipment _______________________________ -->

<div class="tab-pane" id="tab_4">

<table id="vacbtable" class="table table-bordered table-striped">
</table>
<form name="form4" id="form4" method="post">    
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >                

<table  class="table table-bordered table-striped">

<tr> <td id="equipment1" colspan="5"></td></tr>
<tr> <td colspan="5"> 
<button type="button" class="btn btn-info pull-right btn-space" name="tab4next" id="tab4next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab4back" id="tab4back">Back</button>  

</td> </tr>
</table>
</form>     
</div>
 <!-- /. end of tab-pane 4-->

              
<!--__________________________ Particulars of Fire Appliance _____________________________-->
             
<div class="tab-pane" id="tab_5">
<form name="form5" id="form5" method="post">  
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >
<table id="vacbtable" class="table table-bordered table-striped">


<tr><td id="fireappliance1" colspan="5"></td> </tr>
<tr> <td colspan="5"> 
<button type="button" class="btn btn-info pull-right btn-space" name="tab5next" id="tab5next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab5back" id="tab5back">Back</button>  

</td> </tr>
</table>
</form>
</div>
 <!-- /. end of tab-pane 5-->

              
<!--________________________ Other Equipment _____________________________ -->

<div class="tab-pane" id="tab_6">
<form name="form6" id="form6" method="post">  
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >
<table id="vacbtable" class="table table-bordered table-striped">

<tr><td id="otherequipment1" colspan="5"></td> </tr>
<tr> <td colspan="5"> 
<button type="button" class="btn btn-info pull-right btn-space" name="tab6next" id="tab6next">Save</button>
<button type="button" class="btn btn-warning pull-right btn-space" name="tab6back" id="tab6back">Back</button>  

</td> </tr>
</table>
</form>
</div>
<!-- /. end of tab-pane 6-->
              
    <!-- ______________________ Documents ________________________________-->

<div class="tab-pane" id="tab_7">


<form name="form7" id="form7" method="post" action="" enctype="multipart/form-data">  
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" > 
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >

<table id="vacbtable" class="table table-bordered table-striped">


<tr><td id="documents1" colspan="5"></td> </tr>

<!-- <?php
$i=1;
foreach($list_document as $res_list_document)
{
?>
	<tr>
		<td > <?php echo $res_list_document['document_name']; ?><input type="hidden" name="document_id<?php echo $i;  ?>" value="<?php echo $res_list_document['document_sl']; ?>">&nbsp;<?php if($res_list_document['document_sl']==1 || $res_list_document['document_sl']==2 || $res_list_document['document_sl']==5) { echo '<span style="color:red">*</span>'; }?> </td>
		<td colspan="4"> 
		<div class="div400">
		<label class="btn bg-green btn-sm" for="my-file-selector<?php echo $i; ?>">
		<input id="my-file-selector<?php echo $i; ?>" type="file" style="display:none" name="myFile<?php echo $i;  ?>"  onchange="$('#upload-file-info'+<?php echo $i; ?>).html(this.files[0].name)"> Browse File  </label>
		<span class="label label-info"  id="upload-file-info<?php echo $i; ?>"></span>
		</div></td>
	</tr>

<?php
$i++;
}
?> -->
	<tr>
		<td> Preferred Inspection Date</td>
		<td colspan="4" > 
		             
		<div class="div250">
		<div class="form-group">
		<div class="input-group date">
		<div class="input-group-addon">
		<i class="fa fa-calendar"></i>
		</div>
		 <input type="text" class="form-control" id="datepicker3" name="vessel_pref_inspection_date" title="Enter Preferred Inspection Date" data-validation="required">
		</div>

		</div>

		</div>
		</td>
	</tr>       
	<tr> 
		<td colspan="5"> 
		<button type="button" class="btn btn-info pull-right btn-space" name="tab7next" id="tab7next">Save</button>
		<button type="button" class="btn btn-warning pull-right btn-space" name="tab7back" id="tab7back">Back</button>  
		</td>
	</tr>

</table>
</form>
</div> 
<!-- /. end of tab-pane 7-->
              
<!--_______________Payment Details __________________________ --> 

<div class="tab-pane" id="tab_8">
<form name="form8" id="form8" method="post"> 
<input type="hidden" class="hdn_vessel_type" name="hdn_vessel_type" value="" >
<input type="hidden" class="hdn_vessel_subtype" name="hdn_vessel_subtype" value="" >
<input type="hidden" class="hdn_vessel_length" name="hdn_vessel_length" value="" >
<input type="hidden" class="hdn_engine_inboard_outboard" name="hdn_engine_inboard_outboard" value="" >
<input type="hidden" class="hdn_hullmaterial_id" name="hdn_hullmaterial_id" value="" >
<table id="vacbtable" class="table table-bordered table-striped">
 
	<tr> 
		<td colspan="2"> Payment Type</td>
		<td colspan="3"> 
		<div class="form-group">
		<select class="form-control select2 div200" name="paymenttype_id" id="paymenttype_id" data-validation="required" >
		<option value="">Select</option>
		<?php foreach ($paymenttype as $res_paymenttype)
		{
		?>
		<option value="<?php echo $res_paymenttype['paymenttype_sl']; ?>"> <?php echo $res_paymenttype['paymenttype_name'];?>  </option>
		<?php
		}	
		?>
		</select>
		</div>
		<!-- /.form-group -->
		</td>
	</tr>

	<tr>
		<td> DD Amount </td> <td> 
		<div class="div150">
		<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-inr"></i></span>
		<input type="text" class="form-control" name="dd_amount" value="6250" id="dd_amount" maxlength="8" autocomplete="off" data-validation="required">
		</div>
		</div>
		</td> 
		<td> DD Number </td> <td><div class="div100"> <div class="form-group">
		<input type="text" name="dd_number" value="" id="dd_number"  class="form-control"  maxlength="6" autocomplete="off" data-validation="required" onkeypress="return IsNumeric(event);"  />&nbsp;6 digits
		</div> </div>
		</td> 
	</tr>

	<tr> <td> DD Date </td> 
		<td> <div class="div250">
		<div class="form-group">
		<div class="input-group date">
		<div class="input-group-addon">
		<i class="fa fa-calendar"></i>
		</div>
		<input type="text" class="form-control" id="datepicker1" name="dd_date" data-validation="required" >
		</div>
		<!-- /.input group -->
		</div>
		<!-- /.form group -->
		</div></td> 
		<td> Favoring </td> 
		<td> <div class="form-group">
		<select class="form-control select2 div200" name="portofregistry_id" id="portofregistry_id" data-validation="required">
		<option value="">Select</option>
		<?php foreach ($portofregistry as $res_portofregistry)
		{
		?>
		<option value="<?php echo $res_portofregistry['portofregistry_sl']; ?>"> <?php echo $res_portofregistry['portofregistry_name'];?>  </option>
		<?php
		}	?>

		</select>
		</div>
		<!-- /.form-group --> 
		</td> 
	</tr>



	<tr> 
		<td> Bank </td> 
		<td><div class="form-group">
		<select class="form-control select2 div200" name="bank_id" data-validation="required">
		<option value="">Select</option>
		<?php foreach ($bank as $res_bank)
		{
		?>
		<option value="<?php echo $res_bank['bank_sl']; ?>"> <?php echo $res_bank['bank_name'];?>  </option>
		<?php
		}	?>
		</select>
		</div>
		<!-- /.form-group --> </td>
		<td> Payable at </td> 
		<td><div class="div250"> <div class="form-group">
		<input type="text" name="branch_name" value="" id="branch_name"  class="form-control"  maxlength="50" autocomplete="off" data-validation="required"  />&nbsp;Branch Name
		</div> </div>
		</td>
		</tr>
		<tr> <td colspan="5"> 
		<button type="button" class="btn btn-info pull-right btn-space" name="tab8next" id="tab8next">Submit</button>
		<button type="button" class="btn btn-warning pull-right btn-space" name="tab8back" id="tab8back">Back</button>  
		</td>
	</tr>
</table>
</form>
</div>
              
                <!-- /. end of tab-pane 8--> 



              <!-- ----------------------------------------- Owner Details -------------------------------------- ->
              <?php foreach($user as $result_user)
					{
						$user_name			=	$result_user['user_name'];
						$user_address		=	$result_user['user_address'];
						$user_email			=	$result_user['user_email'];
						$user_mobile_number	=	$result_user['user_mobile_number'];
					}
				  foreach ($agent as $result_agent)
				  {
					  $agent_name=$result_agent['user_name'];
					$agent_address=$result_agent['user_address'];
				  }
				  ?>
               <div class="tab-pane" id="tab_9">
               <form name="form9" method="post">
                <table id="vacbtable" class="table table-bordered table-striped">
                <tr>
                  <td colspan="2"> Reference Number</td>
                  <td colspan="3"> <?php ?></td>
                </tr>
                <tr>
                  <td colspan="2"> Name</td>
                  <td colspan="3">  <?php echo $user_name; ?></td>
                </tr>
                <tr>
                  <td colspan="2"> Address</td>
                  <td colspan="3"> <?php echo $user_address; ?></td>
                </tr>
                <tr>
                  <td colspan="2"> Email</td>
                  <td colspan="3">  <?php echo $user_email; ?></td>
                </tr>
                <tr>
                  <td colspan="2"> Mobile</td>
                  <td colspan="3"> <?php echo $user_mobile_number; ?></td>
                </tr>
                <tr>
                  <td colspan="2"> Agent Name</td>
                  <td colspan="3"><?php echo $agent_name; ?> </td>
                </tr>
                <tr>
                  <td colspan="2"> Agent Address</td>
                  <td colspan="3"> <?php echo $agent_address; ?></td>
                </tr>
                 </table>
                 </form>
              </div>
              <!-- /. end of tab-pane 9-->
            </div>
                      <?php
                     
					//echo form_close();
					?>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
     </div>
     <!-- End of Row Custom-Inner -->
  <!-- Main Content Ends here -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->