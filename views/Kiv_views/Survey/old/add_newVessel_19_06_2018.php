<script language="javascript">
    
  
    
$(document).ready(function(){
	
   $("#bulk_heads_show").hide(); //hide when Particulars of Hull Tab Load
   $("#Ton").hide();
 
  //-------------------Vessel Details---------------//  
   //----tab1 Click Start----//     
 $("#tab1next").click(function() {
  var vessel_name= $("#vessel_name").val();
   var vessel_expected_completion=$("#vessel_expected_completion").val();
   var vessel_category_id=$("#vessel_category_id").val();
   var vessel_subcategory_id=$("#vessel_subcategory_id").val();
   
   var vessel_type_id=$("#vessel_type_id").val();
   var vessel_subtype_id=$("#vessel_subtype_id").val();
   var vessel_length=$("#vessel_breadth").val();
   var vessel_breadth=$("#vessel_category_id").val();
   var vessel_depth=$("#vessel_depth").val();
   
   if(vessel_name=="")
   {
       alert("Enter Vseel Name");
       $("#vessel_name").focus();
       return false;
   }
   /*
   if(vessel_expected_completion=="")
   {
       alert("Enter Vessel Expected Completion");
       $("#vessel_expected_completion").focus();
       return false;
   }
    if(vessel_category_id=="")
   {
       alert("Select Vessel Category");
       $("#vessel_category_id").focus();
       return false;
   }
    if(vessel_type_id=="")
   {
       alert("Select Vessel Type");
       $("#vessel_type_id").focus();
       return false;
   }
    if(vessel_length=="")
   {
       alert("Enter Vessel Length");
       $("#vessel_length").focus();
       return false;
   }
   if(vessel_breadth=="")
   {
       alert("Enter Vessel Breadth");
       $("#vessel_breadth").focus();
       return false;
   }
   if(vessel_depth=="")
   {
       alert("Enter Vessel Depth");
       $("#vessel_depth").focus();
       return false;
   }
        */
   
   
   
     
     $.ajax({
            url : "<?php echo site_url('Survey/add_vessel_details/')?>",
            type: "POST",
            data:{vessel_name:vessel_name,
				  vessel_expected_completion:vessel_expected_completion,
				  vessel_category_id:vessel_category_id,
				  vessel_subcategory_id:vessel_subcategory_id,
				  vessel_type_id:vessel_type_id,
				  vessel_subtype_id:vessel_subtype_id,
				  vessel_length:vessel_length,
				  vessel_breadth:vessel_breadth,
				  vessel_depth:vessel_depth
				 },
            //dataType: "JSON",
            success: function(data)
            {
				alert("Vessel Details inserted Successfully");
				 $('.nav-tabs a[href="#tab_2"]').tab('show');
					
			}
		
		 
				});
     
});  //----tab1 Click End----//  
                        
  
   
   
 
	$("#vessel_category_id").change(function(){
		
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
	
	
	$("#vessel_type_id").change(function(){
		
		var vessel_type_id=$("#vessel_type_id").val();
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
		}
	});
	
        $("#check_tonnage").click(function(){
       
            var vessel_length=$("#vessel_length").val();
            var vessel_breadth=$("#vessel_breadth").val();
            var vessel_depth=$("#vessel_depth").val();
            var tonnage=(((vessel_length)*(vessel_breadth)*(vessel_depth))/2.83);
            var result= Math.round(tonnage);
             $("#Ton").show();
            $("#show_tonnage").html(result).append(' Ton');
              
        });
        
        
    //-------------------Particulars of Hull---------------//    
     
       $("input[type='radio'][name='freeboard_status_id']").click(function() {
      if ($("input[type='radio'][name='freeboard_status_id']:checked").val()=='1'){
         $("#bulk_heads_show").show();    
       }
       else {
           $("#bulk_heads").val('');
          $("#bulk_heads_show").hide();  
       }
   });  

//--tab2 click start---//	
$("#tab2next").click(function() {
  
   var hull_name= $("#hull_name").val();
   var hull_address=$("#hull_address").val();
   var hullmaterial_id=$("#hullmaterial_id").val();
   var hull_thickness=$("#hull_thickness").val();
   
   var hullplating_material_id=$("#hullplating_material_id").val();
   var hull_plating_material_thickness=$("#hull_plating_material_thickness").val();
   var freeboard_status_id=$("#freeboard_status_id").val();
   var bulk_heads=$("#bulk_heads").val();
   
   var bulk_head_placement=$("#bulk_head_placement").val();
   var bulk_head_thickness=$("#bulk_head_thickness").val();
  /*
   if(hull_name=="")
  {
      alert("Enter Name of builder of hull");
      $("#hull_name").focus();
      return false;
      
  }
   if(hull_address=="")
  {
      alert("Enter Address of builder of hull");
      $("#hull_address").focus();
      return false;
      
  }
   if(hullmaterial_id=="")
  {
      alert("Select Material of hull");
      $("#hullmaterial_id").focus();
      return false;
      
  }
   if(hull_thickness=="")
  {
      alert("Enter Thickness of hull");
      $("#hull_thickness").focus();
      return false;
      
  }
   if(hullplating_material_id=="")
  {
      alert("Select Hull plating material");
      $("#hullplating_material_id").focus();
      return false;
      
  }
  
  if(hull_plating_material_thickness=="")
  {
      alert("Enter Thickness of hull plating material");
      $("#hull_plating_material_thickness").focus();
      return false;
      
  }
   if(bulk_head_placement=="")
  {
      alert("Enter Bulk head placement");
      $("#bulk_head_placement").focus();
      return false;
      
  }
  
  if(bulk_head_thickness=="")
  {
      alert("Enter Bulk head thickness");
      $("#bulk_head_thickness").focus();
      return false;
      
  }
  */
  
    
     
     $.ajax({
            url : "<?php echo site_url('Survey/add_hull_details/')?>",
            type: "POST",
            data:{hull_name:hull_name,
             hull_address:hull_address,
             hullmaterial_id:hullmaterial_id,
             hull_thickness:hull_thickness,
             hullplating_material_id:hullplating_material_id,
             hull_plating_material_thickness:hull_plating_material_thickness,	
             freeboard_status_id:freeboard_status_id,
             bulk_heads:bulk_heads,
            bulk_head_placement:bulk_head_placement,
             bulk_head_thickness:bulk_head_thickness
				 },
            //dataType: "JSON",
            success: function(data)
            {
                alert("Hull Details inserted Successfully");
		$('.nav-tabs a[href="#tab_3"]').tab('show');
      	    }
	    });
     
}); //---tab2 click End---//
        
      //------------------- Particulars of Engine ---------------//     
      $("#chg_engine").click(function(){
      var no_of_engineset=$("#no_of_engineset").val();
      
      
     
          
      
      	if(no_of_engineset!='')
		{ 
		$.ajax
			({
				type: "POST",
				url:"<?php echo site_url('/Survey/no_of_engineset/')?>"+no_of_engineset,
				success: function(data)
				{	
                                    //alert(data);
				
				$("#show_engine_set").html(data).find(".div200").select2();
				 
				}
			});
		}
      
      
      
      });
         
	//-----tab3 click start------//
  $("#tab3next").click(function() {
  
    $.ajax({
            url : "<?php echo site_url('Survey/add_engine_details/')?>",
            type: "POST",
            data:$('#form3').serialize(),
            //dataType: "JSON",
            success: function(data)
            {
              //alert(data);
                alert("Engine Details inserted Successfully");
		$('.nav-tabs a[href="#tab_4"]').tab('show');
      	    }
	    });
            
           
  
  
  }); //---tab3 click End---//
  
	
  /*
    for(var i=1;i<=no_of_engineset;i++)
            {
                $("#remove"+i).click(function()
                {
                    alert("hii");
                    $("#vacbtable"+i).remove();
                });
            }
   */
 
   //------------------- Particulars of Equipment ---------------// 
  //-----tab4 click start------//
  $("#tab4next").click(function() {
              $.ajax({
            url : "<?php echo site_url('Survey/add_equipment_details/')?>",
            type: "POST",
            data:$('#form4').serialize(),
            //dataType: "JSON",
            success: function(data)
            {
            // alert(data);
                alert("Equipment Details inserted Successfully");
		 		$('.nav-tabs a[href="#tab_5"]').tab('show');
      	    }
	    });   
    
    
    });  //---tab4 click End---//
	
	//------------------- Particulars of Fire Appliance ---------------// 
  //-----tab5 click start------//
	
	$("#tab5next").click(function() {
		
		  $.ajax({
            url : "<?php echo site_url('Survey/add_fire_appliance/')?>",
            type: "POST",
            data:$('#form5').serialize(),
            //dataType: "JSON",
            success: function(data)
            {
                
                alert("Fire Appliance Details inserted Successfully");
		$('.nav-tabs a[href="#tab_6"]').tab('show');
      	    }
	    }); 
		
      
		
    });
	
//------tab5 click End---//
    
	
	
	
	//------------------- Particulars of Other Equipments ---------------// 
  //-----tab6 click start------//
	
	$("#tab6next").click(function() {
		
		  $.ajax({
            url : "<?php echo site_url('Survey/add_other_equipments/')?>",
            type: "POST",
            data:$('#form6').serialize(),
            //dataType: "JSON",
            success: function(data)
            {
            alert(data);
                alert("Other Equipments Details inserted Successfully");
		$('.nav-tabs a[href="#tab_7"]').tab('show');
      	    }
	    }); 
		
      
		
    });
	
//------tab6 click End---//
	
	
	//------------------- Particulars of Documents ---------------// 
  //-----tab7 click start------//
	
	$("#tab7next").click(function() {
		 $.ajax({
            url : "<?php echo site_url('Survey/add_vessel_documents/')?>",
            type: "POST",
            data:$('#form7').serialize(),
              
            success: function(data)
            {
                alert(data);
                alert("Vessel Documents Details inserted Successfully");
		$('.nav-tabs a[href="#tab_8"]').tab('show');
      	    }
	    }); 
				
    });

    /*
	$('#upload_file').submit(function(e) {
		e.preventDefault();
		$.ajaxFileUpload({
			url 			:'./upload/upload_file/', 
			secureuri		:false,
			fileElementId	:'userfile',
			dataType		: 'json',
			data			: {
				'title'				: $('#title').val()
			},
			success	: function (data, status)
			{
				if(data.status != 'error')
				{
					$('#files').html('<p>Reloading files...</p>');
					refresh_files();
					$('#title').val('');
				}
				alert(data.msg);
			}
		});
		return false;
	});
        */

     
     
     
     
        
        
//------tab7 click End---//
	
	
	
  
	//------------------- Payment Details ---------------// 
  //-----tab8 click start------//
	
	$("#tab8next").click(function() {
		
		  $.ajax({
            url : "<?php echo site_url('Survey/add_payment_details/')?>",
            type: "POST",
            data:$('#form8').serialize(),
            //dataType: "JSON",
            success: function(data)
            {
                //alert(data);
                alert("Payment Details inserted Successfully");
				
		
      	    }
	    }); 
		
      
		
    });
	
//------tab8 click End---//
  
	
/* $("#tab1next").click(function() {
                $('.nav-tabs a[href="#tab_2"]').tab('show');
    });
    
    $("#tab2next").click(function() {
                $('.nav-tabs a[href="#tab_3"]').tab('show');
    });
 $("#tab3next").click(function() {
                $('.nav-tabs a[href="#tab_4"]').tab('show');
    });
	
	
 $("#tab4next").click(function() {
                $('.nav-tabs a[href="#tab_5"]').tab('show');
    });
	 $("#tab5next").click(function() {
                $('.nav-tabs a[href="#tab_6"]').tab('show');
    });
	
	 $("#tab6next").click(function() {
            $('.nav-tabs a[href="#tab_7"]').tab('show');
    });
	
	
  $("#tab7next").click(function() {
                $('.nav-tabs a[href="#tab_8"]').tab('show');
    });
   
*/


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
	
	
	
    
   
	
	
	
	
	
	
	
	
	
	
	
	
	
	
});
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
              <li><a href="#tab_2" data-toggle="tab">Particulars of Hull</a></li>
              <li><a href="#tab_3" data-toggle="tab">Particulars of Engine</a></li>
              <li><a href="#tab_4" data-toggle="tab">Particulars of Equipment</a></li>
              <li><a href="#tab_5" data-toggle="tab">Particulars of Fire Appliance</a></li>
              <li><a href="#tab_6" data-toggle="tab">Other Equipments</a></li>
              <li><a href="#tab_7" data-toggle="tab">Documents</a></li>
              <li><a href="#tab_8" data-toggle="tab">Payment</a></li>
                <li><a href="#tab_9" data-toggle="tab">Owner Details</a></li>
            </ul>
              
               
              
              <div class="tab-content">
                
              
               
             <!------------------------------------------- Vessel Details ----------------------------------------------->
           <div class="tab-pane active" id="tab_1">
               <form name="form1" id="form1" method="post" > 
                    
               <?php 
        //$attributes = array("class" => "form-horizontal", "id" => "form1", "name" => "form1");
       //echo form_open("Survey/add_newVessel", $attributes); ?>
          
           <table id="vacbtable" class="table table-bordered table-striped">
             <tr> 
            <td  colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ പേര്  / </small>  <h5>Vessel name  </h5> </font> </td>
            <td > <div class="div350"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off"/>
            <div> </div> </td> 
            <td >  <font color="#282626"> <small> നിർമ്മാണം പൂർത്തീകരിക്കാവുന്ന വർഷം / </small>  <h5>Proposed year of completion  </h5> </font></td>
            <td > <div class="div100"><div class="form-group">
            <input type="text" name="vessel_expected_completion" value="2018" id="vessel_expected_completion"  class="form-control"  maxlength="4" autocomplete="off"  /> 
            </div></div></td>
          </tr>
           <tr> 
            <td colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ വിഭാഗം / </small>  <h5> Category of vessel </h5> </font> </td>
            <td> <div class="div200">
                 <div class="form-group">
                <select class="form-control select2" name="vessel_category_id" id="vessel_category_id" >
                 
                  <option value="">Select</option>
                <?php foreach ($vesselcategory as $res_vesselcategory)
					{
					?>
               <option value="<?php echo $res_vesselcategory['vesselcategory_sl']; ?>"> <?php echo $res_vesselcategory['vesselcategory_name'];?>  </option>
                <?php
						}	?>
               
                </select>
                
              </div>
              <!-- /.form-group -->
            </div></td>
            <td><font color="#282626"> <small> യാനത്തിന്റെ ഉപവിഭാഗം / </small>  <h5> Sub category of vessel</h5> </font></td>
            <td> <div class="div200">
                 <div class="form-group">
                <select class="form-control select2" name="vessel_subcategory_id" id="vessel_subcategory_id" >
                 
                 
                </select>
              </div>
              <!-- /.form-group -->
            </div></td>
          </tr>
          <tr> 
            <td colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ തരം / </small>  <h5> Type of vessel</h5> </font></td>
            <td> <div class="div200">
                 <div class="form-group">
                <select class="form-control select2" name="vessel_type_id" id="vessel_type_id">
                  
                   <option value="">Select</option>
                <?php foreach ($vesseltype as $res_vesseltype)
						{
					?>
               <option value="<?php echo $res_vesseltype['vesseltype_sl']; ?>"> <?php echo $res_vesseltype['vesseltype_name'];?>  </option>
                <?php
						}	?>
                
                  
                  
                </select>
              </div>
              <!-- /.form-group -->
            </div></td>
            <td><font color="#282626"> <small> യാനത്തിന്റെ സബ്ടൈപ്പ് / </small>  <h5>  Sub-type of vessel</h5> </font></td>
            <td> <div class="div200">
                 <div class="form-group">
                <select class="form-control select2" name="vessel_subtype_id" id="vessel_subtype_id" >
                
                </select>
              </div>
              <!-- /.form-group -->
            </div></td>
             <tr> <td colspan="2" class="div200"> <font color="#282626"> <small> നീളം / </small>  <h5> Length </h5> </font> </td> 
              <td> <font color="#282626"> <small> വീതി / </small>  <h5>Breadth </h5> </font></td> 
                <td> <font color="#282626"> <small> ആഴം / </small>  <h5>Depth </h5> </font></td> 
                  <td> <font color="#282626"> <small> ഭാരം / </small>  <h5> Tonnage </h5> </font> </td> </tr>
             <tr>  
               
              <td colspan="2"> <div class="div100">
               <div class="input-group">
                <input type="text" class="form-control" name="vessel_length" value="" id="vessel_length" maxlength="4" autocomplete="off">
                <span class="input-group-addon">m</span>
              </div>
              </div></td> 
              <td> <div class="div100"> <div class="input-group">
            <input type="text" name="vessel_breadth" value="" id="vessel_breadth"  class="form-control"  maxlength="4" autocomplete="off" />
            <span class="input-group-addon">m</span>
                      </div></div></td> 
              <td> <div class="div100"> <div class="input-group">
            <input type="text" name="vessel_depth" value="" id="vessel_depth"  class="form-control"  maxlength="4" autocomplete="off" />
            <span class="input-group-addon">m</span>
                      </div> </div></td> 
              <td> <div class="">
            
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                 <button type="button" class="btn bg-olive btn-flat" id="check_tonnage"> Check </button>
                 </div>
                </div>
                  
                <div class="col-md-6" id="Ton">
                  <font color="#00f" id="show_tonnage">  </font>
              <div class="progress progress-xs">
                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">                  
                </div>
              </div>
                </div>
                  
                  
              </div>
              
          
            </div> </td> 
            </tr>
            <tr > <td colspan="5">  
                
                   <button type="button" class="btn btn-info pull-right" name="tab1next" id="tab1next" >Save</button> 
         <!-- <input type="submit" class="btn btn-info pull-right" name="tab1next" id="tab1next" value="Next"> -->
                </td></tr>
                 </table>
              </form>  
              <?php
       //echo form_close();
              ?>
              </div>
                   
              <!-- /. end of tab-pane 1-->
    
              <!-- /. end of tab-pane 1-->
              
               <!------------------------------------------- Particulars of Hull ---------------------------------------- -->
              <div class="tab-pane" id="tab_2">
               <form name="form2" id="form2" method="post" >
                      
               <?php 
      /*  $attributes = array("class" => "form-horizontal", "id" => "form2", "name" => "form2");
       echo form_open("Survey/add_newVessel", $attributes);*/ ?>
                <table id="vacbtable" class="table table-bordered table-striped">
                <tr> 
            <td colspan="2"> Name of builder of hull</td>
            <td> <div class="div350"> <div class="form-group">
            <input type="text" name="hull_name" value="" id="hull_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
            <td> Address of builder of hull</td>
            <td> <div class="div350">
            <div class="form-group">
                  <textarea class="form-control" rows="3" name="hull_address" id="hull_address" ></textarea>
                </div>
                <!-- end of text area -->
            </div></td>
          </tr>
      <tr> 
            <td colspan="2"> Material of hull</td>   
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" name="hullmaterial_id" id="hullmaterial_id" >
                 <option value="">Select</option>
                <?php foreach ($hullmaterial as $res_hullmaterial)
						{
					?>
               <option value="<?php echo $res_hullmaterial['hullmaterial_sl']; ?>"> <?php echo $res_hullmaterial['hullmaterial_name'];?>  </option>
                <?php
						}	?>
                
                </select>
              </div>
              <!-- /.form-group -->
             </td>
            
            <td> Thickness of hull</td>
            <td> <div class="div100"> <div class="input-group">
            <input type="text" name="hull_thickness" value="" id="hull_thickness"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">mm</span>
            </div> </div></td>
          </tr>
         
            	
             
          <tr> 
            <td colspan="2"> Hull plating material</td> 
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" name="hullplating_material_id" id="hullplating_material_id" >
                 
					 <option value="">Select</option>
                <?php foreach ($hullplating_material as $res_hullplating_material)
						{
					?>
               <option value="<?php echo $res_hullplating_material['hullplating_material_sl']; ?>"> <?php echo $res_hullplating_material['hullplating_material_name'];?>  </option>
                <?php
						}	?>
                
               
               
                </select>
              </div>
              <!-- /.form-group -->
             </td>
            <td> Thickness of hull plating material</td>
            <td> <div class="div100"> <div class="input-group">
            <input type="text" name="hull_plating_material_thickness" value="" id="hull_plating_material_thickness"  class="form-control"  maxlength="30" autocomplete="off" />
            <span class="input-group-addon">mm</span>
                    </div> </div></td>
          </tr>
           <tr> 
         
            
            
            <td colspan="2"> Whether with a deck above freeboard (default no)</td>
            <td> <div class="form-group">
                <label>
                  <input type="radio" name="freeboard_status_id" id="freeboard_status_id_y" value="1" > &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="freeboard_status_id"  id="freeboard_status_id_n"  value="0" checked> &nbsp;No
                </label>
              </div>
              <!-- end of radio --></td>
            <td> Number of Bulk Head </td>
            <td> <div class="div100"> <div class="form-group" id="bulk_heads_show" >
            <input type="text" name="bulk_heads" value="" id="bulk_heads"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
          </tr>
           <tr> 
            <td colspan="2"> Bulk head placement</td>
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" name="bulk_head_placement" id="bulk_head_placement">
                  <option value="">Select</option>
                <?php foreach ($bulk_head_placement as $res_bulkhead)
						{
					?>
               <option value="<?php echo $res_bulkhead['location_sl']; ?>"> <?php echo $res_bulkhead['location_name'];?>  </option>
                <?php
						}	?>
                
                </select>
              </div>
              <!-- /.form-group -->
           </td>
            <td> Bulk head thickness</td>
            <td> <div class="div100"> <div class="input-group">
            <input type="text" name="bulk_head_thickness" value="" id="bulk_head_thickness"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">mm</span> 
            </div> </div></td>
          </tr>
          <tr> <td colspan="5"> 
            <button type="button" class="btn btn-info pull-right btn-space" name="tab2next" id="tab2next">Save</button>
             <button type="button" class="btn btn-warning pull-right btn-space" name="tab2back" id="tab2back">Back</button>  

             </td> </tr>
                 </table>
				  </form>
             <?php
      // echo form_close();
              ?>
              </div>
              
      <!------------------------------------------- Particulars of Engine --------------------------------------->
              
              <!-- /. end of tab-pane 2 -->
              <div class="tab-pane" id="tab_3">
                    <form name="form3" id="form3" method="post">
                <table id="vacbtable" class="table table-bordered table-striped">
                <tr> <td colspan="3">  Number of engine sets</td><td colspan="2">  <div class="div100">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="no_of_engineset" id="no_of_engineset">
                    <span class="input-group-btn"> 
                        <button type="button" class="btn btn-primary btn-flat" id="chg_engine" name="chg_engine"> Go </button>
                    </span>
              </div>
              <!-- /input-group -->
             </div> </td></tr>
                <tr>
                    <td colspan="5" align="center" >
                        <div id="show_engine_set">
                        </div>
                        
                    </td>
                    
                </tr>
            
              <tr> <td colspan="5"> 
            <button type="button" class="btn btn-info pull-right btn-space" name="tab3next" id="tab3next">Save</button>
            <button type="button" class="btn btn-warning pull-right btn-space" name="tab3back" id="tab3back">Back</button>  

             </td> </tr>
                 </table>
                  
                    </form>
           
              </div>
              <!-- /. end of tab-pane 3-->
              
              
              
              
               <!---------------------- Particulars of Equipment ----------------------------------->
              
              
              
              <div class="tab-pane" id="tab_4">
                  
                <table id="vacbtable" class="table table-bordered table-striped">
                 </table>
                    <form name="form4" id="form4" method="post">    
                        
                <table id="vacbtable" class="table table-bordered table-striped">
              
                    
             <tr> <td colspan="5"> Anchor</td> </tr>
             <tr> <td colspan="3"> </td> <td> Weight</td> <td> Material </td>  </tr>
             <tr> <td colspan="2"> </td> <td > Port</td> 
              <td>  <div class="div100"> <div class="input-group">
            <input type="text" name="weight1" value="" id="weight1"  class="form-control "  maxlength="30" autocomplete="off" /><span class="input-group-addon">kg</span>
            </div> </div> </td> 
            <td> 
                 <div class="form-group">
                     <select class="form-control select2 div200" name="material_id1" id="material_id1" >
                <option value="">Select</option>
                <?php foreach ($equipment_material as $res_equipment_material)
						{
					?>
               <option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>"> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
                <?php
						}	?>
                  
                </select>
              </div>
             
                  
             </td>  </tr>
             <tr> <td colspan="2"> </td> <td > Starboard</td> 
              <td> <div class="div100"> <div class="input-group">
            <input type="text" name="weight2" value="" id="weight2"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">kg</span>
            </div> </div></td> 
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" name="material_id2" id="material_id2">
                  <option value="">Select</option>
                <?php foreach ($equipment_material as $res_equipment_material)
						{
					?>
               <option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>"> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
                <?php
						}	?>
                  
                </select>
                </select>
              </div>
             
            </td>  </tr>
                  
                  
             <tr> <td colspan="2"> </td> <td > Spare </td> 
              <td> <div class="div100"> <div class="input-group">
            <input type="text" name="weight3" value="" id="weight3"  class="form-control"  maxlength="30" autocomplete="off" /> <span class="input-group-addon">kg</span>
            </div> </div></td> 
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" name="material_id3" id="material_id3">
                 <option value="">Select</option>
                <?php foreach ($equipment_material as $res_equipment_material)
						{
					?>
               <option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>"> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
                <?php
						}	?>
                  
            
                </select>
              </div>
             
             </td>  </tr>
                  
            <tr> <td colspan="5"> Chain</td> </tr>
             <tr> <td> </td> <td> </td> <td> Size </td>  <td> Length </td> <td> Type</td>  </tr>
             <tr> <td> </td> <td > Port</td> 
              <td>   <div class="div100"> <div class="form-group">
            <input type="text" name="size4" value="" id="size"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
            
            <td> <div class="div100"> <div class="input-group">
            <input type="text" name="length4" value="" id="length"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">m</span>
            </div> </div> </td>
              <td>  
                 <div class="form-group">
                <select class="form-control select2 div200" name="equipment_type_id4" id="equipment_type_id">
                 <option value="">Select</option>
                <?php foreach ($chainport_type as $res_chainport_type)
						{
					?>
               <option value="<?php echo $res_chainport_type['chainporttype_sl']; ?>"> <?php echo $res_chainport_type['chainporttype_name'];?>  </option>
                <?php
						}	?>
                  
                </select>
                </select>
              </div>
             
                  
             </td> 
          </tr>
             <tr> <td> </td> <td > Starboard</td> 
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="size5" value="" id="size"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
            
            <td>  <div class="div100"> <div class="input-group">
            <input type="text" name="length5" value="" id="length"  class="form-control"  maxlength="30" autocomplete="off" /><span class="input-group-addon">m</span>
            </div> </div></td> 
            <td>  
                 <div class="form-group">
                     <select class="form-control select2 div200" name="equipment_type_id5" id="equipment_type_id">
                 <option value="">Select</option>
                <?php foreach ($chainport_type as $res_chainport_type)
						{
					?>
               <option value="<?php echo $res_chainport_type['chainporttype_sl']; ?>"> <?php echo $res_chainport_type['chainporttype_name'];?>  </option>
                <?php
						}	?>
                  
                  
                </select>
                </select>
              </div>
              
                  
            </td> 
             </tr>
             <tr> <td colspan="5"> Rope</td> </tr>
             <tr> <td colspan="2"></td> <td> Size </td>  <td> Number </td>  <td> Material</td> </tr>
             <tr> <td colspan="2"></td> 
              <td>   <div class="div100"> <div class="form-group">
            <input type="text" name="size6" value="" id="size"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
             
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="number6" value="" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div> </td> 
             <td>  
                 <div class="form-group">
                <select class="form-control select2 div200" name="material_id6" id="material_id">
                 <option value="">Select</option>
                <?php foreach ($equipment_material as $res_equipment_material)
						{
					?>
               <option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>"> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
                <?php
						}	?>
                  
                </select>
              </div>
             
            </td>
          </tr>
          </tr>
             <tr> <td colspan="5"> Search Light</td> </tr>
             <tr> <td colspan="2"> </td> <td> Number </td> <td> Power </td> <td> Size</td>  </tr>
             <tr> <td colspan="2"> </td> 
               
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="number7" value="" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div> </td> 
             <td>   <div class="div100"> <div class="form-group">
            <input type="text" name="power7" value="" id="power"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
            <td>  
                 <div class="form-group">
                     <select class="form-control select2 div200" name="size7" id="size" >
                   <option value="">Select</option>
                <?php foreach ($searchlight_size as $res_searchlight_size)
						{
					?>
               <option value="<?php echo $res_searchlight_size['searchlight_size_sl']; ?>"> <?php echo $res_searchlight_size['searchlight_size_name'];?>  </option>
                <?php
						}	?>
                  
                </select>
              </div>
              
            </td>
          </tr>
          <tr> 
             <td colspan="3"> Number of life buoys </td> 
             <td colspan="2"> <div class="div100"> <div class="form-group">
            <input type="text" name="number8" value="" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
             </tr>
             <tr> 
             <td colspan="3"> Life buoys buoyant apparatus with self-ignited light or with buoyant lanyard </td> 
             <td colspan="2"> <div class="div100"> <div class="form-group">
            <input type="text" name="number9" value="" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
             </tr>

             
             <tr> 
             <td colspan="3"> Navigation light particulars </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                  
                                 
                
               
                <select name="nav_equipment_id[]" class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list"  >
                    
                    
                 <option value="">Select</option>
                <?php foreach ($navigation_light as $res_navigation_light)
						{
					?>
               <option value="<?php echo $res_navigation_light['equipment_sl']; ?>"> <?php echo $res_navigation_light['equipment_name'];?>  </option>
                <?php
						}	?>
                </select>
                
                
              </div>
            </td>
             </tr>
             <tr> 
             <td colspan="3"> Sound signals </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list" name="sound_equipment_id[]"  >
                     
                 <option value="">Select</option>
                <?php foreach ($sound_signals as $res_sound_signals)
						{
					?>
               <option value="<?php echo $res_sound_signals['equipment_sl']; ?>"> <?php echo $res_sound_signals['equipment_name'];?>  </option>
                <?php
						}	?>
                </select>
              </div>
           </td>
             </tr>
              
               <tr> <td colspan="5"> 
            <button type="button" class="btn btn-info pull-right btn-space" name="tab4next" id="tab4next">Save</button>
             <button type="button" class="btn btn-warning pull-right btn-space" name="tab4back" id="tab4back">Back</button>  

             </td> </tr>
                 </table>
                  </form>     
                       
                       
              </div>
              <!-- /. end of tab-pane 4-->
              <div class="tab-pane" id="tab_5">
                <form name="form5" id="form5" method="post">  
                <table id="vacbtable" class="table table-bordered table-striped">
                <tr> <td colspan="5"> Fire pumps</td> </tr>
             <tr> <td colspan="2">  </td> <td> Number </td>  <td> Capacity </td> <td> Size</td> </tr>
             <tr> <td colspan="2"> </td> 
              <td>   <div class="div100"> <div class="form-group">
            <input type="text" name="number1" value="" id="number"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
             
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="capacity1" value="" id="capacity"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div> </td> 
            <td>  
                 <div class="form-group">
                 
                <select class="form-control select2 div200" name="size1" id="size" >
                 
                    <option value="">Select</option>
                <?php foreach ($firepumpsize as $res_firepumpsize)
						{
					?>
               <option value="<?php echo $res_firepumpsize['firepumpsize_sl']; ?>"> <?php echo $res_firepumpsize['firepumpsize_name'];?>  </option>
                <?php
						}	?>
                  
                  
                </select>
              </div>
              <!-- /.form-group -->
           </td> 
          </tr>
          <tr> 
            <td  colspan="2"> Material of fire mains </td>
            <td > 
            
            <div class="form-group">
                <select class="form-control select2 div200"  data-placeholder="Select the list" name="material_id1" >
                 <option value="">Select</option>
                <?php foreach ($equipment_material as $res_equipment_material)
						{
					?>
               <option value="<?php echo $res_equipment_material['equipment_material_sl']; ?>"> <?php echo $res_equipment_material['equipment_material_name'];?>  </option>
                <?php
						}	?>
                </select>
              </div>
            </td>
            <td > Diameter of fire mains</td>
            <td > 
            
            <div class="div100"><div class="form-group">
            <input type="text" name="diameter1" value="" id="diameter"  class="form-control"  maxlength="30" autocomplete="off"  />
            </div></div>
          </td>
          </tr>
          <tr> 
            <td  colspan="2"> Number of hydrants </td>
            <td > <div class="div100"> <div class="form-group">
            <input type="text" name="number2" value="" id="number"  class="form-control"  maxlength="30" autocomplete="off"/>
            <div> </div> </td>
            <td > Number of hose</td>
            <td > <div class="div100"><div class="form-group">
            <input type="text" name="number3" value="" id="number"  class="form-control"  maxlength="30" autocomplete="off"  />
            </div></div></td>
          </tr>
          
          <tr> 
             <td colspan="3">  Nozzles </td> 
             <td colspan="2"> 
            
            <div class="form-group">
                <select class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list" name="nozzle_type[]" >
                  <option value="">Select</option>
                <?php foreach ($nozzletype as $res_nozzletype)
						{
					?>
               <option value="<?php echo $res_nozzletype['equipment_sl']; ?>"> <?php echo $res_nozzletype['equipment_name'];?>  </option>
                <?php
						}	?>
                </select>
                
                
              </div>
           </td>
             </tr>
              <tr> <td colspan="5"> Portable fire extinguishers</td> </tr>
             <?php 
				 $i=1;
				 foreach($portable_fire_ext as $result_port)
				 {
					 
				 
				 ?> <tr> <td>&nbsp; </td>
             
            
             <td colspan="2"><input type="hidden" value="<?php echo $result_port['portable_fire_extinguisher_sl']?>" name="fire_extinguisher_type_id[]"> <?php echo $i; ?>. &nbsp;<?php echo $result_port['portable_fire_extinguisher_name']?></td> 
             <td colspan="2"> 
             <div class="div100"> <div class="form-group">
            <input type="text" name="fire_extinguisher_number[]" value="" id="fire_extinguisher_number"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
            
            
             </tr>
            <?php
					 $i++;
				 } ?>
              
               <tr> <td colspan="5"> 
            <button type="button" class="btn btn-info pull-right btn-space" name="tab5next" id="tab5next">Save</button>
             <button type="button" class="btn btn-warning pull-right btn-space" name="tab5back" id="tab5back">Back</button>  

             </td> </tr>
                 </table>
                  
					</form>
                   
              </div>
              <!-- /. end of tab-pane 5-->
              
              <div class="tab-pane" id="tab_6">
                 <form name="form6" id="form6" method="post">  
                <table id="vacbtable" class="table table-bordered table-striped">
                  <tr> 
             <td colspan="3"> Particulars of communication equipments  </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" name="list1[]"  >
                 
                  <option value="">Select</option>
                <?php foreach ($commnequipment as $res_commnequipment)
						{
					?>
               <option value="<?php echo $res_commnequipment['equipment_sl']; ?>"> <?php echo $res_commnequipment['equipment_name'];?>  </option>
                <?php
						}	?>
                  
                  
                </select>
              </div>
           </td>
             </tr>
             <tr> 
             <td colspan="3"> Particulars of navigation equipments </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" name="list2[]" >
                   <option value="">Select</option>
                <?php foreach ($navgnequipments as $res_navgnequipments)
						{
					?>
               <option value="<?php echo $res_navgnequipments['equipment_sl']; ?>"> <?php echo $res_navgnequipments['equipment_name'];?>  </option>
                <?php
						}	?>
                </select>
              </div>
           </td>
             </tr>
             <tr> 
             <td colspan="3"> Type of pollution control devices </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" name="list3[]" >
                 <option value="">Select</option>
                <?php foreach ($pollution_controldevice as $res_pollution_controldevice)
						{
					?>
               <option value="<?php echo $res_pollution_controldevice['equipment_sl']; ?>"> <?php echo $res_pollution_controldevice['equipment_name'];?>  </option>
                <?php
						}	?>
                </select>
              </div>
            </td>
             </tr>
              <tr>
                <td> (Tick whether applicable) </td>
                <td colspan="4"> 
                  <div class="col-md-12">
            <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal" name="sewage_treatment" value="1" > &nbsp;&nbsp;&nbsp;Whether there is sewage treatment and disposal
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             
                <label>
                  <input type="checkbox" class="minimal" name="solid_waste"  value="1"> &nbsp;&nbsp;&nbsp;Whether there is solid waste processing and disposal
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  
                <label>
                  <input type="checkbox" class="minimal" name="sound_pollution"  value="1"> &nbsp;&nbsp;&nbsp;Whether there is sound pollution control 
                </label>
              </div>
            </div>

                </td>

              </tr>
             
             <tr>  
              <td colspan="2"> Water consumption per day </td> 
              <td> <div class="div100"> <div class="input-group">
            <input type="text" name="water_consumption" value="" id="water_consumption"  class="form-control"  maxlength="30" autocomplete="off"  /><span class="input-group-addon">ltr</span>
            </div> </div></td>
            <td> Source of water </td>
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" name="source_of_water" id="source_of_water" >
                <option value="">Select</option>
                <?php foreach ($sourceofwater as $res_sourceofwater)
						{
					?>
               <option value="<?php echo $res_sourceofwater['sourceofwater_sl']; ?>"> <?php echo $res_sourceofwater['sourceofwater_name'];?>  </option>
                <?php
						}	?>
                  
                  </select>
              </div>
              <!-- /.form-group -->
           </td>
                </tr>
                 
                  <tr> <td colspan="5"> 
            <button type="button" class="btn btn-info pull-right btn-space" name="tab6next" id="tab6next">Save</button>
             <button type="button" class="btn btn-warning pull-right btn-space" name="tab6back" id="tab6back">Back</button>  

             </td> </tr>
                 </table>
                   </form>
              </div>
              <!-- /. end of tab-pane 6-->
              
              
              <div class="tab-pane" id="tab_7"> <!-- <?php //echo base_url(); ?>index.php/Survey/upload_files-->
                 
                 
           <form name="form7" id="form7" method="post" action="" enctype="multipart/form-data">  
                <table id="vacbtable" class="table table-bordered table-striped">
                
                    <tr> <td > General Arrangments plans, structural drawings, freeboard marking, shell expansion, machinery and machinery layout, propeller, shafting, gears and steering plans, pipeline such as bilge and ballast, oil transfer etc </td>
              <td colspan="4"> 
              <div class="div400">
           <label class="btn bg-green btn-sm" for="my-file-selector1">
           <input id="my-file-selector1" type="file" style="display:none" name="file1"  onchange="$('#upload-file-info1').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info1"></span>
         
               
            </div></td>
            </tr>
            
            
            <tr> <td > Particulars iof wheel house, crew accomodation, passengers, galleys, stores/service place etc. </td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector2">
           <input id="my-file-selector2" type="file" style="display:none"  name="file2" onchange="$('#upload-file-info2').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info2"></span>
               
            </div></td>
            </tr>
            <tr> <td > Particulars of ventilation, charge of air for engine room </td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector3">
           <input id="my-file-selector3" type="file" style="display:none" name="file3" onchange="$('#upload-file-info3').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info3"></span>
               
            </div></td>
            </tr>
            
            
            <tr> <td >Builders yard accredition certificate </td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector4">
           <input id="my-file-selector4" type="file" style="display:none" name="file4" onchange="$('#upload-file-info4').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info4"></span>
                
            </div></td>
            </tr>
            <tr> <td > Preliminary stability calcualtion</td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector5">
           <input id="my-file-selector5" type="file" style="display:none" name="file5" onchange="$('#upload-file-info5').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info5"></span>
                
            </div></td>
            </tr>
            
            
             <tr>
              <td > Preferred Inspection date</td>
              <td colspan="4" > 
                                 
                  <div class="div250">
            <div class="form-group">
                 <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                     <input type="text" class="form-control" id="datepicker2" name="vessel_pref_inspection_date">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div>
                  
                  
                  
                  
              </td></tr>
               <tr> <td colspan="5"> 
                        <input type="submit" name="btnsubmit" value="save" id="tab7next" >   
        <!--<button type="button" class="btn btn-info pull-right btn-space" name="tab7next" id="tab7next">Save</button>-->
            <button type="button" class="btn btn-warning pull-right btn-space" name="tab7back" id="tab7back">Back</button>  

             </td> </tr>
                 </table>
                   </form>
              </div>
              <!-- /. end of tab-pane 7-->
              
              
              <div class="tab-pane" id="tab_8">
                 <form name="form8" id="form8" method="post">  
                <table id="vacbtable" class="table table-bordered table-striped">
                          <tr> 
            <td colspan="2"> Payment Type</td>
            <td colspan="3"> 
                 <div class="form-group">
                     <select class="form-control select2 div200" name="paymenttype_id" id="paymenttype_id" >
                 
                      <option value="">Select</option>
                <?php foreach ($paymenttype as $res_paymenttype)
						{
					?>
               <option value="<?php echo $res_paymenttype['paymenttype_sl']; ?>"> <?php echo $res_paymenttype['paymenttype_name'];?>  </option>
                <?php
						}	?>
                    
                                   
                  
                </select>
              </div>
              <!-- /.form-group -->
            </td>
          </tr>
          <tr>
            <td> DD Amount </td> <td> 
                
                <!-- <div class="form-group">
            <input type="text" name="dd_amount" value="" id="dd_amount"  class="form-control"  maxlength="8" autocomplete="off"  />Rs
            </div> </div>-->
                <div class="div150">
                <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                <input type="text" class="form-control" name="dd_amount" value="" id="dd_amount" maxlength="8" autocomplete="off">
              </div>
                </div>
            </td> 
            <td> DD Number </td> <td><div class="div100"> <div class="form-group">
            <input type="text" name="dd_number" value="" id="dd_number"  class="form-control"  maxlength="6" autocomplete="off"  />&nbsp;6 digits
            </div> </div> </td> </tr>
            <tr> <td> DD Date </td> 
              <td> <div class="div250">
            <div class="form-group">
                 <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                     <input type="text" class="form-control" id="datepicker1" name="dd_date">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div></td> 
              <td> Favoring </td> 
              <td> <div class="form-group">
                      <select class="form-control select2 div200" name="portofregistry_id" id="portofregistry_id" >
                 
                       <option value="">Select</option>
                <?php foreach ($portofregistry as $res_portofregistry)
						{
					?>
               <option value="<?php echo $res_portofregistry['portofregistry_sl']; ?>"> <?php echo $res_portofregistry['portofregistry_name'];?>  </option>
                <?php
						}	?>
                  
                </select>
              </div>
              <!-- /.form-group --> </td> </tr>
            <tr> <td> Bank </td> 
              <td><div class="form-group">
                      <select class="form-control select2 div200" name="bank_id">
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
               <td> Payable at </td> <td><div class="div250"> <div class="form-group">
                           <input type="text" name="branch_name" value="" id="branch_name"  class="form-control"  maxlength="50" autocomplete="off"  />&nbsp;Branch Name
            </div> </div> </td> </tr>
           <tr> <td colspan="5"> 
            <button type="button" class="btn btn-info pull-right btn-space" name="tab8next" id="tab8next">Submit</button>
             <button type="button" class="btn btn-warning pull-right btn-space" name="tab8back" id="tab8back">Back</button>  
             </td> </tr>
                 </table>
				  </form>
              </div>
              <!------------------------------------------- Owner Details ------------------------------------------------>
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