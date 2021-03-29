
<script language="javascript">
    
   
    
$(document).ready(function(){
    
    
    
   /* $("#form1").validate({
    rules:{
            vessel_name:{required:true,
                                  maxlength:30, 
                    },
             vessel_expected_completion:{required:true,
                                digits: true,
                                maxlength:4,
                                minlength:4,},
            vessel_category_id:{required:true,},
            
            vessel_subcategory_id: {required: {
                            depends: function(element) {
                       if ($("#vessel_category_id").val()!='')
                        return true;
                        else
                        return false;
                        }
                    }
          
         },
         
            vessel_type_id:{required:true,},
            vessel_subtype_id: {required: {
                            depends: function(element) {
                                
                        
                       if ($("#vessel_type_id").val()!='')
                        return true;
                        else
                        return false;
                        }
                    }
                    
                    
         },
            
            vessel_length:{required:true,
             digits: true,},
            vessel_breadth:{required:true,
             digits: true,},
            vessel_depth:{required:true,
             digits: true,},  
          
          
                
        },      
        messages:{
           
            
            vessel_name:{required:"<font color='red'>Enter Vessel Name</span>",
                      maxlength:"<font color='red'>Maximum 30 Characters allowed</font>"
                    },
         
             vessel_expected_completion:{required:"<font color='red'>Enter Date</font>",
                                digits:"<font color='red'>Only Number allowed</font>",
                                maxlength:"<font color='red'>Maximum 4 Number allowed</font>",
                                minlength:"<font color='red'>Minimum 4 Number allowed</font>",},
            vessel_category_id:{required:"<font color='red'>Select Category of Vessel</font>",},
            
            vessel_subcategory_id:{required:"<font color='red'>Select Sub Category of Vessel</font>",},
            
            vessel_type_id:{required:"<font color='red'>Select Type of Vessel</font>",},
            vessel_subtype_id:{required:"<font color='red'>Select Sub Type of Vessel</font>",},
            
            vessel_length:{required:"<font color='red'>Enter Length of Vessel</font>",
                                    digits:"<font color='red'>Only Number allowed</font>",},
                                
            vessel_breadth:{required:"<font color='red'>Enter Breadth of Vessel</font>",
                            digits:"<font color='red'>Only Number allowed</font>",
                            },
            vessel_depth:{required:"<font color='red'>Enter Depth of Vessel</font>",
                            digits:"<font color='red'>Only Number allowed</font>",
                            },
                        
          
           
                 }
    
    });
		
     
     */
    
    
    
    
    
    
    
    
    
    
    
    /*
   
     $('#step_2').fadeTo("fast", .5);
     $('.step_2').removeAttr("href");
     
     $('#step_3').fadeTo("fast", .5);
     $('.step_3').removeAttr("href");
     
     $('#step_4').fadeTo("fast", .5);
     $('.step_4').removeAttr("href");
          
     $('#step_5').fadeTo("fast", .5);
     $('.step_5').removeAttr("href");
     
     $('#step_6').fadeTo("fast", .5);
     $('.step_6').removeAttr("href");
      
     $('#step_7').fadeTo("fast", .5);
     $('.step_7').removeAttr("href");
     
     $('#step_8').fadeTo("fast", .5);
     $('.step_8').removeAttr("href");
     
     $('#step_9').fadeTo("fast", .5);
     $('.step_9').removeAttr("href");
      
     
	*/
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
            var tonnage=(((vessel_length)*(vessel_breadth)*(vessel_depth))/2.8);
            var result= Math.round(tonnage);
            $("#show_tonnage").html(result);
              
        });
            
        
        
        
	
    
     $("#form_step1") .click(function(){
     
     
     
     $("#form1").validate({
    rules:{
            vessel_name:{required:true,
                                  maxlength:30, 
                    },
                   vessel_expected_completion:{required:true,
                                digits: true,
                                maxlength:4,
                                minlength:4,},
            vessel_category_id:{required:true,},
            
            vessel_subcategory_id: {required: {
                            depends: function(element) {
                                
                        
                       if ($("#vessel_category_id").val()!='')
                        return true;
                        else
                        return false;
                        }
                    }
                    
                    
         },
         
          vessel_type_id:{required:true,},
            
            vessel_subtype_id: {required: {
                            depends: function(element) {
                                
                        
                       if ($("#vessel_type_id").val()!='')
                        return true;
                        else
                        return false;
                        }
                    }
                    
                    
         },
            
            vessel_length:{required:true,
             digits: true,},
            vessel_breadth:{required:true,
             digits: true,},
            vessel_depth:{required:true,
             digits: true,},  
           
            
                
        },      
        messages:{
           
            
            vessel_name:{required:"<font color='red'>Enter Vessel Name</span>",
                      maxlength:"<font color='red'>Maximum 30 Characters allowed</font>"
                    },
            
             vessel_expected_completion:{required:"<font color='red'>Enter Date</font>",
                                digits:"<font color='red'>Only Number allowed</font>",
                                maxlength:"<font color='red'>Maximum 4 Number allowed</font>",
                                minlength:"<font color='red'>Minimum 4 Number allowed</font>",},
            vessel_category_id:{required:"<font color='red'>Select Category of Vessel</font>",},
            
            vessel_subcategory_id:{required:"<font color='red'>Select Sub Category of Vessel</font>",},
            
            vessel_type_id:{required:"<font color='red'>Select Type of Vessel</font>",},
            vessel_subtype_id:{required:"<font color='red'>Select Sub Type of Vessel</font>",},
            
            vessel_length:{required:"<font color='red'>Enter Length of Vessel</font>",
                                    digits:"<font color='red'>Only Number allowed</font>",},
                                
            vessel_breadth:{required:"<font color='red'>Enter Breadth of Vessel</font>",
                            digits:"<font color='red'>Only Number allowed</font>",
                            },
            vessel_depth:{required:"<font color='red'>Enter Depth of Vessel</font>",
                            digits:"<font color='red'>Only Number allowed</font>",
                            },
                        
            
           
                 }
    
    });
    
    
    
     

     
     
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
       <!-- <li><a href="#"></i>  <span class="badge bg-blue"> Page1 </span> </a></li>
        <li><a href="#"><span class="badge bg-blue"> Page2  </span></a></li>-->
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
              <p>  See Rule 5 (1) - Form for expressing the intention to build a new vessel  </p>
            </div>
              <div class="box-body">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom" >
           
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
          <!--        
                  
          <li id="step_1" class="active"><a href="#tab_1" data-toggle="tab" class="step_1">Vessel Details</a></li>
          <li id="step_2"><a href="#tab_2" data-toggle="tab" class="step_2">Particulars of Hull</a></li>
          <li id="step_3"><a href="#tab_3" data-toggle="tab" class="step_3">Particulars of Engine</a></li>
          <li id="step_4"><a href="#tab_4" data-toggle="tab" class="step_4">Particulars of Equipment</a></li>
          <li id="step_5"><a href="#tab_5" data-toggle="tab" class="step_5">Particulars of Fire Appliance</a></li>
          <li id="step_6"><a href="#tab_6" data-toggle="tab" class="step_6">Other Equipments</a></li>
          <li id="step_7"><a href="#tab_7" data-toggle="tab" class="step_7">Documents</a></li>
          <li id="step_8"><a href="#tab_8" data-toggle="tab" class="step_8">Payment</a></li>
          <li id="step_9"><a href="#tab_9" data-toggle="tab" class="step_9">Owner Details</a></li>
          -->
            </ul>
              
              
            <div class="tab-content">
             
             
                <form name="form1" id="form1" method="post" enctype="multipart/form-data">
             <!------------------------------------------- Vessel Details ----------------------------------------------->
           <div class="tab-pane active" id="tab_1">
           <table id="vacbtable" class="table table-bordered table-striped">
             <tr> 
            <td  colspan="2"> <font color="#282626"> <small> യാനത്തിന്റെ പേര്  / </small>  <h5>Vessel name  </h5> </font> </td>
            <td > <div class="div350"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off"/>
            <div> </div> </td> 
            <td >  <font color="#282626"> <small> നിർമ്മാണം പൂർത്തീകരിക്കാവുന്ന വർഷം / </small>  <h5>Proposed year of completion  </h5> </font></td>
            <td > <div class="div100"><div class="form-group">
            <input type="text" name="vessel_expected_completion" value="" id="vessel_expected_completion"  class="form-control"  maxlength="30" autocomplete="off" placeholder="2018" />
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
               
              <td colspan="2"> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_length" value="" id="vessel_length"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in metres" />
            </div></div></td> 
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_breadth" value="" id="vessel_breadth"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in metres"/>
            </div></div></td> 
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_depth" value="" id="vessel_depth"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in metres"/>
            </div> </div></td> 
              <td> <div class="">
            
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                 <button type="button" class="btn bg-olive btn-flat" id="check_tonnage"> Check </button>
                 </div>
                </div>
                <div class="col-md-6">
                  <font color="#00f" id="show_tonnage">  ton.</font>
              <div class="progress progress-xs">
                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">                  
                </div>
              </div>
                </div>
              </div>
              
          
            </div> </td> 
            </tr>
            <tr > <td colspan="5">  
                    
          <!-- 
          <button type="submit" class="btn btn-info pull-right" name="tab1next" id="tab1next">Next</button> --> 
          <input type="submit" class="btn btn-info pull-right" name="form_step1" id="form_step1" value="Next">
                </td></tr>
                 </table>
              </div>
                    </form>
              <!-- /. end of tab-pane 1-->
              
             <!------------------------------------------- Particulars of Hull ------------------------------------------>
              
              
              <div class="tab-pane" id="tab_2">
                <table id="vacbtable" class="table table-bordered table-striped">
                <tr> 
            <td colspan="2"> Name of builder of hull</td>
            <td> <div class="div350"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
            <td> Address of builder of hull</td>
            <td> <div class="div350">
            <div class="form-group">
                  <textarea class="form-control" rows="3" ></textarea>

                </div>
                <!-- end of text area -->
            </div></td>
          </tr>
           <tr> 
            <td colspan="2"> Material of hull</td>
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
             </td>
            <td> Thickness of hull</td>
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in mm"/>
            </div> </div></td>
          </tr>
          <tr> 
            <td colspan="2"> Hull plating material</td>
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
             </td>
            <td> Thickness of hull plating material</td>
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in mm"/>
            </div> </div></td>
          </tr>
           <tr> 
            <td colspan="2"> Whether with a deck above freeboard (default no)</td>
            <td> <div class="form-group">
                <label>
                  <input type="radio" name="r1" class="minimal" > &nbsp;Yes
                </label> &nbsp; &nbsp;
                <label>
                  <input type="radio" name="r1" class="minimal" checked> &nbsp;No
                </label>
              </div>
              <!-- end of radio --></td>
            <td> Number of Bulk Head (based on Yes/No)</td>
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
          </tr>
           <tr> 
            <td colspan="2"> Bulk head placement</td>
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
           </td>
            <td> Bulk head thickness</td>
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in mm"/>
            </div> </div></td>
          </tr>
          <tr> <td colspan="5"> 
            <button type="submit" class="btn btn-info pull-right btn-space" name="tab2next" id="tab2next">Next</button>
             <button type="submit" class="btn btn-warning pull-right btn-space" name="tab2back" id="tab2back">Back</button>  

             </td> </tr>
                 </table>
              </div>
              <!-- /. end of tab-pane 2 -->
             <!------------------------------------------- PParticulars of Engine --------------------------------------->
            
              <div class="tab-pane" id="tab_3">
                <table id="vacbtable" class="table table-bordered table-striped">
                <tr> <td colspan="3">  Number of engine sets</td><td colspan="2">  <div class="div100">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-primary btn-flat"> Go </button>
                    </span>
              </div>
              <!-- /input-group -->
             </div> </td></tr>
             <tr> <td colspan="5"> Engine Set # 1 </td> </tr>
             <tr>
              <td colspan="2"> Whether Engine inboard/outboard</td>
              <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Inboard</option>
                  <option>Outboard</option>
                </select>
              </div>
              <!-- /.form-group -->
             </td>
              <td> BHP</td>
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
             </tr>
             <tr>
              <td colspan="2"> Name of manufacturer</td>
              <td> <div class="div350"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
              <td> Brand of manufacturer</td>
              <td> <div class="div350"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
             </tr>
             <tr>
              <td colspan="2"> Model number of engine</td>
              <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
            </td>
              <td> Type of engine</td>
              <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
            </td>
             </tr>
             <tr>
              <td colspan="2"> Diameter of propulsion shaft</td>
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in cm"/>
            </div> </div></td>
              <td> Material of propulsion shaft</td>
              <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Steel</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
             </td>
             </tr>
             <tr>
              <td colspan="2"> Type of gear</td>
              <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
             </td>
              <td> Number of gear</td>
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
             </tr>
              <tr> <td colspan="5"> 
            <button type="submit" class="btn btn-info pull-right btn-space" name="tab3next" id="tab3next">Next</button>
             <button type="submit" class="btn btn-warning pull-right btn-space" name="tab3back" id="tab3back">Back</button>  

             </td> </tr>
                 </table>
              </div>
               <!------------------------------------------- Particulars of Equipment ------------------------------------->
             
              <!-- /. end of tab-pane 3-->
              
              <div class="tab-pane" id="tab_4">
                <table id="vacbtable" class="table table-bordered table-striped">
                
                 </table><table id="vacbtable" class="table table-bordered table-striped">
                <tr> <td colspan="5"> Anchor</td> </tr>
             <tr> <td colspan="3"> </td> <td> Weight</td> <td> Material </td>  </tr>
             <tr> <td colspan="2"> </td> <td > Port</td> 
              <td>  <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control "  maxlength="30" autocomplete="off" placeholder="...in kg"/>
            </div> </div> </td> 
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
             </td>  </tr>
             <tr> <td colspan="2"> </td> <td > Starboard</td> 
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in kg"/>
            </div> </div></td> 
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Washington DC</option>
                </select>
              </div>
              <!-- /.form-group -->
            </td>  </tr>
             <tr> <td colspan="2"> </td> <td > Spare </td> 
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in kg"/>
            </div> </div></td> 
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
             </td>  </tr>
            <tr> <td colspan="5"> Chain</td> </tr>
             <tr> <td> </td> <td> </td> <td> Size </td>  <td> Length </td> <td> Type</td>  </tr>
             <tr> <td> </td> <td > Port</td> 
              <td>   <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
            
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in m"/>
            </div> </div> </td>
              <td>  
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
             </td> 
          </tr>
             <tr> <td> </td> <td > Starboard</td> 
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
            
            <td>  <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in m"/>
            </div> </div></td> 
            <td>  
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
            </td> 
             </tr>
             <tr> <td colspan="5"> Rope</td> </tr>
             <tr> <td colspan="2"></td> <td> Size </td>  <td> Number </td>  <td> Material</td> </tr>
             <tr> <td colspan="2"></td> 
              <td>   <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
             
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div> </td> 
             <td>  
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
            </td>
          </tr>
          </tr>
             <tr> <td colspan="5"> Search Light</td> </tr>
             <tr> <td colspan="2"> </td> <td> Number </td> <td> Power </td> <td> Size</td>  </tr>
             <tr> <td colspan="2"> </td> 
               
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div> </td> 
             <td>   <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
            <td>  
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
            </td>
          </tr>
          <tr> 
             <td colspan="3"> Number of life buoys </td> 
             <td colspan="2"> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
             </tr>
             <tr> 
             <td colspan="3"> Life buoys buoyant apparatus with self-ignited light or with buoyant lanyard </td> 
             <td colspan="2"> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
             </tr>

             <tr> 
             <td colspan="3"> Navigation light particulars </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list" >
                  <option>Alabama</option>
                  <option>Alaska</option>
                  <option>California</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>
                </select>
              </div>
            </td>
             </tr>
             <tr> 
             <td colspan="3"> Sound signals </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list" >
                  <option>Alabama</option>
                  <option>Alaska</option>
                  <option>California</option>
                  <option>Delaware</option>
                  <option>Tennessee</option>
                  <option>Texas</option>
                  <option>Washington</option>
                </select>
              </div>
           </td>
             </tr>
              
               <tr> <td colspan="5"> 
            <button type="submit" class="btn btn-info pull-right btn-space" name="tab4next" id="tab4next">Next</button>
             <button type="submit" class="btn btn-warning pull-right btn-space" name="tab4back" id="tab4back">Back</button>  

             </td> </tr>
                 </table>
              </div>
              
              <!------------------------------------------- Particulars of Fire Appliance -------------------------------->
             
              
              <!-- /. end of tab-pane 4-->
              <div class="tab-pane" id="tab_5">
                <table id="vacbtable" class="table table-bordered table-striped">
                <tr> <td colspan="5"> Fire pumps</td> </tr>
             <tr> <td colspan="2">  </td> <td> Number </td>  <td> Capacity </td> <td> Size</td> </tr>
             <tr> <td colspan="2"> </td> 
              <td>   <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td> 
             
            <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div> </td> 
            <td>  
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
              <!-- /.form-group -->
           </td> 
          </tr>
          <tr> 
            <td  colspan="2"> Material of fire mains </td>
            <td > 
            
            <div class="form-group">
                <select class="form-control select2 div200"  data-placeholder="Select the list" >
                  <option>Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
            </td>
            <td > Diameter of fire mains</td>
            <td > 
            
            <div class="div100"><div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off"  />
            </div></div>
          </td>
          </tr>
          <tr> 
            <td  colspan="2"> Number of hydrants </td>
            <td > <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off"/>
            <div> </div> </td>
            <td > Number of hose</td>
            <td > <div class="div100"><div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off"  />
            </div></div></td>
          </tr>
          
          <tr> 
             <td colspan="3">  Nozzles </td> 
             <td colspan="2"> 
            
            <div class="form-group">
                <select class="form-control select2 div350" multiple="multiple" data-placeholder="Select the list" >
                  <option>Jet type</option>
                  <option>Spray type</option>
                  <option>Dual type</option>
                </select>
              </div>
           </td>
             </tr>
              <tr> <td colspan="5"> Portable fire extinguishers</td> </tr>
             <tr> <td> </td>
             <td colspan="2"> i. Name (e.g. Soda)</td> 
             <td colspan="2"> 
             <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" />
            </div> </div></td>
             </tr>
            
               <tr> <td colspan="5"> 
            <button type="submit" class="btn btn-info pull-right btn-space" name="tab5next" id="tab5next">Next</button>
             <button type="submit" class="btn btn-warning pull-right btn-space" name="tab5back" id="tab5back">Back</button>  

             </td> </tr>
                 </table>
              </div>
              <!-- /. end of tab-pane 5-->
              <!------------------------------------------- Other Equipments --------------------------------------------->
            
              <div class="tab-pane" id="tab_6">
                <table id="vacbtable" class="table table-bordered table-striped">
                  <tr> 
             <td colspan="3"> Particulars of communication equipments  </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" >
                  <option>Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
           </td>
             </tr>
             <tr> 
             <td colspan="3"> Particulars of navigation equipments </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" >
                  <option>Alabama</option>
                  <option>Alaska</option>
                </select>
              </div>
           </td>
             </tr>
             <tr> 
             <td colspan="3"> Type of pollution control devices </td> 
             <td colspan="2"> 
             
            <div class="form-group">
                <select class="form-control select2 div500" multiple="multiple" data-placeholder="Select the list" >
                  <option>Alabama</option>
                  <option>Alaska</option>
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
                  <input type="checkbox" class="minimal" > &nbsp;&nbsp;&nbsp;Whether there is sewage treatment and disposal
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             
                <label>
                  <input type="checkbox" class="minimal"> &nbsp;&nbsp;&nbsp;Whether there is solid waste processing and disposal
                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  
                <label>
                  <input type="checkbox" class="minimal"> &nbsp;&nbsp;&nbsp;Whether there is sound pollution control 
                </label>
              </div>
            </div>

                </td>

              </tr>
             <tr>  
              <td colspan="2"> Water consumption per day </td> 
              <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="30" autocomplete="off" placeholder="...in litre" />
            </div> </div></td>
            <td> Source of water </td>
            <td> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Alabama</option>
                  <option>Alaska</option></select>
              </div>
              <!-- /.form-group -->
           </td>
                </tr>
                 
                  <tr> <td colspan="5"> 
            <button type="submit" class="btn btn-info pull-right btn-space" name="tab6next" id="tab6next">Next</button>
             <button type="submit" class="btn btn-warning pull-right btn-space" name="tab6back" id="tab6back">Back</button>  

             </td> </tr>
                 </table>
              </div>
              <!-- /. end of tab-pane 6-->
               <!------------------------------------------- Documents ---------------------------------------------------->
             
              <div class="tab-pane" id="tab_7">
                <table id="vacbtable" class="table table-bordered table-striped">
                <tr> <td > General Arrangments plans, structural drawings, freeboard marking, shell expansion, machinery and machinery layout, propeller, shafting, gears and steering plans, pipeline such as bilge and ballast, oil transfer etc </td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector">
           <input id="my-file-selector" type="file" style="display:none"  onchange="$('#upload-file-info').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info"></span>
                <!-- end of file input -->
            </div></td>
            </tr>
            <tr> <td > Particulars iof wheel house, crew accomodation, passengers, galleys, stores/service place etc. </td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector">
           <input id="my-file-selector" type="file" style="display:none"  onchange="$('#upload-file-info').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info"></span>
                <!-- end of file input -->
            </div></td>
            </tr>
            <tr> <td > Particulars of ventilation, charge of air for engine room </td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector">
           <input id="my-file-selector" type="file" style="display:none"  onchange="$('#upload-file-info').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info"></span>
                <!-- end of file input -->
            </div></td>
            </tr>
            <tr> <td >Builders yard accredition certificate </td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector">
           <input id="my-file-selector" type="file" style="display:none"  onchange="$('#upload-file-info').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info"></span>
                <!-- end of file input -->
            </div></td>
            </tr>
            <tr> <td > Preliminary stability calcualtion</td>
              <td colspan="4"> 
              <div class="div400">
            <label class="btn bg-green btn-sm" for="my-file-selector">
           <input id="my-file-selector" type="file" style="display:none"  onchange="$('#upload-file-info').html(this.files[0].name)"> Browse File  </label>
           <span class="label label-info"  id="upload-file-info"></span>
                <!-- end of file input -->
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
                  <input type="text" class="form-control" id="datepicker2">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div>
              </td></tr>
               <tr> <td colspan="5"> 
            <button type="submit" class="btn btn-info pull-right btn-space" name="tab7next" id="tab7next">Next</button>
             <button type="submit" class="btn btn-warning pull-right btn-space" name="tab7back" id="tab7back">Back</button>  

             </td> </tr>
                 </table>
              </div>
              <!-- /. end of tab-pane 7-->
              <!------------------------------------------- Payment ------------------------------------------------------>
             
              <div class="tab-pane" id="tab_8">
                <table id="vacbtable" class="table table-bordered table-striped">
                          <tr> 
            <td colspan="2"> Payment Type</td>
            <td colspan="3"> 
                 <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Demand Draft</option>
                  <option>Credit Card</option>
                  <option>Debit Card</option>
                  <option>Net Banking</option>
                </select>
              </div>
              <!-- /.form-group -->
            </td>
          </tr>
          <tr>
            <td> DD Amount </td> <td> <div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="8" autocomplete="off" placeholder="...Rupees" />
            </div> </div></td> 
            <td> DD Number </td> <td><div class="div100"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="6" autocomplete="off" placeholder="...6 digits" />
            </div> </div> </td> </tr>
            <tr> <td> DD Date </td> 
              <td> <div class="div250">
            <div class="form-group">
                 <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
            </div></td> 
              <td> Favoring </td> 
              <td> <div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">Vizhinjam</option>
                  <option>Azhikkal</option>
                  <option>Port of Registry</option>
                </select>
              </div>
              <!-- /.form-group --> </td> </tr>
            <tr> <td> Bank </td> 
              <td><div class="form-group">
                <select class="form-control select2 div200" >
                  <option selected="selected">State Bank of India</option>
                  <option>Kerala Gramin Bank</option>
                  <option>Bank names</option>
                </select>
              </div>
              <!-- /.form-group --> </td>
               <td> Payable at </td> <td><div class="div250"> <div class="form-group">
            <input type="text" name="vessel_name" value="" id="vessel_name"  class="form-control"  maxlength="50" autocomplete="off" placeholder="...branch name" />
            </div> </div> </td> </tr>
           <tr> <td colspan="5"> 
            <button type="submit" class="btn btn-info pull-right btn-space" name="tab8next" id="tab8next">Submit</button>
             <button type="submit" class="btn btn-warning pull-right btn-space" name="tab8back" id="tab8back">Back</button>  
             </td> </tr>
                 </table>
              </div>
              <!-- /. end of tab-pane 8-->
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
              </div>
              <!-- /. end of tab-pane 9-->
            </div>
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